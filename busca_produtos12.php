<?php

include "php/config.php";



$cod_produto12 = $_POST['cod_produto12'];

$select_produto = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto12'";

//echo "<script>alert('teste')

$query = mysql_query($select_produto)or die(mysql_error());

$rows = mysql_num_rows($query);



if(mysql_num_rows($query) == 0){

	echo '<input name="produto_cliente12" id="produto_cliente12" size="35" tabindex="49" onkeyup="this.value = this.value.toUpperCase();" /> ';

}

else{

	while($a=mysql_fetch_array($query)){

		echo '<input name="produto_cliente12" id="produto_cliente12" size="35" tabindex="49" value="'.$a['modelo'].'" onkeyup="this.value = this.value.toUpperCase();" /> ';

	}

}

?>