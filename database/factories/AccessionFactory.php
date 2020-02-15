<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Accession;
use Faker\Generator as Faker;

$factory->define(Accession::class, function (Faker $faker) {
    
    try {
        
        $beneficiary = App\Beneficiary::all()->random();
        $company = App\Company::all()->random();
        $address = App\Address::all()->random();
        $health_plan = App\HealthPlan::all()->random();

    } catch(\Exception $e){

        if (!isset($beneficiary->id)) {
            factory(App\Beneficiary::class, 1)->create();
            $beneficiary = App\Beneficiary::all()->first();
        }

        if (!isset($company->id)) {
            factory(App\Company::class, 1)->create();
            $company = App\Company::all()->first();
        }

        if (!isset($address->id)) {
            factory(App\Address::class, 1)->create();
            $address = App\Address::all()->first();
        }            
    
        if (!isset($health_plan->id)) {
            factory(App\HealthPlan::class, 1)->create();
            $health_plan = App\HealthPlan::all()->first();
        }

    }
       

    return [
        'proposal_number' => rand(1111, 9999),
        'beneficiary_id' => $beneficiary->id,
        'financier_id' => $beneficiary->id,
        'company_id' => $company->id,
        'address_id' => $address->id,
        'health_plan_id' => $health_plan->id,
        'received_at' => $faker->date
    ];

});
