<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filtroDespesa(){

        return view('relatorios.filtro-despesa');
    }
}
