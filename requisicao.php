<?php

function query(){
    $prefix =   '{
        "prefix": [ 
            {"nome":"dbo", "link":"http://dbpedia.org/ontology/"}, 
            {"nome":"dc", "link":"http://purl.org/dc/terms/"}
        ]
    }';
    $json = json_decode($prefix);
    $itens = $json->prefix;
    $prefixString = "";

    foreach ($itens as $prefixs) { 
       $prefixString .= " PREFIX " . $prefixs->nome . ": <". $prefixs->link .">";
    }

    $parameters = urlencode($prefixString . " select ?x ?name ?title where {?x rdf:type dbo:Disease . ?x dbo:icd10 ?name . ?x dc:title ?title}");
    $format= "json";

   $dados = getresult($parameters, $format);

    return $dados;
}

function getResult($parameters, $format){
   
    $result = file_get_contents('http://webproj04.cin.ufpe.br/sparql/?query='. $parameters . "&format=" . $format);
   
    return $result;
}

?>