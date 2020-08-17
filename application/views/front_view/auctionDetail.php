	<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
	<div class="container-fluid container_margin">
            <div class="row row_bg">
               <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li><a href="<?php echo base_url(); ?>propertylisting?search=<?php echo $auction_data[0]->city_name; ?>&assetsTypeId=1"><?php echo $auction_data[0]->city_name; ?> Auctions</a></li>
                            <li class="active"><?php echo $auction_data[0]->bank_name; ?></li>
                        </ol>
                    </div><!--breadcrumb_main-->
                </div>
            </div>
            </div><!--row-->
        </div><!--container-fluid-->
           <div class="container">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="form_wrap_anction_search form-wrap">
                           <form class="form_desc">
                               <div class="dropdown">
                                   <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Category
                                       <span class="caret"></span></button>
                                   <ul class="dropdown-menu">
                                       <li class="dropdown-header"><input type="radio" id="test1" name="radio-group" checked>
                                           <label for="test1">All Properties</label></li>
                                       <li><label class="checkbox-inline"><input type="checkbox" value="">Land</label></li>
                                       <li><label class="checkbox-inline"><input type="checkbox" value="">Residential</label></li>
                                       <li><label class="checkbox-inline"><input type="checkbox" value="">Commercial</label></li>
                                       <li class="dropdown-header"><input type="radio" id="test2" name="radio-group">
                                           <label for="test2">All Vehicles</label></li>
                                       <li><label class="checkbox-inline"><input type="checkbox" value="">Personal</label></li>
                                       <li><label class="checkbox-inline"><input type="checkbox" value="">Commercial</label></li>
                                       <li class="dropdown-header"><input type="radio" id="test3" name="radio-group">
                                           <label for="test3">Others</label></li>
                                   </ul>
                               </div>
                               <div class="custom-dropdown-select">
                                   <div class="custom-select">
                                       <select>
                                           <option value="0">Select City</option>
                                           <option value="1">All Cities</option>
                                           <option value="2">Agra</option>
                                           <option value="3">Ahmedabad</option>
                                           <option value="4">Delhi</option>
                                           <option value="5">UP</option>
                                           <option value="6">Goa</option>
                                           <option value="7">Kerla</option>
                                           <option value="8">Ahmedabad</option>
                                           <option value="9">Delhi</option>
                                           <option value="10">UP</option>
                                           <option value="11">Goa</option>
                                           <option value="12">Kerla</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="custom-dropdown-select">
                                   <div class="custom-select">
                                       <select>
                                           <option value="0">Select Bank</option>
                                           <option value="1">All Cities</option>
                                           <option value="2">Agra</option>
                                           <option value="3">Ahmedabad</option>
                                           <option value="4">Delhi</option>
                                           <option value="5">UP</option>
                                           <option value="6">Goa</option>
                                           <option value="7">Kerla</option>
                                           <option value="8">Ahmedabad</option>
                                           <option value="9">Delhi</option>
                                           <option value="10">UP</option>
                                           <option value="11">Goa</option>
                                           <option value="12">Kerla</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="search_btn_section">
                                   <button class="btn btn-default btn-search" type="Search">
                                        <i class="fa fa-search"></i> Search
                                   </button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
            <div class="container-fluid">
                <div class="row ad_row_width">
                    <div class="col-sm-12">
                        <div class="adblock">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_insurance.png">
                        </div><!--adblock-->
                    </div>
                </div><!--row-->
        </div><!--container-fluid-->
        <div class="container">
		<?php //echo "<pre>";print_r($auction_data);die; ?>
            <div class="row">
                <div class="col-sm-9 border_right">
                    <div class="desc_wrapper">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="desc_wrapper_inner">
                                    <h3>Residential Plot in <?php echo $auction_data[0]->location_name; ?>, <?php echo $auction_data[0]->city_name; ?></h3>
                                    <p><img src="<?php echo base_url().$auction_data[0]->bank_img; ?>" style="width:18px;height:18px;"> <?php echo $auction_data[0]->bank_name; ?></p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="social_platform">
                                    <ul>
                                        <li><a href="#" class="whatsapp"><i class="fa fa-whatsapp"></i></a></li>
                                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="envelope"><i class="fa fa-envelope"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="shortlist_desc">
                            <div class="desc_para"><p>Description</p></div>
                            <div class="desc_shortlist_button">
                                <button class="btn btn-default shortlist_list <?php echo ($auction_data[0]->is_fav)?'shortlisted_list':''; ?>" type="button" onclick="addtoeventfavlist(<?php echo (int)$auction_data[0]->id; ?>)">
                                    <i class="fa fa-star"></i> <?php echo ($auction_data[0]->is_fav)?'Shortlisted':'Shortlist'; ?>
                                </button>
                            </div>
                            <div class="clr"></div>
                        </div>
                    </div>
					<?php
						$userid=$this->session->userdata('id');
						$indate =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "indate");
						$free_sub_expire_date = date('Y-m-d H:i:s',strtotime(FREE_SUBSCRIPTION_TIME,strtotime($indate)));
						$free_sub_expire_date_str = strtotime($free_sub_expire_date);
						$free_sub_flag = 0;
						if(time() < $free_sub_expire_date_str)
						{
							$free_sub_flag = 1;
						}

					?>
                    <div class="table_desc">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Bank Name</td>
                                    <td><?php echo $auction_data[0]->bank_name; ?></td>
                                </tr>
								<?php if($auction_data[0]->isSub > 0 || $free_sub_flag == 1){ ?>
									<tr>
										<td>Bank Branch</td>
										<td><?php echo $auction_data[0]->branch_name; ?></td>
									</tr>
									<tr>
										<td>Contact Details</td>
										<td><?php echo $auction_data[0]->contact_person_details_1; ?></td>
									</tr>
									<tr>
										<td>Auction Type</td>
										<td>
											<?php if($auction_data[0]->event_type=='sarfaesi')
												{
													echo 'Sarfaesi Auction';
												}
												else if($auction_data[0]->event_type=='liquidation')
												{
													echo 'Liquidation Auction';
												}
												else if($auction_data[0]->event_type=='government')
												{
													echo 'Government Auction';
												}
												else 
												{
													echo 'Other Auction';
												}
											 ?>
										</td>
									</tr>
										<tr>
										<td>Borrower Name</td>
										<td><?php echo $auction_data[0]->borrower_name; ?></td>
									</tr>
									<tr>
										<td>Asset Category</td>
										<td><?php echo $auction_data[0]->category_name; ?></td>
									</tr>
								<?php } ?>
                                <tr>
                                    <td>Asset Type</td>
                                    <td><?php echo ($auction_data[0]->sub_category_name)?$auction_data[0]->sub_category_name:'N/A'; ?></td>
                                </tr>
								<?php if($auction_data[0]->isSub > 0 || $free_sub_flag == 1){ ?>
									<tr>
										<td>Asset Details</td>
										<td><?php echo $auction_data[0]->PropertyDescription; ?></td>
									</tr>
								<?php } ?>
                                <tr>
                                    <td>Asset Location</td>
                                    <td><?php echo $auction_data[0]->location_name; ?></td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><?php echo $auction_data[0]->city_name; ?></td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><?php echo $auction_data[0]->state_name; ?></td>
                                </tr>
                                <tr>
                                    <td>Reserve Price</td>
                                    <td>₹<?php echo $auction_data[0]->reserve_price; ?></td>
                                </tr>
                                <tr>
                                    <td>EMD Amount</td>
                                    <td>₹<?php echo $auction_data[0]->emd_amt; ?></td>
                                </tr>
                                <tr>
                                    <td>EMD Submission Last Date</td>
                                    <td><?php echo date('F d',strtotime($auction_data[0]->bid_last_date)); ?><sup><?php echo date('S',strtotime($auction_data[0]->bid_last_date)); ?></sup>, <?php echo date('Y',strtotime($auction_data[0]->bid_last_date)); ?></td>
                                </tr>
								<?php if($auction_data[0]->isSub > 0 || $free_sub_flag == 1){ ?>
									<tr>
										<td>Auction Start Date & Time</td>
										<td><?php echo date('F d',strtotime($auction_data[0]->auction_start_date)); ?><sup><?php echo date('S',strtotime($auction_data[0]->auction_start_date)); ?></sup>, <?php echo date('Y',strtotime($auction_data[0]->auction_start_date)); ?></td>
									</tr>
									<tr>
										<td>Auction End Date & Time</td>
										<td><?php echo date('F d',strtotime($auction_data[0]->auction_end_date)); ?><sup><?php echo date('S',strtotime($auction_data[0]->auction_end_date)); ?></sup>, <?php echo date('Y',strtotime($auction_data[0]->auction_end_date)); ?></td>
									</tr>
									<tr>
										<td>E-Auction Provider</td>
										<td><?php echo $auction_data[0]->service_no; ?></td>
									</tr>
									<tr>
										<td>E-Auction Website</td>
										<td><a href="<?php echo 'https://'.$auction_data[0]->far; ?>" target="_blank"><?php echo $auction_data[0]->far; ?></a></td>
									</tr>
									<tr>
										<td>Documents Available</td>
										<td> 
											<?php 
											$picSrNo=1;
											foreach($uploadedDocs as $key => $doc){ if($doc->upload_document_field_id==0 && $doc->status == 1){ ?>
												<a href="/public/uploads/event_auction/<?php echo $doc->file_path; ?>" target="_blank"><?php echo 'Pic '.$picSrNo; ?></a><?php if($key+1 != count($uploadedDocs)){ ?>,<?php } ?>
											<?php 
												$picSrNo++;	
											} } ?>
											<br/>
											<?php 
											$dSrNo=1;
											foreach($uploadedDocs as $key => $doc){ if($doc->upload_document_field_id > 0){ ?>
												<a href="/public/uploads/event_auction/<?php echo $doc->file_path; ?>" target="_blank"><?php echo 'Doc '.$dSrNo; ?></a><?php if($key+1 != count($uploadedDocs)){ ?>,<?php } ?>
											<?php
												$dSrNo++;
												} 
											
											} ?>
										</td>
									</tr>
								<?php } ?>
								<?php if(($auction_data[0]->isSub > 0) || $free_sub_flag == 1){ ?>
								<!--<tr>
                                    <td colspan="2" class="contact_desc"><p>For further assistance, please contact our sales team</p>
                                        <p><?php echo $sales_person_detail; ?>
										</p>
                                    </td>
                                </tr>-->
                                <tr>
                                    <td colspan="2" class="residential_btn"><button class="btn btn-default" type="button" onclick="window.location='<?php echo base_url(); ?>propertylisting?search=<?php echo $auction_data[0]->city_name; ?>&assetsTypeId=1'">View more residential plot in <?php echo $auction_data[0]->city_name; ?> <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></button></td>
                                </tr>
								<?php } ?>
                            </tbody>
                        </table>
                    </div>
					<?php if(!($auction_data[0]->isSub > 0 || $free_sub_flag == 1)){ ?>
                    <div class="premium_section">
                        <div class="premium_section_inner">
                            <p>Become Premium member to view auction details and documents.</p>
                            <button class="btn btn-default" type="button" onclick="window.location='<?php echo base_url();?>home/premiumServices'">Premium Services</button>
							<?php if(!$this->session->userdata('id')){ ?>
								<p class="subscriber_para">If you are already a subscriber</p>
								<ul class="login_register_section">
									<li><a href="<?php echo base_url(); ?>home/login"><button class="btn btn-default btn_login" type="button">Login</button></a></li>
									<li><p>Or</p></li>
								<li><a href="<?php echo base_url(); ?>registration/signup"><button class="btn btn-default btn_register" type="button">Register</button></a></li>
								</ul>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>
                </div>
                <div class="col-sm-3">
                    <div class="adblock_right">
                        <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_other.png">
                    </div><!--adblock-->
                </div>
            </div><!--row-->
        </div><!--container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="adblock">
                        <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_insurance_bottom.png">
                    </div><!--adblock-->
                </div>
            </div><!--row-->
        </div><!--container-fluid-->
		<script>
			function addtoeventfavlist(auctionID)
			{

						
						if (auctionID) {
								var is_fav = $(".shortlist_list").hasClass('shortlisted_list');
								if(is_fav)
								{
									$(".shortlist_list").removeClass('shortlisted_list');
									$(".shortlist_list").html('<i class="fa fa-star"></i> Shortlist');
								}
								else
								{
									$(".shortlist_list").addClass('shortlisted_list');
									$(".shortlist_list").html('<i class="fa fa-star"></i> Shortlisted');
								}
						jQuery.ajax({
							url: '/home/liveupcomingauciton_event_add',
							type: 'POST',
							data: {
								auctionID: auctionID,
								message: "Added Successfully"
							},
							success: function (data) {
								//alert(data);
								//var rand = Math.random() * 10000000000000000;
								//location.href = "?rand=" + rand;
							}
						});
					}
				
			}
		</script>