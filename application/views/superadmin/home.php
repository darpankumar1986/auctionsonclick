<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/dashboard.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.slimscroll.js"></script>


<style>
@media screen and (max-width: 500px) {
	table, thead, tbody, th, td, tr { 
			display: block; 
		}
		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr { 
			position: absolute;
			top: -9999px;
			left: -9999px;
		}
		td { 
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee; 
			position: relative;
			padding-left: 50%; 
		}	
		td:before { 
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%; 
			padding-right: 10px; 
			white-space: nowrap;
		}

		.display tr:nth-child(odd){background:#fff!important;}
		.display tr:nth-child(even){background:#fff!important;}		
		
		}
</style>





<section class="container_12">
			<?php 
				if($this->session->userdata('arole') != '10')
				{ ?>
			<div class="box-head">Dashboard</div>
			<?php } ?>
				<div style="min-height: 0px; display: block;" class="box-content no-pad">
				<div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
					<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
 
				<div class="box-content no-pad">
					<?php if($this->session->userdata('arole') == '9'){ ?>
						<table class="display" id="dt1" >     
						      
						<tr>
							<td ><a href="<?php echo base_url()?>superadmin/news/">Add/Update Homepage Breaking News</a></td>
							<td ><a href="<?php echo base_url()?>superadmin/news/homebannerlist">Add/Update Homepage Header Banner</a></td>
							<td ><a href="<?php echo base_url()?>superadmin/news/homesliderlist">Add/Update Homepage Slider Banner's</a></td>
							
						</tr>
						<tr>
							<td ><a href="<?php echo base_url()?>superadmin/news/banklist">Add/Update Bankwise Header/Banner</a></td>
							<td ><a href="<?php echo base_url()?>superadmin/news/robots">Robots</a></td>
							<td ><a href="<?php echo base_url()?>superadmin/news/uploadData">Uploads Bidder Registration Data (CSV)</a></td>
						</tr>
						</table>
					<?php }
					if($this->session->userdata('arole') == '1')
					{ ?>
						<table class="display" id="dt1" >       
						<tr>
							<td><a href="<?php echo base_url('/superadmin/bank')?>">Bank List</a></td>
							<td><a href="<?php echo base_url('/superadmin/bank_branch');?>">Branch List</a></td>
							<!--<td><a href="<?php echo base_url('/superadmin/user/bankeraddedit');?>">Create Branch User</a></td> -->
							<td><a href="<?php echo base_url('/superadmin/category/addeditmain')?>">Create Category</a></td>
							<td><a href="<?php echo base_url('/superadmin/category/addedit')?>">Create Sub Category</a></td>
							<td><a href="<?php echo base_url()?>superadmin/country/addedit">Create Country</a></td> 
							

							
							
						</tr>    
						<tr>	
							<td><a href="<?php echo base_url()?>superadmin/state/addedit">Create State</a></td>
							<td><a href="<?php echo base_url()?>superadmin/city">City List</a></td>
							<!--<td><a href="<?php echo base_url()?>superadmin/sales_person/addedit">Create Sales Person</a></td>-->
							<td><a href="<?php echo base_url()?>superadmin/user/bidder_list">User List</a></td>
							<td><a href="<?php echo base_url()?>superadmin/upload_document/addedit">Create Upload  Document Fields</a></td>
							<td><a href="<?php echo base_url('/superadmin/user/banker');?>">Branch User List</a></td> 
							<!--<td><a href="<?php echo base_url()?>superadmin/bank_account/addedit">Create Bank Account</a></td>
							<td><a href="<?php echo base_url()?>superadmin/master_bank/addedit">Create Master Bank</a></td>
							<td><a href="<?php echo base_url('/superadmin/user/assignDeptlist');?>">Assigned	Department List</a></td>-->
							
						</tr>
						<tr>
							<!--<td><a href="<?php echo base_url()?>superadmin/rolepage/addeditrole">Create Roles</a></td>	
							<td><a href="<?php echo base_url()?>superadmin/rolepage/addeditpage">Create Pages</a></td>-->
							
						<tr>
							<!--
							<td><a href="<?php echo base_url('/superadmin/user/assignRolelist');?>">Assigned Role List</a></td> 
							<td><a href="<?php echo base_url()?>superadmin/account_type/addedit">Create Account Type</a></td>
							<td><a href="<?php echo base_url()?>superadmin/email_template/addedit">Create Email Template</a></td>
							<td><a href="<?php echo base_url()?>superadmin/sms_template/addedit">Create SMS Template</a></td>
							<td ><a href="<?php echo base_url()?>superadmin/news/homesliderlist">Add/Update Homepage Slider Banner's</a></td>
							<td><a href="<?php echo base_url()?>superadmin/bidder_document/addedit">Create Bidder Documents</a></td>
							<td><a href="<?php echo base_url()?>superadmin/participation_emd_cal/addedit">Create Participation EMD Fee</a></td>-->
							<!--<td><a href="<?php echo base_url('/superadmin/location/addedit')?>">Create Location</a></td>-->							
						</tr>                            							
													
													
							
							<?php /*?><td><a href="<?php echo base_url()?>superadmin/tokens/addedit">Create Tokens</a></td><?php */?>
							<?php /*?><td ><a href="<?php echo base_url('/superadmin/bank_zone/zone_addedit');?>">Create Zone</a></td><?php */?>
                        </tr>
                        
						
						</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>	
	<?php if($this->session->userdata('arole') == '1'){ ?>
	<div class="box-head">Logs</div>	
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
				<div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
				<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
                                    <div class="box-content no-pad">							
					<table class="display" id="dt1" >           
                                            <tr>
                                                <td><a href="<?php echo base_url('/superadmin/user/userlog');?>">User Login/Logout Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/bidderegisterlog')?>">User Registration / Profile Update Logs</a></td> 
												<td><a href="<?php echo base_url('/superadmin/user/contact_us_log')?>">Contact Us Logs</a></td> 
												<td><a href="<?php echo base_url('/superadmin/user/user_subscription_list')?>">User Subscription Logs</a></td>
                                                <!--<td><a href="<?php echo base_url('/superadmin/event_log/index');?>">Logged Event Creation Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/iagreelog');?>">Bidder Participitated Agreement Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/bidderfinalsubmissionlog');?>">Bidder Final Submission Logs</a></td>-->
                                                                                              
                                                <!--<td><a href="<?php echo base_url()?>superadmin/user/liveauctionlog">Live Auction Log</a></td> -->                                                
                                               
                                            </tr>
											<?php /*?>
                                            <tr>
                                                <!-- <td><a href="<?php echo base_url('/superadmin/user/bidsubmissionlog');?>">Bid Submission Logs</a></td> -->
                                                <!-- <td><a href="<?php echo base_url('/superadmin/user/masterlog');?>">Master Logs</a></td> -->
                                                <td><a href="<?php echo base_url('/superadmin/user/auctiontraininglog');?>">Auction Training Acceptance Logs</a></td> 
                                                <td><a href="<?php echo base_url('/superadmin/user/bidopeninglog');?>">Bid Opening Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/payment_approver_log');?>">Payment Approve/Rejection Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/document_approver_log')?>">Document Approve/Rejection Logs</a></td> 
                                                <td><a href="<?php echo base_url('/superadmin/user/finalapproverLog');?>"> Final Approver Logs</a></td>
                                            </tr>
                                            <tr>
												<td><a href="<?php echo base_url('/superadmin/user/bidsubmitlog');?>">Bid Submission Logs</a></td>
												<td><a href="<?php echo base_url()?>superadmin/user/invalid_bid_log"> Invalid Bid Logs</a></td>
												<td><a href="<?php echo base_url()?>superadmin/user/registration_payment_log"> Registration Payment Logs</a></td>
                                                <td><a href="<?php echo base_url()?>superadmin/user/payment_log"> Bank Processing Payment Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/masterlogreports');?>">Reports Logs</a></td>
                                                
                                            </tr>
                                            <tr>
												<td><a href="<?php echo base_url()?>superadmin/user/awardedList_log"> Awarded List Logs</a></td>												
                                                <td><a href="<?php echo base_url('/superadmin/user/corrigendumlog');?>">Corrigendum Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/bidderforgotpasslog')?>">Bidder Forgot Password Logs</a></td>
                                                <td><a href="<?php echo base_url('/superadmin/user/bidderresetpasslog')?>">Bidder Reset Password Logs</a></td>
                                                 <td><a href="<?php echo base_url()?>superadmin/user/gst_mis_report_registration_fee">GST MIS Report of Registration Fee</a></td>
                                               
                                            </tr>
											<tr>
												<td><a href="<?php echo base_url()?>superadmin/user/gst_mis_report_bank_processing_fee">GST MIS Report of Bank Processing Fee</a></td>
												<td><a href="<?php echo base_url()?>superadmin/user/emd_deposit_report">EMD Deposit Report</a></td>												
                                                <td><a href="<?php echo base_url()?>superadmin/user/emd_refund_report">EMD Refund Report</a></td>
                                                <td></td>
                                                <td></td>
                                                 
                                               
                                            </tr>
											<?php */ ?>
					</table>
                                    </div>
						
				</div>
			</div>
		</div>	
		<?php } ?>
		
		
</section>


