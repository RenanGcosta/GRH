@extends('layout.menu')

@section('title', 'Novo Exame')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>Exames de: {{ $funcionarios->nome }}</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcExame.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="edit" name="form">
            <div class="form-group mb-4">
                <input type="hidden" name="id_funcionario" value="{{ $funcionarios->id }}" id="id_funcionario">
            </div>

            <div id="exames_info"></div>
            <table class="table table-striped" id="exames-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Exame</th>
                        <th>Status</th>
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
                            <td id="status">
                                <p id="desc"></p>
                            </td>
                            <td>
                                <input name="anotacao{{ $exame->id }}" class="form-control" placeholder="Anotação">
                            </td>
                            <td>
                                <p>Duração: {{ $exame->duracao }} {{ $exame->tipo_periodo }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-primary">Atualizar Exame(s)</button>
                <a href="{{ route('funcExame.index') }}" class="btn btn-secondary">Listar todos</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            const idFuncionario = $('#id_funcionario').val();
            const examesInfoDiv = $('#exames_info');
            const checkboxes = $('input[name="exames[]"]');
    
            // Função para carregar os dados dos exames
            function carregarDadosExames(idFuncionario) {
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
                                        const dataValidade = new Date(exameInfo.data_validade);
                                        const formattedDataValidade = dataValidade.toLocaleDateString('pt-BR');
                                        html += '<li>' + exameInfo.exame + ' - Vence em: ' + formattedDataValidade + '</li>';
                                        const checkbox = $('input[name="exames[]"][value="' + exameInfo.id_exame + '"]');
                                        if (checkbox.length) {
                                            checkbox.prop('checked', true);
                                            const anotacaoInput = $('input[name="anotacao' + exameInfo.id_exame + '"]');
                                            anotacaoInput.val(exameInfo.anotacao || '');
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
                        }
                    });
                } else {
                    examesInfoDiv.html('');
                }
            }
    
            carregarDadosExames(idFuncionario);
    
            $('#id_funcionario').change(function() {
                const idFuncionario = $(this).val();
                const examesInfoDiv = $('#exames_info');
                const checkboxes = $('input[name="exames[]"]');
                checkboxes.prop('checked', false);
    
                carregarDadosExames(idFuncionario);
            });
        });
    </script>
    
@endsection
