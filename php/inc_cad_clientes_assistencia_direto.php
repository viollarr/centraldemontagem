<?php

include "config.php";



$id_cliente_assistencia = $_GET['id_clientes'];

//echo $id_cliente_assistencia."<br>";

	$select_cliente_antigo = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente_assistencia'";

	//echo $select_cliente_antigo."<br>";

	$query_cliente_antigo = mysql_query($select_cliente_antigo);

	$result_cliente_antigo = mysql_fetch_array($query_cliente_antigo);

	

	$select_cliente_novo = "SELECT * FROM clientes_assistencia WHERE n_montagem = '$result_cliente_antigo[n_montagem]' AND orcamento = '$result_cliente_antigo[orcamento]' AND data_faturamento = '$result_cliente_antigo[data_faturamento]' AND nome_cliente = '$result_cliente_antigo[nome_cliente]'";

	//echo $select_cliente_novo."<br>";

	$query_cliente_novo = mysql_query($select_cliente_novo);

	$rows_cliente_novo = mysql_num_rows($query_cliente_novo);

	//echo $rows_cliente_novo;

	if($rows_cliente_novo == '1'){

		//echo "cadastrado";

		echo "<script> alert('Cliente j&aacute; foi cadastrado no setor de ASSIST&Ecirc;NCIA T&eacute;cnica.');location.href='javascript:window.history.go(-1)'; </script>";

	}

	else{

		//echo " cadastrando";

		

		$query = "INSERT INTO clientes_assistencia (prioridade, n_montagem, cod_loja, orcamento, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, numero_cliente, complemento_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente, cod_cliente, produto_cliente, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6) VALUES ('".$result_cliente_antigo['prioridade']."', '".$result_cliente_antigo['n_montagem']."', '".$result_cliente_antigo['cod_loja']."', '".$result_cliente_antigo['orcamento']."', '".$result_cliente_antigo['data_faturamento']."', '".$result_cliente_antigo['nome_cliente']."', '".$result_cliente_antigo['cep_cliente']."', '".$result_cliente_antigo['endereco_cliente']."', '".$result_cliente_antigo['numero_cliente']."', '".$result_cliente_antigo['complemento_cliente']."', '".$result_cliente_antigo['bairro_cliente']."', '".$result_cliente_antigo['cidade_cliente']."', '".$result_cliente_antigo['estado_cliente']."', '".$result_cliente_antigo['telefone1_cliente']."', '".$result_cliente_antigo['telefone2_cliente']."', '".$result_cliente_antigo['telefone3_cliente']."', '".$result_cliente_antigo['referencia_cliente']."', '".$result_cliente_antigo['qtde_cliente']."', '".$result_cliente_antigo['cod_cliente']."', '".$result_cliente_antigo['produto_cliente']."', '".$result_cliente_antigo['qtde_cliente2']."', '".$result_cliente_antigo['cod_cliente2']."', '".$result_cliente_antigo['produto_cliente2']."', '".$result_cliente_antigo['qtde_cliente3']."', '".$result_cliente_antigo['cod_cliente3']."', '".$result_cliente_antigo['produto_cliente3']."', '".$result_cliente_antigo['qtde_cliente4']."', '".$result_cliente_antigo['cod_cliente4']."', '".$result_cliente_antigo['produto_cliente4']."', '".$result_cliente_antigo['qtde_cliente5']."', '".$result_cliente_antigo['cod_cliente5']."', '".$result_cliente_antigo['produto_cliente5']."', '".$result_cliente_antigo['qtde_cliente6']."', '".$result_cliente_antigo['cod_cliente6']."', '".$result_cliente_antigo['produto_cliente6']."')";

		//echo "<br>".$query."<br>";

		//exit;

		$result = mysql_query($query);

		

	$select_cli = "SELECT * FROM clientes_assistencia WHERE n_montagem = '".$result_cliente_antigo['n_montagem']."'";

	//echo $select_cli."<br>";

	$query_cli  = mysql_query($select_cli) or die (mysql_error());

	$result_cli = mysql_fetch_array($query_cli);

	

	$select_bairro = "SELECT * FROM bairros WHERE nome = '".$result_cliente_antigo['bairro']."'";

	$query_bairro = mysql_query($select_bairro);

	$a = mysql_fetch_array($query_bairro);

	$id_bairros = $a[id_bairros];

	

	

	$insert_montagem = "INSERT INTO	ordem_montagem_assistencia (n_montagem, id_cliente, id_bairros) VALUES ('".$result_cli['n_montagem']."', '".$result_cli['id_cliente']."', '".$id_bairros."')";

	$query_montagem  = mysql_query($insert_montagem) or die (mysql_error());

	

	

	########################################################

	#				PEGAR DATA LIMITE					   #

	

			$datas = explode('-',$result_cli['data_faturamento']);

			$dia = $datas[2];

			$mes = $datas[1];

			$ano = $ano[0];	

			$startdate=mktime(0,0,0,$mes,$dia,$ano);

			$hoje_7dias=$startdate + 7*24*60*60;

			$data_7=date ( "Y-m-d", $hoje_7dias );

	#													   #

	########################################################

	

	$insert_data = "INSERT INTO	datas_assistencia (n_montagens, data_faturamento, data_limite) VALUES ('".$result_cli['n_montagem']."', '".$result_cli['data_faturamento']."', '".$data_7."')";

	echo $insert_data;

	$query_datas = mysql_query($insert_data);

	 exit;

	//echo "<script> alert('Cadastro efetuado com sucesso!');location.href='../adm_clientes_assistencia.php'; </script";

	

}

?>