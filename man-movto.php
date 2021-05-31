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
     $("#cpf_p").mask("000");
     $("#dat").mask("00/00/0000");
     $("#dat_v").mask("00/00/0000");
     $("#dat_p").mask("00/00/0000");
     $("#dat_t").mask("00/00/0000");
     $("#rec_v").mask("00/00/0000");
     $("#dtb_t").mask("00/00/0000");
     $("#qtd").mask("000.000.000", {
          reverse: true
     });
     $("#val").mask("000.000.000,00", {
          reverse: true
     });
     $("#qtd_v").mask("000.000.000", {
          reverse: true
     });
     $("#qtd_t").mask("000.000.000", {
          reverse: true
     });
     $("#qtd_p").mask("000.000.000", {
          reverse: true
     });
     $("#val_v").mask("000.000.000,00", {
          reverse: true
     });
     $("#vai_t").mask("000,00", {
          reverse: true
     });
     $("#vol_t").mask("000,00", {
          reverse: true
     });
     $("#val_t").mask("000.000.000,00", {
          reverse: true
     });
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
     $("#dat_v").datepicker($.datepicker.regional["pt-BR"]);
     $("#dat_p").datepicker($.datepicker.regional["pt-BR"]);
     $("#rec_v").datepicker($.datepicker.regional["pt-BR"]);
     $("#dat_t").datepicker($.datepicker.regional["pt-BR"]);
     $("#dtb_t").datepicker($.datepicker.regional["pt-BR"]);
});

$(function() {
     $('#nom').autocomplete({
          source: "ajax/mostrar-con.php",
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

     $('#nom_v').autocomplete({
          source: "ajax/mostrar-mil.php",
          minLength: 3,
          select: function(event, ui) {
               $('#cta_v').val(ui.item.id);
               $('#usu_v').val(ui.item.usuario);
               $('#pro_v').val(ui.item.programa);
               if (ui.item.tipo == 0) {
                    $('#tit_v').text("Quantidade de Milhas");
               } else {
                    $('#tit_v').text("Quantidade de Pontos");
               }
          }
     });

     $('#nom_p').autocomplete({
          source: "ajax/mostrar-mil.php",
          minLength: 3,
          select: function(event, ui) {
               $('#cta_p').val(ui.item.id);
               $('#usu_p').val(ui.item.usuario);
               $('#pro_p').val(ui.item.programa);
               if (ui.item.tipo == 0) {
                    $('#tit_p').text("Quantidade de Milhas");
               } else {
                    $('#tit_p').text("Quantidade de Pontos");
               }
          }
     });

     $('#nom_t').autocomplete({
          source: "ajax/mostrar-pon.php",
          minLength: 3,
          select: function(event, ui) {
               let tam = ui.item.usuario.trim().length - 1;
               $('#cta_t').val(ui.item.id);
               $('#des_t').val(ui.item.usuario.substring(0, tam));
               if (ui.item.tipo == 0) {
                    $('#tit_t').text("Milhas a Transferir");
               } else {
                    $('#tit_t').text("Pontos a Transferir");
               }
          }
     });

     $('#des_t').autocomplete({
          source: "ajax/mostrar-mil.php",
          minLength: 3,
          select: function(event, ui) {
               $('#cta_d').val(ui.item.id);
               if (ui.item.tipo == 0) {
                    $('#tit_d').text("Milhas Transferidas");
               } else {
                    $('#tit_d').text("Pontos Transferidos");
               }
          }
     });

});

$(document).ready(function() {

     $("#mov_c").show(); // $("#mov_c").fadeOut();          $("#mov_c").fadeOut("fast");
     $("#mov_v").hide(); //  $("#mov_v").fadeIn();           $("#mov_v").fadeIn("slow");
     $("#mov_p").hide();
     $("#mov_t").hide();

     var alt = $(window).height();
     var lar = $(window).width();
     if (lar < 800) {
          $('nav').removeClass("fixed-top");
     }

     $('#frmTelMan').submit(function() {
          let erro = 0;
          let rec = "";
          let int = "";
          let nom = "";
          let cta = "";
          let qtd = "";
          let val = "";
          let dat = "";
          let car = "";
          let cpf = "";
          let loc = "";
          let dst = "";
          let pro = 0;
          let des = "";
          let bon = "";
          let vai = "";
          let vol = "";

          let dad = $('#frmTelMan').serialize();
          let opc1 = $("#opc_1").prop("checked");
          let opc2 = $("#opc_2").prop("checked");
          let opc3 = $("#opc_3").prop("checked");
          let opc4 = $("#opc_4").prop("checked");
          if (opc1 == true) {
               nom = $('#nom').val();
               cta = $('#cta').val();
               qtd = $('#qtd').val();
               val = $('#val').val();
               car = $('#car').val();
               dat = $('#dat').val();
          }
          if (opc2 == true) {
               nom = $('#nom_t').val();
               dst = $('#des_t').val();
               pro = $('#pro_t').val();
               cta = $('#cta_t').val();
               des = $('#cta_d').val();
               qtd = $('#qtd_t').val();
               val = $('#val_t').val();
               dat = $('#dat_t').val();
               bon = $('#dtb_t').val();
               vai = $('#vai_t').val();
               vol = $('#vol_t').val();
          }
          if (opc3 == true) {
               nom = $('#nom_v').val();
               cta = $('#cta_v').val();
               qtd = $('#qtd_v').val();
               val = $('#val_v').val();
               dat = $('#dat_v').val();
               rec = $('#rec_v').val();
               int = $('#int_v').val();
          }
          if (opc4 == true) {
               nom = $('#nom_p').val();
               cta = $('#cta_p').val();
               qtd = $('#qtd_p').val();
               dat = $('#dat_p').val();
               int = $('#int_p').val();
               cpf = $('#cpf_p').val();
               loc = $('#loc_p').val();
          }
          if (nom == '0' || nom == '') {
               alert("Informação de usuário/programa para movimento está em branco !");
               erro = 1;
          }
          if (qtd == '0' || qtd == '') {
               alert("Quantidade informada para ser movimento está em branco !");
               erro = 1;
          }
          if (opc4 == false && (val == '0' || val == '')) {
               alert("Valor Total informado para ser movimento está em branco !");
               erro = 1;
          }
          if (dat == '0' || dat == '') {
               alert("Data de movimento da conta não pode ficar em branco !");
               erro = 1;
          }
          if (cta == '0' || cta == '') {
               $('#nom').val("");
               alert("Informação de usuário/programa para movimento não é válida !");
               erro = 1;
          }
          if (opc2 == true) {
               if (dst == '') {
                    alert("Conta de Destino da operação não pode ficar em branco !");
                    erro = 1;
               }
               if (bon == '') {
                    alert("Data para o Bônus da operação não pode ficar em branco !");
                    erro = 1;
               }
               if (cta == des) {
                    alert("Contas de Operação de origem e de destino não podem ser iguais !");
                    erro = 1;
               }
               if (des == '0' || des == '') {
                    alert("Conta para Operação de destino não pode ficar em branco !");
                    erro = 1;
               }
          }
          if (opc3 == true) {
               if (rec == '') {
                    alert("Informação de data de recebimento não pode ficar em branco !");
                    erro = 1;
               }
               if (int == '0' || int == '') {
                    alert("Informação do intermediário para venda não pode ficar em branco !");
                    erro = 1;
               }
          }
          if (opc4 == true) {
               if (cpf == '') {
                    alert("Informação de número de Cpf´s não pode ficar em branco ou zero !");
                    erro = 1;
               }
          }
          if (erro == 1) {
               return false;
          } else {
               $.post("ajax/gravar-mov.php", dad, function(data) {
                    if (data.men != "") {
                         alert(data.men);
                         return false;
                    } else {
                         $('#nom').val('');
                         $('#cta').val(0);
                         $('#car').val(0);
                         $('#usu').val('');
                         $('#pro').val('');
                         $('#qtd').val('');
                         $('#val').val('');
                         $('#pre').val('');
                         $('#dat').val('');
                         $('#obs').val('');
                         $('#car').val('');
                         $('#cus_c').val(0);
                         $('#tot_s').val(0);
                         $('#med_t').val(0);
                         $('#qtd_m').val(0);
                         $('#qtd_s').val(0);
                         $('#val_s').val(0);
                         $('#cta_t').val(0);
                         $('#cta_d').val(0);
                         $('#cta_v').val(0);
                    }
               }, "json");
          }
     });

     $('.opc').click(function() {
          $('#nom').val('');
          $('#cta').val(0);
          $('#qtd').val('');
          $('#val').val('');
          $('#usu').val('');
          $('#pro').val('');
          $('#pre').val('');
          $('#sal').val('');
          $('#lib').val('');
          $('#car').val(0);
          $('#nom_v').val('');
          $('#cta_v').val(0);
          $('#qtd_v').val('');
          $('#val_v').val('');
          $('#usu_v').val('');
          $('#pro_v').val('');
          $('#pre_v').val('');
          $('#nom_p').val('');
          $('#cta_p').val(0);
          $('#qtd_p').val('');
          $('#usu_p').val('');
          $('#pro_p').val('');
          $('#nom_t').val('');
          $('#des_t').val('');
          $('#cta_t').val(0);
          $('#cta_d').val(0);
          $('#cus_c').val(0);
          $('#tot_s').val(0);
          $('#med_t').val(0);
          $('#qtd_m').val(0);
          $('#qtd_s').val(0);
          $('#val_s').val(0);
          let opc = $(this).attr("value");
          if (opc == 1) {
               $("#mov_v").fadeOut();
               $("#mov_p").fadeOut();
               $("#mov_t").fadeOut();
               $("#mov_c").fadeIn();
          }
          if (opc == 2) {
               $("#mov_c").fadeOut();
               $("#mov_p").fadeOut();
               $("#mov_v").fadeOut();
               $("#mov_t").fadeIn();
          }
          if (opc == 3) {
               $("#mov_c").fadeOut();
               $("#mov_p").fadeOut();
               $("#mov_t").fadeOut();
               $("#mov_v").fadeIn();
          }
          if (opc == 4) {
               $("#mov_c").fadeOut();
               $("#mov_v").fadeOut();
               $("#mov_t").fadeOut();
               $("#mov_p").fadeIn();
          }
     });

     $('#nom').blur(function() {
          // debugger; Dá pausa no programa para debugar (debug) em código javascript
          let cta = $('#cta').val();
          if (cta != 0) {
               $.getJSON("ajax/carrega-sdo.php", {
                         cta: cta
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                         } else {
                              $('#sal').text(data.sal);
                              $('#lib').text(data.lib);
                              $('#qtd_s').val(data.sal);
                              $('#tot_s').val(data.tot);
                              $('#val_s').val(data.val);
                              $('#qtd_m').val(data.qtd);
                         }
                    }).fail(function(data) {
                         console.log('Erro: ' + JSON.stringify(data));
                         alert("Erro ocorrido no processamento do saldo da conta para compra");
                    });
          }
     });

     $('#nom_t').blur(function() {
          // debugger; Dá pausa no programa para debugar (debug) em código javascript
          let cta = $('#cta_t').val();
          if (cta != 0) {
               $.getJSON("ajax/carrega-sdo.php", {
                         cta: cta
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                         } else {
                              $('#sal_t').text(data.sal);
                              $('#cto_t').text(data.cus);
                              $('#med_t').val(data.med);
                              $('#lib_t').text(data.lib);
                              $('#qtd_s').val(data.sal);
                              $('#tot_s').val(data.tot);
                              $('#val_s').val(data.val);
                              $('#qtd_m').val(data.qtd);
                         }
                    }).fail(function(data) {
                         console.log('Erro: ' + JSON.stringify(data));
                         alert("Erro ocorrido no processamento do saldo da conta para compra");
                    });
          }
     });

     $('#nom_v').blur(function() {
          // debugger;   // Para o programa - pausa - brek point
          let cta = $('#cta_v').val();
          if (cta != 0) {
               $.getJSON("ajax/carrega-sdo.php", {
                         cta: cta
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                         } else {
                              $('#sal_v').text(data.sal);
                              $('#lib_v').text(data.lib);
                              $('#qtd_s').val(data.sal);
                              $('#tot_s').val(data.tot);
                              $('#val_s').val(data.val);
                              $('#qtd_m').val(data.qtd);
                         }
                    }).fail(function(data) {
                         console.log('Erro: ' + JSON.stringify(data));
                         alert("Erro ocorrido no processamento do saldo da conta para venda");
                    });
          }
     });

     $('#nom_p').blur(function() {
          let cta = $('#cta_p').val();
          if (cta != 0) {
               $.getJSON("ajax/carrega-sdo.php", {
                         cta: cta
                    })
                    .done(function(data) {
                         if (data.men != "") {
                              alert(data.men);
                         } else {
                              $('#sal_p').text(data.sal);
                              $('#lib_p').text(data.lib);
                              $('#qtd_s').val(data.sal);
                              $('#tot_s').val(data.tot);
                              $('#val_s').val(data.val);
                              $('#qtd_m').val(data.qtd);
                         }
                    }).fail(function(data) {
                         console.log('Erro: ' + JSON.stringify(data));
                         alert("Erro ocorrido no processamento do saldo da conta para passagem");
                    });
          }
     });

     $('#dat').blur(function() {
          if ($('#dat').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#dat').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#dat_v').blur(function() {
          if ($('#dat_v').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#dat_v').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#rec_v').blur(function() {
          if ($('#rec_v').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#rec_v').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#dat_p').blur(function() {
          if ($('#dat_p').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#dat_p').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#dat_t').blur(function() {
          if ($('#dat_t').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#dat_t').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#dtb_t').blur(function() {
          if ($('#dtb_t').val() == "") {
               var dat = new Date;
               var ddd = ('0' + dat.getDate()).slice(-2);
               var mmm = ('0' + (dat.getMonth() + 1)).slice(-2);
               var aaa = dat.getFullYear();
               $('#dtb_t').val(ddd + "/" + mmm + "/" + aaa);
          }
     });

     $('#qtd').blur(function() { // Calculla preço unitário pela qtd
          let pre = 0;
          let qtd = $('#qtd').val();
          let val = $('#val').val();
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre').val(pre);
          }
     });

     $('#val').blur(function() { // Calculla preço unitário pelo valor
          let pre = 0;
          let qtd = $('#qtd').val();
          let val = $('#val').val();
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre').val(pre);
          }
     });

     $('#qtd_v').blur(function() {
          let pre = 0;
          let sal = $('#qtd_s').val();
          let tot = $('#tot_s').val();
          let qtd = $('#qtd_v').val();
          let val = $('#val_v').val();
          if (qtd == "") {
               qtd = sal;
               $('#qtd_v').val(sal);
          }
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre_v').val(pre);
          }
     });

     $('#val_v').blur(function() {
          let pre = 0;
          let qtd = $('#qtd_v').val();
          let val = $('#val_v').val();
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#pre_v').val(pre);
          }
     });

     $('#pro_t').change(function() {
          let pro = $('#pro_t').val();
          $('#boi_t').val('');
          $('#bov_t').val('');
          if (pro == 1) {
               $('#vai_t').val('');
               $('#vol_t').val('');
               $('#lit_p').text('Percentual de Bônus');
               $('#lit_b').text('Bônus de Transferência');
               $('#vol_t').attr('disabled', 'disabled');
          }
          if (pro == 2) {
               $('#vol_t').removeAttr('disabled');
               $('#lit_p').text('Percentual que Vai');
               $('#lit_b').text('Bônus que Vai');
          }
     });


     $('#qtd_t').blur(function() {
          var qtd = $('#qtd_t').val();
          var qua = $('#qtd_m').val();
          var pre = $('#med_t').val();
          if (qtd == "") {
               $('#qtd_t').val($('#qtd_s').val());
               $('#val_t').val($('#tot_s').val());
               var cus = (pre * 1000).toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#cus_t').val(cus);
          }
          if (qtd > $('#qtd_s').val()) {
               alert("Quantidade informada não pode ser maior que quantidade em saldo !");
               $('#qtd_t').val($('#qtd_s').val());
               $('#qtd_d').val($('#qtd_s').val());
          }
     });

     $('#qtd_v').blur(function() {
          var qtd = $('#qtd_v').val();
          if (qtd == "") {
               $('#qtd_v').val($('#qtd_s').val());
          }
          if (qtd > $('#qtd_s').val()) {
               alert("Quantidade a vender não pode ser maior que quantidade em saldo !");
               $('#qtd_v').val($('#qtd_s').val());
          }
     });

     $('#qtd_t').change(function() {
          var val = $('#val_t').val();
          var qtd = $('#qtd_t').val();
          var med = $('#med_t').val();
          $('#qtd_d').val(qtd);
          if (qtd != "" && qtd != "0") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               var cus = qtd * med;
               cus = cus.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               cus = cus.replace('R$', '');
               $('#val_t').val(cus.trim());

               val = (qtd * med).toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               val = val.replace('R$', '');
          }
          if (qtd != "" && val != "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               $('#cus_c').val(pre);
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#cus_t').val(pre);
          }
     });

     $('#val_t').change(function() {
          let pro = $('#pro_t').val();
          let val = $('#val_t').val();
          let qtd = $('#qtd_t').val();
          let vai = $('#vai_t').val();
          let vol = $('#vol_t').val();
          $('#qtd_d').val(qtd);
          if (qtd != "" && val != "" && vai == "" && vol == "") {
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = val.replace('.', '');
               val = val.replace(',', '.');
               pre = val / qtd * 1000;
               $('#cus_c').val(pre);
               pre = pre.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               $('#cus_t').val(pre);
          }
     });

     $('#vai_t').change(function() {    // Qtd que vai - Calculo de transferência e Boomerangue com preço de custo
          let pro = $('#pro_t').val();
          let qtd = $('#qtd_t').val();
          let per = $('#vai_t').val();
          let vai = $('#vai_t').val();
          let vol = $('#vol_t').val();
          if (per == "" || qtd == "") {
               $('#boi_t').val('');
          } else {
               per = per.replace('.', '');
               per = per.replace(',', '.');
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               let vai = $('#vai_t').val();
               let vol = $('#vol_t').val();
               val = qtd * per / 100;
               val = val.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               val = val.replace('R$', '');
               val = val.replace(',00', '');
               $('#boi_t').val(val);
          }
          if (per != "" && qtd != "" && vai != "" && vol != "") {
               let val = $('#val_t').val();
               val = val.replace('.', '');
               val = val.replace(',', '.');
               if (pro == 1) {
                    let res = parseFloat(qtd, 10) * (1 + parseFloat(per, 10) / 100);
                    res = val / res * 1000;
                    $('#cus_c').val(res);
                    res = res.toLocaleString("pt-BR", {
                         style: "currency",
                         currency: "BRL"
                    });
                    $('#cus_t').val(res);
               } else {
                    let tot = 0; // Calculo de promoção Bumerange, preço de custo por milhero
                    let med = $('#med_t').val();
                    vai = vai.replace('.', '');
                    vai = vai.replace(',', '.');
                    vol = vol.replace('.', '');
                    vol = vol.replace(',', '.');
                    let res = parseFloat(qtd, 10) * (1 - parseFloat(vol, 10) / 100);
                    res = res * med;
                    res = res / (qtd * (1 + parseFloat(vai, 10) / 100)) * 1000;
                    $('#cus_c').val(res);
                    res = res.toLocaleString("pt-BR", {
                         style: "currency",
                         currency: "BRL"
                    });
                    $('#cus_t').val(res);
               }
          }
     });

     $('#vol_t').change(function() {
          let val = 0;
          let pro = $('#pro_t').val();
          let qtd = $('#qtd_t').val();
          let per = $('#vol_t').val();
          let vai = $('#vai_t').val();
          let vol = $('#vol_t').val();
          if (per == "" || qtd == "") {
               $('#bov_t').val('');
          } else {
               per = per.replace('.', '');
               per = per.replace(',', '.');
               qtd = qtd.replace('.', '');
               qtd = qtd.replace(',', '.');
               val = qtd * per / 100;
               val = val.toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL"
               });
               val = val.replace('R$', '');
               val = val.replace(',00', '');
               $('#bov_t').val(val);
          }
          if (per != "" && qtd != "" && vai != "" && vol != "") {
               let val = $('#val_t').val();
               val = val.replace('.', '');
               val = val.replace(',', '.');
               if (pro == 1) {
                    let res = parseFloat(qtd, 10) * (1 + parseFloat(per, 10) / 100);
                    res = val / res * 1000;
                    $('#cus_c').val(res / 1000);
                    res = res.toLocaleString("pt-BR", {
                         style: "currency",
                         currency: "BRL"
                    });
                    $('#cus_t').val(res);
               } else {
                    let tot = 0; // Calculo de promoção Bumerange, preço de custo por milhero
                    let med = $('#med_t').val();
                    vai = vai.replace('.', '');
                    vai = vai.replace(',', '.');
                    vol = vol.replace('.', '');
                    vol = vol.replace(',', '.');
                    let res = parseFloat(qtd, 10) * (1 - parseFloat(vol, 10) / 100);
                    res = res * med;
                    res = res / (qtd * (1 + parseFloat(vai, 10) / 100)) * 1000;
                    $('#cus_c').val(res / 1000);
                    res = res.toLocaleString("pt-BR", {
                         style: "currency",
                         currency: "BRL"
                    });
                    $('#cus_t').val(res);
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
     $car = (isset($_REQUEST['car']) == false ? 0 : $_REQUEST['car']);
     $dat = (isset($_REQUEST['dat']) == false ? date('d/m/Y') : $_REQUEST['dat']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     $nom_v = (isset($_REQUEST['nom_v']) == false ? '' : $_REQUEST['nom_v']);
     $qtd_v = (isset($_REQUEST['qtd_v']) == false ? '' : $_REQUEST['qtd_v']);
     $val_v = (isset($_REQUEST['val_v']) == false ? '' : $_REQUEST['val_v']);
     $int_v = (isset($_REQUEST['int_v']) == false ? 0 : $_REQUEST['int_v']);
     $rec_v = (isset($_REQUEST['rec_v']) == false ? date('d/m/Y', strtotime('+45 days')) : $_REQUEST['rec_v']);
     $dat_v = (isset($_REQUEST['dat_v']) == false ? date('d/m/Y') : $_REQUEST['dat_v']);
     $obs_v = (isset($_REQUEST['obs_v']) == false ? '' : str_replace("'", "´", $_REQUEST['obs_v']));

     $nom_p = (isset($_REQUEST['nom_p']) == false ? '' : $_REQUEST['nom_p']);
     $qtd_p = (isset($_REQUEST['qtd_p']) == false ? '' : $_REQUEST['qtd_p']);
     $loc_p = (isset($_REQUEST['loc_p']) == false ? '' : $_REQUEST['loc_p']);
     $int_p = (isset($_REQUEST['int_p']) == false ? 0 : $_REQUEST['int_p']);
     $cpf_p = (isset($_REQUEST['cpf_p']) == false ? 0 : $_REQUEST['cpf_p']);
     $dat_p = (isset($_REQUEST['dat_p']) == false ? date('d/m/Y') : $_REQUEST['dat_p']);
     $obs_p = (isset($_REQUEST['obs_p']) == false ? '' : str_replace("'", "´", $_REQUEST['obs_p']));

     $nom_t = (isset($_REQUEST['nom_t']) == false ? '' : $_REQUEST['nom_t']);
     $des_t = (isset($_REQUEST['des_t']) == false ? '' : $_REQUEST['des_t']);
     $qtd_t = (isset($_REQUEST['qtd_t']) == false ? '' : $_REQUEST['qtd_t']);
     $pro_t = (isset($_REQUEST['pro_t']) == false ? 1 : $_REQUEST['pro_t']);
     $val_t = (isset($_REQUEST['val_t']) == false ? '' : $_REQUEST['val_t']);
     $vai_t = (isset($_REQUEST['vai_t']) == false ? '' : $_REQUEST['vai_t']);
     $vol_t = (isset($_REQUEST['vol_t']) == false ? '' : $_REQUEST['vol_t']);
     $bon_t = (isset($_REQUEST['bon_t']) == false ? '' : $_REQUEST['bon_t']);
     $dtb_t = (isset($_REQUEST['dtb_t']) == false ? date('d/m/Y', strtotime('+18 days')) : $_REQUEST['dtb_t']);
     $dat_t = (isset($_REQUEST['dat_t']) == false ? date('d/m/Y') : $_REQUEST['dat_t']);
     $obs_t = (isset($_REQUEST['obs_t']) == false ? '' : str_replace("'", "´", $_REQUEST['obs_t']));

     if (isset($_REQUEST['salvar']) == true) {
          $nom = ""; $qtd = ""; $val = ""; $dat = date('d/m/Y'); $obs = ""; $car = 0;
          $nom_v = ""; $qtd_v = ""; $val_v = ""; $dat_v = date('d/m/Y'); $obs_v = ""; $rec_v = date('d/m/Y', strtotime('+45 days')); $int_v = 0; 
          $nom_p = ""; $qtd_p = ""; $dat_p = date('d/m/Y'); $obs_p = ""; $loc_p = ""; $int_p = 0; $cpf_p = 0; 
          $nom_t = ""; $qtd_t = ""; $dat_t = date('d/m/Y'); $obs_t = ""; $des_t = ""; $pro_t = 1; $val_t = ''; $vai_t = ''; $vol_t = ''; $bon_t = ''; $dtb = date('d/m/Y', strtotime('+18 days'));
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
                    <div class="col-md-3">
                         <input type="radio" id="opc_1" class="opc" name="opc" value="1" checked="checked" /><span>
                              Compra </span>
                    </div>
                    <div class="col-md-3">
                         <input type="radio" id="opc_2" class="opc" name="opc" value="2" /><span> Transferência </span>
                    </div>
                    <div class="col-md-3">
                         <input type="radio" id="opc_3" class="opc" name="opc" value="3" /><span> Venda </span>
                    </div>
                    <div class="col-md-3">
                         <input type="radio" id="opc_4" class="opc" name="opc" value="4" /><span> Passagens </span>
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
                                   value="<?php echo $nom; ?>" />
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
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Cartão de Crédito</label>
                              <select id="car" name="car" class="form-control">
                                   <?php $ret = carrega_car($car); ?>
                              </select>
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit">Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="qtd" name="qtd"
                                   value="<?php echo $qtd; ?>" />
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Atual</label><br />
                              <p id="sal">0</p>
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Liberar</label><br />
                              <p id="lib">0</p>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Custo Total R$</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="val" name="val"
                                   value="<?php echo $val; ?>" />
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
                                   value="<?php echo $dat; ?>" />
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
               <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               <div id="mov_t">
                    <table class="table tab-3">
                         <tbody>
                              <tr>
                                   <td>
                                        <div class="form-row">
                                             <div class="col-md-12">
                                                  <label>Conta de Origem</label>
                                                  <input type="text" class="form-control" maxlength="50" id="nom_t"
                                                       name="nom_t" value="<?php echo $nom_t; ?>" />
                                             </div>
                                             <br />
                                             <div class="col-md-3"></div>
                                             <div class="col-md-6">
                                                  <label>Promoção</label>
                                                  <select id="pro_t" name="pro_t" class="form-control">
                                                       <option value="1"
                                                            <?php echo ($pro_t != 1 ? '' : 'selected="selected"'); ?>>
                                                            Transferência
                                                       </option>
                                                       <option value="2"
                                                            <?php echo ($pro_t != 2 ? '' : 'selected="selected"'); ?>>
                                                            Bumerangue
                                                       </option>
                                                  </select>
                                             </div>
                                             <div class="col-md-3"></div>
                                             <br />
                                             <div class="col-md-3"></div>
                                             <div class="col-md-6">
                                                  <label id="tit_t">Quantidade a Transferir</label>
                                                  <input type="text" class="form-control text-right" maxlength="10"
                                                       id="qtd_t" name="qtd_t" value="<?php echo $qtd_t; ?>" />
                                             </div>
                                             <div class="col-md-3"></div>
                                             <br />
                                             <div class="col-md-5">
                                                  <label id="lit_p">Percentual de Bônus</label>
                                                  <input type="text" class="form-control text-center" maxlength="5"
                                                       id="vai_t" name="vai_t" value="<?php echo $vai_t; ?>" />
                                             </div>
                                             <div class="col-md-2"></div>
                                             <div class="col-md-5">
                                                  <label>Percentual que Volta</label>
                                                  <input type="text" class="form-control text-center" maxlength="5"
                                                       id="vol_t" name="vol_t" value="<?php echo $vol_t; ?>" disabled />
                                             </div>
                                             <br />
                                             <div class="col-md-6">
                                                  <label>Custo Total</label>
                                                  <input type="text" class="form-control text-right" maxlength="12"
                                                       id="val_t" name="val_t" value="<?php echo $val_t; ?>" />
                                             </div>
                                             <div class="col-md-6">
                                                  <label>Data da Operação</label>
                                                  <input type="text" class="form-control text-center" maxlength="10"
                                                       id="dat_t" name="dat_t" value="<?php echo $dat_t; ?>" />
                                             </div>
                                             <br />
                                             <div class="col-md-12">
                                                  <label>Observação</label>
                                                  <textarea class="form-control" rows="3" id="obs_t"
                                                       name="obs_t"><?php echo $obs; ?></textarea>
                                             </div>
                                        </div>
                                   </td>

                                   <td>
                                        <div class="form-row">
                                             <div class="col-md-12">
                                                  <label>Conta de Destino</label>
                                                  <input type="text" class="form-control" maxlength="50" id="des_t"
                                                       name="des_t" value="<?php echo $des_t; ?>" />
                                             </div>
                                             <br />
                                             <div class="lin-3"></div>
                                             <br />
                                             <div class="col-md-6">
                                                  <label id="tit_d">Quantidade Transferida</label>
                                                  <input type="text" class="form-control text-center" maxlength="12"
                                                       id="qtd_d" name="qtd_d" value="" disabled />
                                             </div>
                                             <div class="col-md-6">
                                                  <label>Custo por Milheiro</label>
                                                  <input type="text" class="form-control text-center" maxlength="12"
                                                       id="cus_t" name="cus_t" value="" disabled />
                                             </div>
                                             <br />
                                             <div class="col-md-6">
                                                  <label id="lit_b">Bônus de Transferência</label>
                                                  <input type="text" class="form-control text-center" maxlength="12"
                                                       id="boi_t" name="boi_t" value="" disabled />
                                             </div>
                                             <div class="col-md-6">
                                                  <label>Bônus de Volta (Pontos)</label>
                                                  <input type="text" class="form-control text-center" maxlength="12"
                                                       id="bov_t" name="bov_t" value="" disabled />
                                             </div>
                                             <br />
                                             <div class="col-md-3"></div>
                                             <div class="col-md-6">
                                                  <label>Data para o Bônus</label>
                                                  <input type="text" class="form-control text-center" maxlength="10"
                                                       id="dtb_t" name="dtb_t" value="<?php echo $dtb_t; ?>" />
                                             </div>
                                             <div class="col-md-3"></div>
                                             <br />
                                             <div class="lit-1 col-md-4 text-center">
                                                  <label>Saldo Atual</label><br />
                                                  <p id="sal_t">0</p>
                                             </div>
                                             <div class="lit-1 col-md-4 text-center">
                                                  <label>Saldo Liberar</label><br />
                                                  <p id="lib_t">0</p>
                                             </div>
                                             <div class="lit-1 col-md-4 text-center">
                                                  <label>Custo Médio</label><br />
                                                  <p id="cto_t">0,00</p>
                                             </div>
                                        </div>
                                   </td>

                              </tr>
                         </tbody>
                    </table>
               </div>
               <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               <div id="mov_v">
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Usuário / Programa para a Operação</label>
                              <input type="text" class="form-control" maxlength="50" id="nom_v" name="nom_v"
                                   value="<?php echo $nom_v; ?>" />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Usuário</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="usu_v" name="usu_v"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Programa</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="pro_v" name="pro_v"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Vendido para</label>
                              <select id="int_v" name="int_v" class="form-control">
                                   <?php $ret = carrega_int($int_v); ?>
                              </select>
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit_v">Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="qtd_v" name="qtd_v"
                                   value="<?php echo $qtd_v; ?>" />
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Atual</label><br />
                              <p id="sal_v">0</p>
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Liberar</label><br />
                              <p id="lib_v">0</p>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Valor Total R$</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="val_v" name="val_v"
                                   value="<?php echo $val_v; ?>" />
                         </div>
                         <div class="col-md-1"></div>
                         <div class="col-md-2 text-center">
                              <label>Preço Unitário</label>
                              <input type="text" class="form-control text-center" maxlength="12" id="pre_v" name="pre_v"
                                   value="" disabled />
                         </div>
                         <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Data da Venda</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dat_v" name="dat_v"
                                   value="<?php echo $dat_v; ?>" />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Recebimento em</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="rec_v" name="rec_v"
                                   value="<?php echo $rec_v; ?>" />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Observação</label>
                              <textarea class="form-control" rows="3" id="obs_v"
                                   name="obs_v"><?php echo $obs_v; ?></textarea>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
               </div>
               <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               <div id="mov_p">
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Usuário / Programa para a Operação</label>
                              <input type="text" class="form-control" maxlength="50" id="nom_p" name="nom_p"
                                   value="<?php echo $nom_p; ?>" />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Usuário</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="usu_p" name="usu_p"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Programa</label>
                              <input type="text" class="form-control text-center" maxlength="50" id="pro_p" name="pro_p"
                                   value="" disabled />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-6">
                              <label>Nome do Intermediário</label>
                              <select id="int_p" name="int_p" class="form-control">
                                   <?php $ret = carrega_int($int_p); ?>
                              </select>
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit_p">Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="12" id="qtd_p" name="qtd_p"
                                   value="<?php echo $qtd_p; ?>" />
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Atual</label><br />
                              <p id="sal_p">0</p>
                         </div>
                         <div class="lit-1 col-md-2 text-center">
                              <label>Saldo Liberar</label><br />
                              <p id="lib_p">0</p>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit">Localizador</label>
                              <input type="text" class="form-control" maxlength="15" id="loc_p" name="loc_p"
                                   value="<?php echo $loc_p; ?>" />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label id="tit">Número de CPF´s</label>
                              <input type="text" class="form-control text-center" maxlength="3" id="cpf_p" name="cpf_p"
                                   value="<?php echo $cpf_p; ?>" />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-4">
                              <label>Data da Operação</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dat_p" name="dat_p"
                                   value="<?php echo $dat_p; ?>" />
                         </div>
                         <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Observação</label>
                              <textarea class="form-control" rows="3" id="obs_p"
                                   name="obs_p"><?php echo $obs_p; ?></textarea>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
               </div>
               <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
               <br />
               <div class="row">
                    <div class="col-12 text-center">
                         <button type="submit" id="gra" name="salvar" class="bot-1">Salvar</button>
                    </div>
               </div>
               <br />
               <input type="hidden" id="cta" name="cta" value="0" />
               <input type="hidden" id="cta_t" name="cta_t" value="0" />
               <input type="hidden" id="cta_d" name="cta_d" value="0" />
               <input type="hidden" id="cta_v" name="cta_v" value="0" />
               <input type="hidden" id="cta_p" name="cta_p" value="0" />
               <input type="hidden" id="qtd_s" name="qtd_s" value="0" />
               <input type="hidden" id="val_s" name="val_s" value="0" />
               <input type="hidden" id="qtd_m" name="qtd_m" value="0" />
               <input type="hidden" id="med_t" name="med_t" value="0" />
               <input type="hidden" id="cus_c" name="cus_c" value="0" />
               <input type="hidden" id="tot_s" name="tot_s" value="0" />
          </form>
     </div>
     <br />
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_int($int_v) {
     $sta = 0;
     include_once "dados.php";    
     if ($int_v == 0) {
          echo '<option value="0" selected="selected">Selecione o intermediário ...</option>';
     }
     $com = "Select idintermediario, intdescricao from tb_intermediario where intstatus = 0 and intempresa = " . $_SESSION['wrkcodemp'] . " order by intdescricao, idintermediario";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idintermediario'] != $int_v) {
               echo  '<option value ="' . $lin['idintermediario'] . '">' . $lin['intdescricao'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idintermediario'] . '" selected="selected">' . $lin['intdescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_car($car) {
     $sta = 0;
     include_once "dados.php";    
     if ($car == 0) {
          echo '<option value="0" selected="selected">Selecione o cartão de crédito ...</option>';
     }
     $com = "Select idcartao, cardescricao, carnumero from tb_cartao where carstatus = 0 and carempresa = " . $_SESSION['wrkcodemp'] . " order by cardescricao, idcartao";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idcartao'] != $car) {
               echo  '<option value ="' . $lin['idcartao'] . '">' . $lin['cardescricao'] . " - " . $lin['carnumero']. '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idcartao'] . '" selected="selected">' . $lin['cardescricao'] . " - " . $lin['carnumero'] . '</option>';
          }
     }
     return $sta;
}

?>

</html>