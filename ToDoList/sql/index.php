<?php
	session_start();
	if(!isset($_SESSION["RegState"])) $_SESSION["RegState"] = 0;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>CIS3342 Lab2 Tobe</title>

    

    

    

	<link href="css/bootstrap.min.css" rel="stylesheet">

   
	<link rel="icon" href="images/favicon.ico">
	<meta name="theme-color" content="#712cf9">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
    
	<main class="form-signin w-100 m-auto">
<?php
	if($_SESSION["RegState"] <= 0){
?>	
	  <form id = "signInForm" action = "php/login.php" method = "POST">
		<img class="mb-4" src="images/favicon.ico" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

		<div class="form-floating">
		  <input type="email" class="form-control" name = "loginEmail" id="loginEmail" placeholder="name@example.com">
		  <label for="loginEmail">Email address</label>
		</div>
		<div class="form-floating">
		  <input type="password" class="form-control" name = "loginPassword" id="loginPassword" placeholder="Password">
		  <label for="loginPassword">Password</label>
		</div>

		<div class="checkbox mb-3">
		  <label>
			<input type="checkbox" value="remember-me"> Remember me
		  </label>
		</div>
		
		<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		<div id = "loginMessage" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<br>
		<a href = "php/register0.php">Register</a> | <a href = "php/forgotPassword0.php">Forgot Password?</a>
	  </form>
<?php
	}
	if($_SESSION["RegState"] == 1){
?>
	  <form id = "registrationForm" action = "php/register.php" method = "GET">
		<img class="mb-4" src="images/favicon.ico" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please register</h1>

		<div class="form-floating">
		  <input type="text" class="form-control" name = "FirstName" id="FirstName" placeholder="First Name">
		  <label for="FirstName">First Name</label>
		</div>
		<div class="form-floating">
		  <input type="text" class="form-control" name = "LastName" id="LastName" placeholder="Last Name">
		  <label for="LastName">Last Name</label>
		</div>
		<div class="form-floating">
		  <input type="email" class="form-control" name = "Email" id="Email" placeholder="example@gmail.com">
		  <label for="Email">Email</label>
		</div>

		<button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
		<div id = "registerMessage" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<br>
		<a href = "php/backBtn.php">Back</a>
	  </form>
	  <form id = "authenticationForm" action = "php/authenticate.php" method = "POST">
		<h1 class="h3 mb-3 fw-normal">Please enter authentication code</h1>
		<div class="form-floating">
			<input type="text" class="form-control" name = "Acode" id="aCode" placeholder="Authorization code">
			<label for="aCode">Authentication code</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Authenticate</button>
	    <div id = "authenticationMessage" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
	  </form>
<?php
	}
	if($_SESSION["RegState"] == 2){
?>	  
	  <form id = "setPasswordForm" action = "php/setPassword.php" method = "POST">
		<img class="mb-4" src="images/favicon.ico" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Please set password</h1>

		<div class="form-floating">
		  <input type="password" class="form-control" name = "password1" id="setPassword1" placeholder="New Password">
		  <label for="Password">Password</label>
		</div>
		<div class="form-floating">
		  <input type="password" class="form-control" name = "password2" id="setPassword2" placeholder="Confirm Password">
		  <label for="Password2">Confirm Password</label>
		</div>

		<button class="w-100 btn btn-lg btn-primary" type="submit">Set Password</button>
		<div id = "setPasswordMessage" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div><br>
		<a href = "php/homeBtn.php">Home</a> 
	  </form>
<?php
	}
	if($_SESSION["RegState"] == 3){
?> 
	  <form id = "resetPasswordForm" action = "php/resetPassword.php" method = "POST">
		<img class="mb-4" src="images/favicon.ico" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Enter Email to get authentication code</h1>

		<div class="form-floating">
		  <input type="email" class="form-control" name = "resetEmail"id="resetPasswordEmail" placeholder="Email">
		  <label for="resetPasswordEmail">Email</label>
		</div>
		
		<button class="w-100 btn btn-lg btn-primary" type="submit">Send code</button>
		<div id = "newPasswordMessage" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<br>
		<a href = "php/homeBtn.php">Home</a> 
	  </form>
<?php
	}
	if($_SESSION["RegState"] == 4){
?>
	 <form id = "authenticationForm2" action = "php/authenticate.php" method = "POST">
		<h1 class="h3 mb-3 fw-normal">Enter authentication code</h1>

		<div class="form-floating">
			<input type="text" class="form-control" name = "Acode2" id="aCode2" placeholder="Authorization code">
			<label for="aCode2">Authentication code</label>
		</div>
		
		<button class="w-100 btn btn-lg btn-primary" type="submit">Authenticate</button>
		<div id = "authenticationMessage2" class = "btn btn-info">
			<?php
				print $_SESSION["Message"];
				$_SESSION["Message"] = "";
			?>
		</div>
		<br>
		<a href = "php/homeBtn.php">Home</a> 
	  </form>
<?php
	}
?>		  
	</main>


    
</body>
</html>
