<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="suggestion" class="form-control  @error('suggestion') is-invalid @enderror" placeholder="Sugestão" value="{{ old('suggestion', $suggestion->suggestion ?? null) }}">
        @error('suggestion')
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