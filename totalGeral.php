<?php
require_once('requisicao.php');
require_once('lib/querys.php');


ini_set('max_execution_time', 300);

function getValor($nameQuery){
      $resultado = strings();
      $string = $resultado->strings;

      $names = null;
      foreach ($string as $s){
        $query = $s->$nameQuery;
      }

      $resultQuery = query($query);
      //print_r($resultQuery);
      return json_decode($resultQuery);
  }

$json = getValor('queryPlace');
$itens = $json->results->bindings;

/*
$jsonIndicador = getValor('queryIndicadorGeral');
$itensIndicador = $jsonIndicador->results->bindings;

foreach ($itens as $i){
	foreach ($itensIndicador as $k) {
		$cont = 0;
		
		if($k->place->value == $i->place->value){
			$curados[$i->place->value][$cont] = $k->curados->value;
			$cont++;
		}
	}
}
print_r($curados); */

/*foreach ($itens as $i){
	if(isset($curados[$i->place->value])){	
	//$totalcurados = $curados[$i->place->value];

	//print_r($totalcurados . );
		foreach ($curados as $c) {
			//echo $c . " - " . $i->place->value . "<br>" ;
			//$totalcurados =  $totalcurados + $c;
			
		}

		//$curadosCidade[$i->place->value] = $totalcurados; 
	}
} */


$place = "";
foreach ($itens as $r) {
	$totalcurados = 0;
	$totaldiagnosticados = 0;
	$totaGeralCasos = 0;
	$place = $r->place->value;
	$jsonIndicador = json_decode(getIndicadorForPlace($r->place->value));
	
	$itensIndicador = $jsonIndicador->results->bindings;
//print_r($itensIndicador);
	foreach ($itensIndicador as $r) {
	    $curados[] = $r->curados->value;
	    $diagnosticados[] = $r->diagnosticados->value;
	    $doenca = $r->doenca->value;  
  	}
	foreach($curados as $c){
		$totalcurados =  $totalcurados + $c;
	}
	foreach($diagnosticados as $d){
		$totaldiagnosticados =  $totaldiagnosticados + $d;
	}
	if(isset($totalcurados)){
		print_r($totalcurados . " - " . $place);
	}

	if(isset($totaldiagnosticados)){
		print_r($totaldiagnosticados . " - " . $place); 
	} 
} 





?>