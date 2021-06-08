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
     if ($_SESSION['wrktipusu'] != 5) {
          echo '<script>alert("Tipo de usuário não permite visualização de menu de acesso");</script>';
          echo '<script>history.go(-1);</script>';
     }     
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
     <h1 class="cab-0">Menu Master - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="row text-center">
               <div class="col-md-12">
                    <h2><span><strong> Resumo &nbsp; &nbsp; &nbsp; <i class="fa fa-line-chart fa-1g"
                                        aria-hidden="true"></i></strong></span></h2>
               </div>
          </div>
          <br />
          <div class="row">
               <div class="col-md-4 text-center">
                    <div class="qua-4">
                         <label>Nº de Contratantes</label>
                         <p><?php echo number_format($dad['num_a'], 0, ",", "."); ?></p>
                    </div>
               </div>
               <div class="col-md-4 text-center">
                    <div class="qua-4">
                         <label>Nº de Usuários</label>
                         <p><?php echo number_format($dad['num_u'], 0, ",", "."); ?></p>
                    </div>
               </div>
               <div class="col-md-4 text-center">
                    <div class="qua-4">
                         <label>Nº de Planos</label>
                         <p><?php echo number_format($dad['num_p'], 0, ",", "."); ?></p>
                    </div>
               </div>
          </div>
          <br />
          <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-8">
                    <div class="qua-4 text-center">
                         <label>Recebimentos</label>
                         <p><?php echo 'R$ ' . number_format($dad['val_r'], 2, ",", "."); ?></p>
                    </div>
               </div>
          </div>
          <br />
          <div class="tab-1 table-responsive">
               <table id="tab-0" class="table table-sm table-striped">
                    <thead class="thead-dark">
                         <tr>
                              <th width="5%">Número</th>
                              <th>Status</th>
                              <th>Descrição do Plano</th>
                              <th>Usuários</th>
                              <th>Valor</th>
                              <th width="15%">Inclusão</th>
                              <th width="15%">Alteração</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $ret = carrega_pla();  ?>
                    </tbody>
               </table>
          </div>
     </div>

     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_das(&$dad) {
     $ret = 0;
     $dad = array();
     $dad['num_u'] = 0;
     $dad['num_a'] = 0;
     $dad['num_p'] = 0;
     $dad['val_r'] = 0;
     include_once "dados.php";
     $com  = "Select Count(*) as usuqtde from tb_usuario where usuempresa > 0";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
               $dad['num_u'] += $lin['usuqtde'];
     }
     $com  = "Select Count(*) as usuqtde from tb_usuario where usutipo = 4";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
               $dad['num_a'] += $lin['usuqtde'];
     }
     $com  = "Select Count(*) as plaqtde from tb_plano where idplano > 0";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
               $dad['num_p'] += $lin['plaqtde'];
     }
     $com  = "Select Sum(titvalor) as titvalor from tb_titulo where idtitulo > 0";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { 
               $dad['val_r'] += $lin['titvalor'];
     }

     return $ret;
}

function carrega_pla() {
     include_once "dados.php";
     $com = "Select * from tb_plano order by idplano";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          $txt =  '<tr>';
          $txt .= '<td class="text-center">' . $lin['idplano'] . '</td>';
          if ($lin['plastatus'] == 0) {$txt .= "<td>" . "Ativo" . "</td>";}
          if ($lin['plastatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
          if ($lin['plastatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
          if ($lin['plastatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['pladescricao'] . "</td>";
          $txt .= '<td class="text-center">' . $lin['planumerotit'] . "</td>";
          $txt .= '<td class="text-right">' . number_format($lin['plavalor'], 2, ",", ".") . '</td>';
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

?>

</html>