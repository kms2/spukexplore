<?php

/* LINK MAPA 
https://geobrainstorms.wordpress.com/2013/05/23/mapa-de-calor-com-o-google-maps/ 
http://stackoverflow.com/questions/21558845/chart-js-and-php
http://websocialdev.com/graficos-chart-js-introducao/
*/

include_once('navbar.html');
require_once('requisicao.php');

$names = null;

$result = query();
$json = json_decode($result);

$itens = $json->results->bindings;
foreach ($itens as $r) {
  $names[] = $r->title->value;
 
}

?>
<html>
  <head>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
 
    <script type='text/javascript' src='graphics/graph2.js'></script>
  </head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-9">
        <div class="form-group">
          <form action="post">
            <label for="sel1">Doenças:</label>
            <select class="form-control" id="doenca">
            <?php 
              for ($i = 0; $i < count($names); $i++) {
                echo  '<option> '. $names[$i] .'</option>';
              } 
            ?> 
            </select>
        </form>
        </div>
      </div>
  <div class="col-md-1"></div>
    </div>
  <div class="row">
  <div class="col-md-1"></div>
    <div class='col-md-9'>
      <div class='panel-group'>
      <div class='panel panel-primary'>
        <div id='regions_div' style='width: 600px; height: 300px;'></div>
      </div>
      </div>
    </div>
  <div class="col-md-1"></div>
  </div>

</div>
 </body>
</html>



