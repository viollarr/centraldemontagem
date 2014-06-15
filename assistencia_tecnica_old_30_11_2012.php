<?php

include "php/config.php";



$v_montagem = $_GET['n'];

$select = "SELECT c.*, d.*, m.*, o.* FROM clientes c, datas d, montadores m, ordem_montagem o  WHERE c.n_montagem = '$v_montagem' AND c.n_montagem = o.n_montagem AND o.id_montador = m.id_montadores";

//echo $select;

$query = mysql_query($select);

$x = mysql_fetch_array($query);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>NAEC - ASSIST&Ecirc;NCIA T&eacute;cnica</title>

</head>

<style>

*{

	font-size: 12px;

}

</style>

<body>

<form action="assistencia_tecnica_excel.php" enctype="multipart/form-data" method="post">

<input type="hidden" name="n" value="<?=$x['n_montagem']?>" />

<table width="60%" align="center" cellpadding="1" cellspacing="1" border="1">

	<tr>

    	<td colspan="4" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">RICARDO ELETRO - PEDIDO DE ASSIST&Ecirc;NCIA T&Eacute;CNICA DE MÓVEIS</td>

    </tr>

	<tr>

    	<td width="14%" align="left" bgcolor="#CAC7C6"><strong>MONTADORA:</strong></td>

        <td width="39%" align="left"> WA - MÁQUINA DE MONTAGEM</td>

        <td width="15%" align="left" bgcolor="#CAC7C6"><strong>DATA PEDIDO:</strong></td>

        <td width="32%" align="left"><?php echo date('d/m/Y');?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>MONTADOR:</strong></td>

        <td align="left"><?=$x['nome']?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>Or&ccedil;amento:</strong></td>

        <td align="left"><?=$x['orcamento']?></td>

    </tr>

	<tr>

    	<td colspan="4" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">ENDEREÇO PARA ENTREGA DAS PEÇAS</td>

    </tr>

	<tr>

    	<td colspan="4" align="center"><strong>Ricardo Eletro Rio de Janeiro</strong></td>

    </tr>

	<tr>

    	<td colspan="4" align="center">Avenida Coronel Phidias Távora, N&deg; 360 – Pavuna – Rio de Janeiro – Cep: 21535-510</td>

    </tr>

	<tr>

    	<td colspan="4" align="center">Telefone: (21) 3501-3000 / (21) 3501-3016 – Ramal 3016 – Lúcio Flávio</td>

    </tr>

	<tr>

    	<td colspan="4" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">DADOS CLIENTE</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>NOME CLIENTE:</strong></td>

        <td align="left" colspan="3"><?=$x['nome_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>PROTOCOLO:</strong></td>

        <td align="left"><input name="protocolo" size="50"></td>

        <td align="left" bgcolor="#CAC7C6"><strong>CPF:</strong></td>

        <td align="left"><?=$x['cpf_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>RUA:</strong></td>

        <td align="left"><?=$x['endereco_cliente']?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>N&deg;:</strong></td>

        <td align="left"><?=$x['numero_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>BAIRRO:</strong></td>

        <td align="left"><?=$x['bairro_cliente']?>)</td>

        <td align="left" bgcolor="#CAC7C6"><strong>CIDADE:</strong></td>

        <td align="left"><?=$x['cidade_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>REFERÊNCIA:</strong></td>

        <td align="left" colspan="3"><?=$x['referencia_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>TELEFONE:</strong></td>

        <td align="left" colspan="3"><?=$x['telefone1_cliente']?> <?=$x['telefone2_cliente']?> <?=$x['telefone3_cliente']?></td>

    </tr>

	<tr>

    	<td colspan="4" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">DADOS DO PRODUTO/PEÇAS SOLICITADAS</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>C&Oacute;d/DESC/FABR:</strong></td>

        <td align="left" colspan="3"><input type="checkbox" name="produto" value="1"> <?=$x['cod_cliente']?> - <?=$x['produto_cliente']?></td>

    </tr>

    <?php

		for($i=2;$i<=20;$i++){

			if($x["cod_cliente$i"] !=''){

				echo'<tr>

						<td align="left" bgcolor="#CAC7C6"><strong>C&Oacute;d/DESC/FABR:</strong></td>

						<td align="left" colspan="3"><input type="checkbox" name="produto'.$i.'" value="'.$i.'"> '.$x["cod_cliente$i"].' - '.$x["produto_cliente$i"].'</td>

					 </tr>';

			}

		}

	?>

	<tr>

    	<td colspan="4" align="center">

        	<table cellpadding="0" cellspacing="0" width="100%" border="1">

             	<tr>

                	<td width="46%" align="center" bgcolor="#CAC7C6">PEÇA / QTDE</td>

                  	<td width="8%" align="center" bgcolor="#CAC7C6">MOTIVO</td>

                	<td bgcolor="#CAC7C6" colspan="4" align="center">LEGENDA DO MOTIVO</td>

                </tr>

              	<tr>

                	<td align="left"><input name="peca1" size="70"></td>

                    <td align="center"><input name="motivo1" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>1</strong></td>

                  	<td width="19%" align="left">Quebrado</td>

                  	<td width="4%" align="center" bgcolor="#CAC7C6"><strong>8</strong></td>

                  	<td width="19%" align="left">Rachado/lascado</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca2" size="70"></td>

                    <td align="center"><input name="motivo2" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>2</strong></td>

                    <td width="19%" align="left">Faltando/Incompleto</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>9</strong></td>

                    <td width="19%" align="left">Tonalidade errada</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca3" size="70"></td>

                    <td align="center"><input name="motivo3" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>3</strong></td>

                    <td width="19%" align="left">Arranhado/Riscado</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>10</strong></td>

                    <td width="19%" align="left">Mofado</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca4" size="70"></td>

                    <td align="center"><input name="motivo4" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>4</strong></td>

                    <td width="19%" align="left">Empenado</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>11</strong></td>

                    <td width="19%" align="left">Falha na Montagem</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca5" size="70"></td>

                    <td align="center"><input name="motivo5" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>5</strong></td>

                    <td width="19%" align="left">Amassado</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>12</strong></td>

                    <td width="19%" align="left">Modelo Errado</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca6" size="70"></td>

                    <td align="center"><input name="motivo6" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>6</strong></td>

                    <td width="19%" align="left">N&Atilde;O encaixa/ Furação errada</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>13</strong></td>

                    <td width="19%" align="left">Avariado Transp.</td>

              	</tr>

                <tr>

                	<td align="left"><input name="peca7" size="70"></td>

                    <td align="center"><input name="motivo7" size="2"></td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>7</strong></td>

                    <td width="19%" align="left">Falha Pintura/Cromo/Ferrujem</td>

                    <td width="4%" align="center" bgcolor="#CAC7C6"><strong>14</strong></td>

                    <td width="19%" align="left">Outros- especificar</td>

              </tr>                

            </table>

        </td>

    </tr>

	<tr>

    	<td colspan="4" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">RETORNO DO PEDIDO – ATRE</td>

    </tr>

	<tr>

    	<td colspan="4">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="4">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="4">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="4">&nbsp;</td>

    </tr>    

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>ASS CLIENTE:</strong></td>

        <td align="left" colspan="3">&nbsp;</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>ASS MONTADOR:</strong></td>

        <td align="left" colspan="3">&nbsp;</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>DATA: _____/______</strong></td>

        <td align="center" colspan="3" bgcolor="#CAC7C6" style="font-size: 16px; font-weight: bold;">Declaro ter recebido a ASSIST&Ecirc;NCIA do móvel acima citado com os devidos reparos.</td>

    </tr>

	<tr>

    	<td colspan="4">&nbsp;</td>

    </tr> 

	<tr>

    	<td colspan="4" align="center"><input type="submit" name="ENVIAR E-MAIL" value="ENVIAR E-MAIL" /></td>

    </tr>    

</table>

</form>

</body>

</html>