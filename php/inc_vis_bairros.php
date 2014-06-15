<?php
include"config.php";

$y = mysql_query("SELECT * FROM bairros WHERE id_bairros = '".$_GET['id_bairros']."'");

if ($x = mysql_fetch_array($y)){

?>

<form name="form1" method="post" enctype="multipart/form-data" action="php/alterar_db_bairros.php">
 <input type="hidden" name="editar_bairro" value="1" />
	<input type="hidden" name="id_bairro" value="<?=$x['id_bairros']?>" />
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
        <script language="javascript">addCampos('salvar');</script>
      </tr>
	  <tr>
		<td colspan="2" class="titulo">Alterar Bairros</td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
    <tr>
        <td width="214" align="left">Nome do Bairro: </td>
        <td width="587" align="left"><input type="text" size="60" value="<?=htmlentities($x['nome'])?>" name="nome_bairro" id="nome_bairro" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
        <script language="javascript">addCampos('nome_bairro');</script>
    </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">* Favor alterar os nomes dos bairros que a empresa atende.</td>
	  </tr>
	  <tr>
		<td align="center" colspan="2"><a href="javascript:history.go(-1)">Voltar</a></td>
	  </tr>
    </table>
</form>		
<?php
}
?>