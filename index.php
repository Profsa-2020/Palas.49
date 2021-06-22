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

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Login - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {

     if (localStorage.xpto_01 == undefined) {
          localStorage.setItem('xpto_01', '');
     } else {
          let email = localStorage.xpto_01;
          $('#ema').val(email);
     }

     $('#lem').change(function() {
          var ema = $('#ema').val();
          let opc = $("#lem").prop("checked");
          if (opc == true) {
               localStorage.setItem('xpto_01', ema);
          } else {
               localStorage.removeItem('xpto_01');
          }
     });

     $('#frmLogin').submit(function() {
          var ema = $('#ema').val();
          var sen = $('#sen').val();
          var lem = $('#lem').prop("checked") == true ? "S" : "N";
          $.getJSON("ajax/verifica-ace.php", {
                    ema: ema,
                    sen: sen,
                    lem: lem
               })
               .done(function(data) {
                    if (data.err != "") {
                         $('#ema').val('');
                         $('#sen').val('');
                         alert(data.err);
                    } else {
                         if (data.men != "") {
                              alert(data.men);
                         }
                         if (data.tip != 5) {
                              location.href = "menu01.php";
                         } else {
                              location.href = "menu02.php";
                         }
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido no processamento de login e senha de acesso");
               });
          return false;
     });
});
</script>

<?php
     $ret = 0; 
     $_SESSION['wrkdirsis'] = __DIR__;
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     $_SESSION['wrknumusu'] = getmypid();
     if (isset($_SESSION['wrkcpocoo']) == false) { $_SESSION['wrkcpocoo'] = ""; }
     if (isset($_COOKIE["k_ent"]) == true || isset($_COOKIE["k_end"]) == true) {
          $sen = $_COOKIE["k_ent"]; $ema = $_COOKIE["k_end"];         
     }

?>

<body class="login">
     <h1 class="cab-0">Login inicial sistema de Gerenciamento de Milhas - Profsa Informática</h1>
     <div class="entrada">
          <div class="qua-1 animated bounceInDown">
               <br />
               <div class="row">
                    <div class="col-md-12 text-center">
                         <img class="img-a" src="img/logo-03.jpg">
                    </div>
               </div>
               <form class="cpo-0" id="frmLogin" name="frmLogin" action="" method="POST">
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <input type="email" class="center" id="ema" name="ema" maxlength="75" value="" required>
                              <label for="nome">Seu e-mail para acesso ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <input type="password" class="center" id="sen" name="sen" maxlength="15" value=""
                                   required>
                              <label for="senha">Sua senha para entrada ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>
                    <div class="row">
                         <input class="bot-1" type="submit" id="ent" name="entrar" value="Entrar" />
                         <br /><br />
                         <input type="checkbox" id="lem" name="lem" value="S" />
                         <label class="tit-1" for="lem">Lembrar Login</label>
                         <br /><br />
                         <span class="tit-2"><a href="recupera.php">Esqueci a senha</a></span>
                    </div>
               </form>
          </div>
     </div>
</body>

</html>