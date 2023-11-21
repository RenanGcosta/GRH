@extends('layout.menu')
@section('title', 'Editar Exame')

@section('bars')
@if (Session::has('sucesso'))
    <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
@elseif (Session::has('erro'))
    <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
@endif
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1 class="mb-3">Editar Exame</h1>
        <form class="row g-4" method="post" action="{{ route('exame.update', $dadosExame->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="exame" class="form-label">Nome do Exame</label>
                        <input type="text" name="exame" class="form-control form-control-lg bg-light"
                            value="{{ $dadosExame->exame }}">
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <select name="ativo" class="form-select form-select-lg bg-light">
                            <option value="Sim" @if($dadosExame->ativo === 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if($dadosExame->ativo === 'Não') selected @endif>Não</option>
                        </select>
                    </div>
                </div> 
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <div>
                        <label for="duracao" class="form-label">Duração</label>
                        <input type="number" name="duracao" class="form-control form-control-lg bg-light"
                            value="{{ $dadosExame->duracao }}">
                    </div>
                </div>
                <div class="col-6">
                    <label for="tipo_periodo" class="form-label">Tipo de Período</label>
                    <select name="tipo_periodo" class="form-select form-select-lg bg-light">
                        <option value="ano(s)" {{ $dadosExame->tipo_periodo === 'ano(s)' ? 'selected' : '' }}>Anos</option>
                        <option value="mês(es)" {{ $dadosExame->tipo_periodo === 'mês(es)' ? 'selected' : '' }}>Meses</option>
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Atualizar</button>
                <a href="{{ route('exame.index') }}" class="btn btn-danger ">Cancelar</a>
            </div>
        </div>
    </div>
    </form>
@endsection
