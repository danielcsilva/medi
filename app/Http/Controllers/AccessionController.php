<?php

namespace App\Http\Controllers;

use App\Accession;
use App\AccessionInterview;
use App\AccessionMedicalAnalysis;
use App\Address;
use App\Beneficiary;
use App\Cid;
use App\Company;
use App\Delegation;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\HealthPlan;
use App\Inconsistency;
use App\Quiz;
use App\RiskGrade;
use App\Suggestion;
use App\Telephone;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

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
        $finished = false;
        if (request()->get('finished') && request()->get('finished') == '1') {
            $finished = true;
        }

        $editable = true;
        if ($finished && !Auth::user()->can('Editar Processos Finalizados')) {
            $editable = false;
        }

        // Delegation process
        $dtActions = [];
        if (Auth::user()->can('Delegar Processos')) {
            $dtActions = ['name' => 'Delegar Processos', 'route' => '/delegation'];
        }
        
        return view('accessions.list', [
            'model' => Accession::class, 
            'filter' => ['analysis_status' => $finished],
            'selectAble' => !$finished,
            'filterField' => [
                'companies' => ['label' => 'Cliente', 'field' => 'company_id', 'model' => 'App\Company', 'itens' => []]
            ], 
            'editRoute' => 'accessions',
            'routeParam' => 'accession',
            'dataTablesActions' => $dtActions,
            'selectAble' => Auth::user()->can('Delegar Processos'),
            'editable' => $editable
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (!Auth::user()->can('Editar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();

        return view('accessions.new', [
            'customers' => $customers, 
            'healthplans' => $healthplans, 
            'quizzes' => $quizzes, 
            'specifics' => '',
            'inconsistencies' => Inconsistency::all(), 
            'riskgrades' => RiskGrade::all(),
            'suggestions' => Suggestion::all() 
        ]);
    }


    public function accessionValidate(Request $request)
    {
        
        Validator::make($request->all(), 
        [
            'proposal_number' => 'required',
            'received_at' => 'required',
            'company_id' => 'required',
            'beneficiary_cpf.*' => 'required|min:13|cpf',
            'beneficiary_name.*' => 'required',
            'beneficiary_height.*' => 'required',
            'beneficiary_weight.*' => 'required',
            'beneficiary_gender.*' => 'required',
            'beneficiary_telephone.*' => 'required',
            'beneficiary_financier.*' => 'required',
            'beneficiary_age.*' => 'required',
            'address_cep.*' => '',
            'address_address.*' => '',
            'address_city.*' => 'required',
            'address_state.*' => 'required',            
            'contacted_date' => '',
            'contacted_comments' => ''
        ],
        [
            'proposal_number.required' => 'O n??mero da proposta ?? obrigat??rio!',
            'received_at.required' => 'A data de recebimento ?? obrigat??ria!',
            'company_id.required' => 'Escolher um Cliente ?? obrigat??rio!',
            'beneficiary_cpf.*.required' => 'O CPF ?? obrigat??rio!',
            'beneficiary_cpf.*.min' => 'O CPF deve ter 11 digitos!',
            'beneficiary_name.*.required' => 'O nome do benefici??rio ?? obrigat??rio!' ,
            'beneficiary_height.*.required' => 'A altura ?? obrigat??ria!',
            'beneficiary_weight.*.required' => 'O peso ?? obrigat??rio!',
            'beneficiary_gender.*.required' => 'O campo sexo ?? obrigat??rio!',
            'beneficiary_telephone.*.required' => 'O Telefone ?? obrigat??rio!',
            'beneficiary_age.*.required' => 'Campo Idade ?? obrigat??rio!',
            // 'address_cep.*.required' => 'Cep obrigat??rio!',
            // 'address_address.*.required' => 'Endere??o obrigat??rio!',
            'address_city.*.required' => 'Cidade obrigat??rio!',
            'address_state.*.required' => 'Estado (UF) obrigat??rio!'           
        ])->validate();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        if (!Auth::user()->can('Editar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }


        $this->accessionValidate($request);

        $beneficiaries = $request->get('beneficiary_cpf');
        $telephones = $request->get('beneficiary_telephone');
        $specifics = $request->get('specific_comment_number');
    
        try {
            
            $this->accessionTransaction($request, $beneficiaries, $telephones, null, $specifics);
            
        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Ades??o criado com sucesso!');
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
    public function edit($accession)
    {

        if (!Auth::user()->can('Editar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();
        $beneficiaries = Beneficiary::where('accession_id', $accession)->get();
        $telephones = Telephone::where('accession_id', $accession)->get();
        $addresses = Address::where('accession_id', $accession)->get();
        $answers = HealthDeclarationAnswer::where('accession_id', $accession)->get();
        $specifics = HealthDeclarationSpecific::where('accession_id', $accession)->get();
        
        $accessionInstace = Accession::findOrFail($accession);

        // $inconsistencies = Inconsistency::all();

        return view('accessions.edit', [
            'customers' => $customers, 
            'beneficiaries' => $beneficiaries, 
            'telephones' => $telephones, 
            'healthplans' => $healthplans, 
            'quizzes' => $quizzes, 
            'accession' => $accessionInstace,
            'addresses' => $addresses, 
            'answers' => $answers, 
            'specifics' => $specifics,
            // 'inconsistencies' => $inconsistencies, 
            'riskgrades' => RiskGrade::all(),
            'suggestions' => Suggestion::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accession_id)
    {
       
        
        if (!Auth::user()->can('Editar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        // $accession = AccessionInterview::where('accession_id', $accession_id)->first();
        // if ($accession !== null) {
        //      return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());
        // }

        $this->accessionValidate($request);

        $beneficiaries = $request->get('beneficiary_cpf');
        $telephones = $request->get('beneficiary_telephone');
        $specifics = $request->get('specific_comment_number');

        try {
            
            $this->accessionTransaction($request, $beneficiaries, $telephones, $accession_id, $specifics);

        } catch(Throwable $t) {

             return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Ades??o editado com sucesso!');
    }

    /**
     * Accession Transaction
     */
    public function accessionTransaction($request, $beneficiaries, $telephones, $accession_id = null, $specifics = null)
    {   
        
        // dd($request->all());
        DB::transaction(function() use ($request, $beneficiaries, $telephones, $accession_id, $specifics) {
                            
            $to_contact = 0;
            if ($request->has('to_contact') && $request->get('to_contact') == '1') {
                $to_contact = 1;
            }
            
            $financier = $request->get('beneficiary_financier') ?? null;

            if ($financier === null) {
                
            }

            if ($accession_id !== null) { // edit
            
                Accession::where('id', $accession_id)->update(['financier_id' => null]);
                
                $interviews = AccessionInterview::with('beneficiary')->where('accession_id', $accession_id)->get();
                AccessionInterview::where('accession_id', $accession_id)->update(['beneficiary_id' => null]);
                
                HealthDeclarationSpecific::where('accession_id', $accession_id)->delete(); 
                HealthDeclarationAnswer::where('accession_id', $accession_id)->delete();
                Address::where('accession_id', $accession_id)->delete();
                Beneficiary::where('accession_id', $accession_id)->delete();
                Telephone::where('accession_id', $accession_id)->delete();

                $accession = Accession::where('id', $accession_id)->first();
                $accession->fill([
                    'proposal_number' => $request->get('proposal_number'),
                    'received_at' => $request->get('received_at'),
                    'company_id' => $request->get('company_id'),
                    'comments' => $request->get('health_declaration_comments') ?? '',
                    'quiz_id' => $request->get('health_declaration'),
                    'admin_partner' => $request->get('admin_partner'),
                    'health_plan_id' => $request->get('health_plan_id'),
                    'initial_validity' => $request->get('initial_validity'),
                    'consult_partner' => $request->get('consult_partner'),
                    'broker_partner' => $request->get('broker_partner'),
                    'entity' => $request->get('entity'),
                    'to_contact' => $to_contact,
                    'registered_by' => Auth::user()->id,
                    'registered_date' => date('Y-m-d H:i:s'),
                    'holder_id' => 9999
                ]);
               
            } else {

                $accession = Accession::create([
                    'proposal_number' => $request->get('proposal_number'),
                    'received_at' => $request->get('received_at'),
                    'company_id' => $request->get('company_id'),
                    'comments' => $request->get('health_declaration_comments') ?? '',
                    'quiz_id' => $request->get('health_declaration'),
                    'admin_partner' => $request->get('admin_partner'),
                    'health_plan_id' => $request->get('health_plan_id'),
                    'initial_validity' => $request->get('initial_validity'),
                    'consult_partner' => $request->get('consult_partner'),
                    'broker_partner' => $request->get('broker_partner'),
                    'entity' => $request->get('entity'),
                    'to_contact' => $to_contact,
                    'holder_id' => 9999
                ]);

            }                    
               
            foreach($telephones as $tel) {
                
                Telephone::create([
                    'telephone' => $tel,
                    'accession_id' => $accession->id
                ]);

            }

            foreach($beneficiaries as $k => $v) {
    
                $weight = (double)$request->get('beneficiary_weight')[$k];
                $height = (double)$request->get('beneficiary_height')[$k];
                $imc = ($height > 0 ? round($weight / ($height * $height), 2) : 0);
    
                $beneficiary = Beneficiary::create([
                    'name' => $request->get('beneficiary_name')[$k], 
                    'email' => $request->get('beneficiary_email')[$k], 
                    'cpf' => $v, 
                    'birth_date' => DateTime::createFromFormat('d.m.Y', $request->get('beneficiary_birth_date')[$k])->format('Y-m-d'), 
                    'height' => $height, 
                    'weight' => $weight, 
                    'imc' => $imc, 
                    'gender' => $request->get('beneficiary_gender')[$k],
                    'accession_id' => $accession->id,
                    'age' => $request->get('beneficiary_age')[$k]
                ]);
                
                if ($k == 0) { //Holder
                    $accession->holder_id = $beneficiary->id;                
                }

                // Update Interviews with new Beneficiary ID
                if (isset($interviews)) {

                    foreach($interviews as $interview) {
                        if (isset($interview->beneficiary->cpf) && $interview->beneficiary->cpf == $beneficiary->cpf) {
                            $interview->beneficiary_id = $beneficiary->id;
                            $interview->save();
                        }
                    }
                    
                }

                Address::create([
                    // 'cep' => $request->get('address_cep')[$k],
                    // 'address' => $request->get('address_address')[$k],
                    // 'number' => $request->get('address_number')[$k],
                    // 'complement' => $request->get('address_complement')[$k],
                    'accession_id' => $accession->id,
                    'city' => $request->get('address_city')[$k],
                    'state' => $request->get('address_state')[$k]
                ]);    
                
                //Health Declaration
                $field = 'beneficiary_' . $k;
                
                if ($request->get('beneficiary_' . $k) !== null) {
                    
                    $questions = $request->get('question');
                    foreach($questions as $k1 => $v1) { // questions of Health Declaration
                        
                        HealthDeclarationAnswer::create([
                            'question' => $request->get('question')[$k1],
                            'answer' => $request->get($field)[$k1],
                            'beneficiary_id' => $beneficiary->id,
                            'accession_id' => $accession->id,
                            'quiz_id' => $accession->quiz_id,
                            'question_id' => $v1
                        ]);
                        
                        
                    }
                    // dd($specifics);
                 
                }
                
                // // beneficiaries index from _form view
                if (isset($financier[0]) && $financier[0] == ($k + 1)){
                    $accession->financier_id = $beneficiary->id;
                }

            }

            if ($specifics !== null) {

                foreach($specifics as $kSpecific => $specific) {
                    // specific points on Helth Declaration
                    HealthDeclarationSpecific::create([
                        'comment_number' => $request->get('specific_comment_number')[$kSpecific],
                        'comment_item' => $request->get('specific_comment_item')[$kSpecific],
                        'period_item' => $request->get('specific_period_item')[$kSpecific],
                        'accession_id' => $accession->id,
                        'beneficiary_id' => null,
                        'beneficiary_index' => $request->get('specific_beneficiary_index')[$kSpecific],
                        'quiz_id' => $accession->quiz_id,
                        'question_id' => $request->get('specific_question_id')[$kSpecific]
                    ]);
                    
                }
                
            }

            $accession->save();
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accession  $accession
     * @return \Illuminate\Http\Response
     */
    public function destroy($accession_id)
    {

        try {
            
            if (Accession::findOrFail($accession_id)->to_medic_analysis === 1) {
                return redirect('/medicanalysis/list')->with('error', 'Processo de Ades??o n??o pode ser exclu??do no est??gio de Ana??ise M??dica!'); 
            }
            
            HealthDeclarationSpecific::where('accession_id', $accession_id)->delete(); 
            HealthDeclarationAnswer::where('accession_id', $accession_id)->delete();
            Address::where('accession_id', $accession_id)->delete();
            Telephone::where('accession_id', $accession_id)->delete();
            Beneficiary::where('accession_id', $accession_id)->delete();
            Accession::where('id', $accession_id)->delete();
            
        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Ades??o deletado com sucesso!'); 
    }


    /**
     * Medic Analysis
     */
    public function medicAnalysisList()
    {
        if (!Auth::user()->can('Avaliar Processos Clinicamente') || !Auth::user()->can('Revisar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $items = Delegation::where('user_id', Auth::user()->id)
                            ->where('action', 'LIKE', '%An??lise M??dica%')
                            ->get();

        if (count($items) > 0) {
            $items = implode(",", $items->pluck('accession_id')->toArray());
        } else {
            $items = "";
        }
        
        return view('accessions.list', [
            'model' => Accession::class, 
            'filter' => [
                'to_medic_analysis' => true,
                'analysis_status' => false
            ],
            'selectAble' => false, 
            'filterField' => [],
            'editRoute' => 'accessions.medicAnalysis',
            'routeParam' => 'accession',
            'delete' => false,
            'breadcrumb' => 'Liberados para An??lise M??dica',
            'items' => $items 
        ]);

    }

    public function preparingMedicalAnalysis($accession)
    {
        if (!Auth::user()->can('Avaliar Processos Clinicamente') || !Auth::user()->can('Revisar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();
        $beneficiaries = Beneficiary::where('accession_id', $accession)->get();
        $telephones = Telephone::where('accession_id', $accession)->get();
        $addresses = Address::where('accession_id', $accession)->get();
        $answers = HealthDeclarationAnswer::where('accession_id', $accession)->get();
        $specifics = HealthDeclarationSpecific::where('accession_id', $accession)->get();
        
        $accessionInstace = Accession::with(['suggestion', 'riskGRade'])->findOrFail($accession);

        $interviews = AccessionInterview::with('inconsistencies')->where('accession_id', $accession)->get();

        $analysis = AccessionMedicalAnalysis::where('accession_id', $accession)->get();

        return view('accessions.medic_analysis', [
            'customers' => $customers, 
            'beneficiaries' => $beneficiaries,
            'analysis' => $analysis, 
            'telephones' => $telephones, 
            'healthplans' => $healthplans, 
            'quizzes' => $quizzes, 
            'accession' => $accessionInstace,
            'addresses' => $addresses, 
            'answers' => $answers, 
            'specifics' => $specifics,
            'interviews' => $interviews,
            'riskgrades' => RiskGrade::all(),
            'suggestions' => Suggestion::all(),
            'inconsistencies' => Inconsistency::all()
        ]);
    }

    /**
     * Set Medical Analysis
     */
    public function setAnalysis($accession_id)
    {
        if (!Auth::user()->can('Avaliar Processos Clinicamente') || !Auth::user()->can('Revisar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $request = request();
        $analysis = $request->get('analysis_beneficiary_id');

        foreach($analysis as $k => $v) {

            if ($request->get('justification')) {

                $medicalAnalysis = AccessionMedicalAnalysis::updateOrCreate(
                [
                    'accession_id' => $accession_id,
                    'beneficiary_id' => $request->get('analysis_beneficiary_id')[$k]
                ],
                [
                    'accession_id' => $accession_id,
                    'beneficiary_id' => $request->get('analysis_beneficiary_id')[$k],
                    'risk_grade_id' => $request->get('analysis_risk_grade_id')[$k],
                    'suggestion_id' => $request->get('suggestion_id')[$k],
                    'justification' => $request->get('justification')[$k]
                ]);

                // CIDs by beneficiary
                if ($request->get('cids_' . $request->get('analysis_beneficiary_id')[$k])) {
                    $cids = $request->get('cids_' . $request->get('analysis_beneficiary_id')[$k]);
                    $toSaveCids = [];
                    foreach($cids as $cid) {
                        $cid = Cid::where('cid', substr($cid, 0, strpos($cid, "-") - 1))->first();
                        if ($cid) {
                           $toSaveCids[] = $cid->id; 
                        }
                    }

                    $medicalAnalysis->cids()->sync($toSaveCids);
                }


            }

        }

        if ($request->get('finish_process')) {
            $accession = Accession::findOrFail($accession_id);
            $accession->analysis_status = true;
            $accession->save();
        }

        if ($request->get('reviewed_process')) {
            $accession = Accession::findOrFail($accession_id);
            $accession->to_review = false;
            $accession->reviewed_at = date('Y-m-d');
            $accession->save();
        }

        return redirect('/medicanalysis/list')->with('success', 'An??lise M??dica gravada com sucesso!'); 

    }


    /**
     * To Review
     */
    public function toReview()
    {
        if (!Auth::user()->can('Revisar Processos')) {
            return redirect()->route('home')->with('error', 'Este usu??rio n??o tem permiss??o para executar esta a????o!');
        }

        $items = Delegation::where('user_id', Auth::user()->id)
                            ->where('action', 'LIKE', '%Revis??o%')
                            ->get();

        if (count($items) > 0) {
            $items = implode(",", $items->pluck('accession_id')->toArray());
        } else {
            $items = "";
        }
        
        return view('accessions.list', [
            'model' => Accession::class, 
            'filter' => [
                'to_review' => false,
                'analysis_status' => true,
                'reviewed_at' => null
            ],
            'selectAble' => false, 
            'filterField' => [],
            'editRoute' => 'accessions.medicAnalysis',
            'routeParam' => 'accession',
            'delete' => false,
            'breadcrumb' => 'Aguardando Revis??o',
            'items' => $items,
            'editable' => true 
        ]);

    }
}
