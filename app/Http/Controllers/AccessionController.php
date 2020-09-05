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
        
        $filter = request()->all();

        return view('accessions.list', ['model' => Accession::class, 'filter' => []]);

    }

    public function toContact()
    {
        return view('accessions.list', ['model' => Accession::class, 'filter' => ['to_contact' => true]]);

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

        return view('accessions.new', ['customers' => $customers, 'healthplans' => $healthplans, 
                                       'quizzes' => $quizzes, 'specifics' => '',
                                       'inconsistencies' => Inconsistency::all(), 'riskgrades' => RiskGrade::all(),
                                       'suggestions' => Suggestion::all() ]);
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
            'address_cep.*' => 'required',
            'address_address.*' => 'required',
            'address_city.*' => 'required',
            'address_state.*' => 'required',
            'contacted_date' => '',
            'contacted_comments' => ''
        ],
        [
            'proposal_number.required' => 'O número da proposta é obrigatório!',
            'received_at.required' => 'A data de recebimento é obrigatória!',
            'company_id.required' => 'Escolher um Cliente é obrigatório!',
            'beneficiary_cpf.*.required' => 'O CPF é obrigatório!',
            'beneficiary_cpf.*.min' => 'O CPF deve ter 11 digitos!',
            'beneficiary_name.*.required' => 'O nome do beneficiário é obrigatório!' ,
            'beneficiary_height.*.required' => 'A altura é obrigatória!',
            'beneficiary_weight.*.required' => 'O peso é obrigatório!',
            'beneficiary_gender.*.required' => 'O campo sexo é obrigatório!',
            'beneficiary_telephone.*.required' => 'O Telefone é obrigatório!',
            'address_cep.*.required' => 'Cep obrigatório!',
            'address_address.*.required' => 'Endereço obrigatório!',
            'address_city.*.required' => 'Cidade obrigatório!',
            'address_state.*.required' => 'Estado (UF) obrigatório!'           
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

        $this->accessionValidate($request);

        $beneficiaries = $request->get('beneficiary_cpf');
        $telephones = $request->get('beneficiary_telephone');
    
        try {

            $this->accessionTransaction($request, $beneficiaries, $telephones);
            
        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Adesão criado com sucesso!');
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
        $customers = Company::all();
        $healthplans = HealthPlan::all();
        $quizzes = Quiz::all();
        $beneficiaries = Beneficiary::where('accession_id', $accession)->get();
        $telephones = Telephone::where('accession_id', $accession)->get();
        $addresses = Address::where('accession_id', $accession)->get();
        $answers = HealthDeclarationAnswer::where('accession_id', $accession)->get();
        $specifics = HealthDeclarationSpecific::where('accession_id', $accession)->get();
        
        $accessionInstace = Accession::findOrFail($accession);

        $inconsistencies = Inconsistency::all();

        return view('accessions.edit', ['customers' => $customers, 'beneficiaries' => $beneficiaries, 
                                        'telephones' => $telephones, 'healthplans' => $healthplans, 
                                        'quizzes' => $quizzes, 'accession' => $accessionInstace,
                                        'addresses' => $addresses, 'answers' => $answers, 'specifics' => $specifics,
                                        'inconsistencies' => $inconsistencies, 'riskgrades' => RiskGrade::all(),
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
        
        $this->accessionValidate($request);

        $beneficiaries = $request->get('beneficiary_cpf');
        $telephones = $request->get('beneficiary_telephone');

        try {
            
            $this->accessionTransaction($request, $beneficiaries, $telephones, $accession_id);

        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Adesão editado com sucesso!');
    }

    /**
     * Accession Transaction
     */
    public function accessionTransaction($request, $beneficiaries, $telephones, $accession_id = null)
    {   
        // dd($request->all());
        DB::transaction(function() use ($request, $beneficiaries, $telephones, $accession_id) {
                            
            if ($accession_id !== null) { // edit
            
                Accession::where('id', $accession_id)->update(['financier_id' => null]);
                
                HealthDeclarationSpecific::where('accession_id', $accession_id)->delete(); 
                HealthDeclarationAnswer::where('accession_id', $accession_id)->delete();
                Address::where('accession_id', $accession_id)->delete();
                Beneficiary::where('accession_id', $accession_id)->delete();
                Telephone::where('accession_id', $accession_id)->delete();

                // Detach inconsistencies
                // $oldAccession = Accession::find($accession_id);
                // $oldAccession->inconsistencies()->detach();

               Accession::where('id', $accession_id)->delete();
            }

            $to_contact = 0;
            if ($request->has('to_contact') && $request->get('to_contact') == '1') {
                $to_contact = 1;
            }

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
                'to_contact' => $to_contact
            ]);
               
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

                Address::create([
                    'cep' => $request->get('address_cep')[$k],
                    'address' => $request->get('address_address')[$k],
                    'number' => $request->get('address_number')[$k],
                    'complement' => $request->get('address_complement')[$k],
                    'accession_id' => $accession->id,
                    'city' => $request->get('address_city')[$k],
                    'state' => $request->get('address_state')[$k]
                ]);    
                
                //Health Declaration
                $field = 'beneficiary_' . $k;
                
                if ($request->get('beneficiary_0')) {
                    
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
                        
                        if ($request->get($field)[$k1] == 'S') { // specific points on Helth Declaration
                            HealthDeclarationSpecific::create([
                                'comment_number' => $request->get('specific_comment_number')[$k1],
                                'comment_item' => $request->get('specific_comment_item')[$k1],
                                'period_item' => $request->get('specific_period_item')[$k1],
                                'accession_id' => $accession->id,
                                'beneficiary_id' => $beneficiary->id,
                                'quiz_id' => $accession->quiz_id,
                                'question_id' => $v1
                            ]);
                        }
                    }

                }

                // beneficiaries index from _form view
                if (isset($request->get('beneficiary_financier')[0]) && $request->get('beneficiary_financier')[0] == ($k + 1)) {                    
                    $accession->financier_id = $beneficiary->id;
                }

            }

            // if ($request->get('comment_number')) {

            //     $specifics = $request->get('comment_number');
                
            //     foreach($specifics as $specific_k => $specific_v) {

            //         if ($request->get('comment_item')[$specific_k] !== null) {

            //             HealthDeclarationSpecific::create([
            //                 'comment_number' => $request->get('comment_number')[$specific_k],
            //                 'comment_item' => $request->get('comment_item')[$specific_k],
            //                 'period_item' => $request->get('period_item')[$specific_k],
            //                 'accession_id' => $accession->id
            //             ]);

            //         }
            //     }

            // }

            // $this->setContact($request, $accession);
            // $this->setInterview($request, $accession);
            // $this->setMedicAnalysis($request, $accession);

            $accession->save();
        });
    }

    public function setContact($request, $accession)
    {
        //Contact
        if ($request->get('inconsistencies')) {
            $accession->inconsistencies()->sync($request->get('inconsistencies'));
        }

        if ($request->get('contacted_date')) {
            $accession->contacted_date = $request->get('contacted_date');
        }

        if ($request->get('contacted_comments')) {
            $accession->contacted_comments = $request->get('contacted_comments');
        }

        $accession->save();
    }

    public function setInterview($request, $accession) 
    {
        //Interview
        if ($request->get('interviewed_name')) {
            $accession->interviewed_name = $request->get('interviewed_name');
        }

        if ($request->get('interview_date')) {
            $accession->interview_date = $request->get('interview_date');
        }

        if ($request->get('interviewed_by')) {
            $accession->interviewed_by = $request->get('interviewed_by');
        }

        if ($request->get('interview_comments')) {
            $accession->interview_comments = $request->get('interview_comments');
        }
        
        if ($request->get('interview_validated')) {
            $accession->interview_validated = $request->get('interview_validated');
        }

        $accession->save();
    }

    public function setMedicAnalysis($request, $accession)
    {
        //Medic analysis
        if ($request->get('risk_grade_id')) {
            $accession->risk_grade_id = $request->get('risk_grade_id');
        }

        if ($request->get('suggestion_id')) {
            $accession->suggestion_id = $request->get('suggestion_id');
        }

        $accession->save();
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

            $oldAccession = Accession::find($accession_id);
            $oldAccession->inconsistencies()->detach();

            HealthDeclarationSpecific::where('accession_id', $accession_id)->delete(); 
            HealthDeclarationAnswer::where('accession_id', $accession_id)->delete();
            Address::where('accession_id', $accession_id)->delete();
            Beneficiary::where('accession_id', $accession_id)->delete();
            Telephone::where('accession_id', $accession_id)->delete();
            Accession::where('id', $accession_id)->delete();

        } catch(Throwable $t) {

            return back()->withInput()->with('error', config('medi.tech_error_msg') . $t->getMessage());

        }
        
        return redirect()->route('accessions.index')->with('success', 'Processo de Adesão deletado com sucesso!'); 
    }
}
