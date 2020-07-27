<link href="<?php echo base_url()?>/bankeauc/css/common.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url()?>/bankeauc/css/tables.css" type="text/css" media="screen"/>	
<style>table tbody th{border:1px solid #ccc;padding:10px;}</style>
<style>table tbody tr td{border:1px solid #ccc;padding:10px;}</style>
  <?php //echo $breadcrumb;?>

	 <section class="body_main11">
		  <div class="row ">
			<div class="wrapper-full">
			  <div class="dashboard-wrapper">

				<div id="tab-pannel3" class="btmrgn">
		
				  <div class="tab_container3">
					
					
					<!-- #tab1 -->
					<div id="tab6" class="tab_content3">
					  <div class="container">
						<?php echo $leftPanel?>
						<div class="secttion-right">
						  <div class="table-wrapper btmrg20">
							<div class="table-heading btmrg">
							  <div class="box-head no_cursor">View Corrigendum</div>
							  <!--<div class="srch_wrp2">
								<input type="text" value="Search" id="search" name="search">
								<span class="ser_icon"></span> </div>-->
							</div>
							<div class="table-section">
							<?php
								$changeStr = '';
								$changeStr .= '<table width="100%" border="1" cellpadding="0" cellspacing="0">';
								$changeStr .= '<tr><th align="left">Fieldname</td>';
								$changeStr .= '<th align="left">Previous</th>';
								$changeStr .= '<th align="left">Current</th></tr>';
									
								$data = (array)$corrigendum;
								if($data["event_type"] != $data["event_type_old"])
								{
									$changeStr .= '<tr><td align="left">Account</td>';
									$changeStr .= '<td align="left">'.$data["event_type_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["event_type"].'</td></tr>';
								}						
								
								if($data["reference_no"] != $data["reference_no_old"])
								{
									$changeStr .= '<tr><td align="left">Property ID</td>';
									$changeStr .= '<td align="left">'.$data["reference_no_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["reference_no"].'</td></tr>';
								}
								
								if($data["event_title"] != $data["event_title_old"])
								{
									$changeStr .= '<tr><td align="left">Event Title</td>';
									$changeStr .= '<td align="left">'.$data["event_title_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["event_title"].'</td></tr>';
								}
								
								if($data["bank_id"] != $data["bank_id_old"])
								{
									 $bank_id_old = GetTitleByField('tbl_bank', "id='".$data["bank_id_old"]."'", 'name');
									 $bank_id = GetTitleByField('tbl_bank', "id='".$data["bank_id"]."'", 'name');
									 
									$changeStr .= '<tr><td align="left">Name of the Organization</td>';
									$changeStr .= '<td align="left">'.$bank_id_old.'</td>';
									$changeStr .= '<td align="left">'.$bank_id.'</td></tr>';
								}
								
								if($data["category_id"] != $data["category_id_old"])
								{
									$category_id_old = GetTitleByField('tbl_category', "id='".$data["category_id_old"]."'", 'name');
									$category_id = GetTitleByField('tbl_category', "id='".$data["category_id"]."'", 'name');
									 
									$changeStr .= '<tr><td align="left">Asset Category</td>';
									$changeStr .= '<td align="left">'.$category_id_old.'</td>';
									$changeStr .= '<td align="left">'.$category_id.'</td></tr>';
								}
								
								if($data["subcategory_id"] != $data["subcategory_id_old"])
								{
									$subcategory_id_old = GetTitleByField('tbl_category', "id='".$data["subcategory_id_old"]."'", 'name');
									$subcategory_id = GetTitleByField('tbl_category', "id='".$data["subcategory_id"]."'", 'name');
									
									$changeStr .= '<tr><td align="left">Sub Category</td>';
									$changeStr .= '<td align="left">'.$subcategory_id_old.'</td>';
									$changeStr .= '<td align="left">'.$subcategory_id.'</td></tr>';
								}
								
								if(trim($data["product_description"]) != trim($data["product_description_old"]))
								{
									$changeStr .= '<tr><td align="left">Description of the property</td>';
									$changeStr .= '<td align="left">'.$data["product_description_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["product_description"].'</td></tr>';
								}
								
								if($data["countryID"] != $data["countryID_old"])
								{
									$countryID_old = GetTitleByField('tbl_country', "id='".$data["countryID_old"]."'", 'country_name');
									$countryID = GetTitleByField('tbl_country', "id='".$data["countryID"]."'", 'country_name');
									
									$changeStr .= '<tr><td align="left">Country</td>';
									$changeStr .= '<td align="left">'.$countryID_old.'</td>';
									$changeStr .= '<td align="left">'.$countryID.'</td></tr>';
								}
								
								if($data["state"] != $data["state_old"])
								{
									if($data["state_old"] > 0)
									{
										$state_old = GetTitleByField('tbl_state', "id='".$data["state_old"]."'", 'state_name');
									}
									else
									{
										$state_old = '-';
									}
									$state = GetTitleByField('tbl_state', "id='".$data["state"]."'", 'state_name');
									
									$changeStr .= '<tr><td align="left">Property State</td>';
									$changeStr .= '<td align="left">'.$state_old.'</td>';
									$changeStr .= '<td align="left">'.$state.'</td></tr>';
								}
								
								if($data["city"] != $data["city_old"])
								{
									if($data["other_city_old"] != '')
									{
										$city_old = $data["other_city_old"];
									}
									else
									{
										$city_old = GetTitleByField('tbl_city', "id='".$data["city_old"]."'", 'city_name');										
									}
									
									if($data["other_city"] != '')
									{
										$city = $data["other_city"];
									}
									else
									{
										$city = GetTitleByField('tbl_city', "id='".$data["city"]."'", 'city_name');										
									}									
									
									$changeStr .= '<tr><td align="left">Property City</td>';
									$changeStr .= '<td align="left">'.$city_old.'</td>';
									$changeStr .= '<td align="left">'.$city.'</td></tr>';
								}
								
								if($data["borrower_name"] != $data["borrower_name_old"])
								{
									$changeStr .= '<tr><td align="left">Borrower Name</td>';
									$changeStr .= '<td align="left">'.$data["borrower_name_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["borrower_name"].'</td></tr>';
								}
								
								if($data["invoice_mail_to"] != $data["invoice_mail_to_old"])
								{
									$invoice_mail_to_old = GetTitleByField('tbl_user', "id='".$data["invoice_mail_to_old"]."'", 'email_id');
									$invoice_mail_to = GetTitleByField('tbl_user', "id='".$data["invoice_mail_to"]."'", 'email_id');
									
									$changeStr .= '<tr><td align="left">Kind Attention To.(Invoiced to be mailed)</td>';
									$changeStr .= '<td align="left">'.$invoice_mail_to_old.'</td>';
									$changeStr .= '<td align="left">'.$invoice_mail_to.'</td></tr>';
								}
								
								if(str_replace(" ","",$data["invoice_mailed"]) != str_replace(" ","",$data["invoice_mailed_old"]))
								{
									if($data["invoice_mailed_old"] != "" && $data["invoice_mailed_old"] != "0")
									{
										$invoice_mailed_oldArr = explode(",",$data["invoice_mailed_old"]);	
										if(is_array($invoice_mailed_oldArr))
										{
											//print_r($invoice_mailed_oldArr);
											$invoice_mailed_old = '';
											foreach($invoice_mailed_oldArr as $key => $userid)
											{
												if($key > 0)
												{
													$invoice_mailed_old .= ', ';	
												}
												$invoice_mailed_old .= GetTitleByField('tbl_user', "id='".$userid."'", 'email_id');
											}
										}
										else
										{
											$invoice_mailed_old = "N/A";
										}
									}
									else
									{
										$invoice_mailed_old = "N/A";
									}
									
									if($data["invoice_mailed"] != "" && $data["invoice_mailed"] != "0")
									{
										$invoice_mailed_oldArr = explode(",",$data["invoice_mailed"]);	
										if(is_array($invoice_mailed_oldArr))
										{
											$invoice_mailed = '';
											foreach($invoice_mailed_oldArr as $key => $userid)
											{
												if($key > 0)
												{
													$invoice_mailed .= ', ';	
												}
												$invoice_mailed .= GetTitleByField('tbl_user', "id='".$userid."'", 'email_id');
											}
										}
										else
										{
											$invoice_mailed = "N/A";
										}
									}
									else
									{
										$invoice_mailed = "N/A";
									}
									if($invoice_mailed_old != $invoice_mailed)
									{
										$changeStr .= '<tr><td align="left">To.(Invoice to be Mailed)</td>';
										$changeStr .= '<td align="left">'.$invoice_mailed_old.'</td>';
										$changeStr .= '<td align="left">'.$invoice_mailed.'</td></tr>';
									}
								}
								
								if($data["reserve_price"] != $data["reserve_price_old"])
								{
									$changeStr .= '<tr><td align="left">Reserve Price</td>';
									$changeStr .= '<td align="left">'.$data["reserve_price_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["reserve_price"].'</td></tr>';
								}
								
								if($data["emd_amt"] != $data["emd_amt_old"])
								{
									$changeStr .= '<tr><td align="left">EMD Amount</td>';
									$changeStr .= '<td align="left">'.$data["emd_amt_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["emd_amt"].'</td></tr>';
								}
								
								if($data["tender_fee"] != $data["tender_fee_old"])
								{
									$changeStr .= '<tr><td align="left">Tender Fee</td>';
									$changeStr .= '<td align="left">'.$data["tender_fee_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["tender_fee"].'</td></tr>';
								}
								
								if($data["nodal_bank"] != $data["nodal_bank_old"])
								{
									$changeStr .= '<tr><td align="left">Nodal Bank</td>';
									$changeStr .= '<td align="left">'.$data["nodal_bank_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["nodal_bank"].'</td></tr>';
								}
								
								if($data["nodal_bank_name"] != $data["nodal_bank_name_old"])
								{
									$nodal_bank_name_old = GetTitleByField('tbl_bank', "id='".$data["nodal_bank_name_old"]."'", 'name');
									$nodal_bank_name = GetTitleByField('tbl_bank', "id='".$data["nodal_bank_name"]."'", 'name');
									 
									$changeStr .= '<tr><td align="left">Nodal Bank Name</td>';
									$changeStr .= '<td align="left">'.$nodal_bank_name_old.'</td>';
									$changeStr .= '<td align="left">'.$nodal_bank_name.'</td></tr>';
								}
								
								if($data["nodal_bank_account"] != $data["nodal_bank_account_old"])
								{
									$changeStr .= '<tr><td align="left">Nodal Bank account number</td>';
									$changeStr .= '<td align="left">'.$data["nodal_bank_account_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["nodal_bank_account"].'</td></tr>';
								}
								
								if($data["branch_ifsc_code"] != $data["branch_ifsc_code_old"])
								{
									$changeStr .= '<tr><td align="left">Branch IFSC Code</td>';
									$changeStr .= '<td align="left">'.$data["branch_ifsc_code_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["branch_ifsc_code"].'</td></tr>';
								}
								
								if($data["press_release_date"] != $data["press_release_date_old"])
								{
									$changeStr .= '<tr><td align="left">Press Release Date</td>';
									$changeStr .= '<td align="left">'.$data["press_release_date_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["press_release_date"].'</td></tr>';
								}
								
								if($data["inspection_date_from"] != $data["inspection_date_from_old"])
								{
									$changeStr .= '<tr><td align="left">Date of inspection of asset(From)</td>';
									$changeStr .= '<td align="left">'.$data["inspection_date_from_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["inspection_date_from"].'</td></tr>';
								}
								
								if($data["inspection_date_to"] != $data["inspection_date_to_old"])
								{
									$changeStr .= '<tr><td align="left">Date of inspection of asset(To)</td>';
									$changeStr .= '<td align="left">'.$data["inspection_date_to_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["inspection_date_to"].'</td></tr>';
								}
								
								if($data["bid_last_date"] != $data["bid_last_date_old"])
								{
									$changeStr .= '<tr><td align="left">Sealed Bid Submission Last Date</td>';
									$changeStr .= '<td align="left">'.$data["bid_last_date_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["bid_last_date"].'</td></tr>';
								}
								
								if($data["bid_opening_date"] != $data["bid_opening_date_old"])
								{
									$changeStr .= '<tr><td align="left">Sealed Bid Opening Date</td>';
									$changeStr .= '<td align="left">'.$data["bid_opening_date_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["bid_opening_date"].'</td></tr>';
								}
								
								if($data["auction_start_date"] != $data["auction_start_date_old"])
								{
									$changeStr .= '<tr><td align="left">Auction Start date</td>';
									$changeStr .= '<td align="left">'.$data["auction_start_date_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["auction_start_date"].'</td></tr>';
								}
								
								if($data["auction_end_date"] != $data["auction_end_date_old"])
								{
									$changeStr .= '<tr><td align="left">Auction End date</td>';
									$changeStr .= '<td align="left">'.$data["auction_end_date_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["auction_end_date"].'</td></tr>';
								}
								
								if($data["show_home"] != $data["show_home_old"])
								{
									if($data["show_home"] == '0')
									{
										$data["show_home"] = 'Limited User';	
									}
									else
									{
										$data["show_home"] = 'Open';
									}
									
									if($data["show_home_old"] == '0')
									{
										$data["show_home_old"] = 'Limited User';	
									}
									else
									{
										$data["show_home_old"] = 'Open';
									}
									
									$changeStr .= '<tr><td align="left">Auction Type</td>';
									$changeStr .= '<td align="left">'.$data["show_home_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["show_home"].'</td></tr>';
								}
								
								if($data["show_frq"] != $data["show_frq_old"])
								{
									if($data["show_frq"] == '0')
									{
										$data["show_frq"] = 'No';	
									}
									else
									{
										$data["show_frq"] = 'Yes';
									}
									
									if($data["show_frq_old"] == '0')
									{
										$data["show_frq_old"] = 'No';	
									}
									else
									{
										$data["show_frq_old"] = 'Yes';
									}
									
									$changeStr .= '<tr><td align="left">Show FRQ</td>';
									$changeStr .= '<td align="left">'.$data["show_frq_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["show_frq"].'</td></tr>';
								}
								
								if($data["dsc_enabled"] != $data["dsc_enabled_old"] && false)
								{
									if($data["dsc_enabled_old"] == '0')
									{
										$data["dsc_enabled_old"] = 'Disable';	
									}
									else
									{
										$data["dsc_enabled_old"] = 'Enable';
									}
									
									if($data["dsc_enabled"] == '0')
									{
										$data["dsc_enabled"] = 'Disable';	
									}
									else
									{
										$data["dsc_enabled"] = 'Enable';
									}
									
									$changeStr .= '<tr><td align="left">Is DSC Enabled</td>';
									$changeStr .= '<td align="left">'.$data["dsc_enabled_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["dsc_enabled"].'</td></tr>';
								}
								
								if($data["auto_bid_cut_off"] != $data["auto_bid_cut_off_old"])
								{
									if($data["auto_bid_cut_off_old"] == '0')
									{
										$data["auto_bid_cut_off_old"] = 'No';	
									}
									else
									{
										$data["auto_bid_cut_off_old"] = 'Yes';
									}
									
									if($data["auto_bid_cut_off"] == '0')
									{
										$data["auto_bid_cut_off"] = 'No';	
									}
									else
									{
										$data["auto_bid_cut_off"] = 'Yes';
									}
									
									$changeStr .= '<tr><td align="left">Auto Bid Cut Off</td>';
									$changeStr .= '<td align="left">'.$data["auto_bid_cut_off_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["auto_bid_cut_off"].'</td></tr>';
								}
								
								/*if($data["event_type"] != $data["event_type_old"])
								{
									$changeStr .= '<tr><td align="left">Price Bid</td>';
									$changeStr .= '<td align="left">'.$data["event_type_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["event_type"].'</td></tr>';
								}*/
								
								if($data["bid_inc"] != $data["bid_inc_old"])
								{
									$changeStr .= '<tr><td align="left">Bid Increment value</td>';
									$changeStr .= '<td align="left">'.$data["bid_inc_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["bid_inc"].'</td></tr>';
								}
								
								if($data["auto_extension_time"] != $data["auto_extension_time_old"])
								{
									if(!($data["auto_extension_time_old"] > 0 ))
									{
										$data["auto_extension_time_old"] = 'N/A';	
									}
									
									if(!($data["auto_extension_time"] > 0 ))
									{
										$data["auto_extension_time"] = 'N/A';	
									}
									
									
									$changeStr .= '<tr><td align="left">Auto Extension time (In Minutes.)</td>';
									$changeStr .= '<td align="left">'.$data["auto_extension_time_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["auto_extension_time"].'</td></tr>';
								}
								
								if($data["no_of_auto_extn"] != $data["no_of_auto_extn_old"])
								{
									if(!($data["no_of_auto_extn_old"] > 0 ))
									{
										$data["no_of_auto_extn_old"] = 'Unlimited';	
									}
									
									if(!($data["no_of_auto_extn"] > 0 ))
									{
										$data["no_of_auto_extn"] = 'Unlimited';	
									}
									
									$changeStr .= '<tr><td align="left">Auto Extension(s)</td>';
									$changeStr .= '<td align="left">'.$data["no_of_auto_extn_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["no_of_auto_extn"].'</td></tr>';
								}
								
								if($data["related_doc"] != $data["related_doc_old"])
								{
									if(!($data["related_doc_old"] != ""))
									{
										$data["related_doc_old"] = "N/A";										
									}
									
									if(!($data["related_doc"] != ""))
									{
										$data["related_doc"] = "N/A";										
									}
									
									$changeStr .= '<tr><td align="left">Upload Related Documents</td>';
									if($data["related_doc_old"] != "N/A" && $data["related_doc_old"]!='0')
									{
										$changeStr .= '<td align="left"> <a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["related_doc_old"].'">'.$data["related_doc_old"].'</a></td>';
									}else{
										$changeStr .= '<td align="left">'.$data["related_doc_old"].'</td>';
									}
									if($data["related_doc"] != "N/A" && $data["related_doc"]!='0')
									{
										$changeStr .= '<td align="left"><a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["related_doc"].'">'.$data["related_doc"].'</a></td></tr>';
									}else{
										$changeStr .= '<td align="left">'.$data["related_doc"].'</td></tr>';
									}
								}
								
								if($data["image"] != $data["image_old"])
								{
									if(!($data["image_old"] != ""))
									{
										$data["image_old"] = "N/A";										
									}
									
									if(!($data["image"] != ""))
									{
										$data["image"] = "N/A";										
									}
									
									$changeStr .= '<tr><td align="left">Upload Images</td>';
									if($data["image_old"] != "N/A" && $data["image_old"]!='0')
									{
										$changeStr .= '<td align="left"><a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["image_old"].'">'.$data["image_old"].'</a></td>';
									}else{
										$changeStr .= '<td align="left">'.$data["image_old"].'</td>';
									}
									if($data["image"] != "N/A" && $data["image"]!='0')
									{
										$changeStr .= '<td align="left"><a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["image"].'">'.$data["image"].'</a></td></tr>';
									}else{
										$changeStr .= '<td align="left">'.$data["image"].'</td></tr>';
									}
								}
								
								if($data["supporting_doc"] == '0' || $data["supporting_doc"] == NULL)
								{
										$data["supporting_doc"] = "N/A";
								}
								
								if($data["supporting_doc_old"] == '0' || $data["supporting_doc_old"] == NULL)
								{
										$data["supporting_doc_old"] = "N/A";
								}
								
						
								if($data["supporting_doc"] != $data["supporting_doc_old"])
								{
									if(!($data["supporting_doc_old"] != ""))
									{
										$data["supporting_doc_old"] = "N/A";										
									}
									
									if(!($data["supporting_doc"] != ""))
									{
										$data["supporting_doc"] = "N/A";										
									}
									
									$changeStr .= '<tr><td align="left">Upload Special terms and conditions documents</td>';
									if($data["supporting_doc_old"] != "N/A" && $data["supporting_doc_old"]!='0')
									{					
										$changeStr .= '<td align="left"><a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["supporting_doc_old"].'">'.$data["supporting_doc_old"].'</a></td>';
									}else{
										$changeStr .= '<td align="left">'.$data["supporting_doc_old"].'</td>';
									}
									if($data["supporting_doc"] != "N/A" && $data["supporting_doc"]!='0')
									{
										$changeStr .= '<td align="left"><a target="_blank" href="'.base_url().'public/uploads/event_auction/'.$data["supporting_doc"].'">'.$data["supporting_doc"].'</a></td></tr>';
									}else{
										$changeStr .= '<td align="left">'.$data["supporting_doc"].'</td></tr>';
									}
								}
								
								//echo str_replace($data["doc_to_be_submitted"]," ","") ." | ". str_replace($data["doc_to_be_submitted_old"]," ","");
								if(str_replace(" ","",$data["doc_to_be_submitted"]) != str_replace(" ","",$data["doc_to_be_submitted_old"]))
								{
									if($data["doc_to_be_submitted_old"] != "")
									{
										$doc_to_be_submitted_oldArr = explode(",",$data["doc_to_be_submitted_old"]);	
										if(is_array($doc_to_be_submitted_oldArr))
										{
											$doc_to_be_submitted_old = '';
											foreach($doc_to_be_submitted_oldArr as $key => $docID)
											{
												if($key > 0)
												{
													$doc_to_be_submitted_old .= ', ';	
												}
												$doc_to_be_submitted_old .= GetTitleByField('tbl_doc_master', "id='".trim($docID)."'", 'name');
											}
										}
										else
										{
											$doc_to_be_submitted_old = "N/A";
										}
									}
									else
									{
										$doc_to_be_submitted_old = "N/A";
									}
									
									if($data["doc_to_be_submitted"] != "")
									{
										$doc_to_be_submitted_oldArr = explode(",",$data["doc_to_be_submitted"]);	
										if(is_array($doc_to_be_submitted_oldArr))
										{
											$doc_to_be_submitted = '';
											foreach($doc_to_be_submitted_oldArr as $key => $docID)
											{
												if($key > 0)
												{
													$doc_to_be_submitted .= ', ';	
												}
												$doc_to_be_submitted .= GetTitleByField('tbl_doc_master', "id='".trim($docID)."'", 'name');
											}
										}
										else
										{
											$doc_to_be_submitted = "N/A";
										}
									}
									else
									{
										$doc_to_be_submitted = "N/A";
									}
									
									$changeStr .= '<tr><td align="left">Documents to be submitted</td>';
									
									
									$changeStr .= '<td align="left">'.$doc_to_be_submitted_old.'</td>';
									$changeStr .= '<td align="left">'.$doc_to_be_submitted.'</td></tr>';
								}
								
								if($data["second_opener"] == '0' || $data["second_opener"] == NULL)
								{
										$data["second_opener"] = "N/A";
								}
								
								if($data["second_opener_old"] == '0' || $data["second_opener_old"] == NULL)
								{
										$data["second_opener_old"] = "N/A";
								}
								
								if($data["second_opener"] != $data["second_opener_old"])
								{
									if($data["second_opener_old"] > 0)
									{
										$second_opener_old = GetTitleByField('tbl_user', "id='".$data["second_opener_old"]."'", 'email_id');
									}
									else
									{
										$second_opener_old = "N/A";
									}
									
									if($data["second_opener"] > 0)
									{
										$second_opener = GetTitleByField('tbl_user', "id='".$data["second_opener"]."'", 'email_id');
									}
									else
									{
										$second_opener = "N/A";
									}					
									
									
									$changeStr .= '<tr><td align="left">Second Opener</td>';
									$changeStr .= '<td align="left">'.$second_opener_old.'</td>';
									$changeStr .= '<td align="left">'.$second_opener.'</td></tr>';
								}
								
								if($data["status"] != $data["status_old"])
								{
									$statusArr[0] = "Saved";
									$statusArr[1] = "Publish";
									$statusArr[3] = "Stay";
									$statusArr[4] = "Cancel";
									$statusArr[5] = "Deleted";
									$statusArr[6] = "Completed";
									$statusArr[7] = "Conclude";
									
									$changeStr .= '<tr><td align="left">Status</td>';
									$changeStr .= '<td align="left">'.$statusArr[$data["status_old"]].'</td>';
									$changeStr .= '<td align="left">'.$statusArr[$data["status"]].'</td></tr>';
								}
								
								if($data["indate"] != $data["indate_old"])
								{
									$changeStr .= '<tr><td align="left">Publish Date</td>';
									$changeStr .= '<td align="left">'.$data["indate_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["indate"].'</td></tr>';
								}
								
								$changeStr .= '</table>';
								
								echo $changeStr;
								?>
								
							</div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					
					
				  </div>
				</div>
			  </div>
			</div>
		  </div>
</section>
