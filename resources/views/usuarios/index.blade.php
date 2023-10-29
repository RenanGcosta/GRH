@extends('layout.menu')

@section('title', 'Listar Usuários')

@section('bars')
    @if (Session::has('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @elseif (Session::has('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif
    <h1>Usuários Cadastrados</h1>

    <div class="row mb-3">
        <form action="{{ route('usuarios.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="buscaUser" class="form-control" placeholder="Nome">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
            <div class="d-flex align-items-center" style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;">
            </div>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Novo</a>
        </form>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo de usuário</th>
                <th>Data de Criação</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="text-center">
                    <td class="align-middle">{{ $user->id }}</td>
                    <td class="align-middle">{{ $user->nome }}</td>
                    <td class="align-middle">{{ $user->tipo }}</td>
                    <td class="align-middle">{{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}</td>
                    <td class="align-middle text-center">
                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-primary" title="Editar"><i
                                class="bi bi-pen"></i></a>
                        <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                            data-bs-target="#modal-deletar-{{ $user->id }}"><i class="bi bi-trash"></i></a>
                        @include('usuarios.delete')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
