  <?php
$res = array(array("nome"=>"4.1. FURTO DE NOTEBOOK","solicitacao"=>3),array("nome"=>"4.2. FURTO DE COMPUTADOR","solicitacao"=>7),array("nome"=>"AAAAA NOVO ASSUNTO DDDD","solicitacao"=>6));
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" language="javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" language="javascript">
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);


      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
	  <?php
foreach($res as $key => $valores){
	if($key == count($res)){
		$virgula = '';	
	}
	else{
		$virgula = ',';
	}
	echo '["'.$valores['nome'].'",'.$valores['solicitacao'].']'.$virgula;
}
	  
	  ?>
	  ]);
      // Set chart options
      var options = {'title':'How Much Pizza I Ate Last Night',
                     'width':800,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
	   
	   google.setOnLoadCallback(drawChart2);


      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart2() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
	  <?php
foreach($res as $key => $valores){
	if($key == count($res)){
		$virgula = '';	
	}
	else{
		$virgula = ',';
	}
	echo '["'.$valores['nome'].'",'.$valores['solicitacao'].']'.$virgula;
}
	  
	  ?>
	  ]);

      // Set chart options
      var options = {'title':'How Much Pizza I Ate Last Night',
                     'width':800,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
      chart.draw(data, options);
    }

    </script>
  </head>

  <body>
<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:800; height:300; float:left;"></div>
    <div id="chart_div2" style="width:800; height:300; float:left;"></div>

  </body>
</html>