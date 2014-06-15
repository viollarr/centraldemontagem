<?php
include_once "php/valida_sessao.php";
include "php/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CENTRAL DE MONTAGEM</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.maskMoney.js"></script>
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#preco_real").maskMoney({showSymbol:false, symbol:"R$", decimal:",", thousands:"."});
			$("#preco_real_cp").maskMoney({showSymbol:false, symbol:"R$", decimal:",", thousands:"."});
			$("#preco_montador").maskMoney({showSymbol:false, symbol:"R$", decimal:",", thousands:"."});
			$("#preco_montador_cp").maskMoney({showSymbol:false, symbol:"R$", decimal:",", thousands:"."});
		});
    </script>
</head>
<body>
<table width="778" border="0" align="center" cellpadding="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
    	<form action="cad_precos.php" method="post" enctype="multipart/form-data">
        <table width="570" border="0" align="center">
          <tr>
            <td align="center" colspan="2" class="titulo">Cadastro de Preços</td>
          </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
            <td width="404" align="right" class="texto_pop_bottom">Nome da Família dos Produtos:</td>
            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="2" type="text" name="nome" size="45" onkeyup="this.value = this.value.toUpperCase();"/></td>
          </tr>
          <tr>
            <td width="404" align="right" class="texto_pop_bottom">Preço real (R$):</td>
            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="5" name="preco_real" id="preco_real" size="20"/></td>
          </tr>
          <tr>
            <td width="404" align="right" class="texto_pop_bottom">Preço real CP (R$):</td>
            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="5" name="preco_real_cp" id="preco_real_cp" size="20"/></td>
          </tr>
          <tr>
            <td width="404" align="right" class="texto_pop_bottom">Preço montador PR (R$):</td>
            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="7" name="preco_montador" id="preco_montador" size="20"/></td>
          </tr>
          <tr>
            <td width="404" align="right" class="texto_pop_bottom">Preço montador CP (R$):</td>
            <td width="399" align="left" class="texto_pop_bottom"><input tabindex="7" name="preco_montador_cp" id="preco_montador_cp" size="20"/></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="texto_pop_bottom"><input tabindex="8" type="submit"  value="ENVIAR" size="30" onkeyup="this.value = this.value.toLowerCase();"/></td>
          </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
            <td colspan="2" align="center" class="texto_pop_bottom">Últimos Enviados
            	<table border="1" cellpadding="0" cellspacing="0">
                	<tr>
			  <?php
                $select = "SELECT * FROM precos ORDER BY id_preco DESC LIMIT 3";
                $query = mysql_query($select) or die ("Query: ".$select." : ".mysql_error());
                
                while($linhas = mysql_fetch_array($query)){
                    echo'<td align="center" class="texto_pop_bottom">
							<strong>'.utf8_encode($linhas['nome']).'</strong><br>
							RC = R$<strong>'.str_replace(".",",",$linhas['preco_real']).'</strong><br>
							CP = R$<strong>'.str_replace(".",",",$linhas['preco_real_cp']).'</strong><br>
							MT(PR) = R$<strong>'.str_replace(".",",",$linhas['preco_montador']).'</strong><br>
							MT(CP) = R$<strong>'.str_replace(".",",",$linhas['preco_montador_cp']).'</strong><br>
							PR(Empresa) = R$<strong>'.str_replace(".",",",$linhas['preco_empresa']).'</strong><br>
							PR(CP) = R$<strong>'.str_replace(".",",",$linhas['preco_empresa_cp']).'</strong></td>';
                }			
                
              ?>
              	</tr>
              </table>
          	</td>
         </tr>
         <tr>
         	<td>&nbsp;</td>
         </tr>
         <tr>
         	<td>
            Legenda:<br />
            MT = montador<br />
            PR = prestyrio<br />
            RC = Ricardo Eletro<br />
            CP = lojas competição<br />
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