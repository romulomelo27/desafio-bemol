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

Route::prefix('igrejas')->group(function () {

    Route::get('/', [App\Http\Controllers\IgrejasController::class, 'index'])->name('igrejas');
    Route::get('/cadastro', [App\Http\Controllers\IgrejasController::class, 'viewCadastro'])->name('igrejas.cadastro');
    Route::post('/cadastro', [App\Http\Controllers\IgrejasController::class, 'cadastroAdd'])->name('igrejas.cadastro.add');
    Route::get('/editar/{id_igreja}', [App\Http\Controllers\IgrejasController::class, 'viewEditar'])->name('igrejas.editar');
    Route::post('/editar', [App\Http\Controllers\IgrejasController::class, 'salvarEdicao'])->name('igrejas.editar.salvar');
    Route::get('/get-cidades/{id_estado}', [App\Http\Controllers\IgrejasController::class, 'getCidades'])->name('igrejas.cidade');
    Route::get('/impressao-detalhes/{id_igreja}', [App\Http\Controllers\IgrejasController::class, 'getDetalhesImpressao'])->name('igrejas.detalhes.impressao');
    Route::get('/impressao-lista', [App\Http\Controllers\IgrejasController::class, 'listaImpressao'])->name('igrejas.lista.impressao');

});

Route::prefix('pessoas')->group(function () {

    Route::get('/', [App\Http\Controllers\PessoasController::class, 'index'])->name('pessoas');
    Route::get('/cadastro', [App\Http\Controllers\PessoasController::class, 'viewCadastro'])->name('pessoas.cadastro');
    Route::post('/cadastro', [App\Http\Controllers\PessoasController::class, 'cadastroAdd'])->name('pessoas.cadastro.add');
    Route::get('/editar/{id_pessoa}', [App\Http\Controllers\PessoasController::class, 'viewEditar'])->name('pessoas.editar');
    Route::post('/editar', [App\Http\Controllers\PessoasController::class, 'salvarEdicao'])->name('pessoas.editar.salvar');
    Route::get('/foto-perfil/{id_pessoa}', [App\Http\Controllers\PessoasController::class, 'viewFotoPefil'])->name('pessoas.foto.perfil');
    Route::post('/foto-perfil', [App\Http\Controllers\PessoasController::class, 'fotoPefilSalvar'])->name('pessoas.foto.salvar');
    Route::get('/impressao-detalhes/{id_pessoa}', [App\Http\Controllers\PessoasController::class, 'getDetalhesImpressao'])->name('pessoas.detalhes.impressao');
    Route::get('/impressao-lista', [App\Http\Controllers\PessoasController::class, 'listaImpressao'])->name('pessoas.lista.impressao');
    Route::get('/atribuicoes/{id_pessoa}', [App\Http\Controllers\PessoasController::class, 'atribuicoesView'])->name('pessoas.atribuicoes');
    Route::post('/atribuicoes', [App\Http\Controllers\PessoasController::class, 'atribuicoesSalvar'])->name('pessoas.atribuicoes.salvar');
});

Route::prefix('receitas')->group(function () {

    Route::get('/', [App\Http\Controllers\ReceitasController::class, 'index'])->name('receitas');
    Route::get('/novo-lancamento', [App\Http\Controllers\ReceitasController::class, 'novaReceitaView'])->name('receitas.cadastro');
    Route::post('/novo-lancamento', [App\Http\Controllers\ReceitasController::class, 'novaReceitaSalvar'])->name('receitas.cadastro.salvar');
    Route::get('/get-membros/{id_igreja}', [App\Http\Controllers\ReceitasController::class, 'getMembros'])->name('receitas.get.membros');
    Route::get('/editar/{id_receita}', [App\Http\Controllers\ReceitasController::class, 'editarReceitarView'])->name('receitas.editar');
    Route::post('/editar', [App\Http\Controllers\ReceitasController::class, 'editarReceitaSalvar'])->name('receitas.editar.salvar');
});