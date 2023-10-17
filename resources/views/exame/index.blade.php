@extends('layout.menu')

@section('title', 'GRH - Exames')

@section('bars')
    @if (Session::has('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @elseif (Session::has('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif
    <h1>Exames Cadastrados</h1>
    <a href="{{ route('exame.create') }}" title="Cadastrar Exame"
        class="btn btn-primary position-absolute top-0 end-0 m-4 rounded-circle fs-4"><i
            class="bi bi-file-earmark-person"></i></a>
    <form action="" method="get" class="mb-3 d-flex justify-content-end">
        <div class="input-group me-3">
            <input type="text" name="buscaExame" class="form-control form-control-lg" placeholder="Exemplo: ASO">
            <button class="btn btn-primary" type="submit">Procurar</button>
        </div>
        <a href="{{ route('exame.index') }}" class="btn btn-danger border ">Limpar</a>
    </form>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Exames Cadastrados</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($exames as $exame)
                <tr class="text-center">
                    <td class="align-middle">{{ $exame->id }}</td>
                    <td class="align-middle">{{ $exame->exame }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('exame.edit', $exame->id) }}" class="btn btn-danger" title="Editar"><i
                                        class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal"
                                    data-bs-target="#modal-deletar-{{ $exame->id }}"><i
                                        class="bi bi-trash">Excluir</i></a>
                                @include('exame.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
