<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class CriticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'score'=>$faker->randomFloat($nbMaxDecimals = 1, $min = 0, $max = 100),
            'comment'=>$faker->text($maxNbChars = 200),
            'film_id'=>$faker->numberBetween($min = 1, $max = 100) 
        ];
    }
}
