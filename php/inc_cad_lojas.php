<?php

include "config.php";



$nome_loja		= $_POST['nome_loja'];

$cod_loja		= $_POST['cod_loja'];

$gerente_loja	= $_POST['gerente_loja'];

$tel_loja		= $_POST['tel_loja'];

$tel2_loja		= $_POST['tel2_loja'];

$tel3_loja		= $_POST['tel3_loja'];

$tel4_loja		= $_POST['tel4_loja'];

$email_loja		= $_POST['email_loja'];



$pesquisar = mysql_query("SELECT * FROM lojas WHERE (cod_loja = '$cod_loja' OR nome_loja = '$nome_loja') "); //conferimos se o login escolhido j&aacute; N&Atilde;O foi cadastrado

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima



if ( $contagem == 1 ) {

  echo("<script>

      alert(\"Loja j&aacute; cadastrada\");

      window.location = '../cad_lojas.php';

      </script>");

	  exit;

} else {



$insert = "INSERT INTO lojas (cod_loja, nome_loja, gerente_loja, tel_loja, tel2_loja, tel3_loja, tel4_loja, email_loja) VALUES ('".$cod_loja."', '".$nome_loja."', '".$gerente_loja."', '".$tel_loja."', '".$tel2_loja."', '".$tel3_loja."', '".$tel4_loja."', '".$email_loja."')";



$cadastrar = mysql_query($insert);



Header("Location: ../cad_lojas.php");

	

}

?>

