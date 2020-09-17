<div>

    <h4>CIDs</h4>

    <div class="row">
        <div class="col-2">
            <input type="text" class="form-control" value="" name="cid[]" wire:keyup="completeCid($event.target.value)">
            {{ $searchResults }}
        </div>
        <div class="col-4">
            <input type="text" class="form-control" value="" readonly> 
        </div>
        <div class="col">
            <a class="btn btn-secondary" wire:click.prevent="addCid">Adicionar CID</a>            
        </div>
    </div>

    @foreach($cids as $cid)
        <div class="row">
            <div class="col-2">
                <input type="text" class="form-control" value="{{ $cid->cid ?? null}}" name="cid[]"> 
            </div>
            <div class="col-4">
                <input type="text" class="form-control" value="{{ $cid->description ?? null }}" readonly> 
            </div>
        </div>
    @endforeach

</div>
