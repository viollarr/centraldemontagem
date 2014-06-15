<?php

include "config.php";



$select = "SELECT c.prioridade, c.tipo, c.nome_cliente, c.orcamento, d.data_saida_montador, d.data_entrega_montador, d.data_final, o.porcentagem, o.n_montagem, o.comentario, o.status, o.id_montador, o.id_montagem FROM ordem_montagem o, datas d, clientes c WHERE o.id_montagem = '".$_GET['id_montagem']."' AND (c.n_montagem = o.n_montagem AND c.n_montagem = d.n_montagens AND o.n_montagem = d.n_montagens )";

//echo $select;

$y = mysql_query($select);

$z= mysql_num_rows($y);

$x = mysql_fetch_array($y);

//echo $z;

$select_montador = "SELECT * FROM montadores WHERE id_montadores = '$x[id_montador]' ";

$query_montador = mysql_query($select_montador);

$result = mysql_fetch_array($query_montador);





$data_saida = new DateTime($x[data_saida_montador]);  

$data_saida = $data_saida->format('d/m/Y');





if(($x["status"] != '2')&&($x["status"] != '0')){

$data_entrega = new DateTime($x[data_entrega_montador]);  

$data_entrega = $data_entrega->format('d/m/Y');



$data_final = new DateTime($x[data_final]);  

$data_final = $data_final->format('d/m/Y');



$data_montagem = "value='$data_final'";

$baixado = "Esta nota j&aacute; foi avaliada no dia $data_entrega";

$comentario = $x["comentario"];

}else{

$data_montagem = "value='dd/mm/aaaa'";

$comentario = "";

}

if($x["porcentagem"] != 0){

	$vintePor = ' checked="checked"';

}

else{

	$vintePor2 = ' checked="checked"';

}



?>

<form name="form1" method="post" action="php/alterar_db_baixas.php" enctype="multipart/form-data">

 <input type="hidden" name="editar_montagem" value="1" />

	<input type="hidden" name="id_montagem" value="<?=$x[id_montagem]?>" />

    <input type="hidden" name="id_montador" value="<?=$x[id_montador]?>" />

    <input type="hidden" name="quem_avalia" value="<?=$_SESSION['id_usuario']?>" />

<table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">

          <tr>

		    <td align="center" bgcolor="#FFFFFF" colspan="2"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" />&nbsp;&nbsp;<a href="assistencia_tecnica.php?n=<?=$x[n_montagem]?>" target="_blank" title="Criar E-mail de ASSIST&Ecirc;NCIA"><img src="../img/email.png" border="0" /></a></td>

            <script language="javascript">addCampos('salvar');</script>

          </tr>

		  <tr>

            <td align="center" class="titulo" colspan="2">Validar as Montagens</td>

          </tr>

		  <tr>

            <td align="center" colspan="2">&nbsp;</td>

          </tr>

          <tr>

          	<td>Vale Montagem N&deg;: <strong><?=$x[n_montagem]?></strong></td>

            <td>Or&ccedil;amento N&deg;: <strong><?=$x[orcamento]?></strong></td>

          </tr>

          <tr>

          	<td colspan="2">Cliente: <strong><?=$x[nome_cliente]?></strong></td>

          </tr>

          <tr>

          	<td>Montador: <strong><?=$result[nome]?></strong></td>

            <td>Data sa&iacute;da montador: <strong><?=$data_saida?></strong></td>

          </tr>

          <tr>

          	<td colspan="2">&nbsp;</td>

          </tr>

          <tr>

          	<td colspan="2" align="center"><strong>PARA VALIDAR A NOTA FAVOR PREENCHA OS DADOS ABAIXO</strong></td>

          </tr>

          <?php

			if(($x["status"] != '2')&&($x["status"] != '0')){

		  ?>

          <tr>

          	<td colspan="2">&nbsp;</td>

          </tr>         

          <tr>

          	<td colspan="2" align="center"><h3 style="color: #FF0000;"><b><blink><?=$baixado?></blink></b></h3></td>

          </tr>

          <?php

		  }

		  ?>      

          <tr>

          	<td colspan="2">&nbsp;</td>

          </tr> 

          <tr>

          	<td colspan="2">Adicionar 20% a nota: <input type="radio" name="vinte"<?=$vintePor?> value="1" /> SIM    <input type="radio" name="vinte"<?=$vintePor2?> value="0" /> N&Atilde;O</td>

          </tr>         

          <tr>

          	<td colspan="2">Data da Montagem: <input type="text" name="data_final" maxlength="10" size="15" <?=$data_montagem?> onkeyup="barra(this)" /></td>

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

                		echo'<option value="4">N&Atilde;O MONTADO</option>';

						echo'<option value="1">MONTADO COM ASSIST&Ecirc;NCIA</option>';

						echo'<option value="6">AUSENTE</option>';

					}

					elseif($x["tipo"] == 1){

						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';

						echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';

						echo'<option value="6">AUSENTE</option>';

					}

					elseif($x["tipo"] == 2){

						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';

						echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';

						echo'<option value="6">AUSENTE</option>';

					}

					elseif($x["tipo"] == 3){

						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';

						echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';

						echo'<option value="6">AUSENTE</option>';

					}					

				}

				elseif(($x["prioridade"] == 2)){

					if($x["tipo"] == 0){

						echo'<option value="5">JUSTI&Ccedil;A EXECUTADA</option>';

						echo'<option value="10">JUSTI&Ccedil;A N&Atilde;O EXECUTADA</option>';

					}

					elseif($x["tipo"] == 1){

						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';

						echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';

					}

					elseif($x["tipo"] == 2){

						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';

						echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';

					}

					elseif($x["tipo"] == 3){

						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';

						echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';

					}

				}

				elseif(($x["prioridade"] == 4)){

					if($x["tipo"] == 0){

						echo'<option value="3">MONTADO</option>';

                		echo'<option value="4">N&Atilde;O MONTADO</option>';

					}

					elseif($x["tipo"] == 1){

						echo'<option value="9">DESMONTAGEM EXECUTADA</option>';

						echo'<option value="13">DESMONTAGEM N&Atilde;O EXECUTADA</option>';

					}

					elseif($x["tipo"] == 2){

						echo'<option value="7">REVIS&Atilde;O EXECUTADA</option>';

						echo'<option value="11">REVIS&Atilde;O N&Atilde;O EXECUTADA</option>';

					}

					elseif($x["tipo"] == 3){

						echo'<option value="8">T&Eacute;CNICA EXECUTADA</option>';

						echo'<option value="12">T&Eacute;CNICA N&Atilde;O EXECUTADA</option>';

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

          	<td colspan="2"><textarea name="comentario" cols="60" rows="10" onchange="this.value = this.value.toUpperCase();"><?=$comentario?></textarea></td>

          </tr>

		  <tr>

            <td colspan="2">&nbsp;</td>

          </tr>

          <tr>

          	<td colspan="2"><strong>Para enviar email solicitando pe&ccedil;a de ASSIST&Ecirc;NCIA clique abaixo</strong></td>

          </tr>

          <tr>

          	<td colspan="2" align="center"><br /><a href="assistencia_tecnica.php?n=<?=$x[n_montagem]?>" target="_blank" title="Criar E-mail de ASSIST&Ecirc;NCIA"><img src="../img/email.png" border="0" /></a></td>

          </tr>

		  <tr>

            <td colspan="2">&nbsp;</td>

          </tr>

      </table>

</form>

