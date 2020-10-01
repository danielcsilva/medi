<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function myProfile($id)
    {
        return ['message' => 'not implemented yet!'];
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
        return ['message' => 'not implemented yet!'];
    }
}
