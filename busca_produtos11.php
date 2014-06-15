<?php

include "php/config.php";



$cod_produto11 = $_POST['cod_produto11'];

$select_produto = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto11'";

//echo "<script>alert('teste')

$query = mysql_query($select_produto)or die(mysql_error());

$rows = mysql_num_rows($query);



if(mysql_num_rows($query) == 0){

	echo '<input name="produto_cliente11" id="produto_cliente11" size="35" tabindex="46 onkeyup="this.value = this.value.toUpperCase();" /> ';

}

else{

	while($a=mysql_fetch_array($query)){

		echo '<input name="produto_cliente11" id="produto_cliente11" size="35" tabindex="46" value="'.$a['modelo'].'" onkeyup="this.value = this.value.toUpperCase();" /> ';

	}

}

?>