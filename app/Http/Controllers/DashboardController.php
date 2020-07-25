<?php

namespace App\Http\Controllers;

use App\Company;
use App\Dashboard;
use App\Http\Requests\StoreDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboards.list', ['model' => '\App\\Dashboard']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboards.new', ['companies' => Company::all()]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDashboard $request)
    {
        $validationData = $request->validated();
        
        $validationData['active'] = $validationData['active'] ?? false; 

        Dashboard::create($validationData);

        return redirect()->route('dashboards.index')->with('success', 'Dashboard adicionado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboards.edit', ['dashboard' => Dashboard::findOrFail($id), 'companies' => Company::all()]);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDashboard $request, $id)
    {
        $validationData = $request->validated();
        
        $validationData['active'] = $validationData['active'] ?? false; 

        $dash = Dashboard::find($id);
        $dash->fill($validationData);
        $dash->save();

        return redirect()->route('dashboards.index')->with('success', 'Dashboard editado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dash = Dashboard::findOrFail($id);
        $dash->delete();

        return redirect()->route('dashboards.index')->with('success', 'Dashboard excluído com sucesso!');
    }
}
