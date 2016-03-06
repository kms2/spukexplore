<?php

/* LINK MAPA 
https://geobrainstorms.wordpress.com/2013/05/23/mapa-de-calor-com-o-google-maps/ 
http://stackoverflow.com/questions/21558845/chart-js-and-php
http://websocialdev.com/graficos-chart-js-introducao/
*/

include_once('navbar.html');
require_once('requisicao.php');


  /*$json = getValor('queryDiosease');
  $itens = $json->results->bindings;
  foreach ($itens as $r) {
    $names[] = $r->title->value;
   
  } */


header('Content-Type: text/html; charset=UTF-8');
echo '<html>';
?>
 
<?php

// GET LOCALIDADES //
  $json = getValor('queryPlace');
  $itens = $json->results->bindings;
  foreach ($itens as $r) {
    $places[] = $r->place->value;
  }
  
// GET DRS //
  $jsonDRS = getValor('queryDRS');
  $itensDRS = $jsonDRS->results->bindings;
  foreach ($itensDRS as $d) {
    $drs[] = $d->drs->value;
  }

  // GET DRS //
  $jsonRRAS = getValor('queryRRAS');
  $itensRRAS = $jsonRRAS->results->bindings;
  
  foreach ($itensRRAS as $a) {
    $rras[] = $a->rras->value;
  }

?>


<style>
#places{
  width: 200px;
    float: left;
    margin-right: 10px;
    padding-right: 10px;
} 

#localidades{
      margin-left: 4%;
}
</style>
 <body>
  <div class="container">
  
  <div class="row">
  <div class='col-md-12'>  
    <div class="panel-group">
        <div class="panel panel-info">
          <div class="panel-heading"><center><p style="text-transform: uppercase;margin-bottom: 0";>Escolha uma Cidade</p></center></div>
        </div>
      </div>
  </div>
<div class='col-md-12'>
  <div class='col-md-12' style="margin-left: 4%;margin-bottom: 20px;">
    <div class='col-md-5' style="padding-left: 0px;"> 
    <h5 style="float: left;"> <strong style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">DRS: </strong> </h5>
    <div class="form-group">
        <form role="form" action="post">
          <div class='col-md-8'>  
            <input type="hidden" id="place" value="<?php echo $place; ?>"> 
            <select class="form-control" id="drs">
                    <option value="">TODAS </option>
            <?php
              foreach ($drs as $d){         
                echo "<option id='drs' name='drs' value='".$d."'>".$d."</option>";
              }
            ?>
          </select>
          </div>
          <div class='col-md-2'>
              <input class="btn btn-default" type="button" value="Atualizar" id="btnverificar" name="btnverificar" onclick="Enviadrs()">
          </div>   
        </form>
    </div>
    </div>
    <div class='col-md-5' style=" margin-left: 10%;"> 
    <h5 style="float: left;"> <strong style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">RRAS: </strong> </h5>
    <div class="form-group">
        <form role="form" action="post">
          <div class='col-md-8'>  
            <input type="hidden" id="place" value="<?php echo $place; ?>"> 
            <select class="form-control" id="rras">
                    <option value="">TODAS </option>
            <?php
              foreach ($rras as $rr){         
                echo "<option id='rras' name='rras' value='".$rr."'>".$rr ."</option>";
              }
            ?>
          </select>
          </div>
          <div class='col-md-2'>
              <input class="btn btn-default" type="button" value="Atualizar" id="btnverificar" name="btnverificar" onclick="Enviarras()">
          </div>   
        </form>
    </div>
    </div>
  </div>
    <div class='col-md-12' style="margin-left: 4%;margin-bottom: 20px;"> 
      <h5 style="float: left;"> <strong style="text-transform: uppercase;margin-bottom: 0;font-weight: bold;color: #31708F;">Buscar </strong> </h5>
       <div class='col-md-10'><input type="text" class="form-control" autocomplete="on" id="autocomplete" /></div>
    </div>

<br>
    <div class='col-md-12' style="margin-left: 4%;">
      <div id="result"> </div>
    </div>
    <div class='col-md-12' id="localidades">
      
          <?php 
          foreach($places as $p){
            echo '<a href="place.php?name='. $p . '">
                   <div class="panel-group" id="places">
                   <div class="panel panel-default">';
            echo  ' <div class="panel-heading"><center><p style="margin-bottom: 0;">  '. $p .'</p></center></div>';
            echo ' </div>
                  </div>
                </a>';
          } 
          ?>   
  </div>

</div>
</div>
 </body>
</html>



