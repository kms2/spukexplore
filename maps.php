<?php

require_once('requisicao.php');
require_once('lib/querys.php');


$resultado = strings();

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
print_r($informacao);



?>
