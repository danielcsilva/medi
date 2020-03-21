@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('riskgrades', $risk) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('riskgrades.update', ['riskgrade' => $risk->id])  }}">
                @csrf
                @method('PUT')

                @include('riskgrades._form')

            </form>
        </div>
    </div>

@endsection
