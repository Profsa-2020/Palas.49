<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Gerenciamento de Milhas - Alexandre Alves Rautemberg" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-11.png" sizes="32x32" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-12.png" sizes="50x50" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-13.png" sizes="192x192" />
     <link rel="apple-touch-icon" href="https://www.admmilhas.com.br/pallas49/img/logo-14.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <?php
          if ($_SESSION['wrkopcpro']  == 1) {
          ?>
     <script type="text/javascript"
          src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
     <?php } else { ?>
     <script type="text/javascript"
          src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
     <?php } ?>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Venda IV - Gerenciamento de Milhas - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cvv_v").mask("0000");
     $("#dat_v").mask("00/0000");
     $("#cpf_v").mask("000.000.000-00");
     $("#car_v").mask("0000 0000 0000 0000");
});

$(document).ready(function() {
     var tipo = 4;

     $('#fas-1').click(function() {
          location.href = "venda-1.php";
     });

     $('#fas-2').click(function() {
          location.href = "venda-2.php";
     });

     $('#fas-3').click(function() {
          location.href = "venda-3.php";
     });

     $('#cpf_v').blur(function() {
          var sta = 0;
          var cpf = $('#cpf_v').val();
          var cpf = cpf.replace(/[^0-9]/g, '');
          if (cpf != "" && cpf != "0") {
               $.get("ajax/validar-car.php", {
                         tip: 1,
                         cpf: cpf
                    })
                    .done(function(data) {
                         if (data != 0) {
                              sta = 1;
                              alert(
                                   "Número do C.p.f. informado para o dono do cartão não é válido");
                              $('#cpf_v').val("");
                         }
                    });
          }
     });

     $('#dat_v').blur(function() {
          var sta = 0;
          var dat = $('#dat_v').val();
          if (dat != "") {
               $.get("ajax/validar-car.php", {
                         tip: 2,
                         dat: dat
                    })
                    .done(function(data) {
                         if (data != 0) {
                              sta = 1;
                              alert(
                                   "Data de Validade informado do cartão de crédito não é válido");
                              $('#dat_v').val("");
                         }
                    });
          }
     });

     $('#car_v').blur(function() {
          var car = $('#car_v').val();
          var has = $('#has_c').val();
          car = car.replace(/[^0-9]/g, '');
          if (car.length != 16) {
               alert("Número de dígitos do cartão de crédito deve ser 16 números");
          }
          if (has == "") {
               PagSeguroDirectPayment.onSenderHashReady(function(dado) {
                    if (dado.status == 'error') {
                         $('#has_c').val('#');
                    }
                    dad = dado.senderHash;   // Hash estará disponível nesta variável.
                    $('#has_c').val(dad);
               });
          }
     });

     $('#cvv_v').blur(function() {
          var tok = $('#tok_c').val();
          var ban = $('#ban_c').val();
          var cvv = $('#cvv_v').val();
          var ven = $('#dat_v').val();
          var num = $('#car_v').val();
          num = num.replace(/[^0-9]/g, '');
          var mes = ven.substring(0, 2);
          var ano = ven.substring(3, 7);
          if (tok == "") {
               if (ban != "" && cvv != "" && ven != "" && num != "") {
                    PagSeguroDirectPayment.createCardToken({
                         cardNumber: num,         // Número do cartão de crédito
                         brand: ban,                   // Bandeira do cartão
                         cvv: cvv,                       // CVV do cartão
                         expirationMonth: mes,   // Mês da expiração do cartão
                         expirationYear: ano,      // Ano da expiração do cartão, é necessário os 4 dígitos.
                         success: function(data) {
                              var tok = data.card.token;
                              $('#tok_c').val(tok);
                         },
                         error: function(data) {
                              console.log('Erro token: '  + JSON.stringify(data));    
                         },
                         complete: function(data) {
                              var inf = data.card.token;
                         }
                    });
               }
          }
     });

     $.getJSON("ajax/carrega-ven.php", {
               tip: tipo
          })
          .done(function(data) {
               if (data.men != "") {
                    alert(data.men);
               } else {
                    $('#nom_v').val(data.nom_v);
                    $('#cpf_v').val(data.cpf_v);
                    $('#dat_v').val(data.dat_v);
                    $('#cvv_v').val(data.cvv_v);
                    $('#car_v').val(data.car_v);
               }
          }).fail(function(data) {
               console.log('Erro: ' + JSON.stringify(data));
               alert("Erro ocorrido no carregamento dos dados de venda");
          });

     $('#frmTelVen').submit(function() {
          var erro = 0;
          var nom = $('#nom_v').val();
          var cpf = $('#cpf_v').val();
          var dat = $('#dat_v').val();
          var cvv = $('#cvv_v').val();
          var car = $('#car_v').val();
          var ses = $('#ses_e').val();
          var tok = $('#tok_c').val();
          var has = $('#has_c').val();
          var pla = $('#tok_p').val();
          if (nom == "") {
               alert("Nome no cartão de crédito não pode ficar em branco"); erro = 1; return false;
          }
          if (dat == "") {
               alert("Data de validade do cartão de crédito não pode ficar em branco"); erro = 1; return false;
          }
          if (car == "") {
               alert("Número do cartão de crédito não pode ficar em branco"); erro = 1; return false;
          }
          if (cpf == "") {
               alert("CPF para cartão de crédito não pode ficar em branco"); erro = 1; return false;
          }
          if (cvv == "") {
               alert("Nº de segurança (CVV) do cartão não pode ficar em branco"); erro = 1; return false;
          }
          if (tok == "") {
               alert("Nº de identificação do cartão de crédito não foi encontrado (token)"); erro = 1; return false;
          }
          if (pla == "") {
               alert("Nº de identificação do plano escolhido não foi encontrado (token)"); erro = 1; return false;
          }
          if (has == "") {
               alert("Nº de identificação da compra pelo usuário não foi encontrado (hash)"); erro = 1; return false;
          }
          if (erro == 0) {
               $.getJSON("ajax/guardar-04.php", {
                         nom: nom,
                         cpf: cpf,
                         dat: dat,
                         car: car,
                         cvv: cvv,
                         has: has, 
                         tok: tok
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                         } else {
                              location.href = "venda-5.php";
                         }
                    }).fail(function(data) {
                         console.log('Erro: ' + JSON.stringify(data));
                         alert("Erro ocorrido no processamento de venda 04 (cartão de crédito)");
                    });
               }
          return false;
     });

});
</script>

<?php
     $_SESSION['wrkdirsis'] = __DIR__;
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkdadven']) == false) { $_SESSION['wrkdadven'] = array(); }

     if (isset($_SESSION['wrkdadven']['nom_c']) == false) { 
          echo '<script>alert("Dados básicos do usuário não foram informados ainda !");</script>';
          exit('<script>location.href = "venda-1.php"</script>');
     }

     if (isset($_SESSION['wrkdadven']['nom_v']) == true) {
          $nom = $_SESSION['wrkdadven']['nom_v'];
          $cpf = $_SESSION['wrkdadven']['cpf_v'];
     } else {
          $nom = $_SESSION['wrkdadven']['nom_c'];
          $cpf = $_SESSION['wrkdadven']['cpf_c'];
     }

     if (isset($_SESSION['wrkdadven']['ses_e'] ) == false) {
          $ret = sessao_pag();
     }

?>

<body id="box00" class="fun-a">
     <h1 class="cab-0">Venda - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="container">
          <div class="qua-a animated fadeInDown">
               <form id="frmTelVen" name="frmTelVen" action="venda-4.php" method="POST">
                    <br />
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <img class="img-a" src="img/logo-06.png">
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-4 text-right"></div>
                         <div class="col-1 text-center">
                              <p id="fas-1" class="fas-c" title="Dados básicos ...">1</p>
                         </div>
                         <div class="col-1 text-center">
                              <p  id="fas-2" class="fas-c" title="Endereço completo ...">2</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-3" class="fas-c" title="Plano escolhido ...">3</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-4" class="fas-b" title="Finalização da adesão ...">4</p>
                         </div>
                         <div class="col-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <?php 
                              if ($_SESSION['wrkdadven']['pla_v'] == "88") {
                                   echo '<strong>' . 'Plano escolhido: ' . '30 dias de teste grátis...' . '</strong><br />'; 
                                   echo '<strong>' . 'Valor mensal: R$ ' . " 0,00" . '</strong>'; 
                              } else if ($_SESSION['wrkdadven']['pla_v'] == "99") {
                                   echo '<strong>' . 'Plano escolhido: ' . 'Contate a administração ...' . '</strong><br />'; 
                                   echo '<strong>' . 'Valor mensal: R$ ' . "a combinar ..." . '</strong>'; 
                              } else {
                                   echo '<strong>' . 'Plano escolhido: ' . $_SESSION['wrkdadven']['des_v'] . '</strong><br />'; 
                                   echo '<strong>' . 'Valor mensal: R$ ' . number_format($_SESSION['wrkdadven']['val_v'], 2, ",", ".") . '</strong>'; 
                              }
                              ?>

                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-12">
                              <label>Nome no Cartão de Crédito</label>
                              <input type="text" class="form-control" maxlength="75" id="nom_v" name="nom_v" value="<?php echo $nom; ?>" required />
                         </div>
                    </div>
                    <div class="row">
                    <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Número do Cartão</label>
                              <input type="text" class="form-control text-center" maxlength="19" id="car_v" name="car_v" value="" required />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Número do CPF</label>
                              <input type="text" class="form-control text-center" maxlength="18" id="cpf_v" name="cpf_v" value="<?php echo $cpf; ?>" required />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                    <div class="col-md-3"></div>
                         <div class="col-md-3">
                              <label>Validade</label>
                              <input type="text" class="form-control text-center" maxlength="7" id="dat_v" name="dat_v" value=""
                                   required />
                         </div>
                         <div class="col-md-3">
                              <label>CVV</label>
                              <input type="text" class="form-control text-center" maxlength="4" id="cvv_v" name="cvv_v" value="" required />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-12 text-center">
                              <button type="submit" id="sal" name="salvar" class="bot-a">Finalizar</button>
                         </div>
                    </div>
                    <input type="hidden" id="ban_c" name="ban_c" value="" />
                    <input type="hidden" id="tam_c" name="tam_c" value="" />
                    <input type="hidden" id="tok_c" name="tok_c" value="" />
                    <input type="hidden" id="has_c" name="has_c" value="" />
                    <input type="hidden" id="opc_p" name="opc_p" value="<?php echo $_SESSION['wrkopcpro']; ?>" />
                    <input type="hidden" id="tok_p" name="tok_p" value="<?php echo $_SESSION['wrkdadven']['tok_v']; ?>" />
                    <input type="hidden" id="ses_e" name="ses_e" value="<?php echo $_SESSION['wrkdadven']['ses_e']; ?>" />
                    <input type="hidden" id="val_p" name="val_p" value="<?php echo round($_SESSION['wrkdadven']['val_v'], 2); ?>" />
               </form>
               <br />
          </div>
     </div>

     <script>

     $(document).ready(function() {
          var ses = $('#ses_e').val();
          var val = $('#val_p').val();
          if (ses != "") {
               PagSeguroDirectPayment.setSessionId(ses);

               PagSeguroDirectPayment.getPaymentMethods({   // Pega lista de opções de pagamento para o valor informado
                    amount: val,
                    success: function(response) {
                         console.log('OK', response);
                    },
                    error: function(response) {
                         console.log('Erro', response);
                    },
                    complete: function(response) {
                         console.log('ok', response);
                    }
               });               
          }

          $('#car_v').on('keyup', function() {    // Pega tamanho do CVV e imagem da bandeira do cartão com os 6 primeiros dígitos do mesmo.
               var num = $('#car_v').val();
               num = num.replace(/[^0-9]/g, '');
               if (num.length >= 6) {
                    PagSeguroDirectPayment.getBrand({
                         cardBin: num,
                         success: function(dado) {
                              console.log('O.K.', dado);
                              var sta = "";
                              var tam = dado.brand.cvvSize;
                              var ban = dado.brand.name;
                              var nom = dado.brand.name;
                              $('#ban_c').val(nom);
                              $('#tam_c').val(tam);
                              nom = 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/' +
                                   nom + '.png';
                              // $('#ima').attr('src', nom);
                         },
                         error: function(dado) {
                              console.log('erro ', num, dado);
                              // $('#ima').attr('src', 'img/cartao.png');
                         },
                         complete: function(dado) {
                              console.log('o.k.', num, dado);
                              // tratamento comum para todas chamadas
                         }
                    });
               }
          });

     });

     </script>

</body>
<?php
function sessao_pag() {
     $sta = 0;
     include_once "dados.php";
     include_once "profsa.php";
     $sta = 0; $_SESSION['wrkdadven']['err_e'] = ""; $_SESSION['wrkdadven']['ses_e'] = "";
     $_SESSION['wrkdadven']['tip_e'] = retorna_dad('emptipo', 'tb_empresa', 'idempresa', 1); 
     $_SESSION['wrkdadven']['ema_e'] = retorna_dad('empemail', 'tb_empresa', 'idempresa', 1); 
     if ($_SESSION['wrkdadven']['ema_e'] == "") {
          echo '<script>alert("E-Mail informado na empresa para PagSeguro em branco !");</script>';
          return 1;
     }
     if ($_SESSION['wrkdadven']['tip_e'] == 1) {  // 0-Homologação 1-Produção
          $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenpro', 'tb_empresa', 'idempresa', 1); 
          $url = "https://ws.pagseguro.uol.com.br/v2/sessions?" . 'email=' . $_SESSION['wrkdadven']['ema_e'] . '&token=' . $_SESSION['wrkdadven']['tok_e'];
     } else {
          $_SESSION['wrkdadven']['tok_e'] = retorna_dad('emptokenhom', 'tb_empresa', 'idempresa', 1); 
          $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?" . 'email=' . $_SESSION['wrkdadven']['ema_e'] . '&token=' . $_SESSION['wrkdadven']['tok_e'];
     }

     $cur  = curl_init($url);
     curl_setopt($cur, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencode; charset=UTF-8"));
     curl_setopt($cur, CURLOPT_POST, 1);
     if ($_SESSION['wrkdadven']['tip_e'] == 1) {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, true);
     } else {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
     }
     curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
     
     $ret = curl_exec($cur);
     curl_close($cur);
     if ($ret == false) { 
          echo '<script>alert("Acesso a PagSeguro para identificação não foi autorizado");</script>';
          return 2;
     }
     if ($ret == 'Unauthorized') { 
          echo '<script>alert("Informações para logar no PagSeguro não estão corretas");</script>';
          return 3;
     }
     $xml = simplexml_load_string($ret);
     if (isset($xml->error) == true) {
          $sta = 4;
          $_SESSION['wrkdadven']['err_e'] = (string) $xml->error->code;
          echo '<script>alert("' . $_SESSION['wrkdadven']['err_e'] . '");</script>';
     }else{
          $_SESSION['wrkdadven']['ses_e'] = (string) $xml->id;
     }
     return $sta;
}

?>

</html>