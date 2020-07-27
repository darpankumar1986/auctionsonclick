<?php
class Admin_model extends CI_Model {
	
	private $apath = 'public/uploads/property_images/';
	private $event_auction = 'public/uploads/event_auction/';
	private $document_auction = 'public/uploads/document/';
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('admin/role_model');
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(*) as total');
			//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_admin");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		$this->db->where('status !=', 5);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_admin");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_admin");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_admin_data($image=null) {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$indate = $this->input->post('indate');
		$status = $this->input->post('status');
		$data = array(
					'name'=>$name ,
					'email'=>$email,	
					'role'=>$role,
					'indate'=>$indate,
					'status'=>$status
					);
		if($id)			
		{
			$data['password'] = $this->input->post('password');
			$this->db->where('id', $id);
			$this->db->update('tbl_admin', $data); 
		}
		else
		{
			if($this->input->post('password') != ''){
				$data['password'] = $this->input->post('password');
			}
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_admin',$data); 
		}
		return true;
	}
	
 public function validate(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean|callback_check_database');
	//$this->security->xss_clean();
	$username = $this->input->post('user_email');
	$password = $this->input->post('user_pass');
	//$username=$this->db->escape($username);
	//$password=$this->db->escape($password);
	$username=$this->db->escape_str($username);
	$password=$this->db->escape_str($password);
	$username=$this->security->xss_clean($username);
	$password=$this->security->xss_clean($password);
	
	if($this->form_validation->run() == FALSE)
	{
		return false;
	}
	else
	{
			$remember_password = $this->input->post('remember_password');
			if($remember_password)
			{
			$_COOKIE['user_email']=$username;
			$_COOKIE['user_pass']=$password;
			}
			$this->db->where('email', $username);
			$this->db->where('admin_type', 0); //0-Admin
			//$this->db->where('password',$password);
			$this->db->where('status', 1);
			$query = $this->db->get('tbl_admin'); 
                        $row=$query->result();
			if($query->num_rows == 1)
			{
                       $generatedPass=hash("sha256", $password);   
                     if($this->is_valid_password($generatedPass, $row[0]->password)==0){
                        $row = $query->row();
                        $data = array(
                                    'adminid' => $row->id,
                                    'aname' => $row->name,
                                    'aemail' => $row->email,
                                    'validated' => true,
                                    'arole' => $row->role
                                     );
                        $this->session->set_userdata($data);
		        return true;    
                      }else{
                      return false;    
                      }
                      return false;   
                     }
		   
                     
	     }
}

        public function is_valid_password($generatedPass,$Password){
                    return strcmp($generatedPass,$Password);
               }
	public function GettotalSavedAuctionRecord() {
		$this->db->select(" COUNT(id) as totalsavedrecods");
		$this->db->where('status',0);
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->totalsavedrecods;
            }
            return $data;
        }else{
			return $data=0;
		}
    }
	public function GettotalUpcomingAuctionRecord() {
		$this->db->select("COUNT(id) as totalsavedrecods");
		$this->db->where('status !=',0);
		$this->db->where('bid_last_date >= NOW()');
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->totalsavedrecods;
            }
            return $data;
        }else{
			return $data=0;
		}
    }
    
    public function setRole()
	{
		
		$user_dept_id = $this->input->post('user_dept_id');
		$userid= $this->session->userdata('adminid');
		
		$this->db->select('ud.*, tu.first_name, tu.last_name,tu.email_id');
		$this->db->from('tbl_user_department as ud');
		$this->db->join('tbl_user as tu','tu.id=ud.user_id','left');
		$this->db->where('ud.user_deprt_id',$user_dept_id);
		$this->db->where('ud.user_id',$userid);
		$this->db->where('ud.status',1);
		$qry = $this->db->get();		
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
				
				$rows = $qry->result_array();
				$this->session->set_userdata('role_id',$rows[0]['role_id']);
				$this->session->set_userdata('depart_id',$rows[0]['department_id']);
				
				if ($rows[0]['role_id'] ==6) {
					
					$data = array(
                                'adminid' => $rows[0]['user_id'],
                                'id' => $rows[0]['user_id'],
                                'aname' => $rows[0]['first_name'].' '.$rows[0]['last_name'],
                                'aemail' => $row[0]['email_id'],
                                'validated' => true,
                                'arole' => 1
                                 );
                    $this->session->set_userdata($data);
                    redirect(base_url().'admin/home');
                }
                else{ 
					
				$this->session->unset_userdata('adminid'); 
				$this->session->unset_userdata('id'); 
				$this->session->unset_userdata('aname'); 
				$this->session->unset_userdata('aemail'); 
				$this->session->unset_userdata('validated');
				$this->session->unset_userdata('arole'); 
				
				$user_type = 'buyer';	
                $rand = rand(1000000000, 9999999999);
                $res = $this->bankuserupdate_login($rows[0]['user_id']);
                $this->session->set_userdata('id', $rows[0]['user_id']);
                $this->session->set_userdata('full_name', $rows[0]['first_name'].' '.$rows[0]['last_name']);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('bank_id', 41);
                $this->session->set_userdata('branch_id', 0);
                
                $this->session->set_userdata('session_id_user', $rand);
                $this->session->set_userdata('table_session', 'banker_tb'); 
                                
                 if($this->session->userdata('role_id')==3)
                {
					
					redirect(base_url()."buyer/emd_payment_verification");
					exit;
				}
				else
				{                
					redirect(base_url()."registration/redirectDashboard");
					exit;
				}
					 
			}
		}
		
	}
	
	public function bankuserupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $setarray);
        return true;
    }
    
    function getAllCloseAuctionBidder($auctionID){
		//echo $auctionID;die;
		$query=$this->db->query("SELECT * from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			foreach ($query->result() as $row) {
						$data[] = $row->bidderID;
					}
		}else{
			$data = 0;	
		}
		return $data;
	}
	
	function saveeventdata(){ 
  
		//ini_set("display_errors", "1");
		//error_reporting(E_ALL);
		/*echo '<pre>';
        print_r($_POST);
        print_r($_FILES);die;*/
		$bank_id					= 	 $this->input->post('bank_id');
		$branch_id					= 	 $this->input->post('branch_id');
		$created_by					=	 $this->session->userdata['adminid'];
		$auctionID 					=	 $this->input->post('auctionID');
		$account 					=	 $this->input->post('account');
		$reference_no               = 	 $this->input->post('reference_no');
		$dispatch_date 				=	 $this->input->post('dispatch_date');
		//$bank_name 				=	 $this->input->post('bank_name');		
		$propertyDescription        =	 $this->input->post('description');
		$area		 	  		    =	 $this->input->post('area');
		$area_unit_id	 			=	 $this->input->post('area_unit_id');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category_id');
		$vehicle_type 				=	 $this->input->post('vehicle_type');
		$is_corner_property			=	 $this->input->post('is_corner_property');
		$remark						=	 $this->input->post('remark');
        $scheme_id                  =	 $this->input->post('scheme_id');
		$scheme_name				=	 $this->input->post('scheme_name');
		//$cprms_scheme_name		=	 $this->input->post('cprms_scheme_name');
		$service_no					=	 $this->input->post('service_no');
		$zone_id					=	 $this->input->post('zone_id');
		$far						=	 $this->input->post('far');
		$property_height			=	 $this->input->post('property_height');
		$height_unit_id				=	 $this->input->post('height_unit_id');
		$max_coverage_area			=	 $this->input->post('max_coverage_area');
		$drt_id 					=	 $this->input->post('drt_id');
		$subcategory_id 			=	 $this->input->post('subcategory_id');
		$borrower_name 				=	 $this->input->post('borrower_name');
		$invoice_mail_to 			=	 $this->input->post('invoice_mail_to');
		$invoice_mailed 			=	 $this->input->post('invoice_mailed');
		$tender_fee 				=	 $this->input->post('tender_fee');
		$reserve_price 				=	 $this->input->post('reserve_price');
		$unit_id_of_price			=	 $this->input->post('unit_id_of_price');		
		$emd_amt 					=	 $this->input->post('emd_amt');		
		$nodal_bank_name 			=	 $this->input->post('nodal_bank_name');
		$nodal_bank 				=	 $this->input->post('nodal_bank');
		$nodal_bank_account			=	 $this->input->post('nodal_bank_account');
		$branch_ifsc_code 			=	 $this->input->post('branch_ifsc_code');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$registration_start_date	=	 $this->input->post('registration_start_date');
		$registration_end_date 		=	 $this->input->post('registration_end_date');
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
                
		$open_price_bid             = 	1;
		$opening_price 				=	 $this->input->post('reserve_price');
	  
		$second_opener 				=   $this->session->userdata['adminid'];
		        
		
		$auto_bid_cut_off 			=	 $this->input->post('auto_bid_cut_off');
		$is_closed 					=	 $this->input->post('is_closed');
		$bidders_list 				=	 $this->input->post('bidders_list');
		$auction_type               =    $this->input->post('auction_type'); // 1-property type, 2-vehicle type
		$first_opener 				= 	 $this->session->userdata['adminid'];// New Added
		$drtEvent 					=	 $this->input->post('drtEvent');		
		$bank_branch_id 			=	 $this->input->post('bank_branch_name');
		
		$latitude					=	 $this->input->post('latitude');
		$longitude					=	 $this->input->post('longitude');
		$contact_person_details_1   =	 $this->input->post('contact_person_details_1');		
		$contact_person_details_2   =	 $this->input->post('contact_person_details_2');
		$save						=	 $this->input->post('Save');
		$publish					=	 $this->input->post('Publish');
		$create_copy				=	 $this->input->post('create_copy');
		
		$mode_of_bid				=	 $this->input->post('mode_of_bid');
		
		$upload_document_field 		= 	 $this->GetUploadDocumentFieldRecords();
		
		$depart_id 					=	 $this->session->userdata('depart_id');
		
		      
		/*if($auto_extension_time!='' && $auto_extension=='')
		{
			$auto_extension=100;	
		}else if($auto_extension_time>0 && $auto_extension<=0)
		{
			$auto_extension=$auto_extension;	
		}else{
			$auto_extension=$auto_extension;	
		}*/
		if($auto_extension_time =='')
		{
			$auto_extension_time = 0;
		}
		if($auto_extension == '')
		{
			$auto_extension = 0;
		}
		if($height_unit_id == '' || $height_unit_id <=0)
		{
			$height_unit_id =0;
		}
		
		$press_release_date	= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		if($inspection_date_from)
		{
			$inspection_date_from = date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}
		if($inspection_date_to)
		{
			$inspection_date_to	= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));	
		}
		$dispatch_date			=	date("Y-m-d H:i:s",strtotime($dispatch_date));
		$bid_last_date			= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		//$bid_opening_date		= 	date("Y-m-d H:i:s",strtotime($bid_opening_date)); 
		$bid_opening_date		= 	date("Y-m-d H:i:s");
		$registration_start_date	= 	date("Y-m-d H:i:s",strtotime($registration_start_date));
		//$registration_end_date		= 	date("Y-m-d H:i:s",strtotime($registration_end_date));
		
		$auction_start_date			= 	date("Y-m-d H:i:s",strtotime($auction_start_date));
		$auction_end_date			= 	date("Y-m-d H:i:s",strtotime($auction_end_date));
                
        //new fields
		$country_id =	 $this->input->post('country');
		$state_id 	=	 $this->input->post('state');
		$city 		=	 $_POST['city'];
        
				

		if($city=='' || $city == 'others')
		{
			$other_city = $this->input->post('other_city');
		}
		else
		{
			$other_city = '';     
		}
                
        if($nodal_bank=='others')
        {
            $nodal_bank_name = $this->input->post('nodal_bank_n');
        }
        else
        {
            $nodal_bank_name = $this->input->post('nodal_bank_name');   
        } 
        	
        $salesPerson = $this->getSalesPerson($state_id);

		$sales_person_id = $salesPerson[0]->id;
		
		if($publish)
		{
			$approvalStatus=2;
			$status=1; 
			$pstatus=1;
			$approverComments =	 '';
		}
		
        if($save)
        {
			$approvalStatus = 0;
			$approverComments =	 '';
			
			$status=0; 
			$pstatus=4;
		}
        		
        if($doc_to_be_submitted)
        {
			$doc_to_be_submitted=implode(",",$doc_to_be_submitted);
		}
		
		if($invoice_mailed)
		{
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
		if($dispatch_date == "" || $dispatch_date == '0000-00-00 00:00:00' || $dispatch_date == '1970-01-01 05:30:00')
        {
            $dispatch_date = '0000-00-00 00:00:00';
        }
		
		$data 	= array(
			//'productID'=>$productID,
			'event_type'=>'',
			'account_type_id'=>$account,
			'auto_bid_cut_off'=>$auto_bid_cut_off,
			'reference_no'=>$reference_no,
			'event_title'=>$event_title,
			'dispatch_date'=>$dispatch_date,
			'vehicle_type'=>$vehicle_type,
			'subcategory_id'=>$subcategory_id,
			'area_unit_id'=>$area_unit_id,
			'is_corner_property'=>$is_corner_property,
			'remark'=>$remark,
			'scheme_id'=>$scheme_id,
			'scheme_name'=>$scheme_name,
			'open_price_bid'=>$open_price_bid,
			'opening_price'=>$opening_price,
			//'cprms_scheme_name'=>$cprms_scheme_name,
			'service_no'=>$service_no,
			'zone_id'=>$zone_id,
			'department_id'=>$depart_id,
			'far'=>$far,
			'property_height'=>$property_height,
			'height_unit_id'=>$height_unit_id,
			'max_coverage_area'=>$max_coverage_area,
			'unit_id_of_price'=>$unit_id_of_price,
			'registration_start_date'=>$registration_start_date,
			'registration_end_date'=>date('Y-m-d H:i:s'),
			'mode_of_bid'=>$mode_of_bid,
			'branch_id'=>$branch_id,
			'drt_id'=>$drt_id,
			'bank_id'=>$bank_id,
			'borrower_name'=>$borrower_name,
			'invoice_mail_to'=>$invoice_mail_to,
			'invoice_mailed'=>$invoice_mailed,
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
			'price_bid_applicable'=>$price_bid,			
			'auto_extension_time'=>$auto_extension_time,
			'no_of_auto_extn'=>$auto_extension,
			'doc_to_be_submitted'=>$doc_to_be_submitted,
			'second_opener'=>$second_opener,
			'created_by'=>$created_by,
			'first_opener'=>$created_by,
			'auction_type'=>$auction_type,
			'indate'=>date('Y-m-d H:i:s'),
			'is_closed'=>$is_closed,
			'countryID'=>  $country_id,
			'state'=> $state_id,
			'city'=> $city,
			'area'=>$area,
			'latitude'=>$latitude,
			'longitude'=>$longitude,
			'other_city'=>$other_city,
			'status'=>$status,
			'contact_person_details_1'=>$contact_person_details_1,			
			'contact_person_details_2'=>$contact_person_details_2,
			'approvalStatus'=>$approvalStatus,
			'approverComments'=>$approverComments,
			'PropertyDescription'=>$propertyDescription,
			'sales_person_id'=>($sales_person_id!='')?$sales_person_id:0			
		);
		
		/*
		echo"<pre>";
		print_r($data);die;
		*/
		
		/*$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
		$this->db->last_query();
		$insertedid_id 	=$auctionID;*/
						
		if($auctionID)
		{
			$datalog = $data;
			
			
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',$data); 
			
			$copy_count = $this->input->post('copy_count');
			if($copy_count > 0 && $create_copy)
			{
				$this->db->trans_begin();
				
				$this->db->where('auction_id',$auctionID);
				$this->db->where('status',1);
				$aDocQry = $this->db->get('tbl_auction_document');
				if($aDocQry->num_rows()>0)
				{
					$aDocRow = $aDocQry->result();
					
				}
				//echo "<pre>";print_r($aDocRow);die;
				
				$copyData = $data;
				$copyData['approvalStatus'] = 0;
				$copyData['approverComments'] = '';
				$isCopy=0;
				for($i=1;$i<=$copy_count;$i++)
				{
					$this->db->insert('tbl_auction',$copyData);					
					$copyInsertId = $this->db->insert_id();		
									
					$copyDataLog = $copyData;
					$copyDataLog['ip'] = $_SERVER['REMOTE_ADDR'];
					$copyDataLog['auction_id'] = $copyInsertId;
					$this->db->insert('tbl_log_auction',$copyDataLog);	
					$copyDataFile = array();
					foreach($aDocRow as $aDRow)
					{
						if($aDRow->upload_document_field_id==0) // Upload Photographs Documents
						{
							$photoCaption = $aDRow->photo_caption;
						}
						else
						{
							$photoCaption = '';
						}
						
						
						$this->db->where('auction_id',$copyInsertId);
						$this->db->where('auction_document_id',$aDRow->auction_document_id);
						$dQry = $this->db->get('tbl_auction_document');
						
						
						$copyDataFile =array(
									'auction_id'=>$copyInsertId,
									'upload_document_field_id'=>$aDRow->upload_document_field_id,
									'upload_document_field_name'=>$aDRow->upload_document_field_name,
									'file_path'=>$aDRow->file_path,
									'photo_caption'=>$photoCaption,
									'date_created'=>date('Y-m-d H:i:s'),
									'status'=>1
							);
							
						if($dQry->num_rows()>0)
						{
							$this->db->where('auction_id',$copyInsertId);
							$this->db->where('auction_document_id',$aDRow->auction_document_id);
							$this->db->update('tbl_auction_document',$copyDataFile);
						}
						else
						{
							$this->db->insert('tbl_auction_document',$copyDataFile);
						}	
						
					}
					
					//print_r($copyDataFile);die;
					
					
				}
				
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					log_message('error', 'Unable to create copies of auctions');
				}
				else
				{
					$this->db->trans_commit();
					if($copyInsertId)
					{
						$isCopy=1;
					}
						
				}	
				//echo "<pre>";print_r($copyDataFile);die;			
				
			}
			
			$insertedid_id 	=$auctionID;
			$datalog['auction_id'] = $insertedid_id;
			$datalog['ip'] = $_SERVER['REMOTE_ADDR'];		
			$this->db->insert('tbl_log_auction',$datalog);
		}else{
			$currentdate=date('Y-m-d H:i:s');
			$data['updated_date']=$currentdate;
			$this->db->insert('tbl_auction',$data); 
			
			$insertedid_id = $this->db->insert_id();			
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['auction_id'] = $insertedid_id;
			$this->db->insert('tbl_log_auction',$data);			
			
		}			
				
		/*
		if($_FILES['image'])
		{
			$this->db->where('auction_id',$insertedid_id);
			$this->db->where('status',1);
			$this->db->update('tbl_auction_image',array('status'=>0));
			$files=$this->upload_files($_FILES['image']);
			if(count($files)>0)
			{
				$date = date('Y-m-d H:i:s');
				foreach($files as $val)
				{
					$data1 = array(
					'auction_id'=>$insertedid_id,
					'image_full_path' => $this->event_auction.$val,
					'date_created' => $date,
					'status' =>1
					);
					
					$this->db->insert('tbl_auction_image',$data1);
				}
			}
		}
		*/
		
		if(is_array($_FILES) && count($_FILES)>0)
		{
			$photo_caption = $this->input->post('photo_caption');
			if(count($photo_caption) != '')
			{
				$photoFileArr = $this->upload_files($_FILES['upload_property_photo']);	
				//echo "<pre>";print_r($photoFileArr);die;
				foreach($photoFileArr as $k => $photo)				
				{		
					
					//echo $_FILES['upload_property_photo']['name'][$k];die;
							
					//echo $photo_caption[$k];die;
					$rData = array(
						'auction_id'=>$insertedid_id,
						'upload_document_field_id'=>0,
						'upload_document_field_name'=>'Upload Property Photograph',
						'file_path'=>$photo,
						'photo_caption'=>$photo_caption[$k],
						'date_created'=>date('Y-m-d H:i:s'),
						'status'=>1
					);
					
					$this->db->insert('tbl_auction_document',$rData);
					
				}
				
				
				
			}
			
			foreach($_FILES as $key => $fls)
			{						
				foreach($upload_document_field as $udf)
				{
					$fieldName = strtolower(str_replace(' ','_',$udf->upload_document_field_name));
					if($key == $fieldName)
					{
						if($_FILES[$fieldName]['name']!='')
						{							
							if($udf->upload_document_field_type ==1)
							{
								$uploadFile = $this->uploadauction($key);
							}
							else if($udf->upload_document_field_type ==2)
							{
								$uploadFile = $this->uploadeventvideo($key);
							}
							
							$this->db->where('auction_id',$insertedid_id);
							$this->db->where('upload_document_field_id',$udf->upload_document_field_id);
							$dQry = $this->db->get('tbl_auction_document');
							
							$dataFile =array(
									'auction_id'=>$insertedid_id,
									'upload_document_field_id'=>$udf->upload_document_field_id,
									'upload_document_field_name'=>$udf->upload_document_field_name,
									'file_path'=>$uploadFile,
									'date_created'=>date('Y-m-d H:i:s'),
									'status'=>1
							);
							
							if($dQry->num_rows()>0)
							{
								$this->db->where('auction_id',$insertedid_id);
								$this->db->where('upload_document_field_id',$udf->upload_document_field_id);
								$this->db->update('tbl_auction_document',$dataFile);
							}
							else
							{
								$this->db->insert('tbl_auction_document',$dataFile);
							}
						}
					}
					
				}						
				
			}
		}
		
		
                                                
		$productID 		     =	$this->input->post('productID');	
		$type 			     =	($this->input->post('subcategory_id'))?$this->input->post('subcategory_id'):0;
		$category 		     =  ($this->input->post('category_id'))?$this->input->post('category_id'):0;
		$product_type_val    =  GetTitleByField('tbl_category', "id=".$category."", 'name');
		$records		     =	$this->GetRecordByCategory($type,$is_auction='auction',$is_bank='bank',$is_sell='sell');
		$description 	     =	$this->input->post('description');		
        $product_subtype_val =  GetTitleByField('tbl_category', "id=".$type."", 'name');
        
		$data 	= array(
			'product_description'=>$description,			
			'auctionID'=>$insertedid_id,
			'is_auction'=>1,
			'product_type'=>$category,
			'product_subtype_id'=>$type,
			'product_type_val'=>$product_type_val,
			'product_subtype_val'=>$product_subtype_val,
			'status'=>3
			);
								
			if($productID)			
			{
				$updateddate=date('Y-m-d H:i:s');
				$data['updated_date']=$updateddate;
				$this->db->where('id', $productID);
				$this->db->update('tbl_product', $data); 
				$product_id =$productID;
				
				if($product_id>0){
					//$aucArr=array('updated_date'=>$updateddate);
					//$this->db->where('id', $insertedid_id);
					//$this->db->update('tbl_auction', $aucArr); 
				}
			}
			else
			{
				$data['indate']=date('Y-m-d H:i:s');
				$this->db->insert('tbl_product', $data);	
				$product_id = $this->db->insert_id();	
				if($product_id>0)
				{
					$aucArr=array('productID'=>$product_id);
					$this->db->where('id', $insertedid_id);
					$this->db->update('tbl_auction', $aucArr); 
				}
				
			}		
			
		
				
			//******************Start Add Close Auction Bidders***************
			if($insertedid_id)
			{
				if($is_closed==1)
				{
					if(count($bidders_list))
					{
						$query=$this->db->query("SELECT bidderID from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
						if ($query->num_rows() > 0) 
						{
							foreach ($query->result() as $cbrow)
							{
								if(!in_array($cbrow->bidderID,$bidders_list))
								{
									$this->db->where('auctionID', $auctionID);
									$this->db->where('bidderID', $cbrow->bidderID);
									$this->db->delete('tbl_closed_auction_bidder');	
								}
							}	
						}
						
						// add new bidder 
						$newbidderArr=$this->getAllCloseAuctionBidder($auctionID);
						
						foreach($bidders_list as $bidderID)
						{
							if(!in_array($bidderID,$newbidderArr))
							{
								$bidderdata='';
								$email_id	=	GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'email_id');
								$productUrl=$_SERVER['SERVER_NAME'].$productID;
								$bidderdata = array('bidderID'=>$bidderID,
													'auctionID'=>$auctionID,
													'email'=>$email_id,
													'product_url'=>$productUrl,
													'status'=>1,
													'indate'=>date('Y-m-d H:i:s'));
								 $this->db->insert('tbl_closed_auction_bidder',$bidderdata);
								 $this->sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID);
							}
						}
					}

				}
				//******************End Add Close Auction Bidders***************
				$this->db->where('id', $productID);
				$this->db->update('tbl_product', array('status'=>$pstatus,'updated_date'=>date('Y-m-d H:i:s')));
			}
					
		return $insertedid_id;
	}
	
	public function checkMultipleExtension($filename=null) 
	{
		$strArray = count_chars($filename,1);

		foreach ($strArray as $dotkey=>$dotCountVal)
		  {
			  if(chr($dotkey) == '.')
			  {
				$dotCountValue[] = $dotCountVal;
			  }
		  }	
		  if($dotCountValue[0] > 1)
		  {
			return 'mul';
		  }
		  else
		  {
				if($dotCountValue[0] == '1')
				  {
					  $getFileExt = explode('.',$filename);
					  $getFileExt = strtolower($getFileExt[1]);
					  $allowed =  array('gif','png' ,'jpg','jpeg','xls','doc','docx','zip','pdf');
					  if(!in_array($getFileExt,$allowed) ) 
						{
							 return 'mul';
						}
						
				  }
				 return 'sin';
		   }		
		  return 'sin';
    }
    public function checkHTMLTags($string)
    {
		if($string != strip_tags($string)) 
		{
			// contains HTML
			return '1';
		}
		else
		{
			return '0';	
		}
	}
	
	public function checkVideoMultipleExtension($filename=null) 
	{
		$strArray = count_chars($filename,1);

		foreach ($strArray as $dotkey=>$dotCountVal)
		  {
			  if(chr($dotkey) == '.')
			  {
				$dotCountValue[] = $dotCountVal;
			  }
		  }	
		  if($dotCountValue[0] > 1)
		  {
			return 'mul';
		  }
		  else
		  {
				if($dotCountValue[0] == '1')
				  {
					  $getFileExt = explode('.',$filename);
					  $getFileExt = $getFileExt[1];
					  $allowed =  array('webm','mkv','flv','avi','3gp','mp4','wmv');
					  if(!in_array($getFileExt,$allowed) ) 
						{
							 return 'mul';
						}
						
				  }
				 return 'sin';
		   }		
		  return 'sin';
    }
    
    function saveEventsdatatable()
	{	 //get bank id of logged user
		$userid= $this->session->userdata('id');
		$depart_id = $this->session->userdata('depart_id');
		$bank_id= $this->session->userdata('bank_id');
		
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		//$approvalStatus = array(0,2,3);
		
		// $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
		$this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, cat.name, ea.reserve_price, ea.dsc_enabled, ea.approvalStatus, ea.approverComments",false)
		// ->unset_column('ea.id')		   
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a><a href='/admin/home/createEvent/$1' class=''><img src='/bankeauc/images/edit.png' title='Edit Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_category as cat','cat.id=ea.category_id','left')
		//->where('ea.approvalStatus IN (0,2,3)')
		->where('ea.approvalStatus !=',4)
		//->where('ea.department_id',$depart_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.status',0);
		
		return $this->datatables->generate();
    }
    
    function rejectedEventsdatatable()
	{	 //get bank id of logged user
		$userid= $this->session->userdata('id');
		$depart_id = $this->session->userdata('depart_id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		//$approvalStatus = array(0,2,3);
		
		// $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
		$this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, cat.name, ea.reserve_price, ea.dsc_enabled, ea.approvalStatus, ea.approverComments",false)
		// ->unset_column('ea.id')		   
		//->add_column('Actions',"<a href='/admin/home/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_category as cat','cat.id=ea.category_id','left')
		->where('ea.approvalStatus',4)
		->where('ea.department_id',$depart_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.status',0);
		
		return $this->datatables->generate();
    }
    
    function approvelRejectionEventsdatatable()
	{	 //get bank id of logged user
		 $userid= $this->session->userdata('id');
		 $depart_id = $this->session->userdata('depart_id');
		 $bank_id= $this->session->userdata('bank_id');
		 $branch_id= $this->session->userdata('branch_id');
		 $user_type_ses= $this->session->userdata('user_type');

        // $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
        $this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.auction_start_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,ea.dsc_enabled, ea.approvalStatus",false)
        // ->unset_column('ea.id')		   
		->add_column('Actions',"<a href='/admin/home/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where('ea.approvalStatus IN (1,2,3)')
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.department_id',$depart_id)
		->where('ea.status',0);		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
    
	//liveUpcomingAuctionsdatatable
	function liveUpcomingAuctionsdatatable()
    {
		$depart_id = $this->session->userdata('depart_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
		
		       $this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription,ea.registration_start_date, DATE_FORMAT(ea.auction_start_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' and ( tbl_auction_participate.operner2_accepted = '1' OR (tbl_auction_participate.operner2_accepted IS NULL and tbl_auction_participate.operner1_accepted = '1') ))   as total_bidder,ea.dsc_enabled, ea.stageID",false)

 /*$this->datatables->select(" ea.* ",false)*/
	        //->unset_column('ea.id')	   
		/*->add_column('Actions',"<a href='/admin/home/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/admin/home/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a> <a href='/admin/home/auction_alert_msg/$1' class=''><img src='/bankeauc/images/alert.png' title='Add Alert' class='edit1'></a>", 'ea.id')*/
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a> <a href='/admin/home/createEvent/$1' class=''><img src='/bankeauc/images/edit.png' title='Edit Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		 ->join('tbl_user as tu','ea.created_by=tu.id','left ')
		 ->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		 ->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		 ->join('tbl_drt td','ea.drt_id=td.id','left ')
		 ->join('tbl_product tp','ea.productID=tp.id','left ')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                 ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		//->where('((NOW() >= ea.auction_start_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.auction_start_date)) OR (ea.open_price_bid = 1))')  // Changed as discussed with saurabh
		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))') MAIN

		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.opening_price IS NOT NULL AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))')	
		//->where('((NOW() >= ea.bid_opening_date AND ea.auction_end_date <=NOW()  AND ea.open_price_bid = 1) )') //before
        // neeraj ->where('((NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.open_price_bid = 1) )')   // //COMMENT WRONG QUERY
        // ->where('(NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.opening_price IS NOT NULL )')   // //CAN BE DONE
		->where('ea.status',1);
		//->where('ea.department_id',$depart_id);
		if($this->session->userdata('role_id')==1)
		{
			$this->db->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		}
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
	return $this->datatables->generate();
	//echo $this->db->last_query();die;
    }
	
    function liveEventsdatatable()
    {
		$depart_id = $this->session->userdata('depart_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.bid_last_date,ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		$this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.bid_last_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder,ea.dsc_enabled, ea.stageID",false)
		
        //->unset_column('ea.id')		   
		//->add_column('Action',"<a href='/admin/home/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/admin/home/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a>", 'ea.id')
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a> <a href='/admin/home/createEvent/$1' class=''><img src='/bankeauc/images/edit.png' title='Edit Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left ')
		#->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		//->where('(NOW()>= ea.auction_start_date AND NOW()<= ea.auction_end_date)')
		//->where('bid_last_date')
		->where('ea.bid_last_date >= NOW()')
		->where('ea.status',1);		
		//->where('ea.department_id',$depart_id);
		if($this->session->userdata('role_id')==1)
		{
			$this->db->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		}
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		
		return $this->datatables->generate();
    }
	
    function bids_to_be_openeddatatable()
    {
			$userid= $this->session->userdata('id');
			$depart_id = $this->session->userdata('depart_id');
			$bank_id= $this->session->userdata('bank_id');
			$branch_id= $this->session->userdata('branch_id');
			
			$user_type_ses= $this->session->userdata('user_type');


			//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.bid_opening_date,ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		        $this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.bid_opening_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' ) as total_bidder,ea.dsc_enabled",false)
			
                     //    ->unset_column('ea.id')	   
			//->add_column('Actions',"<a href='/admin/home/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/admin/home/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a>", 'ea.id')
			->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a>  <a href='/admin/home/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a>", 'ea.id')
			->from('tbl_auction as ea')
			->join('tbl_user as tu','ea.created_by=tu.id','left ')
			->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
			->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
			->join('tbl_drt td','ea.drt_id=td.id','left ')
			->join('tbl_product tp','ea.productID=tp.id','left ')
			//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                        ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
			->where('ea.auction_start_date > NOW()')
			->where('NOW()>ea.bid_last_date')
			->where('ea.status',1)
			->where('ea.department_id',$depart_id)
			//->or_where('ea.stageID is NULL')
			//->where('ea.open_price_bid is NULL')
            ->where('ea.open_price_bid',0);                        
            //->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");                
			
			return $this->datatables->generate();
    }
	
	
	
	function completedAuctionsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		$depart_id = $this->session->userdata('depart_id');
      //  $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	    $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	         //->unset_column('ea.id')	 
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where('ea.auction_end_date < NOW()')
		->where('ea.status','6');
		//->where('ea.department_id',$depart_id);
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		$this->db->group_by('ea.id');
        $this->db->order_by("ea.id","desc");
        return $this->datatables->generate();
    }
    
    
    function canceleddatatable()
    {	
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
       // $this->datatables->select("ea.id,tb.name, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price",false)
       $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price",false)
      
                //->unset_column('ea.id')		
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/admin/home/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID = tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
		->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where("ea.status",4);
		//->where("(ea.status ='3' OR ea.status ='4')")
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
    }
    
    
    /*
    public function getAllPages(){
               
		//$this->db->where('auctionID', $auctionID);
		$role_id = $this->session->userdata('role_id');
		
		$this->db->select('rp.*');
		$this->db->where_in('r.role_id',$role_id);
		$this->db->where('rp.is_show_menu',1);
		$this->db->where('rp.status',1);
		$this->db->where('p.status',1);
		$this->db->join('tbl_role_page as rp','rp.role_page_id = p.role_page_id and rp.status = 1');
		$this->db->join('tbl_role as r','r.role_id = p.role_id and  r.status = 1');
		$this->db->order_by('rp.order');
		$query = $this->db->get("tbl_role_page_permission as p");
        return $query->result();
	}
	*/
	
	public function GetUploadDocumentFieldRecords()
    {
		$this->db->where('status', 1);
		$this->db->order_by("upload_document_field_id", "ASC");
        $query = $this->db->get("tblmst_upload_document_field");	
		//echo $this->db->last_query();
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[] = $row;
            }
             return $data;
        }
        return false;
	}
	
	public function upload_files($files)
    {
        $config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|zip|pdf|doc|docx';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {
			if($image !='')
			{
				$_FILES['images[]']['name']= $files['name'][$key];
				$_FILES['images[]']['type']= $files['type'][$key];
				$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
				$_FILES['images[]']['error']= $files['error'][$key];
				$_FILES['images[]']['size']= $files['size'][$key];

				$fileName = time() .'_'.$key.'_'. $image;
				

				$config['file_name'] = $fileName;
				
				$this->upload->initialize($config);

				if ($this->upload->do_upload('images[]')) {
					$imgData = $this->upload->data();               
					$images[$key] = $imgData['file_name'];
					
				} else {
					echo $this->upload->display_errors();
					
					return false;
				}
			}
        }

        return $images;
    }
	
	function uploadauction($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true; // Change for Filename change
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if(!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
        }
        else
        {
			//$new_name = time().$fieldname;
			//$config['file_name'] = $new_name;

			$upload_data = $this->upload->data();
			
			return $upload_data['file_name'];		
		}							
	}
	 public function getAllPages(){
               
		//$this->db->where('auctionID', $auctionID);
		$role_id = $this->session->userdata('role_id');
		
		$this->db->select('rp.*');
		$this->db->where('rp.is_show_menu',1);
		$this->db->where('rp.status',1);
		$this->db->where_in('rp.role_page_id',array(1,2,4,7));
		$this->db->order_by('rp.order');
		$query = $this->db->get("tbl_role_page as rp");
        return $query->result();
	}
	
	function auctionDetailPopupData($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		return $query_auction->result();
	}
	
	public function GetRecordByCategory($category_id,$is_auction='',$is_bank='',$is_sell='')
	{
	
		$this->db->select('a.* , ag.name as group_name, ag.id as group_id, ag.is_display');		
		$this->db->from("tbl_attribute_group as ag");
		$this->db->join('tbl_attribute as a', 'a.group_id = ag.id and a.status=1', 'left');
		$this->db->where("FIND_IN_SET('$category_id',ag.category_id) !=", 0);
		$this->db->where("ag.status",1);
		if($is_auction)
		{
		$this->db->where("(a.is_auction='$is_auction' OR a.is_auction='both')");
		}
		if($is_bank)
		{
		$this->db->where("(a.is_bank='$is_bank' OR a.is_bank='both')");
		}
		if($is_sell)
		{
		$this->db->where("(a.is_sell='$is_sell' OR a.is_sell='both')");
		}
		$this->db->order_by("a.priorty", "asc");
		$this->db->order_by("ag.priority", "asc");
		$query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->group_id][] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function removePorpertyPhotoData()
	{ 			
		$auction_document_id = $this->input->post('auction_document_id');						
		$data = array('status'=>0);
		$this->db->where('auction_document_id', $auction_document_id);	
		$this->db->update('tbl_auction_document',$data); 
	}

	public function getSalesPerson($state_id) {
		
		$this->db->where('status', 1);
		$this->db->where('state_id', $state_id);
		$this->db->order_by("sales_person_name", "ASC");
        $query = $this->db->get("tblmst_sales_person");	
		//echo $this->db->last_query();
		
        $data = array();
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
				$data[] = $row;
            }
             return $data;
        }
        return false;
    }
}

?>
