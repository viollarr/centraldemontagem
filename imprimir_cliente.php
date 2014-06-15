<?php

include"php/config.php";



$id_cliente = $_GET['id_clientes'];



$select	= "
	SELECT
		c.* ,
		es.sigla AS estado_cliente,
		cd.nome AS cidade_cliente
	FROM 
		clientes c 
	INNER JOIN
		estados es
	ON
		(c.estado_cliente = es.cod_estados)
	INNER JOIN
		cidades cd
	ON
		(c.cidade_cliente = cd.cod_cidades)
	WHERE 
		c.id_cliente = '$id_cliente'";

		
$query 	= mysql_query($select);

$x	= mysql_fetch_array($query);



$date_build = new DateTime($x['data_faturamento']);  

$data_certa = $date_build->format('d/m/Y');


if($x['tipo'] == 0){
	$texto_m = "MONTAGEM";
}
elseif($x['tipo'] == 1){
	$texto_m = "DESMONTAGEM";
}
elseif($x['tipo'] == 2){
	$texto_m = "REVIS&Atilde;O";
}
elseif($x['tipo'] == 3){
	$texto_m = "ASSIST&Ecirc;NCIA";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>

	<link rel="stylesheet" href="css/estilo_imprimir.css" type="text/css" />

    <script type="text/javascript">

	window.print('divdoconteudo');

	</script>

</head>

<body>

<div id="divdoconteudo">

<table width="878" border="0" align="center" cellpadding="0" cellspacing="0" height="210">

  <tr>

    <td valign="top">

		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto" height="200">

		  <tr>

            <td align="center" colspan="4"><b>ORDEM DE <?=$texto_m?></b><h1>CENTRAL DE MONTAGEM</h1><i>Central de Montagem a serviço da Ricardo Eletro</i><br /><br /></td>

          </tr>

			<tr>

				<td colspan="4" align="center"><strong>DADOS DE CADASTRO</strong><br /></td>

			</tr>

		  <tr>

			<td width="43%"><b>Vale Montagem:</b> <?=$x[n_montagem]?></td>

			<td width="10%"><b>Loja:</b> <?=$x[cod_loja]?></td>

			<td width="20%"><b>Or&ccedil;amento:</b> <?=$x[orcamento]?></td>

			<td width="27%"><b>Data Faturamento:</b> <?=$data_certa?></td>

		  </tr>

		  <tr>

			<td align="left" colspan="4"><b>Nome Completo:</b> <?=$x[nome_cliente]?></td>

          </tr>

          <tr>

			<td align="left"><b>Endere&ccedil;o:</b> <?=$x[endereco_cliente]?></td>

            <td align="left"><b>N&deg;:</b> <?=$x[numero_cliente]?></td>

            <td align="left"><b>Comp.:</b> <?=$x[complemento_cliente]?></td>

			<td align="left"><b>CEP:</b> <?=$x[cep_cliente]?></td>

		  </tr>

		  <tr>

			<td align="left" colspan="4"><b>Bairro:</b> <?=$x[bairro_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade:</b> <?=strtoupper(strtr(strtoupper(utf8_encode(strtoupper($x['cidade_cliente']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"))?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Estado:</b> <?=$x[estado_cliente]?></td>

		  </tr>

		  <tr>

			<td align="left" colspan="4"><b>Telefone:</b> <?=$x[telefone1_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b> <?=$x[telefone2_cliente]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b> <?=$x[telefone3_cliente]?></td>

		  </tr>

		  <tr>

			<td colspan="4">

				<b>Ponto de Refer&ecirc;ncia:</b><br />

				<span style="text-align: justify;"><?=$x[referencia_cliente]?></span>        

			</td>

            </tr>

			<tr>

				<td colspan="4" align="center" valign="middle"><strong>PRODUTO(S)</strong></td>

			</tr>

            <?php

			if($x[qtde_cliente]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente2]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente2]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente2]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente2]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente3]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente3]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente3]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente3]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente4]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente4]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente4]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente4]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente5]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente5]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente5]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente5]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente6]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente6]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente6]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente6]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente7]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente7]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente7]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente7]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente8]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente8]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente8]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente8]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente9]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente9]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente9]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente9]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente10]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente10]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente10]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente10]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente11]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente11]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente11]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente11]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente12]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente12]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente12]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente12]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente13]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente13]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente13]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente13]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente14]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente14]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente14]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente14]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente15]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente15]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente15]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente15]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente16]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente16]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente16]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente16]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente17]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente17]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente17]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente17]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente18]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente18]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente18]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente18]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente19]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente19]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente19]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente19]?>

				</td>

			</tr>

            <?php

			}

			if($x[qtde_cliente20]>0){

			?>

			<tr>

				<td colspan="4"><b>Qtde:</b> <?=$x[qtde_cliente20]?>

                &nbsp;&nbsp;&nbsp;<b>C&oacute;d.:</b> <?=$x[cod_cliente20]?>

                &nbsp;&nbsp;&nbsp;<b>Descri&ccedil;&atilde;o:</b> <?=$x[produto_cliente20]?>

				</td>

			</tr>

            <?php

			}

			?>

            <tr><td colspan="4">&nbsp;</td></tr>

			<tr>

				<td colspan="4" align="center" valign="middle"><strong>PEDIDO DE ASSIST&Ecirc;NCIA</strong></td>

			</tr>

            <tr>

            	<td colspan="4" align="left"><br />

                	<b>C&oacute;d.Prod.:</b> _____________&nbsp;&nbsp;&nbsp;<b>C&oacute;d.Peç:</b> _____________&nbsp;&nbsp;&nbsp;<b>Desc:</b> _____________&nbsp;&nbsp;&nbsp;<b>Avaria:</b> _____________&nbsp;&nbsp;&nbsp;<b>Ok:</b> _____________

                </td>

            </tr>

            <tr>

            	<td colspan="4" align="left"><br />

                	<b>C&oacute;d.Prod.:</b> _____________&nbsp;&nbsp;&nbsp;<b>C&oacute;d.Peç:</b> _____________&nbsp;&nbsp;&nbsp;<b>Desc:</b> _____________&nbsp;&nbsp;&nbsp;<b>Avaria:</b> _____________&nbsp;&nbsp;&nbsp;<b>Ok:</b> _____________

                </td>

            </tr>

            <tr>

            	<td colspan="4" align="left"><br />

                	<b>C&oacute;d.Prod.:</b> _____________&nbsp;&nbsp;&nbsp;<b>C&oacute;d.Peç:</b> _____________&nbsp;&nbsp;&nbsp;<b>Desc:</b> _____________&nbsp;&nbsp;&nbsp;<b>Avaria:</b> _____________&nbsp;&nbsp;&nbsp;<b>Ok:</b> _____________<br /><br />

                </td>

            </tr>

            <tr>

            	<td colspan="4"><br />

                <p style="text-align: center;">Instalação de Cozinha</p>

                <p style="text-align: justify;">Declaro para os devidos fins, que foi autorizado a instalação da cozinha, me responsabilizando por quaisquer danos ao meu patrimônio (parte hidráulica, elétrica e fixação da cozinha na parede).</p>

                <p style="text-align: center;">Ass.Cliente: _________________________________________________________________________</p>

                </td>

            </tr>

            <tr>

            	<td colspan="4">

                <table width="100%" border="0">

                	<tr>

                    	<td width="50%">

                			<b>Planta Baixa:</b><br /><br /><input type="button" value="" style="width: 300px; height: 130px; margin: 0 0 10px 20px;" />

                        </td>

                      	<td>

                            <b>Produto N&Atilde;O montado devido:</b><br /><br />

                            <input type="checkbox" /> cliente ausente.<br />

                            <input type="checkbox" /> endereço N&Atilde;O localizado.<br />

                            <input type="checkbox" /> recusa de montagem.<br />

                            <input type="checkbox" /> recebido por menores de 18(dezoito) anos.<br />

                            <input type="checkbox" /> recebido por maiores de 65(sessenta e cinco) anos.<br />                

                        </td>

                    </tr>

                </table>

                </td>

            </tr>

            <tr>

            	<td colspan="4">

                	<b>Declaração(ões):</b><br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima foram montadas e estão em perfeito estado.<br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima foram revisados e estão em perfeito estado.<br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima foram feito assisntência T&eacute;cnica e estão em perfeito estado.<br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima foram desmontados.<br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima foram montados e foi aberta um pedido de assistência que será executada no prazo de 30(trinta) dias.<br />

                    <input type="checkbox" /> - Declaro para os devidos fins, que o(s) produto(s) acima N&Atilde;O foram montados devido:<br />

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" /> - falta de volume.<br />

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" /> - volume errado.<br />

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" /> - produto muito danificado.<br /><br />

                    Li e concordo com a declaração acima mencionada.

   				</td>

            </tr>

            <tr>

            	<td colspan="4" align="left"><br /><br />

                <b>Ass.</b> ___________________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>RG:</b>&nbsp;&nbsp;&nbsp;&nbsp;_______________________<br /><br /><br />

                <b>Nome Leg&iacute;vel:</b> ___________________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Data</b> _____/_____/__________ <br /><br /><br /><br /><b>Montador:</b> ___________________________________________________<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(nome legível)

                </td>

            </tr>

      </table>

	</td>

  </tr>

</table>

</div>

</body>

</html>