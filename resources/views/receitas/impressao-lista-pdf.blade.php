<h3 align="center">Lisda de Receitas</h3>
<table border="1" cellspadding="0" cellspacing="0">
    <thead>
      <tr>
        <th>Id</th>
        <th>Membro</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Categoria</th>
        <th>Igreja</th>        
      </tr>
    </thead>
    <tbody>
      @foreach ($receitas as $receita)
      <tr>
        <td >{{$receita->id}}</td>
        <td>{{$receita->nome}}</td>
        <td>R$ {{number_format($receita->total,2,',','.')}}</td>
        <td>{{$receita->data_formatada}}</td>
        <td>{{$receita->descricao}}</td>
        <td>{{$receita->nome_fantasia}}</td>        
      </tr>
      @endforeach
    </tbody>
  </table>