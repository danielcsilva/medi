<?php

namespace App\Http\Controllers;

use App\HealthPlan;
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
        return view('health_plans.list');
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
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function show(HealthPlan $healthPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthPlan $healthPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthPlan $healthPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthPlan $healthPlan)
    {
        //
    }
}
