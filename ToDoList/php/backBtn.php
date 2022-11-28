<?php
	session_start();
	$_SESSION["RegState"] = 0;
	//echo $_SESSION["RegState"];
	echo json_encode($_SESSION);
	exit();
?>