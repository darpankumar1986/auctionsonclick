<?php
date_default_timezone_set("Asia/Calcutta");
$current_timestamp = round(microtime(true) * 1000);
//echo date("Y-m-d H:i:s",);
?>

				
		<p id='demo' class="text-center cal-container" style="font-family:'Open Sans', Arial;color:#000;font-size: 13px;font-weight: bold;text-align: left;/* width: 100%; */"><?php echo date("d-m-Y H:i:s");?></p>
				
				<?php /* ?>
<div id="msg" class="text-center cal-container" style="color:#000"><?php echo date("Y-m-d H:i:s");?></div>
		<?php */ ?>

		<?php //$current_timestamp = time();?>

		<script>
		    flag_time = true;
			timer = '';			
			td = "";
			
			setInterval(function(){phpJavascriptClock();},50);
			
			setInterval(function(){
				var rand = Math.random() * 10000000000000;
				location.href = "?rand="+rand;
			},60000);
			
	
			
			function phpJavascriptClock123()
			{
				if ( flag_time ) {
					var d = new Date();
					var n = d.getTime();
					var d1 = d;
					var utcTime = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(), d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
					n = utcTime.getTime() + 19800000;

					timer = <?php echo $current_timestamp;?>;					
					td = parseInt(timer) - parseInt(n);
					flag_time = false;
					//alert(td);			
				}
//				alert(td);
				var d = new Date();
				//var d1 = d;
				var n = d.getTime();
				var d = new Date(n+td);
				//alert(d1+"|"+d);

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
				
				//flag_time = false;
			}
			
			flag_time1 = true;
			timer1 = 0;
			
			setInterval(function(){
				if(timer1 > 0)
				{
					timer1 = timer1 + 1000;
				}
			},1000);
			
			function phpJavascriptClock()
			{
				if ( flag_time1 ) {
					timer1 = <?php echo $current_timestamp;?>;
					//timer1 = "<?php echo date('Y').",".date('m').",".date('d').",".date('H').",".date('i').",".date('s'); ?>";
				}
				//alert(timer1);
				var d = new Date(timer1);
				//console.log(d.getTime());
				d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 + 19800000);
				//var d = new Date(Date.UTC(<?php echo date('Y').",".date('m').",".date('d').",".date('H').",".date('i').",".date('s'); ?>));
				//alert(d);
				//d.getTimezone() => 'Asia/Calcutta';
				//d.setTimezone('Asia/Calcutta');
				//alert(d);
				
                               
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
				//timer1 = timer1 + 1000;
                
				//document.getElementById("demo").innerHTML=currentYear+'-'+currentMonth1+'-'+currentDate+' '+strTime;
				document.getElementById("demo").innerHTML=currentDate+'-'+currentMonth1+'-'+currentYear+' '+strTime;
				flag_time1 = false;
			}
		</script>


	<?Php

//*****************************************
// ini_set('display_errors', true);//Set this display to display  all erros while testing and developing the script
//////////////////////////////
?>


<script type="text/javascript">

//setInterval(function(){timer_function();},1000);

function AjaxFunction()
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
document.getElementById("msg").innerHTML=httpxml.responseText;
      }
    }
	var url="<?php echo base_url(); ?>server_date/ajaxserverclockdemock";
url=url+"?sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
tt=timer_function();
  }

///////////////////////////
function timer_function(){
var refresh=1000; // Refresh rate in milli seconds
//mytime=setTimeout('AjaxFunction();',refresh)
}


</script>



<!--
<input type=button value='Get Server Time' onclick="timer_function();">-->
