<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/quizzes/{quiz_id?}', 'QuizApiController@getQuizzes')->name('api.quiz');

Route::middleware('auth:api')->prefix('v1')->group(function () {
    
    Route::get('/ping', 'Api\AccessionApiController@ping');
    Route::get('/meuperfil/{client_id}', 'Api\AccessionApiController@myProfile');
    Route::post('/novoprocesso', 'Api\AccessionApiController@newAccession');
    Route::get('/declaracoesdesaude', 'Api\AccessionApiController@healthDeclarations');

});