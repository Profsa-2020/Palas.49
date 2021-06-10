<?php
     $opc = 0;
     $sta = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     
     $_SESSION['wrknompro'] = __FILE__;

     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['opc']) == true) { $opc = $_REQUEST['opc']; }
     if ($opc == '1') {
          $nro = acessa_reg("Select * from tb_movto where idmovto = " . $_SESSION['wrkcodreg'], $reg);            
          if ($nro == 1) {
               if ( $reg['movpercvolta'] != 0) {
                    $ret = gravar_vol($opc, $reg);
               }
               if ( $reg['movpercvai'] != 0) {
                    $ret = gravar_vai($opc, $reg);
               }
          }     
     }     
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
     $per = retorna_dad('movpercvolta', 'tb_movto', 'idmovto', $_SESSION['wrkcodreg']); 
     $val = retorna_dad('movvalor', 'tb_movto', 'idmovto', $_SESSION['wrkcodreg']); 
     $qtd = retorna_dad('movquantidade', 'tb_movto', 'idmovto', $_SESSION['wrkcodreg']); 

     $ret = gravar_log(15, "Movimento baixado no sistema - Chave: " . $_SESSION['wrkcodreg'] . " Valor: " . number_format($val, 2, ",", ".") . " Qtde: " . number_format($qtd, 0, ",", ".")  . " Perc: " . number_format($per, 2, ",", "."));  

     echo json_encode($tab);     

     function gravar_vai($opc, $reg) {  // Destino
          $ret = '';
          include_once "../dados.php";
          $qtd = $reg['movquantidade'] * $reg['movpercvai'] / 100;
          $val = $qtd * $reg['movcusto'] / 1000;
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $reg['movdestino']); 
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $reg['movdestino']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movtipo, ";
          $sql .= "movconta, ";
          $sql .= "movusuario, ";
          $sql .= "movprograma, ";
          $sql .= "movcartao, ";
          $sql .= "movdata, ";
          $sql .= "movcusto, ";
          $sql .= "movvalor, ";
          $sql .= "movquantidade, ";
          $sql .= "movpercvai, ";
          $sql .= "movaerea, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . $opc . "',";
          $sql .= "'" . $reg['movdestino'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $reg['movbonus'] . "',";
          $sql .= "'" . $reg['movcusto'] . "',";
          $sql .= "'" . $val . "',";
          $sql .= "'" . $qtd . "',";
          $sql .= "'" . $reg['movpercvai'] . "',";
          $sql .= "'" . '2' . "',";
          $sql .= "'" . ""  . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $ret = $sql;
          }
          return $ret;
     }

     function gravar_vol($opc, $reg) {  //   Original
          $ret = '';
          include_once "../dados.php";
          $pre = round($reg['movvalor'] / $reg['movquantidade'], 4);          
          $qtd = $reg['movquantidade'] * $reg['movpercvolta'] / 100;
          $val = $qtd * $pre;
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movtipo, ";
          $sql .= "movconta, ";
          $sql .= "movusuario, ";
          $sql .= "movprograma, ";
          $sql .= "movcartao, ";
          $sql .= "movdata, ";
          $sql .= "movcusto, ";
          $sql .= "movvalor, ";
          $sql .= "movquantidade, ";
          $sql .= "movpercvolta, ";
          $sql .= "movaerea, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . $opc . "',";
          $sql .= "'" . $reg['movconta'] . "',";
          $sql .= "'" . $reg['movusuario'] . "',";
          $sql .= "'" . $reg['movprograma'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $reg['movbonus'] . "',";
          $sql .= "'" . $pre . "',";
          $sql .= "'" . $val . "',";
          $sql .= "'" . $qtd . "',";
          $sql .= "'" . $reg['movpercvolta'] . "',";
          $sql .= "'" . '4' . "',";
          $sql .= "'" . ""  . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $ret = $sql;
          }
          return $ret;
     }

?>