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

    @if(isset($selectedQuestions))
    <ul class="ml-0">
        @foreach($selectedQuestions as $selected)
            <li wire:key="selected_{{ $selected['id'] }}">{{ $selected['question'] }} <a href="#" wire:click.prevent="removeSelected({{ $selected['id'] }})">
                <i class="material-icons" style="font-size:16px;color:red;">remove_circle_outline</i></a></li>
        @endforeach
    </ul>
    @endif

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2 @error('selectedItems') is-invalid @enderror">
    
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
                    <a href="#" wire:click="selectItem({{ $row->id }})">                
                    <i class="material-icons" @if(in_array($row->id, $selectedItems)) style="color:green;" @endif>check_circle</i></a>
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
                <button type="button" class="btn btn-primary">Sim</button>
            </div>
            </div>
        </div>
    </div>

</div>
