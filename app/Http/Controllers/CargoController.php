<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CargoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
       public function create()
    {
        Gate::authorize('acessar-usuarios');
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $input = $request->toArray();
        Cargo::create($input);
        return redirect()->route('cargo.index')->with('sucesso', 'Cargo Cadastrado com sucesso');
    }

    public function index(Request $request){
        Gate::authorize('acessar-usuarios');
        $cargos = Cargo::where('cargo', 'like', '%' .
        $request->buscaCargo . '%')->orderby('cargo', 'asc')->paginate(100);
        return view('cargo.index', compact('cargos'));
    }

    public function edit($id){
        Gate::authorize('acessar-usuarios');
        $dadosCargo = Cargo::find($id);
        return view('cargo.edit', compact('dadosCargo'));
    }

    public function update(Request $request, $id){
        Gate::authorize('acessar-usuarios');
        $input = $request->toArray();
        $cargo = Cargo::find($id);
        $cargo->fill($input);
        $cargo->save();
        return redirect()->route('cargo.index')->with('sucesso','Cargo alterado com sucesso.');
    }

    public function destroy($id){
        Gate::authorize('acessar-usuarios');
        $cargo = Cargo::find($id);
        $funcionarioVinculado = Funcionario::where('id_cargo', $id)->count();
        if($funcionarioVinculado > 0 ){
            return redirect()->route('cargo.index')->with('erro', 'Não é possível excluir o cargo porque ele está vinculado a funcionários.');
        }

        $cargo->delete();
        return redirect()->route('cargo.index')->with('sucesso', 'Cargo deletado com sucesso.');
    }
}