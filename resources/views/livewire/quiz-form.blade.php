<div>
    <div class="form-row mb-4 mt-4">
        <div class="col-4">
            <input type="text" wire:model.lazy="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Nome da DS" value="{{ old('name', $quiz->name ?? null) }}">
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            </div>    
    </div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2 @error('selectedItems') is-invalid @enderror">
    <input type="hidden" wire:model.lazy="selectedItems" value="@json($selectedItems)">
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
                <th scope="row">                    
                    <a href="#" wire:click.prevent="selectItem({{ $row->id }})">                
                    <i class="material-icons" 
                    @if(in_array($row->id, $selectedItems))    
                        style="color:green;"
                    @endif
                    >check_circle</i></a>
                </th>
                @endif

                @foreach($columns as $col)
                    @if(strpos($col, '.') !== false)
                        <td>{{ $row[explode('.', $col)[0]][explode('.', $col)[1]] }}</td>
                    @else 
                        <td>{{ $row[$col] }}</td>
                    @endif
                @endforeach                
            </tr>
            @endforeach
        </tbody>
    </table>

    @error('selectedItems')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="row">
        <div class="col">
            {{ $rows->links() }}
        </div>
    </div>

    <div class="form-row mb-4 mt-4">
        <div class="col">
            <button type="button" wire:click.prevent="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>

</div>