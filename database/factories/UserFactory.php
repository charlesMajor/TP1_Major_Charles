<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserFactory extends Factory
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
            'login'=>$faker->text(50),
            'password'=>$faker->text(255),
            'email'=>$faker->text(50),
            'last_name'=>$faker->lastName(),
            'first_name'=>$faker->firstName()
        ];
    }
}
