<?php

/* LINK MAPA 
https://geobrainstorms.wordpress.com/2013/05/23/mapa-de-calor-com-o-google-maps/ 
http://stackoverflow.com/questions/21558845/chart-js-and-php
http://websocialdev.com/graficos-chart-js-introducao/
*/

include_once('navbar.html');
require_once('requisicao.php');
require_once('lib/querys.php');
  

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

  $json = getValor('queryDiosease');
  $itens = $json->results->bindings;
  foreach ($itens as $r) {
    $names[] = $r->title->value;
   
  } 


?>
<html>
  
  <body>
  <div class="container">
    <div class="row">
      
      <!-- <div class="col-md-12">
        <div class="form-group">
          <form action="post">
            <label for="doenca">Doenças:</label>
            <select class="form-control" id="doenca">
              <option>----- SELECIONE -----</option>
            <?php 
           //   for ($i = 0; $i < count($names); $i++) {
             //   echo  '<option> '. $names[$i] .'</option>';
             // } 
            ?> 
            </select>
        </form>
        </div>
      </div>-->
  
    </div> 

<?php


  $json = getValor('queryPlace');

  $itens = $json->results->bindings;

  foreach ($itens as $r) {
    $places[] = $r->place->value;
   
  }
  asort($places);
?>


<style>
.places{
  float:left;
  width: 220px;
}

footer{
      background-color: #B6BEC5;
    height: 50px;
    width: 100%;
    margin-top: 20px;
}


</style>

  <div class="row">

    <div class='col-md-12'>

      <div class="panel-group">
        <div class="panel panel-info">
          <div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Escolha uma Cidade</p></center></div>
        </div>
      </div>
  
        <ul>
        
            <?php 

            foreach($places as $p){
              echo  '<li class="places"> <a href="place.php?name='. $p . '"> '. $p .'</a></li>';
            } 
              
            ?> 

        </ul>
    </div>
  </div>

</div>
 </body>
<footer><center><p style="padding-top: 14px;">Todos os direitos reservados </p></center></footer>
</html>



