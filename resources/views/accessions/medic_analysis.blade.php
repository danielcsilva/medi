@extends('layouts.app')

@section('content')

    @can('Avaliar Processos Clinicamente')
        
        @include('partials.accession', ['breadcrumbs' => 'accessions-medic-analysis'])


        <div class="row mb-4" style="margin-top:60px;">
            <div class="col-6"><h4>Classificação Médica</h4></div>
        </div>

        <div class="row mb-4 mt-4">
            
            <div class="col">
                <label for="">Grau de Risco</label>
                <select class="form-control" name="risk_grade_id">
                    @if ($riskgrades)
                        <option value=""></option>
                        @foreach($riskgrades as $risk)
                            <option value="{{ $risk->id }}" {{ old('risk_grade_id', $risk->id ?? null) === (isset($accession) && $accession->risk_grade_id) ? 'selected' : '' }}>{{ $risk->risk }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        
            <div class="col">
                <label for="">Sugestão de Tratamento</label>
                <select class="form-control" name="suggestion_id">
                    @if ($suggestions)
                        <option value=""></option>
                        @foreach($suggestions as $suggestion)
                            <option value="{{ $suggestion->id }}" {{ old('suggestion_id', $suggestion->id ?? null) === (isset($accession) && $accession->suggestion_id) ? 'selected' : '' }}>{{ $suggestion->suggestion }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

        </div>
    @endcan

@endsection