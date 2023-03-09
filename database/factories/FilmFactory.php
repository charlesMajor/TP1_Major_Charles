<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class FilmFactory extends Factory
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
            'title'=>$faker->text(50),
            'release_year'=>$faker->year(),
            'length'=>$faker->randomNumber(3),
            'description'=>$faker->text(),
            'rating'=>$faker->text(5),
            'special_features'=>$faker->text(200),
            'image'=>$faker->text(40)
        ];
    }
}
