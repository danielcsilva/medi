@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('statusprocess') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('statusprocess.store')  }}">
                @csrf

                @include('process_status._form')

            </form>
        </div>
    </div>

@endsection
