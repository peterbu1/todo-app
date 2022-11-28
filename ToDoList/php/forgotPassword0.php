<?php
	session_start();
	$_SESSION["RegState"] = 3;
	echo $_SESSION["RegState"];
	exit();
?>