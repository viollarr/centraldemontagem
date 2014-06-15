<?php

include "config.php";



$nome	= $_POST['nome_comp'];

$ad		= $_POST['admissao'];

$de		= $_POST['demissao'];

$rota	= $_POST['rota'];

$id_empresa = $_POST['empresa'];

$nome_c	= $_POST['nome_conta'];

$agencia= $_POST['agencia'];

$conta	= $_POST['conta'];

$banco	= $_POST['banco'];

$cpf	= $_POST['cpf'];

$dataNascimento	= $_POST['dataNascimento'];

$rg		= $_POST['rg'];

$cep	= $_POST['cep'];

$rua	= $_POST['rua'];

$numero	= $_POST['numero'];

$comp	= $_POST['comp'];

$bairro	= $_POST['bairro'];

$cidade	= $_POST['cidade'];

$estado	= $_POST['estado'];

$tel	= '('.$_POST['codigo'].')'.$_POST['res'];

$cel	= '('.$_POST['codigo2'].')'.$_POST['cel'];

$email	= $_POST['email'];

$observacao = $_POST['observacao'];

$ctpsserie = $_POST['ctpsserie'];
$ctpsnumero = $_POST['ctpsnumero'];
$ctpsuf = $_POST['ctpsuf'];
$id_responsavel = $_POST['id_responsavel'];




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

	

	$foto = str_replace($acento,$semacento,$formulario['name']);

	

	$pdf = $foto;

	//echo $pdf;

	if($pdf == ""){

		echo "<script> alert('Por favor selecione uma foto.');location.href='javascript:window.history.go(-1)'; </script>";

		exit();

	}

	$caminho1=$dir.$pdf;

	$arq=$formulario['tmp_name'];

if(!move_uploaded_file($arq,$caminho1))

	{

		echo "<script> alert('Erro ao enviar arquivo $arq para $caminho1 !');location.href='javascript:window.history.go(-1)'; </script>";

		$cadastra_nome_foto 	= "";

		$cadastra_foto			= "";

		exit();

	}

	if($pdf != ""){

		$cadastra_nome_foto 	= "foto,";

		$cadastra_foto			= "'$pdf',";

	}

}







$atendimento2 = $_POST['atendimento'];

$rows = count($atendimento2);

for($i=0;$i<$rows;$i++){

	$atendimento .= $atendimento2[$i].';';

}



$pesquisar = mysql_query("SELECT * FROM montadores WHERE (cpf = '$cpf' AND nome = '$nome') "); //conferimos se o login escolhido j&aacute; N&Atilde;O foi cadastrado

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima



if ( $contagem == 1 ) {

  echo("<script>

      alert(\"Montador j&aacute; cadastrado\");

      window.location = '../cad_montadores.php';

      </script>");

	  exit;

} else {



$insert = "INSERT INTO montadores (id_empresa, id_responsavel, nome, admissao, demissao, $cadastra_nome_foto rota, nome_conta, ag, conta, banco, ctpsserie, ctpsnumero, ctpsuf, cpf, rg, data_nascimento, comentario, cep, rua, numero, comp, bairro, cidade, estado, telefone, celular, email, atendimento) VALUES ('".$id_empresa."', '".$id_responsavel."', '".$nome."', '".$ad."', '".$de."', $cadastra_foto '".$rota."', '".$nome_c."', '".$agencia."', '".$conta."', '".$banco."', '".$ctpsserie."', '".$ctpsnumero."', '".$ctpsuf."', '".$cpf."', '".$rg."', '".$dataNascimento."', '".$observacao."', '".$cep."', '".$rua."', '".$numero."', '".$comp."', '".$bairro."', '".$cidade."', '".$estado."', '".$tel."', '".$cel."', '".$email."', '".$atendimento."')";

//echo $insert;

$cadastrar = mysql_query($insert) or die ("SQL => ".$insert." <br>mysql_erro = ".mysql_error());



Header("Location: ../adm_montadores.php");

	

}

?>