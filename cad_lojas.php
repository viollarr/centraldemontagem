<?php
include_once "php/valida_sessao.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CENTRAL DE MONTAGEM</title>
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
	<script type="text/javascript" src="js/funcoes.js"></script>
</head>
<body>
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td width="200px" align="center" valign="top" class="menu"><? include_once "inc_menu.php"; ?></td>
   <td width="578" valign="top">
	<form action="php/inc_cad_lojas.php" method="post" id="teste"  name="frm_servico" onSubmit="return validaForm()">
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
     <tr>
       <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
       <script language="javascript">addCampos('salvar');</script>
     </tr>
	  <tr>
		<td colspan="2" class="titulo">Cadastro de Lojas</td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
   <tr>
       <td width="257" align="left">Código da Loja: </td>
       <td width="544" align="left"><input type="text" size="5" maxlength="2" name="cod_loja" id="cod_loja" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('cod_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">Nome da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="nome_loja" id="nome_loja" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('nome_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">Gerente da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="gerente_loja" id="gerente_loja" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('gerente_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">1º Telefone da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="tel_loja" id="tel_loja" tabindex="1" onkeyup="this.value = this.value.toLowerCase();" /></td>
       <script language="javascript">addCampos('tel_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">2º Telefone da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="tel2_loja" id="tel2_loja" tabindex="1" onkeyup="this.value = this.value.toLowerCase();" /></td>
       <script language="javascript">addCampos('tel2_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">3º Telefone da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="tel3_loja" id="tel3_loja" tabindex="1" onkeyup="this.value = this.value.toLowerCase();" /></td>
       <script language="javascript">addCampos('tel3_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">4º Telefone da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="tel4_loja" id="tel4_loja" tabindex="1" onkeyup="this.value = this.value.toLowerCase();" /></td>
       <script language="javascript">addCampos('tel4_loja');</script>
   </tr>
   <tr>
       <td width="257" align="left">Email da Loja: </td>
       <td width="544" align="left"><input type="text" size="40" name="email_loja" id="email_loja" tabindex="1" value="@maquinadevendas.com.br" onkeyup="this.value = this.value.toLowerCase();" /></td>
       <script language="javascript">addCampos('email_loja');</script>
   </tr>

	  <tr>

		<td colspan="2">&nbsp;</td>

	  </tr>
   </table>

	</form>

	</td>
 </tr>

</table>

<? include_once "inc_rodape.php"; ?>

</body>

</html>