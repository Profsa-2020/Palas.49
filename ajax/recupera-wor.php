<?php
     $ret = 0;
     $ema = "";
     $sen = "";
     $tab = array();
     session_start();
     $tab['sta'] = 0;
     $tab['err'] = '';
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['ema']) == true) { $ema = $_REQUEST['ema']; }
     if (isset($_SESSION['wrkendser']) == false) { $_SESSION['wrkendser'] = getenv("REMOTE_ADDR");; }

     include_once "../dados.php";
     include_once "../profsa.php";
     $nro = acessa_ema($ema, $reg); 
     if ($nro == 0) {
          $tab['sta'] = 1;
          $tab['err'] = "E-Mail informado para recuperação não existe cadastrado no sistema !";
     } 
     if ($nro >= 2) {
          $tab['sta'] = 2;
          $tab['err'] = "Há mais de um e-mail informado no sistema para este parâmetro. !";
     } 
     if ($tab['sta'] == 0) {
          $pas = base64_decode($reg['ususenha']);
          $tex  = '<!DOCTYPE html>';
          $tex .= '<html lang="pt_br">';
          $tex .= '<head>';
          $tex .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
          $tex .= '<title>Gerenciamento de Pontos e Milhas Aéreas</title>';
          $tex .= '</head>';
          $tex .= '<body>'; 
          $tex .= '<a href="http://www.admmilhas.com.br/">';
          $tex .= '<p align="center">';
          $tex .= '<img border="0" src="https://www.admmilhas.com.br/pallas49/img/logo-02.png"></p></a>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '<p align="center"><font size="5" face="Verdana" color="#FF0000"><b>Recuperação de Senha de Usuário</b></font></p>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Nome: ' . $reg['usunome']. '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Login: ' . $reg['usuemail'] . '</b></font></p>';
          $tex .= '<p align="center"><font size="5" face="Verdana"><b>Senha: ' . $pas . '</b></font></p>';
          $tex .= '<p align="center"><font size="4" face="Verdana"><a href="http://www.admmilhas.com.br/">';
          $tex .= 'www.admmilhas.com.br</a></font></p>';
          $tex .= '<p align="center">&nbsp;</p>';
          $tex .= '</body>';
          $tex .= '</html>';

          $asu = "Recuperação de login e senha do sistema Gerenciamento de Pontos e Milhas Aéreas";

          $sta = envia_email($reg['usuemail'], $asu, $tex, $reg['usunome'], '', '');

          if ($sta == 1) {
               $tab['men'] = "Senha e Login de acesso enviado com sucesso !";
               $ret = gravar_log(2,"Solicitação de reenvio de acesso para " . $reg['usunome'] . " - E-Mail: " . $reg['usuemail']);
          }else{
               $tab['err'] = "Erro no envio de login e senha para o usuário, lamento !";
          }
     }
     echo json_encode($tab);     

?>