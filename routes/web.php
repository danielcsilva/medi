<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('beneficiaries', 'BeneficiaryController');
Route::resource('companies', 'CompanyController');
Route::resource('quizzes', 'QuizController');
Route::resource('healthplans', 'HealthPlanController');
Route::resource('inconsistencies', 'InconsistencyController');
Route::resource('accessions', 'AccessionController');
Route::resource('healthquestions', 'HealthQuestionController');


