<?php
	session_start();
	require_once("config.php");//Need to track LOdatetime
	$LODatetime = date("Y-m-d h:i:s");
	$Email = $_SESSION["Email"];
	//print "Logging out... ($Email) ($LODatetime) (".$_SESSION["RememberMe"].") <br>";
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "System Bug: DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//print "DB connected <br>";
	$query = "Update Users Set LODatetime = '$LODatetime' where Email = '$Email';";
	$result = mysqli_query($con,$query);
	if(!result){
		$_SESSION["RegState"]= 4; 
		$_SESSION["Message"] = "Logout query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
	if(mysqli_affected_rows($con) != 1){
		$_SESSION["RegState"]= 4;
		$_SESSION["Message"] = "Logout date time update failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//Check if remember was clicked
	$CookieName = md5("MysteryName77");
	if($_SESSION["RememberMe"] != "remember-me"){
		//Remove check
		setcookie($CookieName, "", time() - 3600, "/");
	}
	$_SESSION["RegState"] = 0;
	echo json_encode($_SESSION);
	exit();
?>