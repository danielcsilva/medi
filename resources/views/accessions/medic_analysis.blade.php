@extends('layouts.app')

@section('content')

    @can('Avaliar Processos Clinicamente')
        
        @include('partials.accession', ['breadcrumbs' => 'accessions-medic-analysis'])

        <div class="row mb-4" style="margin-top:60px;">
            <div class="col-6"><h4>Entrevistas</h4></div>
        </div>

        @foreach($interviews as $interview)

        <div class="row mb-4 mt-4">
            <div class="col-3">
                <label for="">Nome do Entrevistado</label>
                <input type="text" disabled class="form-control" name="interviewed_name" value="{{ $interview->interviewed_name ?? null }}">
                <label for="" class="mt-2">Data da Entrevista</label>
                <input type="text" disabled class="form-control date-br" name="interview_date" value="{{ $interview->interview_date ?? null }}">
                <label for="" class="mt-2">Entrevistado por</label>
                <input type="text" disabled class="form-control" name="interviewed_by" value="{{ $interview->interviewed_by ?? null }}">
            </div>
            <div class="col-3">
                <label>Informar inconsistência(s)</label>
                <select disabled class="form-control" multiple name="inconsistencies[]" style="height: 200px;">
                    @if ($inconsistencies)
                        @foreach($inconsistencies as $inconsistency)
                            <option value="{{ $inconsistency->id }}" {{ ( isset($interview->inconsistencies) && in_array($inconsistency->id, $interview->inconsistencies->pluck('id')->toArray()) ? 'selected' : '' ) }}>{{ $inconsistency->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col">
                <label for="">Comentários da Entrevista</label>
                <textarea disabled name="interview_comments" class="form-control" id="" cols="30" rows="8">{{ $interview->interview_comments ?? null }}</textarea>
            </div>
        </div>

        {{-- <div class="row mb-4 mt-4">
            <div class="col">
                <label for="">Entrevista validada </label>
                <input type="checkbox" disabled name="interview_validated" class="" {{ old('interview_validated', $interview->interview_validated ?? 0) !== 0 ? 'checked' : ''}} value="1">
            </div>
        </div> --}}
        @endforeach

        <div class="row mb-4" style="margin-top:60px;">
            <div class="col-6"><h4>Classificação Médica</h4></div>
        </div>

        <form id="medic-analysis-form" method="post" action="{{ url('/medicanalysis/setanalysis', ['accession' => $accession->id])  }}">
            @csrf
            @method('PUT')

            <div class="row mb-4 mt-4">

                @foreach($beneficiaries as $k => $beneficiary)

                    <div class="col-4">
                        <label for="">Beneficiário</label>
                        <input type="text" class="form-control" name="analysis_beneficiary_name[]" value="{{ old('analysis_beneficiary_name.' . $k, $beneficiary->name ?? null) }}" />
                        <input type="hidden" name="analysis_beneficiary_id[]" value="{{ old('analysis_beneficiary_id.' . $k, $beneficiary->id ?? null) }}" />
                        
                        <label for="" class="mt-4">Grau de Risco</label>
                        <select class="form-control" name="analysis_risk_grade_id[]" required>
                            @if ($riskgrades)
                                <option value=""></option>
                                @foreach($riskgrades as $risk)
                                    <option value="{{ $risk->id }}" {{ old('analysis_risk_grade_id.' . $k, $risk->id ?? null) == (isset($analysis[$k]->risk_grade_id) ? $analysis[$k]->risk_grade_id : '' ) ? 'selected' : '' }}>{{ $risk->risk }}</option>
                                @endforeach
                            @endif
                        </select>
                    
                        <label for="" class="mt-4">Sugestão de Ação</label>
                        <select class="form-control" name="suggestion_id[]" required>
                            @if ($suggestions)
                                <option value=""></option>
                                @foreach($suggestions as $suggestion)
                                    <option value="{{ $suggestion->id }}" {{ old('suggestion_id', $suggestion->id ?? null) == (isset($analysis[$k]->suggestion_id) ? $analysis[$k]->suggestion_id : '') ? 'selected' : '' }}>{{ $suggestion->suggestion }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col">
                        <label for="">Justificativa</label>
                        <textarea name="justification[]" id="" cols="30" rows="10" class="form-control" required>{{ old('justification.' . $k, $analysis[$k]->justification ?? null) }}</textarea>
                    </div>

                @endforeach

            </div>

            <div class="row mb-4 mt-4">
                <div class="col-3">
                    <a class="btn btn-primary" id="save-medic-analysis">Salvar Avaliação Médica</a>
                    <p><small>Salvando a Avaliação Médica o Processo fica bloqueado para alteração.</small></p>
                </div>  
            </div>

        </form>

        <script defer>
        
            document.addEventListener("DOMContentLoaded", function(event) {
                
                var $ = window.$;

            
                $('#save-medic-analysis').click(function(e){
    
                    e.preventDefault()

                    if(confirm('Deseja realmente salvar a Avaliação Médica?')) {
        
                        $('form').submit();
    
                    }
    
                }) 
    
            })
    
        </script>


    @endcan

@endsection