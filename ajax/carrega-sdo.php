<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['sal'] = '';
     $tab['lib'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['cta']) == true) { $cta = $_REQUEST['cta']; }

     $sal = saldos_cta($cta, $ent, $sai, $vai, $vol);
     if ($sal != 0) {
          $tab['sal'] = number_format($sal, 0, ",", ".");
     }

     $tab['qtd'] = $sal; $tab['ent'] = $ent; $tab['sai'] = $sai;

     if ($vol != 0) {
          $tab['lib'] = number_format($vol, 0, ",", ".");
     }
     echo json_encode($tab);     

?>