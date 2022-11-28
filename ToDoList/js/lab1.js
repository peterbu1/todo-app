$(document).ready(function(){
	var startBtn_state = 0; // For the start/pause/reset button
	var snoozeResetBtnState = 0;
	var time_state = 0;
	var countdownMSeconds;
	var countDownDateTime;
	var timeTracker, current, days, hours, minutes, seconds, milliSeconds;
	
	var alarmSound = document.createElement('audio');
	alarmSound.setAttribute('src','sounds/cool_alarm.mp3');
	//Setting the default date and time
	
	current = new Date(); //Lines 13-28 is to get the current date. It's outside the setInterval so that the date
	                      //doesn't keep reset to the current date when selescting another date for the event.
	var month = current.getMonth()+1;
	var day = current.getDate();
	var year = current.getFullYear();
	var fullDate = function(){
		
		if (month < 10){
			month = '0' + month;
		}
		if (day < 10){
			day = '0' + day;
		}
		return year + '-' + month + '-' + day;
	}; 
	
	$("#eventDate").val(fullDate);
	var time = function(){
		current = new Date();//This get the current date and time every second. This is to get the current time as every
							 //second goes up.
		minutes = current.getMinutes();
		seconds = current.getSeconds();
		hours = current.getHours();
		
		
		if (minutes < 10){
			minutes = '0' + minutes;
		}
		if (seconds < 10){
			seconds = '0' + seconds;
		}
		if (hours < 10){
			hours = '0' + hours;
		}
			
		
		return hours + ':' + minutes + ':' + seconds;
		
		
	};
	$("#eventTime").val(time);
	var getCurrentTime = setInterval(function(){
				$("#now").text(time);
			},1000);
	
	
	
	$("#setEventDateBtn").click(function(){
		var date = $("#eventDate").val();
		var time2 = $("#eventTime").val();
		countDownDateTime = new Date(date + " " + time2);
		//If user clicks on set event date button while the time values are all not 0 alert a message.
		//Finish 9/11/22
		
		if(startBtn_state == 1 || startBtn_state == 2 || startBtn_state == 3){
			alert("Can't set the event date while time values are all not 0 and when the alarm is still sounding.");
			return;
		}
		
		
		current = new Date();
		//Math.abs(countDownDateTime - current)/1000
		var daysCount = countDownDateTime - current;
		if(daysCount < 0){
			alert("Event date can not be negative [" +daysCount+"]");
			return;
		}
		alert("Count down time is " + countDownDateTime);
		var daysCalc = (1000*60*60*24);
		var hoursCalc = (1000*60*60);
		var minutesCalc = (1000*60);
		var secondsCalc = 1000;
		
		days = (daysCount/daysCalc);
		hours = ((daysCount%daysCalc)/hoursCalc);
		minutes = ((daysCount%hoursCalc)/minutesCalc);
		seconds = ((daysCount%minutesCalc)/secondsCalc);
		
		$("#days").val(Math.floor(days));
		$("#hours").val(Math.floor(hours));
		$("#minutes").val(Math.floor(minutes));		
		$("#seconds").val(Math.floor(seconds));
		$("#milliSeconds").val(0);
		return;
	});
	
	function decreaseTime(){
		timeTracker = setInterval(function(){
				
					countdownMSeconds -= 10; //Decreasing down time by 10 seconds
					var daysCalc = (1000*60*60*24);
					var hoursCalc = (1000*60*60);
					var minutesCalc = (1000*60);
					var secondsCalc = 1000;
				
					days = (countdownMSeconds/daysCalc);
					hours = ((countdownMSeconds%daysCalc)/hoursCalc);
					minutes = ((countdownMSeconds%hoursCalc)/minutesCalc);
					seconds = ((countdownMSeconds%minutesCalc)/secondsCalc);
					milliSeconds = (countdownMSeconds%secondsCalc);
					
					$("#days").val(Math.floor(days));
					$("#hours").val(Math.floor(hours));
					$("#minutes").val(Math.floor(minutes));		
					$("#seconds").val(Math.floor(seconds));
					$("#milliSeconds").val(Math.floor(milliSeconds));
					
					if (countdownMSeconds < 0){
						$("#days").val(0);
						$("#hours").val(0);
						$("#minutes").val(0);		
						$("#seconds").val(0);
						$("#milliSeconds").val(0);
						clearInterval(timeTracker);
						
						time_state = 0;
						startBtn_state = 3;
						snoozeResetBtnState = 1;
						$("#snoozeResetBtn").html("Snooze");
						alarmSound.play();
						alarmSound.onended = function() {//As long as the quiet button is not clicked on continuosly play
							alarmSound.play();           // the alarm sound
						};
						
						$("#startBtn").html("Quiet");
					}
				
				},10);//looping the timeTracker function every ten seconds to count down time
		$("#startBtn").html("Pause");
		return; //Returning nothing
	}
	$("#startBtn").click(function(){
		//startBtn states 0: play , 1:pause , 2 :resume and 3:Quiet
		if(startBtn_state == 0){
			startBtn_state = 1;
			
			if($("#days").val() == 0 && $("#hours").val() == 0 && $("#minutes").val() == 0 && 
			$("#seconds").val() == 0 && $("#milliSeconds").val() == 0){
				//If all the time values are 0 do the below code
				alert("Days,hours,minutes,seconds and milliSeconds can't all be 0. One of them must have a value greater than 0.");
				startBtn_state = 0;
				return;
			}
			
			
		    
			if(time_state == 1){ // If user enter time values recalculate the time values
				countdownMSeconds = $("#days").val() * (1000*60*60*24) + $("#hours").val()*(1000 *60*60)+
				$("#minutes").val() *(1000 * 60) + $("#seconds").val() * 1000;
			}
			else{//If user clicks on set event date perform the code in the else
				var curr = new Date();
				countdownMSeconds = countDownDateTime - curr;
			}
			decreaseTime();
			return;
			
		}
		if(startBtn_state == 1){
			startBtn_state = 2;
			//Code btn function
			clearInterval(timeTracker);//Pausing the count down
			$("#startBtn").html("Resume");
			return;
		}
		if(startBtn_state == 2){
			startBtn_state = 1;
			//Code btn function
			
			decreaseTime();
					
			return;
		}
		if(startBtn_state == 3){
			startBtn_state = 0;
			snoozeResetBtnState = 0;
			time_state = 0;
			alarmSound.pause();//Stopping the alarm sound
			//Code btn function
			$("#startBtn").html("Start");
			$("#snoozeResetBtn").html("Reset");
			return;
		}
		
		
	});
	$("#snoozeResetBtn").click(function(){
		if(snoozeResetBtnState == 0){//Code in the if is to reset
			location.reload();
		}
		if(snoozeResetBtnState == 1){//Code for snoozing
			alarmSound.pause();
			countdownMSeconds = 60000; //60 seconds
			$("#days").val(0);
			$("#hours").val(0);
			$("#minutes").val(1);		
			$("#seconds").val(0);
			$("#milliSeconds").val(0);
			startBtn_state = 1;
			snoozeResetBtnState = 0;
			$("#startBtn").html("Pause");
			$("#snoozeResetBtn").html("Reset");
			
			decreaseTime();
			return;
			
			
		}
		
	});
	$(".time").focusin(function(){
		time_state = 1;
		
		
		if($("#days").val() == 0 && $("#hours").val() == 0 && $("#minutes").val() == 0 && 
			$("#seconds").val() == 0 && $("#milliSeconds").val() == 0){
			//Reset alarm clock if user clicked in a text box	
			startBtn_state = 0;
			alarmSound.pause();
			snoozeResetBtnState = 0;
			$("#startBtn").html("Start");
			$("#snoozeResetBtn").html("Reset");
			
		}
		
		$("#days").val(0);
		$("#hours").val(0);
		$("#minutes").val(0);		
		$("#seconds").val(0);
		$("#milliSeconds").val(0);
		
		if(startBtn_state == 1 || startBtn_state == 2){
			//Reset clock if user clicked in the textbox while count down has not finished
			clearInterval(timeTracker);
			startBtn_state = 0;
			snoozeResetBtnState = 0;
			$("#startBtn").html("Start");
			$("#snoozeResetBtn").html("Reset");
			return;
		}
		
		$(".time").css("border-color","red");
	});
	
	$(".time").focusout(function(){
		$(".time").css("border-color","");//Removing border color when user clicks out of the textbox
	});
})