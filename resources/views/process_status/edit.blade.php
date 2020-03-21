@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('statusprocess', $risk) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('statusprocess.update', ['statusprocess' => $risk->id])  }}">
                @csrf
                @method('PUT')

                @include('process_status._form')

            </form>
        </div>
    </div>

@endsection
