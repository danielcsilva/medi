<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="type_of_process" class="form-control  @error('type_of_process') is-invalid @enderror" placeholder="Tipo de Movimentação" value="{{ old('type_of_process', $processtype->type_of_process ?? null) }}">
        @error('type_of_process')
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