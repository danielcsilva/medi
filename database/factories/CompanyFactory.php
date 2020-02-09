<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {

    $types = ['LTDA', 'INC', 'SA', 'GOV'];
    $rand_keys = array_rand($types, 1);

    return [
        'name' => $faker->name . ' ' . $types[$rand_keys] ,
        'cnpj' => $faker->unique()->numberBetween(11111111111111, 99999999999999),
        'telephone' => '(' . rand(10,99) . ') ' . rand(11111111, 99999999), 
        'email' => $faker->email,
        'contract' => rand(11111, 99999)
    ];

});
