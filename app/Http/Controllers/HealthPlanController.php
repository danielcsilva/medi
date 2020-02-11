<?php

namespace App\Http\Controllers;

use App\HealthPlan;
use App\Http\Requests\HealthPlanStore;
use Illuminate\Http\Request;

class HealthPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('health_plans.list', ['model' => '\App\\HealthPlan']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('health_plans.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HealthPlanStore $request)
    {
        $validationData = $request->validated();
        
        HealthPlan::create($validationData);

        return redirect()->route('healthplans.index')->with('success', 'Operadora adicionada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function show($healthplan)
    {
       
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($healthplan)
    {
        return view('health_plans.edit', ['healthplan' => HealthPlan::findOrFail($healthplan)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function update(HealthPlanStore $request, $healthplan)
    {
        $healthplanModel = HealthPlan::findOrFail($healthplan);
        $validationData = $request->validated();        
        
        $healthplanModel->fill($validationData);
        $healthplanModel->save();

        return redirect()->route('healthplans.index')->with('success', 'Operadora editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy($healthplan)
    {
        $healthplanModel = Company::findOrFail($healthplan);
        $healthplanModel->delete();

        return redirect()->route('healthplans.index')->with('success', 'Operadora excluída com sucesso!');
    }
}
