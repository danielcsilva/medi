<?php

namespace App\Repositories;

use App\Accession;
use App\Address;
use App\Beneficiary;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\Telephone;
use DateTime;
use Illuminate\Support\Facades\DB;

class AccessionRepository 
{
    public function saveProcess($request, $beneficiaries, $telephones, $accession_id = null)
    {
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
                'entity' => $request->get('entity')
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
                    'accession_id' => $accession->id
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
                
                if ($request->get('question')) {
                    
                    $questions = $request->get('question');
                    foreach($questions as $k1 => $v1) { // questions of Health Declaration
                        
                        HealthDeclarationAnswer::create([
                            'question' => $request->get('question')[$k1],
                            'answer' => $request->get($field)[$k1],
                            'beneficiary_id' => $beneficiary->id,
                            'accession_id' => $accession->id
                        ]);
                        
                        if ($request->get($field)[$k1] == 'S') { // specific points on Helth Declaration
                            HealthDeclarationSpecific::create([
                                'comment_number' => $request->get('comment_number')[$k],
                                'comment_item' => $request->get('comment_item')[$k],
                                'period_item' => $request->get('period_item')[$k],
                                'accession_id' => $accession->id,
                                'beneficiary_id' => $beneficiary->id
                            ]);
                        }
                    }

                }

                // beneficiaries index from _form view
                if (isset($request->get('beneficiary_financier')[0]) && $request->get('beneficiary_financier')[0] == ($k + 1)) {                    
                    $accession->financier_id = $beneficiary->id;
                }

            }          

            $accession->save();
        });
    }
}