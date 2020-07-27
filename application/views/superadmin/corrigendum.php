<script src="<?php echo base_url(); ?>media/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/calender/jquery-ui.css" type="text/css" media="screen"/>	

<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" type="text/css" media="screen"/>	


<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>-->
<script src="<?php echo base_url(); ?>media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>media/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<?php //if($type=='AuctionToBePublished' || $type==''){  ?> 
<style>
.he_view_report{  font-size: 12px;  background: none; border: none; color: blue; cursor: pointer;}
table {border-collapse:collapse;}
.dataTables_empty{text-align:center;}
.paginate_button{border: 1px solid #C1C1C1;border-radius: 3px;padding: 3px 9px;margin: 0px 1px;cursor: pointer;color: #333;font-size: 12px;}
.paginate_button:hover{ background:#ccc;}
.paginate_active{background-color: #A7A7A7;color: #FFF;border: 1px solid #A7A7A7;border-radius: 3px;padding: 3px 9px;margin: 0px 1px;cursor: pointer;font-size:12px;}
.flt_rgt select, input{font-size: 1em !important;}
</style>
<!--=============================open page search box==============================-->			
<section class="container_12">						
    <span class="err_msg" align="center" style="color:#CC0000;margin-left:450px;"></span>
    <?php if(isset($this->session->userdata['flash:old:message1'])){?>
							<br/>
							<div class="success_msg" style="color:red !important;"> 
								<?php 
									echo $message =  @$this->session->userdata['flash:old:message1']; 
									
								?>
							</div>
						<?php } ?>
						
    <div class="box-head custom123 no_cursor">
        Search Event ID to Edit Event
    </div>
    <div style="min-height: 0px; display: block;" class="box-content no-pad">
        <div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
            <div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
                <div class="box-content no-pad">
                    <div class="container-outer">
                        <form name="open_page_by" id="open_page_by" method="post" onsubmit="return chkevent();" action="">
                            <div class="container-inner">
                               
                                <table class="display">
                                    <tr style="text-align:center;">
                                        <td style="font-weight:bold;">Event ID <span class="red">*</span></td>
                                        <td align="left"> <input name="auctionid" id="auctionid" maxlength="6" onkeypress="return isNumberKey(event);" type="text" value="<?php echo $auctionID; ?>" style="width:200px; height: 20px;"  class="input"></td>
                                        <td><a><input name="page_type" value="Submit" type="submit" class="b_deal he_view_report"></a></td>                                        
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<script type="text/javascript">
function chkevent(){
    $("#err_msg").text("");
  if($("#auctionid").val()==''){ 
   $(".err_msg").text("Please enter Event ID");
   return false;
  }  
}
</script>




