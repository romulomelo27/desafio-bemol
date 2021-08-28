<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Fornecedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class FornecedoresController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $fornecedores = Fornecedor::all();        
        return view('fornecedores.listar', compact('fornecedores'));
    }

    public function viewCadastro()
    {
        $estados = Estado::all();        

        return view('fornecedores.cadastro',compact('estados'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $cadastro['documento'] = $this->removeMascara($cadastro['documento']);
            $cadastro['cep'] = $this->removeMascara($cadastro['cep']);
            $setFornecedor = Fornecedor::create($cadastro);
            Log::info("Novo fornecedor cadastrado. Id: ".$setFornecedor->id." Por: ". Auth::user()->name);
            return redirect()->route('fornecedores.cadastro')->with(['status_sucesso'=>'Fornecedor cadastrado com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao cadastrar novo Fornecedor. Erro: ". $e->getMessage());
            return redirect()->route('fornecedores.cadastro')->with(['status_error'=>'Erro ao cadastrar novo fornecedor'.$e->getMessage()]);
        }

    }

    public function viewEditar(int $id_fornecedor){

        $estados = Estado::all();
        $cidades = Cidade::all();        
        $fornecedor  = Fornecedor::find($id_fornecedor);  

        return view('fornecedores.editar',compact('estados','cidades','fornecedor'));
    }

    public function salvarEdicao(Request $resquest){

        try{
            $editar = $resquest->except('_token');
            $editar['documento'] = $this->removeMascara($editar['documento']);
            $editar['cep'] = $this->removeMascara($editar['cep']);            
            Fornecedor::find($editar['id'])->update($editar);
            Log::info("Fornecedor editado. Id: ".$editar['id']." Por: ". Auth::user()->name);
            return redirect()->route('fornecedores.editar',['id_fornecedor'=>$editar['id']])->with(['status_sucesso'=>'Fornecedor editado com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao editar fornecedor. Erro: ". $e->getMessage());
            return redirect()->route('fornecedores.editar',['id_fornecedor'=>$editar['id']])->with(['status_error'=>'Erro ao editar fornecedor'.$e->getMessage()]);
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

    public function getDetalhesImpressao(int $id_fornecedor)
    {
        $fornecedor = Fornecedor::join('estados','fornecedores.id_estado','=','estados.id')
        ->join('cidades','fornecedores.id_cidade','=','cidades.id')
        ->select('fornecedores.*',DB::raw('estados.nome as estado'), DB::raw('cidades.nome as cidade'))
        ->where('fornecedores.id',$id_fornecedor)->first();
        $pdf = PDF::loadView('fornecedores.detalhes-impressao-pdf', compact('fornecedor'));
        return $pdf->stream('detalhes-fornecedor' . date('d_m_Y') . '.pdf');
    }

    public function listaImpressao(Request $resquest)
    {
        $fornecedores = Fornecedor::join('estados','fornecedores.id_estado','=','estados.id')
        ->join('cidades','fornecedores.id_cidade','=','cidades.id')
        ->select('fornecedores.*',DB::raw('estados.nome as estado'), DB::raw('cidades.nome as cidade'))
        ->get();
        $pdf = PDF::loadView('fornecedores.lista-impressao-pdf', compact('fornecedores'))->setPaper('a4', 'landscape');
        return $pdf->stream('lista-de-fornecedores' . date('d_m_Y') . '.pdf');
    }
}
