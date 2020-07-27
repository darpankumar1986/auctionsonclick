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
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= base_url(); ?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url(); ?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?= base_url(); ?>bankeauc/css/jquery-ui.css">
        <!--[if lt IE 9]>
            <script type="text/javascript" 
                src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
            </script>
        <![endif]-->
        <script type="text/javascript" src="<?= base_url(); ?>bankeauc/js/sortable.js"></script>
        <script src="<?= base_url(); ?>bankeauc/js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>bankeauc/js/global.js" type="text/javascript"></script>
        <script type="text/javascript" src="/js/common.js"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js?rand=1"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js?rand=1"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js?rand=1"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css?rand=1">
       <script type="text/javascript">
        function noBack()
         {
             window.history.forward()
         }
        noBack();
        window.onload = noBack;
        window.onpageshow = function(evt) { if (evt.persisted) noBack() }
        window.onunload = function() { void (0) }
    </script>
    <?php if(MOBILE_VIEW) { ?>
    <style>    
    header { position: fixed; top:0; left:0; width: 100%;  z-index:9999;}	
	.top100mrgn{margin-top:70px;}
	</style>
    <?php }?>
        <script>    <?php
			$date = new DateTime();
			$current_timestamp = $date->getTimestamp();
		?>
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
				minutes = minutes < 10 ? '0'+minutes : minutes;
				seconds = seconds < 10 ? '0'+seconds : seconds;
				var strTime = hours + ':' + minutes+ ':' + seconds;
				timer1 = timer1 + 1000;
				document.getElementById("clockbox").innerHTML=currentYear+'-'+currentMonth1+'-'+currentDate+' '+strTime;
				flag_time1 = false;
			}

		</script>
        
        <style>
            .sortable .icon{margin-left:0;}
            .logo-text{padding: 14px 0 0 15px !important;}
        </style>
    </head>
    <body>
        <header>
            <?php
            //validate user
            $user_type = $this->session->userdata('user_type');
            $userid = $this->session->userdata('id');
            
            $this->db->select('first_name,email_id,organisation_name,register_as,user_sess_val,last_name');
            $this->db->where('id',$userid);
            $query=$this->db->get('tbl_user_registration');
            $row=$query->result();
           // echo "<pre>"; print_r($row); echo "</pre>";
            if(!empty($row)){
                    //case User is a Company
                   if($row[0]->register_as=='builder'){
                    $full_name=$row[0]->organisation_name;
                     }else{
                     //case User is an Individual
                     $full_name=$row[0]->first_name.' '.$row[0]->last_name;
                     }
                     $bidder_email_id = $row[0]->email_id;
                    //case logout if another user is looged in
                    $session_id = $this->session->userdata('session_id_user');
                   if($row[0]->user_sess_val !=  $session_id){
					   //echo $row[0]->user_sess_val."|".$session_id;die;
                       header('Location:'.  base_url().'registration/logout');
                       exit();
                    }
            }
        ?>
            <!--============================header==================================-->
            <section class="header_wrapper">
                <div class="header_top">
                    <div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>                    
                    </div>
                    <div class="header_right">
                        <label for="show-menu" class="show-menu">&nbsp;</label>
                        <input type="checkbox" id="show-menu" role="button">                        
                        <ul id="menu">
                           <!--<li><a href="<?=base_url();?>faq.html" target="_blank">FAQs</a></li>-->
                           <!-- <li><a href="<?=base_url(); ?>owner/myProfileChangePassword">Change Password</a></li>
                            <li><a href="<?=base_url(); ?>owner/myProfile">Edit Profile</a></li>-->
                            <!--<li><a href="<?=base_url();?>contactus.html" target="_blank">Contact Us</a></li>-->
                            <?php if ($userid > 0){ 
								if(MOBILE_VIEW){?>
									<li><a href="<?php echo base_url();?>owner"><img src="<?php echo base_url()?>bankeauc/images/home2.png" alt="Home" style="width:22px" title="View/Edit Profile"></a></li>
									<?php }
							?>
							<li><a href="<?php echo base_url(); ?>owner/myProfile"><img src="<?php echo base_url();?>assets/images/admin.png" class="hoverImage" title="View/Edit Profile" style="width:25px"/></a></li>	
							<li><a href="<?php echo base_url(); ?>owner/myProfileChangePassword" style="color:#f00;"><img src="<?php echo base_url();?>assets/images/chng_pwd.png" class="hoverImage" title="Change Password" style="width:25px"/></a></li>	
                            <!--<li><a href="<?php echo base_url(); ?>registration/logout" style="color:#f00;">Logout</a></li>-->
                            <li><a href="<?php echo base_url(); ?>registration/logout" style="color:#f00;"><img src="<?php echo base_url();?>assets/images/logout.svg" class="hoverImage" title="Logout" style="width:25px;height:25px;"/></a></li>
                             <?php } ?>
                        </ul>
                    </div>
                    <iframe class="servertime_iframe" marginwidth="0" marginheight="5px" hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo base_url(); ?>server_date"></iframe>

                </div>
                <!--============================login end==================================-->
            </section>
        </header>
        <div class="box-head1 no_border top100mrgn">
            <div class="container_12">
                <?php if ($userid > 0) { ?>
                    <h2><?php echo 'Hi, '.ucfirst($full_name); ?></h2>
                <?php } ?>
                <span class="flt_rgt res_flt">
										
                    <?php if(!MOBILE_VIEW){ ?> 
					<a href="<?php echo base_url();?>owner" style="color:#fff;font-size:12px;">Dashboard</a>
                    <?php $second_uri_segment   =   $this->uri->segment(2); ?>	
                    <select name="ddlLogin" id="ddlLogin" title="Select Link"  onchange="location = this.options[this.selectedIndex].value;" style="width: auto;">
                        <option value="<?php base_url();?>owner" <?php if($second_uri_segment == ""){ echo "selected";} ?>>Select Link</option>
                        <option value="<?=  base_url();?>owner/liveAuction" <?php if($second_uri_segment == "liveAuction"){ echo "selected";} ?>>Participation Stage</option>
                        
                        <option value="<?=  base_url();?>owner/upcomingAuction" <?php if($second_uri_segment == "upcomingAuction"){ echo "selected";} ?>>Live Auctions</option>
                        
                        <option value="<?=  base_url();?>owner/buylistLiveAuctions" <?php if($second_uri_segment == "buylistLiveAuctions"){ /*echo "selected";*/ } ?>>Live Auctions List</option>
                        <option value="<?=  base_url();?>owner/completedAuction" <?php if($second_uri_segment == "completedAuction"){ echo "selected";} ?>>Completed Auctions</option>
                    </select>
                    <?php }
                    ?>
                </span>
            </div>
        </div>



