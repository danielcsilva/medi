<?php

namespace App\Http\Controllers;

use App\HealthQuestion;
use Illuminate\Http\Request;

class HealthQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('health_questions.list', ['model' => '\App\\HealthQuestion']);                        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('health_questions.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(HealthQuestion $healthQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($healthQuestion)
    {
        return view('health_questions.edit', ['healthquestion' => HealthQuestion::find($healthQuestion)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthQuestion $healthQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthQuestion $healthQuestion)
    {
        //
    }
}
