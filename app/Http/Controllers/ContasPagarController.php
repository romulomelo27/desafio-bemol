<?php

namespace App\Http\Controllers;

use App\Models\DespesaParcela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContasPagarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $parcelas = DespesaParcela::join('despesas','despesas.id','=','despesas_parcelas.id_despesa')
        ->join('fornecedores','fornecedores.id','=','despesas.id_fornecedor')
        ->select('despesas_parcelas.*','fornecedores.nome_fantasia as fornecedor','despesas.numero_documento',DB::raw("date_format(data_vencimento,'%d/%m/%Y') vencimento_formatado"),
        DB::raw("date_format(data_pagamento,'%d/%m/%Y') pagamento_formatado"))
        ->paginate();

        // dd($parcelas);

        return view('contas-pagar.lista', compact('parcelas'));
    }
}
