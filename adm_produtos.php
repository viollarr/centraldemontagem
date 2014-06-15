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
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
	  <table width="570" border="0" align="center">
      <tr>
        <td align="left">
        	<?php
             $ie6 = "MSIE 6.0";
			 $ie7 = "MSIE 7.0";
			 $ie8 = "MSIE 8.0";
			 if( strstr($_SERVER['HTTP_USER_AGENT'], $ie8)){
			   echo '<form action="adm_produtos.php?buscar=buscar" method="get" enctype="application/x-www-form-urlencoded">';
			 }elseif (( strstr($_SERVER['HTTP_USER_AGENT'], $ie7)) or ( strstr($_SERVER['HTTP_USER_AGENT'], $ie6))) {
			   echo '<form action="adm_produtos.php?buscar=buscar" method="get" enctype="application/x-www-form-urlencoded" style="margin:0 0 0 7px;">';
			 }else{
			   echo '<form action="adm_produtos.php?buscar=buscar" method="get" enctype="application/x-www-form-urlencoded">';
			 } 
             ?>
            	<input type="text" name="buscar" class="upper"/>
                <script language="javascript">addCampos('buscar');</script>
                <select name="tipo" id="tipo">
                	<option value="cod_produto" selected="selected">C&oacute;d Produto</option>
                    <option value="modelo">Nome Produto</option>
                </select>
                <script language="javascript">addCampos('tipo');</script>
                <input type="submit" value="Buscar" name="submit"/>

                <?php
					include "limite.php";
				?>
        </td>
      </tr>
      <tr>
        <td><?php include "php/inc_adm_produtos.php"; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<?php include_once "inc_rodape.php"; ?>
</body>
</html>