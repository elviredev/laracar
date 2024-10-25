<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<CarImage>
 */
class CarImageFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'image_path' => fake()->imageUrl(),
      'position' => function (array $attributes) {
        return Car::find($attributes['car_id'])->images()->count() + 1;
      },
    ];
  }
}