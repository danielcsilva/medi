@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <div class="alert alert-danger" id="msg-alert" style="display: none;"></div>
    </div>
</div>

<div class="row">
    <div class="col">    
        {{-- {{ dd($breadcrumb) }} --}}
        {{ Breadcrumbs::render('delegation', $breadcrumb ?? 'list') }}                
    </div>
    @can('Delegar Processos')
    <div class="col">
        <div class="row">
            <div class="col">

                <select name="users" id="user-delegated" class="form-control">
                    <option value="">Escolha usuário</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col">

                @foreach($actions as $index => $action)
                    <div class="form-check">
                        <input type="checkbox" name="{{ $action }}" id="{{ $index }}" class="form-check-input actions">
                        <label class="form-check-label" for="{{ $action }}">{{ $action }}</label>
                    </div>
                @endforeach

            </div>

            <div class="col">
                <button class="btn btn-primary" type="button" id="delegar">Delegar</button>
            </div>
        </div>
    </div>
    @endcan
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

@section('jscontent')
    <script>

        document.addEventListener("DOMContentLoaded", function(event) {
            
            window.livewire.on('responseSelectedItems', (items) => {
                console.log(items)
            })

            $(document).on('click', '#delegar', () => {
                console.log('delegou')

                let action = false
                $('.actions').each((i,o) => {
                    if ($(o).prop('checked')) {
                        action = true
                    }
                })

                if ($('#user-delegated').val() === '') {
                    showAlert("Você precisa escolher um usuário!")
                    return false
                } 
                
                if (!action) {
                    showAlert("Você precisa escolher uma ação!")    
                    return false
                }
                


                window.livewire.emit('getSelectedItems')
            })

            function showAlert(msg) {
                $('#msg-alert').text(msg)
                $('#msg-alert').show()
                setTimeout(() => $('#msg-alert').hide(), 3000)
            }
        })

    </script>
@endsection