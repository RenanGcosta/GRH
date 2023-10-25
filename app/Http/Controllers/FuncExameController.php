<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exame;
use App\Models\Funcionario;
use App\Models\FuncionarioExame;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FuncExameController extends Controller
{

    public function create()
    {
        $funcionarios = Funcionario::all();
        $exames = Exame::where('ativo', 'Sim')->get();
        return view('funcExame.create', compact('funcionarios', 'exames'));
    }

    public function edit($idFuncionario, $idExame)
    {
        $funcExame = DB::table('func_x_exame')
            ->where('id_funcionario', $idFuncionario)
            ->where('id_exame', $idExame)
            ->first();
        $exame = Exame::where('id', $idExame)->first();
        $funcionario = Funcionario::find($idFuncionario);

        return view('funcExame.edit', compact('funcionario', 'exame', 'funcExame'));
    }

    private function calcularDataValidade($duracao, $tipoPeriodo)
    {
        $dataAtual = Carbon::now();
        $dataValidade = null;

        if ($tipoPeriodo === 'ano(s)') {
            $dataValidade = $dataAtual->addYears($duracao);
        } elseif ($tipoPeriodo === 'mês(es)') {
            $dataValidade = $dataAtual->addMonths($duracao);
        }
        return $dataValidade;
    }


    public function store(Request $request)
    {
        $funcionario = Funcionario::find($request->input('id_funcionario'));
        $examesSelecionados = $request->input('exames', []);
        $id_user = auth()->user()->id;

        $algumExameSelecionado = !empty($examesSelecionados);
        if (!$algumExameSelecionado) {
            return redirect()->route('funcExame.create')->with('erro', 'Nenhum exame foi selecionado para ' . $funcionario->nome . '.');
        }

        foreach ($examesSelecionados as $id_exame) {
            $exame = Exame::find($id_exame);
            $dataValidade = $this->calcularDataValidade($exame->duracao, $exame->tipo_periodo);

            $data = [
                'data_validade' => $dataValidade,
                'anotacao' => $request->input('anotacao' . $id_exame),
                'id_user' => $id_user,
                'id_funcionario' => $funcionario->id,
                'id_exame' => $id_exame,
            ];
            DB::table('func_x_exame')->insert($data);
        }

        return redirect()->route('funcExame.create')->with('sucesso', 'Dados Atualizados com Sucesso para ' . $funcionario->nome . '. Clique em (Listar Todos) para visualizar.');
    }

    public function verificarExamesFuncionario($idFuncionario)
    {
        $exames = DB::table('func_x_exame')
            ->select('func_x_exame.id_exame', 'func_x_exame.data_validade', 'func_x_exame.id_funcionario', 'exame.exame', 'func_x_exame.anotacao')
            ->join('exame', 'func_x_exame.id_exame', '=', 'exame.id')
            ->where('func_x_exame.id_funcionario', $idFuncionario)
            ->get();

        return response()->json(['exames' => $exames]);
    }

    public function index(Request $request)
    {
        $FuncExames = FuncionarioExame::whereHas('idExame', function ($query) use ($request) {
            $query->where('exame', 'like', '%' . $request->buscaFuncExame . '%');
        })->with('idExame', 'idFuncionario')->orderBy('id_exame', 'asc')->paginate(100);
        return view('funcExame.index', compact('FuncExames'));
    }

    public function verificarAnotacaoExame($idFuncionario, $exameId)
    {
        $dadosExame = DB::table('func_x_exame')
            ->where('id_funcionario', $idFuncionario)
            ->where('id_exame', $exameId)
            ->select('anotacao', 'data_validade')
            ->first();
        return response()->json($dadosExame);
    }

    public function update(Request $request, $id)
    {
        $funcExame = FuncionarioExame::find($id);

        if ($funcExame->data_validade != $request->data_validade || $funcExame->anotacao != $request->anotacao) {
            $dataValidade = \DateTime::createFromFormat('d/m/Y', $request->data_validade);
            $funcExame->data_validade = $dataValidade->format('Y-m-d');

            $funcExame->anotacao = $request->anotacao;
            $funcExame->save();
        } else {
            return redirect()->route('funcExame.index');
        }
        return redirect()->route('funcExame.index')->with('sucesso', 'Dados do exame atualizados com sucesso!');
    }
}