@extends('layouts.app')

@section('content')

<h2>Beneficiários</h2>

<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
      </tr>
    </thead>
    <tbody>
        @foreach($beneficiaries as $beneficiary)
        <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $beneficiaries->links() }}

@endsection