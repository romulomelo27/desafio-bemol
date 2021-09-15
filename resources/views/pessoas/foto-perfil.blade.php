@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('perfil.editar')}}">Perfil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Foto Perfil</li>
  </ol>
</nav>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Cadastrar Foto do Perfil</div>
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
        <div class="row">
            <div class="col-md-4">
              <img src="{{$user->foto != '' ? asset("storage/{$user->foto}") : asset('images/perfil.jpg')}}" class="img-thumbnail" alt="Cinque Terre"> 
            </div>
            <div class="col-md-8">
              <form action="{{route('perfil.foto.salvar')}}" method="POST" enctype="multipart/form-data">
                  <div class="form-group">                  
                      @csrf
                      
                      <label for="foto">Selecione a foto</label>                      
                      <input type="file" name="foto" class="form-control">
                      <input type="submit" value="Salvar" class="btn btn-primary" style="margin-top:10px">
                  </div>
              </form>                            
            </div>
        </div>
    </div>
</div>

@stop
