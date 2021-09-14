$(document).ready(function(){

    $('.baixa-contas-pagar').click(function(){

        let id_despesa = $(this).data('id-despesa');
        let fornecedor = $(this).data('fornecedor');
        let documento = $(this).data('documento');
        let numero = $(this).data('numero');
        let valor = $(this).data('valor');
        let vencimento = $(this).data('vencimento');
        var linha = $(this).data('linha');

        $('#idDespesa').val(id_despesa);
        $('#numeroParcela').val(numero);
        $('#fornecedor').text(fornecedor);
        $('#documento').text(documento);
        $('#numero').text(numero);
        $('#valor').text(valor);
        $('#vencimento').text(vencimento);
        $('#linhaTabela').val(linha);
    });

    $('#btnBaixarDespesa').click(function(){

        let id_despesa = $('#idDespesa').val();
        let numero_parcela = $('#numeroParcela').val();
        let data_pagamento = $('#dataPagamento').val()        
        let url = $('#url').val();
        let token = $("[name=_token]").val(); 
        let id_conta = $('#idConta').val();
        
        
        if((data_pagamento == '') || (id_conta == '')){
            
            $.toast({
                heading:'Infomação',
                text: 'Conta e Data de pagamento obrigatórios',
                showHideTransition: 'slide',
                position:'top-right',
                hideAfter:4000,
                icon: 'error'
            });

            return false
        }

        $.ajax({
            url : url + '/contas-pagar/baixar',
            dataType:'json',
            type : 'post',
            data : {
                 _token: token,
                 id_despesa: id_despesa,
                 numero_parcela: numero_parcela,
                 data_pagamento: data_pagamento,
                 id_conta: id_conta
            },
            beforeSend : function(){
                 $("#resultado").html("ENVIANDO...");
            }
       })
       .done(function(result){
            
            if(result.status){
                $.toast({
                    heading:'Infomação',
                    text: result.msg,
                    showHideTransition: 'slide',
                    position:'top-right',
                    hideAfter:4000,
                    icon: 'info'
                })                
                $('#myModal').modal('hide');
                let linha = $('#linhaTabela').val()
                $('#dataPagamentoLinha'+linha).text(result.data_pagamento);
                $('#pagar'+linha).hide();
                console.log(result);
                console.log(linha);
            }
            else{
                $.toast({
                    heading:'Infomação',
                    text: result.msg,
                    showHideTransition: 'slide',
                    position:'top-right',
                    hideAfter:4000,
                    icon: 'error'
                })
            }
       })
       .fail(function(jqXHR, textStatus, msg){
            alert(msg);
       });
    });
});