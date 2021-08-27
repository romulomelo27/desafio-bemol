@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('receitas')}}">Receitas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary"><b>Editar Receita</b></div>
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
        <form action="{{route('receitas.editar.salvar')}}" method="POST" id="frmReceitas">
            @csrf
            <input type="hidden" name="id" value="{{$receita->id}}">
            <input type="hidden" value="{{url('')}}" id="url">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Membro">Igreja</label>
                        <select name="id_igreja" id="idIgreja" required class="form-control enter" autofocus>
                            <option value="">Selecione</option>
                            @foreach ($igrejas as $igreja)
                            <option value="{{$igreja->id}}" {{$igreja->id == $receita->id_igreja?'selected':''}}>
                                {{$igreja->nome_fantasia}}
                            </option>
                            @endforeach                        
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="Membro">Membro</label>
                    <select name="id_pessoa" id="idMembro" required class="form-control enter">
                        <option value="">Selecione</option>                        
                        @foreach ($membros as $membro)
                            <option value="{{$membro->id}}" {{$membro->id == $receita->id_pessoa?'selected':''}}>
                                {{$membro->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="Tipo">categoria</label>
                    <select name="id_categoria" id="idTipo" class="form-control enter" required>
                        <option value="">Selecione</option>
                        @foreach ($receitas_categorias as $categoria)
                        <option value="{{$categoria->id}}" {{$categoria->id == $receita->id_categoria?'selected':''}}>
                            {{$categoria->descricao}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 dizimo-oferta">
                    <div class="form-group">
                        <label for="valor1">Valor Dízimo</label>
                        <input type="text" name="valor1"  id="valor1" class="form-control enter valores" value="{{old('valor1') ? old('valor1') : number_format($receita->valor1,2,',','.')}}">
                    </div>
                </div>
                <div class="col-md-2 dizimo-oferta">
                    <div class="form-group">
                        <label for="valor2">Valor Oferta</label>
                        <input type="text" name="valor2" id="valor2" class="form-control enter valores" value="{{old('valor1') ? old('valor1') : number_format($receita->valor2,2,',','.')}}">
                    </div>
                </div>
                <div class="col-md-2 outros" style="display: none">
                    <div class="form-group">
                        <label for="valor2">Valor</label>
                        <input type="text" id="valor3" class="form-control enter valores" value="{{old('valor1') ? old('valor1') : number_format($receita->valor1,2,',','.')}}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="data">Data</label>
                        <input type="date" name="data" id="data" class="form-control enter" value="{{$receita->data}}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Tipo">Conta</label>
                    <select name="id_conta" id="" class="form-control enter" required>
                        <option value="">Selecione</option>
                        @foreach ($contas as $conta)
                        <option value="{{$conta->id}}" {{$conta->id == $receita->id_conta ? 'selected':''}}>
                            {{$conta->descricao}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5><b>Total: </b><span id="total">R$ {{number_format($receita->total,2,',','.')}}</span></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Observação</label>
                        <textarea name="observacao" class="form-control enter" id="observacao">{{$receita->observacao}}</textarea>
                    </div>
                </div>
            </div>
            <input type="submit" value="Salvar" class="btn btn-primary btn-block enter">
        </form>
    </div>
</div>

@stop

@section('js')
    <script src="{{asset('js/receita.js')}}"></script>
@endsection