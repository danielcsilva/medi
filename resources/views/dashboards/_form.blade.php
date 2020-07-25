
<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="label" class="form-control  @error('label') is-invalid @enderror" placeholder="Título do Dashboard" value="{{ old('label', $dashboard->label ?? null) }}">
        @error('label')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
    <div class="col-8">
        <input type="text" name="dashboard_link" class="form-control @error('dashboard_link') is-invalid @enderror" placeholder="Link do dashboard" value="{{ old('dashboard_link', $dashboard->dashboard_link ?? null) }}">
        
        @error('dashboard_link')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="row mb-4 mt-4 col-6">
    <label for="">Cliente</label>
    <select class="form-control" name="company_id">
        @if ($companies)
        <option value=""></option>
        @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ old('company_id', $company->id ?? null) == (isset($dashboard) && $dashboard->company_id) ? 'selected' : '' }}>{{ $company->name }}</option>
            @endforeach
        @endif
    </select>
</div>


<div class="row mb-4 mt-4">
    <div class="col">
        <label for="">Ativo</label>
        <input type="checkbox" name="active" class="" {{ old('active', $dashboard->active ?? 0) !== 0 ? 'checked' : ''}} value="1">
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>
