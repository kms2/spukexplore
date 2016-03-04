$( document ).ready(function() {
  // Handler for .ready() called.
  $("#doenca").change(function() {
  	if($("#doenca").val() == "Tuberculose A16.9" ){
  		console.log("estou aqui");
  		alert("Funcionou");
  	}
    doenca = $("#doeca").val();
       
      
  });


});
