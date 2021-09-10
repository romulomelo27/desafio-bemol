@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('igrejas')}}">Tesouraria</a></li>
    <li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary"><b>Contas a Pagar</b></div>
    <div class="card-body">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th>Fornecedor</th>
            <th>Documento</th>
            <th>Nº Parc</th>
            <th>Valor</th>
            <th>Vencimento</th>
            <th>Pagamento</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($parcelas as $parcela)
          <tr>
            <td>{{$parcela->fornecedor}}</td>
            <td>{{$parcela->numero_documento}}</td>
            <td>{{$parcela->numero}}</td>
            <td>R${{number_format($parcela->valor_parcela,2,',','.')}}</td>
            <td>{{$parcela->vencimento_formatado}}</td>
            <td>{{$parcela->pagamento_formatado}}</td>
            <td> 
              <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                  Opções
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Pagar</a>
                  <a class="dropdown-item" href="#">Estornar</a>                
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
