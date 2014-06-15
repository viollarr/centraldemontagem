<?php
if (isset($_POST['editar_montagem']))

{
	include"config.php";
	$id_montagem = $_POST['id_montagem'];
	$id_montador = $_POST['id_montador'];
	$vinte		 = $_POST['vinte'];
	$tabela		 = $_POST['tabela'];
	
	$quem_avalia = trim($_POST['quem_avalia']);
	$data_hora_avaliacao = date('Y-m-d H:i:s');
	
	$select_n = "SELECT * FROM ordem_montagem WHERE id_montagem = '$id_montagem'";
	$query_n = mysql_query($select_n);
	$res_n = mysql_fetch_array($query_n);
	
	$select_c = "UPDATE clientes SET id_usuario_avaliacao = '$quem_avalia', data_hora_avaliacao = '$data_hora_avaliacao' WHERE n_montagem = '".$res_n['n_montagem']."'";
	$query_c = mysql_query($select_c);
	
	$data_final  = $_POST['data_final'];
	$data_final	 = str_replace("/","-",$data_final);
	if(($data_final != 'dd-mm-aaaa')&&($data_final != '')){
		$data_final = new DateTime($data_final);  
		$data_final = $data_final->format('Y-m-d');
	
		$valida = $_POST['valida'];
		if(($valida != '')&&(strlen($valida)>0)){
			
			$comentario = $_POST['comentario'];
			
			$query	= "UPDATE ordem_montagem SET status	= '$valida', comentario	= '$comentario', porcentagem = '$vinte', wa_tabela_preco = '$tabela'	WHERE id_montagem ='$id_montagem'";
			$query_data = "UPDATE datas SET data_final = '$data_final', data_entrega_montador = '".date('Y-m-d')."' WHERE id_montagem = '$id_montagem'";
			
			$query_pre	= "DELETE FROM pre_baixas WHERE n_montagem = '".$res_n['n_montagem']."' ";
			
			$result	= mysql_query($query);
			$result_data = mysql_query($query_data);
			$result_pre = mysql_query($query_pre);
			
			
			Header("Location: ../adm_baixas.php?montador=$id_montador");
		}
		else{
			echo "<script> alert('Favor Selecione o processo da nota!');location.href='javascript:window.history.go(-1)';</script>";
		}
	}
	else{
		echo "<script> alert('Favor Preencher o campo Data da Baixa!');location.href='javascript:window.history.go(-1)';</script>";
	}
}

?>