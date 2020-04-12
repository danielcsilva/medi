<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Accession;
use Faker\Generator as Faker;

$factory->define(Accession::class, function (Faker $faker) {
    
    try {
        $company = App\Company::all()->random();
    } catch(Throwable $e) {
        factory(App\Company::class, 1)->create();
        $company = App\Company::all()->first();
    } 

    try {
        $health_plan = App\HealthPlan::all()->random();
    } catch(Throwable $e) {
        factory(App\HealthPlan::class, 1)->create();
        $health_plan = App\HealthPlan::all()->first();
    }   
    
    return [
        'proposal_number' => rand(1111, 9999),
        'company_id' => $company->id,
        'health_plan_id' => $health_plan->id,
        'received_at' => date('Y-m-d', strtotime("-".rand(1, 10)." days")),
        'consult_partner' => $faker->name,
        'broker_partner' => $faker->name,
        'health_declaration_expires' => date('Y-m-d', strtotime("+".rand(1, 10)." months")),
        'registered_date' => date('Y-m-d', strtotime("-".rand(1, 5)." days")),
        'entity' => $faker->name,
        'acomodation' => 'Apartamento',
        'plan_value' => $faker->randomFloat(2),
        'comments' => $faker->text,
        'initial_validity' => date('d/m/Y', strtotime("-10 days")),
        'admin_partner' => $faker->name
    ];

});


$factory->state(Accession::class, 'interviewProcess', function (Faker $faker) {
    
    try {
        $company = App\Company::all()->random();
    } catch(Throwable $e) {
        factory(App\Company::class, 1)->create();
        $company = App\Company::all()->first();
    } 

    try {
        $health_plan = App\HealthPlan::all()->random();
    } catch(Throwable $e) {
        factory(App\HealthPlan::class, 1)->create();
        $health_plan = App\HealthPlan::all()->first();
    }   
    
    return [
        'proposal_number' => rand(1111, 9999),
        'company_id' => $company->id,
        'health_plan_id' => $health_plan->id,
        'received_at' => date('Y-m-d', strtotime("-".rand(1, 10)." days")),
        'consult_partner' => $faker->name,
        'broker_partner' => $faker->name,
        'health_declaration_expires' => date('Y-m-d', strtotime("+".rand(1, 10)." months")),
        'registered_date' => date('Y-m-d', strtotime("-".rand(1, 5)." days")),
        'entity' => $faker->name,
        'acomodation' => 'Apartamento',
        'plan_value' => $faker->randomFloat(2),
        'comments' => $faker->text,
        'initial_validity' => date('d/m/Y', strtotime("-10 days")),
        'admin_partner' => $faker->name,
        'interview_date' => date('d/m/Y', strtotime("-".rand(1, 5)." days")),
        'interviewed_name' => $faker->name,
        'interview_validated' => true,
        'interviewed_by' => $faker->name,
        'interview_comments' => $faker->sentence
    ];

});


$factory->state(Accession::class, 'medicAnalysis', function (Faker $faker) {
    
    try {
        $company = App\Company::all()->random();
    } catch(Throwable $e) {
        factory(App\Company::class, 1)->create();
        $company = App\Company::all()->first();
    } 

    try {
        $health_plan = App\HealthPlan::all()->random();
    } catch(Throwable $e) {
        factory(App\HealthPlan::class, 1)->create();
        $health_plan = App\HealthPlan::all()->first();
    }   

    $riskGrade = factory(App\RiskGrade::class, 1)->states('riskTest')->create();
    $suggestion = factory(App\Suggestion::class, 1)->states('suggestionTest')->create();
    
    return [
        'proposal_number' => rand(1111, 9999),
        'company_id' => $company->id,
        'health_plan_id' => $health_plan->id,
        'received_at' => date('Y-m-d', strtotime("-".rand(1, 10)." days")),
        'consult_partner' => $faker->name,
        'broker_partner' => $faker->name,
        'health_declaration_expires' => date('Y-m-d', strtotime("+".rand(1, 10)." months")),
        'registered_date' => date('Y-m-d', strtotime("-".rand(1, 5)." days")),
        'entity' => $faker->name,
        'acomodation' => 'Apartamento',
        'plan_value' => $faker->randomFloat(2),
        'comments' => $faker->text,
        'initial_validity' => date('d/m/Y', strtotime("-10 days")),
        'admin_partner' => $faker->name,
        'interview_date' => date('d/m/Y', strtotime("-".rand(1, 5)." days")),
        'interviewed_name' => $faker->name,
        'interview_validated' => true,
        'interviewed_by' => $faker->name,
        'interview_comments' => $faker->sentence,
        'risk_grade_id' => $riskGrade[0]->id,
        'suggestion_id' => $suggestion[0]->id
    ];

});