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
        <select id="inputState" class="form-control" name="company_id" required1>
            <option value="">selecione</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @if(old('company_id', $accession->company_id ?? null) == $customer->id) selected @endif> {{ $customer->name }}</option>
            @endforeach
        </select>
        
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

        <input type="text" name="proposal_number" class="form-control" value="{{ old('proposal_number', $accession->proposal_number ?? null) }}" required1>
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
            <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf.0', $beneficiaries[0]->cpf ?? null) }}" required>            
            @if($errors->has('beneficiary_cpf.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_cpf.0') }}</div>
            @endif
        </div>
        <div class="col-5">
            <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name.0', $beneficiaries[0]->name ?? null) }}" placeholder="Nome do beneficiário titular" required>            
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
            <input type="number" name="beneficiary_height[]" step=".01" value="{{ old('beneficiary_height.0', $beneficiaries[0]->height ?? null) }}" class="form-control" placeholder="Altura" required1>
            @if($errors->has('beneficiary_height.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_height.0') }}</div>
            @endif
        </div>
        <div class="col-2">
            <label for="">Peso</label>
            <input type="number" name="beneficiary_weight[]" step=".01" value="{{ old('beneficiary_weight.0', $beneficiaries[0]->weight ?? null) }}" class="form-control" placeholder="Peso" required1>
            @if($errors->has('beneficiary_weight.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_weight.0') }}</div>
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

<div class="form-row mb-4 mt-4">
    <div class="col-6">
        <label for="health-declaration">Escolha um Modelo de DS</label>
        <select id="health-declaration" class="form-control" name="health_declaration">
            <option value="">...</option>
            @foreach($quizzes as $quiz)
                <option value="{{ $quiz->id }}" @if(old('health_declaration', $accession->quiz_id ?? null) == $quiz->id) selected @endif> {{ $quiz->name }}</option>
            @endforeach
        </select>
    </div>
</div>


@if(old('holder_answer'))
    @foreach(old('holder_answer') as $k => $v)
        <input type="hidden" id="holder_answer.{{ $k }}" value="{{ old('holder_answer.' . $k) }}">
    @endforeach
@endif

@for($i = 1; $i <= 10; $i++)
    @if(old('dependent_'.$i))
        @foreach(old('dependent_'.$i) as $k => $v)
            <input type="hidden" id="dependent_{{ $i }}.{{ $k }}" value="{{ old('dependent_'.$i.'.' . $k) }}">
        @endforeach
    @endif
@endfor

@if(isset($beneficiaries) && isset($answers))
    @foreach ($beneficiaries as $k => $v)
        @if ($k == 0)
            @foreach($answers as $k1 => $v1)
                @if ($v1->beneficiary_id == $v->id)
                    <input type="hidden" id="holder_answer.{{ $k1 }}" value="{{ $v1->answer }}">
                @endif
            @endforeach
        @else 
            @php 
                $question = 0
            @endphp
            @foreach($answers as $k1 => $v1)
                @if ($k1 > 0 && $v1->beneficiary_id == $v->id)
                    <input type="hidden" id="dependent_{{ $k }}.{{ $question }}" value="{{ $v1->answer }}">
                    @php
                        $question++
                    @endphp
                @endif
            @endforeach
        @endif
    @endforeach
@endif

<div class="form-row mb-4 mt-4">
    <div class="col">
        <table id="health-declaration-table" class="table table-striped">                 
        </table>        
    </div>
</div>

@if ($specifics)
    @foreach($specifics as $specific_k => $specific_v)
        <input type="hidden" id="specific-item-{{ ($specific_k + 1) }}" value="{{ old('comment_number.' . ($specific_k + 1), $specific_v->comment_number ?? null) }}" />
    @endforeach
@endif

<div id="comments-by-item" style="display:none;">
    <label>Em caso de existência de doença, especifique o item, subitem e proponente</label>
    @for($i = 0; $i < 5; $i++)
        <div class="form-row mb-1 mt-1">
            <div class="col-1">
                # {{ $i + 1 }}
            </div>
            <div class="col-2">
                <select name="comment_number[]" class="specific-items form-control"> 
                    <option value="">selecione</option>
                </select>
            </div>
            <div class="col">
                <input type="text" name="comment_item[]" class="form-control" placeholder="especificação" value="{{ old('comment_item.' . $i, $specifics[$i]->comment_item ?? null) ?? null }}" />
            </div>
            <div class="col">
                <input type="text" name="period_item[]" class="form-control" placeholder="período da doença" value="{{ old('period_item.' . $i, $specifics[$i]->period_item ?? null) ?? null }}" />
            </div>
        </div>
    @endfor
</div>

<div class="form-row mb-4 mt-4" id="health-declaration-comments" style="display:none;">
    <div class="col">
        <label for="health-declaration-comments">Comentários da DS</label>
        <textarea name="health_declaration_comments" class="form-control" id="" cols="30" rows="5">{{ old('health_declaration_comments', $accession->comments ?? null) }}</textarea>
    </div>
</div>

<div class="row mb-4" style="margin-top:60px;">
    <div class="col-6"><h4>Dados sobre o Contato</h4></div>
</div>

<div class="row mb-4 mt-4">
    <div class="col-3">
        <label for="">Data do Contato</label>
        <input type="text" class="form-control date-br" name="contacted_date" value="{{ old('contacted_date', $accession->contacted_date ?? null) }}">
    </div>
    <div class="col-4">
        <label>Informar inconsistência(s)</label>
        <select class="form-control" multiple name="inconsistencies[]" style="height: 200px;">
            @if ($inconsistencies)
                    @foreach($inconsistencies as $inconsistency)
                        <option value="{{ $inconsistency->id }}" {{ ( isset($accession) && in_array($inconsistency->id, $accession->inconsistencies->pluck('id')->toArray()) ? 'selected' : '' ) }}>{{ $inconsistency->name }}</option>
                    @endforeach
            @endif
        </select>
    </div>
    <div class="col">
        <label for="health-declaration-comments">Comentários do Contato</label>
        <textarea name="contacted_comments" class="form-control" id="" cols="30" rows="8">{{ old('contacted_comments', $accession->contacted_comments ?? null) }}</textarea>
    </div>
</div>

@can('Editar Entrevistas')

    <div class="row mb-4" style="margin-top:60px;">
        <div class="col-6"><h4>Dados da Entrevista</h4></div>
    </div>


    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Nome do Entrevistado</label>
            <input type="text" class="form-control" name="interviewed_name" value="{{ old('interviewed_name', $accession->interviewed_name ?? null) }}">
        </div>
        <div class="col">
            <label for="">Data da Entrevista</label>
            <input type="text" class="form-control date-br" name="interview_date" value="{{ old('interview_date', $accession->interview_date ?? null) }}">
        </div>
        <div class="col">
            <label for="">Entrevistado por</label>
            <input type="text" class="form-control" name="interviewed_by" value="{{ Auth::user()->name }}">
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Comentários da Entrevista</label>
            <textarea name="interview_comments" class="form-control" id="" cols="30" rows="8">{{ old('interview_comments', $accession->interview_comments ?? null) }}</textarea>
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Entrevista validada </label>
            <input type="checkbox" name="interview_validated" class="" {{ old('interview_validated', $accession->interview_validated ?? 0) !== 0 ? 'checked' : ''}} value="1">
        </div>
    </div>

@endcan

@can('Avaliar Processos Clinicamente')
    
    <div class="row mb-4" style="margin-top:60px;">
        <div class="col-6"><h4>Classificação Médica</h4></div>
    </div>

    <div class="row mb-4 mt-4">
        
        <div class="col">
            <label for="">Grau de Risco</label>
            <select class="form-control" name="risk_grade_id">
                @if ($riskgrades)
                    <option value=""></option>
                    @foreach($riskgrades as $risk)
                        <option value="{{ $risk->id }}" {{ old('risk_grade_id', $risk->id ?? null) === (isset($accession) && $accession->risk_grade_id) ? 'selected' : '' }}>{{ $risk->risk }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    
        <div class="col">
            <label for="">Sugestão de Tratamento</label>
            <select class="form-control" name="suggestion_id">
                @if ($suggestions)
                    <option value=""></option>
                    @foreach($suggestions as $suggestion)
                        <option value="{{ $suggestion->id }}" {{ old('suggestion_id', $suggestion->id ?? null) === (isset($accession) && $accession->suggestion_id) ? 'selected' : '' }}>{{ $suggestion->suggestion }}</option>
                    @endforeach
                @endif
            </select>
        </div>

    </div>
@endcan

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar Processo</button>
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
