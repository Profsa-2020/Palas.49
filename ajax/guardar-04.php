<?php
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (strlen($_REQUEST['nom']) <= 5) {
          $tab['men'] = "Nome no cartão não pode conter menos de 5 caracteres !";
     }
     if (strlen($_REQUEST['cvv']) < 3) {
          $tab['men'] = "Número do CVV não pode conter menos de 3 dígitos !";
     }
     if (strlen($_REQUEST['dat']) < 7) {
          $tab['men'] = "Mês/Ano do cartão não pode conter menos de 7 dígitos !";
     }
     $sta = valida_cpf($_REQUEST['cpf']);
     if ($sta != 0) {
          $tab['men'] = "Dígito de controle do C.p.f. informado não está correto !";
     }
     if ($tab['men'] == "") {
          $mes = substr($_REQUEST['dat'], 0, 2);  
          $ano = substr($_REQUEST['dat'], 3, 4);  
          if ($mes < 1 || $mes > 12 || $ano < date('Y')) {
               $tab['men'] = "Mês/Ano informado para  o cartão não é válido !";
          }
     }
     if ($tab['men'] == "") {
          $_SESSION['wrkdadven']['nom_v'] = $_REQUEST['nom'];
          $_SESSION['wrkdadven']['cpf_v'] = $_REQUEST['cpf'];
          $_SESSION['wrkdadven']['dat_v'] = $_REQUEST['dat'];
          $_SESSION['wrkdadven']['cvv_v'] = $_REQUEST['cvv'];
          $_SESSION['wrkdadven']['car_v'] = $_REQUEST['car'];
     }
     
     echo json_encode($tab);     

?>