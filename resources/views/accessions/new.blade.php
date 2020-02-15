@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('accessions') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('accessions.store')  }}">
                @csrf

                @include('accessions._form')

            </form>
        </div>
    </div>

@endsection
