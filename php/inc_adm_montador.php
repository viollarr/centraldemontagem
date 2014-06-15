<?php
include"config.php";

$y = mysql_query("SELECT * FROM montadores WHERE id_montadores = '".$_SESSION['id_montador']."'");

if ($x = mysql_fetch_array($y)){

	if($x['admissao'] !="0000-00-00" ){

		$ad = $x[admissao];
		$ad = new DateTime($ad);  
		$ad = $ad->format('d/m/Y');
	}
	if($x['demissao'] !="0000-00-00" ){

		$de = $x[demissao];
		$de = new DateTime($de);  
		$de = $de->format('d/m/Y');
	}

	
	$select_mont = "SELECT * FROM usuarios WHERE id_montador = '".$x[id_montadores]."'";
	$c = mysql_query($select_mont);
	$rows_mont = mysql_num_rows($c);
	$d = mysql_fetch_array($c);

?>

	<table width="570" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
		<tr>
			<td align="center" class="titulo" colspan="3">:: Seja Bem Vindo <?=htmlentities($x['nome'])?> ::</td>
		</tr>
        <?php
		if($x['foto'] != ""){
		?>
		<tr>
			<td align="center" colspan="3"><img src="foto/<?=$x['foto']?>" border="0" width="100"  /></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td width="10%" align="left"><b>Nome Completo:</b>&nbsp;</td>
			<td width="50%" align="left"><?=htmlentities($x[nome])?></td>
            <td width="40%" align="left"><b>Login:</b>&nbsp;&nbsp;<?=$d[login];?></td> 
		</tr>
        <tr>
        	<td align="left"><b>Rota:</b>&nbsp;</td>
            <td align="left" colspan="2"> <?=htmlentities($x['rota'])?></td>
        </tr>
		<tr>
        	<td align="left"><b>Banco:</b>&nbsp;</td>
			<td align="left"><?=$x['banco']?></td>
            <td align="left"><b>Nome Conta:</b>&nbsp;&nbsp;<?=htmlentities($x['nome_conta'])?>
        	</td>
		</tr>
		<tr>
        	<td align="left"><b>Ag.:</b>&nbsp;</td>
        	<td align="left"><?=$x['ag']?></td>
        	<td align="left"><b>Conta:</b>&nbsp;&nbsp;<?=$x['conta']?>
     	</tr>
    	<tr>
        	<td align="left"><b>Data Nascimento:</b>&nbsp;</td>
        	<td align="left" colspan="2"><?=$x['data_nascimento']?></td>
    	</tr>
    	<tr>
        	<td align="left"><b>RG:</b>&nbsp;</td>
        	<td align="left"><?=$x['rg']?></td>
            <td align="left"><b>CPF:</b>&nbsp;&nbsp;<?=$x[cpf]?></td>
		</tr>
		<tr>
			<td align="left"><b>Endereço:</b>&nbsp;</td>
			<td align="left" colspan="2"><?=htmlentities($x[rua])?>, <b>nº:</b> <?=$x[numero]?></td>
        </tr>
        <tr>
			<td align="left"><b>Comp.:</b>&nbsp;</td>
		  	<td align="left" colspan="2"><?=htmlentities($x[comp])?></td>
		</tr>
		<tr>
			<td align="left"><b>Bairro:</b>&nbsp;</td>
			<td align="left"><?=htmlentities($x[bairro])?></td>
            <td align="left"><b>CEP:</b>&nbsp;&nbsp;<?=$x[cep]?></td>
        </tr>
        <tr>
            <td align="left"><b>Cidade:</b>&nbsp;</td>
			<td align="left"><?=$x[cidade]?></td>
            <td align="left"><b>Estado:</b>&nbsp;&nbsp;<?=$x[estado]?></td>
		</tr>
		<tr>
			<td align="left"><b>Telefone:</b>&nbsp;</td>
			<td align="left"><?=$x[telefone]?></td>
			<td align="left"><b>Celular:</b>&nbsp;&nbsp;<?=$x[celular]?></td>
		</tr>
		<tr>
			<td align="left"><b>Email:</b>&nbsp;</td>
			<td align="left" colspan="4"><?=$x[email]?></td>
		</tr>
            <?php
				if($x[atendimento] != ""){
			?>
		<tr>
			<td colspan="3">
				<table width="100%">
					<tr>
						<td align="left">Áreas que ele atende: </td>
					</tr>
					<tr>
						<td valign="top">
						<?php
							$rows_bairross = explode(';',$x[atendimento]);
							$contagem = count($rows_bairross);
							$contagem_bairros = $contagem;
							for ($i=0;$i<($contagem-1);$i++){
								$select = 'SELECT * FROM bairros WHERE id_bairros = "'.$rows_bairross[$i].'"';
								$query= mysql_query($select);
								$a = mysql_fetch_array($query);
								echo ' '.htmlentities($a[nome]);
								if($i < ($contagem-2)){
									echo ' /';
								}
							}
						$contagem_geral = ($contagem - 1);
						?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		 <?php
            }
         ?>
		<tr>
			<td colspan="3">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="3"><b>obs: </b>Se houver alguma informação acima que não esteje correta, favor entrar em contato com a Montadora para atualizar os dados.</td>
		</tr>
      </table>
<?php
}
?>