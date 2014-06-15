<?php
include ("config.php");
include ("../classes/jpgraph.php");
include ("../classes/jpgraph_pie.php");
include ("../classes/jpgraph_pie3d.php");

$dia =date("d");
$mes =date("m");
$ano =date("Y");
$data =$dia."/".$mes."/".$ano;

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


/*$data_inicio = $_POST['ano_ini']."-".$_POST['mes_ini']."-".$_POST['dia_ini'];
$data_fim = $_POST['ano_fim']."-".$_POST['mes_fim']."-".$_POST['dia_fim'];
*/
$ativo = 0;

if ((!empty($data_inicio))&&(!empty($data_fim))){
		$select = "SELECT * FROM clientes c, datas d, ordem_montagem o WHERE c.n_montagem = o.n_montagem AND d.n_montagens = o.n_montagem AND (d.data_recebimento >= '$data_inicio' AND d.data_recebimento <= '$data_fim') AND c.ativo='$ativo' AND status = '2' ORDER BY o.n_montagem ASC";
		$query = mysql_query($select);
		$rows = mysql_num_rows($query);
		
		//var_dump($select);
		//exit;
		
		$naMontadora 				= 0; // status = 0
		$montadoAssistencia 		= 0; // status = 1
		$emAtendimento 				= 0; // status = 2
		$montado 					= 0; // status = 3
		$naoMontado 				= 0; // status = 4
		$justicaExecutada 			= 0; // status = 5
		$ausente 					= 0; // status = 6
		$revisaoExecutada 			= 0; // status = 7
		$tecnicaExecutada 			= 0; // status = 8
		$desmontagemExecutada 		= 0; // status = 9
		$justicaNaoExecutada 		= 0; // status = 10
		$revisaoNaoExecutada 		= 0; // status = 11
		$tecnicaNaoExecutada 		= 0; // status = 12
		$desmontagemNaoExecutada 	= 0; // status = 13

while($z = mysql_fetch_array($query)){
	
		$select_pre = "SELECT * FROM pre_baixas WHERE n_montagem = '".$z['n_montagem']."'";
		$query_pre = mysql_query($select_pre);
		$x = mysql_fetch_array($query_pre);
		$rows_pre = mysql_num_rows($query_pre);
		
		
		if($rows_pre > 0){
			if($x["valida"] == '0'){$naMontadora = $naMontadora + 1;}
			elseif($x["valida"] == '1'){$montadoAssistencia = $montadoAssistencia + 1;}
			elseif($x["valida"] == '3'){$montado = $montado + 1;}
			elseif($x["valida"] == '4'){$naoMontado = $naoMontado + 1;}
			elseif($x["valida"] == '5'){$justicaExecutada = $justicaExecutada + 1;}
			elseif($x["valida"] == '6'){$ausente = $ausente + 1;}
			elseif($x["valida"] == '7'){$revisaoExecutada = $revisaoExecutada + 1;}
			elseif($x["valida"] == '8'){$tecnicaExecutada = $tecnicaExecutada + 1;}
			elseif($x["valida"] == '9'){$desmontagemExecutada = $desmontagemExecutada + 1;}
			elseif($x["valida"] == '10'){$justicaNaoExecutada = $justicaNaoExecutada + 1;}
			elseif($x["valida"] == '11'){$revisaoNaoExecutada = $revisaoNaoExecutada + 1;}
			elseif($x["valida"] == '12'){$tecnicaNaoExecutada = $tecnicaNaoExecutada + 1;}
			elseif($x["valida"] == '13'){$desmontagemNaoExecutada = $desmontagemNaoExecutada + 1;}
		}
		else{			
			$emAtendimento = $emAtendimento + 1;
		}

}

/*
echo "Total de Fichas Cadastradas = ".$rows."<br>";
echo "Na Montadora = ".$naMontadora."<br>";
echo "Montado com Assistencia = ".$montadoAssistencia."<br>";
echo "Em Atendimento = ".$emAtendimento."<br>";
echo "Montado = ".$montado."<br>";
echo "Nao Montado = ".$naoMontado."<br>";
echo "Justica Executada = ".$justicaExecutada."<br>";
echo "Ausente = ".$ausente."<br>";
echo "Revisao Executada = ".$revisaoExecutada."<br>";
echo "Tecnica Executada = ".$tecnicaExecutada."<br>";
echo "Desmontagem Executada = ".$desmontagemExecutada."<br>";
echo "Justica Nao Executada = ".$justicaNaoExecutada."<br>";
echo "Revisao Nao Executada = ".$revisaoNaoExecutada."<br>";
echo "Tecnica Nao Executada = ".$tecnicaNaoExecutada."<br>";
echo "Desmontagem Nao Executada = ".$desmontagemNaoExecutada."<br>";
exit;
*/

		$data_inicio = new DateTime($data_inicio);  
		$data_inicio = $data_inicio->format('d/m/Y');
		$data_fim = new DateTime($data_fim);  
		$data_fim = $data_fim->format('d/m/Y');
		
		$n_montagens = array();
		$descritivo  = array();
		$i = 0;
		if($naMontadora > 0){
			$n_montagens[$i] = $naMontadora; 
			$descritivo[$i]="Na Montadora ($naMontadora)";
			$i++;
		}
		if($montadoAssistencia > 0){
			$n_montagens[$i] = $montadoAssistencia; 
			$descritivo[$i]="Montado c/ Assistência ($montadoAssistencia)";
			$i++;
		}
		if($emAtendimento > 0){
			$n_montagens[$i] = $emAtendimento; 
			$descritivo[$i]="Em Atendimento ($emAtendimento)";
			$i++;
		}
		if($desmontagemExecutada > 0){
			$n_montagens[$i] = $desmontagemExecutada; 
			$descritivo[$i]="Desmontagem Executada ($desmontagemExecutada)";
			$i++;
		}
		if($montado > 0){
			$n_montagens[$i] = $montado; 
			$descritivo[$i]="Montado ($montado)";
			$i++;
		}
		if($desmontagemNaoExecutada > 0){
			$n_montagens[$i] = $desmontagemNaoExecutada; 
			$descritivo[$i]="Desmontagem não Executada ($desmontagemNaoExecutada)";
			$i++;
		}
		if($naoMontado > 0){
			$n_montagens[$i] = $naoMontado; 
			$descritivo[$i]="Não Montado ($naoMontado)";
			$i++;
		}
		if($justicaExecutada > 0){
			$n_montagens[$i] = $justicaExecutada; 
			$descritivo[$i]="Justiça Executada ($justicaExecutada)";
			$i++;
		}
		if($ausente > 0){
			$n_montagens[$i] = $ausente;
			$descritivo[$i]="Cliente Ausente ($ausente)";
			$i++;
		}
		if($revisaoExecutada > 0){
			$n_montagens[$i] = $revisaoExecutada; 
			$descritivo[$i]="Revisão Executada ($revisaoExecutada)";
			$i++;
		}
		if($tecnicaExecutada > 0){
			$n_montagens[$i] = $tecnicaExecutada; 
			$descritivo[$i]="Técnica Executada ($tecnicaExecutada)";
			$i++;
		}
		if($justicaNaoExecutada > 0){
			$n_montagens[$i] = $justicaNaoExecutada; 
			$descritivo[$i]="Justiça não Executada ($justicaNaoExecutada)";
			$i++;
		}
		if($revisaoNaoExecutada > 0){
			$n_montagens[$i] = $revisaoNaoExecutada; 
			$descritivo[$i]="Revisão não Executada ($revisaoNaoExecutada)";
			$i++;
		}
		if($tecnicaNaoExecutada > 0){
			$n_montagens[$i] = $tecnicaNaoExecutada; 
			$descritivo[$i]="Técnica não Executada ($tecnicaNaoExecutada)";
			$i++;
		}

// criar novo gráfico de 350x200 pixels com tipo de
// imagem automático
$grafico = new PieGraph(850,800,"auto");

// adicionar sombra
$grafico->SetShadow();

// título do gráfico
$grafico->title->Set("NAEC - PRESTYRIO  -  Emissão($data)\n\nA montadora possui $rows fichas em ATENDIMENTO\n\ncom data de recebimento entre os dias $data_inicio e $data_fim");
$grafico->title->SetFont(FF_FONT2,FS_BOLD);

// definir valores ao gráfico
$p1 = new PiePlot3D($n_montagens);

// PARA SEPARAR TODA A PIZZA DESCOMENTAR A VARIAVEIS ABAIXO
$p1->ExplodeAll();

// PARA SEPARAR A PIZZA POR PEDAÇO DESCOMENTAR AS VARIAVEIS ABAIXO

/*$p1->ExplodeSlice(0);
$p1->ExplodeSlice(1);
$p1->ExplodeSlice(2);
$p1->ExplodeSlice(3);
$p1->ExplodeSlice(4);
$p1->ExplodeSlice(5);
$p1->ExplodeSlice(6);
$p1->ExplodeSlice(7);
$p1->ExplodeSlice(8);
$p1->ExplodeSlice(9);
$p1->ExplodeSlice(10);
$p1->ExplodeSlice(11);
$p1->ExplodeSlice(12);
$p1->ExplodeSlice(13);

*/// centralizar a 45% da largura/
$p1->SetCenter(0.50);

// definir legendas
$p1->SetLegends($descritivo);

// adicionar valores ao gráfico
$grafico->Add($p1);

// gerar o gráfico
$grafico->Stroke();


}else{

  echo "<script> alert('Por Favor! Selecione um intervalo de datas para gerar o grafico');location.href='javascript:window.history.go(-1)'; </script>";

}

?>