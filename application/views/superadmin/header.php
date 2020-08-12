<?php
header("cache-Control: private,no-cache,no-store,pre-check=0,post-check=0,must-revalidate,max-age=0");
//header("cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin :: <?php echo isset($heading) ? $heading : "Dashboard"; ?></title>
        <?php $this->load->helper('url'); ?>
        <?php define('VIEWBASE', site_url() . 'application/views/superadmin/'); ?>

<!--<link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/style.default.css" type="text/css" />-->
        <link href="<?php echo VIEWBASE; ?>css/dt_common.css" rel="stylesheet" type="text/css">
            <link href="<?php echo VIEWBASE; ?>css/dt_responsive.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/dt_tables.css">
				<!--[if lt IE 9]>
					<script type="text/javascript" 
						src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
					</script>
				<![endif]-->

				<!--<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-1.7.min.js"></script>-->
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-3.2.0.min.js"></script>

				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.cookie.js"></script>
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.uniform.min.js"></script>
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/general.js"></script>
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/dt_global.js"></script>
				<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<link rel="stylesheet" href="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.12.1.css">
<script src="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.12.1.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
				<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/excanvas.min.js"></script><![endif]-->
				<!--[if IE 9]>
					<link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie9.css"/>
				<![endif]-->
				<!--[if IE 8]>
					<link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie8.css"/>
				<![endif]-->
				<!--[if lt IE 9]>
						<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
				<![endif]-->
				<?php
				header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
				header("Pragma: no-cache"); // HTTP 1.0.
				header("Expires: 0"); // Proxies.
				?>
<style>
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
                background: #fff !important;
            }
    .logo-text{padding: 14px 0 0 15px !important;}
    
</style>
                    </head>

                    <body>
                        <header>
                            <!--============================header==================================-->

                            <?php
//echo '<pre>';
                            //print_r();
                            ?>
                            <section class="header_wrapper">
                                <div class="header_top">
                                    <div class="logo"><img src="<?php echo base_url();?>assets/front_view/images/<?php echo SITE_LOGO; ?>" style="max-width: 250px;"></a>                                           
                                           
                                    </div>
                                    <div class="header_right">
                                        <ul>
                                            <!--<li><a href="">About us</a></li>-->
                                            <!--<li><a href="<?= base_url(); ?>faq.html" target="_blank">FAQs</a></li>-->
                                            <!--<li><a href="">Help Desk</a></li>-->
                                            <!--<li><a href="<?= base_url(); ?>contactus.html" target="_blank">Contact Us</a></li>-->
                                            <li><a href="<?php echo base_url() . 'superadmin/logout' ?>" style="color:#f00;">Logout</a></li>
                                        </ul>
                                        <iframe style="width: 150px;height: 23px; float:right;" marginwidth="0" marginheight="5px" hspace="0" vspace="0" frameborder="0" scrolling="no" src="<?php echo base_url(); ?>server_date"></iframe>

                                    </div>
                                </div>
                                <!--============================login end==================================-->
                            </section>
                        </header>
                        <!-- ========================= Header End     ==================================== -->
                        
                <?php
                    $full_name          =   $this->session->userdata('name_of_person'); //Added by Aziz
                    $department_name    =   $this->session->userdata('department_name'); //Added by Aziz
                    $designation_name   =   $this->session->userdata('designation_name'); //Added by Aziz
                ?>
                <div class="box-head1 no_border">
                    <div class="container_12">
                       
                        <?php if($full_name == '' || $full_name == NULL): ?>
                        <h2>Welcome, <?php  echo ucfirst($this->session->userdata('aname')); ?></h2>
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
                if (count($ssoData) > 1) {
                    ?>
                    <span>
                        <form method="post" action="<?php echo base_url(); ?>superadmin/home/sendRole" style="display: inline-block;">
                            <select name="user_dept_id" id="user_dept_id" onchange="submit()" >
                                <!--<option value="">Select Role</option>-->
                                <?php
                                foreach ($ssoData as $sso) {
                                    ?>
                                    <option value="<?php echo $sso['user_deprt_id']; ?>" <?php if ($sso['role_id'] == $roleId && $sso['department_id'] == $depart_id) {
                                echo 'selected';
                            } ?>> <?php echo 'Role: '.$sso['name'] . ' [Dept.: ' . $sso['department_name'] . ']'; ?></option>
                        <?php
                    }
                    ?>
                            </select>
                        </form>
                    </span>
                            <?php
                        }
                        ?>
                                <span class="flt_rgt">
                                    <a href="<?php echo base_url() . 'superadmin/home' ?>"><h2>Dashboard</h2></a>
                                </span>
                            </div>
                        </div>





