<?php

namespace App\Http\Controllers;

use App\Http\Requests\InconsistencyStore;
use App\Inconsistency;
use Illuminate\Http\Request;

class InconsistencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inconsistencies.list', ['model' => '\App\\Inconsistency']);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inconsistencies.new');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InconsistencyStore $request)
    {
        $validationData = $request->validated();
        
        Inconsistency::create($validationData);

        return redirect()->route('inconsistencies.index')->with('success', 'Inconsistência adicionada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function show(Inconsistency $inconsistency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function edit($inconsistency)
    {
        return view('inconsistencies.edit', ['inconsistency' => Inconsistency::findOrFail($inconsistency)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function update(InconsistencyStore $request, $inconsistency)
    {
        $inconsistencyModel = inconsistency::findOrFail($inconsistency);
        $validationData = $request->validated();        
        
        $inconsistencyModel->fill($validationData);
        $inconsistencyModel->save();

        return redirect()->route('inconsistencies.index')->with('success', 'Inconsistência editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function destroy($inconsistency)
    {
        $inconsistencyModel = Inconsistency::findOrFail($inconsistency);
        $inconsistencyModel->delete();

        return redirect()->route('inconsistencies.index')->with('success', 'Inconsistência excluída com sucesso!');
    }
}
