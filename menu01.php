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

     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script> <!-- 2.9.4 / 2.7.0 -->

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Menu - Gerenciamento de Milhas  - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 0;
     include_once "profsa.php";
     $_SESSION['wrknumvol'] = 0;
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrknumusu'] = getmypid();
     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "index.php"</script>');   
     }
     
     $_SESSION['wrkopereg'] = 0; $_SESSION['wrkcodreg'] = 0; $_SESSION['wrklogemp'] = ''; 
     if (isset($_SESSION['wrkendser']) == false) { $_SESSION['wrkendser'] = getenv("REMOTE_ADDR"); }

     $ret = carrega_das($dad);

?>

<body id="box00">
     <h1 class="cab-0">Menu Principal - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container-fluid">
          <div class="row text-center">
               <div class="col-md-12">
                    <h2><span><strong><i class="fa fa-tachometer fa-1g" aria-hidden="true"></i>
                                   DashBoard</strong></span></h2>
               </div>
          </div>
          <br />
     </div>
     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_das(&$dad) {
     $ret = 0;
     $dad = array();

     

     return $ret;
}

?>

</html>