<?php
	session_start();
	//Need DB credentials
	require_once("config.php");
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require '../../PHPMailer-master/src/Exception.php';
	require '../../PHPMailer-master/src/PHPMailer.php';
	require '../../PHPMailer-master/src/SMTP.php';

	//connecting to db
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if(!$con){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "DB connection failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//print "DATABASE connected <br>";
	// Get webdata
	$FirstName = mysqli_real_escape_string($con,$_GET["FirstName"]);
	$LastName = mysqli_real_escape_string($con,$_GET["LastName"]);
	$Email = mysqli_real_escape_string($con,$_GET["Email"]);
	
	//print "Webdata ($Email) ($FirstName) ($LastName) <br>";
	// Insert into DB
	$Rdatetime = date("Y-m-d h:i:s");
	$Acode = rand(100000,999999);
	$query = "INSERT INTO Users(FirstName, LastName, Email, Rdatetime, Acode, Status) 
	values('$FirstName','$LastName','$Email', '$Rdatetime', '$Acode', 0)";
	$result = mysqli_query($con, $query);
	
	if(!$result){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Query failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	if(mysqli_affected_rows($con) != 1){
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Query insert failed: ".mysqli_error($con);
		echo json_encode($_SESSION);
		exit();
	}
	//print "Record added... Ready to send email ...<br>";
	//Email Password: gwjxwwnnakttrjdm
	
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
		$msg = "Welcome to ToDoList. Here is your Authentication code $Acode. Please complete registration on site.";
		$mail->addAddress($Email,$FirstName,$LastName);
		$mail->Subject = "ToDoList";
		$mail->Body = $msg;
		$mail->send();
		
		$_SESSION["RegState"] = 1;
		$_SESSION["Message"] = "Email sent to $Email.";
		$_SESSION["Email"] = $Email;
		
		//print "Email sent ... <br>";
		
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = 1;
		//print "Mail send failed: ".$e->errorMessage;		
	}
	echo json_encode($_SESSION);

	exit();
?>