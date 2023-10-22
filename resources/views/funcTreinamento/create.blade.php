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
                <!-- Cabeçalho da tabela -->
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Treinamento</th>
                        <th id="status_column">Status</th>
                        <th>Anotação</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($treinamentos as $treinamento)
                        <tr class="text-center">
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" name="treinamentos[]" value="{{ $treinamento->id }}"
                                        class="form-check-input">
                                    <label class="form-check-label">{{ $treinamento->treinamento }}</label>
                                </div>
                            </td>
                            <td id="status_line">
                                <p id="desc"></p>
                            </td>
                            <td>
                                <input name="anotacao{{ $treinamento->id }}" class="form-control" placeholder="Anotação"
                                    disabled>
                            </td>
                            <td>
                                <p>Duração: {{ $treinamento->duracao }} {{ $treinamento->tipo_periodo }}</p>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Cadastrar Treinamento(s)</button>
                <a href="" class="btn btn-secondary">Listar todos</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {

            $('#id_funcionario').change(function() {
                const idFuncionario = $(this).val();
                const treinamentosInfoDiv = $('#treinamentos_info');
                const checkboxes = $('input[name="treinamentos[]"]');
                const statusCells = $('td#status p');
    
                checkboxes.prop('checked', false);
                statusCells.text('');
                $('input[name^="anotacao"]').val('').prop('disabled', true);
    
                if (idFuncionario !== '') {
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
                            } else {
                                if (response.treinamentos.length > 0) {
                                    let html =
                                        '<h3>Treinamentos Existentes para o Funcionário:</h3><ul>';
                                    response.treinamentos.forEach(function(treinamentoInfo) {
                                        const dataValidade = new Date(treinamentoInfo.data_validade);
                                        const formattedDataValidade = dataValidade.toLocaleDateString('pt-BR');
                                        html += '<li>' + treinamentoInfo.treinamento +
                                            ' - Vence em: ' + formattedDataValidade + '</li>';
                                    });
                                    html += '</ul>';
    
                                    treinamentosInfoDiv.html(html);
                                } else {
                                    treinamentosInfoDiv.html('');
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Nenhum treinamento encontrado',
                                        text: 'Nenhum treinamento encontrado para este funcionário.'
                                    });
                                }
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Erro ao verificar treinamentos: ' + error
                            });
                        }
                    });
                } else {
                    treinamentosInfoDiv.html('');
                }
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