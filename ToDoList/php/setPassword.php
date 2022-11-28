<?php
	session_start();
	require_once("config.php");
	//Get web data
	$Password1 = md5($_POST["setPassword1"]);
	$Password2 = md5($_POST["setPassword2"]);
	

	//Connect to db
	if($Password1 != $Password2){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Passwords don't match. Please try again.";
		echo json_encode($_SESSION);
		exit();
	}
	
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
	$Email = $_SESSION["Email"];
	//Set adatetime
	$Adatetime = date("Y-m-d h:i:s");
	$Acode = rand(100000,999999);
	
	$query = "Update Users Set Password = '$Password1', Acode = '$Acode', Adatetime = '$Adatetime',PswdChanges = PswdChanges + 1 Where Email = '$Email';";
	$result = mysqli_query($con,$query);
	
	if(!$result){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) == 0){
		$_SESSION["RegState"] = 2;
		$_SESSION["Message"] = "Update query2 failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
   
	$_SESSION["RegState"] = 0;
	$_SESSION["Message"] = "Password has been set. Please login.";
	echo json_encode($_SESSION);
	exit();
?>