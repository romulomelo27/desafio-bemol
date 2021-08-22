<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista impressa de Pessoas</title>
</head>
<body>
    <p align="center"><b>LISTA DE PESSOAS</b></p>
    <p align="center" style="margin-top: -15px"><b>{{date('d/m/Y')}}</b></p>
    <table border="1" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th>NOME</th>
                <th>TIPO</th>
                <th>CELULAR</th>
                <th>IGREJA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pessoas as $pessoa)
            <tr>
                <td>{{$pessoa->nome}}</td>
                <td>{{$pessoa->tipo == 'm'?'Membro' : 'Visitante'}}</td>
                <td>{{$pessoa->celular}}</td>
                <td>{{$pessoa->nome_fantasia}}</td>
            </tr>
            @endforeach            
        </tbody>
        
    </table>

    
    
</body>
</html>