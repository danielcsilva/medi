<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HealthQuestion;
use Faker\Generator as Faker;

$factory->define(HealthQuestion::class, function (Faker $faker) {
    
    return [
        'question' => $faker->sentence . '?',
        'description' => $faker->text,
        'required' => rand(0, 1)
    ];

});
