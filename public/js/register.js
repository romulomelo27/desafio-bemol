$(document).ready(function(){
    // $("#cep").mask("99.999-999", { reverse: true });
    $("#cpf").mask("999.999.999.99", { reverse: true });

    // $("#cep").change(function () {
    //     if ($(this).val().length == 10) {
    //         var cep = $(this).val();
    //         cep = cep.replace(".", "");
    //         cep = cep.replace("-", "");
    
    //         $.ajax({
    //             type: "GET",
    //             url: "https://viacep.com.br/ws/" + cep + "/json/",
    //             success: function (endereco) {
                    
    //                 console.log(endereco);
    //                 if (endereco.erro) {
    //                     alert("CEP não encontrado!");
    //                     $('#alertInfo').hide();
                        
    //                 } else {

    //                     if(endereco.uf != 'AM'){

    //                         $('#alertInfo').show();
    //                         $('#alertInfo').text('O CEP informa não é do AMAZONAS');
    //                         $('#btnRegister').attr('disabled',true);
    //                         $('#testeCep').val('0');
    //                     }
    //                     else{

    //                         $('#testeCep').val('1');
    //                         $('#alertInfo').hide();
    //                         $('#logradouro').val(endereco.logradouro);                                 
    //                         $('#bairro').val(endereco.bairro);
    //                         $('#localidade').val(endereco.localidade);
    //                         $('#uf').val(endereco.uf);

    //                         if(($('#testeCep').val() == '1') && ($('#testeNascimento').val() == '1')){                                
    //                             $('#btnRegister').removeAttr('disabled');
    //                         }                                                   
    //                     }
                        

    //                 }
    //             },
    //             beforeSend: function () {
    //                 $(".icon-load-cep").show();
    //             },
    //             error: function (jq, status, message) {
    //                 console.log("Status: " + status + " - Message: " + message);
    //             },
    //         });
    //     }
    // });

    // $('#nascimento').focusout(function(){

    //     let data_nascimento = new Date($('#nascimento').val());                
    //     let data_atual = new Date();
    //     let idade = parseInt(data_atual.getFullYear()) - parseInt(data_nascimento.getFullYear());

    //     if(idade < 18){
    //         $('#alertInfo').show();
    //         $('#alertInfo').text('Você precisa ser maior de idade');
    //         $('#btnRegister').attr('disabled',true);
    //         $('#testeNascimento').val('0');
    //     }
    //     else{
    //         $('#testeNascimento').val('1');
    //         $('#alertInfo').hide();

    //         if(($('#testeCep').val() == '1') && ($('#testeNascimento').val() == '1')){                
    //             $('#btnRegister').removeAttr('disabled');
    //         }                                                     
    //     }
        
    // });
});

var app = new Vue({
    el: '#app',
    data: {
      cep: '',
      logradouro:'',
      bairro:'',
      localidade:'',
      uf:'',
      statusCep: false,
      statusInfo:false,
      mensagem:'',
      nascimento,
      statusNascimento:false,
      disabledBtnSalvar:true
    },
    methods: {
        buscarCep: function() {
          if(this.cep.length == 8){
              fetch('https://viacep.com.br/ws/'+this.cep+'/json').then(r => r.json()).then(
                  r => {
                      if(r.uf == 'AM'){
                        this.logradouro = r.logradouro;
                        this.bairro = r.bairro;
                        this.localidade = r.localidade;
                        this.uf = r.uf;
                        this.statusCep = true;
                        this.statusInfo = false;
                        this.checarValidacoes()
                      }
                      else{
                        this.statusCep = false;
                        this.statusInfo = true;
                        this.mensagem = 'O Cep informado NÃO é do AMAZONAS';
                        
                      }
                      
                  }
              );
          }
        },
        validarIdade: function(){
            let data_nascimento = new Date(this.nascimento);                
            let data_atual = new Date();
            let idade = parseInt(data_atual.getFullYear()) - parseInt(data_nascimento.getFullYear());

            if(idade >= 18){
                this.statusNascimento = true;
                this.checarValidacoes();
            }
            else{
                this.statusNascimento = false;
                this.statusInfo = true;
                this.mensagem = 'Cadastro somente para maiores de Idade';
            }
        },
        checarValidacoes: function(){
            if(this.statusCep && this.statusNascimento){
                this.disabledBtnSalvar = false;
            }
        }

    }
  })