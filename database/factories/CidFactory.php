<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cid;
use Faker\Generator as Faker;

$factory->define(Cid::class, function (Faker $faker) {
    return [
        'cid' => $faker->randomElement(['A', 'B', 'C', 'D']) . $faker->numberBetween(10, 99),
        'description' => $faker->text(50)
    ];
});
