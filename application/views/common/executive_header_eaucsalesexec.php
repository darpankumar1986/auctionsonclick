<?php
header("cache-Control: private,no-cache,no-store,pre-check=0,post-check=0,must-revalidate,max-age=0");
//header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo JDA_TITLE; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?=  base_url();?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
<link href="<?=  base_url();?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">
<!--<link rel="stylesheet" href="<?=  base_url();?>bankeauc/css/tables.css">-->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/common.js"></script>
<!--[if lt IE 9]>
    <script type="text/javascript" 
        src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
<![endif]-->
<?php /*?>
<script type="text/javascript">
var tmonth=new Array("1","2","3","4","5","6","7","8","9","10","11","12");

function GetClock(){
var d=new Date();
var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
if(nyear<1000) nyear+=1900;

var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
if(nmin<=9) nmin="0"+nmin
if(nsec<=9) nsec="0"+nsec;
document.getElementById("clockbox").innerHTML=currentYear+'-'+currentDate2+'-'+currentDate+' '+strTime;
				
//document.getElementById('clockbox').innerHTML=""+tmonth[nmonth]+"/"+" "+ndate+"/ "+nyear+" "+nhour+":"+nmin+":"+nsec+"";
}

window.onload=function(){
GetClock();
setInterval(GetClock,1000);
}
</script>
<?php */ ?>
<?php
			$date = new DateTime();
			$current_timestamp = $date->getTimestamp();
		?>

		<script>
		    flag_time1 = true;
			timer1 = '';
			//setInterval(function(){phpJavascriptClock1();},1000);
			
			function phpJavascriptClock1()
			{
				if ( flag_time1 ) {
				timer1 = <?php echo $current_timestamp;?>*1000;
				}
				var d = new Date(timer1);
                               
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
				timer1 = timer1 + 1000;
				document.getElementById("clockbox").innerHTML=currentYear+'-'+currentMonth1+'-'+currentDate+' '+strTime;
				flag_time1 = false;
			}

		</script>
	
</head>
<?php
	  $user_type=$this->session->userdata('user_type');
	  $userid=$this->session->userdata('id');
	  $full_name =GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
	  ?>
<body>
<header><!--============================header==================================-->
		<section class="header_wrapper">
						<div class="header_top">
					<div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>								
								<div class="header_right">
										<label for="show-menu" class="show-menu">&nbsp;</label>
										<input type="checkbox" id="show-menu" role="button">
										<ul id="menu">
										   <!-- <li><a href="">About us</a></li>-->
											<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>
											<!--<li><a href="">Help Desk</a></li>-->
											<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>
											<?php  if($userid>0){ ?>
											<li><a href="<?=  base_url();?>registration/logout">Logout</a></li>
											<?php } ?>
										</ul>
								</div>
						</div>
						<!--============================login end==================================-->
		</section>
</header>

		<!--<div class="box-head1 no_border">
			<div class="container_12">
                            <?php /* if($userid>0){ ?>
                             <h2>Welcome,<?php echo ucfirst($full_name);?></h2>
                                <?php } */ ?>
				
			</div>
	   </div>-->
<div class="box-head1 no_border">
<div class="container_12">
    <?php  if($userid>0){ ?>
    <h2>Welcome,<?php echo ucfirst($full_name);?></h2>
    <?php } ?>
		
        <span class="flt_rgt">
								<a href="<?=  base_url();?>helpdesk_executive/" style="color:#fff;font-size:12px;">Dashboard</a>
                                <select name="ddlLogin" id="ddlLogin" title="Select Link"  onchange="location = this.options[this.selectedIndex].value;">
                                <option value="1">Select Link</option>
                                
                                <!--<option value="<?=  base_url();?>helpdesk_executive/addEventBidder">Add Auction Bidder</option>-->
                                <!--<option value="<?=  base_url();?>helpdesk_executive/manageLoggedEvents">Manage Logged Events</option>-->
                                <option value="<?=  base_url();?>helpdesk_executive/createLoggedEvents">Create Logged Events</option>
                                <!--<option value="<?=  base_url();?>helpdesk_executive/Search">Search</option>-->
                                <option value="<?=  base_url();?>helpdesk_executive/saveLoggedEvents">Saved Logged Events</option>
                                <option value="<?=  base_url();?>helpdesk_executive/completeReports">Complete Reports</option>
                                <option value="<?=  base_url();?>helpdesk_executive/manageLimitedAccessEvents">Limited User Events</option>
                </select>
        </span>
</div>
</div>
