@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))
@section('auth_body')
<div id="app">    
    <div class="alert alert-warning" v-if="statusInfo" id="alertInfo">@{{mensagem}}</div>
    <form action="{{ $register_url }}" method="post">
        {{ csrf_field() }}        

        {{-- Name field --}}        
        <div class="input-group mb-3">            
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   value="{{ old('name') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>
        {{-- Email field --}}
        <label for="">CPF</label>
        <div class="input-group mb-3">
            <input type="text" name="cpf" id="cpf" class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}"
                value="{{ old('cpf') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    {{-- <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span> --}}
                </div>
            </div>
            @if($errors->has('cpf'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('cpf') }}</strong>
                </div>
            @endif
        </div>
        {{-- Email field --}}                
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}">                    
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>       
        <div class="row">
            <div class="col-md-6">
                {{-- cep field --}}
                <label for="">Cep</label>
                <div class="input-group mb-3">
                    <input type="text" name="cep" v-model="cep" id="cep" v-on:blur="buscarCep" maxlength="8" class="form-control {{ $errors->has('cep') ? 'is-invalid' : '' }}"
                        value="{{ old('cep') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            {{-- <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span> --}}
                        </div>
                    </div>
                    @if($errors->has('cep'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('cep') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                {{-- nascimento field --}}
                <label for="">Nascimento</label>            
                <div class="input-group mb-3">            
                    <input type="date" id="nascimento" v-model="nascimento" v-on:blur="validarIdade" name="nascimento" class="form-control {{ $errors->has('nascimento') ? 'is-invalid' : '' }}"
                        value="{{ old('nascimento') }}" >            
                    @if($errors->has('nascimento'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('nascimento') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {{-- Password field --}}
                <label for="">Senha</label>            
                <div class="input-group mb-3">
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                {{-- Confirm password field --}}
                <label for="">Confime a senha</label>            
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @if($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>                            

        <input type="hidden" v-model="logradouro" name="logradouro" id="logradouro">
        <input type="hidden" v-model="bairro" name="bairro" id="bairro">
        <input type="hidden" v-model="localidade" name="localidade" id="localidade">
        <input type="hidden" v-model="uf" name="uf" id="uf">

        {{-- Register button --}}
        <button type="submit" :disabled="disabledBtnSalvar" id="btnRegister" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
</div>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
    
@section('js')
    <script src="{{asset('js/register.js')}}"></script>
@endsection    
@stop
