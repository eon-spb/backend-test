<?php

namespace Database\Factories;

use EON\Http\Models\Apartment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory  extends Factory
{
    protected $model = Apartment::class;
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->uuid(),
            's_total' => fake()->randomFloat(2,0,999999),
            's_living' => fake()->randomFloat(2,0,999999),
            's_kitchen' => fake()->randomFloat(2,0,999999),
            'height' => fake()->randomNumber(8, true),
            'price' => fake()->randomFloat(2,0,999999),
            'floor' => fake()->randomNumber(8, true)
        ];
    }
}
