<?php

namespace App\Http\Controllers;

use App\Models\DespesaParcela;
use App\Models\Extrato;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        ->paginate(20);

        return view('contas-pagar.lista', compact('parcelas'));
    }

    public function baixarDespesa(Request $request)
    {

        try{

            $baixar = $request->all();

            $parcela = DespesaParcela::join('despesas','despesas.id','=','despesas_parcelas.id_despesa')
            ->select('despesas_parcelas.*','despesas.id_fornecedor')->where('parcelas_despesas.id_despesa',$baixar['id_despesa'])->where('numero',$baixar['numero_parcela'])->first();

            //1° verifico se a parcela ja foi baixada
            if(!is_null($parcela->data_pagamento)){
                return response()->json(['status'=>false, 'msg'=>'Esse parcela já possui registro de pagamento, atualize sua tela. (F5)']);    
            }
            
            //2° verificar saldo da conta

            DB::beginTransaction();

            DespesaParcela::where('id_despesa',$baixar['id_despesa'])->where('numero',$baixar['numero_parcela'])->update(
                [
                    'data_pagamento'=>$baixar['data_pagamento'],
                    'id_user_baixa' => Auth::user()->id
                ]
            );

            $extrato = [                
                'id_lancamento' => $parcela->id, //id da despesa
                'origem_lancamento' => 'd',
                'numero_parcela' => $parcela->numero,                
                'id_igreja' => $parcela->id_igreja,
                'id_pessoa_forn' => $parcela->id_fornecedor,
                'id_conta' => $baixar['id_conta'],
                'id_categoria' => $parcela->id_categoria,
                'id_responsavel' => Auth::user()->id,
                'valor1' => $parcela->total_parcela,
                'valor2' => 0,                
                'total' => $parcela->total_parcela
            ];

            Extrato::create($extrato);

            DB::commit();

            Log::info("Despesa paga, parcela {$baixar['numero_parcela']}, despesa {$baixar['id_despesa']} pelo usuario: ". Auth::user()->name);

            $data = date_create($baixar['data_pagamento']);
            $data_pagamento = date_format($data,'d/m/Y'); 
            return response()->json(
                [
                    'status'=>true, 
                    'msg'=>'Baixa realizada com sucesso',
                    'data_pagamento' => $data_pagamento
                ]);
        }
        catch(Exception $e){

            DB::rollBack();
            Log::error("Falha ao realizar pagamento erro: " .$e->getMessage());
            return response()->json(['status'=>false, 'msg'=> $e->getMessage()]);
        }
        
    }
}
