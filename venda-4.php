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
          var nom = $('#nom_v').val();
          var cpf = $('#cpf_v').val();
          var dat = $('#dat_v').val();
          var cvv = $('#cvv_v').val();
          var car = $('#car_v').val();
          $.getJSON("ajax/guardar-04.php", {
                    nom: nom,
                    cpf: cpf,
                    dat: dat,
                    car: car,
                    cvv: cvv
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
                              if ($_SESSION['wrkdadven']['val_v'] == "") {
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
               </form>
               <br />
          </div>
     </div>
</body>

</html>