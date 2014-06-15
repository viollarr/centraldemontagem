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

             $ie6 = "MSIE 6.0";

			 $ie7 = "MSIE 7.0";

			 $ie8 = "MSIE 8.0";

			 if( strstr($_SERVER['HTTP_USER_AGENT'], $ie8)){

			   echo '<form action="adm_clientes.php?buscar=buscar&tipo=tipo" method="get" enctype="application/x-www-form-urlencoded">';

			 }elseif (( strstr($_SERVER['HTTP_USER_AGENT'], $ie7)) or ( strstr($_SERVER['HTTP_USER_AGENT'], $ie6))) {

			   echo '<form action="adm_clientes.php?buscar=buscar&tipo=tipo" method="get" enctype="application/x-www-form-urlencoded" style="margin:0 0 0 7px;">';

			 }else{

			   echo '<form action="adm_clientes.php?buscar=buscar&tipo=tipo" method="get" enctype="application/x-www-form-urlencoded">';

			 } 

             ?>

            	<input type="text" name="buscar" class="upper"/>

                <select name="tipo">

                	<option value="nome_cliente" selected="selected">Nome</option>

                    <option value="n_montagem">V.Montagem</option>

                    <option value="orcamento">Or&ccedil;amento</option>

                    <option value="telefone1_cliente">Telefone</option>

                </select>

                <input type="submit" value="Buscar" name="submit"/>

                <?php

					include "limite.php";

				?>

        </td>

      </tr>

      <tr>

        <td><?php include "php/inc_adm_clientes.php"; ?></td>

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

      <tr>

      <td bgcolor="#00552B"></td>

        <td align="left">

            <img src='images/revisar.gif' border='0' /> = Escolher Montador | 

            <img src='images/tools.png' border='0' /> = Assitência | 

            <img src='images/ampulheta.gif' border='0' align="absbottom" /> = Em Atendimento |

            <img src='images/ico_excluir.jpg' border='0' /> = N&Atilde;O Executado <br />

            <img src='images/tick.png' border='0' /> = Executado | 

            <img src='images/justice.png' border='0' /> = Justiça |

            <img src='images/justiceNo.png' border='0' /> = Justiça N&Atilde;O executado | 

            <img src='images/ausente.png' border='0' width="24" /> = Ausente |

            <img src='images/verificar.png' border='0' /> = Revis&atilde;o <br />

            <img src='images/verificarNo.png' border='0' /> = Revis&atilde;o N&Atilde;O executada |

            <img src='images/tecnica.png' border='0' /> = T&eacute;cnica |

            <img src='images/tecnicaNo.png' border='0' /> = T&eacute;cnica N&Atilde;O executado </td> 

      </tr>

</table>



<?php include_once "inc_rodape.php"; ?>

</body>

</html>