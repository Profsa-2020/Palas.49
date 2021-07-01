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
     <title>Pontos - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>

$(document).ready(function() {

     let usu = $('#usu').val();
     let pro = $('#pro').val();
     if (usu != 0) {
          $.get("ajax/carrega-pro.php", {
                    usu: usu, pro: pro
               })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
     }

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
     $dad = array();
     $aaa = (date('Y') - 4);
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     
     $ano = (isset($_REQUEST['ano']) == false ? date('Y'): $_REQUEST['ano']);

     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Resumo por Pontos no sistema: " . $ano);  
          }
     }
     if (isset($_SESSION['wrkcodusu']) == false) { $_SESSION['wrkcodusu'] = 0; }
     if (isset($_SESSION['wrkcodpro']) == false) { $_SESSION['wrkcodpro'] = 0; }

     $ret = carrega_mov($ano, $dad);

?>

<body id="box00">
     <h1 class="cab-0">Resumo por Pontos - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" id="frmTelCon" name="frmTelCon" action="" method="POST">
                              <p class="lit-4">Resumo por Pontos</p><br />
                              <div class="row">
                                   <div class="col-md-5"></div>
                                   <div class="col-md-2">
                                        <label>Ano Desejado</label><br />
                                        <select id="ano" name="ano" class="sel-a form-control">
                                             <?php
                                                  for ($ind = 0; $ind <= 10; $ind++) {
                                                       if (date('Y') != ($aaa + $ind)) {
                                                            echo '<option value="' . ($aaa + $ind) . '"> ' . 'Ano: ' . ($aaa + $ind) . '</option>';
                                                       } else {
                                                            echo '<option value="' . ($aaa + $ind) . '" selected="selected"> ' . 'Ano: ' . ($aaa + $ind) . '</option>';
                                                       }
                                                  }
                                             ?>
                                        </select>
                                   </div>
                                   <div class="col-md-3"></div>
                                   <div class="col-md-2 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <br />
                         </form>
                         <br /><br />
                         <div class="table-responsive">
                              <table class="table table-sm table-striped">
                                   <thead class="thead-dark">
                                        <tr>
                                             <th width="30%">Nome do Usuário</th>
                                             <?php
                                                  for ($ind = 0; $ind < count($dad['cod_p']) ; $ind++) {
                                                       echo '<th class="text-center">' . $dad['tit_p'][$ind] . '</th>';
                                                  }
                                                  echo '<th class="text-center">' . 'TOTAL' . '</th>';
                                                  ?>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                             $tot = 0; $usu = 0; $pro = 0; $lista = array(); $geral = array();
                                             if (isset($dad['usu_m']) == true) {     
                                                  for ($ind = 0; $ind < count($dad['usu_m']) ; $ind++) {
                                                       if ($usu != $dad['usu_m'][$ind] || $pro != $dad['pro_m'][$ind]) {
                                                            if (isset($lista['con'] ) == true) {
                                                                 $mai = array_sum($lista);
                                                                 if (count($lista['con']) >= 1 &&$mai > 0) {
                                                                      echo '<tr>'; $som = 0;
                                                                      echo '<td>' . $lista['con'] . '</td>';
                                                                      for ($nro = 0; $nro < count($dad['cod_p']) ; $nro++) {                                                                 
                                                                           if (isset($lista[$nro]) == true ) {
                                                                                $som = $som + $lista[$nro];
                                                                                $tot = $tot + $lista[$nro];
                                                                                echo '<td class="text-center">' . number_format($lista[$nro], 0, ",", ".") . '</td>';
                                                                                if (isset($geral[$nro]) == false) {
                                                                                     $geral[$nro] = $lista[$nro];
                                                                                } else {
                                                                                     $geral[$nro] += $lista[$nro];
                                                                                }
                                                                           } else {
                                                                                echo '<td>' . '' . '</td>';
                                                                           }
                                                                      }                                                       
                                                                      echo '<td class="text-center">' . number_format($som, 0, ",", ".") . '</td>';
                                                                      echo '</tr>';
                                                                 }
                                                            }
                                                            $lista = array();
                                                            $usu = $dad['usu_m'][$ind];
                                                            $pro = $dad['pro_m'][$ind];
                                                       } 
                                                       $lista['con'] = $dad['des_u'][$ind];
                                                       $ord = array_search($dad['pro_m'][$ind], $dad['cod_p']);
                                                       if ($ord !== false) {
                                                            $lista[$ord] = $dad['qtd_m'][$ind];
                                                       }
                                                  }
                                             }
                                             if (isset($lista['con'] ) == true) {
                                                  $mai = array_sum($lista);
                                                  if ($mai > 0) {
                                                       echo '<tr>'; $som = 0;
                                                       echo '<td>' . $lista['con'] . '</td>';
                                                       for ($nro = 0; $nro < count($dad['cod_p']) ; $nro++) {                                                                 
                                                            if (isset($lista[$nro]) == true ) {
                                                                 $som = $som + $lista[$nro];
                                                                 $tot = $tot + $lista[$nro];
                                                                 echo '<td class="text-center">' . number_format($lista[$nro], 0, ",", ".") . '</td>';
                                                                 if (isset($geral[$nro]) == false) {
                                                                      $geral[$nro] = $lista[$nro];
                                                                 } else {
                                                                      $geral[$nro] += $lista[$nro];
                                                                 }
                                                            } else {
                                                                 echo '<td>' . '' . '</td>';
                                                            }
                                                       }                                                       
                                                       echo '<td class="text-center">' . number_format($som, 0, ",", ".") . '</td>';
                                                       echo '</tr>';
                                                  }
                                             }
                                             echo '<tr>'; 
                                             echo '<td class="text-right"><strong>' . 'TOTAL GERAL:' . '</strong></td>';
                                             for ($nro = 0; $nro < count($dad['cod_p']) ; $nro++) {         
                                                  if (isset($geral[$nro]) == false) {
                                                       echo '<td>' . '' . '</td>';
                                                  } else {                                                        
                                                       echo '<td class="text-center">' . number_format($geral[$nro], 0, ",", ".") . '</td>';
                                                  }
                                             }                                                       
                                             echo '<td class="text-center">' . number_format($tot, 0, ",", ".") . '</td>';
                                             echo '</tr>';
                                        ?>
                                   </tbody>
                              </table>
                         </div>
                         <hr />
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
function carrega_mov($ano, &$dad) {
     include_once "dados.php";
     $nro = 0; $ind = -1; $pro = 0; $usu = 0; $dad = array();  
     $dti = $ano . "-01-01"; $dtf = $ano . "-12-31";
     $com = "Select * from tb_programa where protipo= 1 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $dad['cod_p'][] = $lin['idprograma'];
          $dad['tit_p'][] = $lin['prodescricao'];
     }
     $com  = "Select movusuario, movprograma, movtipo, movliquidado, Sum(movquantidade)  as movqtde from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "' group by movusuario, movprograma, movtipo, movliquidado order by movusuario, movprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
          $flag = 0;
          $ger_u = retorna_dad('congerente', 'tb_conta', 'idconta', $lin['movusuario']); 
          if ($_SESSION['wrktipusu'] <= 3) {
               if ($ger_u != $_SESSION['wrkideusu']) {
                    $flag = 1;
               }
          }
          if ($flag == 0) {
               if ($usu !=  $lin['movusuario'] || $pro !=  $lin['movprograma']) {
                    $ind = $ind + 1;
                    $usu =  $lin['movusuario']; $pro =  $lin['movprograma'];
                    $des_u = retorna_dad('usunome', 'tb_usuario', 'idsenha', $lin['movusuario']); 
                    $des_p = retorna_dad('prodescricao', 'tb_programa', 'idprograma', $lin['movprograma']); 
                    $dad['des_u'][$ind] = $des_u;
                    $dad['des_p'][$ind] = $des_p;
                    $dad['usu_m'][$ind] = $lin['movusuario'];
                    $dad['pro_m'][$ind] = $lin['movprograma'];               
                    $dad['qtd_m'][$ind] = 0;
               }
               if ($lin['movtipo'] == 0) {
                    $dad['qtd_m'][$ind] += $lin['movqtde'];     
               }
               if ($lin['movtipo'] == 2 || $lin['movtipo'] == 3 || $lin['movtipo'] == 4) {
                    if ($lin['movliquidado'] == 1) {
                         $dad['qtd_m'][$ind] += $lin['movqtde'];     
                    }
               }
               if ($lin['movtipo'] == 1) {
                    $dad['qtd_m'][$ind] -= $lin['movqtde'];     
               }
          }
     }
     return $nro;
}

?>

</html>