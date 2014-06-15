<?php
include"config.php";

	$mont = $_POST['mont'];

	$data_hoje = date("Y-m-d");
	/*
	$select_query = "SELECT * FROM datas d, clientes c, ordem_montagem o WHERE d.n_montagens = c.n_montagem AND d.n_montagens = o.n_montagem AND d.data_limite < '$data_hoje' AND d.data_final = '0000-00-00' AND o.id_montador = '$mont'";
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
	
	PARA COLOCAR PAGINAÇÃO DESCOMENTAR O SELECT ABAIXO
	
	$select_paginacao = "SELECT * FROM datas d, clientes c, ordem_montagem o WHERE d.n_montagens = c.n_montagem AND d.n_montagens = o.n_montagem AND d.data_limite < '$data_hoje' AND d.data_final = '0000-00-00' AND o.id_montador = '$mont' ORDER BY data_limite ASC LIMIT $inicio, $lpp";
	
	*/
	$select_paginacao = "SELECT * FROM datas d, clientes c, ordem_montagem o WHERE d.n_montagens = c.n_montagem AND d.n_montagens = o.n_montagem AND d.data_limite < '$data_hoje' AND d.data_final = '0000-00-00' AND o.id_montador = '$mont' ORDER BY data_limite ASC";
	$sql = mysql_query($select_paginacao); // Executa a query no MySQL com o limite de linhas.

		echo "<table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>";
		echo "<tr>";
		echo "<td class=titulo colspan=6>:: Clientes Atrasados ::</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='texto' width='100'><b>V.Montagens:</b></td>";
		echo "<td class='texto' width='105'><b>Pedido</b></td>";
		echo "<td class='texto' width='100'><b>Cliente</b></td>";
		echo "<td class='texto' width='100'><b>data Montagem</b></td>";
		echo "<td class='texto' width='145'><b>Bairro</b></td>";
		echo "<td class='texto' align='center' width='100'><b>Pr&eacute;-Baixa</b></td>";
		echo "</tr>";

		while ($linha = mysql_fetch_array($sql))
		{
/*			$select_nome = "SELECT * FROM montadores WHERE id_montadores = '".$linha['id_montador']."'";
			$query_nome = mysql_query($select_nome);
			$rows_nome = mysql_num_rows($query_nome);
			if($rows_nome > 0){
				$result_nome = mysql_fetch_array($query_nome);
				$nome = $result_nome['nome'];
			}
			else{
				$nome = 'S/ montador';
			}
*/			
			$status = $linha['status'];

			$nome = $linha['nome_cliente'];
			
			$data_final = new DateTime($linha["data_limite"]);  
			$data_final = $data_final->format('d/m/Y');

			$n_montagem			= $linha["n_montagem"];
			$orcamento			= $linha["orcamento"];
			$bairro				= $linha["bairro_cliente"];
			$id_clientes		= $linha["id_cliente"];
			
			echo "<tr>";
			echo "<td class='texto'>$n_montagem</td>";
			echo "<td class='texto'>$orcamento</td>";
			echo "<td class='texto'>$nome</td>";
			echo "<td class='texto'>$data_final</td>";
			echo "<td class='texto'>$bairro</td>";
			if($status == 2){
			####################################### PRE BAIXAS ##################################################
			$select_pre = "SELECT * FROM pre_baixas WHERE n_montagem = '".$linha["n_montagem"]."'";
			$query_pre = mysql_query($select_pre);
			$result_pre = mysql_fetch_array($query_pre);
			$rows_pre = mysql_num_rows($query_pre);
			
			if($rows_pre > 0){
				echo "<td align='center'><img src='images/positivo_in.png' border='0' width='19' /></td>";
			}
			else{
				echo "<td align='center'><img src='images/positivo_out.png' border='0' width='19' /></td>";
			}		
			#####################################################################################################
			}
			else{
				echo "<td align='center'>&nbsp;</td>";
			}
			echo "</tr>";		
			}
			echo "</table>";
	/*	
			
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
			*/
?>