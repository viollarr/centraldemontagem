<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
    <title>CENTRAL DE MONTAGEM</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="css/sddm.css" >
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script type="text/javascript">
        jQuery(document).ready(function($){ 
            // Colocar o focus no input do login.
            $('#n').focus();
			$('#envia').bind("click", function(){
				if($('#n').val() != ""){
					$("#frm").attr("action","assistencia_tecnica.php");
					$('#frm').submit();	
				}
				else{
					alert('Informe o número do vale montagem.');	
				}
			});
        });
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
<!--[if lt IE 9]>
<script>
document.createElement('header');
document.createElement('nav');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('footer');
document.createElement('hgroup');
</script>
<![endif]-->
<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
	<div class="box_conteudo">
        <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
            <td width="578" valign="top">
            <form method="get" target="_blank" enctype="multipart/form-data" name="frm" id="frm">
                <table width="570" border="0" align="center">
                  <tr>
                    <td class="titulo">Assistência Técnica</td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td><ul><li>Digite o N&deg; do Vale Montagem para criar a ASSISTÊNCIA:</li></ul></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" bgcolor="#FFFFFF">
                    <input type="text" name="n" id="n" size="20" maxlength="10" onKeyUp="nu(this)" />
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<input name="OK" id="envia" type="button" size="10"  value="OK"/></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
            </table>
            </form>
            </td>
          </tr>
        </table>
</div>
<?php include_once "inc_rodape3.php"; ?>

</body>
</html>