<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="risk" class="form-control  @error('risk') is-invalid @enderror" placeholder="Grau de Risco" value="{{ old('risk', $risk->risk ?? null) }}">
        @error('risk')
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