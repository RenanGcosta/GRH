<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="/images/layout/icone.png">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg mb-4" style="background-color: #000;">
        <div class="container">
            <a href=""><img src="" height="30" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <img src="#" alt="" width="70" height="40">
                <ul class="navbar-nav">
                    <li class="nav-item px-3">
                        <a class="nav-link bi bi-house text-white" href="{{ route('dashboard.index') }}"> Home </a>
                    </li>

                    @can('acessar-usuarios')
                        <li class="nav-item px-3 dropdown">
                            <a class="nav-link dropdown-toggle text-white bi bi-people" href="#" role="button"
                                data-bs-toggle="dropdown"> Cadastros </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('funcionario.create') }}">Cadastro de Funcionário</a></li>
                                <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Cadastro de Usuário</a></li>
                                <li><a class="dropdown-item" href="{{ route('departamento.create')}}">Cadastro de Departamento</a></li>
                                <li><a class="dropdown-item" href="{{ route('cargo.create')}}">Cadastro de Cargo</a></li>
                                <li><a class="dropdown-item" href="{{ route('exame.create')}}">Cadastro de Exame</a></li>
                                <li><a class="dropdown-item" href="{{ route('treinamento.create')}}">Cadastro de Treinamento</a></li>
                                <li><a class="dropdown-item" href="{{ route('funcExame.create')}}">Novo Exame</a></li>
                                <li><a class="dropdown-item" href="{{ route('funcTreinamento.create')}}">Novo Treinamento</a></li>
                            </ul>
                        </li>
                    @endcan

                    <li class="nav-item px-3 dropdown">
                        <a class="nav-link dropdown-toggle text-white bi bi-person" href="#" role="button"
                            data-bs-toggle="dropdown">
                            Olá {{ auth()->user()->nome }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('usuarios.edit', auth()->user()->id) }}">Editar
                                    Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('login.logout') }}">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mb-3 p-4 position-relative rounded"  style="background-color: #cae3e9">
        @yield('bars')
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>