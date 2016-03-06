<?php 

function limpaURI($uri){
  $partes = explode("/", $uri);
  $tam = count($partes);
  $string = $partes[$tam-1];
  return $string;
}

 function getValor($nameQuery){
      $resultado = strings();
      $string = $resultado->strings;

      $names = null;
      foreach ($string as $s){
        $query = $s->$nameQuery;
      }

      $resultQuery = query($query);
      return json_decode($resultQuery);
  }

?>
