<?php
include "php/config.php";

$cod_produto = $_POST['cod_produto'];
$posicao = $_POST['id_campo'];
if($posicao == 1){
	$posicao = "";
}
$select_produto = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
//echo "<script>alert('teste')
$query = mysql_query($select_produto)or die(mysql_error());
$rows = mysql_num_rows($query);
if(mysql_num_rows($query) == 0){
	echo '<input name="produto_cliente'.$posicao.'" id="produto_cliente'.$posicao.'" size="35" onkeyup="this.value = this.value.toUpperCase();" /> ';
}
else{
	while($a=mysql_fetch_array($query)){
		echo '<input name="produto_cliente'.$posicao.'" id="produto_cliente'.$posicao.'" size="35" value="'.$a['modelo'].'" onkeyup="this.value = this.value.toUpperCase();" /> ';
	}
}
?>