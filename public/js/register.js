$(document).ready(function(){
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
                    
                    console.log(endereco);
                    if (endereco.erro) {
                        alert("CEP não encontrado!");
                        $('#alertInfo').hide();
                        
                    } else {

                        if(endereco.uf != 'AM'){

                            $('#alertInfo').show();
                            $('#alertInfo').text('O CEP informa não é do AMAZONAS');
                            $('#btnRegister').attr('disabled',true);
                            $('#testeCep').val('0');
                        }
                        else{

                            $('#testeCep').val('1');
                            $('#alertInfo').hide();
                            if(($('#testeCep').val() == '1') && ($('#testeNascimento').val() == '1')){
                                alert('entrou 1')
                                $('#btnRegister').removeAttr('disabled');
                            }                                                        
                        }
                        

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

    $('#nascimento').focusout(function(){

        let data_nascimento = new Date($('#nascimento').val());                
        let data_atual = new Date();
        let idade = parseInt(data_atual.getFullYear()) - parseInt(data_nascimento.getFullYear());

        if(idade < 18){
            $('#alertInfo').show();
            $('#alertInfo').text('Você precisa ser maior de idade');
            $('#btnRegister').attr('disabled',true);
            $('#testeNascimento').val('0');
        }
        else{
            $('#testeNascimento').val('1');
            $('#alertInfo').hide();

            if(($('#testeCep').val() == '1') && ($('#testeNascimento').val() == '1')){
                alert('entrou 2')
                $('#btnRegister').removeAttr('disabled');
            }                                                     
        }
        
    });
});