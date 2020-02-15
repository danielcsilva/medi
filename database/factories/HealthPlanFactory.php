<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HealthPlan;
use Faker\Generator as Faker;

$factory->define(HealthPlan::class, function (Faker $faker) {
    
    return [
        'name' => $faker->company
    ];

});
