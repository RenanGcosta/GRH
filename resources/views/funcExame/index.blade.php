@extends('layout.menu')

@section('title', 'GRH - Exames')

@section('bars')
    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif
    <h1 class="mb-3">Todos os Exames</h1>
    <form action="" method="get" class="mb-3 d-flex align-items-center">
        <div class="input-group me-3">
            <input type="text" name="buscaFuncExame" class="form-control form-control-lg" placeholder="Exemplo: ASO">
            <button class="btn btn-primary" type="submit">Procurar</button>
        </div>
        <a href="{{ route('funcExame.index') }}" class="btn btn-danger border btn-lg">Limpar</a>
        <a href="{{ route('funcExame.create') }}" title="Novo Exame" class="btn btn-primary me-auto btn-lg">Novo</a>
    </form>
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
                    <td class="align-middle">{{ \Carbon\Carbon::parse($funcExame->data_validade)->format('d-m-Y') }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('funcExame.edit', ['idFuncionario' => $funcExame->idFuncionario, 'idExame' => $funcExame->idExame]) }}"
                                    class="btn btn-danger" title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-"><i class="bi bi-trash">Excluir</i></a>
                                {{-- @include('funcionario.delete') --}}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection