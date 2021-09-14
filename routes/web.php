<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('perfil')->group(function () {

    Route::get('/', [App\Http\Controllers\ClientesController::class, 'index'])->name('pessoas');
    Route::get('/cadastro', [App\Http\Controllers\ClientesController::class, 'viewCadastro'])->name('pessoas.cadastro');
    Route::post('/cadastro', [App\Http\Controllers\ClientesController::class, 'cadastroAdd'])->name('pessoas.cadastro.add');
    Route::get('/editar/{id_pessoa}', [App\Http\Controllers\ClientesController::class, 'viewEditar'])->name('pessoas.editar');
    Route::post('/editar', [App\Http\Controllers\ClientesController::class, 'salvarEdicao'])->name('pessoas.editar.salvar');
    Route::get('/foto-perfil/{id_pessoa}', [App\Http\Controllers\ClientesController::class, 'viewFotoPefil'])->name('pessoas.foto.perfil');
    Route::post('/foto-perfil', [App\Http\Controllers\ClientesController::class, 'fotoPefilSalvar'])->name('pessoas.foto.salvar');
    Route::get('/impressao-detalhes/{id_pessoa}', [App\Http\Controllers\ClientesController::class, 'getDetalhesImpressao'])->name('pessoas.detalhes.impressao');
    Route::get('/impressao-lista', [App\Http\Controllers\ClientesController::class, 'listaImpressao'])->name('pessoas.lista.impressao');
    Route::get('/atribuicoes/{id_pessoa}', [App\Http\Controllers\ClientesController::class, 'atribuicoesView'])->name('pessoas.atribuicoes');
    Route::post('/atribuicoes', [App\Http\Controllers\ClientesController::class, 'atribuicoesSalvar'])->name('pessoas.atribuicoes.salvar');
});
