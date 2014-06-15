<?php

include"config.php";



if($_SESSION['login'] == 'narcizo'){

	$colspan = 'colspan=5';

}else{

	$colspan = 'colspan=4';

}



if (strlen($_GET["buscar"])>0){



	$buscar = $_GET["buscar"];

	$tipo	= $_GET["tipo"];

	

	if($tipo == 'nome_cliente'){

		$condicao = "nome_cliente LIKE '$buscar%'";

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

	

	$selectBuscar = "SELECT * FROM clientes_assistencia WHERE $condicao AND ativo = '0' ORDER BY prioridade DESC, nome_cliente ASC";

	//echo $selectBuscar."<br>";

	$sql = mysql_query($selectBuscar);

	

	$total = mysql_num_rows($sql);

	

		$geti = $_GET['pagina'];

		if ($geti>0){

			$inicio = 20*$geti; // Especifique quantos resultados você quer por página

			$lpp= 20; // Retorna qual será a primeira linha a ser mostrada no MySQL

		}else{

			$inicio = 0;

			$lpp	= 20;

		}

		$paginas = ceil($total / 20); // Retorna o total de páginas

		if(!isset($pagina)) { 

			$pagina = $_GET['pagina']; 

		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada

	

	$select_1 = "SELECT * FROM clientes_assistencia WHERE $condicao AND ativo = '0' ORDER BY prioridade DESC, nome_cliente ASC LIMIT $inicio, $lpp";

	//echo $select_1;

	$sql = mysql_query($select_1);

	$num = mysql_num_rows($sql);

	if ($num > 0){

	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

	echo "<tr>";

	echo "<td class=titulo $colspan>:: Administrar Clientes ::</td>";

	echo "</tr>";

	echo "<tr>";

	echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

	echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

	echo "<td class='texto2' width='200'><b>Nome</b></td>";

	echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

	if($_SESSION['login'] == 'narcizo'){

		echo "<td class='texto' width='50'><b>Excluir</b></td>";

	}

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

		

		$select_status	= "SELECT * FROM ordem_montagem_assistencia WHERE n_montagem = '".$n_montagem."'";

		$query_status	= mysql_query($select_status);

		$linha_status	= mysql_fetch_array($query_status);

		$status			= $linha_status["status"];



		echo "<tr>";

		echo "<td class='texto'><a href='#'>$n_montagem</a></td>";

		echo "<td class='texto'><a href='#'>$orcamento</td>";

		echo "<td class='texto'><a href='#'>$nome_cliente</a></td>";

		if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

		elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

		elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

		elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

		elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

		elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

		elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

		

		if($_SESSION['login'] == 'narcizo'){

			echo "<td align='center'><a href='#'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";

		}

		echo "</tr>";		

	}

	echo "</table>";

	if ($total > 20){

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

			$menos = 0;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos&tipo=$tipo";

			echo "<a href=\"$url\"><strong>&laquo;</strong></a> "; 

		if($pagina > 0) {

			$menos = ($pagina - 1);

			if($menos >= 0){

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos&tipo=$tipo";

				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a página anterior

			}

		}

		$menos2 = $pagina;

		if($pagina > 0) {

			$menos2 = ($menos2 - 1);

			if($menos2 >= 0){

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos&tipo=$tipo";

				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a página anterior

			}

		}

			if(!isset($pagina)){

				echo " <a class=\"destaque\" href='$PHP_SELF?buscar=".$buscar."&pagina=0&tipo=$tipo'>0</a> ";

			}

			else{

				echo " <a class=\"destaque\" href='$PHP_SELF?buscar=".$buscar."&pagina=$pagina&tipo=$tipo'><strong style='font-size:16px;'><u>".$pagina."</u></strong></a> ";

			}

			$mais = $pagina;

		if($pagina < ($paginas - 1)) {

			for($x=0;$x<(($paginas/4)-1);$x++){

				$mais = $mais + 1;

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais&tipo=$tipo";

				if($mais<=($paginas-1)){

					echo "  <a href=\"$url\">".$mais."</a>";

				}

				else{ echo'';}				

			}

		}



		if($pagina < ($paginas - 1)) {

			$mais = $_GET['pagina'] + 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais&tipo=$tipo";

			if($mais<=$paginas){

				echo " | <a href=\"$url\"><strong>&rsaquo;</strong></a>";

			}

			else {echo'';}

		}

			$mais = ($paginas - 1);

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais&tipo=$tipo";

			if($mais<=$paginas){

				echo "| <a href=\"$url\"><strong>&raquo;</strong></a>"; 

			}

			else{ echo'';}

	}

	}else{

	echo "Nenhum registro foi encontrado.";

	}

}else{



	$select_query = "SELECT c.id_cliente, c.n_montagem, c.orcamento, c.nome_cliente, c.prioridade FROM clientes_assistencia c WHERE c.ativo = '0' ORDER BY c.prioridade DESC, c.nome_cliente ASC ";

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

			$pagina = $_GET['pagina']; 

		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada

	

	$select_paginacao = "SELECT c.id_cliente, c.n_montagem, c.orcamento, c.nome_cliente, c.prioridade FROM clientes_assistencia c WHERE c.ativo = '0' ORDER BY c.prioridade DESC, c.nome_cliente ASC LIMIT $inicio, $lpp";

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1>";

		echo "<tr>";

		echo "<td class=titulo $colspan>:: Administrar Clientes ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='100'><b>N&deg; Montagem</b></td>";

		echo "<td class='texto' width='100'><b>Or&ccedil;amento</b></td>";

		echo "<td class='texto2' width='200'><b>Nome</b></td>";

		echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

		if($_SESSION['login'] == 'narcizo'){

			echo "<td class='texto' width='50'><b>Excluir</b></td>";

		}

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

			

			$select_status	= "SELECT * FROM ordem_montagem_assistencia WHERE n_montagem = '".$n_montagem."'";

			$query_status	= mysql_query($select_status);

			$linha_status	= mysql_fetch_array($query_status);

			$status			= $linha_status["status"];

			

			echo "<tr ".$color.">";

			echo "<td class='texto'><a href='#'>$n_montagem</a></td>";

			echo "<td class='texto'><a href='#'>$orcamento</td>";

			echo "<td class='texto'><a href='#'>$nome_cliente</a></td>";

			if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

			elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

			elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

			elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

			elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

			elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

			elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";



			if($_SESSION['login'] == 'narcizo'){

				echo "<td align='center'><a href='#'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";

			}

			echo "</tr>";		

			}

			echo "</table>";

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

			$menos = 0;

			$url = "$PHP_SELF?pagina=$menos";

			echo "<a href=\"$url\"><strong>&laquo;</strong></a> "; 

		if($pagina > 0) {

			$menos = ($pagina - 1);

			if($menos >= 0){

				$url = "$PHP_SELF?pagina=$menos";

				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a página anterior

			}

		}

		$menos2 = $pagina;

		if($pagina > 0) {

			$menos2 = ($menos2 - 1);

			if($menos2 >= 0){

				$url = "$PHP_SELF?pagina=$menos";

				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a página anterior

			}

		}

			if(!isset($pagina)){

				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=0'>0</a> ";

			}

			else{

				echo " <a class=\"destaque\" href='$PHP_SELF?pagina=$pagina'><strong style='font-size:16px;'><u>".$pagina."</u></strong></a> ";

			}

			$mais = $pagina;

		if($pagina < ($paginas - 1)) {

			for($x=0;$x<(($paginas/4)-1);$x++){

				$mais = $mais + 1;

				$url = "$PHP_SELF?pagina=$mais";

				if($mais<=($paginas-1)){

					echo "  <a href=\"$url\">".$mais."</a>";

				}

				else{ echo'';}				

			}

		}



		if($pagina < ($paginas - 1)) {

			$mais = $_GET['pagina'] + 1;

			$url = "$PHP_SELF?pagina=$mais";

			if($mais<=$paginas){

				echo " | <a href=\"$url\"><strong>&rsaquo;</strong></a>";

			}

			else {echo'';}

		}

			$mais = ($paginas - 1);

			$url = "$PHP_SELF?pagina=$mais";

			if($mais<=$paginas){

				echo "| <a href=\"$url\"><strong>&raquo;</strong></a>"; 

			}

			else{ echo'';}

}

?>