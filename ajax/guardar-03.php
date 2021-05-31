<?php
     $pla = 0;
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if ($tab['men'] == "") {
          $pla = $_REQUEST['plano'];          
          $_SESSION['wrkdadven']['pla_v'] = $_REQUEST['plano'];          
          $_SESSION['wrkdadven']['des_v'] = retorna_dad('pladescricao', 'tb_plano', 'idplano', $_REQUEST['plano']); 
          $_SESSION['wrkdadven']['val_v'] = retorna_dad('plavalor', 'tb_plano', 'idplano', $_REQUEST['plano']); 
     }
     if ($pla == 0) {
          $tab['men'] = 'Não informado qual o plano desejado para o sistema !';
     }
     
     echo json_encode($tab);     

?>