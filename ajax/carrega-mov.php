<?php
     $ope = 0;
     $cod = 0;
     $tab = array();
     session_start();
     $tab['men'] = '';
     $tab['txt'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['ope']) == true) { $ope = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }

     $_SESSION['wrkopereg'] = $ope; $_SESSION['wrkcodreg'] = $cod; 

     $com  = "Select M.*, U.usunome, P.prodescricao, I.intdescricao from (((((tb_movto M left join tb_conta C on M.movconta = C.idconta) ";
     $com .= "left join tb_usuario U on M.movusuario = U.idsenha) ";
     $com .= "left join tb_programa P on M.movprograma = P.idprograma) ";
     $com .= "left join tb_intermediario I on M.movintermediario = I.idintermediario) ";
     $com .= "left join tb_cartao X on M.movcartao = X.idcartao) ";
     $com .= "where idmovto = " . $cod;
     $nro = acessa_reg($com, $reg);            
     if ($nro == 1) {
          if ($reg['movtipo'] == 0) {$ope = "Compra (+)"; }
          if ($reg['movtipo'] == 1) {$ope = "Transferência (-)"; }
          if ($reg['movtipo'] == 2) {$ope = "Transferência (+)"; }
          if ($reg['movtipo'] == 3) {$ope = "Bônus (+)"; } 
          if ($reg['movtipo'] == 4) {$ope = "Bônus (+)"; } 
          if ($reg['movtipo'] == 5) {$ope = "Venda (-)"; } 
          if ($reg['movtipo'] == 6) {$ope = "Passagem (-)"; } 
          if ($reg['movtipo'] == 7) {$ope = "Cartão (+)"; } 
          if ($reg['movtipo'] == 8) {$ope = "Bônus [+]"; } 
          $tab['txt'] .= '<strong><br />';
          $tab['txt'] .= '<h4>Operação: ' . $ope . '</h4><br />';
          $tab['txt'] .= 'Usuário: ' . $reg['usunome'] . '<br />';
          $tab['txt'] .= 'Programa: ' . $reg['prodescricao'] . '<br />';
          $tab['txt'] .= 'Data da Operação: ' . date('d/m/Y',strtotime($reg['movdata'])) . '<br />';
          if ($reg['intdescricao'] != null) {
               $tab['txt'] .= 'Intermediário: ' . $reg['intdescricao'] . '<br />';
          }
          if ($reg['movbonus'] != null) {
               $tab['txt'] .= 'Data do Bônus: ' . date('d/m/Y',strtotime($reg['movbonus'])) . '<br />';
          }
          if ($reg['movvecto'] != null) {
               $tab['txt'] .= 'Data do Recebimento: ' . date('d/m/Y',strtotime($reg['movvecto'])) . '<br />';
          }
          $tab['txt'] .= 'Quantidade: ' . number_format($reg['movquantidade'], 0, ",", ".") . '<br />';
          if ($reg['movtipo'] == 0  || $reg['movtipo'] == 3 || $reg['movtipo'] == 4 || $reg['movtipo'] == 5) {
               $tab['txt'] .= 'Valor: R$ ' . number_format($reg['movvalor'], 2, ",", ".") . '<br />';
          } else {
               $tab['txt'] .= 'Valor: R$ ' . number_format($reg['movquantidade'] * $reg['movcusto'] / 1000, 2, ",", ".") . '<br />';
          }
          $tab['txt'] .= 'Observação: ' . $reg['movobservacao'] . '<br />';
          $tab['txt'] .= '</strong>';
     }

     echo json_encode($tab);     

?>