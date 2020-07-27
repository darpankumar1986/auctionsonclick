<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>

<?php 
if($row){
	$id=$row->id; 
	$msg_role=$row->msg_role;
	$msg_from=$row->msg_from;
	$msg_to=$row->msg_to;
	$msg_body=$row->msg_body; 
}else{
	$status = 1;
	$show_home = 0;
	$menu_item = 0;
	$slug = '';
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
			<span class="pagedesc" style="color:red; text-align:center;">
		<?php echo $this->session->flashdata('message'); ?>
		</span>	
            <form enctype="multipart/form-data" method="post" class="stdform" id="message" name="message" accept-charset="utf-8" action="/superadmin/message/save">	
                    
                    <p>
                        <?php //echo '<pre>', print_r($this->session->all_userdata()), '</pre>'; ?>
                        <?php ($this->session->userdata('aemail')); ?>
                        <?php //echo '<pre>', print_r($this->session->userdata('adminid')), '</pre>'; ?>
                        <?php $get_user_data; ?>
                        <?php $msg_from.'<br />'; ?>
                        <?php $msg_to.'<br />'; ?>
                    </p><?php
                    
                    if(empty($msg_from)){ ?>
                        <script>
                        function lookup(inputString) {
                          usertype=jQuery("input[name='usertype']:checked").val();
                            if(inputString == ''){
                               
                                setTimeout("jQuery('#suggestions').hide();", 200);
                                
                            } else {
                                jQuery.post("/superadmin/message/autocomplete", {name: ""+inputString+"",usertype:usertype}, function(data){
								     if(data.length > 0) {
                                        
                                        jQuery('#suggestions').show();
                                        jQuery('#autoSuggestionsList').html(data+', ');
                                    }else{
                                        setTimeout("jQuery('#suggestions').hide();", 200);
                                    }
                                });
                            }
                        }

                        function fill(id, thisValue){
                            id_msg_to=jQuery('#id_msg_to').val();
							if(id_msg_to)
							{
								jQuery('#id_msg_to').val( id_msg_to+','+id);
							}else{
								jQuery('#id_msg_to').val(id);
							}
                            
							
							
                            strVal=jQuery('#id_input').val();
							strcomma=strVal.indexOf(",");
							if(strcomma>0)
							{
								fval=strVal.lastIndexOf(",");
								res = strVal.substring(0,fval+1);
								jQuery('#id_input').val(res+thisValue+' ,');
							}else{
								jQuery('#id_input').val('');
								jQuery('#id_input').val(thisValue+' ,');	
							}
                            
                            setTimeout("jQuery('#suggestions').hide();", 200);
                        }
                        function flashdata(vale){
							usertypeval=jQuery('#usertypeval').val();
							if(vale!=usertypeval){
								jQuery('#id_input').val('');
								jQuery('#usertypeval').val(vale);
							}
						}
                        </script>
                        
                        <style>
                            #suggestions {
                                background: #fff none repeat scroll 0 0;
                                border: 1px solid #c0c0c0;
                                float: left;
                                position: absolute;
                                width: 86.1%;
                                z-index: 100;
                                display: none;
                            }
                            
                            #suggestions li{
                                list-style-type: none;
                            }
                            
                        </style>
                        <p>
                        <label>User Type <font color='red'>*</font></label>
                        <span class="field">
						<input checked  type="radio" onclick="flashdata(this.value);" name="usertype" name="usertype" class="usertype" value="bidder"> : Bidder 
						<input type="radio" name="usertype" onclick="flashdata(this.value);" class="usertype" value="banker"> : Banker 
						</span>
						<input type="hidden" id="usertypeval" value="bidder" >
						</p>
						
                            <label>To<font color='red'>*</font></label>
                            
                            <span class="field">
                                <input autocomplete="off"  maxlength="100" name="name" id="id_input" type="text" onKeyUp="lookup(this.value);">
                                <div id="suggestions">
                                    <!--<img src="<?php echo base_url(); ?>upArrow.png">-->
                                    <div class="alonginput" id="autoSuggestionsList"></div>
                                </div>
                                <input type="hidden" name="msg_to" id="id_msg_to" class="longinput" value="" />
                            </span>
                            <?php /*<span class="field">
                                <select name="msg_to">
                                    <option value="">-- Select --</option><?php

                                    if(!empty($get_user_data)){

                                        foreach($get_user_data as $user_tmp_data){?>

                                            <option value="<?php echo $user_tmp_data->id; ?>"><?php echo $user_tmp_data->first_name.' '.$user_tmp_data->last_name.' ('.$user_tmp_data->email_id.')'; ?></option><?php
                                        }
                                    }?>
                                </select>*/ ?>
                            </span>
                        </p><?php
                        
                    }else{?>
                        
                        <input type="hidden" name="msg_role" value="<?php echo $msg_role; ?>">
                        <input type="hidden" name="msg_from" value="<?php echo $msg_from; ?>">
                        <input type="hidden" name="msg_to" value="<?php echo $msg_to; ?>"><?php
                    }?>
                    
                    <p>
                        <label>Message<font color='red'>*</font></label>
                        <span class="field"><textarea  maxlength="500" name="msg_body" ><?php echo $msg_body; ?></textarea></span>
                    </p>

                    <p class="stdformbutton">					
                        <input type="submit"  name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <input type="hidden" name="menu_item" id="menu_item" value="<?php echo $menu_item ?>">
                    </p>
            </form>
        </div>
    </div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#message").validate({
		rules: {         
			name: {
				required: true,
				//email: true
			},
              msg_body: {
                required: true
			}             
		},
		messages: { 
			name: {
				required: "Please enter email",
				//email: "Please valid email"
			},
                        
			msg_body: {
				required: "Please enter Message"
			}
			
		}
	});
});	
</script>


