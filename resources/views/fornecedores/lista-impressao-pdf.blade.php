<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista impressão de Igrejas</title>
</head>
<body>
    <p align="center"><b>LISTA DE FORNECEDORES</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <table border="1" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>CNPJ/CPF</th>
                <th>CEP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fornecedores as $fornecedor)
            <tr>
                <td>{{$fornecedor->razao_social}}</td>
                <td>{{$fornecedor->nome_fantasia}}</td>
                <td>{{$fornecedor->documento}}</td>
                <td>{{$fornecedor->cep}}</td>
            </tr>
            @endforeach            
        </tbody>
        
    </table>

    
    
</body>
</html>