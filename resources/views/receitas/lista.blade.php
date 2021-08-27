@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('receitas.cadastro')}}" class="btn btn-primary"> Novo Lançamento</a>
<a target="_blank" href="{{route('receitas.impressao.lista')}}" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
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
            <th>Data</th>
            <th>Categoria</th>
            <th>Igreja</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($receitas as $receita)
          <tr>
            <td>{{$receita->id}}</td>
            <td>{{$receita->nome}}</td>
            <td>R$ {{number_format($receita->total,2,',','.')}}</td>
            <td>{{$receita->data_formatada}}</td>
            <td>{{$receita->descricao}}</td>
            <td>{{$receita->nome_fantasia}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  Opções
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('receitas.impressao',['id_receita'=>$receita->id])}}" target="_blank">Imprimir</a>
                  <a class="dropdown-item" href="{{route('receitas.recibo',['id_receita'=>$receita->id])}}" target="_blank">Recibo</a>
                  <a class="dropdown-item" href="{{route('receitas.editar',['id_receita'=>$receita->id])}}">Estornar</a>
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
