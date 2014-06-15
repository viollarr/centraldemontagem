<?php
include"config.php";

$y = mysql_query("SELECT * FROM ordem_montagem WHERE id_montagem = '".$_GET['id_notas']."'");

if ($x = mysql_fetch_array($y)){

	$select_montador = "SELECT * FROM montadores WHERE id_montadores = '".$x[id_montador]."'";
	$query_montador  = mysql_query($select_montador);
	$result_montador = mysql_fetch_array($query_montador);
	$montador = $result_montador['nome'];
	$id_montador_antigo = $result_montador['id_montadores'];

	$select_data = "SELECT * FROM datas WHERE n_montagens = '".$x[n_montagem]."'";
	$query_data  = mysql_query($select_data);
	$result_data = mysql_fetch_array($query_data);
	$data_faturamento = $result_data['data_faturamento'];
	$data_limite = $result_data['data_limite'];
	$data_agendamento = $result_data['agendamento'];
	$hora_agendamento = $result_data['hora_agendamento'];

	$date_faturamento = new DateTime($data_faturamento);  
	$data_faturamento = $date_faturamento->format('d/m/Y');

	$date_limite = new DateTime($data_limite);  
	$data_limite = $date_limite->format('d/m/Y');

	if($hora_agendamento == ""){
		$primeiro = '<option value="" selected="selected">.:ESCOLHA:.</option>';
	}

	else{
		$primeiro = '<option value="'.$hora_agendamento.'" selected="selected">'.$hora_agendamento.'</option>';
	}

	if($data_agendamento == "0000-00-00"){
		$data_agendamento = "dd/mm/aaaa";
		$exibicao = '<td width="199" align="left">Data limite: </td>
      <td width="360" align="left"><strong>'.$data_limite.'</strong></td>';
	}
	else{
		$date_agendamento = new DateTime($data_agendamento);  
		$data_agendamento = $date_agendamento->format('d/m/Y');
		$exibicao = '<td width="199" align="left">Data Agendamento: </td>
      <td width="360" align="left"><strong>'.$data_agendamento.' &agrave;s '.$hora_agendamento.' hr(s)</strong></td>';
	}
?>

<form name="form1" method="post" action="php/alterar_db_notas.php?id_notas=<?=$x[id_montagem]?>">
	<input type="hidden" name="editar_notas" value="1" />
	<input type="hidden" name="id_montagem" value="<?=$x[id_montagem]?>" />
    <input type="hidden" name="n_montagem" value="<?=$x[n_montagem]?>" />
    <input type="hidden" name="status" value="<?=$x[status]?>" />
    <input type="hidden" name="montador_antigo" value="<?=$id_montador_antigo?>" />
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
        <tr>
        	<td colspan="2" align="center" bgcolor="#FFFFFF">
        	<input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" />
        	</td>
        	<script language="javascript">addCampos('salvar');</script>
        </tr>
        <tr>
        	<td colspan="2" class="titulo">Alterar Montador e  Agendamento</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
		<tr>
        	<td width="199" align="left">N&deg; Ordem Montagem: </td>
      		<td width="360" align="left"><strong><?=$x[n_montagem]?></strong></td>
		</tr>
    	<tr>
        	<td width="199" align="left">Data da nota: </td>
      		<td width="360" align="left"><strong><?=$data_faturamento?></strong></td>
    	</tr>
    	<tr>
			<?=$exibicao?>
    	</tr>
    	<tr>
        	<td width="199" align="left">Nome do Montador: </td>
      		<td width="360" align="left"><strong><?=$montador?></strong></td>
    	</tr>
	  	<tr>
			<td colspan="2">&nbsp;</td>
	  	</tr>
	  	<tr>
			<td colspan="2">Esolher outro Montador</td>
	  	</tr>
      	<tr>
      		<td colspan="2">
            	<select name="montador">
        			<option value="">..::ESCOLHA::..</option>
                    <option value="NENHUM">VAZIO</option>
						<?php
                        $select_all = "SELECT * FROM montadores WHERE ativo_m = '1' ORDER BY nome ASC";
                        $query_all  = mysql_query($select_all);
                            while($b_all = mysql_fetch_array($query_all)){
                                echo '<option value="'.$b_all[id_montadores].'">'.$b_all[nome].'</option>';
                            }
                        ?>
				</select>
			</td>
       		<script language="javascript">addCampos('montador');</script>
      	</tr>
	  	<tr>
			<td colspan="2">&nbsp;</td>
	  	</tr>
	  	<tr>
		  <td colspan="2">
            	<input type="checkbox" name="repassar" value="1" /> Marque se quiser que seja disponibilizado a nota no acesso do montador.
          </td>
	  	</tr>
	  	<tr>
			<td colspan="2">&nbsp;</td>
	  	</tr>
	  	<tr>
			<td>Agendar data de Montagem</td>
        	<td>Hora</td>
	  	</tr>
      	<tr>
      		<td><input name="agendamento" id="agendamento" size="15" maxlength="10" value="<?=$data_agendamento?>" /></td>
        	<script language="javascript">addCampos('agendamento');</script>
        	<td>
                <select name="hora">
                    <?=$primeiro?>
                    <option value="COMERCIAL">COMERCIAL</option>
                    <option value="MANHÃ">MANHÃ</option>
                    <option value="TARDE">TARDE</option>
               </select>
            </td>
      	</tr>
	  	<tr>
			<td colspan="2">&nbsp;</td>
	  	</tr>
	  	<tr>
			<td align="center" colspan="2"><a href="javascript:history.go(-1)">Voltar</a></td>
	  	</tr>
    </table>
</form>		
<?php
}
?>