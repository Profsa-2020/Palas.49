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
     <title>Recuperação - Gerenciamento de Milhas  - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {
     $('#frmLogin').submit(function() {
          var ema = $('#ema').val();
          $.getJSON("ajax/recupera-wor.php", {
                    ema: ema
               })
               .done(function(data) {
                    if (data.err != "") {
                         $('#ema').val('');
                         alert(data.err);
                    } else {
                         if (data.men != "") {
                              alert(data.men);
                         }
                         location.href = "index.php";
                    }
               }).fail(function(data) {
                    console.log('Erro: ' + JSON.stringify(data));
                    alert("Erro ocorrido no processamento de recuperação de senha de acesso");
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

?>

<body class="login">
<h1 class="cab-0">Recuperação de Senha sistema de Gerenciamento de Milhas - Profsa Informática</h1>
     <div class="entrada">
          <div class="qua-1 animated bounceInDown">
               <form class="cpo-0" id="frmLogin" name="frmLogin" action="" method="POST">
                    <br />
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">                         
                              <input type="email" class="center" id="ema" name="ema" maxlength="75" value="" required >
                              <label for="nome">Seu e-mail para acesso ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>
                    <div class="row">
                         <input class="bot-1" type="submit" id="env" name="envio" value="Enviar" />
                         <br /><br />
                         <span class="tit-2"><a href="index.php">Voltar</a></span>
                    </div>
               </form>
          </div>
     </div>
</body>

</html>
