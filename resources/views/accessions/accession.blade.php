@extends('layouts.app')

@section('content')

    @include('partials.accession')

@endsection

@section('jscontent')

    <script src="{{ mix('js/accession.js') }}"></script>

@endsection
