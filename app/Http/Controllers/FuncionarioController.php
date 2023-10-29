<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class FuncionarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $query = Funcionario::query();

        if ($request->filled('matricula')) {
            $query->where('matricula', $request->input('matricula'));
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        if ($request->filled('CPF')) {
            $query->where('CPF', $request->input('CPF'));
        }

        if ($request->filled('cargo')) {
            $query->whereHas('idCargo', function ($query) use ($request) {
                $query->where('cargo', $request->input('cargo'));
            });
        }

        $funcionarios = $query->get();

        return view('funcionario.index', compact('funcionarios'));
    }

    public function edit($id)
    {
        $dadosFuncionario = Funcionario::find($id);
        // dd($dadosFuncionario);
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
        $examesCount = DB::table('func_x_exame')
            ->where('id_funcionario', $id)
            ->count();

        $treinamentosCount = DB::table('func_x_treinamento')
            ->where('id_funcionario', $id)
            ->count();

        if ($examesCount > 0 || $treinamentosCount > 0) {
            return redirect()->route('funcionario.index')->with('erro', 'Este funcionário possui exames ou treinamentos vinculados e não pode ser excluído.');
        }

        $funcionario->delete();
        return redirect()->route('funcionario.index')->with('sucesso', 'Funcionario deletado com sucesso!');
    }
}
