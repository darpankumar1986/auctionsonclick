
		<footer>
				<p><span style="color:#000;"><?php  if(!MOBILE_VIEW) echo  'Powered By:';//BRAND_NAME; ?></span><a style="color:#1776ae; cursor:pointer;" href="http://c1india.com" target="_blank"> C1 India</a></p>
				<!--<div id="clockbox" class="dtime"></div>-->
				<?php $current_date = date('d/m/Y == H:i:s'); ?>
				<!--<p id='demo' class="text-center cal-container" style="color:#000"></p>-->
				
		</footer>
		<?php
			$date = new DateTime();
			$current_timestamp = $date->getTimestamp();
		?>

		<script>
		    flag_time = true;
			timer = '';			
			
			setInterval(function(){updateTimer();},1000);
			
			setInterval(function(){phpJavascriptClock();},1000);
			
			function updateTimer()
			{
				if ( flag_time ) {
					timer = <?php echo $current_timestamp;?>*1000;
					flag_time = false;
				}
				
				if(parseInt(timer) > 0)
				{
					timer = timer + 1000;
				}
			}
			
			function phpJavascriptClock()
			{
				if ( flag_time ) {
					timer = <?php echo $current_timestamp;?>*1000;
					flag_time = false;
				}
				var d = new Date(timer);
                               
				months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
				
				month_array = new Array('January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'Augest', 'September', 'October', 'November', 'December');
				month_array = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
				
				day_array = new Array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
				
				currentYear = d.getFullYear();
				month = d.getMonth();
				var currentMonth = months[month];
				var currentMonth1 = month_array[month];
				var currentDate = d.getDate();
				currentDate = currentDate < 10 ? '0'+currentDate : currentDate;
                                currentDate2 = month < 10 ? '0'+month : month;
                              
				var day = d.getDay();
				current_day = day_array[day];
				var hours = d.getHours();
				var minutes = d.getMinutes();
				var seconds = d.getSeconds();
				
				var ampm = hours >= 12 ? 'PM' : 'AM';
				//hours = hours % 12;
				//hours = hours ? hours : 12; // the hour ’0′ should be ’12′
				minutes = minutes < 10 ? '0'+minutes : minutes;
				seconds = seconds < 10 ? '0'+seconds : seconds;
				var strTime = hours + ':' + minutes+ ':' + seconds;
				
                                //2016-03-08 11:15:00
				//document.getElementById("demo").innerHTML= currentMonth+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				var timeobj = document.getElementById("demo");
				if(timeobj !== undefined && timeobj !==  null)
				{
					document.getElementById("demo").innerHTML=currentYear+'-'+currentMonth1+'-'+currentDate+' '+strTime;
				}
				//document.getElementById("demo1").innerHTML= currentMonth1+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				
				//document.getElementById("demo2").innerHTML= currentDate+':' +(month+1)+':' +currentYear + ' ' + strTime ;
				
				//document.getElementById("demo3").innerHTML= strTime ;
				
				//document.getElementById("demo4").innerHTML= current_day + ' , ' +currentMonth1+' ' + currentDate+' , ' + currentYear + ' ' + strTime ;
				
				
				//flag_time = false;
			}

		</script>		
</body>
</html>
