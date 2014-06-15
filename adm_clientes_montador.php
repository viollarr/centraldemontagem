<?php
include_once "php/valida_sessao.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CENTRAL DE MONTAGEM</title>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
    <style>
		.texto2{
			text-align:left !important;
		}
	</style>
</head>
<body>
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu_montadores.php"; ?></td>
        <td width="578" valign="top">
            <table width="570" border="0" align="center">
                <tr>
                    <td><?php include "php/inc_adm_clientes_montadores.php"; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
		<td bgcolor="#00552B"></td>
        <td>
        	<table width="100%">
            	<tr>
                    <td width="15%">Prioridade:</td>
                    <td width="25%" bgcolor="#FFB3B3" bordercolor="#000000">&nbsp;</td>
                    <td width="15%" align="left"> = Jurídico</td>
                    <td width="25%" bgcolor="#DBDC7C" bordercolor="#000000">&nbsp;</td>
                    <td align="left"> = Loja</td>
              </tr>
            </table>
        </td>
	</tr>
</table>
<?php include_once "inc_rodape.php"; ?>

</body>

</html>