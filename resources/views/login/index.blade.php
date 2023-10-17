<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GRH - Login</title>
    <link rel="icon" href="/images/layout/icone.png">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/icons/bootstrap-icons.css ">
</head>

<body background="/images/layout/login.jpg">
    <div class="col-xl-3 bg-white p-5 shadow position-absolute top-50 start-50 translate-middle rounded">
        <img src="/images/layout/logo.png" alt="logo" height="100" class="d-block mx-auto mb-4">

        @if (Session::get('erro'))
            <div class="alert alert-danger text-center p-2">{{ Session::get('erro') }}</div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning text-center p-2">{{ $error }}</div>
            @endforeach
        @endif

        <form class="row g-4 text-center" action="{{ route('login.auth') }}" method="post">
            @csrf
            <div class="col-12">
                <label for="username" class="form-label fs-5 fs-5">Nome de usuário</label>
                <input type="text" class="bg-light form-control form-control-lg" id="username" name="username">
            </div>
            <div class="col-12">
                <label for="password" class="form-label fs-5 fs-5">Senha</label>
                <input type="password" class="bg-light form-control form-control-lg" id="password" name="password">
            </div>
            <div class="col-12 d-grid">
                <button type="submit" class="btn btn-primary ">Entrar</button>
            </div>
        </form>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>