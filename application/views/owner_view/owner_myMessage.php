<?php
$tabtype=$this->input->get('type');

//echo "session dat->".$this->session->userdata('tabindex');

?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#selecctall').click(function(event) {  //on toggle click 
            if(this.checked) { // check toggle status
                $('.checkbox1').each(function() { //select all checkboxes with class "checkbox1"
                    this.checked = true;                        
                });
            }else{
                $('.checkbox1').each(function() { //disselect all checkboxes with class "checkbox1"
                    this.checked = false;                        
                });			
            }
        });
    });
</script>

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
            <?php if($tabtype =='sell'){?>
				<a href="/owner"><li rel="tab1">Buy</li></a>
				<a href="/owner/sell"><li class="active" rel="tab2">Sell</li></a>
			<?php }else{?>
				<a href="/owner"><li class="active" rel="tab1">Buy</li></a>
				<a href="/owner/sell"><li rel="tab2">Sell</li></a>
			<?php }?>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  
				  
					<?php if($tabtype == 'sell'){?>
						<ul class="tabs3">
							<a href="/owner/sell">
								<li rel="tab9">My Summary</li>
							</a>
							<a href="/owner/sellMyActivity">
								<li rel="tab10">My Activity</li>
							</a>
							
							
							<a href="/owner/myMessage?type=sell">
								<li class="active" rel="tab11">My Message</li>
							</a>
							<a href="/owner/myProfile?type=sell">
								<li rel="tab12">My Profile</li>
							</a>
							
							
						</ul> 
					<?php }else{?>
						<ul class="tabs3">
							<a href="/owner/">
								<li rel="tab9">My Summary</li>
							</a>
							<a href="/owner/liveAuction">
								<li rel="tab10">My Activity</li>
							</a>
							<a href="/owner/myMessage">
								<li class="active" rel="tab11">My Message</li>
							</a>
							<a href="/owner/myProfile">
								<li rel="tab12">My Profile</li>
							</a>
						</ul>
					<?php }?>	
					
				  
                  
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
                                <form method="POST" action=""><?php
                                    
                                    if($this->session->flashdata('message_validation')){?>

                                        <div class="form_validation_msg" style="color: red;">
                                            <?php echo $this->session->flashdata('message_validation'); ?>
                                        </div><?php
                                    }?>
                                    
                                    
                                    <div class="button-row btmrg">
                                        <input type="checkbox" id="selecctall"/>
                                        <input type="button" value="All" class="b_submit" />
                                        <input type="submit" name="delete_all" onclick="return confirm('Are you sure, Delete?')" value="Delete" class="b_submit" />
                                        <input type="submit" name="mark_as_read" onclick="return confirm('Are you sure, Mark as Read?')" value="Mark as Read" class="b_submit" />
                                       
                                    </div>

                                    <div class="table-section">
                                        <input type="hidden" name="controller" id="controller" value="message" />
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="defaultTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="5%">&nbsp;</th>
                                                    <th scope="col" width="20%">From</th>
                                                    <!--<th class="head0">Priority</th>-->
                                                    <th scope="col" width="35%">Message</th>
                                                    <th scope="col" width="20%">Date</th>
                                                    <th scope="col" width="15%">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody><?php 

                                                $i = 1;

                                                foreach ($records as $data){?>

                                                    <tr class=<?php if($i == 1){ echo "odd"; $i=2; } else if($i==2){echo "even"; $i=1;} ?>>

                                                        <td>
                                                            <input class="checkbox1" type="checkbox" name="status[]" value="<?php echo $data->id; ?>">
                                                        </td>

                                                        <td>C1india</td>

                                                        <td><span style="font-weight: <?php echo ($data->msg_status == '2') ? "bold" : "normal"; ?>;"><?php echo $data->msg_body; ?></span></td>
                                                        <td><?php GetDateFormat($data->msg_created_datetime); ?><?php echo date ("d/m/Y h:ia",strtotime($data->msg_created_datetime)); ?></td>

                                                        <td>
                                                             <a href="/owner/myMessage_delete_msg/<?php echo $data->id; ?>" class="deletelink" onclick="return confirm('Are you sure, Delete?')"><strong>Delete</strong></a>
                                                        </td>
                                                    </tr><?php
                                                }?>	
                                            </tbody>
                                        </table>
                                    </div>
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