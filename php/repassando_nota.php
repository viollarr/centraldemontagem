<?php
include "config.php";

$select_rep = "SELECT * FROM repassando_nota WHERE n_montagem = '$n_montagem'";
$query_rep = mysql_query($select_rep);
$rows_rep = mysql_num_rows($query_rep);

if($rows_rep == 0){
	
	$select_clie = "SELECT * FROM clientes WHERE n_montagem = '$n_montagem'";
	$query_clie = mysql_query($select_clie);
	$x_clie = mysql_fetch_array($query_clie);
	
	$resp = "INSERT INTO repassando_nota (n_montagem, cod_loja, orcamento, nota_fiscal, vendedor, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, numero_cliente, complemento_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente1, cod_cliente1, produto_cliente1, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6, qtde_cliente7, cod_cliente7, produto_cliente7, qtde_cliente8, cod_cliente8, produto_cliente8, qtde_cliente9, cod_cliente9, produto_cliente9, qtde_cliente10, cod_cliente10, produto_cliente10, qtde_cliente11, cod_cliente11, produto_cliente11, qtde_cliente12, cod_cliente12, produto_cliente12, qtde_cliente13, cod_cliente13, produto_cliente13, qtde_cliente14, cod_cliente14, produto_cliente14, qtde_cliente15, cod_cliente15, produto_cliente15, qtde_cliente16, cod_cliente16, produto_cliente16, qtde_cliente17, cod_cliente17, produto_cliente17, qtde_cliente18, cod_cliente18, produto_cliente18, qtde_cliente19, cod_cliente19, produto_cliente19, qtde_cliente20, cod_cliente20, produto_cliente20, id_montador) VALUES ('".$x_clie['n_montagem']."', '".$x_clie['cod_loja']."', '".$x_clie['orcamento']."', '".$x_clie['nota_fiscal']."', '".$x_clie['vendedor']."', '".$x_clie['data_faturamento']."', '".$x_clie['nome_cliente']."', '".$x_clie['cep_cliente']."', '".$x_clie['endereco_cliente']."', '".$x_clie['numero_cliente']."', '".$x_clie['complemento_cliente']."', '".$x_clie['bairro_cliente']."', '".$x_clie['cidade_cliente']."', '".$x_clie['estado_cliente']."', '".$x_clie['telefone1_cliente']."', '".$x_clie['telefone2_cliente']."', '".$x_clie['telefone3_cliente']."', '".$x_clie['referencia_cliente']."', '".$x_clie['qtde_cliente']."', '".$x_clie['cod_cliente']."', '".$x_clie['produto_cliente']."', '".$x_clie['qtde_cliente2']."', '".$x_clie['cod_cliente2']."', '".$x_clie['produto_cliente2']."', '".$x_clie['qtde_cliente3']."', '".$x_clie['cod_cliente3']."', '".$x_clie['produto_cliente3']."', '".$x_clie['qtde_cliente4']."', '".$x_clie['cod_cliente4']."', '".$x_clie['produto_cliente4']."', '".$x_clie['qtde_cliente5']."', '".$x_clie['cod_cliente5']."', '".$x_clie['produto_cliente5']."', '".$x_clie['qtde_cliente6']."', '".$x_clie['cod_cliente6']."', '".$x_clie['produto_cliente6']."', '".$x_clie['qtde_cliente7']."', '".$x_clie['cod_cliente7']."', '".$x_clie['produto_cliente7']."', '".$x_clie['qtde_cliente8']."', '".$x_clie['cod_cliente8']."', '".$x_clie['produto_cliente8']."', '".$x_clie['qtde_cliente9']."', '".$x_clie['cod_cliente9']."', '".$x_clie['produto_cliente9']."', '".$x_clie['qtde_cliente10']."', '".$x_clie['cod_cliente10']."', '".$x_clie['produto_cliente10']."', '".$x_clie['qtde_cliente11']."', '".$x_clie['cod_cliente11']."', '".$x_clie['produto_cliente11']."', '".$x_clie['qtde_cliente12']."', '".$x_clie['cod_cliente12']."', '".$x_clie['produto_cliente12']."', '".$x_clie['qtde_cliente13']."', '".$x_clie['cod_cliente13']."', '".$x_clie['produto_cliente13']."', '".$x_clie['qtde_cliente14']."', '".$x_clie['cod_cliente14']."', '".$x_clie['produto_cliente14']."', '".$x_clie['qtde_cliente15']."', '".$x_clie['cod_cliente15']."', '".$x_clie['produto_cliente15']."', '".$x_clie['qtde_cliente16']."', '".$x_clie['cod_cliente16']."', '".$x_clie['produto_cliente16']."', '".$x_clie['qtde_cliente17']."', '".$x_clie['cod_cliente17']."', '".$x_clie['produto_cliente17']."', '".$x_clie['qtde_cliente18']."', '".$x_clie['cod_cliente18']."', '".$x_clie['produto_cliente18']."', '".$x_clie['qtde_cliente19']."', '".$x_clie['cod_cliente19']."', '".$x_clie['produto_cliente19']."', '".$x_clie['qtde_cliente20']."', '".$x_clie['cod_cliente20']."', '".$x_clie['produto_cliente20']."', '".$montador."')";
	
	$repassa_nota = mysql_query($resp);
	
	$select_id = "select LAST_INSERT_ID(id_cliente) as ultimoID from repassando_nota order by id_cliente desc limit 1";
	$query_id = mysql_query($select_id);
	$id_rpn = mysql_fetch_array($query_id);
	
	$insert_acompanhamento = "INSERT INTO acompanhamento (id_cliente, n_montagem) VALUES ('".$id_rpn['ultimoID']."', '".$x_clie['n_montagem']."')";
	$insert_ac = mysql_query($insert_acompanhamento);
	
}
else{
	$resp = "UPDATE repassando_nota SET id_montador = '$montador', imprimir = '1' WHERE n_montagem = '$n_montagem' ";	
	$repassa_nota = mysql_query($resp);
	
	$up_acompanhamento = "UPDATE acompanhamento SET status = 'atendimento' WHERE n_montagem = '$n_montagem' ";
}



?>