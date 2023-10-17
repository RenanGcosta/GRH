@extends('layout.menu')

@section('title', 'Cadastrar Cargo')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Cadastro de Cargo</h1>
        <form class="row g-4" method="post" action="{{ route('cargo.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="cargo" class="form-label">Nome do cargo</label>
                        <input type="text" name="cargo" class="form-control form-control-lg bg-light" required>
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <select name="ativo" class="form-select form-select-lg bg-light" required>
                            <option value=""></option>
                            <option value="Sim">Sim</option>
                            <option value="Não">Não</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Cadastrar</button>
                <a href="{{ route('cargo.index') }}" class="btn btn-secondary ">Listar todos</a>
            </div>
    </div>
    </form>
@endsection