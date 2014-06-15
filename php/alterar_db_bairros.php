<?php
if (isset($_POST['editar_bairro']))

{
include"config.php";
$id_bairro = $_POST['id_bairro'];
$nome_bairro = utf8_decode(trim($_POST["nome_bairro"]));

$query	= "
	UPDATE bairros SET 
	nome = '".$nome_bairro."' 
	
	WHERE id_bairros='".$id_bairro."'";
//echo $query;
$result	= mysql_query($query);

header("Location: ../adm_bairros.php");

}

?>
