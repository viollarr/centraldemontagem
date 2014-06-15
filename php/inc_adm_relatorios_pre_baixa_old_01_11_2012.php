<?php
include ("config.php");

$dia =date("d");
$mes =date("m");
$ano =date("Y");
$data =$dia."/".$mes."/".$ano;

$relat = $_POST['relat'];
$data_inicio = $_POST['ano_ini']."-".$_POST['mes_ini']."-".$_POST['dia_ini'];
$data_fim = $_POST['ano_fim']."-".$_POST['mes_fim']."-".$_POST['dia_fim'];
$ativo = 0;

if($relat != 25){
//$condicao = "d.data_final >= '$data_inicio' AND d.data_final <= '$data_fim'";
$condicao = "(p.n_montagem = o.n_montagem AND p.valida = '$relat' AND o.status = '2') AND ((p.data_pre >= '$data_inicio' AND p.data_pre <= '$data_fim') AND (p.n_montagem = d.n_montagens AND c.n_montagem = p.n_montagem ) AND o.id_montador = m.id_montadores AND c.ativo='$ativo')";
$colspan = '9';

if ((strlen($relat)>0)&&($data_inicio!='--')&&($data_fim!='--')){



		$SQL = "SELECT c.nome_cliente, c.orcamento, d.data_recebimento, o.*, p.*, m.nome, m.id_responsavel FROM clientes c, montadores m, datas d, ordem_montagem o, pre_baixas p WHERE $condicao ORDER BY m.id_responsavel, o.id_montador ASC";

		//echo $SQL;



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

				   <form action="#" method="post" style="text-align:center;">

					  <input type="submit" value="Download" />

					  <input type="hidden" name="relat" value="<?=$relat?>"/>

                      <input type="hidden" name="data_inicio" value="<?=$data_inicio?>"/>

                      <input type="hidden" name="data_fim" value="<?=$data_fim?>"/>

				  </form>

				  <?php

				  echo "".$data."</td>

				</tr>
				<tr>
				  <td bgcolor='#F2F2F2'><b>Quant</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Nota</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Pedido</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Cliente</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Montador</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Data Recebimento (NAEC)</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Data Entrega</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Status Pré-Baixa</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Func. Responsável</b></td>
			   </tr>";

		$i=1;

		while ($rs = mysql_fetch_array($executa)){

			$select_responsavel = "SELECT nome FROM usuarios WHERE id ='".$rs['id_responsavel']."' ";
			$query_responsavel = mysql_query($select_responsavel);
			$res_responsavel = mysql_fetch_array($query_responsavel);
			
			$responsavel = $res_responsavel['nome'];

			if($relat == 25){$status == "N.E.";}
			else{
			if($rs[valida] == 3){$status = "<img src='images/tick.png' border='0' />";}
			
			elseif($rs[valida] == 1){$status = "M.A.";}

			elseif($rs[valida] == 4){$status = "<img src='images/ico_excluir.jpg' border='0' />";}

			elseif($rs[valida] == 5){$status = "<img src='images/justice.png' border='0' />";}
			
			elseif($rs[valida] == 10){$status = "<img src='images/justiceNo.png' border='0' />";}

			elseif($rs[valida] == 6){$status = "<img src='images/ausente.png' border='0' width='24' />";}
			
			elseif($rs[valida] == 7){$status = "<img src='images/verificar.png' border='0' />";}
			
			elseif($rs[valida] == 8){$status = "<img src='images/tecnica.png' border='0' />";}
			
			elseif($rs[valida] == 11){$status = "<img src='images/verificarNo.png' border='0' />";}
			
			elseif($rs[valida] == 12){$status = "<img src='images/tecnicaNo.png' border='0' />";}
			
			elseif($rs[valida] == 9){$status = "D.E.";}
			
			elseif($rs[valida] == 13){$status = "D.N.E.";}
			}
			

			

			$data_faturamento = new DateTime($rs[data_recebimento]);  

			$data_faturamento = $data_faturamento->format('d/m/Y');

			

			if($rs[data_final] != '0000-00-00'){

				$data_final = new DateTime($rs[data_final]);  

				$data_final = $data_final->format('d/m/Y');

			}
			

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$i</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[nome_cliente]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[nome]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_faturamento</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$status</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$responsavel</td>";

			echo "</tr>";

			$i++;

		}

		  echo "<tr>

				  <td colspan='$colspan' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>

														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>

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

  echo "<script> alert('Por Favor! Selecione um tipo para gerar o relatório');location.href='javascript:window.history.go(-1)'; </script>";

}


}
elseif($relat == 25){
	$condicao = "(o.n_montagem AND o.status = '2') AND ((d.data_recebimento >= '$data_inicio' AND d.data_recebimento <= '$data_fim') AND (o.n_montagem = d.n_montagens AND c.n_montagem = o.n_montagem ) AND o.id_montador = m.id_montadores AND p.n_montagem IS NULL AND c.ativo='$ativo')";
	$colspan = '9';


if ((strlen($relat)>0)&&($data_inicio!='--')&&($data_fim!='--')){

		
		$SQL = "SELECT c.nome_cliente, c.orcamento, d.data_recebimento, o.*, m.nome, m.id_responsavel FROM clientes c, datas d, montadores m, ordem_montagem o LEFT OUTER JOIN pre_baixas p ON o.n_montagem = p.n_montagem WHERE $condicao ORDER BY m.id_responsavel, o.id_montador ASC";

		//echo $SQL;

//exit;


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

				   <form action="#" method="post" style="text-align:center;">

					  <input type="submit" value="Download" />

					  <input type="hidden" name="relat" value="<?=$relat?>"/>

                      <input type="hidden" name="data_inicio" value="<?=$data_inicio?>"/>

                      <input type="hidden" name="data_fim" value="<?=$data_fim?>"/>

				  </form>

				  <?php

				  echo "".$data."</td>

				</tr>
				<tr>
				  <td bgcolor='#F2F2F2'><b>Quant</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Nota</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Pedido</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Cliente</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Montador</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Data Recebimento (NAEC)</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Data Entrega</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Status Pré-Baixa</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>Func. Responsável</b></td>
			   </tr>";

		$i=1;

		while ($rs = mysql_fetch_array($executa)){


			$status = "Ñ. Executado";
			
			$select_responsavel = "SELECT nome FROM usuarios WHERE id ='".$rs['id_responsavel']."' ";
			$query_responsavel = mysql_query($select_responsavel);
			$res_responsavel = mysql_fetch_array($query_responsavel);
			
			$responsavel = $res_responsavel['nome'];
			

			$data_faturamento = new DateTime($rs[data_recebimento]);  

			$data_faturamento = $data_faturamento->format('d/m/Y');

			

			if($rs[data_final] != '0000-00-00'){

				$data_final = new DateTime($rs[data_final]);  

				$data_final = $data_final->format('d/m/Y');

			}
			

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$i</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[nome_cliente]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[nome]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_faturamento</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>Ñ Entregue</td>";

				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$status</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$responsavel</td>";

			echo "</tr>";

			$i++;

		}

		  echo "<tr>

				  <td colspan='$colspan' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>

														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>

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

  echo "<script> alert('Por Favor! Selecione um tipo para gerar o relatório');location.href='javascript:window.history.go(-1)'; </script>";

}
}
?>