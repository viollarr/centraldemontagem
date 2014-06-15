<?php

include "php/config.php";

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

    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>

    <td width="578" valign="top">

	<form action="php/inc_cad_produtos.php" method="post" id="teste"  name="frm_servico" onSubmit="return validaForm()">

	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">

      <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>

        <script language="javascript">addCampos('salvar');</script>

      </tr>

	  <tr>

		<td colspan="2" class="titulo">Cadastro de Produtos</td>

	  </tr>

	  <tr>

		<td colspan="2">&nbsp;</td>

	  </tr>

    <tr>

        <td width="267" align="left">Código do Produto: </td>

        <td width="534" align="left"><input type="text" size="15" name="cod_produto" id="cod_produto" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('cod_produto');</script>

    </tr>

    <tr>

        <td width="267" align="left">Nome do Produto: </td>

        <td width="534" align="left"><input type="text" size="60" name="nome_produto" id="nome_produto" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('nome_produto');</script>

    </tr>

    <tr>

        <td align="left" colspan="2">Selecione o Modelo em que o produto se encaixa: </td>

    </tr>

    <tr>

        <td align="left" colspan="2">

        	<select name="modelo">

            	<option value="">...::: Escolha :::...</option>

                <?php

					$select = "SELECT * FROM precos ORDER BY nome ASC";

					$query = mysql_query($select);

					while($a = mysql_fetch_array($query)){

						echo "<option value='".$a['id_preco']."'>".htmlentities($a['nome'])."</option>";

					}

				?>

            </select>

            <script language="javascript">addCampos('modelo');</script>

        </td>

    </tr>

	  <tr>

		<td colspan="2">&nbsp;</td>

	  </tr>

    </table>

	</form>

	</td>

  </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>