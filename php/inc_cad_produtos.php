<?php

include "config.php";



$cod_produto	= $_POST['cod_produto'];

$nome_produto	= $_POST['nome_produto'];

$id_precos		= $_POST['modelo'];



$pesquisar = mysql_query("SELECT * FROM produtos WHERE (cod_produto = '$cod_produto' OR modelo = '$nome_produto') "); //conferimos se o login escolhido já não foi cadastrado

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima



if ( $contagem == 1 ) {

  echo("<script>

      alert(\"Produto já cadastrado\");

      window.location = '../cad_produtos.php';

      </script>");

	  exit;

} else {

	if((strlen($cod_produto)>0) and (strlen($nome_produto)>0) and ($id_precos != "")){



		$insert = "INSERT INTO produtos (cod_produto, modelo, id_preco) VALUES ('".$cod_produto."', '".$nome_produto."', '".$id_precos."')";

		

		$cadastrar = mysql_query($insert);

		

		Header("Location: ../cad_produtos.php");

	}

	else{

		echo "<script> alert('Erro! Verifique um dos itens abaixo:\\n\\n - Campo Cod. Produto.\\n - Campo Nome.\\n - Campo Modelo.\\n ');location.href='javascript:window.history.go(-1)'; </script>";

	}

}

?>

