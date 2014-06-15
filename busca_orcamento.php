<?php



include "php/config.php";



header('Content-Type: text/html; charset=utf-8');



$orcamento = $_POST['orcamento'];



$select_produto = "SELECT * FROM clientes WHERE orcamento = '$orcamento'";



//echo $select_produto;

//echo "<script>alert('teste')



$query = mysql_query($select_produto)or die(mysql_error());



$rows = mysql_num_rows($query);



$x = mysql_fetch_array($query);



if(mysql_num_rows($query) > 0){



echo "<script> alert('Or&ccedil;amento em DUPLICIDADE!!\\n Nome Cliente: $x[nome_cliente]');</script>";

}

?>