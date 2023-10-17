<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\Treinamento;

class FuncTreinamentoController extends Controller
{
    private function calcularDataValidade($duracao, $tipoPeriodo)
    {
        $dataAtual = Carbon::now();

        if ($tipoPeriodo === 'ano(s)') {
            $dataValidade = $dataAtual->addYears($duracao);
        } elseif ($tipoPeriodo === 'mês(es)') {
            $dataValidade = $dataAtual->addMonths($duracao);
        } else {
        }
        return $dataValidade;
    }

    public function store(Request $request)
    {
        $funcionario = Funcionario::find($request->input('id_funcionario'));
        $treinamentosSelecionados = $request->input('treinamentos', []);
        $id_user = auth()->user()->id;

        if (empty($treinamentosSelecionados)) {
            return redirect()->route('funcTreinamento.create')->with('erro', 'Nenhum treinamento foi selecionado para ' . $funcionario->nome .'.');
        }

        foreach ($treinamentosSelecionados as $id_treinamento) {
            $treinamento = Treinamento::find($id_treinamento);
            $dataValidade = $this->calcularDataValidade($treinamento->duracao, $treinamento->tipo_periodo);

            $data = [
                'data_validade' => $dataValidade,
                'anotacao' => $request->input('anotacao' . $id_treinamento),
                'id_user' => $id_user,
                'id_funcionario' => $funcionario->id,
            ];
            $funcionario->treinamentos()->attach($id_treinamento, $data);
        }

        return redirect()->route('funcTreinamento.create')->with('sucesso', 'Treinamento(s) inserido(s) com sucesso para ' . $funcionario->nome . '. Clique em (Listar Todos) para visualizar.');
    }

    public function create()
    {
        $funcionarios = Funcionario::all();
        $treinamentos = Treinamento::where('ativo', 'Sim')->get();
        return view('funcTreinamento.create', compact('funcionarios', 'treinamentos'));
    }
}