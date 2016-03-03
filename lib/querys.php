<?php
function strings(){
	$json = '{
	        "strings": [ 
	            { 
	            	"queryDiosease": " select ?x ?name ?title where {?x rdf:type dbo:Disease . ?x dbo:icd10 ?name . ?x dc:title ?title}"
	            } 
	           
	        ]
	    }';
	    
    return json_decode($json);
} 

?>