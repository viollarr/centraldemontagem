<?php
include_once "php/valida_sessao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CENTRAL DE MONTAGEM</title>
    <link rel="stylesheet" href="js/datepiker/themes/base/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="js/funcoes.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/datepiker/ui/jquery.ui.core.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/i18n/jquery.ui.datepicker-pt-BR.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    <script type="text/javascript">
      //função que inicia o datepicker
      jQuery(function($) {
            $(".datepicker").datepicker( $.datepicker.regional[ "pt-BR" ] );
      		$(".data").mask("99/99/9999");
      });
    </script>
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
			function barra(objeto){
				if (objeto.value.length == 2 || objeto.value.length == 5 ){
				objeto.value = objeto.value+"/";
				}
			}
			function soNums(e){
				if (document.all){var evt=event.keyCode;}
				else{var evt = e.charCode;}
				if (evt <20 || (evt >47 && evt<58)){return true;}
				return false;
			}
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
        <td><?php include "php/inc_vis_baixas.php"; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><a href="javascript:history.go(-2)">Voltar</a></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<?php include_once "inc_rodape.php"; ?>
</body>
</html>