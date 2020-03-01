<?php

namespace App\Http\Controllers;

use App\Accession;
use App\Beneficiary;
use App\Company;
use App\HealthPlan;
use App\Quiz;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessionController extends Controller
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
        return view('accessions.list', ['model' => Accession::class]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();

        return view('accessions.new', ['customers' => $customers, 'healthplans' => $healthplans, 'quizzes' => $quizzes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'beneficiary_cpf.*' => 'required',
            'beneficiary_name.*' => 'required',
        ]);

        $beneficiaries = $request->get('beneficiary_cpf');
            
        DB::transaction(function() use ($request, $beneficiaries) {
            
            foreach($beneficiaries as $k => $v) {
    
                $weight = (double)$request->get('beneficiary_weight')[$k];
                $height = (double)$request->get('beneficiary_height')[$k];
                $imc = round($weight / ($height * $height), 2);
    
                $beneficiary = Beneficiary::create([
                    'name' => $request->get('beneficiary_name')[$k], 
                    'email' => $request->get('beneficiary_email')[$k], 
                    'cpf' => $v, 
                    'birth_date' => DateTime::createFromFormat('d/m/Y', $request->get('beneficiary_birth_date')[$k])->format('Y-m-d'), 
                    'height' => $height, 
                    'weight' => $weight, 
                    'imc' => $imc, 
                    'gender' => $request->get('beneficiary_gender')[$k]
                ]);
    
                Accession::create([
                    'proposal_number' => $request->get('proposal_number'),
                    'received_at' => DateTime::createFromFormat('d/m/Y', $request->get('received_at'))->format('Y-m-d'),
                    'company_id' => $request->get('company_id'),
                    'beneficiary_id' => $beneficiary->id 
                ]);
                    
            }

        });
        
        dd('fim');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function show(Accession $accession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function edit(Accession $accession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accession $accession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accession $accession)
    {
        //
    }
}
