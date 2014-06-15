<?php

include "config.php";



$prioridade				= $_POST['prioridade'];

$tipo_cadastro 			= $_POST['tipo'];

$quem_cadastra			= trim($_POST['quem_cadastra']);

$data_hora_cadastro		= date('Y-m-d H:i:s');

$n_montagem				= trim($_POST['n_montagem']);

$cod_loja				= trim($_POST['cod_loja']);

$orcamento				= trim($_POST['orcamento']);

$data					= trim($_POST['data_faturamento']);

$data_explode			= explode('/',$data);

$ano					= $data_explode[2];

$mes					= $data_explode[1];

$dia					= $data_explode[0];

$data_faturamento		= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];

$nome_cliente			= trim($_POST['nome_cliente']);

$cep					= trim($_POST['cep']);

$rua					= strtoupper(trim($_POST['rua']));

$numero					= trim($_POST['numero']);

$comp					= trim($_POST['comp']);

$bairro					= strtoupper(trim($_POST['bairro']));

$cidade					= strtoupper(trim($_POST['cidade']));

$estado					= trim($_POST['estado']);

$res					= trim($_POST['res']);

$res2					= trim($_POST['res2']);

$res3					= trim($_POST['res3']);

$referencia_cliente		= trim($_POST['referencia_cliente']);

$qtde_cliente			= trim($_POST['qtde_cliente']);

$cod_cliente			= trim($_POST['cod_cliente']);

$produto_cliente		= trim($_POST['produto_cliente']);



$qtde_cliente2			= trim($_POST['qtde_cliente2']);

$cod_cliente2			= trim($_POST['cod_cliente2']);

$produto_cliente2		= trim($_POST['produto_cliente2']);



$qtde_cliente3			= trim($_POST['qtde_cliente3']);

$cod_cliente3			= trim($_POST['cod_cliente3']);

$produto_cliente3		= trim($_POST['produto_cliente3']);



$qtde_cliente4			= trim($_POST['qtde_cliente4']);

$cod_cliente4			= trim($_POST['cod_cliente4']);

$produto_cliente4		= trim($_POST['produto_cliente4']);



$qtde_cliente5			= trim($_POST['qtde_cliente5']);

$cod_cliente5			= trim($_POST['cod_cliente5']);

$produto_cliente5		= trim($_POST['produto_cliente5']);



$qtde_cliente6			= trim($_POST['qtde_cliente6']);

$cod_cliente6			= trim($_POST['cod_cliente6']);

$produto_cliente6		= trim($_POST['produto_cliente6']);



$acento = array("À", "Á", "Ã", "Â", "É", "Ê", "Í", "Ó", "Õ", "Ô", "Ú", "Ü", "Ç");

$acento2= array("à", "á", "ã", "â", "é", "ê", "í", "ó", "õ", "ô", "ú", "ü", "ç");



$rua 	= str_replace($acento2,$acento,$rua);

$bairro = str_replace($acento2,$acento,$bairro);

$cidade = str_replace($acento2,$acento,$cidade);



$select = "SELECT * FROM clientes WHERE ((n_montagem = '$n_montagem' AND nome_cliente = '$nome_cliente') OR (orcamento = '$orcamento' AND cod_cliente = '$cod_cliente') OR (orcamento = '$orcamento' AND nome_cliente = '$nome_cliente' AND n_montagem = '$n_montagem') OR (n_montagem = '$n_montagem')) ";

$pesquisar = mysql_query($select); 

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima



if ( $contagem == 1 ) {

  echo("<script>

      alert(\"Cliente j&aacute; cadastrado\");

      window.location = '../cad_clientes.php';

      </script>");

	  exit;

} else {

		if((strlen($n_montagem)>0) && (strlen($data_faturamento)>2) && (strlen($cod_loja)>0) && (strlen($orcamento)>0) && (strlen($nome_cliente)>0) && (strlen($bairro)>0)){

	$insert = "INSERT INTO clientes (prioridade, tipo, n_montagem, cod_loja, orcamento, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, numero_cliente, complemento_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente, cod_cliente, produto_cliente, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6, id_usuario_cadastro, data_hora_cadastro) VALUES ('".$prioridade."', '".$tipo_cadastro."', '".$n_montagem."', '".$cod_loja."', '".$orcamento."', '".$data_faturamento."', '".$nome_cliente."', '".$cep."', '".$rua."', '".$numero."', '".$comp."', '".$bairro."', '".$cidade."', '".$estado."', '".$res."', '".$res2."', '".$res3."', '".$referencia_cliente."', '".$qtde_cliente."', '".$cod_cliente."', '".$produto_cliente."', '".$qtde_cliente2."', '".$cod_cliente2."', '".$produto_cliente2."', '".$qtde_cliente3."', '".$cod_cliente3."', '".$produto_cliente3."', '".$qtde_cliente4."', '".$cod_cliente4."', '".$produto_cliente4."', '".$qtde_cliente5."', '".$cod_cliente5."', '".$produto_cliente5."', '".$qtde_cliente6."', '".$cod_cliente6."', '".$produto_cliente6."', '".$quem_cadastra."', '".$data_hora_cadastro."')";



$cadastrar = mysql_query($insert) or die (mysql_error());



if((strlen($cod_cliente)>0)){

	$select_pro = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente."'";

	$query_pro  = mysql_query($select_pro) or die (mysql_error());

	$result_pro = mysql_num_rows($query_pro);

	if($result_pro == 0){

		$insert_pro = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente."', '".$produto_cliente."')";

		$query_pro	= mysql_query($insert_pro);

	}

}

if((strlen($cod_cliente2)>0)){

	$select_pro2 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente2."'";

	$query_pro2  = mysql_query($select_pro2) or die (mysql_error());

	$result_pro2 = mysql_num_rows($query_pro2);

	if($result_pro2 == 0){

		$insert_pro2 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente2."', '".$produto_cliente2."')";

		$query_pro2	= mysql_query($insert_pro2);

	}

}

if((strlen($cod_cliente3)>0)){

	$select_pro3 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente3."'";

	$query_pro3  = mysql_query($select_pro3) or die (mysql_error());

	$result_pro3 = mysql_num_rows($query_pro3);

	if($result_pro3 == 0){

		$insert_pro3 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente3."', '".$produto_cliente3."')";

		$query_pro3	= mysql_query($insert_pro3);

	}

}

if((strlen($cod_cliente4)>0)){

	$select_pro4 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente4."'";

	$query_pro4  = mysql_query($select_pro4) or die (mysql_error());

	$result_pro4 = mysql_num_rows($query_pro4);

	if($result_pro4 == 0){

		$insert_pro4 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente4."', '".$produto_cliente4."')";

		$query_pro4	= mysql_query($insert_pro4);

	}

}

if((strlen($cod_cliente5)>0)){

	$select_pro5 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente5."'";

	$query_pro5  = mysql_query($select_pro5) or die (mysql_error());

	$result_pro5 = mysql_num_rows($query_pro5);

	if($result_pro5 == 0){

		$insert_pro5 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente5."', '".$produto_cliente5."')";

		$query_pro5	= mysql_query($insert_pro5);

	}

}

if((strlen($cod_cliente6)>0)){

	$select_pro6 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente6."'";

	$query_pro6  = mysql_query($select_pro6) or die (mysql_error());

	$result_pro6 = mysql_num_rows($query_pro6);

	if($result_pro6 == 0){

		$insert_pro6 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente6."', '".$produto_cliente6."')";

		$query_pro6	= mysql_query($insert_pro6);

	}

}



$select_cli = "SELECT * FROM clientes WHERE n_montagem = '".$n_montagem."'";

$query_cli  = mysql_query($select_cli) or die (mysql_error());

$result_cli = mysql_fetch_array($query_cli);



$select_bairro = "SELECT * FROM bairros WHERE nome LIKE '%".$bairro."%'";

$query_bairro = mysql_query($select_bairro);

$rows_bairro = mysql_num_rows($query_bairro);

if($rows_bairro > 0){

$a = mysql_fetch_array($query_bairro);

$id_bairros = $a[id_bairros];

}

else{

$insert_bairro = "INSERT INTO bairros (nome) VALUES ('".$bairro."')";

$query_insert = mysql_query($insert_bairro);



$select_bairro = "SELECT * FROM bairros WHERE nome LIKE '%".$bairro."%'";

$query_bairro = mysql_query($select_bairro);

$rows_bairro = mysql_num_rows($query_bairro);

$a = mysql_fetch_array($query_bairro);

$id_bairros = $a[id_bairros];

}





$insert_montagem = "INSERT INTO	ordem_montagem (n_montagem, id_cliente, id_bairros) VALUES ('".$n_montagem."', '".$result_cli['id_cliente']."', '".$id_bairros."')";

$query_montagem  = mysql_query($insert_montagem) or die (mysql_error());





########################################################

#				PEGAR DATA LIMITE					   #			

		$startdate=mktime(0,0,0,$mes,$dia,$ano);

		$hoje_7dias=$startdate + 7*24*60*60;

		$data_7=date ( "Y-m-d", $hoje_7dias );

#													   #

########################################################



$insert_data = "INSERT INTO	datas (n_montagens, data_faturamento, data_limite) VALUES ('".$n_montagem."', '".$data_faturamento."', '".$data_7."')";

$query_datas = mysql_query($insert_data);



Header("Location: ../cad_clientes.php");

	}

	else{

		echo "<script> alert('O cadastro N&Atilde;O pode ser realizado pois existe campos sem preencher. Verifique um dos itens abaixo:\\n - N&deg; Ordem Montagem.\\n - Loja.\\n - Or&ccedil;amento.\\n - Data de Faturamento.\\n - Nome Completo.\\n - Bairro!');location.href='javascript:window.history.go(-1)'; </script>";

	}

}

?>

