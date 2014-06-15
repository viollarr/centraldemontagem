<?php

if (isset($_POST['editar_montadores']))



{



include"config.php";



$id_montadores = $_POST['id_montadores'];





$nome	= $_POST['nome_comp'];

$ad		= $_POST['admissao'];

$de		= $_POST['demissao'];

$rota	= $_POST['rota'];

$nome_c	= $_POST['nome_conta'];

$agencia= $_POST['agencia'];

$conta	= $_POST['conta'];

$banco	= $_POST['banco'];

$cpf	= $_POST['cpf'];

$rg		= $_POST['rg'];

$cep	= $_POST['cep'];

$rua	= $_POST['rua'];

$numero	= $_POST['numero'];

$comp	= $_POST['comp'];

$bairro	= $_POST['bairro'];

$cidade	= $_POST['cidade'];

$estado	= $_POST['estado'];

$tel	= $_POST['res'];

$cel	= $_POST['cel'];

$email	= $_POST['email'];

$observacao = $_POST['observacao'];



if(isset($ad)){

	$ad = explode("/",$ad);

	$ad = $ad[2]."-".$ad[1]."-".$ad[0];

}

if(isset($de)){

	$de = explode("/",$de);

	$de = $de[2]."-".$de[1]."-".$de[0];

}





if($_FILES["foto"]["name"] != ""){

	$acento = array("À", "Á", "Ã", "Â", "É", "Ê", "Í", "Ó", "Õ", "Ô", "Ú", "Ü", "Ç", "à", "á", "ã", "â", "é", "ê", "í", "ó", "õ", "ô", "ú", "ü", "ç", "A", "E", "I", "O", "U", "/", " ");

	$semacento=array("a", "a", "a", "a", "e", "e", "i", "o", "o", "o", "u", "u", "c", "a", "a", "a", "a", "e", "e", "i", "o", "o", "o", "u", "u", "c", "a", "e", "i", "o", "u", "", "");

	$formulario 	= $_FILES["foto"];

	$dir="../foto/";

	//echo $formulario['name'];

	//exit();

	$foto = str_replace($acento,$semacento,$formulario['name']);

	

	//echo "foto => ".$foto;

	//exit();

	

	$pdf = $foto;

	//echo $pdf;

	if($pdf == ""){

		echo "<script> alert('Por favor selecione uma foto.');location.href='javascript:window.history.go(-1)'; </script>";

		exit();

	}

	$caminho1=$dir.$pdf;

	//echo $caminho1;

	//exit();

	$arq=$formulario['tmp_name'];

if(!move_uploaded_file($arq,$caminho1))

	{

		echo "<script> alert('Erro ao enviar arquivo $arq para $caminho1 !');location.href='javascript:window.history.go(-1)'; </script>";

		$cadastra_foto			= "";

		exit();

	}

	if($pdf != ""){

		$cadastra_foto 	= ", foto	= '$pdf'";

	}

}



$select_montadores = "SELECT * FROM montadores WHERE id_montadores = '".$id_montadores."'";

$query_montadores  = mysql_query($select_montadores);

$res_montadores	   = mysql_fetch_array($query_montadores);

$montagens = $res_montadores['n_montagens'];





if(strlen($_POST['atendimento'])>0){



	$atendimento2 = $_POST['atendimento'];

	$rows = count($atendimento2);

	for($i=0;$i<$rows;$i++){

		$atendimento .= $atendimento2[$i].';';

	}

	$aten = ", atendimento = '".$atendimento."' ";

}

else{

	$aten = '';

}

if(strlen($_POST['n_montagens'])>0){



	$n_montagens2 = $_POST['n_montagens'];

	$rows = count($n_montagens2);

	for($i=0;$i<$rows;$i++){

		$n_montagens .= $n_montagens2[$i].';';

	}

	$mont = ", n_montagens = '".$montagens.$n_montagens."' ";

}

else{

	$mont = '';

}



$query	= "

	UPDATE montadores SET 

	nome 	= '".$nome."', 

	admissao= '".$ad."',

	demissao= '".$de."',

	rota	= '".$rota."',

	nome_conta	= '".$nome_c."',

	banco	= '".$banco."',

	ag		= '".$agencia."',

	conta	= '".$conta."',

	cpf 	= '".$cpf."',

	rg		= '".$rg."',

	cep 	= '".$cep."',

	rua 	= '".$rua."',

	numero 	= '".$numero."',

	comp 	= '".$comp."',

	bairro 	= '".$bairro."',

	cidade 	= '".$cidade."',

	estado 	= '".$estado."',

	telefone= '".$tel."',

	celular	= '".$cel."',

	comentario='".$observacao."',

	email 	= '".$email."'

	".$cadastra_foto."

	".$aten."

	".$mont."		

	WHERE id_montadores='".$id_montadores."'";



	//echo $query;

	//exit();

	$result	= mysql_query($query) or die ("SQL => ".$query." <br>mysql_erro = ".mysql_error());



for($i=0;$i<$rows;$i++){



$query_montagem  = "UPDATE ordem_montagem SET id_montador = '".$id_montadores."', status = '2' WHERE id_montagem = '".$n_montagens2[$i]."'";

$result_montagem = mysql_query($query_montagem);

}



for($i=0;$i<$rows;$i++){



$select_ordem_montagem = "SELECT * FROM ordem_montagem WHERE id_montagem = '".$n_montagens2[$i]."'";

$query_ordem_montagem  = mysql_query($select_ordem_montagem);

$result_ordem_montagem = mysql_fetch_array($query_ordem_montagem);



$query_datas	= "UPDATE datas SET data_saida_montador = '".date('Y-m-d')."', id_montagem = '".$n_montagens2[$i]."' WHERE n_montagens = '".$result_ordem_montagem['n_montagem']."'";

$result_datas 	= mysql_query($query_datas);



}



Header("Location: ../adm_montadores.php");



}



?>