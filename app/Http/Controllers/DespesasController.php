<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Despesa;
use App\Models\DespesaCategoria;
use App\Models\DespesaParcela;
use App\Models\Extrato;
use App\Models\Fornecedor;
use App\Models\Igreja;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class DespesasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $despesas = Despesa::join('fornecedores','fornecedores.id','=','despesas.id_fornecedor')
                    ->join('igrejas','igrejas.id','=','despesas.id_igreja')
                    ->join('despesas_categorias','despesas_categorias.id','=','despesas.id_categoria')
                    ->select('despesas.*',DB::raw("date_format(despesas.data,'%d/%m/%Y') as data_formatada"),'igrejas.nome_fantasia',DB::raw('fornecedores.nome_fantasia as fornecedor'),'despesas_categorias.descricao')
                    ->paginate(30);
                        
        return view('despesas.lista', compact('despesas'));        
    }

    public function novaDespesaView(){
        
        session()->forget('despesa_parcelas');
        $despesas_categorias = DespesaCategoria::where('ativo','1')->get();
        $fornecedores = Fornecedor::where('ativo','1')->get();
        $igrejas = Igreja::where('ativo','1')->get();
        $contas = Conta::where('ativo','1')->get();
        return view('despesas.cadastro', compact('despesas_categorias','fornecedores','igrejas','contas'));
    }

    public function parcelaAdd(Request $request, GeraisController $geraisController)
    {
        // session()->forget('despesa_parcelas');
        $parcela = $request->all();

        if($parcela['id_conta'] != null){
                
            $conta = Conta::find($parcela['id_conta']);
            $parcela['conta'] = $conta->descricao;

            if($conta->saldo < $parcela['valor_parcela']){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'A conta selecionada não possui saldo suficiente',
                        'data' => []
                    ]
                );
            }
        }
        else{
            
            $parcela['conta'] = '';
        }
        
        //verifico se ja existe sessao
        if (session()->has("despesa_parcelas")) {

            $despesa_parcelas = session('despesa_parcelas');

            $total_parcelas = $this->somaParcelas() + $parcela['valor_parcela'];

            if($total_parcelas > $parcela['valor_documento']){

                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Total parcelas superior ao do Documento',
                        'data' => []
                    ]
                );
            }            
            
            $despesa_parcelas[] = $parcela;
        } 
        else {
            
            $despesa_parcelas[] = $parcela;
        }

        session(["despesa_parcelas" => $despesa_parcelas]);

        return response()->json(
            [
                'status' =>true,
                'msg' => 'Parcela inserida com sucesso',
                'data' => session('despesa_parcelas')              
            ]
        );

    }

    private function somaParcelas()
    {

        $despesa_parcelas = session('despesa_parcelas');

        $total_parcelas = 0;

        foreach ($despesa_parcelas as $parcela) {

            $total_parcelas = $total_parcelas + $parcela['valor_parcela'];
        }

        return $total_parcelas;
    }

    public function deletarParcela(int $key_vetor)
    {
        try{
            $despesa_parcelas = session('despesa_parcelas');

            unset($despesa_parcelas[$key_vetor]);

            $indices_reorganizados = array_values($despesa_parcelas);

            session(["despesa_parcelas" => $indices_reorganizados]);

            return response()->json(
                [
                    'status' => true,
                    'msg' => 'parcela removida com sucesso',
                    'data' => session('despesa_parcelas')
                ]);
        }
        catch(Exception $e){

            return response()->json(
                [
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'data' => session('despesa_parcelas')
                ]);
        }

    }

    public function novaDespesaAdd(Request $request, GeraisController $geraisController)
    {
        $despesa = $request->all();

        $despesa['valor_documento'] = $geraisController->setFormatoAmericano($despesa['valor_documento']);

        $despesa_parcelas = session('despesa_parcelas');

        if ((!session()->has('despesa_parcelas')) || (count($despesa_parcelas) == 0)) {

            return redirect()->back()->with(['status_aviso' => 'Insira pelo menos uma parcela']);
        }
        
        if ( number_format($despesa['valor_documento'],2)  != number_format($this->somaParcelas(),2)) {                        

            return redirect()->back()->with(['status_aviso' => 'O valor das parcelas difere do valor total do documento']);
        }        

        $despesa['id_user'] = Auth::user()->id;
        $despesa['numero_parcelas'] = count($despesa_parcelas);
        $despesa['total'] = $despesa['valor_documento'];

        try {

            DB::beginTransaction();
            // dd($custo);

            //insindo custo
            $set_despesa = Despesa::create($despesa);

            $id_despesa = $set_despesa->id;

            $indice = 1;

            foreach ($despesa_parcelas as $parcela) {

                $parcela['id_despesa'] = $id_despesa;
                $parcela['id_fornecedor'] = $despesa['id_fornecedor'];
                $parcela['numero'] = $indice;
                $parcela['total_parcela'] = $parcela['valor_parcela'];

                //inserindo custo parcelas
                DespesaParcela::create($parcela);

                $indice++;

                if(!is_null($parcela['data_pagamento'])){

                    $saldo_atual = 0;
                    $conta = Conta::find($parcela['id_conta']);
                    $saldo_atual = $conta->saldo - $parcela['total_parcela'];
                    Conta::find($parcela['id_conta'])->update(['saldo' => $saldo_atual]);

                    $extrato = [                
                        'id_lancamento' => $id_despesa,
                        'origem_lancamento' => 'd',
                        'numero_parcela' => $parcela['numero'],             
                        'id_igreja' => $despesa['id_igreja'],
                        'id_pessoa_forn' => $despesa['id_fornecedor'],
                        'id_conta' => $parcela['id_conta'],
                        'id_categoria' => $despesa['id_categoria'],
                        'id_responsavel' => $despesa['id_user'],
                        'valor1' => $parcela['total_parcela'],
                        'valor2' => 0,                
                        'saldo_anterior' => $conta->saldo,
                        'total' => $parcela['total_parcela'],
                        'saldo_atual' => $saldo_atual
                    ];
                    
                    Extrato::create($extrato);
                }
            }

            Log::info("Nova despesa cadastrado com sucesso.");

            session()->forget('despesa_parcelas');

            DB::commit();

            return redirect()->route('despesas.cadastro')->with(['status_sucesso' => 'Despesa cadastrada com sucesso']);
        } catch (Exception $e) {

            Log::error("Erro ao cadastrar despesa. Error: " . $e->getMessage());

            DB::rollBack();

            return redirect()->route('despesas.cadastro')->with(['status_error' => 'Erro ao cadastrar:' . $e->getMessage()]);
        }

    }

    public function viewDespesaEditar(int $id_despesa)
    {
        $despesas_categorias = DespesaCategoria::where('ativo','1')->get();
        $fornecedores = Fornecedor::where('ativo','1')->get();
        $igrejas = Igreja::where('ativo','1')->get();
        $contas = Conta::where('ativo','1')->get();
        $despesa = Despesa::find($id_despesa);
        $despesa_parcelas = DespesaParcela::where('id_despesa',$id_despesa)->get();
        $array_parcelas = $this->montarVetorParcelasEdicao($despesa_parcelas);
        session(['despesa_parcelas'=>$array_parcelas]);
        return view('despesas.editar', compact('despesa','despesas_categorias','fornecedores','igrejas','contas','array_parcelas'));
    }
    
    private function montarVetorParcelasEdicao($parcelas)
    {

        foreach ($parcelas as $parcela) {            

            $parc = [
                'numero'     => $parcela->numero,
                'valor_parcela'      => $parcela->valor_parcela,
                'data_vencimento' => $parcela->data_vencimento,
                'data_pagamento'  => $parcela->data_pagamento,
                'id_conta'  => $parcela->id_conta
            ];

            if($parc['id_conta'] != null){
                
                $conta = Conta::find($parcela['id_conta']);
                $parc['conta'] = $conta->descricao;
            }
            else{
                
                $parc['conta'] = '';
            }

            $array_parcelas[] = $parc;
        }

        return $array_parcelas;
    }

    public function salvarEdicao(Request $request, GeraisController $geraisController){

        $despesa = $request->except('_token');

        $despesa['valor_documento'] = $geraisController->setFormatoAmericano($despesa['valor_documento']);
        $despesa['total'] = $despesa['valor_documento'];

        $despesa_parcelas = session('despesa_parcelas');

        if ((!session()->has('despesa_parcelas')) || (count($despesa_parcelas) == 0)) {

            return redirect()->back()->with(['status_aviso' => 'Insira pelo menos uma parcela']);
        }

    
        if ( number_format($despesa['valor_documento'],2)  != number_format($this->somaParcelas(),2)) {                        

            return redirect()->back()->with(['status_aviso' => 'O valor das parcelas difere do valor total do documento']);
        }


        $despesa['id_user'] = Auth::user()->id;

        try {

            DB::beginTransaction();
            // dd($custo);

            Despesa::find($despesa['id'])->update($despesa);

            //crio indice para contar numerar parcelas
            $indice = 1;

            //removo as parcelas
            DespesaParcela::where('id_despesa', $despesa['id'])->where('id_despesa', $despesa['id'])->delete();
            Extrato::where('id_lancamento',$despesa['id'])->where('origem_lancamento','d')->update(['estornado'=>1]);

            foreach ($despesa_parcelas as $parcela) {

                $parcela['id_despesa'] = $despesa['id'];
                $parcela['id_fornecedor'] = $despesa['id_fornecedor'];
                $parcela['numero'] = $indice;
                $parcela['total_parcela'] = $parcela['valor_parcela'];

                DespesaParcela::create($parcela);

                $indice++;

                if(!is_null($parcela['data_pagamento'])){
                    $extrato = [                
                        'id_lancamento' => $despesa['id'],
                        'origem_lancamento' => 'd',         
                        'numero_parcela' => $parcela['numero'],       
                        'id_igreja' => $despesa['id_igreja'],
                        'id_pessoa_forn' => $despesa['id_fornecedor'],
                        'id_conta' => $parcela['id_conta'],
                        'id_categoria' => $despesa['id_categoria'],
                        'id_responsavel' => $despesa['id_user'],
                        'valor1' => $parcela['total_parcela'],
                        'valor2' => 0,                
                        'total' => $parcela['total_parcela']               
                    ];
                    
                    Extrato::create($extrato);
                }
            }

            Log::info("Despesa editada com sucesso {$despesa['id']}");

            session()->forget('despesa_parcelas');

            DB::commit();

            return redirect()->route('despesas.editar',['id_despesa'=>$despesa['id']])->with(['status_sucesso' => 'Despesa editada com sucesso']);
        } catch (Exception $e) {

            Log::error("Erro ao editar despesa. Error: " . $e->getMessage());

            DB::rollBack();

            return redirect()->route('despesas.editar',['id_despesa'=>$despesa['id']])->with(['status_error' => 'Erro ao editar despesa. Erro:'.$e->getMessage()]);
        }

    }

    public function despesaImpressao(int $id_despesa)
    {
        $despesa = Despesa::join('fornecedores','fornecedores.id','=','despesas.id_fornecedor')
                    ->join('igrejas','igrejas.id','=','despesas.id_igreja')
                    ->join('despesas_categorias','despesas_categorias.id','=','despesas.id_categoria')
                    ->join('users','users.id','=','despesas.id_user')
                    ->select('despesas.*',DB::raw("date_format(despesas.data,'%d/%m/%Y') as data_formatada"),'igrejas.nome_fantasia','fornecedores.nome_fantasia as fornecedor',
                    'despesas_categorias.descricao', 'users.name as resp_lancamento')
                    ->find($id_despesa);
        
        $despesa_parcelas = DespesaParcela::leftJoin('contas','contas.id','=','despesas_parcelas.id_conta')
        ->select('despesas_parcelas.*','contas.descricao')->where('id_despesa', $id_despesa)->get();

        $pdf = PDF::loadView('despesas.impressao-detalhes-pdf', compact('despesa','despesa_parcelas'));//->setPaper('a4', 'landscape');
        return $pdf->stream('despesa-detalhes-' . date('d_m_Y') . '.pdf');
    }

    public function listaContasPagar()
    {
        
    }
}
