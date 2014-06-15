<?php
set_time_limit(0);
include 'config.php';
$bloqueados = 0;
$aceitas = 0;
$invalidas = 0;
//ABRE O ARQUIVO TXT
$arquivo_montadora 		= $_FILES['arquivo']['name'];
$primeiro_nome = explode(".",$arquivo_montadora);

$select = "SELECT * FROM arquivo WHERE nome_arquivo = '".$primeiro_nome[0]."'";
$query = mysql_query($select);
$rows = mysql_num_rows($query);

if($rows == 0){

	if(eregi("PREVIMONT",$arquivo_montadora)){
	$status = move_uploaded_file($_FILES['arquivo']['tmp_name'],"arquivo/"."$arquivo_montadora");
	
	$arquivo = "arquivo/".$arquivo_montadora;
	$ponteiro = fopen ("$arquivo", "r");

	//LÊ O ARQUIVO ATÉ CHEGAR AO FIM
	while (!feof ($ponteiro)) {
	  //LÊ UMA LINHA DO ARQUIVO
	  $linha = fgets($ponteiro, 4096);
	  //IMPRIME NA TELA O RESULTADO
	  $result = explode(" ",$linha);

	if($result[0] == 00){	  	
		$dataArquivoGerado = trim(substr($linha,25,8));	  	
		$anoData = trim(substr($dataArquivoGerado,0,4));	  	
		$mesData = trim(substr($dataArquivoGerado,4,2));	  	
		$diaData = trim(substr($dataArquivoGerado,6,2));	  	
		$dataArquivoGerado = $anoData."-".$mesData."-".$diaData;
	}
	  elseif($result[0] == 01){
		$orcamento 	= trim(substr($linha,32,10));
		$loja 		= trim(substr($linha,42,4));				
		$notaFiscal = trim(substr($linha,140,6));				
		$serie 		= trim(substr($linha,146,3));				
		$notaFiscalSerie = $notaFiscal." / ".$serie;				
		$vendedor	= "";
		$data_fat	= trim(substr($linha,149,8));
		$dia_dat	= trim(substr($data_fat,0,2));
		$mes_dat	= trim(substr($data_fat,2,2));
		$ano_dat	= trim(substr($data_fat,4,4));
		$data_final = $ano_dat.'-'.$mes_dat.'-'.$dia_dat;
		$nome 		= trim(substr($linha,233,100));
		$endereco 	= trim(substr($linha,333,100));
		$bairro 	= trim(substr($linha,433,30));
		$cidade 	= trim(substr($linha,463,50));
		$estado 	= trim(substr($linha,513,2));
		$cep 		= trim(substr($linha,535,8));
		$telefone	= trim(substr($linha,803,8));
		if($telefone == '00000000'){
			$telefone = "";
		}
		else{
			$telefone = "(21)".substr($telefone,0,4)."-".substr($telefone,4,7);
		}
		$referencia = trim(substr($linha,811,250));
		
		$select_user = "SELECT * FROM clientes WHERE (orcamento = \"$orcamento\" AND cod_loja = \"$loja\" AND data_faturamento = \"$data_final\" AND nome_cliente LIKE \"%$nome%\" AND cep_cliente = \"$cep\")";
		//echo $select_user."<br>";
		$query_user = mysql_query($select_user);
		$rows_user = mysql_num_rows($query_user);
		//echo $rows_user;
		//$rows_user = 0; // colocado para deixar cadastrar qualquer arquivo.
		if($rows_user == 0){
			if($notaFiscalSerie != "000000 / "){
				$select_user_termporario = "SELECT * FROM clientes_assistencia WHERE (orcamento = \"$orcamento\" AND cod_loja = \"$loja\" AND data_faturamento = \"$data_final\" AND nome_cliente LIKE \"%$nome%\" AND cep_cliente = \"$cep\")";
				$query_user_termporario = mysql_query($select_user_termporario);
				$rows_user_termporario = mysql_num_rows($query_user_termporario);
				if($rows_user_termporario == 0){
					
					$estado_select = "SELECT cod_estados FROM estados WHERE sigla = \"$estado\" LIMIT 1";
					$estado_query = mysql_query($estado_select);
					$estado_rows = mysql_num_rows($estado_query);
					$estado_linha = mysql_fetch_array($estado_query);
					if($estado_rows >0){
						$estado = $estado_linha["cod_estados"];
					}
					
					$cidade_select = "SELECT cod_cidades, nome FROM cidades";
					$cidade_query = mysql_query($cidade_select);
					$cidade_rows = mysql_num_rows($cidade_query);
					if($cidade_rows >0){
						while($cidade_linha = mysql_fetch_array($cidade_query)){
							$acento = array("A", "A", "A", "A", "E", "E", "E", "I", "I", "O", "O", "O", "O", "U", "U", "U", "C");
							$acento2= array("à", "á", "ã", "â", "é", "ê", "è", "í", "ì", "ó", "ò", "õ", "ô", "ú", "ù", "ü", "ç");							
							$upper_cidade_select = utf8_encode($cidade_linha["nome"]);
							$acento_cidade_select = str_replace($acento2,$acento,$upper_cidade_select);
							if($acento_cidade_select = $cidade){
								$cidade = $cidade_linha["cod_cidades"];
							}
						}
					}
					
					$cadastro = "
						INSERT	INTO 
							clientes_assistencia 
								(
									nota_fiscal, 
									vendedor, 
									orcamento, 
									cod_loja, 
									data_faturamento, 
									nome_cliente, 
									endereco_cliente, 
									bairro_cliente, 
									cidade_cliente, 
									estado_cliente, 
									cep_cliente, 
									telefone1_cliente, 
									referencia_cliente
								) 
						VALUE 
							(
								\"$notaFiscalSerie\",
								\"$vendedor\",
								\"$orcamento\",
								\"$loja\",
								\"$data_final\",
								\"$nome\",
								\"$endereco\",
								\"$bairro\",
								\"$cidade\",
								\"$estado\",
								\"$cep\",
								\"$telefone\",
								\"$referencia\"
							)";
							
					//echo $cadastro."<br>";
					//exit;
					$query = mysql_query($cadastro);
					$aceitas = $aceitas+1;
				}
				else{
					$bloqueados = $bloqueados+1;
				}
			}
			else{ //else invalido
				$invalidas = $invalidas+1;
			}
		}
		elseif($rows_user == 1){
			$bloqueados = $bloqueados+1;
		}
	  }
	  elseif($result[0] == 02){
		
		$n_montagem 	= trim(substr($linha,43,30));
		$orcamento2 	= trim(substr($linha,73,10));
		$cod_produto 	= trim(substr($linha,83,10));
		$nome_produto 	= trim(substr($linha,93,100));
		$qtde_produto 	= trim(substr($linha,193,15));
		
		$select_prod = "SELECT * FROM clientes_assistencia WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\"))";
		$query_prod = mysql_query($select_prod);
		$rows_prod = mysql_num_rows($query_prod);
		$result_prod = mysql_fetch_array($query_prod);

		if($rows_prod > 0){
			//echo $result_prod['cod_cliente']."<br>";
			if($result_prod['cod_cliente'] == ""){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente = \"$cod_produto\", qtde_cliente = \"$qtde_produto\", produto_cliente = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod."<br>";
			}
			elseif(strlen($result_prod['cod_cliente'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente2 = \"$cod_produto\", qtde_cliente2 = \"$qtde_produto\", produto_cliente2 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente2'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente3 = \"$cod_produto\", qtde_cliente3 = \"$qtde_produto\", produto_cliente3 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente3'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente4 = \"$cod_produto\", qtde_cliente4 = \"$qtde_produto\", produto_cliente4 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente4'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente5 = \"$cod_produto\", qtde_cliente5 = \"$qtde_produto\", produto_cliente5 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente5'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente6 = \"$cod_produto\", qtde_cliente6 = \"$qtde_produto\", produto_cliente6 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente6'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente7 = \"$cod_produto\", qtde_cliente7 = \"$qtde_produto\", produto_cliente7 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente7'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente8 = \"$cod_produto\", qtde_cliente8 = \"$qtde_produto\", produto_cliente8 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente8'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente9 = \"$cod_produto\", qtde_cliente9 = \"$qtde_produto\", produto_cliente9 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente9'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente10 = \"$cod_produto\", qtde_cliente10 = \"$qtde_produto\", produto_cliente10 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente10'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente11 = \"$cod_produto\", qtde_cliente11 = \"$qtde_produto\", produto_cliente11 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente11'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente12 = \"$cod_produto\", qtde_cliente12 = \"$qtde_produto\", produto_cliente12 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente12'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente13 = \"$cod_produto\", qtde_cliente13 = \"$qtde_produto\", produto_cliente13 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente13'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente14 = \"$cod_produto\", qtde_cliente14 = \"$qtde_produto\", produto_cliente14 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente14'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente15 = \"$cod_produto\", qtde_cliente15 = \"$qtde_produto\", produto_cliente15 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente15'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente16 = \"$cod_produto\", qtde_cliente16 = \"$qtde_produto\", produto_cliente16 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente16'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente17 = \"$cod_produto\", qtde_cliente17 = \"$qtde_produto\", produto_cliente17 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente17'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente18 = \"$cod_produto\", qtde_cliente18 = \"$qtde_produto\", produto_cliente18 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente18'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente19 = \"$cod_produto\", qtde_cliente19 = \"$qtde_produto\", produto_cliente19 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			elseif(strlen($result_prod['cod_cliente19'])>0){
				$update_prod = "UPDATE clientes_assistencia SET n_montagem = \"$n_montagem\", cod_cliente20 = \"$cod_produto\", qtde_cliente20 = \"$qtde_produto\", produto_cliente20 = \"$nome_produto\" WHERE ((orcamento = \"$orcamento2\" AND n_montagem = '0') OR (orcamento = \"$orcamento2\" AND n_montagem = \"$n_montagem\")) LIMIT 1";
				//echo $update_prod;
			}
			//echo $update_prod."<br>";
			$cadastro2 = mysql_query($update_prod);
		}
	  }
	}//FECHA WHILE
	//FECHA O PONTEIRO DO ARQUIVO
	fclose ($ponteiro);
	$data_envio = date("Y-m-d");
	$include = "INSERT INTO arquivo (nome_arquivo, data_envio, data_arquivo) VALUE ('".$primeiro_nome[0]."', '".$data_envio."', '".$dataArquivoGerado."')";
	//echo "<br>".$include;
	$registrando = mysql_query($include);
	//echo "<br><br>aceitas = ".$aceitas." bloqueadas = ".$bloqueados;
	//exit;
	
	echo "<script> alert('Arquivo da montadora gerado com sucesso.\\n Status:\\n Existe $bloqueados notas duplicadas. \\n Existe $invalidas notas invalidas.\\n Foram cadastradas $aceitas notas.');location.href='../adm_clientes_validar.php'; </script>";
	
	}
	else{
		echo "<script> alert('Por Favor envie o arquivo correto!');location.href='javascript:window.history.go(-1)'; </script>";
	}
}
else{
		echo "<script> alert('Esse arquivo ja foi enviado para o sistema.');location.href='javascript:window.history.go(-1)'; </script>";
}
?>