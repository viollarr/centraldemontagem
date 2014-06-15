<?php
include"config.php";

$select_geral = "
	SELECT 
		rpn.*,
		d.agendamento,
		d.hora_agendamento,
		es.sigla AS estado_cliente,
		cd.nome AS cidade_cliente,
		ac.status
	FROM 
		repassando_nota rpn
	INNER JOIN
		datas d
	ON
		(rpn.n_montagem = d.n_montagens)
	INNER JOIN
		estados es
	ON
		(rpn.estado_cliente = es.cod_estados)
	INNER JOIN
		cidades cd
	ON
		(rpn.cidade_cliente = cd.cod_cidades)
	INNER JOIN
		acompanhamento ac
	ON
		(rpn.id_cliente = ac.id_cliente)
	WHERE 
		rpn.id_cliente = '".$_GET['id_clientes']."'
";

//echo $select_geral;
$y = mysql_query($select_geral);

if ($x = mysql_fetch_array($y))

{


	$date_build = new DateTime($x['data_faturamento']);  
	$data_certa = $date_build->format('d/m/Y');

if($x['agendamento'] != '0000-00-00'){
	$date_build2 = new DateTime($x['agendamento']);  
	$data_certa_agendamento = $date_build2->format('d/m/Y');
}
else{
	$data_certa_agendamento = 'n&atilde;o definido';
}

?>
<form name="form1" method="post" action="php/cad_pre_avaliacao.php">
 <input type="hidden" name="editar_pre_avaliacao" value="1" />
	<input type="hidden" name="id_cliente" value="<?=$x['id_cliente']?>" />
    <input type="hidden" name="n_montagem" value="<?=$x['n_montagem']?>" />
    <div id="divdoconteudo">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
	<?php
		if($_SESSION['tipo'] == 5){
    ?>
        <tr>
            <td align="center" bgcolor="#FFFFFF" colspan="4"><?php echo($x['status'] == 'concluido')? '':'<input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" />';?></td>
        </tr>
    <?php
		}
    ?>
        <tr>
            <td align="center" class="titulo" colspan="4">Visualizar Clientes</td>
        </tr>
        <tr>
        	<td colspan="4">&nbsp;</td>
        </tr>
        <tr>
        	<td class="bold">Acompanhamento: </td>
        	<td colspan="3">
            	<select name="acompanhamento">
                	<?php if($x['status'] == 'atendimento'){ ?>
                        <option value="atendimento" <?php echo($x['status'] == 'atendimento')? 'selected="selected"':'';?> >Atendimento</option>
                        <option value="em_andamento" <?php echo($x['status'] == 'em_andamento')? 'selected="selected"':'';?>>Em Andamento</option>
                    <?php }
						elseif($x['status'] == 'em_andamento'){	
					?>
                        <option value="em_andamento" <?php echo($x['status'] == 'em_andamento')? 'selected="selected"':'';?>>Em Andamento</option>
                        <option value="concluido" <?php echo($x['status'] == 'concluido')? 'selected="selected"':'';?>>Conclu&iacute;do</option>
                    <?php }
						elseif($x['status'] == 'concluido'){
							$texto = 'Voc&ecirc; n&atilde;o pode mais alterar este status.';
					?>
                    	<option value="concluido" <?php echo($x['status'] == 'concluido')? 'selected="selected"':'';?>>Conclu&iacute;do</option>
                    <?php }
						else{
					?>
                        <option value="atendimento" <?php echo($x['status'] == 'atendimento')? 'selected="selected"':'';?> >Atendimento</option>
                        <option value="em_andamento" <?php echo($x['status'] == 'em_andamento')? 'selected="selected"':'';?>>Em Andamento</option>
                        <option value="concluido" <?php echo($x['status'] == 'concluido')? 'selected="selected"':'';?>>Conclu&iacute;do</option>
                    <?php } ?>
                </select>
                <span id="texto" style="color:#FF0000"><?=(!empty($texto))? $texto : ''?></span>
            </td>
        </tr>
        <tr>
            <td width="25%" class="bold">Data Agendamento: </td>
        	<td width="75%" colspan="3"><?=$data_certa_agendamento?></td>
        </tr>
        <tr>
            <td class="bold">Hor&aacute;rio agendamento:</td>
        	<td><?php echo ($x['hora_agendamento'] != "")? $x['hora_agendamento']: 'n&atilde;o definido';?></td>
        </tr>
        <tr>
            <td class="bold">Data Faturamento:</td>
        	<td colspan="3"><?=$data_certa?></td>
        </tr>
        <tr>
            <td class="bold">V.Montagem:</td>
        	<td colspan="3"><?=$x['n_montagem']?></td>
        </tr>
        <tr>
            <td class="bold">Pedido:</td>
        	<td colspan="3"><?=$x['orcamento']?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Nome Completo: </td>
            <td align="left" colspan="3"><?=htmlentities($x[nome_cliente])?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Endere&ccedil;o: </td>
            <td align="left" colspan="3"><?=htmlentities($x[endereco_cliente])?></td>
        </tr>
        <tr>
            <td align="left" class="bold">N&deg;:</td>
            <td align="left" colspan="3"><?=$x[numero_cliente]?><?php echo ($x['complemento_cliente'] != "")? ' - <strong>Comp.: </strong>'.$x['complemento_cliente']:'' ?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Bairro: </td>
            <td align="left" colspan="3"><?=strtoupper(strtr(strtoupper(utf8_encode(strtoupper($x['bairro_cliente']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"))?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Cidade</td>
            <td align="left" colspan="3"><?=strtoupper(strtr(strtoupper(utf8_encode(strtoupper($x['cidade_cliente']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"))?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Estado: </td>
            <td align="left" colspan="3"><?=$x['estado_cliente']?></td>
        </tr>
        <tr>
            <td align="left" class="bold">Telefone1: </td>
            <td align="left" colspan="3">
                <?=$x["telefone1_cliente"]?>
                <?php echo ($x["telefone2_cliente"] != "")? '&nbsp;&nbsp;<strong>Telefone2:</strong>&nbsp;'.$x["telefone2_cliente"]:'';
                echo ($x["telefone3_cliente"] != "")? '&nbsp;&nbsp;<strong>Telefone3:</strong>&nbsp;'.$x["telefone3_cliente"]:""; ?>
            </td>
        </tr>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" class="bold" colspan="4">Produto(s)</td>
		</tr>
        <?php
			for($i=1;$i<=20;$i++){
				$nome = 'produto_cliente'.$i;
				if($x[$nome]!= ""){
		?>
        <tr>
            <td align="left" class="bold">Produto: </td>
            <td align="left" colspan="3"><?=$x[$nome]?></td>
        </tr>
        <? }} ?>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="4"><a href="javascript:history.go(-1)">Voltar</a></td>
		</tr>
      </table>
      </div>
</form>

<?php		
}
?>