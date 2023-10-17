<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function auth(Request $request)
    {
        $credenciais = $request->validate(
            [
                'username' => ['required'], // Alterado de 'email' para 'username'
                'password' => ['required'],
            ],
            [
                'username.required' => 'O campo nome de usuário é obrigatório', // Atualizado o erro para 'username'
                'password.required' => 'O campo senha é obrigatório',
            ]
        );
    
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        } else {
            return redirect()->back()->with('erro', 'Nome de usuário ou senha inválidos');
        }
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index');
    }
}
