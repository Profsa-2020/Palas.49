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
          if ($reg['movstatus'] == 0) {$ope = "Compra (+)"; }
          if ($reg['movstatus'] == 1) {$ope = "Transferência (*)"; }
          if ($reg['movstatus'] == 2) {$ope = "Venda (-)"; } 
          if ($reg['movstatus'] == 3) {$ope = "Passagem (-)"; } 

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
          $tab['txt'] .= 'Valor: R$ ' . number_format($reg['movquantidade'] * $reg['movcusto'] / 1000, 2, ",", ".") . '<br />';
          if ($reg['movstatus'] == 1) {
               $tab['txt'] .= 'Ida: ' . number_format($reg['movpercvai'], 0, ",", ".") . ' % - Quantidade: ' . number_format($reg['movquantidade'] * $reg['movpercvai'] / 100 , 0, ",", ".") . '<br />';
               $tab['txt'] .= 'Volta: ' . number_format($reg['movpercvolta'], 0, ",", ".") . ' % - Quantidade: ' . number_format($reg['movquantidade'] * $reg['movpercvolta'] / 100 , 0, ",", ".") . '<br />';
          }
          $tab['txt'] .= 'Observação: ' . $reg['movobservacao'] . '<br />';
          $tab['txt'] .= '</strong>';
     }

     echo json_encode($tab);     

?>