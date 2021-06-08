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
     <title>Usuários - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
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
               [2, 'asc'],
               [4, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Usuários ...",
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
     $ret = 0; $ima = ''; 
     include_once "profsa.php";
     $_SESSION['wrknumvol'] = 0;
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");     
     if ($_SESSION['wrktipusu'] <= 3) {
          echo '<script>alert("Nível de usuário não permite visualização de log de acesso");</script>';
          echo '<script>history.go(-1);</script>';
     }     
?>

<body id="box00">
     <h1 class="cab-0">Menu Principal - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
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
          <div class="row">
               <div class="col-md-12">
                    <p class="lit-4">Consulta de Usuários &nbsp; &nbsp; &nbsp; <a href="man-usuario.php?ope=1&cod=0"
                              title="Abre janela para criação de novo usuário no sistema"><i
                                   class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></a></p>
               </div>
          </div>
          <br />
     </div>

     <div class="container">
          <div class="row">
               <div class="col-md-12">
                    <br />
                    <div class="tab-1 table-responsive">
                         <table id="tab-0" class="table table-sm table-striped">
                              <thead>
                                   <tr>
                                        <th width="3%">Alterar</th>
                                        <th width="3%">Excluir</th>
                                        <th>Contratante</th>
                                        <th width="3%">Código</th>
                                        <th>Nome do Usuário</th>
                                        <th>Status</th>
                                        <th>E-Mail</th>
                                        <th>Tipo</th>
                                        <th>Validade</th>
                                        <th>Acessos</th>
                                        <th>Celular</th>
                                        <th>Telefone</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php $ret = carrega_usu();  ?>
                              </tbody>
                         </table>
                         <hr />
                    </div>
               </div>
          </div>
     </div>

     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>
<?php
function carrega_usu() {
     include_once "dados.php";
     if ($_SESSION['wrktipusu'] == 5) {
          $com = "Select U.* , C.usunome as usucontratante from (tb_usuario U left join tb_usuario C on U.usuempresa = C.idsenha) order by usunome, idsenha";
     } else {
          $com = "Select U.*, C.usunome as usucontratante from (tb_usuario U left join tb_usuario C on U.usuempresa = C.idsenha) where U.usuempresa = " . $_SESSION['wrkcodemp'] . " order by U.usunome, U.idsenha";
     }
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($_SESSION['wrktipusu'] == 5 || $lin['usutipo'] < $_SESSION['wrktipusu'] || $_SESSION['wrkideusu'] == $lin['idsenha']) {
               $txt =  '<tr>';
               $txt .= '<td class="text-center"><a href="man-usuario.php?ope=2&cod=' . $lin['idsenha'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
               $txt .= '<td class="lit-d text-center"><a href="man-usuario.php?ope=3&cod=' . $lin['idsenha'] . '" title="Efetua exclusão do registro informado na linha"><i class="cor-1 large material-icons">delete_forever</i></a></td>';
               $txt .= "<td>" . $lin['usucontratante'] . "</td>";
               $txt .= '<td class="text-center">' . str_pad($lin['usuempresa'], 3, "0", STR_PAD_LEFT) . "-" . $lin['idsenha'] . '</td>';
               $txt .= "<td>" . $lin['usunome'] . "</td>";
               if ($lin['usustatus'] == 0) {$txt .= "<td>" . "Ativo" . "</td>";}
               if ($lin['usustatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
               if ($lin['usustatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
               if ($lin['usustatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
               $txt .= "<td>" . $lin['usuemail'] . "</td>";
               if ($lin['usutipo'] == 0) {$txt .= "<td>" . "Visitante" . "</td>";}
               if ($lin['usutipo'] == 1) {$txt .= "<td>" . "Vendedor" . "</td>";}
               if ($lin['usutipo'] == 2) {$txt .= "<td>" . "Titular" . "</td>";}
               if ($lin['usutipo'] == 3) {$txt .= "<td>" . "Gerente" . "</td>";}
               if ($lin['usutipo'] == 4) {$txt .= "<td>" . "Administrador" . "</td>";}
               if ($lin['usutipo'] == 5) {$txt .= "<td>" . "Usuário Master" . "</td>";}
               if ($lin['usuvalidade'] == null) {
                    $txt .= "<td>" . '' . "</td>";
               }else{
                    $txt .= "<td>" . date('d/m/Y',strtotime($lin['usuvalidade'])) . "</td>";
               }
               $txt .= '<td class="text-center">' . $lin['usuacessos'] . '</td>';
               $txt .= "<td>" . $lin['usucelular'] . "</td>";
               $txt .= "<td>" . $lin['usutelefone'] . "</td>";
               $txt .= "</tr>";
               echo $txt;
          }
     }
}

?>

</html>