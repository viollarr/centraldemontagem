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
	$tipo = $_POST['tipo'];

}

$ativo = 0;

if($tipo == 3){
$condicao = "o.status = '1' OR";
}
elseif($tipo == 4){
$condicao = "o.status = '6' OR";
}

			$data_inicio_t = new DateTime($data_inicio);  
			$data_inicio_t = $data_inicio_t->format('d/m/Y');

			$data_final_t = new DateTime($data_fim);  
			$data_final_t = $data_final_t->format('d/m/Y');


//echo $data_inicio;
//echo "<br>";
//echo $data_fim;
//exit();

if ((strlen($tipo)>0)&&(!empty($data_inicio))&&(!empty($data_fim))){


		$SQL = "SELECT o.n_montagem, d.data_final, c.orcamento, c.cod_cliente, c.qtde_cliente, c.produto_cliente, c.cod_cliente2, c.qtde_cliente2, c.produto_cliente2, c.cod_cliente3, c.qtde_cliente3, c.produto_cliente3, c.cod_cliente4, c.qtde_cliente4, c.produto_cliente4, c.cod_cliente5, c.qtde_cliente5, c.produto_cliente5, c.cod_cliente6, c.qtde_cliente6, c.produto_cliente6, p.preco_real, p.preco_montador, p.preco_empresa FROM clientes c, datas d, ordem_montagem o, produtos pd, precos p WHERE (d.data_entrega_montador >= '$data_inicio' AND d.data_entrega_montador <= '$data_fim') AND c.ativo='$ativo' AND c.cod_cliente = pd.cod_produto AND p.id_preco = pd.id_preco AND c.n_montagem = o.n_montagem AND d.n_montagens = o.n_montagem AND ($condicao o.status = '$tipo') AND c.prioridade='0' AND c.tipo='0' ORDER BY o.n_montagem ASC";
		//echo $SQL."<br>";
		//exit();
		$executa = mysql_query($SQL)or die(mysql_error());

		// montando a tabela
		if($pagina == ""){
		echo "<table border='0' width='100%' align='center'>
				  <tr>
				   <td colspan='3' align='center'>
						<a href=javascript:history.go(-1) style='color:#000'>Voltar</a>
				   </td>
				  </tr>";
		}
		echo "</table>";
		echo "<table border='0' width='900' cellspacing='1' bgcolor='#000000' align='center'>
				<tr>
				  <td bgcolor='#F2F2F2' colspan='3' align='left'>Data: <b>$data</b></td>
				</tr>
				<tr>
				  <td bgcolor='#F2F2F2' colspan='3' align='center'><b>Vencimentos $data_inicio_t até $data_final_t</b></td>
				</tr>
				<tr>
				  <td align='center' bgcolor='#F2F2F2'><b>RICARDO ELETRO</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>MONTADORES</b></td>
				  <td align='center' bgcolor='#F2F2F2'><b>PRESTY-RIO</b></td>
			   </tr>";
		$i=1;
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
		$total_geral_re =0;
		$total_geral_mo =0;
		$total_geral_em =0;
		while ($rs = mysql_fetch_array($executa)){
		            		
			$data_final = new DateTime($rs[data_final]);  
			$data_final = $data_final->format('d/m/Y');
			
			$total = ($rs['preco_real']*$rs['qtde_cliente']);
			$total7 = ($rs['preco_montador']*$rs['qtde_cliente']);
			$total13 = ($rs['preco_empresa']*$rs['qtde_cliente']);
			
			
			$select_preco2 = "SELECT p.preco_real, p.preco_montador, p.preco_empresa FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente2]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco2."<br>";
			$query_preco2 = mysql_query($select_preco2);
			$p = mysql_fetch_array($query_preco2);
			
			$total2 = ($p['preco_real']*$rs['qtde_cliente2']);
			$total8 = ($p['preco_montador']*$rs['qtde_cliente2']);
			$total14 = ($p['preco_empresa']*$rs['qtde_cliente2']);

			$select_preco3 = "SELECT p.preco_real, p.preco_montador, p.preco_empresa FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente3]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco3."<br>";
			$query_preco3 = mysql_query($select_preco3);
			$q = mysql_fetch_array($query_preco3);
			
			$total3 = ($q['preco_real']*$rs['qtde_cliente3']);
			$total9 = ($q['preco_montador']*$rs['qtde_cliente3']);
			$total15 = ($q['preco_empresa']*$rs['qtde_cliente3']);
			
			$select_preco4 = "SELECT p.preco_real, p.preco_montador, p.preco_empresa FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente4]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco4."<br>";
			$query_preco4 = mysql_query($select_preco4);
			$r = mysql_fetch_array($query_preco4);
			
			$total4 = ($r['preco_real']*$rs['qtde_cliente4']);
			$total10 = ($r['preco_montador']*$rs['qtde_cliente4']);
			$total16 = ($r['preco_empresa']*$rs['qtde_cliente4']);
			
			$select_preco5 = "SELECT p.preco_real, p.preco_montador, p.preco_empresa FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente5]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco5."<br>";
			$query_preco5 = mysql_query($select_preco5);
			$s = mysql_fetch_array($query_preco5);
			
			$total5 = ($s['preco_real']*$rs['qtde_cliente5']);
			$total11 = ($s['preco_montador']*$rs['qtde_cliente5']);
			$total17 = ($s['preco_empresa']*$rs['qtde_cliente5']);
			
			$select_preco6 = "SELECT p.preco_real, p.preco_montador, p.preco_empresa FROM precos p, produtos pd WHERE pd.cod_produto = '$rs[cod_cliente6]' AND p.id_preco = pd.id_preco ";
			//echo $select_preco5."<br>";
			$query_preco6 = mysql_query($select_preco6);
			$t = mysql_fetch_array($query_preco6);
			
			$total6 = ($t['preco_real']*$rs['qtde_cliente6']);
			$total12 = ($t['preco_montador']*$rs['qtde_cliente6']);
			$total18 = ($t['preco_empresa']*$rs['qtde_cliente6']);
			
			$total_geral_re += $total+$total2+$total3+$total4+$total5+$total6;
			$total_geral_mo += $total7+$total8+$total9+$total10+$total11+$total12;
			$total_geral_em += $total13+$total14+$total15+$total16+$total17+$total18;

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
			
			/*
			$preco_real = number_format($rs['preco_real'],2,',','');
			$preco_real2 = number_format($p['preco_real'],2,',','');
			$preco_real3 = number_format($q['preco_real'],2,',','');
			$preco_real4 = number_format($r['preco_real'],2,',','');
			$preco_real5 = number_format($s['preco_real'],2,',','');
			$preco_real6 = number_format($t['preco_real'],2,',','');
			*/
			
		}
			$total_geral_re = number_format($total_geral_re,2,',','');
			$total_geral_mo = number_format($total_geral_mo,2,',','');
			$total_geral_em = number_format($total_geral_em,2,',','');
			
		  echo "<tr>
					<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total_geral_re</td>
					<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total_geral_mo</td>
					<td align='right' style='font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;' bgcolor='#F2F2F2'>R$ $total_geral_em</td>
		  		</tr>
		  		<tr>
				  <td colspan='3' bgcolor='#F2F2F2' style='font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;' align='center'><br><b> RUA PEDRO RUFINO, 1041 CORDOVIL - RIO DE JANEIRO - RJ CEP:21250-230 BRASIL<br>
														TELS.: 3381-6179 - FAX.: 3351-1944</b><br>
				  </td>
				</tr>  
		</table>";
		
}else{
  echo "<script> alert('Por Favor! Selecione um tipo e um intervalo entre as datas corretamente!');location.href='javascript:window.history.go(-1)'; </script>";
}
?>