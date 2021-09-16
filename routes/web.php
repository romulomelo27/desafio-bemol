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

        
    Route::get('/editar', [App\Http\Controllers\UsersController::class, 'viewEditar'])->name('perfil.editar');
    Route::post('/editar', [App\Http\Controllers\UsersController::class, 'salvarEdicao'])->name('perfil.editar.salvar');
    Route::get('/foto-perfil', [App\Http\Controllers\UsersController::class, 'viewFotoPefil'])->name('perfil.foto.perfil');
    Route::post('/foto-perfil', [App\Http\Controllers\UsersController::class, 'fotoPefilSalvar'])->name('perfil.foto.salvar');    
    Route::get('/consultar-cpf/{cpf}', [App\Http\Controllers\UsersController::class, 'consultarCPF'])->name('perfil.consultar.cpf');
    
});
