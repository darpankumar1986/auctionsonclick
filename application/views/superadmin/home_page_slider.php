<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/home_page_slider/addedit" class="b_green"><strong>Add Slider</strong></a></span></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="POST" id="searchfm" name="searchfm">
			
		
		<br>
		<?php //search ends ?>
	
		<input type="hidden" name="controller" id="controller" value="home_page_slider" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
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
					<th class="head1">Title</th>
					<th class="head0">Description</th>
                    <th class="head0">Image</th>
                    <th class="head0">Status</th>
					<th class="head1"><input type="checkbox" id="selecctall1"/> Select</th>
					<th class="head1">Added Date</th>
					<th class="head1">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->title; ?></td>
						<td><?php echo $data->description; ?></td>
						<td>
						
						<img width="120" height="120"  src="<?php base_url()?>/public/uploads/home_page_slider/<?php echo $data->image; ?>"
						</td>
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
						<td><?php echo GetDateFormat($data->indate); ?></td>
						<td>
                                                    <a href="/superadmin/home_page_slider/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a>
						
						 <!--| <a href="#" Onclick="return ConfirmDelete(<?php echo $data->id; ?>);"><strong>Delete</strong></a>-->
						</td>
					</tr>
				<?php }?>	
				
			</tbody>
		</table>
		<div class="pagination">
			<span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all"></span>
			<span style="float:right"><?php //echo $pagination_links; ?></span>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
<script>
     function ConfirmDelete(id){
      var x = confirm("Are you sure you want to delete?");
      if (x)
          jQuery.ajax({
              type:"post",
             url:"/superadmin/home_page_slider/delete" ,
             data:"id="+id,
             success:function(return_data){
                 if(return_data == 1){
                 var delay=1000//2 seconds
                    setTimeout(function(){
                         location.reload();
                    },delay)
                 }
             }
          });
    }
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
	jQuery(".pagination ul li a").click(function() {
			frm = jQuery('#searchfm');
			frm.attr("action", jQuery(this).attr("href"));
			jQuery(this).attr("href", "javascript:void(0)");
			//jQuery('#searchfm').submit();
			jQuery('#btnSearch').click();
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


    
