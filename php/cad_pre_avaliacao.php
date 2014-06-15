<?php

if (isset($_POST['editar_pre_avaliacao']))

{
	include"config.php";
	$acompanhamento = $_POST['acompanhamento'];
	$id_cliente = $_POST['id_cliente'];
	$n_montagem = $_POST['n_montagem'];
	
	$query	= "
		UPDATE acompanhamento SET 
		status = '".$acompanhamento."' 
		
		WHERE id_cliente='".$id_cliente."'";
	//echo $query;
	$result	= mysql_query($query);
	
	if($acompanhamento == "concluido"){
		header("Location: ../admim_baixa_montador.php?n_montagem=".$n_montagem);
	}
	else{
		header("Location: ../adm_clientes_montador.php");
	}

}

?>