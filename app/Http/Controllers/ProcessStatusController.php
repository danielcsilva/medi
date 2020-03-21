<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessStatusStore;
use App\ProcessStatus;
use Illuminate\Http\Request;

class ProcessStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('process_status.list', ['model' => '\App\\ProcessStatus']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('process_status.new');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcessStatusStore $request)
    {
        $validationData = $request->validated();
        
        ProcessStatus::create($validationData);

        return redirect()->route('statusprocess.index')->with('success', 'Status do Processo adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcessStatus  $processStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessStatus $processStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcessStatus  $processStatus
     * @return \Illuminate\Http\Response
     */
    public function edit($processStatus)
    {
        return view('process_status.edit', ['risk' => ProcessStatus::findOrFail($processStatus)]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcessStatus  $processStatus
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessStatusStore $request, $processStatus)
    {
        $processSatusModel = ProcessStatus::findOrFail($processStatus);
        $validationData = $request->validated();        
        
        $processSatusModel->fill($validationData);
        $processSatusModel->save();

        return redirect()->route('statuprocess.index')->with('success', 'Status do Processo editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcessStatus  $processStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($processStatus)
    {
        try {
            
            $processStatusModel = ProcessStatus::findOrFail($processStatus);
            $processStatusModel->delete();

        } catch (\Illuminate\Database\QueryException $e) {
                
            return redirect()->route('statusprocess.index')->with('error', config('medi.constraint_error'));

        }

        return redirect()->route('statusprocess.index')->with('success', 'Status do Processo excluído com sucesso!');
    }
}
