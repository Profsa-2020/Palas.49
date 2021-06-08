<?php
     $usu = 0;
     $pro = 0;
     $txt = '<option value="0" selected="selected">Selecione ...</option>';
     session_start();
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['usu']) == true) { $usu = $_REQUEST['usu']; }
     if (isset($_REQUEST['pro']) == true) { $pro = $_REQUEST['pro']; }
     if (isset($_SESSION['wrkcodpro']) == false) { $_SESSION['wrkcodpro'] = 0; }
     $com  = "Select C.*, P.prodescricao from (tb_conta C left join tb_programa P on C.conprograma = P.idprograma) ";
     $com .= "where protipo = 0 and conusuario = " . $usu;
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['conprograma'] != $_SESSION['wrkcodpro']) {
               $txt .= '<option value ="' . $lin['conprograma'] . '">' . $lin['prodescricao'] . '</option>'; 
          } else {
               $txt .= '<option value ="' . $lin['conprograma'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }

     echo $txt;     

?>