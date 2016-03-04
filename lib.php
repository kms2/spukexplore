<?php 

function limpaURI($uri){
  $partes = explode("/", $uri);
  $tam = count($partes);
  $string = $partes[$tam-1];
  return $string;
}

?>
