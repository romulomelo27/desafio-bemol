<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Igreja;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

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
        $pessoas = Pessoa::all();

        return view('igrejas.cadastro',compact('estados','pessoas'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $cadastro['cnpj'] = $this->removeMascara($cadastro['cnpj']);
            $cadastro['cep'] = $this->removeMascara($cadastro['cep']);
            $setIgreja = Igreja::create($cadastro);
            Log::info("Nova Igreja cadastra. Id: ".$setIgreja->id." Por: ". Auth::user()->name);
            return redirect()->route('igrejas.cadastro')->with(['status_sucesso'=>'Igreja cadastrada com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao cadastrar nova igreja. Erro: ". $e->getMessage());
            return redirect()->route('igrejas.cadastro')->with(['status_error'=>'Erro ao cadastrar nova igreja'.$e->getMessage()]);
        }

    }

    public function viewEditar(int $id_igreja){

        $estados = Estado::all();
        $cidades = Cidade::all();
        $pessoas = Pessoa::all();
        $igreja  = Igreja::find($id_igreja);  

        return view('igrejas.editar',compact('estados','cidades','pessoas','igreja'));
    }

    public function salvarEdicao(Request $resquest){

        try{
            $editar = $resquest->except('_token');
            $editar['cnpj'] = $this->removeMascara($editar['cnpj']);
            $editar['cep'] = $this->removeMascara($editar['cep']);            
            Igreja::find($editar['id'])->update($editar);
            Log::info("Igreja editada. Id: ".$editar['id']." Por: ". Auth::user()->name);
            return redirect()->route('igrejas.editar',['id_igreja'=>$editar['id']])->with(['status_sucesso'=>'Igreja editada com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao edita igreja. Erro: ". $e->getMessage());
            return redirect()->route('igrejas.editar',['id_igreja'=>$editar['id']])->with(['status_error'=>'Erro ao editar igreja'.$e->getMessage()]);
        }

    }
    private function removeMascara($var){

        $var = str_replace('.','',$var);
        $var = str_replace('-','',$var);
        $var = str_replace('/','',$var);

        return $var;
    }

    public function getCidades(int $id_estado)
    {
        try{
            $cidades = Cidade::where('id_estado', $id_estado)->orderBy('nome')->get();
            return response()->json($cidades);
        }
        catch(Exception $e){

            return response()->json(['erro'=>$e->getMessage()]);
        }
    }

    public function getDetalhesImpressao(int $id_igreja)
    {
        $igreja = Igreja::join('estados','igrejas.id_estado','=','estados.id')
        ->join('cidades','igrejas.id_cidade','=','cidades.id')
        ->select('igrejas.*',DB::raw('estados.nome as estado'), DB::raw('cidades.nome as cidade'))
        ->where('igrejas.id',$id_igreja)->first();
        $pdf = PDF::loadView('igrejas.detalhes-impressao-pdf', compact('igreja'));
        return $pdf->stream('detalhes-igreja' . date('d_m_Y') . '.pdf');
    }

    public function listaImpressao(Request $resquest)
    {
        $igrejas = Igreja::join('estados','igrejas.id_estado','=','estados.id')
        ->join('cidades','igrejas.id_cidade','=','cidades.id')
        ->select('igrejas.*',DB::raw('estados.nome as estado'), DB::raw('cidades.nome as cidade'))
        ->get();
        $pdf = PDF::loadView('igrejas.lista-impressao-pdf', compact('igrejas'))->setPaper('a4', 'landscape');
        return $pdf->stream('detalhes-igreja' . date('d_m_Y') . '.pdf');
    }
}
