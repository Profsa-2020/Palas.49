<?php
     $usu = 0;
     $txt = '<option value="0" selected="selected">Selecione ...</option>';
     session_start();
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['usu']) == true) { $usu = $_REQUEST['usu']; }
     $com  = "Select C.*, P.prodescricao from (tb_conta C left join tb_programa P on C.conprograma = P.idprograma) ";
     $com .= "where conusuario = " . $usu;
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $txt .=  '<option value ="' . $lin['conprograma'] . '">' . $lin['prodescricao'] . '</option>'; 
     }

     echo $txt;     

?>