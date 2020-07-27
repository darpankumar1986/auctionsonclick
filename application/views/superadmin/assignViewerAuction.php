<?php
if($getViewerDetails)
{
	foreach($getViewerDetails as $val)
	{
		$vEmailID = $val->email_id;
		$vUserID = $val->user_id;
	}
}
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
.container_12 .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length{padding-top: 0px !important;}
.dataTables_wrapper .dataTables_filter input{width:250px;} 
</style>
<script type="text/javascript">
	var leadArr = [];
        $(document).ready(function() {
			var oTable1 = $('#big_table').dataTable({
					"bAutoWidth": false,
					"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "8%"},  {"sWidth": "8%"}, {"sWidth": "8%"}, {"sWidth": "8%"}],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": '<?php echo base_url(); ?>superadmin/viewer/assignViewerAuctionData/<?php echo $viewerId; ?>/<?php echo $bankid; ?>',
                    "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 4] } ],      
					"sPaginationType": "full_numbers",
					"iDisplayStart ": 10,
					"aaSorting": [[ 4, "desc" ]],
					"oLanguage": {
						"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
					},
					"fnInitComplete": function () {
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
					   
					},
					'fnServerData': function (sSource, aoData, fnCallback)
					{
						$.ajax
								({
									'dataType': 'json',
									'type': 'POST',
									'url': sSource,
									'data': aoData,
									'success': fnCallback
								});
					},
					"fnRowCallback": function (nRow, aData, iDisplayIndex) {
						if(aData[0]!='null')
						{
							var chkInpt = '<input type="checkbox" name="auction_id[]" value="'+aData[0]+'" id="l_'+aData[0]+'" class="lead" />';
						}
						
						$('td:eq(0)', nRow).html(chkInpt);
						return nRow;
					  }
				});		
		});
</script>		
<section class="container_12">
	<div class="box-head">Assign Auction To Viewer</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red; text-align:center;"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	                
					<div class="row">
                        <div class="lft_heading">Organization Name : </div>
                        <div class="rgt_detail"><?php echo $getbankName; ?></div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Viewer Email ID : </div>
                        <div class="rgt_detail"><?php echo $vEmailID; ?></div>					
                    </div>
                    <div class="row">
                        <div class="lft_heading">Viewer User ID : </div>
                        <div class="rgt_detail"><?php echo $vUserID; ?></div>					
                    </div>
				</div>
			</div><!--contentwrapper-->
			<br clear="all" />
		</div><!-- centercontent -->
    <div class="row">
		<div class="wrapper-full">
			<div class="dashboard-wrapper">
				<div class="container tab_content3">
					<div class="secttion-left"></div>
					<div class="secttion-right">
						<div style="color:green;"><br/>	
					    <?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
						<?php } ?>
					</div>
					<form id="meeting" name="meeting" method="post" action="/superadmin/viewer/addViewerAuction"  autocomplete="off">
						<input type="hidden" name="viewerID" id="viewerID" value="<?php echo $viewerId;?>">
						<input type="hidden" name="bankID" id="bankID" value="<?php echo $bankid;?>">
						<div class="table-wrapper btmrg20 tpmrg20">
                            <div class="table-heading btmrg">
								<div class="box-head"><?php echo $heading;?></div>
							</div>
							<div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
								<?php 
										//set table id in table open tag
										$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
										$this->table->set_template($tmpl); 
										
										$this->table->set_heading('ID','Auction ID','Organization ID','Start Date','End Date','Organization Name');	
										echo $this->table->generate(); 
									?> 	
							</div>
                        </div>
						<div class="row btn_row">
						   <input type="submit" name="save" value="Submit" class="button_grey">
						   <a href="/superadmin/viewer/bankviewerList/<?php echo $bankid; ?>" class="button_grey">Back</a>
						</div>
					</div> 
				</form>
			</div>
        </div>
    </div>
</section>
   
