<?php

if (isset($_POST['editar_clientes']))

{
include"config.php";

$empresa				= $_POST['empresa'];
$prioridade 			= $_POST['prioridade'];
$tipo_cadastro 			= $_POST['tipo'];
$quem_modifica			= trim($_POST['quem_modifica']);
$data_hora_modificacao	= date('Y-m-d H:i:s');
$id_clientes 			= $_POST['id_clientes'];
$n_montagem				= $_POST['n_montagem'];
$cod_loja				= $_POST['cod_loja'];
$orcamento				= $_POST['orcamento'];
$notaFiscal				= $_POST['notaFiscal'];
$vendedor				= utf8_decode($_POST['vendedor']);
$data					= $_POST['data_faturamento'];
$data_explode			= explode('/',$data);
$ano					= $data_explode[2];
$mes					= $data_explode[1];
$dia					= $data_explode[0];
$data_faturamento		= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];

// DATA RECEBIMENTO

$data2					= $_POST['data_recebimento'];
$data_explode2			= explode('/',$data2);
$ano2					= $data_explode2[2];
$mes2					= $data_explode2[1];
$dia2					= $data_explode2[0];
$data_recebimento		= $data_explode2[2].'-'.$data_explode2[1].'-'.$data_explode2[0];

include "funcao_data_limite.php";
$d3 = $dia2."/".$mes2."/".$ano2;

$DataInicial = "$d3";
$QtdDia = 7;
$diasSomados = SomaDiasUteis($DataInicial,$QtdDia);

$d4 = explode('/',$diasSomados );
$data_3 = $d4[2]."-".$d4[1]."-".$d4[0];

//FIM

$nome_cliente			= utf8_decode($_POST['nome_cliente']);
$cep					= $_POST['cep'];
$rua					= utf8_decode($_POST['rua']);
$numero					= $_POST['numero'];
$comp					= utf8_decode($_POST['comp']);
if($_POST['bairro'] != ""){
$bairro					= strtoupper(strtr(strtoupper(utf8_decode(strtoupper(trim($_POST['bairro'])))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
}
$cidade					= $_POST['cidade'];
$estado					= $_POST['estado'];
$res					= $_POST['res'];
$res2					= $_POST['res2'];
$res3					= $_POST['res3'];
$referencia_cliente		= utf8_decode($_POST['referencia_cliente']);
$comentario_c			= $_POST['comentario_c'];
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

$qtde_cliente7			= $_POST['qtde_cliente7'];
$cod_cliente7			= $_POST['cod_cliente7'];
$produto_cliente7		= $_POST['produto_cliente7'];

$qtde_cliente8			= $_POST['qtde_cliente8'];
$cod_cliente8			= $_POST['cod_cliente8'];
$produto_cliente8		= $_POST['produto_cliente8'];

$qtde_cliente9			= $_POST['qtde_cliente9'];
$cod_cliente9			= $_POST['cod_cliente9'];
$produto_cliente9		= $_POST['produto_cliente9'];

$qtde_cliente10			= $_POST['qtde_cliente10'];
$cod_cliente10			= $_POST['cod_cliente10'];
$produto_cliente10		= $_POST['produto_cliente10'];

$qtde_cliente11			= $_POST['qtde_cliente11'];
$cod_cliente11			= $_POST['cod_cliente11'];
$produto_cliente11		= $_POST['produto_cliente11'];

$qtde_cliente12			= $_POST['qtde_cliente12'];
$cod_cliente12			= $_POST['cod_cliente12'];
$produto_cliente12		= $_POST['produto_cliente12'];

$qtde_cliente13			= $_POST['qtde_cliente13'];
$cod_cliente13			= $_POST['cod_cliente13'];
$produto_cliente13		= $_POST['produto_cliente13'];

$qtde_cliente14			= $_POST['qtde_cliente14'];
$cod_cliente14			= $_POST['cod_cliente14'];
$produto_cliente14		= $_POST['produto_cliente14'];

$qtde_cliente15			= $_POST['qtde_cliente15'];
$cod_cliente15			= $_POST['cod_cliente15'];
$produto_cliente15		= $_POST['produto_cliente15'];

$qtde_cliente16			= $_POST['qtde_cliente16'];
$cod_cliente16			= $_POST['cod_cliente16'];
$produto_cliente16		= $_POST['produto_cliente16'];

$qtde_cliente17			= $_POST['qtde_cliente17'];
$cod_cliente17			= $_POST['cod_cliente17'];
$produto_cliente17		= $_POST['produto_cliente17'];

$qtde_cliente18			= $_POST['qtde_cliente18'];
$cod_cliente18			= $_POST['cod_cliente18'];
$produto_cliente18		= $_POST['produto_cliente18'];

$qtde_cliente19			= $_POST['qtde_cliente19'];
$cod_cliente19			= $_POST['cod_cliente19'];
$produto_cliente19		= $_POST['produto_cliente19'];

$qtde_cliente20			= $_POST['qtde_cliente20'];
$cod_cliente20			= $_POST['cod_cliente20'];
$produto_cliente20		= $_POST['produto_cliente20'];

$select_cliente = "SELECT * FROM clientes WHERE id_cliente = '$id_clientes'";
$query_cliente = mysql_query($select_cliente);
$a = mysql_fetch_array($query_cliente);

$select_data = "UPDATE datas SET n_montagens = '$n_montagem', data_faturamento = '$data_faturamento', data_recebimento = '$data_recebimento', data_limite = '$data_3' WHERE n_montagens = '$a[n_montagem]'";
$query_data = mysql_query($select_data);
$select_ordem = "UPDATE ordem_montagem SET n_montagem = '$n_montagem' WHERE n_montagem = '$a[n_montagem]'";
$query_ordem = mysql_query($select_ordem);

$query	= "
	UPDATE clientes SET 
	id_empresa			= '".$empresa."',
	prioridade			= '".$prioridade."',
	tipo	 			= '".$tipo_cadastro."', 
	n_montagem 			= '".$n_montagem."', 
	cod_loja 			= '".$cod_loja."',
	orcamento 			= '".$orcamento."',
	nota_fiscal			= '".$notaFiscal."',
	vendedor 			= '".$vendedor."',
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
	comentario_c		= '".$comentario_c."',
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
	produto_cliente6	= '".$produto_cliente6."',
	qtde_cliente7 		= '".$qtde_cliente7."',
	cod_cliente7		= '".$cod_cliente7."',
	produto_cliente7	= '".$produto_cliente7."',
	qtde_cliente8 		= '".$qtde_cliente8."',
	cod_cliente8		= '".$cod_cliente8."',
	produto_cliente8	= '".$produto_cliente8."',
	qtde_cliente9 		= '".$qtde_cliente9."',
	cod_cliente9		= '".$cod_cliente9."',
	produto_cliente9	= '".$produto_cliente9."',
	qtde_cliente10 		= '".$qtde_cliente10."',
	cod_cliente10		= '".$cod_cliente10."',
	produto_cliente10	= '".$produto_cliente10."',
	qtde_cliente11 		= '".$qtde_cliente11."',
	cod_cliente11		= '".$cod_cliente11."',
	produto_cliente11	= '".$produto_cliente10."',
	qtde_cliente12 		= '".$qtde_cliente12."',
	cod_cliente12		= '".$cod_cliente12."',
	produto_cliente12	= '".$produto_cliente10."',
	qtde_cliente13 		= '".$qtde_cliente13."',
	cod_cliente13		= '".$cod_cliente13."',
	produto_cliente13	= '".$produto_cliente10."',
	qtde_cliente14 		= '".$qtde_cliente14."',
	cod_cliente14		= '".$cod_cliente14."',
	produto_cliente14	= '".$produto_cliente10."',
	qtde_cliente15 		= '".$qtde_cliente15."',
	cod_cliente15		= '".$cod_cliente15."',
	produto_cliente15	= '".$produto_cliente10."',
	qtde_cliente16 		= '".$qtde_cliente16."',
	cod_cliente16		= '".$cod_cliente16."',
	produto_cliente16	= '".$produto_cliente10."',
	qtde_cliente17 		= '".$qtde_cliente17."',
	cod_cliente17		= '".$cod_cliente17."',
	produto_cliente17	= '".$produto_cliente10."',
	qtde_cliente18 		= '".$qtde_cliente18."',
	cod_cliente18		= '".$cod_cliente18."',
	produto_cliente18	= '".$produto_cliente10."',
	qtde_cliente19 		= '".$qtde_cliente19."',
	cod_cliente19		= '".$cod_cliente19."',
	produto_cliente19	= '".$produto_cliente10."',
	qtde_cliente20 		= '".$qtde_cliente20."',
	cod_cliente20		= '".$cod_cliente20."',
	produto_cliente20	= '".$produto_cliente20."',

	id_usuario_modificacao = '".$quem_modifica."',
	data_hora_modificacao  = '".$data_hora_modificacao."'
	
	
	WHERE id_cliente	='".$id_clientes."'";
	

//echo $query;
//echo "<br>";
//exit();
$result	= mysql_query($query);

##################################################################################################################
include"../classe/Log.class.php";
$select_mod = "SELECT * FROM usuarios WHERE id = '$quem_modifica'";
$query_mod = mysql_query($select_mod);
$result_mod = mysql_fetch_array($query_mod);

$grava_entrada = "";
foreach($_POST AS $entrada){
	$grava_entrada .= $entrada." => ";
}
$objLog = new Log();
$objLog->grava(" ");
$objLog->grava("ALTERAÇÃO DE CLIENTE");
$objLog->grava('POST => "'.$result_mod['login'].'" Data => "'.date('Y-m-d H:i:s').'", Alterou o Cliente de vale '.$n_montagem.' => "INFORMAÇÕES ALTERADAS => "'.$grava_entrada.'"');

###################################################################################################################

echo "<script>location.href=' ../adm_clientes.php';</script>";
//Header("Location: ../adm_clientes.php");

}

?>