<?php
	session_start();
	$_SESSION["RegState"] = 1;
	//Redirect to index.php
	echo $_SESSION["RegState"];
	exit();
?>