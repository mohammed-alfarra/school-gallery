<?php

namespace Tests\Feature\Dashboard;

use App\Helpers\MediaHelper;
use App\Models\Image;
use App\Models\School;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\BaseTestCase;

class ImageTest extends BaseTestCase
{
    protected string $endpoint = '/api/dashboard/images/';

    public function testCanUploadImages(): void
    {
        $this->loginAsAdmin();

        $school = School::factory()->create();

        Storage::fake('public');

        $payload = [
            'images' => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->json('POST', "{$this->endpoint}school/{$school->id}/upload", $payload)
            ->assertStatus(201);

        $randomImagePath = MediaHelper::getFileFullPath(Image::inRandomOrder()->first()->path);

        $this->assertDatabaseHas('images', [
            'path' => str_replace('/storage/', '', $randomImagePath),
        ]);
    }

    public function testUploadExceedLimitImages(): void
    {
        $this->loginAsAdmin();

        $school = School::factory()->create();

        Storage::fake('public');

        $payload = [
            'images' => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.png'),
                UploadedFile::fake()->image('image3.png'),
                UploadedFile::fake()->image('image4.png'),
                UploadedFile::fake()->image('image5.png'),
                UploadedFile::fake()->image('image6.png'),
                UploadedFile::fake()->image('image7.png'),
            ],
        ];

        $this->json('POST', "{$this->endpoint}school/{$school->id}/upload", $payload)
            ->assertSee('The number of images cannot exceed 5.')
            ->assertStatus(422);

        $this->assertEquals(0, Image::count());
    }

    public function testUploadImagesWithUnsupportedMimeType(): void
    {
        $this->loginAsAdmin();

        $school = School::factory()->create();

        Storage::fake('public');

        $payload = [
            'images' => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.png'),
                UploadedFile::fake()->image('image3.svg'),
            ],
        ];

        $this->json('POST', "{$this->endpoint}school/{$school->id}/upload", $payload)
            ->assertSee('The images.2 must be a file of type: jpeg, png.')
            ->assertStatus(422);

        $this->assertEquals(0, Image::count());
    }

    public function testCanNotUploadImagesWhenUnauthenticated(): void
    {
        $school = School::factory()->create();

        Storage::fake('public');

        $payload = [
            'images' => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.png'),
            ],
        ];

        $this->json('POST', "{$this->endpoint}school/{$school->id}/upload", $payload)
            ->assertSee('Unauthenticated.')
            ->assertStatus(401);
    }
}
