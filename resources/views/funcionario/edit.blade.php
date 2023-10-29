@extends('layout.menu')
@section('title', 'GRH - Editar Cadastro')

@section('bars')
@if (Session::has('sucesso'))
    <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
@elseif (Session::has('erro'))
    <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
@endif
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1 class="mb-3">Editar Cadastro</h1>
        <form class="row g-4" method="post" action="{{ route('funcionario.update', $dadosFuncionario->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ auth()->user()->id }}" name="id_user">
            <div class="row mt-5 mb-4">
                <div class="col-6">
                    <div>
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control form-control-lg bg-light" value="{{ $dadosFuncionario->nome }}">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="CPF" class="form-label">CPF</label>
                        <input type="text" name="CPF" class="form-control form-control-lg bg-light" value="{{ $dadosFuncionario->CPF }}">
                    </div>
                </div>

                <div class="col-3">
                    <div>
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control form-control-lg bg-light" value="{{ $dadosFuncionario->data_nascimento }}">
                    </div>
                </div>
                
            </div>
            <div class="row mb-4">
                <div class="col-3">
                    <div>
                        <label for="RG" class="form-label">RG</label>
                        <input type="text" name="RG" class="form-control form-control-lg bg-light" value=" {{ $dadosFuncionario->RG }} ">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="data_admissao" class="form-label">Data de Admissão</label>
                        <input type="date" name="data_admissao" class="form-control form-control-lg bg-light" value="{{ $dadosFuncionario->data_admissao }}">
                    </div>
                </div>
                <div class="col-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-lg bg-light" value=" {{ $dadosFuncionario->email }}">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="id_departamento" class="form-label fw-bold">Departamento</label>
                    <select name="id_departamento" class="form-select form-select-lg bg-light" required>
                        <option value=""></option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" @if($dadosFuncionario->id_departamento == $departamento->id) selected @endif>
                                {{ $departamento->departamento }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-5">
                    <label for="id_cargo" class="form-label fw-bold">Cargo</label>
                    <select name="id_cargo" class="form-select form-select-lg bg-light" required>
                        <option value=""></option>
                        @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->id }}" @if($dadosFuncionario->id_cargo == $cargo->id) selected @endif>
                                {{ $cargo->cargo }}
                            </option>
                        @endforeach
                    </select>
                </div>                
                <div class="col-3">
                    <div>
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control form-control-lg bg-light" value="{{ $dadosFuncionario->telefone }}"
                            placeholder="(DDD) XXXXX-XXXX">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select name="sexo" class="form-select form-select-lg bg-light">
                        <option value="Masculino" {{ $dadosFuncionario->sexo === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Feminino" {{ $dadosFuncionario->sexo === 'Feminino' ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>                
                    <div class="col-8">
                        <div>
                            <label for="observacao" class="form-label">Observação</label>
                            <input type="text" name="observacao" class="form-control form-control-lg bg-light"
                                value="{{ $dadosFuncionario->observacao }}">
                        </div>
                    </div>
                    <div class="col-1">
                        <div>
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="number" name="matricula" class="form-control form-control-lg bs-dark-bg-subtle"
                                 value="{{ $dadosFuncionario->matricula }}">
                        </div>
                    </div>
            <div class="row mb-4 mt-4">
                <div class="col-5">
                    <label for="formFile" class="form-label">Foto</label>
                    <input name="foto" class="form-control" type="file" id="foto">
                </div>
            </div>
            <div class="mb-2">
                <h2>Endereço</h2>
            </div>
            <div class="row mb-4">
                <div class="col-3">
                    <div>
                        <label for="CEP" class="form-label">CEP</label>
                        <input type="text" name="CEP" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->CEP }}" placeholder="48000-000">
                    </div>
                </div>
                <div class="col-8">
                    <div>
                        <label for="logradouro" class="form-label">Logradouro</label>
                        <input type="text" name="logradouro" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->logradouro }}">
                    </div>
                </div>
                <div class="col-1">
                    <div>
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" name="numero" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->numero }}">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-5">
                    <div>
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" name="bairro" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->bairro }}">
                    </div>
                </div>
                <div class="col-4">
                    <div>
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" name="estado" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->estado }}">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" name="cidade" class="form-control form-control-lg bg-light"
                            value="{{ $dadosFuncionario->cidade }}">
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Atualizar</button>
                <a href="{{ route('funcionario.index') }}" class="btn btn-danger ">Cancelar</a>
            </div>
    </div>
    </form>
@endsection
