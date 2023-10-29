@extends('layout.menu')

@section('title', 'Novo Treinamento')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Novo Treinamento</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcTreinamento.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label class="mb-2" for="id_funcionario">Selecione o Funcionário:</label>
                <select name="id_funcionario" id="id_funcionario" class="form-control" required>
                    <option value=""></option>
                    @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div id="treinamentos_info"></div>
            <table class="table table-striped" id="treinamentos-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Treinamento</th>
                        <th>Anotação</th>
                        <th>Data de Validade</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($treinamentos as $treinamento)
                        <div class="row">
                            <tr class="text-center">
                                <td class="col-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="treinamentos[]" value="{{ $treinamento->id }}"
                                            class="form-check-input">
                                        <label class="form-check-label">{{ $treinamento->treinamento }}</label>
                                    </div>
                                </td>
                                <td>
                                    <input name="anotacao{{ $treinamento->id }}" class="form-control"
                                        placeholder="Anotação">
                                </td>
                                <td class="col-2">
                                    <input type="text" name="data_validade{{ $treinamento->id }}"
                                        class="form-control bg-light" readonly>
                                </td>
                                <td class="col-2">
                                    <p>Duração: {{ $treinamento->duracao }} {{ $treinamento->tipo_periodo }}</p>
                                </td>
                            </tr>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Cadastrar Treinamento(s)</button>
                <a href="{{ route('funcTreinamento.index') }}" class="btn btn-secondary">Listar todos</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            const idFuncionario = $('#id_funcionario').val();
            const treinamentosInfoDiv = $('#treinamentos_info');
            const checkboxes = $('input[name="treinamentos[]"]');
            const anotacaoInputs = $('input[name^="anotacao"]');
            const dataValidadeInputs = $('input[name^="data_validade"]');

            function carregarDadosTreinamentos(idFuncionario) {
                checkboxes.prop('checked', false).prop('disabled', false);
                anotacaoInputs.val('');
                dataValidadeInputs.val('');
                if (idFuncionario) {
                    $.ajax({
                        url: '/verificar-treinamentos/' + idFuncionario,
                        method: 'GET',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Nenhum funcionário selecionado',
                                    text: 'Por favor, selecione um funcionário para verificar os treinamentos.'
                                });
                                treinamentosInfoDiv.html('');
                            } else {
                                const treinamentosVinculados = new Set(response.treinamentos.map(
                                    treinamentoInfo =>
                                    treinamentoInfo.id_treinamento));
                                let html = '<ul>';
                                checkboxes.each(function() {
                                    const checkbox = $(this);
                                    const treinamentoId = parseInt(checkbox.val(), 10);
                                    if (treinamentosVinculados.has(treinamentoId)) {
                                        checkbox.prop('disabled', true);
                                        const treinamentoInfo = response.treinamentos.find(
                                            treinamentoInfo =>
                                            treinamentoInfo.id_treinamento === treinamentoId
                                            );
                                        const formattedDataValidade = new Date(treinamentoInfo
                                            .data_validade).toLocaleDateString('pt-BR');
                                        html += '<li>' + treinamentoInfo.treinamento +
                                            ' - Vence em: ' +
                                            formattedDataValidade + '</li>';
                                    }
                                });

                                if (treinamentosVinculados.size === 0) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Nenhum treinamento encontrado',
                                        text: 'Este funcionário não possui treinamentos vinculados.'
                                    });
                                    treinamentosInfoDiv.html('');
                                } else {
                                    html = '<h3>Treinamentos Existentes para o Funcionário:</h3>' +
                                    html;
                                }
                                html += '</ul>';
                                treinamentosInfoDiv.html(html);
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Erro ao verificar treinamentos: ' + error.statusText
                            });
                            treinamentosInfoDiv.html('');
                        }
                    });
                } else {
                    treinamentosInfoDiv.html('');
                }
            }

            function limparAnotacaoWhenUnchecked() {
                checkboxes.change(function() {
                    const checkbox = $(this);
                    const treinamentoId = checkbox.val();
                    const anotacaoInput = $('input[name="anotacao' + treinamentoId + '"]');
                    const dataValidadeInput = $('input[name="data_validade' + treinamentoId + '"]');

                    if (checkbox.prop('checked')) {
                        const idFuncionario = $('#id_funcionario').val();
                        $.ajax({
                            url: '/data-validade-treinamento/' + treinamentoId,
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
            carregarDadosTreinamentos(idFuncionario);
            $('#id_funcionario').change(function() {
                const idFuncionario = $(this).val();
                carregarDadosTreinamentos(idFuncionario);
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
