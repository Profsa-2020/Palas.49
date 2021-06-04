<?php 
     $ret = 00;
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");

     if ($_SESSION['wrktipusu'] != 5) {
          echo '<script>alert("Tipo de usuário não permite visualização de menu de acesso");</script>';
          echo '<script>history.go(-1);</script>';
     }     

     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "index.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "index.php"</script>');   
     }   
?>

<nav class="navbar navbar-expand-lg navbar-light text-white fixed-top"> 
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação do menu principal">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="menu02.php">
          <?php
          if ($_SESSION['wrklogemp'] == "") {
               echo '<img class="log-1" src="img/logo-02.jpg">';
          } else {
               echo '<img class="log-1" src="' . $_SESSION['wrklogemp'] . '">';
          }
          ?>

     </a>
     <div class="collapse navbar-collapse align-self-center" id="navbarNav">
          <ul class="navbar-nav mr-auto text-center">
               <li class="nav-item">
                    <a class="nav-link" href="menu02.php"><i class="fa fa-home fa-2x"
                              aria-hidden="true"></i><br /> Início </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-parametro.php?ope=1&cod=0"> <i class="fa fa-cogs fa-2x"
                              aria-hidden="true"></i><br /> Parâmetros </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-plano.php?ope=1&cod=0"> <i class="fa fa-credit-card-alt fa-2x"
                              aria-hidden="true"></i><br /> Planos </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-indicacao.php?ope=1&cod=0"> <i class="fa fa-handshake-o fa-2x"
                              aria-hidden="true"></i><br /> Indicação </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-titulo.php"><i class="fa fa-money fa-2x"
                              aria-hidden="true"></i><br /> Recebimentos </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-usuario.php"><i class="fa fa-users fa-2x"
                              aria-hidden="true"></i><br /> Usuários </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="saida.php"><i class="fa fa-sign-out fa-2x"
                              aria-hidden="true"></i><br /> Saída </a>
               </li>
          </ul>
          <span class="navbar-text text-center">
               <?php 
                    echo '<div>';
                    echo '<a class="nav-link" href="log-acesso.php" title="Abre página com consulta de Log de usuários, somente o administrador"><strong class="lit-1 text-white">' . $_SESSION['wrkapeusu'] . '</strong></a>';
                    echo '<a class="nav-link" href="log-acesso.php" title="Abre página com consulta de Log de usuários, somente o administrador"><span class="lit-2 text-white">' . date('d/m/Y') . '</span></a>';
                    echo '</div>';
               ?>
          </span>
     </div>
</nav>
<br /><br /><br /><br /><br /><br /> 

