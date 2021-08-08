<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Igreja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IgrejasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $igrejas = Igreja::all();
        return view('igrejas.listar', compact('igrejas'));
    }

    public function viewCadastro()
    {
        $estados = Estado::all();
        $cidades = Cidade::all();

        return view('igrejas.cadastro',compact('estados','cidades'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $setIgreja = Igreja::create($cadastro);
            Log::info("Nova Igreja cadastra. Id: ".$setIgreja->id." Por: ". Auth::user()->name);
            return redirect()->route('igrejas.cadastro')->with(['status_sucesso'=>'Igreja cadastrada com sucesso']);
        }
        catch(Exception $e){

            Log::erro("Erro ao cadastrar nova igreja. Erro: ". $e->getMessage());
            return redirect()->route('igrejas.cadastro')->with(['status_error'=>'Erro ao cadastrar nova igreja'.$e->getMessage()]);
        }

    }
}
