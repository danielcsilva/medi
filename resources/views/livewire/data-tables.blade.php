<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            
            @foreach($labels as $label)
                <th>{{ $label }}</th>
            @endforeach

            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr wire:key="{{ $row->id }}">
                @if(key($rows) == 0)                    
                    <th scope="row"><a href="{{ route( $editRoute . '.edit', [$modelEditParam => $row->id]) }}"><i class="material-icons">edit</i></a></th>
                @endif
                @foreach($columns as $col)
                    <td>{{ $row->$col }}</td>
                @endforeach

                <td><a href="#" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteRoute('{{ route( $editRoute . '.destroy', [$modelEditParam => $row->id]) }}')"><i class="material-icons">delete_forever</i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $rows->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Deseja realmente excluir o registro?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="submitDeleteForm()">Sim</button>
        </div>
        </div>
    </div>
</div>

<form action="" method="post" id="delete-form">
    @csrf
    @method('DELETE')

</form>

<script>

function setDeleteRoute(route)
{
    document.getElementById('delete-form').action = route;
}

function submitDeleteForm()
{
    document.getElementById('delete-form').submit();
}


</script>