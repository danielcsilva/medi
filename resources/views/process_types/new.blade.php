@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('processtypes') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('processtypes.store')  }}">
                @csrf

                @include('process_types._form')

            </form>
        </div>
    </div>

@endsection
