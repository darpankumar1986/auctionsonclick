<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<section class="container_12">
  <?php   
  //echo $breadcrumb;?>  
	  <!-- onsubmit="return validateopenerfrm('bidopenerfrm1');-->
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php //echo $leftPanel?>
                <div class="secttion-right">
					<?php 									
					//if($this->session->userdata('role_id')==3) 
					{ 
					?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:success'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:success']; ?></div>
					<?php } ?>
					<?php /* if(isset($this->session->userdata['flash:old:success_new'])){?>
						<div class="success_msg" style="color:red;text-align:left;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:success_new']; ?></div>
					 <?php } */ ?>
                      <div class="box-head">Scroll/Cheque Download (Auction Id: <?php echo $auction_id; ?>)</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

					<div class="container-outer">
					<div class="container-inner">
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">
							<thead>
								<tr class="odd">
									<td width="5%" align="left" valign="top" class=""><strong>S/No.</strong></td>
								
									<td width="35%" align="left" valign="top" class=""><strong>Dispose Order No.</strong></td>						
									<td width="13%" align="left" valign="top" class=""><strong>Download Scroll</strong></td>
									<td width="13%" align="left" valign="top" class=""><strong>Download Cheque</strong></td>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php 					
								//echo '<pre>';print_r($auctionData);die;
								
								if(count($refundData)){
                                                                    foreach($refundData as $key => $rData)
                                                                    {
                                                                ?>
                                                                    <tr class="even">														
                                                                        <td><?php echo ++$key?></td>
                                                                        <td align="left" valign="top" class=""><?php echo $rData->dispose_order_no; ?></td>
                                                                        <td>
                                                                                <a href="<?php echo base_url()?>pdfdata/initiate_refund_pdf/<?php echo $auction_id;?>/<?php echo $rData->dispose_order_no; ?>/S" download><img src="<?php echo base_url('images/pdf-icon.jpg'); ?>" class="table_icon"></a>
                                                                        </td>
                                                                        <td>
                                                                               <a href="<?php echo base_url()?>pdfdata/initiate_refund_pdf/<?php echo $auction_id;?>/<?php echo $rData->dispose_order_no; ?>/C" download><img src="<?php echo base_url('images/pdf-icon.jpg'); ?>" class="table_icon"></a>
                                                                        </td>
                                                                    </tr>
                                                                <?php 
                                                                    }
								}
								else
								{
								?>
								<tr class="even">
									<td colspan="5" align="center">No Record found</td>
								</tr>
								<?php 
								}
								?>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <input name="back" value="Back" onclick="window.location.href='<?php echo base_url();?>buyer/refund_transfer_dashboard'"  type="button" class="button_grey">
                                                                    </td>
                                                                </tr>
							</tbody>     					
						</table>
						
					</div></div>
					</div>
                  </div>
                  
                </div>
                <?php } ?>
                
					</div></div>
					</div>
                  </div>
                  
                </div>
                
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>  
</section>
<script>
	$(document).ready(function() {});
</script>

