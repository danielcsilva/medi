<?php

namespace App\Http\Controllers;

use App\Accession;
use App\Address;
use App\Beneficiary;
use App\Company;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\HealthPlan;
use App\Inconsistency;
use App\Quiz;
use App\Telephone;
use Illuminate\Http\Request;

use App\AccessionContact;
use Illuminate\Support\Facades\Auth;

class AccessionContactController extends Controller
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
                'to_contact' => true
            ],
            'editRoute' => 'tocontact',
            'routeParam' => 'tocontact',
            'breadcrumb' => 'Processos para Contato'
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

        return view('accessions.contact', [
            'customers' => $customers, 
            'beneficiaries' => $beneficiaries, 
            'telephones' => $telephones, 
            'healthplans' => $healthplans, 
            'quizzes' => $quizzes, 
            'accession' => $accessionInstace,
            'addresses' => $addresses, 
            'answers' => $answers, 
            'specifics' => $specifics,
            'step' => 'Contato',
            'inconsistencies' => $inconsistencies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $accession = Accession::findOrFail($id);

        AccessionContact::create([
            'contacted_date' => $request->get('contacted_date'),
            'contacted_comments' => $request->get('contacted_comments'), 
            'inconsistency_id' => null, 
            'user_id' => Auth::user()->id, 
            'accession_id' => $accession->id
        ]);

        if ($request->get('inconsistencies') !== null) {
            $accession->inconsistencies()->sync($request->get('inconsistencies'));
        }        

        if ($request->get('to_interview') !== null) {
            $accession->to_interview = $request->get('to_interview');
        }

        $accession->save();
        

        return redirect()->route('tocontact.index')->with('success', 'Contato do Processo de Adesão criado com sucesso!');

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
