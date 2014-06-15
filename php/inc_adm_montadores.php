<?php

include"config.php";

if(($_SESSION['login'] == 'narcizo')||($_SESSION['login'] == 'andreia')||($_SESSION['login'] == 'ANDREIA')){
     $colspan = 6;
}
else{
     $colspan = 5;
}


if (strlen($_GET["buscar"])>0){



	$buscar = $_GET["buscar"];

	$sql = mysql_query("SELECT * FROM montadores WHERE nome ='".$buscar."' ORDER BY nome ASC");

	

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

	

	$sql = mysql_query("SELECT * FROM montadores WHERE nome LIKE '%".$buscar."%' ORDER BY nome ASC LIMIT $inicio, $lpp");

	$num = mysql_num_rows($sql);

	if ($num > 0){

	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

	echo "<tr>";

	echo "<td class=titulo colspan=$colspan>:: Administrar Montadores ::</td>";

	echo "</tr>";

	echo "<tr>";

	echo "<td class='texto' width='100'><b>Nome:</b></td>";

	//echo "<td class='texto' width='100'><b>RG</b></td>";

	echo "<td class='texto' width='100'><b>Telefone</b></td>";

	echo "<td class='texto' width='100'><b>Celular</b></td>";

	echo "<td class='texto' width='95'><b>Rota</b></td>";
   if(($_SESSION['login'] == 'narcizo')||($_SESSION['login'] == 'andreia')||($_SESSION['login'] == 'ANDREIA') || ($_SESSION['login'] == 'MIRIAN') || ($_SESSION['login'] == 'mirian')){
	echo "<td class='texto' width='45' align='center'><b>Status</b></td>";
   }


	echo "</tr>";



	while ($linha = mysql_fetch_array($sql))

	{
		$id_montadores	= $linha["id_montadores"];
		$nome			= $linha["nome"];
		//$rg				= $linha["rg"];
		$telefone		= $linha["telefone"];
		$celular		= $linha["celular"];
		$rota			= $linha["rota"];		
		$ativo			= $linha["ativo_m"];
		
		if($ativo == 1){
			$link_abre = "<a href='vis_montadores.php?id_montadores=$id_montadores'>";
			$link_fecha = "</a>";
		}
		else{
			$link_abre = "<span style='color: #999999'>";
			$link_fecha = "</span>";
		}



		echo "<tr>";

		echo "<td class='texto'>$link_abre $nome $link_fecha</td>";

		//echo "<td class='texto'>$link_abre $rg $link_fecha</td>";

		echo "<td class='texto'>$link_abre $telefone $link_fecha</td>";

		echo "<td class='texto'>$link_abre $celular $link_fecha</td>";

		echo "<td align='center'>$link_abre $rota $link_fecha</td>";
	if(($_SESSION['login'] == 'narcizo')||($_SESSION['login'] == 'andreia')||($_SESSION['login'] == 'ANDREIA') || ($_SESSION['login'] == 'MIRIAN') || ($_SESSION['login'] == 'mirian')){
		if($ativo == 1){
			echo "<td align='center'><a href='php/desativa_montador.php?id_montadores=$id_montadores&status=0'>DESATIVAR</a></td>";
		}
		else{
			echo "<td align='center'><a href='php/desativa_montador.php?id_montadores=$id_montadores&status=1' style='color: #FF0000;'>ATIVAR</a></td>";
		}
       }

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



	$select_query = "SELECT * FROM montadores ORDER BY nome ASC";

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

	

	$select_paginacao = "SELECT * FROM montadores ORDER BY nome ASC LIMIT $inicio, $lpp";

	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.



		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";

		echo "<tr>";

		echo "<td class=titulo colspan=$colspan>:: Administrar Montadores ::</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td class='texto' width='150'><b>Nome:</b></td>";

		//echo "<td class='texto' width='100'><b>RG</b></td>";

		echo "<td class='texto' width='100'><b>Telefone</b></td>";

		echo "<td class='texto' width='100'><b>Celular</b></td>";

		echo "<td class='texto' width='95'><b>Rota</b></td>";
	if(($_SESSION['login'] == 'narcizo')||($_SESSION['login'] == 'andreia')||($_SESSION['login'] == 'ANDREIA') || ($_SESSION['login'] == 'MIRIAN') || ($_SESSION['login'] == 'mirian')){
		echo "<td class='texto' width='45' align='center'><b>Status</b></td>";
        }

		echo "</tr>";



		while ($linha = mysql_fetch_array($sql))

		{
			$id_montadores		= $linha["id_montadores"];
			$nome				= $linha["nome"];
			//$rg					= $linha["rg"];
			$telefone			= $linha["telefone"];
			$celular			= $linha["celular"];
			$rota				= $linha["rota"];
			$ativo				= $linha["ativo_m"];
			
			if($ativo == 1){
				$link_abre = "<a href='vis_montadores.php?id_montadores=$id_montadores'>";
				$link_fecha = "</a>";
			}
			else{
				$link_abre = "<span style='color: #999999'>";
				$link_fecha = "</span>";
			}

			

			echo "<tr>";

			echo "<td class='texto'>$link_abre $nome $link_fecha</td>";

			//echo "<td class='texto'>$link_abre $rg $link_fecha</td>";

			echo "<td class='texto'>$link_abre $telefone $link_fecha</td>";

			echo "<td class='texto'>$link_abre $celular $link_fecha</td>";

			echo "<td align='center'>$link_abre $rota $link_fecha</td>";
		if(($_SESSION['login'] == 'narcizo')||($_SESSION['login'] == 'andreia')||($_SESSION['login'] == 'ANDREIA') || ($_SESSION['login'] == 'MIRIAN') || ($_SESSION['login'] == 'mirian')){
			if($ativo == 1){
				echo "<td align='center'><a href='php/desativa_montador.php?id_montadores=$id_montadores&status=0'>DESATIVAR</a></td>";
			}
			else{
				echo "<td align='center'><a href='php/desativa_montador.php?id_montadores=$id_montadores&status=1' style='color: #FF0000;'>ATIVAR</a></td>";
			}
                }
	
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