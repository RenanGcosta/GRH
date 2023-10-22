@extends('layout.menu')

@section('title', 'Novo Exame')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>{{ $exame->exame }} de {{ $funcionario->nome }}</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcExame.update', $funcExame->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <input type="hidden" value="edit" name="form">
                <input type="hidden" name="id_funcExame" value="{{ $funcExame->id }}">
            </div>
            <table class="table table-striped" id="exames-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Anotação</th>
                        <th>Data de Validade</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>
                            <input type="text" name="anotacao" class="form-control bg-light"
                                value="{{ $funcExame->anotacao }}">
                        </td>
                        <td>
                            <input type="date" name="data_validade" class="form-control bg-light"
                                value="{{ $funcExame->data_validade }}">
                        </td>
                        <td>
                            <p>Duração: {{ $exame->duracao }} {{ $exame->tipo_periodo }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Atualizar Exame(s)</button>
                <a href="{{ route('funcExame.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
