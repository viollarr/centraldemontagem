<?php

include_once "php/valida_sessao.php";
include_once "php/config.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CENTRAL DE MONTAGEM</title>
    <link rel="stylesheet" href="css/estilo.css" type="text/css" />
	<script type="text/javascript" src="js/funcoes.js"></script>
</head>
<body>

<?php //include_once "inc_topo.php"; ?>

<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
   <td width="578" valign="top">

	<form action="php/inc_cad_bairros.php" method="post" id="teste"  name="frm_servico" onSubmit="return validaForm()">
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
      <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
        <script language="javascript">addCampos('salvar');</script>
      </tr>
	  <tr>
		<td colspan="2" class="titulo">Cadastro de Bairros</td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
    <tr>
        <td width="214" align="left">Nome do Bairro: </td>
        <td width="587" align="left"><input type="text" size="60" name="nome_bairro" id="nome_bairro" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
        <script language="javascript">addCampos('nome_bairro');</script>
    </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">* Favor cadastrar os bairros que a empresa atende.</td>
	  </tr>
    </table>
	</form>
	</td>
 </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>