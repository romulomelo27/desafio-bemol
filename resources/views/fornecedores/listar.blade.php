@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('fornecedores.cadastro')}}" class="btn btn-primary"><i class="fas fa-handshake"></i> Novo Fornecedor</a>
<a href="{{route('fornecedores.lista.impressao')}}" target="_blank" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Lista de Fornecedores</div>
    <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($fornecedores as $fornecedor)
              <tr>
                <td>{{$fornecedor->nome_fantasia}}</td>
                <td>{{$fornecedor->tipo == 'f'? 'Físico':'Jurídico' }}</td>
                <td>{{$fornecedor->telefone}}</td>
                <td>{{$fornecedor->email}}</td>
                <td>{{$fornecedor->ativo == "1" ? 'Ativo' : 'Inativo'}}</td>
                <td> 
                  <div class="btn-group">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                      Opções
                      </button>
                      <div class="dropdown-menu">                        
                        <a class="dropdown-item" href="{{route('fornecedores.editar',['id_fornecedor'=>$fornecedor->id])}}">Editar</a>
                        <a class="dropdown-item" href="{{route('fornecedores.detalhes.impressao',['id_fornecedor'=>$fornecedor->id])}}" target="_target">Imprimir</a>
                      </div>
                    </div>
                  </div>                  
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>          
    </div>
</div>

@stop
