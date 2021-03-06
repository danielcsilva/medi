<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Nome do usuário" value="{{ old('name', $user->name ?? null) }}">
        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>    
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $user->email ?? null) }}">
        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>    
</div>

@role('Cliente') 
    @if (Auth::user()->powerbi_url != '')
        Para acessar seu dashboard utilize o link: <a href="/home" target="_blank">Dashboard</a>
    @endif
@else
    <div class="form-row mb-4 mt-4">
        <div class="col-4">
            <input type="text" name="powerbi_url" class="form-control  @error('powerbi_url') is-invalid @enderror" placeholder="Power BI link" value="{{ old('powerbi_url', $user->powerbi_url ?? null) }}">
            @error('powerbi_url')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
            </span>
            @enderror
            </div>    
    </div>
@endrole

<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Senha" value="">
        @error('password')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>    
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-4">
       
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme a Senha" autocomplete="new-password">
    
        @error('password')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
</div>

<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <input type="CRM_COREN" name="CRM_COREN" class="form-control  @error('CRM_COREN') is-invalid @enderror" placeholder="CRM ou COREN (opcional)" value="{{ old('name', $user->CRM_COREN ?? null) }}">
        @error('CRM_COREN')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>    
</div>

@can('Editar Grupo de Usuários')
<div class="form-row mb-4 mt-4">
    <div class="col-4">
        <label for="">Cliente</label>
        <select class="form-control" name="company_id">
            @if ($companies)
                <option value=""></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $company->id ?? null) == (isset($user->company->id) ? $user->company->id : null) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
@endcan

<div class="form-row mb-4 mt-4">
    <div class="col-4">

        @if (isset($user) && Auth::user()->id == $user->id)
            @role('SuperAdmin')
                <div class="alert alert-info">Você é um Super Admin. Qualquer mudança de grupo não afetará seu usuário.</div> 
            @endrole
        @endif 

        @can('Editar Grupo de Usuários')
        
            <label>Grupos</label>
            <select class="form-control" multiple name="roles[]" style="height: 200px;">
                @if ($roles)
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ ( isset($user) && in_array($role->id, $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                @endif
            </select>

            <span>Escolha mais de um grupo segurando a telca CTRL</span>
        @else

            <div class="alert alert-info">{{  (count($user->roles->pluck('name')->toArray()) > 0 ? "Você pertence ao(s) grupo(s): " . implode(",",  $user->roles->pluck('name')->toArray()) . "." : '') }} Você não tem permissão para modificar o grupo do seu usuário.</div>
        
        @endcan

        @if($errors->has('beneficiary_gender.0'))
            <div class="alert alert-danger small">{{ $errors->first('beneficiary_gender.0') }}</div>
        @endif

    </div>
</div>

<div class="form-row mb-4 mt-4">
    <div class="col">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>