<?php
include ("config.php");
include ("../classes/jpgraph.php");
include ("../classes/jpgraph_pie.php");
include ("../classes/jpgraph_pie3d.php");

$dia =date("d");
$mes =date("m");
$ano =date("Y");
$data =$dia."/".$mes."/".$ano;

$estado = $_POST['estado'];
$cidade = $_POST['cidade']; 
$bairro = $_POST['bairro'];

$filtros = "";
$cidadeCorreto = "";
$estadoCorreto = "";
$bairroCorreto = "";
$filtrando = false;

if(!empty($estado)){
	$filtros .= "AND c.estado_cliente = '$estado' ";
	
	$select_estados = "SELECT sigla FROM estados WHERE cod_estados = '$estado'";
	$query_estados = mysql_query($select_estados);
	$a = mysql_fetch_array($query_estados);
	$estadoCorreto .= $a["sigla"];
	
	$filtrando = true;
}
if(!empty($cidade)){
	$select_cidades = "SELECT nome FROM cidades WHERE cod_cidades = '$cidade'";
	$query_cidades = mysql_query($select_cidades);
	$y = mysql_fetch_array($query_cidades);

	if(strlen($filtros)>2){
		$filtros .= "AND c.cidade_cliente = '$cidade' ";
		$cidadeCorreto .= ' - '.strtoupper(strtr(strtoupper(utf8_encode($y['nome'])) ,"����������������","����������������"));
	}
	else{
		$filtros .= "c.cidade_cliente = '$cidade' ";
		$cidadeCorreto .= strtoupper(strtr(strtoupper(utf8_encode($y['nome'])) ,"����������������","����������������"));
	}
	$filtrando = true;	
}
if(!empty($bairro)){
	if(strlen($filtros)>2){
		$filtros .= "AND c.bairro_cliente = '$bairro' ";
		$bairroCorreto .= ' - '.$bairro;
	}
	else{
		$filtros .= "c.bairro_cliente = '$bairro' ";
		$bairroCorreto .= $bairro;
	}
	$filtrando = true;
}

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

$ativo = 0;

if ((!empty($data_inicio))&&(!empty($data_fim))){
		$select = "
			SELECT 
				* 
			FROM 
				clientes c, 
				datas d, 
				ordem_montagem o 
			WHERE 
				c.n_montagem = o.n_montagem AND 
				d.n_montagens = o.n_montagem AND 
				(
					d.data_recebimento >= '$data_inicio' AND 
					d.data_recebimento <= '$data_fim'
				) AND 
				c.ativo='$ativo'
				$filtros 
			ORDER BY 
				o.n_montagem ASC
		";
		$query = mysql_query($select);
		$rows = mysql_num_rows($query);
		
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

while($x = mysql_fetch_array($query)){

		if($x["status"] == '0'){$naMontadora = $naMontadora + 1;}
		elseif($x["status"] == '1'){$montadoAssistencia = $montadoAssistencia + 1;}
		elseif($x["status"] == '2'){$emAtendimento = $emAtendimento + 1;}
		elseif($x["status"] == '3'){$montado = $montado + 1;}
		elseif($x["status"] == '4'){$naoMontado = $naoMontado + 1;}
		elseif($x["status"] == '5'){$justicaExecutada = $justicaExecutada + 1;}
		elseif($x["status"] == '6'){$ausente = $ausente + 1;}
		elseif($x["status"] == '7'){$revisaoExecutada = $revisaoExecutada + 1;}
		elseif($x["status"] == '8'){$tecnicaExecutada = $tecnicaExecutada + 1;}
		elseif($x["status"] == '9'){$desmontagemExecutada = $desmontagemExecutada + 1;}
		elseif($x["status"] == '10'){$justicaNaoExecutada = $justicaNaoExecutada + 1;}
		elseif($x["status"] == '11'){$revisaoNaoExecutada = $revisaoNaoExecutada + 1;}
		elseif($x["status"] == '12'){$tecnicaNaoExecutada = $tecnicaNaoExecutada + 1;}
		elseif($x["status"] == '13'){$desmontagemNaoExecutada = $desmontagemNaoExecutada + 1;}

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
			$descritivo[$i]="Montado c/ Assist�ncia ($montadoAssistencia)";
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
			$descritivo[$i]="Desmontagem n�o Executada ($desmontagemNaoExecutada)";
			$i++;
		}
		if($naoMontado > 0){
			$n_montagens[$i] = $naoMontado; 
			$descritivo[$i]="N�o Montado ($naoMontado)";
			$i++;
		}
		if($justicaExecutada > 0){
			$n_montagens[$i] = $justicaExecutada; 
			$descritivo[$i]="Justi�a Executada ($justicaExecutada)";
			$i++;
		}
		if($ausente > 0){
			$n_montagens[$i] = $ausente;
			$descritivo[$i]="Cliente Ausente ($ausente)";
			$i++;
		}
		if($revisaoExecutada > 0){
			$n_montagens[$i] = $revisaoExecutada; 
			$descritivo[$i]="Revis�o Executada ($revisaoExecutada)";
			$i++;
		}
		if($tecnicaExecutada > 0){
			$n_montagens[$i] = $tecnicaExecutada; 
			$descritivo[$i]="T�cnica Executada ($tecnicaExecutada)";
			$i++;
		}
		if($justicaNaoExecutada > 0){
			$n_montagens[$i] = $justicaNaoExecutada; 
			$descritivo[$i]="Justi�a n�o Executada ($justicaNaoExecutada)";
			$i++;
		}
		if($revisaoNaoExecutada > 0){
			$n_montagens[$i] = $revisaoNaoExecutada; 
			$descritivo[$i]="Revis�o n�o Executada ($revisaoNaoExecutada)";
			$i++;
		}
		if($tecnicaNaoExecutada > 0){
			$n_montagens[$i] = $tecnicaNaoExecutada; 
			$descritivo[$i]="T�cnica n�o Executada ($tecnicaNaoExecutada)";
			$i++;
		}
		
	if($filtrando){$texto='Filtros: '.$estadoCorreto.$cidadeCorreto.$bairroCorreto;}
	else{$texto='';}
	//var_dump($n_montagens,$descritivo);
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'CENTRAL DE MONTAGEM'],
		  <?php
		  	foreach($n_montagens AS $key => $montagem){
				echo utf8_encode("['$descritivo[$key]', $montagem],");
			}
		  ?>
          
        ]);

        var options = {
          title: 'CENTRAL DE MONTAGEM  -  Emitida em:(<?=$data?>)\n\n <?=$texto?>\n\n\rA montadora possui <?=$rows?> fichas com data de recebimento entre os dias <?=$data_inicio?> e <?=$data_fim?>',
		  tooltip: {text:'percentage'}
		  
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 1000px; height: 500px;"></div>
  </body>
</html>
<?php	
	
	

/*// criar novo gr�fico de 350x200 pixels com tipo de
// imagem autom�tico
$grafico = new PieGraph(850,800,"auto");

// adicionar sombra
$grafico->SetShadow();

// t�tulo do gr�fico
$grafico->title->Set("CENTRAL DE MONTAGEM  -  Emiss�o($data)\n\n ".$texto."\n\nA montadora possui $rows fichas com data de recebimento entre os dias $data_inicio e $data_fim");
$grafico->title->SetFont(FF_FONT2,FS_BOLD);

// definir valores ao gr�fico
$p1 = new PiePlot3D($n_montagens);

// PARA SEPARAR TODA A PIZZA DESCOMENTAR A VARIAVEIS ABAIXO
$p1->ExplodeAll();

// PARA SEPARAR A PIZZA POR PEDA�O DESCOMENTAR AS VARIAVEIS ABAIXO

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

// centralizar a 45% da largura/
$p1->SetCenter(0.50);

// definir legendas
$p1->SetLegends($descritivo);

// adicionar valores ao gr�fico
$grafico->Add($p1);

// gerar o gr�fico
$grafico->Stroke();
*/

}else{

  echo "<script> alert('Por Favor! Selecione um intervalo de datas para gerar o grafico');location.href='javascript:window.history.go(-1)'; </script>";

}

?>