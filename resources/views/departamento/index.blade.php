@extends('layout.menu')

@section('title', 'GRH - Departamentos')

@section('bars')
@if (Session::has('sucesso'))
    <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
@elseif (Session::has('erro'))
    <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
@endif
    <h1>Departamentos Cadastrados</h1>
    <a href="{{ route('departamento.create') }}" title="Cadastrar Departamento" class="btn btn-primary position-absolute top-0 end-0 m-4 rounded-circle fs-4"><i
            class="bi bi-file-earmark-person"></i></a>
    <form action="" method="get" class="mb-3 d-flex justify-content-end">
        <div class="input-group me-3">
            <input type="text" name="buscaDepartamento" class="form-control form-control-lg" placeholder="Exemplo: CHESF">
            <button class="btn btn-primary" type="submit">Procurar</button>
        </div>
        <a href="{{ route('departamento.index') }}" class="btn btn-danger border ">Limpar</a>
    </form>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Departamentos Cadastrados</th>
                <th width='190'>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($departamentos as $departamento)
                <tr class="text-center">
                    <td class="align-middle">{{ $departamento->id }}</td>
                    <td class="align-middle">{{ $departamento->departamento }}</td>
                    <td class="align-middle">
                        <div class="row">
                            <div class="col">
                                    <a href="{{ route('departamento.edit', $departamento->id) }}" class="btn btn-danger" 
                                    title="Editar"><i class="bi bi-pen">Editar</i></a>
                            </div>
                            <div class="col">
                                <a href="" class="btn btn-danger" title="Excluir" data-bs-toggle="modal" data-bs-target="#modal-deletar-{{ $departamento->id }}"><i class="bi bi-trash">Excluir</i></a>
                                @include('departamento.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
