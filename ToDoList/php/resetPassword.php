<?php
	session_start();
	require_once("config.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require '../../PHPMailer-master/src/Exception.php';
	require '../../PHPMailer-master/src/PHPMailer.php';
	require '../../PHPMailer-master/src/SMTP.php';
	//Get web data
	//$Email = $_SESSION["Email"];
	$Email = $_POST["rEmail"];
	
	
	//Connect to db
	
	$con = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	
	
	
	$query1 = "Select * From Users Where Email = '$Email';";
	$result1 = mysqli_query($con,$query1);
	
	if(!$result1){
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_num_rows($result1) != 1){
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Invalid email: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	$row = mysqli_fetch_assoc($result1);
			
	$FirstName = $row["FirstName"];
	$LastName = $row["LastName"];
	
	//Set adatetime
	//$Adatetime = date("Y-m-d h:i:s");
	$Acode = rand(100000,999999);
	$query = "Update Users Set Acode = '$Acode' Where Email = '$Email';";
	$result = mysqli_query($con,$query);
	
	if(!$result){
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Update query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) == 0){
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Update failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	$_SESSION["Email"] = $Email;
	// Build the PHPMailer object:
	$mail= new PHPMailer(true);
	try { 
		$mail->SMTPDebug = 0; // Wants to see all errors
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username="todolistapp4@gmail.com";
		$mail->Password = "uzieqvwgirfasshl";
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("tuj23563@temple.edu", "Tobe Jaison");
		$mail->addReplyTo("tuj23563@temple.edu","Tobe Jaison");
		$msg = "Here is your reset password Authentication code $Acode. Please enter authentication code on site.";
		$mail->addAddress($Email,$FirstName,$LastName);
		$mail->Subject = "ToDoList";
		$mail->Body = $msg;
		$mail->send();
		
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Email sent to $Email.";
       // print "Email sent ... <br>";		
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = 3;
		//print "Mail send failed: ".$e->errorMessage;		
	}
	echo json_encode($_SESSION);

	exit();
?>