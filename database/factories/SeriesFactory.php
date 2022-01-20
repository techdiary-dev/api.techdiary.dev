<?php

namespace Database\Factories;

use App\Models\Series;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Series::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->paragraph
        ];
    }
}
