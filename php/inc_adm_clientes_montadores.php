<?php

include"config.php";	

	$select_paginacao = "
		SELECT 
			rpn.id_cliente,
			rpn.nome_cliente, 
			c.prioridade,
			rpn.bairro_cliente,
			ac.status
		FROM 
			repassando_nota rpn
		INNER JOIN
			clientes c
		ON
			(rpn.n_montagem = c.n_montagem)
		INNER JOIN
			acompanhamento ac
		ON
			(rpn.id_cliente = ac.id_cliente)
		WHERE 
			rpn.id_montador = '".$_SESSION['id_montador']."' AND
			rpn.imprimir = '1'
		ORDER BY 
			c.prioridade DESC, 
			rpn.nome_cliente ASC";
			

	$sql = mysql_query($select_paginacao);
	$rows = mysql_num_rows($sql);

?>

<table width='550' border='0' cellpadding='1' cellspacing='1'>
    <tr>
        <td class='titulo' colspan="3">:: Administrar Clientes ::</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>		
    <tr>
        <td class='texto2' width='60%'><b>Nome</b></td>
        <td class='texto2' width='30%'><b>Bairro</b></td>
        <td class='texto2' width='10%'><b>Status</b></td>

    </tr>
	<?php
		if($rows > 0){
			while ($linha = mysql_fetch_array($sql)){
				
				$id_clientes  	= $linha["id_cliente"];
				$bairro	 		= $linha["bairro_cliente"];
				$nome_cliente	= $linha["nome_cliente"];
				$prioridade		= $linha["prioridade"];
				
				if($linha['status'] == 'atendimento')$status = 'Atendimento';
				elseif($linha['status'] == 'em_andamento')$status = 'Em Andamento';
				elseif($linha['status'] == 'concluido')$status = 'Conclu&iacute;do';
				else $status = '';
				
				if($prioridade == 1){$color = 'bgcolor="#C7DAFE"';}
				elseif($prioridade == 2){$color = 'bgcolor="#FFB3B3"';}
				elseif($prioridade == 3){$color = 'bgcolor="#C3C0BE"';}
				elseif($prioridade == 4){$color = 'bgcolor="#DBDC7C"';}
				else{$color = '';}
    ?>		
    <tr <?=$color?>>
        <td class='texto'><a href='vis_clientes_montador.php?id_clientes=<?=$id_clientes?>'><?=$nome_cliente?></a></td>
        <td class='texto'><a href='vis_clientes_montador.php?id_clientes=<?=$id_clientes?>'><?=$bairro?></a></td>
        <td class='texto'><a href='vis_clientes_montador.php?id_clientes=<?=$id_clientes?>'><?=$status?></a></td>
    </tr>		
	<?php 
		}
			}
		else{
	?>	
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>		
    <tr>
        <td colspan="3" align="center">Voc&ecirc; n&atilde;o possui fichas em aberto.</td>
    </tr>
    <?php
		}
	?>	
    		
</table>

