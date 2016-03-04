<?php

function query($queryString){
    $prefix =   '{
        "prefix": [ 
            {"nome":"dbo", "link":"http://dbpedia.org/ontology/"}, 
            {"nome":"dc", "link":"http://purl.org/dc/terms/"},
            {"nome": "ns0", "link": "http://www.governoaberto.sp.gov.br/ontologia/spuk#"}
        ]
    }';
    $json = json_decode($prefix);
    $itens = $json->prefix;
    $prefixString = "";

    foreach ($itens as $prefixs) { 
       $prefixString .= " PREFIX " . $prefixs->nome . ": <". $prefixs->link .">";
    }

    $parameters = urlencode($prefixString . $queryString);
    $format= "json";
    $dados = getresult($parameters, $format);

    return $dados;
}

function getResult($parameters, $format){
   
    $result = file_get_contents('http://webproj04.cin.ufpe.br/sparql/?query='. $parameters . "&format=" . $format);
   
    return $result;
}

function getGeoNames($nameLocal){

    $localidade = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='. urlencode($nameLocal) .'&key=AIzaSyB5Q7dfBggEUonloDiWGl8wCpM1s3PoSiY');
    $json = json_decode($localidade);
    //print_r($json);
    $itens = $json->results;
    //print_r($itens );
    foreach ($itens as $key ) {
       $lat = $key->geometry->location->lat;
       $long = $key->geometry->location->lng;
       $lat_long[] = array("lat" => $lat, "long" => $long);
    }
   
  
    return $lat_long;
}


function getPlaceInfo($namePlace){
    $queryString = "select distinct ?ibge ?area ?curados ?diagnosticados ?valor ?ano ?title  where {?x rdf:type ns0:Place . ?x ns0:ibge6 ?ibge . ?y rdf:type ns0:IndicadorCuradoDiagnosticado  . ?x dc:title '".$namePlace."' . ?y ns0:refersToPlace ?x . ?y ns0:refersToDisease ?doenca .  ?x ns0:areaTotalKm ?area . ?y ns0:quantidadeCasosCurados ?curados . ?y ns0:quantidadeCasosDiagnosticados ?diagnosticados . ?y ns0:valorCalculado ?valor . ?y dc:temporal ?ano . ?z rdf:type dbo:Disease . ?y ns0:refersToDisease ?z .  ?z dc:title ?title  } ORDER BY ?valor";

   return query($queryString);
}


function getPlaceInfoForDiasease($namePlace, $nameDisease) {
    $queryString = "select distinct ?ibge ?area ?curados ?diagnosticados ?valor ?ano  where {?x rdf:type ns0:Place . ?x ns0:ibge6 ?ibge . ?y rdf:type ns0:IndicadorCuradoDiagnosticado  . ?x dc:title '".$namePlace."' . ?y ns0:refersToPlace ?x . ?y ns0:refersToDisease ?doenca .  ?x ns0:areaTotalKm ?area . ?y ns0:quantidadeCasosCurados ?curados . ?y ns0:quantidadeCasosDiagnosticados ?diagnosticados . ?y ns0:valorCalculado ?valor . ?y dc:temporal ?ano . ?z rdf:type dbo:Disease . ?y ns0:refersToDisease ?z .  ?z dc:title '". $nameDisease ."' } ORDER BY ?valor";
   // print_r($queryString);
   return query($queryString);
}


?>