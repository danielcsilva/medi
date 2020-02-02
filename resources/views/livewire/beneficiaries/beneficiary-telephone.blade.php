<div class="telephone">
    @for($i = 1; $i >= $telephonesInput; $i++)
        <div class="form-group">
            <button class="btn btn-info float-right mb-2" type="button" wire:click.prevent="addTelephone">Adicionar</button>
            <label for="telephone">Telefones</label>
            <input type="text" class="form-control" id="telephone" name="telephone[]" aria-describedby="telephonelHelp" placeholder="(XX) xxxx-xxxx">
        </div>
    @endfor
</div>
