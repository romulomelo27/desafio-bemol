<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Extrato;
use App\Models\Igreja;
use App\Models\Pessoa;
use App\Models\Receita;
use App\Models\ReceitaCategoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $receitas = Receita::join('pessoas','pessoas.id','=','receitas.id_pessoa')
                    ->join('igrejas','igrejas.id','=','receitas.id_igreja')
                    ->join('receitas_categorias','receitas_categorias.id','=','receitas.id_categoria')
                    ->select('receitas.*',DB::raw("date_format(receitas.data,'%d/%m/%Y') as data_formatada"),'igrejas.razao_social','pessoas.nome','receitas_categorias.descricao')
                    ->paginate(30);
                        
        return view('receitas.lista', compact('receitas'));
    }

    public function novaReceitaView()
    {
        $igrejas = Igreja::where('ativo','1')->get();
        $receitas_categorias = ReceitaCategoria::where('ativo',1)->get();
        $contas = Conta::where('ativo',1)->get();        

        return view('receitas.cadastro',compact('igrejas','receitas_categorias','contas'));
    }

    public function novaReceitaSalvar(Request $request, GeraisController $geraisController)
    {   
        try{
            $lancamento = $request->all();
            $valor1 = $geraisController->setFormatoAmericano($lancamento['valor1']);
            $lancamento['valor1'] = $valor1;
            $lancamento['id_user'] = Auth::user()->id;

            if($lancamento['id_categoria'] == 1){
                
                $valor2 = $geraisController->setFormatoAmericano($lancamento['valor2']);            
                $lancamento['valor2'] = $valor2;
                $lancamento['total'] = $valor1 + $valor2;
            }
            else{
                $lancamento['total'] = $valor1;
            }

            if($lancamento['total'] == 0){
                $request->flash();
                return redirect()->back()->with(['status_aviso' => 'O valor do lançamento não pode ser zero']);
            }

            DB::beginTransaction();

            $setLancamento = Receita::create($lancamento);

            $extrato = [                
                'id_lancamento' => $setLancamento->id,
                'origem_lancamento' => 'r',                
                'id_igreja' => $lancamento['id_igreja'],
                'id_pessoa_forn' => $lancamento['id_pessoa'],
                'id_conta' => $lancamento['id_conta'],
                'id_categoria' => $lancamento['id_categoria'],
                'id_responsavel' => $lancamento['id_user'],
                'valor1' => $lancamento['valor1'],
                'valor2' => $lancamento['id_categoria'] == '1' ? $lancamento['valor2'] : 0,                
                'total' => $lancamento['total'],                
            ];

            Extrato::create($extrato);

            DB::commit();

            Log::info("Novo lançamento de receita realizada. Id receita: " . $setLancamento->id);

            return redirect()->route('receitas.cadastro')->with(['status_sucesso' => 'Lançamento realizado com sucesso!']);
        }
        catch(Exception $e){

            DB::rollBack();
            Log::error("Erro não realizado lancamento. Erro: ".$e->getMessage());
            return redirect()->route('receitas.cadastro')->with(['status_error' => 'Erro: '. $e->getMessage()]);
        }
    }

    public function getMembros(int $id_igreja)
    {
        try{
            $membro = Pessoa::where('id_igreja', $id_igreja)->where('tipo','m')->orderBy('nome')->get();
            return response()->json($membro);
        }
        catch(Exception $e){

            response()->json(['error'=>'erro : '. $e->getMessage()]);
        }
    }

    public function editarReceitarView(int $id_receita){

        $receita = Receita::find($id_receita);
        $igrejas = Igreja::where('ativo','1')->get();
        $receitas_categorias = ReceitaCategoria::where('ativo',1)->get();
        $contas = Conta::where('ativo',1)->get();
        $membros = Pessoa::where('id_igreja', $receita->id_igreja)->where('tipo','m')->orderBy('nome')->get();

        return view('receitas.editar', compact('receita','igrejas','receitas_categorias','contas','membros'));
    }

    public function editarReceitaSalvar(Request $request, GeraisController $geraisController)
    {        
        try{

            $lancamento = $request->except('_token');
            $valor1 = $geraisController->setFormatoAmericano($lancamento['valor1']);
            $lancamento['valor1'] = $valor1;
            $lancamento['id_user'] = Auth::user()->id;

            if($lancamento['id_categoria'] == 1){
                
                $valor2 = $geraisController->setFormatoAmericano($lancamento['valor2']);            
                $lancamento['valor2'] = $valor2;
                $lancamento['total'] = $valor1 + $valor2;
            }
            else{
                $lancamento['total'] = $valor1;
            }

            if($lancamento['total'] == 0){
                $request->flash();
                return redirect()->back()->with(['status_aviso' => 'O valor do lançamento não pode ser zero']);
            }

            DB::beginTransaction();

            Receita::where('id',$lancamento['id'])->update($lancamento);

            Extrato::where('id_lancamento',$lancamento['id'])
            ->where('origem_lancamento','r')
            ->update(['estornado'=>1]);

            $extrato = [                
                'id_lancamento' => $lancamento['id'],
                'origem_lancamento' => 'r',                
                'id_igreja' => $lancamento['id_igreja'],
                'id_pessoa_forn' => $lancamento['id_pessoa'],
                'id_conta' => $lancamento['id_conta'],
                'id_categoria' => $lancamento['id_categoria'],
                'id_responsavel' => $lancamento['id_user'],
                'valor1' => $lancamento['valor1'],
                'valor2' => $lancamento['id_categoria'] == '1' ? $lancamento['valor2'] : 0,                
                'total' => $lancamento['total'],                
            ];

            Extrato::create($extrato);

            DB::commit();

            Log::info("Lançamento de receita editada com sucesso. Id receita: " . $lancamento['id']);

            return redirect()->route('receitas.editar',['id_receita'=>$lancamento['id']])->with(['status_sucesso' => 'Lançamento editado com sucesso!']);
        }
        catch(Exception $e){

            DB::rollBack();
            Log::error("Erro ao realizar edição. Erro: ".$e->getMessage());
            return redirect()->route('receitas.cadastro')->with(['status_error' => 'Erro: '. $e->getMessage()]);
        }
    }
}
