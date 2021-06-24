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

     $dad = array();
     $ret = carrega_das($dad); 

?>

<body id="box00">
     <h1 class="cab-0">Menu Principal - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="row text-center">
               <div class="col-md-12">
                    <h2><span><strong><i class="fa fa-tachometer fa-1g" aria-hidden="true"></i>
                                   DashBoard</strong></span></h2>
               </div>
          </div>
          <br />
          <div class="row text-center">
               <div class="col-md-2 bg-primary text-white">
                    <p>Qtde Comprada</p>
                    <span><strong><?php echo number_format($dad['qtd_c'], 0,"," ,"."); ?></strong></span>
               </div>
               <div class="col-md-2 bg-primary text-white">
                    <p>Valor Comprado</p>
                    <span><strong><?php echo "R$ " . number_format($dad['val_c'], 2,"," ,"."); ?></strong></span>
               </div>
               <div class="col-md-2 bg-primary text-white">
                    <p>Qtde Tranferida</p>
                    <span><strong><?php echo number_format($dad['qtd_t'], 0,"," ,"."); ?></strong></span>
               </div>
               <div class="col-md-2 bg-primary text-white">
                    <p>Valor Tranferido</p>
                    <span><strong><?php echo "R$ " . number_format($dad['val_t'], 2,"," ,"."); ?></strong></span>
               </div>
               <div class="col-md-2 bg-primary text-white">
                    <p>Qtde Vendida</p>
                    <span><strong><?php echo number_format($dad['qtd_v'], 0,"," , "."); ?></strong></span>
               </div>
               <div class="col-md-2 bg-primary text-white">
                    <p>Valor Vendido</p>
                    <span><strong><?php echo "R$ " . number_format($dad['val_v'], 2,"," , "."); ?></strong></span>
               </div>
          </div>
          <br /><br />
          <div class="table-responsive">
               <table class="table table-sm table-striped">
                    <thead>
                         <tr>
                              <th>Usuário</th>
                              <th>Programa</th>
                              <th>Qtde Entrada</th>
                              <th>Valor Entrada</th>
                              <th>Valor Investido</th>
                              <th>Qtde Saída</th>
                              <th>Valor Saída</th>
                              <th>Preço Médio</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php 
                              $nro = count($dad['cta']);
                              foreach( $dad['cta'] as $cpo => $con ) {                                   
                                   $txt =  '<tr>';
                                   $txt .= '<td>' . $dad['usu'][$cpo] . '</td>';
                                   $txt .= '<td>' . $dad['pro'][$cpo] . '</td>';
                                   $txt .= '<td class="text-right">' . number_format($dad['ent'][$cpo], 0,"," , ".") . '</td>';
                                   $txt .= '<td class="text-right">' . number_format($dad['com'][$cpo], 2,"," , ".") . '</td>';
                                   $txt .= '<td class="text-right">' . number_format($dad['inv'][$cpo], 2,"," , ".") . '</td>';
                                   $txt .= '<td class="text-right">' . number_format($dad['sai'][$cpo], 0,"," , ".") . '</td>';
                                   $txt .= '<td class="text-right">' . number_format($dad['ven'][$cpo], 2,"," , ".") . '</td>';
                                   if ($dad['com'][$cpo] == $dad['ven'][$cpo]) { 
                                        $txt .= '<td class="text-right">' . '0,0000' . '</td>';
                                   } else {
                                        if ($dad['ent'][$cpo] == 0 && $dad['sai'][$cpo] == 0 || $dad['ent'][$cpo] == $dad['sai'][$cpo]) {
                                             $txt .= '<td class="text-right">' . '0,0000' . '</td>';
                                        } else {
                                             $txt .= '<td class="text-right">' . number_format(($dad['com'][$cpo] - $dad['ven'][$cpo]) / ($dad['ent'][$cpo] - $dad['sai'][$cpo]) * 1000, 2,"," , ".") . '</td>';
                                        }
                                   }
                                   $txt .=  '</tr>';
                                   echo $txt;
                              }
                         ?>
                    </tbody>
               </table>
          </div>
          <hr />
          <?php if ($dad['int_m'] == 1) { ?>                              
               <div class="table-responsive">
                    <table class="table table-sm table-striped">
                         <thead>
                              <tr>
                                   <th>Nome do Intermediário</th>
                                   <th class="text-center">CPF´s</th>
                                   <th width="20%">Qtde Vendida</th>
                                   <th width="20%">Qtde Utilizada</th>
                                   <th width="20%">Saldo do Intermediário</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php 
                                   $nro = count($dad['int']);
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
                              ?>
                         </tbody>
                    </table>
               </div>
          <?php } ?>                              
          
          <br />

     </div>
     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_das(&$dad) {
     $ret = 0;
     $dad = array();
     $dad['int_m'] = 0;
     $dad['val_c'] = 0;
     $dad['qtd_c'] = 0;
     $dad['val_t'] = 0;
     $dad['qtd_t'] = 0;
     $dad['val_v'] = 0;
     $dad['qtd_v'] = 0;
     $dad['int'] = array();
     $dad['cta'] = array();
     include_once "dados.php";
     $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'];
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { // 0-Compra 1-Transferência 2-Venda 3-Venda intermediario
          if ($lin['movtipo'] == 0) {
               $dad['qtd_c'] += $lin['movquantidade'];
               $dad['val_c'] += $lin['movvalor'];
          }
          if ($lin['movtipo'] == 1) {
               $dad['qtd_t'] += $lin['movquantidade'];
               $dad['val_t'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
          }
          if ($lin['movtipo'] == 5) {
               $dad['qtd_v'] += $lin['movquantidade'];
               $dad['val_v'] += $lin['movvalor'];
          }
          if ($lin['movtipo'] == 7 || $lin['movtipo'] == 8) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qtd_c'] += $lin['movquantidade'];
                    $dad['val_c'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
               }
          }
     }
     $com = "Select M.*, U.usunome, P.prodescricao from (((tb_movto M left join tb_conta C on M.movconta = C.idconta) ";
     $com .= "left join tb_usuario U on M.movusuario = U.idsenha) ";
     $com .= "left join tb_programa P on M.movprograma = P.idprograma) ";
     $com .= "where movempresa = " . $_SESSION['wrkcodemp'] . " order by idmovto";          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {     
          $flag = 0;
          $ger_u = retorna_dad('congerente', 'tb_conta', 'idconta', $reg['movusuario']); 
          if ($_SESSION['wrktipusu'] <= 3) {
               if ($ger_u != $_SESSION['wrkideusu']) {
                    $flag = 1;
               }
          }
          if ($flag == 0) {
               if (isset($dad['cta'][$reg['movconta']]) == false) {
                    $dad['cta'][$reg['movconta']] = $reg['movconta'];
                    $dad['usu'][$reg['movconta']] = $reg['usunome'];
                    $dad['pro'][$reg['movconta']] = $reg['prodescricao'];
                    $dad['ent'][$reg['movconta']] = 0;
                    $dad['sai'][$reg['movconta']] = 0;
                    $dad['val'][$reg['movconta']] = 0;
                    $dad['com'][$reg['movconta']] = 0;
                    $dad['ven'][$reg['movconta']] = 0;
                    $dad['inv'][$reg['movconta']] = 0;
               }
               if ($reg['movtipo'] == 0) {
                    $dad['ent'][$reg['movconta']] += $reg['movquantidade'];
                    $dad['com'][$reg['movconta']] += $reg['movvalor'];
                    $dad['val'][$reg['movconta']] += $reg['movvalor'];
                    $dad['inv'][$reg['movconta']] += $reg['movquantidade'] * $reg['movcusto'];
               }
               if ($reg['movtipo'] == 1) {
                    $dad['sai'][$reg['movconta']] += $reg['movquantidade'];
                    $dad['ven'][$reg['movconta']] += $reg['movvalor'];
               }
               if ($reg['movtipo'] == 5) {
                    $dad['sai'][$reg['movconta']] += $reg['movquantidade'];
                    $dad['ven'][$reg['movconta']] += $reg['movvalor'];
                    $dad['val'][$reg['movconta']] -= $reg['movquantidade'] * $reg['movcusto'];
               }
               if ($reg['movtipo'] == 7 || $reg['movtipo'] == 8) {
                    if ($reg['movliquidado'] == 1) {
                         $dad['ent'][$reg['movconta']] += $reg['movquantidade'];
                         $dad['com'][$reg['movconta']] += $reg['movquantidade'] * $reg['movcusto'] / 1000;
                    }
               }
          }
     }
     $com = "Select M.*, I.intdescricao from (tb_movto M left join tb_intermediario I on M.movintermediario = I.idintermediario) ";
     $com .= "where movempresa = " . $_SESSION['wrkcodemp'] . " order by idmovto";          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {      
          if (isset($dad['int'][$reg['movintermediario']]) == false) {
               $dad['int'][$reg['movintermediario']] = $reg['movintermediario'];
               $dad['des'][$reg['movintermediario']] = $reg['intdescricao'];
               $dad['com'][$reg['movintermediario']] = 0;
               $dad['vnd'][$reg['movintermediario']] = 0;
               $dad['uti'][$reg['movintermediario']] = 0;
               $dad['cpf'][$reg['movintermediario']] = 0;
          }
          if ($reg['movtipo'] == 5) {
               $dad['int_m'] = 1;
               $dad['com'][$reg['movintermediario']] += $reg['movquantidade'];
          }
          if ($reg['movtipo'] == 6) {
               $dad['int_m'] = 1;
               $dad['vnd'][$reg['movintermediario']] += $reg['movquantidade'];
               $dad['cpf'][$reg['movintermediario']] += $reg['movnumerocpf'];
          }
     }
     return $ret;
}

?>

</html>