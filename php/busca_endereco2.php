<?php
include ("config.php");
$cod_estado = utf8_decode($_GET['uf']);
$cod_cep = utf8_decode($_GET['cep']);

$sql_endereco = "SELECT * FROM ".$cod_estado." WHERE cep='$cod_cep' LIMIT 1";
$qr_endereco = mysql_query($sql_endereco) or die(mysql_error());
if(mysql_num_rows($qr_endereco) == 0){
   echo  '';
}else{
   //echo  '<option value="0">'.htmlentities('Selecione').'</option>';
   while($ln_endereco = mysql_fetch_assoc($qr_endereco)){
	   	$dados = array(
		'id'			=> $ln_endereco['id'],
		'cidade'		=> utf8_encode($ln_endereco['cidade']),
		'tp_logradouro'	=> utf8_encode($ln_endereco['tp_logradouro']),
		'logradouro'	=> utf8_encode($ln_endereco['logradouro']),
		'bairro'		=> utf8_encode($ln_endereco['bairro']),
	);

      echo json_encode($dados);
   }
}
?>