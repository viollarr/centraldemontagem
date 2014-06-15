<?php
ob_start();
include "php/config.php";

if($_POST['vales'] != ''){
	
	
	
	// Definindo o tipo de arquivo (Ex: msexcel, msword, pdf ...)
	header("Content-type: application/msword");
	 
	// Formato do arquivo (Ex: .xls, .doc, .pdf ...)
	header("Content-Disposition: attachment; filename=valemontagem.doc");
	
	?> 
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
	
	
	<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
		<title>CENTRAL DE MONTAGEM</title>
	
	<style>
	li{
		list-style-type:none;
	}
	td{
		font-size:12px;
		font-family:Arial, Helvetica, sans-serif;
	}
	</style>
	</head>
	<body style="padding:-10px 0 0 0;">
	<?php
	
/*	$arquivo_select = "SELECT id_arquivo FROM arquivo ORDER BY id_arquivo DESC LIMIT 1";
	$arquivo_query = mysql_query($arquivo_select);
	$arquivo_id = mysql_fetch_assoc($arquivo_query);
*/	
	
	$select = "SELECT * FROM impressoes_vales WHERE id_arquivo = '".$_POST['vales']."'";
	$query 	= mysql_query($select);
	while($x = mysql_fetch_array($query)){
	
	$data = $x['data_faturamento']; // Data no formato MySQL
	$aux = explode("-",$data); // Faz a separa��o da data em itens
	// de uma array
	// Agora faz a jun��o invertendo a ordem do itens da data
	// para a forma normal.
	$data_faturamento = $aux[2]."/".$aux[1]."/".$aux[0];
	$maxProdutos = 0;
	
	for($ii=1;$ii<=20;$ii++){
		if($x["cod_cliente".$ii] != ""){
			$maxProdutos++; 
		}
	}
	
	?>
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" height="50">
		<tr>
			<td width="144" align="center"><img src="http://www.prestyrio.com.br/img/ricardoeletro.png" width="60%" border="0" /></td>
			<td width="395" align="center"><h3>ORDEM DE MONTAGEM_CLIENTE</h3></td>
			<td width="161"><b>N&deg; &nbsp;&nbsp;<?=$x[n_montagem]?></b></td>
		</tr>
	</table>
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" height="160">
	  <tr>
		<td valign="top">
			<table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto" height="200">
			  <tr>
				<td width="16%"><b>Nro. Ordem</b><br /><?=$x[n_montagem]?></td>
				<td width="19%"><b>Nota Fiscal/S&eacute;rie</b><br /><?=$x[nota_fiscal]?></td>
				<td width="10%"><b>Loja</b><br /><?=$x[cod_loja]?></td>
				<td width="11%"><b>Pedido</b><br /><?=$x[orcamento]?></td>
				<td width="23%"><b>Vendedor</b><br /><?=$x[vendedor]?></td>
				<td width="21%"><b>Data</b><br /><?=$data_faturamento?></td>
			  </tr>
			  <tr>
				<td align="left" colspan="4"><b>Montadora</b><br />100215 - PRESTY-RIO MONTAGENS MÓVEIS</td>
				<td align="left" valign="top"><b>Tel. Montadora</b><br />(21) 3381 6179</td>
				<td align="left" valign="top"><b>Visto Gerente</b><br />&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" colspan="6">
				<b>Cliente:</b>&nbsp;<?=$x[nome_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b>&nbsp;<?=$x[telefone1_cliente]?><br />
				<b>Endere&ccedil;o:</b>&nbsp;<?=$x[endereco_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>CEP:</b>&nbsp;<?=$x[cep_cliente]?><br />
				<b>Bairro:</b>&nbsp;<?=$x[bairro_cliente]?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade:</b>&nbsp;<?=$x[cidade_cliente]?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Estado:</b>&nbsp;<?=$x[estado_cliente]?><br />
				<b>Refer&ecirc;ncia:</b>&nbsp;<?=$x[referencia_cliente]?><br />
				</td>
			  </tr>
			  <tr>
				<td colspan="6">
					<table width="100%" cellpadding="0" cellspacing="0" border="1">
						<tr>
							<td width="6%" align="left"><b>Qtd.</b></td>
							<td width="11%" align="left"><b>C&oacute;d.</b></td>
							<td width="83%" align="left"><b>Produto.</b></td>
						</tr>
				<?php
					for($i=1;$i<=$maxProdutos;$i++){
						echo'
							<tr>
								<td align="left">'.$x["qtde_cliente".$i].'</td>
								<td align="left">'.$x["cod_cliente".$i].'</td>
								<td align="left">'.$x["produto_cliente".$i].'</td>
							</tr>';
					}
				?>
					</table>
				</td>
			  </tr>
				<tr>
					<td colspan="6">
					<center>Aten&ccedil;&atilde;o</center><br />
						1 - Só permita o acesso ao local de montagem se o montador estiver uniformizado e com o crach&aacute; de identifica&ccedil;&atilde;o.<br />
						2 - N&atilde;o tente montar o m&oacute;vel sob pena de perda da garantia, pois o montador n&atilde;o completa uma montagem iniciada pelo cliente.<br />
						3 - N&atilde;o pague nenhum valor diretamente ao montador.<br />
						4 - Terminada a montagem das mercadorias, assinale com &quot;X&quot; uma das respostas abaixo, date, assine e entregue este formul&aacute;rio ao montador.
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="65%" align="left">Voc&ecirc; esta satisfeito com a montagem ?</td>
							<td width="3%" align="left"><input type="checkbox" /></td>
							<td width="10%" align="left">Sim</td>
						  <td width="3%" align="left"><input type="checkbox" /></td>
							<td width="19%" align="left">N&Atilde;O</td>
						</tr>
						<tr>
							<td align="left">A montagem foi realizada no dia combinado com a montadora  ?</td>
							<td align="left"><input type="checkbox" /></td>
							<td align="left">Sim</td>
							<td align="left"><input type="checkbox" /></td>
							<td align="left">N&Atilde;O</td>
						</tr>
						<tr>
							<td align="left">Produtos montados por</td>
							<td align="left"><input type="checkbox" /></td>
							<td align="left">Cliente</td>
							<td align="left"><input type="checkbox" /></td>
							<td align="left">Montador</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td colspan="6" align="left">
					<p style="text-align:left;"><b>Data</b> ___/___/_____    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Ass. Cliente:</b> _______________________________________________________________</p></td>
				</tr>
		</table>	
	   </td>
	  </tr>
	</table>
	<?php if($maxProdutos!=20){ echo '<br />'; } ?>
	<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" height="100">
	  <tr>
		<td valign="top">
			<table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto" height="200">
			  <tr>
				<td width="16%"><b>Nro. Ordem</b><br /><?=$x[n_montagem]?></td>
				<td width="19%"><b>Nota Fiscal/S&eacute;rie</b><br /><?=$x[nota_fiscal]?></td>
				<td width="10%"><b>Loja</b><br /><?=$x[cod_loja]?></td>
				<td width="11%"><b>Pedido</b><br /><?=$x[orcamento]?></td>
				<td width="23%"><b>Vendedor</b><br /><?=$x[vendedor]?></td>
				<td width="21%"><b>Data</b><br /><?=$x[data_faturamento]?></td>
			  </tr>
			  <tr>
				<td align="left" colspan="4"><b>Montadora</b><br />100215 - PRESTY-RIO MONTAGENS MÓVEIS</td>
				<td align="left" valign="top"><b>Tel. Montadora</b><br />(21) 3381 6179</td>
				<td align="left" valign="top"><b>Visto Gerente</b><br />&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" colspan="6">
				<b>Cliente:</b>&nbsp;<?=$x[nome_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b>&nbsp;<?=$x[telefone1_cliente]?><br />
				<b>Endere&ccedil;o:</b>&nbsp;<?=$x[endereco_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>CEP:</b>&nbsp;<?=$x[cep_cliente]?><br />
				<b>Bairro:</b>&nbsp;<?=$x[bairro_cliente]?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade:</b>&nbsp;<?=$x[cidade_cliente]?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Estado:</b>&nbsp;<?=$x[estado_cliente]?><br />
				<b>Refer&ecirc;ncia:</b>&nbsp;<?=$x[referencia_cliente]?><br />
				</td>
			  </tr>
				<tr>
					<td colspan="6" align="left">
					<p style="text-align:left;"><b>Data</b> ___/___/_____    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Ass. Montador:</b> _______________________________________________________________</p></td>
				</tr>
		</table>
	  </td>
	 </tr>
	</table>
	<?php
		if(($maxProdutos == 1)||($maxProdutos == 2)||($maxProdutos == 3)||($maxProdutos == 4)||($maxProdutos == 5)||($maxProdutos == 6)){
			echo'<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
		}
		elseif(($maxProdutos == 7)||($maxProdutos == 8)){
			echo'<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 9){
			echo'<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 10){
			echo'<br /><br /><br /><br /><br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 11){
			echo'<br /><br /><br /><br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 12){
			echo'<br /><br /><br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 13){
			echo'<br /><br /><br /><br /><br /><br />';
		}
		elseif(($maxProdutos == 14)||($maxProdutos == 15)){
			echo'<br /><br /><br /><br /><br />';
		}
		elseif($maxProdutos == 16){
			echo'<br /><br /><br /><br />';
		}
		elseif($maxProdutos == 17){
			echo'<br /><br /><br />';
		}
		elseif($maxProdutos == 18){
			echo'<br /><br />';
		}
		elseif(($maxProdutos == 19)||($maxProdutos == 20)){
			echo'';
		}
	}//fecha o while geral
	?>
	</body>
	</html>
<?php
}
else{
	echo "<script> alert('Selecione ao menos um tipo de arquivo!');location.href='javascript:window.history.go(-1)'; </script>";	
}
?>

