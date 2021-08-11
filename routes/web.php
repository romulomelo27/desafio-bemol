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
});

Route::prefix('pessoas')->group(function () {

    Route::get('/', [App\Http\Controllers\PessoasController::class, 'index'])->name('pessoas');
    Route::get('/cadastro', [App\Http\Controllers\PessoasController::class, 'viewCadastro'])->name('pessoas.cadastro');
    Route::post('/cadastro', [App\Http\Controllers\PessoasController::class, 'cadastroAdd'])->name('pessoas.cadastro.add');
    Route::get('/editar/{id_pessoa}', [App\Http\Controllers\PessoasController::class, 'viewEditar'])->name('pessoas.editar');
    Route::post('/editar', [App\Http\Controllers\PessoasController::class, 'salvarEdicao'])->name('pessoas.editar.salvar');
});