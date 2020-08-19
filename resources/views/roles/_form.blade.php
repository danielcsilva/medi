<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Nome do Grupo" value="{{ old('name', $role->name ?? null) }}">
        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
</div>

<label>Grupos</label>
<select class="form-control" multiple name="permissions[]" style="height: 400px;">
    @if ($permissions)
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}" {{ in_array($permission->id, (isset($role) ? $role->permissions->pluck('id')->toArray() : [])  ) ? 'selected' : '' }}>{{ $permission->name }}</option>
            @endforeach
    @endif
</select>

<span>Escolha mais de um grupo segurando a telca CTRL ou SHIFT</span>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>