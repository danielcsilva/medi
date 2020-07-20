@extends('layouts.app')

@section('content')

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
                    <h2>Sistema de Gerenciamento em Saúde</h2>

                    @role('Cliente')
                        <p>
                            @if ($powerbi_url != '')
                                @iframe(['src_url' => $powerbi_url, 'width' => 1380, 'height' => 900])
                                @endiframe
                            @endif
                        </p>
                    @endrole
                </div>
            </div>
        </div>

    </div>

@endsection
