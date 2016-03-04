
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

            
       