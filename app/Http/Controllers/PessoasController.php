<?php

namespace App\Http\Controllers;

use App\Models\Atribuicoes;
use App\Models\Cidade;
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

class PessoasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pessoas = DB::table('pessoas')->join('igrejas','igrejas.id','=','pessoas.id_igreja')->select('pessoas.*','igrejas.nome_fantasia')->paginate(20);
        return view('pessoas.listar', compact('pessoas'));
    }

    public function viewCadastro()
    {
        $estados = Estado::all();
        $pessoas = Pessoa::all();
        $igrejas = Igreja::all();

        return view('pessoas.cadastro',compact('estados','pessoas','igrejas'));
    }

    public function cadastroAdd(Request $resquest){

        try{
            $cadastro = $resquest->all();
            $cadastro['cpf'] = $this->removeMascara($cadastro['cpf']);
            $cadastro['rg'] = $this->removeMascara($cadastro['rg']);
            $cadastro['cep'] = $this->removeMascara($cadastro['cep']);
            $setPessoa = Pessoa::create($cadastro);
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

    public function viewFotoPefil(int $id_pessoa)
    {
        $pessoa = Pessoa::find($id_pessoa);

        return view('pessoas.foto-perfil', compact('pessoa'));
    }

    public function fotoPefilSalvar(Request $request)
    {
        try{

            $pessoa = $request->all();

            if (isset($pessoa["foto"])) {

                $foto = $request->file("foto")->store("public/pessoas");

                $foto = str_replace('public/','',$foto);

                Pessoa::find($pessoa['id'])->update(['foto'=>$foto]);

                return redirect()->route('pessoas.foto.perfil', ['id_pessoa' => $pessoa['id']])->with(['status_sucesso'=>'Foto salva com sucesso']);
            }                 
        }
        catch(Exception $e){

            return redirect()->route('pessoas.foto.perfil', ['id_pessoa' => $pessoa['id']])->with(['status_error'=>'Erro ao salvar foto. Erro: '. $e->getMessage()]);
        }  
        
    }

    public function getDetalhesImpressao(int $id_pessoa)
    {
        $pessoa = Pessoa::join('estados','pessoas.id_estado','=','estados.id')
        ->join('cidades','pessoas.id_cidade','=','cidades.id')
        ->join('igrejas','pessoas.id_igreja','=','igrejas.id')
        ->select('pessoas.*',DB::raw('estados.nome as estado'), DB::raw('cidades.nome as cidade'),DB::raw('igrejas.nome_fantasia'))
        ->where('igrejas.id',$id_pessoa)->first();
        $pdf = PDF::loadView('pessoas.detalhes-impressao-pdf', compact('pessoa'));
        return $pdf->stream('detalhes-pessoa' . date('d_m_Y') . '.pdf');
    }

    public function listaImpressao(Request $resquest)
    {
        $pessoas = DB::table('pessoas')->join('igrejas','igrejas.id','=','pessoas.id_igreja')->select('pessoas.*','igrejas.nome_fantasia')->get();
        $pdf = PDF::loadView('pessoas.lista-impressao-pdf', compact('pessoas'))->setPaper('a4', 'landscape');
        return $pdf->stream('lista-de-pessoas' . date('d_m_Y') . '.pdf');
    }

    public function atribuicoesView(int $id_pessoa)
    {

        $pessoa = Pessoa::find($id_pessoa);
        $atribuicoes = Atribuicoes::all();
        $get_pessoa_atribuicoes = PessoaAtribuicoes::where('id_pessoa', $id_pessoa)->get();
        $pessoa_atribuicoes = $get_pessoa_atribuicoes->toArray();
        // dd(array_search('t', array_column($pessoa_atribuicoes, 'id_atribuicao')));

        return view('pessoas.atribuicoes', compact('pessoa','atribuicoes', 'pessoa_atribuicoes'));
    }

    public function atribuicoesSalvar(Request $request)
    {
        try{
            $atribuicoes = $request->all();

            PessoaAtribuicoes::where('id_pessoa',$atribuicoes['id_pessoa'])->delete();

            if(isset($atribuicoes['atribuicoes'])){

                foreach ($atribuicoes['atribuicoes'] as $atribuicao) {
                    PessoaAtribuicoes::create(
                        [
                            'id_pessoa'     => $atribuicoes['id_pessoa'],
                            'id_atribuicao' => $atribuicao
                        ]
                    );
                }
            }

            return redirect()->route('pessoas.atribuicoes', ['id_pessoa' => $atribuicoes['id_pessoa']])->with(['status_sucesso'=>'Atribuições salvas com sucesso']);
        }
        catch(Exception $e){
            
            return redirect()->route('pessoas.atribuicoes', ['id_pessoa' => $atribuicoes['id_pessoa']])->with(['status_error'=>'Erro ao salvar atribuições. '. $e->getMessage()]);
        }
    
    }
}
