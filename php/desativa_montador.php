<?php
include"config.php";

$id_montadores		= $_GET['id_montadores'];
$status = $_GET['status'];

$sql	= "UPDATE montadores SET ativo_m = '$status' WHERE id_montadores = '$id_montadores'";

$resultado = mysql_query($sql);

echo "<script>location.href='javascript:window.history.go(-1)'; </script>";


?>