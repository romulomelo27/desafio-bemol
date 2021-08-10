@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('igrejas.cadastro')}}" class="btn btn-primary"><i class="fas fa-fw fa-church"></i> Nova Igreja</a>
<a href="#" target="_blank" class="btn btn-secondary"><i class="fas fa-fw fa-list"></i> Imprimir Lista</a>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Lista de Igrejas</div>
    <div class="card-body">
        <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>Nome Fantasia</th>
                <th>Tipo</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($igrejas as $igreja)
              <tr>
                <td>{{$igreja->nome_fantasia}}</td>
                <td>{{$igreja->tipo == 'i'? 'Igreja':'Congregação' }}</td>
                <td>{{$igreja->telefone}}</td>
                <td>{{$igreja->email}}</td>
                <td>{{$igreja->ativo == "1" ? 'Ativo' : 'Inativo'}}</td>
                <td> 
                  <a href="{{route('igrejas.editar',['id_igreja'=>$igreja->id])}}" class="btn btn-warning btn-sm">Editar</a>
                  <a href="" class="btn btn-secondary btn-sm">Imprimir</a>
                </td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
