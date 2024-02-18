<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    public function definition(): array
    {
        $model = randomOrCreateFactory(School::class);

        return [
            'imageable_id' => $model->id,
            'imageable_type' => $model->getMorphClass(),
            'path' => 'images/'.$this->faker->date('Y-m-d').'/'.$this->faker->uuid.'.jpg',
            'mime_type' => 'ipg',
            'size' => random_int(1, 1000),
        ];
    }
}
