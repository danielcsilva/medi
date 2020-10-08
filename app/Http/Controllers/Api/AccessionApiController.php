<?php

namespace App\Http\Controllers\Api;

use App\Accession;
use App\Address;
use App\Beneficiary;
use App\Company;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\HealthPlan;
use App\HealthQuestion;
use App\Http\Controllers\Controller;
use App\ProcessType;
use App\Quiz;
use App\Telephone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * @group Processos
 * 
 * API para gerenciamento de processos
 */
class AccessionApiController extends Controller
{
    /**
     * API online
     * 
     * Verifica se a API está online (healthcheck)
     * 
     * @response {
     *    "message": "success"
     * }
     */
    public function ping()
    {
        return ['message' => 'success'];
    }

    /**
     * Meu Perfil
     * 
     * Retorna os dados do cliente Medi, se está ativo e etc.
     * 
     * @urlParam clientId int ID do Cliente que consulta a API. Exemplo: 9;
     */
    public function myProfile($client_id)
    {   
    
        // $validator = Validator::make(request()->all(), [
        //     "client_id" => "required|Integer"
        // ]);

        if (!is_numeric($client_id)) {
            return response()->json(['message' => 'client_id precisa ser um número!'], 400);
        }
    
        // if ($validator->fails()) {
        //     return response(
        //         $validator->errors(),
        //         400
        //     );
        // }

        $client = Company::findOrFail($client_id);

        if ($client) {
            return $client;
        } 
        
        return response()->json(['message' => 'Client not found!'], 404);
    }

    /**
     * Novo Processo
     * 
     * Cria um novo processo no sistema da Medi
     *  
     * @bodyParam  users.*.first_name string The first name of the user. Example: John
     * @bodyParam  yet_another_param object required Some object params.
     * 
     */
    public function newAccession()
    {
        // "medi_data_envio": "2020-07-01",dd($a['medi_cliente']);

        // "medi_cliente": "POSITIVA ADMINISTRADORA",
        // "medi_parceiro": "POSITIVA ADMINISTRADORA",
        // "proposta_operadora": "BRADESCO SAÚDE S.A.",
        // "proposta_numero": "0000000999",
        // "proposta_tipomov": "INCLUSÃO",
        // "proposta_vigencia": "2020-07-01",
        // "proposta_entidade": "CREMERJ",
        // "proposta_consultor": "CARLA CRISTINA DE SOUZA",
        // "proposta_corretora": "SOOMAR",

        $validator = Validator::make(request()->json()->all(), [
            "medi_cliente" => [
                "required",
                "String",
                function ($attribute, $value, $fail) {
                    
                    $exists = Company::where('name', '=', trim($value))->first();

                    if (!$exists) {
                        $fail($attribute.' não existe na Base de Dados da Medi Consultoria.');
                    }
                }
            ],
            "proposta_operadora" => [
                "required",
                function ($attribute, $value, $fail) {
                    
                    $exists = HealthPlan::where('name', '=', trim($value))->first();

                    if (!$exists) {
                        $fail($attribute.' não existe Esta Operadora de Saúde na Base de Dados da Medi Consultoria.');
                    }
                }
            ],
            "proposta_tipomov" => [
                "required",
                function ($attribute, $value, $fail) {
                    
                    $exists = ProcessType::where('type_of_process', '=', trim($value))->first();

                    if (!$exists) {
                        $fail($attribute.' tipo de Movimentação não existe na Base de Dados da Medi Consultoria.');
                    }
                }
            ],
            "perguntas_dps" => "required",
            "proposta_operadora" => "required",
            "beneficiarios.*.telcel" => "required",
            "beneficiarios.*.email" => 'required|email',
            "beneficiarios.*.cpf" => 'required|cpf',
            "beneficiarios.*.sexo" => 'required|in:M,F,m,f',
            "beneficiarios.*.cep" => 'required|numeric',
            "proposta_vigencia" => "required|date_format:Y-m-d",
            "proposta_vigencia" => "required|date_format:Y-m-d"
        ]);

        if ($validator->fails()) {
            return response(
                $validator->errors(),
                400
            );
        }

        $jsonData = request()->json()->all();

        // Helath Plan
        $healthPlan = HealthPlan::where('name', '=', trim($jsonData['proposta_operadora']))->first();
        if (!$healthPlan) {
            $healthPlan = HealthPlan::create([
                'name' => trim($jsonData['proposta_operadora'])
            ]);
        }    
        
        // Client
        $company = Company::where('name', '=', $jsonData['medi_cliente'])->first();

        $accession = Accession::create([
            'proposal_number' => $jsonData['proposta_numero'],
            'admin_partner' => $jsonData['medi_parceiro'],
            'health_plan_id' => $healthPlan->id,
            'company_id' => $company->id,
            'entity' => $jsonData['proposta_entidade'],
            'consult_partner' => $jsonData['proposta_consultor'],
            'received_at' => $jsonData['medi_data_envio'],
            'initial_validity' => $jsonData['proposta_vigencia'],
            'broker_partner' => $jsonData['proposta_corretora']
        ]);

        // 1. Quiz verifica se já existe Quiz com as perguntas iguais (é preciso verificar as perguntas), se houver , usar o ID do Quiz, ou 
        // inlcuir novo Quiz
        
        $questions = $jsonData['perguntas_dps'];
        
        $quizzes = Quiz::all();
        $requestedQuiz = 0;

        foreach($quizzes as $quiz) {
            // questions already exists
            if ($questions === $quiz->questions->pluck('question')->toArray()) {
                $requestedQuiz = $quiz;
                break;
            }            
        }

        if ($requestedQuiz === 0) {
            $requestedQuiz = Quiz::create([
                'name' => 'Questionário de ' . $company->name  . ' ' . date('d.m.Y.H:i:s')
            ]);

            foreach($questions as $question) {
                $newQuestion = HealthQuestion::create([
                    'question' => $question,
                    'description' => $question . ' de ' . $company->name,
                    'required' => true
                ]);
                
                $requestedQuiz->questions()->attach($newQuestion);
            }
        }

        $accession->quiz_id = $requestedQuiz->id;
        $accession->save();

        // 2. Incluir Beneficiário
        $beneficiaries = $jsonData['beneficiarios'];

        foreach($beneficiaries as $kBeneficiary => $beneficiary) {
            
            $newBeneficiary = Beneficiary::create([
                'name' => $beneficiary['nome'], 
                'email' => $beneficiary['email'], 
                'cpf' => $beneficiary['cpf'], 
                'birth_date' => $beneficiary['dt_nasc'], 
                'height' => $beneficiary['altura'], 
                'weight' => $beneficiary['peso'], 
                'imc' => $beneficiary['imc'], 
                'gender' => strtoupper($beneficiary['sexo']), 
                'accession_id' => $accession->id, 
                'age' => $beneficiary['idade']
            ]);
            
            // 2.1 Cadastrar telefones
            $telephones = [$beneficiary['telcel'], $beneficiary['telfixo'] ?? '', $beneficiary['telcom'] ?? ''];
            foreach($telephones as $telephone) {
                if ($telephone != '') {
                    Telephone::create([
                        'telephone' => $telephone,
                        'accession_id' => $accession->id
                    ]);
                }
            }

            // 2.2 Cadastrar endereço
            $address = new Address();
            $address->address = $beneficiary['endereco'];
            $address->number = $beneficiary['numero'];
            $address->complement = $beneficiary['complemento'];
            $address->city = strtoupper($beneficiary['municipio']);
            $address->state = strtoupper($beneficiary['uf']);
            $address->cep = $beneficiary['cep'];
            $address->accession_id = $accession->id;
            $address->save();

             // 3. Incluir respotas dadas no Quiz HealthDeclarationAnswer
            foreach($requestedQuiz->questions as $k => $question) {
                HealthDeclarationAnswer::create([
                    'question' => $k + 1,
                    'answer' => $beneficiary['respostas_dps'][$k]['resposta'],
                    'beneficiary_id' => $newBeneficiary->id,
                    'accession_id' => $accession->id,
                    'quiz_id' => $requestedQuiz->id,
                    'question_id' => $question->id
                ]);   
                
                // 3.1 incluir CIDs relatados na DS HealthDeclarationSpecific
                if (isset($beneficiary['respostas_dps'][$k]['CIDS']) && count($beneficiary['respostas_dps'][$k]['CIDS']) > 0) {
                    foreach($beneficiary['respostas_dps'][$k]['CIDS'] as $kCid => $cid) {
                        
                        HealthDeclarationSpecific::create([
                            'comment_number' => $k,
                            'comment_item' => $beneficiary['respostas_dps'][$k]['CIDS'][$kCid]['codigo'] . ' ' . $beneficiary['respostas_dps'][$k]['CIDS'][$kCid]['especificacao'],
                            'period_item' => $beneficiary['respostas_dps'][$k]['CIDS'][$kCid]['data_evento'],
                            'accession_id' => $accession->id,
                            'question_id' => $question->id,
                            'quiz_id' => $requestedQuiz->id,
                            'beneficiary_index' => $kBeneficiary + 1
                        ]);

                    }
                }
            }
            
            // Holder (Titular)
            if ($beneficiary['cpf'] == $jsonData['proposta_titular_cpf']) {
                $accession->holder_id = $newBeneficiary->id;
                $accession->save();
            }

        }



        return ['message' => 'success', 'process_number' => $accession->id];
    }

    /**
     * Declarações de Saúde
     * 
     * Retorna todas as declarações de saúde disponíveis no sistema Medi
     */
    public function healthDeclarations()
    {
        $healthDeclarations = Quiz::with(['questions' => function($query) {
            $query->select('question');
        }])->get();

        return $healthDeclarations;
    }


    /**
     * Retorna os Tipos de Movimentação (tipos de processo)
     * 
     * Return type of Process Types
     */
    public function processTypes()
    {
        return ProcessType::select('type_of_process')->get();
    }
}
