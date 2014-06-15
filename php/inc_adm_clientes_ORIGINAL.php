<?php

include"config.php";





if (strlen($_GET["buscar"])>0){



	$buscar = $_GET["buscar"];

	$tipo	= $_GET["tipo"];

	

	if($tipo == 'nome_cliente'){

		$condicao = "nome_cliente LIKE '%$buscar%'";

	}

	elseif($tipo == 'n_montagem'){

		$condicao = "n_montagem ='$buscar'";

	}

	elseif($tipo == 'orcamento'){

		$condicao = "orcamento ='$buscar'";

	}

	elseif($tipo == 'telefone1_cliente'){

		$condicao = "telefone1_cliente ='$buscar'";

	}

	

	$sql = mysql_query("SELECT * FROM clientes WHERE $condicao AND ativo = '0' ORDER BY prioridade DESC, nome_cliente ASC");

	

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

	

	$select_1 = "SELECT * FROM clientes WHERE $condicao AND ativo = '0' ORDER BY prioridade DESC, nome_cliente ASC LIMIT $inicio, $lpp";

	//echo $select_1;

	$sql = mysql_query($select_1);

	$num = mysql_num_rows($sql);

	if ($num > 0){

	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

	echo "<tr>";

	echo "<td class=titulo colspan=5>:: Administrar Clientes ::</td>";

	echo "</tr>";

	echo "<tr>";

	echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

	echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

	echo "<td class='texto' width='200'><b>Nome</b></td>";

	echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

	echo "<td class='texto' width='50'><b>Excluir</b></td>";

	echo "</tr>";



	while ($linha = mysql_fetch_array($sql))

	{

		$id_clientes  	= $linha["id_cliente"];

		$n_montagem		= $linha["n_montagem"];

		$orcamento	 	= $linha["orcamento"];

		$nome_cliente	= $linha["nome_cliente"];

		$prioridade		= $linha["prioridade"];

		

		if($prioridade == 1){$color = 'bgcolor="#C7DAFE"';}

		elseif($prioridade == 2){$color = 'bgcolor="#FFB3B3"';}

		else{$color = '';}

		

		$select_status	= "SELECT * FROM ordem_montagem WHERE n_montagem = '".$n_montagem."'";

		$query_status	= mysql_query($select_status);

		$linha_status	= mysql_fetch_array($query_status);

		$status			= $linha_status["status"];



		echo "<tr>";

		echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$n_montagem</a></td>";

		echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$orcamento</td>";

		echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$nome_cliente</a></td>";

		if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

		elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

		elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

		elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

		elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

		elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

		elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

		

		echo "<td align='center'><a href='php/excluir_clientes.php?id_clientes=$id_clientes'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";

		echo "</tr>";		

	}

	echo "</table>";

	if ($total > 20){

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

		if($pagina > 0) {

			$menos = $pagina - 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos";

			echo "<a class=\"destaque\" href=\"$url\">&laquo;</a>"; // Vai para a página anterior

		}

		for($i=0;$i<$paginas;$i++) { // Gera um loop com o destaque para as páginas

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$i";

			echo " | <a class=\"destaque\" href=\"$url\">$i</a>";

		}

		if($pagina < ($paginas - 1)) {

			$mais = $pagina + 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais";

			echo " | <a href=\"$url\">&raquo;</a>";

		}

	}

	}else{

	echo "Nenhum registro foi encontrado.";

	}

}else{



	$select_query = "SELECT c.id_cliente, c.n_montagem, c.orcamento, c.nome_cliente, c.prioridade, o.status FROM clientes c, ordem_montagem o WHERE c.n_montagem = o.n_montagem AND c.ativo = '0' ORDER BY c.prioridade DESC, o.status DESC, c.nome_cliente ASC ";

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

	

	$select_paginacao = "SELECT c.id_cliente, c.n_montagem, c.orcamento, c.nome_cliente, c.prioridade, o.status FROM clientes c, ordem_montagem o WHERE c.n_montagem = o.n_montagem AND c.ativo = '0' ORDER BY c.prioridade DESC, o.status DESC, c.nome_cliente ASC LIMIT $inicio, $lpp";

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1>";

		echo "<tr>";

		echo "<td class=titulo colspan=5>:: Administrar Clientes ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

		echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

		echo "<td class='texto' width='200'><b>Nome</b></td>";

		echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

		echo "<td class='texto' width='50'><b>Excluir</b></td>";

		echo "</tr>";



		while ($linha = mysql_fetch_array($sql))

		{

			$id_clientes  	= $linha["id_cliente"];

			$n_montagem		= $linha["n_montagem"];

			$orcamento	 	= $linha["orcamento"];

			$nome_cliente	= $linha["nome_cliente"];

			$prioridade		= $linha["prioridade"];

			

			if($prioridade == 1){$color = 'bgcolor="#C7DAFE"';}

			elseif($prioridade == 2){$color = 'bgcolor="#FFB3B3"';}

			else{$color = '';}

			

			$select_status	= "SELECT * FROM ordem_montagem WHERE n_montagem = '".$n_montagem."'";

			$query_status	= mysql_query($select_status);

			$linha_status	= mysql_fetch_array($query_status);

			$status			= $linha_status["status"];

			

			echo "<tr ".$color.">";

			echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$n_montagem</a></td>";

			echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$orcamento</td>";

			echo "<td class='texto'><a href='vis_clientes.php?id_clientes=$id_clientes'>$nome_cliente</a></td>";

			if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

			elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

			elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

			elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

			elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

			elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

			elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

			

			echo "<td align='center'><a href='php/excluir_clientes.php?id_clientes=$id_clientes'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";

			echo "</tr>";		

			}

			echo "</table>";

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

		if($pagina > 0) {

			$menos = $pagina - 1;

			if($menos > 0){

				$url = "$PHP_SELF?pagina=$menos";

				echo "<a class=\"destaque\" href=\"$url\">&laquo;</a>"; // Vai para a página anterior

			}

		}

		for($i=0;$i<$paginas;$i++) { // Gera um loop com o destaque para as páginas

			$url = "$PHP_SELF?pagina=$i";

			echo " | <a class=\"destaque\" href=\"$url\">$i</a>";

		}

		if($pagina < ($paginas - 1)) {

			$mais = $pagina + 1;

			$url = "$PHP_SELF?pagina=$mais";

			echo " | <a href=\"$url\">&raquo;</a>";

		}

}

?>