<?php


if (isset($_POST['editar_usuario']))

{
include"config.php";
$id = $_POST['id_usuario'];
$ip = $_SERVER["REMOTE_ADDR"];
$data = date("Y-m-d H:i:s");
$hora = date("H:i:s");
$tipo  = $_POST["tipo"];
$email = $_POST["email"];
$login = $_POST["login"];
$senha = $_POST["senha"];
$nome = $_POST["nome"];


$filtro = '';
if(!empty($_POST['acesso_externo'])){
	$filtro .= ", acesso_externo = '".$_POST['acesso_externo']."'"; 	
}

$query	= "
	UPDATE usuarios SET 
	ip = '".$ip."',
	data_hora = '" . $data;	# . "',

	#hora = '".$hora."',
	$query .= " $hora'" . ", 
	tipo  = '".$tipo."',
	email = '".$email."',
	login = '".$login."', 
	senha = '".$senha."',
	nome = '".$nome."' 
	$filtro
	WHERE id='".$id."'";

$result	= mysql_query($query);
#print "query: $query <br>"; exit();

Header("Location: ../adm_usuarios.php");

}

?>
