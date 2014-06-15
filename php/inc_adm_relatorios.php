<?php
include ("config.php");

$dia =date("d");
$mes =date("m");
$ano =date("Y");
$data =$dia."/".$mes."/".$ano;

$estado = $_POST['estado'];
$cidade = $_POST['cidade']; 
$bairro = $_POST['bairro'];

$filtros = "";
$cidadeCorreto = "";
$estadoCorreto = "";
$bairroCorreto = "";
$filtrando = false;

if(!empty($estado)){
	$filtros .= "AND c.estado_cliente = '$estado' ";
	
	$select_estados = "SELECT sigla FROM estados WHERE cod_estados = '$estado'";
	$query_estados = mysql_query($select_estados);
	$a = mysql_fetch_array($query_estados);
	$estadoCorreto .= $a["sigla"];
	
	$filtrando = true;
}
if(!empty($cidade)){
	$select_cidades = "SELECT nome FROM cidades WHERE cod_cidades = '$cidade'";
	$query_cidades = mysql_query($select_cidades);
	$y = mysql_fetch_array($query_cidades);

	if(strlen($filtros)>2){
		$filtros .= "AND c.cidade_cliente = '$cidade' ";
		$cidadeCorreto .= ' - '.strtoupper(strtr(strtoupper(utf8_encode(strtoupper($y['nome']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	else{
		$filtros .= "c.cidade_cliente = '$cidade' ";
		$cidadeCorreto .= strtoupper(strtr(strtoupper(utf8_encode(strtoupper($y['nome']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"));
	}
	$filtrando = true;	
}
if(!empty($bairro)){
	if(strlen($filtros)>2){
		$filtros .= "AND c.bairro_cliente = '$bairro' ";
		$bairroCorreto .= ' - '.$bairro;
	}
	else{
		$filtros .= "c.bairro_cliente = '$bairro' ";
		$bairroCorreto .= $bairro;
	}
	$filtrando = true;
}


$relat = $_POST['relat'];
if(!empty($_POST['data_inicio'])){
	$data_inicio = explode("/",$_POST['data_inicio']);
	$data_inicio = $data_inicio[2]."-".$data_inicio[1]."-".$data_inicio[0];
}
else{
	$data_inicio = "";	
}

if(!empty($_POST['data_final'])){
	$data_fim = explode("/",$_POST['data_final']);
	$data_fim = $data_fim[2]."-".$data_fim[1]."-".$data_fim[0];
}
else{
	$data_fim = "";	
}
$ativo = 0;

if($relat == "0"){
//$condicao = "d.data_faturamento >= '$data_inicio' AND d.data_faturamento <= '$data_fim'";
$condicao = "d.data_recebimento >= '$data_inicio' AND d.data_recebimento <= '$data_fim'";
$m_nome = "";
$m_database = "";
$nome_montador = "";
$td = "";
$colspan = '8';
}

else{
$condicao = "d.data_final >= '$data_inicio' AND d.data_final <= '$data_fim'";
$m_nome = "m.nome,";
$m_database = "montadores m,";
$nome_montador = "AND m.id_montadores = o.id_montador";
$td = "<td align='center' bgcolor='#F2F2F2'><b>Montador</b></td>";
$colspan = '9';
}


if ((strlen($relat)>0)&&(!empty($data_inicio))&&(!empty($data_fim))){



		$SQL = "
		SELECT 
			$m_nome 
			c.nome_cliente, 
			c.orcamento, 
			d.*, 
			o.* 
		FROM 
			$m_database 
			clientes c, 
			datas d, 
			ordem_montagem o 
		WHERE 
			o.status = '$relat' AND 
			($condicao) AND 
			(
				o.n_montagem = d.n_montagens 
				$nome_montador AND 
				c.n_montagem = d.n_montagens 
			) AND 
			c.ativo='$ativo'
			$filtros
		ORDER BY 
			o.n_montagem ASC";

		echo $SQL;

		$executa = mysql_query($SQL)or die(mysql_error());

		// montando a tabela
		echo "<table border='0' width='100%' align='center'>

				  <tr>

				   <td colspan='$colspan' align='center'>

						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>

				   </td>

				  </tr>";

		echo "</table>";

		echo "<table border='0' width='900' cellspacing='1' bgcolor='#000000'>

				<tr>

				  <td bgcolor='#F2F2F2' colspan='$colspan' align='left'><b></b>";

				  ?>

				   <form action="down_notas.php" method="post" style="text-align:center;">
					  <input type="submit" value="Download" />
					  <input type="hidden" name="relat" value="<?=$relat?>"/>
                      <input type="hidden" name="data_inicio" value="<?=$data_inicio?>"/>
                      <input type="hidden" name="data_fim" value="<?=$data_fim?>"/>
					  <input type="hidden" name="estado" value="<?=$estado?>"/>
                      <input type="hidden" name="cidade" value="<?=$cidade?>"/>
                      <input type="hidden" name="bairro" value="<?=$bairro?>"/>
				  </form>

				  <?php

				  echo "".$data." ";
				  echo ($filtrando)? 'Filtros: '.$estadoCorreto.$cidadeCorreto.$bairroCorreto:'';
				  echo "</td>

				</tr>

				<tr>

				  <td bgcolor='#F2F2F2'><b>Quant</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Nota</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Pedido</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Cliente</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Data Recebimento</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Data Entrega</b></td>

				  $td

				  <td align='center' bgcolor='#F2F2F2'><b>Status</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Comentarios</b></td>

			   </tr>";

		$i=1;

		while ($rs = mysql_fetch_array($executa)){

		            

			if($rs[status] == 1){$status = "<img src='images/tools.png' border='0' />";}

			elseif($rs[status] == 2){$status = "<img src='images/ampulheta.gif' border='0' align='absbottom' />";}

			elseif($rs[status] == 3){$status = "<img src='images/tick.png' border='0' />";}

			elseif($rs[status] == 4){$status = "<img src='images/ico_excluir.jpg' border='0' />";}

			elseif($rs[status] == 5){$status = "<img src='images/justice.png' border='0' />";}
			
			elseif($rs[status] == 10){$status = "<img src='images/justiceNo.png' border='0' />";}

			elseif($rs[status] == 6){$status = "<img src='images/ausente.png' border='0' width='24' />";}
			
			elseif($rs[status] == 7){$status = "<img src='images/verificar.png' border='0' />";}
			
			elseif($rs[status] == 8){$status = "<img src='images/tecnica.png' border='0' />";}
			
			elseif($rs[status] == 11){$status = "<img src='images/verificarNo.png' border='0' />";}
			
			elseif($rs[status] == 12){$status = "<img src='images/tecnicaNo.png' border='0' />";}
			

			

			$data_faturamento = new DateTime($rs[data_recebimento]);  

			$data_faturamento = $data_faturamento->format('d/m/Y');

			

			if($rs[data_final] != '0000-00-00'){

				$data_final = new DateTime($rs[data_final]);  

				$data_final = $data_final->format('d/m/Y');

			}

			else{

				$data_final = 'N&Atilde;O DEFINIDO';

			}

			

			if($relat == "0"){

			$vis_nome = "";

			}

			else{

			$vis_nome = "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>".$rs[nome]."</td>";

			}

			

			

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$i</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[nome_cliente]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_faturamento</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";

				echo "$vis_nome";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$status</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[comentario]</td>";

			echo "</tr>";

			$i++;

		}

		  echo "<tr>

				  <td colspan='$colspan' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b>AV. CORONEL PHIDIAS TÁVORA, PAVUNA - RIO DE JANEIRO - RJ - BRASIL<br></b><br>
				  </td>
				</tr>  

		</table> 

		<table border='0' width='100%'>

				  <tr>

				   <td colspan='$colspan' align='center'>

						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>

				   </td>

				  </tr>";

		echo "</table>";

}else{

  echo "<script> alert('Por Favor! Selecione um tipo para gerar o relat贸rio');location.href='javascript:window.history.go(-1)'; </script>";

}

?>