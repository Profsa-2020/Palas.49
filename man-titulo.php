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
     <title>Títulos - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $(".dat").mask("00/00/0000");
     $(".por").mask("00,00", {
          reverse: true
     });
     $(".val").mask("000.000,00", {
          reverse: true
     });
     $(".dat").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

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
     $bot = "Salvar";
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     if ($_SESSION['wrktipusu'] != 5) {
          echo '<script>alert("Tipo de usuário não permite visualização desta opção do menu");</script>';
          echo '<script>history.go(-1);</script>';
     }     
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6, "Entrada na página de manutenção de títulos a receber do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $emi = (isset($_REQUEST['emi']) == false ? '' : $_REQUEST['emi']);
     $ven = (isset($_REQUEST['ven']) == false ? '' : $_REQUEST['ven']);
     $bai = (isset($_REQUEST['bai']) == false ? '' : $_REQUEST['bai']);
     $par = (isset($_REQUEST['par']) == false ? 0 : $_REQUEST['par']);
     $pla = (isset($_REQUEST['pla']) == false ? 0 : $_REQUEST['pla']);
     $ind = (isset($_REQUEST['ind']) == false ? 0 : $_REQUEST['ind']);
     $adm = (isset($_REQUEST['adm']) == false ? 0 : $_REQUEST['adm']);
     $com = (isset($_REQUEST['com']) == false ? 0 : $_REQUEST['com']);
     $val = (isset($_REQUEST['val']) == false ? 0 : $_REQUEST['val']);
     $pag = (isset($_REQUEST['pag']) == false ? 0 : $_REQUEST['pag']);
     $jur = (isset($_REQUEST['jur']) == false ? 0 : $_REQUEST['jur']);
     $des = (isset($_REQUEST['des']) == false ? 0 : $_REQUEST['des']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrknumvol'] = 1;
               $ret = ler_titulo($cha, $sta, $emi, $ven, $bai, $par, $pla, $ind, $adm, $com, $val, $pag, $jur, $des, $obs); 
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $del = "cor-3";
          $per = ' onclick="return confirm(\'Confirma exclusão de Título a Receber informado em tela ?\')" ';
     }

     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1; $_SESSION['wrknumdoc'] = $_SESSION['wrkcodreg'];
          if ($_SESSION['wrkopereg'] == 2) {
               $sta = consiste_tit();
               if ($sta == 0) {
                    $ret = alterar_tit();
                    $nom = retorna_dad('usunome', 'tb_usuario', 'idsenha', $adm); 
                    $ret = gravar_log(12, "Alteração de Título a Receber cadastrado: " . $nom); 
                    $emi = ''; $sta = 0;  $ven = ""; $bai = ""; $par = 0; $val = 0; $pag = 0; $jur = 0; $des = 0; $obs = ''; $ind = 0; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_tit(); $bot = 'Salvar'; $per = '';
               $nom = retorna_dad('usunome', 'tb_usuario', 'idsenha', $adm); 
               $ret = gravar_log(13, "Exclusão de Título a Receber cadastrado: " . $nom); 
               $emi = ''; $sta = 0;  $ven = ""; $bai = ""; $par = 0; $val = 0; $pag = 0; $jur = 0; $des = 0; $obs = ''; $ind = 0; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }

?>

<body id="box00">
     <h1 class="cab-0">Títulos - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
     </div>
     <div class="container">
          <form class="qua-2 qua-3" id="frmTelMan" name="frmTelMan" action="man-titulo.php" method="POST">
               <p class="lit-4">Manutenção de Títulos &nbsp; &nbsp; &nbsp; </p>
               <br />
               <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                         <label>Número</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                         <label>Status</label><br />
                         <select name="sta" class="form-control">
                              <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                   Aberto
                              </option>
                              <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                   Pago
                              </option>
                              <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                   Cancelado
                              </option>
                              <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                   Cortesia
                              </option>
                         </select>
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                         <label>Nome do Contratante</label>
                         <select id="adm" name="adm" class="form-control">
                              <?php $ret = carrega_adm($adm); ?>
                         </select>
                    </div>
                    <div class="col-md-2"></div>
               </div>
               <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                         <label>Plano Contratado</label>
                         <select id="pla" name="pla" class="form-control">
                              <?php $ret = carrega_pla($pla); ?>
                         </select>
                    </div>
                    <div class="col-md-2"></div>
               </div>
               <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                         <label>Nome da Indicação</label>
                         <select id="ind" name="ind" class="form-control">
                              <?php $ret = carrega_ind($ind); ?>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Comissão</label>
                         <input type="text" class="por form-control text-center" maxlength="5" id="com" name="com"
                              value="<?php echo $com; ?>" />
                    </div>
                    <div class="col-md-2"></div>
               </div>
               <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                         <label>Data de Entrada</label>
                         <input type="text" class="dat form-control text-center" maxlength="10" id="emi" name="emi"
                              value="<?php echo $emi; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Data de Vencto</label>
                         <input type="text" class="dat form-control text-center" maxlength="10" id="ven" name="ven"
                              value="<?php echo $ven; ?>" />
                    </div>
                    <div class="col-md-2">
                         <label>Data do Pagto</label>
                         <input type="text" class="dat form-control text-center" maxlength="10" id="bai" name="bai"
                              value="<?php echo $bai; ?>" />
                    </div>
                    <div class="col-md-3"></div>
               </div>
               <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                         <label>Valor</label>
                         <input type="text" class="val form-control text-right" maxlength="12" id="val" name="val"
                              value="<?php echo $val; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Juros</label>
                         <input type="text" class="val form-control text-right" maxlength="12" id="jur" name="jur"
                              value="<?php echo $jur; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Desconto</label>
                         <input type="text" class="val form-control text-right" maxlength="12" id="val" name="des"
                              value="<?php echo $des; ?>" />
                    </div>
                    <div class="col-md-3"></div>
               </div>
               <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                         <label>Observação</label>
                         <textarea class="form-control" rows="3" id="obs" name="obs"><?php echo $obs; ?></textarea>
                    </div>
                    <div class="col-md-2"></div>
               </div>
               <br />
               <div class="row">
                    <div class="col-12 text-center">
                         <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                              class="bot-1 <?php echo $del; ?>"><?php echo $bot; ?></button>
                    </div>
               </div>
               <br />

          </form>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>
<?php
function carrega_adm($adm) {
     $sta = 0;
     include_once "dados.php";    
     if ($adm == 0) {
          echo '<option value="0" selected="selected">Selecione o contratante ...</option>';
     }
     $com = "Select idsenha, usunome from tb_usuario where usutipo >= 3 order by usunome, idsenha";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idsenha'] != $adm) {
               echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pla($pla) {
     $sta = 0;
     include_once "dados.php";    
     if ($pla == 0) {
          echo '<option value="0" selected="selected">Selecione o plano ...</option>';
     }
     $com = "Select idplano, pladescricao from tb_plano order by pladescricao, idplano";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idplano'] != $pla) {
               echo  '<option value ="' . $lin['idplano'] . '">' . $lin['pladescricao'] . " - R$ " . number_format($reg['plavalor'], 2, ",", ".") . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idplano'] . '" selected="selected">' . $lin['pladescricao'] . " - R$ " . number_format($reg['plavalor'], 2, ",", ".") . '</option>';
          }
     }
     return $sta;
}

function carrega_ind($ind) {
     $sta = 0;
     include_once "dados.php";    
     if ($ind == 0) {
          echo '<option value="0" selected="selected">Selecione a indicação ...</option>';
     }
     $com = "Select idindicacao, inddescricao from tb_indicacao order by inddescricao, idindicacao";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idindicacao'] != $ind) {
               echo  '<option value ="' . $lin['idindicacao'] . '">' . $lin['inddescricao'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idindicacao'] . '" selected="selected">' . $lin['inddescricao'] . '</option>';
          }
     }
     return $sta;
}

function ler_titulo(&$cha, &$sta, &$emi, &$ven, &$bai, &$par, &$pla, &$ind, &$adm, &$com, &$val, &$pag, &$jur, &$des, &$obs) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_titulo where idtitulo = " . $cha, $reg);            
     if ($nro == 0) {
          echo '<script>alert("Número do título informado não cadastrado no sistema");</script>';
     } else {
          $cha = $reg['idtitulo'];
          $emi = date('d/m/Y',strtotime($reg['titdataemi']));
          $ven = date('d/m/Y',strtotime($reg['titdataven']));
          if ($reg['titdatabai'] != null) { $bai = date('d/m/Y',strtotime($reg['titdatabai'])); }
          $sta = $reg['titstatus'];
          $par = $reg['titparcela'];
          $pla = $reg['titplano'];
          $ind = $reg['titindicacao'];
          $adm = $reg['titadministrador'];
          $obs = $reg['titobservacao'];
          $com = number_format($reg['titcomissao'], 2, ",", ".");
          $val = number_format($reg['titvalor'], 2, ",", ".");
          $pag = number_format($reg['titpago'], 2, ",", ".");
          $jur = number_format($reg['titjuros'], 2, ",", ".");
          $des = number_format($reg['titdesconto'], 2, ",", ".");
     }
     return $cha;
 }

 function consiste_tit() {
     $sta = 0;
     if (trim($_REQUEST['adm']) == "" || trim($_REQUEST['adm']) == "0") {
          echo '<script>alert("Nome do contratante não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['pla']) == "" || trim($_REQUEST['pla']) == "0") {
          echo '<script>alert("Plnao escolhido não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['emi']) == "") {
          echo '<script>alert("Data de emissão não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['ven']) == "") {
          echo '<script>alert("Data de vencimento não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['val']) == "" || trim($_REQUEST['val']) == "0") {
          echo '<script>alert("Valor do título informado não pode estar em branco");</script>';
          return 1;
     }
     if (valida_dat($_REQUEST['emi']) != 0) {
          echo '<script>alert("Data de entrada informada no usuário não é valida");</script>';
          return 1;
     }
     if (valida_dat($_REQUEST['ven']) != 0) {
          echo '<script>alert("Data de vencimento informada no usuário não é valida");</script>';
          return 1;
     }
     if (strlen($_REQUEST['obs']) > 750) {
          echo '<script>alert("Observação do título não pode ter mais de 750 caracteres");</script>';
          $sta = 1;
     }       
     return $sta;
 }

 function alterar_tit() {
     $ret = 0;
     include_once "dados.php";
     if ($_REQUEST['emi'] == "") { $_REQUEST['emi'] = date('d/m/Y'); }
     if ($_REQUEST['ven'] == "") { $_REQUEST['ven'] = $_REQUEST['emi']; }
     $sql  = "update tb_titulo set ";
     $sql .= "titstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "titplano = '". $_REQUEST['pla'] . "', ";
     $sql .= "titindicacao = '". $_REQUEST['ind'] . "', ";
     $sql .= "titdataemi = '". inverte_dat(1, $_REQUEST['emi']) . "', ";
     $sql .= "titdataven = '". inverte_dat(1, $_REQUEST['ven']) . "', ";
     if ($_REQUEST['bai'] != "") {
          $sql .= "titdatabai = '". inverte_dat(1, $_REQUEST['bai']) . "', ";
     }
     $sql .= "titcomissao = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['com'])) . "', ";
     $sql .= "titvalor = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "', ";
     $sql .= "titjuros = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['jur'])) . "', ";
     $sql .= "titdesconto = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['des'])) . "', ";
     $sql .= "titobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idtitulo = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     } else {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 } 

 function excluir_tit() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_titulo where idtitulo = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
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