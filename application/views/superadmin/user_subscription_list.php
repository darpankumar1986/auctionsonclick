<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<style>
	.usrBtn:hover{background-color: #807c7c;color:#ffffff;} 
	.usrBtn:focus{background-color: #807c7c !important;color:#ffffff !important;} 
</style>
<section class="container_12">
    <?php
     if(isset($_POST['from_date']) and !empty($_POST['start_date']))
        {
        $from_date=$_POST['from_date'];
      }
     if(isset($_POST['to_date']) and !empty($_POST['to_date'])){
        $to_date=$_POST['to_date'];
     }
    ?>
<?php if( $this->session->flashdata('message')){  ?>
<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">&nbsp;<?php echo $this->session->flashdata('message'); ?></span>
<?php } ?>		
<div class="box-head">User Subscription Listing</div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="GET"  id="searchfm" name="searchfm" onsubmit="return validateform();">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
			        <tbody>
                                        <tr>
                                          
                                           <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
										<label><strong>Email ID: </strong></label><input type="text" value="<?php echo $email_id;?>" id="email_id" name="email_id">
											</td>
                                      <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
                                          <input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
                                      </td>
                                     </tr>
                                     <tr>
									  
                                      
                                       
			        </tbody>
			</table>
		<input type="hidden" name="controller" id="controller" value="user" />
               
		<div class=" no-pad">
			<div class="container-outer">
				<div class="container-inner">
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">
			<colgroup>
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />				
			</colgroup>
			<thead>
			     <tr>
                                <th class="head0">S.No.</th>
                                <!--<th class="head1">Log ID</th>-->
                                <th class="head1">User Name</th>
                                <th class="head1">Register As</th>
                                <th class="head1">Email ID</th>
                                 <th class="head1">Mobile Number</th>
                                 <th class="head1">Registered On</th>
                                 <!--<th class="head1">Payment Mode</th>
                                 <th class="head1">UTR No.</th>-->
                                <th class="head1">Status</th>
                                <th class="head1">Action</th>
                              </tr>
			</thead>
			<tbody id="Change_main_data">
				<?php 
                                if($this->uri->segment(4)!=''){
                                $i=($this->uri->segment(4)-1)*10;
                                }else{ 
                                 $i=0;
                                }
                               // echo '<pre>';
                               // print_r($records);die;
                                foreach($records as $data){ $i++;?>
			          <tr class='gradeA'>
                                  <td><?php echo $i; ?></td>
                                  <!--<td><?php echo $data->id; ?></td>-->
                                  <td><?php echo ($data->user_type == 'builder') ? $data->organisation_name : $data->first_name.' '.$data->last_name;?></td>
                                  <td><?php echo ($data->user_type == 'builder') ? 'Organization':'Individual';?></td>
                                  <td><?php echo $data->email_id;?></td>
                                  <td><?php echo $data->mobile_no;?></td>
                                  <td><?php echo $data->indate;?></td>
                                  <!--<td><?php echo ($data->payment_mode==1)?'Online':'Offline';?></td>
                                  <td><?php echo ($data->payment_mode==1)?'N/A':$data->utr_no;?></td>-->
                                  <td><?php echo ($data->status==1)?'<span style="font-weight:bold;color:green;">Activated</span>':'<span style="font-weight:bold;color:red;">Inactive</span>';?></td>
                                  <td><a href="<?php echo base_url()?>superadmin/user/user_subscription_logs/<?php echo $data->id;?>" style="color:blue;">View</a></td>
                                  
                                  
                                </tr>
				<?php }?>	
			  </tbody>
		    </table>
	         </div>
	       </div>
		<div class="pagination">
                     <span style="float:left;padding-top:9px;"><?php echo $total_rows; ?></span>
                   <span style="float:left">
                       <!--<input type="submit" name="submit" value="Download" class="button_grey">-->
                       <a href="<?php echo base_url(); ?>superadmin/home" class="button_grey">Back</a>
                       &nbsp;
                   </span>
                   <span style="float:right;padding-top:9px;"><?php echo $pagination_links; ?></span>
		</div>
	     </div>
            <!-- #updates -->
        </form>
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->

</section>
<script>
jQuery(document).ready(function() {
   
      jQuery('#start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
       
    });
    function validateform(){  
        return true;
     /*    if(jQuery("#start_date").val()==''){
              alert("Please Select Start Date");
                 return false;
         }else if(jQuery("#start_date").val()!=''){
             if(jQuery("#end_date").val()==''){
                 alert("Please Select To Date");
                 return false;
             }
        }
        */
    }
    
    function changelog(id){  
      
        jQuery.ajax({url: "<?=base_url();?>superadmin/user/ajaxCorrigndumrender",data:{type:id.value},dataType:'post', success: function(result){
                alert(result);
        jQuery("#Change_main_data").html(result);
    }});
        
    }
</script>


    
