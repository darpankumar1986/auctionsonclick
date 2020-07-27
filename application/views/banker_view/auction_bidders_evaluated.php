<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
	.hidetd{display:none;}
	.case, #selectAll{width:22px !important;}
	
.category_dd {
    border: 1px solid #bbb;
    width: 200px;
    background: #fff !important;
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
.lft_heading {
    width: 35%;
    float: left;
    text-align: right;
    font-size: .8em;
    font-weight: bold;
    padding-right: 1%;
    padding-top: 30px;
}
.rgtDetail {
    width: 62%;
    float: left;
    text-align: left;
    font-size: .8em;
    padding-left: 1%;
}
.button_grey{
	 margin: 22px 0 0 5px;
    vertical-align: top !important
}
</style>
<script>
jQuery(document).ready(function(){	
	jQuery(".annexure_detail_iframe").colorbox({iframe:true, width:"70%", height:"80%"});
});
</script>
<section class="container_12">
<?php  
 $auctionID = $this->uri->segment(3);
 
?>  
  
  <form id="bidopenerfrm1" name="submitdoc" action="/buyer/add_bidder_auction" method="post" enctype="multipart/form-data" >
	  <!-- onsubmit="return validateopenerfrm('bidopenerfrm1');-->
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            <?php if(!$auctionId>0 && false) {?>
					<form name="categoryFrm" method="GET">
						<div class="lft_heading">Select Category</div>
						<?php
								$category_id = array();
								if($_GET['category_id'] != '')
								{
									$category_id = explode(',',$_GET['category_id']);
								}
								//print_r($caste_cat);die;
							?>	
						<div class="rgtDetail">
						<select id="categoryId" name="category_id[]" class="category_dd" multiple>	
							
							<?php foreach($caste_cat as $cc) {
									$selected = '';
									if(in_array($cc->caste_category_id,$category_id))
									{
										$selected = 'selected="selected"';
									}
								?>
								<option value="<?php echo $cc->caste_category_id;?>" <?php echo $selected; ?> ><?php echo $cc->caste_category_name;?></option>
							<?php } ?>
						</select>			
						<input id="categorySbt" type="button" name="categorySbt" class="b_submit button_grey" value="Search" />
						</div>
					</form>		
					<?php } ?>
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php //echo $leftPanel?>
                <div class="secttion-right">					
                            
            <?php if($this->session->userdata('role_id')==2) { 
				    $auctionID = $this->uri->segment(3);
					$doc_to_be_submitted = GetTitleById('tbl_auction',$auctionID,'doc_to_be_submitted'); 
					//$annexure_enabled = GetTitleById('tbl_auction',$auctionID,'annexure_enabled'); 
					
				?>
                <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
						<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
					 <?php //} ?>
                      <div class="box-head"><?php echo "Final Approver"; ?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

		<div class="container-outer">
		<div class="container-inner">
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<thead>
					<tr class="odd">						
						<td width="10%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<!-- <td width="30%" align="left" valign="top" class=""><strong>View </strong></td> -->
                        <td width="30%" align="left" valign="top" class=""><strong>EMD Status</strong></td>
						<td width="20%" align="left" valign="top" class=""><strong>Payment Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Payment Verifier Comments </strong></td>
						<?php if($doc_to_be_submitted == 0){}else{ ?>
                        <td width="10%" align="left" valign="top" class=""><strong>View Docs </strong></td>
						<td width="10%" align="left" valign="top" class=""><strong>Document Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Document Verifier Comments </strong></td>
						<?php } ?>
						
						<td width="10%" align="left" valign="top" class=""><strong>Final Approver Action </strong></td>						
						<td width="20%" align="left" valign="top" class=""><strong>Final Approver Comments</strong></td>
						
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 					
					//echo '<pre>';print_r($bider_detail->payment_verifier_accepted);die;
					
					if(count($bidders[0]->bider_detail)){
						foreach($bidders[0]->bider_detail as $key=>$bider_detail){
						
					?>
						<tr class="even">							
							<td align="left" valign="top" class=""><?php echo ++$key?></td>
							<td align="left" valign="top" class="">
							<?php 
							if( GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='builder'){
							   echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name'); 
							  }else{
							  echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name');  
							}
							?></td>
							<td align="left" valign="top" class="" >
								<?php if(LOCAL_URL == true){ ?>
							    <a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Success</a>
							<?php } else {
							 ?>
								<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>"><?php echo ucfirst($bider_detail->emd_detail[0]->payment_status);?></a>
							<?php } ?>							
							</td>
                                                        
							<td align="left" valign="top" class="">
								<?php
									if($bider_detail->payment_verifier_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->payment_verifier_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->payment_verifier_accepted==0)
									{
										echo 'Rejected';
									}
								 
								 ?>
							</td>
							<td align="left" valign="top" class="">
								<?php echo $bider_detail->payment_verifier_comment; ?>
							</td>
							<?php if($doc_to_be_submitted == 0){}else{ ?>
								<td>							
									<a class='tenderfee_detail_iframe' href="/buyer/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">Docs</a>
								</td>
								<td align="left" valign="top" class="" >
								<?php 
									if($bider_detail->operner1_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->operner1_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->operner1_accepted==0)
									{
										echo 'Rejected';
									}
								?>
							</td>
							<td align="left" valign="top" class="" >
								<?php echo $bider_detail->operner1_comment; ?>
							</td>

							<?php } ?>
							<?php
							if($annexure_enabled ==1)
							{
							?>
								<td align="left" valign="top" class="" >							
									<a class='annexure_detail_iframe' href="/buyer/annexureDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">Annexure Docs</a>
								</td>
							<?php
							 } ?>
							<td align="left" valign="top" class="" >							
							<?php 
								if($bider_detail->operner2_accepted==1)
								{
									echo 'Accepted';
								}
								else if($bider_detail->operner2_accepted==null)
								{
									echo '--';
								}
								else if($bider_detail->operner2_accepted==0)
								{
									echo 'Rejected';
								}
							?>
							</td>
							
							<td align="left" valign="top" class="" >
								<?php echo $bider_detail->operner2_comment; ?>
							</td>
							
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="13" align="center">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					</tbody>     					
					<tr>
						<td colspan="13">								
							 <input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/eventTrack/<?php echo $auctionID;?>'"  type="button" class="button_grey">
						</td>
					</tr>
				
				        
			</table>
			<br><br><br>
						
					</div></div>
					</div>
                  </div>
                  
                </div>
                
              </div>
            </div>
            <?php } ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
