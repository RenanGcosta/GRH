<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ExameController;
use App\Http\Controllers\FuncExameController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\FuncTreinamentoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TreinamentoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/edit/{id}', [UsuarioController::class,'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UsuarioController::class,'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class,'destroy'])->name('usuarios.destroy');
/*-------------------------------------------------------------------------------------------*/ 
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/auth', [LoginController::class, 'auth'])->name('login.auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
/*-------------------------------------------------------------------------------------------*/ 
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
/*-------------------------------------------------------------------------------------------*/ 
Route::get('/departamento/create', [DepartamentoController::class, 'create'])->name('departamento.create');
Route::post('/departamento', [DepartamentoController::class, 'store'])->name('departamento.store');
Route::get('/departamento', [DepartamentoController::class, 'index'])->name('departamento.index');
Route::get('/departamento/edit/{id}', [DepartamentoController::class,'edit'])->name('departamento.edit');
Route::put('/departamento/{id}', [DepartamentoController::class, 'update'])->name('departamento.update');
Route::delete('/departamento/{id}', [DepartamentoController::class, 'destroy'])->name('departamento.destroy');
/*-------------------------------------------------------------------------------------------*/ 
Route::get('/cargo/create', [CargoController::class, 'create'])->name('cargo.create');
Route::post('/cargo', [CargoController::class, 'store'])->name('cargo.store');
Route::get('/cargo', [CargoController::class, 'index'])->name('cargo.index');
Route::get('/cargo/edit/{id}', [CargoController::class,'edit'])->name('cargo.edit');
Route::put('/cargo/{id}', [CargoController::class, 'update'])->name('cargo.update');
Route::delete('/cargo/{id}', [CargoController::class, 'destroy'])->name('cargo.destroy');
/*-------------------------------------------------------------------------------------------*/
Route::get('/funcionario/create', [FuncionarioController::class, 'create'])->name('funcionario.create');
Route::post('/funcionario', [FuncionarioController::class, 'store'])->name('funcionario.store');
Route::get('/funcionario', [FuncionarioController::class, 'index'])->name('funcionario.index');
Route::get('/funcionario/edit/{id}', [FuncionarioController::class,'edit'])->name('funcionario.edit');
Route::put('/funcionario/{id}', [FuncionarioController::class,'update'])->name('funcionario.update');
Route::delete('/funcionario/{id}', [FuncionarioController::class, 'destroy'])->name('funcionario.destroy');
/*-------------------------------------------------------------------------------------------*/
Route::get('/exame/create', [ExameController::class, 'create'])->name('exame.create');
Route::post('/exame', [ExameController::class, 'store'])->name('exame.store');
Route::get('/exame', [ExameController::class, 'index'])->name('exame.index');
Route::get('/exame/edit/{id}', [ExameController::class,'edit'])->name('exame.edit');
Route::put('/exame/{id}', [ExameController::class,'update'])->name('exame.update');
Route::delete('/exame/{id}', [ExameController::class, 'destroy'])->name('exame.destroy');
/*-------------------------------------------------------------------------------------------*/
Route::get('/treinamento/create', [TreinamentoController::class, 'create'])->name('treinamento.create');
Route::post('/treinamento', [TreinamentoController::class, 'store'])->name('treinamento.store');
Route::get('/treinamento', [TreinamentoController::class, 'index'])->name('treinamento.index');
Route::get('/treinamento/edit/{id}', [TreinamentoController::class,'edit'])->name('treinamento.edit');
Route::put('/treinamento/{id}', [TreinamentoController::class,'update'])->name('treinamento.update');
Route::delete('/treinamento/{id}', [TreinamentoController::class, 'destroy'])->name('treinamento.destroy');
/*-------------------------------------------------------------------------------------------*/
Route::get('/funcExame/create', [FuncExameController::class, 'create'])->name('funcExame.create');
Route::post('/funcExame', [FuncExameController::class, 'store'])->name('funcExame.store');
Route::get('/funcExame', [FuncExameController::class, 'index'])->name('funcExame.index');
Route::get('/funcExame/edit/{id}', [FuncExameController::class,'edit'])->name('funcExame.edit');
Route::put('/funcExame/{id}', [FuncExameController::class,'update'])->name('funcExame.update');
Route::delete('/funcExame/{id}', [FuncExameController::class, 'destroy'])->name('funcExame.destroy');
/*-------------------------------------------------------------------------------------------*/
Route::get('/funcTreinamento/create', [FuncTreinamentoController::class, 'create'])->name('funcTreinamento.create');
Route::post('/funcTreinamento', [FuncTreinamentoController::class, 'store'])->name('funcTreinamento.store');
Route::get('/funcTreinamento', [FuncTreinamentoController::class, 'index'])->name('funcTreinamento.index');
Route::get('/funcTreinamento/edit/{id}', [FuncTreinamentoController::class,'edit'])->name('funcTreinamento.edit');
Route::put('/funcTreinamento/{id}', [FuncTreinamentoController::class,'update'])->name('funcTreinamento.update');
Route::delete('/funcTreinamento/{id}', [FuncTreinamentoController::class, 'destroy'])->name('funcTreinamento.destroy');


Route::get('/verificar-exames/{idFuncionario}', [ExameController::class, 'verificarExamesFuncionario']);
//Route::get('/verificar-exames/{idFuncionario}', 'ExameController@verificarExamesFuncionario');

//Route::get('/verificar-exames/{idFuncionario}', 'ExameController@verificarExamesFuncionario');