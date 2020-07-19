@extends('layouts.app')

@section('content')

    @iframe(['src_url' => $powerbi_url])
    @endiframe
    
@endsection