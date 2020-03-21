@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('processtypes', $processtype) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('processtypes.update', ['processtype' => $processtype->id])  }}">
                @csrf
                @method('PUT')

                @include('process_types._form')

            </form>
        </div>
    </div>

@endsection
