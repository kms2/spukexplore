<?php
require_once('lib/querys.php');

function query($queryString){
    $prefix =   '{
        "prefix": [ 
            {"nome":"dbo", "link":"http://dbpedia.org/ontology/"}, 
            {"nome":"dct", "link":"http://purl.org/dct/terms/"},
            {"nome": "spuk", "link": "http://www.governoaberto.sp.gov.br/ontologia/spuk#"}
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



function getPlaceInfo($namePlace){
    $queryString = "select distinct ?ibge ?area ?curados ?diagnosticados ?valor ?ano ?title ?drs  where {?x rdf:type spuk:Place . ?x spuk:ibge6 ?ibge . ?y rdf:type spuk:IndicadorCuradoDiagnosticado  . ?x dct:title '".$namePlace."' . ?y spuk:refersToPlace ?x . ?y spuk:refersToDisease ?doenca .  ?x spuk:areaTotalKm ?area . ?y spuk:quantidadeCasosCurados ?curados . ?y spuk:quantidadeCasosDiagnosticados ?diagnosticados . ?y spuk:valorCalculado ?valor . ?y dct:temporal ?ano . ?z rdf:type dbo:Disease . ?y spuk:refersToDisease ?z .  ?z dct:title ?title . ?w rdf:type spuk:DRS .  ?x spuk:belongsTo ?w . ?w skos:prefLabel ?drs } ORDER BY ?valor";

   return query($queryString);
}


function getPlaceInfoForDiasease($namePlace, $nameDisease) {
    $queryString = "select distinct ?ibge ?area ?curados ?diagnosticados ?valor ?ano  where {?x rdf:type spuk:Place . ?x spuk:ibge6 ?ibge . ?y rdf:type spuk:IndicadorCuradoDiagnosticado  . ?x dct:title '".$namePlace."' . ?y spuk:refersToPlace ?x . ?y spuk:refersToDisease ?doenca .  ?x spuk:areaTotalKm ?area . ?y spuk:quantidadeCasosCurados ?curados . ?y spuk:quantidadeCasosDiagnosticados ?diagnosticados . ?y spuk:valorCalculado ?valor . ?y dct:temporal ?ano . ?z rdf:type dbo:Disease . ?y spuk:refersToDisease ?z .  ?z dct:title '". $nameDisease ."' } ORDER BY ?valor";
   // print_r($queryString);
   return query($queryString);
}

// RESPONSAVEL POR RETORNAR AS PESSOAS CURADAS, DIAGNOSTICADAS E A DOENCA DE UMA CIDADE ESPECIFICADA //
function getIndicadorForPlace($namePlace){
    $queryString = "select distinct ?curados ?diagnosticados ?doenca where { ?y rdf:type spuk:IndicadorCuradoDiagnosticado  .  ?y spuk:refersToDisease ?doenca  . ?y spuk:quantidadeCasosCurados ?curados . ?y spuk:quantidadeCasosDiagnosticados ?diagnosticados . ?x rdf:type spuk:Place . ?x dct:title '". $namePlace ."' . ?y spuk:refersToPlace ?x  }";
    return query($queryString);
}


// RESPONSAVEL POR RETORNAR AS CIDADES QUE PERTENCEM A UM DRS ESPECIFICADO //
function getPlaceForDRS($nameDRS){
    $queryString = "select distinct ?place where {?x rdf:type spuk:Place . ?w rdf:type spuk:DRS . ?x spuk:belongsTo ?w . ?w skos:prefLabel '". $nameDRS . "' . ?x dct:title ?place } ORDER BY ?place";
    return query($queryString);
}

// RESPONSAVEL POR RETORNAR AS CIDADES QUE PERTENCEM A UM DRS ESPECIFICADO //
function getPlaceForRRAS($nameRRAS){
    $queryString = "select distinct ?place where {?x rdf:type spuk:Place . ?w rdf:type spuk:RRAS . ?x spuk:belongsTo ?w . ?w skos:prefLabel '". $nameRRAS . "' . ?x dct:title ?place } ORDER BY ?place";
    return query($queryString);
}

function getDBpedia($nameLocal){

    $queryString = "SELECT DISTINCT ?city ?populacao ?site ?lat ?long ?vizinhos
                        WHERE { ?city rdf:type dbpedia-owl:City .
                                ?city foaf:name '".$nameLocal."'@pt .
                                ?city dbpedia-owl:populationTotal ?populacao .
                                ?city foaf:isPrimaryTopicOf ?site .
                                ?city geo:lat ?lat .
                                ?city geo:long ?long .
                                ?city dbpprop-pt:vizinhos ?vizinhos           
                             }";
    $parameters = urlencode($queryString);
    $format= "json";

    $placeInfo = file_get_contents('http://pt.dbpedia.org/sparql?query='. $parameters . "&format=" . $format);
    
    return $placeInfo;
}



?>