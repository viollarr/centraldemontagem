<?php
include "config.php";
header('Content-Type: text/html; charset=utf8');
$quem_cadastra			= trim($_POST['quem_cadastra']);
$data_hora_cadastro		= date('Y-m-d H:i:s');

$select_arquivo_vales = "SELECT * FROM arquivo ORDER BY id_arquivo DESC";
$query_arquivo_vales = mysql_query($select_arquivo_vales);
$result_arquivo = mysql_fetch_array($query_arquivo_vales);


$select_v = "SELECT * FROM clientes_assistencia";
$query_v = mysql_query($select_v);
$rows_v = mysql_num_rows($query_v);
if($rows_v > 0){
	while($x = mysql_fetch_array($query_v)){
	
	$id_valida 				= $x['id_cliente'];
	$n_montagem_v 			= $x['n_montagem'];
	$orcamento_v 			= $x['orcamento'];
	$cod_loja_v 			= $x['cod_loja'];
	$data_faturamento_v 	= $x['data_faturamento'];
	$nome_cliente_v 		= $x['nome_cliente'];
	$nota_fiscal			= $x['nota_fiscal'];
	$vendedor				= $x['vendedor'];
	$cep_cliente_v 			= $x['cep_cliente'];
	$endereco_cliente_v		= $x['endereco_cliente'];
	$bairro_cliente_v 		= $x['bairro_cliente'];
	$cidade_cliente_v 		= $x['cidade_cliente'];
	$estado_cliente_v 		= $x['estado_cliente'];
	$telefone1_cliente_v 	= $x['telefone1_cliente'];
	$telefone2_cliente_v	= $x['telefone2_cliente'];
	$telefone3_cliente_v	= $x['telefone3_cliente'];
	$referencia_cliente_v	= $x['referencia_cliente'];	
	$cod_cliente_v			= $x['cod_cliente'];
	$qtde_cliente_v			= $x['qtde_cliente'];		
	$produto_cliente_v		= $x['produto_cliente'];
	$cod_cliente2_v			= $x['cod_cliente2'];
	$qtde_cliente2_v		= $x['qtde_cliente2'];		
	$produto_cliente2_v		= $x['produto_cliente2'];	
	$cod_cliente3_v			= $x['cod_cliente3'];
	$qtde_cliente3_v		= $x['qtde_cliente3'];		
	$produto_cliente3_v		= $x['produto_cliente3'];	
	$cod_cliente4_v			= $x['cod_cliente4'];
	$qtde_cliente4_v		= $x['qtde_cliente4'];		
	$produto_cliente4_v		= $x['produto_cliente4'];	
	$cod_cliente5_v			= $x['cod_cliente5'];
	$qtde_cliente5_v		= $x['qtde_cliente5'];		
	$produto_cliente5_v		= $x['produto_cliente5'];	
	$cod_cliente6_v			= $x['cod_cliente6'];
	$qtde_cliente6_v		= $x['qtde_cliente6'];		
	$produto_cliente6_v		= $x['produto_cliente6'];
	$cod_cliente7_v			= $x['cod_cliente7'];
	$qtde_cliente7_v		= $x['qtde_cliente7'];		
	$produto_cliente7_v		= $x['produto_cliente7'];	
	$cod_cliente8_v			= $x['cod_cliente8'];
	$qtde_cliente8_v		= $x['qtde_cliente8'];		
	$produto_cliente8_v		= $x['produto_cliente8'];	
	$cod_cliente9_v			= $x['cod_cliente9'];
	$qtde_cliente9_v		= $x['qtde_cliente9'];		
	$produto_cliente9_v		= $x['produto_cliente9'];	
	$cod_cliente10_v		= $x['cod_cliente10'];
	$qtde_cliente10_v		= $x['qtde_cliente10'];		
	$produto_cliente10_v	= $x['produto_cliente10'];	
	$cod_cliente11_v		= $x['cod_cliente11'];
	$qtde_cliente11_v		= $x['qtde_cliente11'];		
	$produto_cliente11_v	= $x['produto_cliente11'];
	$cod_cliente12_v		= $x['cod_cliente12'];
	$qtde_cliente12_v		= $x['qtde_cliente12'];		
	$produto_cliente12_v	= $x['produto_cliente12'];	
	$cod_cliente13_v		= $x['cod_cliente13'];
	$qtde_cliente13_v		= $x['qtde_cliente13'];		
	$produto_cliente13_v	= $x['produto_cliente13'];	
	$cod_cliente14_v		= $x['cod_cliente14'];
	$qtde_cliente14_v		= $x['qtde_cliente14'];		
	$produto_cliente14_v	= $x['produto_cliente14'];	
	$cod_cliente15_v		= $x['cod_cliente15'];
	$qtde_cliente15_v		= $x['qtde_cliente15'];		
	$produto_cliente15_v	= $x['produto_cliente15'];	
	$cod_cliente16_v		= $x['cod_cliente16'];
	$qtde_cliente16_v		= $x['qtde_cliente16'];		
	$produto_cliente16_v	= $x['produto_cliente16'];
	$cod_cliente17_v		= $x['cod_cliente17'];
	$qtde_cliente17_v		= $x['qtde_cliente17'];		
	$produto_cliente17_v	= $x['produto_cliente17'];	
	$cod_cliente18_v		= $x['cod_cliente18'];
	$qtde_cliente18_v		= $x['qtde_cliente18'];		
	$produto_cliente18_v	= $x['produto_cliente18'];	
	$cod_cliente19_v		= $x['cod_cliente19'];
	$qtde_cliente19_v		= $x['qtde_cliente19'];		
	$produto_cliente19_v	= $x['produto_cliente19'];	
	$cod_cliente20_v		= $x['cod_cliente20'];
	$qtde_cliente20_v		= $x['qtde_cliente20'];		
	$produto_cliente20_v	= $x['produto_cliente20'];	
	
	$select_c = "SELECT * FROM clientes WHERE (n_montagem = '$n_montagem_v') OR (orcamento = '$orcamento_v' AND cod_loja = '$cod_loja_v' AND qtde_cliente = '$qtde_cliente_v' AND nome_cliente = '$nome_cliente_v' AND cod_cliente = '$cod_cliente_v') OR (cod_loja = '$cod_loja_v' AND qtde_cliente = '$qtde_cliente_v' AND nome_cliente = '$nome_cliente_v' AND cod_cliente = '$cod_cliente_v' AND endereco_cliente = '$endereco_cliente_v')";
	$query_c = mysql_query($select_c);
	$rows_c = mysql_num_rows($query_c);
	$z = mysql_fetch_array($query_c);
	if($rows_c > 0){
################################## EXCLUINDO CADASTRO DA TABELA VALIDAR #############################
		$delet_c = "DELETE FROM clientes_assistencia WHERE id_cliente='$id_valida'";
		$dell = mysql_query($delet_c);
#####################################################################################################
		//echo "<script> alert('Nota Duplicada.\\n Orcamento:".$z['orcamento']." \\n Nome: ".$z['nome_cliente']." ');location.href='javascript:window.history.go(-1)'; </script";	
	}
	else{
		$insert_c = "INSERT INTO clientes (id_empresa, prioridade, tipo, n_montagem, cod_loja, orcamento, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente, cod_cliente, produto_cliente, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6, qtde_cliente7, cod_cliente7, produto_cliente7, qtde_cliente8, cod_cliente8, produto_cliente8, qtde_cliente9, cod_cliente9, produto_cliente9, qtde_cliente10, cod_cliente10, produto_cliente10, qtde_cliente11, cod_cliente11, produto_cliente11, qtde_cliente12, cod_cliente12, produto_cliente12, qtde_cliente13, cod_cliente13, produto_cliente13, qtde_cliente14, cod_cliente14, produto_cliente14, qtde_cliente15, cod_cliente15, produto_cliente15, qtde_cliente16, cod_cliente16, produto_cliente16, qtde_cliente17, cod_cliente17, produto_cliente17, qtde_cliente18, cod_cliente18, produto_cliente18, qtde_cliente19, cod_cliente19, produto_cliente19, qtde_cliente20, cod_cliente20, produto_cliente20, id_usuario_cadastro, data_hora_cadastro) VALUE ('1', '0', '0', '$n_montagem_v', '$cod_loja_v', '$orcamento_v', '$data_faturamento_v', '$nome_cliente_v', '$cep_cliente_v', '$endereco_cliente_v', '$bairro_cliente_v', '$cidade_cliente_v', '$estado_cliente_v', '$telefone1_cliente_v', '$telefone2_cliente_v', '$telefone3_cliente_v', '$referencia_cliente_v', '$qtde_cliente_v', '$cod_cliente_v', '$produto_cliente_v', '$qtde_cliente2_v', '$cod_cliente2_v', '$produto_cliente2_v', '$qtde_cliente3_v', '$cod_cliente3_v', '$produto_cliente3_v', '$qtde_cliente4_v', '$cod_cliente4_v', '$produto_cliente4_v', '$qtde_cliente5_v', '$cod_cliente5_v', '$produto_cliente5_v', '$qtde_cliente6_v', '$cod_cliente6_v', '$produto_cliente6_v', '$qtde_cliente7_v', '$cod_cliente7_v', '$produto_cliente7_v', '$qtde_cliente8_v', '$cod_cliente8_v', '$produto_cliente8_v', '$qtde_cliente9_v', '$cod_cliente9_v', '$produto_cliente9_v', '$qtde_cliente10_v', '$cod_cliente10_v', '$produto_cliente10_v', '$qtde_cliente11_v', '$cod_cliente11_v', '$produto_cliente11_v', '$qtde_cliente12_v', '$cod_cliente12_v', '$produto_cliente12_v', '$qtde_cliente13_v', '$cod_cliente13_v', '$produto_cliente13_v', '$qtde_cliente14_v', '$cod_cliente14_v', '$produto_cliente14_v', '$qtde_cliente15_v', '$cod_cliente15_v', '$produto_cliente15_v', '$qtde_cliente16_v', '$cod_cliente16_v', '$produto_cliente16_v', '$qtde_cliente17_v', '$cod_cliente17_v', '$produto_cliente17_v', '$qtde_cliente18_v', '$cod_cliente18_v', '$produto_cliente18_v', '$qtde_cliente19_v', '$cod_cliente19_v', '$produto_cliente19_v', '$qtde_cliente20_v', '$cod_cliente20_v', '$produto_cliente20_v', '$quem_cadastra', '$data_hora_cadastro')";
		
		$cadastrar = mysql_query($insert_c) or die (mysql_error());
		
		$insert_imp = "INSERT INTO impressoes_vales (nota_fiscal, vendedor, n_montagem, cod_loja, orcamento, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente1, cod_cliente1, produto_cliente1, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6, qtde_cliente7, cod_cliente7, produto_cliente7, qtde_cliente8, cod_cliente8, produto_cliente8, qtde_cliente9, cod_cliente9, produto_cliente9, qtde_cliente10, cod_cliente10, produto_cliente10, qtde_cliente11, cod_cliente11, produto_cliente11, qtde_cliente12, cod_cliente12, produto_cliente12, qtde_cliente13, cod_cliente13, produto_cliente13, qtde_cliente14, cod_cliente14, produto_cliente14, qtde_cliente15, cod_cliente15, produto_cliente15, qtde_cliente16, cod_cliente16, produto_cliente16, qtde_cliente17, cod_cliente17, produto_cliente17, qtde_cliente18, cod_cliente18, produto_cliente18, qtde_cliente19, cod_cliente19, produto_cliente19, qtde_cliente20, cod_cliente20, produto_cliente20, id_arquivo) VALUE ('$nota_fiscal', '$vendedor', '$n_montagem_v', '$cod_loja_v', '$orcamento_v', '$data_faturamento_v', '$nome_cliente_v', '$cep_cliente_v', '$endereco_cliente_v', '$bairro_cliente_v', '$cidade_cliente_v', '$estado_cliente_v', '$telefone1_cliente_v', '$telefone2_cliente_v', '$telefone3_cliente_v', '$referencia_cliente_v', '$qtde_cliente_v', '$cod_cliente_v', '$produto_cliente_v', '$qtde_cliente2_v', '$cod_cliente2_v', '$produto_cliente2_v', '$qtde_cliente3_v', '$cod_cliente3_v', '$produto_cliente3_v', '$qtde_cliente4_v', '$cod_cliente4_v', '$produto_cliente4_v', '$qtde_cliente5_v', '$cod_cliente5_v', '$produto_cliente5_v', '$qtde_cliente6_v', '$cod_cliente6_v', '$produto_cliente6_v', '$qtde_cliente7_v', '$cod_cliente7_v', '$produto_cliente7_v', '$qtde_cliente8_v', '$cod_cliente8_v', '$produto_cliente8_v', '$qtde_cliente9_v', '$cod_cliente9_v', '$produto_cliente9_v', '$qtde_cliente10_v', '$cod_cliente10_v', '$produto_cliente10_v', '$qtde_cliente11_v', '$cod_cliente11_v', '$produto_cliente11_v', '$qtde_cliente12_v', '$cod_cliente12_v', '$produto_cliente12_v', '$qtde_cliente13_v', '$cod_cliente13_v', '$produto_cliente13_v', '$qtde_cliente14_v', '$cod_cliente14_v', '$produto_cliente14_v', '$qtde_cliente15_v', '$cod_cliente15_v', '$produto_cliente15_v', '$qtde_cliente16_v', '$cod_cliente16_v', '$produto_cliente16_v', '$qtde_cliente17_v', '$cod_cliente17_v', '$produto_cliente17_v', '$qtde_cliente18_v', '$cod_cliente18_v', '$produto_cliente18_v', '$qtde_cliente19_v', '$cod_cliente19_v', '$produto_cliente19_v', '$qtde_cliente20_v', '$cod_cliente20_v', '$produto_cliente20_v', '".$result_arquivo['id_arquivo']."')";
		$cadastrar2 = mysql_query($insert_imp) or die (mysql_error());

############################################ CADASTRO DOS PRODUTOS SE NAO HOUVER #######################################################	
		if((strlen($cod_cliente_v)>0)){
			$select_pro = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente_v."'";
			$query_pro  = mysql_query($select_pro) or die (mysql_error());
			$result_pro = mysql_num_rows($query_pro);
			if($result_pro == 0){
				$insert_pro = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente_v."', '".$produto_cliente_v."')";
				$query_pro	= mysql_query($insert_pro);
			}
		}
		if((strlen($cod_cliente2_v)>0)){
			$select_pro2 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente2_v."'";
			$query_pro2  = mysql_query($select_pro2) or die (mysql_error());
			$result_pro2 = mysql_num_rows($query_pro2);
			if($result_pro2 == 0){
				$insert_pro2 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente2_v."', '".$produto_cliente2_v."')";
				$query_pro2	= mysql_query($insert_pro2);
			}
		}
		if((strlen($cod_cliente3_v)>0)){
			$select_pro3 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente3_v."'";
			$query_pro3  = mysql_query($select_pro3) or die (mysql_error());
			$result_pro3 = mysql_num_rows($query_pro3);
			if($result_pro3 == 0){
				$insert_pro3 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente3_v."', '".$produto_cliente3_v."')";
				$query_pro3	= mysql_query($insert_pro3);
			}
		}
		if((strlen($cod_cliente4_v)>0)){
			$select_pro4 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente4_v."'";
			$query_pro4  = mysql_query($select_pro4) or die (mysql_error());
			$result_pro4 = mysql_num_rows($query_pro4);
			if($result_pro4 == 0){
				$insert_pro4 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente4_v."', '".$produto_cliente4_v."')";
				$query_pro4	= mysql_query($insert_pro4);
			}
		}
		if((strlen($cod_cliente5_v)>0)){
			$select_pro5 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente5_v."'";
			$query_pro5  = mysql_query($select_pro5) or die (mysql_error());
			$result_pro5 = mysql_num_rows($query_pro5);
			if($result_pro5 == 0){
				$insert_pro5 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente5_v."', '".$produto_cliente5_v."')";
				$query_pro5	= mysql_query($insert_pro5);
			}
		}
		if((strlen($cod_cliente6_v)>0)){
			$select_pro6 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente6_v."'";
			$query_pro6  = mysql_query($select_pro6) or die (mysql_error());
			$result_pro6 = mysql_num_rows($query_pro6);
			if($result_pro6 == 0){
				$insert_pro6 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente6_v."', '".$produto_cliente6_v."')";
				$query_pro6	= mysql_query($insert_pro6);
			}
		}
		if((strlen($cod_cliente7_v)>0)){
			$select_pro7 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente7_v."'";
			$query_pro7  = mysql_query($select_pro7) or die (mysql_error());
			$result_pro7 = mysql_num_rows($query_pro7);
			if($result_pro7 == 0){
				$insert_pro7 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente7_v."', '".$produto_cliente7_v."')";
				$query_pro7	= mysql_query($insert_pro7);
			}
		}
		if((strlen($cod_cliente8_v)>0)){
			$select_pro8 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente8_v."'";
			$query_pro8  = mysql_query($select_pro8) or die (mysql_error());
			$result_pro8 = mysql_num_rows($query_pro8);
			if($result_pro8 == 0){
				$insert_pro8 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente8_v."', '".$produto_cliente8_v."')";
				$query_pro8	= mysql_query($insert_pro8);
			}
		}
		if((strlen($cod_cliente9_v)>0)){
			$select_pro9 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente9_v."'";
			$query_pro9  = mysql_query($select_pro9) or die (mysql_error());
			$result_pro9 = mysql_num_rows($query_pro9);
			if($result_pro9 == 0){
				$insert_pro9 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente9_v."', '".$produto_cliente9_v."')";
				$query_pro9	= mysql_query($insert_pro9);
			}
		}
		if((strlen($cod_cliente5_v)>0)){
			$select_pro5 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente5_v."'";
			$query_pro5  = mysql_query($select_pro5) or die (mysql_error());
			$result_pro5 = mysql_num_rows($query_pro5);
			if($result_pro5 == 0){
				$insert_pro5 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente5_v."', '".$produto_cliente5_v."')";
				$query_pro5	= mysql_query($insert_pro10);
			}
		}
		if((strlen($cod_cliente11_v)>0)){
			$select_pro11 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente11_v."'";
			$query_pro11  = mysql_query($select_pro11) or die (mysql_error());
			$result_pro11 = mysql_num_rows($query_pro11);
			if($result_pro11 == 0){
				$insert_pro11 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente11_v."', '".$produto_cliente11_v."')";
				$query_pro11	= mysql_query($insert_pro11);
			}
		}
		if((strlen($cod_cliente12_v)>0)){
			$select_pro12 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente12_v."'";
			$query_pro12  = mysql_query($select_pro12) or die (mysql_error());
			$result_pro12 = mysql_num_rows($query_pro12);
			if($result_pro12 == 0){
				$insert_pro12 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente12_v."', '".$produto_cliente12_v."')";
				$query_pro12	= mysql_query($insert_pro12);
			}
		}
		if((strlen($cod_cliente13_v)>0)){
			$select_pro13 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente13_v."'";
			$query_pro13  = mysql_query($select_pro13) or die (mysql_error());
			$result_pro13 = mysql_num_rows($query_pro13);
			if($result_pro13 == 0){
				$insert_pro13 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente13_v."', '".$produto_cliente13_v."')";
				$query_pro13	= mysql_query($insert_pro13);
			}
		}
		if((strlen($cod_cliente14_v)>0)){
			$select_pro14 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente14_v."'";
			$query_pro14  = mysql_query($select_pro14) or die (mysql_error());
			$result_pro14 = mysql_num_rows($query_pro14);
			if($result_pro14 == 0){
				$insert_pro14 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente14_v."', '".$produto_cliente14_v."')";
				$query_pro14	= mysql_query($insert_pro14);
			}
		}
		if((strlen($cod_cliente15_v)>0)){
			$select_pro15 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente15_v."'";
			$query_pro15  = mysql_query($select_pro15) or die (mysql_error());
			$result_pro15 = mysql_num_rows($query_pro15);
			if($result_pro15 == 0){
				$insert_pro15 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente15_v."', '".$produto_cliente15_v."')";
				$query_pro15	= mysql_query($insert_pro15);
			}
		}
		if((strlen($cod_cliente16_v)>0)){
			$select_pro16 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente16_v."'";
			$query_pro16  = mysql_query($select_pro16) or die (mysql_error());
			$result_pro16 = mysql_num_rows($query_pro16);
			if($result_pro16 == 0){
				$insert_pro16 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente16_v."', '".$produto_cliente16_v."')";
				$query_pro16	= mysql_query($insert_pro16);
			}
		}
		if((strlen($cod_cliente17_v)>0)){
			$select_pro17 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente17_v."'";
			$query_pro17  = mysql_query($select_pro17) or die (mysql_error());
			$result_pro17 = mysql_num_rows($query_pro17);
			if($result_pro17 == 0){
				$insert_pro17 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente17_v."', '".$produto_cliente17_v."')";
				$query_pro17	= mysql_query($insert_pro17);
			}
		}
		if((strlen($cod_cliente18_v)>0)){
			$select_pro18 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente18_v."'";
			$query_pro18  = mysql_query($select_pro18) or die (mysql_error());
			$result_pro18 = mysql_num_rows($query_pro18);
			if($result_pro18 == 0){
				$insert_pro18 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente18_v."', '".$produto_cliente18_v."')";
				$query_pro18	= mysql_query($insert_pro18);
			}
		}
		if((strlen($cod_cliente19_v)>0)){
			$select_pro19 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente19_v."'";
			$query_pro19  = mysql_query($select_pro19) or die (mysql_error());
			$result_pro19 = mysql_num_rows($query_pro19);
			if($result_pro19 == 0){
				$insert_pro19 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente19_v."', '".$produto_cliente19_v."')";
				$query_pro19	= mysql_query($insert_pro19);
			}
		}
		if((strlen($cod_cliente20_v)>0)){
			$select_pro20 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente20_v."'";
			$query_pro20  = mysql_query($select_pro20) or die (mysql_error());
			$result_pro20 = mysql_num_rows($query_pro20);
			if($result_pro20 == 0){
				$insert_pro20 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente20_v."', '".$produto_cliente20_v."')";
				$query_pro20	= mysql_query($insert_pro20);
			}
		}
######################################### FIM DO CADASTRO DOS PRODUTOS SE N&Atilde;O HOUVER #######################################################		

		$select_cli = "SELECT * FROM clientes WHERE n_montagem = '".$n_montagem_v."'";
		$query_cli  = mysql_query($select_cli) or die (mysql_error());
		$result_cli = mysql_fetch_array($query_cli);
		
		$select_bairro = "SELECT * FROM bairros WHERE nome LIKE '%".$bairro_cliente_v."%'";
		$query_bairro = mysql_query($select_bairro);
		$rows_bairro = mysql_num_rows($query_bairro);
		if($rows_bairro > 0){
		$a = mysql_fetch_array($query_bairro);
		$id_bairros = $a[id_bairros];
		}
		else{
		$insert_bairro = "INSERT INTO bairros (nome) VALUES ('".$bairro_cliente_v."')";
		$query_insert = mysql_query($insert_bairro);
		
		$select_bairro = "SELECT * FROM bairros WHERE nome LIKE '%".$bairro_cliente_v."%'";
		$query_bairro = mysql_query($select_bairro);
		$rows_bairro = mysql_num_rows($query_bairro);
		$a = mysql_fetch_array($query_bairro);
		$id_bairros = $a[id_bairros];
		}
		
		
		$insert_montagem = "INSERT INTO	ordem_montagem (n_montagem, id_cliente, id_bairros) VALUES ('".$n_montagem_v."', '".$result_cli['id_cliente']."', '".$id_bairros."')";
		$query_montagem  = mysql_query($insert_montagem) or die (mysql_error());
		
		
		$data = explode("-",$data_faturamento_v);
		$ano = $data[0];
		$mes = $data[1];
		$dia = $data[2];
		
		$data_recebimento_v = date("Y-m-d");
		
/*
		########################################################
		
		#				PEGAR DATA LIMITE					   #			
		
		//		$startdate=mktime(0,0,0,$mes,$dia,$ano);
		
		//		$hoje_3dias=$startdate + 3*24*60*60;
		
		//		$data_3=date ( "Y-m-d", $hoje_3dias );
		
		#													   #
		
		########################################################
		
		include "funcao_data_limite.php";
		$d3 = $dia."/".$mes."/".$ano;
		
		$DataInicial = "$d3";
		$QtdDia = 3;
		$diasSomados = SomaDiasUteis($DataInicial,$QtdDia);
		
		$d4 = explode('/',$diasSomados );
		$data_3 = $d4[2]."-".$d4[1]."-".$d4[0];
		
		$insert_data = "INSERT INTO	datas (n_montagens, data_faturamento, data_recebimento, data_limite) VALUES ('".$n_montagem_v."', '".$data_faturamento_v."', '".$data_recebimento_v."', '".$data_3."')";
		
		$query_datas = mysql_query($insert_data);
		
		################################################################################################################
*/		
		
		
		########################################################
		#				PEGAR DATA LIMITE					   #			
				$startdate=mktime(0,0,0,$mes,$dia,$ano);
				$hoje_7dias=$startdate + 7*24*60*60;
				$data_7=date ( "Y-m-d", $hoje_7dias );
		#													   #
		########################################################
		
		$insert_data = "INSERT INTO	datas (n_montagens, data_faturamento, data_limite) VALUES ('".$n_montagem_v."', '".$data_faturamento_v."', '".$data_7."')";
		$query_datas = mysql_query($insert_data);

################################## FIM DO CADASTRO ##################################################
################################## EXCLUINDO CADASTRO DA TABELA VALIDAR #############################
		$delet_c = "DELETE FROM clientes_assistencia WHERE id_cliente='$id_valida'";
		$dell = mysql_query($delet_c);
#####################################################################################################

	}
  }
Header("Location: ../adm_clientes_validar.php");
}
else{
	echo "<script> alert('N&Atilde;O há fichas para validar.');location.href='javascript:window.history.go(-1)'; </script>";
}

?>