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
     $_SESSION['wrknumdoc'] = getmypid();
     if (isset($_SESSION['wrkdadven']) == false) { $_SESSION['wrkdadven'] = array(); }
     if (isset($_SESSION['wrkendser']) == false) { $_SESSION['wrkendser'] = getenv("REMOTE_ADDR"); }

     $_SESSION['wrkdadven']['cod_i']  = 0; $_SESSION['wrkdadven']['nom_i']  = ""; $_SESSION['wrkdadven']['key_i']  = ""; $_SESSION['wrkdadven']['com_i']  = 0;
     $_SESSION['wrkdadven']['key_i'] = (isset($_REQUEST['chave']) == false ? '' : $_REQUEST['chave']);
     $_SESSION['wrkdadven']['cha_i'] = (isset($_REQUEST['indicado']) == false ? '' : $_REQUEST['indicado']);
     if ($_SESSION['wrkdadven']['cha_i'] != '') {
          $_SESSION['wrkdadven']['cod_i']  = retorna_dad('idindicacao', 'tb_indicacao', 'indchave', $_SESSION['wrkdadven']['cha_i']);
          if ($_SESSION['wrkdadven']['cod_i'] == "") {
               $_SESSION['wrkdadven']['cod_i']  = retorna_dad('idindicacao', 'tb_indicacao', 'indapelido', $_SESSION['wrkdadven']['cha_i']);
               $_SESSION['wrkdadven']['nom_i']  = retorna_dad('indnome', 'tb_indicacao', 'indapelido', $_SESSION['wrkdadven']['cha_i']);
               $_SESSION['wrkdadven']['com_i']  = retorna_dad('indcomissao', 'tb_indicacao', 'indapelido', $_SESSION['wrkdadven']['cha_i']);
          } else {
               $_SESSION['wrkdadven']['nom_i']  = retorna_dad('indnome', 'tb_indicacao', 'idindicacao', $_SESSION['wrkdadven']['cod_i']);
               $_SESSION['wrkdadven']['com_i']  = retorna_dad('indcomissao', 'tb_indicacao', 'idindicacao', $_SESSION['wrkdadven']['cod_i']);
          }
          if ($_SESSION['wrkdadven']['nom_i'] == "") {
               $_SESSION['wrkdadven']['cod_i'] = "0";
               $_SESSION['wrkdadven']['cha_i'] = "0";
               $_SESSION['wrkdadven']['com_i'] = "0";
               $_SESSION['wrkdadven']['nom_i'] = '##############################';
          }
     }
     $_SESSION['wrkopcpro'] = retorna_dad('emptipo', 'tb_empresa', 'idempresa', 1);   

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
               <div class="row">
                         <div class="cor-1 col-12 text-center">
                              <strong>
                              <?php 
                                   if ($_SESSION['wrkdadven']['cha_i'] != "") {
                                        echo 'Indicação: ' . $_SESSION['wrkdadven']['nom_i']; 
                                   }
                              ?>
                              </strong>
                         </div>
                    </div>
               <br />
          </div>
     </div>
</body>

</html>