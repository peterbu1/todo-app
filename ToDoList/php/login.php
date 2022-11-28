<?php

	session_start();
	$SessionId = session_id();
	require_once("config.php");
	//Get webdata
	
	
	//Connect to db
	
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
	    echo json_encode($_SESSION);
		exit();
	}
	//print "DB connected <br>";
	//Check if the cookies is present ...
	$Email = mysqli_real_escape_string($con,$_POST["loginEmail"]);
	$Password = mysqli_real_escape_string($con,md5($_POST["loginPassword"]));
	$_SESSION["RememberMe"] = mysqli_real_escape_string($con,$_POST["rememberMe"]);
	//print "Webdata ($Email) ($Password) ($RememberMe) <br>";
	//Create cookie and new SessionID
	//What is the cookie name
	$CookieName = md5("MysteryName77");
	if(isset($_COOKIE[$CookieName])){
		$CookieContent = $_COOKIE[$CookieName];
		
		//What should be the cookie content
		//print "Cookie content : ($CookieContent) <br>";
		//Check email and password unique exists in DB.
		$query = "Select * From Users Where Email = '$Email' and CookieContent = '$CookieContent';";
		$result = mysqli_query($con,$query);
		if(!result){
			$_SESSION["RegState"]= 0;
			$_SESSION["Message"] = "System bug: Cookie query failed ".mysqli_error($con);
			echo json_encode($_SESSION);
			exit();
		}
		if(mysqli_num_rows($result) == 1){
			$_SESSION["RegState"]= 4;
			$_SESSION["Message"] = "Login based on cookie content. ";
			$Ldatetime = date("Y-m-d h:i:s");
			$row = mysqli_fetch_assoc($result);
			//print "Login Success";
			$_SESSION["FirstName"] = $row["FirstName"];
			$_SESSION["LastName"] = $row["LastName"];
			$_SESSION["Email"] = $row["Email"];
			echo json_encode($_SESSION);
			exit();
		}
		
		
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Cookie content check failed. Regular login";
		
	}
		
	
	
	$query = "Select * From Users Where Email = '$Email' and Password = '$Password';";
	$result = mysqli_query($con,$query);
	if(!result){
		$_SESSION["RegState"]= 0;
		$_SESSION["Message"] = "System bug: Login query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_num_rows($result) != 1){
		$_SESSION["RegState"]= 0;
		$_SESSION["Message"] = "Login failed. Either email or password is incorrect. ";
		echo json_encode($_SESSION);
		exit();
	}
	setcookie($CookieName, $SessionId,time() + (86400), "/"); // 86400 sec = 1 day
	//print "Login Success";
	$Ldatetime = date("Y-m-d h:i:s");
	
	$row = mysqli_fetch_assoc($result);
	$_SESSION["FirstName"] = $row["FirstName"];
	$_SESSION["LastName"] = $row["LastName"];
	$_SESSION["Email"] = $Email;
	$_SESSION["RegState"] = 4; //Logged in
	$_SESSION["Message"] = "Login success.";
	
	$query = "Update Users Set CookieContent = '$SessionId', LDatetime = '$Ldatetime' Where Email = '$Email';";
	$result = mysqli_query($con,$query);
	if(!result){
		$_SESSION["RegState"]= 0;
		$_SESSION["Message"] = "System Bug: Login cookie update query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
	if(mysqli_affected_rows($con) != 1){
		$_SESSION["RegState"]= 0;
		$_SESSION["Message"] = "System bug: Login cookie update failed.";
		echo json_encode($_SESSION);
		exit();
	}
	
	echo json_encode($_SESSION);
	exit();
?>