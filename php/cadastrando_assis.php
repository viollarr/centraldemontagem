<?php
include "config.php";
include_once "valida_sessao.php";

$cliente_antigo = $_POST['id_clientes'];
$protocolo =  $_POST['protocolo'];
$data	= $_POST['data_faturamento'];
$produto_ref =  $_POST['produto'];

$select = "SELECT * FROM clientes WHERE id_cliente = '$cliente_antigo'";
$query = mysql_query($select);
$x = mysql_fetch_array($query);

$prioridade				= $x['prioridade'];
$tipo_cadastro 			= 3;
$quem_cadastra			= trim($_SESSION['id_usuario']);
$data_hora_cadastro		= date('Y-m-d H:i:s');
$n_montagem				= $protocolo;
$cod_loja				= trim($x['cod_loja']);
$orcamento				= $protocolo;
$data_explode			= explode('/',$data);
$ano					= $data_explode[2];
$mes					= $data_explode[1];
$dia					= $data_explode[0];
$data_faturamento		= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];
$nome_cliente			= trim($x['nome_cliente']);
$cep					= trim($x['cep_cliente']);
$rua					= strtoupper(trim($x['endereco_cliente']));
$numero					= trim($x['numero_cliente']);
$comp					= trim($x['complemento_cliente']);
$bairro					= strtoupper(trim($x['bairro_cliente']));
$cidade					= strtoupper(trim($x['cidade_cliente']));
$estado					= trim($x['estado_cliente']);
$res					= trim($x['telefone1_cliente']);
$res2					= trim($x['telefone2_cliente']);
$res3					= trim($x['telefone3_cliente']);
$referencia_cliente		= trim($x['referencia_cliente']);

if($produto_ref == 1){
	$qtde_cliente			= trim($x['qtde_cliente']);
	$cod_cliente			= trim($x['cod_cliente']);
	$produto_cliente		= trim($x['produto_cliente']);
}
elseif($produto_ref == 2){	
	$qtde_cliente			= trim($x['qtde_cliente2']);
	$cod_cliente			= trim($x['cod_cliente2']);
	$produto_cliente		= trim($x['produto_cliente2']);
}
elseif($produto_ref == 3){	
	$qtde_cliente			= trim($x['qtde_cliente3']);
	$cod_cliente			= trim($x['cod_cliente3']);
	$produto_cliente		= trim($x['produto_cliente3']);
}
elseif($produto_ref == 4){	
	$qtde_cliente			= trim($x['qtde_cliente4']);
	$cod_cliente			= trim($x['cod_cliente4']);
	$produto_cliente		= trim($x['produto_cliente4']);
}
elseif($produto_ref == 5){	
	$qtde_cliente			= trim($x['qtde_cliente5']);
	$cod_cliente			= trim($x['cod_cliente5']);
	$produto_cliente		= trim($x['produto_cliente5']);
}
elseif($produto_ref == 6){	
	$qtde_cliente			= trim($x['qtde_cliente6']);
	$cod_cliente			= trim($x['cod_cliente6']);
	$produto_cliente		= trim($x['produto_cliente6']);
}
elseif($produto_ref == 7){	
	$qtde_cliente			= trim($x['qtde_cliente7']);
	$cod_cliente			= trim($x['cod_cliente7']);
	$produto_cliente		= trim($x['produto_cliente7']);
}
elseif($produto_ref == 8){	
	$qtde_cliente			= trim($x['qtde_cliente8']);
	$cod_cliente			= trim($x['cod_cliente8']);
	$produto_cliente		= trim($x['produto_cliente8']);
}
elseif($produto_ref == 9){	
	$qtde_cliente			= trim($x['qtde_cliente9']);
	$cod_cliente			= trim($x['cod_cliente9']);
	$produto_cliente		= trim($x['produto_cliente9']);
}
elseif($produto_ref == 10){	
	$qtde_cliente			= trim($x['qtde_cliente10']);
	$cod_cliente			= trim($x['cod_cliente10']);
	$produto_cliente		= trim($x['produto_cliente10']);
}
elseif($produto_ref == 11){	
	$qtde_cliente			= trim($x['qtde_cliente11']);
	$cod_cliente			= trim($x['cod_cliente11']);
	$produto_cliente		= trim($x['produto_cliente11']);
}
elseif($produto_ref == 12){	
	$qtde_cliente			= trim($x['qtde_cliente12']);
	$cod_cliente			= trim($x['cod_cliente12']);
	$produto_cliente		= trim($x['produto_cliente12']);
}
elseif($produto_ref == 13){	
	$qtde_cliente			= trim($x['qtde_cliente13']);
	$cod_cliente			= trim($x['cod_cliente13']);
	$produto_cliente		= trim($x['produto_cliente13']);
}
elseif($produto_ref == 14){	
	$qtde_cliente			= trim($x['qtde_cliente14']);
	$cod_cliente			= trim($x['cod_cliente14']);
	$produto_cliente		= trim($x['produto_cliente14']);
}
elseif($produto_ref == 15){	
	$qtde_cliente			= trim($x['qtde_cliente15']);
	$cod_cliente			= trim($x['cod_cliente15']);
	$produto_cliente		= trim($x['produto_cliente15']);
}
elseif($produto_ref == 16){	
	$qtde_cliente			= trim($x['qtde_cliente16']);
	$cod_cliente			= trim($x['cod_cliente16']);
	$produto_cliente		= trim($x['produto_cliente16']);
}
elseif($produto_ref == 17){	
	$qtde_cliente			= trim($x['qtde_cliente17']);
	$cod_cliente			= trim($x['cod_cliente17']);
	$produto_cliente		= trim($x['produto_cliente17']);
}
elseif($produto_ref == 18){	
	$qtde_cliente			= trim($x['qtde_cliente18']);
	$cod_cliente			= trim($x['cod_cliente18']);
	$produto_cliente		= trim($x['produto_cliente18']);
}
elseif($produto_ref == 19){	
	$qtde_cliente			= trim($x['qtde_cliente19']);
	$cod_cliente			= trim($x['cod_cliente19']);
	$produto_cliente		= trim($x['produto_cliente19']);
}
elseif($produto_ref == 20){	
	$qtde_cliente			= trim($x['qtde_cliente20']);
	$cod_cliente			= trim($x['cod_cliente20']);
	$produto_cliente		= trim($x['produto_cliente20']);
}	

	$insert = "INSERT INTO clientes (prioridade, tipo, n_montagem, cod_loja, orcamento, data_faturamento, nome_cliente, cep_cliente, endereco_cliente, numero_cliente, complemento_cliente, bairro_cliente, cidade_cliente, estado_cliente, telefone1_cliente, telefone2_cliente, telefone3_cliente, referencia_cliente, qtde_cliente, cod_cliente, produto_cliente, id_usuario_cadastro, data_hora_cadastro) VALUES ('".$prioridade."', '".$tipo_cadastro."', '".$n_montagem."', '".$cod_loja."', '".$orcamento."', '".$data_faturamento."', '".$nome_cliente."', '".$cep."', '".$rua."', '".$numero."', '".$comp."', '".$bairro."', '".$cidade."', '".$estado."', '".$res."', '".$res2."', '".$res3."', '".$referencia_cliente."', '".$qtde_cliente."', '".$cod_cliente."', '".$produto_cliente."', '".$quem_cadastra."', '".$data_hora_cadastro."')";

$cadastrar = mysql_query($insert) or die (mysql_error());

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

Header("Location: ../adm_clientes.php");

?>