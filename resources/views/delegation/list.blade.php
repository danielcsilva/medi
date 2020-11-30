@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">    
        {{-- {{ dd($breadcrumb) }} --}}
        {{ Breadcrumbs::render('delegation', $breadcrumb ?? 'list') }}                
    </div>
    <div class="col">
        <div class="row">
            <div class="col">

                <select name="users" id="" class="form-control">
                    <option value="">Escolha usuário</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button class="btn btn-primary" wire:click="$emitTo('data-tables', 'delegation')">Delegar</button>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', [
    'editRoute' => $editRoute, 
    'routeParam' => $routeParam, 
    'model' => $model, 
    'columns' => [
        'proposal_number', 
        'received_at', 
        'financier.name', 
        'company.name'
    ], 
    'labels' => [
        'Proposta', 
        'Recebida', 
        'Financiamento', 
        'Cliente'
    ],
    'filter' => $filter,
    'deleteRoute' => 'removeFromInItems',
    'options' => [
        'editable' => false
    ]
])

@endsection

<script>
    window.addEventListener('name-updated', event => {
        console.log('teste')
        alert('Name updated to: ' + event.detail.newName);
    })
</script>