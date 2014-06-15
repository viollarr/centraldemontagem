<?php
include "php/config.php";
$nome				= $_POST['nome'];
$preco_real			= preg_replace("/,/",".",$_POST['preco_real']);
$preco_real_cp		= preg_replace("/,/",".",$_POST['preco_real_cp']);
$preco_montador		= preg_replace("/,/",".",$_POST['preco_montador']);
$preco_montador_cp	= preg_replace("/,/",".",$_POST['preco_montador_cp']);
$preco_empresa		= preg_replace("/,/",".",$preco_real) - preg_replace("/,/",".",$preco_montador);
$preco_empresa_cp	= preg_replace("/,/",".",$preco_real_cp) - preg_replace("/,/",".",$preco_montador_cp);

if((strlen($nome)>0) or (strlen($preco_real)>0) or (strlen($preco_real_cp)>0) or (strlen($preco_montador)>0) or (strlen($preco_montador_cp)>0)){
	$select = "SELECT * FROM precos WHERE nome = '$nome'";
	$query = mysql_query($select) or die ("Query: ".$select." : ".mysql_error());
	$rows = mysql_num_rows($query);
	
	if($rows == 0){
			$cadastrar = "INSERT INTO precos (nome, preco_real, preco_real_cp, preco_montador, preco_montador_cp, preco_empresa, preco_empresa_cp)
				VALUES ('$nome','$preco_real','$preco_real_cp','$preco_montador','$preco_montador_cp','$preco_empresa','$preco_empresa_cp')";
			$sql = mysql_query($cadastrar) or die ("Query: ".$cadastrar." : ".mysql_error());
			
			echo "<script>window.location = 'cadastro_precos.php';</script>";
	}
	else{
		echo "<script> alert('Esse produto ja foi cadastrado \\n Ass. Victor Narcizo!');location.href='javascript:window.history.go(-1)'; </script>";
	}
}
else{
	echo "<script> alert('Erro! Verifique um dos itens abaixo:\\n\\n - Campo Nome.\\n - Campo Preço real.\\n - Campo Preço montador.\\n');location.href='javascript:window.history.go(-1)'; </script>";
}
?>