@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
        </div>
    </div>
</div>
@endsection
