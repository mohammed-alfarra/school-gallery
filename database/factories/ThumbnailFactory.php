<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThumbnailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image_id' => randomOrCreateFactory(Image::class),
            'path' => 'images/'.$this->faker->date('Y-m-d').'/'.$this->faker->uuid.'.jpg',
        ];
    }
}
