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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Venda II - Gerenciamento de Milhas - Profsa Informátda Ltda</title>
</head>

<script>
$(function() {
     $("#cep").mask("00000-000");
     $("#num").mask("000.000");
});

$(document).ready(function() {
     var tipo = 2;

     $('#fas-1').click(function() {
          location.href = "venda-1.php";
     });

     $('#fas-3').click(function() {
          location.href = "venda-3.php";
     });

     $('#fas-4').click(function() {
          location.href = "venda-4.php";
     });

     $.getJSON("ajax/carrega-ven.php", {
               tip: tipo
          })
          .done(function(data) {
               if (data.men != "") {
                    alert(data.men);
               } else {
                    $('#cep').val(data.cep);
                    $('#end').val(data.end);
                    $('#num').val(data.num);
                    $('#com').val(data.com);
                    $('#bai').val(data.bai);
                    $('#cid').val(data.cid);
                    $('#est').val(data.est);
               }
          }).fail(function(data) {
               console.log('Erro: ' + JSON.stringify(data));
               alert("Erro ocorrido no carregamento dos dados de venda");
          });

     $('#cep').blur(function() {
          var cep = $('#cep').val();
          var cep = cep.replace(/[^0-9]/g, '');
          if (cep != '') {
               var url = '//viacep.com.br/ws/' + cep + '/json/';
               $.getJSON(url, function(data) {
                    if ("error" in data) {
                         return;
                    }
                    if ($('#end').val() == "") {
                         $('#end').val(data.logradouro.substring(0, 50));
                    }
                    if ($('#cep').val() == "" || $('#cep').val() == "-") {
                         $('#cep').val(data.cep.replace('.', ''));
                    }
                    if ($('#bai').val() == "") {
                         $('#bai').val(data.bairro.substring(0, 50));
                    }
                    if ($('#cid').val() == "") {
                         $('#cid').val(data.localidade);
                    }
                    if ($('#est').val() == "") {
                         $('#est').val(data.uf);
                    }
               });
          }
     });

     $('#frmTelVen').submit(function() {
          var cep = $('#cep').val();
          var end = $('#end').val();
          var num = $('#num').val();
          var com = $('#com').val();
          var bai = $('#bai').val();
          var cid = $('#cid').val();
          var est = $('#est').val();
          $.getJSON("ajax/guardar-02.php", {
                    cep: cep,
                    end: end,
                    num: num,
                    com: com,
                    bai: bai,
                    cid: cid,
                    est: est
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         location.href = "venda-3.php";
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido no processamento de venda 02 (endereço)");
               });
          return false;
     });

});
</script>

<?php
     $_SESSION['wrkdirsis'] = __DIR__;
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkdadven']) == false) { $_SESSION['wrkdadven'] = array(); }

     $ip  = getenv("REMOTE_ADDR");

     $end = curl_init('http://ipinfo.io/' . $ip . '/json');
     curl_setopt($end, CURLOPT_RETURNTRANSFER, true);    
     curl_setopt($end, CURLOPT_SSL_VERIFYPEER, false);
     $ret = curl_exec($end);
     $dad = json_decode($ret);
     curl_close($end);    
     if (isset($dad->bogon) == true) {
          $cid = 'Rio de Janeiro';
          $est = 'Rj';
     } else if (isset($dad->city) == true) {
          $cid = $dad->city;
          $est = $dad->region;
          if ($est == "São Paulo") { $est = "SP"; }
          if ($est == "Sao Paulo") { $est = "SP"; }
          if ($est == "Paraná") { $est = "PR"; }
          if ($est == "Parana") { $est = "PR"; }
          if ($est == "Minas Gerais") { $est = "MG"; }
          if ($est == "Rio de Janeiro") { $est = "RJ"; }
          if ($est == "Espirito Santo") { $est = "ES"; }
          if ($est == "Espírito Santo") { $est = "ES"; }
          if ($est == "Rio de Janeiro") { $est = "RJ"; }
     }
     if (strlen($est) > 2) { $est = ""; }

     if (isset($_SESSION['wrkdadven']['nom_c']) == false) { 
          echo '<script>alert("Dados básicos do usuário não foram informados ainda !");</script>';
          exit('<script>location.href = "venda-1.php"</script>');
     }


?>

<body id="box00" class="fun-a">
     <h1 class="cab-0">Venda - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <div class="container">
          <div class="qua-a animated fadeInDown">
               <form id="frmTelVen" name="frmTelVen" action="venda-2.php" method="POST">
                    <br />
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <img class="img-a" src="img/logo-06.png">
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-4 text-right"></div>
                         <div class="col-1 text-center">
                              <p id="fas-1" class="fas-c" title="Dados básicos ...">1</p>
                         </div>
                         <div class="col-1 text-center">
                              <p  id="fas-2" class="fas-b" title="Endereço completo ...">2</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-3" class="fas-c" title="Plano escolhido ...">3</p>
                         </div>
                         <div class="col-1 text-center">
                              <p id="fas-4" class="fas-c" title="Finalização da adesão ...">4</p>
                         </div>
                         <div class="col-4"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <?php echo '<strong>' . $_SESSION['wrkdadven']['nom_c'] . '</strong>'; ?>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-3">
                              <label>CEP</label>
                              <input type="text" class="form-control" maxlength="9" id="cep" name="cep" value=""
                                   required />
                         </div>
                         <div class="col-md-9"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-9">
                              <label>Endereço</label>
                              <input type="text" class="form-control" maxlength="50" id="end" name="end" value=""
                                   required />
                         </div>
                         <div class="col-md-3">
                              <label>Número</label>
                              <input type="text" class="form-control" maxlength="6" id="num" name="num" value="" />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              <label>Complemento</label>
                              <input type="text" class="form-control" maxlength="50" id="com" name="com" value="" />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-5">
                              <label>Bairro</label>
                              <input type="text" class="form-control" maxlength="50" id="bai" name="bai" value=""
                                   required />
                         </div>
                         <div class="col-md-5">
                              <label>Cidade</label>
                              <input type="text" class="form-control" maxlength="50" id="cid" name="cid" value=""
                                   required />
                         </div>
                         <div class="col-md-2">
                              <label>UF</label>
                              <input type="text" class="form-control text-center" maxlength="2" id="est" name="est" value=""
                                   required />
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-12 text-center">
                              <button type="submit" id="sal" name="salvar" class="bot-a">Guardar</button>
                         </div>
                    </div>
               </form>
               <br />
          </div>
     </div>
</body>

</html>