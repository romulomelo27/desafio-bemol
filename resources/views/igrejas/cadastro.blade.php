@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('igrejas')}}">Igrejas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Cadastrar Nova Igreja</div>
    <div class="card-body">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="razao_social">Razão Social</label>
                      <input type="text" class="form-control" name="razao_social" id="razao_social" maxlength="150">
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nome_fantasia">Nome Fantasia <span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" maxlength="150">
                  </div>
                </div>              
            </div>   
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="apelido">Apelido</label>
                    <input type="text" class="form-control" name="apelido" id="apelido" maxlength="60">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cnpj">CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" class="form-control" name="rua" id="rua" maxlength="100">
                  </div>
                </div>
            </div>  
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="numero">Número</label>
                  <input type="text" class="form-control" name="numero" id="numero" maxlength="8">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="complemento">Complemento</label>
                  <input type="text" class="form-control" name="complemento" id="complemento" maxlength="80">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="estado">Estado</label>
                  <select name="id_estado" id="id_estado" class="form-control" required>
                      <option value="">Selecione</option>
                      @foreach ($estados as $estado)
                      <option value="{{$estado->id}}">{{$estado->nome}}</option>
                      @endforeach                      
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cidade">Estado</label>
                  <select name="id_cidade" id="id_cidade" class="form-control" required>
                      <option value="">Selecione</option>
                      @foreach ($cidades as $cidade)
                      <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                      @endforeach                      
                  </select>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="telefone">Telefone</label>
                  <input type="text" class="form-control" name="telefone" id="telefone" maxlength="15">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="celular">Celular</label>
                  <input type="text" class="form-control" name="celular" id="celular" maxlength="15">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" maxlength="60">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="tipo" class="form-control">
                      <option value="i">Igreja</option>
                      <option value="c">Congregação</option>
                  </select>
                </div>
              </div>
            </div>    
            <input type="submit" value="Salvar" class="btn btn-primary btn-block">             
        </form>
    </div>
</div>

@stop
