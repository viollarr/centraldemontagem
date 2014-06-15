<?php
header( 'Content-type: application/xml; charset="utf-8"', true );
header( 'Cache-Control: no-cache' );

require_once('config.php');

$cod_estados = mysql_real_escape_string( $_GET['cod_estados'] );

$cidades = array();


$sql = "SELECT cod_cidades, nome
		FROM cidades
		WHERE estados_cod_estados=$cod_estados
		ORDER BY nome";

$objCidades = mysql_query($sql); 

while ( $row = mysql_fetch_assoc($objCidades) ) {
	$cidades[] = array(
		'cod_cidades'	=> $row['cod_cidades'],
		'nome'			=> utf8_encode($row['nome']),
	);
}

echo( json_encode( $cidades ) );
?>