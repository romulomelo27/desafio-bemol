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
        <form action="{{route('pessoas.cadastro.add')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="nome">Nome<span style="color: red">*</span></label>
                      <input type="text" class="form-control" name="nome" id="nome" maxlength="150">
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="igreja">Igreja <span style="color: red">*</span></label>
                    <select name="id_igreja" id="id_igreja" class="form-control" required>
                      <option value="">Selecione</option>
                      @foreach ($igrejas as $igreja)
                      <option value="{{$igreja->id}}">{{$igreja->nome_fantasia}}</option>
                      @endforeach                      
                  </select>
                  </div>
                </div>              
            </div>   
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="rg">RG</label>
                    <input type="text" class="form-control" name="rg" id="rg" maxlength="30">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf">
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
              <div class="col-md-4">
                <div class="form-group">
                  <label for="complemento">Complemento</label>
                  <input type="text" class="form-control" name="complemento" id="complemento" maxlength="80">
                </div>
              </div>
              <div class="col-md-3">
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="cidade">Cidade</label>
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
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" maxlength="60">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Tipo</label>
                  <select name="tipo" id="tipo" class="form-control">
                      <option value="m">Membro</option>
                      <option value="v">Visitante</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tipo">Status</label>
                  <select name="ativo" id="ativo" class="form-control">
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

@stop