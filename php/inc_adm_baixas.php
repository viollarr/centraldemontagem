<?php

include"config.php";





if (strlen($_GET["buscar"])>0){

	if(strlen($_GET['montador'])>0){

	$buscar = $_GET["buscar"];

	$select = "SELECT o.id_montagem, o.n_montagem, c.orcamento, c.nome_cliente, o.status FROM ordem_montagem o, clientes c WHERE o.n_montagem ='".$buscar."' AND c.n_montagem ='".$buscar."' AND o.id_montador = '".$_GET['montador']."' AND c.ativo = '0' ORDER BY o.status ASC, o.n_montagem ASC";

	//echo $select;

	$sql = mysql_query($select);

	$total = mysql_num_rows($sql);

	

	$geti = $_GET['pagina'];

	if ($geti>0){

		$inicio = 20*$geti; // Especifique quantos resultados você quer por página

		$lpp= 20; // Retorna qual será a primeira linha a ser mostrada no MySQL

	}else{

		$inicio = 0;

		$lpp	= 20;

	}

	//$total = mysql_num_rows($sql); // Esta função irá retornar o total de linhas na tabela

	$paginas = ceil($total / 20); // Retorna o total de páginas

	if(!isset($pagina)) { 

		$pagina = 0; 

	} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada

	

	$sql = mysql_query("SELECT o.id_montagem, o.n_montagem, c.orcamento, c.nome_cliente, o.status FROM ordem_montagem o, clientes c WHERE o.n_montagem ='".$buscar."' AND c.n_montagem ='".$buscar."' AND o.id_montador = '".$_GET['montador']."' AND c.ativo = '0' ORDER BY o.status ASC, o.n_montagem ASC LIMIT $inicio, $lpp");

	$num = mysql_num_rows($sql);

	if ($num > 0){

	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

	echo "<tr>";

	echo "<td class=titulo colspan=4>:: Baixa de Notas ::</td>";

	echo "</tr>";

	echo "<tr>";

	echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

	echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

	echo "<td class='texto' width='250'><b>Nome</b></td>";

	echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

	echo "</tr>";



	while ($linha = mysql_fetch_array($sql))

	{

		$id_montagem  	= $linha["id_montagem"];

		$n_montagem		= $linha["n_montagem"];

		$orcamento	 	= $linha["orcamento"];

		$nome_cliente	= $linha["nome_cliente"];

		$prioridade		= $linha["prioridade"];

		

		if($prioridade == 1){$color = 'bgcolor="#C7DAFE"';}

		elseif($prioridade == 2){$color = 'bgcolor="#FFB3B3"';}

		elseif($prioridade == 3){$color = 'bgcolor="#C3C0BE"';}

		elseif($prioridade == 4){$color = 'bgcolor="#DBDC7C"';}

		else{$color = '';}

		

		$select_status	= "SELECT * FROM ordem_montagem WHERE n_montagem = '".$n_montagem."'";

		$query_status	= mysql_query($select_status);

		$linha_status	= mysql_fetch_array($query_status);

		$status			= $linha_status["status"];



		echo "<tr ".$color.">";

		echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$n_montagem</a></td>";

		echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$orcamento</td>";

		echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$nome_cliente</a></td>";

		if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

		elseif($status == 1)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

		elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

		elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

		elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

		elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

		elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

		elseif($status == 7)echo "<td align='center'><img src='images/verificar.png' border='0' /></td>";

		elseif($status == 8)echo "<td align='center'><img src='images/tecnica.png' border='0' /></td>";

		elseif($status == 9)echo "<td align='center'>Desmontagem LJ</td>";

		elseif($status == 10)echo "<td align='center'><img src='images/justiceNo.png' border='0' /></td>";

		elseif($status == 11)echo "<td align='center'><img src='images/verificarNo.png' border='0' /></td>";

		elseif($status == 12)echo "<td align='center'><img src='images/tecnicaNo.png' border='0' width='24' /></td>";

		elseif($status == 13)echo "<td align='center'>Desmontagem NM</td>";

		echo "</tr>";		

	}

	echo "</table>";

	if ($total > 20){

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

		if($pagina > 0) {

			$menos = $pagina - 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos&vlm=$vlm&montador=$montador";

			echo "<a class=\"destaque\" href=\"$url\">&laquo;</a>"; // Vai para a página anterior

		}

		for($i=0;$i<$paginas;$i++) { // Gera um loop com o destaque para as páginas

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$i&vlm=$vlm&montador=$montador";

			echo " | <a class=\"destaque\" href=\"$url\">$i</a>";

		}

		if($pagina < ($paginas - 1)) {

			$mais = $pagina + 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais&vlm=$vlm&montador=$montador";

			echo " | <a href=\"$url\">&raquo;</a>";

		}

	}

	}else{

	echo "Nenhum registro foi encontrado para este montador.";

	}

 }

}else{



	if(strlen($vlm)>0){

		$condicao = "AND o.n_montagem = '".$vlm."'";

	}

	else{

		$condicao = "AND o.id_montador = '".$montador."'";

	}



	$select_query = "SELECT o.id_montagem, o.n_montagem, c.orcamento, c.nome_cliente, o.status FROM ordem_montagem o, clientes c WHERE o.n_montagem = c.n_montagem $condicao AND c.ativo = '0' ORDER BY o.status ASC, o.n_montagem ASC ";

	$sql = mysql_query($select_query);

	$geti = $_GET['pagina'];

	if ($geti>0){

		$inicio = 20*$geti; // Especifique quantos resultados você quer por página

		$lpp= 20; // Retorna qual será a primeira linha a ser mostrada no MySQL

	}else{

		$inicio = 0;

		$lpp	= 20;

	}

	$total = mysql_num_rows($sql); // Esta função irá retornar o total de linhas na tabela

	$paginas = ceil($total / 20); // Retorna o total de páginas

	if(!isset($pagina)) { 

		$pagina = 0; 

	} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada

	

	$select_paginacao = "SELECT o.id_montagem, o.n_montagem, c.orcamento, c.nome_cliente, o.status FROM ordem_montagem o, clientes c WHERE o.n_montagem = c.n_montagem $condicao AND c.ativo = '0' ORDER BY o.status ASC, o.n_montagem ASC LIMIT $inicio, $lpp";

	//echo $select_paginacao;

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1>";

		echo "<tr>";

		echo "<td class=titulo colspan=4>:: Baixa de Notas ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

		echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

		echo "<td class='texto' width='250'><b>Nome</b></td>";

		echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

		echo "</tr>";



		while ($linha = mysql_fetch_array($sql))

		{

			$id_montagem  	= $linha["id_montagem"];

			$n_montagem		= $linha["n_montagem"];

			$orcamento	 	= $linha["orcamento"];

			$nome_cliente	= $linha["nome_cliente"];

			$prioridade		= $linha["prioridade"];

			

			if($prioridade == 1){$color = 'bgcolor="#C7DAFE"';}

			elseif($prioridade == 2){$color = 'bgcolor="#FFB3B3"';}

			elseif($prioridade == 3){$color = 'bgcolor="#C3C0BE"';}

			elseif($prioridade == 4){$color = 'bgcolor="#DBDC7C"';}

			else{$color = '';}

			

			$select_status	= "SELECT * FROM ordem_montagem WHERE n_montagem = '".$n_montagem."'";

			$query_status	= mysql_query($select_status);

			$linha_status	= mysql_fetch_array($query_status);

			$status			= $linha_status["status"];

			

			echo "<tr ".$color.">";

			echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$n_montagem</a></td>";

			echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$orcamento</td>";

			echo "<td class='texto'><a href='vis_baixas.php?id_montagem=$id_montagem'>$nome_cliente</a></td>";

			if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

			elseif($status == 1)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

			elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

			elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

			elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

			elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

			elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

			elseif($status == 7)echo "<td align='center'><img src='images/verificar.png' border='0' /></td>";

			elseif($status == 8)echo "<td align='center'><img src='images/tecnica.png' border='0' /></td>";

			elseif($status == 9)echo "<td align='center'>&nbsp;</td>";

			elseif($status == 10)echo "<td align='center'><img src='images/justiceNo.png' border='0' /></td>";

			elseif($status == 11)echo "<td align='center'><img src='images/verificarNo.png' border='0' /></td>";

			elseif($status == 12)echo "<td align='center'><img src='images/tecnicaNo.png' border='0' width='24' /></td>";

			elseif($status == 13)echo "<td align='center'>&nbsp;</td>";

			echo "</tr>";		

			}

			echo "</table>";

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

		if($pagina > 0) {

			$menos = $pagina - 1;

			if($menos > 0){

				$url = "$PHP_SELF?pagina=$menos&vlm=$vlm&montador=$montador";

				echo "<a class=\"destaque\" href=\"$url\">&laquo;</a>"; // Vai para a página anterior

			}

		}

		for($i=0;$i<$paginas;$i++) { // Gera um loop com o destaque para as páginas

			$url = "$PHP_SELF?pagina=$i&vlm=$vlm&montador=$montador";

			echo " | <a class=\"destaque\" href=\"$url\">$i</a>";

		}

		if($pagina < ($paginas - 1)) {

			$mais = $pagina + 1;

			$url = "$PHP_SELF?pagina=$mais&vlm=$vlm&montador=$montador";

			echo " | <a href=\"$url\">&raquo;</a>";

		}

}

?>