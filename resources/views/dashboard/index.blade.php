@extends('layout.menu')

@section('title', 'GRH - Dashboard')

@section('bars')

    <body style="background-color: #ffffff">
        <p></p>
        <br><br><br><br>

        <div class="row row-cols-1 row-cols-md-3 g-4 mybackground">
            <div class="col" id="30_dias">
                <div class="card h-100">
                    <div class="card-body text-center">
                        @foreach ($exames30 as $exame)
                            <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                            <p>{{ $exame->idFuncionario->nome }}</p>
                            <p><strong>Data:</strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}</p>
                        @endforeach

                        @foreach ($treinamentos30 as $treinamento)
                            <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                            <p>{{ $treinamento->idFuncionario->nome }}</p>
                            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                            </p>
                        @endforeach

                    </div>
                    <div class="card-footer" style="background-color: #c94203">
                        <small class="text-muted"> </small>
                    </div>
                </div>
            </div>

            <div class="col" id="7_dias">
                <div class="card h-100">
                    <div class="card-body text-center">
                        @foreach ($exames7 as $exame)
                            <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                            <p>{{ $exame->idFuncionario->nome }}</p>
                            <p><strong>Data:</strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}</p>
                        @endforeach

                        @foreach ($treinamentos7 as $treinamento)
                            <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                            <p>{{ $treinamento->idFuncionario->nome }}</p>
                            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                            </p>
                        @endforeach
                    </div>
                    <div class="card-footer" style="background-color: #1900ff">
                        <small class="text-muted"> </small>
                    </div>
                </div>
            </div>
            <div class="col" id="vencido">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <p>vencido</p>
                        @foreach ($examesVencidos as $exame)
                        <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                        <p>{{ $exame->idFuncionario->nome }}</p>
                        <p><strong>Data:</strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}</p>
                    @endforeach

                    @foreach ($treinamentosVencidos as $treinamento)
                        <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                        <p>{{ $treinamento->idFuncionario->nome }}</p>
                        <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                        </p>
                    @endforeach
                    </div>
                    <div class="card-footer" style="background-color: #09ff00">
                        <small class="text-muted"> </small>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection