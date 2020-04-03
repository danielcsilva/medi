<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Accession;
use Faker\Generator as Faker;

$factory->define(Accession::class, function (Faker $faker) {
    
    try {
        $company = App\Company::all()->random();
    } catch(Exception $e) {
        factory(App\Company::class, 1)->create();
        $company = App\Company::all()->first();
    } 

    try {
        $health_plan = App\HealthPlan::all()->random();
    } catch(Exception $e) {
        factory(App\HealthPlan::class, 1)->create();
        $health_plan = App\HealthPlan::all()->first();
    }   
    
    return [
        'proposal_number' => rand(1111, 9999),
        'company_id' => $company->id,
        'health_plan_id' => $health_plan->id,
        'received_at' => $faker->date,
        'consult_partner' => $faker->name,
        'broker_partner' => $faker->name,
        'health_declaration_expires' => $faker->date,
        'registered_date' => $faker->date,
        'entity' => $faker->name,
        'acomodation' => 'Apartamento',
        'plan_value' => $faker->randomFloat(2),
        'comments' => $faker->text,
        'initial_validity' => date('d/m/Y', strtotime("-1 days"))
    ];

});
