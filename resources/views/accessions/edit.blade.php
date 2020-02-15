@extends('layouts.app')

@section('content')    

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('accessions', $accession) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('accessions.update', ['accession' => $accession->id])  }}">
                @csrf
                @method('PUT')

                @include('accessions._form')

            </form>
        </div>
    </div>

@endsection
