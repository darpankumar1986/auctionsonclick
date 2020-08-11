<section class="container_12">
    <?php
       if(isset($_POST['from_date']) and !empty($_POST['start_date'])){
        $from_date=$_POST['from_date'];
        }
     if(isset($_POST['to_date']) and !empty($_POST['to_date'])){
        $to_date=$_POST['to_date'];
     }
    ?>
<?php if( $this->session->flashdata('message')){  ?>
<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick"><?php echo $this->session->flashdata('message'); ?></span>
<?php } ?>		
<div class="box-head"><?=$heading;?></div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div>
       <!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="POST"  id="searchfm" name="searchfm" onsubmit="return validateform();">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
			        <tbody>
                                        <tr>
                                          <td style="width:24%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">
                                           <label><strong>Sub Module</strong></label><select name="Change_status" id="Change_status"><?=$subcatdata;?></select>
                                          </td>
                                           <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
                                           <label><strong>From Date</strong></label><input type="text" id="start_date" value="<?php echo $from_date;?>" name="from_date">
                                           </td>
                                           <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
                                           <label><strong>To Date</strong></label><input type="text" value="<?php echo $to_date;?>" id="end_date" name="to_date">
                                         
                                        </td>
                                      
                                     </tr>
                                     <tr>
                                      <td style="width:24%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">
                                           <label><strong>Auction ID</strong></label>
                                          <input type="text" value="<?=$auctionId;?>" name="auctionId" id="auctionId">
                                       </td>
                                       <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
                                           <label><strong>Event Id</strong></label>
                                             <input type="text" value="<?=$eventId;?>" name="eventId" id="eventId">
                                       </td>
                                        <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
                                          <label><strong> User Id</strong></label>
                                         <input type="text" id="createdby" value="<?=$createdby; ?>" name="createdby">
                                       </td>
                                       <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
                                          <input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
                                      </td>
                                     </tr>
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
                                <th class="head0">S.No</th>
                                <th class="head1">Log ID</th>
                                <th class="head1">Activity Name</th>
                                <th class="head1">Operation</th>
                                <th class="head1">Auction Log ID</th>
                                <th class="head1">AuctionID</th>
                                <th class="head1">ClientAddress</th>
                                <th class="head1">Date</th>
                                <th class="head1">UserID</th> 
                                <th class="head1">UserCategory</th>
                                <th class="head1">BankName</th>
                              </tr>
			</thead>
			<tbody id="Change_main_data">
				<?php $i=0;foreach($records as $data){ $i++;?>
			          <tr class='gradeA'>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $data->id; ?></td>
                                  <td><?php if($data->activity_done!=''){
                                  echo $data->activity_done;
                                  }
                                  ?>
                                  </td>
                                  <td><?php echo $data->bid_type;?></td>
                                  <td><?php echo $data->eventID;?></td>
                                  <td><?php echo $data->auctionID;?></td>
                                  <td><?php echo $data->ip_address;?></td>
                                  <td><?php echo $data->indate; ?></td>
                                  <td><?php echo $data->bidderID; ?></td>
                                  <td><?php echo $data->usercategory; ?></td>
                                  <td><?php echo $data->bankname; ?></td>
                                </tr>
				<?php }?>	
			  </tbody>
		    </table>
	         </div>
	       </div>
		<div class="pagination">
                     <span style="float:left;padding-top:9px;"><?php echo $total_rows; ?></span>
                   <span style="float:left">
                       <input type="submit" name="submit" value="Download" class="button_grey">
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


    
