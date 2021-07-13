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
     <title>Planos - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#num").mask("000");
     $("#val").mask("000.000,00", {
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
               "infoEmpty": "Sem registros de Planos ...",
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
     $dad = array();
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
               $ret = gravar_log(6, "Entrada na página de manutenção de planos do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumses']) == false) { $_SESSION['wrknumses'] = ''; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $num = (isset($_REQUEST['num']) == false ? 0 : $_REQUEST['num']);
     $val = (isset($_REQUEST['val']) == false ? 0 : $_REQUEST['val']);
     $tok = (isset($_REQUEST['tok']) == false ? '' : $_REQUEST['tok']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     if ($_SESSION['wrknumses'] == "") {
          $ret = sessao_pag($dad);
          $_SESSION['wrknumses'] = $dad['ses'];
     }
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_plano($cha, $des, $sta, $num, $val, $tok); 
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $del = "cor-3";
          $per = ' onclick="return confirm(\'Confirma exclusão de Plano informado em tela ?\')" ';
     }

 if (isset($_REQUEST['salvar']) == true) {
      if ($_SESSION['wrkopereg'] == 1) {
           $sta = consiste_pla();
           if ($sta == 0) {
                $ret = incluir_pla();
                $cod = ultimo_cod();
                $ret = gravar_log(11,"Inclusão de novo Plano: " . $des); 
                $des = ''; $num = 0; $sta = 0; $val = 0; $tok = ''; $del = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 2) {
           $sta = consiste_pla();
           if ($sta == 0) {
                $ret = alterar_pla();
                $cod = ultimo_cod(); 
                $ret = criacao_pla($dad);    // Cria o plano no PagSeguro, só que está sometne localhost 
                $ret = gravar_log(12,"Alteração de Plano cadastrado: " . $des); 
                $des = ''; $num = 0; $sta = 0;  $del = ""; $val = 0; $tok = ''; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 3) {
           $ret = excluir_pla(); $bot = 'Salvar'; $per = '';
           $cod = ultimo_cod(); 
           $ret = gravar_log(13,"Exclusão de Plano cadastrado: " . $des); 
           $des = ''; $num = 0; $sta = 0;  $del = ""; $val = 0; $tok = ''; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
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
          <form class="qua-2" name="frmTelMan" action="man-plano.php" method="POST">
               <p class="lit-4">Manutenção de Planos &nbsp; &nbsp; &nbsp; <a href="man-plano.php?ope=1&cod=0"
                         title="Abre janela para criação de novo plano de fidelidade no sistema"><i class="fa fa-plus-circle fa-1g"
                              aria-hidden="true"></i></a></p>
               <div class="row">
                    <div class="col-md-2">
                         <label>Código</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-6">
                         <label>Descrição do Plano</label>
                         <input type="text" class="form-control" maxlength="50" id="des" name="des"
                              value="<?php echo $des; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Nº de Usuários</label><br />
                         <input type="text" class="form-control text-center" maxlength="3" id="num" name="num"
                              value="<?php echo $num; ?>" required />
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
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                         <label>Token</label>
                         <input type="text" class="form-control" maxlength="150" id="tok" name="tok"
                              value="<?php echo $tok; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Valor</label>
                         <input type="text" class="form-control text-center" maxlength="12" id="val" name="val"
                              value="<?php echo $val; ?>" required />
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
                              <th>Descrição do Plano</th>
                              <th>Usuários</th>
                              <th>Valor</th>
                              <th>Token</th>
                              <th>Inclusão</th>
                              <th>Alteração</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $ret = carrega_pla();  ?>
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
     exit('<script>location.href = "man-plano.php?ope=1&cod=0"</script>');
}

function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = acessa_reg('Select idplano from tb_plano order by idplano desc Limit 1', $reg);
     if ($nro == 1) {
          $cod = $reg['idplano'] + 1;
     }        
     return $cod;
}

function consiste_pla() {
     $sta = 0;
     if (trim($_REQUEST['des']) == "") {
          echo '<script>alert("Descrição do Plano não pode estar em branco");</script>';
          return 1;
     }
     return $sta;
 }

function carrega_pla() {
     include_once "dados.php";
     $com = "Select * from tb_plano order by pladescricao, idplano";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $txt =  '<tr>';
          $txt .= '<td class="text-center"><a href="man-plano.php?ope=2&cod=' . $lin['idplano'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $txt .= '<td class="text-center"><a href="man-plano.php?ope=3&cod=' . $lin['idplano'] . '" title="Efetua exclusão do registro informado na linha"><i class="cor-1 large material-icons">delete_forever</i></a></td>';
          $txt .= '<td class="text-center">' . $lin['idplano'] . '</td>';
          if ($lin['plastatus'] == 0) {$txt .= "<td>" . "Ativo" . "</td>";}
          if ($lin['plastatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
          if ($lin['plastatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
          if ($lin['plastatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['pladescricao'] . "</td>";
          $txt .= '<td class="text-center">' . $lin['planumerotit'] . "</td>";
          $txt .= '<td class="text-right">' . number_format($lin['plavalor'], 2, ",", ".") . '</td>';
          $txt .= '<td class="text-left">' . $lin['platoken'] . "</td>";
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

function incluir_pla() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "insert into tb_plano (";
     $sql .= "plastatus, ";
     $sql .= "plaempresa, ";
     $sql .= "pladescricao, ";
     $sql .= "platoken, ";
     $sql .= "planumerotit, ";
     $sql .= "plavalor, ";
     $sql .= "plaobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['des']) . "',";
     $sql .= "'" . $_REQUEST['tok'] . "',";
     $sql .= "'" . $_REQUEST['num'] . "',";
     $sql .= "'" . str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "',";
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

function ler_plano(&$cha, &$des, &$sta, &$num, &$val, &$tok) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_plano where idplano = " . $cha, $reg);            
     if ($nro == 0) {
          echo '<script>alert("Código do Plano informado não cadastrado no sistema");</script>';
     } else {
          $cha = $reg['idplano'];
          $des = $reg['pladescricao'];
          $sta = $reg['plastatus'];
          $tok = $reg['platoken'];
          $num = $reg['planumerotit'];
          $val = number_format($reg['plavalor'], 2, ",", ".");
     }
     return $cha;
 }

 function alterar_pla() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_plano set ";
     $sql .= "plastatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "pladescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "platoken = '". $_REQUEST['tok'] . "', ";
     $sql .= "plavalor = '". str_replace(",", ".", str_replace(".", "", $_REQUEST['val'])) . "', ";
     $sql .= "planumerotit = '". $_REQUEST['num'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idplano = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 } 

 function excluir_pla() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_plano where idplano = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }

 function sessao_pag(&$dad) {
     $sta = 0; $dad['err'] = ""; $dad['ses'] = "";
     $dad['ema'] = retorna_dad('empemail', 'tb_empresa', 'idempresa', 1); 
     if ($_SESSION['wrkopcpro']  == 1) {
          $dad['tok'] =  retorna_dad('emptokenpro', 'tb_empresa', 'idempresa', 1); 
          $url = "https://ws.pagseguro.uol.com.br/v2/sessions?" . 'email=' . $dad['ema'] . '&token=' . $dad['tok'];
     } else {
          $dad['tok'] =  retorna_dad('emptokenhom', 'tb_empresa', 'idempresa', 1); 
          $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?" . 'email=' . $dad['ema'] . '&token=' . $dad['tok'];
     }
     if ($dad['ema'] == "") {
          echo '<script>alert("E-Mail informado na empresa para PagSeguro em branco !");</script>';
          return 1;
     }

     $cur  = curl_init($url);
     curl_setopt($cur, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencode; charset=UTF-8"));
     curl_setopt($cur, CURLOPT_POST, 1);
     if ($_SESSION['wrkopcpro']  == 1) {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, true);
     } else {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
     }
     curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
     
     $ret = curl_exec($cur);
     curl_close($cur);
     if ($ret == false) { 
          echo '<script>alert("Acesso a PagSeguro para identificação não foi autorizado");</script>';
          return 2;
     }
     if ($ret == 'Unauthorized') { 
          echo '<script>alert("Informações para logar no PagSeguro não estão corretas");</script>';
          return 3;
     }
     $xml = simplexml_load_string($ret);
     if (isset($xml->error) == true) {
          $sta = 4;
          $dad['err'] = (string) $xml->error->code;
     }else{
          $dad['ses'] = (string) $xml->id;
     }
     return $sta;
}

function criacao_pla(&$dad) {

     if ($_SESSION['wrkendser'] != '127.0.0.1') { return 1; }    // Só cria o plano se estiver rodando localhost 

     $sta = 0; $dad['cod'] = ''; $dad['dat'] = '';
     $tax = retorna_dad('emptaxa', 'tb_empresa', 'idempresa', 1); 
     $ema = retorna_dad('empemail', 'tb_empresa', 'idempresa', 1); 

     if ($_SESSION['wrkopcpro']  == 1) {
          $tok = retorna_dad('emptokenpro', 'tb_empresa', 'idempresa', 1); 
     } else {
          $tok = retorna_dad('emptokenhom', 'tb_empresa', 'idempresa', 1); 
     }

     $val = str_replace(".", "", $_REQUEST['val']); $val = str_replace(",", ".", $val);
     $pla['reference'] = 'Ref_' . str_pad($_SESSION['wrkcodreg'], 3, "0", STR_PAD_LEFT);
     $pla['preApproval']['name'] = limpa_cpo($_REQUEST['des']);
     $pla['preApproval']['charge'] = 'AUTO';
     $pla['preApproval']['period'] = 'MONTHLY';
     $pla['preApproval']['amountPerPayment'] = $val;
     $pla['preApproval']['membershipFee'] = $tax;
     $pla['preApproval']['expiration'] =  array('value' => 12, 'unit' => 'MONTHS');
     if ($_SESSION['wrkopcpro']  == 1) {
          $pla['preApproval']['cancelURL'] = 'https://www.admilhas.com.br/pallas49/cancela-pla.php';
     } else {
          $pla['preApproval']['cancelURL'] = 'https://www.profsa.com.br/pallas49/cancela-pla.php';
     }
     $pla['maxUses'] = 999;

     $env = json_encode($pla);
          
     if ($_SESSION['wrkopcpro']  == 1) {
          $url = "https://ws.pagseguro.uol.com.br/pre-approvals/request?" . "email=" . $ema . '&token=' . $tok;
     } else {
          $url = "https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request?"  . "email=" . $ema . '&token=' . $tok;
     }

     $cur = curl_init($url);
     curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/vnd.pagseguro.com.br.v3+xml;charset=ISO-8859-1'));
     curl_setopt($cur, CURLOPT_POST, true);
     if ($_SESSION['wrkopcpro']  == 1) {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, true);
     } else {
          curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
     }
     curl_setopt($cur, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($cur, CURLOPT_POSTFIELDS, $env);
     
     $ret = curl_exec($cur);
     if ($ret == false) { 
          echo '<script>alert("Acesso a PagSeguro para identificação não foi autorizado");</script>';
          return 2;
     }
     if ($ret == 'Unauthorized') { 
          echo '<script>alert("Informações para logar no PagSeguro não estão corretas");</script>';
          return 3;
     }

     curl_close($cur);
     $xml = simplexml_load_string($ret);
     $qtd = count($xml->error);
     if ($qtd == 0) {
          $dad['cod'] = $xml->code;
          $dad['dat'] = $xml->date;
          include "lerinformacao.inc";
          if ($_REQUEST['tok'] == "") {
               $sql  = "update tb_plano set ";
               $sql .= "platoken = '". $dad['cod'] . "', ";
               $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
               $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
               $sql .= "where idplano = " . $_SESSION['wrkcodreg'];
               $ret = comando_tab($sql, $nro, $ult, $men);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na regravação da chave do plano solicitado !");</script>';
               }
          }    
          echo '<script>alert("Criação de Plano Recorrente efetuada com Sucesso !");</script>';
     }
     return $sta;
}


?>

</html>