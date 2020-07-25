<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @livewireStyles
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img src="/images/Doctor-Icon-1-244x300.png" height="35" alt=""> <span style="font-size:12px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                                </li>
                            @endif
                        @else
                            @hasanyrole('SuperAdmin|Diretoria|Operacional|Médico|Coordenação|Supervisão|Gerência')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Processos <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('accessions.create') }}">Novo</a>
                                        <a class="dropdown-item" href="{{ route('accessions.index') }}">Em andamento</a>
                                        <a class="dropdown-item" href="{{ route('accessions.index') }}">Liberado para Entrevista</a>
                                        <a class="dropdown-item" href="{{ route('accessions.index') }}">Avaliar Grau de Risco</a>
                                        <a class="dropdown-item" href="{{ route('accessions.index') }}">Finalizados</a>
                                    </div>
                                </li>    
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Cadastros <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        {{-- <a class="dropdown-item" href="{{ route('beneficiaries.index') }}">Beneficiários</a> --}}
                                        <a class="dropdown-item" href="{{ route('companies.index') }}">Clientes</a>
                                        <a class="dropdown-item" href="{{ route('quizzes.index') }}">Modelos de DSs</a>
                                        <a class="dropdown-item" href="{{ route('healthquestions.index') }}">Questões para DS</a>
                                        <a class="dropdown-item" href="{{ route('healthplans.index') }}">Operadoras</a>
                                        <a class="dropdown-item" href="{{ route('inconsistencies.index') }}">Inconsistências</a>
                                        <a class="dropdown-item" href="{{ route('suggestions.index') }}">Sugestões</a>
                                        <a class="dropdown-item" href="{{ route('riskgrades.index') }}">Graus de Risco</a>
                                        <a class="dropdown-item" href="{{ route('statusprocess.index') }}">Status do Processo</a>
                                        <a class="dropdown-item" href="{{ route('processtypes.index') }}">Tipos de Movimentação</a>
                                    </div>
                                </li>
                                
                                @can('Editar Usuários')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Sistema <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('dashboards.index') }}">Painéis (Dashboards)</a>
                                        <a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a>
                                        <a class="dropdown-item" href="{{ route('roles.index') }}">Grupos de Usuários</a>
                                    </div>
                                </li>
                                @endcan
                                
                            @endhasanyrole

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.edit', [ 'user' => Auth::user()->id ]) }}">Meu Perfil</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-4">
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

        
    @yield('jscontent')

    <!-- Livewire scripts -->
    @livewireScripts
    @stack('scripts')

</body>
</html>
