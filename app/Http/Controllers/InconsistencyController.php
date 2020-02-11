<?php

namespace App\Http\Controllers;

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
        //
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
    public function edit(Inconsistency $inconsistency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inconsistency $inconsistency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inconsistency  $inconsistency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inconsistency $inconsistency)
    {
        //
    }
}
