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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Accession;
use App\Cid;
use App\Delegation;
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

        if (!Auth::user()->can('Visualizar Entrevistas')) {
            return redirect()->route('home')->with('error', 'Este usuário não tem permissão para executar esta ação!');
        }

        $items = Delegation::where('user_id', Auth::user()->id)
        ->where('action', 'LIKE', '%Entrevista%')
        ->get();

        if (count($items) > 0) {
            $items = implode(",", $items->pluck('accession_id')->toArray());
        } else {
            $items = "";
        }

        return view('accessions.list', [
            'model' => Accession::class, 
            'filter' => [
                'to_interview' => true,
                'analysis_status' => false
            ],
            'selectAble' => false,
            'editable' => true,
            'editRoute' => 'interview',
            'filterField' => [],
            'routeParam' => 'interview',
            'breadcrumb' => 'Liberados para Entrevista',
            'items' => $items
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

        if (!Auth::user()->can('Editar Entrevistas')) {
            return redirect()->route('home')->with('error', 'Este usuário não tem permissão para executar esta ação!');
        }
        
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

        if (!Auth::user()->can('Editar Entrevistas')) {
            return redirect()->route('home')->with('error', 'Este usuário não tem permissão para executar esta ação!');
        }

        $accession = Accession::findOrFail($accession_id);

        $msg = "";

        $oldInterviews = AccessionInterview::where('accession_id', $accession_id);

        if (!$oldInterviews) {
                        
            Validator::make($request->all(), 
            [
                'interviewed_name' => 'required', 
                'interview_date' => 'required', 
                'interviewed_by' => '', 
                'interview_comments' => 'required', 
                'interview_validated' => '', 
                'user_id' => '', 
                'accession_id' => ''
            ],
            [
                'interviewed_name.required' => 'Nome do Entrevistado é obrigatório', 
                'interview_date.required' => 'Data da Entrevista é obrigatório', 
                'interview_comments.required' => 'Comentários da Entrevista é obrigatório', 
            ])->validate();

        }

        if ($request->get('beneficiary_id') !== null && $request->get('interview_comments') !== null) {
            // dd($request->all());
            $interview = AccessionInterview::create([
                'interviewed_name' => $request->get('beneficiary_id'), 
                'interview_date' => $request->get('interview_date'), 
                'interviewed_by' => Auth::user()->name, 
                'interview_comments' => $request->get('interview_comments'), 
                'interview_validated' => false, 
                'user_id' => Auth::user()->id, 
                'accession_id' => $accession_id,
                'beneficiary_id' => $request->get('beneficiary_id'),
            ]);

            if ($request->get('height')) {
                $interview->height = $request->get('height');
                $interview->save();
            }

            if ($request->get('weight')) {
                $interview->weight = $request->get('weight');
                $interview->save();
            }
            
            $msg = 'Entrevista do Processo de Adesão criada com sucesso!';

        }

        if ($request->get('inconsistencies') !== null) {
            $interview->inconsistencies()->sync($request->get('inconsistencies'));
        }        

        if ($request->get('to_medic_analysis') !== null) {
            $accession->to_medic_analysis = $request->get('to_medic_analysis');

            if ($request->get('to_medic_analysis') == "1") {
                $msg .= " Processo com o Nº de proposta ". $accession->proposal_number ." Liberado para Análise Médica";
            } else {
                $msg .= " Processo com o Nº de proposta ". $accession->proposal_number ." Bloqueado para Análise Médica";
            }

        }

        // $cids = [];
        // if ($request->get('cids')) {
        //     foreach($request->get('cids') as $cid) {
        //         $cid = Cid::where('cid', substr($cid, 0, strpos($cid, "-") - 1))->first();
        //         if ($cid) {
        //            $cids[] = $cid->id; 
        //         }
        //     }
            
        //     $interview->cids()->sync($cids);
        // }

        $accession->save();      
        

        return redirect()->route('interview.index')->with('success', $msg);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('Editar Entrevistas')) {
            return redirect()->route('home')->with('error', 'Este usuário não tem permissão para executar esta ação!');
        }

        if (Accession::findOrFail($id)->to_interview === 1) {
            return redirect()->route('interview.index')->with('error', 'Processo de Adesão não pode ser excluído quando liberado para Entrevista!'); 
        }
    }
}
