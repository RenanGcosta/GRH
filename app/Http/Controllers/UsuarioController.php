<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function create()
    {
        Gate::authorize('acessar-usuarios');
        return view('usuarios.create');
    }
    public function store(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $existingUsername = User::where('username', $request->username)->value('username');
        if ($existingUsername) {
            return redirect()->route('usuarios.index')->with('erro', 'Já existe um usuário com o nome de ' . $existingUsername);
        }

        $input = $request->toArray();
        $input['password'] = bcrypt($input['password']);
        User::create($input);
        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário cadastrado com sucesso');
    }

    public function index(Request $request)
    {
        Gate::authorize('acessar-usuarios');
        $users = User::where('nome', 'like', '%' .
            $request->buscaUser . '%')->orderby('nome', 'asc')->paginate(5);
        $totalUsers = User::all()->count();
        return view('usuarios.index', compact('users', 'totalUsers'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('usuarios.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->toArray();
        $input['password'] = bcrypt($input['password']);
        $users = User::find($id);
        $users->fill($input);
        $users->save();
        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário alterado com sucesso!');
    }

    public function destroy($id)
    {
        Gate::authorize('acessar-usuarios');
        $users = User::find($id);
        $users->delete();
        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário deletado com sucesso!');
    }
}
