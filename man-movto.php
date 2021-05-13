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
     <title>Movimento - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#qtd").mask("000.000.000", {
          reverse: true
     });
     $("#val").mask("000.000.000,00", {
          reverse: true
     });
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
});

$(function() {
     $('#nom').autocomplete({
          source: "ajax/mostrar-cta.php",
          minLength: 3,
          select: function(event, ui) {
               $('#cta').val(ui.item.id);
               $('#usu').val(ui.item.usuario);
               $('#pro').val(ui.item.programa);
               if (ui.item.tipo == 0) {
                    $('#tit').text("Quantidade de Milhas");
               } else {
                    $('#tit').text("Quantidade de Pontos");
               }
          }
     });
});

$(document).ready(function() {
     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#frmTelMan').submit(function() {
          erro = 0;
          var dad = $('#frmTelMan').serialize();
          let cta = $('#cta').val();
          if (cta == '0' || cta == '') {
               $('#nom').val("");
               alert("Informação de usuário/programa para movimento não é válida !");
               erro = 1;
          }
          if (erro == 1) {
               return false;
          } else {
               $.post("ajax/gravar-mov.php", dad, function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         $('#nom').val('');
                         $('#cta').val(0);
                         $('#usu').val('');
                         $('#pro').val('');
                         $('#qtd').val('');
                         $('#val').val('');
                         $('#pre').val('');
                         $('#dat').val('');
                         $('#obs').val('');
                    }
               }, "json");
          }
     });

     $('.opc').click(function() {
          let opc = $(this).attr("value");
          
     });


     $('#qtd').blur(function() {
          let pre = 0;
          let qtd = $('#qtd').val();
          let val = $('#val').val();
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre').val(pre);
          }
     });

     $('#val').blur(function() {
          let pre = 0;
          let qtd = $('#qtd').val();
          let val = $('#val').val();
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre').val(pre);
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
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6, "Entrada na página de manutenção de Movimento do sistema Pallas.49 ");  
          }
     }
     $nom = (isset($_REQUEST['nom']) == false ? '' : $_REQUEST['nom']);
     $qtd = (isset($_REQUEST['qtd']) == false ? '' : $_REQUEST['qtd']);
     $val = (isset($_REQUEST['val']) == false ? '' : $_REQUEST['val']);
     $dat = (isset($_REQUEST['dat']) == false ? date('d/m/Y') : $_REQUEST['dat']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     if (isset($_REQUEST['salvar']) == true) {
          $nom = ""; $qtd = ""; $val = ""; $dat = date('d/m/Y'); $obs = ""; 
     }
?>

<body id="box00">
     <h1 class="cab-0">Movimento - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <form class="qua-2 qua-3" id="frmTelMan" name="frmTelMan" action="man-movto.php" method="POST">
               <p class="lit-4">Movimentação de Contas &nbsp; &nbsp; &nbsp; </p>
               <br />
               <div class="row text-center">
                    <div class="col-md-4">
                         <input type="radio" class="opc" name="opc" value="1" checked="checked" /><span> Compra </span>
                    </div>
                    <div class="col-md-4">
                         <input type="radio" class="opc" name="opc" value="2" /><span> Transferência </span>
                    </div>
                    <div class="col-md-4">
                         <input type="radio" class="opc" name="opc" value="3" /><span> Venda </span>
                    </div>
               </div>
               <br />

               <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               <div id="mov_c">
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Usuário / Programa para a Operação</label>
                              <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                                   value="<?php echo $nom; ?>" required />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Usuário</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="usu" name="usu"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Programa</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="pro" name="pro"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit">Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="qtd" name="qtd"
                                   value="<?php echo $qtd; ?>" required />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Custo Total R$</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="val" name="val"
                                   value="<?php echo $val; ?>" required />
                         </div>
                         <div class="col-md-1"></div>
                         <div class="col-md-2 text-center">
                              <label>Preço Unitário</label>
                              <input type="text" class="form-control text-center" maxlength="12" id="pre" name="pre"
                                   value="" disabled />
                         </div>
                         <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Data da Compra</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dat" name="dat"
                                   value="<?php echo $dat; ?>" required />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Observação</label>
                              <textarea class="form-control" rows="3" id="obs" name="obs"><?php echo $obs; ?></textarea>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
               </div>
               <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

               <br />
               <div class="row">
                    <div class="col-12 text-center">
                         <button type="submit" id="gra" name="salvar" class="bot-1">Salvar</button>
                    </div>
               </div>
               <br />
               <input type="hidden" id="cta" name="cta" value="0" />
          </form>
     </div>
     <br />
</body>

<?php

?>

</html>