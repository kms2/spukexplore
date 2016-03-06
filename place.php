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
    $drs[] = $r->drs->value;
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

$dbpedia = getDBpedia($place);
$jsonDBpedia = json_decode($dbpedia);
$itensDBpedia = $jsonDBpedia->results->bindings;


if(!empty($itensDBpedia)){
  foreach ($itensDBpedia as $db) {
    $populacao = $db->populacao->value;
    $site = $db->site->value;
    $latitude = $db->lat->value;
    $longitude = $db->long->value;
    $vizinhos = $db->vizinhos->value;

  } 
}

?>

<style >
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
<body>
 <div class="container">
    <div class="row">
    
		<div class='col-md-12' style="margin-top: 2%;">

			<div class="panel-group">
			  <div class="panel panel-primary">
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;">Informações Gerais</p></center></div>
			  	<div class="panel-body">
			  		
			  		<p><strong>Nome da Cidade:</strong> 
		  			<?php if(isset($site)){ ?>
		  			  <a href='<?php echo $site; ?>' target="_blank"> <?php echo $place; ?> </a></p>
		  			<?php } else { ?>
 					   <?php echo $place; ?> </p>
		  			<?php
		  			} ?>

			  		<?php if(isset($nIbge)){ ?>
			  			<p><strong>Nº IBGE:</strong> <?php echo $nIbge[0];  ?> </p> 
			  		<?php } ?>	

			  		<?php if(isset($area)){ ?>
			  			<p><strong>Área Total:</strong> <?php echo $area[0];  ?> KM </p> 
			  		<?php } ?>

			  		<?php if(isset($drs)){ ?>
			  			<p><strong>DRS:</strong> <?php echo $drs[0];  ?> </p> 
			  		<?php } ?>
			  		
			  		<?php if(isset($populacao)){ ?>
			  			<p><strong>População:</strong> <?php echo $populacao; ?> habitantes</p>
			  		<?php } ?>

			  		<?php if(isset($vizinhos)){ ?>
			  			<p><strong>Cidades vizinhas:</strong> <?php echo $vizinhos; ?></p> 
			  		<?php } ?>

			  				  		
			  	</div>
			  </div>
			</div>
		</div>

		<div class='col-md-12'>
			<div class="panel-group">
			  <div class="panel panel-info">
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Indicadores refente a cidade de <strong><?php echo $place; ?></strong></p></center></div>
			  </div>
			</div>
		</div>


		<div class='col-md-12' style="margin-bottom: 25px;">
			<h5 style="float: left;"> <strong style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Filtrar por Doença: </strong> </h5>
		  <div class="form-group">
			  <form role="form" action="post">
			  	<div class='col-md-9'>	
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
		    	<div class='col-md-1'>
		      		<input class="btn btn-default" type="button" value="Atualizar" id="btnverificar" name="btnverificar" onclick="post()">
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
			  					   
			  					echo '<br><spam style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Total Geral de Casos nesta cidade:</spam> <strong>' . $totacasos . '</strong>';
			  					
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
            fillColor: "rgba(117,157,193,1)",
            strokeColor: "rgba(117,157,193,1)",
            highlightFill: "rgba(117,157,193,0.8)",
            highlightStroke: "rgba(117,157,193,0.8)",
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
            fillColor: "rgba(247,70,74,1)",
            strokeColor: "rgba(247,70,74,1)",
            highlightFill: "rgba(247,70,74,0.8)",
            highlightStroke: "rgba(247,70,74,0.8)",
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
        color:"rgba(117,157,193,1)",
        highlight: "rgba(117,157,193,0.8)",
        label: "Curados"
    },
    {
        value: <?php echo $totaldiagnosticados; ?> ,
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
			  	<div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Desculpe, não há Indicadores refente a cidade de <strong><?php echo $place; ?></strong></p></center></div>
			  </div>
			</div>
		</div>
	</div>
	</div>
</body>
<?php
}

?>