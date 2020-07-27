<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
/*	table a {
    font-size: 12px;
    /*text-decoration: none;*/
    color: #000;
}
table a:hover {
    /*text-decoration: underline;*/
}
*/
</style>
<section class="container_12">
  <?php //echo $breadcrumb;?>  
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
					{ ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">					
                      <div class="box-head"><?php echo "Auction Reports"?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
						<div class="container-outer">
							<div class="container-inner">
								<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<tr>
											 <td><a href="<?php echo base_url().'buyer/viewReport/'.$auctionId;?>">Highest Bid Report</a></td>
											 <td><a href="<?php echo base_url().'buyer/acceptedBidsReport/'.$auctionId;?>">Accepted Bids Report</a></td> 
											 <td><a href="<?php echo base_url().'buyer/allBidsReport/'.$auctionId;?>">All Bids Report</a></td>
											 <td><a href="<?php echo base_url().'buyer/breakupBidsReport/'.$auctionId;?>">Breakup of Bids Report</a></td>				 
											 <td><a href="<?php echo base_url().'buyer/rejectedBidsReport/'.$auctionId;?>">Rejected Bids Report</a></td><?php  ?>
										</tr>
									</tbody>        
								</table>
							</div>
						</div>
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
