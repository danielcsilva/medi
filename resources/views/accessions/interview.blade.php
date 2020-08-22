@can('Editar Entrevistas')

    <div class="row mb-4" style="margin-top:60px;">
        <div class="col-6"><h4>Dados da Entrevista</h4></div>
    </div>


    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Nome do Entrevistado</label>
            <input type="text" class="form-control" name="interviewed_name" value="{{ old('interviewed_name', $accession->interviewed_name ?? null) }}">
        </div>
        <div class="col">
            <label for="">Data da Entrevista</label>
            <input type="text" class="form-control date-br" name="interview_date" value="{{ old('interview_date', $accession->interview_date ?? null) }}">
        </div>
        <div class="col">
            <label for="">Entrevistado por</label>
            <input type="text" class="form-control" name="interviewed_by" value="{{ old('interviewed_by', $accession->interviewed_by ?? null) }}">
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Comentários da Entrevista</label>
            <textarea name="interview_comments" class="form-control" id="" cols="30" rows="8">{{ old('interview_comments', $accession->interview_comments ?? null) }}</textarea>
        </div>
    </div>

    <div class="row mb-4 mt-4">
        <div class="col">
            <label for="">Entrevista validada </label>
            <input type="checkbox" name="interview_validated" class="" {{ old('interview_validated', $accession->interview_validated ?? 0) !== 0 ? 'checked' : ''}} value="1">
        </div>
    </div>

@endcan