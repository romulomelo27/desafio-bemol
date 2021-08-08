<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;


class IgrejasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('igrejas.listar');
    }

    public function viewCadastro()
    {
        $estados = Estado::all();
        $cidades = Cidade::all();

        return view('igrejas.cadastro',compact('estados','cidades'));
    }

    public function cadastroAdd(){

        
    }
}
