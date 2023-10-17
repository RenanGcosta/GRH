@extends('layout.menu')

@section('title', 'Editar Departamento')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Editar Departamento</h1>
        <form class="row g-4" method="post" action="{{ route('departamento.update', $dadosDepartamento->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="departamento" class="form-label">Departamento</label>
                        <input type="text" name="departamento" class="form-control form-control-lg bg-light"
                            value="{{ $dadosDepartamento->departamento }}">
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <select name="ativo" class="form-select form-select-lg bg-light">
                            <option value="Sim" @if($dadosDepartamento->ativo === 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if($dadosDepartamento->ativo === 'Não') selected @endif>Não</option>
                        </select>
                    </div>
                </div>
                                
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Atualizar</button>
                <a href="{{ route('departamento.index') }}" class="btn btn-danger ">Cancelar</a>
            </div>
    </div>
    </form>
@endsection