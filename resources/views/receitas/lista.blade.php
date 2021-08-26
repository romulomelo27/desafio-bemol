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
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Membro</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Igreja</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John</td>
            <td>Doe</td>
            <td>john@example.com</td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
</div>

@stop
