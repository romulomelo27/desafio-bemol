@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('receitas.cadastro')}}" class="btn btn-primary"> Novo Lançamento</a>
<a href="#" target="_blank" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
@stop


@section('content')
<div class="card">
    <div class="card-header bg-primary"><b>Lista de Receitas</b></div>
    <div class="card-body">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th>Id</th>
            <th>Membro</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Igreja</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($receitas as $receita)
          <tr>
            <td>{{$receita->id}}</td>
            <td>{{$receita->nome}}</td>
            <td>{{number_format($receita->total,2,',','.')}}</td>
            <td>{{$receita->descricao}}</td>
            <td>{{$receita->razao_social}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  Opções
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Link 1</a>
                  <a class="dropdown-item" href="#">Link 2</a>
                  <a class="dropdown-item" href="#">Link 3</a>
                </div>
              </div> 
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>

@stop