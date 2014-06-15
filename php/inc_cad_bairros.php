<?php

include "config.php";



$nome_bairro = utf8_decode(trim($_POST['nome_bairro']));



$pesquisar = mysql_query("SELECT * FROM bairros WHERE nome = '$nome_bairro'"); //conferimos se o login escolhido j&aacute; N&Atilde;O foi cadastrado

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima



if ( $contagem == 1 ) {

  echo("<script>

      alert(\"Bairro j&aacute; cadastrado\");

      window.location = '../cad_bairros.php';

      </script>");

	  exit;

} else {



$cadastrar = mysql_query("INSERT INTO bairros (nome) VALUES ('$nome_bairro')");



Header("Location: ../adm_bairros.php");

	

}

?>