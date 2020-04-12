<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Suggestion;
use Faker\Generator as Faker;

$factory->define(Suggestion::class, function (Faker $faker) {
    return [
        'suggestion' => $faker->sentence
    ];
});

$factory->state(Suggestion::class, 'suggestionTest', function (Faker $faker) {
    return [
        'suggestion' => 'Vaccine'
    ];
});
