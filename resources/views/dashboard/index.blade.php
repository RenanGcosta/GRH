@extends('layout.menu')

@section('title', 'GRH - Dashboard')

@section('bars')

    <body style="background-color: #ffffff">
        <p></p>


        <div class="row row-cols-1 row-cols-md-3 g-4 mybackground">
            <div class="col" id="30_dias">
                <div class="card h-100">
                    <div class="card-body text-center border border-primary border-2 rounded">
                        <p>30 Dias ou Menos</p>
                        @foreach ($exames30 as $exame)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(215, 223, 243) 0%, rgb(197, 197, 237) 100%);">
                                    <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                                    <p>{{ $exame->idFuncionario->nome }}</p>
                                    <p><strong>Data:</strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($treinamentos30 as $treinamento)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(215, 223, 243) 0%, rgb(197, 197, 237) 100%);">
                                    <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                                    <p>{{ $treinamento->idFuncionario->nome }}</p>
                                    <p><strong>Data:</strong>
                                        {{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col" id="7_dias">
                <div class="card h-100">
                    <div class="card-body text-center border border-warning border-2 rounded">
                        <p class="mb-3">7 Dias ou Menos</p>
                        @foreach ($exames7 as $exame)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(241, 239, 215) 0%, rgb(240, 234, 174) 100%);">
                                    <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                                    <p>{{ $exame->idFuncionario->nome }}</p>
                                    <p><strong>Data:
                                        </strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($treinamentos7 as $treinamento)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(241, 239, 215) 0%, rgb(240, 234, 174) 100%);">
                                    <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                                    <p>{{ $treinamento->idFuncionario->nome }}</p>
                                    <p><strong>Data:
                                        </strong>{{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="col" id="vencido">
                <div class="card h-100">
                    <div class="card-body text-center border border-danger border-2 rounded">
                        <p>Vencidos</p>
                        @foreach ($examesVencidos as $exame)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(240, 210, 210) 0%, rgb(228, 162, 162) 100%);">
                                    <p><strong>Exame:</strong> {{ $exame->idExame->exame }}</p>
                                    <p>{{ $exame->idFuncionario->nome }}</p>
                                    <p><strong>Data:</strong>{{ \Carbon\Carbon::parse($exame->data_validade)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($treinamentosVencidos as $treinamento)
                            <div class="card mb-3">
                                <div class="card-body"
                                    style="background: linear-gradient(to right, rgb(240, 210, 210) 0%, rgb(228, 162, 162) 100%);">
                                    <p><strong>Treinamento:</strong> {{ $treinamento->idTreinamento->treinamento }}</p>
                                    <p>{{ $treinamento->idFuncionario->nome }}</p>
                                    <p><strong>Data:</strong>
                                        {{ \Carbon\Carbon::parse($treinamento->data_validade)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection