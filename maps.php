<?php

require_once('requisicao.php');
require_once('lib/querys.php');
require_once('lib.php');

$nameDiasease = $_POST['doenca'];
$namePlace = $_POST['place'];
if(isset($nameDiasease) && isset($namePlace)){
	
	$returnDisease = getPlaceInfoForDiasease($namePlace, $nameDiasease);
	//print_r($returnDisease);
	$jsonDisease = json_decode($returnDisease);
	
$itens = $jsonDisease->results->bindings;
if(!empty($itens)){
  foreach ($itens as $r) {
    $nIbgeDisease[] = $r->ibge->value;
    $areaDisease[] = $r->area->value;
    $curadosDisease[] = $r->curados->value;
    $diagnosticadosDisease[] = $r->diagnosticados->value;
    $valorDisease[] = intval($r->valor->value);
    $anoDisease[] = limpaURI($r->ano->value);
    //$doencaDisease[] = $r->title->value;
  } 
//print_r($doenca);
$totalcuradosDisease = 0;
$totaldiagnosticadosDisease = 0;
$totacasosDisease = 0;
foreach($curadosDisease as $c){
	$totalcuradosDisease =  $totalcuradosDisease + $c;
}

foreach($diagnosticadosDisease as $d){
	$totaldiagnosticadosDisease =  $totaldiagnosticadosDisease + $d;
}

$totacasosDisease = $totaldiagnosticadosDisease + $totalcuradosDisease;



?>
<style>
#disease{
	color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

#texto {
	text-transform: uppercase;
	margin-bottom: 0;
	font-weight: bold;
	color: #31708F;"
}
html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
#result{
	margin-top: 35%;
}
ul {
    list-style: none;
}
ul li {
    display: block;
    padding-left: 30px;
    position: relative;
    margin-bottom: 4px;
    border-radius: 5px;
    padding: 2px 8px 2px 28px;
    font-size: 14px;
    cursor: default;
    float:left;
    -webkit-transition: background-color 200ms ease-in-out;
    -moz-transition: background-color 200ms ease-in-out;
    -o-transition: background-color 200ms ease-in-out;
    transition: background-color 200ms ease-in-out;
}
li span {
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 75%;
    border-radius: 5px;
}
</style>
<html>
<body>

    <div class="row" id="disease">

		<div class='col-md-12' style="margin-top: 15px;">
			<div class="panel-group">
			  <div class="panel panel-default">
			  	<div class="panel-heading"><center><p id="texto">Indicadores refente apenas a <?php echo $nameDiasease; ?></strong></p></center></div>
			  </div>
			</div>
		</div>
		<br>
		<div class='col-md-6'>
			<div class="panel-group">
			  <div class="panel panel-default">
			  	<div class="panel-heading"><center><p id="texto">Acertos de Casos por Ano</p></center></div>
			  	<div class="panel-body">
			  				<?php
			  					//arsort($valor);
			  					//$cont = 1;
			  					$i = 0;
			  					foreach ($valorDisease as $value) {			  					
			  						echo "<p>" .$value . "% no ano de ".$anoDisease[$i] ."</p>";
			  						//$cont++;
			  						$i++;
			  						
			  					}
			  					   
			  					echo '<br><spam style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Total de Casos nesta cidade:</spam> <strong>' . $totacasosDisease . '</strong>';
			  					
			  				?>

			  	</div>
			  </div>
			</div>
		</div>

    	<div class='col-md-6'>
    		<div class="panel-group">
				  <div class="panel panel-default">
				  	<div class="panel-heading"><center><p id="texto">Curados x Diagnosticados por Ano</p></center></div>
					 <div class="panel-body">
						<div class="box-chart">
						  <canvas id="GraficoBarra" style="width:50%;"></canvas>
						  
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='col-md-6'>
    		<div class="panel-group">
				  <div class="panel panel-default">
				  	<div class="panel-heading"><center><p id="texto">Total Curados x Diagnosticados</p></center></div>
					 <div class="panel-body">
						<div class="box-chart">
						  <canvas id="GraficoPie" style="width:50%;"></canvas>
						  
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

<script type="text/javascript">                                        
    var options = {
        responsive:true

    };
    var data = {
    labels: [
		<?php 
        	foreach($anoDisease as $a){
        		echo $a . ",";
        	}
        ?>
        ],
    datasets: [
        {
            label: "Curados",
            fillColor: "rgba(117,157,193,1)",
            strokeColor: "rgba(117,157,193,1)",
            highlightFill: "rgba(117,157,193,0.8)",
            highlightStroke: "rgba(117,157,193,0.8)",
            data: [
            <?php 
            	foreach($curadosDisease as $c){
            		echo $c . ",";
            	}
            ?>
          ]
        },
        {
            label: "Diagnosticados",
            fillColor: "rgba(247,70,74,1)",
            strokeColor: "rgba(247,70,74,1)",
            highlightFill: "rgba(247,70,74,0.8)",
            highlightStroke: "rgba(247,70,74,0.8)",
            data: [
            <?php 
            	foreach($diagnosticadosDisease as $d){
            		echo $d . ",";
            	}
            ?>]
        }
    ]
};    

var dataPie = [
    {
        value: <?php echo $totalcuradosDisease; ?> ,
        color:"rgba(117,157,193,1)",
        highlight: "rgba(117,157,193,0.8)",
        label: "Curados"
    },
    {
        value: <?php echo $totaldiagnosticadosDisease; ?> ,
        color: "#F7464A",
        highlight: "rgba(247,70,74,0.8)",
        label: "Diagnosticados"
    }
];                  
    
        var ctx = document.getElementById("GraficoBarra").getContext("2d");
        var BarChart = new Chart(ctx).Bar(data, options);
        var legendBar = document.createElement('div');
		legendBar.innerHTML = BarChart.generateLegend();
		document.getElementById('GraficoBarra').parentNode.parentNode.appendChild(legendBar.firstChild);

        var ctx1 = document.getElementById("GraficoPie").getContext("2d");
   		var myPie = new Chart(ctx1).Pie(dataPie,options);
  		var legendPie = document.createElement('div');
		legendPie.innerHTML = myPie.generateLegend();
		document.getElementById('GraficoPie').parentNode.parentNode.appendChild(legendPie.firstChild);

        
               
</script>


<?php 

} else {

	?>

	<div class="container">
    <div class="row">
		<div class='col-md-12'>
			<div class="panel-group">
			  <div class="panel panel-info">
			  	<div class="panel-heading"><center><p id="texto">Desculpe, não há Indicadores refente a cidade de <strong><?php echo $namePlace; ?></strong></p></center></div>
			  </div>
			</div>
		</div>
	</div>
	</div>
</html>
</body>
<?php
}

	
}



?>
