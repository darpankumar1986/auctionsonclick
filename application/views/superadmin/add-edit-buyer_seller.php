<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$buyer_name=$row->buyer_name;
	$stock_name=$row->stock_name;
	$action=$row->action; 
	$quantity=$row->quantity;
	$rate=$row->rate; 
	$holds=$row->holds;
	$transaction_date=$row->transaction_date;
	$status=$row->status; 
	$created_by=$row->created_by; 
	$date_created=$row->date_created; 
}
else{
	$status = 1;
	$id = 0;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="author" name="add_data_view" accept-charset="utf-8" action="/superadmin/buyer_seller/save">	
				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="buyer_name" id="buyer_name" class="longinput" value="<?php echo $buyer_name?>" />
					</span>					
				</p>
				<p>
					<label>Stock name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="stock_name" id="stock_name" class="longinput" value="<?php echo $stock_name?>" />
					</span>					
				</p>
				<p>
					<label>Action</label>
					<span class="field">
					<select name="action">
						<option value="1" <?php if($action==1)echo 'selected';?>>Bought</option>
						<option value="0" <?php if($action==0)echo 'selected';?>>Sold</option>
					</select>
					</span>
				</p>
				<p>
					<label>Quantity<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="quantity" id="quantity" class="longinput" value="<?php echo $quantity?>" />
					</span>					
				</p>
				<p>
					<label>Per Share Rate<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="rate" id="rate" class="longinput" value="<?php echo $rate?>" />
					</span>					
				</p>
				<p>
					<label>Holds<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="holds" id="holds" class="longinput" value="<?php echo $holds?>" />
					</span>					
				</p>
				<p>
					<label>Status</label>
					<span class="field">
					<select name="status">
						<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
						<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
					</select>
					</span>
				</p>	
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" id="addedit" value="Submit">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#category").validate({
		rules: {
			name: required,
			image: {
				accept: "png|jp?g|gif"
			},
			priority: {
				number: true
			}
		},
		messages: {
			name: {
				required: "Please enter name",
			},
			image: {
				accept: "Please select a valid image"
			}
		}
	});
});	
</script>
