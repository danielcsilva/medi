<div>

    <h4>CIDs</h4>

    <div class="row">
        <div class="col-6">
            <input type="text" class="form-control" value="" id="cid" list="cids" wire:model="cidSelected" wire:keyup="searchCid($event.target.value)">
            <datalist id="cids">
                @foreach($allCids as $cid)
                    <option value="{{ $cid->cid }} - {{ $cid->description }}">
                @endforeach 
            </datalist>
        </div>
        <div class="col">
            <a class="btn btn-secondary" wire:click.prevent="addCid">Adicionar CID</a>            
        </div>
    </div>

    @if ($cids)
        <p class="mt-4">Relatados até agora:</p>
    @endif
    
    @if ($message)
        <div class="alert alert-success" id="cids-message">
            {{ $message }}
        </div>
    @endif

    @foreach($cids as $selectedCid)
        <div class="form-row">
            <div class="col-7">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inlineFormInputGroup" name="cids[]" value="{{ $selectedCid }}" wire:key="{{ $loop->index }}">
                    <div class="input-group-apend">
                        <a class="btn btn-warning" wire:click.prevent="removeCid({{ $loop->index }})">X</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
    <a class="btn btn-secondary" wire:click.prevent="saveCids">Salvar apenas CIDs relatados</a>  

</div>

@push('scripts')
    <script>

        window.livewire.on('savedCids', () => {
            setTimeout(() => {
                $('#cids-message').slideUp('slow')
            }, 3000)
        })

    </script>
@endpush