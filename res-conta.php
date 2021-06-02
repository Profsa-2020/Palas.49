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
$(function() {
     $("#dti").mask("99/99/9999");
     $("#dtf").mask("99/99/9999");
     $("#dti").datepicker($.datepicker.regional["pt-BR"]);
     $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {

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
     date_default_timezone_set("America/Sao_Paulo");
     $dti = date('d/m/Y', strtotime('-29 days'));
     $dtf = date('d/m/Y');
     $usu = (isset($_REQUEST['usu']) == false ? 0 : $_REQUEST['usu']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Resumo por Contano sistema: " . $dti . " até " . $dtf);  
          }
     }
     $ope = (isset($_REQUEST['ope']) == false ? 0 : $_REQUEST['ope']);

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
                                   <div class="col-md-3"></div>
                                   <div class="col-md-3">
                                        <label>Usuário</label>
                                        <select id="usu" name="usu" class="form-control">
                                             <?php $ret = carrega_usu($usu); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Programa</label>
                                        <select id="pro" name="pro" class="form-control">
                                             <?php $ret = carrega_pro($pro); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-2"></div>
                                   <div class="col-md-1 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <br />
                         </form>
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
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
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
     echo '<option value="0" selected="selected">Selecione ...</option>';
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

function carrega_mov($ope, $usu, $pro, $dti, $dtf) {
     $nro = 0; $com = "";
     include_once "dados.php";


     return $nro;
}

?>

</html>