<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuncionarioExame;
use App\Models\FuncionarioTreinamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $hojeSemHora = Carbon::now()->toDateString();

        $periodo30diasExame = Carbon::now()->addDays(30)->toDateString();
        $exames30 = FuncionarioExame::whereBetween('data_validade', [$hojeSemHora, $periodo30diasExame])
            ->whereNotBetween('data_validade', [$hojeSemHora, Carbon::now()->addDays(7)->toDateString()]) // Exclui os exames que faltam 7 dias ou menos
            ->orderBy('data_validade', 'asc')
            ->get();

        $periodo7diasExame = Carbon::now()->addDays(7)->toDateString();
        $exames7 = FuncionarioExame::whereBetween('data_validade', [$hojeSemHora, $periodo7diasExame])
            ->orderBy('data_validade', 'asc')
            ->get();

        $examesVencidos = FuncionarioExame::where('data_validade', '<', $hojeSemHora)
            ->orderBy('data_validade', 'asc')
            ->get();

        /*-------------------------------------------------------------------------------------------*/
        /*-------------------------------------------------------------------------------------------*/
        /*-------------------------------------------------------------------------------------------*/

        $periodo30diasTreinamento = Carbon::now()->addDays(30)->toDateString();
        $treinamentos30 = FuncionarioTreinamento::whereBetween('data_validade', [$hojeSemHora, $periodo30diasTreinamento])
            ->whereNotBetween('data_validade', [$hojeSemHora, Carbon::now()->addDays(7)->toDateString()]) // Exclui os exames que faltam 7 dias ou menos
            ->orderBy('data_validade', 'asc')
            ->get();

        $periodo7diasTreinamento = Carbon::now()->addDays(7)->toDateString();
        $treinamentos7 = FuncionarioTreinamento::whereBetween('data_validade', [$hojeSemHora, $periodo7diasTreinamento])
            ->orderBy('data_validade', 'asc')
            ->get();

        $treinamentosVencidos = FuncionarioTreinamento::where('data_validade', '<', $hojeSemHora)
            ->orderBy('data_validade', 'asc')
            ->get();

        // dd($hojeSemHora, $examesVencidos);

        return view('dashboard.index', compact('exames30', 'exames7', 'examesVencidos', 'treinamentos30', 'treinamentos7', 'treinamentosVencidos'));
    }
}