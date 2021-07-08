<?php
     $tip = 0;
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['tip']) == true) { $tip = $_REQUEST['tip']; }

     if ($tip > 1 && isset($_SESSION['wrkdadven']['nom_c']) == false) {
          $tab['men'] = 'Não foi informado ainda o nome do usuário para o sistema !';
     } 
     if ($tip == 1 && isset($_SESSION['wrkdadven']['nom_c']) == false) {
          $tab['men'] = '*';
     } 
     if ($tab['men'] == "") {
          $tab['nom'] = $_SESSION['wrkdadven']['nom_c']; 
          $tab['ema'] = $_SESSION['wrkdadven']['ema_c'];
          $tab['cel'] = $_SESSION['wrkdadven']['cel_c'];
          $tab['cpf'] = $_SESSION['wrkdadven']['cpf_c'];
          $tab['sen'] = $_SESSION['wrkdadven']['sen_c'];
          if (isset($_SESSION['wrkdadven']['cep_e']) == true) {
               $tab['cep'] = $_SESSION['wrkdadven']['cep_e'];
               $tab['end'] = $_SESSION['wrkdadven']['end_e'];
               $tab['num'] = $_SESSION['wrkdadven']['num_e'];
               $tab['com'] = $_SESSION['wrkdadven']['com_e'];
               $tab['bai'] = $_SESSION['wrkdadven']['bai_e'];
               $tab['cid'] = $_SESSION['wrkdadven']['cid_e'];
               $tab['est'] = $_SESSION['wrkdadven']['est_e'];
               $tab['nas'] = $_SESSION['wrkdadven']['nas_c'];
          }
          if (isset($_SESSION['wrkdadven']['nom_v']) == false) {
               $tab['nom_v'] = $_SESSION['wrkdadven']['nom_c'];
               $tab['cpf_v'] = $_SESSION['wrkdadven']['cpf_c'];     
          } else {
               $tab['nom_v'] = $_SESSION['wrkdadven']['nom_v'];
               $tab['cpf_v'] = $_SESSION['wrkdadven']['cpf_v'];
               $tab['dat_v'] = $_SESSION['wrkdadven']['dat_v'];
               $tab['cvv_v'] = $_SESSION['wrkdadven']['cvv_v'];
               $tab['car_v'] = $_SESSION['wrkdadven']['car_v'];
          }
     }

     echo json_encode($tab);     

?>