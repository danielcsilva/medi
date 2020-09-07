@extends('layouts.app')

@section('content')

    @can('Editar Entrevistas')

        @include('partials.accession', ['breadcrumbs' => 'accessions-interview'])
        
        <div class="alert alert-dark">Você está na etapa: Entrevista</div>
        <div class="alert alert-primary">Lembrete: Não é possível editar o Processo nesta etapa.</div>

        @if (count($interviews) > 0) 
        <div class="row mb-4" style="margin-top:60px;">
            <div class="col-6"><h4>Entrevistas Anteriores</h4></div>
        </div>
        @endif

        @foreach($interviews as $interview)
        <div class="row mb-4 mt-4">
            <div class="col-3">
                <label for="">Nome do Entrevistado</label>
                <input type="text" disabled class="form-control" name="interviewed_name" value="{{ $interview->interviewed_name ?? null }}">
                <label for="" class="mt-2">Data da Entrevista</label>
                <input type="text" disabled class="form-control date-br" name="interview_date" value="{{ $interview->interview_date }}">
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
            <div class="col-6"><h4>Nova Entrevista</h4></div>
        </div>

        <form id="interview-form" method="post" action="{{ route('interview.update', ['interview' => $accession->id])  }}">
            @csrf
            @method('PUT')

        <div class="row mb-4 mt-4">
            <div class="col-3">
                <label for="">Nome do Entrevistado</label>
                <input type="text" class="form-control" name="interviewed_name" value="{{ old('interviewed_name') }}">
                <label for="" class="mt-2">Data da Entrevista</label>
                <input type="text" class="form-control date-br" name="interview_date" value="{{ old('interview_date') }}">
                <label for="" class="mt-2">Entrevistado por</label>
                <input type="text" disabled class="form-control" name="interviewed_by" value="{{ Auth::user()->name }}">
            </div>
            <div class="col-3">
                <label>Informar inconsistência(s)</label>
                <select class="form-control" multiple name="inconsistencies[]" style="height: 200px;">
                    @if ($inconsistencies)
                        @foreach($inconsistencies as $inconsistency)
                            <option value="{{ $inconsistency->id }}" >{{ $inconsistency->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col">
                <label for="">Comentários da Entrevista</label>
                <textarea name="interview_comments" class="form-control" id="" cols="30" rows="8">{{ old('interview_comments') }}</textarea>
            </div>
        </div>

        {{-- <div class="row mb-4 mt-4">
            <div class="col">
                <label for="">Entrevista validada </label>
                <input type="checkbox" name="interview_validated" class="" {{ old('interview_validated', $interview->interview_validated ?? 0) !== 0 ? 'checked' : ''}} value="1">
            </div>
        </div> --}}

        <div class="row mb-4 mt-4">
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Salvar Nova Entrevista</button>
            </div>
            @if (count($interviews) > 0) 
            <div class="col-3">
                <a class="btn {{ (isset($accession->to_medic_analysis) && $accession->to_medic_analysis == "1" ? 'btn-outline-secondary' : 'btn-success') }}" id="ok-analysis">{{ (isset($accession->to_medic_analysis) && $accession->to_medic_analysis == "1" ? 'Bloquear para Análise Médica' : 'Liberar para Análise Médica') }}</a>
            </div>
            <div class="col">
                <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" type="hidden" id="to-medic-analysis" name="to_medic_analysis" value="">
                </div>
            </div>
            @endif
        </div>

        </form>
    

        <script defer>
        
            document.addEventListener("DOMContentLoaded", function(event) {
                
                var $ = window.$;
            
                $('#ok-analysis').click(function(e){
    
                    e.preventDefault()
    
                    if(confirm('Deseja realmente liberar o Processo para Análise Médica?')) {
                        
                        let to_medic_analysis = $('#to-medic-analysis').val();
                        
                        $('#to-medic-analysis').val(parseInt(to_medic_analysis) === 0 ? 1 : 0);
        
                        $('form').submit();
    
                    }
    
                }) 
    
            })
    
        </script>

    @endcan

@endsection