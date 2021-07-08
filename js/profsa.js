
function carrega_mei(ses) {
     PagSeguroDirectPayment.setSessionId(ses);
     PagSeguroDirectPayment.getPaymentMethods({
          success: function(dado) {
               console.log(dado);
          },
          error: function(dado) {
               console.log('erro: ' + dado);
          },
          complete: function(dado) {
               // Callback para todas chamadas.                         
          }
     });     
}

function numero_par(ban, val, par) {
     PagSeguroDirectPayment.getInstallments({
          amount: val,
          maxInstallmentNoInterest: par,
          brand: ban,
          success: function(dado){
               // console.log(dado);      
               var txt = "";
               $.each(dado.installments, function(ia, obja) {
                    $.each(obja, function(ib, objb) {
                         var val = objb.installmentAmount.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
                         var tot = objb.totalAmount.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
                         txt = txt + '<option value="' + objb.totalAmount + '" valor="' + objb.installmentAmount + '">Parcelas: ' + objb.quantity + ' - Valor: ' + val + ' - Total: ' + tot + '</option>';
                    });     
               });
               $('.par-1').css({display: 'block'});   
               $('#par').empty().html(txt);
          },
          error: function(dado) {
               console.log(dado);          
          },
          complete: function(dado){
              // Callback para todas chamadas.
          }
     });
}

function token_car(car, ban, cvv, mes, ano) {
     PagSeguroDirectPayment.createCardToken({
          cardNumber: car, // Número do cartão de crédito
          brand: ban,         // Bandeira do cartão
          cvv: cvv,             // CVV do cartão
          expirationMonth: mes,   // Mês da expiração do cartão
          expirationYear: ano,      // Ano da expiração do cartão, é necessário os 4 dígitos.
          success: function(data) {
               var tok = data.card.token;
               $('#tok_c').val(tok);
               sessionStorage.setItem('nom_1', tok);
               return tok;
          },
          error: function(data) {
               console.log('Erro na solicitação do token -> '  + JSON.stringify(data));    
          },
          complete: function(data) {
               var inf = data.card.token;
               sessionStorage.setItem('nom_2', inf);
               return inf;
          }
     });
}

function dados_don() {
     var dad = '*';
     PagSeguroDirectPayment.onSenderHashReady(function(dado){
          if (dado.status == 'error') {
               console.log(dado.message);
               return false;
          }
          var dad = dado.senderHash;    // Hash estará disponível nesta variável, ele não existe fora da chamada.
          $('#has_c').val(dad);
          sessionStorage.setItem('nom_3', dad);
          console.log('Has -> ' + dad);
     });     
     return dad;
}