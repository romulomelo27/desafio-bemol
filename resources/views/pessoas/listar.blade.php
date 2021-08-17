@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('pessoas.cadastro')}}" class="btn btn-primary"><i class="fas fa-fw fa-users"></i> Nova Pessoa</a>
<a href="#" target="_blank" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Lista de Pessoas</div>
    <div class="card-body">
        <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Celular</th>
                <th>Igreja</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pessoas as $pessoa)
              <tr>
                <td>{{$pessoa->nome}}</td>
                <td>{{$pessoa->tipo == 'm'? 'Membro':'Visitante' }}</td>
                <td>{{$pessoa->celular}}</td>
                <td>{{$pessoa->nome_fantasia}}</td>
                <td>{{$pessoa->ativo == "1" ? 'Ativo' : 'Inativo'}}</td>
                <td> 
                  <div class="btn-group">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Opções
                      </button>
                      <div class="dropdown-menu">                        
                        <a class="dropdown-item" href="{{route('pessoas.editar',['id_pessoa'=>$pessoa->id])}}">Editar</a>
                        @if($pessoa->tipo == "m")
                        <a class="dropdown-item" href="#" >Atribuições</a>
                        @endif                        
                        <a class="dropdown-item" href="{{route('pessoas.foto.perfil',['id_pessoa'=>$pessoa->id])}}">Foto</a>
                        <a class="dropdown-item" href="#" target="_target">Imprimir</a>
                      </div>
                    </div>
                  </div>                  
                </td>
              </tr>
              @endforeach
            </tbody>
        </table>
        {{$pessoas->links()}}
    </div>
</div>

@stop
