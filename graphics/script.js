
function post() {
	
	$("#result").html("<center><img style='width: auto; height: auto;' src='img/loading.gif' /></center>");
	$("#graficosGerais").hide();
	name = $('#doenca').val();
	place = $('#place').val();

	if ((name !== null && name !== undefined && name !== "") && (place !== null && place !== undefined)) {

		$.post("maps.php", { 'doenca': name, 'place': place}, function(data){
			$("#result").html(data);
			
		}); 
		
		} else  {
			//alert('teste');
			window.location.reload();
			
		}
}


function Enviadrs() {

	$("#result").html("<center><img style='width: auto; height: auto;' src='img/loading.gif' /></center>");
	$("#localidades").hide();
	drs = $('#drs').val();

	if (drs !== null && drs !== undefined && drs !== "") {

		$.post("filtroDRS.php", { 'drs': drs}, function(data){
			$("#result").html(data);
			
		}); 
		
		} else  {
			//alert('teste');
			window.location.reload();
			
		}
}


function Enviarras() {

	$("#result").html("<center><img style='width: auto; height: auto;' src='img/loading.gif' /></center>");
	$("#localidades").hide();
	rras = $('#rras').val();

	if (rras !== null && rras !== undefined && rras !== "") {

		$.post("filtroRRAS.php", { 'rras': rras}, function(data){
			$("#result").html(data);
			
		}); 
		
		} else  {
			
			window.location.reload();
			
		}
}



$( document ).ready(function() {
    $("#ontologia").hide();
    $("#fechar").hide();
    $("#visualizar").click(function() {
 		 $("#ontologia").show();
 		 $("#visualizar").hide();
 		 $("#fechar").show();
	});

	$("#fechar").click(function() {
 		 $("#ontologia").hide();
 		 $("#visualizar").show();
 		 $("#fechar").hide();
	});

	

});

     
$(function() {     

	$('#autocomplete').autocomplete({
    	source:'lib/returnPlace.php',
    	minLength:3
      });

 });