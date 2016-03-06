<?php
require_once('requisicao.php');
if($_POST['rras']){

// GET DRS //
  $nameRRAS = $_POST['rras'];
  $json = json_decode(getPlaceForRRAS($nameRRAS));
  $itens = $json->results->bindings;
  foreach ($itens as $d) {
    $places[] = $d->place->value;
  }

  foreach($places as $p){
              echo '<a href="place.php?name='. $p . '">
                     <div class="panel-group" id="places">
                     <div class="panel panel-default">';
              echo  ' <div class="panel-heading"><center><p style="margin-bottom: 0;">  '. $p .'</p></center></div>';
              echo ' </div>
                    </div>
                  </a>';
            } 
} else {
  echo "";
}

?>