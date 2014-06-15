<?php

//Conexão ao Banco de dados local

include "php/config.php";

$relat = $_POST['relat'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];

$estado = $_POST['estado'];
$cidade = $_POST['cidade']; 
$bairro = $_POST['bairro'];

$filtros = "";

if(!empty($estado)){
	$filtros .= "AND c.estado_cliente = '$estado' ";
}
if(!empty($cidade)){
	if(strlen($filtros)>2){
		$filtros .= "AND c.cidade_cliente = '$cidade' ";
	}
	else{
		$filtros .= "c.cidade_cliente = '$cidade' ";
	}
}
if(!empty($bairro)){
	if(strlen($filtros)>2){
		$filtros .= "AND c.bairro_cliente = '$bairro' ";
	}
	else{
		$filtros .= "c.bairro_cliente = '$bairro' ";
	}
}

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
$td = "<td align='center' bgcolor='#FFFFFF'><b>Montador</b></td>";
$colspan = '9';
}



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
				c.ativo='0'
				$filtros
			ORDER BY 
				o.n_montagem ASC";



		$executa = mysql_query($SQL)or die(mysql_error());



header("Content-type: application/msexcel");



// Como será gravado o arquivo

header("Content-Disposition: attachment; filename=relatorio_notas.xls");

		// montando a tabela

		echo "<table border='0' width='100%' cellspacing='1' bgcolor='#FFFFFF'>

				<tr>

				  <td bgcolor='#FFFFFF'><b>Quant</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Nota</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Pedido</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Cliente</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Data Recebimento</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Data Entrega</b></td>

				  $td

				  <td bgcolor='#FFFFFF' align='center'><b>Status</b></td>

				  <td bgcolor='#FFFFFF' align='center'><b>Coment&aacute;rios</b></td>

			   </tr>";

		$i=1;

		while ($rs = mysql_fetch_array($executa)){

		            

			if($rs[status] == 1){$status = "<img src='http://www.prestyrio.com.br/images/tools.png' border='0' />";}

			elseif($rs[status] == 2){$status = "<img src='http://www.prestyrio.com.br/images/ampulheta.gif' border='0' align='absbottom' />";}

			elseif($rs[status] == 3){$status = "<img src='http://www.prestyrio.com.br/images/tick.png' border='0' />";}

			elseif($rs[status] == 4){$status = "<img src='http://www.prestyrio.com.br/images/ico_excluir.jpg' border='0' />";}

			elseif($rs[status] == 5){$status = "<img src='http://www.prestyrio.com.br/images/justice.png' border='0' />";}

			elseif($rs[status] == 6){$status = "<img src='http://www.prestyrio.com.br/images/ausente.png' border='0' width='24' />";}

			

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

			$vis_nome = "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>".$rs[nome]."</td>";

			}

			

			echo "<tr>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$i</td>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$rs[n_montagem]</td>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$rs[orcamento]</td>";	

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$rs[nome_cliente]</td>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$data_faturamento</td>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$data_final</td>";

				echo "$vis_nome";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'></td>";

				echo "<td bgcolor='#FFFFFF' align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;'>$rs[comentario]</td>";

			echo "</tr>";

			$i++;

		}

		  echo "<tr>
				  <td bgcolor='#FFFFFF' colspan='$colspan' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b>AV. CORONEL PHIDIAS TÁVORA, PAVUNA - RIO DE JANEIRO - RJ - BRASIL<br></b><br>
				  </td>
				</tr>  

		</table>";

?>