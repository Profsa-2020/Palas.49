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

     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script> <!-- 2.9.4 / 2.7.0 -->

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Menu - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#usu').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#pro').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#usu').change(function() {
          $('#tab-0 tbody').empty();
          let usu = $('#usu').val();
          $.get("ajax/carrega-pro.php", {
                    usu: usu
               })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
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
     include_once "profsa.php";
     $_SESSION['wrknumvol'] = 0;
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrknumusu'] = getmypid();
     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "index.php"</script>');   
     }
     
     $_SESSION['wrkopereg'] = 0; $_SESSION['wrkcodreg'] = 0; $_SESSION['wrklogemp'] = ''; 
     if (isset($_SESSION['wrkendser']) == false) { $_SESSION['wrkendser'] = getenv("REMOTE_ADDR"); }

     $usu = (isset($_REQUEST['usu']) == false ? 0 : $_REQUEST['usu']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);

     $dad = array();
     $ret = carrega_das($usu, $pro, $dad); 

?>

<body id="box00">
     <h1 class="cab-0">Menu Principal - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <br />
     <div class="container">
          <div class="row text-center">
               <div class="col-md-3">
                    <h3><span class="cor-b"><strong>DashBoard</strong></span></h3>
               </div>
               <div class="col-md-6">
                    <span class="qua-b"><span class="cor-1">AVISO: </span>Módulo Venda Direta de Passagens em breve
                         !</span>
               </div>
               <div class="col-md-3">
                    <span class="qua-b"><i class="cor-c fa fa-question-circle fa-1g" aria-hidden="true"></i> Ajuda /
                         Video Aulas</span>
               </div>
          </div>
          <br />
          <div class="row text-center">
               <div class="col-md-3">
                    <div class="qua-c">
                         <p>Milhas Negociadas (Mês Corrente)</p>
                         <h3><?php echo number_format($dad['qtd_m'], 0,"," ,"."); ?></h3>
                    </div>
               </div>
               <div class="col-md-3">
                    <div class="qua-c">
                         <p>Total de Venda (Mês Corrente)</p>
                         <h3><?php echo 'R$ ' . number_format($dad['val_m'], 2,"," ,"."); ?></h3>
                    </div>
               </div>
               <div class="col-md-3">
                    <div class="qua-d">
                         <p>Milhas Negociadas (Geral Ano)</p>
                         <h3><?php echo number_format($dad['qtd_a'], 0,"," ,"."); ?></h3>
                    </div>
               </div>
               <div class="col-md-3">
                    <div class="qua-d">
                         <p>Total de Venda (Geral Ano)</p>
                         <h3><?php echo 'R$ ' . number_format($dad['val_a'], 2,"," ,"."); ?></h3>
                    </div>
               </div>
          </div>
          <br />
          <form id="frmTelCon" name="frmTelCon" action="menu01.php" method="POST">
               <div class="row let-b cor-4">
                    <div class="qua-e col-md-4">
                         <label>Filtrar por titular da conta</label>
                         <select id="usu" name="usu" class="form-control">
                              <?php $ret = carrega_usu($usu); ?>
                         </select>
                    </div>
                    <div class="qua-e col-md-4">
                         <label>Filtrar por programa de fidelidade</label>
                         <select id="pro" name="pro" class="form-control">
                              <option value="0" selected="selected">Selecione ...</option>
                         </select>
                    </div>
                    <div class="qua-e col-md-1 text-center">
                         <br />
                         <button type="submit" id="con" name="consulta" class="bot-2"
                              title="Carrega movimento conforme periodo solicitado pelo usuário."><i
                                   class="fa fa-search fa-3x" aria-hidden="true"></i></button>
                    </div>
                    <div class="col-md-3 text-center">
                         <div class="qua-f">
                              <p>Próximos Recebimentos</p>
                              <h3><?php echo 'R$ ' . number_format($dad['pro_r'], 2,"," ,"."); ?></h3>
                         </div>
                    </div>
               </div>
          </form>


          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-9">
                         <div class="tab-1 table-responsive">
                              <table id="tab-0" class="table table-sm">
                                   <thead>
                                        <tr>
                                             <th>Titular da Conta</th>
                                             <th>Programa</th>
                                             <th>Saldo Disponível</th>
                                             <th>Custo Médio</th>
                                             <th>Preço Médio</th>
                                             <th class="text-center">CPFs Usados</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                        if (isset($dad['usu_l']) == true)  {    
                                             foreach($dad['usu_l'] as $ind => $cpo ) {
                                                  echo '<tr>';
                                                  echo '<td><strong>' . retorna_dad('usunome', 'tb_usuario', 'idsenha', $dad['usu_l'][$ind]) . '</strong></td>';
                                                  echo '<td><strong>' . retorna_dad('prodescricao', 'tb_programa', 'idprograma', $dad['pro_l'][$ind]) . '</strong></td>';
                                                  echo '<td class="text-right"><strong>' . number_format($dad['sal_l'][$ind], 0, ",", ".") . '</strong></td>';
                                                  echo '<td class="text-right"><strong>' . number_format($dad['com_l'][$ind], 2, ",", ".")  . '</strong></td>';
                                                  echo '<td class="text-right"><strong>' . number_format($dad['ven_l'][$ind], 2, ",", ".")  . '</strong></td>';
                                                  echo '<td class="text-center"><strong>' . number_format($dad['cpf_l'][$ind], 0, ",", ".")  . '</strong></td>';
                                                  echo '</tr>';
                                             }                                             
                                        }
                                        ?>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="col-md-3 text-center">
                         <div class="tab-1 table-responsive">
                              <table id="tab-0" class="table table-sm">
                                   <thead>
                                        <tr>
                                             <th class="text-center">Valor</th>
                                             <th class="text-center">Data</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                        if (isset($dad['dat_r']) == true)  {    
                                             foreach($dad['dat_r'] as $ind => $cpo ) {
                                                  echo '<tr>';
                                                  echo '<td><strong>' . number_format($dad['val_r'][$ind], 2, ",", ".")  . '</strong></td>';
                                                  echo '<td><strong>' . date('d/m/Y',strtotime($dad['dat_r'][$ind]))  . '</strong></td>';
                                                  echo '</tr>';
                                             }                                             
                                        }
                                        ?>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
          </div>
          <hr />
     </div>
     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_das($usu, $pro, &$dad) {
     $ret = 0; $sal = 0; $cpf = 0; $usu_a = 0; $pro_a = 0; $qtd_c = 0; $val_c = 0;$qtd_v = 0; $val_v = 0;
     $dad = array();
     $dad['qtd_m'] = 0;
     $dad['val_m'] = 0;
     $dad['qtd_a'] = 0;
     $dad['val_a'] = 0;
     $dad['pro_r'] = 0;
     include_once "dados.php";
     $dti = date('Y') . "-01-01";
     $dtf = date('Y') . "-12-31";
     $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "' ";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
          if ($lin['movtipo'] == 5) {
               $dad['qtd_a'] += $lin['movquantidade'];
               $dad['val_a'] += $lin['movvalor'];
               if (date('m',strtotime($lin['movdata'])) == date('m')) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movvalor'];     
               }
          }
     }
     $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movvecto > '" . date('Y-m-d') . "'";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
          if ($lin['movtipo'] == 5) {
               if ($lin['movliquidado'] == 0) {
                    $dad['pro_r'] += $lin['movvalor'];
                    $dad['dat_r'][] = $lin['movvecto'];
                    $dad['val_r'][] = $lin['movvalor'];
               }
          }
     }     
     $com = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'];
     if ($usu != 0) { $com .= " and movusuario = " . $usu; }
     if ($pro != 0) { $com .= " and movprograma = " . $pro; };
     $com .= " order by movusuario, movprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
          if ($usu_a == 0) {
               $usu_a = $lin['movusuario']; $pro_a = $lin['movprograma'];
          }
          if ($usu_a != $lin['movusuario'] || $pro_a != $lin['movprograma']) {
               $dad['usu_l'][] = $usu_a;
               $dad['pro_l'][] = $pro_a;
               $dad['sal_l'][] = $sal; $sal = 0;
               $dad['cpf_l'][] = $cpf; $cpf = 0;
               $dad['com_l'][] = $val_c / ($qtd_c == 0 ? 1 : $qtd_c) * 1000; $qtd_c = 0; $val_c = 0;
               $dad['ven_l'][] = $val_v / ($qtd_v == 0 ? 1 : $qtd_v) * 1000; $qtd_v = 0; $val_v = 0;
               $usu_a = $lin['movusuario']; $pro_a = $lin['movprograma'];
          }
          if ($lin['movtipo'] == 0) {
               $sal = $sal + $lin['movquantidade'];
               $qtd_c = $qtd_c + $lin['movquantidade'];
               $val_c = $val_c + $lin['movvalor'];
          }
          if ($lin['movtipo'] == 1) {
               $sal = $sal - $lin['movquantidade'];
          }
          if ($lin['movtipo'] == 2) {
               if ($lin['movliquidado'] == 1) {
                    $sal = $sal + $lin['movquantidade'];
                    $qtd_c = $qtd_c + $lin['movquantidade'];
                    $val_c = $val_c + $lin['movquantidade'] * $lin['movcusto'] / 1000;     
               }
          }
          if ($lin['movtipo'] == 3) {
               if ($lin['movliquidado'] == 1) {
                    $sal = $sal + $lin['movquantidade'];
                    $qtd_c = $qtd_c + $lin['movquantidade'];
                    $val_c = $val_c + $lin['movquantidade'] * $lin['movcusto'];     
               }
          }
          if ($lin['movtipo'] == 4) {
               if ($lin['movliquidado'] == 1) {
                    $sal = $sal + $lin['movquantidade'];
                    $qtd_c = $qtd_c + $lin['movquantidade'];
                    $val_c = $val_c + $lin['movquantidade'] * $lin['movcusto'];     
               }
          }
          if ($lin['movtipo'] == 5) {   // Venda
               $sal = $sal - $lin['movquantidade'];
               $qtd_v = $qtd_v + $lin['movquantidade'];
               $val_v = $val_v + $lin['movvalor'];
          }
          if ($lin['movtipo'] == 6) {   // CPF´s
               $cpf = $cpf + $lin['movnumerocpf'];
          }
          if ($lin['movtipo'] == 7) {   // Venda com cartão
               if ($lin['movliquidado'] == 1) {
                    $sal = $sal + $lin['movquantidade'];
                    $qtd_c = $qtd_c + $lin['movquantidade'];
                    $val_c = $val_c + $lin['movquantidade'] * $lin['movcusto'] / 1000;     
               }
          }
          if ($lin['movtipo'] == 8) {   // Venda com cartão
               if ($lin['movliquidado'] == 1) {
                    $sal = $sal + $lin['movquantidade'];
                    $qtd_c = $qtd_c + $lin['movquantidade'];
                    $val_c = $val_c + $lin['movquantidade'] * $lin['movcusto'] / 1000;     
               }
          }
     }
     $dad['usu_l'][] = $usu_a;
     $dad['pro_l'][] = $pro_a;
     $dad['sal_l'][] = $sal; $sal = 0;
     $dad['cpf_l'][] = $cpf; $cpf = 0;
     $dad['com_l'][] = $val_c / ($qtd_c == 0 ? 1 : $qtd_c) * 1000; 
     $dad['ven_l'][] = $val_v / ($qtd_v == 0 ? 1 : $qtd_v) * 1000; 
     return $ret;
}

function carrega_usu($usu) {
     $sta = 0; $ant = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
     } else {
          $com = "Select U.idsenha, U.usunome from (tb_usuario U left join tb_conta C on U.idsenha = C.conusuario) where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp']  . "  and congerente = " . $_SESSION['wrkideusu'] . " order by U.usunome, U.idsenha";
     }
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($ant != $lin['idsenha']) {
               $ant = $lin['idsenha'];
               if ($lin['idsenha'] != $usu) {
                    echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
               } else {
                    echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
               }
          }
     }
     return $sta;
}


?>

</html>