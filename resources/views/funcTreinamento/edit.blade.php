@extends('layout.menu')

@section('title', 'Editar dados do treinamento')

@section('bars')
    <div class="container-fluid shadow bg-white p-4 rounded">
        <h1>{{ $treinamento->treinamento }} de {{ $funcionario->nome }}</h1>
        @if (Session::has('sucesso'))
            <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
        @elseif (Session::has('erro'))
            <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
        @endif
        <form method="post" action="{{ route('funcTreinamento.update', $funcTreinamento->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <input type="hidden" value="edit" name="form">
                <input type="hidden" name="id_funcExame" value="{{ $funcTreinamento->id }}">
            </div>

            <div class="row">
                <div class="form-group mb-3">
                    <label for="anotacao" class="form-label">Anotação</label>
                    <textarea name="anotacao" class="form-control bg-light" rows="5" style="width: 100%;">{{ $funcTreinamento->anotacao }}</textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <label for="duracao" class="form-label">Duração</label>
                    <input type="text" name="duracao" class="form-control bg-light"
                        value="{{ $treinamento->duracao }} {{ $treinamento->tipo_periodo }}" readonly>
                </div>
                <div class="col-3">
                    <label for="data_validade" class="form-label">Data de Validade</label>
                    <input type="text" name="data_validade" class="form-control bg-light"
                        value="{{ date('d/m/Y', strtotime($funcTreinamento->data_validade)) }}" required>
                </div>
                <div class="col-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" id="obter-data">Obter Data</button>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Atualizar Treinamento(s)</button>
                <a href="{{ route('funcTreinamento.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
    </div>
    </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
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

            $('#obter-data').click(function() {
                $.ajax({
                    url: '/data-validade-treinamento/' + <?php echo $treinamento->id; ?>, 
                    method: 'GET',
                    success: function(data) {
                        $('input[name="data_validade"]').val(data.data_validade);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection