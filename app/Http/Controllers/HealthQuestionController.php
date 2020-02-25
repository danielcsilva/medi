<?php

namespace App\Http\Controllers;

use App\HealthQuestion;
use App\Http\Requests\HealthQuestionStore;
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
    public function store(HealthQuestionStore $request)
    {
        $validationData = $request->validated();

        HealthQuestion::create($validationData);

        return redirect()->route('healthquestions.index')->with('success', 'Questão criada com sucesso!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(HealthQuestion $healthQuestion)
    {
        
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
    public function update(HealthQuestionStore $request, $healthquestion)
    {
        $healthquestionModel = healthquestion::findOrFail($healthquestion);
        $validationData = $request->validated();        
        
        $healthquestionModel->fill($validationData);
        $healthquestionModel->save();

        return redirect()->route('healthquestions.index')->with('success', 'Questão editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HealthQuestion  $healthQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($healthquestion)
    {
        $healthquestionModel = healthquestion::findOrFail($healthquestion);
        $healthquestionModel->delete();

        return redirect()->route('healthquestions.index')->with('success', 'Questão excluída com sucesso!');
    }
}
