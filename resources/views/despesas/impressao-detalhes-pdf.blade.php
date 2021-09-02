<h3 align="center">DETALHES DESPESA</h5>
<p align="center" style="margin-top:-13px">{{date('d/m/Y')}}</p>
<p><b>Igreja: </b>{{$despesa->nome_fantasia}}</p>
<p><b>Fornecedor: </b>{{$despesa->fornecedor}}</p>
<p><b>Categoria: </b>{{$despesa->descricao}}</p>
<p><b>Data: </b>{{$despesa->data_formatada}}</p>
<p><b>Responsável: </b>{{$despesa->resp_lancamento}}</p>
<p><b>Valor: </b>R$ {{number_format($despesa->total,2,',','.')}}</p>
<p align="center"><b>PARCELAS</b></p>
<table border="1" cellspacing=0 width="100%">
    <thead>
        <tr>
            <td>Valor</td>
            <td>Data Vencimento</td>
            <td>Data Pagamento</td>
            <td>Conta</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($despesa_parcelas as $parcela)
        @php
            $vencimento=date_create($parcela['data_vencimento']);
            $pagamento=date_create($parcela['data_pagamento']);
        @endphp
        <tr>
            <td>{{number_format($parcela['total_parcela'],2,',','.')}}</td>
            <td>{{$parcela['data_vencimento'] == null ? '' : date_format($vencimento,'d/m/Y')}}</td>
            <td>{{$parcela['data_pagamento'] == null ? '' : date_format($pagamento,'d/m/Y')}}</td>
            <td>{{$parcela['descricao']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
