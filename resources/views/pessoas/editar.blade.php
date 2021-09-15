@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('perfil.editar')}}">Perfil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Editar Perfil</div>
    <div class="card-body">
        @if(session('status_sucesso'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_sucesso')}}
        </div>
        @endif
        @if(session('status_error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_error')}}
        </div>
        @endif
        <form action="{{route('perfil.editar.salvar')}}" method="POST">
            @csrf
            <input type="hidden" value="{{url('')}}" id="url">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="nome">Nome<span style="color: red">*</span></label>
                      <input type="text" class="form-control enter" autofocus name="nome" id="nome" maxlength="150" value="{{$user->name}}">
                    </div>
                </div>        
            </div>   
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="rg">RG</label>
                    <input type="text" class="form-control enter" name="rg" id="rg" maxlength="30" value="{{$user->rg}}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control enter" disabled id="cpf" value="{{$user->cpf}}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cep">CEP <i class='fa fa-spinner fa-spin icon-load-cep' style='font-size:24px; display:none'></i></label>
                    <input type="text" class="form-control enter" name="cep" id="cep" value="{{$user->cep}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" class="form-control enter" name="rua" id="rua" maxlength="100" value="{{$user->rua}}">
                  </div>
                </div>
            </div>  
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="numero">Número</label>
                  <input type="text" class="form-control enter" name="numero" id="numero" maxlength="8" value="{{$user->numero}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="complemento">Bairro/Complemento</label>
                  <input type="text" class="form-control enter" name="complemento" id="complemento" maxlength="80" value="{{$user->complemento}}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="estado">Estado</label>
                  <input type="text" id="estado" name="estado" value="{{$user->estado}}" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cidade">Cidade</label>
                  <input type="text" id="cidade" name="cidade" value="{{$user->cidade}}" class="form-control">
                </div>
              </div>              
            </div> 
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="telefone">Telefone</label>
                  <input type="text" class="form-control enter" name="telefone" id="telefone" maxlength="15" value="{{$user->telefone}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input type="text" class="form-control enter" name="celular" id="celular" maxlength="15" value="{{$user->celular}}">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control enter" name="email" id="email" maxlength="60" value="{{$user->email}}">
                </div>
              </div>
            </div>    
            <input type="submit" value="Salvar" class="btn btn-primary btn-block">             
        </form>
    </div>
</div>
@section('js')
    <script src="{{asset('js/pessoa.js')}}"></script>
@endsection

@stop
