<div class="form-row mb-4 mt-4">
    <div class="col">
        <input type="text" name="question" class="form-control  @error('question') is-invalid @enderror" placeholder="Escreva a Pergunta" value="{{ old('name', $healthquestion->question ?? null) }}">
        @error('question')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
</div>

<div class="form-row mb-2 mt-4">
    <div class="col-6">
        <label for="description">Descrição da Pergunta</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10">
            {{ old('description', $healthquestion->description ?? null) }}
        </textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
</div>

<div class="form-row mb-2 mt-2">
    <div class="col-4">
        <div class="form-check form-check-inline mt-2">
            <input type="hidden" name="required" value="0" />
            <input class="form-check-input @error('required') is-invalid @enderror" name="required" @if(isset($healthquestion) && $healthquestion->required) checked @endif type="checkbox" id="required" value="1">
            <label class="form-check-label" for="required">Obrigatória?</label>
            @error('required')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>    
    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>