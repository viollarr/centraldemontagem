<?php
include"config.php";

if(($_SESSION['tipo'] == 1)||($_SESSION['tipo'] == '3')){
$colspan = "colspan=4";
$tipo_administrador = "<td class='texto' width='50'><b>Valor(R$)</b></td>";
}
else{
$colspan = "colspan=3";
$tipo_administrador = "";
}

if (strlen($_GET["buscar"])>0){
	
	$buscar = trim($_GET["buscar"]);
	$tipo 	= trim($_GET["tipo"]);
	
	if($tipo == 'modelo'){

		$condicao = "modelo LIKE '$buscar%'";

	}

	elseif($tipo == 'cod_produto'){

		$condicao = "cod_produto ='$buscar'";

	}
	
	$select_prod = "SELECT * FROM produtos WHERE $condicao ORDER BY id_preco, cod_produto ASC";
	$sql = mysql_query($select_prod);
	$total = mysql_num_rows($sql);
	
		$geti = $_GET['pagina'];
		if ($geti>0){
			$inicio = 20*$geti; // Especifique quantos resultados voc� quer por p�gina
			$lpp= 20; // Retorna qual ser� a primeira linha a ser mostrada no MySQL
		}else{
			$inicio = 0;
			$lpp	= 20;
		}
		$paginas = ceil($total / 20); // Retorna o total de p�ginas
		if(!isset($pagina)) { 
			$pagina = $_GET['pagina']; 
		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada
	
	$sql = mysql_query("SELECT * FROM produtos WHERE $condicao ORDER BY id_preco, cod_produto ASC LIMIT $inicio, $lpp");
	$num = mysql_num_rows($sql);
	if ($num > 0){
	echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";
	echo "<tr>";
	echo "<td class=titulo $colspan >:: Administrar Produtos ::</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='texto' width='100'><b>C&oacute;d</b></td>";
	echo "<td class='texto' width='350'><b>Nome</b></td>";
	echo $tipo_administrador;
	echo "<td class='texto' width='50'><b>Excluir</b></td>";
	echo "</tr>";

	while ($linha = mysql_fetch_array($sql))
	{
		$select_preco 	= "SELECT * FROM precos WHERE id_preco = '".$linha['id_preco']."'";
		$query_preco	= mysql_query($select_preco);
		$b				= mysql_fetch_array($query_preco);
		$id_produtos	= $linha["id_produto"];
		$cod_produto	= $linha["cod_produto"];
		$nome		 	= $linha["modelo"];
		if(preg_match('/[a-zA-Z]/',$cod_produto)){
			$valor			= $b["preco_real_cp"];
		}
		else{
			$valor			= $b["preco_real"];	
		}
		$valor_produto  = str_replace(".",",",$valor);
		if(($_SESSION['tipo'] == 1)||($_SESSION['tipo'] == 3)){
	$tipo_administrador_valor = "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$valor_produto</a></td>";
	
	}
	else{
	$tipo_administrador_valor = "";
	}
	
		echo "<tr>";
		echo "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$cod_produto</a></td>";
		echo "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$nome</td>";
		echo $tipo_administrador_valor;
	
	echo "<td align='center'><a href='php/excluir_produtos.php?id_produtos=$id_produtos'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";
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
				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a p�gina anterior
			}
		}
		$menos2 = $pagina;
		if($pagina > 0) {
			$menos2 = ($menos2 - 1);
			if($menos2 >= 0){
				$url = "$PHP_SELF?pagina=$menos";
				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a p�gina anterior
			}
		}
		if(!isset($pagina)){
			echo " | <a class=\"destaque\" href='$PHP_SELF?buscar=".$buscar."&pagina=0'>0</a> ";
		}
		else{
			echo " | <a class=\"destaque\" href='$PHP_SELF?buscar=".$buscar."&pagina=$pagina'><strong style='font-size:16px;'><u>".$pagina."</u></strong></a> ";
		}
		$mais = $pagina;
		if($pagina < ($paginas - 1)) {
			for($x=0;$x<(($paginas/2)-1);$x++){
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

	$select_query = "SELECT * FROM produtos ORDER BY id_preco, cod_produto ASC";
	$sql = mysql_query($select_query);
		$geti = $_GET['pagina'];
		if ($geti>0){
			$inicio = 20*$geti; // Especifique quantos resultados voc� quer por p�gina
			$lpp= 20; // Retorna qual ser� a primeira linha a ser mostrada no MySQL
		}else{
			$inicio = 0;
			$lpp	= 20;
		}
		$total = mysql_num_rows($sql); // Esta fun��o ir� retornar o total de linhas na tabela
		$paginas = ceil($total / 20); // Retorna o total de p�ginas
		if(!isset($pagina)) { 
			$pagina = $_GET['pagina']; 
		} // Especifica uma valor para variavel pagina caso a mesma N&Atilde;O esteja setada
	
	$select_paginacao = "SELECT * FROM produtos ORDER BY id_preco, cod_produto ASC LIMIT $inicio, $lpp";
	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.

		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";
		echo "<tr>";
		echo "<td class=titulo $colspan >:: Administrar Produtos ::</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='texto' width='100'><b>C&oacute;d</b></td>";
		echo "<td class='texto' width='350'><b>Nome</b></td>";
		echo $tipo_administrador;
		echo "<td class='texto' width='50'><b>Excluir</b></td>";
		echo "</tr>";

		while ($linha = mysql_fetch_array($sql))
		{
			$select_preco 	= "SELECT * FROM precos WHERE id_preco = '".$linha['id_preco']."'";
			$query_preco	= mysql_query($select_preco);
			$b				= mysql_fetch_array($query_preco);
			
			$id_produtos	= $linha["id_produto"];
			$cod_produto	= $linha["cod_produto"];
			$nome		 	= $linha["modelo"];
			if(preg_match('/[a-zA-Z]/',$cod_produto)){
				$valor			= $b["preco_real_cp"];
			}
			else{
				$valor			= $b["preco_real"];	
			}
			$valor_produto  = str_replace(".",",",$valor);
		if(($_SESSION['tipo'] == 1)||($_SESSION['tipo'] == 3)){
	$tipo_administrador_valor = "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$valor_produto</a></td>";
	
	}
	else{
	$tipo_administrador_valor = "";
	}
		
			echo "<tr>";
			echo "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$cod_produto</a></td>";
			echo "<td class='texto'><a href='vis_produtos.php?id_produtos=$id_produtos'>$nome</td>";
			echo $tipo_administrador_valor;
			echo "<td align='center'><a href='php/excluir_produtos.php?id_produtos=$id_produtos'><img src='img/ico_excluir.png' alt='' border='0' /></a><br></td>";
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
				echo "| <a class=\"destaque\" href=\"$url\"><strong>&lsaquo;</strong></a>"; // Vai para a p�gina anterior
			}
		}
		$menos2 = $pagina;
		if($pagina > 0) {
			$menos2 = ($menos2 - 1);
			if($menos2 >= 0){
				$url = "$PHP_SELF?pagina=$menos";
				echo "| <a class=\"destaque\" href=\"$url\">".$menos2."</a>"; // Vai para a p�gina anterior
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
			for($x=0;$x<(($paginas/2)-1);$x++){
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