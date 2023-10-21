<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\Treinamento;
use Illuminate\Support\Facades\DB;

class FuncTreinamentoController extends Controller
{
    public function create()
    {
        $funcionarios = Funcionario::all();
        $treinamentos = Treinamento::where('ativo', 'Sim')->get();
        return view('funcTreinamento.create', compact('funcionarios', 'treinamentos'));
    }

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
        $treinamentoSelecionados = $request->input('treinamentos', []);
        $id_user = auth()->user()->id;

        if (empty($treinamentoSelecionados)) {
            return redirect()->route('funcTreinamento.create')->with('erro', 'Nenhum treinamento foi selecionado para ' . $funcionario->nome . '.');
        }

        foreach ($treinamentoSelecionados as $id_treinamento) {
            $treinamento = Treinamento::find($id_treinamento);
            $dataValidade = $this->calcularDataValidade($treinamento->duracao, $treinamento->tipo_periodo);

            $existingRecord = DB::table('func_x_treinamento')
                ->where('id_funcionario', $funcionario->id)
                ->where('id_treinamento', $id_treinamento)
                ->first();

            if ($existingRecord) {
                DB::table('func_x_treinamento')
                    ->where('id_funcionario', $funcionario->id)
                    ->where('id_treinamento', $id_treinamento)
                    ->update([
                        'data_validade' => $dataValidade,
                        'anotacao' => $request->input('anotacao' . $id_treinamento),
                        'id_user' => $id_user,
                    ]);
            } else {
                $data = [
                    'data_validade' => $dataValidade,
                    'anotacao' => $request->input('anotacao' . $id_treinamento),
                    'id_user' => $id_user,
                    'id_funcionario' => $funcionario->id,
                    'id_treinamento' => $id_treinamento,
                ];
                DB::table('func_x_treinamento')->insert($data);
            }
        }

        return redirect()->route('funcTreinamento.create')->with('sucesso', 'Dados Atualizados com Sucesso para ' . $funcionario->nome . '. Clique em (Listar Todos) para visualizar.');
    }
    public function verificarTreinamentosFuncionario($idFuncionario)
    {
        $treinamentos = DB::table('func_x_treinamento')
            ->select('func_x_treinamento.id_treinamento', 'func_x_treinamento.data_validade', 'func_x_treinamento.id_funcionario', 'treinamento.treinamento', 'func_x_treinamento.anotacao')
            ->join('treinamento', 'func_x_treinamento.id_treinamento', '=', 'treinamento.id')
            ->where('func_x_treinamento.id_funcionario', $idFuncionario)
            ->get();

        return response()->json(['treinamentos' => $treinamentos]);
    }
    public function verificarStatusTreinamento($idFuncionario, $treinamentoId)
    {
        $treinamento = DB::table('func_x_treinamento')
            ->where('id_funcionario', $idFuncionario)
            ->where('id_treinamento', $treinamentoId)
            ->first();

        return response()->json(['existe' => $treinamento !== null]);
    }
    public function verificarAnotacaoTreinamento($idFuncionario, $treinamentoId)
    {
        $anotacao = DB::table('func_x_treinamento')
            ->where('id_funcionario', $idFuncionario)
            ->where('id_treinamento', $treinamentoId)
            ->value('anotacao');

        return response()->json(['anotacao' => $anotacao]);
    }
}
