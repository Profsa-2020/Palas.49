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
     <title>Títulos - Gerenciamento de Milhas - PagSeguro - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#dti").mask("99/99/9999");
     $("#dtf").mask("99/99/9999");
     $("#dti").datepicker($.datepicker.regional["pt-BR"]);
     $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     $('#sta').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [2, 'desc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Títulos a Receber ...",
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
     if ($_SESSION['wrktipusu'] != 5) {
          echo '<script>alert("Tipo de usuário não permite visualização desta opção do menu");</script>';
          echo '<script>history.go(-1);</script>';
     }     
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6, "Entrada na página de consulta de títulos a receber do sistema Pallas.49 ");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 1; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $dti = date('d/m/Y', strtotime('-30 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $sta = (isset($_REQUEST['sta']) == false ? 9 : $_REQUEST['sta']);


?>

<body id="box00">
     <h1 class="cab-0">Títulos - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
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
          <form class="qua-2" name="frmTelMan" action="con-titulo.php" method="POST">
               <p class="lit-4">Consulta de Títulos a Receber &nbsp; &nbsp; &nbsp; </p>
               <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                         <label>Status</label><br />
                         <select id="sta" name="sta" class="form-control">
                              <option value="9" <?php echo ($sta != 9 ? '' : 'selected="selected"'); ?>>
                                   Todos
                              </option>
                              <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                   Em Aberto
                              </option>
                              <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                   Baixado
                              </option>
                              <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                   Cancelado
                              </option>
                              <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                   Cortesia
                              </option>
                              <option value="4" <?php echo ($sta != 4 ? '' : 'selected="selected"'); ?>>
                                   Suspenso
                              </option>
                         </select>
                    </div>
                    <div class="col-md-2">
                         <label>Data Inicial</label>
                         <input type="text" class="form-control text-center" maxlength="10" id="dti" name="dti"
                              value="<?php echo $dti; ?>" required />
                    </div>
                    <div class="col-md-2">
                         <label>Data Final</label>
                         <input type="text" class="form-control text-center" maxlength="10" id="dtf" name="dtf"
                              value="<?php echo $dtf; ?>" required />
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2 text-center">
                         <br />
                         <button type="submit" id="con" name="consulta" class="bot-2"
                              title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                   class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                    </div>
               </div>

          </form>
     </div>
     <br />
     <div class="container-fluid">
          <div class="row">
               <div class="tab-1 table-responsive">
                    <table id="tab-0" class="table table-sm table-striped">
                         <thead>
                              <tr>
                                   <th width="3%">Alterar</th>
                                   <th width="3%">Excluir</th>
                                   <th width="5%">Número</th>
                                   <th>Status</th>
                                   <th>Nome do Contratante</th>
                                   <th>Plano</th>
                                   <th>Entrada</th>
                                   <th>Pagamento</th>
                                   <th>Valor</th>
                                   <th>Indicação</th>
                                   <th>Observação</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php $ret = carrega_tit($sta, $dti, $dtf);  ?>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
function carrega_tit($sta, $dti, $dtf) {
     $nro = 0;
     include_once "dados.php";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2);
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2);
     $com = "Select M.*, U.usunome, P.pladescricao, I.indnome from (((tb_titulo M left join tb_usuario U on M.titadministrador = U.idsenha) left join tb_plano P on M.titplano = P.idplano) left join tb_indicacao I on M.titindicacao = I.idindicacao) ";
     $com .= "where titdataemi between '" . $dti . "' and '" . $dtf . "' ";
     if ($sta != 9) { $com .=" and titstatus = " . $sta; }
     $com .= " order by idtitulo desc";          
     $nro = leitura_reg($com, $lin);
     foreach ($lin as $reg) {               
          $txt =  '<tr>';
          $txt .= '<td class="text-center"><a href="man-titulo.php?ope=2&cod=' . $reg['idtitulo'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $txt .= '<td class="text-center"><a href="man-titulo.php?ope=3&cod=' . $reg['idtitulo'] . '" title="Efetua exclusão do registro informado na linha"><i class="cor-1 large material-icons">delete_forever</i></a></td>';
          $txt .= '<td class="text-center">' . $reg['idtitulo'] . '</td>';
          if ($reg['titstatus'] == 0) {$txt .= "<td>" . "" . "</td>";}
          if ($reg['titstatus'] == 1) {$txt .= "<td>" . "Pago" . "</td>";}
          if ($reg['titstatus'] == 2) {$txt .= "<td>" . "Cancelado" . "</td>";} 
          if ($reg['titstatus'] == 3) {$txt .= "<td>" . "Cortesia" . "</td>";} 
          $txt .= '<td>' . $reg['usunome'] . '</td>';
          $txt .= '<td>' . $reg['pladescricao'] . '</td>';
          $txt .= '<td>' . date('d/m/Y',strtotime($reg['titdataemi'])) . '</td>';
          if ($reg['titdatabai'] == null) {
               $txt .= '<td>' . '' . '</td>';
          } else {
               $txt .= '<td>' . date('d/m/Y',strtotime($reg['titdatabai'])) . '</td>';
          }
          $txt .= '<td class="text-right">' . number_format($reg['titvalor'], 2, ",", ".") . '</td>';
          $txt .= '<td>' . $reg['indnome'] . '</td>';
          $txt .= '<td>' . $reg['titobservacao'] . '</td>';
          $txt .= '</tr>';
          echo $txt;
     }

     return $nro;
}


?>

</html>