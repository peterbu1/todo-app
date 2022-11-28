<?php
	session_start();
	if($_SESSION["RegState"] != 5){
		$_SESSION["RegState"] = 0;
		$_SESSION["Message"] = "Please login or register";
		header("location:index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href = "css/bootstrap.min.css" rel="stylesheet">
	
	<link href = "images/favicon.ico" rel="shortcut icon" type= "image/x-icon">
	<script src = "js/jquery-3.6.1.min.js"></script>
	<script src = "js/bootstrap.bundle.min.js"></script>
	<link href = "css/lab1.css" rel="stylesheet">
	<script src = "js/lab1.js"></script>
	<title>Alarm Clock</title>
</head>
<body>
    <a href = "php/logout.php">
		<button class = "text-center btn btn-outline-warning" id = "logOutBtn">
			Logout
		</button>
	</a>
	<div id = "timeContainer" class = "mw-auto w-50 p-3">
		<h1>
		
			Welcome
			<?php
				print $_SESSION["FirstName"];
				print " ";
				print $_SESSION["LastName"];
			?><br>
			Current Time: 
		</h1>
		
		<h3 id = "now"></h3>
	
	</div>
        <div class="mw-auto w-auto p-3">
			<div class="mw-auto w-auto p-3">
				<table class = "table table-responsive mw-auto w-auto p-3">
				    <tr class = "w-auto p-3">
						<td colspan="5">Alarm Clock</td>
		            </tr>
					<tr class = "w-auto p-3">	
						<td colspan = "5" class = "w-auto p-3">
							<input class = "w-auto" type = "date" id = "eventDate">
							<input class = "w-auto" type = "time" id = "eventTime">
							<button class = "btn btn btn-outline-primary" id = "setEventDateBtn">Set Event Date</button>
						</td>
					</tr>

					<tr class = "w-auto p-3">
						<td class = "w-auto p-3"><input class = "time" id = "days" type = "number" value="0" max="365" size = "1"></td>
						<td class = "w-auto p-3"><input class = "time" id = "hours" type = "number" value="0" max="23" size = "1"></td>
						<td class = "w-auto p-3"><input class = "time" id = "minutes" type = "number" value="0" max="59" size = "1"></td>
						<td class = "w-auto p-3"><input class = "time" id = "seconds" type = "number" value="0" max="59" size = "1"></td>
						<td class = "w-auto p-3"><input class = "time" id = "milliSeconds" value="0" size = "5"></td>
					</tr>
					<tr class = "w-auto p-3">
						<td class = "w-auto p-3"><span class = "">Days</span></td>
						<td class = "w-auto p-3"><span class = "">Hours</span></td>
						<td class = "w-auto p-3"><span class = "">Minutes</span></td>
						<td class = "w-auto p-3"><span class = "">Seconds</span></td>
						<td><span class = "">Milliseconds</span></td>
					</tr>

					<tr class = "w-auto p-3">
						<td colspan = "5" class = "w-auto p-3">
							<button class = "btn btn btn-outline-success col-2" id = "startBtn">Start</button>
							<button class = "btn btn btn-outline-info col-2" id = "snoozeResetBtn">Reset</button>
						</td>
					</tr>
				</table>
            </div>
		</div>
</body>
</html>
