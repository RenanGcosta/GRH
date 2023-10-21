@extends('layout.menu')

@section('title', 'Novo Exame')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Novo Exame</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcExame.store') }}" enctype="multipart/form-data">
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
            <div id="exames_info"></div>
            <table class="table table-striped">
                <!-- Cabeçalho da tabela -->
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Exame</th>
                        <th>Anotação</th>
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
                                <input name="anotacao{{ $exame->id }}" class="form-control" placeholder="Anotação"
                                    disabled>
                            </td>
                            <td>
                                <p>Duração: {{ $exame->duracao }} {{ $exame->tipo_periodo }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Cadastrar Exame(s)</button>
                <a href="" class="btn btn-secondary">Listar todos</a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const anotacaoInput = this.closest('tr').querySelector('.form-control');
                    if (this.checked) {
                        anotacaoInput.removeAttribute('disabled');
                    } else {
                        anotacaoInput.setAttribute('disabled', 'disabled');
                        anotacaoInput.value = '';
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#id_funcionario').change(function() {
                const idFuncionario = $(this).val();
                const examesInfoDiv = $('#exames_info');
                const checkboxes = $('input[name="exames[]"]');

                checkboxes.prop('checked', false);

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
                            } else {
                                if (response.exames.length > 0) {
                                    let html = '<ul>';
                                    response.exames.forEach(function(exameInfo) {
                                        const dataValidade = new Date(exameInfo
                                            .data_validade);
                                        const formattedDataValidade = dataValidade
                                            .toLocaleDateString('pt-BR');
                                        html += '<li>' + exameInfo.exame +
                                            ' - Vence em: ' + formattedDataValidade +
                                            '</li>';
                                        // const checkbox = $(
                                        //     'input[name="exames[]"][value="' +
                                        //     exameInfo.id_exame + '"]');
                                        // if (checkbox.length) {
                                        //     checkbox.prop('checked', true);
                                        //}
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
                        }
                    });
                } else {
                    examesInfoDiv.html('');
                }
            });
        });
    </script>
@endsection
