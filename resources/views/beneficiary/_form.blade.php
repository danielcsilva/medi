<div class="form-row mb-4 mt-4">
    <div class="col">
        <input type="text" name="name" class="form-control" placeholder="Nome">
    </div>
    <div class="col">
        <input type="text" name="email" class="form-control" placeholder="Email">
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <input type="text" name="birth_date" class="form-control" placeholder="Data de Nascimento">
    </div>
    <div class="col">
        <input type="text" name="height" class="form-control" placeholder="Altura">
    </div>
    <div class="col">
        <input type="text" name="weight" class="form-control" placeholder="Peso">
    </div>
</div>

<div class="form-row">
    <div class="col-md-3">

        <div class="form-group" id="telephone-repeater">
            <button class="btn btn-info float-right mb-2" type="button" id="addTelephone">Adicionar</button>
            <label for="telephone">Telefones</label>
            <div class="input-group repeat-telephone mb-2 mt-2">
                <input type="text" class="form-control"
                       name="telephone[]" aria-describedby="telephonelHelp"
                       placeholder="(XX) xxxx-xxxx">
                <div class="input-group-append">
                    <span class="input-group-text remove-telephone" style="display:none;"><img src="/images/delete.png" alt=""></span>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
</div>
<button type="submit" class="btn btn-primary">Submit</button>

@section('jscontent')

    <script src="{{ mix('js/beneficiary.js') }}"></script>

@endsection
