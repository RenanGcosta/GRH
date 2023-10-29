<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuncionarioExame;
use App\Models\FuncionarioTreinamento;
use Carbon\Carbon;
use DateTime;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = new DateTime();
        dd($today);

        $exames30 = FuncionarioExame::whereDate('data_validade', '<=', $today->addDays(30))
            ->whereDate('data_validade', '>', $today)
            ->get()
            ->map(function ($exame) {
                $exame->data_validade = Carbon::parse($exame->data_validade)->format('Y-m-d');
                return $exame;
            });

        $exames7 = FuncionarioExame::whereDate('data_validade', '<=', $today->addDays(7))
            ->whereDate('data_validade', '>', $today)
            ->get()
            ->map(function ($exame) {
                $exame->data_validade = Carbon::parse($exame->data_validade)->format('Y-m-d');
                return $exame;
            });

            $examesVencidos = FuncionarioExame::get()
            ->filter(function ($exame) use ($today) {
                return Carbon::parse($exame->data_validade)->lessThan($today);
            })
            ->map(function ($exame) {
                $exame->data_validade = Carbon::parse($exame->data_validade)->format('Y-m-d');
                return $exame;
            });
        
        $treinamentos30 = FuncionarioTreinamento::whereDate('data_validade', '<=', $today->addDays(30))
            ->whereDate('data_validade', '>', $today)
            ->get()
            ->map(function ($treinamento) {
                $treinamento->data_validade = Carbon::parse($treinamento->data_validade)->format('Y-m-d');
                return $treinamento;
            });

        $treinamentos7 = FuncionarioTreinamento::whereDate('data_validade', '<=', $today->addDays(7))
            ->whereDate('data_validade', '>', $today)
            ->get()
            ->map(function ($treinamento) {
                $treinamento->data_validade = Carbon::parse($treinamento->data_validade)->format('Y-m-d');
                return $treinamento;
            });

        $treinamentosVencidos = FuncionarioTreinamento::whereDate('data_validade', '<', $today)
            ->get()
            ->map(function ($treinamento) {
                $treinamento->data_validade = Carbon::parse($treinamento->data_validade)->format('Y-m-d');
                return $treinamento;
            });

        return view('dashboard.index', compact('exames30', 'exames7', 'examesVencidos', 'treinamentos30', 'treinamentos7', 'treinamentosVencidos'));
    }
}