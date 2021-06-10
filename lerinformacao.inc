<?php
    	$ser_b = "127.0.0.1:3306";
	$usu_b = "root";
    	$pas_b = "";
	$bco_b = "bc_milhas";    
    	$conexao = mysqli_connect($ser_b,$usu_b,$pas_b,$bco_b) or die("Erro ao conectar o banco de dados do sistema -> " . $ser_b);     
	$banco = mysqli_select_db($conexao, $bco_b) or die("Erro ao selecionar o banco de dados do sistema -> " . $bco_b);     
    	$mysqli = new mysqli($ser_b,$usu_b,$pas_b,$bco_b) or die("Erro ao conectar o banco de dados do sistema MySqli -> " . $ser_b . " banco: " . $bco_b);
?>