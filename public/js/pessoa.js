$("#cnpj").mask("99.999.999/9999-99", { reverse: true });
$("#telefone").mask("(99)9999-9999", { reverse: true });
$("#celular").mask("(99)9999-9999", { reverse: true });
$("#cep").mask("99.999-999", { reverse: true });

$("#cep").change(function () {
    if ($(this).val().length == 10) {
        var cep = $(this).val();
        cep = cep.replace(".", "");
        cep = cep.replace("-", "");

        $.ajax({
            type: "GET",
            url: "https://viacep.com.br/ws/" + cep + "/json/",
            success: function (endereco) {
                $(".icon-load-cep").hide();

                if (endereco.erro) {
                    alert("Endereço não encontrado");
                    $("#rua").val("");
                    $("#bairro").val("");
                } else {
                    $("#rua").val(endereco.logradouro);
                    $("#bairro").val(endereco.bairro);
                    $("#complemento").val(endereco.bairro);
                }
            },
            beforeSend: function () {
                $(".icon-load-cep").show();
            },
            error: function (jq, status, message) {
                console.log("Status: " + status + " - Message: " + message);
            },
        });
    }
});

$('#idEstado').change(function(){
    let id_estado = $(this).val();
    setCidades(id_estado);
});

function setCidades(id_estado) {
    
    link = $("#url").val() + "/igrejas/get-cidades/" + id_estado;

    $.ajax({
        type: "GET",
        url: link,
        dataType:'json',
        success: function (cidades) {
            quantidadeDeCidades = cidades.length;

            $("#idCidade").removeAttr('disabled',false);
            $("#idCidade").text("");

            for (i = 0; i < quantidadeDeCidades; i++) {
                $("#idCidade").append(
                    "<option value='" +
                        cidades[i].id +
                        "' selected>" +
                        cidades[i].nome +
                        "</option>"
                );
            }
            if(id_estado == 4)
            {
                $("#idCidade").val("177");
            }
            
        },
        beforeSend: function () {
            $("#idCidade").text("");
            $("#idCidade").append("<option value=''>Carregando..</option>");
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