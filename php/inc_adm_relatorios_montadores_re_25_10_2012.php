<?php

include ("config.php");





$dia =date("d");

$mes =date("m");

$ano =date("Y");

$data =$dia."/".$mes."/".$ano;



$mont = $_POST['mont'];

$data_inicio = $_POST['ano_ini']."-".$_POST['mes_ini']."-".$_POST['dia_ini'];

$data_fim = $_POST['ano_fim']."-".$_POST['mes_fim']."-".$_POST['dia_fim'];

$condicao1 = $_POST['ficha_normal'];

$condicao2 = $_POST['ficha_justica'];

$condicao3 = $_POST['ficha_loja'];



$condicao11 = $condicao1;

$condicao22 = $condicao2;

$condicao33 = $condicao3;



if($condicao1 == 1){$condicao1 = "c.prioridade = '0'";}

else{$condicao1 = "";}



if($condicao2 == 1){

	if($condicao1 != ""){

		$condicao2 = " OR c.prioridade = '2'";

	}

	else{

		$condicao2 = " c.prioridade = '2'";

	}

}

else{$condicao2 = "";}



if($condicao3 == 1){

	if(($condicao1 != "")&&($condicao2 != "")){

		$condicao3 = " OR c.prioridade = '4'";

	}

	elseif(($condicao1 != "")&&($condicao2 == "")){

		$condicao3 = " OR c.prioridade = '4'";

	}

	elseif(($condicao1 == "")&&($condicao2 != "")){

		$condicao3 = " OR c.prioridade = '4'";

	}

	else{

		$condicao3 = " c.prioridade = '4'";

	}

}

else{$condicao3 = "";}



$condicao_fichas = $condicao1.$condicao2.$condicao3;



$ativo = 0;

$not = $_POST['not'];

if($not == 2){

	$cond = "o.status = '$not'";

	$cond_data = "d.data_saida_montador >= '$data_inicio' AND d.data_saida_montador <= '$data_fim'";

}

else{

	$cond = "o.status = '1' OR o.status = '3' OR o.status = '5' OR o.status = '7' OR o.status = '8' OR o.status = '9'";

	$cond_data = "d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim'";

}





if ((strlen($mont)>0)&&($data_inicio!='--')&&($data_fim!='--')){



		$SQL = "SELECT DISTINCT m.nome, c.prioridade, c.tipo, c.*, pr.preco_montador_re, d.*, o.* FROM montadores m, clientes c, datas d, ordem_montagem o, produtos pd, precos pr WHERE c.cod_cliente = pd.cod_produto AND pr.id_preco = pd.id_preco AND c.n_montagem = o.n_montagem AND d.n_montagens = o.n_montagem AND ($cond_data) AND (o.id_montador = m.id_montadores AND m.id_montadores = '$mont' AND ($cond)) AND c.ativo='$ativo' ORDER BY o.n_montagem ASC";

		

		//echo $SQL;

		//exit();

		$executa = mysql_query($SQL)or die(mysql_error());



		// montando a tabela

		echo "<table border='0' width='100%' align='center'>

				  <tr>

				   <td colspan='7' align='center'>

						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>

				   </td>

				  </tr>";

		echo "</table>";

		echo "<table border='0' width='900' cellspacing='1' bgcolor='#000000'>

				<tr>

				  <td bgcolor='#F2F2F2' colspan='7' align='left' style='font-size:14px; font-family:Arial;'><b></b>";

				  ?>

				   <form action="down_notas_montadores_re.php" method="post" style="text-align:center;">

					  <input type="submit" value="Download" />

                      <input type="hidden" name="not" value="<?=$not?>"/>

					  <input type="hidden" name="mont" value="<?=$mont?>"/>

                      <input type="hidden" name="condicao1" value="<?=$condicao11?>"/>

                      <input type="hidden" name="condicao2" value="<?=$condicao22?>"/>

                      <input type="hidden" name="condicao3" value="<?=$condicao33?>"/>                      

					  <input type="hidden" name="data_inicio" value="<?=$data_inicio?>"/>

                      <input type="hidden" name="data_fim" value="<?=$data_fim?>"/>

				  </form>

				  <?php

				  echo "".$data."</td>

				</tr>

				<tr>

				  <td bgcolor='#F2F2F2' style='font-family:Arial;' width='50'><b>Nota</b></td>

				  <td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>Pedido</b></td>

				  <td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>QP</b></td>
				  
				  <td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>C&oacute;d P</b></td>

				  <td align='center' width='300' bgcolor='#F2F2F2' style='font-family:Arial;'><b>Produto</b></td>";

			if($not == 2){

				echo "<td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>Visto Montador</b></td>

				  <td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>Visto Ger&ecirc;ncia</b></td>

				  </tr>";

			}

			else{

				echo "<td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>V. Unit.(R$)</b></td>

				  <td align='center' width='100' bgcolor='#F2F2F2' style='font-family:Arial;'><b>Total(R$)</b></td>

				  </tr>";

			}



		$ii=1;

		$total=0;

		$total_geral =0;

		while ($rs = mysql_fetch_array($executa)){

					            

			if($rs[status] == 1){$status = "<img src='images/tools.png' border='0' />";}

			elseif($rs[status] == 2){$status = "<img src='images/ampulheta.gif' border='0' align='absbottom' />";}

			elseif($rs[status] == 3){$status = "<img src='images/tick.png' border='0' />";}

			elseif($rs[status] == 4){$status = "<img src='images/ico_excluir.jpg' border='0' />";}

			elseif($rs[status] == 5){$status = "<img src='images/justice.png' border='0' />";}

			elseif($rs[status] == 6){$status = "<img src='images/ausente.png' border='0' width='24' />";}



			if($rs[data_final] != '0000-00-00'){

				$data_final = new DateTime($rs[data_final]);  

				$data_final = $data_final->format('d/m/Y');

			}

			else{

				$data_final = 'N&Atilde;O DEFINIDO';

			}

			if($rs[data_entrega_montador] != '0000-00-00'){

				$data_entrega_montador = new DateTime($rs[data_entrega_montador]);  

				$data_entrega_montador = $data_entrega_montador->format('d/m/Y');

			}

			else{

				$data_entrega_montador = 'N&Atilde;O DEFINIDO';

			}

			

			$prioridade = $rs["prioridade"];

			$tipo		= $rs["status"];

		

if($prioridade == 0){

	if($tipo == 3){$modelo = 0;}

	if($tipo == 1){$tipo = 3;}	

	if($tipo == 7){$modelo = 2;}

	if($tipo == 8){$modelo = 3;}

	if($tipo == 9){$modelo = 1;}

}

elseif($prioridade == 2){

	if($tipo == 3){$modelo = 5;}

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

	

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Mont N";

				}

				// montagem justica

				elseif($tipo == 5){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Juri N";

				}

				// montagem revisao

				elseif($tipo == 7){

					$total = (7.50*$rs['qtde_cliente']);

					$texto_condicao = "Revi&atilde; N";

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total = (9.00*$rs['qtde_cliente']);

					$texto_condicao = "Assist Tec N";

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_montador_re']/2)*$rs['qtde_cliente']);

					$texto_condicao = "Desmont N";

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Mont Just";

				}

				// juridico justica

				elseif($tipo == 5){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Juri Just";

				}

				// juridico revisao

				elseif($tipo == 7){

					$total = (7.50*$rs['qtde_cliente']);

					$texto_condicao = "Revi&atilde; Just";

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total = (9.00*$rs['qtde_cliente']);

					$texto_condicao = "Assist Tec Just";

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_montador_re']/2)*$rs['qtde_cliente']);

					$texto_condicao = "Desmont Just";

				}



			}

			elseif($prioridade == 4){

				// loja normal

				if($tipo == 3){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Mont Lj";

				}

				// loja justica

				elseif($tipo == 5){

					$total = ($rs['preco_montador_re']*$rs['qtde_cliente']);

					$texto_condicao = "Juri Lj";

				}

				// loja revisao

				elseif($tipo == 7){

					$total = (7.50*$rs['qtde_cliente']);

					$texto_condicao = "Revis&atilde;o Lj";

				}

				// loja tecnica

				elseif($tipo == 8){

					$total = (9.00*$rs['qtde_cliente']);

					$texto_condicao = "Assist Tec Lj";

				}

				// loja desmontagem

				elseif($tipo == 9){

					$total = (($rs['preco_montador_re']/2)*$rs['qtde_cliente']);

					$texto_condicao = "Desmont Lj";

				}



			}

			//echo $total;

			$select_preco2 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente2]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco2."<br>";

			$query_preco2 = mysql_query($select_preco2);

			$p = mysql_fetch_array($query_preco2);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Mont N";

				}

				// montagem justica

				elseif($tipo == 5){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Juri N";

				}

				// montagem revisao

				elseif($tipo == 7){

					$total2 = (7.50*$rs['qtde_cliente2']);

					$texto_condicao = "Revi&atilde; N";

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total2 = (9.00*$rs['qtde_cliente2']);

					$texto_condicao = "Assist Tec N";

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_montador_re']/2)*$rs['qtde_cliente2']);

					$texto_condicao = "Desmont N";

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Mont Just";

				}

				// juridico justica

				elseif($tipo == 5){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Juri Just";

				}

				// juridico revisao

				elseif($tipo == 7){

					$total2 = (7.50*$rs['qtde_cliente2']);

					$texto_condicao = "Revi&atilde; Just";

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total2 = (9.00*$rs['qtde_cliente2']);

					$texto_condicao = "Assist Tec Just";

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_montador_re']/2)*$rs['qtde_cliente2']);

					$texto_condicao = "Desmont Just";

				}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Mont Lj";

				}

				// montagem justica

				elseif($tipo == 5){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Juri Lj";

				}

				// montagem revisao

				elseif($tipo == 7){

					$total2 = ($p['preco_montador_re']*$rs['qtde_cliente2']);

					$texto_condicao = "Revis&atilde;o Lj";

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total2 = (9.00*$rs['qtde_cliente2']);

					$texto_condicao = "Assist Tec Lj";

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total2 = (($p['preco_montador_re']/2)*$rs['qtde_cliente2']);

					$texto_condicao = "Desmont Lj";

				}



			}

			

			$select_preco3 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente3]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco3."<br>";

			$query_preco3 = mysql_query($select_preco3);

			$q = mysql_fetch_array($query_preco3);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Mont N";

				}

				// montagem justica

				elseif($tipo == 5){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Juri N";

				}

				// montagem revisao

				elseif($tipo == 7){

					$total3 = (7.50*$rs['qtde_cliente3']);

					$texto_condicao = "Revi&atilde; N";

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total3 = (9.00*$rs['qtde_cliente3']);

					$texto_condicao = "Assist Tec N";

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_montador_re']/2)*$rs['qtde_cliente3']);

					$texto_condicao = "Desmont N";

				}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Mont Just";

				}

				// juridico justica

				elseif($tipo == 5){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Juri Just";

				}

				// juridico revisao

				elseif($tipo == 7){

					$total3 = (7.50*$rs['qtde_cliente3']);

					$texto_condicao = "Revi&atilde; Just";

				}

				// juridico tecnica

				elseif($tipo == 8){

					$total3 = (9.00*$rs['qtde_cliente3']);

					$texto_condicao = "Assist Tec Just";

				}

				// juridico desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_montador_re']/2)*$rs['qtde_cliente3']);

					$texto_condicao = "Desmont Just";

				}

				

			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Mont Lj";

				}

				// montagem justica

				elseif($tipo == 5){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Juri Lj";

				}

				// montagem revisao

				elseif($tipo == 7){

					$total3 = ($q['preco_montador_re']*$rs['qtde_cliente3']);

					$texto_condicao = "Revi&atilde; Lj";

				}

				// montagem tecnica

				elseif($tipo == 8){

					$total3 = (9.00*$rs['qtde_cliente3']);

					$texto_condicao = "Assist Tec Lj";

				}

				// montagem desmontagem

				elseif($tipo == 9){

					$total3 = (($q['preco_montador_re']/2)*$rs['qtde_cliente3']);

					$texto_condicao = "Desmont Lj";

				}



			}

			

			$select_preco4 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente4]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco4."<br>";

			$query_preco4 = mysql_query($select_preco4);

			$r = mysql_fetch_array($query_preco4);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Mont N";

					}

				// montagem justica

				elseif($tipo == 5){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Juri N";

					}

				// montagem revisao

				elseif($tipo == 7){

					$total4 = (7.50*$rs['qtde_cliente4']);

					$texto_condicao = "Revi&atilde; N";

					}

				// montagem tecnica

				elseif($tipo == 8){

					$total4 = (9.00*$rs['qtde_cliente4']);

					$texto_condicao = "Assist Tec N";

					}

				// montagem desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_montador_re']/2)*$rs['qtde_cliente4']);

					$texto_condicao = "Desmont N";

					}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Mont Just";

					}

				// juridico justica

				elseif($tipo == 5){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Juri Just";

					}

				// juridico revisao

				elseif($tipo == 7){

					$total4 = (7.50*$rs['qtde_cliente4']);

					$texto_condicao = "Revi&atilde; Just";

					}

				// juridico tecnica

				elseif($tipo == 8){

					$total4 = (9.00*$rs['qtde_cliente4']);

					$texto_condicao = "Assist Tec Just";

					}

				// juridico desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_montador_re']/2)*$rs['qtde_cliente4']);

					$texto_condicao = "Desmont Just";

					}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Mont Lj";

					}

				// montagem justica

				elseif($tipo == 5){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Juri Lj";

					}

				// montagem revisao

				elseif($tipo == 7){

					$total4 = ($r['preco_montador_re']*$rs['qtde_cliente4']);

					$texto_condicao = "Revi&atilde; Lj";

					}

				// montagem tecnica

				elseif($tipo == 8){

					$total4 = (9.00*$rs['qtde_cliente4']);

					$texto_condicao = "Assist Tec Lj";

					}

				// montagem desmontagem

				elseif($tipo == 9){

					$total4 = (($r['preco_montador_re']/2)*$rs['qtde_cliente4']);

					$texto_condicao = "Desmont Lj";

					}



			}

			

			$select_preco5 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente5]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco5."<br>";

			$query_preco5 = mysql_query($select_preco5);

			$s = mysql_fetch_array($query_preco5);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

					$texto_condicao = "Mont N";

					}

				// montagem justica

				elseif($tipo == 5){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

					$texto_condicao = "Juri N";

					}

				// montagem revisao

				elseif($tipo == 7){

					$total5 = (7.50*$rs['qtde_cliente5']);

					$texto_condicao = "Revi&atilde; N";

					}

				// montagem tecnica

				elseif($tipo == 8){

					$total5 = (9.00*$rs['qtde_cliente5']);

					$texto_condicao = "Assist Tec N";

					}

				// montagem desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_montador_re']/2)*$rs['qtde_cliente5']);

					$texto_condicao = "Desmont N";

					}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

					$texto_condicao = "Mont Just";

					}

				// juridico justica

				elseif($tipo == 5){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

					$texto_condicao = "Juri Just";

					}

				// juridico revisao

				elseif($tipo == 7){

					$total5 = (7.50*$rs['qtde_cliente5']);

					$texto_condicao = "Revi&atilde; Just";

					}

				// juridico tecnica

				elseif($tipo == 8){

					$total5 = (9.00*$rs['qtde_cliente5']);

					$texto_condicao = "Assist Tec Just";

					}

				// juridico desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_montador_re']/2)*$rs['qtde_cliente5']);

					$texto_condicao = "Desmont Just";

					}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total5 = ($s['preco_montador_re']*$rs['qtde_cliente5']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total5 = (9.00*$rs['qtde_cliente5']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total5 = (($s['preco_montador_re']/2)*$rs['qtde_cliente5']);

$texto_condicao = "Desmont Lj";

}



			}



			$select_preco6 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente6]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco6."<br>";

			$query_preco6 = mysql_query($select_preco6);

			$t = mysql_fetch_array($query_preco6);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total6 = (7.50*$rs['qtde_cliente6']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total6 = (9.00*$rs['qtde_cliente6']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_montador_re']/2)*$rs['qtde_cliente6']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total6 = (7.50*$rs['qtde_cliente6']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total6 = (9.00*$rs['qtde_cliente6']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_montador_re']/2)*$rs['qtde_cliente6']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total6 = ($t['preco_montador_re']*$rs['qtde_cliente6']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total6 = (9.00*$rs['qtde_cliente6']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total6 = (($t['preco_montador_re']/2)*$rs['qtde_cliente6']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco7 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente7]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco7."<br>";

			$query_preco7 = mysql_query($select_preco7);

			$u = mysql_fetch_array($query_preco7);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total7 = (7.50*$rs['qtde_cliente7']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total7 = (9.00*$rs['qtde_cliente7']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total7 = (($u['preco_montador_re']/2)*$rs['qtde_cliente7']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total7 = (7.50*$rs['qtde_cliente7']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total7 = (9.00*$rs['qtde_cliente7']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total7 = (($u['preco_montador_re']/2)*$rs['qtde_cliente7']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total7 = ($u['preco_montador_re']*$rs['qtde_cliente7']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total7 = (9.00*$rs['qtde_cliente7']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total7 = (($u['preco_montador_re']/2)*$rs['qtde_cliente7']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco8 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente8]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco8."<br>";

			$query_preco8 = mysql_query($select_preco8);

			$v = mysql_fetch_array($query_preco8);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total8 = (7.50*$rs['qtde_cliente8']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total8 = (9.00*$rs['qtde_cliente8']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total8 = (($v['preco_montador_re']/2)*$rs['qtde_cliente8']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total8 = (7.50*$rs['qtde_cliente8']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total8 = (9.00*$rs['qtde_cliente8']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total8 = (($v['preco_montador_re']/2)*$rs['qtde_cliente8']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total8 = ($v['preco_montador_re']*$rs['qtde_cliente8']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total8 = (9.00*$rs['qtde_cliente8']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total8 = (($v['preco_montador_re']/2)*$rs['qtde_cliente8']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco9 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente9]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco9."<br>";

			$query_preco9 = mysql_query($select_preco9);

			$x = mysql_fetch_array($query_preco9);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total9 = (7.50*$rs['qtde_cliente9']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total9 = (9.00*$rs['qtde_cliente9']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total9 = (($x['preco_montador_re']/2)*$rs['qtde_cliente9']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total9 = (7.50*$rs['qtde_cliente9']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total9 = (9.00*$rs['qtde_cliente9']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total9 = (($x['preco_montador_re']/2)*$rs['qtde_cliente9']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total9 = ($x['preco_montador_re']*$rs['qtde_cliente9']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total9 = (9.00*$rs['qtde_cliente9']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total9 = (($x['preco_montador_re']/2)*$rs['qtde_cliente9']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco10 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente10]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco10."<br>";

			$query_preco10 = mysql_query($select_preco10);

			$z = mysql_fetch_array($query_preco10);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total10 = (7.50*$rs['qtde_cliente10']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total10 = (9.00*$rs['qtde_cliente10']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total10 = (($z['preco_montador_re']/2)*$rs['qtde_cliente10']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total10 = (7.50*$rs['qtde_cliente10']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total10 = (9.00*$rs['qtde_cliente10']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total10 = (($z['preco_montador_re']/2)*$rs['qtde_cliente10']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total10 = ($z['preco_montador_re']*$rs['qtde_cliente10']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total10 = (9.00*$rs['qtde_cliente10']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total10 = (($z['preco_montador_re']/2)*$rs['qtde_cliente10']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco11 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente11]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco11."<br>";

			$query_preco11 = mysql_query($select_preco11);

			$a = mysql_fetch_array($query_preco11);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total11 = (7.50*$rs['qtde_cliente11']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total11 = (9.00*$rs['qtde_cliente11']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total11 = (($a['preco_montador_re']/2)*$rs['qtde_cliente11']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total11 = (7.50*$rs['qtde_cliente11']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total11 = (9.00*$rs['qtde_cliente11']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total11 = (($a['preco_montador_re']/2)*$rs['qtde_cliente11']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total11 = ($a['preco_montador_re']*$rs['qtde_cliente11']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total11 = (9.00*$rs['qtde_cliente11']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total11 = (($a['preco_montador_re']/2)*$rs['qtde_cliente11']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco12 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente12]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco12."<br>";

			$query_preco12 = mysql_query($select_preco12);

			$b = mysql_fetch_array($query_preco12);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total12 = (7.50*$rs['qtde_cliente12']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total12 = (9.00*$rs['qtde_cliente12']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total12 = (($b['preco_montador_re']/2)*$rs['qtde_cliente12']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total12 = (7.50*$rs['qtde_cliente12']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total12 = (9.00*$rs['qtde_cliente12']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total12 = (($b['preco_montador_re']/2)*$rs['qtde_cliente12']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total12 = ($b['preco_montador_re']*$rs['qtde_cliente12']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total12 = (9.00*$rs['qtde_cliente12']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total12 = (($b['preco_montador_re']/2)*$rs['qtde_cliente12']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco13 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente13]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco13."<br>";

			$query_preco13 = mysql_query($select_preco13);

			$c = mysql_fetch_array($query_preco13);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total13 = (7.50*$rs['qtde_cliente13']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total13 = (9.00*$rs['qtde_cliente13']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total13 = (($c['preco_montador_re']/2)*$rs['qtde_cliente13']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total13 = (7.50*$rs['qtde_cliente13']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total13 = (9.00*$rs['qtde_cliente13']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total13 = (($c['preco_montador_re']/2)*$rs['qtde_cliente13']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total13 = ($c['preco_montador_re']*$rs['qtde_cliente13']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total13 = (9.00*$rs['qtde_cliente13']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total13 = (($c['preco_montador_re']/2)*$rs['qtde_cliente13']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco14 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente14]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco14."<br>";

			$query_preco14 = mysql_query($select_preco14);

			$d = mysql_fetch_array($query_preco14);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total14 = (7.50*$rs['qtde_cliente14']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total14 = (9.00*$rs['qtde_cliente14']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total14 = (($d['preco_montador_re']/2)*$rs['qtde_cliente14']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total14 = (7.50*$rs['qtde_cliente14']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total14 = (9.00*$rs['qtde_cliente14']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total14 = (($d['preco_montador_re']/2)*$rs['qtde_cliente14']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total14 = ($d['preco_montador_re']*$rs['qtde_cliente14']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total14 = (9.00*$rs['qtde_cliente14']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total14 = (($d['preco_montador_re']/2)*$rs['qtde_cliente14']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco15 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente15]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco15."<br>";

			$query_preco15 = mysql_query($select_preco15);

			$e = mysql_fetch_array($query_preco15);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total15 = (7.50*$rs['qtde_cliente15']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total15 = (9.00*$rs['qtde_cliente15']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total15 = (($e['preco_montador_re']/2)*$rs['qtde_cliente15']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total15 = (7.50*$rs['qtde_cliente15']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total15 = (9.00*$rs['qtde_cliente15']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total15 = (($e['preco_montador_re']/2)*$rs['qtde_cliente15']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total15 = ($e['preco_montador_re']*$rs['qtde_cliente15']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total15 = (9.00*$rs['qtde_cliente15']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total15 = (($e['preco_montador_re']/2)*$rs['qtde_cliente15']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco16 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente16]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco16."<br>";

			$query_preco16 = mysql_query($select_preco16);

			$f = mysql_fetch_array($query_preco16);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total16 = (7.50*$rs['qtde_cliente16']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total16 = (9.00*$rs['qtde_cliente16']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total16 = (($f['preco_montador_re']/2)*$rs['qtde_cliente16']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total16 = (7.50*$rs['qtde_cliente16']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total16 = (9.00*$rs['qtde_cliente16']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total16 = (($f['preco_montador_re']/2)*$rs['qtde_cliente16']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total16 = ($f['preco_montador_re']*$rs['qtde_cliente16']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total16 = (9.00*$rs['qtde_cliente16']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total16 = (($f['preco_montador_re']/2)*$rs['qtde_cliente16']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco17 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente17]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco17."<br>";

			$query_preco17 = mysql_query($select_preco17);

			$g = mysql_fetch_array($query_preco17);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Mont N";

}

				// monagem justica

				elseif($tipo == 5){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total17 = (7.50*$rs['qtde_cliente17']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total17 = (9.00*$rs['qtde_cliente17']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total17 = (($g['preco_montador_re']/2)*$rs['qtde_cliente17']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total17 = (7.50*$rs['qtde_cliente17']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total17 = (9.00*$rs['qtde_cliente17']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total17 = (($g['preco_montador_re']/2)*$rs['qtde_cliente17']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total17 = ($g['preco_montador_re']*$rs['qtde_cliente17']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total17 = (9.00*$rs['qtde_cliente17']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total17 = (($g['preco_montador_re']/2)*$rs['qtde_cliente17']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco18 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente18]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco18."<br>";

			$query_preco18 = mysql_query($select_preco18);

			$h = mysql_fetch_array($query_preco18);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total18 = (7.50*$rs['qtde_cliente18']);

$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total18 = (9.00*$rs['qtde_cliente18']);

$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total18 = (($h['preco_montador_re']/2)*$rs['qtde_cliente18']);

$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total18 = (7.50*$rs['qtde_cliente18']);

$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total18 = (9.00*$rs['qtde_cliente18']);

$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total18 = (($h['preco_montador_re']/2)*$rs['qtde_cliente18']);

$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total18 = ($h['preco_montador_re']*$rs['qtde_cliente18']);

$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total18 = (9.00*$rs['qtde_cliente18']);

$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total18 = (($h['preco_montador_re']/2)*$rs['qtde_cliente18']);

$texto_condicao = "Desmont Lj";

}



			}

			$select_preco19 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente19]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco19."<br>";

			$query_preco19 = mysql_query($select_preco19);

			$i = mysql_fetch_array($query_preco19);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total19 = (7.50*$rs['qtde_cliente19']);

					$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total19 = (9.00*$rs['qtde_cliente19']);

					$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total19 = (($i['preco_montador_re']/2)*$rs['qtde_cliente19']);

					$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total19 = (7.50*$rs['qtde_cliente19']);

					$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total19 = (9.00*$rs['qtde_cliente19']);

					$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total19 = (($i['preco_montador_re']/2)*$rs['qtde_cliente19']);

					$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total19 = ($i['preco_montador_re']*$rs['qtde_cliente19']);

					$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total19 = (9.00*$rs['qtde_cliente19']);

					$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total19 = (($i['preco_montador_re']/2)*$rs['qtde_cliente19']);

					$texto_condicao = "Desmont Lj";

}



			}

			$select_preco20 = "SELECT p.preco_montador_re FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente20]' AND p.id_preco = pd.id_preco ";

			//echo $select_preco20."<br>";

			$query_preco20 = mysql_query($select_preco20);

			$j = mysql_fetch_array($query_preco20);

			

			if($prioridade == 0){

				// montagem normal

				if($tipo == 3){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Mont N";

}

				// montagem justica

				elseif($tipo == 5){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Juri N";

}

				// montagem revisao

				elseif($tipo == 7){

					$total20 = (7.50*$rs['qtde_cliente20']);

					$texto_condicao = "Revi&atilde; N";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total20 = (9.00*$rs['qtde_cliente20']);

					$texto_condicao = "Assist Tec N";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total20 = (($j['preco_montador_re']/2)*$rs['qtde_cliente20']);

					$texto_condicao = "Desmont N";

}



			}

			elseif($prioridade == 2){

				// juridico normal

				if($tipo == 3){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Mont Just";

}

				// juridico justica

				elseif($tipo == 5){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Juri Just";

}

				// juridico revisao

				elseif($tipo == 7){

					$total20 = (7.50*$rs['qtde_cliente20']);

					$texto_condicao = "Revi&atilde; Just";

}

				// juridico tecnica

				elseif($tipo == 8){

					$total20 = (9.00*$rs['qtde_cliente20']);

					$texto_condicao = "Assist Tec Just";

}

				// juridico desmontagem

				elseif($tipo == 9){

					$total20 = (($j['preco_montador_re']/2)*$rs['qtde_cliente20']);

					$texto_condicao = "Desmont Just";

}



			}

			elseif($prioridade == 4){

				// montagem normal

				if($tipo == 3){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Mont Lj";

}

				// montagem justica

				elseif($tipo == 5){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Juri Lj";

}

				// montagem revisao

				elseif($tipo == 7){

					$total20 = ($j['preco_montador_re']*$rs['qtde_cliente20']);

					$texto_condicao = "Revi&atilde; Lj";

}

				// montagem tecnica

				elseif($tipo == 8){

					$total20 = (9.00*$rs['qtde_cliente20']);

					$texto_condicao = "Assist Tec Lj";

}

				// montagem desmontagem

				elseif($tipo == 9){

					$total20 = (($j['preco_montador_re']/2)*$rs['qtde_cliente20']);

					$texto_condicao = "Desmont Lj";

}



			}



			$detalhe = '';

			$porcentagem = 0;

			if($rs["porcentagem"] == 1){

				$detalhe = '*';

				$porcentagem = 20;

				$total = ($total + (($total*$porcentagem)/100));

				$total2 = ($total2 + (($total2*$porcentagem)/100));

				$total3 = ($total3 + (($total3*$porcentagem)/100));

				$total4 = ($total4 + (($total4*$porcentagem)/100));

				$total5 = ($total5 + (($total5*$porcentagem)/100));

				$total6 = ($total6 + (($total6*$porcentagem)/100));

				$total7 = ($total7 + (($total7*$porcentagem)/100));

				$total8 = ($total8 + (($total8*$porcentagem)/100));

				$total9 = ($total9 + (($total9*$porcentagem)/100));

				$total10 = ($total10 + (($total10*$porcentagem)/100));

				$total11 = ($total11 + (($total11*$porcentagem)/100));

				$total12 = ($total12 + (($total12*$porcentagem)/100));

				$total13 = ($total13 + (($total13*$porcentagem)/100));

				$total14 = ($total14 + (($total14*$porcentagem)/100));

				$total15 = ($total15 + (($total15*$porcentagem)/100));

				$total16 = ($total16 + (($total16*$porcentagem)/100));

				$total17 = ($total17 + (($total17*$porcentagem)/100));

				$total18 = ($total18 + (($total18*$porcentagem)/100));

				$total19 = ($total19 + (($total19*$porcentagem)/100));

				$total20 = ($total20 + (($total20*$porcentagem)/100));

			}



			$total_geral += $total+$total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9+$total10+$total11+$total12+$total13+$total14+$total15+$total16+$total17+$total18+$total19+$total20;



			

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

		

	if($rs["porcentagem"] == 1){		

			if($prioridade == 0){

				if($tipo == 3){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format((($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re2 = number_format((($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re3 = number_format((($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re4 = number_format((($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re5 = number_format((($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re6 = number_format((($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re7 = number_format((($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re8 = number_format((($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re9 = number_format((($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re10 = number_format((($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re11 = number_format((($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re12 = number_format((($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re13 = number_format((($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re14 = number_format((($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re15 = number_format((($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re16 = number_format((($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re17 = number_format((($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re18 = number_format((($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re19 = number_format((($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re20 = number_format((($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100))/2),2,',','');	

				}

			}

			elseif($prioridade == 2){

				if($tipo == 3){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');						

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format((($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re2 = number_format((($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re3 = number_format((($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re4 = number_format((($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re5 = number_format((($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re6 = number_format((($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re7 = number_format((($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re8 = number_format((($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re9 = number_format((($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re10 = number_format((($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re11 = number_format((($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re12 = number_format((($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re13 = number_format((($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re14 = number_format((($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re15 = number_format((($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re16 = number_format((($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re17 = number_format((($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re18 = number_format((($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re19 = number_format((($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re20 = number_format((($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100))/2),2,',','');	

				}

			}

			elseif($prioridade == 4){

				if($tipo == 3){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format(($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((7.50+((7.50*$porcentagem)/100)),2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re2 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re3 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re4 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re5 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re6 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re7 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re8 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re9 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re10 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re11 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re12 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re13 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re14 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re15 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re16 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re17 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re18 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re19 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');

					$preco_montador_re20 = number_format((9.00+((9.00*$porcentagem)/100)),2,',','');						

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format((($rs['preco_montador_re']+(($rs['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re2 = number_format((($p['preco_montador_re']+(($p['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re3 = number_format((($q['preco_montador_re']+(($q['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re4 = number_format((($r['preco_montador_re']+(($r['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re5 = number_format((($s['preco_montador_re']+(($s['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re6 = number_format((($t['preco_montador_re']+(($t['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re7 = number_format((($u['preco_montador_re']+(($u['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re8 = number_format((($v['preco_montador_re']+(($v['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re9 = number_format((($x['preco_montador_re']+(($x['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re10 = number_format((($z['preco_montador_re']+(($z['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re11 = number_format((($a['preco_montador_re']+(($a['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re12 = number_format((($b['preco_montador_re']+(($b['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re13 = number_format((($c['preco_montador_re']+(($c['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re14 = number_format((($d['preco_montador_re']+(($d['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re15 = number_format((($e['preco_montador_re']+(($e['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re16 = number_format((($f['preco_montador_re']+(($f['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re17 = number_format((($g['preco_montador_re']+(($g['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re18 = number_format((($h['preco_montador_re']+(($h['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re19 = number_format((($i['preco_montador_re']+(($i['preco_montador_re']*$porcentagem)/100))/2),2,',','');

					$preco_montador_re20 = number_format((($j['preco_montador_re']+(($j['preco_montador_re']*$porcentagem)/100))/2),2,',','');	

				}

			}		

####################################################################################################################			

	}

	else{		

			if($prioridade == 0){

				if($tipo == 3){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format(7.50,2,',','');

					$preco_montador_re2 = number_format(7.50,2,',','');

					$preco_montador_re3 = number_format(7.50,2,',','');

					$preco_montador_re4 = number_format(7.50,2,',','');

					$preco_montador_re5 = number_format(7.50,2,',','');

					$preco_montador_re6 = number_format(7.50,2,',','');

					$preco_montador_re7 = number_format(7.50,2,',','');

					$preco_montador_re8 = number_format(7.50,2,',','');

					$preco_montador_re9 = number_format(7.50,2,',','');

					$preco_montador_re10 = number_format(7.50,2,',','');

					$preco_montador_re11 = number_format(7.50,2,',','');

					$preco_montador_re12 = number_format(7.50,2,',','');

					$preco_montador_re13 = number_format(7.50,2,',','');

					$preco_montador_re14 = number_format(7.50,2,',','');

					$preco_montador_re15 = number_format(7.50,2,',','');

					$preco_montador_re16 = number_format(7.50,2,',','');

					$preco_montador_re17 = number_format(7.50,2,',','');

					$preco_montador_re18 = number_format(7.50,2,',','');

					$preco_montador_re19 = number_format(7.50,2,',','');

					$preco_montador_re20 = number_format(7.50,2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format(9.00,2,',','');

					$preco_montador_re2 = number_format(9.00,2,',','');

					$preco_montador_re3 = number_format(9.00,2,',','');

					$preco_montador_re4 = number_format(9.00,2,',','');

					$preco_montador_re5 = number_format(9.00,2,',','');

					$preco_montador_re6 = number_format(9.00,2,',','');

					$preco_montador_re7 = number_format(9.00,2,',','');

					$preco_montador_re8 = number_format(9.00,2,',','');

					$preco_montador_re9 = number_format(9.00,2,',','');

					$preco_montador_re10 = number_format(9.00,2,',','');

					$preco_montador_re11 = number_format(9.00,2,',','');

					$preco_montador_re12 = number_format(9.00,2,',','');

					$preco_montador_re13 = number_format(9.00,2,',','');

					$preco_montador_re14 = number_format(9.00,2,',','');

					$preco_montador_re15 = number_format(9.00,2,',','');

					$preco_montador_re16 = number_format(9.00,2,',','');

					$preco_montador_re17 = number_format(9.00,2,',','');

					$preco_montador_re18 = number_format(9.00,2,',','');

					$preco_montador_re19 = number_format(9.00,2,',','');

					$preco_montador_re20 = number_format(9.00,2,',','');	

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format(($rs['preco_montador_re']/2),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']/2),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']/2),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']/2),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']/2),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']/2),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']/2),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']/2),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']/2),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']/2),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']/2),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']/2),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']/2),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']/2),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']/2),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']/2),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']/2),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']/2),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']/2),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']/2),2,',','');	

				}

			}

			elseif($prioridade == 2){

				if($tipo == 3){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format(7.50,2,',','');

					$preco_montador_re2 = number_format(7.50,2,',','');

					$preco_montador_re3 = number_format(7.50,2,',','');

					$preco_montador_re4 = number_format(7.50,2,',','');

					$preco_montador_re5 = number_format(7.50,2,',','');

					$preco_montador_re6 = number_format(7.50,2,',','');

					$preco_montador_re7 = number_format(7.50,2,',','');

					$preco_montador_re8 = number_format(7.50,2,',','');

					$preco_montador_re9 = number_format(7.50,2,',','');

					$preco_montador_re10 = number_format(7.50,2,',','');

					$preco_montador_re11 = number_format(7.50,2,',','');

					$preco_montador_re12 = number_format(7.50,2,',','');

					$preco_montador_re13 = number_format(7.50,2,',','');

					$preco_montador_re14 = number_format(7.50,2,',','');

					$preco_montador_re15 = number_format(7.50,2,',','');

					$preco_montador_re16 = number_format(7.50,2,',','');

					$preco_montador_re17 = number_format(7.50,2,',','');

					$preco_montador_re18 = number_format(7.50,2,',','');

					$preco_montador_re19 = number_format(7.50,2,',','');

					$preco_montador_re20 = number_format(7.50,2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format(9.00,2,',','');

					$preco_montador_re2 = number_format(9.00,2,',','');

					$preco_montador_re3 = number_format(9.00,2,',','');

					$preco_montador_re4 = number_format(9.00,2,',','');

					$preco_montador_re5 = number_format(9.00,2,',','');

					$preco_montador_re6 = number_format(9.00,2,',','');

					$preco_montador_re7 = number_format(9.00,2,',','');

					$preco_montador_re8 = number_format(9.00,2,',','');

					$preco_montador_re9 = number_format(9.00,2,',','');

					$preco_montador_re10 = number_format(9.00,2,',','');

					$preco_montador_re11 = number_format(9.00,2,',','');

					$preco_montador_re12 = number_format(9.00,2,',','');

					$preco_montador_re13 = number_format(9.00,2,',','');

					$preco_montador_re14 = number_format(9.00,2,',','');

					$preco_montador_re15 = number_format(9.00,2,',','');

					$preco_montador_re16 = number_format(9.00,2,',','');

					$preco_montador_re17 = number_format(9.00,2,',','');

					$preco_montador_re18 = number_format(9.00,2,',','');

					$preco_montador_re19 = number_format(9.00,2,',','');

					$preco_montador_re20 = number_format(9.00,2,',','');						

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format(($rs['preco_montador_re']/2),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']/2),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']/2),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']/2),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']/2),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']/2),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']/2),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']/2),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']/2),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']/2),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']/2),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']/2),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']/2),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']/2),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']/2),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']/2),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']/2),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']/2),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']/2),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']/2),2,',','');						

				}

			}

			elseif($prioridade == 4){

				if($tipo == 3){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 5){

					$preco_montador_re = number_format($rs['preco_montador_re'],2,',','');

					$preco_montador_re2 = number_format($p['preco_montador_re'],2,',','');

					$preco_montador_re3 = number_format($q['preco_montador_re'],2,',','');

					$preco_montador_re4 = number_format($r['preco_montador_re'],2,',','');

					$preco_montador_re5 = number_format($s['preco_montador_re'],2,',','');

					$preco_montador_re6 = number_format($t['preco_montador_re'],2,',','');

					$preco_montador_re7 = number_format($u['preco_montador_re'],2,',','');

					$preco_montador_re8 = number_format($v['preco_montador_re'],2,',','');

					$preco_montador_re9 = number_format($x['preco_montador_re'],2,',','');

					$preco_montador_re10 = number_format($z['preco_montador_re'],2,',','');

					$preco_montador_re11 = number_format($a['preco_montador_re'],2,',','');

					$preco_montador_re12 = number_format($b['preco_montador_re'],2,',','');

					$preco_montador_re13 = number_format($c['preco_montador_re'],2,',','');

					$preco_montador_re14 = number_format($d['preco_montador_re'],2,',','');

					$preco_montador_re15 = number_format($e['preco_montador_re'],2,',','');

					$preco_montador_re16 = number_format($f['preco_montador_re'],2,',','');

					$preco_montador_re17 = number_format($g['preco_montador_re'],2,',','');

					$preco_montador_re18 = number_format($h['preco_montador_re'],2,',','');

					$preco_montador_re19 = number_format($i['preco_montador_re'],2,',','');

					$preco_montador_re20 = number_format($j['preco_montador_re'],2,',','');	

				}

				elseif($tipo == 7){

					$preco_montador_re = number_format(7.50,2,',','');

					$preco_montador_re2 = number_format(7.50,2,',','');

					$preco_montador_re3 = number_format(7.50,2,',','');

					$preco_montador_re4 = number_format(7.50,2,',','');

					$preco_montador_re5 = number_format(7.50,2,',','');

					$preco_montador_re6 = number_format(7.50,2,',','');

					$preco_montador_re7 = number_format(7.50,2,',','');

					$preco_montador_re8 = number_format(7.50,2,',','');

					$preco_montador_re9 = number_format(7.50,2,',','');

					$preco_montador_re10 = number_format(7.50,2,',','');

					$preco_montador_re11 = number_format(7.50,2,',','');

					$preco_montador_re12 = number_format(7.50,2,',','');

					$preco_montador_re13 = number_format(7.50,2,',','');

					$preco_montador_re14 = number_format(7.50,2,',','');

					$preco_montador_re15 = number_format(7.50,2,',','');

					$preco_montador_re16 = number_format(7.50,2,',','');

					$preco_montador_re17 = number_format(7.50,2,',','');

					$preco_montador_re18 = number_format(7.50,2,',','');

					$preco_montador_re19 = number_format(7.50,2,',','');

					$preco_montador_re20 = number_format(7.50,2,',','');	

				}

				elseif($tipo == 8){

					$preco_montador_re = number_format(9.00,2,',','');

					$preco_montador_re2 = number_format(9.00,2,',','');

					$preco_montador_re3 = number_format(9.00,2,',','');

					$preco_montador_re4 = number_format(9.00,2,',','');

					$preco_montador_re5 = number_format(9.00,2,',','');

					$preco_montador_re6 = number_format(9.00,2,',','');

					$preco_montador_re7 = number_format(9.00,2,',','');

					$preco_montador_re8 = number_format(9.00,2,',','');

					$preco_montador_re9 = number_format(9.00,2,',','');

					$preco_montador_re10 = number_format(9.00,2,',','');

					$preco_montador_re11 = number_format(9.00,2,',','');

					$preco_montador_re12 = number_format(9.00,2,',','');

					$preco_montador_re13 = number_format(9.00,2,',','');

					$preco_montador_re14 = number_format(9.00,2,',','');

					$preco_montador_re15 = number_format(9.00,2,',','');

					$preco_montador_re16 = number_format(9.00,2,',','');

					$preco_montador_re17 = number_format(9.00,2,',','');

					$preco_montador_re18 = number_format(9.00,2,',','');

					$preco_montador_re19 = number_format(9.00,2,',','');

					$preco_montador_re20 = number_format(9.00,2,',','');						

				}

				elseif($tipo == 9){

					$preco_montador_re = number_format(($rs['preco_montador_re']/2),2,',','');

					$preco_montador_re2 = number_format(($p['preco_montador_re']/2),2,',','');

					$preco_montador_re3 = number_format(($q['preco_montador_re']/2),2,',','');

					$preco_montador_re4 = number_format(($r['preco_montador_re']/2),2,',','');

					$preco_montador_re5 = number_format(($s['preco_montador_re']/2),2,',','');

					$preco_montador_re6 = number_format(($t['preco_montador_re']/2),2,',','');

					$preco_montador_re7 = number_format(($u['preco_montador_re']/2),2,',','');

					$preco_montador_re8 = number_format(($v['preco_montador_re']/2),2,',','');

					$preco_montador_re9 = number_format(($x['preco_montador_re']/2),2,',','');

					$preco_montador_re10 = number_format(($z['preco_montador_re']/2),2,',','');

					$preco_montador_re11 = number_format(($a['preco_montador_re']/2),2,',','');

					$preco_montador_re12 = number_format(($b['preco_montador_re']/2),2,',','');

					$preco_montador_re13 = number_format(($c['preco_montador_re']/2),2,',','');

					$preco_montador_re14 = number_format(($d['preco_montador_re']/2),2,',','');

					$preco_montador_re15 = number_format(($e['preco_montador_re']/2),2,',','');

					$preco_montador_re16 = number_format(($f['preco_montador_re']/2),2,',','');

					$preco_montador_re17 = number_format(($g['preco_montador_re']/2),2,',','');

					$preco_montador_re18 = number_format(($h['preco_montador_re']/2),2,',','');

					$preco_montador_re19 = number_format(($i['preco_montador_re']/2),2,',','');

					$preco_montador_re20 = number_format(($j['preco_montador_re']/2),2,',','');	

				}

			}

	}		

#########################################################################################################################################					

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total</td>";				

			}

			echo "</tr>";

			if(strlen($rs['cod_cliente2'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente2]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente2]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente2]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re2</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total2</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente3'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente3]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente3]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente3]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re3</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total3</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente4'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente4]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente4]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente4]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re4</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total4</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente5'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente5]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente5]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente5]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re5</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total5</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente6'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente6]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente6]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente6]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re6</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total6</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente7'])>0){

			$ii++;			

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente7]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente7]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente7]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re7</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total7</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente8'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente8]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente8]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente8]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re8</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total8</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente9'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente9]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente9]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente9]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re9</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total9</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente10'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente10]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente10]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente10]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re10</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total10</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente11'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente11]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente11]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'$detalhe >$rs[produto_cliente11]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re11</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total11</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente12'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente12]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente12]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente12]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re12</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total12</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente13'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente13]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente13]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente13]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re13</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total13</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente14'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente14]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente14]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente14]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re14</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total14</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente15'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente15]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente15]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente15]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re15</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total15</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente16'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente16]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente16]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente16]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re16</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total16</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente17'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente17]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente17]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente17]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re17</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total17</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente18'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente18]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente18]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente18]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re18</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total18</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente19'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente19]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente19]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente19]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re19</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total19</td>";				

			}

			echo "</tr>";

			}

			if(strlen($rs['cod_cliente20'])>0){

			$ii++;

			echo "<tr>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[n_montagem]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[orcamento]</td>";
				
				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[qtde_cliente20]</td>";
				
				//echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$texto_condicao</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$rs[cod_cliente20]</td>";

				echo "<td align='center' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>$detalhe $rs[produto_cliente20]</td>";

			if($not == 2){

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'></td>";				

			}

			else{

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $preco_montador_re20</td>";								

				echo "<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'>R$ $total20</td>";				

			}

			echo "</tr>";

			}

			$ii++;

		}

			

					$total_geral = number_format($total_geral,2,',','');

	if($not == 2){

		  echo "<tr>

		  			<td align='right' colspan='6' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'><strong></strong></td>

		  			<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2' align='center'><strong></strong></td>

		  		</tr>

		  		<tr>

				  <td colspan='7' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>

														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>

				  </td>

				</tr>  

		</table> 

		<table border='0' width='100%'>

				  <tr>

				   <td colspan='7' align='center'>

						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>

				   </td>

				  </tr>";

	}

	else{

		  echo "<tr>

		  			<td align='right' colspan='6' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2'><strong>TOTAL BRUTO</strong></td>

		  			<td align='right' style='font-size:10px; font-family:Arial;' bgcolor='#F2F2F2' align='center'><strong>R$ $total_geral</strong></td>

		  		</tr>

		  		<tr>

				  <td colspan='7' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>

														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>

				  </td>

				</tr>  

		</table> 

		<table border='0' width='100%'>

				  <tr>

				   <td colspan='7' align='center'>

						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>

				   </td>

				  </tr>";

	}

		echo "</table>";

}else{

  echo "<script> alert('Por Favor! Selecione um montador e as datas para gerar o relat�rio');location.href='javascript:window.history.go(-1)'; </script>";

}

?>