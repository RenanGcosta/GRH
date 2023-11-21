@extends('layout.menu')

@section('title', 'Departamentos')

@section('bars')
    @if (Session::has('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @elseif (Session::has('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif
    <h1>Departamentos Cadastrados</h1>
    <div class="row mb-3">
        <form action="{{ route('departamento.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="buscaDepartamento" class="form-control" placeholder="Nome do Departamento">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('departamento.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
            <div class="d-flex align-items-center" style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;">
            </div>
            <a href="{{ route('departamento.create') }}" class="btn btn-primary">Novo</a>
        </form>
    </div>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Nome do Departamento</th>
                <th>Data de Criação</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($departamentos as $departamento)
                <tr class="text-center">
                    <td class="align-middle">{{ $departamento->id }}</td>
                    <td class="align-middle">{{ $departamento->departamento }}</td>
                    <td class="align-middle">{{ date('d/m/Y H:i:s', strtotime($departamento->created_at)) }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('departamento.edit', $departamento->id) }}" class="btn btn-danger"
                                    title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $departamento->id }}"><i
                                        class="bi bi-trash">Excluir</i></a>
                                @include('departamento.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
