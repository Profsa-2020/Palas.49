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
     <title>Parâmetros - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#tel").mask("(00) 0000-0000");
     $("#cel").mask("(00)0-0000-0000");
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
     $sta = 0; 
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
               $ret = gravar_log(6, "Entrada na página de manutenção de parâmetros do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 0 : $_REQUEST['tip']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $tel = (isset($_REQUEST['tel']) == false ? '' : $_REQUEST['tel']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $hom = (isset($_REQUEST['hom']) == false ? '' : $_REQUEST['hom']);
     $pro = (isset($_REQUEST['pro']) == false ? '' : $_REQUEST['pro']);
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));

     $cod = ultimo_cod($nro);
     $_SESSION['wrkopereg'] = ($cod == 0 ? 1 : 2);

     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_parametro($cha, $nom, $sta, $tip, $cel, $tel, $ema, $hom, $pro); 
          }
     }

 if (isset($_REQUEST['salvar']) == true) {
      if ($_SESSION['wrkopereg'] == 1) {
           if ($sta == 0) {
                $ret = incluir_par();
                $cod = ultimo_cod($nro);
                $ret = gravar_log(11,"Inclusão de novo Parâmetro: " . $nom); 
                $nom = ''; $tip = 0; $sta = 0; $cel = ''; $ema = ''; $tel = ''; $hom = ""; $pro = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 2) {
           if ($sta == 0) {
                $ret = alterar_par();
                $cod = ultimo_cod($nro); 
                $ret = gravar_log(12,"Alteração de Parâmetro cadastrado: " . $nom); 
                $nom = ''; $tip = 0; $sta = 0; $cel = ''; $ema = ''; $tel = ''; $hom = ""; $pro = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
}
?>

<body id="box00">
     <h1 class="cab-0">Planos - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
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
          <form class="qua-2" name="frmTelMan" action="man-parametro.php" method="POST">
               <p class="lit-4">Manutenção de Parâmetros </p>
               <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                         <label>Código</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-5"></div>
               </div>
               <div class="row">
                    <div class="col-md-8">
                         <label>Nome da Empresa</label>
                         <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                              value="<?php echo $nom; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Tipo</label><br />
                         <select name="tip" class="form-control">
                              <option value="0" <?php echo ($tip != 0 ? '' : 'selected="selected"'); ?>>
                                   Homologação
                              </option>
                              <option value="1" <?php echo ($tip != 1 ? '' : 'selected="selected"'); ?>>
                                   Produção
                              </option>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Status</label><br />
                         <select name="sta" class="form-control">
                              <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                   Ativo
                              </option>
                              <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                   Bloqueado
                              </option>
                              <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                   Suspenso
                              </option>
                              <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                   Cancelado
                              </option>
                         </select>
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-2">
                         <label>Celular</label>
                         <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                              value="<?php echo $cel; ?>"  />
                    </div>
                    <div class="col-md-2">
                         <label>Telefone</label>
                         <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                              value="<?php echo $tel; ?>"  />
                    </div>
                    <div class="col-md-8">
                         <label>E-Mail</label>
                         <input type="email" class="form-control" maxlength="50" id="ema" name="ema"
                              value="<?php echo $ema; ?>" required />
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-6">
                         <label>Token de Produção</label>
                         <input type="text" class="form-control" maxlength="50" id="pro" name="pro"
                              value="<?php echo $pro; ?>"  required />
                    </div>
                    <div class="col-md-6">
                         <label>Token de Homologação</label>
                         <input type="text" class="form-control" maxlength="50" id="hom" name="hom"
                              value="<?php echo $hom; ?>"  required />
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
          </form>
     </div>
     <br /><br />
</body>
<?php

function ultimo_cod(&$nro) {
     $cod = 0;
     include_once "dados.php";
     $nro = acessa_reg('Select idempresa from tb_empresa order by idempresa', $reg);
     if ($nro == 1) {
          $cod = $reg['idempresa'];
     }        
     $_SESSION['wrkcodreg'] = $cod;
     return $cod;
}

function ler_parametro($cha, &$nom, &$sta, &$tip, &$cel, &$tel, &$ema, &$hom, &$pro) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_empresa where idempresa = " . $cha, $reg);            
     if ($nro == 0) {
          echo '<script>alert("Código do Parâmetro informado não cadastrado no sistema");</script>';
     } else {
          $cha = $reg['idempresa'];
          $nom = $reg['empnome'];
          $sta = $reg['empstatus'];
          $tip = $reg['emptipo'];
          $cel = $reg['empcelular'];
          $tel = $reg['emptelefone'];
          $ema = $reg['empemail'];
          $hom = $reg['emptokenhom'];
          $pro = $reg['emptokenpro'];
     }
     return $cha;
 }

 function incluir_par() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "insert into tb_empresa (";
     $sql .= "empstatus, ";
     $sql .= "empnome, ";
     $sql .= "emptipo, ";
     $sql .= "empemail, ";
     $sql .= "emptokenhom, ";
     $sql .= "emptokenpro, ";
     $sql .= "empcelular, ";
     $sql .= "emptelefone, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['nom']) . "',";
     $sql .= "'" . $_REQUEST['tip'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['hom'] . "',";
     $sql .= "'" . $_REQUEST['pro'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
}

function alterar_par() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_empresa set ";
     $sql .= "empstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "empnome = '". $_REQUEST['nom'] . "', ";
     $sql .= "emptipo = '". $_REQUEST['tip'] . "', ";
     $sql .= "empemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "emptokenhom = '". $_REQUEST['hom'] . "', ";
     $sql .= "emptokenpro = '". $_REQUEST['pro'] . "', ";
     $sql .= "empcelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "emptelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idempresa = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }
?>

</html>