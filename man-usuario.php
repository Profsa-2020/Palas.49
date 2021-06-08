<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Gerenciamento de Milhas - Alexandre Alves Rautemberg" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-11.png" sizes="32x32" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-12.png" sizes="50x50" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-13.png" sizes="192x192" />
     <link rel="apple-touch-icon" href="https://www.admmilhas.com.br/pallas49/img/logo-14.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Usuários - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cel").mask("(00)0-0000-0000");
     $("#tel").mask("(00) 0000-0000");
     $("#val").mask("00/00/0000");
     $("#cpf").mask("000.000.000-00");
     $("#doc").mask("000.000.000-00");
     $("#cep").mask("00000-000");
     $("#ace").mask("000.000", {
          reverse: true
     });
     $("#num").mask("000.000", {
          reverse: true
     });
     $("#cmv").mask("000.000,00", {
          reverse: true
     });
     $("#val").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#cep').blur(function() {
          var cep = $('#cep').val();
          var cep = cep.replace(/[^0-9]/g, '');
          if (cep != '') {
               var url = '//viacep.com.br/ws/' + cep + '/json/';
               $.getJSON(url, function(data) {
                    if ("error" in data) {
                         return;
                    }
                    if ($('#end').val() == "") {
                         $('#end').val(data.logradouro.substring(0, 50));
                    }
                    if ($('#cep').val() == "" || $('#cep').val() == "-") {
                         $('#cep').val(data.cep.replace('.', ''));
                    }
                    if ($('#bai').val() == "") {
                         $('#bai').val(data.bairro.substring(0, 50));
                    }
                    if ($('#cid').val() == "") {
                         $('#cid').val(data.localidade);
                    }
                    if ($('#est').val() == "") {
                         $('#est').val(data.uf);
                    }
               });
          }
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 0; 
     $per = "";
     $del = "";
     $hab = "";
     $bot = "Salvar";
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     if ($_SESSION['wrktipusu'] <= 3) {
          echo '<script>alert("Nível de usuário não permite visualização de log de acesso");</script>';
          echo '<script>history.go(-1);</script>';
     }     
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6, "Entrada na página de manutenção de usuários do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }

     if ($_SESSION['wrktipusu'] <= 4) { $hab = " disabled "; }

     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 0  : $_REQUEST['tip']);
     $sen = (isset($_REQUEST['sen']) == false ? '' : $_REQUEST['sen']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $tel = (isset($_REQUEST['tel']) == false ? '' : $_REQUEST['tel']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $val = (isset($_REQUEST['val']) == false ? '' : $_REQUEST['val']);
     $ace = (isset($_REQUEST['ace']) == false ? 0 : $_REQUEST['ace']);
     $cmv = (isset($_REQUEST['cmv']) == false ? 0 : $_REQUEST['cmv']);
     $cmt = (isset($_REQUEST['cmt']) == false ? 0 : $_REQUEST['cmt']);
     $cep = (isset($_REQUEST['cep']) == false ? "" : $_REQUEST['cep']);
     $num = (isset($_REQUEST['num']) == false ? "" : $_REQUEST['num']);
     $com = (isset($_REQUEST['com']) == false ? "" : $_REQUEST['com']);
     $con = (isset($_REQUEST['con']) == false ? "" : $_REQUEST['con']);
     $cid = (isset($_REQUEST['cid']) == false ? "" : $_REQUEST['cid']);
     $est = (isset($_REQUEST['est']) == false ? "" : $_REQUEST['est']);
     $cpf = (isset($_REQUEST['cpf']) == false ? "" : $_REQUEST['cpf']);
     $doc = (isset($_REQUEST['doc']) == false ? "" : $_REQUEST['doc']);
     $bco = (isset($_REQUEST['bco']) == false ? "" : $_REQUEST['bco']);
     $age = (isset($_REQUEST['age']) == false ? "" : $_REQUEST['age']);
     $cta = (isset($_REQUEST['cta']) == false ? "" : $_REQUEST['cta']);     
     $fav = (isset($_REQUEST['fav']) == false ? '' : str_replace("'", "´", $_REQUEST['fav']));
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));
     $ape = (isset($_REQUEST['ape']) == false ? '' : str_replace("'", "´", $_REQUEST['ape']));
     $end = (isset($_REQUEST['end']) == false ? '' : str_replace("'", "´", $_REQUEST['end']));
     $bai = (isset($_REQUEST['bai']) == false ? '' : str_replace("'", "´", $_REQUEST['bai']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod(); $_SESSION['wrknumvol'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $del = "cor-3";
          $per = ' onclick="return confirm(\'Confirma exclusão de usuário informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrknumvol'] = 1;
               $ret = ler_usuario($cha, $emp, $nom, $ape, $sta, $tip, $sen, $ema, $val, $ace, $tel, $cel, $cep, $end, $num, $com, $bai, $cid, $est, $cmv, $cmt, $cpf, $doc, $bco, $age, $cta, $fav, $obs); 
               if ($_SESSION['wrktipusu'] != 5) {
                    if ($_SESSION['wrkcodemp'] != $emp) {
                         echo '<script>alert("Seu tipo de usuário não pode acessar outro administrador lamento");</script>';
                         echo '<script>history.go(-2);</script>';
                    }
               }
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_usu();
               if ($ret == 0) {
                    $ret = incluir_usu();
                    $ret = gravar_log(11,"Inclusão de novo usuário: " . $nom);
                    $sen = ''; $nom = ''; $ape = ''; $ema = ''; $sta = ''; $tip = 0; $val = ''; $ace = ''; $tel = '';  $cel = ''; $cmv = ''; $cmt = 0; $cep = ''; $end = ''; $num = ''; $com = ''; $bai = ''; $cid = ''; $est = '';$cpf = ''; $doc = ''; $bco = ''; $age = ''; $cta = ''; $fav = ''; $obs = ''; 
                    $cod = ultimo_cod();$_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_usu();
               if ($ret == 0) {
                    $ret = alterar_usu();
                    $ret = gravar_log(12,"Alteração de usuário existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                    $sen = ''; $nom = ''; $ape = ''; $ema = ''; $sta = ''; $tip = 0; $val = ''; $ace = ''; $tel = '';  $cel = ''; $cmv = ''; $cmt = 0; $cep = ''; $end = ''; $num = ''; $com = ''; $bai = ''; $cid = ''; $est = '';$cpf = ''; $doc = ''; $bco = ''; $age = ''; $cta = ''; $fav = ''; $obs = ''; 
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_usu();
               $ret = gravar_log(13,"Exclusão de usuário existente: " . $nom); $_SESSION['wrkmostel'] = 0;
               $sen = ''; $nom = ''; $ape = ''; $ema = ''; $sta = ''; $tip = 0; $val = ''; $ace = ''; $tel = '';  $cel = ''; $cmv = ''; $cmt = 0; $cep = ''; $end = ''; $num = ''; $com = ''; $bai = ''; $cid = ''; $est = '';$cpf = ''; $doc = ''; $bco = ''; $age = ''; $cta = ''; $fav = ''; $obs = ''; 
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">Usuários - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
          <?php 
                    if ($_SESSION['wrktipusu'] != 5) {
                         include_once "cabecalho-1.php"; 
                    } else {
                         include_once "cabecalho-2.php"; 
                    }
               ?>
          </div>
     </div>
     <div class="container">
          <form class="qua-2" name="frmTelMan" action="man-usuario.php" method="POST">
               <p class="lit-4">Manutenção de Usuários &nbsp; &nbsp; &nbsp; <a href="man-usuario.php?ope=1&cod=0"
                         title="Abre janela para criação de novo usuário no sistema"><i class="fa fa-plus-circle fa-1g"
                              aria-hidden="true"></i></a></p>
               <div class="row">
                    <div class="col-md-2">
                         <label>Código</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-6">
                         <label>Nome do Usuário</label>
                         <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                              value="<?php echo $nom; ?>" required />
                    </div>
                    <div class="col-md-4">
                         <label>Nome Curto</label>
                         <input type="text" class="form-control" maxlength="25" id="ape" name="ape"
                              value="<?php echo $ape; ?>" />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-4">
                         <label>Número do CPF</label>
                         <input type="text" class="form-control text-center" maxlength="15" id="cpf" name="cpf"
                              value="<?php echo $cpf; ?>" />
                    </div>
                    <div class="col-md-2">
                         <label>Tipo</label>
                         <select id="tip" name="tip" class="form-control" required>
                              <?php if ($_SESSION['wrktipusu'] >= 5) { ?>
                                   <option value="0" <?php echo ($tip != 0 ? '' : 'selected="selected"'); ?>>
                                        Visitante</option>
                              <?php } ?>                                   
                              <option value="1" <?php echo ($tip != 1 ? '' : 'selected="selected"'); ?>>
                                   Vendedor</option>
                              <option value="2" <?php echo ($tip != 2 ? '' : 'selected="selected"'); ?>>
                                   Titular</option>
                              <option value="3" <?php echo ($tip != 3 ? '' : 'selected="selected"'); ?>>
                                   Gerente</option>
                              <?php if ($_SESSION['wrktipusu'] >= 5) { ?>
                                   <option value="4" <?php echo ($tip != 4 ? '' : 'selected="selected"'); ?>>
                                        Administrador</option>
                                   <option value="5" <?php echo ($tip != 5 ? '' : 'selected="selected"'); ?>>
                                        Usuário Master</option>
                              <?php } ?>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Status</label>
                         <select name="sta" class="form-control" <?php echo $hab; ?> >
                              <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                   Ativo</option>
                              <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                   Bloqueado</option>
                              <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                   Suspenso</option>
                              <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                   Cancelado</option>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Acessos</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="ace" name="ace"
                              value="<?php echo $ace; ?>" <?php echo $hab; ?> />
                    </div>
                    <div class="col-md-2">
                         <label>Validade</label>
                         <input type="text" class="form-control text-center" maxlength="10" id="val" name="val"
                              value="<?php echo $val; ?>" <?php echo $hab; ?> />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                         <label>E-Mail</label>
                         <input type="email" class="form-control" maxlength="50" id="ema" name="ema"
                              value="<?php echo $ema; ?>" required />
                    </div>
                    <div class="col-md-3">
                         <label>Senha</label>
                         <input type="password" class="form-control text-center" maxlength="15" id="sen" name="sen"
                              value="<?php echo $sen; ?>" required />
                    </div>
                    <div class="col-md-3"></div>
               </div>
               <hr />
               <div class="row">
                    <div class="col-md-2">
                         <label>CEP</label>
                         <input type="text" class="form-control" maxlength="9" id="cep" name="cep"
                              value="<?php echo $cep; ?>" required />
                    </div>
                    <div class="col-md-8">
                         <label>Endereço</label>
                         <input type="text" class="form-control" maxlength="50" id="end" name="end"
                              value="<?php echo $end; ?>" />
                    </div>
                    <div class="col-md-2">
                         <label>Número</label>
                         <input type="text" class="form-control" maxlength="6" id="num" name="num"
                              value="<?php echo $num; ?>" />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-10">
                         <label>Complemento</label>
                         <input type="text" class="form-control" maxlength="50" id="com" name="com"
                              value="<?php echo $com; ?>" />
                    </div>
                    <div class="col-md-2"></div>
               </div>
               <div class="row">
                    <div class="col-md-6">
                         <label>Bairro</label>
                         <input type="text" class="form-control" maxlength="50" id="bai" name="bai"
                              value="<?php echo $bai; ?>" />
                    </div>
                    <div class="col-md-5">
                         <label>Cidade</label>
                         <input type="text" class="form-control" maxlength="50" id="cid" name="cid"
                              value="<?php echo $cid; ?>" />
                    </div>
                    <div class="col-md-1">
                         <label>Estado</label>
                         <input type="text" class="form-control text-center" maxlength="2" id="est" name="est"
                              value="<?php echo $est; ?>" />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                         <label>Telefone</label>
                         <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                              value="<?php echo $tel; ?>" />
                    </div>
                    <div class="col-md-3">
                         <label>Celular</label>
                         <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                              value="<?php echo $cel; ?>" required />
                    </div>
                    <div class="col-md-3"></div>
               </div>
               <hr />
               <div class="row">
                    <div class="col-md-1">
                         <label>Banco</label>
                         <input type="text" class="form-control" maxlength="3" id="bco" name="bco"
                              value="<?php echo $bco; ?>" />
                    </div>
                    <div class="col-md-2">
                         <label>Agência</label>
                         <input type="text" class="form-control" maxlength="6" id="cel" name="age"
                              value="<?php echo $age; ?>" />
                    </div>
                    <div class="col-md-3">
                         <label>Conta</label>
                         <input type="text" class="form-control" maxlength="15" id="cta" name="cta"
                              value="<?php echo $cta; ?>" />
                    </div>
                    <div class="col-md-3">
                         <label>CPF</label>
                         <input type="text" class="form-control" maxlength="15" id="doc" name="doc"
                              value="<?php echo $doc; ?>" />
                    </div>
                    <div class="col-md-3">
                         <label>Favorecido</label>
                         <input type="text" class="form-control" maxlength="50" id="fav" name="fav"
                              value="<?php echo $fav; ?>" />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 text-left"><br />
                         <input type="radio" id="val" name="cmt" value="0"
                              <?php echo ($cmt == 0 ? 'checked' : ''); ?> /> Comissão por Valor &nbsp; &nbsp; &nbsp; <br />
                         <input type="radio" id="per" name="cmt" value="1"
                              <?php echo ($cmt == 1 ? 'checked' : ''); ?> /> Comissão por Percentual
                    </div>
                    <div class="col-md-3">
                         <label>Comissão</label>
                         <input type="text" class="form-control text-center" maxlength="5" id="cmv" name="cmv"
                              value="<?php echo $cmv; ?>" required />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-12">
                         <label>Observação para Usuário</label>
                         <textarea class="form-control" rows="3" id="obs" name="obs"><?php echo $obs; ?></textarea>
                    </div>
               </div>
               <br />
               <div class="row">
                    <div class="col-12 text-center">
                         <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                              class="bot-1 <?php echo $del; ?>"><?php echo $bot; ?></button>
                    </div>
               </div>
               <br />
               <div class="row">
                    <div class="col-12 text-center">
                         <?php
                              echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                         ?>
                    </div>
               </div>
          </form>
     </div>
     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = acessa_reg('Select idsenha, usunome from tb_usuario order by idsenha desc Limit 1', $reg);
     if ($nro == 1) {
          $cod = $reg['idsenha'] + 1;
     }
     return $cod;
 }

 function ler_usuario($cha, &$emp, &$nom, &$ape, &$sta, &$tip, &$sen, &$ema, &$val, &$ace, &$tel, &$cel, &$cep, &$end, &$num, &$com, &$bai, &$cid, &$est, &$cmv, &$cmt, &$cpf, &$doc, &$bco, &$age, &$cta, &$fav, &$obs) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_usuario where idsenha = " . $cha, $reg);            
     if ($nro == 0 || $reg == false) {
          echo '<script>alert("Código do usuário informada não cadastrada");</script>';
          $nro = 1;
     } else {
          $cha = $reg['idsenha'];
          $emp = $reg['usuempresa'];
          $nom = $reg['usunome'];
          $ape = $reg['usuapelido'];
          $sta = $reg['usustatus'];
          $tip = $reg['usutipo'];
          $ace = $reg['usuacessos'];
          $sen = base64_decode($reg['ususenha']);
          $tel = $reg['usutelefone'];
          $cel = $reg['usucelular'];
          $ema = $reg['usuemail'];
          $cep = $reg['usucep'];
          $end = $reg['usuendereco'];
          $num = $reg['usunumero'];
          $com = $reg['usucomplemento'];
          $bai = $reg['usubairro'];
          $cid = $reg['usucidade'];
          $est = $reg['usuestado'];
          if ($reg['usucomissaop'] == 0) {
               $cmv = $reg['usucomissaov']; $cmt = 0;
          } else {
               $cmv = $reg['usucomissaop']; $cmt = 1;
          }
          $cpf = $reg['usucpf'];
          $doc = $reg['usudocto'];
          $bco = $reg['usubanco'];
          $age = $reg['usuagencia'];
          $cta = $reg['usuconta'];
          $fav = $reg['usufavorecido'];
          $obs = $reg['usuobservacao'];
          if ($reg['usuvalidade'] != null) { 
               $val = date('d/m/Y',strtotime($reg['usuvalidade'])); 
          }        
     }
     return $cha;
 }

 function consiste_usu() {
     $sta = 0;
     if ($_REQUEST['ape'] == "") {
          $_REQUEST['ape'] = primeiro_nom($_REQUEST['nom']);
     }
     if (trim($_REQUEST['nom']) == "") {
          echo '<script>alert("Nome do Usuário não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['sen']) == "") {
          echo '<script>alert("Senha do Usuário não pode estar em branco");</script>';
          return 2;
     }
     if (trim($_REQUEST['ema']) == "") {
          echo '<script>alert("E-mail do Usuário não pode estar em branco");</script>';
          return 3;
     }
     if (trim($_REQUEST['est']) != "") {
          if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
               echo '<script>alert("Estado da Federação informado não é válido");</script>';
               return 8;
          }
     }
     if (isset($_REQUEST['val']) == true) {
          if ($_REQUEST['val'] != "") {
               if (valida_dat($_REQUEST['val']) != 0) {
                    echo '<script>alert("Data de validade informada no usuário não é valida");</script>';
                    return 4;
               }
          }
     }
     if ($_REQUEST['tip'] > $_SESSION['wrktipusu'] ) {
          echo '<script>alert("Usuário não pode informar nivel de acesso maior que o seu");</script>';
          return 5;
     }
     include_once "dados.php";     
     $nro = acessa_reg("Select idsenha from tb_usuario where usuempresa = " . $_SESSION['wrkcodemp'] . " and usuemail = '" . $_REQUEST['ema'] . "'", $reg);       
     if ($nro > 0) {
          if ($reg['idsenha'] != 0 && $reg['idsenha'] != $_SESSION['wrkcodreg']) {
               echo '<script>alert("E-mail informado para usuário já existe cadastrado");</script>';
               return 6;
          }
     }
     $nro = acessa_reg("Select idsenha from tb_usuario where  usuempresa = " . $_SESSION['wrkcodemp'] . " and usucpf = " . limpa_nro($_REQUEST['cpf']) . "", $reg);       
     if ($nro > 0) {
          if ($reg['idsenha'] != 0 && $reg['idsenha'] != $_SESSION['wrkcodreg']) {
               echo '<script>alert("C.P.F. informado para usuário já existe cadastrado");</script>';
               return 6;
          }
     }
     if ($_REQUEST['cpf'] != "") {
          $sta = valida_cpf($_REQUEST['cpf']);
          if ($sta != 0) {
               echo '<script>alert("Dígito de controle do C.p.f. não está correto");</script>';
               return 8;
          }
     }    
     return $sta;
 }    
     
 function incluir_usu() {
     $ret = 0; $emp = 0; $ace = 999999; $val = date('Y-m-d', strtotime('+365 days'));
     include_once "dados.php";
     if ($_SESSION['wrktipusu'] >= 4) { $emp = $_SESSION['wrkcodemp']; }
     if ($_REQUEST['ape'] == "") { $_REQUEST['ape'] = primeiro_nom($_REQUEST['nom']); }
     if (isset($_REQUEST['ace']) == true) {
          $ace = str_replace(".", "", $_REQUEST['ace']); $ace = str_replace(",", ".", $ace);
     }
     if (isset($_REQUEST['val']) == true) {
          $val = substr($_REQUEST['val'],6,4) . "-" . substr($_REQUEST['val'],3,2) . "-" . substr($_REQUEST['val'],0,2);     
     }
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
     if (isset($_REQUEST['ace']) == true) {
          $sql .= "usuacessos, ";
     }
     if (isset($_REQUEST['val']) == true) {
          $sql .= "usuvalidade, ";
     }
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
     $sql .= "usufavorecido, ";
     $sql .= "usuobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $emp . "',";
     $sql .= "'" . '0' . "',";
     $sql .= "'" . $_REQUEST['nom'] . "',";
     $sql .= "'" . $_REQUEST['ape'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . base64_encode($_REQUEST['sen']) . "',";
     $sql .= "'" . $_REQUEST['tip'] . "',";
     if (isset($_REQUEST['ace']) == true) {
          $sql .= "'" . ($ace == "" || $ace == "0" ? '999999' : $ace) . "',";
     }
     if (isset($_REQUEST['val']) == true) {
          $sql .= "'" . ($val == "--" ? date('Y-m-d', strtotime('+180 days')) : $val) . "',";
     }
     $sql .= "'" . limpa_nro($_REQUEST['cep']) . "',";
     $sql .= "'" . $_REQUEST['end'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['num']) . "',";
     $sql .= "'" . $_REQUEST['com'] . "',";
     $sql .= "'" . $_REQUEST['bai'] . "',";
     $sql .= "'" . $_REQUEST['cid'] . "',";
     $sql .= "'" . $_REQUEST['est'] . "',";
     if ($_REQUEST['cmt'] == '0') {
          $sql .= "'" . ($_REQUEST['cmv'] == "" ? '0' : limpa_val($_REQUEST['cmv'])) . "',";
          $sql .= "'" . "0" . "',";
     } else {
          $sql .= "'" . "0" . "',";
          $sql .= "'" . ($_REQUEST['cmv'] == "" ? '0' : limpa_val($_REQUEST['cmv'])) . "',";
     }
     $sql .= "'" . limpa_nro($_REQUEST['cpf']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['doc']) . "',";
     $sql .= "'" . $_REQUEST['bco'] . "',";
     $sql .= "'" . $_REQUEST['age'] . "',";
     $sql .= "'" . $_REQUEST['cta'] . "',";
     $sql .= "'" . $_REQUEST['fav'] . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $cha, $men);
     if ($ret == true) {
          echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
 }

function alterar_usu() {
     $ret = 0;
     include_once "dados.php";
     if (isset($_REQUEST['ace']) == true) {
          $ace = str_replace(".", "", $_REQUEST['ace']); $ace = str_replace(",", ".", $ace);
     }
     if (isset($_REQUEST['val']) == true) {
          $val = substr($_REQUEST['val'],6,4) . "-" . substr($_REQUEST['val'],3,2) . "-" . substr($_REQUEST['val'],0,2);
     }
     $sql  = "update tb_usuario set ";
     $sql .= "usunome = '". $_REQUEST['nom'] . "', ";
     $sql .= "usuapelido = '". $_REQUEST['ape'] . "', ";
     $sql .= "usucpf = '". limpa_nro($_REQUEST['cpf']) . "', ";
     if (isset($_REQUEST['sta']) == true) {
          $sql .= "usustatus = '". $_REQUEST['sta'] . "', ";
     }
     $sql .= "usutipo = '". $_REQUEST['tip'] . "', ";
     $sql .= "ususenha = '". base64_encode($_REQUEST['sen']) . "', ";
     $sql .= "usuemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "usutelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "usucelular = '". $_REQUEST['cel'] . "', ";
     if (isset($_REQUEST['ace']) == true) {
          $sql .= "usuacessos = '". ($ace == "0" ? '1000000' : $ace) . "', ";
     }
     if (isset($_REQUEST['val']) == true) {
          $sql .= "usuvalidade =  ". ($val == "--" ? 'null' : "'" . $val . "'") . " , ";
     }
     $sql .= "usucep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "usuendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "usunumero = '". limpa_nro($_REQUEST['num']) . "', ";
     $sql .= "usucomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "usubairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "usucidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "usuestado = '". $_REQUEST['est'] . "', ";
     $sql .= "usubanco = '". $_REQUEST['bco'] . "', ";
     $sql .= "usuagencia = '". $_REQUEST['age'] . "', ";
     $sql .= "usuconta = '". $_REQUEST['cta'] . "', ";
     $sql .= "usufavorecido = '". $_REQUEST['fav'] . "', ";
     $sql .= "usudocto = '". limpa_nro($_REQUEST['doc']) . "', ";
     if ($_REQUEST['cmt'] == '0') {
          $sql .= "usucomissaov = '". ($_REQUEST['cmv'] == "" ? '0' : limpa_val($_REQUEST['cmv'])) . "', ";
     } else {
          $sql .= "usucomissaop = '". ($_REQUEST['cmv'] == "" ? '0' : limpa_val($_REQUEST['cmv'])) . "', ";
     }
     $sql .= "usuobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idsenha = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $cha, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     } else {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }   
     
 function excluir_usu() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_usuario where idsenha = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $cha, $men);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }

 ?>


</html>