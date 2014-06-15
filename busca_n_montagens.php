<?php

include "php/config.php";


$n_montagem = $_POST['n_montagem'];

$select_produto = "SELECT * FROM clientes WHERE n_montagem = '$n_montagem'";

//echo $select_produto;
//echo "<script>alert('teste')

$query = mysql_query($select_produto)or die(mysql_error());

$rows = mysql_num_rows($query);

$x = mysql_fetch_array($query);

if(mysql_num_rows($query) > 0){

echo "<script> alert('Vale Montagem em DUPLICIDADE!!\\n Nome Cliente: $x[nome_cliente]');</script>";
}
?>