<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title<?php echo BRAND_NAME; ?> </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
    <script type="text/javascript" 
        src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
    </script>
<![endif]-->


<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="banker"){
                $(".box").not(".banker").hide();
                $(".banker").show();
            }           
            else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>

</head>
<body>
<!--============================header==================================-->
<header>
<section class="header_wrapper">
<div class="header_top">
<div class="logo"><img src="images/logo.png" width="192" height="60" alt="Bank eauctions"></div>
<div class="header_right">
<ul>
                <li><a href="">Downloads</a></li>
                <li><a href="Registration.html">Registration</a></li>
                <li><a href="">FAQs</a></li>
</ul>
<div class="clear">&nbsp;</div>
<div class="header_number">Call us at: +91-124-4302020 / 21 / 22 / 23 / 24<!--<br>-->
                <!--Call us at: +91-120-4888888--> </div>
</div>
</div>
						
<div class="clear">&nbsp;</div>
<div class="banner"><img src="images/hammer.png" width="560" height="228"></div>

<form action="/registration/checklogintype" method="post" >						
<div class="login_box"><!--==========Login start=========-->
                <div class="login_heading">Login</div>
                <br>
                <div class="selct_optn">
                                <select name="ddlLogin" id="ddlLogin" title="Login As">
                                                <option value="green">Bidder/All</option>
                                                <option value="banker">Buyer</option>
                                </select>
                </div>
                <div class="inpt_heading"> Email ID<br>
                                <input type="text" title="Login ID">
                </div>
                <div class="banker box" align="left" style="padding-left:30px;line-height:15px;color:grey;font-size:12px;margin-top:5px;display:none;"> User ID
                                <input id="txtLoginID" name="txtUserID" type="text"  title="User ID">
                                </div>
                <div class="inpt_heading"> Password<br>
                                <input type="password" title="Password">
                </div>
                <div class="login_link"> 
                    <!--<a href="#" class="login">Login</a>-->
                    <input type="submit" value="login" name="Login" class="login">
                <span class="forgot_password"><a href="#">Forgot Password?</a></span> </div>
</b></div>
</form>
<!--============================login end==================================-->
</section>
 </header><!--============================header end==================================-->


		<section id="body_wrapper"><!--==========body main start=========-->
				<div class="body_main">
								<div class="heading_bg">
										<img src="images/liveevent.png" class="live_event" width="120" height="20">
										<div class="search">
											<label>Search</label> <input type="text">
										</div>
								</div>
		
		
						<section class="table_bg"><!--==========table bg start=========-->
							<div class="container-outer">
							<div class="container-inner">
								<table width="100%" border="1">
								<thead>
										<tr>
												<th width="25px">&nbsp;</th>
												<th>Auction ID</th>
												<th>Bank Name</th>
												<th>Asset on Auction</th>
												<th>City</th>
												<th>Date</th>
												<th>Reserve Price</th>
												<th>EMD</th>
										</tr>
								</thead>
								
								<tbody>		
										<tr onclick="document.location = 'EventView.html';">
												<td><img src="images/logo(1).png" width="30" height="30"></td>
												<td>20508</td>
												<td>Phoenix ARC Pvt Ltd</td>
												<td>Property I (Owned by SDN Corporation): Office No. 201, 2nd floor, admeasuring 412 sq. ft (area adm 577 super built up) in the building known as Atlan...</td>
												<td>Mumbai</td>
												<td>19 Jan 2016</td>
												<td>73,15,200.00</td>
												<td>7,31,520.00</td>
										</tr>
										<tr onclick="document.location = 'EventView.html';">
												<td><img src="images/logo(2).png" width="30" height="30"></td>
												<td>20508</td>
												<td>Phoenix ARC Pvt Ltd</td>
												<td>Property I (Owned by SDN Corporation): Office No. 201, 2nd floor, admeasuring 412 sq. ft (area adm 577 super built up) in the building known as Atlan...</td>
												<td>Mumbai</td>
												<td>19 Jan 2016</td>
												<td>73,15,200.00</td>
												<td>7,31,520.00</td>
										</tr>
										
										<tr onclick="document.location = 'EventView.html';">
												<td><img src="images/logo(3).png" width="30" height="30"></td>
												<td>20508</td>
												<td>Phoenix ARC Pvt Ltd</td>
												<td>Property I (Owned by SDN Corporation): Office No. 201, 2nd floor, admeasuring 412 sq. ft (area adm 577 super built up) in the building known as Atlan...</td>
												<td>Mumbai</td>
												<td>19 Jan 2016</td>
												<td>73,15,200.00</td>
												<td>7,31,520.00</td>
										</tr>
										
										<tr onclick="document.location = 'EventView.html';">
												<td><img src="images/logo(4).png" width="30" height="30"></td>
												<td>20508</td>
												<td>Phoenix ARC Pvt Ltd</td>
												<td>Property I (Owned by SDN Corporation): Office No. 201, 2nd floor, admeasuring 412 sq. ft (area adm 577 super built up) in the building known as Atlan...</td>
												<td>Mumbai</td>
												<td>19 Jan 2016</td>
												<td>73,15,200.00</td>
												<td>7,31,520.00</td>
										</tr>
										
										<tr onclick="document.location = 'EventView.html';">
												<td><img src="images/logo(1).png" width="30" height="30"></td>
												<td>20508</td>
												<td>Phoenix ARC Pvt Ltd</td>
												<td>Property I (Owned by SDN Corporation): Office No. 201, 2nd floor, admeasuring 412 sq. ft (area adm 577 super built up) in the building known as Atlan...</td>
												<td>Mumbai</td>
												<td>19 Jan 2016</td>
												<td>73,15,200.00</td>
												<td>7,31,520.00</td>
										</tr>
								</tbody>		
								</table>
								
							</div>
							</div>
						</section><!--==========table bg end=========-->
		
		
					<div class="participating_bank">Participating Banks</div>
						<div class="table_bg"><!--==========bank icon start=========-->
								<ul class="bank_icon_bg">
										<li><a href="#"><img src="images/andhrabankbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/bobbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/boi.gif" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/sbi.gif" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/canarabiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/centralbankbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/denabiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/hudco.gif" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/ibbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/idbibiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/iob.gif" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/obcbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/bombiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/psbbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/sbhbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/ubi.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/ubbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/sbtbiglogo.png" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/sidbi.gif" class="bank_image" width="120" height="40"></a></li>
										<li><a href="#"><img src="images/pnbbiglogo.png" class="bank_image" width="120" height="40"></a></li>
								</ul>
						</div><!--==========bank icon end=========-->
				</div><!--==========body_main end=========-->
		</section><!--==========body_wrapper end=========-->


		<footer>
				<p><span>Copyright © <?php echo BRAND_NAME; ?></span> <span><a href="#">Terms of Use</a></span></p>
		</footer>
</body>
</html>
