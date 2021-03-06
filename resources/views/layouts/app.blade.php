<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
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
                            
                            @can('Visualizar Processos')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Processos <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    @can('Editar Processos')
                                        <a class="dropdown-item" href="{{ route('accessions.create') }}">Novo</a>
                                        <a class="dropdown-item" href="{{ route('accessions.index') }}">Em andamento</a>            
                                    @endcan
                                    @can('Editar Contatos')
                                        <a class="dropdown-item" href="{{ route('tocontact.index') }}">Liberado para Contato</a>
                                    @endcan
                                    @can('Editar Entrevistas')
                                        <a class="dropdown-item" href="{{ route('interview.index') }}">Liberado para Entrevista</a>
                                    @endcan

                                    @can('Avaliar Processos Clinicamente')                                        
                                        <a class="dropdown-item" href="{{ url('/medicanalysis/list') }}">Avaliar Grau de Risco</a>
                                    @endcan

                                    @can('Revisar Processos')                                        
                                        <a class="dropdown-item" href="{{ url('/toreview') }}">Aguardando Revis??o</a>
                                    @endcan
                                    
                                    @can('Editar Processos')
                                        <a class="dropdown-item" href="{{ route('accessions.index', ['finished' => 1]) }}">Finalizados</a>
                                    @endcan
                                </div>
                            </li>  
                            @endcan  
                            
                            @can('Editar Processos')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Cadastros <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('beneficiaries.index') }}">Benefici??rios</a> --}}
                                    <a class="dropdown-item" href="{{ route('companies.index') }}">Clientes</a>
                                    <a class="dropdown-item" href="{{ route('quizzes.index') }}">Modelos de DSs</a>
                                    <a class="dropdown-item" href="{{ route('healthquestions.index') }}">Quest??es para DS</a>
                                    <a class="dropdown-item" href="{{ route('healthplans.index') }}">Operadoras</a>
                                    <a class="dropdown-item" href="{{ route('inconsistencies.index') }}">Inconsist??ncias</a>
                                    <a class="dropdown-item" href="{{ route('suggestions.index') }}">Sugest??es</a>
                                    <a class="dropdown-item" href="{{ route('riskgrades.index') }}">Graus de Risco</a>
                                    <a class="dropdown-item" href="{{ route('statusprocess.index') }}">Status do Processo</a>
                                    <a class="dropdown-item" href="{{ route('processtypes.index') }}">Tipos de Movimenta????o</a>
                                </div>
                            </li>
                            @endcan
                            
                            @can('Editar Usu??rios')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Sistema <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboards.index') }}">Pain??is (Dashboards)</a>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Usu??rios</a>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Grupos de Usu??rios</a>
                                </div>
                            </li>
                            @endcan
                            
                        

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


    <script src="{{ asset('js/app.js') }}"></script>

    @yield('jscontent')

    <!-- Livewire scripts -->
    @livewireScripts
    @stack('scripts')

</body>
</html>
