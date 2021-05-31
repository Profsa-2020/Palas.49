<?php
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (strlen($_REQUEST['end']) <= 5) {
          $tab['men'] = "Endereço do usuário não pode conter menos de 5 caracteres !";
     }
     if (strlen($_REQUEST['cep']) <= 8) {
          $tab['men'] = "C.e.p. do usuáruio não pode conter menos de 8 caracteres !";
     }
     $sta = valida_est($_REQUEST['est']);
     if ($sta == 0) {
          $tab['men'] = "Estado da Federação (UF) informado não está correto !";
     }
     if ($tab['men'] == "") {
          $_SESSION['wrkdadven']['cep_e'] = $_REQUEST['cep'];
          $_SESSION['wrkdadven']['end_e'] = $_REQUEST['end'];
          $_SESSION['wrkdadven']['num_e'] = $_REQUEST['num'];
          $_SESSION['wrkdadven']['com_e'] = $_REQUEST['com'];
          $_SESSION['wrkdadven']['bai_e'] = $_REQUEST['bai'];
          $_SESSION['wrkdadven']['cid_e'] = $_REQUEST['cid'];
          $_SESSION['wrkdadven']['est_e'] = $_REQUEST['est'];
     }
     
     echo json_encode($tab);     

?>