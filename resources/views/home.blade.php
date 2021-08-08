@extends('adminlte::page')

@section('title', 'Igreja Digital')

@section('content_header')
Painel
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-info-box title="0" text="Igrejas" icon="fas fa-lg fa-church text-primary" theme="gradient-primary" icon-theme="white"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="0" text="Membros" icon="fas fa-lg fa-users text-primary" theme="gradient-primary" icon-theme="white"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="0" text="Visitantes" icon="fas fa-lg fa-male text-primary" theme="gradient-primary" icon-theme="white"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box title="0" text="Eventos" icon="fas fa-lg fa-calendar-check text-primary" theme="gradient-primary" icon-theme="white"/>
    </div>
</div>
@stop