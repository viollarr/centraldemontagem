<?php
include"config.php";

$id_clientes	= $_GET['id_clientes'];

$select_cliente = "SELECT * FROM clientes WHERE id_cliente = '$id_clientes'";
$query_cliente = mysql_query($select_cliente);
$a = mysql_fetch_array($query_cliente);

$select_data = "DELETE FROM datas WHERE n_montagens = '$a[n_montagem]'";
$query_data = mysql_query($select_data);
$select_ordem = "DELETE FROM ordem_montagem WHERE n_montagem = '$a[n_montagem]'";
$query_ordem = mysql_query($select_ordem);
$select_pre_baixas = "DELETE FROM pre_baixas WHERE n_montagem = '$a[n_montagem]'";
$query_pre_baixas = mysql_query($select_pre_baixas);
$select_acompanhamento = "DELETE FROM acompanhamento WHERE n_montagem = '$a[n_montagem]'";
$query_acompanhamento = mysql_query($select_acompanhamento);

$sql	= "DELETE FROM clientes	WHERE id_cliente='$id_clientes'";
$resultado = mysql_query($sql);

Header("Location: ../adm_clientes.php");
?>