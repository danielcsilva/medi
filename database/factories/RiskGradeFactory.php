<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RiskGrade;
use Faker\Generator as Faker;

$factory->define(RiskGrade::class, function (Faker $faker) {
    return [
        'risk' => $faker->sentence
    ];
});


$factory->state(RiskGrade::class, 'riskTest', function (Faker $faker) {
    return [
        'risk' => 'TooRisk'
    ];
});
