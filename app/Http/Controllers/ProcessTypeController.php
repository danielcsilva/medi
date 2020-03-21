<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessTypeStore;
use App\ProcessType;
use Illuminate\Http\Request;

class ProcessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('process_types.list', ['model' => '\App\\ProcessType']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('process_types.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcessTypeStore $request)
    {
        $validationData = $request->validated();
        
        processType::create($validationData);

        return redirect()->route('processtypes.index')->with('success', 'Grau de Risco adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcessType  $processType
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessType $processType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcessType  $processType
     * @return \Illuminate\Http\Response
     */
    public function edit($processType)
    {
        return view('process_types.edit', ['processtype' => ProcessType::findOrFail($processType)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcessType  $processType
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessTypeStore $request, $processType)
    {
        $processTypeModel = processType::findOrFail($processType);
        $validationData = $request->validated();        
        
        $processTypeModel->fill($validationData);
        $processTypeModel->save();

        return redirect()->route('processtypes.index')->with('success', 'Tipo Movimentação editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcessType  $processType
     * @return \Illuminate\Http\Response
     */
    public function destroy($processType)
    {
        try {
            
            $processTypeModel = ProcessType::findOrFail($processType);
            $processTypeModel->delete();
          
        } catch (\Illuminate\Database\QueryException $e) {
            
            return redirect()->route('processtypes.index')->with('error', config('medi.constraint_error'));

        }

        return redirect()->route('processtypes.index')->with('success', 'Tipo Movimentação excluída com sucesso!');
    }
}
