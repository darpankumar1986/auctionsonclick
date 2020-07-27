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
                      <!--<li> <a href="/buyer/myMessage"> <span class="circle-wrapper2"><img src="../images/mymessage-icon1.png"></span> Inbox</a></li>-->
                      <li> <a href="/buyer/myMessage"> <span class="circle-wrapper2"><img src="../images/mymessage-icon2.png"></span> <?php echo BRAND_NAME; ?></a></li>
                      <li> <a href="#"> <span class="circle-wrapper2"><img src="../images/mymessage-icon3.png"></span> User</a></li>
                      <!--<li> <a href="#"> <span class="circle-wrapper2"><img src="../images/mymessage-icon4.png"></span> Send</a></li>-->
                      <li> <a href="/buyer/myMessageTrash"> <span class="circle-wrapper2"><img src="../images/mymessage-icon5.png"></span> Trash</a></li>
                    </ul>
                  </div>
                  </div>
                </div>
                  
                  <div class="secttion-right">
                      
                      <div class="table-wrapper btmrg20">
                          <form method="post" action="">
                    <!--<div class="button-row btmrg">
                            
                            <input type="checkbox" id="selecctall"/>
                            <input type="button" value="All" class="b_submit">
                            <input type="submit" name="delete_all" onclick="if(confirm('Are you sure, Delete all?')){return true;} else{return false;};" value="Delete" class="b_submit">
                            
                            <input type="submit" name="mark_as_read" onclick="if(confirm('Are you sure, Mark as Read all?')){return true;} else{return false;};" value="Mark as Read" class="b_submit">
                            
                            <input type="button" value="Forward" onclick="location.replace('/buyer/myMessage_new')" class="b_submit">
                            
                          </div>-->
                    
            
                          <!--<a href="/buyer/myMessage_new">New</a>-->
                          
                          <div class="table-section"> 
                            
                                <input type="hidden" name="controller" id="controller" value="message" />
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="defaultTable">
                                        <thead>
                                            <tr>
                                                <!--<th scope="col" width="5%">&nbsp;</th>-->
                                                <th scope="col" width="25%">Send To</th>
                                                <!--<th class="head0">Priority</th>-->
                                                <th scope="col" width="35%">Message</th>
                                                <th scope="col" width="15%">Create DateTime</th>
                                                <!--<th scope="col" width="15%">Actions</th>-->
                                            </tr>
                                        </thead>

                                        <tbody><?php 

                                            $i = 1;

                                            foreach ($records as $data){?>

                                                <tr class=<?php if($i == 1){ echo "odd"; $i=2; } else if($i==2){echo "even"; $i=1;} ?>>
                                                    
                                                    <!--<td>
                                                        <input class="checkbox1" type="checkbox" name="status[]" value="<?php echo $data->id; ?>">
                                                    </td>-->
                                                    
                                                    <td><?php 

                                                        $get_role = GetTitleById('tbl_user',$data->msg_to,'role');

                                                        echo GetTitleById('tbl_user',$data->msg_to,'first_name').' '.GetTitleById('tbl_user',$data->msg_to,'last_name').' ('.GetTitleById('tbl_role',$get_role,'name').')'; ?>
                                                    </td>

                                                    <td><span style="font-weight: <?php echo ($data->msg_status == '2') ? "bold" : "normal"; ?>;"><?php echo $data->msg_body; ?></span></td>
                                                    <td><?php GetDateFormat($data->msg_created_datetime); ?><?php echo date ("d/m/Y h:ia",strtotime($data->msg_created_datetime)); ?></td>

                                                    <!--<td>
                                                        <a href="/buyer/myMessage_reply_msg/<?php echo $data->id; ?>"><strong>reply</strong></a>
                                                     |  <a href="/buyer/myMessage_delete_msg/<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>
                                                    </td>-->
                                                </tr><?php
                                                
                                                
                                            }?>	

                                        </tbody>
                                </table>
                                <div class="pagination">

                                </div>
                            
                          </div>
	
                          </form>
                      </div>
                      
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
