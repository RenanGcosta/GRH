<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exame;
use App\Models\Funcionario;
use Carbon\Carbon;
class FuncExameController extends Controller
{

    public function create()
    {
        $funcionarios = Funcionario::all();
        $exames = Exame::where('ativo', 'Sim')->get();
        return view('funcExame.create', compact('funcionarios', 'exames'));
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
        $examesSelecionados = $request->input('exames', []);
        $id_user = auth()->user()->id;
        
        if (empty($examesSelecionados)) {
            return redirect()->route('funcExame.create')->with('erro', 'Nenhum exame foi selecionado para ' . $funcionario->nome .'.');
        }

        foreach ($examesSelecionados as $id_exame) {
            $exame = Exame::find($id_exame);
            $dataValidade = $this->calcularDataValidade($exame->duracao, $exame->tipo_periodo);

            $data = [
                'data_validade' => $dataValidade,
                'anotacao' => $request->input('anotacao' . $id_exame),
                'id_user' => $id_user,
                'id_funcionario' => $funcionario->id,
            ];
            $funcionario->exames()->attach($id_exame, $data);
        }
        return redirect()->route('funcExame.create')->with('sucesso', 'Exame(s) inserido(s) com sucesso para ' . $funcionario->nome . '. Clique em (Listar Todos) para visualizar.');
    }
}
