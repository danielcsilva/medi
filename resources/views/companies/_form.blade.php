
<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="name" class="form-control" placeholder="Nome da Empresa" value="{{ old('name', $company->name ?? null) }}">
        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
    <div class="col-2">
        <input type="text" name="cnpj" class="form-control cnpj" placeholder="CNPJ" value="{{ old('cnpj', $company->cnpj ?? null) }}">
        
        @error('cnpj')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-3">
        <input type="text" name="telephone" class="form-control telefone" placeholder="Telefone" value="{{ old('telephone', $company->telephone ?? null) }}">
        @error('telephone')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
    <div class="col-3">
        <input type="text" name="contract" class="form-control" placeholder="Contrato" value="{{ old('contract', $company->contract ?? null) }}">
        
        @error('contract')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-6">
        <input type="email" name="email" class="form-control email" placeholder="Email" value="{{ old('email', $company->email ?? null) }}">
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>

@section('jscontent')

    <script src="{{ mix('js/company.js') }}"></script>

@endsection