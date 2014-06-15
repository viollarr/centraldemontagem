<?php
session_start();
if (isset($_POST['editar_montagem']))

{
	include"config.php";
	$id_montagem	= $_POST['id_montagem'];
	$id_montador	= $_POST['id_montador'];
	$n_montagem_1	= $_POST['n_montagem'];
		
	$select_pre = "SELECT * FROM pre_baixas WHERE n_montagem = '$n_montagem_1'";
	$query_pre  = mysql_query($select_pre);
	$rows_pre = mysql_num_rows($query_pre);
	
	if($rows_pre == 0){
	$data_final  = $_POST['data_final'];
	$data_final	 = str_replace("/","-",$data_final);
	if(($data_final != 'dd-mm-aaaa')&&($data_final != '')){
		$data_final = new DateTime($data_final);  
		$data_final = $data_final->format('Y-m-d');
	
		$valida = $_POST['valida'];
		if(($valida != '')&&(strlen($valida)>0)){
			
			$comentario = $_POST['comentario'];
			
			$query	= "INSERT INTO pre_baixas (n_montagem, id_montador, data_final, data_pre, valida, comentario) VALUES ('$n_montagem_1', '$id_montador', '$data_final', '".date('Y-m-d')."', '$valida', '$comentario')";
			
			$result	= mysql_query($query);
			
			$select = "SELECT id_cliente FROM repassando_nota WHERE n_montagem = '$n_montagem_1'";
			$query_busca = mysql_query($select);
			$rows_busca = mysql_num_rows($query_busca);
			
			if($rows_busca > 0){
				while($result_busca = mysql_fetch_array($query_busca)){
					$up_notas_montador = "UPDATE repassando_nota SET imprimir = '0'	WHERE id_cliente='".$result_busca['id_cliente']."'";
					$up_notas = mysql_query($up_notas_montador);
				}
			}
			
			if($_SESSION['tipo'] == 5){
				Header("Location: ../admim_baixa_montador.php");
			}
			else{
				Header("Location: ../admim_pre_baixas.php");
			}
			
		}
		else{
			echo "<script> alert('Favor Selecione o processo da nota!');location.href='javascript:window.history.go(-1)';</script>";
		}
	}
	else{
		echo "<script> alert('Favor Preencher o campo Data da Baixa!');location.href='javascript:window.history.go(-1)';</script>";
	}
  }
  else{
	echo "<script> alert('Esta nota já foi pré avaliada!');location.href='javascript:window.history.go(-1)';</script>";	
  }
}

?>