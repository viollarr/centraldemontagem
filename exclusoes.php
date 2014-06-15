<?php

include "php/config.php";

$fichas = array("755840", "755842", "755843", "755845", "755846", "755847", "755848", "755849", "755850", "755851", "755852", "755856", "755860", "755861", "755862", "755863", "755866", "755868", "755869", "756803",
"756804", "756807", "756808", "756809", "756810", "759811", "759812", "759813", "759814", "759815", "759817", "759818", "759819", "759820", "759821", "759822", "759823", "759824", "759826", "759827", "759828",
"759829", "759831", "759832", "759834", "759836", "759838", "759839", "759840", "759841", "759843", "759844", "759846", "759847", "759849", "759850", "759852", "759853", "759854", "759855", "759857", "759858", "759859",
"756863", "756864", "756869", "756870", "758044", "758045", "758047", "758048", "758053", "758055", "758056", "758061", "758063", "758064", "758066", "758071", "758278", "758279", "758282", "758283", "758287", "758288",
"760784", "760786", "7607887", "7607888", "7607889", "763427", "763431", "763432", "763434", "763436", "763437", "763439", "763440", "763443", "763448", "763449", "763450", "763454", "763456", "763461", "763462",
"763467", "763468", "763471", "763475", "463866", "463867", "463868", "463869", "463875", "463878", "463882", "463883", "763884", "763885", "763887", "763888", "763890", "763891", "763892", "763893", "763895", "763896",
"763898", "763900", "763901", "763903", "765487", "765498", "755505", "755507", "765533", "768858", "768860", "768862", "768869", "768871", "768873", "768874", "768875", "768878", "768879", "768883", "768884", "769455");



echo count($fichas)."<br>";

for($i = 0; $i < count($fichas); $i++){
	
	$select_linhas = "SELECT count(id_cliente) AS qtde FROM clientes WHERE n_montagem = '".$fichas[$i]."'";
	$query_linhas = mysql_query($select_linhas);
	$res_linhas = mysql_fetch_array($query_linhas);
	
	if($res_linhas['qtde']>1){
		$select_clientes = "SELECT * FROM clientes WHERE n_montagem = '".$fichas[$i]."' ORDER BY id_cliente DESC LIMIT 1";
		$query_clientes = mysql_query($select_clientes);
		$res_clientes = mysql_fetch_array($query_clientes);
		echo "id a ser excluido => ".$res_clientes['id_cliente']."<br>";
		
		$exlusão_cliente = "DELETE FROM clientes WHERE id_cliente = '".$res_clientes['id_cliente']."'";
		//$delete_clientes = mysql_query($exlusão_cliente);
		echo $exlusão_cliente."<br>";
		
	}
	
	
	echo $i." => ".$fichas[$i]." ==> ".$res_linhas['qtde']." fichas <br>";	
}
/*
for($i = 0; $i < count($fichas); $i++){
	
	$select_linhas = "SELECT count(id_montagem) AS qtde FROM ordem_montagem WHERE n_montagem = '".$fichas[$i]."'";
	$query_linhas = mysql_query($select_linhas);
	$res_linhas = mysql_fetch_array($query_linhas);
	
	if($res_linhas['qtde']>1){
		$select_clientes = "SELECT * FROM ordem_montagem WHERE n_montagem = '".$fichas[$i]."' ORDER BY id_montagem DESC LIMIT 1";
		$query_clientes = mysql_query($select_clientes);
		$res_clientes = mysql_fetch_array($query_clientes);
		echo "id a ser excluido => ".$res_clientes['id_montagem']."<br>";
		
		$exlusão_cliente = "DELETE FROM ordem_montagem WHERE id_montagem = '".$res_clientes['id_montagem']."'";
		//$delete_clientes = mysql_query($exlusão_cliente);
		echo $exlusão_cliente."<br>";
		
	}
	
	
	echo $i." => ".$fichas[$i]." ==> ".$res_linhas['qtde']." fichas <br>";	
}

for($i = 0; $i < count($fichas); $i++){
	
	$select_linhas = "SELECT count(id_data) AS qtde FROM datas WHERE n_montagens = '".$fichas[$i]."'";
	$query_linhas = mysql_query($select_linhas);
	$res_linhas = mysql_fetch_array($query_linhas);
	
	if($res_linhas['qtde']>1){
		$select_clientes = "SELECT * FROM datas WHERE n_montagens = '".$fichas[$i]."' ORDER BY id_data DESC LIMIT 1";
		$query_clientes = mysql_query($select_clientes);
		$res_clientes = mysql_fetch_array($query_clientes);
		echo "id a ser excluido => ".$res_clientes['id_data']."<br>";
		
		$exlusão_cliente = "DELETE FROM datas WHERE id_data = '".$res_clientes['id_data']."'";
		//$delete_clientes = mysql_query($exlusão_cliente);
		echo $exlusão_cliente."<br>";
		
	}
	
	
	echo $i." => ".$fichas[$i]." ==> ".$res_linhas['qtde']." fichas <br>";	
}
*/

?>