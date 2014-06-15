<?php

include"config.php";



$y = mysql_query("SELECT * FROM clientes_assistencia WHERE id_cliente = '".$_GET['id_clientes']."'");

if ($x = mysql_fetch_array($y))



{



$prioridade = $x[prioridade];

if($prioridade == 0){ $check0 = 'checked="checked"';}

elseif($prioridade == 1){$check1 = 'checked="checked"';}

elseif($prioridade == 2){$check2 = 'checked="checked"';}



$tipo_pessoa = $x[tipo];

$tipo_montagem = $x[tipo_montagem];



if($tipo_pessoa==0){

	if($tipo_montagem == 0){$tipo1 = 'checked="checked"';}

	elseif($tipo_montagem == 1){$tipo2 = 'checked="checked"';}

	elseif($tipo_montagem == 2){$tipo3 = 'checked="checked"';}

	elseif($tipo_montagem == 3){$tipo6 = 'checked="checked"';}

}

elseif($tipo_pessoa==1){

	if($tipo_montagem == 0){$tipo4 = 'checked="checked"';}

	elseif($tipo_montagem == 1){$tipo5 = 'checked="checked"';}

}





	

			if(strlen($a["comentario"])>0){

				$comentario = "<tr><td colspan='4'>Coment&aacute;rio:<br /><textarea name='referencia_cliente' rows='5' cols='40' tabindex='16'>".$a['comentario']."</textarea></td></tr>";

			}else{

				$comentario = "";

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



<form name="form1" method="post" action="php/alterar_db_clientes_assistencia.php?id_clientes=<?=$x[id_cliente]?>">

 <input type="hidden" name="editar_clientes" value="1" />

	<input type="hidden" name="id_clientes" value="<?=$x[id_cliente]?>" />

    <div id="divdoconteudo">

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">

          <tr>

		    <td align="center" bgcolor="#FFFFFF" colspan="4"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /><a onclick="printDiv('divdoconteudo','janela');" style="margin-left:20px;"><img src="img/impressora.png" border="0" /></a></td>

            <script language="javascript">addCampos('salvar');</script>

          </tr>

		  <tr>

            <td align="center" class="titulo" colspan="4">Visualizar Clientes</td>

          </tr>

          <tr>

            <td width="101"><strong>Prioridade</strong>: </td>

            <td width="227" colspan="3">

                <input type="checkbox" name="nor" id="nor" <?=$check0;?> value="0" /><strong>Normal</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <script language="javascript">addCampos('nor');</script>

                <input type="checkbox" name="agen" id="agen" value="1" <?=$check1;?> /><strong>Agendamento</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <script language="javascript">addCampos('agen');</script>

                <input type="checkbox" name="jur" id="jur" value="2" <?=$check2;?> /><strong>Jurídico</strong>

                <script language="javascript">addCampos('jur');</script>

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

						echo '<input name="produto_cliente2" id="produto_cliente2" size="35" tabindex="19" value="'.$x[produto_cliente2].'" onkeyup="this.value = this.value.toUpperCase();" />';

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

						echo '<input name="produto_cliente3" id="produto_cliente3" size="35" tabindex="19" value="'.$x[produto_cliente3].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente4" id="qtde_cliente4" value="<?=$x[qtde_cliente4]?>" size="2" tabindex="25" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente4');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente4" id="cod_cliente4" value="<?=$x[cod_cliente4]?>" size="5" tabindex="26" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente4');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente4] == ""){

						echo '<span id="produtos4"></span>';

					}

					else{

						echo '<input name="produto_cliente4" id="produto_cliente4" size="35" tabindex="19" value="'.$x[produto_cliente4].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente5" id="qtde_cliente5" value="<?=$x[qtde_cliente5]?>" size="2" tabindex="28" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente5');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente5" id="cod_cliente5" value="<?=$x[cod_cliente5]?>" size="5" tabindex="29" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente5');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente5] == ""){

						echo '<span id="produtos5"></span>';

					}

					else{

						echo '<input name="produto_cliente5" id="produto_cliente5" size="35" tabindex="19" value="'.$x[produto_cliente5].'" onkeyup="this.value = this.value.toUpperCase();" />';

					}

				?>

				</td>

			</tr>

			<tr>

				<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente6" id="qtde_cliente6" value="<?=$x[qtde_cliente6]?>" size="2" tabindex="25" onkeyup="nu(this)" />

                <script language="javascript">addCampos('qtde_cliente6');</script>

                &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente6" id="cod_cliente6" value="<?=$x[cod_cliente6]?>" size="5" tabindex="26" onkeyup="this.value = this.value.toUpperCase();" />

                <script language="javascript">addCampos('cod_cliente6');</script>

                &nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;

                <?php

                	if($x[produto_cliente6] == ""){

						echo '<span id="produtos6"></span>';

					}

					else{

						echo '<input name="produto_cliente6" id="produto_cliente6" size="35" tabindex="19" value="'.$x[produto_cliente6].'" onkeyup="this.value = this.value.toUpperCase();" />';

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

