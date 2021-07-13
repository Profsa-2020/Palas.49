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
     <title>Indicação - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cel").mask("(00)0-0000-0000");
     $("#com").mask("000.000,00", {
          reverse: true
     });     
});

$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [4, 'asc'],
               [2, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Indicações ...",
               "sSearch": "Buscar:",
               "infoFiltered": "(Consulta de _MAX_ total de linhas)",
               "oPaginate": {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Próximo",
                    sPrevious: "Anterior"
               }
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
     $cam = "";
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
               $ret = gravar_log(6, "Entrada na página de manutenção de indicações do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 0 : $_REQUEST['tip']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $com = (isset($_REQUEST['com']) == false ? 0 : $_REQUEST['com']);
     $key = (isset($_REQUEST['key']) == false ? rand(100, 999) : $_REQUEST['key']);
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));
     $ape = (isset($_REQUEST['ape']) == false ? '' : str_replace("'", "´", $_REQUEST['ape']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_indicacao($cha, $nom, $sta, $ema, $cel, $tip, $com, $key, $ape, $obs); 
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $del = "cor-3";
          $per = ' onclick="return confirm(\'Confirma exclusão de Indicação informado em tela ?\')" ';
     }
     if ($ape != "") {        
          $cam = retorna_dad('empsite', 'tb_empresa', 'idempresa', 1);   
          $cam = '<a href="' . $cam . 'venda-1.php?indicado=' . $ape . '" target="_blank">' . $cam . 'venda-1.php?indicado=' . $ape . '</a>'; 
     }

     if (isset($_REQUEST['salvar']) == true) {
          if ($_SESSION['wrkopereg'] == 1) {
               $sta = consiste_ind();
               if ($sta == 0) {
                    $ret = incluir_ind();
                    $cod = ultimo_cod();
                    $ret = gravar_log(11,"Inclusão de novo Indicação: " . $nom); 
                    $nom = ''; $ape = ''; $tip = 0; $sta = 0; $cel = ''; $key = rand(100, 999); $com = 0; $ema = ""; $cam = ""; $obs = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $sta = consiste_ind();
               if ($sta == 0) {
                    $ret = alterar_ind();
                    $cod = ultimo_cod(); 
                    $ret = gravar_log(12,"Alteração de Indicação cadastrado: " . $nom); 
                    $nom = ''; $ape = ''; $tip = 0; $sta = 0; $cel = ''; $key = rand(100, 999); $com = 0; $ema = ""; $cam = ""; $obs = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_ind(); $bot = 'Salvar'; $per = '';
               $cod = ultimo_cod(); 
               $ret = gravar_log(13,"Exclusão de Indicação cadastrado: " . $nom); 
               $nom = ''; $ape = ''; $tip = 0; $sta = 0; $cel = ''; $key = rand(100, 999); $com = 0; $ema = ""; $cam = ""; $obs = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">Indicações - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
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
          <form class="qua-2" name="frmTelMan" action="man-indicacao.php" method="POST">
               <p class="lit-4">Manutenção de Indicações &nbsp; &nbsp; &nbsp; <a href="man-indicacao.php?ope=1&cod=0"
                         title="Abre janela para criação de nova indicação de fidelidade no sistema"><i class="fa fa-plus-circle fa-1g"
                              aria-hidden="true"></i></a></p>
               <div class="row">
                    <div class="col-md-2">
                         <label>Código</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-6">
                         <label>Nome do Indicado</label>
                         <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                              value="<?php echo $nom; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Nome Curto</label>
                         <input type="text" class="form-control" maxlength="25" id="ape" name="ape"
                              value="<?php echo $ape; ?>" />
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
                         <label>Comissao</label>
                         <input type="text" class="form-control text-right" maxlength="12" id="com" name="com"
                              value="<?php echo $com; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Chave</label>
                         <input type="text" class="form-control text-center" maxlength="5" id="key" name="key"
                              value="<?php echo $key; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Celular</label>
                         <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                              value="<?php echo $cel; ?>" required />
                    </div>
                    <div class="col-md-6">
                         <label>E-Mail</label>
                         <input type="email" class="form-control" maxlength="50" id="ema" name="ema"
                              value="<?php echo $ema; ?>" required />
                    </div>
               </div>
               <br />
               <div class="row">
                    <div class="col-md-12 text-center">
                         <strong><?php echo $cam; ?></strong>
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
     <div class="container">
          <div class="tab-1 table-responsive">
               <table id="tab-0" class="table table-sm table-striped">
                    <thead>
                         <tr>
                              <th width="5%">Alterar</th>
                              <th width="5%">Excluir</th>
                              <th width="5%">Número</th>
                              <th>Status</th>
                              <th>Nome do Indicado</th>
                              <th>Apelido</th>
                              <th>Chave</th>
                              <th>Celular</th>
                              <th>E-Mail</th>
                              <th>Comissão</th>
                              <th>Inclusão</th>
                              <th>Alteração</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $ret = carrega_ind();  ?>
                    </tbody>
               </table>
          </div>
     </div>

     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
if ($_SESSION['wrkopereg'] == 1 && $_SESSION['wrkcodreg'] == $cod) {
     exit('<script>location.href = "man-indicacao.php?ope=1&cod=0"</script>');
}

function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = acessa_reg('Select idindicacao from tb_indicacao order by idindicacao desc Limit 1', $reg);
     if ($nro == 1) {
          $cod = $reg['idindicacao'] + 1;
     }        
     return $cod;
}

function consiste_ind() {
     $sta = 0;
     if (trim($_REQUEST['nom']) == "") {
          echo '<script>alert("Nome do Indicado não pode estar em branco");</script>';
          return 1;
     }
     if (strpos($_REQUEST['ape'], " ") > 0) {
          echo '<script>alert("Nome curto informado não pode conter espaços em branco");</script>';
          return 1;
     }
     return $sta;
 }

function carrega_ind() {
     include_once "dados.php";
     $com = "Select * from tb_indicacao order by indnome, idindicacao";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $txt =  '<tr>';
          $txt .= '<td class="text-center"><a href="man-indicacao.php?ope=2&cod=' . $lin['idindicacao'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $txt .= '<td class="text-center"><a href="man-indicacao.php?ope=3&cod=' . $lin['idindicacao'] . '" title="Efetua exclusão do registro informado na linha"><i class="cor-1 large material-icons">delete_forever</i></a></td>';
          $txt .= '<td class="text-center">' . $lin['idindicacao'] . '</td>';
          if ($lin['indstatus'] == 0) {$txt .= "<td>" . "Ativo" . "</td>";}
          if ($lin['indstatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
          if ($lin['indstatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
          if ($lin['indstatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['indnome'] . "</td>";
          $txt .= '<td class="text-left">' . $lin['indapelido'] . "</td>";
          $txt .= '<td class="text-center">' . $lin['indchave'] . "</td>";
          $txt .= '<td class="text-left">' . $lin['indcelular'] . "</td>";
          $txt .= '<td class="text-left">' . $lin['indemail'] . "</td>";
          $txt .= '<td class="text-right">' . number_format($lin['indcomissao'], 2, ",", ".") . '</td>';
          if ($lin['datinc'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datinc'])) . "</td>";
          }
          if ($lin['datalt'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datalt'])) . "</td>";
          }
          $txt .= "</tr>";
          echo $txt;
     }
}

function incluir_ind() {
     $ret = 0;
     include_once "dados.php";
     if ($_REQUEST['ape'] == "") { $_REQUEST['ape'] = primeiro_nom($_REQUEST['nom']); }
     $sql  = "insert into tb_indicacao (";
     $sql .= "indstatus, ";
     $sql .= "indempresa, ";
     $sql .= "indnome, ";
     $sql .= "indapelido, ";
     $sql .= "indchave, ";
     $sql .= "indcelular, ";
     $sql .= "indemail, ";
     $sql .= "indtipo, ";
     $sql .= "indcomissao, ";
     $sql .= "indobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['nom']) . "',";
     $sql .= "'" . limpa_cpo($_REQUEST['ape']) . "',";
     $sql .= "'" . $_REQUEST['key'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . "0" . "',";
     $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['com'])) . "',";
     $sql .= "'" . "" . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
}

function ler_indicacao($cha, &$nom, &$sta, &$ema, &$cel, &$tip, &$com, &$key, &$ape, &$obs) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_indicacao where idindicacao = " . $cha, $reg);            
     if ($nro == 0) {
          echo '<script>alert("Código do Indicação informado não cadastrado no sistema");</script>';
     } else {
          $cha = $reg['idindicacao'];
          $nom = $reg['indnome'];
          $ape = $reg['indapelido'];
          $sta = $reg['indstatus'];
          $ema = $reg['indemail'];
          $cel = $reg['indcelular'];
          $tip = $reg['indtipo'];
          $key = $reg['indchave'];
          $obs = $reg['indobservacao'];
          $com = number_format($reg['indcomissao'], 2, ",", ".");
     }
     return $cha;
 }

 function alterar_ind() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_indicacao set ";
     $sql .= "indstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "indnome = '". $_REQUEST['nom'] . "', ";
     $sql .= "indapelido = '". limpa_cpo($_REQUEST['ape']) . "', ";
     $sql .= "indcomissao = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['com'])) . "', ";
     $sql .= "indcelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "indemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idindicacao = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 } 

 function excluir_ind() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_indicacao where idindicacao = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }


?>

</html>