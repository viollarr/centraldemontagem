<?php
include "config.php";

if(strlen($_POST['escritorio'])>0){
	$select_mont = "SELECT * FROM ordem_montagem WHERE n_montagem = '".$_POST['vlm']."' LIMIT 0,1";
	$query_mont = mysql_query($select_mont);
	$result_mont = mysql_fetch_array($query_mont);
	$id_montador = $result_mont['id_montador'];
}
else{
	$id_montador = $_SESSION['id_montador'];	
}

$select = "
	SELECT 
		c.prioridade, 
		c.tipo, 
		c.nome_cliente, 
		c.orcamento, 
		d.data_saida_montador,
		d.data_entrega_montador,
		o.n_montagem, 
		o.status, 
		o.id_montador, 
		o.id_montagem
	FROM 
		ordem_montagem o, 
		datas d, 
		clientes c 
	WHERE 
		o.n_montagem = '".$_POST['vlm']."' AND 
		(	
			c.n_montagem = o.n_montagem AND 
			c.n_montagem = d.n_montagens AND 
			o.n_montagem = d.n_montagens 
		) AND 
		d.data_entrega_montador = '0000-00-00' AND
		o.id_montador = '".$id_montador."'
	LIMIT 
		0,1";

//echo $select;
//exit;

$y = mysql_query($select);
$z= mysql_num_rows($y);
$x = mysql_fetch_array($y);

if($z > 0){
	
	$select_pre = "SELECT * FROM pre_baixas WHERE n_montagem = '".$_POST['vlm']."'";
	$query_pre  = mysql_query($select_pre);
	$rows_pre = mysql_num_rows($query_pre);
	
	if($rows_pre == 0){
//echo $z;
$select_montador = "SELECT * FROM montadores WHERE id_montadores = '$x[id_montador]' ";
$query_montador = mysql_query($select_montador);
$result = mysql_fetch_array($query_montador);

$data_saida = new DateTime($x['data_saida_montador']);  
$data_saida = $data_saida->format('d/m/Y');


?>
<form name="form1" method="post" action="php/alterar_db_baixas_montadores.php" enctype="multipart/form-data">
	<input type="hidden" name="editar_montagem" value="1" />
	<input type="hidden" name="id_montagem" value="<?=$x['id_montagem']?>" />
    <input type="hidden" name="id_montador" value="<?=$x['id_montador']?>" />
    <input type="hidden" name="n_montagem" value="<?=$_POST['vlm']?>" />
<table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
          <tr>
		    <td align="center" bgcolor="#FFFFFF" colspan="2"><input type="image" src="img/ico_salvar.jpg" title="Salvar" alt="Salvar" name="salvar" /></td>
            <script language="javascript">addCampos('salvar');</script>
          </tr>
		  <tr>
            <td align="center" class="titulo" colspan="2">Pré Validar as Montagens</td>
          </tr>
		  <tr>
            <td align="center" colspan="2">&nbsp;</td>
          </tr>
          <tr>
          	<td>Vale Montagem N&deg;: <strong><?=$x['n_montagem']?></strong></td>
            <td>Or&ccedil;amento N&deg;: <strong><?=$x['orcamento']?></strong></td>
          </tr>
          <tr>
          	<td colspan="2">Cliente: <strong><?=$x['nome_cliente']?></strong></td>
          </tr>
          <tr>
          	<td>Montador: <strong><?=$result['nome']?></strong></td>
            <td>Data sa&iacute;da montador: <strong><?=$data_saida?></strong></td>
          </tr>
          <tr>
          	<td colspan="2">&nbsp;</td>
          </tr>
          <tr>
          	<td colspan="2" align="center"><strong>PARA VALIDAR A NOTA FAVOR PREENCHA OS DADOS ABAIXO</strong></td>
          </tr>
          <tr>
          	<td colspan="2">&nbsp;</td>
          </tr> 
          <tr>
          	<td colspan="2">Data da Montagem: <input type="text" name="data_final" maxlength="10" size="15" onkeyup="barra(this)" value="dd/mm/aaaa" /></td>
          </tr>
          <tr>
          	<td colspan="2">Selecione o processo da nota:

           	<select name="valida">
                <?php
				if(($x["status"]=='3') || ($x["status"]=='1')){
					if($X["status"]=="3"){
						echo '<option value="3" selected="selected">MONTADO</option>';
					}else{
						echo '<option value="1" selected="selected">MONTADO COM ASSIST&Ecirc;NCIA</option>';
					}
				}else{
					echo '<option value="" selected="selected">-==ESCOLHA==-</option>';
				}
				
				if($x["prioridade"] == 0){
					if($x["tipo"] == 0){
						echo'<option value="3">MONTADO</option>';
						echo'<option value="1">MONTADO COM ASSIST&Ecirc;NCIA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="4">N&Atilde;O MONTADO</option>';
							echo'<option value="6">AUSENTE</option>';
						}
					}
					elseif($x["tipo"] == 1){
						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';
							echo'<option value="6">AUSENTE</option>';
						}
					}
					elseif($x["tipo"] == 2){
						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';
							echo'<option value="6">AUSENTE</option>';
						}
					}
					elseif($x["tipo"] == 3){
						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';
							echo'<option value="6">AUSENTE</option>';
						}
					}					
				}
				elseif(($x["prioridade"] == 2)){
					if($x["tipo"] == 0){
						echo'<option value="5">JUSTI&Ccedil;A EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="10">JUSTI&Ccedil;A N&Atilde;O EXECUTADA</option>';
						}
					}
					elseif($x["tipo"] == 1){
						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';
						}
					}
					elseif($x["tipo"] == 2){
						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';
						}
					}
					elseif($x["tipo"] == 3){
						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';
						}
					}
				}
				elseif(($x["prioridade"] == 4)){
					if($x["tipo"] == 0){
						echo'<option value="3">MONTADO</option>';
						if($_SESSION['tipo'] == 5){
                			echo'<option value="4">N&Atilde;O MONTADO</option>';
						}
					}
					elseif($x["tipo"] == 1){
						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';
						}
					}
					elseif($x["tipo"] == 2){
						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';
						}
					}
					elseif($x["tipo"] == 3){
						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';
						if($_SESSION['tipo'] == 5){
							echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';
						}
					}
				}
				?>
                </select>
            </td>
          </tr>
          <tr>
          	<td colspan="2">Coment&aacute;rios:</td>
          </tr>
          <tr>
          	<td colspan="2"><textarea name="comentario" cols="60" rows="10" onkeypress="this.value = this.value.toUpperCase();" onchange="this.value = this.value.toUpperCase();"></textarea></td>
          </tr>
		  <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
      </table>
</form>
<?php
	}
	else{
?>
<table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">Este vale montagem já foi pré avaliado.</td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
    </tr>
</table>
<?php	
	}
}
else{
?>
<table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">Vale Montagem Indisponivel para Baixa.</td>
    </tr>
    <tr>
        <td align="center" bgcolor="#FFFFFF" colspan="2">&nbsp;</td>
    </tr>
</table>
<?php
}
?>