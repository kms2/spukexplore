<?php
include_once('navbar.html');
require_once('requisicao.php');
require_once('lib.php');

$place = $_GET['name'];

$return = getPlaceInfo($place);
$json = json_decode($return);
$itens = $json->results->bindings;
if(!empty($itens)){
  foreach ($itens as $r) {
    $nIbge[] = $r->ibge->value;
    $area[] = $r->area->value;
    $curados[] = $r->curados->value;
    $diagnosticados[] = $r->diagnosticados->value;
    $valor[] = intval($r->valor->value);
    $ano[] = limpaURI($r->ano->value);
    $doenca[] = $r->title->value;
  } 
//print_r($doenca);
$totalcurados = 0;
$totaldiagnosticados = 0;
$totacasos = 0;
foreach($curados as $c){
	$totalcurados =  $totalcurados + $c;
}

foreach($diagnosticados as $d){
	$totaldiagnosticados =  $totaldiagnosticados + $d;
}

$totacasos = $totaldiagnosticados + $totalcurados;



?>
<head>
<style>
.checkbox {
	float: left;
    width: 170px;
    margin-top: 0;
}
</style>
</head>
 <div class="container">
    <div class="row">
    
		<div class='col-md-12'>
			<div class="panel-group">
			  <div class="panel panel-info">
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Indicadores refente a cidade de <strong><?php echo $place; ?></strong></p></center></div>
			  </div>
			</div>
		</div>

		<div class='col-md-12' style="margin-bottom: 25px;">
		  <div class="form-group">
			  <form role="form" action="post">
			  	<div class='col-md-10'>		
			  		<input type="hidden" id="place" value="<?php echo $place; ?>"> 
			  		<select class="form-control" id="doenca">
              			<option value="">----- SELECIONE -----</option>
			    	<?php
			    	$doencas =  array_unique($doenca);
			    		foreach ($doencas as $d){		    	
			    			echo "<option id='doenca' name='doenca' type='checkbox' value='".$d."'>".$d."</option>";
			    		}
			    	?>
			    </select>
			   	</div>
		    	<div class='col-md-2'>
		      		<input class="btn btn-default" type="button" value="Atualizar" id="btnverificar" name="btnverificar" onclick="post();">
		    	</div>   
			  </form>
		  </div>
		</div>
		<div id="result"> </div>
		<br>
		<div id="graficosGerais">
		<div class='col-md-6'>
			<div class="panel-group">
			  <div class="panel panel-default">
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Acertos de Casos por Ano</p></center></div>
			  	<div class="panel-body">
			  				<?php
			  					//arsort($valor);
			  					//$cont = 1;
			  					$i = 0;
			  					foreach ($valor as $value) {			  					
			  						echo "<p>" .$value . "% no ano de ".$ano[$i] ."</p>";
			  						//$cont++;
			  						$i++;
			  						
			  					}
			  					   
			  					echo '<br><spam style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Total de Casos nesta cidade:</spam> <strong>' . $totacasos . '</strong>';
			  					
			  				?>

			  	</div>
			  </div>
			</div>
		</div>

    	<div class='col-md-6'>
    		<div class="panel-group">
				  <div class="panel panel-default">
				  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Curados x Diagnosticados por Ano</p></center></div>
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
				  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Total Curados x Diagnosticados</p></center></div>
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
</div>
<script type="text/javascript">                                        
    var options = {
        responsive:true

    };
    var data = {
    labels: [
		<?php 
        	foreach($ano as $a){
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
            	foreach($curados as $c){
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
            	foreach($diagnosticados as $d){
            		echo $d . ",";
            	}
            ?>]
        }
    ]
};    

var dataPie = [
    {
        value: <?php echo $totalcurados; ?> ,
        color:"#337ab7",
        highlight: "#497FAD",
        label: "Curados"
    },
    {
        value: <?php echo $totaldiagnosticados; ?> ,
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
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Desculpe, não há Indicadores refente a cidade de <strong><?php echo $place; ?></strong></p></center></div>
			  </div>
			</div>
		</div>
	</div>
	</div>
<?php
}

?>