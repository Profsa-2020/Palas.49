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
     <title>Contas - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [3, 'asc'],
               [5, 'asc'],
               [6, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Contas ...",
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
     $bot = "Salvar";
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6, "Entrada na página de manutenção de contas do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0 : $_REQUEST['sta']);
     $usu = (isset($_REQUEST['usu']) == false ? 0 : $_REQUEST['usu']);
     $ger = (isset($_REQUEST['ger']) == false ? 0 : $_REQUEST['ger']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);
     $num = (isset($_REQUEST['num']) == false ? '' : $_REQUEST['num']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_conta($cha, $usu, $sta, $pro, $num, $ger); 
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $del = "cor-3";
          $per = ' onclick="return confirm(\'Confirma exclusão de Conta informado em tela ?\')" ';
     }

 if (isset($_REQUEST['salvar']) == true) {
      if ($_SESSION['wrkopereg'] == 1) {
           $sta = consiste_con();
           if ($sta == 0) {
                $ret = incluir_con();
                $cod = ultimo_cod();
                $ret = gravar_log(11,"Inclusão de novo Conta de Operação: " . $des); 
                $usu = 0; $pro = 0; $sta = 0; $ger = 0; $del = ""; $num = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 2) {
           $sta = consiste_con();
           if ($sta == 0) {
                $ret = alterar_con();
                $cod = ultimo_cod(); 
                $ret = gravar_log(12,"Alteração de Conta cadastrada: " . $des); 
                $usu = 0; $pro = 0; $sta = 0;  $ger = 0; $del = ""; $num = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 3) {
           $ret = excluir_con(); $bot = 'Salvar'; $per = '';
           $cod = ultimo_cod(); 
           $ret = gravar_log(13,"Exclusão de Conta cadastrada: " . $des); 
           $usu = 0; $pro = 0; $sta = 0;  $ger = 0; $del = ""; $num = ""; $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
      }
}
?>

<body id="box00">
     <h1 class="cab-0">Contas - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <form class="qua-2" name="frmTelMan" action="man-conta.php" method="POST">
               <p class="lit-4">Manutenção de Contas &nbsp; &nbsp; &nbsp; <a href="man-conta.php?ope=1&cod=0"
                         title="Abre janela para criação de nova conta de operação no sistema"><i class="fa fa-plus-circle fa-1g"
                              aria-hidden="true"></i></a></p>
               <div class="row">
                    <div class="col-md-1">
                         <label>Código</label>
                         <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                              value="<?php echo $cod; ?>" disabled />
                    </div>
                    <div class="col-md-2">
                         <label>Gerente</label>
                         <select id="ger" name="ger" class="form-control">
                              <?php $ret = carrega_ger($ger); ?>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Titular da conta</label>
                         <select id="usu" name="usu" class="form-control">
                              <?php $ret = carrega_usu($usu); ?>
                         </select>
                    </div>
                    <div class="col-md-3">
                         <label>Programa de fidalidade</label>
                         <select id="pro" name="pro" class="form-control">
                              <?php $ret = carrega_pro($pro); ?>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Número</label>
                         <input type="text" class="form-control" maxlength="15" id="num" name="num"
                              value="<?php echo $num; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Status</label><br />
                         <select id="sta" name="sta" class="form-control">
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
                              <th width="5%">Código</th>
                              <th>Gerente</th>
                              <th>Status</th>
                              <th>Titular da conta</th>
                              <th>Programa de fidelidade</th>
                              <th>Tipo</th>
                              <th>Número</th>
                              <th>Inclusão</th>
                              <th>Alteração</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $ret = carrega_con();  ?>
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
     exit('<script>location.href = "man-conta.php?ope=1&cod=0"</script>');
}

function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = acessa_reg('Select idconta from tb_conta order by idconta desc Limit 1', $reg);
     if ($nro == 1) {
          $cod = $reg['idconta'] + 1;
     }        
     return $cod;
}

function consiste_con() {
     $sta = 0;
     if (trim($_REQUEST['ger']) == "" || trim($_REQUEST['ger']) == "0") {
          echo '<script>alert("Gerente da conta não foi informado para a mesma !");</script>';
          return 1;
     }
     if (trim($_REQUEST['usu']) == "" || trim($_REQUEST['usu']) == "0") {
          echo '<script>alert("Nome do usuário não foi informado para a conta !");</script>';
          return 1;
     }
     if (trim($_REQUEST['pro']) == "" || trim($_REQUEST['pro']) == "0") {
          echo '<script>alert("Programa de Ponto ou Milhas não foi informado na conta !");</script>';
          return 1;
     }
     return $sta;
 }

function carrega_con() {
     include_once "dados.php";
     $com = "Select C.*, U.usunome, G.usunome as usugerente, P.prodescricao, P.protipo from (((tb_conta C left join tb_usuario U on C.conusuario = U.idsenha) left join tb_usuario G on C.congerente = G.idsenha) left join tb_programa P on C.conprograma = P.idprograma) where conempresa = " . $_SESSION['wrkcodemp'] . " order by condescricao, idconta";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $txt =  '<tr>';
          $txt .= '<td class="text-center"><a href="man-conta.php?ope=2&cod=' . $lin['idconta'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $txt .= '<td class="lit-d text-center"><a href="man-conta.php?ope=3&cod=' . $lin['idconta'] . '" title="Efetua exclusão do registro informado na linha"><i class="cor-1 large material-icons">delete_forever</i></a></td>';
          $txt .= '<td class="text-center">' . $lin['idconta'] . '</td>';
          $txt .= '<td class="text-left">' . $lin['usugerente'] . "</td>";
          if ($lin['constatus'] == 0) {$txt .= "<td>" . "Ativo" . "</td>";}
          if ($lin['constatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
          if ($lin['constatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
          if ($lin['constatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['usunome'] . "</td>";
          $txt .= '<td class="text-left">' . $lin['prodescricao'] . "</td>";
          if ($lin['protipo'] == 0) {$txt .= "<td>" . "Milhas" . "</td>";}
          if ($lin['protipo'] == 1) {$txt .= "<td>" . "Pontos" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['connumero'] . "</td>";
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

function incluir_con() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "insert into tb_conta (";
     $sql .= "constatus, ";
     $sql .= "congerente, ";
     $sql .= "conempresa, ";
     $sql .= "conusuario, ";
     $sql .= "conprograma, ";
     $sql .= "connumero, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['ger'] . "',";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['usu'] . "',";
     $sql .= "'" . $_REQUEST['pro'] . "',";
     $sql .= "'" . $_REQUEST['num'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
}

function ler_conta(&$cha, &$usu, &$sta, &$pro, &$num, &$ger) {
     include_once "dados.php";
     $nro = acessa_reg("Select * from tb_conta where idconta = " . $cha, $reg);            
     if ($nro == 0) {
          echo '<script>alert("Código da Conta informado não cadastrado no sistema");</script>';
     } else {
          $cha = $reg['idconta'];
          $usu = $reg['conusuario'];
          $sta = $reg['constatus'];
          $ger = $reg['congerente'];
          $num = $reg['connumero'];
          $pro = $reg['conprograma'];
     }
     return $cha;
 }

 function alterar_con() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_conta set ";
     $sql .= "constatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "conusuario = '". $_REQUEST['usu'] . "', ";
     $sql .= "conprograma = '". $_REQUEST['pro'] . "', ";
     $sql .= "congerente = '". $_REQUEST['ger'] . "', ";
     $sql .= "connumero = '". $_REQUEST['num'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idconta = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 } 

 function excluir_con() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_conta where idconta = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }

 function carrega_ger($ger) {
     $sta = 0;
     include_once "dados.php";    
     if ($usu == 0) {
          echo '<option value="0" selected="selected">Selecione ...</option>';
     }
     $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and (usutipo = 3 or usutipo = 4) and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idsenha'] != $usu) {
               echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_usu($usu) {
     $sta = 0;
     include_once "dados.php";    
     if ($usu == 0) {
          echo '<option value="0" selected="selected">Selecione ...</option>';
     }
     $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and (usutipo = 2 or usutipo = 4) and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idsenha'] != $usu) {
               echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pro($pro) {
     $sta = 0;
     include_once "dados.php";    
     if ($pro == 0) {
          echo '<option value="0" selected="selected">Selecione ...</option>';
     }
     $com = "Select idprograma, prodescricao from tb_programa where prostatus = 0 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idprograma'] != $pro) {
               echo  '<option value ="' . $lin['idprograma'] . '">' . $lin['prodescricao'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idprograma'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }
     return $sta;
}

?>

</html>