<?php

namespace App\Http\Controllers;

use App\Models\FuncionarioTreinamento;
use Illuminate\Http\Request;
use App\Models\Treinamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
class TreinamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        Gate::authorize('acessar-usuarios');
        $treinamentos = Treinamento::where('treinamento', 'like', '%' . $request->buscaTreinamento . '%')
            ->orderBy('treinamento', 'asc')
            ->paginate(100);
        return view('treinamento.index', compact('treinamentos'));
    }

    public function create(){
        Gate::authorize('acessar-usuarios');
        return view('treinamento.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $input = $request->all();
        Treinamento::create($input);
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento Cadastrado com sucesso');
    }

    public function destroy($id){
        Gate::authorize('acessar-usuarios');
        $treinamento = Treinamento::find($id);
        $funcionarioVinculado = FuncionarioTreinamento::where('id_treinamento', $id)->count();
        if ($funcionarioVinculado > 0) {
            return redirect()->route('treinamento.index')->with('erro', 'Não é possível excluir o treinamento pois ele está vinculado a funcionários.');
        }
        $treinamento->delete();
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento deletado com sucesso.');
    }
    
    public function edit($id){
        Gate::authorize('acessar-usuarios');
        $dadosTreinamento = Treinamento::find($id);
        return view('treinamento.edit', compact('dadosTreinamento'));
    }

    public function update(Request $request, $id){
        Gate::authorize('acessar-usuarios');
        $input = $request->all();
        $treinamento = Treinamento::find($id);
        $treinamento->fill($input);
        $treinamento->save();
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento alterado com sucesso.');
    }

    public function calcularDataValidade($idTreinamento)
    {
        $treinamento = Treinamento::find($idTreinamento);

        $tipoPeriodo = $treinamento->tipo_periodo;
        $duracao = $treinamento->duracao;

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