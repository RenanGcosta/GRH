@extends('layout.menu')

@section('title', 'GRH - Funcionários')

@section('bars')
    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif
    <h1>Funcionários Cadastrados</h1>
    <form action="" method="get" class="mb-3 d-flex align-items-center">
        <div class="input-group me-3">
            <input type="text" name="buscaFuncionario" class="form-control form-control-lg" placeholder="Exemplo: João">
            <button class="btn btn-primary" type="submit">Procurar</button>
        </div>
        <a href="{{ route('funcionario.index') }}" class="btn btn-danger border btn-lg">Limpar</a>
        <a href="{{ route('funcionario.create') }}" title="Cadastrar Funcionário" class="btn btn-primary me-auto btn-lg">Novo</a>
    </form>
    


    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Matrícula</th>
                <th>Nome do Funcionario</th>
                <th>Cargo</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcionarios as $funcionario)
                <tr class="text-center">
                    <td class="align-middle">{{ $funcionario->matricula }}</td>
                    <td class="align-middle">{{ $funcionario->nome }}</td>
                    <td class="align-middle">{{ $funcionario->idCargo->cargo }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('funcionario.edit', $funcionario->id) }}" class="btn btn-danger"
                                    title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $funcionario->id }}"><i
                                        class="bi bi-trash">Excluir</i></a>
                                @include('funcionario.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection