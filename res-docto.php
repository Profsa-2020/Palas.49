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
     <title>Consultas - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
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

     $ano = (isset($_REQUEST['ano']) == false ? date('Y') : $_REQUEST['ano']);

     $ret = carrega_mov($ano, $dad);

?>

<body id="box00">
     <h1 class="cab-0">Resumo por CPF´s - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" id="frmTelCon" name="frmTelCon" action="" method="POST">
                              <p class="lit-4">Resumo por CPF´s</p><br />
                              <div class="row">
                                   <div class="col-md-5"></div>
                                   <div class="col-md-2">
                                        <label>Ano Desejado</label><br />
                                        <select id="ano" name="ano" class="sel-a form-control">
                                             <?php
                                                  for ($ind = 0; $ind <= 10; $ind++) {
                                                       if (date('Y') != ($ano + $ind)) {
                                                            echo '<option value="' . ($ano + $ind) . '"> ' . 'Ano: ' . ($ano + $ind) . '</option>';
                                                       } else {
                                                            echo '<option value="' . ($ano + $ind) . '" selected="selected"> ' . 'Ano: ' . ($ano + $ind) . '</option>';
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
                                             <th width="30%">CONTA</th>
                                             <?php
                                                  for ($ind = 0; $ind < count($dad['cod_i']) ; $ind++) {
                                                       echo '<th class="text-center">' . $dad['des_i'][$ind] . '</th>';
                                                  }
                                                  echo '<th class="text-center">' . 'TOTAL' . '</th>';
                                                  ?>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php 
                                             $tot = 0; $usu = 0; $pro = 0; $lista = array(); $geral = array();
                                             for ($ind = 0; $ind < count($dad['usu_m']) ; $ind++) {
                                                  if ($usu != $dad['usu_m'][$ind] || $pro != $dad['pro_m'][$ind]) {
                                                       if (isset($lista['con'] ) == true) {
                                                            if (count($lista['con']) > 1) {
                                                                 echo '<tr>'; $som = 0;
                                                                 echo '<td>' . $lista['con'] . '</td>';
                                                                 for ($nro = 0; $nro < count($dad['cod_i']) ; $nro++) {                                                                 
                                                                      if (isset($lista[$nro]) == true ) {
                                                                           $som = $som + $lista[$nro];
                                                                           $tot = $tot + $lista[$nro];
                                                                           echo '<td class="text-center">' . $lista[$nro] . '</td>';
                                                                           if (isset($geral[$nro]) == false) {
                                                                                $geral[$nro] = $lista[$nro];
                                                                           } else {
                                                                                $geral[$nro] += $lista[$nro];
                                                                           }
                                                                      } else {
                                                                           echo '<td>' . '' . '</td>';
                                                                      }
                                                                 }                                                       
                                                                 echo '<td class="text-center">' . $som . '</td>';
                                                                 echo '</tr>';
                                                            }
                                                       }
                                                       $lista = array();
                                                       $usu = $dad['usu_m'][$ind];
                                                       $pro = $dad['pro_m'][$ind];
                                                  } 
                                                  $lista['con'] = $dad['des_u'][$ind] . '-' . $dad['des_p'][$ind];
                                                  $ord = array_search($dad['int_m'][$ind], $dad['cod_i']);
                                                  if ($ord != false) {
                                                       $lista[$ord] = $dad['qtd_m'][$ind];
                                                  }
                                             }
                                             if (isset($lista['con'] ) == true) {
                                                  echo '<tr>'; $som = 0;
                                                  echo '<td>' . $lista['con'] . '</td>';
                                                  for ($nro = 0; $nro < count($dad['cod_i']) ; $nro++) {                                                                 
                                                       if (isset($lista[$nro]) == true ) {
                                                            $som = $som + $lista[$nro];
                                                            $tot = $tot + $lista[$nro];
                                                            echo '<td class="text-center">' . $lista[$nro] . '</td>';
                                                            if (isset($geral[$nro]) == false) {
                                                                 $geral[$nro] = $lista[$nro];
                                                            } else {
                                                                 $geral[$nro] += $lista[$nro];
                                                            }
                                                       } else {
                                                            echo '<td>' . '' . '</td>';
                                                       }
                                                  }                                                       
                                                  echo '<td class="text-center">' . $som . '</td>';
                                                  echo '</tr>';
                                             }
                                             echo '<tr>'; 
                                             echo '<td class="text-right"><strong>' . 'TOTAL GERAL:' . '</strong></td>';
                                             for ($nro = 0; $nro < count($dad['cod_i']) ; $nro++) {         
                                                  if (isset($geral[$nro]) == false) {
                                                       echo '<td>' . '' . '</td>';
                                                  } else {                                                        
                                                       echo '<td class="text-center">' . $geral[$nro] . '</td>';
                                                  }
                                             }                                                       
                                             echo '<td class="text-center">' . $tot . '</td>';
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
     $dti = $ano . "-01-01"; $dtf = $ano . "-12-31";
     include_once "dados.php";
     $nro = 0; $dad = array();  
     $com = "Select * from tb_intermediario where intempresa = " . $_SESSION['wrkcodemp'] . " order by intdescricao, idintermediario";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $dad['cod_i'][] = $lin['idintermediario'];
          $dad['des_i'][] = $lin['intdescricao'];
     }
     $com  = "Select movusuario, movprograma, movintermediario, Sum(movnumerocpf) as movqtde from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "' group by movusuario, movprograma, movintermediario order by movusuario, movprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
          $des_u = retorna_dad('usunome', 'tb_usuario', 'idsenha', $lin['movusuario']); 
          $des_p = retorna_dad('prodescricao', 'tb_programa', 'idprograma', $lin['movprograma']); 
          $dad['des_u'][] = $des_u;
          $dad['des_p'][] = $des_p;
          $dad['usu_m'][] = $lin['movusuario'];
          $dad['pro_m'][] = $lin['movprograma'];
          $dad['int_m'][] = $lin['movintermediario'];
          $dad['qtd_m'][] = $lin['movqtde'];
     }
     return $nro;
}

?>

</html>