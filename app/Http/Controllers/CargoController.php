<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class CargoController extends Controller
{
       public function create()
    {
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        $input = $request->toArray();
        //$input['ativo'] = isset($input['ativo']) ? 'Sim' : 'Não';
        Cargo::create($input);
        return redirect()->route('cargo.index')->with('sucesso', 'Cargo Cadastrado com sucesso');
    }

    public function index(Request $request){
        $cargos = Cargo::where('cargo', 'like', '%' .
        $request->buscaCargo . '%')->orderby('cargo', 'asc')->paginate(100);
        return view('cargo.index', compact('cargos'));
    }

    public function edit($id){
        $dadosCargo = Cargo::find($id);
        return view('cargo.edit', compact('dadosCargo'));
    }

    public function update(Request $request, $id){
        $input = $request->toArray();
       // $input['ativo'] = isset($input['ativo']) ? 'Sim' : 'Não';
        $cargo = Cargo::find($id);
        $cargo->fill($input);
        $cargo->save();
        return redirect()->route('cargo.index')->with('sucesso','Cargo alterado com sucesso.');
    }

    public function destroy($id){
        $cargo = Cargo::find($id);
        $funcionarioVinculado = Funcionario::where('id_cargo', $id)->count();
        if($funcionarioVinculado > 0 ){
            return redirect()->route('cargo.index')->with('erro', 'Não é possível excluir o cargo porque ele está vinculado a funcionários.');
        }

        $cargo->delete();
        return redirect()->route('cargo.index')->with('sucesso', 'Cargo deletado com sucesso.');
    }
}