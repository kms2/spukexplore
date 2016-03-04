
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

            
       