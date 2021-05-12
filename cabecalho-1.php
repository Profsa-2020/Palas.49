<?php 
     $ret = 00;
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");

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

<nav class="navbar navbar-expand-lg navbar-light bg-primary text-white fixed-top"> 
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação do menu principal">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="menu01.php">
          <?php
          if ($_SESSION['wrklogemp'] == "") {
               echo '<img class="log-1" src="img/logo-02.png">';
          } else {
               echo '<img class="log-1" src="' . $_SESSION['wrklogemp'] . '">';
          }
          ?>

     </a>
     <div class="collapse navbar-collapse align-self-center" id="navbarNav">
          <ul class="navbar-nav mr-auto text-center">
               <li class="nav-item">
                    <a class="nav-link" href="menu01.php"><i class="fa fa-home fa-2x"
                              aria-hidden="true"></i><br /> DashBoard </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-usuario.php"><i class="fa fa-users fa-2x"
                              aria-hidden="true"></i><br />
                         Usuários </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-programa.php?ope=1&cod=0"><i class="fa fa-plane fa-2x"
                              aria-hidden="true"></i><br />
                         Programas </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-conta.php?ope=1&cod=0"><i class="fa fa-briefcase fa-2x"
                              aria-hidden="true"></i><br />
                         Contas </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-intermediario.php?ope=1&cod=0"><i class="fa fa-handshake-o fa-2x"
                              aria-hidden="true"></i><br />
                         Intermediários </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-cartao.php?ope=1&cod=0"><i class="fa fa-credit-card fa-2x"
                              aria-hidden="true"></i><br />
                         Cartão </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-aerea.php?ope=1&cod=0"><i class="fa fa-globe fa-2x"
                              aria-hidden="true"></i><br />
                         Cia Aérea </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-movto.php?ope=1&cod=0"> <i class="fa fa-money fa-2x"
                              aria-hidden="true"></i><br /> Movimento </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-movto.php"><i class="fa fa-search fa-2x"
                              aria-hidden="true"></i><br /> Consultas </a>
               </li>
          </ul>
          <span class="navbar-text text-center">
               <?php 
                    echo '<div>';
                    echo '<a class="nav-link" href="log-acesso.php" title="Abre página com consulta de Log de usuários, somente o administrador"><strong class="lit-1 text-white">' . $_SESSION['wrkapeusu'] . '</strong></a>';
                    echo '<a class="nav-link" href="log-acesso.php" title="Abre página com consulta de Log de usuários, somente o administrador"><span class="lit-1 text-white">' . date('d/m/Y') . '</span></a>';
                    echo '<a class="nav-link text-white" href="saida.php"><i class="fa fa-sign-out fa-1g" aria-hidden="true"></i><br /></a>';
                    echo '</div>';
               ?>
          </span>
     </div>
</nav>
<br /><br /><br /><br /><br /><br /><br />     

