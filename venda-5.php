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
     <title>Venda V - Gerenciamento de Milhas - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cvv_v").mask("0000");
});

$(document).ready(function() {
     var tipo = 5;

     $('#fas-1').click(function() {
          location.href = "venda-1.php";
     });

     $('#fas-2').click(function() {
          location.href = "venda-2.php";
     });

     $('#fas-3').click(function() {
          location.href = "venda-3.php";
     });

     $('#fas-4').click(function() {
          location.href = "venda-4.php";
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

     $txt = "<strong>" . "Nome: " . $_SESSION['wrkdadven']['nom_c'] . "</strong><br />";
     $txt .= "E-Mail: " . $_SESSION['wrkdadven']['ema_c'] . "<br />";
     $txt .= "Celular: " . $_SESSION['wrkdadven']['cel_c'] . "<br />";
     $txt .= "CPF: " . $_SESSION['wrkdadven']['cpf_c'] . "<br />";
     $txt .= "Endereço: " . $_SESSION['wrkdadven']['end_e'] . ", " . $_SESSION['wrkdadven']['num_e'] . " " . $_SESSION['wrkdadven']['com_e'] . "<br />";
     $txt .= "Bairro: " . $_SESSION['wrkdadven']['bai_e'] . " - Cidade: " . $_SESSION['wrkdadven']['cid_e'] . " - UF: " . $_SESSION['wrkdadven']['est_e'] . "<br />";
     $txt .= 'Plano escolhido: ' . $_SESSION['wrkdadven']['des_v'] . '<br />'; 
     $txt .= 'Valor mensal: R$ ' . number_format($_SESSION['wrkdadven']['val_v'], 2, ",", ".") . '<br />'; 

?>

<body id="box00" class="fun-a">
     <h1 class="cab-0">Venda - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="container">
          <div class="qua-a animated fadeInDown">
               <form id="frmTelVen" name="frmTelVen" action="venda-5.php" method="POST">
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
                              <p id="fas-4" class="fas-c" title="Finalização da adesão ...">4</p>
                         </div>
                         <div class="col-4"></div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-12 text-center">
                              <?php echo $txt; ?>
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-12 text-center">
                              <button type="submit" id="log" name="login" class="bot-a">Login</button>
                         </div>
                    </div>
               </form>
               <br />
          </div>
     </div>
</body>

</html>