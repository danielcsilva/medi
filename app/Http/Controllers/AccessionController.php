<?php

namespace App\Http\Controllers;

use App\Accession;
use App\Address;
use App\Beneficiary;
use App\Company;
use App\HealthDeclaration;
use App\HealthPlan;
use App\Quiz;
use App\Telephone;
use DateTime;
use Exception;
use Illuminate\Http\Request;
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
        Validator::make($request->all(), 
        [
            'proposal_number' => 'required',
            'received_at' => 'required',
            'company_id' => 'required',
            'beneficiary_cpf.*' => 'required',
            'beneficiary_name.*' => 'required',
            'beneficiary_height.*' => 'required',
            'beneficiary_weight.*' => 'required',
            'beneficiary_gender.*' => 'required',
            'address_cep.*' => 'required',
            'address_address.*' => 'required',
            'address_number.*' => 'required',
            'address_city.*' => 'required',
            'address_state.*' => 'required'
        ],
        [
            'proposal_number' => 'O número da proposta é obrigatório!',
            'received_at' => 'A data de recebimento é obrigatória!',
            'company_id' => 'Escolher um Cliente é obrigatório!',
            'beneficiary_cpf.*' => 'O CPF é obrigatório!',
            'beneficiary_name.*' => 'O nome do beneficiário é obrigatório!' ,
            'beneficiary_height.*' => 'A altura é obrigatória!',
            'beneficiary_weight.*' => 'O peso é obrigatório!',
            'beneficiary_gender.*' => 'O campo sexo é obrigatório!',
            'address_cep.*' => 'Cep obrigatório!',
            'address_address.*' => 'Endereço obrigatório!',
            'address_number.*' => 'Número obrigatório!',
            'address_city.*' => 'Cidade obrigatório!',
            'address_state.*' => 'Estado (UF) obrigatório!'           
        ])->validate();
        

        $beneficiaries = $request->get('beneficiary_cpf');
 
        try {

            DB::transaction(function() use ($request, $beneficiaries) {
                
                foreach($beneficiaries as $k => $v) {
        
                    $weight = (double)$request->get('beneficiary_weight')[$k];
                    $height = (double)$request->get('beneficiary_height')[$k];
                    $imc = ($height > 0 ? round($weight / ($height * $height), 2) : 0);
        
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
        
                    $accession = Accession::create([
                        'proposal_number' => $request->get('proposal_number'),
                        'received_at' => DateTime::createFromFormat('d/m/Y', $request->get('received_at'))->format('Y-m-d'),
                        'company_id' => $request->get('company_id'),
                        'beneficiary_id' => $beneficiary->id 
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
                    
                    Telephone::create([
                        'telephone' => $request->get('beneficiary_telephone')[$k],
                        'accession_id' => $accession->id
                    ]);
                    
                    // Health Declaration
                    $field = 'dependent_' . $k;

                    if ($k == 0) {
                        $field = 'holder_answer';
                    }

                    $questions = $request->get('question');

                    foreach($questions as $k1 => $v1) {

                        HealthDeclaration::create([
                            'question' => $request->get('question')[$k1],
                            'answer' => $request->get($field)[$k1],
                            'period' => $request->get('period_by_item')[$k1] ?? null,
                            'item_number_obs' => $request->get('comment_by_item')[$k1] ?? null,
                            'item_number' => $request->get('item_number')[$k1],
                            'comments' => ($k1 == 0 ? $request->get('health_declaration_comments') : null),
                            'accession_id' => $accession->id
                        ]);

                    }                    

                }
    
            });

        } catch(Exception $e) {
            
            return back()->withInput()->with('error', config('medi.tech_error_msg') . $e->getMessage());

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
        $accession = Accession::find($accession);
        $accessions = Accession::where('proposal_number', $accession->proposal_number);

        $beneficiaries = [];
        $addresses = [];
        $telephones = [];
        foreach ($accessions as $acc) {

            $beneficiaries[] = Beneficiary::find($acc->beneficiary_id);
            $addresses[] = Address::where('accession_id', $acc->id);
            $telephones[] = Telephone::where('accession_id', $acc->id);

        }

        return view('accessions.edit');
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
