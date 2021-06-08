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

<nav class="navbar navbar-expand-lg navbar-light text-white fixed-top"> 
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação do menu principal">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="menu01.php">
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
                    <a class="nav-link" href="menu01.php"><i class="fa fa-home fa-2x"
                              aria-hidden="true"></i><br /> Início </a>
               </li>
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-desktop fa-2x" aria-hidden="true"></i><br /> Cadastros
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <?php if ($_SESSION['wrktipusu'] >= 4) { ?>
                              <a class="dropdown-item" href="con-usuario.php">Usuários</a>
                         <?php } ?>
                         <a class="dropdown-item" href="man-programa.php?ope=1&cod=0">Programas</a>
                         <a class="dropdown-item" href="man-conta.php?ope=1&cod=0">Contas</a>
                         <a class="dropdown-item" href="man-cartao.php?ope=1&cod=0">Cartões</a>
                         <a class="dropdown-item" href="man-intermediario.php?ope=1&cod=0">Intermediários</a>
                    </div>
               </li>               
               <li class="nav-item">
                    <a class="nav-link" href="man-movto.php?ope=1&cod=0"> <i class="fa fa-money fa-2x"
                              aria-hidden="true"></i><br /> Movimento </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="con-movto.php"><i class="fa fa-search fa-2x"
                              aria-hidden="true"></i><br /> Consultas </a>
               </li>
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i><br /> Resumos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <a class="dropdown-item" href="res-conta.php">Por Conta</a>
                         <a class="dropdown-item" href="res-docto.php">Por CPF´s</a>
                         <a class="dropdown-item" href="res-anual.php">Por Conta Anual</a>
                    </div>
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

