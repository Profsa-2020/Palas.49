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
     if ($_REQUEST['opc'] == '5') {
          if ($_REQUEST['dtb_c'] == "") { $_REQUEST['dtb_c'] = $_REQUEST['dta_c']; }
     }

     include_once "../dados.php";
     include_once "../profsa.php";
     
     if ($_REQUEST['opc'] == '2') {
          $ori = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $des = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['des_t']); 
          if ($ori != $des) {
               $tab['men'] = 'Usuário de origem e destino para transferência diferem !';
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
     if ($_REQUEST['opc'] == '5') {
          if (inverte_dat(0, $_REQUEST['dtb_c']) < inverte_dat(0, $_REQUEST['dta_c'])) {
               $tab['men'] = 'Data do bônus não pode ser menor que data da operação !';
          }
     }
     if ($tab['men'] == '') {
          if ($_REQUEST['opc'] == '1' && $_REQUEST['qtd'] != "" && $_REQUEST['val'] != "") {
               $ret = gravar_com($err);               
          }
          if ($_REQUEST['opc'] == '2' && $_REQUEST['qtd_t'] != "" && $_REQUEST['vlo_t'] != "") {
               $ret = gravar_tra_1($err);               
               $tab['men'] = $err;
               $ret = gravar_tra_2($err);     
               $tab['men'] = $err;
               if ($_REQUEST['vai_t'] != "" && $_REQUEST['vai_t'] != '0') {
                    $ret = gravar_tra_3($err);     
                    $tab['men'] = $err;
               }          
               if ($_REQUEST['vol_t'] != "" && $_REQUEST['vol_t'] != '0') {
                    $ret = gravar_tra_4($err);     
                    $tab['men'] = $err;
               }          
          }
          if ($_REQUEST['opc'] == '3' && $_REQUEST['qtd_v'] != "" && $_REQUEST['val_v'] != "") {
               $ret = gravar_ven($err);               
               $tab['men'] = $err;
          }
          if ($_REQUEST['opc'] == '4' && $_REQUEST['qtd_p'] != "") {
               $ret = gravar_pas($err);               
               $tab['men'] = $err;
          }
          if ($_REQUEST['opc'] == '5' && $_REQUEST['qtd_c'] != "" && $_REQUEST['val_c'] != "") {
               $ret = gravar_car_1($err);               
               if ($_REQUEST['bon_c'] != "" && $_REQUEST['bon_c'] != '0') {
                    $ret = gravar_car_2($err);     
                    $tab['men'] = $err;
               }          
          }
     }
     echo json_encode($tab);     



     function gravar_com(&$err) {
          $ret = 0; $err = "";
          include_once "../dados.php";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . $_REQUEST['cta'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . $_REQUEST['car'] . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dat']) . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "',";
          $sql .= "'" . str_replace(".", "", $_REQUEST['qtd']) . "',";
          $sql .= "'" . $_REQUEST['obs'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_tra_1(&$err) {     // Saída da conta quantidade total
          $ret = 0; $err = "";
          include_once "../dados.php";
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "1" . "',";
          $sql .= "'" . "1" . "',";
          $sql .= "'" . $_REQUEST['cta_t'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dat_t']) . "',";
          $sql .= "'" . limpa_val($_REQUEST['vlo_t']) . "',";
          $sql .= "'" . str_replace(".", "", $_REQUEST['qtd_t']) . "',";
          $sql .= "'" . $_REQUEST['des_t'] . "',";
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
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_tra_2(&$err) {     // Entrada no destino quantidade total
          $ret = 0; $err = "";
          include_once "../dados.php";
          $dat = inverte_dat(0, $_REQUEST['dat_t']);
          $dat = date('Y-m-d', strtotime('+2 days', strtotime($dat)));
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['des_t']); 
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['des_t']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "2" . "',";
          $sql .= "'" . $_REQUEST['des_t'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dat_t']) . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['vlo_t'])) . "',";
          $sql .= "'" . str_replace(".", "", $_REQUEST['qtd_t']) . "',";
          $sql .= "'" . '0' . "',";     // $_REQUEST['cta_t']
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
          $sql .= "'" . $dat . "',";
          $sql .= "'" . $_REQUEST['obs_t'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_tra_3(&$err) {     // Bonus de VAI - percentual
          $ret = 0; $err = "";
          include_once "../dados.php";
          $pre = $_REQUEST['cus_c'] / 1000;
          $qtd = limpa_val($_REQUEST['qtd_t']) * limpa_val($_REQUEST['vai_t']) / 100;
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['des_t']); 
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['des_t']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "3" . "',";
          $sql .= "'" . $_REQUEST['des_t'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dat_t']) . "',";
          $sql .= "'" . ($qtd * $pre) . "',";
          $sql .= "'" . $qtd . "',";
          $sql .= "'" . '0' . "',";     // $_REQUEST['cta_t']
          $sql .= "'" . $_REQUEST['pro_t'] . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['vai_t'])) . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $pre . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dtb_t']) . "',";
          $sql .= "'" . $_REQUEST['obs_t'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_tra_4(&$err) {     // Bonus de VOLTA - percentual
          $ret = 0; $err = "";
          include_once "../dados.php";
          $pre = $_REQUEST['med_t'];
          $qtd = limpa_val($_REQUEST['qtd_t']) * limpa_val($_REQUEST['vol_t']) / 100;
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['cta_t']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "4" . "',";
          $sql .= "'" . $_REQUEST['cta_t'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dat_t']) . "',";
          $sql .= "'" . ($qtd * $pre) . "',";
          $sql .= "'" . $qtd . "',";
          $sql .= "'" . '0' . "',"; //  $_REQUEST['des_t']
          $sql .= "'" . $_REQUEST['pro_t'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['vol_t'])) . "',";
          $sql .= "'" . $pre . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dtb_t']) . "',";
          $sql .= "'" . $_REQUEST['obs_t'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_ven(&$err) {     // Venda
          $ret = 0; $err = "";
          include_once "../dados.php";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . '5' . "',";     // Venda - Saída
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
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_pas(&$err) {     // Passagem
          $ret = 0; $err = "";
          include_once "../dados.php";
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
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . '6' . "',";     // Registro de venda de Passagem por Intermediário
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
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_car_1(&$err) {     // Venda do cartão de crédito
          $ret = 0; $err = ""; 
          $pre = $_REQUEST['med_t'];
          include_once "../dados.php";
          $dat = inverte_dat(0, $_REQUEST['dta_c']);
          $dat = date('Y-m-d', strtotime('+2 days', strtotime($dat)));
          $usu = retorna_dad('conusuario', 'tb_conta', 'idconta', $_REQUEST['des_c']); 
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['des_c']); 
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
          $sql .= "movtipo, ";
          $sql .= "movconta, ";
          $sql .= "movusuario, ";
          $sql .= "movprograma, ";
          $sql .= "movdata, ";
          $sql .= "movvalor, ";
          $sql .= "movquantidade, ";
          $sql .= "movdestino, ";
          $sql .= "movpromocao, ";
          $sql .= "movpercvolta, ";
          $sql .= "movpercvai, ";
          $sql .= "movcusto, ";
          $sql .= "movbonus, ";
          $sql .= "movcartao, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "7" . "',";
          $sql .= "'" . $_REQUEST['des_c'] . "',";
          $sql .= "'" . $usu . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dta_c']) . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val_c'])) . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['qtd_c'])) . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '3' . "',";     // Tipo de promoção - Transferência
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '0' . "',";     // $_REQUEST['bon_c']
          $sql .= "'" . $pre . "',";
          $sql .= "'" . $dat . "',";
          $sql .= "'" . $_REQUEST['car_c'] . "',";
          $sql .= "'" . $_REQUEST['obs_c'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

     function gravar_car_2(&$err) {     // Venda do cartão de crédito - bônus
          $ret = 0; $err = ""; 
          include_once "../dados.php";
          $pre = $_REQUEST['med_t'];
          $pro = retorna_dad('conprograma', 'tb_conta', 'idconta', $_REQUEST['des_c']); 
          $qtd = limpa_val($_REQUEST['qtd_c']) * limpa_val($_REQUEST['bon_c']) / 100;
          $sql  = "insert into tb_movto (";
          $sql .= "movstatus, ";
          $sql .= "movempresa, ";
          $sql .= "movliquidado, ";
          $sql .= "movtipo, ";
          $sql .= "movconta, ";
          $sql .= "movusuario, ";
          $sql .= "movprograma, ";
          $sql .= "movdata, ";
          $sql .= "movvalor, ";
          $sql .= "movquantidade, ";
          $sql .= "movdestino, ";
          $sql .= "movpromocao, ";
          $sql .= "movpercvolta, ";
          $sql .= "movpercvai, ";
          $sql .= "movcusto, ";
          $sql .= "movbonus, ";
          $sql .= "movcartao, ";
          $sql .= "movobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . $_REQUEST['opc'] . "',";
          $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "8" . "',";
          $sql .= "'" . $_REQUEST['des_c'] . "',";
          $sql .= "'" . $_REQUEST['usu_c'] . "',";
          $sql .= "'" . $pro . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dta_c']) . "',";    // Data informada
          $sql .= "'" . ($qtd * $pre) . "',";
          $sql .= "'" . $qtd . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '4' . "',";     // Tipo de promoção - Transferência
          $sql .= "'" . '0' . "',";
          $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['bon_c'])) . "',";
          $sql .= "'" . $pre . "',";
          $sql .= "'" . inverte_dat(1, $_REQUEST['dtb_c']) . "',";    // Data do bônus
          $sql .= "'" . $_REQUEST['car_c'] . "',";
          $sql .= "'" . $_REQUEST['obs_c'] . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y-m-d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               $err = $sql;
          }
          return $ret;
     }

?>