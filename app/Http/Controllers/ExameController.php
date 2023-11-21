<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use App\Models\FuncionarioExame;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
class ExameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $exames = Exame::where('exame', 'like', '%' .
            $request->buscaExame . '%')->orderby('exame', 'asc')->paginate(100);
        return view('exame.index', compact('exames'));
    }

    public function create()
    {
        Gate::authorize('acessar-usuarios');
        return view('exame.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $input = $request->toArray();
        Exame::create($input);
        return redirect()->route('exame.index')->with('sucesso', 'Exame Cadastrado com sucesso');
    }

    public function destroy($id)
    {
        Gate::authorize('acessar-usuarios');
        $exame = Exame::find($id);
        $funcionarioVinculado = FuncionarioExame::where('id_exame', $id)->count();
        if ($funcionarioVinculado > 0) {
            return redirect()->route('cargo.index')->with('erro', 'Não é possível excluir o exame pois ele está vinculado a funcionários.');
        }
        $exame->delete();
        return redirect()->route('exame.index')->with('sucesso', 'Exame deletado com sucesso.');
    }

    public function edit($id)
    {
        Gate::authorize('acessar-usuarios');
        $dadosExame = Exame::find($id);
        return view('exame.edit', compact('dadosExame'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('acessar-usuarios');
        $input = $request->toArray();
        $exame = Exame::find($id);
        $exame->fill($input);
        $exame->save();
        return redirect()->route('exame.index')->with('sucesso', 'Exame alterado com sucesso.');
    }

    public function calcularDataValidade($idExame)
    {
        $exame = Exame::find($idExame);

        $tipoPeriodo = $exame->tipo_periodo;
        $duracao = $exame->duracao;

        $dataAtual = Carbon::now();
        $dataValidade = $dataAtual;

        if ($tipoPeriodo === 'ano(s)') {
            $dataValidade->addYears($duracao);
        } elseif ($tipoPeriodo === 'mês(es)') {
            $dataValidade->addMonths($duracao);
        }

       // $dataValidade = $dataValidade->subDay();
        return response()->json(['data_validade' => $dataValidade->format('d/m/Y')]);
    }
}