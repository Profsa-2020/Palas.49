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

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Menu - Gerenciamento de Milhas  - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>
</head>
<?php
    $sta = 00;
    $ret = 00;
    include_once "dados.php";
    include_once "profsa.php";
    date_default_timezone_set("America/Sao_Paulo");
    if (isset($_SESSION['wrknomusu']) == false) { $_SESSION['wrknomusu'] = ''; }
    if (isset($_SESSION['wrkemausu']) == false) { $_SESSION['wrkemausu'] = ''; }

    $ret = gravar_log(99, "Saída do sistema Pallas.49 - Gerenciamento de Milhas");  

    $nom = $_SESSION['wrknomusu'];
    $ema = $_SESSION['wrkemausu'];
    if ($nom == "") { $nom = substr(get_current_user(), 0, 99); }
    $_SESSION['wrkcodreg'] = 0; $_SESSION['wrkopereg'] = 0; $_SESSION['wrktipusu'] = 0;  $_SESSION['wrkideusu'] = 0; 
    $_SESSION['wrknomusu'] = ""; $_SESSION['wrkemausu'] =""; $_SESSION['wrktipban'] =""; $_SESSION['wrkinddat'] = "";
    session_destroy();  
    $sem_c = date("w");
    if ($sem_c == 0) { $hoj_c = 'Domingo '; }
    if ($sem_c == 1) { $hoj_c = 'Segunda-feira  - '; }
    if ($sem_c == 2) { $hoj_c = 'Terça-feira  - '; }
    if ($sem_c == 3) { $hoj_c = 'Quarta-feira  - '; }
    if ($sem_c == 4) { $hoj_c = 'Quinta-feira  - '; }
    if ($sem_c == 5) { $hoj_c = 'Sexta-feira  - '; }
    if ($sem_c == 6) { $hoj_c = 'Sábado  - '; }
    $hoj_c = $hoj_c . date('d/m/Y H:i:s') . ' hs';
?>

<body>
     <h1 class="cab-0">Página de Saída Sistema Gerenciamento de Milhas - Profsa Informática Ltda</h1>
     <div id="particles-js" class="sai-1 text-center">
          <br />
          <div class="ima-2 animated zoomInUp text-center">
               <div class="row text-center">
                    <div class="col-md-12">
                         <a href="index.php">
                              <img class="img-fluid" src="img/logo-03.png" class="img-responsive center-block"
                                   alt="Logotipo da empresa Administração de Milhas"
                                   title="Acesso ao site principal da Administração de Milhas - Gerenciamento de Milhas" />
                         </a>
                    </div>
               </div>
          </div>
          <br /><hr /><br />
          <div class="saida animated fadeInUp text-center">
               <h2><strong>Obrigado por utilizar o sistema de Gerenciamento de Milhas</strong></h2>
               <br />
               <h4><strong><?php echo $nom; ?></strong></h4>
               <h5><strong><?php echo $ema; ?></strong></h5>
               <h5><?php echo $hoj_c; ?></h5>
               <br />
          </div>
     </div>
     <script type="text/javascript" src="js/particles.js"></script>
     <script type="text/javascript" src="js/app.js"></script>

     <script>
     particlesJS.load('particles-js');
     </script>

</body>

</html>
