<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\DespesaParcela;
use App\Models\Extrato;
use COM;
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

        $contas = Conta::where('ativo',1)->get();

        return view('contas-pagar.lista', compact('parcelas', 'contas'));
    }

    public function baixarDespesa(Request $request)
    {

        try{

            $baixar = $request->all();

            $parcela = DespesaParcela::join('despesas','despesas.id','=','despesas_parcelas.id_despesa')
            ->select('despesas_parcelas.*','despesas.id_fornecedor', 'despesas.id', 'despesas.id_igreja',
            'despesas.id_categoria')
            ->where('despesas_parcelas.id_despesa',$baixar['id_despesa'])
            ->where('numero',$baixar['numero_parcela'])->first();

            //1º verifico se a conta tem saldo
            $conta = Conta::find($baixar['id_conta']);
            if($conta->saldo < $parcela->total_parcela){

                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Saldo da conta insuficiente',
                        'data' => []
                    ]
                );
            }     

            //2° verifico se a parcela ja foi baixada
            if(!is_null($parcela->data_pagamento)){
                return response()->json(['status'=>false, 'msg'=>'Esse parcela já possui registro de pagamento, atualize sua tela. (F5)']);    
            }
            
            //3° verificar saldo da conta

            DB::beginTransaction();

            //4º baixa a parcela
            DespesaParcela::where('id_despesa',$baixar['id_despesa'])->where('numero',$baixar['numero_parcela'])->update(
                [
                    'data_pagamento'=>$baixar['data_pagamento'],
                    'id_user_baixa' => Auth::user()->id,
                    'id_conta' =>$baixar['id_conta']
                ]
            );

            //5º atualiza saldo conta
            $saldo_atual = 0;
            $saldo_atual = ($conta->saldo - $parcela->total_parcela);
            Conta::find($baixar['id_conta'])->update(['saldo' => $saldo_atual]);

            //6º lanca o extrato
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
                'saldo_anterior'=> $conta->saldo,
                'total' => $parcela->total_parcela,
                'saldo_atual' => $saldo_atual
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
