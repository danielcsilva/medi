<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Data Nasc.</th>
          </tr>
        </thead>
        <tbody>
            @foreach($beneficiaries as $beneficiary)
            <tr>
                <th scope="row">{{ $beneficiary->id }}</th>
                <td>{{ $beneficiary->name }}</td>
                <td>{{ $beneficiary->email }}</td>
                <td>{{ date('d-m-Y', strtotime($beneficiary->birth_date)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $beneficiaries->links() }}
        </div>
    </div>
</div>
