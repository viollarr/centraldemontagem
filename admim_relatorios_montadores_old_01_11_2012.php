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

	<link rel="stylesheet" href="css/estilo.css" type="text/css" />



</head>





<body>

<?php //include_once "inc_topo.php"; ?>

<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="200px" align="center" valign="top" class="menu"><? include_once "inc_menu.php"; ?></td>

    <td width="578" valign="top">

	<form action="adm_relatorios_montadores.php" method="post" enctype="multipart/form-data" name="frm" id="frm">

	<table width="570" border="0" align="center">

	  <tr>

		<td class="titulo">Escolha o Montador </td>

	  </tr>

      <tr><td>&nbsp;</td></tr>

      <tr>

        <td><ul><li>Selecione um dos montadores para gerar o relat&oacute;rio de montagem e o que ele tem a receber:</li></ul></td>

      </tr>

	  <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF">

			<select name="mont">

          <option value="" selected="selected">---Escolha um Montador---</option>

          <?php

			$select_all = "SELECT * FROM montadores WHERE ativo_m = '1' AND id_empresa='1' ORDER BY nome ASC";

			$query_all  = mysql_query($select_all);

				while($b_all = mysql_fetch_array($query_all)){

					if($b_all[rota] != ""){

						$rota = '=> '.$b_all[rota];

					}

					else{$rota = "";}

					echo '<option value="'.$b_all[id_montadores].'">'.$b_all[nome].' '.substr($rota,0,30).'</option>';

				}

		?>

        </select></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="center">Tipos de Fichas</td>

      </tr>

	  <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF">

			<input type="checkbox" checked="checked" name="ficha_normal" value="1" />Normal

			<input type="checkbox" checked="checked" name="ficha_justica" value="1" />JUSTI&Ccedil;A

			<input type="checkbox" checked="checked" name="ficha_loja" value="1" />Loja                        

        </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="center">Escolha as notas</td>

      </tr>

	  <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF">

			<select name="not">

                <option value="1" selected="selected">Todas</option>

				<option value="2">Em Atendimento</option>

        	</select>

        </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF">Data inicio:

            <select name="dia_ini">

              <option value="" selected="selected">Dia</option>

              <option value='01'>01</option>

              <option value='02'>02</option>

              <option value='03'>03</option>

              <option value='04'>04</option>

              <option value='05'>05</option>

              <option value='06'>06</option>

              <option value='07'>07</option>

              <option value='08'>08</option>

              <option value='09'>09</option>

              <?php

                for($i=10;$i<32;$i++){

                echo "<option value='$i'>$i</option>";

                }

              ?>

            </select>/

            <select name="mes_ini">

              <option value="" selected="selected">Mes</option>

              <option value='01'>01</option>

              <option value='02'>02</option>

              <option value='03'>03</option>

              <option value='04'>04</option>

              <option value='05'>05</option>

              <option value='06'>06</option>

              <option value='07'>07</option>

              <option value='08'>08</option>

              <option value='09'>09</option>

              <option value='10'>10</option>

              <option value='11'>11</option>

              <option value='12'>12</option>

            </select>/

            <select name="ano_ini">

              <option value="" selected="selected">Ano</option>

              <?php

                for($i=2012;$i<2015;$i++){

                echo "<option value='$i'>$i</option>";

                }

              ?>

            </select>

      	</td>

      </tr>

	  <tr>

        <td colspan="2" align="center" bgcolor="#FFFFFF">Data final:

		<select name="dia_fim">

          <option value="" selected="selected">Dia</option>

              <option value='01'>01</option>

              <option value='02'>02</option>

              <option value='03'>03</option>

              <option value='04'>04</option>

              <option value='05'>05</option>

              <option value='06'>06</option>

              <option value='07'>07</option>

              <option value='08'>08</option>

              <option value='09'>09</option>

              <?php

                for($i=10;$i<32;$i++){

                echo "<option value='$i'>$i</option>";

                }

		  ?>

        </select>/

		<select name="mes_fim">

          <option value="" selected="selected">Mes</option>

              <option value='01'>01</option>

              <option value='02'>02</option>

              <option value='03'>03</option>

              <option value='04'>04</option>

              <option value='05'>05</option>

              <option value='06'>06</option>

              <option value='07'>07</option>

              <option value='08'>08</option>

              <option value='09'>09</option>

              <option value='10'>10</option>

              <option value='11'>11</option>

              <option value='12'>12</option>

        </select>/

		<select name="ano_fim">

          <option value="" selected="selected">Ano</option>

          <?php

		  	for($i=2012;$i<2015;$i++){

			echo "<option value='$i'>$i</option>";

			}

		  ?>

        </select>       

       </td>

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

