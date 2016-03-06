<?php
function strings(){
	$json = '{
	        "strings": [ 
	            { 
	            	"queryDiosease": " select ?x ?name ?title where {?x rdf:type dbo:Disease . ?x dbo:icd10 ?name . ?x dct:title ?title}",
	            	"queryPlace" : " select distinct ?place where { ?y rdf:type spuk:Place . ?y dct:title ?place  } GROUP BY ?place ORDER BY ?place",
	            	"queryDRS" : "select distinct ?drs where { ?w rdf:type spuk:DRS .  ?w skos:prefLabel ?drs } ORDER BY ?drs",
	            	"queryRRAS" : "select distinct ?rras where { ?w rdf:type spuk:RRAS .  ?w skos:prefLabel ?rras } ORDER BY ?rras",
	            	"queryIndicadorGeral" : "select distinct ?curados ?diagnosticados ?doenca ?place where { ?y rdf:type spuk:IndicadorCuradoDiagnosticado  .  ?y spuk:refersToDisease ?doenca  . ?y spuk:quantidadeCasosCurados ?curados . ?y spuk:quantidadeCasosDiagnosticados ?diagnosticados . ?x rdf:type spuk:Place . ?x dct:title ?place . ?y spuk:refersToPlace ?x  } ORDER BY ?place",
	            	"queryValorDRS" : "select distinct ?drs  (AVG(xsd:int(?valor)) as ?valorcal) where { ?y rdf:type spuk:IndicadorCuradoDiagnosticado  . ?y spuk:valorCalculado ?valor .  ?x rdf:type spuk:Place . ?x dct:title ?place . ?y spuk:refersToPlace ?x  . ?z rdf:type spuk:DRS . ?x spuk:belongsTo ?z . ?z skos:prefLabel ?drs } order by DESC( AVG(xsd:double(?valor)))",
	           		"queryTopCuradosPlace" : "select distinct ?place (SUM(distinct xsd:int(?curados)) as ?qtdcurados) where { ?y rdf:type spuk:IndicadorCuradoDiagnosticado  . ?y spuk:valorCalculado ?valor . ?y spuk:quantidadeCasosCurados ?curados.  ?x rdf:type spuk:Place . ?x dct:title ?place . ?y spuk:refersToPlace ?x . ?y dct:temporal ?ano } order by DESC(SUM(distinct xsd:int(?curados))) limit 10"
	            } 
	           
	        ]
	    }';
	    
    return json_decode($json);
} 

?>