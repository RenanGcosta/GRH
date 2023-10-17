<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class FuncionarioController extends Controller
{
    public function create()
    {
        $max = DB::table('funcionario')->max('matricula');
        $proxMatricula = $max + 1;
        $cargos = Cargo::where('ativo', 'Sim')->orderBy('cargo')->get();
        $departamentos = Departamento::where('ativo', 'Sim')->orderBy('departamento')->get();
        return view('funcionario.create', compact('proxMatricula', 'cargos', 'departamentos'));
    }
    

    public function store(Request $request)
    {
        $input = $request->toArray();
        Funcionario::create($input);
        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionario Cadastrado com sucesso');
    }

    public function index(Request $request)

    {
        $funcionarios = Funcionario::where('nome', 'like', '%' .
        $request->buscaFuncionario . '%')->orderby('nome', 'asc')->paginate(50);
        return view('funcionario.index', compact('funcionarios'));
    }

    public function edit($id){
        $dadosFuncionario = Funcionario::find($id);
        $departamentos = Departamento::all();
        $cargos = Cargo::all();
        return view('funcionario.edit', compact('dadosFuncionario', 'departamentos', 'cargos'));
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::find($id);
        if ($request->matricula != $funcionario->matricula) {
            $matriculaExistente = Funcionario::where('matricula', $request->matricula)->exists();
            if ($matriculaExistente) {
                return back()->with('erro', 'A matrícula escolhida está vinculada a outro funcionário.');
            }
        }
        $funcionario->fill($request->all())->save();
        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionário atualizado com sucesso!');
    }
    
    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);
        $funcionario->delete();
        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionario deletado com sucesso!');
    }
}