<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        Gate::authorize('acessar-usuarios');
        return view('departamento.create');
    }

    public function store(Request $request)
    {
        $input = $request->toArray();
        Gate::authorize('acessar-usuarios');
        Departamento::create($input);
        return redirect()->route('departamento.index')->with('sucesso', 'Departamento Cadastrado com sucesso');
    }

    public function index(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $departamentos = Departamento::where('departamento', 'like', '%' .
            $request->buscaDepartamento . '%')->orderby('departamento', 'asc')->paginate(100);
        return view('departamento.index', compact('departamentos'));
    }

    public function edit($id)
    {
        Gate::authorize('acessar-usuarios');
        $dadosDepartamento = Departamento::find($id);
        return view('departamento.edit', compact('dadosDepartamento'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('acessar-usuarios');
        $input = $request->toArray();
        $departamento = Departamento::find($id);
        $departamento->fill($input);
        $departamento->save();
        return redirect()->route('departamento.index')->with('sucesso', 'Departamento alterado com sucesso.');
    }

    public function destroy($id)
    {
        Gate::authorize('acessar-usuarios');
        $departamento = Departamento::find($id);
        $funcionarioVinculado = Funcionario::where('id_departamento', $id)->count();
        if ($funcionarioVinculado > 0) {
            return redirect()->route('departamento.index')->with('erro', 'Não é possível excluir o departamento porque ele está vinculado a funcionários.');
        }

        $departamento->delete();
        return redirect()->route('departamento.index')->with('sucesso', 'Departamento deletado com sucesso.');
    }
}
