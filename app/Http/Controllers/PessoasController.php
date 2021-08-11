<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Igreja;
use App\Models\Pessoa;
use App\Models\PessoaTipo;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PessoasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pessoas = Pessoa::all();        
        return view('pessoas.listar', compact('pessoas'));
    }

    public function viewCadastro()
    {
        $estados = Estado::all();
        $cidades = Cidade::all();
        $pessoas = Pessoa::all();
        $igrejas = Igreja::all();

        return view('pessoas.cadastro',compact('estados','cidades','pessoas','igrejas'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $cadastro['cpf'] = $this->removeMascara($cadastro['cpf']);
            $cadastro['rg'] = $this->removeMascara($cadastro['rg']);
            $cadastro['cep'] = $this->removeMascara($cadastro['cep']);
            $setPessoa = Pessoa::create($cadastro);
            Log::info("Nova pessoa cadastra. Id: ".$setPessoa->id." Por: ". Auth::user()->name);
            return redirect()->route('pessoas.cadastro')->with(['status_sucesso'=>'Igreja pessoa com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao cadastrar nova pessoa. Erro: ". $e->getMessage());
            return redirect()->route('pessoas.cadastro')->with(['status_error'=>'Erro ao cadastrar nova pessoa'.$e->getMessage()]);
        }

    }

    public function viewEditar(int $id_pessoa){

        $estados = Estado::all();
        $cidades = Cidade::all();
        $pessoa = Pessoa::find($id_pessoa);
        $igrejas  = Igreja::all();  

        return view('pessoas.editar',compact('estados','cidades','pessoa','igrejas'));
    }

    public function salvarEdicao(Request $resquest){

        try{
            $editar = $resquest->except('_token');
            $editar['cpf'] = $this->removeMascara($editar['cpf']);
            $editar['rg'] = $this->removeMascara($editar['rg']);
            $editar['cep'] = $this->removeMascara($editar['cep']);
            Pessoa::find($editar['id'])->update($editar);
            Log::info("Pessoa editada. Id: ".$editar['id']." Por: ". Auth::user()->name);
            return redirect()->route('pessoas.editar',['id_pessoa'=>$editar['id']])->with(['status_sucesso'=>'Pessoa editada com sucesso']);
        }
        catch(Exception $e){

            Log::erro("Erro ao edita pessoa. Erro: ". $e->getMessage());
            return redirect()->route('pessoas.editar',['id_pessoa'=>$editar['id']])->with(['status_error'=>'Erro ao editar pessoa'.$e->getMessage()]);
        }

    }

    private function removeMascara($var){

        $var = str_replace('.','',$var);
        $var = str_replace('-','',$var);

        return $var;
    }
}
