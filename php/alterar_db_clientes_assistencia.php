<?php
if (isset($_POST['editar_clientes']))

{
include"config.php";

if(strlen($_POST['jur'])>0){
	$prioridade = trim($_POST['jur']);
}
elseif(strlen($_POST['agen'])>0){
	$prioridade = trim($_POST['agen']);
}
else{
	$prioridade = trim($_POST['nor']);
}

$tipo_cadastro = $_POST['tipo'];
// $tipo_montagem = tipo de montagem se é (0 = montagem, 1 = desmontagem ou 2 = assistencia tecnica)
// $tipo_pessoa = tipo de pessoa que e cadastrada (0 = cliente e 1 = loja)
if($tipo_cadastro == 0){
	$tipo_montagem = 0;
	$tipo_pessoa = 0;
}
elseif($tipo_cadastro == 1){
	$tipo_montagem = 0;
	$tipo_pessoa = 1;
}
elseif($tipo_cadastro == 2){
	$tipo_montagem = 1;
	$tipo_pessoa = 0;
}
elseif($tipo_cadastro == 3){
	$tipo_montagem = 1;
	$tipo_pessoa = 1;
}
elseif($tipo_cadastro == 4){
	$tipo_montagem = 2;
	$tipo_pessoa = 0;
}
elseif($tipo_cadastro == 5){
	$tipo_montagem = 3;
	$tipo_pessoa = 0;
}

$id_clientes = $_POST['id_clientes'];

$n_montagem				= $_POST['n_montagem'];
$cod_loja				= $_POST['cod_loja'];
$orcamento				= $_POST['orcamento'];
$data					= $_POST['data_faturamento'];
$data_explode			= explode('/',$data);
$data_faturamento		= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];
$nome_cliente			= $_POST['nome_cliente'];
$cep					= $_POST['cep'];
$rua					= $_POST['rua'];
$numero					= $_POST['numero'];
$comp					= $_POST['comp'];
$bairro					= $_POST['bairro'];
$cidade					= $_POST['cidade'];
$estado					= $_POST['estado'];
$res					= $_POST['res'];
$res2					= $_POST['res2'];
$res3					= $_POST['res3'];
$referencia_cliente		= $_POST['referencia_cliente'];
$qtde_cliente			= $_POST['qtde_cliente'];
$cod_cliente			= $_POST['cod_cliente'];
$produto_cliente		= $_POST['produto_cliente'];

$qtde_cliente2			= $_POST['qtde_cliente2'];
$cod_cliente2			= $_POST['cod_cliente2'];
$produto_cliente2		= $_POST['produto_cliente2'];

$qtde_cliente3			= $_POST['qtde_cliente3'];
$cod_cliente3			= $_POST['cod_cliente3'];
$produto_cliente3		= $_POST['produto_cliente3'];

$qtde_cliente4			= $_POST['qtde_cliente4'];
$cod_cliente4			= $_POST['cod_cliente4'];
$produto_cliente4		= $_POST['produto_cliente4'];

$qtde_cliente5			= $_POST['qtde_cliente5'];
$cod_cliente5			= $_POST['cod_cliente5'];
$produto_cliente5		= $_POST['produto_cliente5'];

$qtde_cliente6			= $_POST['qtde_cliente6'];
$cod_cliente6			= $_POST['cod_cliente6'];
$produto_cliente6		= $_POST['produto_cliente6'];

$select_cliente = "SELECT * FROM clientes_assistencia WHERE id_cliente = '$id_clientes'";
$query_cliente = mysql_query($select_cliente);
$a = mysql_fetch_array($query_cliente);

$select_data = "UPDATE datas_assistencia SET n_montagens = '$n_montagem' WHERE n_montagens = '$a[n_montagem]'";
$query_data = mysql_query($select_data);
$select_ordem = "UPDATE ordem_montagem_assistencia SET n_montagem = '$n_montagem' WHERE n_montagem = '$a[n_montagem]'";
$query_ordem = mysql_query($select_ordem);

$query	= "
	UPDATE clientes_assistencia SET 
	prioridade			= '".$prioridade."',
	tipo	 			= '".$tipo_pessoa."', 
	tipo_montagem		= '".$tipo_montagem."',
	n_montagem 			= '".$n_montagem."', 
	cod_loja 			= '".$cod_loja."',
	orcamento 			= '".$orcamento."',
	data_faturamento 	= '".$data_faturamento."',
	nome_cliente 		= '".$nome_cliente."',
	cep_cliente 		= '".$cep."',
	endereco_cliente 	= '".$rua."',
	numero_cliente 		= '".$numero."',
	complemento_cliente	= '".$comp."',
	bairro_cliente		= '".$bairro."',
	cidade_cliente		= '".$cidade."',
	estado_cliente 		= '".$estado."',
	telefone1_cliente 	= '".$res."',
	telefone2_cliente	= '".$res2."',
	telefone3_cliente	= '".$res3."',
	referencia_cliente	= '".$referencia_cliente."',
	qtde_cliente 		= '".$qtde_cliente."',
	cod_cliente			= '".$cod_cliente."',
	produto_cliente		= '".$produto_cliente."',
	qtde_cliente2 		= '".$qtde_cliente2."',
	cod_cliente2		= '".$cod_cliente2."',
	produto_cliente2	= '".$produto_cliente2."',
	qtde_cliente3 		= '".$qtde_cliente3."',
	cod_cliente3		= '".$cod_cliente3."',
	produto_cliente3	= '".$produto_cliente3."',
	qtde_cliente4 		= '".$qtde_cliente4."',
	cod_cliente4		= '".$cod_cliente4."',
	produto_cliente4	= '".$produto_cliente4."',
	qtde_cliente5 		= '".$qtde_cliente5."',
	cod_cliente5		= '".$cod_cliente5."',
	produto_cliente5	= '".$produto_cliente5."',
	qtde_cliente6 		= '".$qtde_cliente6."',
	cod_cliente6		= '".$cod_cliente6."',
	produto_cliente6	= '".$produto_cliente6."'
	
	WHERE id_cliente	='".$id_clientes."'";
	

//echo $query;
//echo "<br>";
//exit();
$result	= mysql_query($query);


Header("Location: ../adm_clientes_assistencia.php");

}

?>