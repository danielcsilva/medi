<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Contrato</th>
            <th scope="col">CNPJ</th>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>

          </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <th scope="row"><a href="{{ route('companies.edit', ['company' => $company->id]) }}">
                    <input type="hidden" value="{{ $company->id }}" id="{{ $company->id }}"> <i class="material-icons">edit</i></a>
                </th>
                <td>{{ $company->name }}</td>
                <td>{{ $company->contract }}</td>
                <td>{{ $company->cnpj }}</td>
                <td>{{ $company->telephone }}</td>
                <td>{{ $company->email }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $companies->links() }}
        </div>
    </div>
</div>
