$(document).ready(function(){

    $('.enter').keypress(function(e){
        /* 
            * verifica se o evento é Keycode (para IE e outros browsers)
            * se não for pega o evento Which (Firefox)
        */
        var tecla = (e.keyCode?e.keyCode:e.which);
        
        /* verifica se a tecla pressionada é a tecla ENTER */
        if(tecla == 13){
            /* guarda o seletor do campo onde foi pressionado Enter */
            campo =  $('.enter');
            /* pega o indice do elemento*/
            indice = campo.index(this);
            /*soma mais um ao indice e verifica se não é null
            *se não for é porque existe outro elemento
            */
            if(campo[indice+1] != null){
                /* adiciona mais 1 no valor do indice */
                proximo = campo[indice + 1];
                /* passa o foco para o proximo elemento */
                proximo.focus();
            }else{
            return true;
            }
        }
        if(tecla == 13){
        /* impede o submit caso esteja dentro de um form */
        e.preventDefault(e);
        return false;
        }else{
        /* se não for tecla enter deixa escrever */
        return true;
        }
    });

    // $('.valor-documento').focusout(function(){
        
    //     let valor =  parseFloat(formatUSA($('#valorParcela').val()));
    //     let juros =  parseFloat(formatUSA($('#juros').val()));
    //     let desconto =  parseFloat(formatUSA($('#desconto').val()));
    //     let total = (valor + juros)-desconto;

    //     $('#total').text(total.toLocaleString('pt-br', { minimumFractionDigits: 2 }));
    // });

    function formatUSA(variavel) {

        variavel = variavel.replace(".", "");
        //milhao
        variavel = variavel.replace(".", "");
        //bilhao
        variavel = variavel.replace(".", "");
    
        variavel = variavel.replace(",", ".");
    
        return variavel.toLocaleString('en', { minimumFractionDigits: 2 });
    }

    $('#dataPagamento').change(function(){
        
        if($('#dataPagamento').val() != ''){
            
            $('#idConta').removeAttr('disabled');
        }
        else{
            
            $('#idConta').attr('disabled', true);
            $('#idConta').val('');
        }
        
    });

    function formatDate(data, formato) {
        if (formato == 'pt-br') {
          return (data.substr(0, 10).split('-').reverse().join('/'));
        } else {
          return (data.substr(0, 10).split('/').reverse().join('-'));
        }
    } 

    $('#btnAddParcela').click(function(event){

        event.preventDefault();

        let valor_parcela = formatUSA($('#valorParcela').val());
        let vencimento_parcela = $('#dataVencimento').val();
        let pagamento_parcela = $('#dataPagamento').val();
        let valor_documento = formatUSA($('#valorDocumento').val());       
        let id_conta = $('#idConta').val();       
        let url = $('#url').val();        
        
        if( (valor_parcela == '') || (vencimento_parcela == '') || (valor_documento == '')){
            
            $.toast({
                heading:'Infomação',
                text: 'Os campos com (*) são obrigatórios',
                showHideTransition: 'slide',
                position:'top-right',
                hideAfter:4000,
                icon: 'info'
            })
            return false;
        }

        if((pagamento_parcela != '')  && (id_conta == '')){

            $.toast({
                heading:'Infomação',
                text: 'Você deve selecionar a conta',
                showHideTransition: 'slide',
                position:'top-right',
                hideAfter:4000,
                icon: 'info'
            })
            return false;
        }      

        let link = url + '/despesas/parcela-add?valor_documento='+valor_documento+'&valor_parcela='+valor_parcela+'&data_vencimento='+vencimento_parcela+'&data_pagamento='+pagamento_parcela+'&id_conta='+id_conta;
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: link,
            success: function (itens) {

                console.log(itens);
                if(itens.status)
                {
                    listarParcelas(itens);
                    $('#dataPagamento').val('');
                    $('#idConta').val('');
                    $('#idConta').attr('disabled',true);
                }
                else{
                    $.toast({
                        heading:'Infomação',
                        text: itens.msg,
                        showHideTransition: 'slide',
                        position:'top-right',
                        hideAfter:4000,
                        icon: 'error'
                    })
                    return false;
                }                  
            },
            beforeSend: function () {
                // $(".icon-load-cep").show();
            },
            error: function (jq, status, message) {
                console.log("Status: " + status + " - Message: " + message);
            },
        });       

    });

    function listarParcelas(itens){

        $('#despesaParcelas').html("");
        let indice = 1;
        let total_parcelas = 0;
        $.each(itens.data, function(index,item){

            let valor_parcela = parseFloat(item.valor_parcela);

            $row = "<tr>";
            $row += "<td>" + indice + "</td>";
            $row += "<td>" +valor_parcela.toLocaleString('pt-br', { minimumFractionDigits: 2 })+ "</td>";
            $row += "<td>" +formatDate(item.data_vencimento, 'pt-br')+ "</td>";
            $row += "<td>" +(item.data_pagamento == null ? '' : formatDate(item.data_pagamento, 'pt-br')) + "</td>";
            $row += "<td>" +(item.id_conta == null ? '' : item.conta) + "</td>";
            $row += "<td> <a href='#' class='btn btn-danger btn-sm parcela-deletar' data-parcela-deletar='"+index+"' >Remover</a></td>";
            $row += "</tr>";

            $('#despesaParcelas').append($row);
            total_parcelas =  parseFloat(total_parcelas) + parseFloat(item.valor_parcela);
            indice++;
        });
        $('#totalParcelas').text(total_parcelas.toLocaleString('pt-br', { minimumFractionDigits: 2 }));
    }

    $(document).on('click','.parcela-deletar', function(event){

        event.preventDefault();
    
        let url = $('#url').val();
        let key_vetor = $(this).data('parcela-deletar');
    
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url + '/despesas/parcela-remover/'+key_vetor,
            success: function (itens) {
                
                if(itens.status)
                {
                    listarParcelas(itens);
                }
                else{
                    $.toast({
                        heading:'Infomação',
                        text: itens.msg,
                        showHideTransition: 'slide',
                        position:'top-right',
                        hideAfter:4000,
                        icon: 'error'
                    })
                    return false;
                }
            },
            beforeSend: function () {
                // $(".icon-load-cep").show();
            },
            error: function (jq, status, message) {
                console.log("Status: " + status + " - Message: " + message);
            },
        });
    
    
    });
   
    $('#frmDespesa').submit(function(e){

        let valor_documento = parseFloat(formatUSA($('#valorDocumento').val()));
        let total_parcelas =  parseFloat(formatUSA($('#totalParcelas').text()));
    
        if(valor_documento != total_parcelas){

            e.preventDefault();
            $.toast({
                heading:'Infomação',
                text: 'Total de parcelas diverge com o valor do documento',
                showHideTransition: 'slide',
                position:'top-right',
                hideAfter:4000,
                icon: 'error'
            })
            return false;
        }
    });

});