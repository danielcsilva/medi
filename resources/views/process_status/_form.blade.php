<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="status" class="form-control  @error('status') is-invalid @enderror" placeholder="Status do Processo" value="{{ old('status', $statusprocess->status ?? null) }}">
        @error('status')
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