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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Venda I - Gerenciamento de Milhas - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cel").mask("(00)0-0000-0000");
     $("#cpf").mask("000.000.000-00");
});

$(document).ready(function() {
     var tipo = 1;

     $('#fas-2').click(function() {
          location.href = "venda-2.php";
     });

     $('#fas-3').click(function() {
          location.href = "venda-3.php";
     });

     $('#fas-4').click(function() {
          location.href = "venda-4.php";
     });

     $.getJSON("ajax/carrega-ven.php", {
               tip: tipo
          })
          .done(function(data) {
               if (data.men != "") {
                    if (data.men != "*") {
                         alert(data.men);
                    }
               } else {
                    $('#nom').val(data.nom);
                    $('#ema').val(data.ema);
                    $('#cel').val(data.cel);
                    $('#cpf').val(data.cpf);
                    $('#sen').val(data.sen);
               }
          }).fail(function(data) {
               console.log('Erro: ' + JSON.stringify(data));
               alert("Erro ocorrido no carregamento dos dados de venda");
          });

     $('#frmTelVen').submit(function() {
          var nom = $('#nom').val();
          var ema = $('#ema').val();
          var cel = $('#cel').val();
          var cpf = $('#cpf').val();
          var sen = $('#sen').val();
          $.getJSON("ajax/guardar-01.php", {
                    nom: nom,
                    ema: ema,
                    cel: cel,
                    sen: sen,
                    cpf: cpf
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         location.href = "venda-2.php";
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido no processamento de venda 01 (dados básicos)");
               });
          return false;
     });

});
</script>

<?php
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrkdirsis'] = __DIR__;
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrknumusu'] = getmypid();
     if (isset($_SESSION['wrkdadven']) == false) { $_SESSION['wrkdadven'] = array(); }

     $ret = sessao_pag();

?>

<body id="box00" class="fun-a">
     <h1 class="cab-0">Venda - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="container">
          <div class="qua-a animated fadeInDown">
               <form id="frmTelVen" name="frmTelVen" action="venda-1.php" method="POST">
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
                              <p id="fas-1" class="fas-b" title="Dados básicos ...">1</p>
                         </div>
                         <div class="col-1 text-center">
                              <p  id="fas-2" class="fas-c" title="Endereço completo ...">2</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-3" class="fas-c" title="Plano escolhido ...">3</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-4" class="fas-c" title="Finalização da adesão ...">4</p>
                         </div>
                         <div class="col-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              <label>Nome completo</label>
                              <input type="text" class="form-control" maxlength="50" id="nom" name="nom" value=""
                                   required />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                              <label>E-Mail</label>
                              <input type="email" class="form-control" maxlength="50" id="ema" name="ema" value=""
                                   required />
                         </div>
                         <div class="col-md-6">
                              <label>Celular</label>
                              <input type="text" class="form-control" maxlength="15" id="cel" name="cel" value=""
                                   required />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                              <label>CPF</label>
                              <input type="text" class="form-control" maxlength="18" id="cpf" name="cpf" value=""
                                   required />
                         </div>
                         <div class="col-md-6">
                              <label>Senha</label>
                              <input type="text" class="form-control text-center" maxlength="15" id="sen" name="sen" value=""
                                   required />
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-12 text-center">
                              <button type="submit" id="sal" name="salvar" class="bot-a">Guardar</button>
                         </div>
                    </div>
               </form>
               <br />
          </div>
     </div>
</body>

<?php
function sessao_pag() {
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