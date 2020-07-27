<style>
	footer {
    margin-top: 250px;
}
</style>
<section class="container_12">
    <?php //echo $breadcrumb;?>
    <div class="container_12">
        <div class="wrapper-full">
            <div class="dashboard-wrapper">
      
                <div id="tab-pannel6" class="btmrgn">
    
                    <div class="tab_container6"> 
                        <!---- buy tab container start ---->
                        <div id="tab1" class="tab_content6" style="display:block">
                            <div id="tab-pannel3" class="btmrgn">
                
                                <div class="tab_container3 whitebg"> 


                                    <!-- Sell > My Activity start -->

                                    <div id="tab6" class="tab_content3">
                                        <div class="container">
                                            <?php //echo $leftsidebar; ?>
                                            <div class="secttion-right">
                                                <div class="table-wrapper btmrg20">                                                   
                                                    <div class="box-heading">Account Verification</div>
													 <?php 
													  if($msg==1){
													  ?>
													  <div class="success_msg">
													  Your email address is successfully verified. Please login to access your account !
													  </div>
													  <?php }else if($msg==2){ ?>
													   <div class="sucessfully btmrg20">
													   Your Account Already activated! Please login now
													  </div>
													  <?php }else{ ?>
														<div class="fail_msg">
															This Email ID is already verified.
														</div> 
													  <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sell > My Activity end --> 
                                </div>
                            </div>
                        </div>
                        <!---- Sell tab container end ----> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br style="clear: both;"/><br/><br/><br/>

