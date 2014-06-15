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

}

else{

$data_inicio = $_POST['ano_ini']."-".$_POST['mes_ini']."-".$_POST['dia_ini'];

$data_fim = $_POST['ano_fim']."-".$_POST['mes_fim']."-".$_POST['dia_fim'];

$tipo = $_POST['tipo'];

$prioridade = $_POST['prioridade'];



}



$ativo = 0;



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



if ((strlen($tipo)>0)&&(strlen($data_inicio)>0)&&(strlen($data_fim)>0)&&($data_inicio != "--")&&($data_fim != "--")){



		$SQL = "SELECT o.n_montagem, d.data_final, c.orcamento, c.cod_cliente, c.qtde_cliente, c.produto_cliente, c.cod_cliente2, c.qtde_cliente2, c.produto_cliente2, c.cod_cliente3, c.qtde_cliente3, c.produto_cliente3, c.cod_cliente4, c.qtde_cliente4, c.produto_cliente4, c.cod_cliente5, c.qtde_cliente5, c.produto_cliente5, c.cod_cliente6, c.qtde_cliente6, c.produto_cliente6, p.preco_real FROM clientes c, datas d, ordem_montagem o, produtos pd, precos p WHERE (d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim') AND c.ativo='$ativo' AND c.cod_cliente = pd.cod_produto AND p.id_preco = pd.id_preco AND c.n_montagem = o.n_montagem AND d.n_montagens = o.n_montagem AND ($condicao o.status = '$tipo') AND c.prioridade='$prioridade' AND c.tipo='$modelo' ORDER BY o.n_montagem ASC";

		

		//echo $SQL;

		$sql = mysql_query($SQL);

		$geti = $_GET['pagina'];

		if ($geti>0){

			$inicio = 30*$geti; // Especifique quantos resultados você quer por página

			$lpp= 30; // Retorna qual será a primeira linha a ser mostrada no MySQL

		}else{

			$inicio = 0;

			$lpp	= 30;

		}

		$total = mysql_num_rows($sql); // Esta função irá retornar o total de linhas na tabela

		$paginas = ceil($total / 30); // Retorna o total de páginas

		if(!isset($pagina)) { 

			$pagina = $_GET['pagina']; 

		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada



		$SQL = "SELECT o.n_montagem, d.data_final, c.orcamento, c.cod_cliente, c.qtde_cliente, c.produto_cliente, c.cod_cliente2, c.qtde_cliente2, c.produto_cliente2, c.cod_cliente3, c.qtde_cliente3, c.produto_cliente3, c.cod_cliente4, c.qtde_cliente4, c.produto_cliente4, c.cod_cliente5, c.qtde_cliente5, c.produto_cliente5, c.cod_cliente6, c.qtde_cliente6, c.produto_cliente6, p.preco_real FROM clientes c, datas d, ordem_montagem o, produtos pd, precos p WHERE (d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim') AND c.ativo='$ativo' AND c.cod_cliente = pd.cod_produto AND p.id_preco = pd.id_preco AND c.n_montagem = o.n_montagem AND d.n_montagens = o.n_montagem AND ($condicao o.status = '$tipo') AND c.prioridade='$prioridade' AND c.tipo='$modelo' ORDER BY o.n_montagem ASC LIMIT $inicio, $lpp";

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

                      <input type="hidden" name="tipo" value="<?=$tipo?>"/>

				  </form>

				  <?php

				  echo "".$data."</td>

				</tr>

				<tr>

				  <td align='center' bgcolor='#F2F2F2'><b>MONT.N&deg;</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>DATA</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>Or&ccedil;amento</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>C&Oacute;d.</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>PRODUTO</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>UNIDADE</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>V.UNIDADE</b></td>

				  <td align='center' bgcolor='#F2F2F2'><b>SUB TOTAL</b></td>

			   </tr>";

		$i=1;

		$total=0;

		$total2=0;

		$total3=0;

		$total4=0;

		$total5=0;

		$total6=0;

		$total_geral =0;

		while ($rs = mysql_fetch_array($executa)){

		            		

			$data_final = new DateTime($rs[data_final]);  

			$data_final = $data_final->format('d/m/Y');

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total = ($rs['preco_real']*$rs['qtde_cliente']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total = ($rs['preco_real']*$rs['qtde_cliente']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total = (15.60*$rs['qtde_cliente']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total = (5.60*$rs['qtde_cliente']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_real']/2)*$rs['qtde_cliente']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total = ($rs['preco_real']*$rs['qtde_cliente']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total = ($rs['preco_real']*$rs['qtde_cliente']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total = (15.60*$rs['qtde_cliente']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total = (5.60*$rs['qtde_cliente']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_real']/2)*$rs['qtde_cliente']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total = (($rs['preco_real']/2)*$rs['qtde_cliente']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total = ($rs['preco_real']*$rs['qtde_cliente']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total = (15.60*$rs['qtde_cliente']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total = (5.60*$rs['qtde_cliente']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_real']/2)*$rs['qtde_cliente']);

				}



			}

			

			$select_preco2 = "SELECT p.preco_real FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente2]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco2."<br>";

			$query_preco2 = mysql_query($select_preco2);

			$p = mysql_fetch_array($query_preco2);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total2 = ($p['preco_real']*$rs['qtde_cliente2']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total2 = ($p['preco_real']*$rs['qtde_cliente2']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total2 = (15.600*$rs['qtde_cliente2']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total2 = (5.60*$rs['qtde_cliente2']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_real']/2)*$rs['qtde_cliente2']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total2 = ($p['preco_real']*$rs['qtde_cliente2']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total2 = ($p['preco_real']*$rs['qtde_cliente2']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total2 = (15.60*$rs['qtde_cliente2']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total2 = (5.60*$rs['qtde_cliente2']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_real']/2)*$rs['qtde_cliente2']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total2 = (($p['preco_real']/2)*$rs['qtde_cliente2']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total2 = ($p['preco_real']*$rs['qtde_cliente2']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total2 = (15.60*$rs['qtde_cliente2']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total2 = (5.60*$rs['qtde_cliente2']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_real']/2)*$rs['qtde_cliente2']);

				}



			}

			

			$select_preco3 = "SELECT p.preco_real FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente3]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco3."<br>";

			$query_preco3 = mysql_query($select_preco3);

			$q = mysql_fetch_array($query_preco3);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total3 = ($q['preco_real']*$rs['qtde_cliente3']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total3 = ($q['preco_real']*$rs['qtde_cliente3']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total3 = (15.60*$rs['qtde_cliente3']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total3 = (5.60*$rs['qtde_cliente3']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_real']/2)*$rs['qtde_cliente3']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total3 = ($q['preco_real']*$rs['qtde_cliente3']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total3 = ($q['preco_real']*$rs['qtde_cliente3']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total3 = (15.60*$rs['qtde_cliente3']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total3 = (5.60*$rs['qtde_cliente3']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_real']/2)*$rs['qtde_cliente3']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total3 = (($q['preco_real']/2)*$rs['qtde_cliente3']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total3 = ($q['preco_real']*$rs['qtde_cliente3']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total3 = (15.60*$rs['qtde_cliente3']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total3 = (5.60*$rs['qtde_cliente3']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_real']/2)*$rs['qtde_cliente3']);

				}



			}

			

			$select_preco4 = "SELECT p.preco_real FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente4]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco4."<br>";

			$query_preco4 = mysql_query($select_preco4);

			$r = mysql_fetch_array($query_preco4);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total4 = ($r['preco_real']*$rs['qtde_cliente4']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total4 = ($r['preco_real']*$rs['qtde_cliente4']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total4 = (15.60*$rs['qtde_cliente4']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total4 = (5.60*$rs['qtde_cliente4']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_real']/2)*$rs['qtde_cliente4']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total4 = ($r['preco_real']*$rs['qtde_cliente4']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total4 = ($r['preco_real']*$rs['qtde_cliente4']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total4 = (15.60*$rs['qtde_cliente4']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total4 = (5.60*$rs['qtde_cliente4']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_real']/2)*$rs['qtde_cliente4']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total4 = (($r['preco_real']/2)*$rs['qtde_cliente4']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total4 = ($r['preco_real']*$rs['qtde_cliente4']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total4 = (15.60*$rs['qtde_cliente4']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total4 = (5.60*$rs['qtde_cliente4']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_real']/2)*$rs['qtde_cliente4']);

				}



			}

			

			$select_preco5 = "SELECT p.preco_real FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente5]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco5."<br>";

			$query_preco5 = mysql_query($select_preco5);

			$s = mysql_fetch_array($query_preco5);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total5 = ($s['preco_real']*$rs['qtde_cliente5']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total5 = ($s['preco_real']*$rs['qtde_cliente5']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total5 = (15.60*$rs['qtde_cliente5']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total5 = (5.60*$rs['qtde_cliente5']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_real']/2)*$rs['qtde_cliente5']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total5 = ($s['preco_real']*$rs['qtde_cliente5']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total5 = ($s['preco_real']*$rs['qtde_cliente5']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total5 = (15.60*$rs['qtde_cliente5']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total5 = (5.60*$rs['qtde_cliente5']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_real']/2)*$rs['qtde_cliente5']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total5 = (($s['preco_real']/2)*$rs['qtde_cliente5']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total5 = ($s['preco_real']*$rs['qtde_cliente5']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total5 = (15.60*$rs['qtde_cliente5']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total5 = (5.60*$rs['qtde_cliente5']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_real']/2)*$rs['qtde_cliente5']);

				}



			}

			

			$select_preco6 = "SELECT p.preco_real FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente6]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco5."<br>";

			$query_preco6 = mysql_query($select_preco6);

			$t = mysql_fetch_array($query_preco6);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total6 = ($t['preco_real']*$rs['qtde_cliente6']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total6 = ($t['preco_real']*$rs['qtde_cliente6']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total6 = (15.60*$rs['qtde_cliente6']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total6 = (5.60*$rs['qtde_cliente6']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_real']/2)*$rs['qtde_cliente6']);

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total6 = ($t['preco_real']*$rs['qtde_cliente6']);

				}

				// juridico justica

				elseif($tipo == 5){

					$total6 = ($t['preco_real']*$rs['qtde_cliente6']);

				}

				// juridico revisao

				elseif($tipo == 7){

					$total6 = (15.60*$rs['qtde_cliente6']);

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total6 = (5.60*$rs['qtde_cliente6']);

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_real']/2)*$rs['qtde_cliente6']);

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total6 = (($t['preco_real']/2)*$rs['qtde_cliente6']);

				}

				// montagem justica

				elseif($tipo == 5){

					$total6 = ($t['preco_real']*$rs['qtde_cliente6']);

				}

				// montagem revisao

				elseif($tipo == 7){

					$total6 = (15.60*$rs['qtde_cliente6']);

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total6 = (5.60*$rs['qtde_cliente6']);

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_real']/2)*$rs['qtde_cliente6']);

				}



			}

			

			$total_geral += $total+$total2+$total3+$total4+$total5+$total6;



			$total = number_format($total,2,',','');

			$total2 = number_format($total2,2,',','');

			$total3 = number_format($total3,2,',','');

			$total4 = number_format($total4,2,',','');

			$total5 = number_format($total5,2,',','');

			$total6 = number_format($total6,2,',','');

			

			if($prioridade == 0){

				if($tipo == 3){

					$preco_real = number_format($rs['preco_real'],2,',','');

					$preco_real2 = number_format($p['preco_real'],2,',','');

					$preco_real3 = number_format($q['preco_real'],2,',','');

					$preco_real4 = number_format($r['preco_real'],2,',','');

					$preco_real5 = number_format($s['preco_real'],2,',','');

					$preco_real6 = number_format($t['preco_real'],2,',','');

				}

				elseif($tipo == 5){

					$preco_real = number_format($rs['preco_real'],2,',','');

					$preco_real2 = number_format($p['preco_real'],2,',','');

					$preco_real3 = number_format($q['preco_real'],2,',','');

					$preco_real4 = number_format($r['preco_real'],2,',','');

					$preco_real5 = number_format($s['preco_real'],2,',','');

					$preco_real6 = number_format($t['preco_real'],2,',','');

				}

				elseif($tipo == 7){

					$preco_real = number_format(15.60,2,',','');

					$preco_real2 = number_format(15.60,2,',','');

					$preco_real3 = number_format(15.60,2,',','');

					$preco_real4 = number_format(15.60,2,',','');

					$preco_real5 = number_format(15.60,2,',','');

					$preco_real6 = number_format(15.60,2,',','');

				}

				elseif($tipo == 8){

					$preco_real = number_format(5.60,2,',','');

					$preco_real2 = number_format(5.60,2,',','');

					$preco_real3 = number_format(5.60,2,',','');

					$preco_real4 = number_format(5.60,2,',','');

					$preco_real5 = number_format(5.60,2,',','');

					$preco_real6 = number_format(5.60,2,',','');

				}

				elseif($tipo == 9){

					$preco_real = number_format(($rs['preco_real']/2),2,',','');

					$preco_real2 = number_format(($p['preco_real']/2),2,',','');

					$preco_real3 = number_format(($q['preco_real']/2),2,',','');

					$preco_real4 = number_format(($r['preco_real']/2),2,',','');

					$preco_real5 = number_format(($s['preco_real']/2),2,',','');

					$preco_real6 = number_format(($t['preco_real']/2),2,',','');

				}

			}

			elseif($prioridade == 2){

				if($tipo == 3){

					$preco_real = number_format($rs['preco_real'],2,',','');

					$preco_real2 = number_format($p['preco_real'],2,',','');

					$preco_real3 = number_format($q['preco_real'],2,',','');

					$preco_real4 = number_format($r['preco_real'],2,',','');

					$preco_real5 = number_format($s['preco_real'],2,',','');

					$preco_real6 = number_format($t['preco_real'],2,',','');

				}

				elseif($tipo == 5){

					$preco_real = number_format($rs['preco_real'],2,',','');

					$preco_real2 = number_format($p['preco_real'],2,',','');

					$preco_real3 = number_format($q['preco_real'],2,',','');

					$preco_real4 = number_format($r['preco_real'],2,',','');

					$preco_real5 = number_format($s['preco_real'],2,',','');

					$preco_real6 = number_format($t['preco_real'],2,',','');

				}

				elseif($tipo == 7){

					$preco_real = number_format(15.60,2,',','');

					$preco_real2 = number_format(15.60,2,',','');

					$preco_real3 = number_format(15.60,2,',','');

					$preco_real4 = number_format(15.60,2,',','');

					$preco_real5 = number_format(15.60,2,',','');

					$preco_real6 = number_format(15.60,2,',','');

				}

				elseif($tipo == 8){

					$preco_real = number_format(5.60,2,',','');

					$preco_real2 = number_format(5.60,2,',','');

					$preco_real3 = number_format(5.60,2,',','');

					$preco_real4 = number_format(5.60,2,',','');

					$preco_real5 = number_format(5.60,2,',','');

					$preco_real6 = number_format(5.60,2,',','');

				}

				elseif($tipo == 9){

					$preco_real = number_format(($rs['preco_real']/2),2,',','');

					$preco_real2 = number_format(($p['preco_real']/2),2,',','');

					$preco_real3 = number_format(($q['preco_real']/2),2,',','');

					$preco_real4 = number_format(($r['preco_real']/2),2,',','');

					$preco_real5 = number_format(($s['preco_real']/2),2,',','');

					$preco_real6 = number_format(($t['preco_real']/2),2,',','');

				}

			}

			elseif($prioridade == 4){

				if($tipo == 3){

					$preco_real = number_format(($rs['preco_real']/2),2,',','');

					$preco_real2 = number_format(($p['preco_real']/2),2,',','');

					$preco_real3 = number_format(($q['preco_real']/2),2,',','');

					$preco_real4 = number_format(($r['preco_real']/2),2,',','');

					$preco_real5 = number_format(($s['preco_real']/2),2,',','');

					$preco_real6 = number_format(($t['preco_real']/2),2,',','');

				}

				elseif($tipo == 5){

					$preco_real = number_format($rs['preco_real'],2,',','');

					$preco_real2 = number_format($p['preco_real'],2,',','');

					$preco_real3 = number_format($q['preco_real'],2,',','');

					$preco_real4 = number_format($r['preco_real'],2,',','');

					$preco_real5 = number_format($s['preco_real'],2,',','');

					$preco_real6 = number_format($t['preco_real'],2,',','');

				}

				elseif($tipo == 7){

					$preco_real = number_format(15.60,2,',','');

					$preco_real2 = number_format(15.60,2,',','');

					$preco_real3 = number_format(15.60,2,',','');

					$preco_real4 = number_format(15.60,2,',','');

					$preco_real5 = number_format(15.60,2,',','');

					$preco_real6 = number_format(15.60,2,',','');

				}

				elseif($tipo == 8){

					$preco_real = number_format(5.60,2,',','');

					$preco_real2 = number_format(5.60,2,',','');

					$preco_real3 = number_format(5.60,2,',','');

					$preco_real4 = number_format(5.60,2,',','');

					$preco_real5 = number_format(5.60,2,',','');

					$preco_real6 = number_format(5.60,2,',','');

				}

				elseif($tipo == 9){

					$preco_real = number_format(($rs['preco_real']/2),2,',','');

					$preco_real2 = number_format(($p['preco_real']/2),2,',','');

					$preco_real3 = number_format(($q['preco_real']/2),2,',','');

					$preco_real4 = number_format(($r['preco_real']/2),2,',','');

					$preco_real5 = number_format(($s['preco_real']/2),2,',','');

					$preco_real6 = number_format(($t['preco_real']/2),2,',','');

				}

			}				

			

			echo "<tr>";

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

			echo "<tr>";

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

			echo "<tr>";

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

			echo "<tr>";

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

			echo "<tr>";

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

			echo "<tr>";

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

		}

			$total_geral = number_format($total_geral,2,',','');

		  echo "<tr>

		  			<td align='right' colspan='7' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'><strong>TOTAL</strong></td>

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

			$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

			echo "<a href=\"$url\"><strong>&laquo;</strong></a> "; 

		if($pagina > 0) {

			$menos = ($pagina - 1);

			if($menos >= 0){

				$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a página anterior

			}

		}

		$menos2 = $pagina;

		if($pagina > 0) {

			$menos2 = ($menos2 - 1);

			if($menos2 >= 0){

				$url = "$PHP_SELF?pagina=$menos&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a página anterior

			}

		}

			if(!isset($pagina)){

				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=0&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo'>0</a> ";

			}

			else{

				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=$pagina&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo'><strong style='font-size:16px;'><u>".$pagina."</u></strong></a> ";

			}

			$mais = $pagina;

		if($pagina < ($paginas - 1)) {

			for($x=0;$x<(($paginas/2)-1);$x++){

				$mais = $mais + 1;

				$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

				if($mais<=($paginas-1)){

					echo "  <a href=\"$url\">".$mais."</a>";

				}

				else{ echo'';}				

			}

		}



		if($pagina < ($paginas - 1)) {

			$mais = $_GET['pagina'] + 1;

			$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

			if($mais<=$paginas){

				echo " | <a href=\"$url\"><strong>&rsaquo;</strong></a>";

			}

			else {echo'';}

		}

			$mais = ($paginas - 1);

			$url = "$PHP_SELF?pagina=$mais&data_inicio=$data_inicio&data_fim=$data_fim&tipo=$tipo";

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