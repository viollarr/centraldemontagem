<?php

include_once "php/valida_sessao.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>

	<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		$("input[name=cod_cliente]").click(function(){

			$("#produtos").html('CARREGANDO...');

			$.post('busca_produtos.php',

			{cod_produto:$(this).val()},

			function(valor){

				$("#produtos").html(valor);

			}

			)

		})

	})

	</script>

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

					include "limite.php";

				?>

        </td>

      </tr>

      <tr>

        <td><?php include "php/inc_adm_clientes_validar.php"; ?></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

	</td>

  </tr>

      <tr>

      <td bgcolor="#00552B">&nbsp;</td>

        <td>&nbsp;</td>

      </tr>

</table>



<?php include_once "inc_rodape.php"; ?>

</body>

</html>