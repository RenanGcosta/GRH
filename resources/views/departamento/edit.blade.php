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
                <div class="col-2 mt-4">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <input type="checkbox" name="ativo" class="form-check-input"
                            @if($dadosDepartamento->ativo === 'Sim') checked @endif>
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