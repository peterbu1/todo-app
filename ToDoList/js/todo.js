var RegState = 0;
$(document).ready(function(){
	$.ajax({
	  type: 'GET',
	  url:'php/readRegState.php',
	  async: false,
	  dataType:'json',
	  encode: true
	}).always(function(data) {
	  console.log(data);
	  
	  RegState = parseInt(data.RegState);
	
	});	
	alert("readRegState return("+RegState+")");	


	if(RegState <= 0){
		$("#signInForm").show();
		$("#registrationForm").hide();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").hide();
		$("#authenticationForm2").hide();	
	}
	if(RegState == 1){
		$("#signInForm").hide();
		$("#registrationForm").show();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").show();
		$("#authenticationForm2").hide();	
	}
	if(RegState == 2){
		$("#signInForm").hide();
		$("#registrationForm").hide();
		$("#setPasswordForm").show();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").hide();
		$("#authenticationForm2").hide();	
	}
	if(RegState == 3){
		$("#signInForm").hide();
		$("#registrationForm").hide();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").show();
		$("#authenticationForm").hide();
		$("#authenticationForm2").show();	
	}
	if(RegState == 4){
		window.location.href = "protected.html";
			 
	}
	$("#registerBtn").click(function(){
		//You can call php/register0.php then reload the window
		$.ajax({
		  type: 'GET',
		  url:'php/register0.php',
		  async: false,
		  dataType:"json",
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  
		  RegState = parseInt(data.RegState);
		});	
		location.reload();
	})
	$(".backToHome").click(function(e){
		$.ajax({
		  type: 'GET',
		  url:'php/backBtn.php',
		  async: false,
		  dataType:"json",
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  
		  RegState = parseInt(data.RegState);
		});	
		location.reload();
	})
	$("#forgotPassword").click(function(e){
		$.ajax({
		  type: 'GET',
		  url:'php/forgotPassword0.php',
		  async: false,
		  dataType:"json",
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  
		  RegState = parseInt(data.RegState);
		});	
		location.reload();
	}) 
	$("#register").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'FirstName' : $('input[name=FirstName]').val(),
			'LastName' : $('input[name=LastName]').val(),
			'Email' : $('input[name=Email]').val()
		};
		//Make Ajax call here
		$.ajax({
		  type: 'GET',
		  url:'php/register.php',
		  async: true,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  $("#signInForm").hide();
		  $("#registrationForm").show();
		  $("#setPasswordForm").hide();
		  $("#resetPasswordForm").hide();
		  $("#authenticationForm").show();
		  $("#authenticationForm2").hide();
		  $("#registerMessage").html(data.Message);
		  return;
		});	
	})
	
	$("#authBtn1").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'Acode' : $('input[name=Acode]').val()
			
		};
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/authenticate.php',
		  async: true,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  if(RegState == 2){
			  $("#signInForm").hide();
			  $("#registrationForm").hide();
			  $("#setPasswordForm").show();
			  $("#resetPasswordForm").hide();
			  $("#authenticationForm").hide();
			  $("#authenticationForm2").hide();
			  $("#setPasswordMessage").html(data.Message);
			  return;
		  }
		  $("#signInForm").hide();
		  $("#registrationForm").show();
		  $("#setPasswordForm").hide();
		  $("#resetPasswordForm").hide();
		  $("#authenticationForm").show();
		  $("#authenticationForm2").hide();
		  $("#authMessage").html(data.Message);
		  return;
		  
		});	
	})
	$("#setPasswordBtn").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'setPassword1' : $('input[name=password1]').val(),
			'setPassword2' : $('input[name=password2]').val()
		};
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/setPassword.php',
		  async: true,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  if(RegState == 0){
			  $("#signInForm").show();
			  $("#registrationForm").hide();
			  $("#setPasswordForm").hide();
			  $("#resetPasswordForm").hide();
			  $("#authenticationForm").hide();
			  $("#authenticationForm2").hide();
			  $("#loginMessage").html(data.Message);
			  return;
		  }
		  $("#signInForm").hide();
		  $("#registrationForm").hide();
		  $("#setPasswordForm").show();
		  $("#resetPasswordForm").hide();
		  $("#authenticationForm").hide();
		  $("#authenticationForm2").hide();
		  $("#setPasswordMessage").html(data.Message);
		  return;
		  
		});	
	})
	$("#sendCode").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'rEmail' : $('input[name=resetEmail]').val()
		};
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/resetPassword.php',
		  async: true,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  $("#signInForm").hide();
		  $("#registrationForm").hide();
		  $("#setPasswordForm").hide();
		  $("#resetPasswordForm").show();
		  $("#authenticationForm").hide();
		  $("#authenticationForm2").show();
		  $("#resetPasswordFormMessage").html(data.Message);
		  return;
		});	
	})
	$("#reAuthBtn").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'Acode' : $('input[name=Acode2]').val()
		};
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/authenticate.php',
		  async: true,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  if(RegState == 2){
			  $("#signInForm").hide();
			  $("#registrationForm").hide();
			  $("#setPasswordForm").show();
			  $("#resetPasswordForm").hide();
			  $("#authenticationForm").hide();
			  $("#authenticationForm2").hide();
			  $("#setPasswordMessage").html(data.Message);
			  return;
		  }
		  $("#signInForm").hide();
		  $("#registrationForm").hide();
		  $("#setPasswordForm").hide();
		  $("#resetPasswordForm").show();
		  $("#authenticationForm").hide();
		  $("#authenticationForm2").show();
		  $("#authMessage2").html(data.Message);
		  
		  return;
		});	
	})
	$("#loginBtn").click(function(e){
		event.preventDefault(e);
		//Get form data items in XML form
		var formData = {
			'loginEmail' : $('input[name=loginEmail]').val(),
			'loginPassword' : $('input[name=loginPassword]').val(),
			'rememberMe' : $("input[name=rememberMe]").is(':checked')? 'remember-me' : ''
			/*if ($('#rememberMe').is(":checked")){
				
			}*/
		};
		//Make Ajax call here
		$.ajax({
		  type: 'POST',
		  url:'php/login.php',
		  async: false,
		  data: formData,
		  dataType:'json',
		  encode: true
		}).always(function(data) {
		  console.log(data);
		  RegState = parseInt(data.RegState);
		  //Define view according to regstate
		  if(RegState == 4){
			  window.location.href = "protected.html";
			 return;
		  }
		  $("#signInForm").show();
		  $("#registrationForm").hide();
		  $("#setPasswordForm").hide();
		  $("#resetPasswordForm").hide();
		  $("#authenticationForm").hide();
		  $("#authenticationForm2").hide();
		  $("#loginMessage").html(data.Message);
		  
		  return;
		});	
	})
})