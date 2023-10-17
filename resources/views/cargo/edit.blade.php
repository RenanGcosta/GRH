@extends('layout.menu')

@section('title', 'Editar Cargo')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Editar Cargo</h1>
        <form class="row g-4" method="post" action="{{ route('cargo.update', $dadosCargo->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row mb-4 mt-5">
                <div class="col-10">
                    <div>
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" name="cargo" class="form-control form-control-lg bg-light"
                            value="{{ $dadosCargo->cargo }}">
                    </div>
                </div>
                <div class="col-2">
                    <div>
                        <label for="ativo" class="form-label">Ativo</label>
                        <select name="ativo" class="form-select form-select-lg bg-light">
                            <option value="Sim" @if($dadosCargo->ativo === 'Sim') selected @endif>Sim</option>
                            <option value="Não" @if($dadosCargo->ativo === 'Não') selected @endif>Não</option>
                        </select>
                    </div>
                </div>              
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Atualizar</button>
                <a href="{{ route('cargo.index') }}" class="btn btn-danger ">Cancelar</a>
            </div>
    </div>
    </form>
@endsection