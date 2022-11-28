<?php 
	session_start();
	require_once("config.php");
	$Acode = $_POST["Acode"];
	//$Acode2 = $_POST["Acode2"];
	$Email = $_SESSION["Email"];
	//print "Authenticate code ($Acode) <br>";
	
	//Connect to db
	
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//Verify if Acode exists in DB with matching email
	$query = "Select * From Users Where Email = '$Email' and Acode = '$Acode';";
	$result = mysqli_query($con,$query);
	
	//$query2 = "Select * From Users Where Email = '$Email' and Acode = '$Acode2';";
	//$result2 = mysqli_query($con,$query2);
	
	//if($Acode2 == ""){
	if(!$result){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_num_rows($result) != 1){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Invalid authentication code. Please try again.";
		echo json_encode($_SESSION);
		exit();
	}
	//}
	//if($Acode2 != ""){
	/*if(!$result2){
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Query failed: ".mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	if(mysqli_num_rows($result2) != 1){
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Invalid authentication code 2. Please try again.";
		header("location:../index.php");
		exit();
	}*/
	//}
	//Ready to set password
	$_SESSION["RegState"] = 2;
	$_SESSION["Message"] = "Authentication was successful. Please set password";
	echo json_encode($_SESSION);
	exit();
	
?>