@extends('layout.menu')

@section('title', 'Novo Exame')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Exames</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcExame.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="create" name="form">
            <div class="form-group mb-4">
                <label class="mb-2" for="id_funcionario">Selecione o Funcionário:</label>
                <select name="id_funcionario" id="id_funcionario" class="form-control" required>
                    <option value=""></option>
                    @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div id="exames_info"></div>
            <table class="table table-striped" id="exames-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Exame</th>
                        <th>Anotação</th>
                        <th>Data de Validade</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exames as $exame)
                        <tr class="text-center">
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" name="exames[]" value="{{ $exame->id }}"
                                        class="form-check-input">
                                    <label class="form-check-label">{{ $exame->exame }}</label>
                                </div>
                            </td>
                            <td>
                                <input name="anotacao{{ $exame->id }}" class="form-control" placeholder="Anotação">
                            </td>
                            <td>
                                <input type="text" name="data_validade{{ $exame->id }}" class="form-control bg-light"
                                    readonly>
                            </td>
                            <td>
                                <p>Duração: {{ $exame->duracao }} {{ $exame->tipo_periodo }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Cadastrar/Atualizar</button>
                <a href="{{ route('funcExame.index') }}" class="btn btn-secondary">Listar todos</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            const idFuncionario = $('#id_funcionario').val();
            const examesInfoDiv = $('#exames_info');
            const checkboxes = $('input[name="exames[]"]');
            const anotacaoInputs = $('input[name^="anotacao"]');
            const dataValidadeInputs = $('input[name^="data_validade"]');

            function aplicarMascaraData() {
                dataValidadeInputs.on('input', function() {
                    const input = $(this);
                    let value = input.val().replace(/\D/g, ''); // Remover caracteres não numéricos

                    if (value.length > 2) {
                        value = value.slice(0, 2) + '/' + value.slice(2);
                    }

                    if (value.length > 5) {
                        value = value.slice(0, 5) + '/' + value.slice(5, 9);
                    }

                    input.val(value);
                });
            }
            aplicarMascaraData();

            dataValidadeInputs.on('blur', function() {
                const input = $(this);
                const value = input.val();

                if (value) {
                    const pattern = /^(\d{2})\/(\d{2})\/(\d{4})/;

                    if (!pattern.test(value)) {
                        alert('Atenção! Formato de Data Inválido.');
                        input.val('');
                    } else {
                        const day = parseInt(RegExp.$1, 10);
                        const month = parseInt(RegExp.$2, 10);
                        const year = parseInt(RegExp.$3, 10);

                        if (month < 1 || month > 12 || day < 1 || day > 31 || year < 2000 || year > 9999) {
                            alert('Data inválida. Insira uma data válida.');
                            input.val('');
                        }
                    }
                }
            });


            function carregarDadosExames(idFuncionario) {
                checkboxes.prop('checked', false);
                anotacaoInputs.val('').prop('disabled', false);
                dataValidadeInputs.val('');

                if (idFuncionario !== '') {
                    $.ajax({
                        url: '/verificar-exames/' + idFuncionario,
                        method: 'GET',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Nenhum funcionário selecionado',
                                    text: 'Por favor, selecione um funcionário para verificar os exames.'
                                });
                                examesInfoDiv.html('');
                            } else {
                                if (response.exames.length > 0) {
                                    let html = '<ul>';
                                    const hoje = new Date(); // Obter a data de hoje apenas uma vez
                                    const hojeSemHoras = new Date(hoje.getFullYear(), hoje.getMonth(),
                                        hoje.getDate()
                                    ); // Remova as horas para evitar problemas de fuso horário

                                    response.exames.forEach(function(exameInfo) {
                                        const dataValidade = new Date(exameInfo.data_validade);
                                        const formattedDataValidade = dataValidade
                                            .toLocaleDateString('pt-BR', {
                                                timeZone: 'UTC'
                                            }); // Defina a zona de fuso horário para UTC
                                        html += '<li>' + exameInfo.exame + ' - Vence em: ' +
                                            formattedDataValidade + '</li>';
                                        const checkbox = $('input[name="exames[]"][value="' +
                                            exameInfo.id_exame + '"]');

                                        if (checkbox.length) {
                                            const dataValidade = new Date(exameInfo
                                                .data_validade);
                                            const formattedDataValidade = dataValidade
                                                .toLocaleDateString('pt-BR', {
                                                    timeZone: 'UTC'
                                                });

                                            // Crie as datas sem horas para evitar problemas de fuso horário
                                            const dataValidadeSemHoras = new Date(dataValidade
                                                .getFullYear(), dataValidade.getMonth(),
                                                dataValidade.getDate());
                                            const hoje = new Date();
                                            const hojeSemHoras = new Date(hoje.getFullYear(),
                                                hoje.getMonth(), hoje.getDate());

                                            if (dataValidadeSemHoras < hojeSemHoras) {
                                                checkbox.prop('checked', true);
                                            } else {
                                                checkbox.prop('checked', false);
                                            }

                                            const anotacaoInput = $('input[name="anotacao' +
                                                exameInfo.id_exame + '"]');
                                            anotacaoInput.val(exameInfo.anotacao || '');

                                            const dataValidadeInput = $(
                                                'input[name="data_validade' + exameInfo
                                                .id_exame + '"]');
                                            dataValidadeInput.val(formattedDataValidade || '');
                                        }


                                    });
                                    html += '</ul>';
                                    examesInfoDiv.html(html);
                                } else {
                                    examesInfoDiv.html('');
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Nenhum exame encontrado',
                                        text: 'Nenhum exame encontrado para este funcionário.'
                                    });
                                }
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Erro ao verificar exames: ' + error
                            });
                            examesInfoDiv.html('');
                        }
                    });
                } else {
                    examesInfoDiv.html('');
                }
            }

            function limparAnotacaoWhenUnchecked() {
                checkboxes.change(function() {
                    const checkbox = $(this);
                    const exameId = checkbox.val();
                    const anotacaoInput = $('input[name="anotacao' + exameId + '"]');
                    const dataValidadeInput = $('input[name="data_validade' + exameId + '"]');

                    if (checkbox.prop('checked')) {
                        const idFuncionario = $('#id_funcionario').val();
                        $.ajax({
                            url: '/obter-dados-funcExame/' + idFuncionario + '/' + exameId,
                            method: 'GET',
                            success: function(statusResponse) {
                                if (statusResponse.anotacao) {
                                    anotacaoInput.val(statusResponse.anotacao);
                                } else {
                                    anotacaoInput.val('');
                                }

                                if (statusResponse.data_validade) {
                                    const dataValidade = new Date(statusResponse.data_validade);
                                    const formattedDataValidade = dataValidade
                                        .toLocaleDateString('pt-BR', {
                                            timeZone: 'UTC'
                                        });
                                    dataValidadeInput.prop('value', formattedDataValidade);
                                } else {
                                    $.ajax({
                                        url: '/data-validade-exame/' + exameId,
                                        method: 'GET',
                                        success: function(dataValidadeResponse) {
                                            if (dataValidadeResponse
                                                .data_validade) {
                                                dataValidadeInput.prop('value',
                                                    dataValidadeResponse
                                                    .data_validade);
                                            } else {
                                                dataValidadeInput.prop('value', '');
                                            }
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    });

                                }
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    } else {
                        anotacaoInput.val('');
                        dataValidadeInput.prop('value', '');
                    }
                });
            }

            limparAnotacaoWhenUnchecked();
            carregarDadosExames(idFuncionario);
            $('#id_funcionario').change(function() {
                const idFuncionario = $(this).val();
                carregarDadosExames(idFuncionario);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#id_funcionario').change(function() {
                if ($('.alert').is(':visible')) {
                    $('.alert').hide();
                }
            });
        });
    </script>
@endsection
