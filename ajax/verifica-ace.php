<?php
     $ret = 0;
     $ema = "";
     $sen = "";
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['err'] = '';
     $tab['tip'] = 0;
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['sen']) == true) { $sen = $_REQUEST['sen']; }
     if (isset($_REQUEST['ema']) == true) { $ema = $_REQUEST['ema']; }
     if (isset($_SESSION['wrknomusu']) == false) { $_SESSION['wrknomusu'] = ''; }
     if (isset($_SESSION['wrkemausu']) == false) { $_SESSION['wrkemausu'] = ''; }
     if (isset($_SESSION['wrktipusu']) == false) { $_SESSION['wrktipusu'] = 0; }
     include_once "../dados.php";
     include_once "../profsa.php";
     if (trim($sen) == "") {
          $tab['err'] = 'Senha informada para acesso não pode estar em branco, lamento !';
     }
     if (trim($ema) == "") {
          $tab['err'] = 'E-Mail informada para acesso não pode estar em branco, lamento !';
     }
     if ($tab['err'] == "") {
          $nro = valida_ent($sen, $ema);
          if ($nro > 0 ) {
               $tab['err'] = "E-mail e/ou senha contém caracteres não permitidos, lamento !";
          } 
     }
     if ($tab['err'] == "") {
          $nro = acessa_ini($ema, $sen, $reg); 
          if ($nro == 0) {
               $tab['err'] = "E-mail e/ou senha não contém cadastrado no sistema. lamento !";
          } 
          if ($nro >= 2) {
               $tab['err'] = "E-mail e/ou senha contém mais de um registro no sistema. lamento !";
          }      
     }
     if ($tab['err'] == "") {
          if ($reg['usustatus'] != 0) {
               $tab['err'] = "Status do usuário não permite acesso ao sistema, lamento !";
          } else if ($reg['usuacessos'] != "" && $reg['usuacessos'] != null) {
               if ($reg['usuacessos'] > 2 && $reg['usuacessos'] < 31) {
                    $tab['men'] = "Usuário terá somente mais " . $reg['usuacessos'] . " acessos ao sistema !"; 
               }
               if ($reg['usuacessos'] <= 2) {
                    $tab['err'] = "Número de acessos deste usuário ao sistema esgotado, lamento !";
               }
          }          
          if ($reg['usuvalidade'] != "" && $reg['usuvalidade'] != null) {
               $nro = diferenca_dat("", $reg['usuvalidade']);
               if ($nro > 0 && $nro < 16) {
                    $tab['men'] = "Usuário terá somente mais " . $nro . " dias de acessos ao sistema !"; 
               }
               if ($reg['usuvalidade'] < date('Y-m-d')) {
                    $tab['err'] = "Data final do acesso do usuário ao sistema não permitida, lamento !";
               }
          }     
          if ($tab['err'] == "") {
               if ($reg['usuhoraini'] != null && $reg['usuhorafim'] != null) {
                    $hor = date('H:i');
                    if ($reg['usuhoraini'] != "" && $reg['usuhorafim'] != "") {
                         if ($hor < $reg['usuhoraini'] || $hor > $reg['usuhorafim']) {
                              $tab['err'] = "Período de acesso ao sistema fora de horário para o usuário, lamento !";
                         }
                    }
               }
          }
          if ($tab['err'] == "") {
               $tab['tip'] = $reg['usutipo'];
               $_SESSION['wrkideusu'] = $reg['idsenha']; 
               $_SESSION['wrknomusu'] = $reg['usunome'];
               $_SESSION['wrktipusu'] = $reg['usutipo'];
               $_SESSION['wrkcodemp'] = $reg['usuempresa'];
               $_SESSION['wrkemausu'] = $reg['usuemail'];
               $_SESSION['wrkstausu'] = $reg['usustatus'];
               $_SESSION['wrkdatini'] = $reg['usuvalidade'];
               $_SESSION['wrknumace'] = $reg['usuacessos'];  
               $_SESSION['wrkapeusu'] = $reg['usuapelido'];
               if (isset($_REQUEST['lembrete']) == true) {
                    setcookie("k_ent", $_REQUEST['senha'], time() + 3600 * 24 * 30);  // 60 * 60 * 24 * 30 = 30 dias
                    setcookie("k_end", $_REQUEST['email'], time() + 3600 * 24 * 30);  
               }
               if ($_SESSION['wrknumace'] >= 2) {
                    $com = "Update tb_usuario set usuacessos = " . ($_SESSION['wrknumace'] - 1) . " where idsenha = " . $_SESSION['wrkideusu'];
                    $ret = comando_tab($com, $nro, $ult, $men); 
               }          
               $ret = gravar_log(1,"Entrada para Sistema de Gerenciamento de Milhas - AdmMilhas - Menu.01 - Profsa Informática");  
          }
     }

     echo json_encode($tab);     

?>