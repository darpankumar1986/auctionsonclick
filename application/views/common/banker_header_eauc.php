<?php
header("cache-Control: private,no-cache,no-store,pre-check=0,post-check=0,must-revalidate,max-age=0");
//header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<?php
$userid = $this->session->userdata('id');
$this->db->select('user_sess_val');
$this->db->where('id', $userid);
$query = $this->db->get('tbl_user');
$row = $query->result();
 
if (!empty($row)) {
    //case logout if another user is looged in
    $session_id = $this->session->userdata('session_id_user');
    if ($row[0]->user_sess_val != $session_id) {
        //echo $row[0]->user_sess_val."|".$session_id;die;
        //header('Location:'.  base_url().'registration/logout');
        // exit();
    }
}

$pages = $this->banker_model->getAllPages();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo JDA_TITLE; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= base_url(); ?>bankeauc/css/common.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url(); ?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">

        <?php /* ?>
          <link rel="stylesheet" href="<?=  base_url();?>bankeauc/css/tables.css">
          <?php */ ?>
        <link rel="stylesheet" href="<?= base_url(); ?>bankeauc/css/jquery-ui.css">

        <!--[if lt IE 9]>
            <script type="text/javascript" 
                src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
            </script>
        <![endif]-->
        <script type="text/javascript" src="<?= base_url(); ?>bankeauc/js/sortable.js"></script>
        <script src="<?= base_url(); ?>bankeauc/js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>bankeauc/js/global.js" type="text/javascript"></script>
        <script type="text/javascript">
            var tmonth = new Array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");

            function GetClock() {
                var d = new Date();
                var nmonth = d.getMonth(), ndate = d.getDate(), nyear = d.getYear();
                if (nyear < 1000)
                    nyear += 1900;

                var nhour = d.getHours(), nmin = d.getMinutes(), nsec = d.getSeconds();
                if (nmin <= 9)
                    nmin = "0" + nmin
                if (nsec <= 9)
                    nsec = "0" + nsec;

                document.getElementById('clockbox').innerHTML = "" + tmonth[nmonth] + "/" + " " + ndate + "/ " + nyear + " " + nhour + ":" + nmin + ":" + nsec + "";
            }

            /*window.onload=function(){
             GetClock();
             setInterval(GetClock,1000);
             }*/
        </script>
        <style>
            .sortable .icon{margin-left:0;}
            @media screen and (max-width: 1000px) {
                .logo1{ width:29%;}
            }
            @media screen and (max-width: 530px) {
                .logo1{ width:250px;}
                .logo{display:none;}
                .header_right ul {background:#4e8e2d;}
            }
            @media screen and (max-width: 360px) {
                .logo1{ width:250px;}
                .logo{display:none;
                }}

            #user_dept_id{
                border: 1px solid #bbb;
                /*width: 115px;*/
                color: #000;
                box-shadow: none;
                box-sizing: content-box;
                -webkit-box-sizing: content-box;
                border-radius: 2px;
                border: 1px solid #ccc;
                outline: none;
                padding: 3px 1px;
                font-size: 12px;
                margin-top: 5px;
            }

        </style>
        <script type="text/javascript">
            function noBack()
            {
                window.history.forward()
            }
            noBack();
            window.onload = noBack;
            window.onpageshow = function (evt) {
                if (evt.persisted)
                    noBack()
            }
            window.onunload = function () {
                void (0)
            }
        </script>
    </head>
    <body>
<?php
$bank_id = $this->session->userdata('bank_id');
$bank_header_color = GetTitleByField('tbl_bank', "id='" . $bank_id . "'", "bank_header_color");
?>
        <!--============================header==================================-->
        <header>
            <section class="header_wrapper">
                <div class="header_top">
                    <div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>                       
                    </div>
                    <div class="header_right">
                        <label for="show-menu" class="show-menu">&nbsp;</label>
                        <input type="checkbox" id="show-menu" role="button">
                        <ul id="menu">
                                        <!--<li><a href="<?php //=base_url(); ?>aboutus.html">About us</a></li>-->
                            <!--<li><a href="<?= base_url(); ?>faq.html" target="_blank">FAQs</a></li>-->
                            <!--<li><a href="">Help Desk</a></li>
                            <li><a href="">Change Password</a></li>
                            <li><a href="">Edit Profile</a></li>-->
                            <!--<li><a href="<?= base_url(); ?>contactus.html" target="_blank">Contact Us</a></li>-->                            
                            <!--<li><a href="<?php echo base_url(); ?>registration/logout" style="color:#f00;">Logout</a></li>-->
                            <li><a href="<?php echo base_url(); ?>buyer/myProfileChangePassword" style="color:#f00;"><img src="<?php echo base_url();?>assets/images/chng_pwd.png" class="hoverImage" title="Change Password" style="width:25px"/></a></li>
							<li><a href="<?php echo base_url(); ?>registration/logout" style="color:#f00;"><img src="<?php echo base_url();?>assets/images/logout.svg" class="hoverImage" title="Logout" style="width:25px;height:25px;"/></a></li>
                        </ul>
                        <iframe style="width: 150px;height: 23px; float:right;" marginwidth="0" marginheight="5px" hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo base_url(); ?>server_date"></iframe>
                    </div>
                </div>
            </section>
        </header><!--============================header end==================================-->
        <?php
        //print_r($this->session->userdata);
        $userid = $this->session->userdata('id');
        
        $first_name = GetTitleByField('tbl_user', "id='" . $userid . "'", "first_name");
        $last_name = GetTitleByField('tbl_user', "id='" . $userid . "'", "last_name");
        
        
        $full_name          =   $this->session->userdata('name_of_person'); //Added by Aziz
        $department_name    =   $this->session->userdata('department_name'); //Added by Aziz
        $designation_name   =   $this->session->userdata('designation_name'); //Added by Aziz
        

        if ($this->session->userdata('user_type') == 'approver') {
            $controller = 'buyer';
        } else {
            $controller = 'buyer';
        }
        ?>

    <div class="box-head1 no_border">
        <div class="container_12">
            <?php if($full_name == '' || $full_name == NULL): ?>
            <h2>Welcome, <?php echo ucfirst($first_name).' '. ucfirst($last_name); ?></h2>
             <?php  else : ?>
            <h2><?php echo ucwords($full_name).': '.$department_name.' ('.$designation_name.')'; ?></h2>
            <?php endif; ?>
            <?php
            $roleId = $this->session->userdata('role_id');
            $depart_id = $this->session->userdata('depart_id');
            $ssoData = $this->session->userdata('ssoData');

                /* $user_depart_ids= $this->session->userdata('user_depart_ids');
                  $role_arr =  $this->session->userdata('roleIdArr');
                  $role_name_arr = $this->session->userdata('role_name_arr');
                  $depart_arr = $this->session->userdata('depart_arr');
                  $depart_name_arr = $this->session->userdata('depart_name_arr');
                  $roleArr = explode(',',$role_arr);
                 */
                //print_r($ssoData);
                if (count($ssoData) > 0) { ?>
                    <span>
                        <form method="post" action="<?php echo base_url(); ?>buyer/sendRole" style="display: inline-block;">
                            <select name="user_dept_id" id="user_dept_id" onchange="submit()" >
                                <!--<option value="">Select Role</option>-->
                                <?php
                                foreach ($ssoData as $sso) { ?>
                                    <option value="<?php echo $sso['user_deprt_id']; ?>" <?php if ($sso['role_id'] == $roleId && $sso['department_id'] == $depart_id) {
                                        echo 'selected';} ?>> 
                                        <?php echo 'Role: '.$sso['name'] . ' [Dept.: ' . $sso['department_name'] . ']'; ?>
                                    </option>
                          <?php } ?>
                            </select>
                        </form>
                    </span>
          <?php } ?>
                <span class="flt_rgt">
					<?php if($roleId == 3)
					{
					?>
						<a href="<?php echo base_url() . $controller; ?>/emd_payment_verification" style="color:#fff;font-size:12px;">Dashboard</a>
                    <?php } 
                    else
                    {
                    ?>
						<a href="<?php echo base_url() . $controller; ?>/myActivity" style="color:#fff;font-size:12px;">Dashboard</a>
                    <?php 
                    }
                    ?>
                    
                    <?php $second_uri_segment   =   $this->uri->segment(2); ?>
                    <select name="ddlLogin" id="ddlLogin" title="Select Link"  onchange="location = this.options[this.selectedIndex].value;" style="width:auto;">
                        <option value="">Select Links</option>
                        <?php foreach ($pages as $page) { ?>                            
                            <option value="<?php echo base_url() . $controller; ?>/<?php echo $page->link; ?>" <?php if($second_uri_segment == $page->link && $page->link != 'listLiveAuctions'){ echo "selected";} ?>><?php echo $page->name; ?></option>
                        <?php } ?>
                        
                    </select>
                </span>
            </div>
        </div>





<?php /* ?>
  <link rel="stylesheet" href="<?php echo base_url();?>css/bace.css">
  <link rel="stylesheet" href="<?php echo base_url();?>css/admin-style.css">
  <?php */ ?>
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/helpdesk-style.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/banner.css">
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--[if IE]>
        <script type="text/javascript" src="/js/respond.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>js/common.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
        <script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
        <script src="<?php echo base_url(); ?>js/banker.js"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/promise.min.js"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.min.js"></script>
        <script src="<?php echo base_url(); ?>bankeauc/js/sweetalert.core.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>bankeauc/css/sweetalert.css">
        <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            /*------- tab pannel --------------- */
                            $(".tab_content3").hide();
                            $(".tab_content3:first").show();

                            $("ul.tabs3 li").click(function () {
                                $("ul.tabs3 li").removeClass("active");
                                $(this).addClass("active");
                                $(".tab_content3").hide();
                                var activeTab = $(this).attr("rel");
                                $("#" + activeTab).fadeIn();
                            });

                            /*------- header menu --------------- */

                            jQuery('.toggle-nav').click(function (e) {
                                jQuery(this).toggleClass('active');
                                jQuery('.menu ul').toggleClass('active');

                                e.preventDefault();
                            });




                        });

        </script>
        <script src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
        <!--<script src="/js/banker.js"></script>-->
        <?php /* ?>
          </head>
          <body>

          <header>

          <section class="top_header">
          <div class="tp_call">Call us on: 011-4567 789</div>
          <div class="wrapper-full">
          <div class="tp_link">
          <?php
          $userid=$this->session->userdata('id');
          $full_name =	GetTitleByField('tbl_user', "id='".$userid."'", "first_name");
          ?>
          <div class="top_header_name"><p>Welcome!</p> <span><?php echo ucfirst($full_name);?></span></div>
          <a id="login_dropdown" onclick="showhidedropdown();" href="javascript:"><img src="/images/icon-setting.png"></a>
          <div class="login_dropdown" style=" display:none;">
          <a href="/registration/logout">Logout</a>
          </div>
          </div>
          </div>
          </section>
          <?php */ ?>

        <?php /* ?>
          <section class="header">
          <div class="wrapper-full">
          <div class="logo-com">
          <?php
          $bank_id=$this->session->userdata('bank_id');
          $banklogo =	GetTitleByField('tbl_bank', "id='".$bank_id."'", "logopath");
          if($banklogo){
          ?>

          <img src="<?php echo base_url().$banklogo; ?>">
          <?php } ?>

          </div>

          <div class="logo ftright" style="padding:0 0 0 20px;">
          <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url();?>images/logo2.png"></a>
          </div>


          <div class="menu">
          <ul class="active">
          <li <?php echo ($menu_type=='auction_calender')?$class='class="current-item"':$class='';?>><a target="_blank" href="/auction-calender">Auction Calender</a></li>
          <li <?php echo ($menu_type=='how_it_works')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>how-it-works">How it Works</a></li>
          <li <?php echo ($menu_type=='sell')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>property/?propertype=sell&act=non_auction">Buy</a></li>
          <!--<li <?php echo ($menu_type=='rent')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>property/?propertype=rent&act=non_auction">Rent</a></li>-->
          <?php
          if($userid>0){
          if($user_type=='owner'){?>
          <li <?php echo ($menu_type=='post_property')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>owner/sellerPostPropety">Post Property</a></li>
          <?php }else if($user_type=='helpdesk_ex') {?>
          <li <?php echo ($menu_type=='post_property')?$class='class="current-item"':$class='';?>><a href="<?php echo base_url(); ?>helpdesk_executive/createLoggedEvents">Post Property</a></li>
          <?php }else{ ?>
          <li><a href="#">Post Property</a></li>
          <?php } ?>
          <?php }else{ ?>
          <li><a href="<?php echo base_url(); ?>registration/login">Post Property</a></li>
          <?php } ?>
          </ul>
          <a class="toggle-nav" href="#">&#9776;</a>
          </div>
          </div>

          <div style="float: right;margin-right: 20px;"><a target="_blank" href="https://www.c1india.com/"><img src="<?php echo base_url(); ?>images/bankeauction-logo.jpg"/></a></div>

          </section>

          </header><?php */ ?>
