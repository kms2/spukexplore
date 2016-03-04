<?php

require_once('requisicao.php');
require_once('lib/querys.php');
require_once('lib.php');

/*$resultado = strings();

$string = $resultado->strings;

$names = null;
foreach ($string as $s){
  $queryLocalidade = $s->queryLocalidade;
}
//print_r($queryLocalidade);
$localidade = query($queryLocalidade);
$json = json_decode($localidade);
$itens = $json->results->bindings;
foreach ($itens as $r) {
  $informacao[] = getGeoNames($r->title->value);
 
} 
print_r($informacao); */

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
    $doencaDisease[] = $r->title->value;
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

#result{
	margin-top: 10%;
}
</style>
 <div class="container">
    <div class="row" id="disease">

		<div class='col-md-12' style="margin-top: 15px;">
			<div class="panel-group">
			  <div class="panel panel-default">
			  	<div class="panel-heading"><center><p id="texto">Indicadores refente apenas a <?php echo $nameDiasease; ?></strong></p></center></div>
			  </div>
			</div>
		</div>

		<div id="result"> </div>
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
            fillColor: "#337ab7",
            strokeColor: "#337ab7",
            pointColor: "#337ab7",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#337ab7",
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
            fillColor: "#FF3333",
            strokeColor: "#FF3333",
            pointColor: "#FF3333",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#FF3333",
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
        color:"#337ab7",
        highlight: "#497FAD",
        label: "Curados"
    },
    {
        value: <?php echo $totaldiagnosticadosDisease; ?> ,
        color: "#F7464A",
        highlight: "#FF5A5E",
        label: "Diagnosticados"
    }
];                  
    
        var ctx = document.getElementById("GraficoBarra").getContext("2d");
        var BarChart = new Chart(ctx).Bar(data, options);

        var ctx1 = document.getElementById("GraficoPie").getContext("2d");
   		var myPie = new Chart(ctx1).Pie(dataPie,options);
  		

        
               
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
<?php
}

	
}



?>
