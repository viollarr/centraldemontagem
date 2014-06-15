<?php

include "php/config.php";



$v_montagem = $_POST['n'];

$protocolo	= $_POST['protocolo'];

$produto	= $_POST['produto'];



for($i=2;$i<=20;$i++){

	${"produto".$i} = $_POST['produto'.$i];

}

for($ii=1;$ii<=7;$ii++){

	${"peca".$ii} = $_POST['peca'.$ii];

	${"motivo".$ii} = $_POST['motivo'.$ii];

}



$select = "
	SELECT 
		c.*, 
		es.sigla AS estado_cliente, 
		UPPER(cd.nome) AS cidade_cliente, 
		m.*, 
		o.* 
	FROM 
		clientes c  
	INNER JOIN 
		ordem_montagem o 
	ON 
		(c.n_montagem = o.n_montagem) 
	INNER JOIN 
		montadores m 
	ON 
		(o.id_montador = m.id_montadores) 
	INNER JOIN 
		estados es 
	ON 
		(c.estado_cliente = es.cod_estados) 
	INNER JOIN 
		cidades cd 
	ON 
		(c.cidade_cliente = cd.cod_cidades) 
	WHERE 
		c.n_montagem = '".$v_montagem."'
	";

//echo $select;

$query = mysql_query($select);

$x = mysql_fetch_array($query);



if(strlen($produto)>0){$produto_descricao = $x['cod_cliente']." - ".$x['produto_cliente'];}

elseif(strlen($produto2)>0){$produto_descricao = $x['cod_cliente2']." - ".$x['produto_cliente2'];}

elseif(strlen($produto3)>0){$produto_descricao = $x['cod_cliente3']." - ".$x['produto_cliente3'];}

elseif(strlen($produto4)>0){$produto_descricao = $x['cod_cliente4']." - ".$x['produto_cliente4'];}

elseif(strlen($produto5)>0){$produto_descricao = $x['cod_cliente5']." - ".$x['produto_cliente5'];}

elseif(strlen($produto6)>0){$produto_descricao = $x['cod_cliente6']." - ".$x['produto_cliente6'];}

elseif(strlen($produto7)>0){$produto_descricao = $x['cod_cliente7']." - ".$x['produto_cliente7'];}

elseif(strlen($produto8)>0){$produto_descricao = $x['cod_cliente8']." - ".$x['produto_cliente8'];}

elseif(strlen($produto9)>0){$produto_descricao = $x['cod_cliente9']." - ".$x['produto_cliente9'];}

elseif(strlen($produto10)>0){$produto_descricao = $x['cod_cliente10']." - ".$x['produto_cliente10'];}

elseif(strlen($produto11)>0){$produto_descricao = $x['cod_cliente11']." - ".$x['produto_cliente11'];}

elseif(strlen($produto12)>0){$produto_descricao = $x['cod_cliente12']." - ".$x['produto_cliente12'];}

elseif(strlen($produto13)>0){$produto_descricao = $x['cod_cliente13']." - ".$x['produto_cliente13'];}

elseif(strlen($produto14)>0){$produto_descricao = $x['cod_cliente14']." - ".$x['produto_cliente14'];}

elseif(strlen($produto15)>0){$produto_descricao = $x['cod_cliente15']." - ".$x['produto_cliente15'];}

elseif(strlen($produto16)>0){$produto_descricao = $x['cod_cliente16']." - ".$x['produto_cliente16'];}

elseif(strlen($produto17)>0){$produto_descricao = $x['cod_cliente17']." - ".$x['produto_cliente17'];}

elseif(strlen($produto18)>0){$produto_descricao = $x['cod_cliente18']." - ".$x['produto_cliente18'];}

elseif(strlen($produto19)>0){$produto_descricao = $x['cod_cliente19']." - ".$x['produto_cliente19'];}

elseif(strlen($produto20)>0){$produto_descricao = $x['cod_cliente20']." - ".$x['produto_cliente20'];}


header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=pedido_assitencia_tecnica_".$x['n_montagem'].".xls");



?>

<style>

*{

	font-size: 12px;

}

</style>

<table width="60%" align="center" cellpadding="1" cellspacing="1" border="1">

	<tr>

    	<td colspan="8" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">RICARDO ELETRO - PEDIDO DE ASSIST&Ecirc;NCIA T&Eacute;CNICA DE M&Oacute;VEIS</td>

    </tr>

	<tr>

    	<td width="14%" align="left" bgcolor="#CAC7C6"><strong>MONTADORA:</strong></td>

        <td width="33%" align="left" colspan="2">CENTRAL DE MONTAGEM</td>

      <td width="12%" align="left" bgcolor="#CAC7C6"><strong>DATA PEDIDO:</strong></td>

      <td align="left" colspan="4"><?php echo date('d/m/Y');?></td>

  </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>MONTADOR:</strong></td>

        <td align="left" colspan="2"><?=$x['nome']?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>Or&ccedil;amento:</strong></td>

        <td align="left" colspan="4"><?=$x['orcamento']?></td>

    </tr>

	<tr>

    	<td colspan="8" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">ENDERE&Ccedil;O PARA ENTREGA DAS PE&Ccedil;AS</td>

    </tr>

	<tr>

    	<td colspan="8" align="center"><strong>Ricardo Eletro Rio de Janeiro</strong></td>

    </tr>

	<tr>

    	<td colspan="8" align="center">Avenida Coronel Phidias T&aacute;vora, N&deg; 360 - Pavuna - Rio de Janeiro - Cep: 21535-510</td>

    </tr>

	<tr>

    	<td colspan="8" align="center">Telefone: (21) 3501-3000 / (21) 3501-3016 - Ramal 3016 - L&uacute;cio Fl&aacute;vio</td>

    </tr>

	<tr>

    	<td colspan="8" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">DADOS CLIENTE</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>NOME CLIENTE:</strong></td>

        <td align="left" colspan="7"><?=$x['nome_cliente']?></td>

    </tr>
	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>LOJA:</strong></td>

        <td align="left" colspan="7"><?=$x['cod_loja']?></td>

    </tr>
	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>PROTOCOLO:</strong></td>

        <td align="left" colspan="2"><?=$protocolo?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>CPF:</strong></td>

        <td align="left" colspan="4"><?=$x['cpf_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>RUA:</strong></td>

        <td align="left" colspan="2"><?=$x['endereco_cliente']?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>N&deg;:</strong></td>

        <td align="left" colspan="4"><?=$x['numero_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>BAIRRO:</strong></td>

        <td align="left" colspan="2"><?=$x['bairro_cliente']?></td>

        <td align="left" bgcolor="#CAC7C6"><strong>CIDADE:</strong></td>

        <td align="left" colspan="4"><?=$x['cidade_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>REFER&Ecirc;NCIA:</strong></td>

        <td align="left" colspan="7"><?=$x['referencia_cliente']?></td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>TELEFONE:</strong></td>

        <td align="left" colspan="7"><?=$x['telefone1_cliente']?></td>

    </tr>

	<tr>

    	<td colspan="8" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">DADOS DO PRODUTO/PE&Ccedil;AS SOLICITADAS</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>C&Oacute;D/DESC/FABR:</strong></td>

        <td align="left" colspan="7"><?=$produto_descricao?></td>

    </tr>

      <tr>

            <td align="center" bgcolor="#CAC7C6" colspan="3">PE&Ccedil;A / QTDE</td>

        <td width="12%" align="center" bgcolor="#CAC7C6">MOTIVO</td>

        <td bgcolor="#CAC7C6" colspan="4" align="center">LEGENDA DO MOTIVO</td>

        </tr>

      <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca1?></td>

            <td align="center">&nbsp;<?=$motivo1?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>1</strong></td>

        <td width="19%" align="left">Quebrado</td>

        <td width="4%" align="center" bgcolor="#CAC7C6"><strong>8</strong></td>

        <td width="13%" align="left">Rachado/lascado</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca2?></td>

            <td align="center">&nbsp;<?=$motivo2?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>2</strong></td>

          <td width="19%" align="left">Faltando/Incompleto</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>9</strong></td>

          <td width="13%" align="left">Tonalidade errada</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca3?></td>

            <td align="center">&nbsp;<?=$motivo3?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>3</strong></td>

          <td width="19%" align="left">Arranhado/Riscado</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>10</strong></td>

          <td width="13%" align="left">Mofado</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca4?></td>

            <td align="center">&nbsp;<?=$motivo4?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>4</strong></td>

          <td width="19%" align="left">Empenado</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>11</strong></td>

          <td width="13%" align="left">Falha na Montagem</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca5?></td>

            <td align="center">&nbsp;<?=$motivo5?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>5</strong></td>

          <td width="19%" align="left">Amassado</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>12</strong></td>

          <td width="13%" align="left">Modelo Errado</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca6?></td>

            <td align="center">&nbsp;<?=$motivo6?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>6</strong></td>

          <td width="19%" align="left">N&Atilde;O encaixa/ Fura&ccedil;&atilde;o errada</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>13</strong></td>

          <td width="13%" align="left">Avariado Transp.</td>

  </tr>

        <tr>

            <td align="left" colspan="3">&nbsp;<?=$peca7?></td>

            <td align="center">&nbsp;<?=$motivo7?></td>

            <td width="5%" align="center" bgcolor="#CAC7C6"><strong>7</strong></td>

          <td width="19%" align="left">Falha Pintura/Cromo/Ferrujem</td>

          <td width="4%" align="center" bgcolor="#CAC7C6"><strong>14</strong></td>

          <td width="13%" align="left">Outros- especificar</td>

  </tr>                

	<tr>

    	<td colspan="8" bgcolor="#CAC7C6" align="center" style="font-size: 16px; font-weight: bold;">RETORNO DO PEDIDO - ATRE</td>

    </tr>

	<tr>

    	<td colspan="8">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="8">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="8">&nbsp;</td>

    </tr>

	<tr>

    	<td colspan="8">&nbsp;</td>

    </tr>    

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>ASS CLIENTE:</strong></td>

        <td align="left" colspan="7">&nbsp;</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>ASS MONTADOR:</strong></td>

        <td align="left" colspan="7">&nbsp;</td>

    </tr>

	<tr>

    	<td align="left" bgcolor="#CAC7C6"><strong>DATA: _____/______</strong></td>

        <td align="center" colspan="7" bgcolor="#CAC7C6" style="font-size: 16px; font-weight: bold;">Declaro ter recebido a ASSIST&Ecirc;NCIA do m&oacute;vel acima citado com os devidos reparos.</td>

    </tr>

</table>