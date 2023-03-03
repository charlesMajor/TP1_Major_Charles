<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class ActorFactory extends Factory
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
            'last_name'=>$faker->lastName(),
            'first_name'=>$faker->firstName(),
            'birthdate'=>$faker->dateTime()
        ];
    }
}
