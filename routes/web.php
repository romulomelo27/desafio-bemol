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
});
