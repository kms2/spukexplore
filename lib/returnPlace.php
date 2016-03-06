<?php 
require_once('../requisicao.php');
include_once('../navbar.html');

$jsonPlace = getValor('queryPlace');
$itensPlace = $jsonPlace->results->bindings;
  foreach ($itensPlace as $d) {
    $places[] = $d->place->value;
  }

print_r(json_encode($places));

?>