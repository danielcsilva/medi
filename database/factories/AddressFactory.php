<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    
    return [
        'cep' => rand(11111111, 99999999),
        'address' => $faker->address,
        'number' => rand(1111, 9999),
        'complement' => $faker->secondaryAddress
    ];

});
