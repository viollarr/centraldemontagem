<?php
session_start();
include"config.php";
include"../classe/Log.class.php";

$id_produtos	= $_GET['id_produtos'];

$sql_nome = "SELECT * FROM produtos WHERE id_produto='$id_produtos' ";
$query_nome = mysql_query($sql_nome);
$result_nome = mysql_fetch_array($query_nome);

$objLog = new Log();
$objLog->grava(" ");
$objLog->grava("Exclusão Produto");
$objLog->grava('POST => "'.$_SESSION['login'].'" Data => "'.date('Y-m-d H:i:s').'", Deletou o produto => "'.$result_nome['cod_produto'].'" - "'.$result_nome["modelo"].', Id => '.$result_nome["id_produto"].'"');

$sql	= "DELETE FROM produtos WHERE id_produto='$id_produtos' ";
$resultado = mysql_query($sql);

echo "<script>self.location.href=('../adm_produtos.php');</script>";

?>