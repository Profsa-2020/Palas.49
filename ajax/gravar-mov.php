<?php
     $ret = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['cta']) == true) { $cta = $_REQUEST['cta']; }
     if (isset($_REQUEST['opcao']) == true) { $opc = $_REQUEST['opc']; }

     if ($_REQUEST['opc'] == '2') {
          if (isset($_REQUEST['vai_t']) == true) {
               if ($_REQUEST['vai_t'] == "") { $_REQUEST['vai_t'] = 0; }
          }
          if (isset($_REQUEST['vol_t']) == true) {
               if ($_REQUEST['vol_t'] == "") { $_REQUEST['vol_t'] = 0; }
          }
          if ($_REQUEST['dtb_t'] == "") { $_REQUEST['dtb_t'] = $_REQUEST['dat_t']; }
     }

     if ($_REQUEST['opc'] == '3') {
          if ($_REQUEST['rec_v'] == "") { $_REQUEST['rec_v'] = $_REQUEST['dat_v']; }
     }

     include_once "../dados.php";
     include_once "../profsa.php";
     
     if ($_REQUEST['opc'] == '2') {
          $ori = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $des = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_d']); 
          if ($ori != $des) {
               $tab['men'] = 'Usuário de origem e destino para transferência não podem ser diferetes !';
          }
          if (inverte_dat(0, $_REQUEST['dtb_t']) < inverte_dat(0, $_REQUEST['dat_t'])) {
               $tab['men'] = 'Data do bônus não pode ser menor que data da transferência !';
          }
     }
     if ($_REQUEST['opc'] == '3') {
          if (inverte_dat(0, $_REQUEST['rec_v']) < inverte_dat(0, $_REQUEST['dat_v'])) {
               $tab['men'] = 'Data de recebimento não pode ser menor que data da venda !';
          }
     }
     if ($tab['men'] == '') {
          if ($_REQUEST['opc'] == '1' && $_REQUEST['qtd'] != "" && $_REQUEST['val'] != "") {
               $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta']); 
               $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta']); 
               $sql  = "insert into tb_movto (";
               $sql .= "movstatus, ";
               $sql .= "movempresa, ";
               $sql .= "movtipo, ";
               $sql .= "movconta, ";
               $sql .= "movusuario, ";
               $sql .= "movprograma, ";
               $sql .= "movcartao, ";
               $sql .= "movdata, ";
               $sql .= "movvalor, ";
               $sql .= "movquantidade, ";
               $sql .= "movobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . '0' . "',";     // Compra - Entrada
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_REQUEST['opc'] . "',";
               $sql .= "'" . $_REQUEST['cta'] . "',";
               $sql .= "'" . $usu . "',";
               $sql .= "'" . $pro . "',";
               $sql .= "'" . $_REQUEST['car'] . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['dat']) . "',";
               $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "',";
               $sql .= "'" . str_replace(".", "", $_REQUEST['qtd']) . "',";
               $sql .= "'" . $_REQUEST['obs'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = comando_tab($sql, $nro, $ult, $men);
          }
          if ($_REQUEST['opc'] == '2' && $_REQUEST['qtd_t'] != "" && $_REQUEST['val_t'] != "") {
               $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
               $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
               $sql  = "insert into tb_movto (";
               $sql .= "movstatus, ";
               $sql .= "movempresa, ";
               $sql .= "movtipo, ";
               $sql .= "movconta, ";
               $sql .= "movusuario, ";
               $sql .= "movprograma, ";
               $sql .= "movdata, ";
               $sql .= "movvalor, ";
               $sql .= "movquantidade, ";
               $sql .= "movdestino, ";
               $sql .= "movpromocao, ";
               $sql .= "movpercvai, ";
               $sql .= "movpercvolta, ";
               $sql .= "movcusto, ";
               $sql .= "movbonus, ";
               $sql .= "movobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . '1' . "',";     // Transferência
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_REQUEST['opc'] . "',";
               $sql .= "'" . $_REQUEST['cta_t'] . "',";
               $sql .= "'" . $usu . "',";
               $sql .= "'" . $pro . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['dat_t']) . "',";
               $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val_t'])) . "',";
               $sql .= "'" . str_replace(".", "", $_REQUEST['qtd_t']) . "',";
               $sql .= "'" . $_REQUEST['cta_d'] . "',";
               $sql .= "'" . $_REQUEST['pro_t'] . "',";
               if (isset($_REQUEST['vai_t']) == false) {
                    $sql .= "'" . '0' . "',";
               } else {
                    $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['vai_t'])) . "',";
               }
               if (isset($_REQUEST['vol_t']) == false) {
                    $sql .= "'" . '0' . "',";
               } else {
                    $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['vol_t'])) . "',";
               }
               $sql .= "'" . $_REQUEST['cus_c'] . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['dtb_t']) . "',";
               $sql .= "'" . $_REQUEST['obs_t'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = comando_tab($sql, $nro, $ult, $men);
          }
          if ($_REQUEST['opc'] == '3' && $_REQUEST['qtd_v'] != "" && $_REQUEST['val_v'] != "") {
               $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_v']); 
               $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta_v']); 
               $sql  = "insert into tb_movto (";
               $sql .= "movstatus, ";
               $sql .= "movempresa, ";
               $sql .= "movtipo, ";
               $sql .= "movconta, ";
               $sql .= "movusuario, ";
               $sql .= "movprograma, ";
               $sql .= "movintermediario, ";
               $sql .= "movdata, ";
               $sql .= "movvecto, ";
               $sql .= "movvalor, ";
               $sql .= "movquantidade, ";
               $sql .= "movobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . '2' . "',";     // Venda - Saída
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_REQUEST['opc'] . "',";
               $sql .= "'" . $_REQUEST['cta_v'] . "',";
               $sql .= "'" . $usu . "',";
               $sql .= "'" . $pro . "',";
               $sql .= "'" . $_REQUEST['int_v'] . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['dat_v']) . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['rec_v']) . "',";
               $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val_v'])) . "',";
               $sql .= "'" . str_replace(".", "", $_REQUEST['qtd_v']) . "',";
               $sql .= "'" . $_REQUEST['obs_v'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = comando_tab($sql, $nro, $ult, $men);
          }
          if ($_REQUEST['opc'] == '4' && $_REQUEST['qtd_p'] != "") {
               $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_p']); 
               $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta_p']); 
               $sql  = "insert into tb_movto (";
               $sql .= "movstatus, ";
               $sql .= "movempresa, ";
               $sql .= "movtipo, ";
               $sql .= "movconta, ";
               $sql .= "movusuario, ";
               $sql .= "movprograma, ";
               $sql .= "movintermediario, ";
               $sql .= "movdata, ";
               $sql .= "movlocalizador, ";
               $sql .= "movnumerocpf, ";
               $sql .= "movquantidade, ";
               $sql .= "movobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . '3' . "',";     // Registro de venda de Passagem por Intermediário
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_REQUEST['opc'] . "',";
               $sql .= "'" . $_REQUEST['cta_p'] . "',";
               $sql .= "'" . $usu . "',";
               $sql .= "'" . $pro . "',";
               $sql .= "'" . $_REQUEST['int_p'] . "',";
               $sql .= "'" . inverte_dat(1, $_REQUEST['dat_p']) . "',";
               $sql .= "'" . $_REQUEST['loc_p'] . "',";
               $sql .= "'" . $_REQUEST['cpf_p'] . "',";
               $sql .= "'" . str_replace(".", "", $_REQUEST['qtd_p']) . "',";
               $sql .= "'" . $_REQUEST['obs_p'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = comando_tab($sql, $nro, $ult, $men);
          }
          if ($ret == false) {
               $tab['men'] = $sql;
          }
     }
     echo json_encode($tab);     

?>