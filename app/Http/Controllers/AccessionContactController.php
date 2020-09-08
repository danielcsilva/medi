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
use Illuminate\Support\Facades\Validator;
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
            'breadcrumb' => 'Liberados para Contato'
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

        $contacts = AccessionContact::with('inconsistencies')->where('accession_id', $id)->get();


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
            'inconsistencies' => $inconsistencies,
            'contacts' => $contacts ?? []
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
        $msg = "";

        $oldContacts = AccessionContact::where('accession_id', $accession_id);
        
        if (!$oldContacts) {
                        
            Validator::make($request->all(), 
            [
                'contacted_date' => 'required',
                'contacted_comments' => 'required', 
                'user_id' => '', 
                'accession_id' => ''
            ],
            [
                'contacted_date' => "Data do Contato é obrigatório",
                'contacted_comments' => 'Comentário so Contato é obrigatório'
            ])->validate();

        }

        if ($request->get('contacted_comments') !== null) {

            $accessionContact = AccessionContact::create([
                'contacted_date' => $request->get('contacted_date'),
                'contacted_comments' => $request->get('contacted_comments'), 
                'user_id' => Auth::user()->id, 
                'accession_id' => $accession->id
            ]);
            
            $msg = 'Contato do Processo de Adesão criado com sucesso!';
        }   

        if ($request->get('inconsistencies') !== null) {
            $accessionContact->inconsistencies()->sync($request->get('inconsistencies'));
        }        

        if ($request->get('to_interview') !== null) {
            $accession->to_interview = $request->get('to_interview');

            if ($request->get('to_interview') == "1") {
                $msg .= "Processo com o Nº de proposta ". $accession->proposal_number ." Liberado para Entrevista";
            } else {
                $msg .= "Processo com o Nº de proposta ". $accession->proposal_number ." Bloqueado para Entrevista";
            }
        }

        $accession->save();
        

        return redirect()->route('tocontact.index')->with('success', $msg);

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
