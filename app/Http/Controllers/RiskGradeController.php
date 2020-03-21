<?php

namespace App\Http\Controllers;

use App\Http\Requests\RiskGradeStore;
use App\RiskGrade;
use Illuminate\Http\Request;

class RiskGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('riskgrades.list', ['model' => '\App\\RiskGrade']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('riskgrades.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RiskGradeStore $request)
    {
        $validationData = $request->validated();
        
        RiskGrade::create($validationData);

        return redirect()->route('riskgrades.index')->with('success', 'Grau de Risco adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RiskGrade  $riskGrade
     * @return \Illuminate\Http\Response
     */
    public function show(RiskGrade $riskGrade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RiskGrade  $riskGrade
     * @return \Illuminate\Http\Response
     */
    public function edit($riskGrade)
    {
        return view('riskgrades.edit', ['risk' => RiskGrade::findOrFail($riskGrade)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RiskGrade  $riskGrade
     * @return \Illuminate\Http\Response
     */
    public function update(RiskGradeStore $request, $riskGrade)
    {
        $riskgradeModel = riskgrade::findOrFail($riskGrade);
        $validationData = $request->validated();        
        
        $riskgradeModel->fill($validationData);
        $riskgradeModel->save();

        return redirect()->route('riskgrades.index')->with('success', 'Grau de Risco editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RiskGrade  $riskGrade
     * @return \Illuminate\Http\Response
     */
    public function destroy($riskGrade)
    {
        try {
            
            $riskgradeModel = Riskgrade::findOrFail($riskGrade);
            $riskgradeModel->delete();

        } catch (\Illuminate\Database\QueryException $e) {
                
            return redirect()->route('riskgrades.index')->with('error', config('medi.constraint_error'));

        }
        

        return redirect()->route('riskgrades.index')->with('success', 'Grau de Risco excluído com sucesso!');
    }
}
