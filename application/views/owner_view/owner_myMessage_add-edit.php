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



<section>
  
    <?php echo $breadcrumb;?>
  
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner"><li class="active" rel="tab1">Buy</li></a>
            <a href="/owner/sell"><li rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                    <a href="/owner/sell"><li  rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage"><li class="active" rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile"><li rel="tab12">My Profile</li></a>
                </ul>
                  
                <div class="tab_container3 whitebg"> 
                  <!-- Buy > My Message start -->
                  <div id="tab7" class="tab_content3">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <div class="auction-category-heading">My Message
                            <div class="arrow-down"></div>
                          </div>
                          <nav class="continer">
                            <?php echo $leftPanel; ?>
                          </nav>
                        </div>
                      </div>
                        
                        <div class="secttion-right">
                            <div class="table-wrapper btmrg20">
                                
                                <a href="/owner/myMessage">Cancel</a>
                                
                                <form enctype="multipart/form-data" method="post" class="stdform" id="message" name="add_data_view" accept-charset="utf-8" action="/owner/myMessage_save"><?php
                                
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
                                                $.post("/buyer/myMessage_autocomplete", {name: ""+inputString+""}, function(data){
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
                        </div>
                    </div>
                  </div>
                  <!-- Buy > My Message end --> 
                </div>
              </div>
            </div>
            <!---- buy tab container end ----> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
