<?php

function query($queryString){
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

    $parameters = urlencode($prefixString . $queryString);
    $format= "json";
    $dados = getresult($parameters, $format);

    return $dados;
}

function getResult($parameters, $format){
   
    $result = file_get_contents('http://webproj04.cin.ufpe.br/sparql/?query='. $parameters . "&format=" . $format);
   
    return $result;
}

?>