<div class="row mb-4" style="margin-top:60px;">
    <div class="col-6"><h4>Dados sobre o Contato</h4></div>
</div>

<div class="row mb-4 mt-4">
    <div class="col-3">
        <label for="">Data do Contato</label>
        <input type="text" class="form-control date-br" name="contacted_date" value="{{ old('contacted_date', $accession->contacted_date ?? null) }}">
    </div>
    <div class="col-4">
        <label>Informar inconsistência(s)</label>
        <select class="form-control" multiple name="inconsistencies[]" style="height: 200px;">
            @if ($inconsistencies)
                    @foreach($inconsistencies as $inconsistency)
                        <option value="{{ $inconsistency->id }}" {{ ( isset($accession->inconsistencies) && in_array($inconsistency->id, $accession->inconsistencies->pluck('id')->toArray()) ? 'selected' : '' ) }}>{{ $inconsistency->name }}</option>
                    @endforeach
            @endif
        </select>
    </div>
    <div class="col">
        <label for="health-declaration-comments">Comentários do Contato</label>
        <textarea name="contacted_comments" class="form-control" id="" cols="30" rows="8">{{ old('contacted_comments', $accession->contacted_comments ?? null) }}</textarea>
    </div>
</div>