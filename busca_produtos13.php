<?php

include "php/config.php";



$cod_produto13 = $_POST['cod_produto13'];

$select_produto = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto13'";

//echo "<script>alert('teste')

$query = mysql_query($select_produto)or die(mysql_error());

$rows = mysql_num_rows($query);



if(mysql_num_rows($query) == 0){

	echo '<input name="produto_cliente13" id="produto_cliente13" size="35" tabindex="52" onkeyup="this.value = this.value.toUpperCase();" /> ';

}

else{

	while($a=mysql_fetch_array($query)){

		echo '<input name="produto_cliente13" id="produto_cliente13" size="35" tabindex="52" value="'.$a['modelo'].'" onkeyup="this.value = this.value.toUpperCase();" /> ';

	}

}

?>