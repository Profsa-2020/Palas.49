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

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Log - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#dti").mask("99/99/9999");
     $("#dtf").mask("99/99/9999");
     $("#dti").datepicker($.datepicker.regional["pt-BR"]);
     $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [0, 'asc'],
               [1, 'desc'],
               [2, 'desc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Log ...",
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
    $ret = 00;
    include_once "dados.php";
    include_once "profsa.php";
    $_SESSION['wrknompro'] = __FILE__;
    if ($_SESSION['wrktipusu'] <= 3) {
     echo '<script>alert("Nível de usuário não permite visualização de log de acesso");</script>';
     echo '<script>history.go(-1);</script>';
}     
    date_default_timezone_set("America/Sao_Paulo");
    $hoj = date('d/m/Y');
    $dti = date('d/m/Y', strtotime('-6 days'));
    $dtf = date('d/m/Y');
    $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
    $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
    if ($_SESSION['wrktipusu'] <= 2) {
     echo '<script>alert("Nível de usuário não permite manutenção em acessos");</script>';
     echo '<script>history.go(-1);</script>';
 }
    if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Log para verificação de acessos de usuários: " . $dti . " até " . $dtf);  
          }
     }
     
?>

<body id="box00">
     <h1 class="cab-0">Log de Acesso - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container">
          <p class="lit-4">Consulta de Acessos de Usuários</p>
     </div>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" name="frmTelLog" action="" method="POST">
                              <div class="row">
                                   <div class="col-md-4"></div>
                                   <div class="col-md-2">
                                        <label>Data Inicial</label>
                                        <input type="text" class="form-control text-center" maxlength="10" id="dti"
                                             name="dti" value="<?php echo $dti; ?>" required />
                                   </div>
                                   <div class="col-md-2">
                                        <label>Data Final</label>
                                        <input type="text" class="form-control text-center" maxlength="10" id="dtf"
                                             name="dtf" value="<?php echo $dtf; ?>" required />
                                   </div>
                                   <div class="col-md-1 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                                   <div class="col-md-3"></div>
                              </div>
                              <br />
                         </form>
                         <br />
                    </div>
                    <div class="container-fluid">
                         <div class="row">
                              <div class="tab-1 table-responsive">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th>Emp</th>
                                                  <th>Data</th>
                                                  <th>Hora</th>
                                                  <th>Ope</th>
                                                  <th>Usuário</th>
                                                  <th>Tip</th>
                                                  <th>Página</th>
                                                  <th>IP</th>
                                                  <th>Cidade/UF</th>
                                                  <th>Navegador</th>
                                                  <th>Provedor</th>
                                                  <th>Histórico do Log</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_log($dti, $dtf);  ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
function carrega_log($dti, $dtf) {
     $nro = 0;
     include_once "dados.php";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com = "Select logempresa, logdatahora,logoperacao,logusuario,logtipo,logidsenha,logip,logcidade, logestado,lognavegador,logprovedor,logprograma,logobservacao from tb_log ";
     if ($_SESSION['wrktipusu'] >= 3) {
          $com .= " where logdatahora between '" . $dti . "' and '" . $dtf . "' ";
     } else {
          $com .= " where logempresa = " . $_SESSION['wrkcodemp'] . " and logdatahora between '" . $dti . "' and '" . $dtf . "' ";
     }
     $com .= " order by logempresa, logdatahora desc, idlog ";          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {               
          $txt =  '<tr>';
          $txt .= '<td class="text-center"><strong>' . str_pad($reg['logempresa'], 3, "0", STR_PAD_LEFT) . '</strong></td>';
          $txt .= "<td>" . date('d/m/Y',strtotime($reg['logdatahora'])) . "</td>";
          $txt .= "<td>" . date('H:m:s',strtotime($reg['logdatahora'])) . "</td>";
          $txt .= "<td>" . $reg['logoperacao'] . "</td>";
          $txt .= "<td>" . $reg['logusuario'] . "</td>";
          $txt .= "<td>" . $reg['logtipo'] . "</td>";
          $txt .= "<td>" . $reg['logprograma'] . "</td>";
          $txt .= "<td>" . $reg['logip'] . "</td>";
          $txt .= "<td>" . $reg['logcidade'] . "-" . $reg['logestado'] . "</td>";
          $txt .= "<td>" . $reg['lognavegador'] . "</td>";
          $txt .= "<td>" . $reg['logprovedor'] . "</td>";
          $txt .= "<td>" . $reg['logobservacao'] . "</td>";
          $txt .= "</tr>";
          echo $txt;
     }
     return $nro;
}

?>

</html>