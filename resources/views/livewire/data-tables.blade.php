<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">

    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            
            @foreach($labels as $label)
                <th>{{ $label }}</th>
            @endforeach

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

