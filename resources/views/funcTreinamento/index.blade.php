@extends('layout.menu')

@section('title', 'GRH - Treinamentos')

@section('bars')
    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif
    <h1 class="mb-3">Todos os Treinamentos</h1>
    <div class="row mb-3 col">
        <form action="{{ route('funcTreinamento.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="treinamento" class="form-control" placeholder="Treinamento" style="width: 25%;">
                <input type="text" name="nome" class="form-control" placeholder="Nome" style="width: 30%;">
                <input type="text" name="data_validade" class="form-control" placeholder="data_validade" style="width: 20%;">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('funcTreinamento.index') }}" title="Limpar" class="btn btn-secondary">Limpar</a>
                <div class="d-flex align-items-center"
                    style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;"></div>
                <div>
                    <a href="{{ route('funcTreinamento.create') }}" title="Cadastrar Treinamento"
                        class="btn btn-primary">Novo</a>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Treinamento</th>
                <th>Funcionário</th>
                <th>Data de Validade</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($FuncTreinamentos as $FuncTreinamento)
                <tr class="text-center">
                    <td class="align-middle">{{ $FuncTreinamento->idTreinamento->treinamento }}</td>
                    <td class="align-middle">{{ $FuncTreinamento->idFuncionario->nome }}</td>
                    <td class="align-middle">{{ \Carbon\Carbon::parse($FuncTreinamento->data_validade)->format('d/m/Y') }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('funcTreinamento.edit', ['idFuncionario' => $FuncTreinamento->idFuncionario, 'idTreinamento' => $FuncTreinamento->idTreinamento]) }}"
                                    class="btn btn-danger" title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $FuncTreinamento->id }}"><i class="bi bi-trash">Excluir</i></a>
                                  @include('funcTreinamento.delete') 
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection