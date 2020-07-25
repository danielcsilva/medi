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

                    @role('Cliente|SuperAdmin')

                        <div class="mb-4">

                            @foreach($powerbi_urls as $url)
                                @if ($url['type'] === 'user')
                                    <a href="/home" class="btn btn-secondary">Início</a>
                                @endif
                                @if ($url['type'] === 'company')
                                    <a href="/dashboard/bi/{{ $url['id'] }}" class="btn btn-secondary">{{ $url['label'] }}</a>
                                @endif    
                            @endforeach

                        </div>

                        <p>
                            @if ($powerbi_url_iframe)
                                @iframe(['src_url' => $powerbi_url_iframe, 'width' => 1380, 'height' => 900])
                                @endiframe
                            @endif
                        </p>

                    @endrole
                </div>
            </div>
        </div>

    </div>

@endsection
