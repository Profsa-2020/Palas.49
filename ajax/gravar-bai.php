<?php
     $opc = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     
     $_SESSION['wrknompro'] = __FILE__;

     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['opc']) == true) { $opc = $_REQUEST['opc']; }
     
     $sql  = "update tb_movto set ";
     $sql .= "movliquidado = '". "1" . "', ";     
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idmovto = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          $tab['men'] = $sql;
     }
     $_SESSION['wrknumdoc'] = $_SESSION['wrkcodreg'];
     $val = retorna_dad('movvalor', 'tb_movto', 'idmovto', $_SESSION['wrkcodreg']); 
     $qtd = retorna_dad('movquantidade', 'tb_movto', 'idmovto', $_SESSION['wrkcodreg']); 

     $ret = gravar_log(15, "Movimento baixado no sistema - Chave: " . $_SESSION['wrkcodreg'] . " Valor: " . number_format($val, 2, ",", ".") . " Qtde: " . number_format($qtd, 0, ",", "."));  

     echo json_encode($tab);     

?>