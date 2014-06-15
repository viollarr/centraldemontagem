<?php
include"config.php";

$y = mysql_query("SELECT * FROM montadores WHERE id_montadores = '".$_GET['id_montadores']."'");

if ($x = mysql_fetch_array($y)){


$estadoCorreto = "";
$cidadeCorreto = "";

	$select_estados = "SELECT * FROM estados ORDER BY nome ASC";
	$query_estados = mysql_query($select_estados);
	while($a = mysql_fetch_assoc($query_estados)){
		$estados[] = $a;
		if($a["cod_estados"] == $x['estado']){
			$estadoCorreto = $a["sigla"];
		}
	}

	$select_cidades = "SELECT * FROM cidades WHERE estados_cod_estados = '".$x['estado']."' ORDER BY nome ASC";
	//echo $select_cidades;
	$query_cidades = mysql_query($select_cidades);
	$rows_cidades = mysql_num_rows($query_cidades);
	//echo $rows_cidades;
	if($rows_cidades > 0){
		while($y = mysql_fetch_assoc($query_cidades)){
			$cidades[] = $y;
			if($y["cod_cidades"] == $x['cidade']){
				$cidadeCorreto = htmlentities($y['nome']);
			}

		}
	}

	if($estadoCorreto != ""){
		$select_bairros = "SELECT DISTINCT(bairro) FROM ".$estadoCorreto." ORDER BY bairro ASC";
		$query_bairros = mysql_query($select_bairros);
		$rows_bairro = mysql_num_rows($query_bairros);
		if($rows_bairro > 0){
			while($z = mysql_fetch_assoc($query_bairros)){
				$bairros[] = $z;
			}
		}
		else{
			$select_bairros = "SELECT nome AS bairro FROM bairros ORDER BY nome ASC";
			$query_bairros = mysql_query($select_bairros);
			while($z = mysql_fetch_assoc($query_bairros)){
				$bairros[] = $z;
			}
		}
	}
	
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

	if($x['id_empresa']== 1){
		$empresa1 = ' checked="checked"';
	}
	elseif($x['id_empresa']== 2){
		$empresa2 = ' checked="checked"';
	}
	elseif($x['id_empresa']== 3){
		$empresa3 = ' checked="checked"';
	}
	elseif($x['id_empresa']== 4){
		$empresa4 = ' checked="checked"';
	}
	elseif($x['id_empresa']== 5){
		$empresa5 = ' checked="checked"';
	}

	$select_mont = "SELECT * FROM usuarios WHERE id_montador = '".$x[id_montadores]."'";
	$c = mysql_query($select_mont);
	$rows_mont = mysql_num_rows($c);
	$d = mysql_fetch_array($c);

?>

<form name="form1" method="post" enctype="multipart/form-data" <?php if(($_SESSION['tipo'] == '1') || ($_SESSION['tipo'] == '3')){ ?> action="php/alterar_db_montadores.php?id_montadores=<?=$x[id_montadores]?>"> <?php } else{ ?> > <?php } ?>

	<input type="hidden" name="editar_montadores" value="1" />
	<input type="hidden" name="id_montadores" value="<?=$x[id_montadores]?>" />
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
<?php if(($_SESSION['tipo'] == '1') || ($_SESSION['tipo'] == '3')){ ?>
		<tr>
			<td align="center" bgcolor="#FFFFFF" colspan="4"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
            <script language="javascript">addCampos('salvar');</script>
		</tr>
 <?php } ?>
		<tr>
			<td align="center" class="titulo" colspan="4">Visualizar Montadores</td>
		</tr>
        <?php
		if($x['foto'] != ""){
		?>
		<tr>
			<td align="center" colspan="4"><img src="foto/<?=$x['foto']?>" border="0" width="100"  /></td>
		</tr>
		<?php
		}
		?>
    	<tr>
        	<td align="left">Empresa:</td>
			<td colspan="3">
				<input type="radio" <?=$empresa1?> name="empresa" value="1" />RE(RJ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<script language="javascript">addCampos('empresa');</script>
			</td>
		</tr>
      <tr><td colspan="4">&nbsp;</td></tr>
    	<tr>
			<td align="left" colspan="4"> Funcionário Responsável
				<select name="id_responsavel">
                	<?php
						if($x['id_responsavel'] == 0){
							echo "<option value='0'  selected='selected'>Escolha o Responsavel</option>";
						}
						$select_responsavel = "SELECT id, nome FROM usuarios WHERE tipo = '2' OR tipo = '3'  OR tipo = '1'";
						$query_responsavel = mysql_query($select_responsavel);
						
						while($resp = mysql_fetch_array($query_responsavel)){
						
					?>
                    		<option value="<?=$resp['id']?>" <?php if($x['id_responsavel'] == $resp['id']){ echo "selected='selected'";}?>><?=$resp['nome']?></option>
                    <?php
						}
					?>
                </select>
				<script language="javascript">addCampos('id_responsavel');</script>
			</td>
		</tr>
		<tr>
			<td width="104" align="left">Nome Completo: </td>
			<td align="left"><input type="text"  size="50" name="nome_comp" id="nome_comp" value="<?=$x[nome]?>" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
            <script language="javascript">addCampos('nome_comp');</script>
            <td align="left" colspan="2">
                Rota:&nbsp;&nbsp;<input type="text" name="rota" id="rota" value="<?=$x['rota']?>" size="15" />
            <script language="javascript">addCampos('rota');</script>
			</td> 
		</tr>
        <tr>
            <td align="left" colspan="4">Incluir/Alterar Foto: 
            	<input type="file" name="foto" tabindex="2" />
			</td>
                  <script language="javascript">addCampos('foto');</script>
        </tr>
		<tr>
			<td align="left">Admissão: </td>
			<td width="354" align="left" colspan="3"><input name="admissao" type="text" id="admissao" value="<?=$ad?>" class="data datepicker" size="10"  tabindex="3" />
        <script language="javascript">addCampos('admissao');</script>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Demissão:&nbsp;&nbsp;&nbsp;&nbsp; <input name="demissao" type="text" id="demissao" value="<?=$de?>" class="data datepicker" size="10" tabindex="4" /></td>
      <script language="javascript">addCampos('demissao');</script>
		</tr>
		<tr>
        	<td align="left">Banco: </td>
			<td width="354" align="left" colspan="3"><input name="banco" type="text" id="banco" value="<?=$x['banco']?>" size="20"  tabindex="5" />
        	<script language="javascript">addCampos('banco');</script>
        Nome Conta:&nbsp;&nbsp;<input type="text" name="nome_conta" id="nome_conta" value="<?=$x['nome_conta']?>" size="30" tabindex="6" />
        	<script language="javascript">addCampos('nome_conta');</script>
        	</td>
		</tr>
		<tr>
        	<td align="left">Ag.:</td>
        	<td align="left" colspan="3"><input type="text" name="agencia" id="agencia" value="<?=$x['ag']?>" size="15" tabindex="7" />
        	<script language="javascript">addCampos('agencia');</script>
        	Conta:&nbsp;&nbsp;<input type="text" name="conta" id="conta" value="<?=$x['conta']?>" size="15" tabindex="8" />
        	<script language="javascript">addCampos('conta');</script></td>
     	</tr>
		<tr>
        	<td align="left">CTPS Série</td>
        	<td align="left" colspan="1"><input type="text" name="ctpsserie" id="ctpsserie" value="<?=$x['ctpsserie']?>" size="5" tabindex="9" />
        	<script language="javascript">addCampos('ctpsserie');</script>
        	CTPS Número:&nbsp;&nbsp;<input type="text" name="ctpsnumero" id="ctpsnumero" value="<?=$x['ctpsnumero']?>" size="15" tabindex="10" />
        	<script language="javascript">addCampos('ctpsnumero');</script></td>
            <td align="left" colspan="2">CTPS UF:&nbsp;&nbsp;<input type="text" name="ctpsuf" id="ctpsuf" value="<?=$x['ctpsuf']?>" size="4" maxlength="2" tabindex="11" onkeyup="this.value = this.value.toUpperCase();" />
        	<script language="javascript">addCampos('ctpsuf');</script></td>
     	</tr>        
    	<tr>
        	<td align="left">Data Nascimento: </td>
        	<td width="354" align="left" colspan="3"><input name="dataNascimento" type="text" id="dataNascimento" value="<?=$x['data_nascimento']?>" class="data datepicker" size="10"  tabindex="12" /></td>
        	<script language="javascript">addCampos('dataNascimento');</script>
    	</tr>
    	<tr>
        	<td align="left">RG: </td>
        	<td width="354" align="left" colspan="3"><input name="rg" type="text" id="rg" maxlength="18"  value="<?=$x['rg']?>" size="40"  tabindex="13" /></td>
        	<script language="javascript">addCampos('rg');</script>
    	</tr>
		<tr>
			<td align="left">CPF: </td>
			<td width="354" align="left"><input name="cpf" type="text" id="cpf" value="<?=$x[cpf]?>" onblur="validar(this)" maxlength="18" size="40"  tabindex="14" /></td>
            <script language="javascript">addCampos('cpf');</script>
			<td width="56" align="left">CEP: </td>
		  	<td align="left"><input name="cep" id="cep" class="cep" value="<?=$x[cep]?>" size="10" maxlength="8" onblur="getEndereco()" tabindex="15" /></td>
          	<script language="javascript">addCampos('cep');</script>
		</tr>
		  <tr>
			<td align="left">Endere&ccedil;o: </td>
			<td align="left" colspan="3"><input name="rua" id="rua" size="60" value="<?=$x[rua]?>" tabindex="16" onkeyup="this.value = this.value.toUpperCase();"/></td>
            <script language="javascript">addCampos('rua');</script>
          </tr>
          <tr>
            <td align="left">N&deg;:</td>
            <td align="left" colspan="3"><input type="text" name="numero" id="numero" value="<?=$x[numero]?>" size="5" tabindex="17" />
            <script language="javascript">addCampos('numero');</script>&nbsp;&nbsp;&nbsp;
			Comp.:	<input type="text" name="comp" id="comp" value="<?=$x[comp]?>" size="10" tabindex="18" onkeyup="this.value = this.value.toUpperCase();" /></td>
            <script language="javascript">addCampos('comp');</script>
		  </tr>
             <tr>
               <td align="left">Estado*: </td>
               <td align="left" colspan="3">
                    <select name="estado" id="estado" tabindex="13">
                        <option value=""></option>
                        <?php
                            foreach($estados AS $estado){
                                if($x['estado'] == $estado['cod_estados']) $estado_selecionado = 'selected="selected"';
                                else $estado_selecionado = '';
                                echo '<option uf="'.$estado['sigla'].'" '.$estado_selecionado.' value="'.$estado['cod_estados'].'">'.$estado['sigla'].'</option>';
                            }
                        ?>
                    </select> <br />
               <script language="javascript">addCampos('estado');</script>
               </td>
             </tr>
             <tr>
                <td align="left">Cidade</td>
                <td align="left" colspan="3">
                    <select name="cidade" id="cidade" class="select_model" tabindex="14">
					<?php
                        foreach($cidades AS $cidade){
                            if($x['cidade'] == $cidade['cod_cidades']) $cidade_selecionado = 'selected="selected"';
                            else $cidade_selecionado = '';
							
                            echo '<option '.$cidade_selecionado.' value="'.$cidade['cod_cidade'].'">'.strtoupper(strtr(strtoupper(utf8_encode(strtoupper($cidade['nome']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")).'</option>';
                        }
                    ?>
                    </select>
                </td>
               <script language="javascript">addCampos('cidade');</script>
             </tr>
             <tr>
               <td align="left">Bairro*: </td>
               <td align="left" colspan="3">
                    <select name="bairro" id="bairro" tabindex="15">
                        <option value="">-- Escolha um bairro --</option>
                            <?php
                                foreach($bairros AS $bairro){
									if($x['bairro'] == strtoupper(strtr(strtoupper(utf8_encode(strtoupper($bairro['bairro']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"))) $bairro_selecionado = 'selected="selected"';
									else $bairro_selecionado = '';

                                    echo "<option value='".$bairro['bairro']."' ".$bairro_selecionado.">".strtoupper(strtr(strtoupper(utf8_encode(strtoupper($bairro['bairro']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ"))."</option>";
                                }
                            ?>
                    </select> <br />
               <script language="javascript">addCampos('bairro');</script>
               </td>
             </tr>
		<tr>
			<td align="left">Telefone: </td>
			<td align="left"><input type="text" name="res" id="res" value="<?=$x[telefone]?>" size="12" class="telefone" tabindex="22" /></td>
            <script language="javascript">addCampos('res');</script>
			<td align="left">Celular: </td>
			<td align="left"><input type="text" name="cel" id="cel" value="<?=$x[celular]?>" size="12" class="telefone" tabindex="23" /></td>
            <script language="javascript">addCampos('cel');</script>
		</tr>
		<tr>
			<td align="left">Email: </td>
			<td align="left" colspan="4"><input type="text" name="email" id="email" value="<?=$x[email]?>" size="30" maxlength="50" tabindex="24" /></td>
            <script language="javascript">addCampos('email');</script>
		</tr>
        <?php
			if($rows_mont == 0){
		?>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
        	<td colspan="4">
            	Para cadastrar uma senha para o montador <<
                <a href="cad_usuario_montador.php?a=<?=base64_encode($x[id_montadores])?>" target="_blank">CLIQUE AQUI</a> >>
            </td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <?php
			}
			else{
		?>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
        	<td colspan="4">
            	Montador com Acesso ao sistema já cadastrado, o login dele é:  <?=$d[login];?> 
            </td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <?php
			}
		?>
		<tr>
        	<td align="left" colspan="4">Coment&aacute;rio:<br /> 
        	<textarea name="observacao" id="observacao" cols="40" rows="10" tabindex="25"><?=$x['comentario']?></textarea>
        	<script language="javascript">addCampos('observacao');</script>
        	</td>
  		</tr>
		<tr>
			<td colspan="4">
				<table width="100%">
					<tr>
						<td align="left" width="50%">Áreas que ele atende: </td>
						<td align="left" width="50%">Modificar Áreas de atendimento: </td>
					</tr>
					<tr>
						<td valign="top">
						<?php
							$rows_bairross = explode(';',$x[atendimento]);
							$contagem = count($rows_bairross);
							$contagem_bairros = $contagem;
							for ($i=0;$i<($contagem-1);$i++){
								$select = 'SELECT * FROM RJ WHERE id = "'.$rows_bairross[$i].'"';
								//echo $select;
								$query= mysql_query($select);
								$a = mysql_fetch_array($query);
								echo '<strong>'.strtoupper(strtr(strtoupper(utf8_encode(strtoupper($a['bairro']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")).'<strong>';
								echo "<br>";
							}
						$contagem_geral = ($contagem - 1);
						?>
						</td>
						<td valign="top"><select name="atendimento[]" multiple="multiple" size="4">
						<?php
							/*
							$select = "SELECT * FROM bairros ORDER BY nome ASC";
							$query = mysql_query($select);
							while($b = mysql_fetch_array($query)){
								echo '<option value="'.$b[id_bairros].'">'.htmlentities($b[nome]).'</option>';
							}
							*/
							$select = "SELECT DISTINCT(bairro) FROM RJ ORDER BY bairro ASC";
							$query = mysql_query($select);
							while($b = mysql_fetch_array($query)){
								echo '<option value="'.utf8_encode($b[bairro]).'">'.strtoupper(strtr(strtoupper(utf8_encode(strtoupper($b['bairro']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")).'</option>';
							}
							
							
						?>
						</select>
						</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">Só será disponibilizada as notas de montagens referente ao bairro de atendimento do montador. </td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td align="left" width="50%">Notas para montagens selecionadas: </td>
							<td align="left" width="50%">Incluir Notas de Montagens: </td>
						</tr>
						<tr>
							<td valign="top" width="60%">
							<?php
								$rows_montagens = explode(';',$x[n_montagens]);
								$contagem = count($rows_montagens);
								for ($i=0;$i<($contagem-1);$i++){
									$select = 'SELECT * FROM ordem_montagem o, clientes c WHERE o.status <> "3" AND o.id_montador = "'.$x[id_montadores].'" AND o.n_montagem = c.n_montagem ORDER BY o.n_montagem ASC LIMIT '.$i.',1';
									$query= mysql_query($select);
									$a = mysql_fetch_array($query);
									$n_montagem = $a[n_montagem];
									$nome_cli	 = $a[nome_cliente];
									if(strlen($n_montagem)>0){
									echo '<strong>'.$n_montagem.'<strong>&nbsp;->&nbsp;'.substr ($nome_cli,0,23);
									echo "<br>";
									}
								}
							?>
							</td>
							<td valign="top"><select name="n_montagens[]" multiple="multiple" size="7">
								<?php
								for($i=0;$i<($contagem_bairros - 1);$i++){
										$select = "SELECT * FROM ordem_montagem o, clientes c WHERE o.id_bairros = '".$rows_bairross[$i]."' AND o.id_montador = '0' AND (c.n_montagem = o.n_montagem AND c.ativo = '0') ORDER BY o.n_montagem ASC";
										$query = mysql_query($select);
										while($b = mysql_fetch_array($query)){
											echo '<option value="'.$b[id_montagem].'">'.$b[n_montagem].'&nbsp;->&nbsp;'.substr($b[nome_cliente],0,15).'</option>';
										}
								}
								?>
							</select>
							</td></tr>
						<tr><td colspan="2">* Para selecionar mais de um <strong>BAIRRO</strong> ou <strong>NOTAS</strong> favor segurar o botão "<strong>Ctrl</strong>" no teclado e <strong>clicar</strong> com o mouse nas outras opções.
						</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" colspan="4"><a href="javascript:history.go(-1)">Voltar</a></td>
		</tr>
      </table>
</form>		
<?php
}
?>