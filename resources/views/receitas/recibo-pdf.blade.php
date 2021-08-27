<div style="border:1px solid; width: 100%; height: 400px;">
    <div style="padding: 15px">
        <span><b>RECIBO</b></span>
        <span style="float: right"><b>VALOR: R$ {{number_format($receita->total,2,',','.')}}</b></span>        
    </div>
    <h3 style="padding: 15px; line-height: 40px">
        {{$receita->nome_fantasia}} <br>
        CNPJ: {{$receita->cnpj}}<br>
        Declara que recebeu de <u>{{$receita->nome}}</u> portador(a) do CPF: {{$receita->cpf}}
        a quantia de <u>{{$total_por_extenso}}</u> 
        referente à <u>{{$receita->descricao}}</u>.
        <br>
        Data: {{date('d/m/Y')}} <br>
        Assinatura: _______________________________________________________
    </h3>
</div>
<br><br>
<div style="border:1px solid; width: 100%; height: 400px;">
    <div style="padding: 15px">
        <span><b>RECIBO</b></span>
        <span style="float: right"><b>VALOR: R$ {{number_format($receita->total,2,',','.')}}</b></span>        
    </div>
    <h3 style="padding: 15px; line-height: 40px">
        {{$receita->nome_fantasia}} <br>
        CNPJ: {{$receita->cnpj}}<br>
        Declara que recebeu de <u>{{$receita->nome}}</u> portador(a) do CPF: {{$receita->cpf}}
        a quantia de <u>{{$total_por_extenso}}</u> 
        referente à <u>{{$receita->descricao}}</u>.
        <br>
        Data: {{date('d/m/Y')}} <br>
        Assinatura: _______________________________________________________
    </h3>
</div>

