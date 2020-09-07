<?php

namespace App\Http\Controllers;


use App\Address;
use App\Beneficiary;
use App\Company;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\HealthPlan;
use App\Inconsistency;
use App\Quiz;
use App\Telephone;


use App\AccessionInterview;
use Illuminate\Support\Facades\Auth;

use App\Accession;
use Illuminate\Http\Request;

class AccessionInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accessions.list', [
            'model' => Accession::class, 
            'filter' => [
                'to_interview' => true
            ],
            'editRoute' => 'interview',
            'routeParam' => 'interview',
            'breadcrumb' => 'Liberados para Entrevista'
        ]);
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
        
        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();
        $beneficiaries = Beneficiary::where('accession_id', $id)->get();
        $telephones = Telephone::where('accession_id', $id)->get();
        $addresses = Address::where('accession_id', $id)->get();
        $answers = HealthDeclarationAnswer::where('accession_id', $id)->get();
        $specifics = HealthDeclarationSpecific::where('accession_id', $id)->get();
        
        $accessionInstace = Accession::findOrFail($id);
        
        $inconsistencies = Inconsistency::all();

        $interviews = AccessionInterview::with('inconsistencies')->where('accession_id', $id)->get();


        return view('accessions.interview', [
            'customers' => $customers, 
            'beneficiaries' => $beneficiaries, 
            'telephones' => $telephones, 
            'healthplans' => $healthplans, 
            'quizzes' => $quizzes, 
            'accession' => $accessionInstace,
            'addresses' => $addresses, 
            'answers' => $answers, 
            'specifics' => $specifics,
            'inconsistencies' => $inconsistencies,
            'interviews' => $interviews ?? []
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accession_id)
    {   
        $accession = Accession::findOrFail($accession_id);

        $interview = AccessionInterview::create([
            'interviewed_name' => $request->get('interviewed_name'), 
            'interview_date' => $request->get('interview_date'), 
            'interviewed_by' => Auth::user()->name, 
            'interview_comments' => $request->get('interview_comments'), 
            'interview_validated' => $request->get('interview_validated'), 
            'user_id' => Auth::user()->id, 
            'accession_id' => $accession_id
        ]);

        if ($request->get('inconsistencies') !== null) {
            $interview->inconsistencies()->sync($request->get('inconsistencies'));
        }        

        if ($request->get('to_medic_analysis') !== null) {
            $accession->to_medic_analysis = $request->get('to_medic_analysis');
        }

        $accession->save();        

        return redirect()->route('tocontact.index')->with('success', 'Entrevista do Processo de Adesão criada com sucesso!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
