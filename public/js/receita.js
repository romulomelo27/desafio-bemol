
$(document).ready(function(){

    $('#idIgreja').change(function(){
    
        let id_igreja = $(this).val();   
        if(id_igreja !=''){
            setMembros(id_igreja);
        }
        
    });
    
    function setMembros(id_igreja) {
        
        link = $("#url").val() + "/receitas/get-membros/" + id_igreja;
        
        $.ajax({
            type: "GET",
            url: link,
            dataType:'json',
            success: function (membros) {
                quantidadeDeMembros = membros.length;
    
                $("#idMembro").removeAttr('disabled',false);
                $("#idMembro").text("");
    
                for (i = 0; i < quantidadeDeMembros; i++) {
                    $("#idMembro").append(
                        "<option value='" +
                            membros[i].id +
                            "' selected>" +
                            membros[i].nome +
                            "</option>"
                    );
                }               
                
            },
            beforeSend: function () {
                $("#idMembro").text("");
                $("#idMembro").append("<option value=''>Carregando..</option>");
            },
        });
    }
    
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

    $('#idTipo').change(function(){
    
        let id_tipo = $(this).val();
        
        if(id_tipo != 1){
            $('.dizimo-oferta').hide();
            $('.outros').show();
            $('#valor1').removeAttr('name');
            $('#valor2').removeAttr('name');
            $('#valor3').attr('name','valor1');
        }
        else{
            $('.dizimo-oferta').show();
            $('.outros').hide();
            $('#valor1').attr('name','valor1');
            $('#valor2').attr('name','valor2');
            $('#valor3').removeAttr('name');
        }
        calcularValorLancamento();
    });

    $('.valores').focusout(function(){

        calcularValorLancamento();
    });

    function calcularValorLancamento(){
        if(($('#idTipo').val() == 1) || ($('#idTipo').val() == '')){
            
            let valor1 = formatUSA($('#valor1').val());
            let valor2 = formatUSA($('#valor2').val());
            let resultado =  parseFloat(valor1) + parseFloat(valor2);            
            $('#total').text(resultado.toLocaleString('pt-br',{ minimumFractionDigits: 2 }));            
        }
        else{
            let valor3 = parseFloat(formatUSA($('#valor3').val()));
            $('#total').text(valor3.toLocaleString('pt-br',{ minimumFractionDigits: 2 }));
        }
    };

    function formatUSA(variavel) {

        variavel = variavel.replace(".", "");
        //milhao
        variavel = variavel.replace(".", "");
        //bilhao
        variavel = variavel.replace(".", "");
    
        variavel = variavel.replace(",", ".");
    
        return variavel.toLocaleString('en', { minimumFractionDigits: 2 });
    }

    $('#frmReceitas').submit(function(){
        if($('#total').text() == '0,00'){
            alert('O valor não pode ser zerado');
            return false;
        }
    });

});

