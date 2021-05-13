<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['cta']) == true) { $cta = $_REQUEST['cta']; }
     if (isset($_REQUEST['opcao']) == true) { $opc = $_REQUEST['opc']; }
     include_once "../dados.php";
     include_once "../profsa.php";
     $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta']); 
     $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta']); 
     $sql  = "insert into tb_movto (";
     $sql .= "movstatus, ";
     $sql .= "movempresa, ";
     $sql .= "movtipo, ";
     $sql .= "movusuario, ";
     $sql .= "movprograma, ";
     $sql .= "movdata, ";
     $sql .= "movvalor, ";
     $sql .= "movquantidade, ";
     $sql .= "movobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . '0' . "',";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['opc'] . "',";
     $sql .= "'" . $usu . "',";
     $sql .= "'" . $pro . "',";
     $sql .= "'" . inverte_dat(1, $_REQUEST['dat']) . "',";
     $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "',";
     $sql .= "'" . str_replace(".", "", $_REQUEST['qtd']) . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          $tab['men'] = $sql;
     }

     echo json_encode($tab);     

?>