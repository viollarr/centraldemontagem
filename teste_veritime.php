<?php

$login = $_POST['login'];
$senha = $_POST['senha'];
$arrayRetorno[] = array("campor1" => "$login", "campor2"=>"$senha", "campor3"=>"valor3");

$json["retorno"] = $arrayRetorno;

echo json_encode($json);
?>