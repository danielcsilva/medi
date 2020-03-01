@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <label for="">Data do Recebimento</label>
        <input type="text" name="received_at" class="form-control date-br" value="{{ old('received_at', date('d/m/Y')) }}" required1>
    </div>
    <div class="col-3">
        <label for="">Nº da Proposta</label>

        <input type="text" name="proposal_number" class="form-control" value="{{ old('proposal_number', '') }}" required1>
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
        </div>
        <div class="col-5">
            <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name.0') }}" placeholder="Nome do beneficiário titular" required1>            
        </div>
        <div class="col-4">
            <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email.0') }}" placeholder="Email" required1>
        </div>
    </div>
    
    <div class="form-row mb-4 mt-4">
        <div class="col">
            <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date.0') }}" class="form-control date-br" placeholder="Data de Nasc." required1>
        </div>
        <div class="col">
            <input type="text" name="beneficiary_height[]" value="{{ old('beneficiary_height.0') }}" class="form-control" placeholder="Altura" required1>
        </div>
        <div class="col">
            <input type="text" name="beneficiary_weight[]" value="{{ old('beneficiary_weight.0') }}" class="form-control" placeholder="Peso" required1>
        </div>
        <div class="col">        
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                <option value="">Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
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
            <input type="text" name="address_cep[]" id="address-cep" class="form-control cep" placeholder="CEP">
        </div>
        <div class="col-6">
            <input type="text" name="address_address[]" class="form-control" placeholder="rua de exemplo...">
        </div>
        <div class="col">
            <input type="text" name="address_number[]" class="form-control" placeholder="número...">
        </div>
        <div class="col">
            <input type="text" name="address_complement[]" class="form-control" placeholder="complemento...">
        </div>
    </div>

    <div class="form-row mb-4 mt-4 address-city-state">
        <div class="col-4">
            <input type="text" name="address_city[]" class="form-control" placeholder="Cidade">
        </div>
        <div class="col-2">
            <input type="text" name="address_state[]" class="form-control" placeholder="UF">
        </div>
    </div>

</div>


<div class="form-row">
    <div class="col-md-3">

        <div class="form-group" id="telephone-repeater">            
            <label for="telephone">Telefones <a href="#" id="addTelephone">(+)</a></label>
            <div class="input-group repeat-telephone mb-2 mt-2">
                <input type="text" class="form-control telephone" name="beneficiary_telephone[]" aria-describedby="telephonelHelp">
                <div class="input-group-append">
                    <span class="input-group-text remove-telephone" style="display:none;"><img src="/images/delete.png" alt=""></span>
                </div>
            </div>
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
                        <input type="text" name="beneficiary_cpf[]" class="form-control cpf" placeholder="CPF" value="{{ old('beneficiary_cpf')[$k] }}" required1>            
                    </div>
                    <div class="col-5">
                        <input type="text" name="beneficiary_name[]" id="beneficiary-name" class="form-control" value="{{ old('beneficiary_name.0') }}" placeholder="Nome do beneficiário titular" required1>            
                    </div>
                    <div class="col-4">
                        <input type="email" name="beneficiary_email[]" id="beneficiary-email" class="form-control" value="{{ old('beneficiary_email.0') }}" placeholder="Email" required1>
                    </div>
                </div>
                
                <div class="form-row mb-4 mt-4">
                    <div class="col">
                        <input type="text" name="beneficiary_birth_date[]" value="{{ old('beneficiary_birth_date.0') }}" class="form-control date-br" placeholder="Data de Nasc." required1>
                    </div>
                    <div class="col">
                        <input type="text" name="beneficiary_height[]" value="{{ old('beneficiary_height.0') }}" class="form-control" placeholder="Altura" required1>
                    </div>
                    <div class="col">
                        <input type="text" name="beneficiary_weight[]" value="{{ old('beneficiary_weight.0') }}" class="form-control" placeholder="Peso" required1>
                    </div>
                    <div class="col">        
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender[]" required1>
                            <option value="">Sexo</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
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
                        <input type="text" name="address_cep[]" id="address-cep" class="form-control cep" placeholder="CEP">
                    </div>
                    <div class="col-6">
                        <input type="text" name="address_address[]" class="form-control" placeholder="rua de exemplo...">
                    </div>
                    <div class="col">
                        <input type="text" name="address_number[]" class="form-control" placeholder="número...">
                    </div>
                    <div class="col">
                        <input type="text" name="address_complement[]" class="form-control" placeholder="complemento...">
                    </div>
                </div>

                <div class="form-row mb-4 mt-4 address-city-state">
                    <div class="col-4">
                        <input type="text" name="address_city[]" class="form-control" placeholder="Cidade">
                    </div>
                    <div class="col-2">
                        <input type="text" name="address_state[]" class="form-control" placeholder="UF">
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
        <select id="health-declaration" class="form-control" name="health_declaration" required1>
            <option value="">...</option>
            @foreach($quizzes as $quiz)
                <option value="{{ $quiz->id }}" @if(old('health_declaration') == $quiz->id) selected @endif> {{ $quiz->name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="form-row mb-4 mt-4">
    <div class="col">
        <table id="health-declaration-table" class="table table-striped">
        </table>        
    </div>
</div>

<div id="comments-by-item">
</div>

<div class="form-row mb-4 mt-4" id="health-declaration-comments" style="display:none;">
    <div class="col">
        <label for="health-declaration-comments">Comentários da DS</label>
        <textarea name="health_declaration_comments" class="form-control" id="" cols="30" rows="5"></textarea>
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
