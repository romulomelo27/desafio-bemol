<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\Igreja;
use App\Models\Pessoa;
use App\Models\Receita;
use App\Models\ReceitaTipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    ->join('receitas_tipos','receitas_tipos.id','=','receitas.id_tipo')
                    ->select('receitas.*','igrejas.razao_social','pessoas.nome','receitas_tipos.descricao')
                    ->paginate(30);
                        
        return view('receitas.lista', compact('receitas'));
    }

    public function novaReceitaView()
    {
        $igrejas = Igreja::where('ativo','1')->get();
        $receitas_tipos = ReceitaTipo::where('ativo',1)->get();
        $contas = Conta::where('ativo',1)->get();        

        return view('receitas.cadastro',compact('igrejas','receitas_tipos','contas'));
    }

    public function novaReceitaSalvar(Request $request, GeraisController $geraisController)
    {   
        try{
            $lancamento = $request->all();
            $valor1 = $geraisController->setFormatoAmericano($lancamento['valor1']);
            $lancamento['valor1'] = $valor1;
            $lancamento['id_user'] = Auth::user()->id;

            if($lancamento['id_tipo'] == 1){
                
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

            $setLancamento = Receita::create($lancamento);

            Log::info("Novo lançamento de receita realizada. Id receita: " . $setLancamento->id);

            return redirect()->route('receitas.cadastro')->with(['status_sucesso' => 'Lançamento realizado com sucesso!']);
        }
        catch(Exception $e){

            Log::error("Erro ao realizado lancamento. Erro: ".$e->getMessage());
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
}
