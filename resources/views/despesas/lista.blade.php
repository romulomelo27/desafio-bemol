@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('despesas.cadastro')}}" class="btn btn-primary"> Novo Lançamento</a>
<a target="_blank" href="#" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
@stop


@section('content')
<div class="card">
    <div class="card-header bg-primary"><b>Lista de Despesas</b></div>
    <div class="card-body">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th>Id</th>
            <th>Fornecedor</th>
            <th>Valor</th>
            <th>Parcelas</th>
            <th>Data</th>
            <th>Categoria</th>
            <th>Igreja</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($despesas as $despesa)
          <tr>
            <td>{{$despesa->id}}</td>
            <td>{{$despesa->fornecedor}}</td>
            <td>R$ {{number_format($despesa->total,2,',','.')}}</td>
            <td>{{$despesa->numero_parcelas}}</td>
            <td>{{$despesa->data_formatada}}</td>
            <td>{{$despesa->descricao}}</td>
            <td>{{$despesa->nome_fantasia}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  Opções
                </button>
                <div class="dropdown-menu">
                  {{-- <a class="dropdown-item" href="{{route('despesa.impressao',['id_despesa'=>$despesa->id])}}" target="_blank">Imprimir</a>               --}}
                  <a class="dropdown-item" href="{{route('despesas.editar',['id_despesa'=>$despesa->id])}}">Estornar</a>
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
