<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes Impressão</title>
</head>
<body>
    <p align="center"><b>DETALHES PESSOA</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <p><b>Nome:</b> {{$pessoa->nome}}</p>
    <p><b>Igreja:</b> {{$pessoa->nome_fantasia}}</p>
    <p><b>CPF:</b> {{$pessoa->cpf}} <b>RG: </b>{{$pessoa->rg}}</p>
    <p><b>CEP:</b> {{$pessoa->cep}}</p>
    <p><b>Rua:</b> {{$pessoa->rua}} <b> - Número:</b> {{$pessoa->numero}}</p>
    <p><b>Bairro/Complemento:</b> {{$pessoa->complemento}}</p>
    <p><b>Estado:</b> {{$pessoa->estado}} <b>Cidade: </b>{{$pessoa->cidade}}</p>
    <p><b>Telefone:</b> {{$pessoa->telefone}} <b>Celular:</b>{{$pessoa->celular}} </p>
    <p><b>E-mail: </b>{{$pessoa->email}}</p>
    <p><b>Tipo: </b>{{$pessoa->tipo == 'm' ? 'Membro' : 'Visitante'}}</p>
    
</body>
</html>