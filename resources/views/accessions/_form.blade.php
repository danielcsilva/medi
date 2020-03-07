@if($errors->any())
    <div class="alert alert-danger small">Seu formulário contém erros!</div>
@endif

<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <label for="">Data do Recebimento</label>
        <input type="text" name="received_at" class="form-control date-br" value="{{ old('received_at', $accession->received_at ?? date('d/m/Y')) }}" required1>
    </div>
    <div class="col-3">
        <label for="">Nº da Proposta</label>

        <input type="text" name="proposal_number" class="form-control" value="{{ old('proposal_number', $accession->proposal_number ?? null) }}" required1>
    </div>
    <div class="col-6">
        <label for="">Cliente</label>        
        <select id="inputState" class="form-control" name="company_id" required1>
            <option value="">selecione</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @if(old('company_id') == $customer->id) selected @endif> {{ $customer->name }}</option>
            @endforeach
        </select>
        
    </div>
</div>


<div id="repeater-colaborator">

    <div class="form-row mb-4 mt-4">
        <div class="col-3">
            <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf.0') }}" required1>            
            @if($errors->has('beneficiary_cpf.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_cpf.0') }}</div>
            @endif
        </div>
        <div class="col-5">
            <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name.0') }}" placeholder="Nome do beneficiário titular" required1>            
            @if($errors->has('beneficiary_name.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_name.0') }}</div>
            @endif
        </div>
        <div class="col-4">
            <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email.0') }}" placeholder="Email" required1>
            @if($errors->has('beneficiary_email.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_email.0') }}</div>
            @endif
        </div>
    </div>
    
    <div class="form-row mb-4 mt-4">
        <div class="col">
            <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date.0') }}" class="form-control date-br" placeholder="Data de Nasc." required1>
            @if($errors->has('beneficiary_birth_date.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_birth_date.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="number" name="beneficiary_height[]" step=".01" value="{{ old('beneficiary_height.0') }}" class="form-control" placeholder="Altura" required1>
            @if($errors->has('beneficiary_height.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_height.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="number" name="beneficiary_weight[]" step=".01" value="{{ old('beneficiary_weight.0') }}" class="form-control" placeholder="Peso" required1>
            @if($errors->has('beneficiary_weight.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_weight.0') }}</div>
            @endif
        </div>
        <div class="col">        
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                <option value="">Sexo</option>
                <option value="M" {{ (old('beneficiary_gender.0') && old('beneficiary_gender.0') == 'M' ? 'selected' : '') }}>Masculino</option>
                <option value="F" {{ (old('beneficiary_gender.0') && old('beneficiary_gender.0') == 'M' ? 'selected' : '') }}>Feminino</option>
            </select>
            @if($errors->has('beneficiary_gender.0'))
                <div class="alert alert-danger small">{{ $errors->first('beneficiary_gender.0') }}</div>
            @endif
        </div>
        <div class="col">
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="checkbox" id="financier" name="beneficiary_financier[]" value="1">
                <label class="form-check-label" for="financier">Financiador</label>
            </div>
        </div>
    </div>

    <div class="form-row mb-4 mt-4 address">
        <div class="col-2">
            <input type="text" name="address_cep[]" value="{{ old('address_cep.0') }}" id="address-cep" class="form-control cep" placeholder="CEP">
            @if($errors->has('address_cep.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_cep.0') }}</div>
            @endif
        </div>
        <div class="col-6">
            <input type="text" name="address_address[]" value="{{ old('address_address.0') }}" class="form-control" placeholder="rua de exemplo...">
            @if($errors->has('address_address.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_address.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="number" name="address_number[]" value="{{ old('address_number.0') }}" class="form-control" placeholder="número...">
            @if($errors->has('address_number.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_number.0') }}</div>
            @endif
        </div>
        <div class="col">
            <input type="text" name="address_complement[]" value="{{ old('address_complement.0') }}" class="form-control" placeholder="complemento...">
            @if($errors->has('address_complement.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_complement.0') }}</div>
            @endif
        </div>
    </div>

    <div class="form-row mb-4 mt-4 address-city-state">
        <div class="col-4">
            <input type="text" name="address_city[]" value="{{ old('address_city.0') }}" class="form-control" placeholder="Cidade">
            @if($errors->has('address_city.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_city.0') }}</div>
            @endif
        </div>
        <div class="col-2">
            <input type="text" name="address_state[]" value="{{ old('address_state.0') }}" class="form-control" placeholder="UF">
            @if($errors->has('address_state.0'))
                <div class="alert alert-danger small">{{ $errors->first('address_state.0') }}</div>
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
                <input type="text" class="form-control telephone" name="beneficiary_telephone[]" aria-describedby="telephonelHelp" value="{{ old('beneficiary_telephone.0') }}">
                <div class="input-group-append">
                    <span class="input-group-text remove-telephone" style="display:none;"><img src="/images/delete.png" alt=""></span>
                </div>
                
            </div>
            @if(old('beneficiary_telephone'))
                @foreach(old('beneficiary_telephone') as $k => $v)
                    @if($k > 0)
                    <div class="input-group repeat-telephone mb-2 mt-2">
                        <input type="text" class="form-control telephone" name="beneficiary_telephone[]" aria-describedby="telephonelHelp" value="{{ old('beneficiary_telephone')[$k] }}">
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
    
    @if(old('beneficiary_cpf'))
        @foreach(old('beneficiary_cpf') as $k => $v)
            @if($k > 0)
            
            <fieldset class="form-group dependent"><span class="count">#{{ $k }}</span>
                <span class="delete-dependent">
                    <a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>
                </span>

                <div class="form-row mb-4 mt-4">
                    <div class="col-3">
                        <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf')[$k] }}" />
                        @if($errors->has('beneficiary_cpf.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_cpf.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-5">
                        <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name')[$k] }}" placeholder="Nome do beneficiário dependente" required1>            
                        @if($errors->has('beneficiary_name.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_name.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-4">
                        <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email')[$k] }}" placeholder="Email" required1>
                        @if($errors->has('beneficiary_email.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_email.'.$k) }}</div>
                        @endif
                    </div>
                </div>
                
                <div class="form-row mb-4 mt-4">
                    <div class="col">
                        <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date')[$k] }}" class="form-control date-br" placeholder="Data de Nasc." required1>
                        @if($errors->has('beneficiary_birth_date.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_birth_date.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="number" step=".01" name="beneficiary_height[]" value="{{ old('beneficiary_height')[$k] }}" class="form-control" placeholder="Altura" required1>
                        @if($errors->has('beneficiary_height.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_height.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="number" step=".01" name="beneficiary_weight[]" value="{{ old('beneficiary_weight')[$k] }}" class="form-control" placeholder="Peso" required1>
                        @if($errors->has('beneficiary_weight.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_weight.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">        
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                            <option value="">Sexo</option>
                            <option value="M" @if(old('beneficiary_gender')[$k]) selected @endif>Masculino</option>
                            <option value="F" @if(old('beneficiary_gender')[$k]) selected @endif>Feminino</option>
                        </select>
                        @if($errors->has('beneficiary_gender.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('beneficiary_gender.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="checkbox" id="financier" name="beneficiary_financier[]" value="1">
                            <label class="form-check-label" for="financier">Financiador</label>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-4 mt-4 address">
                    <div class="col-2">
                        <input type="text" name="address_cep[]" value="{{ old('address_cep')[$k] }}" id="address-cep" class="form-control cep" placeholder="CEP">
                        @if($errors->has('address_cep.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_cep.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-6">
                        <input type="text" name="address_address[]" value="{{ old('address_address')[$k] }}" class="form-control" placeholder="rua de exemplo...">
                        @if($errors->has('address_address.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_address.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="number" name="address_number[]" value="{{ old('address_number')[$k] }}" class="form-control" placeholder="número...">
                        @if($errors->has('address_number.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_number.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col">
                        <input type="text" name="address_complement[]" value="{{ old('address_complement')[$k] }}" class="form-control" placeholder="complemento...">
                        @if($errors->has('address_complement.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_complement.'.$k) }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-row mb-4 mt-4 address-city-state">
                    <div class="col-4">
                        <input type="text" name="address_city[]" value="{{ old('address_city')[$k] }}" class="form-control" placeholder="Cidade">
                        @if($errors->has('address_city.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_city.'.$k) }}</div>
                        @endif
                    </div>
                    <div class="col-2">
                        <input type="text" name="address_state[]" value="{{ old('address_state')[$k] }}" class="form-control" placeholder="UF">
                        @if($errors->has('address_state.'.$k))
                            <div class="alert alert-danger small">{{ $errors->first('address_state.'.$k) }}</div>
                        @endif
                    </div>
                </div>
            </fieldset>

            @endif
        @endforeach
    @endif        

</div>

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

<div class="form-row mb-4 mt-4">
    <div class="col">
        <table id="health-declaration-table" class="table table-striped">                 
        </table>        
    </div>
</div>

<div id="comments-by-item" style="display:none;">
    <label>Em caso de existência de doença, especifique o item, subitem e proponente</label>
    @for($i = 0; $i < 5; $i++)
        <div class="form-row mb-1 mt-1">
            <div class="col-1">
            # {{ $i + 1 }}<input type="hidden" name="comment_number[]" value="{{ old('comment_number')[$i] ?? null }}">
            </div>
            <div class="col">
                <input type="text" name="comment_item[]" class="form-control" placeholder="especificação" value="{{ old('comment_item')[$i] ?? null }}" />
            </div>
            <div class="col">
                <input type="text" name="period_item[]" class="form-control" placeholder="período da doença" value="{{ old('period_item')[$i] ?? null }}" />
            </div>
        </div>
    @endfor
</div>

<div class="form-row mb-4 mt-4" id="health-declaration-comments" style="display:none;">
    <div class="col">
        <label for="health-declaration-comments">Comentários da DS</label>
        <textarea name="health_declaration_comments" class="form-control" id="" cols="30" rows="5">{{ old('health_declaration_comments') }}</textarea>
    </div>
</div>


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
