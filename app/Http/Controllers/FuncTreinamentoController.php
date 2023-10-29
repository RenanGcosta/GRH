<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\FuncionarioTreinamento;
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
        $dataValidade = null;

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

        $algumtreinamentoselecionado = !empty($treinamentosSelecionados);
        if (!$algumtreinamentoselecionado) {
            return redirect()->route('funcTreinamento.create')->with('erro', 'Nenhum treinamento foi selecionado para ' . $funcionario->nome . '.');
        }

        foreach ($treinamentosSelecionados as $id_treinamento) {
            $treinamento = Treinamento::find($id_treinamento);
            $dataValidade = $this->calcularDataValidade($treinamento->duracao, $treinamento->tipo_periodo);

            $data = [
                'data_validade' => $dataValidade,
                'anotacao' => $request->input('anotacao' . $id_treinamento),
                'id_user' => $id_user,
                'id_funcionario' => $funcionario->id,
                'id_treinamento' => $id_treinamento,
            ];
            DB::table('func_x_treinamento')->insert($data);
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

        foreach ($treinamentos as $treinamento) {
            $dataValidade = Carbon::parse($treinamento->data_validade);
            $dataValidade->addDay();
            $treinamento->data_validade = $dataValidade->format('Y-m-d');
        }
        return response()->json(['treinamentos' => $treinamentos]);
    }

    public function destroy($id)
    {
        $treinamento = FuncionarioTreinamento::find($id);
        $treinamento->delete();
        return redirect()->route('funcTreinamento.index')->with('sucesso', 'Treinamento deletado com sucesso.');
    }

    public function index(Request $request)
    {
        $query = FuncionarioTreinamento::query();
    
        if ($request->filled('treinamento')) {
            $query->whereHas('idTreinamento', function ($subquery) use ($request) {
                $subquery->where('treinamento', 'like', '%' . $request->treinamento . '%');
            });
        }
    
        if ($request->filled('nome')) {
            $query->whereHas('idFuncionario', function ($subquery) use ($request) {
                $subquery->where('nome', 'like', '%' . $request->nome . '%');
            });
        }
    
        if ($request->filled('data_validade')) {
            $dataValidade = \Carbon\Carbon::createFromFormat('d/m/Y', $request->data_validade)->format('Y-m-d');
            $query->where('data_validade', $dataValidade);
        }
    
        $FuncTreinamentos = $query->with('idTreinamento', 'idFuncionario')->orderBy('id_treinamento', 'asc')->paginate(100);
    
        return view('funcTreinamento.index', compact('FuncTreinamentos'));
    }

    public function edit($idFuncionario, $id_treinamento)
    {
        $funcTreinamento = DB::table('func_x_treinamento')
            ->where('id_funcionario', $idFuncionario)
            ->where('id_treinamento', $id_treinamento)
            ->first();
        $treinamento = Treinamento::where('id', $id_treinamento)->first();
        $funcionario = Funcionario::find($idFuncionario);

        return view('funcTreinamento.edit', compact('funcionario', 'treinamento', 'funcTreinamento'));
    }

    public function update(Request $request, $id)
    {
        $FuncTreinamento = FuncionarioTreinamento::find($id);

        if ($FuncTreinamento->data_validade != $request->data_validade || $FuncTreinamento->anotacao != $request->anotacao) {
            $dataValidade = \DateTime::createFromFormat('d/m/Y', $request->data_validade);
            $FuncTreinamento->data_validade = $dataValidade->format('Y-m-d');

            $FuncTreinamento->anotacao = $request->anotacao;
            $FuncTreinamento->save();
        } else {
            return redirect()->route('funcTreinamento.index');
        }
        return redirect()->route('funcTreinamento.index')->with('sucesso', 'Dados do Treinamento atualizados com sucesso!');
    }

    // public function verificarStatusTreinamento($idFuncionario, $treinamentoId)
    // {
    //     $treinamento = DB::table('func_x_treinamento')
    //         ->where('id_funcionario', $idFuncionario)
    //         ->where('id_treinamento', $treinamentoId)
    //         ->first();

    //     return response()->json(['existe' => $treinamento !== null]);
    // }
    // public function verificarAnotacaoTreinamento($idFuncionario, $treinamentoId)
    // {
    //     $anotacao = DB::table('func_x_treinamento')
    //         ->where('id_funcionario', $idFuncionario)
    //         ->where('id_treinamento', $treinamentoId)
    //         ->value('anotacao');

    //     return response()->json(['anotacao' => $anotacao]);
    // }
}
