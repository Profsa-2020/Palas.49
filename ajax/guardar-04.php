<?php
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (strlen($_REQUEST['nom']) <= 5) {
          $tab['men'] = "Nome no cartão não pode conter menos de 5 caracteres !";
     }
     if (strlen($_REQUEST['cvv']) < 3) {
          $tab['men'] = "Número do CVV não pode conter menos de 3 dígitos !";
     }
     if (strlen($_REQUEST['dat']) < 7) {
          $tab['men'] = "Mês/Ano do cartão não pode conter menos de 7 dígitos !";
     }
     $sta = valida_cpf($_REQUEST['cpf']);
     if ($sta != 0) {
          $tab['men'] = "Dígito de controle do C.p.f. informado não está correto !";
     }
     if ($tab['men'] == "") {
          $mes = substr($_REQUEST['dat'], 0, 2);  
          $ano = substr($_REQUEST['dat'], 3, 4);  
          if ($mes < 1 || $mes > 12 || $ano < date('Y')) {
               $tab['men'] = "Mês/Ano informado para  o cartão não é válido !";
          }
     }
     if ($tab['men'] == "") {
          $ret = enviar_ema();
          $_SESSION['wrkdadven']['nom_v'] = $_REQUEST['nom'];
          $_SESSION['wrkdadven']['cpf_v'] = $_REQUEST['cpf'];
          $_SESSION['wrkdadven']['dat_v'] = $_REQUEST['dat'];
          $_SESSION['wrkdadven']['cvv_v'] = $_REQUEST['cvv'];
          $_SESSION['wrkdadven']['car_v'] = $_REQUEST['car'];
          $ret = gravar_log(26,"Finzalização de Adesão do cliente: " . $_REQUEST['nom'] . " Cpf: " . $_REQUEST['cpf'] . " Valor: " . number_format($_SESSION['wrkdadven']['val_v'], 2, ",", "."));
     }
     
     echo json_encode($tab);     

     function enviar_ema() {
          $erro = "";
          $tex  = '<!DOCTYPE html>';
          $tex .= '<html lang="pt_br">';
          $tex .= '<head>';
          $tex .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
          $tex .= '<title>Gerenciamento de Pontos e Milhas</title>';
          $tex .= '</head>';
          $tex .= '<body>'; 
          $tex .= '<a href="http://www.admmilhas.com.br/">';
          $tex .= '<p align="center">';
          $tex .= '<img border="0" src="https://www.admmilhas.com.br/img/logo-03.png"></p></a>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '<p align="center"><font size="5" face="Verdana" color="#FF0000"><b>Processo de Adesão ao Sistema</b></font></p>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Nome: ' . $_SESSION['wrkdadven']['nom_c'] . '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>CPF: ' . $_SESSION['wrkdadven']['cpf_c'] . '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Celular: ' . $_SESSION['wrkdadven']['cel_c'] . '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Login: ' . $_SESSION['wrkdadven']['ema_c'] . '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Senha: ' . $_SESSION['wrkdadven']['sen_c'] . '</b></font></p>';
          if($_SESSION['wrkdadven']['val_v'] == "") {
               $tex .= '<p align="center"><font size="5" face="Verdana"><b>Valor: R$ ' . '(teste por 30 dias)' . '</b></font></p>';
          } else {
               $tex .= '<p align="center"><font size="5" face="Verdana"><b>Valor: R$ ' . number_format($_SESSION['wrkdadven']['val_v'], 2, ",", ".") . '</b></font></p>';
          } 
          $tex .= '<p align="center"><font size="4" face="Verdana"><a href="http://www.admmilhas.com.br/">';
          $tex .= 'www.admmilhas.com.br</a></font></p>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '</body>';
          $tex .= '</html>';

          $asu = "Processo de Adesão ao Sistema - Gerenciamento de Pontos e Milhas";

          $sta = envia_email($_SESSION['wrkdadven']['ema_c'], $asu, $tex, $_SESSION['wrkdadven']['nom_c'], '', '');

          if ($sta == 1) {
               $erro = "Senha e Login de acesso enviado com sucesso !";
          }else{
               $erro = "Erro no envio de login e senha para o usuário, lamento !";
          }          
          return $erro;
     }

?>