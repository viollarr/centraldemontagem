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
	<form action="adm_baixas.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
	<table width="570" border="0" align="center">
	  <tr>
		<td class="titulo">Escolha: Montador ou Vale Montagem</td>
	  </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td><ul><li>Selecione o Montador para dar BAIXA nas notas:</li></ul></td>
      </tr>
	  <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF">
			<select name="montador">
          		<option selected="selected">---Escolha um Montador---</option>
				<?php
					$resultado = mysql_query("SELECT * FROM montadores WHERE ativo_m = '1' ORDER BY nome ASC");
					while($sql = mysql_fetch_array($resultado)){
						echo "<option value='$sql[id_montadores]'>".$sql['nome']."</option>'";
					}
                ?>
        	</select>&nbsp;&nbsp;&nbsp;&nbsp;<input name="OK" type="submit"  value="OK"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
	<form action="adm_baixas.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
	<table width="570" border="0" align="center">
      <tr>
        <td><ul><li>Digite o N&deg; do Vale Montagem para dar BAIXA na nota:</li></ul></td>
      </tr>
	  <tr>
        <td colspan="2" align="center" bgcolor="#FFFFFF">
		<input type="text" name="vlm" id="vlm" size="20" maxlength="10" onKeyUp="nu(this)" />
        </select>&nbsp;&nbsp;&nbsp;&nbsp;<input name="OK" type="submit"  value="OK"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
<? include_once "inc_rodape.php"; ?>
</body>
</html>