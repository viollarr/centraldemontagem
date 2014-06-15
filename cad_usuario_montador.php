<?php
include_once "php/valida_sessao.php";
$login = "re".base64_decode($_GET['a']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CENTRAL DE MONTAGEM</title>
    <script type="text/javascript" src="js/funcoes.js"></script>
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>
<body>
<? //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><? include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
	<form action="php/inc_cad_usuario_montador.php" method="post" name="frm" id="frm">
	<input type="hidden" value="<?=$_GET[ip];?>" name="ip" />
	<input type="hidden" value="<?=$_GET[data];?>" name="data" />
	<input type="hidden" value="<?=$_GET[hora];?>" name="hora" />
    <input type="hidden" value="5" name="tipo" />
    <input type="hidden" value="<?=$login;?>" name="login" />
    <input type="hidden" value="<?=base64_decode($_GET['a']);?>" name="id_montador" />
	  <table width="570"border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
      <tr>
        <td colspan="2" align="center" class="titulo"><strong>Cadastrar Acesso de Montadores</strong></td>
      </tr>
	  <tr>
	    <td align="center" colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td align="left">E-mail:</td>
	    <td align="left"><input name="email" type="text" id="email" size="30" /></td>
        <script language="javascript">addCampos('email');</script>
	  </tr>
	  <tr>
        <td width="120" align="left">Login: </td>
        <td align="left">
          <input name="login2" type="text" id="login2" size="30" disabled="disabled" value="<?=$login;?>" maxlength="10" />
          <script language="javascript">addCampos('login2');</script>
        </td>
	  </tr>
	  <tr>
	    <td align="left">Senha:</td>
	    <td align="left"><input name="senha" type="password" maxlength="8" id="senha" size="30" /></td>
        <script language="javascript">addCampos('senha');</script>
	  </tr>
	  <tr>
	    <td align="center" colspan="2"><input type="submit" name="Submit" value="Entrar" /></td>
        <script language="javascript">addCampos('Submit');</script>
	  </tr>
	  <tr>
	    <td align="center" colspan="2">&nbsp;</td>
	  </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
<? include_once "inc_rodape.php"; ?>
</body>
</html>