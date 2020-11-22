<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HealthQuestion;
use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    
    return [
        'name' => $faker->sentence
    ];

});

$factory->state(Quiz::class, 'quizWithHealthQuestions', function (Faker $faker) {

    return [
        'name' => $faker->sentence
    ];

});



$factory->afterCreatingState(Quiz::class, 'quizWithHealthQuestions', function($row, $faker) {
    
    $questions = HealthQuestion::all()->random(10);
    
    if ($questions) {
        $row->questions()->sync($questions->pluck('id'));
    } else {
        $row->questions()->sync(factory(HealthQuestion::class, 10)->create());
    }

});