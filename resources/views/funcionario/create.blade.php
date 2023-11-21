@extends('layout.menu')

@section('title', 'Cadastrar Funcionário')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <div>
            <h1>Cadastro de Funcionário</h1>
        </div>
        <form class="row g-4" method="post" action="{{ route('funcionario.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ auth()->user()->id }}" name="id_user">
            <div class="row mt-5 mb-4">
                <div class="col-6">
                    <div>
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control form-control-lg bg-light" value="">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="CPF" class="form-label">CPF</label>
                        <input type="text" name="CPF" class="form-control form-control-lg bg-light" value="">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control form-control-lg bg-light"
                            value="">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-3">
                    <div>
                        <label for="RG" class="form-label">RG</label>
                        <input type="text" name="RG" class="form-control form-control-lg bg-light" value="">
                    </div>
                </div>
                <div class="col-3">
                    <div>
                        <label for="data_admissao" class="form-label">Data de Admissão</label>
                        <input type="date" name="data_admissao" class="form-control form-control-lg bg-light"
                            value="">
                    </div>
                </div>
                <div class="col-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-lg bg-light" value="">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="id_departamento" class="form-label fw-bold">Departamento</label>
                    <select name="id_departamento" class="form-select form-select-lg bg-light" required>
                        <option value=""></option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->departamento }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <label for="id_cargo" class="form-label fw-bold">Cargo</label>
                    <select name="id_cargo" class="form-select form-select-lg bg-light" required>
                        <option value=""></option>
                        @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->id }}">{{ $cargo->cargo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <div>
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control form-control-lg bg-light" value=""
                            placeholder="(DDD) XXXXX-XXXX">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select name="sexo" class="form-select form-select-lg bg-light">
                        <option value=""></option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
                <div class="col-8">
                    <div>
                        <label for="observacao" class="form-label">Observação</label>
                        <input type="text" name="observacao" class="form-control form-control-lg bg-light"
                            value="">
                    </div>
                </div>
                <div class="col-1">
                    <div>
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" name="matricula" class="form-control form-control-lg bs-dark-bg-subtle"
                            readonly value="{{ $proxMatricula }}">
                    </div>
                </div>
                <div class="mb-2 mt-4">
                    <h2>Endereço</h2>
                </div>
                <div class="row mb-4">
                    <div class="col-3">
                        <div>
                            <label for="CEP" class="form-label">CEP</label>
                            <input type="text" name="CEP" class="form-control form-control-lg bg-light"
                                value="" placeholder="48000-000">
                        </div>
                    </div>
                    <div class="col-8">
                        <div>
                            <label for="logradouro" class="form-label">Logradouro</label>
                            <input type="text" name="logradouro" class="form-control form-control-lg bg-light"
                                value="">
                        </div>
                    </div>
                    <div class="col-1">
                        <div>
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" name="numero" class="form-control form-control-lg bg-light"
                                value="">
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-5">
                        <div>
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" name="bairro" class="form-control form-control-lg bg-light"
                                value="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div>
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" name="estado" class="form-control form-control-lg bg-light"
                                value="">
                        </div>
                    </div>
                    <div class="col-3">
                        <div>
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" name="cidade" class="form-control form-control-lg bg-light"
                                value="">
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary ">Cadastrar</button>
                    <a href="{{ route('funcionario.index') }}" class="btn btn-secondary ">Listar todos</a>
                </div>
            </div>
        </form>
        <script>
            aplicarMascaraCPF();
        </script>
    @endsection