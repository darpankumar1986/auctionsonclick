<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>


<section class="body_main1">
<div class="centercontent">

	
	<div class="box-head">Upload Bidder</div>
	
	<div class="pageheader">
	</div><!--pageheader-->
	

    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">            	
	
			<form enctype='multipart/form-data' action='' method='post'>
				
			
				<div class="row">
					<div class="lft_heading">File name to import: <span class="red"> *</span></div>
					<div class="rgt_detail">
						<input size='50' type='file' name='filename'>
					</div>					
				</div>
				<br/>
				<div class="row">
					<div class="lft_heading">Sample File (CSV FILE ONLY): </div>
					<div class="rgt_detail">
						<a hreh="<?php echo base_url()."sample.csv"; ?>">Sample CSV File</a>
					</div>					
				</div>
				<div class="row">
					<div class="lft_heading">File Parameters: </div>
					<div class="rgt_detail">
						<b>First Name, Last Name, Email, Mobile No, Address, Country ID, State ID, City ID</b>
					</div>					
				</div>

				<hr>
				<div class="stdformbutton row" style="text-align:center;">				
					<input type="submit"  name="addedit" id="addedit" class="button_grey" value="Upload">
	
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>

