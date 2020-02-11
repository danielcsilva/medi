<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyStore;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        return view('companies.list', ['model' => '\App\\Company']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyStore $request)
    {
        $validationData = $request->validated();
        
        Company::create($validationData);

        return redirect()->route('companies.index')->with('success', 'Empresa adicionada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($company)
    {
        return view('companies.edit', ['company' => Company::findOrFail($company)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyStore $request, $company)
    {
        $companyModel = Company::findOrFail($company);
        $validationData = $request->validated();        
        
        $companyModel->fill($validationData);
        $companyModel->save();

        return redirect()->route('companies.index')->with('success', 'Empresa editada com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($company)
    {
        $companyModel = Company::findOrFail($company);
        $companyModel->delete();

        return redirect()->route('companies.index')->with('success', 'Empresa excluída com sucesso!');

    }
}
