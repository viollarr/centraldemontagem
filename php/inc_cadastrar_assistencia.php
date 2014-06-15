<?php
include"php/config.php";
$cliente = $_GET['id_clientes'];
$select  = "SELECT * FROM clientes WHERE id_cliente = '$cliente'";
$query   = mysql_query($select);
$x= mysql_fetch_array($query);
?>
<form name="assistencia" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id_clientes" value="<?=$x[id_cliente]?>" />
    <div id="divdoconteudo">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
		  <tr>
            <td align="center" class="titulo" colspan="4">Cadastrar Assist&ecirc;ncia T&eacute;cnica do Vale Montagem n&deg;:<?=$x[n_montagem]?></td>
          </tr>
        	<tr><td colspan="4">&nbsp;</td></tr>
          <tr>
            <td><strong>Protocolo:</strong> </td>
            <td colspan="3"><input type="text" size="20" name="protocolo" id="protocolo" tabindex="1" onKeyUp="nu(this)" />
                <script language="javascript">addCampos('protocolo');</script>
            </td>
          </tr>
		  <tr>
			<td><strong>Data Faturamento:</strong></td>
			<td><input type="text" size="20" name="data_faturamento" id="data_faturamento" tabindex="4" maxlength="10" onkeypress="barra(this)" /> (dd/mm/aaaa)</td>
            <script language="javascript">addCampos('data_faturamento');</script>
		  </tr>
      <tr><td colspan="4">&nbsp;</td></tr>
      <tr><td colspan="4"><strong>Selecione o Produto que vai pertencer a esse protocolo:</strong></td></tr>
        <tr>
            <td align="left"><strong>Produto:</strong></td>
            <td align="left" colspan="3"><input type="radio" name="produto" checked="checked" value="1"> <?=$x['cod_cliente']?> - <?=$x['produto_cliente']?></td>
        </tr>
	<?php
		for($i=2;$i<=20;$i++){
			if($x["cod_cliente$i"] !=''){
				echo'<tr>
						<td align="left"><strong>Produto</strong></td>
						<td align="left" colspan="3"><input type="radio" name="produto" value="'.$i.'"> '.$x["cod_cliente$i"].' - '.$x["produto_cliente$i"].'</td>
					 </tr>';
			}
		}
	?>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
        <tr>
            <td colspan="4" align="center">
                <input type="reset" value="Limpar" /><input type="button" name="Enviar" value="Enviar" onClick="return validaAssistencia();" />
            </td>
        </tr>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="4"><a href="javascript:history.go(-1)">Voltar</a></td>
		</tr>
      </table>
      </div>
</form>
