@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('despesas')}}">Despesas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary"><b>Editar Despesa</b></div>
    <div class="card-body">
        @if(session('status_sucesso'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_sucesso')}}
        </div>
        @endif
        @if(session('status_aviso'))
        <div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_aviso')}}
        </div>
        @endif
        @if(session('status_error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_error')}}
        </div>
        @endif
        <form action="{{route('despesas.editar.salvar')}}" method="POST" id="frmDespesa">
            @csrf
            <input type="hidden" value="{{$despesa->id}}" name="id">
            <input type="hidden" value="{{url('')}}" id="url">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Data</label>
                        <input type="date" class="form-control" name="data" autofocus value="{{$despesa->data}}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="id_categoria" id="idCategoria" required class="form-control enter">
                            <option value="">Selecione</option>
                            @foreach ($despesas_categorias as $categoria)
                            <option value="{{$categoria->id}}" {{$categoria->id == $despesa->id_categoria ? 'selected':''}}>
                                {{$categoria->descricao}}
                            </option>
                            @endforeach                        
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Fornecedor</label>
                        <select name="id_fornecedor" id="idFornecedor" required class="form-control enter">
                            <option value="">Selecione</option>
                            @foreach ($fornecedores as $fornecedor)
                            <option value="{{$fornecedor->id}}" {{$fornecedor->id == $despesa->id_fornecedor ? 'selected':''}}>
                                {{$fornecedor->nome_fantasia}}
                            </option>
                            @endforeach                        
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="Membro">Igreja</label>
                    <select name="id_igreja" id="idIgreja" required class="form-control enter">
                        <option value="">Selecione</option>
                        @foreach ($igrejas as $igreja)
                        <option value="{{$igreja->id}}" {{$igreja->id == $despesa->id_igreja ? 'selected':''}}>
                            {{$igreja->nome_fantasia}}
                        </option>
                        @endforeach                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="documento">N° Documento</label>
                        <input type="text" name="numero_documento" value="{{$despesa->documento}}" class="form-control enter">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="valor_documento">Valor Documento (*)</label>
                        <input type="text" name="valor_documento" id="valorDocumento" value="{{number_format($despesa->valor_documento,2,',','.')}}" class="form-control enter">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="valor">Valor Parcela (*)</label>
                                <input type="text" id="valorParcela" class="form-control enter valor-documento" >
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="juros">Juros</label>
                                <input type="text" name="juros" id="juros" class="form-control enter valor-documento" value="0,00">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="desconto">Desconto</label>
                                <input type="text" name="desconto" id="desconto" class="form-control enter valor-documento" value="0,00">
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="data">Vencimento (*)</label>
                                <input type="date" id="dataVencimento" class="form-control enter" value="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="data">Pagamento</label>
                                <input type="date" id="dataPagamento" class="form-control enter">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="Tipo">Conta</label>
                            <select name="id_conta" id="idConta" class="form-control enter" disabled>
                                <option value="">Selecione</option>
                                @foreach ($contas as $conta)
                                <option value="{{$conta->id}}">{{$conta->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">    
                                <label for="">Parcela</label>                                            
                                <button class="btn btn-primary btn-block enter" id="btnAddParcela">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <table class="table table-striped table-hover table-sm">
                <thead>
                  <tr>
                    <th>N° Parcela</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Pagamento</th>
                    <th>Conta</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody id="despesaParcelas">
                    @php
                        $total_parcelas = 0;
                    @endphp
                    @foreach ($array_parcelas as $parcela)
                    <tr>
                        <td>{{$parcela['numero']}}</td>
                        <td>{{number_format($parcela['valor_parcela'],2,',','.')}}</td>
                        @php
                            $vencimento=date_create($parcela['data_vencimento']);
                            $pagamento=date_create($parcela['data_pagamento']);
                        @endphp
                        <td>{{$parcela['data_vencimento'] == null ? '' : date_format($vencimento,'d/m/Y')}}</td>
                        <td>{{$parcela['data_pagamento'] == null ? '' : date_format($pagamento,'d/m/Y')}}</td>
                        <td>{{$parcela['conta']}}</td>
                        <td><a href='#' class='btn btn-danger btn-sm parcela-deletar' data-parcela-deletar="{{$loop->iteration-1}}" >Remover</a></td>
                    </tr>
                    @php
                        $total_parcelas = $total_parcelas + $parcela['valor_parcela'];
                    @endphp
                    @endforeach                    
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <h6><b>Total Parcela(s): </b><span id="totalParcelas"> {{number_format($total_parcelas,2,',','.')}}</span></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Observação</label>
                        <textarea name="observacao" class="form-control enter" id="observacao">{{$despesa->observacao}}</textarea>
                    </div>
                </div>
            </div>
            <input type="submit" value="Salvar" class="btn btn-primary btn-block enter">
        </form>
    </div>
</div>

@stop

@section('js')
    <script src="{{asset('js/despesa.js')}}"></script>
@endsection