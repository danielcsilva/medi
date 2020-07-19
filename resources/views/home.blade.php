@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-header">Adesões</div>

                <div class="card-body">                                        
                    {!! $chart->container() !!}
                    {!! $chart->script() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Entrevistas</div>

                <div class="card-body">                                        
                    {!! $chart2->container() !!}
                    {!! $chart2->script() !!}
                </div>
            </div>
        </div> --}}

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bem-vindo, {{ Auth::user()->name }}!</div>

                <div class="card-body">                    
                    <h2>Sistem de Gerenciamento em Saúde</h2>

                    @role('Cliente')
                        <p>
                        @if (Auth::user()->powerbi_url != '')
                            <a class="btn btn-primary" href="{{ Auth::user()->powerbi_url }}" target="_blank">Acessar Dashboard</a>
                        @endif
                        </p>
                    @endrole
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
