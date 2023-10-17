@extends('layout.menu')

@section('title', 'GRH - Editar Treinamento')

@section('bars')
@if (Session::has('sucesso'))
    <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
@elseif (Session::has('erro'))
    <div class "alert alert-danger text-center">{{ Session::get('erro') }}</div>
@endif
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1 class="mb-3">Editar Treinamento</h1>
        <form class="row g-4" method="post" action="{{ route('treinamento.update', $dadosTreinamento->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="treinamento" class="form-label">Nome do Treinamento</label>
                        <input type="text" name="treinamento" class="form-control form-control-lg bg-light"
                            value="{{ $dadosTreinamento->treinamento }}">
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <select name="ativo" class="form-select form-select-lg bg-light">
                            <option value="Sim" @if($dadosTreinamento->ativo === 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if($dadosTreinamento->ativo === 'Não') selected @endif>Não</option>
                        </select>
                    </div>
                </div> 
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <div>
                        <label for="duracao" class="form-label">Duração</label>
                        <input type="number" name="duracao" class="form-control form-control-lg bg-light"
                            value="{{ $dadosTreinamento->duracao }}">
                    </div>
                </div>
                <div class="col-6">
                    <label for="tipo_periodo" class="form-label">Tipo de Período</label>
                    <select name="tipo_periodo" class="form-select form-select-lg bg-light">
                        <option value="anos" {{ $dadosTreinamento->tipo_periodo === 'anos' ? 'selected' : '' }}>Anos</option>
                        <option value="meses" {{ $dadosTreinamento->tipo_periodo === 'meses' ? 'selected' : '' }}>Meses</option>
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Atualizar</button>
                <a href="{{ route('treinamento.index') }}" class="btn btn-danger ">Cancelar</a>
            </div>
        </div>
    </div>
    </form>
@endsection
