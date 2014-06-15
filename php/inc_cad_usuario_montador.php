<?php
include "config.php"; //aqui inserimos as váriaveis da página de configuração

$ip = $_SERVER["REMOTE_ADDR"];
$ip_inicio= $ip;
$data_hora = date("y.m.d H:i:s");
$inicio=$data_hora;

#$hora = date("H:i:s");
$login = trim($_POST["login"]);
$senha = trim($_POST["senha"]);
$email = trim($_POST["email"]);
$tipo = trim($_POST["tipo"]);
$id_montador = trim($_POST["id_montador"]);

$query="SELECT * FROM $TABLE_usuarios WHERE login = '$login'";
#print "1. query: $query"; exit();
$pesquisar = mysql_query($query); 
//conferimos se o login escolhido j&aacute; N&Atilde;O foi cadastrado

if(mysql_error()){
  print("*** 1. $query ***<br>");
  print "\nMysql error:" . mysql_errno() . " : "  . mysql_error() . "<br>";
  exit();
}
#print "2. query: $query"; exit();

$contagem = mysql_num_rows($pesquisar); //traz o resultado da consulta acima

if ($contagem == 1){
	echo("<script> alert(\"Usuário j&aacute; cadastrado\"); window.location = '../cad_usuario.php'; </script>");
}
else {
	$cadastrar = mysql_query("INSERT INTO $TABLE_usuarios (inicio, ip, ip_inicio, data_hora, login, senha, email, tipo, id_montador, acesso_externo) VALUES ('$inicio', '$ip', '$ip_inicio','$data_hora', '$login',	'$senha', '$email', '$tipo', '$id_montador', 'sim')"); //insere os campos na tabela

	if(mysql_error()){
  		print("*** 2. $query ***<br>");
  		print "\nMysql error:" . mysql_errno() . " : "  . mysql_error() . "<br>";
  		exit();
	}
	if ($cadastrar == 1){ 
		echo("<script> alert(\"Cadastrado efetuado com sucesso\"); window.location = '../adm_usuarios.php'; </script>"); //se cadastrou com sucesso o usuário aparece essa mensagem
	} 
	else {
		print("*** 2. $query ***<br>");
		print "\nMysql error:" . mysql_errno() . " : "  . mysql_error() . "<br>";
		echo("<script> alert(\"Ocorreu um erro no servidor\"); window.location = '../cad_usuario.php'; </script>");  
	}
} 
?>