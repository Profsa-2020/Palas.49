<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['txt'] = '';
     $tab['sal'] = 0;
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['usu']) == true) { $usu = $_REQUEST['usu']; }
     $com = "Select C.idconta, U.usunome, P.prodescricao, P.protipo from ((tb_conta C left join tb_usuario U on C.conusuario = U.idsenha) left join tb_programa P on C.conprograma = P.idprograma) where constatus = 0 and conempresa = " . $_SESSION['wrkcodemp'] . " and protipo = 0 and conusuario = " . $usu . "  order by prodescricao";
     $nro = leitura_reg($com, $reg);     
     foreach ($reg as $lin) {
          $tab['txt'] .= '<option value ="' . $lin['idconta'] . '">' . $lin['usunome'] . " - " . $lin['prodescricao']. '</option>'; 
     }     
     $com = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movusuario = " . $usu;
     $nro = leitura_reg($com, $lin);     
     foreach ($lin as $reg) {
          if ($reg['movtipo'] == 0) {
               $tab['sal'] += $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 2 || $reg['movtipo'] == 3 || $reg['movtipo'] == 4) {
               if ($reg['movliquidado'] == 1) {
                    $tab['sal'] += $reg['movquantidade'];
               }
          }
          if ($reg['movtipo'] == 1) {
               $tab['sal'] -= $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 5) {
               $tab['sal'] -= $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 7) {
               $tab['sal'] -= $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 8 || $reg['movtipo'] == 9) {
               if ($reg['movliquidado'] == 1) {
                    $tab['sal'] += $reg['movquantidade'];
               }
          }
     }     
     $tab['sdo'] =  number_format($tab['sal'], 0,"," , ".");
     echo json_encode($tab);     

?>