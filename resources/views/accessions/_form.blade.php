<div class="form-row mb-4 mt-4 repeater-colaborator">
    <div class="col-4">
        <input type="text" name="beneficiary_name" class="form-control" placeholder="Nome do beneficiário titular"  @error('beneficiary_name') is-invalid @enderror" value="">
    </div>
    <div class="col-3">
        <input type="text" name="beneficiary_email" class="form-control" placeholder="Email">
    </div>
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
</div>


<div class="form-row">
    <div class="col-md-3">

        <div class="form-group" id="telephone-repeater">            
            <label for="telephone">Telefones <a href="#" id="addTelephone">(+)</a></label>
            <div class="input-group repeat-telephone mb-2 mt-2">
                <input type="text" class="form-control"
                       name="beneficiary_telephone[]" aria-describedby="telephonelHelp"
                       placeholder="(XX) xxxx-xxxx">
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

@section('jscontent')

    <script src="{{ mix('js/accession.js') }}"></script>

@endsection
