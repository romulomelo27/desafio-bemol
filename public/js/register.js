
var app = new Vue({
    el: '#app',
    data: {
      cep: '',
      logradouro:'',
      bairro:'',
      localidade:'',
      uf:'',
      statusCep: false,            
      nascimento,
      statusNascimento:false,
      disabledBtnSalvar:true,
      cpf:'',
      statusCPF:false,
      infoCep:false,
      infoCPF:false,
      infoIdade:false,
      link:'',
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
                        this.infoCep = false;                        
                      }
                      else{
                        this.statusCep = false;
                        this.infoCep = true;                                            
                      }
                      
                  }
              );              
          }
          this.checarValidacoes();
        },
        buscarCPF: function() {
            if(this.cpf.length == 11){
                let url = document.querySelector("#url");
                fetch(url.value+'/perfil/consultar-cpf/'+this.cpf).then(r => r.json()).then(
                    r => {
                        console.log(r);
                        if(r.status){                          
                          this.statusCPF = true;  
                          this.infoCPF = false;                        
                          this.checarValidacoes();                            
                        }
                        else{
                          this.statusCPF = false;                          
                          this.infoCPF = true;
                        }
                        
                    }
                );
            }
            this.checarValidacoes();
          },
        validarIdade: function(){
            let data_nascimento = new Date(this.nascimento);                
            let data_atual = new Date();
            let idade = parseInt(data_atual.getFullYear()) - parseInt(data_nascimento.getFullYear());

            if(idade >= 18){
                this.statusNascimento = true;
                this.infoIdade = false;                
            }
            else{
                this.statusNascimento = false;
                this.infoIdade = true;
                this.mensagem = 'Cadastro somente para maiores de Idade';
            }
            this.checarValidacoes();
        },
        checarValidacoes: function(){
            
            if(this.statusCPF && this.statusCep && this.statusNascimento){
                this.disabledBtnSalvar = false;
            }
            else{
                this.disabledBtnSalvar = true;
            }
        }

    }
  })