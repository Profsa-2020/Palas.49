<?php
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
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
          $ret = gravar_usu();
          $ret = gravar_tit();
          $_SESSION['wrkdadven']['nom_v'] = $_REQUEST['nom'];
          $_SESSION['wrkdadven']['cpf_v'] = $_REQUEST['cpf'];
          $_SESSION['wrkdadven']['dat_v'] = $_REQUEST['dat'];
          $_SESSION['wrkdadven']['cvv_v'] = $_REQUEST['cvv'];
          $_SESSION['wrkdadven']['car_v'] = $_REQUEST['car'];
          $ret = gravar_log(26,"Finalização de Adesão do cliente: " . $_SESSION['wrkdadven']['nom_c'] . " Cpf: " . $_SESSION['wrkdadven']['cpf_c'] . " Valor: " . number_format($_SESSION['wrkdadven']['val_v'], 2, ",", "."));
     }
     
     echo json_encode($tab);     


     
     function enviar_ema() {
          $sta = 0; $erro = "";
          $tex  = '<!DOCTYPE html>';
          $tex .= '<html lang="pt_br">';
          $tex .= '<head>';
          $tex .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
          $tex .= '<title>Gerenciamento de Pontos e Milhas</title>';
          $tex .= '</head>';
          $tex .= '<body>'; 
          $tex .= '<a href="http://www.admmilhas.com.br/">';
          $tex .= '<p align="center">';
          $tex .= '<img border="0" src="https://www.admmilhas.com.br/img/logo-06.png"></p></a>';
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
               $erro = "Dados de adesão do usuário enviado com sucesso !";
          }else{
               $erro = "Erro no envio de processo de adesão para o usuário, lamento !";
          }          
          return $sta;
     }

     function gravar_usu() {
          $ret = 0; $erro = ""; $emp = 0;
          include_once "../dados.php";
          $sql  = "insert into tb_usuario (";
          $sql .= "usuempresa, ";
          $sql .= "usustatus, ";
          $sql .= "usunome, ";
          $sql .= "usuapelido, ";
          $sql .= "usuemail, ";
          $sql .= "usutelefone, ";
          $sql .= "usucelular, ";
          $sql .= "ususenha, ";
          $sql .= "usutipo, ";
          $sql .= "usuacessos, ";
          $sql .= "usuvalidade, ";
          $sql .= "usucep, ";
          $sql .= "usuendereco, ";
          $sql .= "usunumero, ";
          $sql .= "usucomplemento, ";
          $sql .= "usubairro, ";
          $sql .= "usucidade, ";
          $sql .= "usuestado, ";
          $sql .= "usucomissaov, ";
          $sql .= "usucomissaop, ";
          $sql .= "usucpf, ";
          $sql .= "usudocto, ";
          $sql .= "usubanco, ";
          $sql .= "usuagencia, ";
          $sql .= "usuconta, ";
          $sql .= "usunumerotit, ";
          $sql .= "usuobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . $emp . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['nom_c'] . "',";
          $sql .= "'" . primeiro_nom($_SESSION['wrkdadven']['nom_c']) . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['ema_c'] . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['cel_c'] . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['cel_c'] . "',";
          $sql .= "'" . base64_encode($_SESSION['wrkdadven']['sen_c']) . "',";
          if ($_SESSION['wrkdadven']['pla_v'] == "88") {    // Visitante
               $sql .= "'" . '0' . "',";
               $sql .= "'" . '100' . "',";
               $sql .= "'" . date('Y-m-d', strtotime('+30 days')) . "',";     
          } else if ($_SESSION['wrkdadven']['pla_v'] == "99") {  // a combinar
               $sql .= "'" . '0' . "',";
               $sql .= "'" . '100' . "',";
               $sql .= "'" . date('Y-m-d', strtotime('+10 days')) . "',";     
          } else {
               $sql .= "'" . '4' . "',";
               $sql .= "'" . '999999' . "',";
               $sql .= "'" . '2031-12-31' . "',";     
          }
          $sql .= "'" . limpa_nro($_SESSION['wrkdadven']['cep_e']) . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['end_e'] . "',";
          $sql .= "'" . limpa_nro($_SESSION['wrkdadven']['num_e']) . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['com_e'] . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['bai_e'] . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['cid_e'] . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['est_e'] . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . "0" . "',";
          $sql .= "'" . limpa_nro($_SESSION['wrkdadven']['cpf_c']) . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '' . "',";
          $sql .= "'" . '' . "',";
          $sql .= "'" . '' . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['qtd_v'] . "',";
          $sql .= "'" . 'Adesão do cliente efetuada via página de venda em: ' . date('d/m/Y H:i:s') . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $cha, $men);
          $_SESSION['wrkcodreg'] = $cha;     // Chave do usuário criado
          if ($ret == false) {
               $erro = $sql;
          } else {
               $sql  = "update tb_usuario set ";
               $sql .= "usuempresa = '". $_SESSION['wrkcodreg'] . "', ";
               $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
               $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
               $sql .= "where idsenha = " . $_SESSION['wrkcodreg'];
               $ret = comando_tab($sql, $nro, $cha, $men);
               if ($ret == false) {
                    $erro = $sql;
               }          
          }     
          return $ret;
     }

     function gravar_tit() {
          $ret = 0; $erro = ""; 
          include_once "../dados.php";
          $sql  = "insert into tb_titulo (";
          $sql .= "tittipo, ";
          $sql .= "titstatus, ";
          $sql .= "titparcela, ";
          $sql .= "titplano, ";
          $sql .= "titindicacao, ";
          $sql .= "titadministrador, ";
          $sql .= "titdataemi, ";
          $sql .= "titdataven, ";
          $sql .= "titvalor, ";
          $sql .= "titpago, ";
          $sql .= "titcomissao, ";
          $sql .= "titobservacao, ";
          $sql .= "keyinc, ";
          $sql .= "datinc ";
          $sql .= ") value ( ";
          $sql .= "'" . '1' . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . date('m') . "',";
          $sql .= "'" . $_SESSION['wrkdadven']['pla_v'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
          $sql .= "'" . date('Y-m-d') . "',";
          $sql .= "'" . date('Y-m-d', strtotime('+30 days')) . "',";     
          $sql .= "'" . $_SESSION['wrkdadven']['val_v'] . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . 'Adesão do cliente efetuada via página de venda em: ' . date('d/m/Y H:i:s') . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $cha, $men);
          if ($ret == false) {
               $erro = $sql;
          }     
          return $ret;
     }

?>