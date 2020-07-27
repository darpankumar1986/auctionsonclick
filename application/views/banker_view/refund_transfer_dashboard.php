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
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
						<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
					 <?php //} ?>
                      <div class="box-head">Refund/Transfer Dashboard</div>
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
									<td  align="left" valign="top" class=""><strong>S/No.</strong></td>
									<td  align="left" valign="top" class=""><strong>Auction Id</strong></td>
									<td width="15%" align="left" valign="top" class=""><strong>Property ID</strong></td>
									<td  align="left" valign="top" class=""><strong>Property Address</strong></td>	
									<td  width="10%" align="left" valign="top" class=""><strong>Auction End Date.</strong></td>	
									<td  align="left" valign="top" class=""><strong>Initiate EMD Refund</strong></td>
									<td  align="left" valign="top" class=""><strong>Download Refund Scrolls/Cheques </strong></td>
									<td  align="left" valign="top" class=""><strong>Initiate Transfer</strong></td>
									<td  align="left" valign="top" class=""><strong>Download Transfer Scrolls/Cheques </strong></td>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php 					
								//echo '<pre>';print_r($auctionData);die;
								
								if(count($auctionData)){
									foreach($auctionData as $key => $aData)
									{
								?>
									<tr class="even">														
										<td><?php echo ++$key?></td>
										<td><?php echo $aData->id; ?></td>
										<td><?php echo $aData->reference_no; ?></td>
                                                                                <td><?php echo $aData->PropertyDescription; ?></td>
                                                                                <td><?php echo date('m-d-Y',strtotime($aData->auction_end_date)); ?></td>
										<td><a href="<?php echo base_url()?>buyer/initiate_refund/<?php echo $aData->id; ?>"><img src="<?php echo base_url(); ?>images/add.png" class="table_icon"></a></td>
										<td><a href="<?php echo base_url('buyer/initiate_refund_dashboard/'.$aData->id)?>"><img src="<?php echo base_url(); ?>images/download.png" class="table_icon"></a></td>
										<td><a href="<?php echo base_url()?>buyer/initiate_transfer/<?php echo $aData->id; ?>"><img src="<?php echo base_url(); ?>images/add.png" class="table_icon"></a></td>	
										<td><a href="<?php echo base_url('buyer/initiate_transfer_dashboard/'.$aData->id)?>"><img src="<?php echo base_url(); ?>images/download.png" class="table_icon"></a></td>							
									</tr>
								<?php 
									}
								}
								else
								{
								?>
								<tr>
									<td colspan="7" align="center">No Record found</td>
								</tr>
								<?php 
								}
								?>
							</tbody>     					
						</table>
						<?php 
						
						//echo "<pre>";
						//print_r($bidders);
					?>
					</div></div>
					</div>
                  </div>
                  
                </div>
                <?php } ?>
                
						<?php 
						
						//echo "<pre>";
						//print_r($bidders);
					?>
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

