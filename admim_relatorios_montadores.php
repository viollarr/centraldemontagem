<?php

include_once "php/valida_sessao.php";

include ("php/config.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>
<link rel="stylesheet" href="js/datepiker/themes/base/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/datepiker/ui/jquery.ui.core.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/i18n/jquery.ui.datepicker-pt-BR.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#data_inicio").datepicker({
				changeMonth: true,
				onSelect: function( selectedDate ) {
					$("#data_final").datepicker( "option", "minDate", selectedDate );
				}
			});
			$("#data_final").datepicker({
				changeMonth: true,
				onSelect: function( selectedDate ) {
					$("#data_inicio").datepicker( "option", "maxDate", selectedDate );
				}
			});
		});
		
		//função que inicia o datepicker
		jQuery(function($) {
			$(".datepicker").datepicker( $.datepicker.regional[ "pt-BR" ] );
			$(".data").mask("99/99/9999");
		});
    </script>
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

			$select_all = "SELECT * FROM montadores WHERE ativo_m = '1' AND (id_empresa='1' OR id_empresa = '5') ORDER BY nome ASC";

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
            	<option value="todas" selected="selected">Todas</option>
				<option value="3">Montadas</option>
                <option value="1">Montado c/ Assist&ecirc;ncias</option>  
                <option value="8">Tecnica Executada</option>
                <option value="9">Desmontagem Executada</option>
                <option value="7">Revis&atilde;o Executada</option>
                <option value="5">Justi&ccedil;a Executada</option>
				<option value="2">Em Atendimento</option>
       	</select>
       </td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>

	  <tr>
       <td colspan="2" align="center" bgcolor="#FFFFFF">Data inicio:
        	<input type="text" name="data_inicio" id="data_inicio" class="data datepiker" size="10" />
     	</td>
     </tr>

	  <tr>
       <td colspan="2" align="center" bgcolor="#FFFFFF">Data final:
        <input type="text" name="data_final" id="data_final" class="data datepiker" size="10" />
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