<?php   
     $sta = 0;
     $cpf = '';
     $dat = '';
     $tip = '';
     $nom = '';
     include_once "../dados.php";
     include_once "../profsa.php";
     if (isset($_REQUEST['tip']) == true) { $tip = $_REQUEST['tip']; } 
     if (isset($_REQUEST['cpf']) == true) { $cpf = $_REQUEST['cpf']; } 
     if (isset($_REQUEST['dat']) == true) { $dat = $_REQUEST['dat']; } 
     if ($tip == 1) {
          if ($cpf != "" && $cpf != "0") {
               $sta = valida_cpf($cpf);
          }
     }
     if ($tip == 2) {
          if (strlen($dat) != 7) { 
               $sta = 1;  
          } else if (substr($dat,0,2) < 1 || substr($dat,0,2) > 12) {
               $sta = 1;  
          } else if (substr($dat,3,4) < 2021 || substr($dat,3,4) > 2030) {
               $sta = 1;  
          }

     }
     
     echo $sta;
?>    