<?php
include_once "php/valida_sessao.php";
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
	<form action="php/inc_cad_usuario.php" method="post" name="frm" id="frm">
	<input type="hidden" value="<?=$_GET[ip];?>" name="ip" />
	<input type="hidden" value="<?=$_GET[data];?>" name="data" />
	<input type="hidden" value="<?=$_GET[hora];?>" name="hora" />
	  <table width="570"border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
      <tr>
        <td colspan="2" align="center" class="titulo"><strong>Cadastrar usuários</strong></td>
      </tr>
	  <tr>
	    <td align="center" colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td align="left">Tipo Usuário:</td>
	    <td align="left">
        	<select name="tipo">
            	<option selected="selected" value="escolha">-=Escolha=-</option>
            	<option value="1">Administrador</option>
                <option value="3">Funcionário RH</option>
                <option value="2">Funcionário</option>
              	<option value="5">Montador</option>
                <option value="4">Visitante</option>
            </select>
            <script language="javascript">addCampos('tipo');</script>
        </td>
	  </tr>
	  <tr>
        <td width="120" align="left">Nome: </td>
        <td align="left">
          <input name="nome" type="text" id="nome" size="30" maxlength="10" />
          <script language="javascript">addCampos('nome');</script>
        </td>
	  </tr>
	  <tr>
	    <td align="left">E-mail:</td>
	    <td align="left"><input name="email" type="text" id="email" size="30" /></td>
        <script language="javascript">addCampos('email');</script>
	  </tr>
	  <tr>
        <td width="120" align="left">Login: </td>
        <td align="left">
          <input name="login" type="text" id="login" size="30" maxlength="10" />
          <script language="javascript">addCampos('login');</script>
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