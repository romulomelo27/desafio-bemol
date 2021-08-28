<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes Impressão</title>
</head>
<body>
    <p align="center"><b>DETALHE FORNECEDOR</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <p><b>Razão Social:</b> {{$fornecedor->razao_social}}</p>
    <p><b>Nome Fantasia:</b> {{$fornecedor->nome_fantasia}}</p>
    <p><b>Apelido:</b> {{$fornecedor->apelido}}</p>
    <p><b>CNPJ/CPF:</b> {{$fornecedor->documento}}</p>
    <p><b>CEP:</b> {{$fornecedor->cep}}</p>
    <p><b>Rua:</b> {{$fornecedor->rua}} <b> - Número:</b> {{$fornecedor->numero}}</p>
    <p><b>Bairro/Complemento:</b> {{$fornecedor->complemento}}</p>
    <p><b>Estado:</b> {{$fornecedor->estado}} <b>Cidade: </b>{{$fornecedor->cidade}}</p>
    <p><b>Telefone:</b> {{$fornecedor->telefone}} <b>Celular:</b>{{$fornecedor->celular}} </p>
    <p><b>E-mail: </b>{{$fornecedor->email}}</p>
    <p><b>Tipo: </b>{{$fornecedor->tipo == 'f' ? 'Físico' : 'Jurídico'}}</p>
    
</body>
</html>