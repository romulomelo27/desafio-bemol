<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('consultarCPF');
    }    
    

    public function viewEditar(){
        
        $user = User::find(Auth::user()->id);        

        return view('pessoas.editar',compact('user'));
    }

    public function salvarEdicao(Request $resquest){
        
        try{
            $editar = $resquest->except('_token');
            // $editar['cpf'] = $this->removeMascara($editar['cpf']);
            $editar['rg'] = $this->removeMascara($editar['rg']);
            $editar['cep'] = $this->removeMascara($editar['cep']);            
            User::find(Auth::user()->id)->update($editar);
            Log::info("Perfil editado. Id: ".Auth::user()->id." Por: ". Auth::user()->name);
            return redirect()->route('perfil.editar')->with(['status_sucesso'=>'Perfil editado com sucesso']);
        }
        catch(Exception $e){

            Log::error("Erro ao edita pessoa. Erro: ". $e->getMessage());
            return redirect()->route('perfil.editar')->with(['status_error'=>'Erro ao editar pessoa'.$e->getMessage()]);
        }

    }

    private function removeMascara($var){

        $var = str_replace('.','',$var);
        $var = str_replace('-','',$var);

        return $var;
    }

    public function viewFotoPefil()
    {
        $user = User::find(Auth::user()->id);

        return view('pessoas.foto-perfil', compact('user'));
    }

    public function fotoPefilSalvar(Request $request)
    {
        try{

            $pessoa = $request->all();

            if (isset($pessoa["foto"])) {

                $foto = $request->file("foto")->store("public/pessoas");

                $foto = str_replace('public/','',$foto);

                User::find(Auth::user()->id)->update(['foto'=>$foto]);

                return redirect()->route('perfil.foto.perfil')->with(['status_sucesso'=>'Foto salva com sucesso']);
            }                 
        }
        catch(Exception $e){

            return redirect()->route('perfil.foto.perfil')->with(['status_error'=>'Erro ao salvar foto. Erro: '. $e->getMessage()]);
        }  
        
    }

    public function consultarCPF($cpf){

        $users = User::where('cpf',$this->removeMascara($cpf))->get();

        if(count($users) == 0){

            return response()->json(['status'=>true, 'msg'=> 'Cpf não existe']);
        }
        else{
            return response()->json(['status'=>false, 'msg'=>'Cpf já cadastrado']);
        }
        
    }
}
