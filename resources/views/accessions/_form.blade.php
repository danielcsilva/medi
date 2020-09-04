@if($errors->any())
    <div class="alert alert-danger small">Seu formulário contém erros!</div>
@endif

@can('Editar Processos')

<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <label for="">Data do Recebimento</label>
        <input type="text" name="received_at" class="form-control date-br" value="{{ old('received_at', $accession->received_at ?? date('d/m/Y')) }}" required>
    </div>
    <div class="col-6">
        <label for="">Cliente</label>        
        <select id="inputState" class="form-control" name="company_id" required>
            <option value="">selecione</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @if(old('company_id', $accession->company_id ?? null) == $customer->id) selected @endif> {{ $customer->name }}</option>
            @endforeach
        </select>
        @if($errors->has('company_id'))
            <div class="alert alert-danger small">{{ $errors->first('company_id') }}</div>
        @endif
    </div>
    <div class="col-3">
        <label for="">Parceiro Administradora</label>
        <input type="text" name="admin_partner" class="form-control" value="{{ old('admin_partner', $accession->admin_partner ?? null) }}">
    </div>
    
    
</div>

<div class="form-row mb-4 mt-4">
    
    <div class="col-6">
        <label for="">Parceiro Operadora</label>        
        <select id="inputState" class="form-control" name="health_plan_id">
            <option value="">selecione</option>
            @foreach($healthplans as $healthplan)
                <option value="{{ $healthplan->id }}" @if(old('health_plan_id', $accession->health_plan_id ?? null) == $healthplan->id) selected @endif> {{ $healthplan->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-3">
        <label for="">Nº da Proposta</label>

        <input type="text" name="proposal_number" class="form-control" value="{{ old('proposal_number', $accession->proposal_number ?? null) }}" required>
    </div>
    <div class="col-3">
        <label for="">Início da Vigência</label>

        <input type="text" name="initial_validity" class="form-control date-br" value="{{ old('initial_validity', $accession->initial_validity ?? null) }}" required>
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <label for="">Parceiro Consultor</label>
        <input type="text" name="consult_partner" class="form-control" value="{{ old('consult_partner', $accession->consult_partner ?? null) }}">
    </div>
    <div class="col-3">
        <label for="">Parceiro Corretora</label>

        <input type="text" name="broker_partner" class="form-control" value="{{ old('broker_partner', $accession->broker_partner ?? null) }}">
    </div>
    <div class="col-6">
        <label for="">Entidade / Empresa</label>

        <input type="text" name="entity" class="form-control" value="{{ old('entity', $accession->entity ?? null) }}">
    </div>
</div>

<div>Titular</div>

<div id="repeater-colaborator">
    <div class="form-row mb-4 mt-4">
        <div class="col-3">
            <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf.0', $beneficiaries[0]->cpf ?? null) }}">            
            @if($errors->has('beneficiary_cpf.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_cpf.0') }}</div>
            @endif
        </div>
        <div class="col-5">
            <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control beneficiaries" value="{{ old('beneficiary_name.0', $beneficiaries[0]->name ?? null) }}" placeholder="Nome do beneficiário titular" required>            
            @if($errors->has('beneficiary_name.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_name.0') }}</div>
            @endif
        </div>
        <div class="col-4">
            <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email.0', $beneficiaries[0]->email ?? null) }}" placeholder="Email" required>
            @if($errors->has('beneficiary_email.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_email.0') }}</div>
            @endif
        </div>
    </div>
    
    <div class="form-row mb-4 mt-4">
        <div class="col">
            <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date.0', $beneficiaries[0]->birth_date ?? null) }}" class="form-control date-br" placeholder="Data de Nasc." required>
            @if($errors->has('beneficiary_birth_date.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_birth_date.0') }}</div>
            @endif
        </div>
        <div class="col">        
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                <option value="">Sexo</option>
                <option value="M" {{ (old('beneficiary_gender.0', $beneficiaries[0]->gender ?? null) == 'M' ? 'selected' : '') }}>Masculino</option>
                <option value="F" {{ (old('beneficiary_gender.0', $beneficiaries[0]->gender ?? null) == 'F' ? 'selected' : '') }}>Feminino</option>
            </select>
            @if($errors->has('beneficiary_gender.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_gender.0') }}</div>
            @endif
        </div>
        <div class="col">
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input financier" type="radio" name="beneficiary_financier[]" {{ old('beneficiary_financier.0', (isset($accession->financier_id) && $accession->financier_id == $beneficiaries[0]->id ? 1 : '' )) == 1 ? "checked" : "" }} value="1">
                <label class="form-check-label" for="financier">Financiador</label>
            </div>
        </div>
    </div>

    <div class="form-row mb-4 mt-4 address">
        <div class="col-2">
            <input type="text" name="address_cep[]" value="{{ old('address_cep.0', $addresses[0]->cep ?? null) }}" id="address-cep" class="form-control cep" placeholder="CEP">
            @if($errors->has('address_cep.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_cep.0') }}</div>
            @endif
        </div>
        <div class="col-6">
            <input type="text" name="address_address[]" value="{{ old('address_address.0', $addresses[0]->address ?? null) }}" class="form-control" placeholder="rua de exemplo...">
            @if($errors->has('address_address.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_address.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="number" name="address_number[]" value="{{ old('address_number.0', $addresses[0]->number ?? null) }}" class="form-control" placeholder="número...">
            @if($errors->has('address_number.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_number.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="text" name="address_complement[]" value="{{ old('address_complement.0', $addresses[0]->complement ?? null) }}" class="form-control" placeholder="complemento...">
            @if($errors->has('address_complement.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_complement.0') }}</div>
            @endif
        </div>
    </div>

    <div class="form-row mb-4 mt-4 address-city-state">
        <div class="col-4">
            <input type="text" name="address_city[]" value="{{ old('address_city.0', $addresses[0]->city ?? null) }}" class="form-control" placeholder="Cidade">
            @if($errors->has('address_city.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_city.0') }}</div>
            @endif
        </div>
        <div class="col-2">
            <input type="text" name="address_state[]" value="{{ old('address_state.0', $addresses[0]->state ?? null) }}" class="form-control" placeholder="UF">
            @if($errors->has('address_state.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_state.0') }}</div>
            @endif
        </div>
    </div>

    <div class="form-row mb-4 mt-4">
        <div class="col-2">
            <label for="">Altura</label>
            <input type="number" name="beneficiary_height[]" step=".01" value="{{ old('beneficiary_height.0', $beneficiaries[0]->height ?? null) }}" class="form-control height" placeholder="Altura">
            @if($errors->has('beneficiary_height.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_height.0') }}</div>
            @endif
        </div>
        <div class="col-2">
            <label for="">Peso</label>
            <input type="number" name="beneficiary_weight[]" step=".01" value="{{ old('beneficiary_weight.0', $beneficiaries[0]->weight ?? null) }}" class="form-control weight" placeholder="Peso">
            @if($errors->has('beneficiary_weight.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_weight.0') }}</div>
            @endif
        </div>
        <div class="col-2">
            <label for="">IMC</label>
            <input type="number" name="beneficiary_imc[]" step=".01" value="{{ old('beneficiary_imc.0', $beneficiaries[0]->imc ?? null) }}" class="form-control imc-calc" placeholder="Peso">
            @if($errors->has('beneficiary_imc.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_imc.0') }}</div>
            @endif
        </div>
    </div>

</div>


<div class="form-row">
    <div class="col-md-3">
        
        <div class="form-group" id="telephone-repeater">            
            <label for="telephone">Telefones <a href="#" id="addTelephone">(+)</a></label>
            @if($errors->has('beneficiary_telephone.0'))
                <div class="alert alert-danger small mb-10">{{ $errors->first('beneficiary_telephone.*') }}</div>
            @endif
            <div class="input-group repeat-telephone mb-2 mt-2">
                <input type="text" class="form-control telephone" name="beneficiary_telephone[]" aria-describedby="telephonelHelp" value="{{ old('beneficiary_telephone.0', $telephones[0]->telephone ?? null) }}">
                <div class="input-group-append">
                    <span class="input-group-text remove-telephone" style="display:none;"><img src="/images/delete.png" alt=""></span>
                </div>
                
            </div>
            @if(old('beneficiary_telephone') || ($telephones ?? false))
                @foreach(old('beneficiary_telephone', $telephones ?? null) as $k => $v)
                    @if($k > 0)
                    <div class="input-group repeat-telephone mb-2 mt-2">
                        <input type="text" class="form-control telephone" name="beneficiary_telephone[]" aria-describedby="telephonelHelp" value="{{ old('beneficiary_telephone.' . $k, $v->telephone ?? null) }}">
                        <div class="input-group-append">
                            <span class="input-group-text remove-telephone" style="display:block;"><img src="/images/delete.png" alt=""></span>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
    
    </div>

</div>


<div class="form-row mb-4 mt-4">
    <div class="col">
        <a href="#" id="addColaborator">Adicionar Dependente</a>
    </div>
</div>

<div id="dependents">
    
    @if(old('beneficiary_cpf', $beneficiaries ?? false))
        @foreach(old('beneficiary_cpf', $beneficiaries ?? null) as $k => $v)
            @if($k > 0)
            
            <fieldset class="form-group dependent"><span class="count">#{{ $k }}</span>

                <span class="delete-dependent">
                    <a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>
                </span>

                <div class="form-row mb-4 mt-4">
                    <div class="col-3">
                        <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf.' . $k, $v->cpf ?? null) }}" />
                        @if($errors->has('beneficiary_cpf.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_cpf.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-5">
                        <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name.' . $k, $v->name ?? null) }}" placeholder="Nome do beneficiário dependente" required1>            
                        @if($errors->has('beneficiary_name.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_name.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-4">
                        <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email.' . $k, $v->email ?? null) }}" placeholder="Email" required1>
                        @if($errors->has('beneficiary_email.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_email.'.$k) }}</div>
                        @endif
                    </div>
                </div>
                
                <div class="form-row mb-4 mt-4">
                    <div class="col">
                        <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date.' . $k, $v->birth_date ?? null) }}" class="form-control date-br" placeholder="Data de Nasc." required>
                        @if($errors->has('beneficiary_birth_date.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_birth_date.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">        
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                            <option value="">Sexo</option>
                            <option value="M" @if(old('beneficiary_gender.' . $k, $v->gender ?? null) == 'M') selected @endif>Masculino</option>
                            <option value="F" @if(old('beneficiary_gender.' . $k, $v->gender ?? null) == 'F') selected @endif>Feminino</option>
                        </select>
                        @if($errors->has('beneficiary_gender.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_gender.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input financier" type="radio" name="beneficiary_financier[]" {{ old('beneficiary_financier.0', (isset($accession->financier_id) && $accession->financier_id == $v->id ? $k + 1 : '')) == ($k + 1) ? "checked" : "" }} value="{{ $k }}">
                            <label class="form-check-label" for="financier">Financiador</label>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-4 mt-4 address">
                    <div class="col-2">
            
                        <input type="hidden" name="address_id[]" value="{{ old('address_cep.' . $k, $addresses[$k]->id ?? null) }}">

                        <input type="text" name="address_cep[]" value="{{ old('address_cep.' . $k, $addresses[$k]->cep ?? null) }}" id="address-cep" class="form-control cep" placeholder="CEP">
                        @if($errors->has('address_cep.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_cep.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-6">
                        <input type="text" name="address_address[]" value="{{ old('address_address.' . $k, $addresses[$k]->address ?? null) }}" class="form-control" placeholder="rua de exemplo...">
                        @if($errors->has('address_address.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_address.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="number" name="address_number[]" value="{{ old('address_number.' . $k, $addresses[$k]->number ?? null) }}" class="form-control" placeholder="número...">
                        @if($errors->has('address_number.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_number.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="text" name="address_complement[]" value="{{ old('address_complement.' . $k, $addresses[$k]->complement ?? null) }}" class="form-control" placeholder="complemento...">
                        @if($errors->has('address_complement.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_complement.'.$k) }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-row mb-4 mt-4 address-city-state">
                    <div class="col-4">
                        <input type="text" name="address_city[]" value="{{ old('address_city.' . $k, $addresses[$k]->city ?? null) }}" class="form-control" placeholder="Cidade">
                        @if($errors->has('address_city.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_city.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-2">
                        <input type="text" name="address_state[]" value="{{ old('address_state.' . $k, $addresses[$k]->state ?? null) }}" class="form-control" placeholder="UF">
                        @if($errors->has('address_state.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_state.'.$k) }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-row mb-4 mt-4">
                    <div class="col-2">
                        <label for="">Altura</label>
                        <input type="number" name="beneficiary_height[]" step=".01" value="{{ old('beneficiary_height.' . $k, $beneficiaries[$k]->height ?? null) }}" class="form-control" placeholder="Altura" required>
                        @if($errors->has('beneficiary_height.0'))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_height.' . $k) }}</div>
                        @endif
                    </div>
                    <div class="col-2">
                        <label for="">Peso</label>
                        <input type="number" name="beneficiary_weight[]" step=".01" value="{{ old('beneficiary_weight.' . $k, $beneficiaries[$k]->weight ?? null) }}" class="form-control" placeholder="Peso" required>
                        @if($errors->has('beneficiary_weight.0'))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_weight.' . $k) }}</div>
                        @endif
                    </div>
                </div>
            </fieldset>

            @endif
        @endforeach
    @endif        

</div>

@endcan 

@livewire('healthdeclaration', ['accession' => $accession ?? null, 'beneficiaries' => $beneficiaries ?? null])


<div class="row mb-4 mt-4">
    <div class="col-2">
        <button type="submit" class="btn btn-primary text-nowrap">Salvar Processo</button>
    </div>
    <div class="col">
        <div class="form-check form-check-inline mt-2">
            <input class="form-check-input" type="checkbox" name="to_contact" {{ (old('to_contact', $accession->to_contact ?? null) ? 'checked' : '')  }} value="1">
            <label class="form-check-label" for="">Liberado para contato?</label>
        </div>
    </div>
</div>

<input type="hidden" class="ignore" name="toDelete" id="toDelete" value="" />

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Deseja realmente excluir o registro?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="delete-dependent-confirm">Sim</button>
        </div>
        </div>
    </div>
</div>

@section('jscontent')

    <script src="{{ mix('js/accession.js') }}"></script>

@endsection
