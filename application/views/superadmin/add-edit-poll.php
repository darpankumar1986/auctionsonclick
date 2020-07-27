<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){	
	$id=$row->id; 
	$poll_type=$row->poll_type; 
	$poll_question=$row->poll_question; 
	$status=$row->status; 
	$created_by=$row->created_by; 
	$date_created=$row->date_created; 
	$date_modified=$row->date_modified; 
	$status=$row->status; 
	$priority=$row->priority; 
	$date_published=$row->date_published; 
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
			<form enctype="multipart/form-data" method="post" class="stdform" id="poll" name="poll" accept-charset="utf-8" action="/superadmin/poll/save">	
				
				<p>
					<label>Poll Question<font color='red'>*</font></label>
					<span class="field">
						<textarea name="poll_question" id="poll_question" rows="3" cols="60" ><?php echo $poll_question?></textarea>
						<label class="error" style="display:none;">Please enter Short Story</label>
					</span>					
				</p>
				
				<div id="container">				
				<?php
				$mode="edit";
				if(count($option_records)>0 && $option_records!=''){ 
				$i=0;
				foreach($option_records as $key=>$records){ 
				$i++;				
				?>
				<p>
					<label>Option Name <?php echo $i; ?></label>
					<span class="field">
						<input type="text" name="option_name[]" id="option_name <?php echo $i; ?>" class="longinput" value="<?php echo $records->option_name; ?>" />
						<input type="hidden" name="option_id[]" id="option_id<?php echo $records->id; ?>" value="<?php echo $records->id; ?>">
					</span>					
				</p>				
				<?php } }else{ $mode="add";
				for($i=1; $i<=4; $i++){ ?>
				<p>
					<label>Option Name <?php echo $i; ?></label>
					<span class="field">
						<input type="text" name="option_name[]" id="option_name<?php echo $i; ?>" class="longinput" value="<?php echo $option_name?>" />						
					</span>					
				</p>
				<?php } }?>			
				
				<div class="content-section">
				
				
				
				</div>
				</div>				
				<p style="text-align:right; width:88%;"><input type="button" name="addmore" id="addmore" value="Add More" onclick="add(<?php echo $i; ?>,'<?php echo $mode; ?>');" /></p>
				
				<p>
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
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
	jQuery("#poll").validate({
	alert("oks");
		rules: {
			poll_question: "required",
			//option_name1: "required",
			//option_name2: "required",	
		},
		messages: {
			poll_question: "Please enter article title"
		}
	});
});
</script>




<script>


//var inc = 5;

function add(cnt,mode){

if(mode=="edit"){
var inputFormDiv = document.getElementById('container');
var count = (inputFormDiv.getElementsByTagName('input').length);
var inc = ((count/2)+1);

	p1 = jQuery('<p><label>Option Name '+inc+'</label><span class="field"><input type="text" id="option_name'+inc+'" name="option_name[]" class="" value="" /></span></p><input type="hidden" name="option_id[]" id="option_id'+inc+'" value="">'); 
	jQuery(".content-section").append(p1);
	inc++;

}else if(mode=="add"){
	var inputFormDiv = document.getElementById('container');
	var count = (inputFormDiv.getElementsByTagName('input').length);	
	var inc = (count+1);
	
	p1 = jQuery('<p><label>Option Name '+inc+'</label><span class="field"><input type="text" id="option_name'+inc+'" name="option_name[]" class="" value="" /></span></p>'); 
	jQuery(".content-section").append(p1);
	inc++;
}


  
};
</script>


