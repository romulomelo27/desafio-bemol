<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DespesasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $receitas = Despesa::join('fornecedores','fornecedores.id','=','despesas.id_fornecedor')
                    ->join('igrejas','igrejas.id','=','despesas.id_igreja')
                    ->join('receitas_categorias','receitas_categorias.id','=','despesas.id_categoria')
                    ->select('receitas.*',DB::raw("date_format(despesas.data,'%d/%m/%Y') as data_formatada"),'igrejas.nome_fantasia','pessoas.nome','receitas_categorias.descricao')
                    ->paginate(30);
                        
        return view('despesas.lista', compact('receitas'));        
    }
}
