<section>
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> </div>
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <div id="tab7" class="tab_content3">
              <div class="container">
                <div class="secttion-left">
				 <div class="left-widget">
                  <div class="auction-category-heading">My Message
                    <div class="arrow-down"></div>
                  </div>
                  <div class="continer">
                    <ul>
                      <!--<li> <a href="/banker/myMessage"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon1.png"></span> Inbox</a></li>-->
                      <li> <a href="/buyer/myMessage"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon2.png"></span><?php echo BRAND_NAME; ?></a></li>
                      <li> <a href="/buyer/myMessageUser"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon3.png"></span> User</a></li>
                      <!--<li> <a href="#"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon4.png"></span> Send</a></li>-->
                      <li> <a href="/buyer/myMessageTrash"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon5.png"></span> Trash</a></li>
                    </ul>
                  </div>
                  </div>
                </div>
                
                  <div class="secttion-right">
                      
                      <div id="contentwrapper" class="contentwrapper">

<?php 
if($row){
	$id=$row->id; 
	$msg_role=$row->msg_role;
	$msg_from=$row->msg_from;
	$msg_to=$row->msg_to;
	$msg_body=$row->msg_body; 
}
else{
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
            
            <a href="/buyer/myMessage">Cancel</a>
            
            
            <form enctype="multipart/form-data" method="post" class="stdform" id="message" name="add_data_view" accept-charset="utf-8" action="/buyer/myMessage_save"><?php
            
                if($this->session->flashdata('message_validation')){?>

                    <dl style="color: red;">
                        <?php echo $this->session->flashdata('message_validation'); ?>
                    </dl><?php
                }
                    
                    if(empty($msg_from)){?>
                    
                    <script src="<?php echo base_url(); ?>js/jquery.min_2.js"></script>
                    
                        <script>
                            
                        function lookup(inputString) {
                            
                            //alert(inputString);
                            //return false;
                            
                            $('#id_msg_to').val('');
                            
                            if(inputString == ''){
                                
                                $('#id_msg_to').val('');
                                setTimeout("$('#suggestions').hide();", 200);
                                
                            } else {
                                $.post("/banker/myMessage_autocomplete", {name: ""+inputString+""}, function(data){
                                    if(data.length > 0) {
                                        
                                        $('#suggestions').show();
                                        $('#autoSuggestionsList').html(data);
                                    }else{
                                        setTimeout("$('#suggestions').hide();", 200);
                                    }
                                });
                            }
                        }

                        function fill(id, thisValue){
                            
                            //alert(id);
                            //alert(thisValue);
                            
                            $('#id_msg_to').val(id);
                            $('#id_input').val(thisValue);
                            setTimeout("$('#suggestions').hide();", 200);
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
                        
                            <label>To<font color='red'>*</font></label>
                            
                            <span class="field">
                                <input name="name" id="id_input" type="text" onKeyUp="lookup(this.value);">
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
                        <span class="field"><textarea name="msg_body" ><?php echo $msg_body; ?></textarea></span>
                    </p>

                    <p class="stdformbutton">					
                        <input type="submit"  name="addedit" id="addedit" value="SEND">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <input type="hidden" name="menu_item" id="menu_item" value="<?php echo $menu_item ?>">
                    </p>
            </form>
        </div>
    </div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->









</div>
                      
                      
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
                      
                  </div>
                  
              </div>
            </div>
            
            <!-- #tab2 -->
            
            <div id="tab8" class="tab_content3">
              <div class="container">
                <div class="secttion-left">
                  <div class="auction-category-heading">View My Profile
                    <div class="arrow-down"></div>
                  </div>
                  <div class="continer">
                    <ul>
                      <li> <a href="#"> <span class="circle-wrapper2"><img src="../images/mymessage-icon1.png"></span> View Profile</a></li>
                      <li> <a href="#"> <span class="circle-wrapper2"><img src="../images/mymessage-icon2.png"></span> <?php echo BRAND_NAME; ?></a></li>
                    </ul>
                  </div>
                </div>
                <div class="secttion-right">
                  <div class="profile-wrapper">
                      <div class="category-heading2"> Your Information Details </div>
                      <div class="continer2">
                      <div class="profile-data">
                      <dl>
                      <dt>Bank Name</dt>
                      <dd>Bank of Baroda</dd>
                      </dl>
                      <dl>
                      <dt>Zone</dt>
                      <dd>South Zone</dd>
                      </dl>
                      <dl>
                      <dt>Regions</dt>
                      <dd>Andhra Pradesh</dd>
                      </dl>
                      <dl>
                      <dt>Branch</dt>
                      <dd>Banjara Hills, Hyderabad</dd>
                      </dl>
                      <dl>
                      <dt>Address</dt>
                      <dd>B24, Nehru Road, Sector-4,<br> Banjara Hills, <br> Hyderabad, India<br> Pincode: 500013</dd>
                      </dl>
                      </div>
                      
                      <div class="last-login">
                      
                      <dl>
                      <dt>Last Login  Seen:</dt>
                      <dd>Monday, 22/05/2015, 11:00 AM</dd>
                      </dl>
                      
                      <dl>
                      <dt>Account Opening Date:</dt>
                      <dd>22/05/2015</dd>
                      </dl>
                      </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            
            <!-- #tab2 --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
