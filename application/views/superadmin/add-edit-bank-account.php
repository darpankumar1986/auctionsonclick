
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>

<style>
    .readonly {
    background: #ddd !important;
}
</style>

<?php 

if($row){
    $organization_id    = $row->organization_id;
    $bank_account_id    = $row->bank_account_id;
    $account_nick_name  = $row->account_nick_name;
    $account_holder_name= $row->account_holder_name;
    $bank_name          = $row->bank_name;
    $ifsc_code          = $row->ifsc_code;
    $account_number     = $row->account_number;
    $status             = $row->status;
}
else
{	
    $bank_account_id = 0;
    if(!empty($_POST)) {
        $organization_id    = $_POST['organization'];
        $account_nick_name  = $_POST['account_nick_name'];
        $account_holder_name= $_POST['account_holder_name'];
        $bank_name          = $_POST['bank_name'];
        $ifsc_code          = $_POST['ifsc_code'];
        $account_number     = $_POST['account_number'];
    }
    $status = 1;
}?> 		
<section class="body_main1">	
    <div class="row">		
            <a href="<?php echo base_url().'superadmin/bank_account/index'?>" class="button_grey">Bank Account List</a>
    </div>
    <div class="box-head"><?php echo $heading; ?></div>
        <div class="centercontent">
                    <div class="pageheader">
                            <span class="pagedesc"><div style="color:red"><?php //echo validation_errors(); ?></div></span>
                    </div><!--pageheader-->



                    <div id="contentwrapper" class="contentwrapper box-content2">
                        <div id="validation" class="subcontent">            	
                            <form method="post" class="stdform" id="bank_account_form" name="add_data_view" accept-charset="utf-8" action="/superadmin/bank_account/save/<?php if($bank_account_id) echo $bank_account_id;?>" autocomplete="off">	

                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                                    <div class="row">
                                        <div class="lft_heading">Organization<span class="red"> *</span></div>
                                        <div class="rgt_detail" > 
                                            <select name="organization" id="organization" class="select" <?php echo (($bank_account_id != '')? 'disabled': '');?>>
                                               <!-- <option value="">Select</option> -->
                                                <?php
                                                    foreach($organization as $org_type){ ?>
                                              
                                                   <option value="<?php echo $org_type->id; ?>" <?php echo ($org_type->id==$organization_id)?'selected':''; ?>><?php echo $org_type->name; ?></option>
                                                <?php }?>
                                            </select>
                                            <?php if($bank_account_id != ''): ?>
                                            <input type="hidden" name="organization" value="<?php echo $organization_id; ?>" />
                                            <?php endif; ?>
                                             <?php echo form_error('organization'); ?>
                                        </div>	
                                    </div>	
                                
                                    <div class="row">
                                        <div class="lft_heading">Account Holder Name<span class="red"> *</span></div>
                                        
                                            <div class="rgt_detail">
                                                <input  type="text" name="account_holder_name" id="account_holder_name" class="longinput html_found" value="<?php echo $account_holder_name; ?>" <?php echo (($bank_account_id != '')? 'readonly': '');?>/>
                                                <?php echo form_error('account_holder_name'); ?>
                                            </div>	
                                        
                                    </div>

                                    <div class="row">
                                        <div class="lft_heading">Account Nick Name<span class="red"> *</span></div>
                                            <div class="rgt_detail">
                                                    <input maxlength="100" type="text" name="account_nick_name" id="account_nick_name" class="longinput html_found" value="<?php echo $account_nick_name ; ?>" <?php echo (($bank_account_id != '')? 'readonly': '');?>/>
                                                    <?php echo form_error('account_nick_name'); ?>
                                            </div>	

                                    </div>
                                    <div class="row">
                                        <div class="lft_heading">Bank Name<span class="red"> *</span></div>
                                            <div class="rgt_detail">
                                                    <input maxlength="100" type="text" name="bank_name" id="bank_name" class="longinput html_found" value="<?php echo $bank_name; ?>" <?php echo (($bank_account_id != '')? 'readonly': '');?>/>
                                                    <?php echo form_error('bank_name'); ?>
                                            </div>	
                                       
                                    </div>
                                    <div class="row">
                                        <div class="lft_heading">Account Number<span class="red"> *</span></div>
                                            <div class="rgt_detail">
                                                    <input maxlength="18" type="text" name="account_number" id="account_number" class="longinput html_found numericonly_1" value="<?php echo $account_number; ?>" <?php echo (($bank_account_id != '')? 'readonly': '');?>/>
                                                    <?php echo form_error('bank_name'); ?>
                                            </div>	
 
                                    </div>
                                    <div class="row">
                                        <div class="lft_heading">IFSC Code<span class="red"> *</span></div>
                                            <div class="rgt_detail">
                                                    <input maxlength="11" minlength="11" type="text" name="ifsc_code" id="ifsc_code" class="longinput html_found" value="<?php echo $ifsc_code; ?>" <?php echo (($bank_account_id != '')? 'readonly': '');?>/>
                                                    <?php echo form_error('ifsc_code'); ?>
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
                                            <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
                                                <input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($bank_account_id)?'Update':'Submit'?>">
                                                <input type="hidden" name="bank_account_id" id="bank_account_id" value="<?php echo $bank_account_id; ?>">

                                        </div>
                                    </form>
                            </div>
                    </div><!--contentwrapper-->
            <br clear="all" />
    </div><!-- centercontent -->
</section>



<script>
jQuery(document).ready(function(){
    
    jQuery(".numericonly_1").keydown(function (e) { 
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    
    
    jQuery("#bank_account_form").validate({
        ignore: [],
        rules: {
            organization: "required",
            account_holder_name: "required",
            account_nick_name: "required",		
            bank_name: "required",
            account_number: {
                required: true,
                digits: true,
                maxlength: 18,
            },
            ifsc_code:{
                required: true,
                minlength: 11,
                maxlength: 11,
            } 
        },
        messages: {
            organization: {
                    required: "Please select organization name."
            },
            account_holder_name: {
                    required: "Please enter account holder  name."
            },
            account_nick_name: {
                required: "Please enter account nick name."
            },
             bank_name: {
                required: "Please enter bank name."
            },
             account_number: {
                required: "Please enter account number.",
                digits: "Please enter valid account number.",
                maxlength: "Please enter valid account number."
            },
            ifsc_code: {
                required: "Please enter bank IFSC code.",
                minlength: "Please valid IFSC code.",
                maxlength: "Please valid IFSC code."
            }
        }

    });
});	
</script>
 
