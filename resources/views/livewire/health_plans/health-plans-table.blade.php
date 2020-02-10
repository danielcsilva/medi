<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
          </tr>
        </thead>
        <tbody>
            @foreach($health_plans as $health_plan)
            <tr>
                <th scope="row"><a href="{{ route('health_plans.edit', ['health_plan' => $health_plan->id]) }}">
                    <input type="hidden" value="{{ $health_plan->id }}" id="{{ $health_plan->id }}"> <i class="material-icons">edit</i></a>
                </th>
                <td>{{ $health_plan->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $health_plans->links() }}
        </div>
    </div>
</div>
