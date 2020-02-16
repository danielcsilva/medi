<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <input type="text" name="proposal_number" class="form-control" placeholder="Nº da Proposta" value="">
    </div>
    <div class="col-3">
        <input type="text" name="received_at" class="form-control" placeholder="Data de Recebimento" value="{{ date('d/m/Y') }}">
    </div>
    <div class="col-6">
        
        <select id="inputState" class="form-control">
            <option>Cliente</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"> {{ $customer->name }}</option>
            @endforeach
        </select>
        
    </div>
</div>



<div id="repeater-colaborator">

    <div class="form-row mb-4 mt-4">
        <div class="col-6">
            <input type="text" name="beneficiary_name" class="form-control" placeholder="Nome do beneficiário titular" value="">
        </div>
        <div class="col-6">
            <input type="email" name="beneficiary_email" class="form-control" placeholder="Email">
        </div>
    </div>
    
    <div class="form-row mb-4 mt-4">
        <div class="col">
            <input type="text" name="beneficiary_birth_date" class="form-control" placeholder="Data de Nasc.">
        </div>
        <div class="col">
            <input type="text" name="beneficiary_height" class="form-control" placeholder="Altura">
        </div>
        <div class="col">
            <input type="text" name="beneficiary_weight" class="form-control" placeholder="Peso">
        </div>
        <div class="col">        
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="beneficiary_gender">
                <option value="">Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </div>
        <div class="col">
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="checkbox" id="financier" value="1">
                <label class="form-check-label" for="financier">Financiador</label>
            </div>
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
</div>


<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar Processo</button>
    </div>
</div>

<input type="hidden" id="toDelete" value="" />

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
