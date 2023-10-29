@extends('layout.menu')

@section('title', 'GRH - Cargos')

@section('bars')
    @if (Session::has('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @elseif (Session::has('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif
    <h1>Cargos Cadastrados</h1>
    <div class="row mb-3">
        <form action="{{ route('cargo.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="buscaCargo" class="form-control" placeholder="Nome do Cargo">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('cargo.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
            <div class="d-flex align-items-center" style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;">
            </div>
            <a href="{{ route('cargo.create') }}" class="btn btn-primary">Novo</a>
        </form>
    </div>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Nome do Cargo</th>
                <th>Data de Criação</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cargos as $cargo)
                <tr class="text-center">
                    <td class="align-middle">{{ $cargo->id }}</td>
                    <td class="align-middle">{{ $cargo->cargo }}</td>
                    <td class="align-middle">{{ date('d/m/Y H:i:s', strtotime($cargo->created_at)) }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('cargo.edit', $cargo->id) }}" class="btn btn-danger" title="Editar"><i
                                        class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $cargo->id }}"><i
                                        class="bi bi-trash">Excluir</i></a>
                                @include('cargo.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
