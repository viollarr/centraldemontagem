<?php
include"config.php";

if (strlen($_GET["buscar"])>0){
	
	$buscar = $_GET["buscar"];
	$sql = mysql_query("SELECT * FROM bairros WHERE nome ='".$buscar."' ORDER BY nome ASC");
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
	} // Especifica uma valor para variavel pagina caso a mesma não esteja setada

	$sql = mysql_query("SELECT * FROM bairros WHERE nome LIKE '%".$buscar."%' ORDER BY nome ASC LIMIT $inicio, $lpp");
	$num = mysql_num_rows($sql);
	if ($num > 0){
		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";
		echo "<tr>";
		echo "<td class=titulo colspan=3>:: Administrar Bairros ::</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='texto' width='200'><b>C&oacute;d.</b></td>";
		echo "<td class='texto' width='305'><b>Nome Bairro</b></td>";
		echo "<td class='texto' width='45'><b>Excluir</b></td>";
		echo "</tr>";

		while ($linha = mysql_fetch_array($sql))
		{
			$id_bairros	  = $linha["id_bairros"];
			$nome_bairros = htmlentities($linha["nome"]);
			echo "<tr>";
			echo "<td class='texto'><a href='vis_bairros.php?id_bairros=$id_bairros'>$id_bairros</a></td>";
			echo "<td class='texto'><a href='vis_bairros.php?id_bairros=$id_bairros'>$nome_bairros</td>";
			echo "<td align='center'><a href='php/excluir_bairros.php?id_bairros=$id_bairros'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";
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

	$select_query = "SELECT * FROM bairros ORDER BY nome ASC";
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

	} // Especifica uma valor para variavel pagina caso a mesma não esteja setada

	

	$select_paginacao = "SELECT * FROM bairros ORDER BY nome ASC LIMIT $inicio, $lpp";

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

		echo "<tr>";

		echo "<td class=titulo colspan=3>:: Administrar Bairros ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='200'><b>C&oacute;d.</b></td>";

		echo "<td class='texto' width='305'><b>Nome Bairro</b></td>";

		echo "<td class='texto' width='45'><b>Excluir</b></td>";

		echo "</tr>";



		while ($linha = mysql_fetch_array($sql))

		{

			$id_bairros	  = $linha["id_bairros"];

			$nome_bairros = htmlentities($linha["nome"]);

			

			echo "<tr>";

			echo "<td class='texto'><a href='vis_bairros.php?id_bairros=$id_bairros'>$id_bairros</a></td>";

			echo "<td class='texto'><a href='vis_bairros.php?id_bairros=$id_bairros'>".$nome_bairros."</td>";

			echo "<td align='center'><a href='php/excluir_bairros.php?id_bairros=$id_bairros'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";

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