<?php

namespace Tests\Feature\Dashboard;

use App\Models\Image;
use App\Models\School;
use App\Models\Thumbnail;
use Tests\Feature\BaseTestCase;

class SchoolTest extends BaseTestCase
{
    protected string $endpoint = '/api/dashboard/schools/';

    public function testCanUListSchools(): void
    {
        $this->loginAsAdmin();

        $school = School::factory()->create();

        $image = Image::factory()->create([
            'imageable_id' => $school->id,
            'imageable_type' => $school->getMorphClass(),
        ]);

        Thumbnail::factory()->create([
            'image_id' => $image->id,
        ]);

        $this->json('GET', $this->endpoint)
            ->assertStatus(200);
    }
}
