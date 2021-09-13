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
<input type="hidden" id="url" value="{{url('')}}">
@csrf
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
            <td id="{{'dataPagamentoLinha'.$loop->iteration}}">{{$parcela->pagamento_formatado}}</td>
            <td> 
              <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                  Opções
                </button>
                <div class="dropdown-menu">
                  @if(is_null($parcela->data_pagamento))
                  <a id="{{'pagar'.$loop->iteration}}"
                    class="dropdown-item baixa-contas-pagar" 
                    href="#" 
                    data-toggle="modal" 
                    data-target="#myModal"
                    data-linha="{{$loop->iteration}}"
                    data-id-despesa="{{$parcela->id_despesa}}"                    
                    data-fornecedor="{{$parcela->fornecedor}}"
                    data-documento="{{$parcela->numero_documento}}"
                    data-numero="{{$parcela->numero}}"
                    data-valor="{{'R$'. number_format($parcela->valor_parcela,2,',','.')}}"
                    data-vencimento="{{$parcela->vencimento_formatado}}">Pagar</a>
                  @endif
                  <a class="dropdown-item" href="#">Estornar</a>                
                </div>
              </div> 
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <br>
      {{$parcelas->links()}}    
    </div>
</div>

<div class="modal" id="myModal" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Baixar Parcela</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <input type="hidden" id="idDespesa">
        <input type="hidden" id="numeroParcela">
        <input type="hidden" id="linhaTabela">
        <label for="">Fornecedor: </label> <span id="fornecedor"></span><br>
        <label for="">Documento: </label> <span id="documento"></span> <br>
        <label for="">Parcela: </label> <span id="numero"></span> <br>
        <label for="">Valor: </label> <span id="valor"></span> <br>
        <label for="">Vencimento: </label> <span id="vencimento"></span> <br>
        <label for="">Data Pagamento: <input type="date" value="{{date('Y-m-d')}}" id="dataPagamento"></label>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnBaixarDespesa">Baixar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>

    </div>
  </div>
</div>

@stop

@section('js')
    <script src="{{asset('js/contas-pagar.js')}}"></script>
@endsection
