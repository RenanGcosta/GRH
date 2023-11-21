@extends('layout.menu')

@section('title', 'Cadastrar Treinamento')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Cadastro de Treinamento</h1>
        <form class="row g-4" method="post" action="{{ route('treinamento.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3 mt-5">
                <div class="col-10">
                    <div>
                        <label for="treinamento" class="form-label">Nome do Treinamento</label>
                        <input type="text" name="treinamento" class="form-control form-control-lg bg-light" required>
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
            <div class="row mb-4">
                <div class="col-6">
                    <div>
                        <label for="duracao" class="form-label">Duração</label>
                        <input type="number" name="duracao" class="form-control form-control-lg bg-light" value="">
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <label for="tipo_periodo" class="form-label">Tipo de Período</label>
                        <select name="tipo_periodo" class="form-select form-select-lg bg-light">
                            <option value="ano(s)">Anos</option>
                            <option value="mês(es)">Meses</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Cadastrar</button>
                <a href="{{ route('treinamento.index') }}" class="btn btn-secondary ">Listar todos</a>
            </div>
        </div>
    </form>
@endsection
