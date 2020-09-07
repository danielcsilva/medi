@extends('layouts.app')

@section('content')

    @can('Editar Contatos')
        
    @include('partials.accession', ['breadcrumbs' => 'accessions-contact'])

        <div class="alert alert-dark">Você está na etapa: Contato</div>
        <div class="alert alert-primary">Lembrete: Não é possível editar o Processo nesta etapa.</div>

        @if (count($contacts) > 0) 
        <div class="row mb-4" style="margin-top:60px;">
            <div class="col-6"><h4>Contatos Anteriores</h4></div>
        </div>
        @endif

        @foreach($contacts as $contact)
                       
            <div class="row mb-4 mt-4">
                <div class="col-3">
                    <label for="">Data do Contato</label>
                    <input type="text" class="form-control date-br" disabled name="contacted_date" value="{{ old('contacted_date', $contact->contacted_date ?? date('d.m.Y')) }}">
                    <label for="" style="margin-top:20px;">Usuário atual</label>
                    <input type="text" disabled class="form-control" name="user" value="{{ $contact->user->name }}">
                </div>
                <div class="col-4">
                    <label>Informar inconsistência(s)</label>
                    <select disabled class="form-control" multiple name="inconsistencies[]" style="height: 200px;">
                        @if ($inconsistencies)
                            @foreach($inconsistencies as $inconsistency)
                                <option value="{{ $inconsistency->id }}" {{ ( isset($contact->inconsistencies) && in_array($inconsistency->id, $contact->inconsistencies->pluck('id')->toArray()) ? 'selected' : '' ) }}>{{ $inconsistency->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col">
                    <label for="health-declaration-comments">Comentários do Contato</label>
                    <textarea name="contacted_comments" disabled class="form-control" id="" cols="30" rows="8">{{ old('contacted_comments', $contact->contacted_comments ?? null) }}</textarea>
                </div>
            </div>
                
        @endforeach

        <form id="contact-form" method="post" action="{{ route('tocontact.update', ['tocontact' => $accession->id])  }}">
            @csrf
            @method('PUT')

            <div class="row mb-4" style="margin-top:60px;">
                <div class="col-6"><h4>Novo Contato</h4></div>
            </div>
            
            <div class="row mb-4 mt-4">
                <div class="col-3">
                    <label for="">Data do Contato</label>
                    <input type="text" class="form-control date-br" name="contacted_date" value="{{ old('contacted_date', $accession->contacted_date ?? date('d.m.Y')) }}">
                    @if($errors->has('contacted_date'))
                        <div class="alert alert-danger small">{{ $errors->first('contacted_date') }}</div>
                    @endif
                    <label for="" style="margin-top:20px;">Usuário atual</label>
                    <input type="text" readonly class="form-control" name="user" value="{{ Auth::user()->name }}">
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
                    @if($errors->has('inconsistencies'))
                        <div class="alert alert-danger small">{{ $errors->first('inconsistencies') }}</div>
                    @endif
                </div>
                <div class="col">
                    <label for="health-declaration-comments">Comentários do Contato</label>
                    <textarea name="contacted_comments" class="form-control" id="" cols="30" rows="8" required>{{ old('contacted_comments', $accession->contacted_comments ?? null) }}</textarea>
                    @if($errors->has('contacted_comments'))
                        <div class="alert alert-danger small">{{ $errors->first('contacted_comments') }}</div>
                    @endif
                </div>
            </div>
        
        
            <div class="row mb-4 mt-4">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Salvar Novo Contato</button>
                </div>
                @if (count($contacts) > 0) 
                <div class="col-3">
                    <a class="btn {{ (isset($accession->to_interview) && $accession->to_interview == "1" ? 'btn-outline-secondary disabled' : 'btn-success') }}" id="ok-interview">{{ (isset($accession->to_interview) && $accession->to_interview == "1" ? 'Entrevista já liberada' : 'Liberar para Entrevista') }}</a>
                </div>
                <div class="col">
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="hidden" id="to-interview" name="to_interview" value="">
                    </div>
                </div>
                @endif
            </div>
            
        </form>

    @endcan

    <script defer>
        
        document.addEventListener("DOMContentLoaded", function(event) {
            
            var $ = window.$;
        
            $('#ok-interview').click(function(e){

                e.preventDefault()

                if(confirm('Deseja realmente liberar o Processo para Entrevista?')) {
                    
                    let to_interview = $('#to-interview').val();
                    
                    $('#to-interview').val(parseInt(to_interview) === 0 ? 1 : 0);
    
                    $('form').submit();

                }

            }) 

        })

    </script>

@endsection