<?php

include"config.php";



if (strlen($_GET["buscar"])>0){



	$buscar = $_GET["buscar"];

	$sql = mysql_query("SELECT * FROM ordem_montagem o, clientes c WHERE o.n_montagem ='".$buscar."' AND c.n_montagem = o.n_montagem AND c.ativo = '0' ORDER BY o.status ASC");

	

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

	

	$sql = mysql_query("SELECT * FROM ordem_montagem o, clientes c WHERE o.n_montagem = '".$buscar."' AND c.n_montagem = o.n_montagem AND c.ativo = '0' ORDER BY o.status ASC LIMIT $inicio, $lpp");

	$num = mysql_num_rows($sql);

	if ($num > 0){

	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

	echo "<tr>";

	echo "<td class=titulo colspan=4>:: Alterar Montador das Notas ::</td>";

	echo "</tr>";

	echo "<tr>";

	echo "<td class='texto' width='50'><b>N&deg; Montagem</b></td>";

	echo "<td class='texto' width='200'><b>Montador</b></td>";

	echo "<td class='texto' width='200'><b>Cliente</b></td>";

	echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

	echo "</tr>";



	while ($linha = mysql_fetch_array($sql))

	{

		$id_notas		= $linha["id_montagem"];

		$id_clientes  	= $linha["id_cliente"];

		$n_montagem		= $linha["n_montagem"];

		$montador	 	= $linha["id_montador"];

		$status			= $linha["status"];



		$select_status	= "SELECT * FROM clientes WHERE id_cliente = '".$id_clientes."'";

		$query_status	= mysql_query($select_status);

		$linha_status	= mysql_fetch_array($query_status);

		$nome_cliente	= $linha_status["nome_cliente"];



		$select_montador	= "SELECT * FROM montadores WHERE id_montadores = '".$montador."'";

		$query_montador	= mysql_query($select_montador);

		$linha_montador	= mysql_fetch_array($query_montador);

		$nome_montador	= $linha_montador["nome"];



		echo "<tr>";

		echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$n_montagem</a></td>";

		echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$nome_montador</td>";

		echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$nome_cliente</a></td>";

		if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

		elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

		elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

		elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

		elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

		elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

		elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

		

		echo "</tr>";		

	}

	echo "</table>";

	if ($total > 20){

		echo "<span class='texto'>Mais registros</span>";

		echo "<br />";

			$menos = 0;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos";

			echo "<a href=\"$url\"><strong>&laquo;</strong></a> "; 

		if($pagina > 0) {

			$menos = ($pagina - 1);

			if($menos >= 0){

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos";

				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a página anterior

			}

		}

		$menos2 = $pagina;

		if($pagina > 0) {

			$menos2 = ($menos2 - 1);

			if($menos2 >= 0){

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$menos";

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

				$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais";

				if($mais<=($paginas-1)){

					echo "  <a href=\"$url\">".$mais."</a>";

				}

				else{ echo'';}				

			}

		}



		if($pagina < ($paginas - 1)) {

			$mais = $_GET['pagina'] + 1;

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais";

			if($mais<=$paginas){

				echo " | <a href=\"$url\"><strong>&rsaquo;</strong></a>";

			}

			else {echo'';}

		}

			$mais = ($paginas - 1);

			$url = "$PHP_SELF?buscar=".$buscar."&pagina=$mais";

			if($mais<=$paginas){

				echo "| <a href=\"$url\"><strong>&raquo;</strong></a>"; 

			}

			else{ echo'';}

	}

	}else{

	echo "Nenhum registro foi encontrado.";

	}

}else{



	$select_query = "SELECT * FROM ordem_montagem o, clientes c WHERE c.n_montagem = o.n_montagem AND c.ativo = '0' ORDER BY o.status ASC";

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

	

	$select_paginacao = "SELECT * FROM ordem_montagem o, clientes c WHERE c.ativo = '0' AND c.n_montagem = o.n_montagem ORDER BY o.status ASC LIMIT $inicio, $lpp";

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

		echo "<tr>";

		echo "<td class=titulo colspan=4>:: Alterar Montador das Notas ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='50'><b>N&deg; Montagem</b></td>";

		echo "<td class='texto' width='200'><b>Montador</b></td>";

		echo "<td class='texto' width='200'><b>Cliente</b></td>";

		echo "<td class='texto2' align='center' width='100'><b>Status</b></td>";

		echo "</tr>";



		while ($linha = mysql_fetch_array($sql))

		{

			$id_notas		= $linha["id_montagem"];

			$id_clientes  	= $linha["id_cliente"];

			$n_montagem		= $linha["n_montagem"];

			$montador	 	= $linha["id_montador"];

			$status			= $linha["status"];

	

			$select_status	= "SELECT * FROM clientes WHERE id_cliente = '".$id_clientes."'";

			$query_status	= mysql_query($select_status);

			$linha_status	= mysql_fetch_array($query_status);

			$nome_cliente	= $linha_status["nome_cliente"];

	

			$select_montador	= "SELECT * FROM montadores WHERE id_montadores = '".$montador."'";

			$query_montador	= mysql_query($select_montador);

			$linha_montador	= mysql_fetch_array($query_montador);

			$nome_montador	= $linha_montador["nome"];

			

			echo "<tr>";

			echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$n_montagem</a></td>";

			echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$nome_montador</td>";

			echo "<td class='texto'><a href='vis_notas.php?id_notas=$id_notas'>$nome_cliente</a></td>";

			if($status == 0)echo "<td align='center'><img src='images/revisar.gif' border='0' /></td>";

			elseif($status == 1)echo "<td align='center'><img src='images/tools.png' border='0' /></td>";

			elseif($status == 2)echo "<td align='center'><img src='images/ampulheta.gif' border='0' /></td>";

			elseif($status == 3)echo "<td align='center'><img src='images/tick.png' border='0' /></td>";

			elseif($status == 4)echo "<td align='center'><img src='images/ico_excluir.jpg' border='0' /></td>";

			elseif($status == 5)echo "<td align='center'><img src='images/justice.png' border='0' /></td>";

			elseif($status == 6)echo "<td align='center'><img src='images/ausente.png' border='0' width='24' /></td>";

		

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