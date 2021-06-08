<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['txt'] = '';
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

     $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $cta); // Somente programa de milhas protipo = 0
     $com = "Select C.idconta, U.usunome, P.prodescricao, P.protipo from ((tb_conta C left join tb_usuario U on C.conusuario = U.idsenha) left join tb_programa P on C.conprograma = P.idprograma) where constatus = 0 and conempresa = " . $_SESSION['wrkcodemp'] . " and protipo = 0 and conusuario = " . $usu . "  order by prodescricao";
     $nro = leitura_reg($com, $reg);     
     foreach ($reg as $lin) {
          $tab['txt'] = '<option value ="' . $lin['idconta'] . '">' . $lin['usunome'] . " - " . $lin['prodescricao']. '</option>'; 
     }     

     echo json_encode($tab);     

?>