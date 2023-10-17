<?php

namespace App\Http\Controllers;

use App\Models\FuncionarioTreinamento;
use Illuminate\Http\Request;
use App\Models\Treinamento;

class TreinamentoController extends Controller
{
    public function index(Request $request){
        $treinamentos = Treinamento::where('treinamento', 'like', '%' . $request->buscaTreinamento . '%')
            ->orderBy('treinamento', 'asc')
            ->paginate(100);
        return view('treinamento.index', compact('treinamentos'));
    }

    public function create(){
        return view('treinamento.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['ativo'] = $request->has('ativo') ? 'Sim' : 'Não';
        Treinamento::create($input);
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento Cadastrado com sucesso');
    }

    public function destroy($id){
        $treinamento = Treinamento::find($id);
        $funcionarioVinculado = FuncionarioTreinamento::where('id_treinamento', $id)->count();
        if ($funcionarioVinculado > 0) {
            return redirect()->route('treinamento.index')->with('erro', 'Não é possível excluir o treinamento porque ele está vinculado a funcionários.');
        }
        $treinamento->delete();
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento deletado com sucesso.');
    }
    
    public function edit($id){
        $dadosTreinamento = Treinamento::find($id);
        return view('treinamento.edit', compact('dadosTreinamento'));
    }

    public function update(Request $request, $id){
        $input = $request->all();
        $input['ativo'] = $request->has('ativo') ? 'Sim' : 'Não';
        $treinamento = Treinamento::find($id);
        $treinamento->fill($input);
        $treinamento->save();
        return redirect()->route('treinamento.index')->with('sucesso', 'Treinamento alterado com sucesso.');
    }
}