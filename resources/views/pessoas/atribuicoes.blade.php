@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('pessoas')}}">Pessoas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Atribuições</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Definir atribuições</div>
    <div class="card-body">
        @if(session('status_sucesso'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_sucesso')}}
        </div>
        @endif
        @if(session('status_error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('status_error')}}
        </div>
        @endif
        <h5><b>Membro:</b> {{$pessoa->nome}}</h5>
        <hr>
        <form action="{{route('pessoas.atribuicoes.salvar')}}" method="POST">
            @csrf
            <input type="hidden" name="id_pessoa" value="{{$pessoa->id}}">
            @foreach ($atribuicoes as $atribuicao)                            
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="checkbox" 
                        name="atribuicoes[]" 
                        class="form-check-input" 
                        value="{{$atribuicao->id}}"
                        {{array_search($atribuicao->id, array_column($pessoa_atribuicoes, 'id_atribuicao')) === false ? '':'checked'}}>
                            {{$atribuicao->descricao}}
                    </label>
                </div>    
            @endforeach    
            <br><br><br>
            <input type="submit" value="Salvar" class="btn btn-primary btn-block">
        </form>        
    </div>
</div>

@stop
