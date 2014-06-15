<?php
session_start();
include"config.php";
include"../classe/Log.class.php";

$id_usuario	= $_GET['id'];

$sql_nome = "SELECT * FROM usuarios WHERE id='$id_usuario' ";
$query_nome = mysql_query($sql_nome);
$result_nome = mysql_fetch_array($query_nome);

$objLog = new Log();
$objLog->grava(" ");
$objLog->grava("Exclusão Usuário");
$objLog->grava('POST => "'.$_SESSION['login'].'" Data => "'.date('Y-m-d H:i:s').'", Deletou o usuario => "'.$result_nome['nome'].'", Id => '.$result_nome["id"].'"');

$sql	= "DELETE FROM usuarios WHERE id='$id_usuario' ";
$resultado = mysql_query($sql);

echo "<script>self.location.href=('../adm_usuarios.php');</script>";

?>