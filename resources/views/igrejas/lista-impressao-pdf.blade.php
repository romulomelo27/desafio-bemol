<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista impressão de Igrejas</title>
</head>
<body>
    <p align="center"><b>LISTA DE IGREJAS</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <table border="1" cellspacing="0" >
        <thead>
            <tr>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th>
                <th>CEP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($igrejas as $igreja)
            <tr>
                <td>{{$igreja->razao_social}}</td>
                <td>{{$igreja->nome_fantasia}}</td>
                <td>{{$igreja->cnpj}}</td>
                <td>{{$igreja->cep}}</td>
            </tr>
            @endforeach            
        </tbody>
        
    </table>

    
    
</body>
</html>