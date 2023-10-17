@extends('layout.menu')

@section('title', 'Cadastrar Exame')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Cadastro de Exame</h1>
        <form class="row g-4" method="post" action="{{ route('exame.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="exame" class="form-label">Nome do Exame</label>
                        <input type="text" name="exame" class="form-control form-control-lg bg-light" required>
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
                        <input type="number" name="duracao" class="form-control form-control-lg bg-light" required>
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <label for="tipo_periodo" class="form-label">Tipo de Período</label>
                        <select name="tipo_periodo" class="form-select form-select-lg bg-light" required>
                            <option value="anos">Anos</option>
                            <option value="meses">Meses</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Cadastrar</button>
                <a href="{{ route('exame.index') }}" class="btn btn-secondary ">Listar todos</a>
            </div>
        </div>
    </form>
@endsection