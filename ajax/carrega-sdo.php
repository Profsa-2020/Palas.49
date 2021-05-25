<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['sal'] = '0';
     $tab['lib'] = '0';
     $tab['med'] = '0';
     $tab['cus'] = '0,00';
     $tab['tot'] = '0,00';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['cta']) == true) { $cta = $_REQUEST['cta']; }

     $sal = saldos_cta($cta, $ent, $sai, $vai, $vol, $val, $tot);
     if ($sal != 0) {
          $tab['sal'] = number_format($sal, 0, ",", ".");
     }

     $tab['qtd'] = $sal; 
     $tab['val'] = $val; 
     $tab['ent'] = $ent; 
     $tab['sai'] = $sai;
     if ($sal != 0) {
          $tab['med'] = $val / $sal;
     }
     $tab['lib'] = number_format($vol, 0, ",", ".");
     $tab['tot'] = number_format($tot, 2, ",", ".");
     if ($sal != 0) {
          $tab['cus'] = number_format($val / $sal * 1000, 2, ",", ".");
     }

     echo json_encode($tab);     

?>