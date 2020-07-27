<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/message/<?php if($type != 'main'){echo 'addedit';}else{echo 'addeditmain';}?>" class="b_green"><strong>Add New</strong></a>	</span></h1>
		<span class="pagedesc" style="color:red; text-align:center;"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
        
	<div id="contentwrapper" class="contentwrapper">
            
	<form method="post" action="">
		<input type="hidden" name="controller" id="controller" value="message" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable">
			<colgroup>
				<col class="con0" />
				<col class="con1" />
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
                                <th class="head0">ID</th>
                                <th class="head1">From (Role)</th>
                                <th class="head1">To (Role)</th>
                                <!--<th class="head0">Priority</th>-->
                                <th class="head0">Message</th>
                                <th class="head0">Message Status</th>
                                <th class="head1">Message Create DateTime</th>
                               <!-- <th class="head1">Actions</th>-->
                            </tr>
                        </thead>

                        <tbody><?php 
                        
                            $i = 0;
                            
                            foreach ($records as $data){
                                $i++; ?>
                            
                                <tr class='gradeA'>
                                    <td><?php echo $data->id; ?></td>
                                    
                                    <td>C1India</td>
                                    
                                    <td><?php 
                                    
                                    if($data->user_type=='banker') 
									{
										$table='tbl_user';
									}else{
										$table='tbl_user_registration';
									}
                                    
                                        echo GetTitleById($table,$data->msg_to,'first_name').' '.GetTitleById($table,$data->msg_to,'last_name').' ('.$data->user_type.'-'.GetTitleById($table,$data->msg_to,'user_type').')'; ?>
                                    </td>
                                    
                                    <td><?php echo $data->msg_body; ?></td>
                                    <td><?php echo ($data->msg_status == 1) ? 'Read' : 'Unread'; ?></td>
                                    <td><?php GetDateFormat($data->msg_created_datetime); ?><?php echo ($data->msg_created_datetime); ?></td>
                                    <!--<td><a href="/superadmin/message/reply_msg/<?php //echo $data->id; ?>"><strong>reply</strong></a></td>-->
                                </tr>
                        <?php } ?>	

                        </tbody>
		</table>
		<div class="pagination">
			<?php echo $pagination_links;?>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
<script>
    
jQuery(document).ready(function() {
    
    jQuery('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            jQuery('.status12').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
				jQuery(this).parent().addClass('checked');
				
            });
        }else{
            jQuery('.status12').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1" 
				jQuery(this).parent().removeClass('checked');
            });        
        }
    });
   
});
function checkSelection()
{
	var flag=false;
	jQuery('.status12').each(function() { //loop through each checkbox
		if(this.checked)
		 flag=true;		
	});
	if(flag)
	{
	 return true;
	}
	else
	{
		alert('Select any one.');
		return false;
	}
}
</script>


    
