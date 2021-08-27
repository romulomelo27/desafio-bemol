<h3 align="center">DETALHES RECEITA</h5>
<p align="center" style="margin-top:-13px">{{date('d/m/Y')}}</p>
<p><b>Igreja: </b>{{$receita->nome_fantasia}}</p>
<p><b>Membro(a): </b>{{$receita->nome}}</p>
<p><b>Categoria: </b>{{$receita->descricao}}</p>
<p><b>Data Referente: </b>{{$receita->data_formatada}}</p>
<p><b>Responsável: </b>{{$receita->resp_lancamento}}</p>
@if($receita->id_categoria == '1')
<p><b>Valor Dízimo: </b>R$ {{number_format($receita->valor1,2,',','.')}}</p>    
<p><b>Valor Oferta: </b>R$ {{number_format($receita->valor2,2,',','.')}}</p>    
@else
<p><b>Valor: </b>R$ {{number_format($receita->valor1,2,',','.')}}</p>    
@endif
<p><b>Conta: </b>{{$receita->conta}}</p>
