<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Nome da inconsistência" value="{{ old('name', $inconsistency->name ?? null) }}">
        @error('name')
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