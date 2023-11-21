@extends('layout.menu')

@section('title', 'Lista de Exames')

@section('bars')
    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif
    <h1 class="mb-3">Todos os Exames</h1>
    <div class="row mb-3 col">
        <form action="{{ route('funcExame.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="exame" class="form-control" placeholder="Exame" style="width: 25%;">
                <input type="text" name="nome" class="form-control" placeholder="Nome" style="width: 30%;">
                <input type="text" name="data_validade" class="form-control" placeholder="Data de Validade" style="width: 20%;">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('funcExame.index') }}" title="Limpar" class="btn btn-secondary">Limpar</a>
                <div class="d-flex align-items-center"
                    style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;"></div>
                <div>
                    <a href="{{ route('funcExame.create') }}" title="Cadastrar Funcionário"
                        class="btn btn-primary">Novo</a>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Exame</th>
                <th>Funcionário</th>
                <th>Data de Validade</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($FuncExames as $funcExame)
                <tr class="text-center">
                    <td class="align-middle">{{ $funcExame->idExame->exame }}</td>
                    <td class="align-middle">{{ $funcExame->idFuncionario->nome }}</td>
                    <td class="align-middle">{{ \Carbon\Carbon::parse($funcExame->data_validade)->format('d/m/Y') }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('funcExame.edit', ['idFuncionario' => $funcExame->idFuncionario, 'idExame' => $funcExame->idExame]) }}"
                                    class="btn btn-danger" title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $funcExame->id }}"><i class="bi bi-trash">Excluir</i></a>
                                 @include('funcExame.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection