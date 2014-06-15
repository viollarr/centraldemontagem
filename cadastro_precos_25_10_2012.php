<?php

include_once "php/valida_sessao.php";

include "php/config.php";

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>

<script type="text/javascript" src="js/funcoes.js"></script>

	<link rel="stylesheet" href="css/estilo.css" type="text/css" />

</head>



<body>

<table width="778" border="0" align="center" cellpadding="0">

  <tr>

    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>

    <td width="578" valign="top">

    	<form action="cad_precos.php" method="post" enctype="multipart/form-data">

        <table width="570" border="0" align="center">

          <tr>

            <td align="center" colspan="2" class="titulo">Cadastro de Pre&ccedil;os</td>

          </tr>

          <tr><td colspan="2">&nbsp;</td></tr>

          <tr>

            <td width="404" align="right" class="texto_pop_bottom">Nome da Fam&iacute;lia dos Produtos:</td>

            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="2" type="text" name="nome" size="45" onkeyup="this.value = this.value.toUpperCase();"/></td>

          </tr>

          <tr>

            <td width="404" align="right" class="texto_pop_bottom">Pre&ccedil;o real (R$):</td>

            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="5" name="preco_real" size="20" maxlength="9"/></td>

          </tr>

          <tr>

            <td width="404" align="right" class="texto_pop_bottom">Pre&ccedil;o montador (R$):</td>

            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="7" name="preco_montador" size="20" maxlength="9"/></td>

          </tr>

          <tr>

            <td colspan="2" align="center" class="texto_pop_bottom"><input tabindex="8" type="submit"  value="ENVIAR" size="30" onkeyup="this.value = this.value.toLowerCase();"/></td>

          </tr>

          <tr><td colspan="2">&nbsp;</td></tr>

          <tr>

            <td colspan="2" align="center" class="texto_pop_bottom">&Uacute;ltimos Enviados

            	<table border="1" cellpadding="0" cellspacing="0">

                	<tr>

			  <?php

                $select = "SELECT * FROM precos ORDER BY id_preco DESC LIMIT 3";

                $query = mysql_query($select) or die ("Query: ".$select." : ".mysql_error());

                

                while($linhas = mysql_fetch_array($query)){

                    echo'<td align="center" class="texto_pop_bottom"><strong>'.$linhas['nome'].'</strong><br>RC = R$<strong>'.$linhas['preco_real'].'</strong><br>MT = R$<strong>'.$linhas['preco_montador'].'</strong><br>PR = R$<strong>'.$linhas['preco_empresa'].'</strong></td>';

                }			

                

              ?>

              	</tr>

              </table>

          	</td>

         </tr>

        </table>

        </form>

	</td>

  </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>