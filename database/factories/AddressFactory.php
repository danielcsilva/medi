<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    
    $ceps = ['22770330', '22750320', '22770310'];
    return [
        'cep' => $ceps[array_rand($ceps, 1)],
        'address' => $faker->address,
        'number' => rand(1111, 9999),
        'complement' => $faker->secondaryAddress,
        'city' => 'Rio de Janeiro',
        'state' => 'RJ'
    ];

});
