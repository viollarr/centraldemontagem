<?php

include "php/config.php";



$n_montagem = $_POST['n_montagem'];

$select_cliente = "SELECT * FROM clientes WHERE n_montagem = '$n_montagem'";

//echo "<script>alert('teste')

$query = mysql_query($select_cliente)or die(mysql_error());

$rows = mysql_num_rows($query);

 echo "teste";

if($rows != 0){

	echo "<script> alert('Essa ordem de montagem j&aacute; consta em nossos registros!\\nPor favor verifique o numero digitado.');</script>";

}

?>