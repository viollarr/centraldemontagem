<?php
include_once "php/valida_sessao.php";
include ("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CENTRAL DE MONTAGEM</title>
	<script type="text/javascript" src="js/funcoes.js"></script>
   	<script language="javascript">	
			function nu(campo){
				var digits="0123456789"
				var campo_temp 
				for (var i=0;i<campo.value.length;i++){
					campo_temp=campo.value.substring(i,i+1) 
					if (digits.indexOf(campo_temp)==-1){
						campo.value = campo.value.substring(0,i);
						break;
					}
				}
			}
    </script>
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>
<body>
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><? include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
	<form action="vis_baixas_montadores.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
    	<input type="hidden" name="escritorio" value="1" />
	<table width="570" border="0" align="center">
	  <tr>
		<td class="titulo">Defina o Montador e Vale Montagem para a Pré-Baixa</td>
	  </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td align="left"><ul><li>Digite o N&deg; do Vale Montagem:</li></ul></td>
      </tr>
	  <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF">
		<input type="text" name="vlm" id="vlm" size="20" maxlength="10" onKeyUp="nu(this)" />
        </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><input name="OK" type="submit"  value="OK"/></td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
<? include_once "inc_rodape.php"; ?>
</body>
</html>