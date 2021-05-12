<?php
     function acessa_ema($ema, &$reg) {
          $nro_r = 0; $reg = array(); 
          include_once "lerinformacao.inc";
          $sql = mysqli_query($conexao,"Select usustatus, usunome, usuemail, ususenha, usuvalidade, usuacessos from tb_usuario where usuemail = '" . $ema . "'");
          $nro_r = mysqli_num_rows($sql);
          if (mysqli_num_rows($sql) == 1) {
               $reg = mysqli_fetch_array($sql);
          }
          return $nro_r;
     }

     function comando_tab($sql, &$nro, &$cha, &$men) {
          $men = "";
          include "lerinformacao.inc";
          $ret = mysqli_query($conexao, $sql);
          $nro = mysqli_affected_rows($conexao);  // Número de linhas afetadas pelo comando
          $cha = mysqli_insert_id($conexao); // Auto Increment Id
          if ($ret == false) {
               $men = "Erro no processamento do comando do registro solicitado !";
          }
          return $ret;
     } 

     function acessa_ini($ema, $sen, &$reg) {
          $nro_r = 0; $reg = array(); $sen = base64_encode($sen);
          include_once "lerinformacao.inc";
          $sql = mysqli_query($conexao,"Select * from tb_usuario where usuemail = '" . $ema . "' and ususenha = '" . $sen . "'");
          $nro_r = mysqli_num_rows($sql);
          if (mysqli_num_rows($sql) == 1) {
               $reg = mysqli_fetch_array($sql);
          }
          return $nro_r;
     }

     function retorna_dad($cpo, $tab, $cha, $cod) {
          $dad = '';
          include "lerinformacao.inc";
          if (is_numeric($cod) == true) {
               $com = "Select " . $cpo . " as campo from " . $tab . " where " . $cha . " = " . $cod;
          } else {
               $com = "Select " . $cpo . " as campo from " . $tab . " where " . $cha . " = '" . $cod . "'";
          }
          $sql = mysqli_query($conexao, $com);
          $nro_r = mysqli_num_rows($sql);
          $sql = mysqli_query($conexao, $com);
          while ($lin = mysqli_fetch_assoc($sql)) {        
               $dad = $lin['campo']; 
          }
          return $dad;
     }

     function acessa_reg($com, &$reg) {
          $nro_r = 0; $reg = array(); 
          include "lerinformacao.inc";
          $sql = mysqli_query($conexao, $com);
          $nro_r = mysqli_num_rows($sql);
          if (mysqli_num_rows($sql) == 1) {
               $reg = mysqli_fetch_array($sql);
          }
          return $nro_r;
     }

     function leitura_reg($com, &$reg) {
          $nro_r = 0; 
          $lin = array(); 
          $reg = array(); 
          include "lerinformacao.inc";
          $sql = mysqli_query($conexao, $com);
          $nro_r = mysqli_num_rows($sql);
          $sql = mysqli_query($conexao, $com);    // mysqli_fetch_all(MYSQLI_ASSOC)
          while ($lin = mysqli_fetch_assoc($sql)) {        
               $reg[] = $lin; 
          }
          return $nro_r;
     }

     function numero_reg($tab) {
          $qtd = 0;
          include "lerinformacao.inc";
          $com = "Select Count(*) as qtde from " . $tab ;
          $sql = mysqli_query($conexao, $com);
          $nro_r = mysqli_num_rows($sql);
          $sql = mysqli_query($conexao, $com);
          while ($lin = mysqli_fetch_assoc($sql)) {        
               $qtd = $lin['qtde']; 
          }
          return $qtd;
     }

?>
