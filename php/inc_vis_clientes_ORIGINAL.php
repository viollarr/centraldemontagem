<?php

include"config.php";



$y = mysql_query("SELECT * FROM clientes WHERE id_cliente = '".$_GET['id_clientes']."'");

if ($x = mysql_fetch_array($y))



{



$quem_cadastrou = $x[id_usuario_cadastro];



if($quem_cadastrou != 0){

	

	$select_cadastro= "SELECT * FROM usuarios WHERE id = '$quem_cadastrou'";

	$query_cadastro = mysql_query($select_cadastro);

	$res_cadastro 	= mysql_fetch_array($query_cadastro); 

	

	$data_cadastrou = $x[data_hora_cadastro];

	$data_cadastrou_date = new DateTime($data_cadastrou);  

	$data_cadastrou_date = $data_cadastrou_date->format('d/m/Y');

	

	$hora_cadastrou = $data_cadastrou;

	$hora_cadastrou = new DateTime($hora_cadastrou);  

	$hora_cadastrou = $hora_cadastrou->format('H:i');

	

	$cadastrado_por = "Cadastrado por: <b>".$res_cadastro['nome']."</b> no dia  <b>".$data_cadastrou_date."</b> &agrave;s <b>".$hora_cadastrou."</b>";

}



$quem_modificou = $x[id_usuario_modificacao];



if($quem_modificou != 0){

	

	$select_modificacao= "SELECT * FROM usuarios WHERE id = '$quem_modificou'";

	$query_modificacao = mysql_query($select_modificacao);

	$res_modificacao 	= mysql_fetch_array($query_modificacao); 

	

	$data_modificacao = $x[data_hora_modificacao];

	$data_modificacao_date = new DateTime($data_modificacao);  

	$data_modificacao_date = $data_modificacao_date->format('d/m/Y');

	

	$hora_modificacao = $data_modificacao;

	$hora_modificacao = new DateTime($hora_modificacao);  

	$hora_modificacao = $hora_modificacao->format('H:i');

	

	$modificado_por = "Alterado por: <b>".$res_modificacao['nome']."</b> no dia  <b>".$data_modificacao_date."</b> &agrave;s <b>".$hora_modificacao."</b>";

}

 

$quem_avaliou = $x[id_usuario_avaliacao];



if($quem_avaliou != 0){

	

	$select_avaliacao= "SELECT * FROM usuarios WHERE id = '$quem_avaliou'";

	$query_avaliacao = mysql_query($select_avaliacao);

	$res_avaliacao 	= mysql_fetch_array($query_avaliacao); 

	

	$data_avaliacao = $x[data_hora_avaliacao];

	$data_avaliacao_date = new DateTime($data_avaliacao);  

	$data_avaliacao_date = $data_avaliacao_date->format('d/m/Y');

	

	$hora_avaliacao = $data_avaliacao;

	$hora_avaliacao = new DateTime($hora_avaliacao);  

	$hora_avaliacao = $hora_avaliacao->format('H:i');

	

	$avaliado_por = "Avaliado por: <b>".$res_avaliacao['nome']."</b> no dia  <b>".$data_avaliacao_date."</b> &agrave;s <b>".$hora_avaliacao."</b>";

}



$prioridade = $x[prioridade];

if($prioridade == 0){ $check0 = 'checked="checked"';}

elseif($prioridade == 2){$check2 = 'checked="checked"';}

elseif($prioridade == 4){$check4 = 'checked="checked"';}



$tipo_pessoa = $x[tipo];



if($tipo_pessoa == 0){$tipo1 = 'checked="checked"';}

elseif($tipo_pessoa == 1){$tipo2 = 'checked="checked"';}

elseif($tipo_pessoa == 2){$tipo3 = 'checked="checked"';}

elseif($tipo_pessoa == 3){$tipo6 = 'checked="checked"';}





$date_build = new DateTime($x[data_faturamento]);  

$data_certa = $date_build->format('d/m/Y');



$select_montador = "SELECT * FROM ordem_montagem WHERE n_montagem = '".$x[n_montagem]."'";

$query_montador  = mysql_query($select_montador);

$rows_montador = mysql_num_rows($query_montador);

if($rows_montador > 0 ){

	$a = mysql_fetch_array($query_montador);

	if($a[status] == 1 ){$status_baixa = "MONTADO COM ASSIST&Ecirc;NCIA";  $assis = $a['status'];}

	elseif($a[status] == 3 ){$status_baixa = "MONTADO";}

	elseif($a[status] == 4 ){$status_baixa = "N&Atilde;O MONTADO";}

	elseif($a[status] == 5 ){$status_baixa = "JUSTI&Ccedil;A EXECUTADA";}

	elseif($a[status] == 6 ){$status_baixa = "AUSENTE";}

	elseif($a[status] == 7 ){$status_baixa = "REVIS&Atilde;O EXECUTADA";}

	elseif($a[status] == 8 ){$status_baixa = "T&Eacute;CNICA EXECUTADA";}

	elseif($a[status] == 9 ){$status_baixa = "DESMONTAGEM EXECUTADA";}

	elseif($a[status] == 10 ){$status_baixa = "JUSTI&Ccedil;A N&Atilde;O EXECUTADA";}

	elseif($a[status] == 11 ){$status_baixa = "REVIS&Atilde;O N&Atilde;O EXECUTADA";}

	elseif($a[status] == 12 ){$status_baixa = "T&Eacute;CNICA N&Atilde;O EXECUTADA";}

	elseif($a[status] == 13 ){$status_baixa = "DESMONTAGEM N&Atilde;O EXECUTADA";}

	$select_nome = "SELECT * FROM montadores WHERE id_montadores = '".$a[id_montador]."'";

	$query_nome = mysql_query($select_nome);

	$rows_nome = mysql_num_rows($query_nome);

	

		$b = mysql_fetch_array($query_nome);

		$select_data = "SELECT * FROM datas WHERE n_montagens = '".$x[n_montagem]."'";

		$query_data = mysql_query($select_data);

		$c = mysql_fetch_array($query_data);

		

		$data_montadorr = new DateTime($c[data_saida_montador]);  

		$data_montador = $data_montadorr->format('d/m/Y');

		

		$data_limite = new DateTime($c[data_limite]);  

		$data_limite = $data_limite->format('d/m/Y');

		

		$data_baixa = new DateTime($c[data_final]);  

		$data_baixa = $data_baixa->format('d/m/Y');



		

	

			if(strlen($a["comentario"])>0){

				$comentario = "<tr><td colspan='4'>Coment&aacute;rio:<br /><textarea name='referencia_cliente' rows='5' cols='40' tabindex='16'>".$a['comentario']."</textarea></td></tr>";

			}else{

				$comentario = "";

			}

		

	if($rows_nome > 0){



		$montador  = "Nome: <strong>";

		$montador .= $b[nome];

		$montador .= "</strong>&nbsp;&nbsp;&nbsp;&nbsp;Telefone: <strong>";

		$montador .= $b[telefone];

		$montador .= "</strong>&nbsp;&nbsp;&nbsp;&nbsp;Celular: <strong>";

		$montador .= $b[celular];

		$montador .= "</strong><br /><br />";

		$montador .= "A Ordem de Montagem foi entregue ao montador no dia <strong>";

		$montador .= $data_montador;

		$montador .= "</strong><br>";

		if($c[data_final] == '0000-00-00'){

			if($c[agendamento] != '0000-00-00'){

				$montador .= "A Montagem foi agendada para <strong>";

				$montador .= $data_agendamento;

				$montador .= "</strong> hor&aacute;rio:  <strong>";

				$montador .= $c[hora_agendamento];

				$montador .= "</strong>";

			}

			else{

				$montador .= "A data m&aacute;xima para montagem &eacute; <strong>";

				$montador .= $data_limite;

				$montador .= "</strong>";

			}

		}

		else{

			$montador .= "<span style='color: #FF0000;'>A montagem foi feita no dia <strong>$data_baixa</strong> e foi avaliada como <strong>$status_baixa</strong></span>";

		}

	}

	else{

		$montador  = "Ainda N&Atilde;O consta um montador para essa Ordem de Montagem<br>";

		if($c[agendamento] != '0000-00-00'){

		$montador .= "A Montagem foi agendada para <strong>";

		$montador .= $data_agendamento;

		$montador .= "</strong> hor&aacute;rio:  <strong>";

		$montador .= $c[hora_agendamento];

		$montador .= "</strong>";

		}

		else{

		$montador .= "A data m&aacute;xima para montagem &eacute; <strong>";

		$montador .= $data_limite;

		$montador .= "</strong>";

		}

	}

	

	$select_loja = "SELECT * FROM lojas WHERE cod_loja = '".$x[cod_loja]."'";

	//echo $select_loja;

	$query_loja = mysql_query($select_loja);

	$rows_loja = mysql_num_rows($query_loja);

	//echo $rows_loja;

	if($rows_loja > 0){

		$b = mysql_fetch_array($query_loja);

		

		$loja  = "Filial: <strong>";

		$loja .= $b[cod_loja];

		$loja .= "</strong>&nbsp;&nbsp;&nbsp;&nbsp;Loja: <strong>";

		$loja .= $b[nome_loja];

		$loja .= "</strong>&nbsp;&nbsp;&nbsp;&nbsp;Gerente: <strong>";

		$loja .= $b[gerente_loja];

		$loja .= "</strong>&nbsp;&nbsp;&nbsp;&nbsp;Telefones: <strong>";

		$loja .= $b[tel_loja];

		if(strlen($b[tel2_loja])>0){ $loja .= " / ".$b[tel2_loja];}

		if(strlen($b[tel3_loja])>0){ $loja .= " / ".$b[tel3_loja];}

		if(strlen($b[tel4_loja])>0){ $loja .= " / ".$b[tel4_loja];}

		$loja .= "</strong>";

	}

}

?>

<form name="form1" method="post" action="php/alterar_db_clientes.php?id_clientes=<?=$x[id_cliente]?>">

 <input type="hidden" name="editar_clientes" value="1" />

	<input type="hidden" name="id_clientes" value="<?=$x[id_cliente]?>" />

    <input type="hidden" name="quem_modifica" value="<?=$_SESSION['id_usuario']?>" />

    <div id="divdoconteudo">

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">

          <tr>

		    <td align="center" bgcolor="#FFFFFF" colspan="4"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /><a onclick="printDiv('divdoconteudo','janela');" style="margin-left:20px;"><img src="img/impressora.png" border="0" /></a></td>

            <script language="javascript">addCampos('salvar');</script>

          </tr>

		  <tr>

            <td align="center" class="titulo" colspan="4">Visualizar Clientes</td>

          </tr>

      	<?php

			if(strlen($cadastrado_por)>0){

				echo '<tr><td align="left" colspan="4">'.$cadastrado_por.'</td></tr>';

			}

			if(strlen($modificado_por)>0){

				echo '<tr><td align="left" colspan="4">'.$modificado_por.'</td></tr>';

			}

			if(strlen($avaliado_por)>0){

				echo '<tr><td align="left" colspan="4">'.$avaliado_por.'</td></tr>';

			}

		?>

        	<tr><td colspan="4">&nbsp;</td></tr>

          <tr>

            <td width="101"><strong>Prioridade</strong>: </td>

            <td width="227" colspan="3">

                <input type="radio" name="prioridade" id="prioridade" <?=$check0?> value="0" /><strong>NORMAL</strong>&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="radio" name="prioridade" id="prioridade" <?=$check2?> value="2" /><strong>JUSTI&Ccedil;A</strong>&nbsp;&nbsp;&nbsp;&nbsp;

                <input type="radio" name="prioridade" id="prioridade" <?=$check4?> value="4" /><strong>LOJA</strong>

                <script language="javascript">addCampos('prioridade');</script>

            </td>

          </tr>

      <tr><td colspan="4">&nbsp;</td></tr>

      <tr>

      	<td align="left" colspan="4">

        	<input type="radio" name="tipo" <?=$tipo1?> value="0" /> Montagem<br />

            <input type="radio" name="tipo" <?=$tipo2?> value="1" /> Desmontagem<br />

            <input type="radio" name="tipo" <?=$tipo3?> value="2" /> Revis&atilde;o<br />

            <input type="radio" name="tipo" <?=$tipo6?> value="3" /> T&eacute;cnica<br />

        </td>

      </tr>

      <tr><td colspan="4">&nbsp;</td></tr>

		  <tr>

			<td width="101">N&deg; Ordem de Montagem:</td>

			<td width="227"><input type="text" size="20" name="n_montagem" id="n_montagem" value="<?=$x[n_montagem]?>" tabindex="1" onKeyUp="nu(this)" /></td>

            <script language="javascript">addCampos('n_montagem');</script>

			<td width="131">Loja:</td>

			<td width="332"><input type="text" size="5" maxlength="2" name="cod_loja" value="<?=$x[cod_loja]?>" id="cod_loja" tabindex="2" onchange="this.value = this.value.toUpperCase();" /></td>

            <script language="javascript">addCampos('cod_loja');</script>

		  </tr>

		  <tr>

			<td>Or&ccedil;amento:</td>

			<td width="227"><input type="text" size="20" name="orcamento" id="orcamento" value="<?=$x[orcamento]?>" tabindex="3" onKeyUp="nu(this)" /></td>

            <script language="javascript">addCampos('orcamento');</script>

			<td>Data Faturamento:</td>

			<td width="227"><input type="text" size="20" name="data_faturamento" id="data_faturamento" value="<?=$data_certa?>" tabindex="4" onkeypress="barra(this)" /></td>

            <script language="javascript">addCampos('data_faturamento');</script>

		  </tr>

		  <tr>

			<td width="104" align="left">Nome Completo: </td>

			<td align="left"><input type="text" size="35" name="nome_cliente" id="nome_cliente" value="<?=$x[nome_cliente]?>" tabindex="5" onkeyup="this.value = this.value.toUpperCase();" /></td>

            <script language="javascript">addCampos('nome_cliente');</script>

			<td align="left">CEP: </td>

			<td align="left"><input name="cep" id="cep" size="10" value="<?=$x[cep_cliente]?>" maxlength="8" onBlur="getEndereco()" tabindex="6" /></td>

            <script language="javascript">addCampos('cep');</script>

		  </tr>

		  <tr>

			<td align="left">Endere&ccedil;o: </td>

			<td align="left" colspan="3"><input name="rua" id="rua" size="60" value="<?=$x[endereco_cliente]?>" tabindex="7" onkeyup="this.value = this.value.toUpperCase();"/></td>

            <script language="javascript">addCampos('rua');</script>

          </tr>

          <tr>

            <td align="left">N&deg;:</td>

            <td align="left" colspan="3"><input type="text" name="numero" id="numero" value="<?=$x[numero_cliente]?>" size="5" tabindex="8" />

            <script language="javascript">addCampos('numero');</script>&nbsp;&nbsp;&nbsp;

			Comp.:	<input type="text" name="comp" id="comp" value="<?=$x[complemento_cliente]?>" size="10" tabindex="9" onkeyup="this.value = this.value.toUpperCase();" /></td>

            <script language="javascript">addCampos('comp');</script>

		  </tr>

		  <tr>

			<td align="left">Bairro: </td>

			<td align="left" colspan="3"><input name="bairro" id="bairro" value="<?=$x[bairro_cliente]?>" size="20" tabindex="10" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('bairro');</script>

            &nbsp;Cidade:&nbsp;<input name="cidade" id="cidade"value="<?=$x[cidade_cliente]?>" size="16" tabindex="11" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cidade');</script>

            &nbsp;Estado:&nbsp;<input name="estado" id="estado" value="<?=$x[estado_cliente]?>" size="2" maxlength="2" tabindex="12" onkeyup="this.value = this.value.toUpperCase();" /></td>

            <script language="javascript">addCampos('estado');</script>

		  </tr>

		  <tr>

			<td align="left">Telefone1: </td>

			<td align="left" colspan="3"><input type="text" name="res" id="res" value="<?=$x[telefone1_cliente]?>" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="13" />

            <script language="javascript">addCampos('res');</script>

            &nbsp;&nbsp;Telefone2:&nbsp;<input type="text" name="res2" id="res2" value="<?=$x[telefone2_cliente]?>" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="14" />

            <script language="javascript">addCampos('res2');</script>

            &nbsp;&nbsp;Telefone3:&nbsp;<input type="text" name="res3" id="res3" value="<?=$x[telefone3_cliente]?>" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="15" /></td>

            <script language="javascript">addCampos('res3');</script>

		  </tr>

		  <tr>

			<td colspan="4">

				Ponto de Refer&ecirc;ncia:<br />

				<textarea name="referencia_cliente" rows="5" cols="40" tabindex="16"><?=$x[referencia_cliente]?></textarea>        

                <script language="javascript">addCampos('referencia_cliente');</script>

			</td>

            </tr>

           	<?=$comentario?>

			<tr>

				<td colspan="4">&nbsp;</td>

			</tr>

			<tr>

				<td colspan="4"><strong>MONTADOR</strong></td>

			</tr>

			<tr>

				<td colspan="4">

					<?=$montador?>

				</td>

			<tr>

				<td colspan="4">&nbsp;</td>

			</tr>

			<tr>

				<td colspan="4"><strong>LOJA</strong></td>

			</tr>

			<tr>

				<td colspan="4">

					<?=$loja?>

				</td>

			<tr>

				<td colspan="4">&nbsp;</td>

			</tr>

			<tr>

				<td colspan="4"><strong>PRODUTOS</strong></td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente" id="qtde_cliente" value="<?=$x[qtde_cliente]?>" size="2" tabindex="17" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente" id="cod_cliente" value="<?=$x[cod_cliente]?>" size="5" tabindex="18"  onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente] == ""){

						echo '<span id="produtos"></span>';

					}

					else{

						echo '<input name="produto_cliente" id="produto_cliente" size="35" tabindex="19" value="'.$x[produto_cliente].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente2" id="qtde_cliente2" value="<?=$x[qtde_cliente2]?>" size="2" tabindex="20" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente2');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente2" id="cod_cliente2" value="<?=$x[cod_cliente2]?>" size="5" tabindex="21" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente2');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente2] == ""){

						echo '<span id="produtos2"></span>';

					}

					else{

						echo '<input name="produto_cliente2" id="produto_cliente2" size="35" tabindex="22" value="'.$x[produto_cliente2].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente3" id="qtde_cliente3" value="<?=$x[qtde_cliente3]?>" size="2" tabindex="23" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente3');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente3" id="cod_cliente3" value="<?=$x[cod_cliente3]?>" size="5" tabindex="24" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente3');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente3] == ""){

						echo '<span id="produtos3"></span>';

					}

					else{

						echo '<input name="produto_cliente3" id="produto_cliente3" size="35" tabindex="25" value="'.$x[produto_cliente3].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente4" id="qtde_cliente4" value="<?=$x[qtde_cliente4]?>" size="2" tabindex="26" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente4');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente4" id="cod_cliente4" value="<?=$x[cod_cliente4]?>" size="5" tabindex="27" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente4');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente4] == ""){

						echo '<span id="produtos4"></span>';

					}

					else{

						echo '<input name="produto_cliente4" id="produto_cliente4" size="35" tabindex="28" value="'.$x[produto_cliente4].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente5" id="qtde_cliente5" value="<?=$x[qtde_cliente5]?>" size="2" tabindex="29" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente5');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente5" id="cod_cliente5" value="<?=$x[cod_cliente5]?>" size="5" tabindex="30" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente5');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente5] == ""){

						echo '<span id="produtos5"></span>';

					}

					else{

						echo '<input name="produto_cliente5" id="produto_cliente5" size="35" tabindex="31" value="'.$x[produto_cliente5].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente6" id="qtde_cliente6" value="<?=$x[qtde_cliente6]?>" size="2" tabindex="32" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente6');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente6" id="cod_cliente6" value="<?=$x[cod_cliente6]?>" size="5" tabindex="33" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente6');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente6] == ""){

						echo '<span id="produtos6"></span>';

					}

					else{

						echo '<input name="produto_cliente6" id="produto_cliente6" size="35" tabindex="34" value="'.$x[produto_cliente6].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente7" id="qtde_cliente7" value="<?=$x[qtde_cliente7]?>" size="2" tabindex="35" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente7');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente7" id="cod_cliente7" value="<?=$x[cod_cliente7]?>"  size="5" tabindex="36" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente7');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente7] == ""){

						echo '<span id="produtos7"></span>';

					}

					else{

						echo '<input name="produto_cliente7" id="produto_cliente7" size="35" tabindex="37" value="'.$x[produto_cliente7].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente8" id="qtde_cliente8" value="<?=$x[qtde_cliente8]?>" size="2" tabindex="38" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente8');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente8" id="cod_cliente8" value="<?=$x[cod_cliente8]?>"  size="5" tabindex="39" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente8');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente8] == ""){

						echo '<span id="produtos8"></span>';

					}

					else{

						echo '<input name="produto_cliente8" id="produto_cliente8" size="35" tabindex="40" value="'.$x[produto_cliente8].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente9" id="qtde_cliente9" value="<?=$x[qtde_cliente9]?>" size="2" tabindex="41" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente9');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente9" id="cod_cliente9" value="<?=$x[cod_cliente9]?>"  size="5" tabindex="42" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente9');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente9] == ""){

						echo '<span id="produtos9"></span>';

					}

					else{

						echo '<input name="produto_cliente9" id="produto_cliente9" size="35" tabindex="43" value="'.$x[produto_cliente9].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente10" id="qtde_cliente10" value="<?=$x[qtde_cliente10]?>" size="2" tabindex="44" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente10');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente10" id="cod_cliente10" value="<?=$x[cod_cliente10]?>"  size="5" tabindex="45" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente10');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente10] == ""){

						echo '<span id="produtos10"></span>';

					}

					else{

						echo '<input name="produto_cliente10" id="produto_cliente10" size="35" tabindex="46" value="'.$x[produto_cliente10].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente11" id="qtde_cliente11" value="<?=$x[qtde_cliente11]?>" size="2" tabindex="47" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente11');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente11" id="cod_cliente11" value="<?=$x[cod_cliente11]?>"  size="5" tabindex="48" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente11');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente11] == ""){

						echo '<span id="produtos11"></span>';

					}

					else{

						echo '<input name="produto_cliente11" id="produto_cliente11" size="35" tabindex="49" value="'.$x[produto_cliente11].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente12" id="qtde_cliente12" value="<?=$x[qtde_cliente12]?>" size="2" tabindex="50" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente12');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente12" id="cod_cliente12" value="<?=$x[cod_cliente12]?>"  size="5" tabindex="51" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente12');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente12] == ""){

						echo '<span id="produtos12"></span>';

					}

					else{

						echo '<input name="produto_cliente12" id="produto_cliente12" size="35" tabindex="52" value="'.$x[produto_cliente12].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente13" id="qtde_cliente13" value="<?=$x[qtde_cliente13]?>" size="2" tabindex="53" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente13');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente13" id="cod_cliente13" value="<?=$x[cod_cliente13]?>"  size="5" tabindex="54" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente13');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente13] == ""){

						echo '<span id="produtos13"></span>';

					}

					else{

						echo '<input name="produto_cliente13" id="produto_cliente13" size="35" tabindex="55" value="'.$x[produto_cliente13].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente14" id="qtde_cliente14" value="<?=$x[qtde_cliente14]?>" size="2" tabindex="56" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente14');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente14" id="cod_cliente14" value="<?=$x[cod_cliente14]?>"  size="5" tabindex="57" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente14');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente14] == ""){

						echo '<span id="produtos14"></span>';

					}

					else{

						echo '<input name="produto_cliente14" id="produto_cliente14" size="35" tabindex="58" value="'.$x[produto_cliente14].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente15" id="qtde_cliente15" value="<?=$x[qtde_cliente15]?>" size="2" tabindex="59" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente15');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente15" id="cod_cliente15" value="<?=$x[cod_cliente15]?>"  size="5" tabindex="60" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente15');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente15] == ""){

						echo '<span id="produtos15"></span>';

					}

					else{

						echo '<input name="produto_cliente15" id="produto_cliente15" size="35" tabindex="61" value="'.$x[produto_cliente15].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente16" id="qtde_cliente16" value="<?=$x[qtde_cliente16]?>" size="2" tabindex="62" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente16');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente16" id="cod_cliente16" value="<?=$x[cod_cliente16]?>"  size="5" tabindex="63" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente16');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente16] == ""){

						echo '<span id="produtos16"></span>';

					}

					else{

						echo '<input name="produto_cliente16" id="produto_cliente16" size="35" tabindex="64" value="'.$x[produto_cliente16].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente17" id="qtde_cliente17" value="<?=$x[qtde_cliente17]?>" size="2" tabindex="65" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente17');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente17" id="cod_cliente17" value="<?=$x[cod_cliente17]?>"  size="5" tabindex="66" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente17');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente17] == ""){

						echo '<span id="produtos17"></span>';

					}

					else{

						echo '<input name="produto_cliente17" id="produto_cliente17" size="35" tabindex="67" value="'.$x[produto_cliente17].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente18" id="qtde_cliente18" value="<?=$x[qtde_cliente18]?>" size="2" tabindex="68" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente18');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente18" id="cod_cliente18" value="<?=$x[cod_cliente18]?>"  size="5" tabindex="69" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente18');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente18] == ""){

						echo '<span id="produtos18"></span>';

					}

					else{

						echo '<input name="produto_cliente18" id="produto_cliente18" size="35" tabindex="70" value="'.$x[produto_cliente18].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente19" id="qtde_cliente19" value="<?=$x[qtde_cliente19]?>" size="2" tabindex="71" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente19');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente19" id="cod_cliente19" value="<?=$x[cod_cliente19]?>"  size="5" tabindex="72" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente19');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente19] == ""){

						echo '<span id="produtos19"></span>';

					}

					else{

						echo '<input name="produto_cliente19" id="produto_cliente19" size="35" tabindex="73" value="'.$x[produto_cliente19].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente20" id="qtde_cliente20" value="<?=$x[qtde_cliente20]?>" size="2" tabindex="74" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente20');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente20" id="cod_cliente20" value="<?=$x[cod_cliente20]?>"  size="5" tabindex="75" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente20');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente20] == ""){

						echo '<span id="produtos20"></span>';

					}

					else{

						echo '<input name="produto_cliente20" id="produto_cliente20" size="35" tabindex="76" value="'.$x[produto_cliente20].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

        </tr>

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

