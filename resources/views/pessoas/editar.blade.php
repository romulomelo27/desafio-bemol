@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('pessoas')}}">Pessoas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Cadastrar Nova Pessoa</div>
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
        <form action="{{route('pessoas.editar.salvar')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$pessoa->id}}">
            <input type="hidden" value="{{url('')}}" id="url">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="nome">Nome<span style="color: red">*</span></label>
                      <input type="text" class="form-control enter" autofocus name="nome" id="nome" maxlength="150" value="{{$pessoa->nome}}">
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="igreja">Igreja <span style="color: red">*</span></label>
                    <select name="id_igreja" id="idIgreja" class="form-control enter" required>
                      <option value="">Selecione</option>
                      @foreach ($igrejas as $igreja)
                      <option value="{{$igreja->id}}" {{$igreja->id == $pessoa->id_igreja ? 'selected' : ''}}>
                        {{$igreja->nome_fantasia}}
                      </option>
                      @endforeach                      
                  </select>
                  </div>
                </div>              
            </div>   
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="rg">RG</label>
                    <input type="text" class="form-control enter" name="rg" id="rg" maxlength="30" value="{{$pessoa->rg}}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control enter" name="cpf" id="cpf" value="{{$pessoa->cpf}}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cep">CEP <i class='fa fa-spinner fa-spin icon-load-cep' style='font-size:24px; display:none'></i></label>
                    <input type="text" class="form-control enter" name="cep" id="cep" value="{{$pessoa->cep}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" class="form-control enter" name="rua" id="rua" maxlength="100" value="{{$pessoa->rua}}">
                  </div>
                </div>
            </div>  
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="numero">Número</label>
                  <input type="text" class="form-control enter" name="numero" id="numero" maxlength="8" value="{{$pessoa->numero}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="complemento">Complemento</label>
                  <input type="text" class="form-control enter" name="complemento" id="complemento" maxlength="80" value="{{$pessoa->complemento}}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="estado">Estado</label>
                  <select name="id_estado" id="idEstado" class="form-control enter" required>
                      <option value="">Selecione</option>
                      @foreach ($estados as $estado)
                        <option value="{{$estado->id}}" {{$estado->id == $pessoa->id_estado ? 'selected' : ''}}>
                          {{$estado->nome}}
                        </option>
                      @endforeach                      
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cidade">Cidade</label>
                  <select name="id_cidade" id="idCidade" class="form-control enter" required>
                      <option value="">Selecione</option>
                      @foreach ($cidades as $cidade)
                      <option value="{{$cidade->id}}" {{$cidade->id == $pessoa->id_cidade ? 'selected':''}}>
                        {{$cidade->nome}}
                      </option>
                      @endforeach                      
                  </select>
                </div>
              </div>              
            </div> 
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="telefone">Telefone</label>
                  <input type="text" class="form-control enter" name="telefone" id="telefone" maxlength="15" value="{{$pessoa->telefone}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input type="text" class="form-control enter" name="celular" id="celular" maxlength="15" value="{{$pessoa->celular}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control enter" name="email" id="email" maxlength="60" value="{{$pessoa->email}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="tipo" class="form-control enter">
                      <option value="m" {{$pessoa->tipo == 'm' ? 'selected':''}}>Membro</option>
                      <option value="v" {{$pessoa->tipo == 'v' ? 'selected':''}}>Visitante</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Status</label>
                  <select name="ativo" id="ativo" class="form-control enter">
                      <option value="1">Ativo</option>
                      <option value="0">Inativo</option>
                  </select>
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
