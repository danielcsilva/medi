<div>

    <input type="text" wire:model="search" placeholder="pesquisar" class="form-control mb-2 mt-2">
    <div style="float: right;padding: 4px;">
        {{-- {{ dd($selectedItems) }} --}}
        @if(!empty($selectedItems))
            @foreach($actions as $action)
                <a class="btn btn-primary btn-sm" href="{{ $action['route'] }}" style="margin-right: 30px;">{{ $action['name'] }}</a>
            @endforeach
        @endif
        <span>Total de processos: {{ $process_count }}</span> 
    </div>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            
            @foreach($labels as $label)
                <th>{{ $label }}
                    @foreach($filterField as $fFilter) 
                        @if ($fFilter['label'] == $label)
                            <br />
                            <select class="selectFilter">
                                <option>Filtro</option>
                                @foreach($fFilter['itens'] as $item)
                                    <option value="{{ $fFilter['field'] }}.{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    @endforeach
                </th>
            @endforeach

            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr wire:key="{{ $row->id }}">
                @if(key($rows) == 0 && $edit)                    
                    <th scope="row">
                        @if ($selectAble)
                            <input type="checkbox" name="item_{{ $row->id }}" class="selectItem"
                             {{ in_array($row->id, $this->selectedItems ?? []) ? 'checked="checked"' : '' }} 
                             value="{{ $row->id }}">
                        @endif
                        {{ $row->id }}<a href="{{ route( $editRoute, [$routeParam => $row->id]) }}"><i class="material-icons">edit</i></a>
                    </th>
                @endif

                @foreach($columns as $col)
                    @if(strpos($col, '.') !== false && is_array(explode('.', $col)))
                        <td class="@if(in_array($col, $booleans)) boolean-value @endif">{{ $row[explode('.', $col)[0]][explode('.', $col)[1]] }}</td>
                    @else 
                        <td class="@if(in_array($col, $booleans)) boolean-value @endif">{{ $row[$col] ?? '' }}</td>
                    @endif
                @endforeach

                <td>
                    @if ($delete)
                    <a href="#" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteRoute('{{ route( $deleteRoute . '.destroy', [$routeParam => $row->id]) }}')"><i class="material-icons">delete_forever</i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col">
            {{ $rows->links() }}
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
    
    @push('scripts')
        <script>
    
        document.addEventListener("DOMContentLoaded", function(event) {

            $('.selectFilter').on('change', (e) => {
                window.livewire.emit('filterSelected', e.target.value)
            })

            $('.selectItem').on('click', (e) => {
                if ($(e.target).prop('checked')) {
                    window.livewire.emit('selectItem', $(e.target).val())
                } else {
                    window.livewire.emit('removeItem', $(e.target).val())
                }
            })

        })

        function setDeleteRoute(route)
        {
            document.getElementById('delete-form').action = route;
        }
    
        function submitDeleteForm()
        {
            document.getElementById('delete-form').submit();
        }
    
        window.livewire.on('rewriteTable', param => {
            
            var elems = document.getElementsByClassName('boolean-value');
            for(i in elems) {
                if (elems[i].innerHTML == '0') {
                    elems[i].innerHTML = 'Não';
                } else if(elems[i].innerHTML == '1') {
                    elems[i].innerHTML = 'Sim';
                }
            }
        })


        window.livewire.emit('rewriteTable', 'rewrite');
    
        </script>
    @endpush


</div>