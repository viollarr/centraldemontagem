<?php
if (isset($_POST['editar_notas']))

{
include"config.php";
$repassar 		= $_POST['repassar'];
$id_montagem	= $_POST['id_montagem'];
$n_montagem		= $_POST['n_montagem'];
$montador 		= $_POST['montador'];
$montador_antigo= $_POST['montador_antigo'];
$agendamento	= $_POST['agendamento'];
$data_explode	= explode('/',$agendamento);
$data_agendamento	= $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];
$hora		 	= $_POST['hora'];

if($repassar == '1'){
	include "repassando_nota.php";
}


if($_POST['status'] == 3){
	$status = $_POST['status'];
}
else{
	$status = 0;
}

if(strlen($montador)>0){
	if($montador == "NENHUM"){
		//APAGA OS DADOS DE MONTAGENS DO MONTADOR ANTIGO
		$retirar_nota_montador = "SELECT * FROM montadores WHERE id_montadores = '".$montador_antigo."'";
		$query_retira = mysql_query($retirar_nota_montador);
		$result_retira = mysql_fetch_array($query_retira);
		$n_montagens_antiga = $result_retira[n_montagens];
		
		$apagar_notas_montador = $id_montagem.';';
		
		$n_montagens_nova = str_replace($apagar_notas_montador,"",$n_montagens_antiga);
		
		$up = "UPDATE montadores SET n_montagens = '".$n_montagens_nova."' WHERE id_montadores = '".$montador_antigo."'";
		$query_up = mysql_query($up);
		
		$up_ordem_m  = "UPDATE ordem_montagem SET id_montador = '0', status = '$status' WHERE id_montagem = '".$id_montagem."'";
		$up_query_m	 = mysql_query($up_ordem_m);
		
		$up = "UPDATE datas SET data_saida_montador = '0000-00-00', data_final = '0000-00-00', data_entrega_montador = '0000-00-00', id_montagem = '0' WHERE n_montagens = '".$n_montagem."'";
		$query_up = mysql_query($up);	
	}
	else{
	$select_montador = "SELECT * FROM montadores WHERE id_montadores = '".$montador."'";
	$query_montador  = mysql_query($select_montador);
	$result_montador = mysql_fetch_array($query_montador);
	$id_montador	 = $result_montador[id_montadores];
	$n_montagem_mont = $result_montador[n_montagens];
	$nome_montador   = $result_montador[nome];
	
	$apagar_notas_montador = $id_montagem.';';
	
	if($montador != $montador_antigo){
	
		//APAGA OS DADOS DE MONTAGENS DO MONTADOR ANTIGO
		$retirar_nota_montador = "SELECT * FROM montadores WHERE id_montadores = '".$montador_antigo."'";
		$query_retira = mysql_query($retirar_nota_montador);
		$result_retira = mysql_fetch_array($query_retira);
		$n_montagens_antiga = $result_retira[n_montagens];
		
		$n_montagens_nova = str_replace($apagar_notas_montador,"",$n_montagens_antiga);
		
		$up = "UPDATE montadores SET n_montagens = '".$n_montagens_nova."' WHERE id_montadores = '".$montador_antigo."'";
		$query_up = mysql_query($up);	

		if($n_montagem_mont == ""){
			$n_montagens_up = $id_montagem.';';
			
		}
		else{
			$n_montagens_up = $n_montagem_mont.$id_montagem.';';
			
		}		
		//ADICIONA OS DADOS NO NOVO MONTADOR
		$up_montador = "UPDATE montadores SET n_montagens = '".$n_montagens_up."' WHERE id_montadores = '".$id_montador."'";
		//echo $up_montador."<br>";
		$up_ordem_m  = "UPDATE ordem_montagem SET id_montador = '".$montador."', status = '2' WHERE id_montagem = '".$id_montagem."'";
		//echo $up_ordem_m."<br>";
		$up_query	 = mysql_query($up_montador);
		$up_query_m	 = mysql_query($up_ordem_m);
	
		$data_correta = date("Y-m-d");
	
		$query	= "
			UPDATE datas SET 
			data_saida_montador  = '".$data_correta."',
			id_montagem	= '".$id_montagem."'
			WHERE n_montagens ='".$n_montagem."'";
		//echo $query;
		//exit();
		$result	= mysql_query($query);
	
	}
  }
}

if(($agendamento != "dd/mm/aaaa")and(strlen($hora)>0)){
	$query	= "
		UPDATE datas SET 
		agendamento  = '".$data_agendamento."',
		hora_agendamento = '".$hora."'
		
		WHERE n_montagens ='".$n_montagem."'";
	$result	= mysql_query($query);
}

Header("Location: ../adm_notas.php");

}

?>