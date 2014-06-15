<?php
include ("config.php");
$cod_estado = utf8_decode($_GET['uf']);
$cod_cidade = $_GET['cidade'];
$dados = array();

$sql_bairro = "SELECT DISTINCT(bairro) FROM ".$cod_estado." WHERE cidade LIKE _UTF8 '%$cod_cidade%' COLLATE utf8_unicode_ci ORDER BY bairro ASC";
$qr_bairro = mysql_query($sql_bairro) or die(mysql_error());
$rows_bairro = mysql_num_rows($qr_bairro);
$dados[] = array(
			'bairro'	=> "-- Escolha um bairro --"
			);
   //echo  '<option value="0">'.htmlentities('Selecione').'</option>';
   if($rows_bairro > 0){
	   while($ln_bairro = mysql_fetch_assoc($qr_bairro)){
			$dados[] = array(
			'bairro'	=> utf8_encode($ln_bairro['bairro'])
			);
	   }
		echo json_encode($dados);
   }
   else{
	$sql_bairros = "SELECT nome AS bairro FROM bairros ORDER BY nome ASC";
	$qr_bairros = mysql_query($sql_bairros) or die(mysql_error());
	   while($ln_bairros = mysql_fetch_assoc($qr_bairros)){
			$dados[] = array(
			'bairro'	=> utf8_encode($ln_bairros['bairro'])
			);
	   }
		echo json_encode($dados);	
   }
?>