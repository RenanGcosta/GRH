@extends('layout.menu')

@section('title', 'Funcionários')

@section('bars')
    @if (Session::has('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @elseif (Session::has('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif
    <h1>Funcionários Cadastrados</h1>
    <div class="row mb-3 col">

        <form action="{{ route('funcionario.index') }}" method="get" class="d-flex align-items-center">
            <div class="input-group">
                <input type="text" name="matricula" class="form-control" placeholder="Matrícula" style="width: 10%;">
                <input type="text" name="nome" class="form-control" placeholder="Nome" style="width: 23%;">
                <input type="text" name="CPF" class="form-control" placeholder="CPF" style="width: 20%;">
                <input type="text" name="cargo" class="form-control" placeholder="Cargo" style="width: 18%;">
                <button class="btn btn-primary" type="submit">Procurar</button>
                <a href="{{ route('funcionario.index') }}" title="Limpar" class="btn btn-secondary">Limpar</a>
                <div class="d-flex align-items-center"
                    style="margin: 0 10px; border-left: 1px solid #aa8888; height: 38px;"></div>
                <div>
                    <a href="{{ route('funcionario.create') }}" title="Cadastrar Funcionário"
                        class="btn btn-primary">Novo</a>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Matrícula</th>
                <th>Nome do Funcionario</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcionarios as $funcionario)
                <tr class="text-center">
                    <td class="align-middle">{{ $funcionario->matricula }}</td>
                    <td class="align-middle">{{ $funcionario->nome }}</td>
                    <td class="align-middle">{{ $funcionario->CPF }}</td>
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
    <script>
        aplicarMascaraCPF();
    </script>
@endsection
