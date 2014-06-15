<?php
  // nome do arquivo
  $arquivo = 'vales.csv';
 $fichas[] = array();
 $produtos[][] = array();
  // ponteiro para o arquivo
  $fp = fopen($arquivo, "r");

   $x = 0;
   $t = false;
  // processa os dados do arquivo
  while(($dados = fgetcsv($fp, 0, ",")) !== FALSE){
    $quant_campos = count($dados);
	for($i = 0; $i < $quant_campos; $i++){
		if($dados[$i] != ""){
			if($dados[$i] == "ORDEM DE"){
				if($x != 0){
					unset($produtos[$fichas[$x][3]][count($produtos[$fichas[$x][3]])],$produtos[$fichas[$x][3]][4]); 
				}
				$x = $x+1;
			}
			$fichas[$x][] = $dados[$i];
			
			if((substr($dados[$i],0,7)) == "Observa"){
				$t = true;
			}
			if((substr($dados[$i],0,4)) == "Aten"){
				$t = false;
			}
			
			if($t){
				unset($produtos[""],$produtos[0],$produtos[$fichas[$x][3]][0]);
				$produtos[$fichas[$x][3]][] = $dados[$i];
			}
		}
	}
  }

  fclose($fp);
  unset($fichas[0]);
  
  foreach($fichas AS $key => $ficha){
	  var_dump($ficha[$key]);
  }
  
  
  
  echo "<pre>";
  echo count($fichas);
  var_dump($produtos,$fichas);
  echo "</pre>";
  
?>