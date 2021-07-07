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

     let usu = $('#usu').val();
     let pro = $('#pro').val();
     if (usu != 0) {
          $.get("ajax/carrega-pro.php", {
                    usu: usu,
                    pro: pro
               })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
     }

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

     $('#pro').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#ano').change(function() {
          $('#tab-0 tbody').empty();
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
     $ret = 00;
     $dad = array();
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $ano = date('Y') - 4;
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Resumo por Contas no sistema: " . $ano);  
          }
     }
     if (isset($_SESSION['wrkcodusu']) == false) { $_SESSION['wrkcodusu'] = 0; }
     if (isset($_SESSION['wrkcodpro']) == false) { $_SESSION['wrkcodpro'] = 0; }
     if (isset($_REQUEST['usu']) == true) { $_SESSION['wrkcodusu'] = $_REQUEST['usu']; }
     if (isset($_REQUEST['pro']) == true) { $_SESSION['wrkcodpro'] = $_REQUEST['pro']; }

     $usu = (isset($_REQUEST['usu']) == false ? $_SESSION['wrkcodusu'] : $_REQUEST['usu']);
     $pro = (isset($_REQUEST['pro']) == false ? $_SESSION['wrkcodpro'] : $_REQUEST['pro']);
     $ano = (isset($_REQUEST['ano']) == false ? date('Y') : $_REQUEST['ano']);

     $ret = carrega_mov($ano, $usu, $pro, $dad);

?>

<body id="box00">
     <h1 class="cab-0">Resumo por Conta - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" id="frmTelCon" name="frmTelCon" action="" method="POST">
                              <p class="lit-4">Resumo por Conta</p><br />
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="col-md-2">
                                        <label>Ano Desejado</label><br />
                                        <select id="ano" name="ano" class="form-control">
                                             <?php
                                                  for ($ind = 0; $ind <= 10; $ind++) {
                                                       if (date('Y') != ($ano + $ind)) {
                                                            echo '<option value="' . ($ano + $ind) . '"> ' . ($ano + $ind) . '</option>';
                                                       } else {
                                                            echo '<option value="' . ($ano + $ind) . '" selected="selected"> ' . ($ano + $ind) . '</option>';
                                                       }
                                                  }
                                             ?>
                                        </select>
                                   </div>
                                   <div class="col-md-1"></div>
                                   <div class="col-md-3">
                                        <label>Usuário</label>
                                        <select id="usu" name="usu" class="form-control">
                                             <?php $ret = carrega_usu($usu); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Programa</label>
                                        <select id="pro" name="pro" class="form-control">
                                             <?php $ret = carrega_pro($usu, $pro); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-1"></div>
                                   <div class="col-md-1 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <br />
                         </form>
                         <br /><br />
                         <div class="row text-center">
                              <div class="col-md-3">
                                   <div class="qua-c">
                                        <p>Total Acumulado na Conta</p>
                                        <h3><?php echo number_format($dad['qtd_m'], 0,"," ,"."); ?></h3>
                                        <p>R$ <?php echo number_format($dad['val_m'], 2,"," ,"."); ?></p>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-d">
                                        <p>Saldo Atual na Conta</p>
                                        <h3><?php echo number_format($dad['sal_m'], 0,"," ,"."); ?></h3>
                                        <br />
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-g">
                                        <p>Saldo Disponível para Venda</p>
                                        <h3><?php echo number_format($dad['dis_m'], 0,"," ,"."); ?></h3>
                                        <br />
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-h">
                                        <p>Custo Médio por Milheiro</p>
                                        <h3><?php echo 'R$ ' . number_format($dad['val_m'] / ($dad['qtd_m'] == 0 ? 1 : $dad['qtd_m']) * 1000, 2,"," ,"."); ?>
                                        </h3>
                                        <br />
                                   </div>
                              </div>
                         </div>
                         <div class="row text-center">
                              <div class="col-md-9">
                                   <div class="tab-1 table-responsive">
                                        <table id="tab-0" class="table table-sm table-striped">
                                             <thead class="cor-d">
                                                  <tr>
                                                       <th width="25%">Intermediário</th>
                                                       <th class="text-center">CPFs Utilizados</th>
                                                       <th width="15%">Milhas Comprada</th>
                                                       <th width="15%">Milhas Utilizadas</th>
                                                       <th width="20%">Saldo do Intermediário</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php 
                                             $nro = count($dad['int']);
                                             if (isset($dad['des']) == true) {
                                                  foreach( $dad['int'] as $cpo => $con ) {        
                                                       if ($dad['des'][$cpo] != null) {     
                                                            $txt =  '<tr>';
                                                            $txt .= '<td>' . $dad['des'][$cpo] . '</td>';
                                                            $txt .= '<td class="text-center">' . $dad['cpf'][$cpo] . '</td>';
                                                            $txt .= '<td class="text-center">' . number_format($dad['com'][$cpo], 0,"," , ".") . '</td>';
                                                            $txt .= '<td class="text-center">' . number_format($dad['vnd'][$cpo], 0,"," , ".") . '</td>';
                                                            $txt .= '<td class="text-center">' . number_format($dad['com'][$cpo] - $dad['vnd'][$cpo], 0,"," , ".") . '</td>';
                                                            $txt .=  '</tr>';
                                                            echo $txt;
                                                       }
                                                  }
                                             }
                                        ?>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                              <div class="col-md-3 text-center">
                                   <div class="qua-f">
                                        <p>Total de CPFs Utilizados</p>
                                        <h3><?php echo number_format($dad['cpf_m'], 0,"," ,"."); ?></h3>
                                   </div>
                              </div>
                         </div>
                         <br />
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
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

function carrega_pro($usu, $pro) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     $com = "Select idprograma, prodescricao from tb_programa where protipo = 1 and prostatus = 0 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idprograma";
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

function carrega_mov($ano, $usu, $pro, &$dad) {
     include_once "dados.php";
     $nro = 0; $com = ""; $dad = array();  $dad['int'] = array(); $dad['cta'] = array();
     $dti = $ano . "-01-01"; $dtf = $ano . "-12-31";
     $dad['qtd_m'] = 0; $dad['val_m'] = 0; $dad['sal_m'] = 0; $dad['dis_m'] = 0; $dad['cpf_m'] = 0; 
     if ($usu == 0  && $pro == 0) { return 0; }
     $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movusuario = " . $usu . " and movprograma = " . $pro . " and movdata between '" . $dti . "' and '" . $dtf . "'";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { // 0-Compra 1-Transferência 2-Venda 3-Venda intermediario
          if ($lin['movtipo'] == 0) {
               $dad['qtd_m'] += $lin['movquantidade'];
               $dad['val_m'] += $lin['movvalor'];
          }
          if ($lin['movtipo'] == 1) {
               $dad['qtd_m'] -= $lin['movquantidade'];
               $dad['val_m'] -= $lin['movvalor'];
          }
          if ($lin['movtipo'] == 2) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
               }
          }
          if ($lin['movtipo'] == 3) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movvalor'];
               }
          }
          if ($lin['movtipo'] == 4) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movvalor'];
               }
          }
          if ($lin['movtipo'] == 7) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movquantidade'] * $lin['movcusto'] /1000;
               }
          }
          if ($lin['movtipo'] == 8) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_m'] += $lin['movquantidade'];
                    $dad['val_m'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
               }
          }
          if ($lin['movtipo'] == 0) {
               $dad['dis_m'] += $lin['movquantidade'];
               $dad['cpf_m'] += $lin['movnumerocpf'];
               $dad['sal_m'] += $lin['movquantidade'];
          }
          if ($lin['movtipo'] == 2 || $lin['movtipo'] == 3 || $lin['movtipo'] == 4) {
               if ($lin['movliquidado'] == 1) {
                    $dad['dis_m'] += $lin['movquantidade'];
                    $dad['cpf_m'] += $lin['movnumerocpf'];
               }
          }
          if ($lin['movtipo'] == 1) {
               $dad['dis_m'] -= $lin['movquantidade'];
               $dad['cpf_m'] -= $lin['movnumerocpf'];
          }
          if ($lin['movtipo'] == 2 || $lin['movtipo'] == 3 || $lin['movtipo'] == 4) {
               if ($lin['movliquidado'] == 1) {
                    $dad['sal_m'] += $lin['movquantidade'];
               }
          }
          if ($lin['movtipo'] == 5) {
               $dad['dis_m'] -= $lin['movquantidade'];
          }
          if ($lin['movtipo'] == 6) {
               $dad['sal_m'] -= $lin['movquantidade'];
               $dad['cpf_m'] += $lin['movnumerocpf'];
          }
          if ($lin['movtipo'] == 7 || $lin['movtipo'] == 8) {
               if ($lin['movliquidado'] == 1) {
                    $dad['dis_m'] += $lin['movquantidade'];
                    $dad['sal_m'] += $lin['movquantidade'];
               }
          }
     }
     $com = "Select M.*, I.intdescricao from (tb_movto M left join tb_intermediario I on M.movintermediario = I.idintermediario) ";
     $com .= "where movempresa = " . $_SESSION['wrkcodemp'] . " and movusuario = " . $usu . " and movprograma = " . $pro;          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {      
          if (isset($dad['int'][$reg['movintermediario']]) == false) {
               $dad['int'][$reg['movintermediario']] = $reg['movintermediario'];
               $dad['des'][$reg['movintermediario']] = $reg['intdescricao'];
               $dad['vnd'][$reg['movintermediario']] = 0;
               $dad['com'][$reg['movintermediario']] = 0;
               $dad['cpf'][$reg['movintermediario']] = 0;
          }
          if ($reg['movtipo'] == 5) {
               $dad['com'][$reg['movintermediario']] += $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 6) {
               $dad['vnd'][$reg['movintermediario']] += $reg['movquantidade'];
               $dad['cpf'][$reg['movintermediario']] += $reg['movnumerocpf'];
          }
     }

     return $nro;
}

?>

</html>