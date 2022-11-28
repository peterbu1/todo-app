$(document).ready(function(){
	var RegState = 0;
	$.ajax({
	  type: 'GET',
	  url:'php/readRegState.php',
	  async: false,
	  dataType:"json",
	  encode: true
	}).always(function(data) {
	  console.log(data);
	  
	  RegState = parseInt(data.RegState);
	  $("#logOutMessage").html(data.Message);
	  $("#welcomeName").html(data.FirstName + " " + data.LastName);
	});	
	if(RegState != 4){
		window.location.href ="index.html";
	}
	$("#logOutBtn").click(function(e){
		
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/logout.php',
		  async: true,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  if(RegState == 0){
			window.location.href = "index.html";
		   
		  }
		   $("#logOutMessage").html(data.Message);
		});	
		return;
	})
})