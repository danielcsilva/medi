<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\HealthQuestion;
use App\Http\Controllers\Controller;
use App\Quiz;
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

          
        // HealthDeclarationSpecific::where('accession_id', $accession_id)->delete(); 
        // HealthDeclarationAnswer::where('accession_id', $accession_id)->delete();
        // Address::where('accession_id', $accession_id)->delete();
        // Beneficiary::where('accession_id', $accession_id)->delete();
        // Telephone::where('accession_id', $accession_id)->delete();
 
        $validator = Validator::make(request()->json()->all(), [
            "medi_cliente" => "required|String",
            "perguntas_dps" => "required"
        ]);

        if ($validator->fails()) {
            return response(
                $validator->errors(),
                400
            );
        }

        $jsonData = request()->json()->all();
        
        $company = Company::where('name', 'like', '%' . $jsonData['medi_cliente'] . '%')->first();
        
        // 1. Quiz verifica se já existe Quiz com as perguntas iguais (é preciso verificar as perguntas), se houver , usar o ID do Quiz, ou 
        // inlcuir novo Quiz
        
        $questions = $jsonData['perguntas_dps'];
        
        $quizzes = Quiz::all();
        $requestedQuiz = 0;

        foreach($quizzes as $quiz) {
            // questions already exists
            if ($questions === $quiz->questions->pluck('question')->toArray()) {
                $requestedQuiz = $quiz->id;
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

        //dd($requestedQuiz);


        // 2. Incluir Beneficiário
        // 2.1 Cadastrar telefones
        // 2.2 Cadastrar endereço

        // 3. Incluir respotas dadas no Quiz HealDeclarationAnswer
        // 3.1 incluir CIDs relatados na DS HealthDeclarationSpecific


        return ['message' => 'not implemented yet!'];
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

}
