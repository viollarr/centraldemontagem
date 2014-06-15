<?php

include "config.php";



$prioridade				= $_POST['prioridade'];

$tipo_cadastro 			= $_POST['tipo'];

$quem_cadastra			= trim($_POST['quem_cadastra']);

$data_hora_cadastro		= date('Y-m-d H:i:s');

$n_montagem				= trim($_POST['n_montagem']);

$cod_loja				= trim($_POST['cod_loja']);

$orcamento				= trim($_POST['orcamento']);

$notaFiscal				= trim($_POST['notaFiscal']);

$vendedor				= trim($_POST['vendedor']);

$data					= trim($_POST['data_faturamento']);

$data_explode			= explode('/',$data);

$ano					= $data_explode[2];

$mes					= $data_explode[1];

$dia					= $data_explode[0];

$data_faturamento		= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];

// DATA RECEBIMENTO

$data2					= trim($_POST['data_recebimento']);

$data_explode2			= explode('/',$data2);

$ano2					= $data_explode2[2];

$mes2					= $data_explode2[1];

$dia2					= $data_explode2[0];

$data_recebimento		= $data_explode2[2].'-'.$data_explode2[1].'-'.$data_explode2[0];

// FIM

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



$qtde_cliente7			= trim($_POST['qtde_cliente7']);

$cod_cliente7			= trim($_POST['cod_cliente7']);

$produto_cliente7		= trim($_POST['produto_cliente7']);



$qtde_cliente8			= trim($_POST['qtde_cliente8']);

$cod_cliente8			= trim($_POST['cod_cliente8']);

$produto_cliente8		= trim($_POST['produto_cliente8']);



$qtde_cliente9			= trim($_POST['qtde_cliente9']);

$cod_cliente9			= trim($_POST['cod_cliente9']);

$produto_cliente9		= trim($_POST['produto_cliente9']);



$qtde_cliente10			= trim($_POST['qtde_cliente10']);

$cod_cliente10			= trim($_POST['cod_cliente10']);

$produto_cliente10		= trim($_POST['produto_cliente10']);



$qtde_cliente11			= trim($_POST['qtde_cliente11']);

$cod_cliente11			= trim($_POST['cod_cliente11']);

$produto_cliente11		= trim($_POST['produto_cliente11']);



$qtde_cliente12			= trim($_POST['qtde_cliente12']);

$cod_cliente12			= trim($_POST['cod_cliente12']);

$produto_cliente12		= trim($_POST['produto_cliente12']);



$qtde_cliente13			= trim($_POST['qtde_cliente13']);

$cod_cliente13			= trim($_POST['cod_cliente13']);

$produto_cliente13		= trim($_POST['produto_cliente13']);



$qtde_cliente14			= trim($_POST['qtde_cliente14']);

$cod_cliente14			= trim($_POST['cod_cliente14']);

$produto_cliente14		= trim($_POST['produto_cliente14']);



$qtde_cliente15			= trim($_POST['qtde_cliente15']);

$cod_cliente15			= trim($_POST['cod_cliente15']);

$produto_cliente15		= trim($_POST['produto_cliente15']);



$qtde_cliente16			= trim($_POST['qtde_cliente16']);

$cod_cliente16			= trim($_POST['cod_cliente16']);

$produto_cliente16		= trim($_POST['produto_cliente16']);



$qtde_cliente17			= trim($_POST['qtde_cliente17']);

$cod_cliente17			= trim($_POST['cod_cliente17']);

$produto_cliente17		= trim($_POST['produto_cliente17']);



$qtde_cliente18			= trim($_POST['qtde_cliente18']);

$cod_cliente18			= trim($_POST['cod_cliente18']);

$produto_cliente18		= trim($_POST['produto_cliente18']);



$qtde_cliente19			= trim($_POST['qtde_cliente19']);

$cod_cliente19			= trim($_POST['cod_cliente19']);

$produto_cliente19		= trim($_POST['produto_cliente19']);



$qtde_cliente20			= trim($_POST['qtde_cliente20']);

$cod_cliente20			= trim($_POST['cod_cliente20']);

$produto_cliente20		= trim($_POST['produto_cliente20']);



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

		if((strlen($n_montagem)>0) && (strlen($data_faturamento)>2) && (strlen($data_recebimento)>2) && (strlen($cod_loja)>0) && (strlen($nome_cliente)>0) && (strlen($bairro)>0)){

	$insert = "INSERT INTO clientes (prioridade, tipo, n_montagem, cod_loja, orcamento, nota_fiscal, vendedor, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, numero_cliente, complemento_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente, cod_cliente, produto_cliente, qtde_cliente2, cod_cliente2, produto_cliente2, qtde_cliente3, cod_cliente3, produto_cliente3, qtde_cliente4, cod_cliente4, produto_cliente4, qtde_cliente5, cod_cliente5, produto_cliente5, qtde_cliente6, cod_cliente6, produto_cliente6, qtde_cliente7, cod_cliente7, produto_cliente7, qtde_cliente8, cod_cliente8, produto_cliente8, qtde_cliente9, cod_cliente9, produto_cliente9, qtde_cliente10, cod_cliente10, produto_cliente10, qtde_cliente11, cod_cliente11, produto_cliente11, qtde_cliente12, cod_cliente12, produto_cliente12, qtde_cliente13, cod_cliente13, produto_cliente13, qtde_cliente14, cod_cliente14, produto_cliente14, qtde_cliente15, cod_cliente15, produto_cliente15, qtde_cliente16, cod_cliente16, produto_cliente16, qtde_cliente17, cod_cliente17, produto_cliente17, qtde_cliente18, cod_cliente18, produto_cliente18, qtde_cliente19, cod_cliente19, produto_cliente19, qtde_cliente20, cod_cliente20, produto_cliente20, id_usuario_cadastro, data_hora_cadastro) VALUES ('".$prioridade."', '".$tipo_cadastro."', '".$n_montagem."', '".$cod_loja."', '".$orcamento."', '".$notaFiscal."', '".$vendedor."', '".$data_faturamento."', '".$nome_cliente."', '".$cep."', '".$rua."', '".$numero."', '".$comp."', '".$bairro."', '".$cidade."', '".$estado."', '".$res."', '".$res2."', '".$res3."', '".$referencia_cliente."', '".$qtde_cliente."', '".$cod_cliente."', '".$produto_cliente."', '".$qtde_cliente2."', '".$cod_cliente2."', '".$produto_cliente2."', '".$qtde_cliente3."', '".$cod_cliente3."', '".$produto_cliente3."', '".$qtde_cliente4."', '".$cod_cliente4."', '".$produto_cliente4."', '".$qtde_cliente5."', '".$cod_cliente5."', '".$produto_cliente5."', '".$qtde_cliente6."', '".$cod_cliente6."', '".$produto_cliente6."', '".$qtde_cliente7."', '".$cod_cliente7."', '".$produto_cliente7."', '".$qtde_cliente8."', '".$cod_cliente8."', '".$produto_cliente8."', '".$qtde_cliente9."', '".$cod_cliente9."', '".$produto_cliente9."', '".$qtde_cliente10."', '".$cod_cliente10."', '".$produto_cliente10."', '".$qtde_cliente11."', '".$cod_cliente11."', '".$produto_cliente11."', '".$qtde_cliente12."', '".$cod_cliente12."', '".$produto_cliente12."', '".$qtde_cliente13."', '".$cod_cliente13."', '".$produto_cliente13."', '".$qtde_cliente14."', '".$cod_cliente14."', '".$produto_cliente14."', '".$qtde_cliente15."', '".$cod_cliente15."', '".$produto_cliente15."', '".$qtde_cliente16."', '".$cod_cliente16."', '".$produto_cliente16."', '".$qtde_cliente17."', '".$cod_cliente17."', '".$produto_cliente17."', '".$qtde_cliente18."', '".$cod_cliente18."', '".$produto_cliente18."', '".$qtde_cliente19."', '".$cod_cliente19."', '".$produto_cliente19."', '".$qtde_cliente20."', '".$cod_cliente20."', '".$produto_cliente20."', '".$quem_cadastra."', '".$data_hora_cadastro."')";



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

if((strlen($cod_cliente7)>0)){

	$select_pro7 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente7."'";

	$query_pro7  = mysql_query($select_pro7) or die (mysql_error());

	$result_pro7 = mysql_num_rows($query_pro7);

	if($result_pro7 == 0){

		$insert_pro7 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente7."', '".$produto_cliente7."')";

		$query_pro7	= mysql_query($insert_pro7);

	}

}

if((strlen($cod_cliente8)>0)){

	$select_pro8 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente8."'";

	$query_pro8  = mysql_query($select_pro8) or die (mysql_error());

	$result_pro8 = mysql_num_rows($query_pro8);

	if($result_pro8 == 0){

		$insert_pro8 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente8."', '".$produto_cliente8."')";

		$query_pro8	= mysql_query($insert_pro8);

	}

}

if((strlen($cod_cliente9)>0)){

	$select_pro9 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente9."'";

	$query_pro9  = mysql_query($select_pro9) or die (mysql_error());

	$result_pro9 = mysql_num_rows($query_pro9);

	if($result_pro9 == 0){

		$insert_pro9 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente9."', '".$produto_cliente9."')";

		$query_pro9	= mysql_query($insert_pro9);

	}

}

if((strlen($cod_cliente10)>0)){

	$select_pro10 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente10."'";

	$query_pro10  = mysql_query($select_pro10) or die (mysql_error());

	$result_pro10 = mysql_num_rows($query_pro10);

	if($result_pro10 == 0){

		$insert_pro10 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente10."', '".$produto_cliente10."')";

		$query_pro10	= mysql_query($insert_pro10);

	}

}

if((strlen($cod_cliente11)>0)){

	$select_pro11 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente11."'";

	$query_pro11  = mysql_query($select_pro11) or die (mysql_error());

	$result_pro11 = mysql_num_rows($query_pro11);

	if($result_pro11 == 0){

		$insert_pro11 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente11."', '".$produto_cliente11."')";

		$query_pro11	= mysql_query($insert_pro11);

	}

}

if((strlen($cod_cliente12)>0)){

	$select_pro12 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente12."'";

	$query_pro12  = mysql_query($select_pro12) or die (mysql_error());

	$result_pro12 = mysql_num_rows($query_pro12);

	if($result_pro12 == 0){

		$insert_pro12 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente12."', '".$produto_cliente12."')";

		$query_pro12	= mysql_query($insert_pro12);

	}

}

if((strlen($cod_cliente13)>0)){

	$select_pro13 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente13."'";

	$query_pro13  = mysql_query($select_pro13) or die (mysql_error());

	$result_pro13 = mysql_num_rows($query_pro13);

	if($result_pro13 == 0){

		$insert_pro13 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente13."', '".$produto_cliente13."')";

		$query_pro13	= mysql_query($insert_pro13);

	}

}

if((strlen($cod_cliente14)>0)){

	$select_pro14 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente14."'";

	$query_pro14  = mysql_query($select_pro14) or die (mysql_error());

	$result_pro14 = mysql_num_rows($query_pro14);

	if($result_pro14 == 0){

		$insert_pro14 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente14."', '".$produto_cliente14."')";

		$query_pro14	= mysql_query($insert_pro14);

	}

}

if((strlen($cod_cliente15)>0)){

	$select_pro15 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente15."'";

	$query_pro15  = mysql_query($select_pro15) or die (mysql_error());

	$result_pro15 = mysql_num_rows($query_pro15);

	if($result_pro15 == 0){

		$insert_pro15 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente15."', '".$produto_cliente15."')";

		$query_pro15	= mysql_query($insert_pro15);

	}

}

if((strlen($cod_cliente16)>0)){

	$select_pro16 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente16."'";

	$query_pro16  = mysql_query($select_pro16) or die (mysql_error());

	$result_pro16 = mysql_num_rows($query_pro16);

	if($result_pro16 == 0){

		$insert_pro16 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente16."', '".$produto_cliente16."')";

		$query_pro16	= mysql_query($insert_pro16);

	}

}

if((strlen($cod_cliente17)>0)){

	$select_pro17 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente17."'";

	$query_pro17  = mysql_query($select_pro17) or die (mysql_error());

	$result_pro17 = mysql_num_rows($query_pro17);

	if($result_pro17 == 0){

		$insert_pro17 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente17."', '".$produto_cliente17."')";

		$query_pro17	= mysql_query($insert_pro17);

	}

}

if((strlen($cod_cliente18)>0)){

	$select_pro18 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente18."'";

	$query_pro18  = mysql_query($select_pro18) or die (mysql_error());

	$result_pro18 = mysql_num_rows($query_pro18);

	if($result_pro18 == 0){

		$insert_pro18 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente18."', '".$produto_cliente18."')";

		$query_pro18	= mysql_query($insert_pro18);

	}

}

if((strlen($cod_cliente19)>0)){

	$select_pro19 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente19."'";

	$query_pro19  = mysql_query($select_pro19) or die (mysql_error());

	$result_pro19 = mysql_num_rows($query_pro19);

	if($result_pro19 == 0){

		$insert_pro19 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente19."', '".$produto_cliente19."')";

		$query_pro19	= mysql_query($insert_pro19);

	}

}

if((strlen($cod_cliente20)>0)){

	$select_pro20 = "SELECT * FROM produtos WHERE cod_produto = '".$cod_cliente20."'";

	$query_pro20  = mysql_query($select_pro20) or die (mysql_error());

	$result_pro20 = mysql_num_rows($query_pro20);

	if($result_pro20 == 0){

		$insert_pro20 = "INSERT INTO	produtos (cod_produto, modelo) VALUES ('".$cod_cliente20."', '".$produto_cliente20."')";

		$query_pro20	= mysql_query($insert_pro20);

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

//		$startdate=mktime(0,0,0,$mes,$dia,$ano);

//		$hoje_3dias=$startdate + 3*24*60*60;

//		$data_3=date ( "Y-m-d", $hoje_3dias );

#													   #

########################################################

include "funcao_data_limite.php";
$d3 = $dia2."/".$mes2."/".$ano2;

$DataInicial = "$d3";
$QtdDia = 3;
$diasSomados = SomaDiasUteis($DataInicial,$QtdDia);

$d4 = explode('/',$diasSomados );
$data_3 = $d4[2]."-".$d4[1]."-".$d4[0];
//var_dump($DataInicial);
//var_dump($diasSomados);
//var_dump($data_3);
//exit();

$insert_data = "INSERT INTO	datas (n_montagens, data_faturamento, data_recebimento, data_limite) VALUES ('".$n_montagem."', '".$data_faturamento."', '".$data_recebimento."', '".$data_3."')";

$query_datas = mysql_query($insert_data);

################################################################################################################
include"../classe/Log.class.php";
$select_mod = "SELECT * FROM usuarios WHERE id = '$quem_cadastra'";
$query_mod = mysql_query($select_mod);
$result_mod = mysql_fetch_array($query_mod);

$grava_entrada = "";
foreach($_POST AS $entrada){
	$grava_entrada .= $entrada." => ";
}

$objLog = new Log();
$objLog->grava(" ");
$objLog->grava("CADASTRO DE CLIENTE");
$objLog->grava('POST => "'.$result_mod['login'].'" Data => "'.date('Y-m-d H:i:s').'", Cadastrou o Cliente de vale '.$n_montagem.' => "INFORMAÇÕES CADASTRADAS => "'.$grava_entrada.'"');

#################################################################################################################

echo "<script>location.href=' ../cad_clientes.php';</script>";
//Header("Location: ../cad_clientes.php");

	}

	else{

		echo "<script> alert('O cadastro N&Atilde;O pode ser realizado pois existe campos sem preencher. Verifique um dos itens abaixo:\\n - N&deg; Ordem Montagem.\\n - Loja.\\n - Or&ccedil;amento.\\n - Data de Faturamento.\\n - Nome Completo.\\n - Bairro!');location.href='javascript:window.history.go(-1)'; </script>";

	}

}

?>