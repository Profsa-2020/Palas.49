<?php   
     $sta = 0;
     $nom = "";
     session_start();
     $tab_w = array();
     include_once "../dados.php";
     include_once "../profsa.php";
     if (isset($_REQUEST['term']) == true) { $nom = $_REQUEST['term']; }    // term é o nome fixo
     if (strlen($nom) >= 3) {           
          if ($_SESSION['wrktipusu'] >= 4) {
               $com = "Select C.idconta, U.usunome, P.prodescricao, P.protipo from ((tb_conta C left join tb_usuario U on C.conusuario = U.idsenha) left join tb_programa P on C.conprograma = P.idprograma) where constatus = 0 and conempresa = " . $_SESSION['wrkcodemp'] . " and usunome like '%" . $nom . "%'  order by usunome, prodescricao, idconta Limit 25";
          } else {
               $com = "Select C.idconta, U.usunome, P.prodescricao, P.protipo from ((tb_conta C left join tb_usuario U on C.conusuario = U.idsenha) left join tb_programa P on C.conprograma = P.idprograma) where constatus = 0 and conempresa = " . $_SESSION['wrkcodemp'] . "  and congerente = " . $_SESSION['wrkideusu'] . " and usunome like '%" . $nom . "%'  order by usunome, prodescricao, idconta Limit 25";
          }
          $nro = leitura_reg($com, $reg);
          foreach ($reg as $lin) {
               $tab_w[] = array ("label" => limpa_cpo( trim($lin['usunome']) . " - " . trim($lin['prodescricao']) ), "id" => $lin['idconta'], "tipo" => $lin['protipo'], "usuario" => $lin['usunome'], "programa" => $lin['prodescricao']);   
          }     
     }

     echo json_encode($tab_w);     

?>  
