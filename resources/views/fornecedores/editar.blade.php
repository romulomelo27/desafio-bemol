@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('fornecedores')}}">Fornecedor</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edição</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Editar Fornecedor</div>
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
        <form action="{{route('fornecedores.editar.salvar')}}" method="POST">
            @csrf
            <input type="hidden" value="{{url('')}}" id="url">
            <input type="hidden" name="id" value="{{$fornecedor->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="razao_social">Razão Social</label>
                      <input type="text" class="form-control enter" name="razao_social" autofocus id="razao_social" maxlength="150" value="{{$fornecedor->razao_social}}">
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nome_fantasia">Nome Fantasia <span style="color: red">*</span></label>
                    <input type="text" class="form-control enter" name="nome_fantasia" id="nome_fantasia" maxlength="150" value="{{$fornecedor->nome_fantasia}}">
                  </div>
                </div>              
            </div>   
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="idTipo" class="form-control enter">
                      <option value="j" {{$fornecedor->tipo == 'j' ? 'selected' : ''}}>Jurídico</option>
                      <option value="f" {{$fornecedor->tipo == 'f' ? 'selected' : ''}}>Físico</option>
                  </select>
                </div>
              </div>
                <div class="col-md-3 cnpj">
                  <div class="form-group">
                    <label for="cnpj">CNPJ</label>
                    <input type="text" class="form-control enter" id="cnpj" value="{{$fornecedor->documento}}">
                  </div>
                </div>
                <div class="col-md-3 cpf">
                  <div class="form-group">
                    <label for="cnpj">CPF</label>
                    <input type="text" class="form-control enter" id="cpf" value="{{$fornecedor->documento}}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cep">CEP <i class='fa fa-spinner fa-spin icon-load-cep' style='font-size:24px; display:none'></i></label>
                    <input type="text" class="form-control enter" name="cep" id="cep" value="{{$fornecedor->cep}}">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" class="form-control enter" name="rua" id="rua" maxlength="100" value="{{$fornecedor->rua}}">
                  </div>
                </div>
            </div>  
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="numero">Número</label>
                  <input type="text" class="form-control enter" name="numero" id="numero" maxlength="8" value="{{$fornecedor->numero}}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="complemento">Bairro/Complemento</label>
                  <input type="text" class="form-control enter" name="complemento" id="complemento" maxlength="80" value="{{$fornecedor->complemento}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="estado">Estado</label>
                  <select name="id_estado" id="idEstado" class="form-control enter" required>
                      <option value="">Selecione</option>
                      @foreach ($estados as $estado)
                      <option value="{{$estado->id}}" {{$estado->id == $fornecedor->id_estado ? 'selected' : ''}}>
                        {{$estado->nome}}
                      </option>
                      @endforeach                      
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cidade">Cidade</label>
                  <select name="id_cidade" id="idCidade" class="form-control enter" required>
                      <option value="">Selecione</option>
                      @foreach ($cidades as $cidade)
                      <option value="{{$cidade->id}}" {{$cidade->id == $fornecedor->id_cidade ? 'selected' : ''}}>
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
                  <input type="text" class="form-control enter" name="telefone" id="telefone" maxlength="15" value="{{$fornecedor->telefone}}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input type="text" class="form-control enter" name="celular" id="celular" maxlength="15" value="{{$fornecedor->celular}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control enter" name="email" id="email" maxlength="60" value="{{$fornecedor->email}}">
                </div>
              </div>              
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Status</label>
                  <select name="ativo" id="ativo" class="form-control enter">
                      <option value="1" {{$fornecedor->ativo == 1 ? 'selected' : ''}}>Ativo</option>
                      <option value="0" {{$fornecedor->ativo == 0 ? 'selected' : ''}}>Inativo</option>
                  </select>
                </div>
              </div>
            </div>    
            <input type="submit" value="Salvar" class="btn btn-primary btn-block">             
        </form>
    </div>
</div>
@section('js')
    <script src="{{asset('js/fornecedor.js')}}"></script>
@endsection
@stop
