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

            function carregarDadosExames(idFuncionario) {
                checkboxes.prop('checked', false).prop('disabled', false);
                anotacaoInputs.val('');
                dataValidadeInputs.val('');
                if (idFuncionario) {
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
                                const examesVinculados = new Set(response.exames.map(exameInfo =>
                                    exameInfo.id_exame));
                                let html = '<ul>';
                                checkboxes.each(function() {
                                    const checkbox = $(this);
                                    const exameId = parseInt(checkbox.val(), 10);
                                    if (examesVinculados.has(exameId)) {
                                        checkbox.prop('disabled', true);
                                        const exameInfo = response.exames.find(exameInfo =>
                                            exameInfo.id_exame === exameId);
                                        const formattedDataValidade = new Date(exameInfo
                                            .data_validade).toLocaleDateString('pt-BR');
                                        html += '<li>' + exameInfo.exame + ' - Vence em: ' +
                                            formattedDataValidade + '</li>';
                                    }
                                });

                                if (examesVinculados.size === 0) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Nenhum exame encontrado',
                                        text: 'Este funcionário não possui exames vinculados.'
                                    });
                                    examesInfoDiv.html('');
                                } else {
                                    html = '<h3>Exames Existentes para o Funcionário:</h3>' + html;
                                }
                                html += '</ul>';
                                examesInfoDiv.html(html);
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Erro ao verificar exames: ' + error.statusText
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
                            url: '/data-validade-exame/' + exameId,
                            method: 'GET',
                            success: function(dataValidadeResponse) {
                                if (dataValidadeResponse.data_validade) {
                                    dataValidadeInput.prop('value', dataValidadeResponse
                                        .data_validade);
                                } else {
                                    dataValidadeInput.prop('value', '');
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