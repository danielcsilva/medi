<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Beneficiary;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Beneficiary::class, function (Faker $faker) {
    
    $height = round(rand(10, 20) / 10, 2);
    $weight = rand(30, 110);
    $imc = round($weight / $height, 2);
    $gender = ['M', 'F'];
    $rand_keys = array_rand($gender, 1);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'cpf' => $faker->unique()->numberBetween(11111111111, 99999999999),
        'birth_date' => date('Y-m-d', strtotime(rand(1970, 2019) . '-'. rand(1, 12) . '-' . rand(1, 31))),
        'height' => $height,
        'weight' => $weight,
        'imc' => $imc,
        'gender' => $gender[$rand_keys] 
    ];
    
});
