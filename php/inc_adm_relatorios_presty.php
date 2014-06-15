<?php
include ("config.php");


$dia =date("d");
$mes =date("m");
$ano =date("Y");
$data =$dia."/".$mes."/".$ano;

if(strlen($_GET[pagina])>0){
	$data_inicio = $_GET[data_inicio];
	$data_fim = $_GET[data_fim];
	$tipo = $_GET[tipo];
	$prioridade = $_GET[prioridade];
	$empresa 	= $_GET[empresa];
}
else{
	if(!empty($_POST['data_inicio'])){
		$data_inicio = explode("/",$_POST['data_inicio']);
		$data_inicio = $data_inicio[2]."-".$data_inicio[1]."-".$data_inicio[0];
	}
	else{
		$data_inicio = "";	
	}
	
	if(!empty($_POST['data_final'])){
		$data_fim = explode("/",$_POST['data_final']);
		$data_fim = $data_fim[2]."-".$data_fim[1]."-".$data_fim[0];
	}
	else{
		$data_fim = "";	
	}
	$tipo 		= $_POST['tipo'];
	$prioridade = $_POST['prioridade'];
	$empresa	= $_POST['empresa'];

}

$ativo = 0;


if($empresa == '3'){
	$busca = 'p.preco_real_cp AS preco';
}
else{
	$busca = 'p.preco_real AS preco';
}

if($prioridade == 0){
	if($tipo == 3){$modelo = 0; $condicao = "o.status = '1' OR";}
	if($tipo == 7){$modelo = 2;}
	if($tipo == 8){$modelo = 3;}
	if($tipo == 9){$modelo = 1;}
}
elseif($prioridade == 2){
	if($tipo == 3){$tipo = 5; $modelo = 0;}
	if($tipo == 7){$modelo = 2;}
	if($tipo == 8){$modelo = 3;}
	if($tipo == 9){$modelo = 1;}
}
elseif($prioridade == 4){
	if($tipo == 3){$modelo = 0;}
	if($tipo == 7){$modelo = 2;}
	if($tipo == 8){$modelo = 3;}
	if($tipo == 9){$modelo = 1;}
}


//echo $data_inicio;
//echo "<br>";
//echo $data_fim;
//exit();

if ((strlen($tipo)>0)&&(!empty($data_inicio))&&(!empty($data_fim))&&(!empty($empresa))){

		$SQL = "SELECT DISTINCT o.n_montagem, d.data_final, c.*, $busca FROM clientes c, datas d, ordem_montagem o, produtos pd, precos p, montadores mo WHERE (d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim') AND c.n_montagem = o.n_montagem AND c.id_empresa = '$empresa' AND mo.id_empresa = '$empresa' AND o.n_montagem = d.n_montagens AND c.ativo='$ativo' AND o.id_montador = mo.id_montadores AND mo.id_empresa = '$empresa' AND c.id_empresa = '$empresa' AND c.cod_cliente = pd.cod_produto AND p.id_preco = pd.id_preco AND ($condicao o.status = '$tipo') AND c.prioridade='$prioridade' AND c.tipo='$modelo' ORDER BY o.n_montagem ASC";

		//echo $SQL;
		$sql = mysql_query($SQL);
		$geti = $_GET['pagina'];
		if ($geti>0){
			$inicio = 40*$geti; // Especifique quantos resultados voc� quer por p�gina
			$lpp= 40; // Retorna qual ser� a primeira linha a ser mostrada no MySQL
		}else{
			$inicio = 0;
			$lpp	= 40;
		}
		$total = mysql_num_rows($sql); // Esta fun��o ir� retornar o total de linhas na tabela
		$paginas = ceil($total / 40); // Retorna o total de p�ginas
		if(!isset($pagina)) { 
			$pagina = $_GET['pagina']; 
		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada

		if($prioridade == 4){
			$testeLimit =  "";
		}
		else{
			$testeLimit =  "LIMIT ".$inicio.", ".$lpp;
		}

		$SQL = "SELECT DISTINCT o.n_montagem, d.data_final, c.*, $busca FROM clientes c, datas d, ordem_montagem o, produtos pd, precos p, montadores mo WHERE (d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim')  AND c.n_montagem = o.n_montagem AND c.id_empresa = '$empresa' AND mo.id_empresa = '$empresa' AND o.n_montagem = d.n_montagens AND c.ativo='$ativo' AND o.id_montador = mo.id_montadores AND mo.id_empresa = '$empresa' AND c.id_empresa = '$empresa' AND c.cod_cliente = pd.cod_produto AND p.id_preco = pd.id_preco AND ($condicao o.status = '$tipo') AND c.prioridade='$prioridade' AND c.tipo='$modelo' ORDER BY o.n_montagem ASC $testeLimit";
		//echo $SQL;
		//exit();
		$executa = mysql_query($SQL)or die(mysql_error());

		// montando a tabela
		if($pagina == ""){
		echo "<table border='0' width='100%' align='center'>
				  <tr>
				   <td colspan='8' align='center'>
						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>
				   </td>
				  </tr>";
		}
		echo "</table>";
		echo "<table border='0' width='900' cellspacing='1' bgcolor='#000000'>
				<tr>
				  <td bgcolor='#F2F2F2' colspan='8' align='left'><b></b>";
				  ?>
				   <form action="down_notas_presty.php" method="post" style="text-align:center;">
					  <input type="submit" value="Download" />
					  <input type="hidden" name="data_inicio" value="<?=$data_inicio?>"/>
                      <input type="hidden" name="data_fim" value="<?=$data_fim?>"/>
                      <input type="hidden" name="tipo" value="<?=$tipo?>"/>
                      <input type="hidden" name="inicio" value="<?=$inicio?>"/>
                      <input type="hidden" name="lpp" value="<?=$lpp?>"/>
                      <input type="hidden" name="prioridade" value="<?=$prioridade?>"/>
                      <input type="hidden" name="empresa" value="<?=$empresa?>"/>
                      <input type="hidden" name="tipo" value="<?=$tipo?>"/>
				  </form>
				  <?php
				  echo "".$data."</td>
				</tr>
				<tr>
				  <td align='center' bgcolor='#F2F2F2'><b>MONT.N&deg;</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>DATA</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>PEDIDO</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>COD.</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>PRODUTO</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>UNIDADE</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>V.UNIDADE</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>SUB TOTAL</b></td>
			   </tr>";
		$i=1;
		$ii = 1;
		$total=0;
		$total2=0;
		$total3=0;
		$total4=0;
		$total5=0;
		$total6=0;
		$total7=0;
		$total8=0;
		$total9=0;
		$total10=0;
		$total11=0;
		$total12=0;
		$total13=0;
		$total14=0;
		$total15=0;
		$total16=0;
		$total17=0;
		$total18=0;
		$total19=0;
		$total20=0;
		
		$total_geral =0;

		
		while ($rs = mysql_fetch_array($executa)){
		            		
			$data_final = new DateTime($rs[data_final]);  
			$data_final = $data_final->format('d/m/Y');
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total = ($rs['preco']*$rs['qtde_cliente']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total = ($rs['preco']*$rs['qtde_cliente']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total = (($rs['preco']/2)*$rs['qtde_cliente']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total = ($rs['preco']*$rs['qtde_cliente']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total = ($rs['preco']*$rs['qtde_cliente']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total = (($rs['preco']/2)*$rs['qtde_cliente']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total = ((str_replace(",",".",$rs['preco'])/2)*$rs['qtde_cliente']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total = ($rs['preco']*$rs['qtde_cliente']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total = (15.60*$rs['qtde_cliente']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total = (($rs['preco']/2)*$rs['qtde_cliente']);
				}

			}
			
			$select_preco2 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente2]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco2."<br>";
			$query_preco2 = mysql_query($select_preco2);
			$p = mysql_fetch_array($query_preco2);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total2 = ($p['preco']*$rs['qtde_cliente2']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total2 = ($p['preco']*$rs['qtde_cliente2']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total2 = (($p['preco']/2)*$rs['qtde_cliente2']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total2 = ($p['preco']*$rs['qtde_cliente2']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total2 = ($p['preco']*$rs['qtde_cliente2']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total2 = (($p['preco']/2)*$rs['qtde_cliente2']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total2 = ((str_replace(",",".",$p['preco'])/2)*$rs['qtde_cliente2']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total2 = ($p['preco']*$rs['qtde_cliente2']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total2 = (15.60*$rs['qtde_cliente2']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total2 = (($p['preco']/2)*$rs['qtde_cliente2']);
				}

			}
			
			$select_preco3 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente3]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco3."<br>";
			$query_preco3 = mysql_query($select_preco3);
			$q = mysql_fetch_array($query_preco3);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total3 = ($q['preco']*$rs['qtde_cliente3']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total3 = ($q['preco']*$rs['qtde_cliente3']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total3 = (($q['preco']/2)*$rs['qtde_cliente3']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total3 = ($q['preco']*$rs['qtde_cliente3']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total3 = ($q['preco']*$rs['qtde_cliente3']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total3 = (($q['preco']/2)*$rs['qtde_cliente3']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total3 = ((str_replace(",",".",$q['preco'])/2)*$rs['qtde_cliente3']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total3 = ($q['preco']*$rs['qtde_cliente3']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total3 = (15.60*$rs['qtde_cliente3']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total3 = (($q['preco']/2)*$rs['qtde_cliente3']);
				}

			}
			
			$select_preco4 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente4]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco4."<br>";
			$query_preco4 = mysql_query($select_preco4);
			$r = mysql_fetch_array($query_preco4);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total4 = ($r['preco']*$rs['qtde_cliente4']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total4 = ($r['preco']*$rs['qtde_cliente4']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total4 = (($r['preco']/2)*$rs['qtde_cliente4']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total4 = ($r['preco']*$rs['qtde_cliente4']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total4 = ($r['preco']*$rs['qtde_cliente4']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total4 = (($r['preco']/2)*$rs['qtde_cliente4']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total4 = ((str_replace(",",".",$r['preco'])/2)*$rs['qtde_cliente4']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total4 = ($r['preco']*$rs['qtde_cliente4']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total4 = (15.60*$rs['qtde_cliente4']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total4 = (($r['preco']/2)*$rs['qtde_cliente4']);
				}

			}
			
			$select_preco5 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente5]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco5."<br>";
			$query_preco5 = mysql_query($select_preco5);
			$s = mysql_fetch_array($query_preco5);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total5 = ($s['preco']*$rs['qtde_cliente5']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total5 = ($s['preco']*$rs['qtde_cliente5']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total5 = (($s['preco']/2)*$rs['qtde_cliente5']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total5 = ($s['preco']*$rs['qtde_cliente5']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total5 = ($s['preco']*$rs['qtde_cliente5']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total5 = (($s['preco']/2)*$rs['qtde_cliente5']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total5 = ((str_replace(",",".",$s['preco'])/2)*$rs['qtde_cliente5']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total5 = ($s['preco']*$rs['qtde_cliente5']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total5 = (15.60*$rs['qtde_cliente5']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total5 = (($s['preco']/2)*$rs['qtde_cliente5']);
				}

			}
			
			$select_preco6 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente6]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco5."<br>";
			$query_preco6 = mysql_query($select_preco6);
			$t = mysql_fetch_array($query_preco6);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total6 = ($t['preco']*$rs['qtde_cliente6']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total6 = ($t['preco']*$rs['qtde_cliente6']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total6 = (($t['preco']/2)*$rs['qtde_cliente6']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total6 = ($t['preco']*$rs['qtde_cliente6']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total6 = ($t['preco']*$rs['qtde_cliente6']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total6 = (($t['preco']/2)*$rs['qtde_cliente6']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total6 = ((str_replace(",",".",$t['preco'])/2)*$rs['qtde_cliente6']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total6 = ($t['preco']*$rs['qtde_cliente6']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total6 = (15.60*$rs['qtde_cliente6']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total6 = (($t['preco']/2)*$rs['qtde_cliente6']);
				}

			}
			$select_preco7 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente7]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco7."<br>";
			$query_preco7 = mysql_query($select_preco7);
			$u = mysql_fetch_array($query_preco7);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total7 = (15.60*$rs['qtde_cliente7']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total7 = (15.60*$rs['qtde_cliente7']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total7 = (($u['preco']/2)*$rs['qtde_cliente7']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total7 = (15.60*$rs['qtde_cliente7']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total7 = (15.60*$rs['qtde_cliente7']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total7 = (($u['preco']/2)*$rs['qtde_cliente7']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total7 = ((str_replace(",",".",$u['preco'])/2)*$rs['qtde_cliente7']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total7 = (15.60*$rs['qtde_cliente7']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total7 = ($u['preco']*$rs['qtde_cliente7']);
				}

			}
			$select_preco8 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente8]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco8."<br>";
			$query_preco8 = mysql_query($select_preco8);
			$v = mysql_fetch_array($query_preco8);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total8 = (15.60*$rs['qtde_cliente8']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total8 = (15.60*$rs['qtde_cliente8']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total8 = (($v['preco']/2)*$rs['qtde_cliente8']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total8 = (15.60*$rs['qtde_cliente8']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total8 = (15.60*$rs['qtde_cliente8']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total8 = (($v['preco']/2)*$rs['qtde_cliente8']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total8 = ((str_replace(",",".",$v['preco'])/2)*$rs['qtde_cliente8']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total8 = (15.60*$rs['qtde_cliente8']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total8 = ($v['preco']*$rs['qtde_cliente8']);
				}

			}
			$select_preco9 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente9]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco9."<br>";
			$query_preco9 = mysql_query($select_preco9);
			$x = mysql_fetch_array($query_preco9);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total9 = (15.60*$rs['qtde_cliente9']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total9 = (15.60*$rs['qtde_cliente9']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total9 = (($x['preco']/2)*$rs['qtde_cliente9']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total9 = (15.60*$rs['qtde_cliente9']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total9 = (15.60*$rs['qtde_cliente9']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total9 = (($x['preco']/2)*$rs['qtde_cliente9']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total9 = ((str_replace(",",".",$x['preco'])/2)*$rs['qtde_cliente9']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total9 = (15.60*$rs['qtde_cliente9']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total9 = ($x['preco']*$rs['qtde_cliente9']);
				}

			}
			$select_preco10 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente10]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco10."<br>";
			$query_preco10 = mysql_query($select_preco10);
			$z = mysql_fetch_array($query_preco10);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total10 = (15.60*$rs['qtde_cliente10']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total10 = (15.60*$rs['qtde_cliente10']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total10 = (($z['preco']/2)*$rs['qtde_cliente10']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total10 = (15.60*$rs['qtde_cliente10']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total10 = (15.60*$rs['qtde_cliente10']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total10 = (($z['preco']/2)*$rs['qtde_cliente10']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total10 = ((str_replace(",",".",$z['preco'])/2)*$rs['qtde_cliente10']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total10 = (15.60*$rs['qtde_cliente10']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total10 = ($z['preco']*$rs['qtde_cliente10']);
				}

			}
			$select_preco11 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente11]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco11."<br>";
			$query_preco11 = mysql_query($select_preco11);
			$a = mysql_fetch_array($query_preco11);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total11 = (15.60*$rs['qtde_cliente11']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total11 = (15.60*$rs['qtde_cliente11']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total11 = (($a['preco']/2)*$rs['qtde_cliente11']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total11 = (15.60*$rs['qtde_cliente11']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total11 = (15.60*$rs['qtde_cliente11']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total11 = (($a['preco']/2)*$rs['qtde_cliente11']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total11 = ((str_replace(",",".",$a['preco'])/2)*$rs['qtde_cliente11']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total11 = (15.60*$rs['qtde_cliente11']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total11 = ($a['preco']*$rs['qtde_cliente11']);
				}

			}
			$select_preco12 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente12]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco12."<br>";
			$query_preco12 = mysql_query($select_preco12);
			$b = mysql_fetch_array($query_preco12);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total12 = (15.60*$rs['qtde_cliente12']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total12 = (15.60*$rs['qtde_cliente12']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total12 = (($b['preco']/2)*$rs['qtde_cliente12']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total12 = (15.60*$rs['qtde_cliente12']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total12 = (15.60*$rs['qtde_cliente12']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total12 = (($b['preco']/2)*$rs['qtde_cliente12']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total12 = ((str_replace(",",".",$b['preco'])/2)*$rs['qtde_cliente12']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total12 = (15.60*$rs['qtde_cliente12']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total12 = ($b['preco']*$rs['qtde_cliente12']);
				}

			}
			$select_preco13 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente13]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco13."<br>";
			$query_preco13 = mysql_query($select_preco13);
			$c = mysql_fetch_array($query_preco13);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total13 = (15.60*$rs['qtde_cliente13']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total13 = (15.60*$rs['qtde_cliente13']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total13 = (($c['preco']/2)*$rs['qtde_cliente13']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total13 = (15.60*$rs['qtde_cliente13']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total13 = (15.60*$rs['qtde_cliente13']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total13 = (($c['preco']/2)*$rs['qtde_cliente13']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total13 = ((str_replace(",",".",$c['preco'])/2)*$rs['qtde_cliente13']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total13 = (15.60*$rs['qtde_cliente13']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total13 = ($c['preco']*$rs['qtde_cliente13']);
				}

			}
			$select_preco14 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente14]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco14."<br>";
			$query_preco14 = mysql_query($select_preco14);
			$d = mysql_fetch_array($query_preco14);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total14 = (15.60*$rs['qtde_cliente14']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total14 = (15.60*$rs['qtde_cliente14']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total14 = (($d['preco']/2)*$rs['qtde_cliente14']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total14 = (15.60*$rs['qtde_cliente14']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total14 = (15.60*$rs['qtde_cliente14']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total14 = (($d['preco']/2)*$rs['qtde_cliente14']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total14 = ((str_replace(",",".",$d['preco'])/2)*$rs['qtde_cliente14']);

				}
				// montagem justica
				elseif($tipo == 5){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total14 = (15.60*$rs['qtde_cliente14']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total14 = ($d['preco']*$rs['qtde_cliente14']);
				}

			}
			$select_preco15 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente15]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco15."<br>";
			$query_preco15 = mysql_query($select_preco15);
			$e = mysql_fetch_array($query_preco15);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total15 = (15.60*$rs['qtde_cliente15']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total15 = (15.60*$rs['qtde_cliente15']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total15 = (($e['preco']/2)*$rs['qtde_cliente15']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total15 = (15.60*$rs['qtde_cliente15']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total15 = (15.60*$rs['qtde_cliente15']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total15 = (($e['preco']/2)*$rs['qtde_cliente15']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total15 = ((str_replace(",",".",$e['preco'])/2)*$rs['qtde_cliente15']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total15 = (15.60*$rs['qtde_cliente15']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total15 = ($e['preco']*$rs['qtde_cliente15']);
				}

			}
			$select_preco16 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente16]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco16."<br>";
			$query_preco16 = mysql_query($select_preco16);
			$f = mysql_fetch_array($query_preco16);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total16 = (15.60*$rs['qtde_cliente16']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total16 = (15.60*$rs['qtde_cliente16']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total16 = (($f['preco']/2)*$rs['qtde_cliente16']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total16 = (15.60*$rs['qtde_cliente16']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total16 = (15.60*$rs['qtde_cliente16']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total16 = (($f['preco']/2)*$rs['qtde_cliente16']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total16 = ((str_replace(",",".",$f['preco'])/2)*$rs['qtde_cliente16']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total16 = (15.60*$rs['qtde_cliente16']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total16 = ($f['preco']*$rs['qtde_cliente16']);
				}

			}
			$select_preco17 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente17]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco17."<br>";
			$query_preco17 = mysql_query($select_preco17);
			$g = mysql_fetch_array($query_preco17);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total17 = (15.60*$rs['qtde_cliente17']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total17 = (15.60*$rs['qtde_cliente17']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total17 = (($g['preco']/2)*$rs['qtde_cliente17']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total17 = (15.60*$rs['qtde_cliente17']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total17 = (15.60*$rs['qtde_cliente17']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total17 = (($g['preco']/2)*$rs['qtde_cliente17']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total17 = ((str_replace(",",".",$g['preco'])/2)*$rs['qtde_cliente17']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total17 = (15.60*$rs['qtde_cliente17']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total17 = ($g['preco']*$rs['qtde_cliente17']);
				}

			}
			$select_preco18 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente18]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco18."<br>";
			$query_preco18 = mysql_query($select_preco18);
			$h = mysql_fetch_array($query_preco18);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total18 = (15.60*$rs['qtde_cliente18']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total18 = (15.60*$rs['qtde_cliente18']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total18 = (($h['preco']/2)*$rs['qtde_cliente18']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total18 = (15.60*$rs['qtde_cliente18']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total18 = (15.60*$rs['qtde_cliente18']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total18 = (($h['preco']/2)*$rs['qtde_cliente18']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total18 = ((str_replace(",",".",$h['preco'])/2)*$rs['qtde_cliente18']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total18 = (15.60*$rs['qtde_cliente18']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total18 = ($h['preco']*$rs['qtde_cliente18']);
				}

			}
			$select_preco19 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente19]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco19."<br>";
			$query_preco19 = mysql_query($select_preco19);
			$i = mysql_fetch_array($query_preco19);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total19 = (15.60*$rs['qtde_cliente19']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total19 = (15.60*$rs['qtde_cliente19']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total19 = (($i['preco']/2)*$rs['qtde_cliente19']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total19 = (15.60*$rs['qtde_cliente19']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total19 = (15.60*$rs['qtde_cliente19']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total19 = (($i['preco']/2)*$rs['qtde_cliente19']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total19 = ((str_replace(",",".",$i['preco'])/2)*$rs['qtde_cliente19']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total19 = (15.60*$rs['qtde_cliente19']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total19 = ($i['preco']*$rs['qtde_cliente19']);
				}

			}
			$select_preco20 = "SELECT $busca FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente20]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco20."<br>";
			$query_preco20 = mysql_query($select_preco20);
			$j = mysql_fetch_array($query_preco20);
			
			if($prioridade == 0){
				// montagem normal
				if($tipo == 3){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total20 = (15.60*$rs['qtde_cliente20']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total20 = (15.60*$rs['qtde_cliente20']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total20 = (($j['preco']/2)*$rs['qtde_cliente20']);
				}

			}
			elseif($prioridade == 2){
				// juridico normal
				if($tipo == 3){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// juridico justica
				elseif($tipo == 5){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// juridico revisao
				elseif($tipo == 7){
					$total20 = (15.60*$rs['qtde_cliente20']);
				}
				// juridico tecnica
				elseif($tipo == 8){
					$total20 = (15.60*$rs['qtde_cliente20']);
				}
				// juridico desmontagem
				elseif($tipo == 9){
					$total20 = (($j['preco']/2)*$rs['qtde_cliente20']);
				}

			}
			elseif($prioridade == 4){
				// montagem normal
				if($tipo == 3){
					$total20 = ((str_replace(",",".",$j['preco'])/2)*$rs['qtde_cliente20']);
				}
				// montagem justica
				elseif($tipo == 5){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// montagem revisao
				elseif($tipo == 7){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}
				// montagem tecnica
				elseif($tipo == 8){
					$total20 = (15.60*$rs['qtde_cliente20']);
				}
				// montagem desmontagem
				elseif($tipo == 9){
					$total20 = ($j['preco']*$rs['qtde_cliente20']);
				}

			}
			
			
			$total_geral += $total+$total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9+$total10+$total11+$total12+$total13+$total14+$total15+$total16+$total17+$total18+$total19+$total20;
			$qtde_geral += $rs['qtde_cliente']+$rs['qtde_cliente2']+$rs['qtde_cliente3']+$rs['qtde_cliente4']+$rs['qtde_cliente5']+$rs['qtde_cliente6']+$rs['qtde_cliente7']+$rs['qtde_cliente8']+$rs['qtde_cliente9']+$rs['qtde_cliente10']+$rs['qtde_cliente11']+$rs['qtde_cliente12']+$rs['qtde_cliente13']+$rs['qtde_cliente14']+$rs['qtde_cliente15']+$rs['qtde_cliente16']+$rs['qtde_cliente17']+$rs['qtde_cliente18']+$rs['qtde_cliente19']+$rs['qtde_cliente20'];

			$total = number_format($total,2,',','');
			$total2 = number_format($total2,2,',','');
			$total3 = number_format($total3,2,',','');
			$total4 = number_format($total4,2,',','');
			$total5 = number_format($total5,2,',','');
			$total6 = number_format($total6,2,',','');
			$total7 = number_format($total7,2,',','');
			$total8 = number_format($total8,2,',','');
			$total9 = number_format($total9,2,',','');
			$total10 = number_format($total10,2,',','');
			$total11 = number_format($total11,2,',','');
			$total12 = number_format($total12,2,',','');
			$total13 = number_format($total13,2,',','');
			$total14 = number_format($total14,2,',','');
			$total15 = number_format($total15,2,',','');
			$total16 = number_format($total16,2,',','');
			$total17 = number_format($total17,2,',','');
			$total18 = number_format($total18,2,',','');
			$total19 = number_format($total19,2,',','');
			$total20 = number_format($total20,2,',','');
			
			if($prioridade == 0){
				if($tipo == 3){
					$preco_real = number_format($rs['preco'],2,',','');
					$preco_real2 = number_format($p['preco'],2,',','');
					$preco_real3 = number_format($q['preco'],2,',','');
					$preco_real4 = number_format($r['preco'],2,',','');
					$preco_real5 = number_format($s['preco'],2,',','');
					$preco_real6 = number_format($t['preco'],2,',','');
					$preco_real7 = number_format($u['preco'],2,',','');
					$preco_real8 = number_format($v['preco'],2,',','');
					$preco_real9 = number_format($x['preco'],2,',','');
					$preco_real10 = number_format($z['preco'],2,',','');
					$preco_real11 = number_format($a['preco'],2,',','');
					$preco_real12 = number_format($b['preco'],2,',','');
					$preco_real13 = number_format($c['preco'],2,',','');
					$preco_real14 = number_format($d['preco'],2,',','');
					$preco_real15 = number_format($e['preco'],2,',','');
					$preco_real16 = number_format($f['preco'],2,',','');
					$preco_real17 = number_format($g['preco'],2,',','');
					$preco_real18 = number_format($h['preco'],2,',','');
					$preco_real19 = number_format($i['preco'],2,',','');
					$preco_real20 = number_format($j['preco'],2,',','');	
				}
				elseif($tipo == 5){
					$preco_real = number_format($rs['preco'],2,',','');
					$preco_real2 = number_format($p['preco'],2,',','');
					$preco_real3 = number_format($q['preco'],2,',','');
					$preco_real4 = number_format($r['preco'],2,',','');
					$preco_real5 = number_format($s['preco'],2,',','');
					$preco_real6 = number_format($t['preco'],2,',','');
					$preco_real7 = number_format($u['preco'],2,',','');
					$preco_real8 = number_format($v['preco'],2,',','');
					$preco_real9 = number_format($x['preco'],2,',','');
					$preco_real10 = number_format($z['preco'],2,',','');
					$preco_real11 = number_format($a['preco'],2,',','');
					$preco_real12 = number_format($b['preco'],2,',','');
					$preco_real13 = number_format($c['preco'],2,',','');
					$preco_real14 = number_format($d['preco'],2,',','');
					$preco_real15 = number_format($e['preco'],2,',','');
					$preco_real16 = number_format($f['preco'],2,',','');
					$preco_real17 = number_format($g['preco'],2,',','');
					$preco_real18 = number_format($h['preco'],2,',','');
					$preco_real19 = number_format($i['preco'],2,',','');
					$preco_real20 = number_format($j['preco'],2,',','');	
				}
				elseif($tipo == 7){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');	
				}
				elseif($tipo == 8){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');	
				}
				elseif($tipo == 9){
					$preco_real = number_format(($rs['preco']/2),2,',','');
					$preco_real2 = number_format(($p['preco']/2),2,',','');
					$preco_real3 = number_format(($q['preco']/2),2,',','');
					$preco_real4 = number_format(($r['preco']/2),2,',','');
					$preco_real5 = number_format(($s['preco']/2),2,',','');
					$preco_real6 = number_format(($t['preco']/2),2,',','');
					$preco_real7 = number_format(($u['preco']/2),2,',','');
					$preco_real8 = number_format(($v['preco']/2),2,',','');
					$preco_real9 = number_format(($x['preco']/2),2,',','');
					$preco_real10 = number_format(($z['preco']/2),2,',','');
					$preco_real11 = number_format(($a['preco']/2),2,',','');
					$preco_real12 = number_format(($b['preco']/2),2,',','');
					$preco_real13 = number_format(($c['preco']/2),2,',','');
					$preco_real14 = number_format(($d['preco']/2),2,',','');
					$preco_real15 = number_format(($e['preco']/2),2,',','');
					$preco_real16 = number_format(($f['preco']/2),2,',','');
					$preco_real17 = number_format(($g['preco']/2),2,',','');
					$preco_real18 = number_format(($h['preco']/2),2,',','');
					$preco_real19 = number_format(($i['preco']/2),2,',','');
					$preco_real20 = number_format(($j['preco']/2),2,',','');	
				}
			}
			elseif($prioridade == 2){
				if($tipo == 3){
					$preco_real = number_format($rs['preco'],2,',','');
					$preco_real2 = number_format($p['preco'],2,',','');
					$preco_real3 = number_format($q['preco'],2,',','');
					$preco_real4 = number_format($r['preco'],2,',','');
					$preco_real5 = number_format($s['preco'],2,',','');
					$preco_real6 = number_format($t['preco'],2,',','');
					$preco_real7 = number_format($u['preco'],2,',','');
					$preco_real8 = number_format($v['preco'],2,',','');
					$preco_real9 = number_format($x['preco'],2,',','');
					$preco_real10 = number_format($z['preco'],2,',','');
					$preco_real11 = number_format($a['preco'],2,',','');
					$preco_real12 = number_format($b['preco'],2,',','');
					$preco_real13 = number_format($c['preco'],2,',','');
					$preco_real14 = number_format($d['preco'],2,',','');
					$preco_real15 = number_format($e['preco'],2,',','');
					$preco_real16 = number_format($f['preco'],2,',','');
					$preco_real17 = number_format($g['preco'],2,',','');
					$preco_real18 = number_format($h['preco'],2,',','');
					$preco_real19 = number_format($i['preco'],2,',','');
					$preco_real20 = number_format($j['preco'],2,',','');	
				}
				elseif($tipo == 5){
					$preco_real = number_format($rs['preco'],2,',','');
					$preco_real2 = number_format($p['preco'],2,',','');
					$preco_real3 = number_format($q['preco'],2,',','');
					$preco_real4 = number_format($r['preco'],2,',','');
					$preco_real5 = number_format($s['preco'],2,',','');
					$preco_real6 = number_format($t['preco'],2,',','');
					$preco_real7 = number_format($u['preco'],2,',','');
					$preco_real8 = number_format($v['preco'],2,',','');
					$preco_real9 = number_format($x['preco'],2,',','');
					$preco_real10 = number_format($z['preco'],2,',','');
					$preco_real11 = number_format($a['preco'],2,',','');
					$preco_real12 = number_format($b['preco'],2,',','');
					$preco_real13 = number_format($c['preco'],2,',','');
					$preco_real14 = number_format($d['preco'],2,',','');
					$preco_real15 = number_format($e['preco'],2,',','');
					$preco_real16 = number_format($f['preco'],2,',','');
					$preco_real17 = number_format($g['preco'],2,',','');
					$preco_real18 = number_format($h['preco'],2,',','');
					$preco_real19 = number_format($i['preco'],2,',','');
					$preco_real20 = number_format($j['preco'],2,',','');	
				}
				elseif($tipo == 7){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');	
				}
				elseif($tipo == 8){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');						
				}
				elseif($tipo == 9){
					$preco_real = number_format(($rs['preco']/2),2,',','');
					$preco_real2 = number_format(($p['preco']/2),2,',','');
					$preco_real3 = number_format(($q['preco']/2),2,',','');
					$preco_real4 = number_format(($r['preco']/2),2,',','');
					$preco_real5 = number_format(($s['preco']/2),2,',','');
					$preco_real6 = number_format(($t['preco']/2),2,',','');
					$preco_real7 = number_format(($u['preco']/2),2,',','');
					$preco_real8 = number_format(($v['preco']/2),2,',','');
					$preco_real9 = number_format(($x['preco']/2),2,',','');
					$preco_real10 = number_format(($z['preco']/2),2,',','');
					$preco_real11 = number_format(($a['preco']/2),2,',','');
					$preco_real12 = number_format(($b['preco']/2),2,',','');
					$preco_real13 = number_format(($c['preco']/2),2,',','');
					$preco_real14 = number_format(($d['preco']/2),2,',','');
					$preco_real15 = number_format(($e['preco']/2),2,',','');
					$preco_real16 = number_format(($f['preco']/2),2,',','');
					$preco_real17 = number_format(($g['preco']/2),2,',','');
					$preco_real18 = number_format(($h['preco']/2),2,',','');
					$preco_real19 = number_format(($i['preco']/2),2,',','');
					$preco_real20 = number_format(($j['preco']/2),2,',','');	
				}
			}
			elseif($prioridade == 4){
				if($tipo == 3){
					$preco_real = number_format((str_replace(",",".",$rs['preco'])/2),2,',','');
					$preco_real2 = number_format((str_replace(",",".",$p['preco'])/2),2,',','');
					$preco_real3 = number_format((str_replace(",",".",$q['preco'])/2),2,',','');
					$preco_real4 = number_format((str_replace(",",".",$r['preco'])/2),2,',','');
					$preco_real5 = number_format((str_replace(",",".",$s['preco'])/2),2,',','');
					$preco_real6 = number_format((str_replace(",",".",$t['preco'])/2),2,',','');
					$preco_real7 = number_format((str_replace(",",".",$u['preco'])/2),2,',','');
					$preco_real8 = number_format((str_replace(",",".",$v['preco'])/2),2,',','');
					$preco_real9 = number_format((str_replace(",",".",$x['preco'])/2),2,',','');
					$preco_real10 = number_format((str_replace(",",".",$z['preco'])/2),2,',','');
					$preco_real11 = number_format((str_replace(",",".",$a['preco'])/2),2,',','');
					$preco_real12 = number_format((str_replace(",",".",$b['preco'])/2),2,',','');
					$preco_real13 = number_format((str_replace(",",".",$c['preco'])/2),2,',','');
					$preco_real14 = number_format((str_replace(",",".",$d['preco'])/2),2,',','');
					$preco_real15 = number_format((str_replace(",",".",$e['preco'])/2),2,',','');
					$preco_real16 = number_format((str_replace(",",".",$f['preco'])/2),2,',','');
					$preco_real17 = number_format((str_replace(",",".",$g['preco'])/2),2,',','');
					$preco_real18 = number_format((str_replace(",",".",$h['preco'])/2),2,',','');
					$preco_real19 = number_format((str_replace(",",".",$i['preco'])/2),2,',','');
					$preco_real20 = number_format((str_replace(",",".",$j['preco'])/2),2,',','');	
				}
				elseif($tipo == 5){
					$preco_real = number_format($rs['preco'],2,',','');
					$preco_real2 = number_format($p['preco'],2,',','');
					$preco_real3 = number_format($q['preco'],2,',','');
					$preco_real4 = number_format($r['preco'],2,',','');
					$preco_real5 = number_format($s['preco'],2,',','');
					$preco_real6 = number_format($t['preco'],2,',','');
					$preco_real7 = number_format($u['preco'],2,',','');
					$preco_real8 = number_format($v['preco'],2,',','');
					$preco_real9 = number_format($x['preco'],2,',','');
					$preco_real10 = number_format($z['preco'],2,',','');
					$preco_real11 = number_format($a['preco'],2,',','');
					$preco_real12 = number_format($b['preco'],2,',','');
					$preco_real13 = number_format($c['preco'],2,',','');
					$preco_real14 = number_format($d['preco'],2,',','');
					$preco_real15 = number_format($e['preco'],2,',','');
					$preco_real16 = number_format($f['preco'],2,',','');
					$preco_real17 = number_format($g['preco'],2,',','');
					$preco_real18 = number_format($h['preco'],2,',','');
					$preco_real19 = number_format($i['preco'],2,',','');
					$preco_real20 = number_format($j['preco'],2,',','');	
				}
				elseif($tipo == 7){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');	
				}
				elseif($tipo == 8){
					$preco_real = number_format(15.60,2,',','');
					$preco_real2 = number_format(15.60,2,',','');
					$preco_real3 = number_format(15.60,2,',','');
					$preco_real4 = number_format(15.60,2,',','');
					$preco_real5 = number_format(15.60,2,',','');
					$preco_real6 = number_format(15.60,2,',','');
					$preco_real7 = number_format(15.60,2,',','');
					$preco_real8 = number_format(15.60,2,',','');
					$preco_real9 = number_format(15.60,2,',','');
					$preco_real10 = number_format(15.60,2,',','');
					$preco_real11 = number_format(15.60,2,',','');
					$preco_real12 = number_format(15.60,2,',','');
					$preco_real13 = number_format(15.60,2,',','');
					$preco_real14 = number_format(15.60,2,',','');
					$preco_real15 = number_format(15.60,2,',','');
					$preco_real16 = number_format(15.60,2,',','');
					$preco_real17 = number_format(15.60,2,',','');
					$preco_real18 = number_format(15.60,2,',','');
					$preco_real19 = number_format(15.60,2,',','');
					$preco_real20 = number_format(15.60,2,',','');						
				}
				elseif($tipo == 9){
					$preco_real = number_format((str_replace(",",".",$rs['preco'])/2),2,',','');
					$preco_real2 = number_format((str_replace(",",".",$p['preco'])/2),2,',','');
					$preco_real3 = number_format((str_replace(",",".",$q['preco'])/2),2,',','');
					$preco_real4 = number_format((str_replace(",",".",$r['preco'])/2),2,',','');
					$preco_real5 = number_format((str_replace(",",".",$s['preco'])/2),2,',','');
					$preco_real6 = number_format((str_replace(",",".",$t['preco'])/2),2,',','');
					$preco_real7 = number_format((str_replace(",",".",$u['preco'])/2),2,',','');
					$preco_real8 = number_format((str_replace(",",".",$v['preco'])/2),2,',','');
					$preco_real9 = number_format((str_replace(",",".",$x['preco'])/2),2,',','');
					$preco_real10 = number_format((str_replace(",",".",$z['preco'])/2),2,',','');
					$preco_real11 = number_format((str_replace(",",".",$a['preco'])/2),2,',','');
					$preco_real12 = number_format((str_replace(",",".",$b['preco'])/2),2,',','');
					$preco_real13 = number_format((str_replace(",",".",$c['preco'])/2),2,',','');
					$preco_real14 = number_format((str_replace(",",".",$d['preco'])/2),2,',','');
					$preco_real15 = number_format((str_replace(",",".",$e['preco'])/2),2,',','');
					$preco_real16 = number_format((str_replace(",",".",$f['preco'])/2),2,',','');
					$preco_real17 = number_format((str_replace(",",".",$g['preco'])/2),2,',','');
					$preco_real18 = number_format((str_replace(",",".",$h['preco'])/2),2,',','');
					$preco_real19 = number_format((str_replace(",",".",$i['preco'])/2),2,',','');
					$preco_real20 = number_format((str_replace(",",".",$j['preco'])/2),2,',','');	
				}
			}				
			
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total</td>";				
			echo "</tr>";
			if(strlen($rs['cod_cliente2'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente2]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente2]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente2]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real2</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total2</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente3'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente3]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente3]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente3]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real3</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total3</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente4'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente4]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente4]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente4]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real4</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total4</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente5'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente5]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente5]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente5]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real5</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total5</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente6'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente6]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente6]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente6]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real6</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total6</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente7'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente7]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente7]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente7]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real7</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total7</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente8'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente8]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente8]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente8]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real8</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total8</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente9'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente9]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente9]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente9]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real9</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total9</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente10'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente10]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente10]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente10]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real10</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total10</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente11'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente11]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente11]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente11]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real11</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total11</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente12'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente12]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente12]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente12]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real12</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total12</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente13'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente13]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente13]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente13]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real13</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total13</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente14'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente14]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente14]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente14]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real14</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total14</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente15'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente15]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente15]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente15]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real15</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total15</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente16'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente16]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente16]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente16]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real16</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total16</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente17'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente17]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente17]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente17]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real17</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total17</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente18'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente18]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente18]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente18]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real18</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total18</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente19'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente19]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente19]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente19]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real19</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total19</td>";				
			echo "</tr>";
			}
			if(strlen($rs['cod_cliente20'])>0){
			$ii++;
			echo "<tr>";
				//echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$ii</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$data_final</td>";
				echo "<td align='center' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";	
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[cod_cliente20]</td>";
				echo "<td align='left' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[produto_cliente20]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>$rs[qtde_cliente20]</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $preco_real20</td>";
				echo "<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total20</td>";				
			echo "</tr>";
			}			
			$ii++;
		}
			$total_geral = number_format($total_geral,2,',','');
		  echo "<tr>
		  			<td align='right' colspan='6' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'><strong>$qtde_geral</strong></td>
		  			<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'><strong>TOTAL</strong></td>
		  			<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2' align='center'><strong>R$ $total_geral</strong></td>
		  		</tr>
		  		<tr>
				  <td colspan='8' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>
														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>
				  </td>
				</tr>  
		</table>";
		
		echo "<span class='texto'>Mais registros</span>";
		echo "<br />";
			$menos = 0;
			$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
			echo "<a href=\"$url\"><strong>&laquo;</strong></a> "; 
		if($pagina > 0) {
			$menos = ($pagina - 1);
			if($menos >= 0){
				$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a p�gina anterior
			}
		}
		$menos2 = $pagina;
		if($pagina > 0) {
			$menos2 = ($menos2 - 1);
			if($menos2 >= 0){
				$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a p�gina anterior
			}
		}
			if(!isset($pagina)){
				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=0&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa'>0</a> ";
			}
			else{
				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=$pagina&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa'><strong style='font-size:16px;'><u>".$pagina."</u></strong></a> ";
			}
			$mais = $pagina;
		if($pagina < ($paginas - 1)) {
			for($x=0;$x<(($paginas/2)-1);$x++){
				$mais = $mais + 1;
				$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
				if($mais<=($paginas-1)){
					echo "  <a href=\"$url\">".$mais."</a>";
				}
				else{ echo'';}				
			}
		}

		if($pagina < ($paginas - 1)) {
			$mais = $_GET['pagina'] + 1;
			$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
			if($mais<=$paginas){
				echo " | <a href=\"$url\"><strong>&rsaquo;</strong></a>";
			}
			else {echo'';}
		}
			$mais = ($paginas - 1);
			$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo&empresa=$empresa";
			if($mais<=$paginas){
				echo "| <a href=\"$url\"><strong>&raquo;</strong></a>"; 
			}
			else{ echo'';}
	
		if($pagina == ""){
		echo"<table border='0' width='100%'>
				  <tr>
				   <td colspan='8' align='center'>
						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>
				   </td>
				  </tr>";
		echo "</table>";
		}

}else{
  echo "<script> alert('Por Favor! Selecione um tipo e um intervalo entre as datas corretamente!');location.href='javascript:window.history.go(-1)'; </script>";
}
?>