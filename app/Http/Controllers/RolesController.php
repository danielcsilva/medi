<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.list', ['model' => '\App\\RiskGrade']);
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
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $Roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $Roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $Roles
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        //
    }
}
