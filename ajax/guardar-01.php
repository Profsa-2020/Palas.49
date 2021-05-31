<?php
     session_start();
     $tab = array();
     $tab['men'] = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     date_default_timezone_set("America/Sao_Paulo");
     if (strlen($_REQUEST['nom']) <= 5) {
          $tab['men'] = "Nome do usuário não pode conter menos de 5 caracteres !";
     }
     if (strlen($_REQUEST['nom']) <= 6) {
          $tab['men'] = "Senha de acesso não pode conter menos de 5 caracteres !";
     }
     if (strlen($_REQUEST['cel']) < 15) {
          $tab['men'] = "Número do celular não pode conter menos de 15 dígitos !";
     }
     $sta = valida_cpf($_REQUEST['cpf']);
     if ($sta != 0) {
          $tab['men'] = "Dígito de controle do C.p.f. informado não está correto !";
     }
     if ($tab['men'] == "") {
          $cha = existe_cpf($_REQUEST['cpf'], $nom);
          if ($cha != 0) {
               $tab['men'] = "Número de C.p.f. informado já cadastrado no sistema !";
          }
     }
     if ($tab['men'] == "") {
          $_SESSION['wrkdadven']['nom_c'] = $_REQUEST['nom'];
          $_SESSION['wrkdadven']['ema_c'] = $_REQUEST['ema'];
          $_SESSION['wrkdadven']['cel_c'] = $_REQUEST['cel'];
          $_SESSION['wrkdadven']['cpf_c'] = $_REQUEST['cpf'];
          $_SESSION['wrkdadven']['sen_c'] = $_REQUEST['sen'];
          $ret = gravar_log(25,"Página de Venda por cliente: " . $_REQUEST['nom'] . " E-mail: " . $_REQUEST['ema'] . " Celular: " . $_REQUEST['cel']);  
     }
     
     echo json_encode($tab);     


     function existe_cpf($cpf, &$nom) {
          $ret = 0;
          include_once "../dados.php";
          $nro = acessa_reg("Select idsenha, usunome from tb_usuario where usucpf = '" . limpa_nro($cpf) . "'", $reg);            
          if ($nro == 1) {
               $ret = $reg['idsenha'];
               $nom = $reg['usunome'];
          }
          return $ret;
     }
     
?>