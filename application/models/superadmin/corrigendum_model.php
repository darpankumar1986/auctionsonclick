<?php
class Corrigendum_model extends CI_Model {
	private $path = 'public/uploads/property_images/';
	private $videopath = 'public/uploads/videos/';
	private $event_auction = 'public/uploads/event_auction/';
	private $document_auction = 'public/uploads/document/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	function saveeventdata(){ 
	
		$created_by					=	 $this->session->userdata['id'];
		$bank_id 					=	 $this->input->post('bank_name');
		$branch_id			  		=	 $this->input->post('branch_id');
		$auctionID 					=	 $this->input->post('auctionID');
		$corrigendumid				=	 $this->input->post('corrigendumid');
		$remarks 					=	 $this->input->post('remarks');
		$account 					=	 $this->input->post('account');
		$reference_no 				= 	 $this->input->post('reference_no');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category_id');
		$drt_id 					=	 $this->input->post('drt_id');
		$subcategory_id 			=	 $this->input->post('subcategory_id');
		$description	 			=	 $this->input->post('description');
		$borrower_name 				=	 $this->input->post('borrower_name');
		$invoice_mail_to 			=	 $this->input->post('invoice_mail_to');
		$invoice_mailed 			=	 $this->input->post('invoice_mailed');
		$reserve_price 				=	 $this->input->post('reserve_price');
		$emd_amt 					=	 $this->input->post('emd_amt');
		$tender_fee 				=	 $this->input->post('tender_fee');
		$nodal_bank_name 			=	 $this->input->post('nodal_bank_name');
		$nodal_bank 				=	 $this->input->post('nodal_bank');
		$nodal_bank_account			=	 $this->input->post('nodal_bank_account');
		$branch_ifsc_code 			=	 $this->input->post('branch_ifsc_code');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$inspection_date_from 		=	 $this->input->post('inspection_date_from');
		$inspection_date_to 		=	 $this->input->post('inspection_date_to');
		$bid_last_date 				=	 $this->input->post('bid_last_date');
		$bid_opening_date 			=	 $this->input->post('bid_opening_date');
		$auction_start_date 		=	 $this->input->post('auction_start_date');
		$auction_end_date 			=	 $this->input->post('auction_end_date');
		$show_frq 					=	 $this->input->post('show_frq');
		$dsc_enabled 				=	 $this->input->post('dsc_enabled');
		$price_bid 					=	 $this->input->post('price_bid');
		$bid_inc 					=	 $this->input->post('bid_inc');
		$auto_extension_time 		=	 $this->input->post('auto_extension_time');
		$auto_extension 			=	 $this->input->post('auto_extension');
		$doc_to_be_submitted 		=	 $this->input->post('doc_to_be_submitted');
		$second_opener 				=	 $this->input->post('second_opener');				
		$first_opener    			= $this->input->post('first_opener');
		$status    					= $this->input->post('status');
		$indate    					= $this->input->post('indate');
		$show_home    					= $this->input->post('show_home');
		
		//get current data 
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		$auction_data  = $query_auction->result();
		
		
		
		if($branch_id > 0)
		{
			
			$bank_branch_name = $branch_id;
		}
		
		if(!($bank_id > 0))
		{
			$bank_id = $auction_data[0]->bank_id;
		}
		
		if(!($branch_id > 0))
		{
			$branch_id = $auction_data[0]->branch_id;
		}
		
              
		if(!($auto_extension > 0))
		{
			$auto_extension = 0;
		}
		
		$press_release_date			= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		if($inspection_date_from){
			$inspection_date_from		= 	date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}
		if($inspection_date_to){
			$inspection_date_to			= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));	
		}
		$bid_last_date				= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		$bid_opening_date			= 	date("Y-m-d H:i:s",strtotime($bid_opening_date));
		$auction_start_date			= 	date("Y-m-d H:i:s",strtotime($auction_start_date));
		$auction_end_date			= 	date("Y-m-d H:i:s",strtotime($auction_end_date));
                
		//new fields
		$country_id 				=	 $this->input->post('country_id');
		$state_id 				=	 $this->input->post('state_id');
		$city 				        =	 $_POST['city_id'];
		
		if($city=='' || $city == 'others'){
			$other_city = $this->input->post('other_city');
		}else{
			$other_city = '';     
		}
		
	   if($nodal_bank=='others'){
		  $nodal_bank_name 			=	 $this->input->post('nodal_bank_n');
	  }else{
		  $nodal_bank_name 			=	 $this->input->post('nodal_bank_name');   
	  } 
    
		if($_FILES['image_new']['name'])
		{
			$image = $this->uploadauction('image_new');			
		}
		else
		{
			$image = $this->input->post('old_image');
		} 
		
		if($_FILES['related_doc']['name'])
		{
			$related_doc=$this->uploadauction('related_doc');
		}else{
			$related_doc=$this->input->post('old_related_doc');
		}
		
		if($_FILES['supporting_doc']['name'])
		{
			$supporting_doc=$this->uploadauction('supporting_doc');
		}else{
			$supporting_doc=$this->input->post('old_supporting_doc');
		}
              if($doc_to_be_submitted){
			$doc_to_be_submitted=implode(",",$doc_to_be_submitted);
		}
		if($invoice_mailed){
			$invoice_mailed=implode(",",$invoice_mailed);
		}
		
		if($inspection_date_from == "" || $inspection_date_from == '0000-00-00 00:00:00' || $inspection_date_from == '1970-01-01 05:30:00')
		{
			$inspection_date_from = '0000-00-00 00:00:00';
		}
		
		if($inspection_date_to == "" || $inspection_date_to == '0000-00-00 00:00:00' || $inspection_date_to == '1970-01-01 05:30:00')
		{
			$inspection_date_to = '0000-00-00 00:00:00';
		}
		
		$noofparticipate = $this->helpdesk_executive_model->getParticipateByAuctionId($auctionID);
		
		if($noofparticipate > 0)
		{
			$emd_amt = $auction_data[0]->emd_amt;
		}
		//echo '<pre>';
		//print_r($_SERVER);die;
		$mac_ip=$_SERVER['REMOTE_ADDR'];
		/*echo $mac_string = shell_exec("arp -a $mac_ip");die;
		$mac_array = explode(" ",$mac_string);
		$mac = $mac_array[3];
		$mac_ip = ($ip." - ".$mac);*/
				
		$data = array(
					'auctionID'=>$auctionID,
					'remarks'=>$remarks,
					'event_type'=>$account,					
					'reference_no'=>$reference_no,
					'event_title'=>$event_title,
					'category_id'=>$category_id,
					'subcategory_id'=>$subcategory_id,
					'product_description'=>$description,
					'bank_id'=>$bank_id,
					'branch_id'=>$branch_id,
					//'drt_id'=>$drt_id,					
					'borrower_name'=>$borrower_name,
					'invoice_mail_to'=>$invoice_mail_to,
					//'invoice_mailed'=>$invoice_mailed,
					'reserve_price'=>$reserve_price,
					'emd_amt'=>$emd_amt,
					'tender_fee'=>$tender_fee,
					'nodal_bank_name'=>$nodal_bank_name,
					'nodal_bank'=>$nodal_bank,
					'nodal_bank_account'=>$nodal_bank_account,
					'branch_ifsc_code'=>$branch_ifsc_code,
					'press_release_date'=>$press_release_date,
					'inspection_date_from'=>$inspection_date_from,
					'inspection_date_to'=>$inspection_date_to,
					'bid_last_date'=>$bid_last_date,
					'bid_opening_date'=>$bid_opening_date,
					'auction_start_date'=>$auction_start_date,
					'auction_end_date'=>$auction_end_date,
					'bank_branch_id'=>$bank_branch_id,
					'show_frq'=>$show_frq,
					'dsc_enabled'=>$dsc_enabled,
					'bid_inc'=>$bid_inc,					
					'related_doc'=>$related_doc,
					'image'=>$image,
					//'supporting_doc'=>$supporting_doc, 
					'auto_extension_time'=>$auto_extension_time,
					'no_of_auto_extn'=>$auto_extension,
					'doc_to_be_submitted'=>$doc_to_be_submitted,
					//'second_opener'=>$second_opener,
					'countryID'=>  $country_id,
					'state'=> $state_id,
					'city'=> $city,
					//'other_city'=>$other_city,
					'status'=>$status,
					'indate'=>$indate,
					'ip'=>$mac_ip,
					'corrigendum_status'=>'0',
					'show_home' => $show_home
				);	
				
				if($invoice_mailed  > 0)
				{
					$data['invoice_mailed'] = $invoice_mailed;				
				}
				
				if($other_city  != "")
				{
					$data['other_city'] = $other_city;				
				}
				
				if($supporting_doc  != "" && $supporting_doc  != '0')
				{
					$data['supporting_doc'] = $supporting_doc;				
				}
				
				if($second_opener  > 0)
				{
					$data['second_opener'] = $second_opener;				
				}
				
				
				
				//echo $auctionID;die;
				$this->db->where('auctionID', $auctionID);
				$this->db->where('corrigendum_status', '0');
				$query = $this->db->get("tbl_auction_corrigendum_approval");				
				if ($query->num_rows() > 0) {					
					$this->db->where('auctionID', $auctionID);
					$this->db->where('corrigendum_status', '0');
					$this->db->update('tbl_auction_corrigendum_approval',$data);										
					//echo $this->db->last_query();die;
					
					$this->setApproverFlag($auctionID);
					$msg = "Corrigendum has been updated successfully!";
					$this->session->set_flashdata('message',$msg);
					redirect('superadmin/corrigendum/searchevent/'.$auctionID.'/');
				}
				else
				{        
										
					/* get property description */
					$this->db->where('id', $auction_data[0]->productID);
					$query_product = $this->db->get("tbl_product");
					$product_data  = $query_product->result();
					
					
					$data['event_type_old'] = $auction_data[0]->event_type;
					$data['reference_no_old'] = $auction_data[0]->reference_no;
					$data['event_title_old'] = $auction_data[0]->event_title;
					$data['category_id_old'] = $auction_data[0]->category_id;
					$data['subcategory_id_old'] = $auction_data[0]->subcategory_id;
					$data['product_description_old'] = $product_data[0]->product_description;
					$data['bank_id_old'] = $auction_data[0]->bank_id;
					$data['branch_id_old'] = $auction_data[0]->branch_id;
					$data['drt_id_old'] = $auction_data[0]->drt_id;
					$data['borrower_name_old'] = $auction_data[0]->borrower_name;
					$data['invoice_mail_to_old'] = $auction_data[0]->invoice_mail_to;
					$data['invoice_mailed_old'] = $auction_data[0]->invoice_mailed;
					$data['reserve_price_old'] = $auction_data[0]->reserve_price;
					$data['emd_amt_old'] = $auction_data[0]->emd_amt;
					$data['tender_fee_old'] = $auction_data[0]->tender_fee;
					$data['nodal_bank_name_old'] = $auction_data[0]->nodal_bank_name;
					$data['nodal_bank_old'] = $auction_data[0]->nodal_bank;
					$data['nodal_bank_account_old'] = $auction_data[0]->nodal_bank_account;
					$data['branch_ifsc_code_old'] = $auction_data[0]->branch_ifsc_code;
					$data['press_release_date_old'] = $auction_data[0]->press_release_date;
					$data['inspection_date_from_old'] = $auction_data[0]->inspection_date_from;
					$data['inspection_date_to_old'] = $auction_data[0]->inspection_date_to;
					$data['bid_last_date_old'] = $auction_data[0]->bid_last_date;
					$data['bid_opening_date_old'] = $auction_data[0]->bid_opening_date;
					$data['auction_start_date_old'] = $auction_data[0]->auction_start_date;
					$data['auction_end_date_old'] = $auction_data[0]->auction_end_date;
					$data['bank_branch_id_old'] = $auction_data[0]->bank_branch_id;
					$data['show_frq_old'] = $auction_data[0]->show_frq;
					$data['dsc_enabled_old'] = $auction_data[0]->dsc_enabled;
					$data['bid_inc_old'] = $auction_data[0]->bid_inc;
					$data['related_doc_old'] = $auction_data[0]->related_doc;
					$data['image_old'] = $auction_data[0]->image;
					$data['supporting_doc_old'] = $auction_data[0]->supporting_doc;
					$data['auto_extension_time_old'] = $auction_data[0]->auto_extension_time;
					$data['no_of_auto_extn_old'] = $auction_data[0]->no_of_auto_extn;
					$data['doc_to_be_submitted_old'] = $auction_data[0]->doc_to_be_submitted;
					$data['second_opener_old'] = $auction_data[0]->second_opener;
					$data['countryID_old'] = $auction_data[0]->countryID;
					$data['state_old'] = $auction_data[0]->state;
					$data['city_old'] = $auction_data[0]->city;
					$data['other_city_old'] = $auction_data[0]->other_city;
					$data['status_old'] = $auction_data[0]->status;						
					$data['indate_old'] = $auction_data[0]->indate;	
					$data['corrigendum_status'] = '0';
					$data['show_home_old'] = $auction_data[0]->show_home;
					$data['createTime'] = date("Y-m-d H:i:s");
				
					$this->db->insert('tbl_auction_corrigendum_approval',$data); 
					$insertedid_id = $this->db->insert_id();
					
					$this->setApproverFlag($auctionID);
					
					$msg = "Corrigendum has been saved successfully!";
					$this->session->set_flashdata('message',$msg);
					redirect('superadmin/corrigendum/searchevent/'.$auctionID.'/');					
				}
				
	}
	
	public function setApproverFlag($auctionID)
	{
		$firstApproverArr = array("reserve_price","emd_amt","bid_last_date","bid_opening_date","bid_inc","indate");
		$secondApproverArr = array("reserve_price","emd_amt","bid_inc","indate");
		
		$firstExpireItemArr = array("auction_start_date","auction_end_date","dsc_enabled","status");
		$secondexpireItemArr = array("status");
		
		$this->db->where('auctionID', $auctionID);
		$this->db->where('corrigendum_status', '0');
		$query = $this->db->get("tbl_auction_corrigendum_approval");
		
		$this->db->where('id', $auctionID);		
		$auction_query = $this->db->get("tbl_auction");
		$auctionData = $auction_query->result();
		
		if ($query->num_rows() > 0) {	
			foreach ($query->result() as $row) 
			{
				$data = array();
				$data['first_approver'] = null;
				$data['second_approver'] = null;
				
				foreach($row as $key => $v)
				{
					if(in_array($key,$firstApproverArr))
					{
						if($row->$key != $row->{$key."_old"})
						{
							$data['first_approver'] = 1;
						}
					}
					
					if(in_array($key,$secondApproverArr))
					{
						if($row->$key != $row->{$key."_old"})
						{
							$data['second_approver'] = 1;
						}
					}
					
					if(strtotime($auctionData[0]->auction_end_date) <= time() && ($data['second_approver'] != 1 || $data['first_approver'] != 1))
					{
						if(in_array($key,$firstExpireItemArr))
						{
							if($row->$key != $row->{$key."_old"})
							{
								$data['first_approver'] = 1;
							}
						}
						
						if(in_array($key,$secondexpireItemArr))
						{
							if($row->$key != $row->{$key."_old"})
							{
								$data['second_approver'] = 1;
							}
						}
						
					}
					
					
				}				
				
				$this->db->where('auctionid', $auctionID);				
				$this->db->where('corrigendum_status','0');
				$query_auction1 = $this->db->update("tbl_auction_corrigendum_approval",$data);
			}
		}
	}
	
	public function updateAuction($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");
		if ($query->num_rows() > 0) {	
			foreach ($query->result() as $auction) {
				$pModified_date = $auction->modified_date;
			}
		}
				
				
		$this->db->where('auctionID', $auctionID);
		$this->db->where('corrigendum_status', '0');
		$query = $this->db->get("tbl_auction_corrigendum_approval");
		if ($query->num_rows() > 0) {	
			foreach ($query->result() as $row) {				
				$data = array(										
					'event_type'=>$row->event_type,				
					'reference_no'=>$row->reference_no,
					'event_title'=>$row->event_title,
					'category_id'=>$row->category_id,
					'subcategory_id'=>$row->subcategory_id,
					//'product_description'=>$row->product_description,
					'bank_id'=>$row->bank_id,
					'branch_id'=>$row->branch_id,					
					'borrower_name'=>$row->borrower_name,
					'invoice_mail_to'=>$row->invoice_mail_to,
					'invoice_mailed'=>$row->invoice_mailed,
					'reserve_price'=>$row->reserve_price,
					//'emd_amt'=>$row->emd_amt,
					'tender_fee'=>$row->tender_fee,
					'nodal_bank_name'=>$row->nodal_bank_name,
					'nodal_bank'=>$row->nodal_bank,
					'nodal_bank_account'=>$row->nodal_bank_account,
					'branch_ifsc_code'=>$row->branch_ifsc_code,
					'press_release_date'=>$row->press_release_date,
					'inspection_date_from'=>$row->inspection_date_from,
					'inspection_date_to'=>$row->inspection_date_to,
					'bid_last_date'=>$row->bid_last_date,
					'bid_opening_date'=>$row->bid_opening_date,
					'auction_start_date'=>$row->auction_start_date,
					'auction_end_date'=>$row->auction_end_date,
					'bank_branch_id'=>$row->bank_branch_id,
					'show_frq'=>$row->show_frq,
					'dsc_enabled'=>$row->dsc_enabled,
					'bid_inc'=>$row->bid_inc,					
					'related_doc'=>$row->related_doc,
					'image'=>$row->image,
					'supporting_doc'=>$row->supporting_doc, 
					'auto_extension_time'=>$row->auto_extension_time,
					'no_of_auto_extn'=>$row->no_of_auto_extn,
					'doc_to_be_submitted'=>$row->doc_to_be_submitted,
					'second_opener'=>$row->second_opener,
					'countryID'=>$row->countryID,
					'state'=>$row->state,
					'city'=> $row->city,
					'other_city'=>$row->other_city,
					'status'=>$row->status,
					'indate'=>$row->indate,	
					'show_home'=>$row->show_home,	
				);	
				
				$noofparticipate = $this->helpdesk_executive_model->getParticipateByAuctionId($auctionID);
		
				if(!($noofparticipate > 0))
				{
					$data['emd_amt'] = $row->emd_amt;
				}
				
			
				$this->db->where('id', $auctionID);				
				$this->db->update('tbl_auction',$data);
				
				
				$this->db->where('id', $auctionID);
				$query = $this->db->get("tbl_auction");
				if ($query->num_rows() > 0) {	
					foreach ($query->result() as $auction) {
						$auctionData = $auction;
					}
				}
								
				$logData = 	$data;
				
				$logData['auction_id'] = $auctionID;				
				$logData['created_by'] = $auctionData->created_by;
				$logData['first_opener'] = $auctionData->first_opener;
				$logData['tender_no'] = ($auctionData->tender_no == null)?0:$auctionData->tender_no;
				$logData['eventID'] = $auctionData->eventID;
				$logData['productID'] = $auctionData->productID;
				$logData['price_bid_applicable'] = $auctionData->price_bid_applicable;
				$logData['updated_date'] = $auctionData->updated_date;				
				$logData['is_corrigendum'] = $auctionData->is_corrigendum;
				$logData['is_invoice_generated'] = $auctionData->is_invoice_generated;
				$logData['is_payment_recived'] = $auctionData->is_payment_recived;				
				$logData['drt_id'] = $auctionData->drt_id;
				$logData['price_bid'] = $auctionData->price_bid;
				$logData['added_autoextension_time'] = $auctionData->added_autoextension_time;
				$logData['auto_bid_cut_off'] = $auctionData->auto_bid_cut_off;
				$logData['allow_auto_bid'] = $auctionData->allow_auto_bid;
				$logData['resume_time'] = $auctionData->resume_time;				
				$logData['opening_price'] = $auctionData->opening_price;
				$logData['completion_time'] = $auctionData->completion_time;
				$logData['extentions_count'] = $auctionData->extentions_count;
				$logData['hit_count'] = $auctionData->hit_count;
				$logData['direct_event'] = $auctionData->direct_event;
				$logData['stageID'] = $auctionData->stageID;				
				$logData['auction_pause_time'] = $auctionData->auction_pause_time;
				$logData['auction_resume_time'] = $auctionData->auction_resume_time;
				$logData['auction_bidding_activity_status'] = $auctionData->auction_bidding_activity_status;
				$logData['is_closed'] = $auctionData->is_closed;
				$logData['auction_type'] = $auctionData->auction_type;				
				
				$this->db->insert('tbl_log_auction',$logData);
				
				
				$type 			=	 $row->subcategory_id;
				$category 		= 	 $row->category_id;
				$product_type_val=GetTitleByField('tbl_category', "id=".$category."", 'name');						
                $name 			=	 $row->borrower_name;		
                $description 	=	 $row->product_description;				
				$Country 		=	 $row->countryID;
				$State 			=	 $row->state;
				$City 			=	 $row->city;
				$product_subtype_val=GetTitleByField('tbl_category', "id=".$type."", 'name');
				
				$productData 		= array(
							'name'=>$name,
							'product_description'=>$description,				
							'product_type'=>$category,
							'product_subtype_id'=>$type,
							'product_type_val'=>$product_type_val,
							'product_subtype_val'=>$product_subtype_val,
							'country'=>$Country,
							'state'=>$State,
							'city'=>$City
							);
              
					$productData['updated_date']=date('Y-m-d H:i:s');
					
					$this->db->where('id', $auctionID);					
					$query = $this->db->get("tbl_auction");	
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {				
							$this->db->where('id', $row->productID);
							$this->db->update('tbl_product', $productData); 
						}
					}
				
				$this->db->where('auctionID', $auctionID);
				$this->db->where('corrigendum_status', '0');
				$this->db->update('tbl_auction_corrigendum_approval',array('corrigendum_status'=>2));		
				
			}
		}
		return $pModified_date;
	}
	
	public function getApproverList()
	{
		//$this->db->where('register_as','mis');
		$this->db->where_in('id',array(870,1485,2637));
		$this->db->where('status','1');
		$query = $this->db->get("tbl_user_registration");		
		$data = array();
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
                $data[] = $row;
            }
		}
		return $data;
	}
	
	public function getApproverFirstList()
	{
		$this->db->where_in('id',array(27826));
		$this->db->where('status','1');
		$query = $this->db->get("tbl_user_registration");		
		$data = array();
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
                $data[] = $row;
            }
		}
		return $data;
	}
	
	public function getCorrigendumByAuctionId($auctionID)
	{
		//get current data 
		$this->db->where('auctionid', $auctionID);				
		$this->db->where('corrigendum_status','0');
		$query_auction1 = $this->db->get("tbl_auction_corrigendum_approval");
		//echo $this->db->last_query();die;
		if($query_auction1->num_rows() > 0)
		{
			foreach ($query_auction1->result() as $row) {
				//echo '<pre>';
				//print_r($row);die;
                return $row;
            }
		}
		return false;	
	}
	
	public function getCorrigendumByCorrigendumId($currID)
	{
		//get current data 
		$this->db->where('id', $currID);				
		$this->db->where('corrigendum_status','2');
		$query_auction1 = $this->db->get("tbl_auction_corrigendum_approval");
		//echo $this->db->last_query();die;
		if($query_auction1->num_rows() > 0)
		{
			foreach ($query_auction1->result() as $row) {
				//echo '<pre>';
				//print_r($row);die;
                return $row;
            }
		}
		return false;	
	}
	
	public function resetCorrigendumByAuctionId($auctionID)
	{
		//get current data 
		$data = array();
		$data['corrigendum_status'] = 3;
		$this->db->where('auctionid', $auctionID);				
		$this->db->where('corrigendum_status','0');
		$query_auction1 = $this->db->update("tbl_auction_corrigendum_approval",$data);
		//echo $this->db->last_query();die;
		return true;	
	}
	
	public function previewUpdate($auctionID)
	{
		//get current data 
		$data = array();
		$data['first_approver_id'] = $this->input->post('first_approve');
		$data['second_approver_id'] = $this->input->post('second_approve');
		
		if($_FILES['upload_document_approval']['name'])
		{
			$data['upload_document_approval'] = $this->uploadauction('upload_document_approval');
		}				
		
		$this->db->where('auctionid', $auctionID);				
		$this->db->where('corrigendum_status','0');
		$query_auction1 = $this->db->update("tbl_auction_corrigendum_approval",$data);
		//echo $this->db->last_query();die;
		return true;	
	}
	
	function corrigendumdatatable()
    {	
		
		$this->db->query("SET @row = 0",false); //@row := @row + 1 as SNo,
       // $this->datatables->select("@row := @row + 1 as SNo,ta.id,ta.reference_no , tac.product_description, DATE_FORMAT(tac.bid_last_date,'%d %M %Y %H:%i:%s'),DATE_FORMAT(tac.bid_opening_date,'%d %M %Y %H:%i:%s'), DATE_FORMAT(tac.auction_start_date,'%d %M %Y %H:%i:%s'),DATE_FORMAT(tac.auction_end_date,'%d %M %Y %H:%i:%s') ,DATE_FORMAT(tac.indate,'%d %M %Y %H:%i:%s')",false)
         $this->datatables->select("tac.id as SNo,tac.auctionID as eventID,tac.id,ta.reference_no , tac.product_description, tac.bid_last_date,tac.bid_opening_date,tac.auction_start_date,tac.auction_end_date ,tac.createTime,tac.upload_document_approval",false)
      
                ->unset_column('tac.id')	   
		->add_column('Actions',"<a href='/superadmin/corrigendum/viewCorrigendum/$1' class='corrigendum_detail_iframe'>View</a>", 'tac.id')
        ->from('tbl_auction_corrigendum_approval as tac')
		->join('tbl_auction as ta','tac.auctionID=ta.id','left ')
		->join('tbl_product as tp','ta.id=tp.auctionID','left ');	
		$this->db->where('corrigendum_status', '2');
		$this->db->group_by('tac.id'); 
		$this->db->order_by('tac.id','DESC');
		return $this->datatables->generate();
    }
	
	function uploadauction($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '45120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true; // Change for Filename change
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());			
			//print_r($error);die;
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
    
}

?>
