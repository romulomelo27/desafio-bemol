<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes Impressão</title>
</head>
<body>
    <p align="center"><b>DETALHE IGREJA</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <p><b>Razão Social:</b> {{$igreja->razao_social}}</p>
    <p><b>Nome Fantasia:</b> {{$igreja->nome_fantasia}}</p>
    <p><b>Apelido:</b> {{$igreja->apelido}}</p>
    <p><b>CNPJ:</b> {{$igreja->cnpj}}</p>
    <p><b>CEP:</b> {{$igreja->cep}}</p>
    <p><b>Rua:</b> {{$igreja->rua}} <b> - Número:</b> {{$igreja->numero}}</p>
    <p><b>Bairro/Complemento:</b> {{$igreja->complemento}}</p>
    <p><b>Estado:</b> {{$igreja->estado}} <b>Cidade: </b>{{$igreja->cidade}}</p>
    <p><b>Telefone:</b> {{$igreja->telefone}} <b>Celular:</b>{{$igreja->celular}} </p>
    <p><b>E-mail: </b>{{$igreja->email}}</p>
    <p><b>Tipo: </b>{{$igreja->tipo == 'c' ? 'Congregação' : 'Igreja'}}</p>
    
</body>
</html>