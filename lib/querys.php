<?php
function strings(){
	$json = '{
	        "strings": [ 
	            { 
	            	"queryDiosease": " select ?x ?name ?title where {?x rdf:type dbo:Disease . ?x dbo:icd10 ?name . ?x dc:title ?title}",
	            	"queryLocalidade" : " select distinct ?ibge ?title ?area where {?x rdf:type ns0:Place . ?x ns0:ibge6 ?ibge . ?x dc:title ?title . ?x ns0:areaTotalKm ?area}",
	            	"queryPlace" : " select distinct ?place where { ?y rdf:type ns0:Place . ?y dc:title ?place  . } GROUP BY ?place "
	            } 
	           
	        ]
	    }';
	    
    return json_decode($json);
} 

?>