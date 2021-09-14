<?php

namespace App\Http\Controllers;

use App\Models\Atribuicoes;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Igreja;
use App\Models\Pessoa;
use App\Models\PessoaAtribuicoes;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $pessoas = DB::table('pessoas')->join('igrejas','igrejas.id','=','pessoas.id_igreja')->select('pessoas.*','igrejas.nome_fantasia')->paginate(20);
    //     return view('pessoas.listar', compact('pessoas'));
    // }

    public function viewCadastro()
    {
        $estados = Estado::all();
        $pessoas = Cliente::all();        

        return view('pessoas.cadastro',compact('estados','pessoas'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $cadastro['cpf'] = $this->removeMascara($cadastro['cpf']);
            $cadastro['rg'] = $this->removeMascara($cadastro['rg']);
            $cadastro['cep'] = $this->removeMascara($cadastro['cep']);
            $setPessoa = Cliente::create($cadastro);
            Log::info("Nova pessoa cadastra. Id: ".$setPessoa->id." Por: ". Auth::user()->name);
            return redirect()->route('pessoas.cadastro')->with(['status_sucesso'=>'Pessoa cadastrada com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao cadastrar nova pessoa. Erro: ". $e->getMessage());
            return redirect()->route('pessoas.cadastro')->with(['status_error'=>'Erro ao cadastrar nova pessoa'.$e->getMessage()]);
        }

    }

    public function viewEditar(int $id_pessoa){

        $estados = Estado::all();
        $cidades = Cidade::all();
        $cliente = Cliente::find($id_pessoa);        

        return view('pessoas.editar',compact('estados','cidades','cliente'));
    }

    public function salvarEdicao(Request $resquest){

        try{
            $editar = $resquest->except('_token');
            $editar['cpf'] = $this->removeMascara($editar['cpf']);
            $editar['rg'] = $this->removeMascara($editar['rg']);
            $editar['cep'] = $this->removeMascara($editar['cep']);
            Cliente::find($editar['id'])->update($editar);
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

    public function viewFotoPefil(int $id_pessoa)
    {
        $pessoa = Cliente::find($id_pessoa);

        return view('pessoas.foto-perfil', compact('pessoa'));
    }

    public function fotoPefilSalvar(Request $request)
    {
        try{

            $pessoa = $request->all();

            if (isset($pessoa["foto"])) {

                $foto = $request->file("foto")->store("public/pessoas");

                $foto = str_replace('public/','',$foto);

                Cliente::find($pessoa['id'])->update(['foto'=>$foto]);

                return redirect()->route('pessoas.foto.perfil', ['id_pessoa' => $pessoa['id']])->with(['status_sucesso'=>'Foto salva com sucesso']);
            }                 
        }
        catch(Exception $e){

            return redirect()->route('pessoas.foto.perfil', ['id_pessoa' => $pessoa['id']])->with(['status_error'=>'Erro ao salvar foto. Erro: '. $e->getMessage()]);
        }  
        
    }

}
