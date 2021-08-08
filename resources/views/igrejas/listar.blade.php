@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
<a href="{{route('igrejas.cadastro')}}" class="btn btn-primary"><i class="fas fa-fw fa-church"></i> Nova Igreja</a>

@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">Lista de Igrejas</div>
    <div class="card-body">
        <table class="table table-striped table-sm table-hover">
            <thead>
              <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>John</td>
                <td>Doe</td>
                <td>john@example.com</td>
              </tr>
              <tr>
                <td>Mary</td>
                <td>Moe</td>
                <td>mary@example.com</td>
              </tr>
              <tr>
                <td>July</td>
                <td>Dooley</td>
                <td>july@example.com</td>
              </tr>
            </tbody>
        </table>
    </div>
</div>

@stop
