<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<?php 

if($alert){
    $alert_id = $alert->alert_id;
    $alert_type = $alert->alert_type;
    $email_subject = $alert->email_subject;
    $message =   $alert->message;
    $status =   $alert->status; 
} else {
	$alert_type = '';	
	$alert_id = 0;
	if(!empty($_POST)) {		 
		$msg_body =  $_POST['msg_body']; 
	}
	$status = 1;
}
?> 		
<script type="text/javascript">
        $(document).ready(function() 
        {
			$('#auctionLiveReverse th').eq(1).hide();
			var oTable = $('#auctionLiveReverse').DataTable({
					"bAutoWidth": false,
					"aaSorting": [[ 0, "desc" ]],
					"aoColumns": [{"sWidth": "3%"}, {"sWidth": "10%"}, {"sWidth": "8%"},  {"sWidth": "8%"}, {"sWidth": "10%"},{"sWidth": "10%"}, {"sWidth": "7%"}],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/auctionAlertsData/<?php echo $auctionId;?>',
                    "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ],      
					"sPaginationType": "full_numbers",
					"iDisplayStart ": 10,
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
						$('td:eq(1)', nRow).hide();
						return nRow;
					  }
				});
				
				
				$("#freesearch,#search_key").on( 'keyup change', function () {
					$(".advanced_Search_section input").val('');
					var columns_no = $("#search_key").val();
					var search_val = $("#freesearch").val();
					if(columns_no >= 0 && columns_no != '')
					{
						if(columns_no == 0)
						{
							oTable.columns(columns_no).search(search_val).draw();
							oTable.columns(1).search('').draw();
							oTable.columns(2).search('').draw();
							oTable.columns(3).search('').draw();
							oTable.columns(4).search('').draw();
						}
						
						if(columns_no == 1)
						{
							oTable.columns(0).search('').draw();
							oTable.columns(columns_no).search(search_val).draw();
							oTable.columns(2).search('').draw();
							oTable.columns(3).search('').draw();
							oTable.columns(4).search('').draw();
						}
						
						if(columns_no == 2)
						{
							oTable.columns(0).search('').draw();
							oTable.columns(1).search('').draw();
							oTable.columns(2).search('').draw();
							oTable.columns(3).search(search_val).draw();
							oTable.columns(4).search(search_val).draw();							
						}
					}					
									
				});
				
				$("#search_key").on( 'keyup change', function () {
					var columns_no = $("#search_key").val();
					if(columns_no == '')
					{
						oTable.columns(0).search('').draw();
						oTable.columns(1).search('').draw();
						oTable.columns(2).search('').draw();
						oTable.columns(3).search('').draw();
						oTable.columns(4).search('').draw();
						$("#freesearch").val('');						
					}
				});
				
				$(".advanced_Search").click(function(){					
					oTable.columns(1).search('').draw();
					oTable.columns(2).search('').draw();
					oTable.columns(3).search('').draw();
					oTable.columns(4).search('').draw();
					$("#freesearch").val('');
					$("#search_key").val('');
				});
                             	
		});
</script>
<style>
	.alertRadio{width:13px !important;margin:0 !important;}
	.alertText{padding:0 8px 0 2px;}
	.errDiv{color: #ff0000;font-size: 12px;width: 50%;padding-top: 2px;}
	.body_main1{width:85% !important;}
</style>
<section class="body_main1">	
    <!--<div class="row">		
            <a href="<?php //echo base_url().'buyer/sms_template/index'?>" class="button_grey">Alert Messages List</a>
    </div>-->
    <div class="box-head"><?php echo $heading; ?></div>
        <div class="centercontent">			
                    <div class="pageheader">
						<?php if($this->session->flashdata('success_msg') != ""){ ?>
							<div class="success_msg"> <?php echo $this->session->flashdata('success_msg'); ?></div>
						<?php } ?>
						<?php if($this->session->flashdata('err_msg') != ""){ ?>
							<div class="fail_msg"> <?php echo $this->session->flashdata('err_msg'); ?></div>
						 <?php } ?>
                    </div><!--pageheader-->



                    <div id="contentwrapper" class="contentwrapper box-content2">
                        <div id="validation" class="subcontent">            	
                            <form method="post" class="stdform" id="sms_template_form" name="add_data_view" accept-charset="utf-8" action="<?php echo base_url();?>buyer/save_alert_msg/<?php echo $auctionId;?>/<?php echo $alert_id;?>" autocomplete="off">	
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
								<div class="row">
									<div class="lft_heading">Alert Type<span class="red"> *</span></div>
										<div class="rgt_detail">
											<!--<input type="radio" name="alert_type" class="html_found alertRadio" onchange="chngeRadio(this.value)" value="E" <?php echo ($alert_type == 'E' || $alert_type =='')? 'checked':''; ?> /><span class="alertText">Email</span>-->
											<input type="radio" name="alert_type" class="html_found alertRadio" onchange="chngeRadio(this.value)" value="M" <?php echo ($alert_type == 'M' || $alert_type =='')? 'checked':''; ?> /><span class="alertText">Marquee</span>
											<input type="radio" name="alert_type" class="html_found alertRadio" onchange="chngeRadio(this.value)" value="P" <?php echo ($alert_type == 'P')? 'checked':''; ?>/><span class="alertText">Panel Message</span>
											<div class="errDiv alertErr"></div>
										</div>	
										
										
								</div>
								<!--<div class="row emsub">
									<div class="lft_heading">Email Subject<span class="red"> *</span></div>
										<div class="rgt_detail">
											<input maxlength="250" type="text" name="email_subject" id="email_subject" class="longinput html_found" value="<?php echo $email_subject; ?>" />
											<div class="errDiv emailErr"></div>
										</div>	
										
								</div>-->
								<div class="row">
										<div class="lft_heading">Message <span class="red"> *</span></div>
										<div class="rgt_detail">
											<textarea name="msg_body" id="msg_body" rows="5" maxlength="250"><?php echo $message; ?></textarea>
											<div class="errDiv msgErr"></div>
										</div>	
										
								</div>	

								<div class="row">
										<div class="lft_heading">Status<span class="red"> *</span></div>
										<div class="rgt_detail">
										<select name="status">
												<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
												<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
										</select>
										</div>	
								</div>	
								<hr>
								<div class="stdformbutton row" style="text-align:center;">		
									<a href="<?php echo base_url().'buyer/myActivity'?>" class="button_grey">Back</a>			
										<input type="submit"  class="button_grey" name="save" id="addedit" value="<?php echo ($alert_id)?'Update':'Submit'?>">
										

								</div>
							</form>
						</div>
                    </div><!--contentwrapper-->
            <br clear="all" />
    </div><!-- centercontent -->
	<div class="table-wrapper btmrg20">
		<div class="table-heading btmrg">
			<div class="box-head">Alert List</div>
			<!--<div class="srch_wrp2">
			<input type="text" value="Search" id="search" name="search">
			<span class="ser_icon"></span> </div>-->
		</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">
		<div class="container-outer">
			<div class="container-inner">
				<?php 
				//set table id in table open tag
				$tmpl = array ( 'table_open'  => '<table id="auctionLiveReverse" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
				$this->table->set_template($tmpl); 

				$this->table->set_heading('Sr. No.','Email Subject','Message', 'Display Page', 'Alert Type', 'Status','Actions' );	
				echo $this->table->generate(); 
				?>
			</div>
		</div>
	</div>
</section>




<script>
<?php if($alert->alert_id > 0){ ?>
	$(document).ready(function(){
		chngeRadio('<?php echo $alert->alert_type; ?>');
	});	
<?php } ?>
 $(document).on('click','#addedit',function(){
	var alert_type = $(".alertRadio:checked").val();
	//var email_subject = $("#email_subject").val().trim();
	var msg_body = $("#msg_body").val().trim();
	var err = false;
	
	
	if(!$(".alertRadio").is(':checked'))
	{
		$('.alertErr').html('Please select Alert Type');
		err = true;
	}
	if(alert_type == 'E' && email_subject == '')
	{
		$('.emailErr').html('Please Enter Email Subject');
		err = true;
	}
	if(msg_body == '')
	{
		$('.msgErr').html('Please Enter Message');		
		err = true;
	}
	
	if(err)
	{
		return false;
	}
	
 });
 $(document).on('focus','#email_subject, #msg_body',function(){
	 $(this).next('div').html('');
	 
 });	
 
 $(document).on('change','.alertRadio',function(){	  
	
	 $('.alertErr').html('');
	 //alert();
	 
 });
 
function chngeRadio(alertType)
{	
	 if(alertType == 'E')
	 {
		 $('.emsub').css('display','block');
	 }
	 else
	 {
		 $('.emsub').css('display','none');
		 $(".emailErr").html('');
	 }
}
<?php if($auctionId > 0){ ?>
function alert_rmv(alertId = 0)
{	
	swal({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!'
}).then(function () {
	
	 $.ajax({
			 //base_url().'buyer/auction_alert_msg/$1/$2/delete 
			url: "/buyer/deleteAuctionAlert/<?php echo $auctionId; ?>/"+alertId+"/delete",
			type: "get",			
			success: function (results) {				
				if (results == '1')
				{
					window.location.reload(true);
					//alert('success');
					//swal('Deleted!','Alert added successfully.','success')					
				} else {
					//alert('error');
					swal('Error', 'Unable to delete Alert', 'error');
				}
				
			}
		});
  
		}, function (dismiss) {
		  // dismiss can be 'cancel', 'overlay',
		  // 'close', and 'timer'
		  if (dismiss === 'cancel') {
			swal('Cancelled','Alert not deleted','error')
		  }
		});
	

	
}
<?php } ?>
/*	
jQuery(document).ready(function(){
	jQuery("#sms_template_form").validate({
        ignore: [],
		rules: {	
			alert_type: "required",
			alert_type: "required",
			msg_body: "required"
		},
		messages: {
			msg_body: {
				required: "Please enter message"
			}
		}
		
		
	});
});	
*/
</script>
