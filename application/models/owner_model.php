<?php

include(BASEPATH.'../ccvenue/new/Crypto.php');

class Owner_model extends CI_Model {
	
	
	//private $apath = 'public/uploads/property_images/';
	//private $event_auction = 'public/uploads/event_auction/';
	//private $document_auction = 'public/uploads/document/';
	//private $path = 'public/uploads/bank/';
        
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('function');
	}
	
	
        /**********************    Start  myMessage     ************************/
        public function GetCIUserRecord($id){
            
            $this->db->where('id', $id);
            $this->db->where('msg_role =', 1);
            $this->db->where('user_type', 'bidder');
            $this->db->where('status !=', 5);
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
            //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        function checkdscloginvalid(){
			
         $bidderId=$this->session->userdata['id'];
         $auctionId= $this->input->post('auctionId');
         $cert_serial_no 			        =	 $this->input->post('cert_serial_no');
         $thum_print 					=	 $this->input->post('thum_print');
         $cert_file 					=	 $this->input->post('cert_file');
         $falid_from 					=	 $this->input->post('falid_from');
         $valid_to 					=	 $this->input->post('valid_to');
         $signature 					=	 $this->input->post('signature');

		 $falid_fromArr1 = explode(" ",$falid_from);
		 $valid_toArr1 = explode(" ",$valid_to);

		 $falid_fromArr = explode("/",trim($falid_fromArr1[0]));
		 $valid_toArr = explode("/",trim($valid_toArr1[0]));

		 $falid_from = $falid_fromArr[2]."-".$falid_fromArr[1]."-".$falid_fromArr[0]." 00:00:00";
		 $valid_to = $valid_toArr[2]."-".$valid_toArr[1]."-".$valid_toArr[0]." 23:59:59";

		if($cert_serial_no != "" && strtotime( $falid_from) <= time() && time() <= strtotime( $valid_to) )
		{
         //case when dsc already exists
         $this->db->where('bidderID', $bidderId);
         $this->db->where('auctionID', $auctionId);
         $query=$this->db->get("tbl_auction_participate");
         $row=$query->result();
                  
          if($row[0]->cert_serial_no!='' && $row[0]->added_type == 'bidder'){
              
				 if($row[0]->cert_serial_no==$cert_serial_no)
				   {
						 $update=1;
						 $data1 = array(
							 'is_accept_auct_training' => 1,
							 'dsc_verified_status' => 1,
						  );
						$this->db->where('bidderID', $bidderId);
						$this->db->where('auctionID', $auctionId);
						$this->db->update('tbl_auction_participate', $data1);
						$this->session->set_userdata('response_dsc_'.$auctionId,'dscverified');
						//$this->session->set_userdata('response_msg_'.$auctionId,"DSC Verified  SuccessFully");
				   }
				   else
				   {
					   $update=3;   //notverified
				   }
			}
			else if($row[0]->added_type == 'helpdesk_ex' || $row[0]->auct_signature == 'added by helpdesk')
			{	
				$update=1;
				 $data1 = array(
					 'cert_serial_no'=>$cert_serial_no,
					 'thum_print'=>$thum_print,
					 'cert_file'=>$cert_file,
					 'falid_from'=>$falid_from,
					 'valid_to'=> $valid_to,
					 'signature'=>$signature,
					 'is_accept_auct_training' => 1,
					 'dsc_verified_status' => 1,
				  );
				$this->db->where('bidderID', $bidderId);
				$this->db->where('auctionID', $auctionId);
				$this->db->update('tbl_auction_participate', $data1);
				$this->session->set_userdata('response_dsc_'.$auctionId,'dscverified');
				//$this->session->set_userdata('response_msg_'.$auctionId,"DSC Verified SuccessFully");
				
			}
			else
			{
			   $update=0;     //not found
			}
		}
		else
		{
		   $update=5;  //expired
		}
        return $update;
          }
        function checkdsclogin(){			
         $bidderId=$this->session->userdata['id'];
         $auctionId= $this->input->post('auctionId');
         $cert_serial_no 			        =	 $this->input->post('cert_serial_no');
         $thum_print 					=	 $this->input->post('thum_print');
         $cert_file 					=	 $this->input->post('cert_file');
         $falid_from 					=	 $this->input->post('falid_from');
         $valid_to 					=	 $this->input->post('valid_to');
         $signature 					=	 $this->input->post('signature');


		 $falid_fromArr1 = explode(" ",$falid_from);
		 $valid_toArr1 = explode(" ",$valid_to);

		 $falid_fromArr = explode("/",trim($falid_fromArr1[0]));
		 $valid_toArr = explode("/",trim($valid_toArr1[0]));

		 $falid_from = $falid_fromArr[2]."-".$falid_fromArr[1]."-".$falid_fromArr[0]." 00:00:00";
		 $valid_to = $valid_toArr[2]."-".$valid_toArr[1]."-".$valid_toArr[0]." 23:59:59";
		//echo'test '. $cert_serial_no .' | '. strtotime( $falid_from) .' | '. time() .' | '. time().' | '.strtotime( $valid_to);die;
		if($cert_serial_no != "" && strtotime( $falid_from) <= time() && time() <= strtotime( $valid_to) )
		{
         //case when dsc already exists
         $this->db->where('bidderID', $bidderId);
         $this->db->where('auctionID', $auctionId);
         $query=$this->db->get("tbl_auction_participate");
         $row=$query->result();
        
          if($row[0]->cert_serial_no!=''){
			  
             if($row[0]->cert_serial_no==$cert_serial_no){
               $data=array(
             'cert_serial_no'=>$cert_serial_no,
             'thum_print'=>$thum_print,
             'cert_file'=>$cert_file,
             'falid_from'=>$falid_from,
             'valid_to'=> $valid_to,
             'signature'=>$signature,
              //'final_submit' => 1  
           );
            $this->db->where('bidderID', $bidderId);
            $this->db->where('auctionID', $auctionId);
            $update=$this->db->update('tbl_auction_participate',$data);  
             $this->session->set_userdata('response_dsc_'.$auctionId,'dscverified');
            }else{
              $update=2;  
            }
        }else{
			//echo 'test1';die;
			$haskey = $auctionId.$bidderId.$cert_file;
			$auct_signature = hash("sha256", $haskey);
			
          $data=array(
			 'is_accept_tc'=>1,
			 'bidderID'=>$bidderId,
			 'auctionID'=>$auctionId,
             'cert_serial_no'=>$cert_serial_no,
             'thum_print'=>$thum_print,
             'cert_file'=>$cert_file,
             'falid_from'=>  date('Y-m-d H:i:s',strtotime($falid_from)),
             'valid_to'=> date('Y-m-d H:i:s',strtotime($valid_to)),
             'signature'=>$signature, 
             'auct_signature'=>$auct_signature,
			 'status'=>2,
			 'participate_by'=>'owner',
			 'indate'=>date('Y-m-d H:i:s'),
			 //'final_submit' => 1,
         );
        $update=$this->db->insert('tbl_auction_participate',$data);
		//echo $this->db->last_query();die;
         }
         }else{
			$update=3;   
         }
		
        return $update;
     }
     
       function checkdsclogin_helpdesk(){
         $bidderId=$this->session->userdata['id'];
         $auctionId= $this->input->post('auctionId');
         $cert_serial_no 			        =	 $this->input->post('cert_serial_no');
         $thum_print 					=	 $this->input->post('thum_print');
         $cert_file 					=	 $this->input->post('cert_file');
         $falid_from 					=	 $this->input->post('falid_from');
         $valid_to 					=	 $this->input->post('valid_to');
         $signature 					=	 $this->input->post('signature');
         //case when dsc already exists
        // $this->db->where('bidderID', $bidderId);
        // $this->db->where('auctionID', $auctionId);
        // $query=$this->db->get("tbl_auction_participate");
        // $row=$query->result();
         
        $valid_to_f=explode('/',$valid_to);
         $valid_to_new=implode('-',array_reverse($valid_to_f));
         $falid_from_f=explode('/',$falid_from);
         $falid_from_new=implode('-',array_reverse($falid_from_f));
        $newvalidate = strtotime($valid_to_new);
        $now =   strtotime(date('Y-m-d H:i:s'));  //or your date as well
        $your_date = strtotime($valid_to_new);    //check valid certificate
        $datediff = $your_date-$now;
        
      if( floor($datediff/(60*60*24))>0 || 1){   
        
           $data=array(
             'cert_serial_no'=>$cert_serial_no,
             'thum_print'=>$thum_print,
             'cert_file'=>$cert_file,
             'falid_from'=>  date('Y-m-d H:i:s',strtotime($falid_from)),
             'valid_to'=> date('Y-m-d H:i:s',strtotime($valid_to)),
             'signature'=>$signature,
             'is_accept_auct_training' => 1,
             'dsc_verified_status' =>1, 
              );
          
        $this->db->where('bidderID', $bidderId);
        $this->db->where('auctionID', $auctionId);
        $update=$this->db->update('tbl_auction_participate',$data);
      if($update){ 
        $this->session->set_userdata('response_dsc_'.$auctionId,'');
        $this->session->set_userdata('response_dsc_'.$auctionId,'dscverified');
        }
         }else{
         $update=3;   
         }
        return $update;
     }
        public function GetCITotalRecord(){
            
            $user_id = $this->session->userdata('id');
			$this->db->where('msg_role =', 1);
            $this->db->where('status !=', 5);
			$this->db->where('user_type', 'bidder');
            $this->db->where('msg_to', $user_id);
			$this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
            // echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0){
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function GetUserTotalRecord(){
            
            $this->db->where('msg_role =', 2);
            $this->db->where('status !=', 5);
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
            //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function GetTrashTotalRecord(){
            $user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
            $this->db->where('status =', 5);
			
            $this->db->where('user_type','bidder');
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
                //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }

	public function GetParentRecordsControl(){
            
            $this->db->where('status', 1);
			$user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
            $query = $this->db->get("tbl_message");
		
            if($query->num_rows() > 0){
                
                foreach ($query->result() as $row){				
                    $data[] = $row;
                }
                return $data;
            }
            
            return false;
        }
	
	public function GetRecordById($id){
            
            $this->db->where('id', $id);
            $query = $this->db->get("tbl_message");
            if ($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data = $row;
                }
                return $data;
            }
            return false;
        }
        public function GetBanksData($id){
            
            $this->db->where('id', $id);
            $query = $this->db->get("tbl_auction");
            if ($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data = $row;
                }
                 if($data){
                   $this->db->where('id',  $data[0]->bank_id);
                      $query1 = $this->db->get("tbl_bank");   
                      $rows = $quer1->result();
                      return $rows[0];
                     
                 }
            }
            return false;
        }

        public function myMessage_save_message_data(){
            
            $id = $this->input->post('id');

            if($id){

                $msg_role = $this->session->userdata('role_id');
                $msg_from = $this->input->post('msg_to');
                $msg_to = $this->input->post('msg_from');

            }else{

                $msg_role = $this->session->userdata('role_id');
                $msg_from = $this->session->userdata('id');
                $msg_to = $this->input->post('msg_to');
            }

            $msg_body = $this->input->post('msg_body');

            $data = array('msg_role'=>$msg_role,
                            'msg_from'=>$msg_from,
                            'msg_to'=>$msg_to,
                            'msg_body'=>$msg_body
                            );

            //echo '<pre>', print_r($data), '</pre>';

            $data['msg_created_datetime']=date('Y-m-d H:i:s');
            $data['msg_status']=2;
            $data['status']=1;
            $this->db->insert('tbl_message',$data); 
            $id = $this->db->insert_id();

            return true;
	}
	
	public function GetUserData(){
            //$this->db->limit(10,0);
            //$this->db->order_by('id DESC');
            $query = $this->db->get("tbl_user");
            //echo $this->db->last_query();

            $data = array();
            if ($query->num_rows() > 0){

                foreach ($query->result() as $row){
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
        
        public function myMessage_get_autocomplete(){
            
            //$id = $this->input->post('search');
            
            $name = $this->input->post('name');
            
            
            $this->db->select('id, first_name, last_name, email_id');
            $this->db->where_not_in('id', $this->session->userdata('adminid'));
            $this->db->where('status',1);
            $this->db->like('first_name',$name);
            //return $this->db->get('tbl_user', 10);
            
            $query = $this->db->get("tbl_user");
            
            //echo $this->db->last_query().'<br />';

            $data = array();
            if ($query->num_rows() > 0){

                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
        /**********************  End    myMessage     ************************/ 
		

	/**********************  Start myProfile     ************************/

        public function myProfileUserData(){
            
            //$this->db->limit(10,0);
            //$this->db->order_by('id DESC');
            
                $this->db->where('id', $this->session->userdata('id'));
		$query = $this->db->get("tbl_user_registration");
                //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
             
        }
        
       public function userProfileData()
	   {       
			$this->db->where('id', $this->session->userdata('id'));
			$query = $this->db->get("tbl_user_registration");
			//echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){                    
				foreach ($query->result_array() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			return false;
				 
	  }  
        
        public function myProfileEditSaveData(){
					 
				$id = $this->session->userdata('id');
				
				
				$company_name = $this->input->post('company_name');
                $designation = $this->input->post('designation');
                $authorized_person = $this->input->post('authorized_person');
                
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $father_name = $this->input->post('father_name');
                
                
                $mobile_no = $this->input->post('mobile_no');
                $country = $this->input->post('country');
                $state = $this->input->post('state');
                $city = $this->input->post('city');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $zip = $this->input->post('zip');
                $pan_form_16 = $this->input->post('pan_form-16');
				$phone_no = $this->input->post('phone');
				$fax = $this->input->post('fax');
				
				
				
				if($transacation_type)
				{
					$transacation_type=	implode(',',$transacation_type);
				}
				$this->load->model('registration_model');	
				if($pan_form_16=='form-16')
				{
						if($_FILES['form16']['name']){
							//$documentName=$this->registration_model->uploaduserdoc('form16');
							$documentName=$this->registration_model->upload1('form16');
						}else{
							$documentName=$this->input->post('form16_old');
						}
				}else{
						 $documentName = $this->input->post('pan_number');
				}
				
				if($_FILES['broker_photo']['name']){
							$broker_photo=$this->registration_model->upload1('broker_photo');
						}else{
							$broker_photo=	$this->input->post('broker_photo_old');
						}
				if($_FILES['company_logo']['name']){
							$company_logo=$this->registration_model->upload1('company_logo');
						}else{
							$company_logo=	$this->input->post('company_logo_old');
						}
				/*if($_FILES['form16']['name']){
							$documentName=$this->registration_model->upload1('form16');
						}else{
							$documentName=	$this->input->post('form16_old');
						}*/
						
		$data = array('mobile_no'=>$mobile_no,
				'country_id'=>$country,
				'state_id'=>$state,
				'city_id'=>$city,
				'phone_no'=>$phone_no,
				'fax'=>$fax,
				'zip'=>$zip,
				'address1'=>$address1,
				'address2'=>$address2,
				'document_type'=>$pan_form_16,
				'document_no'=>$documentName,
				);   
				
		if($this->input->post('profile_type') != 'builder'){
			$data['first_name']=$first_name;
			$data['last_name']=$last_name;
			$data['father_name']=$father_name;
		}else{
			$data['designation']=$designation;
			$data['organisation_name']=$company_name;
			$data['authorized_person']=$authorized_person;
		}             
		$data['date_modified']=date('Y-m-d H:i:s');
		$this->db->where('id', $id);
		$this->db->update('tbl_user_registration', $data);
		
		$data1 = $this->userProfileData();
		
		unset($data1[0]['id']);
		$data1[0]['user_id'] = $this->session->userdata('id');
		$data1[0]['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$data1[0]['indate'] = date('Y-m-d H:i:s');
		$data1[0]['remark'] = 'Profile Update Successfully';
		/*
		echo '<pre>';
		print_r($data1[0]);die;
		*/
		$this->db->insert('tbl_log_user_registration',$data1[0]);
		
		return true;
	}
        
	/**********************  End myProfile     ************************/ 
	/**********************  postRequirement     ************************/ 
   	public function savePostRequirement() {
		$id = $this->input->post('id');
		$is_buy = $this->input->post('is_buy');
		$is_auction = $this->input->post('is_auction');
		$property_type = $this->input->post('property_type');
		$city = $this->input->post('city');
		$bedrooms = $this->input->post('bedrooms');
		$built_up_area = $this->input->post('built_up_area');
		$plot_area = $this->input->post('plot_area');
		$budget = $this->input->post('budget');
		$user_id = $this->session->userdata('id');
		if($budget){
		$budget=implode(',',$budget);
		}
		$status = 1;
		if($city)
		{
			$city=implode(',',$city);
		}
	
		$data = array(
					'is_buy'=>$is_buy ,
					'is_auction'=>$is_auction ,
					'is_auction'=>$is_auction ,
					'property_type'=>$property_type ,
					'city'=>$city ,
					'bedrooms'=>$bedrooms ,
					'built_up_area'=>$built_up_area ,
					'plot_area'=>$plot_area,		
					'budget'=>$budget,
					'userID'=>$user_id,
					'status'=>$status
					);
		if($id)			
		{
			
			$this->db->where('id', $id);
			$this->db->update('tbl_post_requirement', $data); 
			$insertedID=$id;
		}
		else
		{
			
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_post_requirement',$data); 
			$insertedID=$this->db->insert_id();
		}
		
		return $insertedID;
	}
	function manageRequirementDatatable()
    {	
		$user_id = $this->session->userdata('id');
		$this->db->query("SET @row = 0",false); 
        $this->datatables->select("@row := @row + 1 as SNo, p.id as pid, c.name, p.city, p.budget,p.is_buy",false)
        ->unset_column('pid')
	    ->from('tbl_post_requirement as p')
		->join('tbl_category as c','c.id=p.property_type','left')
		->add_column('Actions',"<a href='/owner/manageRequirement/edit/$1' class=''>Edit</a> <a href='/owner/manageRequirement/del/$1' class=''>Delete</a>", 'pid')
		->where('userID',$user_id)
		->where('p.status',1);
		return $this->datatables->generate();
    }
	function matchingRequirementDatatable()
    {	
		$user_id = $this->session->userdata('id');
		$this->db->query("SET @row = 0",false); 
        $this->datatables->select("id,@row := @row + 1 as SNo,(select name from tbl_category where id=TPR.property_type) as category_name ,TPR.city,TPR.budget,TPR.indate, (select count(tp.id)  from tbl_product as tp where (tp.city=TPR.city OR tp.product_type=TPR.property_type) and tp.is_auction=TPR.is_auction) as total_match_product",false)
       ->unset_column('id')
	   ->unset_column('total_match_product')
	   ->add_column('Actions',"<a href='/property?math_type=$1' target='_blank' class=' product_detail_iframe1'>View</a> ", 'id,total_match_product')
	   ->from('tbl_post_requirement as TPR')
	   //popup propert detail
		
		->where('userID',$user_id)
		->where('status',1);
		//->order_by('id','DESC');
        return $this->datatables->generate();
    }
	
	/*function getMatchingString($id) {
		if(!empty($id)) {
			
			$query = $this->db->query("select * from tbl_post_requirement where id='".$id."'");
			$query = $query->row_array();
			return $id;
			
			if($mathType['is_auction']) {
				$act = 'auction';
			} else {
				$act = 'non_auction';
			}
			$match = array('propertype'=>array($mathType['is_buy']), 'act'=>$act, 'budget'=>explode(",", $mathType['budget']), 'build_up_area'=>trim($mathType['built_up_area']), 'match_city'=>explode(",", $mathType['city']), 'bedrooms'=>trim($mathType['bedrooms']));
			$_GET = $match;
		}
	}*/

	
	
	function delPostRequirement($id)
    {	
		
		if($id)			
		{
			
			$this->db->where('id', $id);
			$this->db->update('tbl_post_requirement', array('status'=>5)); 
		}
		return true;
    }
	function getPostRequirement($id)
    {	
			
		$this->db->where('id', $id);
		$query=$this->db->get('tbl_post_requirement'); 
		
		return $query->result();
    }
	
	/********************** End postRequirement     ************************/ 

	/********************** Upcoming Auction     ************************/ 
	function upcomingAuctionDatatable(){	
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id,b.name,a.PropertyDescription,DATE_FORMAT(a.auction_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.auction_end_date,'%d-%m-%Y %H:%i:%s')
		a.status",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
                ->from('tbl_auction as a')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('a.bid_opening_date >= NOW()');
        return $this->datatables->generate();
        
    }
    function upcomingAuctionDatatable1(){	
       
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id,b.name,a.PropertyDescription,DATE_FORMAT(a.auction_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.auction_end_date,'%d-%m-%Y %H:%i:%s'), a.status",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
                ->from('tbl_auction as a')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('a.bid_opening_date >= NOW()');
        return $this->datatables->generate();
        
    }
    
    function liveupcomingAuctionDatatable1(){	
       
		$userid=$this->session->userdata['id'];
		$this->datatables->select("fav.is_fav,a.id,dp.department_name,a.PropertyDescription,a.reference_no,a.registration_end_date,DATE_FORMAT(a.auction_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.auction_end_date,'%d-%m-%Y %H:%i:%s'), CASE  
                                            WHEN a.status ='2' THEN 'Initialize'
                                            WHEN a.status ='1' THEN 'Published'
                                            WHEN a.status ='0' THEN 'Saved'
                                            END as status1,a.dsc_enabled",false)
		//->unset_column('ap.fav')	
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id,ap.fav')
		//->add_column('Actions',favUpcominglistcheck('$1','$2'), 'a.id, ap.fav')

        ->from('tbl_auction as a')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
                //->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_auction_bidder_fav as fav',"fav.auctionID=a.id and fav.bidderID = '".$userid."'",'left')   // Favourite LIST ADDED
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('ap.final_submit','1')
		->where('ap.operner2_accepted',1)
		->where('((a.status!="7" AND a.open_price_bid = 1 and a.stageID = 6 AND (NOW() >= a.bid_opening_date AND NOW()<= a.auction_end_date)))');
		
        return $this->datatables->generate();
        
    }
    
    function inprogressAuctionDatatable(){	
       
		$userid=$this->session->userdata['id'];
		$this->datatables->select("fav.is_fav,a.id,dp.department_name,a.PropertyDescription ,a.reference_no,DATE_FORMAT(a.auction_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.auction_end_date,'%d-%m-%Y %H:%i:%s'), CASE  
				WHEN a.status ='2' THEN 'Initialize'
				WHEN a.status ='1' THEN 'Published'
				WHEN a.status ='0' THEN 'Saved'
				END as status1,a.dsc_enabled, a.productID",false)
		//->unset_column('ap.fav')	
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id,ap.fav')
		//->add_column('Actions',favUpcominglistcheck('$1','$2'), 'a.id, ap.fav')

        ->from('tbl_auction as a')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
                //->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_auction_bidder_fav as fav',"fav.auctionID=a.id and fav.bidderID = '".$userid."'",'left')   // Favourite LIST ADDED
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('ap.final_submit','1')
		->where('ap.operner2_accepted',null);
		
        return $this->datatables->generate();
        
    }
    
    function liveupcomingAuctionDatatable1_fav(){	
       
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id,dp.department_name,a.PropertyDescription,a.registration_end_date ,DATE_FORMAT(a.auction_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.auction_end_date,'%d-%m-%Y %H:%i:%s'), CASE  
   a.status WHEN 1 THEN 'Published'
            WHEN 0 THEN 'Saved'
     END as status1,a.dsc_enabled",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a> <a class='' href='javascript:void(0);' onclick='removefromlivefavEventlist($1)'><img src='../images/addtoFav.jpg' title='Remove from favourite' width='20' height='20' class='imgfav'></a>", 'a.id')
                ->from('tbl_auction as a')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
                //->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_auction_bidder_fav as fav','fav.auctionID=a.id','left') // Favourite LIST ADDED
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('fav.bidderID', $userid)
		->where('ap.final_submit','1')
		->where('fav.is_fav', 1)  // Favourite LIST ADDED
		->where('((a.status!="7" and a.stageID = 6 AND a.open_price_bid = 1 AND (NOW() >= a.bid_opening_date AND NOW()<= a.auction_end_date)))');
		
        return $this->datatables->generate();
        
    }
    
    
    
    
    public function liveupcomingauciton_fav_remove_save(){
				$auctionID = $this->input->post('auctionID');
				$id = $this->session->userdata('id');
                
				/*$data = array('fav'=>'0');                                
                $this->db->where('id', $id);
                $this->db->update('tbl_auction_participate', $data);*/
                
                $query=$this->db->query("UPDATE tbl_auction_participate SET fav=0 WHERE auctionID='".$auctionID."' AND bidderID='".$id."'");
                $query=$this->db->query("UPDATE tbl_log_auction_participate SET fav=0 WHERE auctionID='".$auctionID."' AND bidderID='".$id."'");
                
                /*$data1 = array('fav'=>'0');                                
                $this->db->where('id', $id);
                $this->db->update('tbl_log_auction_participate', $data1);*/
		
		return true;
	}
	public function liveupcomingauciton_fav_add_save(){
		
				$auctionID = $this->input->post('auctionID');
					 
				$id = $this->session->userdata('id');
                
				/*$data = array('fav'=>'0');                                
                $this->db->where('id', $id);
                $this->db->update('tbl_auction_participate', $data);*/
                
                $query=$this->db->query("UPDATE tbl_auction_participate SET fav=1 WHERE auctionID='".$auctionID."' AND bidderID='".$id."'");
                $query=$this->db->query("UPDATE tbl_log_auction_participate SET fav=1 WHERE auctionID='".$auctionID."' AND bidderID='".$id."'");
                
                /*$data1 = array('fav'=>'0');                                
                $this->db->where('id', $id);
                $this->db->update('tbl_log_auction_participate', $data1);*/
		
		return true;
	}
	
	
	
	public function liveupcomingauciton_event_add_save(){
		
				$auctionID = $this->input->post('auctionID');
				$bidderID = $this->session->userdata('id');
       
                $sqlown = "SELECT auctionID,is_fav  FROM tbl_auction_bidder_fav WHERE auctionID='".$auctionID."' AND bidderID='".$bidderID."'";
							$queryown=$this->db->query($sqlown);
							$data = $queryown->result();
							//echo '<pre>';
							//print_r($data);
							//die;	
							$totalRow=$queryown->num_rows();
							if($totalRow>0)			
							{
								if($data[0]->is_fav!=1)
								{
									$data1['updated_date']=date('Y-m-d H:i:s');
									$data1['is_fav']=1;
									$this->db->where('auctionID', $auctionID);
									$this->db->where('bidderID', $bidderID);
									$this->db->update('tbl_auction_bidder_fav', $data1); 
								}
							}else{
								//return "NOT FOUND";
								  $data2['auctionID']=$auctionID;
								  $data2['bidderID']=$bidderID;
								  $data2['is_fav']=1;
								  $data2['indate']=date('Y-m-d H:i:s');
								
								  $this->db->insert('tbl_auction_bidder_fav', $data2);	
								//$product_id = $this->db->insert_id();
							}
		return true;
	}
	
	
	public function liveupcomingauciton_favevent_remove_save(){
				$auctionID = $this->input->post('auctionID');
				$bidderID = $this->session->userdata('id');
				$date=date('Y-m-d H:i:s');
               
                $query=$this->db->query("UPDATE tbl_auction_bidder_fav SET is_fav=0,updated_date='".$date."' WHERE auctionID='".$auctionID."' AND bidderID='".$bidderID."'");
		
		return true;
	}
	
	
    function upcomingAuctionDatatable2(){	
       
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id,b.name,a.PropertyDescription,cit.city_name, DATE_FORMAT(a.bid_last_date,'%d-%m-%Y %H:%i:%s'),a.reserve_price,a.emd_amt",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1'><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
                ->from('tbl_auction as a')
                ->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
                ->join('tbl_product tp','a.productID=tp.id','left')      
                ->join('tbl_city as cit','tp.city=cit.id','left')     
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->where('ap.bidderID',$userid)
		->where('a.bid_opening_date >= NOW()');
        return $this->datatables->generate();
        
    }
    function canceleddatatable()
    {	
		//$bank_id= $this->session->userdata('bank_id');
		//$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
               //$this->datatables->select("ea.id,tb.name, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.reserve_price",false)
                 $this->datatables->select("ea.id,tb.name, ea.reference_no,UCASE(ea.event_type) as type, ea.PropertyDescription, ea.reserve_price",false)
                ->unset_column('ea.id')		
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/owner/eventDetailPopup/$1' class=''>View</a>", 'ea.id')
                 ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left ');		
		//->where("ea.status ='3' OR ea.status ='4'")
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
    
    	
	function concludeCompletedAuctionsdatatable()
    {	
		//get bank id of logged user
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
               // $this->datatables->select("ea.id,tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type,ea.event_title,tp.product_description, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
		 $this->datatables->select("ea.id,tb.name as bank_name, ea.id, ea.reference_no,UCASE(ea.event_type) as type,ea.event_title,ea.PropertyDescription, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
		 ->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/owner/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
                ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')		
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
		->where('ea.status ',7)
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->group_by('ea.id');
        return $this->datatables->generate();
    }
    
    function concludeCompletedAuctionsdatatable1()
    {	
		//get bank id of logged user
		$userid= $this->session->userdata('id');
                if(!$userid){$userid=0;}
		 $this->datatables->select("ea.id,dp.department_name,ea.PropertyDescription,ea.auction_start_date,ea.auction_end_date,(CASE  WHEN ea.status = '7' THEN 'Event Conclude' ELSE 'Event Completed' END) as status,ea.dsc_enabled",false)				
                  //->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/owner/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
                ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
                //->join('tblmst_account_type as ac','ac.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')		
		->join('tbl_auction_participate as ap','ap.auctionID=ea.id','left')
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
	         ->where('ea.status',7) //n
                //->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)") //n
		->where('ap.bidderID',$userid)
		->group_by('ea.id');
        return $this->datatables->generate();
    }
    
    
	/********************** End Upcoming Auction    ************************/
	/********************** myactivityFollowBank     ************************/ 
	function followBankDatatable()
    {	
		$user_id=$this->session->userdata('id');
		$bankArr=$this->owner_model->getFollowBank($user_id);
		$bankstring=implode(',',$bankArr);
		//$user_id=$this->session->userdata('id');
		$this->datatables->select("a.id, a.event_title, a.PropertyDescription ,b.name,  a.auction_start_date, a.auction_end_date",false)
        ->where("(a.bank_id IN('$bankstring') AND a.bank_id!='' AND a.bank_id!='0')")
        //->where("a.bank_id !=''")
		->add_column('Actions',"<a class='' href='/property/detail/$1'>View</a>", 'a.id')
        ->from('tbl_auction as a')
        ->join('tbl_product as p','p.id=a.productID','left')
        ->join('tbl_bank as b','b.id=a.bank_id','left');
	    return $this->datatables->generate();
    }
	function getBank()
    {	
		$this->db->select('id,name');
		$this->db->where('status', 1);
		//$this->db->limit(21);
        $this->db->from("tbl_bank");
        $query = $this->db->get();
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}
		return false;
		
    }
	function getFollowBank($userid)
    {	
		$this->db->select('bank_id');
		$this->db->where('status', 1);
		$this->db->where('user_id', $userid);
		//$this->db->limit(21);
        $this->db->from("tbl_user_bank_follow");
		
		
        $query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row->bank_id;
			}
			return $data;
		}
		return false;
		
    }
	/********************** End myactivityFollowBank    ************************/
	/********************** Favorate     ************************/ 
	function allFavoritesDatatable()
    {	
        $user_id=$this->session->userdata('id');
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("@row := @row + 1 as SNo ,p.id, p.name, p.product_description, p.product_type_val",false)
		->unset_column('p.id')
		->add_column('View',"<a target='_blank' class='' href='/property/detail/$1'>View</a>", 'p.id')
        ->from('tbl_product as p')
        ->join('tbl_user_favorites as f','f.product_id=p.id')
		->where('f.user_id',$user_id);
		
		return $this->datatables->generate();
    }
	/********************** End Favorate    ************************/
	/********************** lastSearchDatatable     ************************/ 
	function lastSearchDatatable()
    {	
		 $user_id=$this->session->userdata('id');
		$this->datatables->select("id,serach_url,indate",false)
		->add_column('View',"<a target='_blank' class='' href='$1'>View</a>", 'serach_url')
        ->from('tbl_user_search_detail as a')
		->where('a.user_id',$user_id);
		//->order_by('id','DESC');
		//->order_by('indate ','desc');
		return $this->datatables->generate();
    }
	/********************** End lastSearchDatatable    ************************/

	function eventTrackData($auctionID,$bidderID=12)
    {	
		$this->db->where('status !=', 5);
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");
		$data  = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();			
			/***** count no. of bidder*****/
			//$this->db->select('count(id) as bider_total');
			$this->db->where('auctionID ', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$query = $this->db->get("tbl_auction_participate");
			$bidder_participation_detail=$query->result();
			$data[0]->bidder_participation_detail=$bidder_participation_detail;
			/***** count no. of bidder*****/
			return $data;
		}
		return false;
    }
	
	
	public function savepropertyData()
	{	
		$user_id		=	 $this->session->userdata['id'];
		$is_auction 	=	 $this->input->post('is_auction');
		$sele_rent 		=	 $this->input->post('sele_rent');
		$category 		= 	 $this->input->post('category');
		$property_type 	=	 $this->input->post('property_type');
		if($is_auction==1){
			$is_auctiontype='auction';
			$status=3;	
		}else{
			$is_auctiontype	='non-auction';
			$status=1;
		}
		$type			=	$property_type;
		$records		=	$this->helpdesk_executive_model->GetRecordByCategory($property_type,$is_auctiontype,$is_bank='non-bank',$sele_rent);
		$productID 		=	 $this->input->post('productID');
		
		$product_type_val=GetTitleByField('tbl_category', "id=".$category."", 'name');
		$product_subtype_val=GetTitleByField('tbl_category', "id=".$type."", 'name');
		$name 			=	 $this->input->post('name');
		$description 	=	 $this->input->post('description');
		$price 			=	 $this->input->post('price');
		$Address1 		=	 $this->input->post('address');
		$Street 		=	 $this->input->post('street');
		$Country 		=	 $this->input->post('country');
		$State 			=	 $this->input->post('state');
		$City 			=	 $this->input->post('city');
		$Zip 			=	 $this->input->post('zip');
		$phone			=	 $this->input->post('phone');
		$fax 			=	 $this->input->post('fax');
		
		$data 			= array(
							'name'=>$name,
							'product_description'=>$description,
							'sell_rent'=>$sele_rent,
							'price'=>$price,
							'product_subtype_val'=>$product_subtype_val,
							'user_id'=>$user_id,
							'is_auction'=>$is_auction,
							
							'product_type'=>$category,
							'product_subtype_id'=>$type,
							'product_type_val'=>$product_type_val,
							'product_subtype_val'=>$product_subtype_val,
							'address1'=>$Address1,
							'street'=>$Street,
							'country'=>$Country,
							'state'=>$State,
							'city'=>$City,
							'zip'=>$Zip,
							'phone'=>$phone,
							'fax'=>$fax,
							'status'=>0
							);
				
		if($productID)			
		{
			$data['updated_date']=date('Y-m-d H:i:s');
			$this->db->where('id', $productID);
			$this->db->update('tbl_product', $data); 
			$product_id =$productID;
		}else{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_product', $data);	
			$product_id = $this->db->insert_id();
		}
				
		$files = $_FILES;
		$count = count($_FILES['image']['name']);
		if($count >0){
			for($i=0; $i<$count; $i++)
			{
				if($files['image']['name'][$i])
				{
					$_FILES['file_upload']['name']		= $files['image']['name'][$i];
					$_FILES['file_upload']['type']		= $files['image']['type'][$i];
					$_FILES['file_upload']['tmp_name']	= $files['image']['tmp_name'][$i];
					$_FILES['file_upload']['error']		= $files['image']['error'][$i];
					$_FILES['file_upload']['size']		= $files['image']['size'][$i];
					$image=$this->helpdesk_executive_model->upload1('file_upload');
				}
				else
				{
					$file_upload 	= 	$this->input->post('image_old');
					$image			=	$file_upload[$i];
				}
				
				if($image){
					$priority 			=	SetPriority('tbl_product_image_video', "and product_id = $product_id");
					$data = array(
							'product_id'=>$product_id,
							'name'=>$image,
							'type'=>'images',
							'priority'=>$priority,
							'status'=>0
						);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_image_video',$data);
				}
			}
		}
		
		//video 
		if($_FILES['video']['name']){
			$video=$this->helpdesk_executive_model->uploadvideo('video');
		}
		else{
			$video = $this->input->post('video_url');
		}
			
		if($video){
			$video_type = $this->input->post('video_type');
			$priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
			$data = array(
				'product_id'=>$product_id,
				'name'=>$video,
				'type'=>$video_type,
				'priority'=>$priority,
				'status'=>0
				);
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_product_image_video',$data);
		}
		//End video
		///Delete previous Records from tbl_product_attribute_values on edit
		if($product_id)			
		{
			$this->db->where('product_id', $product_id);
			$this->db->update('tbl_product_attribute_value', array('status'=>5,'updated_date'=>date('Y-m-d H:i:s'))); 
		}
					
		//End Delete previous Records from tbl_product_attribute_values on edit
		foreach($records as $group_records)		
		{
			foreach($group_records as $data)		
			{
				$values = $this->input->post('form_field_'.$data->id);
				if(is_array($values)){
					$values=implode(',',$values);
				}
				$data = array(
						'attribute_id'=>$data->id,
						'group_id'=>$group_records[0]->group_id,
						'user_id'=>$user_id,
						'product_id'=>$product_id,
						'attr_name'=>$data->name,
						'values'=>$values,
						'status'=>0
					);
				$data['indate']=date('Y-m-d H:i:s');			
				$this->db->insert('tbl_product_attribute_value',$data); 
				$id = $this->db->insert_id();
			}
		}
		//echo $product_id;//die;
		return $product_id;
		//die;
	}
	
	function buyDashboardData()
	{
		$sort_by=$this->input->post('section');
		$value=$this->input->post('value');
		$userid=$this->session->userdata('id');

		$query1=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND status='1' AND user_id='$userid'");
		$row1 = $query1->row();
		$activeProperty=$row1->total_act_property;
		
		$sql = "SELECT COUNT(a.id)as total_act_participate 
		FROM tbl_auction_participate as p 
		INNER JOIN tbl_auction as a ON a.id=p.auctionID 
		WHERE p.bidderID='".$userid."' AND p.participate_by='owner'
		AND IF(a.first_opener is not null AND p.operner1_accepted is not null , 1, 0)
		AND IF(a.second_opener is not null AND p.operner2_accepted is not null , 1, 0)";
		$query1=$this->db->query($sql);
		$row1 = $query1->row();
		$participate=$row1->total_act_participate;
		
		$query2=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_post_requirement WHERE  userID='$userid'");
		$row2 = $query2->row();
		$postRequirement=$row2->total_act_property;
		
$sqlown = "SELECT DISTINCT(auctionID) FROM tbl_live_auction_bid WHERE bidderID='$userid'";
		$queryown=$this->db->query($sqlown);	
		$totalRow=$queryown->num_rows();
		if($totalRow>0)
		{
			$totalOwn='';
			foreach($queryown->result() as $rowo)
			{
				$query4=$this->db->query("SELECT bidderID,auctionID, MAX(bid_value) as h1 FROM tbl_live_auction_bid where auctionID='$rowo->auctionID'");
				$row4 = $query4->row();	
				if($row4->bidderID==$userid){
					$totalOwn[]=$row4->auctionID;
				}
			}
		}
		
		//print_r($totalOwn);
		if(count($totalOwn)>0)
		{
			$auc_own=count($totalOwn);
		}else{
			$auc_own=0;	
		}
		//print_r($totalOwn);
		
		
		$data=array();
		$data['auc_participated']=$participate;
		$data['auc_own']=$auc_own;
		$data['auc_active']=$activeProperty;
		$data['requirementPosted']=$postRequirement;
		$data['responseReceived']=2;
		return $data;
	}

	function ajaxbuyDashboardData()
	{
		$section=$this->input->post('section');
		$key=$this->input->post('key');
		$keytype=$this->input->post('keytype');
		
		
		
		if($keytype=='monthly')
		{
			$condition= " AND MONTH(indate) ='$key'";	
			$pcondition= " AND MONTH(indate) ='$key'";	
			$joinpcondition= " AND MONTH(lb.indate) ='$key'";	
		}
		if($keytype=='quarterly')
		{
			$keyArr=explode('-',$key);
			$range1	=	$keyArr['0'];
			$range2	=	$keyArr['1'];
			$condition= "  AND ( MONTH(indate) BETWEEN '".$range1."' AND '".$range2."')";	
			$pcondition= "  AND ( MONTH(indate) BETWEEN '".$range1."' AND '".$range2."')";	
			//$joinpcondition= "  AND ( MONTH(lb.indate) BETWEEN '".$range1."' AND '".$range2."')";	
		}
		if($keytype=='annually')
		{
			$condition= " AND YEAR(indate) ='$key'";		
			$pcondition= " AND YEAR(indate) ='$key'";		
			//$joinpcondition= " AND YEAR(lb.indate) ='$key'";		
		}
		
		$userid=$this->session->userdata['id'];
		$query1=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND status='1' AND user_id='$userid' $pcondition");
		$row1 = $query1->row();
		$activeProperty=$row1->total_act_property;
		
		
		$query1=$this->db->query("SELECT COUNT(id)as total_act_participate FROM tbl_auction_participate WHERE  bidderID='".$userid."' AND participate_by='owner' $condition");
		$row1 = $query1->row();
		$participate=$row1->total_act_participate;
		
		$query2=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_post_requirement WHERE  userID='$userid' $condition");
		$row2 = $query2->row();
		$postRequirement=$row2->total_act_property;

		$data=array();
		$data['auc_participated']=$participate;
		$data['auc_own']=0;
		$data['auc_active']=$activeProperty;
		$data['requirementPosted']=$postRequirement;
		$data['responseReceived']=2;
		return $data;
	}
	
	
	function sellDashboardData()
	{

		$data=array();
		$userid=$this->session->userdata['id'];
		// Find Total Active auction 
		
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_property_view WHERE uid='$userid'");
		$row = $query->row();
		$propertyViewd=$row->total_act_action;
		
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id is null AND auction_type='1' AND status='1' AND created_by='$userid' ");
		$row = $query->row();
		$activeAuction=$row->total_act_action;
		
		
		// Find Total  auction Conducted
		$query0=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id is null AND auction_type='1' AND created_by='$userid' ");
		$row0 = $query0->row();
		$conductedAuction=$row0->total_act_action;
		
		
		// Find Total Active Property 
		$query1=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND status='1' AND user_id='$userid'");
		$row1 = $query1->row();
		$activeProperty=$row1->total_act_property;
		
		
		$query2=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND user_id='$userid'");
		$row2 = $query2->row();
		$postedProperty=$row2->total_act_property;
		
		
		$query3=$this->db->query("SELECT a.id,lb.auctionID,lb.bidderID  FROM tbl_auction as a LEFT JOIN tbl_auction_participate as lb ON a.id=lb.auctionID WHERE a.bank_id is null AND a.auction_type='1' AND a.created_by='$userid' GROUP BY lb.bidderID");
		$interestedUsers = $query3->num_rows();
		
		$data['propertyViewed']		=	$propertyViewd;
		$data['auctionConducted']	=	$conductedAuction;
		$data['activeAuction']		=	$activeAuction;
		$data['propertyPosted']		=	$postedProperty;
		$data['activeProperties']	=	$activeProperty;
		$data['interestedUsers']	=	$interestedUsers;
		return $data;
	}

	function ajaxsellDashboardData()
	{
	
		//print_r($_POST);
		//echo "function";
		//die;
		$section=$this->input->post('section');
		$key=$this->input->post('key');
		$keytype=$this->input->post('keytype');
		if($keytype=='monthly')
		{
			$condition= " AND MONTH(auction_end_date) ='$key'";	
			$pcondition= " AND MONTH(indate) ='$key'";	
			$joinpcondition= " AND MONTH(lb.indate) ='$key'";	
		}
		if($keytype=='quarterly')
		{
			$keyArr=explode('-',$key);
			$range1	=	$keyArr['0'];
			$range2	=	$keyArr['1'];
			$condition= "  AND ( MONTH(auction_end_date) BETWEEN '".$range1."' AND '".$range2."')";	
			$pcondition= "  AND ( MONTH(indate) BETWEEN '".$range1."' AND '".$range2."')";	
			$joinpcondition= "  AND ( MONTH(lb.indate) BETWEEN '".$range1."' AND '".$range2."')";	
		}
		if($keytype=='annually')
		{
			$condition= " AND YEAR(auction_end_date) ='$key'";		
			$pcondition= " AND YEAR(indate) ='$key'";		
			$joinpcondition= " AND YEAR(lb.indate) ='$key'";		
		}
		
		$data=array();
		$userid=$this->session->userdata['id'];
		
		
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_property_view WHERE uid='$userid' $pcondition");
		$row = $query->row();
		$propertyViewd=$row->total_act_action;
		
		// Find Total Active auction 
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id is null AND auction_type='1' AND status='1' AND created_by='$userid' $condition");
		$row = $query->row();
		 $activeAuction=$row->total_act_action;
		
		$this->db->last_query();
		// Find Total  auction Conducted
		$query0=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id is null AND auction_type='1' AND created_by='$userid' $condition");
		$row0 = $query0->row();
		 $conductedAuction=$row0->total_act_action;
		
		
		// Find Total Active Property 
		$query1=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND status='1' AND user_id='$userid' $pcondition");
		$row1 = $query1->row();
		$activeProperty=$row1->total_act_property;

		$query2=$this->db->query("SELECT COUNT(id)as total_act_property FROM tbl_product WHERE  (sell_rent='sell' OR sell_rent='rent') AND user_id='$userid' $pcondition");
		$row2 = $query2->row();
		$postedProperty=$row2->total_act_property;
		
		$query3=$this->db->query("SELECT a.id,lb.auctionID,lb.bidderID  FROM tbl_auction as a LEFT JOIN tbl_auction_participate as lb ON a.id=lb.auctionID WHERE a.bank_id is null AND a.auction_type='1' AND a.created_by='$userid' $joinpcondition GROUP BY lb.bidderID");
		$interestedUsers = $query3->num_rows();
		$data['propertyViewed']		=	$propertyViewd;
		$data['auctionConducted']	=	$conductedAuction;
		$data['activeAuction']		=	$activeAuction;
		$data['propertyPosted']		=	$postedProperty;
		$data['activeProperties']	=	$activeProperty;
		$data['interestedUsers']	=	$interestedUsers;
		return $data;
	}


	
	function saveeventdata(){
	  
	   $bidincreen1 = $this->input->post('bid_inc');
	   if($bidincreen1[0] == 'others')
	   {
		   $bidincreen = $bidincreen1[1];
	    }else{
		  $bidincreen = $bidincreen1[0];
		}
	   $bid_inc1=$this->input->post('bid_inc');
           if($bid_inc1[0]=='others'){   $bid_inc=$bid_inc1[1]; }else{ $bid_inc=$bid_inc1[0];}
		$created_by					=	 $this->session->userdata['id'];
		$auctionID 					=	 $this->input->post('auctionID');
		$productID 					=	 $this->input->post('propertyID');
		$reference_no 				= 	 $this->input->post('reference_no');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category_id');
		$subcategory_id 			=	 $this->input->post('subcategory_id');
		$borrower_name 				=	 $this->input->post('borrower_name');
		$reserve_price 				=	 $this->input->post('reserve_price');
		$emd_amt 					=	 $this->input->post('emd_amt');
		$tender_fee 				=	 $this->input->post('tender_fee');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$inspection_date_from 		=	 $this->input->post('inspection_date_from');
		$inspection_date_to 		=	 $this->input->post('inspection_date_to');
		$bid_last_date 				=	 $this->input->post('bid_last_date');
		$bid_opening_date 			=	 $this->input->post('bid_opening_date');
		$auction_start_date 		=	 $this->input->post('auction_start_date');
		$auction_end_date 			=	 $this->input->post('auction_end_date');
		$show_frq 					=	 $this->input->post('show_frq');
		$price_bid 					=	 $this->input->post('price_bid');
		$bid_inc 					=	$bid_inc ;
		$auto_extension_time 		=	 $this->input->post('auto_extension_time');
		$auto_extension 			=	 $this->input->post('auto_extension');
		$doc_to_be_submitted 		=	 $this->input->post('doc_to_be_submitted');
		
		if($auto_extension_time!='' && $auto_extension=='')
		{
			$auto_extension=100;	
		}else if($auto_extension_time>0 && $auto_extension<=0)
		{
			$auto_extension=100;	
		}else{
			$auto_extension=$auto_extension;	
		}

		$auto_bid_cut_off 			=	 $this->input->post('auto_bid_cut_off');
		$is_closed 					=	 $this->input->post('is_closed');
		$bidders_list 				=	 $this->input->post('bidders_list');
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
		
		if($_FILES['image']['name'])
		{
			$image=$this->helpdesk_executive_model->uploadauction('image');
			
		}else{
			$image=$this->input->post('old_image');
		} 

		if($_FILES['related_doc']['name'])
		{
			$related_doc=$this->helpdesk_executive_model->uploadauction('related_doc');
		}else{
			$related_doc=$this->input->post('old_related_doc');
		}

		if($doc_to_be_submitted){
			$doc_to_be_submitted=implode(",",$doc_to_be_submitted);
		}

		$data 			= array(
							'productID'=>$productID,
							'auto_bid_cut_off'=>$auto_bid_cut_off,
							'reference_no'=>$reference_no,
							'event_title'=>$event_title,
							'category_id'=>$category_id,
							'subcategory_id'=>$subcategory_id,
							'borrower_name'=>$borrower_name,
							'reserve_price'=>$reserve_price,
							'emd_amt'=>$emd_amt,
							'tender_fee'=>$tender_fee,
							'press_release_date'=>$press_release_date,
							'inspection_date_from'=>$inspection_date_from,
							'inspection_date_to'=>$inspection_date_to,
							'bid_last_date'=>$bid_last_date,
							'bid_opening_date'=>$bid_opening_date,
							'auction_start_date'=>$auction_start_date,
							'auction_end_date'=>$auction_end_date,
							'show_frq'=>$show_frq,
							'dsc_enabled'=>$dsc_enabled,
							'bid_inc'=>$bid_inc,
							'price_bid_applicable'=>$price_bid,
							'related_doc'=>$related_doc,
							'image'=>$image,
							'auto_extension_time'=>$auto_extension_time,
							'no_of_auto_extn'=>$auto_extension,
							'doc_to_be_submitted'=>$doc_to_be_submitted,
							'first_opener'=>$created_by,
							'created_by'=>$created_by,
							'is_closed'=>$is_closed,
							'indate'=>date('Y-m-d H:i:s'),
							'status'=>0,
							'auction_type'=>1
							);	
					if($auctionID)
					{
						$this->db->where('id', $auctionID);
						$this->db->update('tbl_auction',$data); 
						$insertedid_id 	=$auctionID;
					}else{
						$this->db->insert('tbl_auction',$data); 
						$insertedid_id = $this->db->insert_id();
					}
					//echo $this->db->last_query();
					//die;
					//******************Start Add Close Auction Bidders***************
						if($is_closed==1){
							if(count($bidders_list)){
								$query=$this->db->query("SELECT bidderID from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
								if ($query->num_rows() > 0) {
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
								
								$newbidderArr=$this->getAllCloseAuctionBidder($auctionID);
								foreach($bidders_list as $bidderID){
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
										 $this->helpdesk_executive_model->sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID);
										}
								}
							}

						}
						//echo $insertedid_id;					
			//die;	
						//******************End Add Close Auction Bidders***************
					if($insertedid_id){
						$this->db->where('id', $productID);
						$this->db->update('tbl_product', array('status'=>'0','updated_date'=>date('Y-m-d H:i:s'),'auctionID'=>$insertedid_id));
					}
					//$insertedid_id;
					return $insertedid_id;
					
	}	

	function sellerPropertyDatatable(){
		$userid					=	 $this->session->userdata['id'];
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("id,@row := @row + 1 as SNo, id as unique_id, name,
		CASE is_auction WHEN '1' THEN 'Auction' ELSE 'Non-Auction' END as is_auction,
		UCASE(sell_rent),
		CASE status WHEN '1' THEN 'Approved' WHEN '7' THEN 'Rejected' ELSE 'Pending' END as status",false)
		->unset_column('id')
		->from('tbl_product')
		//->add_column('Actions',"<a href='/owner/sellerPostPropety/$1' class=' product_detail_iframe'>Edit</a> ", 'id')
		
		->where("user_id ='$userid' AND (sell_rent='sell' OR sell_rent='rent')")
		->where('status !=',5)
		->where('status !=',0);
		///->order_by('id','DESC');
		return $this->datatables->generate();	
	}
	function sellersavedPropertyDatatable(){
		$userid	= $this->session->userdata['id'];
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("p.id,@row := @row + 1 as SNo,p.name,
		CASE p.is_auction WHEN '1' THEN 'Auction' ELSE 'Non-Auction' END as is_auction,
		UCASE(sell_rent),
		CASE p.status WHEN '4' THEN 'Approved' WHEN '4' THEN 'Pending' ELSE 'Not Approved' END as status",false)
		->unset_column('p.id')
		->from('tbl_product as p')
		->join('tbl_auction as a','p.id=a.productID','left')
		->add_column('Actions',"<a href='/owner/sellerPostPropety/$1' class=' product_detail_iframe'>Edit</a> ", 'p.id')
		->where("p.user_id ='$userid' AND (p.sell_rent='sell' OR p.sell_rent='rent')")
		->where('p.status',0);
		//->where('status',0);
		//->order_by('id','DESC');
		return $this->datatables->generate();	
	}
	function getOwnersLiveAuctionList($aid){
	$currentdate=date("Y-m-d H:i:s");
	$userid=$this->session->userdata['id'];
	if($aid>0){
	$query=$this->db->query("SELECT * FROM tbl_auction WHERE auction_start_date <='$currentdate' AND auction_end_date >= '$currentdate' AND created_by='$userid' AND bank_id is null AND auction_type='1' AND id='$aid' ");
	}else{
	$query=$this->db->query("SELECT * FROM tbl_auction WHERE auction_start_date <='$currentdate' AND auction_end_date >= '$currentdate' AND created_by='$userid' AND bank_id is null AND auction_type='1' ");
	}
	$this->db->last_query();
		if($query->num_rows()>0)
		{
			$data=array();
			foreach ($query->result() as $row)
			{
				$data[]=$row;
			}
		return $data;		
		}else{
			$data=0;
		return $data;	
		}
		//return false;			
			
	}
	
	/********************** Live Auction     ************************/ 
	function liveAuctionDatatable()
    {	
		$userid=$this->session->userdata['id'];
		//$this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name, a.auction_start_date, a.auction_end_date",false)
                $this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name,a.bid_last_date,(CASE  WHEN a.status = '1' THEN 'published' ELSE 'saved' END) as status",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
                ->join('tbl_city as cit','cit.id=pro.city','left')     
		->where('ap.bidderID',$userid)
		->where('a.status !=',0)
		->where('if(a.second_opener!=0, ap.operner2_accepted,ap.operner1_accepted)')
		->where("((NOW() >= a.auction_start_date AND NOW()<= a.auction_end_date) OR (a.open_price_bid=1 and a.auction_start_date >=NOW()))");
        return $this->datatables->generate();
    }
    function liveAuctionDatatable1()
    {	
		$userid=$this->session->userdata['id'];
		//$this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name, a.auction_start_date, a.auction_end_date",false)
                $this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name, a.bid_last_date,a.reserve_price,a.emd_amt",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
                ->join('tbl_city as cit','cit.id=pro.city','left')     
		->where('ap.bidderID',$userid)
		->where('a.status !=',0)
		->where('if(a.second_opener!=0, ap.operner2_accepted,ap.operner1_accepted)')
	        ->where("((NOW() >= a.auction_start_date AND NOW()<= a.auction_end_date) OR (a.open_price_bid=1 and a.auction_start_date >=NOW()))");
        return $this->datatables->generate();
    }
    
    
    function ownerliveEventDatatable1()
    {	
		$userid=$this->session->userdata['id'];
		//$this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name, a.auction_start_date, a.auction_end_date",false)
		
		
        $this->datatables->select("a.id, b.name, a.PropertyDescription,cit.city_name, a.bid_last_date,a.reserve_price,a.emd_amt",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
                ->join('tbl_city as cit','cit.id=pro.city','left')     
		->where('ap.bidderID',$userid)
		->where('a.status !=',0)
		->where('if(a.second_opener!=0, ap.operner2_accepted,ap.operner1_accepted)')
	        ->where("((NOW() >= a.auction_start_date AND NOW()<= a.auction_end_date) OR (a.open_price_bid=1 and a.auction_start_date >=NOW()))");
	          
        $this->db->order_by('a.id','DESC');
                  
                  
                  
        return $this->datatables->generate();
    }
    
    // Dashbord Live Events
    function ownerliveEventDatatable_main()
    {       
		
		$userid=$this->session->userdata['id'];   
		
		$this->datatables->select("fav.is_fav,a.id,dp.department_name, a.PropertyDescription,IFNULL( a.reference_no, a.other_city) AS city_name,DATE_FORMAT(a.registration_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.bid_last_date,'%d-%m-%Y %H:%i:%s'), a.reserve_price,a.emd_amt,a.productID,a.dsc_enabled, ap.cert_serial_no, ap.operner2_accepted, ap.operner2_comment, DATE_FORMAT(ap.opener2_accepted_date,'%d-%m-%Y %H:%i:%s %p')",false)
		 ->from('tbl_auction as a')
        //->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' >Track</a>  <a class='' href='/owner/pro_detail/$2' >View</a>", 'a.id', 'a.id')
        
        ->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  ", 'a.id')
        //->add_column('View',"<a class='' href='/owner/pro_detail/$1' >View</a>", 'a.productID')
		->join('tbl_bank as b','b.id=a.bank_id','left')
       // ->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->join('tbl_branch as bran','bran.id=a.branch_id','left')
		->join('tbl_auction_bidder_fav as fav',"fav.auctionID=a.id and fav.bidderID = '".$userid."'",'left')   // Favourite LIST ADDED
		->join('tbl_city as cit','cit.id=a.city','left')
        ->join('tbl_auction_participate as ap',"ap.auctionID=a.id and ap.bidderID='".$userid."'",'left') //and ap.final_submit !=1
		->where('a.status', 1)
		->where('( a.show_home = 1 OR a.id IN(SELECT auction_id from  tbl_auction_bidder_limited_access WHERE bidder_id = '.$userid.' and status = 1)) ')
		->where('a.id NOT IN(select auctionID from tbl_auction_participate where bidderID='.$userid.' and final_submit = 1 )')
		//->where('registration_start_date <= NOW()')
		->where('bid_last_date >= NOW()');
		$this->db->order_by('a.id','DESC');
		 return $this->datatables->generate();
    }
    
        
    function ownerliveEventDatatable_main_fav()
    {       
		//a.productID
		$userid=$this->session->userdata['id'];   
		//$this->datatables->select("b.logopath,a.id,b.name, a.event_title,cit.city_name,a.bid_last_date, a.reserve_price,a.emd_amt, a.productID",true)
		$this->datatables->select("a.id,dp.department_name, a.PropertyDescription,a.reference_no,DATE_FORMAT(a.registration_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.bid_last_date,'%d-%m-%Y %H:%i:%s'), a.reserve_price, a.emd_amt,a.productID, a.dsc_enabled,ap.cert_serial_no, ap.operner2_accepted, ap.operner2_comment, DATE_FORMAT(ap.opener2_accepted_date,'%d-%m-%Y %H:%i:%s')",false) //
                    
		//->unset_column('a.productID')	
		
        ->from('tbl_auction as a')
        ->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a> 
 <a class='' href='/owner/pro_detail/$2' >View</a> <a class='' href='javascript:void(0);' onclick='removefromlivefavEventlist($1)'><img src='../images/addtoFav.jpg' title='Remove from favourite' width='20' height='20' class='imgfav'></a>", 'a.id,a.productID')
        //->add_column('View',"<a class='' href='/owner/pro_detail/$1' >View</a>", 'a.productID')
		->join('tbl_bank as b','b.id=a.bank_id','left')
                //->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->join('tbl_branch as bran','bran.id=a.branch_id','left')
		->join('tbl_auction_bidder_fav as fav','fav.auctionID=a.id','left') // Favourite LIST ADDED
		->join('tbl_city as cit','cit.id=bran.city','left')
        ->join('tbl_auction_participate as ap','ap.auctionID=a.id and ap.bidderID='.$userid,'left')
        //->join('tbl_city as cit','cit.id=pro.city','left')     Comment 
		->where('a.status', 1)
		->where('fav.is_fav', 1)  // Favourite LIST ADDED
		->where('fav.bidderID', $userid)
		->where('( a.show_home = 1 OR a.id IN(SELECT auction_id from  tbl_auction_bidder_limited_access WHERE bidder_id = '.$userid.' and status = 1)) ') 
		->where('a.id NOT IN(select auctionID from tbl_auction_participate where bidderID='.$userid.' and final_submit = 1 )')               
		->where('bid_last_date >= NOW()');
        $this->db->order_by('a.id','DESC');

        return $this->datatables->generate();
    }
    
    
    function getBidderRankByTimestamp($auctionID,$bidderID,$timestamp){		
		$query=$this->db->query("SELECT bidderID, bid_value, indate, MAX(bid_value) as 'maxValue' FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' AND indate <='$timestamp' GROUP BY bidderID  ORDER BY MAX(bid_value) DESC");		
		if($query->num_rows())
		{	$rankArr=array();
			$i=1;
			foreach ($query->result() as $row)
			{
				if($row->bidderID == $bidderID)
				{
					return $i;
				}
				$i++;	
			}			
		}
		return false;
	}
	
    function checkOwnerLimitedUser($aid)
    { 
		$userid=$this->session->userdata['id']; 
		
		$this->db->where("auction_id",$aid);
		$this->db->where("status",1);
		$this->db->where("bidder_id",$userid);
		$query = $this->db->get('tbl_auction_bidder_limited_access');
		if($query->num_rows() > 0)
		{
			$res = $query->result();
			return $res[0];
		}
		return false;
	}
    
    
    function ownerliveEventDatatable_main_fav_sub()
    {       
		//a.productID
		$userid=$this->session->userdata['id'];   
		$this->datatables->select("a.id,dp.department_name, a.PropertyDescription, a.reference_no, a.registration_start_date, a.bid_last_date, a.reserve_price,a.emd_amt",true)
		
		//->unset_column('a.productID')	
		
        ->from('tbl_auction as a')
        ->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a> <a class='' href='javascript:void(0);' onclick='removefromlivefavEventlist($1)'><img src='../images/addtoFav.jpg' title='Remove from favourite' width='20' height='20' class='imgfav'></a>", 'a.id')

		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		//->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_branch as bran','bran.id=a.branch_id','left')
		->join('tbl_auction_bidder_fav as fav','fav.auctionID=a.id','left') // Favourite LIST ADDED
		->join('tbl_city as cit','cit.id=a.city','left')
        //->join('tbl_city as cit','cit.id=pro.city','left')     Comment 
		->where('a.status', 1)
		->where('fav.is_fav', 1)  // Favourite LIST ADDED
		->where('fav.bidderID', $userid)
		->where('( a.show_home = 1 OR a.id IN(SELECT auction_id from  tbl_auction_bidder_limited_access WHERE bidder_id = '.$userid.' and status = 1)) ') 
		->where('bid_last_date >= NOW()');
        $this->db->order_by('a.id','DESC');

        return $this->datatables->generate();
    }
    
    
    // Sub Menu Live Events
     function ownerliveEventDatatable_sub()
    {       
		
		//a.productID
		$userid=$this->session->userdata['id'];   
		//$this->datatables->select("fav.is_fav,a.id,ac.account_name, a.event_title,cit.city_name,a.bid_last_date, a.reserve_price,a.emd_amt",true)
        $this->datatables->select("fav.is_fav,a.id,dp.department_name, a.PropertyDescription, a.reference_no, DATE_FORMAT(a.registration_start_date,'%d-%m-%Y %H:%i:%s'),DATE_FORMAT(a.bid_last_date,'%d-%m-%Y %H:%i:%s'), a.reserve_price,a.emd_amt",false)
        ->from('tbl_auction as a')
        //->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' >Track</a>  <a class='' href='/owner/pro_detail/$2' >View</a>", 'a.id', 'a.id')
        
        ->add_column('Actions',"<a class='' href='/owner/auctionParticipage/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  ", 'a.id')
        //->add_column('View',"<a class='' href='/owner/pro_detail/$1' >View</a>", 'a.productID')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		//->join('tblmst_account_type as ac','ac.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->join('tbl_branch as bran','bran.id=a.branch_id','left')
		->join('tbl_auction_bidder_fav as fav',"fav.auctionID=a.id and fav.bidderID = '".$userid."'",'left')   // Favourite LIST ADDED
		->join('tbl_city as cit','cit.id=a.city','left')
              //  ->join('tbl_city as cit','cit.id=pro.city','left')     Comment 
		->where('a.status', 1)
		->where('( a.show_home = 1 OR a.id IN(SELECT auction_id from  tbl_auction_bidder_limited_access WHERE bidder_id = '.$userid.' and status = 1)) ')
		->where('bid_last_date >= NOW()');
		$this->db->order_by('a.id','DESC');
		 return $this->datatables->generate();
    }
    
    
	
	function sellliveAuctionDatatable()
    {	
			$userid=$this->session->userdata['id'];
			$this->datatables->select("a.id, a.event_title,a.PropertyDescription,a.auction_start_date,a.auction_end_date, t1.total_bidder",false)
			->add_column('Actions',"<a class='' href='/owner/sellEventtrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
			->from('tbl_auction as a LEFT JOIN 
			(SELECT auctionID, `bidderID`, COUNT(bidderID) as total_bidder FROM tbl_auction_participate as T GROUP BY auctionID) t1 ON t1.auctionID = a.id')
			->join('tbl_product as pro','pro.id=a.productID','left')
			->where('(NOW() >= a.auction_start_date AND NOW()<= a.auction_end_date)')
			->where('a.created_by',$userid)
			->where("a.bank_id is null AND a.auction_type='1'");
        return $this->datatables->generate();
    }
	
	/********************** End Live Auction    ************************/ 
	/********************** Upcommin Auction     ************************/ 
	function sellupcomingAuctionDatatable()
    {	
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id, a.event_title,a.PropertyDescription,a.auction_start_date,a.auction_end_date, t1.total_bidder",false)
		->add_column('Actions',"<a class='' href='/owner/sellEventtrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a
		LEFT JOIN 
		(SELECT auctionID, `bidderID`, COUNT(bidderID) as total_bidder FROM tbl_auction_participate as T GROUP BY auctionID) t1 ON t1.auctionID = a.id')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->where('a.bid_last_date >= NOW()')
		->where('a.status','1')
		->where('a.created_by',$userid)
		->where("a.bank_id is null AND a.auction_type='1'");
        return $this->datatables->generate();
    }
	
	/********************** complete Auction     ************************/ 
	function completeAuctionDatatable()
    {	
		$_POST['bSearchable_7'] = false;
		
	    $userid=$this->session->userdata['id'];
	    $wheretmp = '(a.status=8 OR a.status=7 OR a.status=6)'; 	
		
        $this->datatables->select("a.id, a.reference_no, dp.department_name as type, a.PropertyDescription, a.reserve_price, a.opening_price,MAX(lv.bid_value) as  larget_frq",false)        //MAX(b.frq) as  larget_frq
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_live_auction_bid as lv',"lv.auctionID=a.id AND lv.bidderID = '".$userid."'",'left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		//->join('tblmst_account_type as act','act.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->where('ap.bidderID',$userid)
		->where($wheretmp)
		->where('if(a.second_opener!=0, ap.operner2_accepted,ap.operner1_accepted)')
		->where('a.auction_end_date < NOW()')
		->group_by('a.id');						
        return $this->datatables->generate();
     }
	
	function completeAuctionDatatabletest()
    {	    $userid=$this->session->userdata['id'];
	    $wheretmp = '(a.status=7 OR a.status=6)'; 	
		$this->datatables->select("a.id, b.name, a.PropertyDescription, a.auction_start_date, a.auction_end_date",false)
		->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=a.id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->where('ap.bidderID',$userid)
		->where($wheretmp)
		->where('if(a.second_opener!=0, ap.operner2_accepted,ap.operner1_accepted)')
		->where('a.auction_end_date < NOW()');		
        return $this->datatables->generate();
    }
	
	function sellcompleteAuctionDatatable()
    {	
	
	$userid=$this->session->userdata['id'];
	$this->datatables->select("a.id, a.event_title,a.PropertyDescription, DATE_FORMAT(a.auction_start_date,'%m/%d/%Y %h:%i %p'),DATE_FORMAT(a.auction_end_date,'%m/%d/%Y %h:%i %p'),t1.total_bidder",false)
	->add_column('Actions',"<a class='' href='/owner/sellEventtrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
	->from('tbl_auction as a
		LEFT JOIN 
		(SELECT auctionID, `bidderID`, COUNT(bidderID) as total_bidder FROM tbl_auction_participate as T GROUP BY auctionID) t1 ON t1.auctionID = a.id')
	->join('tbl_product as pro','pro.id=a.productID','left')
	->where('a.auction_end_date < NOW()')
	->where('a.created_by',$userid)
	->where("a.bank_id is null AND a.auction_type='1'");
        return $this->datatables->generate();
    }
	/********************** Cancel Auction     ************************/ 
	function cancelAuctionDatatable()
    {	$userid=$this->session->userdata['id'];
		//$this->datatables->select("a.id, a.PropertyDescription, a.auction_start_date, a.auction_end_date",false)
		$this->datatables->select("a.id,b.name, a.reference_no,dp.department_name as type, a.PropertyDescription, a.reserve_price",false)
	       //  ->add_column('Actions',"<a class='' href='/owner/eventTrack/$1' >Track</a>", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->join('tbl_auction_participate as l',"l.auctionID=a.id","left")
		//->join('tblmst_account_type as act','act.account_id=a.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=a.department_id','left')
		->where('l.bidderID',$userid)
		->where("(a.status='3' OR a.status='4')");
		return $this->datatables->generate();
    }
	
	
		function sellcancelAuctionDatatable(){	
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id, a.event_title,a.PropertyDescription, DATE_FORMAT(a.auction_start_date,'%m/%d/%Y %h:%i %p'), DATE_FORMAT(a.auction_end_date,'%m/%d/%Y %h:%i %p'), t1.total_bidder",false)
		->add_column('Actions',"<a class='' href='/owner/sellEventtrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
		->from('tbl_auction as a
		LEFT JOIN 
		(SELECT auctionID, `bidderID`, COUNT(bidderID) as total_bidder FROM tbl_auction_participate as T GROUP BY auctionID) t1 ON t1.auctionID = a.id')
		->join('tbl_product as pro','pro.id=a.productID','left ')
		//->join('tbl_auction_participate as li','li.auctionID=a.id','left')
		->where("(a.status ='3' OR a.status ='4')")
		->where('a.created_by',$userid)
		->where("a.bank_id is null AND a.auction_type='1'");
		return $this->datatables->generate();
               }
	
	function auctionBidToBeOpenAuction(){
		$userid=$this->session->userdata['id'];
		$this->datatables->select("a.id, a.event_title, a.PropertyDescription, DATE_FORMAT(a.auction_start_date,'%m/%d/%Y %h:%i %p'),  DATE_FORMAT(a.auction_end_date,'%m/%d/%Y %h:%i %p')",false)
		->add_column('Actions',"<a class='' href='/owner/sellEventtrack/$1' ><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'a.id')
        ->from('tbl_auction as a')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->where('a.auction_start_date > NOW()')
		->where('a.bid_last_date < NOW()')
		->where('a.created_by',$userid)
		->where("a.bank_id is null AND a.auction_type='1'");
        return $this->datatables->generate();	
		
	}

	function selleventTrackData($auction_id)
    {	
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			
			/***** count no. of bidder*****/
			$this->db->select('count(id) as bider_total');
			//$this->db->where('status !=', 5);
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_auction_participate");
			$bider_total=$query->result();
			$data[0]->bider_total=$bider_total[0]->bider_total;
			/***** count no. of bidder*****/
			
			/***** bidder detail*****/
			//$this->db->select('count(id) as bider_total');
			//$this->db->where('status !=', 5);
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_auction_participate");
				if($query->num_rows()>0)
				{
					$data1=array();
					foreach ($query->result() as $row1)
					{
						//emd fee
						$this->db->where('auctionID', $data[0]->id);
						$this->db->where('bidderID', $row1->bidderID);
						$query_emd = $this->db->get("tbl_auction_participate_emd");
						$emd_result=$query_emd->result();
						$row1->emd_detail=$emd_result;
						
						//frq
						$this->db->where('auctionID', $data[0]->id);
						$this->db->where('bidderID', $row1->bidderID);
						$query_frq = $this->db->get("tbl_auction_participate_frq");
						$frq_result=$query_frq->result();
						$row1->frq_detail=$frq_result;
						
						//tender fee
						$this->db->where('auctionID', $data[0]->id);
						$query_tenderfee = 
						$this->db->get("tbl_auction_participate_tenderfee");
						$tenderfee_result=$query_tenderfee->result();
						$row1->tenderfee=$tenderfee_result;
						
						//doc
						$this->db->where('auctionID', $data[0]->id);
						$query_tenderfee = 
						$this->db->get("tbl_auction_participate_tenderfee");
						$this->db->where('auctionID', $data[0]->id);
						$query_doc = $this->db->get("tbl_auction_participate_doc");
						$data_doc=array();
						foreach ($query_doc->result() as $row_doc)
						{
						$data_doc[]=$row_doc;
						}
						$row1->doc=$data_doc;
						//doc end
						$data1[]=$row1;
						$data[0]->bider_detail=$data1;
					}
				}
			//$data[0]->bider_total=$bider_total[0]->bider_total;
			/***** end bidder*****/
			
			/***** property desc*****/
			$this->db->select('product_description');
			//$this->db->where('status !=', 5);
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_product");
			$bider_total=$query->result();
			$data[0]->property_description=$bider_total[0]->product_description;
			/***** property desc*****/
			
			return $data;
		}
		return false;

    }
	function eventTrackCurrentStage($status='',$bid_last_date='',$bid_opening_date='',$auction_start_date='',$auction_end_date='',$id='')
    {
		$date=@strtotime(date('Y-m-d H:i:s'));
		$bid_last_date=strtotime($bid_last_date);
		$bid_opening_date=strtotime($bid_opening_date);
		$auction_start_date=strtotime($auction_start_date);
		$auction_end_date=strtotime($auction_end_date);
		if(!$status)
		{
			if($stageID!=1)
			$this->updateStageStatus('1',$id);
			return 1;
		}
		elseif( $bid_last_date >$date)
		{
			if($stageID!=2)
			$this->updateStageStatus('2',$id);
			return 2;
		}
		
		elseif( $bid_oppening_date < $date and $auction_start_date > $date )
		{
			if($stageID!=3)
			$this->updateStageStatus('3',$id);
			return 3;
		}
		/*elseif($bid_oppening_date < $date and $auction_start_date > $date and $stageID==4 )
		{
			if($stageID!=4)
			$this->updateStageStatus('4',$id);
			return 4;
		}*/
		elseif( $auction_end_date > $date  and $auction_start_date < $date )
		{
			if($stageID!=4)
			$this->updateStageStatus('4',$id);
			return 4;
		}
		elseif( $auction_end_date < $date)
		{
			if($stageID!=5)
			$this->updateStageStatus('5',$id);
			return 5;
		}
		return 1;
	}
	function updateStageStatus($stageID,$id)
	{
	
		$data = array(
					'stageID'=>$stageID
					);							
					
			$this->db->where('id', $id);
			$this->db->update('tbl_auction', $data); 
	}
	
	
	function saveFirstOpnerVerification()
	{
			
		
		$auctionID = $this->input->post('auctionID');
		$bidderID = $this->input->post('bidderID');
		$participate_id = $this->input->post('participate_id');
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		$stageID = 4;
		$i=0;
		//echo '<pre>';print_r($_POST);die;
		foreach($participate_id as $pi)
		{	
			$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
			$data = array(
						'operner1_accepted'=>$acceptance,
						'operner1_comment'=>$txtComment[$i]
						);
			$this->db->where('id', $pi);
			$this->db->update('tbl_auction_participate', $data); 
			
			
			$this->db->where('auction_participate_id', $pi);
			$this->db->update('tbl_log_auction_participate', $data); 
			//if(!$second_opener){
			//	$this->send_bid_acceptted_rejected_mail($bidderID[$i],$bid_acceptance[$i]);
			//}
			
			//echo '<br />';
			echo $this->db->last_query();
			$i++;
		}
		//die;
		//$this->db->where('id', $auctionID);
		//$this->db->update('tbl_auction', array('stageID'=>$stageID));
		//echo '<pre>';print_r($_POST);die;
		$this->session->set_userdata('open_popup', true);
		return true;
	}
	
	/*
	function saveFirstOpnerVerification()
	{
		$auctionID = $this->input->post('auctionID');
		$bidderID = $this->input->post('bidderID');
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		$bidderID=implode(',',$bidderID);
		$bidderID=array_shift($bidderID);
		
		
		
		foreach($bidderID as $key=>$bidder_id)
		{		
		
		echo "sdfsafdsfdsaf";
			$data = array(
						'operner1_accepted'=>$bid_acceptance[$key],
						'operner1_comment'=>$txtComment[$key]
						);							
						
				$this->db->where('auctionID', $auctionID);
				$this->db->where('bidderID', $bidder_id);
				$this->db->update('tbl_auction_participate', $data); 
				echo $this->db->last_query();
		}
		echo "yrddddddd";
		die;
		//$this->db->where('id', $auctionID);
		//$this->db->update('tbl_auction', array('stageID'=>4)); 
	}
	
	
	*/
	
	
function savefavorite(){
		$userid=$this->session->userdata['id'];
		$bankID=$this->input->post('bankID');
		$indate=date('Y-m-d H:i:s');
		$data 	= array('user_id'=>$userid,
						'bank_id'=>$bankID,
						'indate'=>$indate,
						'status'=>1);
		$this->db->insert('tbl_user_bank_follow',$data); 
		$insertedid_id = $this->db->insert_id();
		//return $insertedid_id; 		
	}

	function removefollows(){
		$userid=$this->session->userdata['id'];
		$bankID=$this->input->post('bankID');
		$this->db->where('user_id',$userid);
		$this->db->where('bank_id',$bankID);
		$this->db->delete('tbl_user_bank_follow'); 		
		echo $this->db->last_query();
		
	}
	
	function saveFrqParticipate(){

		$bidderid					=	 $this->session->userdata['id'];
		$auction_participateID		=	$this->input->post('auction_participateID');
		$auction_participateFRQID	=	$this->input->post('auction_participateFRQID');
		$quote_price				=	$this->input->post('quote_price');
		$documents_paid				=	$this->input->post('documents_paid');
		$emd_paid					=	$this->input->post('emd_paid');
		$tender_paid				=	$this->input->post('tender_paid');
		$auction_id					=	$this->input->post('auction_id');
		$alaise_name				=	$this->input->post('alaise_name');
		$bidderid					=	$bidderid;
		$fSave						=	$this->input->post('fSave');
		$created_by					=	$this->session->userdata['id'];
		$indate						=	date("Y-m-d H:i:s");
		$Save						=	$this->input->post('Save');
		
		$jda_payment_status = GetTitleByField('tbl_jda_payment_log', "auction_id='" . $auction_id . "' AND bidder_id='" . $bidderid . "' order by payment_log_id DESC", 'payment_status');
		$doc_to_be_submitted = GetTitleByField('tbl_auction', "id='" . $auction_id . "'", 'doc_to_be_submitted');
		
		
		if($Save=='Submit'){
			$final_submit=0;
                        $this->session->set_flashdata('saved','0');
		}else{
			$final_submit=1;	
               }
		
		// Insert FRQ DATA
		if($quote_price!='not_application')
		{
				$datafrq = array('auctionID'=>$auction_id,
								'bidderID'=>$bidderid,
								'frq'=>$quote_price,
								'addby'=>$created_by,
								'indate'=>$indate);
				if($auction_participateFRQID){
					$this->db->where('id',$auction_participateFRQID);	
					$this->db->update('tbl_auction_participate_frq',$datafrq);
				}else{
					$this->db->insert('tbl_auction_participate_frq',$datafrq);
					$frqInsertedID = $this->db->insert_id();
				}
				//echo $this->db->last_query();
				//die;
			$frq=1;
		}else{
			$frq=0;	
		}				
			
		// Insert Final submit  FRQ DATA
		
		if($alaise_name)
		{
		$alaise_name=$alaise_name;	
		}else{
		$alaise_name=$this->bidder_model->alias_name(8);	
		}
		$data 	= array('tender_fee'=>$tender_paid,
						'emd'=>$emd_paid,
						'frq'=>$frq,
						'documents'=>$documents_paid,
						//'final_submit'=>$final_submit,
						'auctionID'=>$auction_id,
						'alaise_name'=>$alaise_name,
						'status'=>1,
						'bidderID'=>$bidderid,
						'added_type'=>'bidder',
						'addby'=>$created_by);
						
		//check if payment faild				
		if($jda_payment_status=='failure')
		{
			$data['payment_verifier_accepted'] = NULL;
			$data['payment_verifier_comment'] = NULL;
			$data['payment_move_to_opener2'] = 0;
			$data['payment_verifier_accepted_date'] = NULL;
		}
		if($doc_to_be_submitted !=0)
		{
			$data['operner1_accepted'] = NULL;
			$data['operner1_comment'] = NULL;
			$data['opener1_move_to_opener2'] = NULL;
			$data['opener1_accepted_date'] = NULL;
		}
		$data['operner2_accepted'] = NULL;
		$data['operner2_comment'] = NULL;
		$data['opener2_accepted_date'] = NULL;
		//print_r($data );die;				
	//	if($auction_participateID)
	//	{
		
			if($Save != 'Submit'){
				$data['final_submit'] = 1;
			}
			$data['modify_date']=$indate;
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$this->db->update('tbl_auction_participate',$data);	
            $insertedid_id	=1;		
			
			
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$pQry = $this->db->get('tbl_auction_participate');
			$rows = $pQry->result_array();					
			$data1 = $rows[0];
			unset($data1['id']);
			unset($data1['pstatus']);
			unset($data1['dsc_verified_status']);
			$final_msg='Bidder final submitted Successfully';
			$data1['final_submit_date'] = $indate;
			$data1['final_submit_ip'] = $_SERVER['REMOTE_ADDR'];
			$data1['final_submit_message'] = $final_msg;
			$data1['auction_participate_id'] = $rows[0]['id'];
			
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$this->db->insert('tbl_log_auction_participate',$data1);	
			
		/*
		}else{
			$data['indate']=$indate;
			$this->db->insert('tbl_auction_participate',$data);				
			$insertedid_id = $this->db->insert_id();			
		}*/				
	return $insertedid_id;		
	}

	function tcAccept()
	{
		$auctionID 	= $this->input->post('auctionID');
        $bidderID	= $this->session->userdata('id');
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query = $this->db->get("tbl_auction_participate");
              if($query->num_rows() == 0){  
                              $row=$query->result();
                              $data = array(  'auctionID'=>$auctionID,
						'bidderID'=>$bidderID,
						'is_accept_tc'=>1,
						'participate_by'=>'owner',
						'status'=>2,
						'indate'=>date('Y-m-d H:i:s'));
				$this->db->insert('tbl_auction_participate',$data);	
				$last_insert_id = $this->db->insert_id();
				$data['auction_participate_id'] = $last_insert_id;
				$data['is_accept_tc_date'] = date('Y-m-d H:i:s');
				$data['is_accept_tc_ip'] = $_SERVER['REMOTE_ADDR'];
				$data['is_accept_tc_message'] = 'Bidder participated agreement Successfully';
				
				$insert=$this->db->insert('tbl_log_auction_participate',$data);	
                                if($insert){
                                  $this->db->select('eventID,bank_id');  
                                  $this->db->from('tbl_auction');   
                                  $this->db->where('id', $auctionID);
                                  $query1=$this->db->get();
                                  $row1=$query1->result();
                                  $message='Bidder participitated agreement Successfully';
                                  $data1=array(  
                                    'event_id'=>$row1[0]->eventID,
                                    'auction_id'=>$auctionID,
                                    'action_type'=>'participitation_agreement',
                                    'bank_id'=>$row1[0]->bank_id,
                                    'bidder_id'=>$bidderID,
                                    'indate'=>date('Y-m-d H:i:s'),
                                    'status'=>'1',
                                    'ip'=>$_SERVER['REMOTE_ADDR'],
                                    'message'=>$message
                                    );
                                 $this->db->insert('tbl_log_bidsubmission_track',$data1); 
                                }
                                
			return 1;
			
		}
		else
		{
			$this->db->where('auctionID', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$this->db->update('tbl_auction_participate', array('is_accept_tc'=>1)); 
			
			
			$this->db->where('auctionID', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$this->db->update('tbl_log_auction_participate', array('is_accept_tc'=>1,'is_accept_tc_date'=>date('Y-m-d H:i:s'))); 
			return 1;
		}
		
	}
	function atAccepted()
	{               $auctionID 	= $this->input->post('auctionID');
		        $bidderID	= $this->session->userdata('id');
		        $this->db->where('auctionID', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$this->db->update('tbl_auction_participate', array('is_accept_auct_training'=>1)); 
			$this->db->where('auctionID', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$this->db->update('tbl_log_auction_participate', array('is_accept_auct_training'=>1,'is_accept_auct_training_date'=>date('Y-m-d H:i:s'),'is_accept_auct_training_ip'=>$_SERVER['REMOTE_ADDR'])); 
			return 1;
			
		
	}	
	function buyeventTrackCurrentStage($status,$bid_last_date,$auction_start_date,$auction_end_date,$second_opener,$bidder_id,$bidder_status,$bidder_operner1_accepted,$bidder_operner2_accepted)
    {
		//$date=@date('Y-m-d H:m:i');
		$date=@strtotime(date('Y-m-d H:i:s'));
		$bid_last_date=strtotime($bid_last_date);
		$auction_start_date=strtotime($auction_start_date);
		$auction_end_date=strtotime($auction_end_date);
		if(!$bidder_id)
		{
			return 'tc';
		}
		elseif($bidder_status==2)
		{
			return 'participate';
		}
		elseif($bid_last_date >=$date)
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'accepted';
			 else
				return 'openning';
			}
			else
			{
			 if($bidder_operner1_accepted)
				return 'accepted';
			 else
				return 'openning';
			}
		}
		
		elseif( $bid_last_date<=$date and $auction_end_date>=$date )
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'liveauction';
			 else
				return 'auction';
			}
			else
			{
			 if($bidder_operner1_accepted)
				return 'liveauction';
			 else
				return 'auction';
			}
		}
		elseif( $auction_end_date>$date )
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'viewreport';
			 else
				return 'report';
			}
			else
			{
			 if($bidder_operner1_accepted)
				return 'viewreport';
			 else
				return 'report';
			}
		}
	}
        
        
        
        function bidsubmissiontrack($data,$type,$message){
             $this->db->select('eventID,bank_id');
             if($data['emd'][0]->auction_id!=null){
               $auctionid=$data['emd'][0]->auction_id;
             }else{
                $auctionid=$data['emd'][0]->auctionID;
             }
             $this->db->where('id', $auctionid);
             $query_emd=$this->db->get('tbl_auction');
             $eventres=$query_emd->result();
             $data=array(
                            'event_id'=>$eventres[0]->eventID,
                            'auction_id'=>$auctionid,
                            'action_type'=>$type,
                            'bank_id'=>$eventres[0]->bank_id,
                            'bidder_id'=> $this->session->userdata['id'],
                            'bank_user_id'=>  $this->session->userdata['id'],
                            'indate'=>date('Y-m-d H:i:s'),
                            'status'=>'1',
                            'ip'=>$_SERVER['REMOTE_ADDR'],
                            'message'=>$message
                            );
           $this->db->insert('tbl_log_bidsubmission_track',$data);
            
        }
	function GetPopularPropertyTypeByRank()
	{	
	$query1=$this->db->query("SELECT c.name, count(a.subcategory_id) as total_use  FROM tbl_auction as a INNER JOIN tbl_category as c ON c.id=a.subcategory_id GROUP BY a.subcategory_id order BY total_use DESC");
	$totalRow1=$query1->num_rows();
			if($totalRow1>0){
				$dataarr1=array();
				$i=1;
				 foreach ($query1->result() as $row) {
					$dataarr1[$i] = $row->name;
					$i++;
				}
			}else{
			$dataarr1=0;	
			}
		return $dataarr1;
	}		
		
	function GetPopularPropertyType(){
		$query=$this->db->query("SELECT c.id,c.name, count(a.subcategory_id) as total_use FROM tbl_auction as a INNER JOIN tbl_category as c ON c.id=a.subcategory_id GROUP BY a.subcategory_id");
		
		$totalRow=$query->num_rows();
		if($totalRow>0){
			$dataarr=array();
	    foreach ($query->result() as $row) {
                        $dataarr[] = $row;
                  }
		}else{
		        $dataarr=0;	
		}
		return  $dataarr;	
	}
	
	
	function countPopularlarAuctionByRange($condition){
		$query=$this->db->query("SELECT id FROM tbl_auction WHERE $condition ");
		//echo "<br>".$this->db->last_query();
		$totalRow=$query->num_rows();
		
		return $totalRow;
	}
	
	function GetPopularAuctionByRange(){
		
		$lessThen25leck=$this->countPopularlarAuctionByRange("reserve_price < '500000'");
		$between25_50lack=$this->countPopularlarAuctionByRange("reserve_price BETWEEN  '500000' AND '1000000'");
		$between50_75lack=$this->countPopularlarAuctionByRange("reserve_price BETWEEN '1000000'  AND '2000000'");
		$between75_1caror=$this->countPopularlarAuctionByRange("reserve_price BETWEEN '2000000'  AND '3000000'");
		$between1caror_2_5carors=$this->countPopularlarAuctionByRange("reserve_price BETWEEN '3000000' AND '4000000'");
		$between1caror2_5carors_5caros=$this->countPopularlarAuctionByRange("reserve_price BETWEEN '4000000' AND '5000000'");
		//$between1caror5caros_10caror=$this->countPopularlarAuctionByRange("reserve_price BETWEEN '50000000' AND '100000000'");
		$morethan10caror=$this->countPopularlarAuctionByRange("reserve_price > '5000000'");
		$dataarr=array();
		
		$dataarr['lessThen25leck']=$lessThen25leck;
		$dataarr['between25_50lack']=$between25_50lack;
		$dataarr['between50_75lack']=$between50_75lack;
		$dataarr['between1caror_2_5carors']=$between1caror_2_5carors;
		$dataarr['between1caror2_5carors_5caros']=$between1caror2_5carors_5caros;
		$dataarr['between1caror5caros_10caror']=$between1caror5caros_10caror;
		$dataarr['morethan10caror']=$morethan10caror;
		return  $dataarr;	
	}
        
        
	function completedAuctionsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
                $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no,UCASE(ea.event_type) as type,ea.event_title, tp.product_description, ea.reserve_price, DATE_FORMAT(ea.opening_price,'%m/%d/%Y %h:%i %p'), MAX(b.bid_value) as  last_bid_value ",false)	 
		->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user_registration as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
		->where('ea.auction_end_date < NOW()')
		->where('ea.status !=',0)
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->group_by('ea.id');
        return $this->datatables->generate();
    }
    
    
    function concludeAuctionsdatatable_main()
    {	
        $userid= $this->session->userdata('id');
		 $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type,tp.product_description, ea.reserve_price, b.frq as  last_bid_value",false)				
                  //->unset_column('ea.id')	 
                  
                /*$this->datatables->select("ea.id,tb.name as bank_name, ea.reference_no,(
    CASE 
        WHEN ea.event_type = 'sarfaesi' THEN SARFAESI
        WHEN ea.event_type = 'drt' THEN DRT
        WHEN ea.event_type = 'others' THEN Others
        ELSE NA
    END) AS type,tp.product_description, ea.reserve_price, MAX(b1.bid_value) as  last_bid_value",false)*/	
		//->add_column('Actions',"<a href='/owner/eventTrack/$1' class=''>Track</a>", 'ea.id')
		
		
                ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_auction_participate as ap','ap.auctionID=ea.id','left')
		->join('tbl_live_auction_bid as b1','b1.auctionID=ea.id','left')
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
	    ->where('ea.status',7)
		->where('ap.bidderID',$userid)
		->group_by('ea.id');
        return $this->datatables->generate();
        
    }
        
        
	function getBiddersLiveAuctionList($auctionID){
		
		$bidderID		=$this->session->userdata['id'];
		if($auctionID>0){
			$query=$this->db->query("SELECT a.*, p.bidderID,p.auctionID,p.is_accept_auct_training FROM tbl_auction as a INNER JOIN tbl_auction_participate as p ON a.id=p.auctionID WHERE a.auction_start_date <= NOW() AND a.auction_end_date >= NOW() AND p.bidderID='".$bidderID."' AND a.id='$auctionID' 
			AND p.operner2_accepted=1 AND a.status!='0'
			");	//if(a.second_opener!=0, p.operner2_accepted,p.operner1_accepted)	
		}else{
			$query=$this->db->query("SELECT a.*, p.bidderID,p.auctionID,p.is_accept_auct_training FROM tbl_auction as a INNER JOIN tbl_auction_participate as p ON a.id=p.auctionID WHERE a.auction_start_date <= NOW() AND a.auction_end_date >= NOW() AND p.bidderID='".$bidderID."'
			AND if(a.second_opener!=0, p.operner2_accepted,p.operner1_accepted) AND a.status!='0'
			");
		}
		//echo $this->db->last_query(); 
		if($query->num_rows()>0)
                {  
                  $data=array();
                foreach ($query->result() as $row){
                  $data[]=$row;
                }
		return $data;		
		}else{
		$data=0;
		return $data;	
		}
		//return false;			
			
	}
	
	function getAuctionWith10Seconds($auctionID){
		
		$bidderID		=$this->session->userdata['id'];
		if($auctionID>0){
			$query=$this->db->query("SELECT a.*, p.bidderID,p.auctionID,p.is_accept_auct_training FROM tbl_auction as a INNER JOIN tbl_auction_participate as p ON a.id=p.auctionID WHERE a.auction_start_date <= NOW() AND a.auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND p.bidderID='".$bidderID."' AND a.id='$auctionID' 
			AND p.operner2_accepted=1 AND a.status!='0' order by auction_start_date ASC, id ASC");		
		}else{
			$query=$this->db->query("SELECT a.*, p.bidderID,p.auctionID,p.is_accept_auct_training FROM tbl_auction as a INNER JOIN tbl_auction_participate as p ON a.id=p.auctionID WHERE a.auction_start_date <= NOW() AND a.auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND p.bidderID='".$bidderID."'
			AND p.operner2_accepted=1 AND a.status != '0' order by auction_start_date ASC, id ASC"); //if(a.second_opener!=0, p.operner2_accepted,p.operner1_accepted)
		}
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
		{  
		  $data=array();
		foreach ($query->result() as $row){
		  $data[]=$row;
		}
		
		return $data;		
		}else{
		$data=0;
		return $data;	
		}
		//return false;			
			
	}
	
	function getCitylist(){
		$query=$this->db->query("SELECT * from tbl_city where status=1");
		$totalRow=$query->num_rows();
		if($totalRow>0){
		$dataarr=array();
		foreach ($query->result() as $row) {
                 $dataarr[] = $row;
                }
		}else{
		 $dataarr=0;	
		}
		return  $dataarr;	
	}
	
	function payment()
	{
		$productID = $this->input->post('productID');
		$this->db->where('id',$productID);
		$this->db->update('tbl_product', array('status'=>4));	
		$auctionID=GetTitleByField('tbl_product', "id='".$productID."'", 'auctionID');
		if($auctionID){
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction', array('status'=>1,'is_payment_recived'=>1));	
		}
		$this->session->set_userdata('open_popup', true);
		return true;
	}
	
	
	function savePropertyAuction()
	{
		$productID = $this->input->post('productID');
		$this->db->where('id',$productID);
		$this->db->update('tbl_product', array('status'=>0));	
		$auctionID=GetTitleByField('tbl_product', "id='".$productID."'", 'auctionID');
		if($auctionID){
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction', array('status'=>0,'is_payment_recived'=>0));	
		}
		$this->session->set_userdata('open_popup', true);
		return true;
	}

function is_accept_tc_update(){
	$aid			=	$this->input->post('aid');
	$bidderID		=	 $this->session->userdata('id');
	$this->db->where('bidderID',$bidderID);
	$this->db->where('auctionID',$aid);
	$update=$this->db->update('tbl_auction_participate', array('is_accept_auct_training'=>1));
       if($update){
	$this->db->where('auctionID', $aid);
	$this->db->where('bidderID', $bidderID);
        $this->db->update('tbl_log_auction_participate', array('is_accept_auct_training'=>1,'is_accept_auct_training_date'=>date('Y-m-d H:i:s')));
        }
       return true;
}

function getParticipatedUsersAuction(){
	$bidderID = $this->session->userdata('id');
	$query=$this->db->query("SELECT auctionID from tbl_auction_participate where bidderID='$bidderID'");
	$totalRow=$query->num_rows();
      if($totalRow>0){
	$dataarr=array();
	foreach ($query->result() as $row) {
        $dataarr[] = $row->auctionID;
        }
	}else{
	$dataarr=0;	
	}
	return $dataarr;
}


function getSellCreatedAuction(){
	$bidderID = $this->session->userdata('id');
	$query=$this->db->query("SELECT id from tbl_auction where created_by='$bidderID' AND first_opener='$bidderID' AND auction_type='1'");
	$totalRow=$query->num_rows();
      if($totalRow>0){
	$dataarr=array();
       foreach ($query->result() as $row) {
         $dataarr[] = $row->id;
        }
       }else{
       $dataarr=0;	
       }
       return $dataarr;
}	

public function GetRegisterUserById($id){
            $this->db->where('id', $id);
            $query = $this->db->get("tbl_user_registration");
            if ($query->num_rows() > 0){
           foreach ($query->result() as $row){
                    $data = $row;
                }
                return $data;
            }
            return false;
        }
function saveTransaction(){
	$useridID = $this->session->userdata('id');
	$amount=$this->input->post('amount');   
	$billing_name=$this->input->post('billing_name');
	$billing_address= $this->input->post('billing_address'); 
	$billing_city= $this->input->post('billing_city');
	$billing_state=$this->input->post('billing_state');
	$billing_zip=$this->input->post('billing_zip'); 
	$billing_country=$this->input->post('billing_country');
	$billing_tel=$this->input->post('billing_tel'); 
	$billing_email=$this->input->post('billing_email');
	$auctionID=$this->input->post('auctionID');
	$productID=$this->input->post('productID');
	$payment_type=$this->input->post('payment_type');
	$data=array('auctionID'=>$auctionID,
				'productID'=>$productID,
				'userID'=>$useridID,
				'amount'=>$amount,
				'billing_name'=>$billing_name,
				'billing_address'=>$billing_address,
				'billing_city'=>$billing_city,
				'billing_state'=>$billing_state,
				'billing_zip'=>$billing_zip,
				'billing_country'=>$billing_country,
				'billing_tel'=>$billing_tel,
				'billing_email'=>$billing_email,
				'status'=>'0',
				'payment_type'=>$payment_type,
				'indate'=>date("Y-m-d H:i:s")
			);
		$this->db->insert('tbl_transaction',$data);
		return $this->db->insert_id();
}


function UpdateTransaction($orderid,$data){
	$this->db->where('id',$orderid);
	$this->db->update('tbl_transaction',$data);
}		
function addAuctionEmdAmout($data){
	//echo "dfasfdsadsa";
	$this->db->insert('tbl_auction_participate_emd',$data);
	//echo $this->db->last_query();
}


	
	
public function GetAuctionFees($user_type,$property_type,$fee_type,$price){
			if($user_type=='owner'){
				$this->db->where('user_type', 'bidder');
			}else{
				$this->db->where('user_type', $user_type);	
			}
            $this->db->where('property_type', $property_type);
            $this->db->where('fee_type', $fee_type);
            $this->db->where('status','1');
            $this->db->where("('$price' BETWEEN `range_from` AND range_to)");
            $query = $this->db->get("tbl_auction_fee");
			//echo $this->db->last_query();
            if ($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data = $row;
                }
                return $data->fees;
            }
            return false;
        }


	/*check bid submission time on participate time*/

	function checkParticipatetime($auctionID)
	{
		$bidderID=$this->session->userdata('id');
		$arows=$this->db->query("SELECT bid_last_date FROM tbl_auction WHERE id='$auctionID'")->row_object();
		$arows->bid_last_date;
		$currentdatetime=time();
		$bid_last_date=strtotime($arows->bid_last_date);
		if($bid_last_date<$currentdatetime)
		{
		   $this->session->set_flashdata('msg','Apply And EMD Submission Date has been expired!');
			redirect(base_url().'owner');
		}
		
	}

	function bidderviewReport($auction_id)
	{
		$bidderID=$this->session->userdata('id');
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
				$data = array();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();
			//Track Bidder View Report start
			$trackreportdata=array('event_id'=>$data[0]->eventID,
								   'auction_id'=>$auction_id,
								   'bidder_id'=>$this->session->userdata('id'),
								   'bank_id'=>$data[0]->bank_id,
								   'user_type'=>$this->session->userdata('user_type'),
								   'action_type'=>"Bidder_report",
								   'action_type_event'=>"view",
								   'ip'=>$_SERVER['REMOTE_ADDR'],
								   'status'=>'1',
								   'message'=>'Bidder has successfully viewed report',
									'indate'=>date('Y-m-d H:i:s'),
								  );
			$query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
			//Track Bidder View Report End
			//Bidder Participated
			$this->db->where('auctionID', $data[0]->id);
			$this->db->where('bidderID', $bidderID);
			$query_bidder = $this->db->get("tbl_auction_participate");
			$data_bidder=array();
			$data_FRQbidder=array();
			foreach ($query_bidder->result() as $row_bidder){
				$data_bidder[]=$row_bidder;
				$this->db->where('auctionID', $data[0]->id);
				$this->db->where('bidderID', $row_bidder->bidderID);
				$query_bidder_frq = $this->db->get("tbl_auction_participate_frq");
				
			}
			$data[0]->bidder=$data_bidder;
			
			//Auction Last Bid Details 

			$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,MAX(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id AND  b.bidderID='$bidderID' GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
			//echo $this->db->last_query();
			$data[0]->lastbidBidder=$lastbidBidder;
			$this->db->where('auctionID', $data[0]->id);
			$this->db->where('bidderID', $bidderID);
			$this->db->order_by('bid_value', 'DESC');							
			$query_bidder_bid = $this->db->get("tbl_live_auction_bid");
			//echo $this->db->last_query();die;
			$data_bidder_bid=array();
			foreach ($query_bidder_bid->result() as $row_bidder_bid)
			{
				$data_bidder_bid[]=$row_bidder_bid;
			}
			$data[0]->bidder_bid=$data_bidder_bid;
			//Auction All Bid Received 
			
			return $data;
		}
		else
		{
			$data =0;
			return $data;
		}
	}
	
	
	function viewReportPDFuser($auction_id)
	{	
		$bidderID=$this->session->userdata('id');		
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
				$data[0]->lastbidBidder=$lastbidBidder;
				//echo '<pre>';
				//print_r($data[0]);die;
				$this->db->where('auctionID',$data[0]->id);
				$this->db->where('bidderID', $bidderID);
				$this->db->order_by('bid_value', 'DESC');							
				$query_bidder_bid = $this->db->get("tbl_live_auction_bid");
				$data_bidder_bid=array();
				foreach ($query_bidder_bid->result() as $row_bidder_bid)
				{
				$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
			//Auction All Bid Received 
			
			return $data;
		}
	}		


function getLoggedInOwner()
	{
		$date = date("Y-m-d H:i:s",strtotime( '-12 seconds' )); 
		$currentDate = date("Y-m-d H:i:s"); 
		//$this->db->where('auctionid', $auctionid);    
		$this->db->where('auction_end_date >=',  $date);                   
		$this->db->where('auction_end_date <=',  $currentDate); 
        
        $this->db->order_by('auction_end_date');
        $this->db->limit(1);
        
        
        $query = $this->db->get("tbl_auction");    
        $login = 0;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) 
            {
					$login++;
            }            
        }
        return $login;
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
		  }else{

					if($dotCountValue[0] == '1')
						  {
							  $getFileExt = explode('.',$filename);
							  $getFileExt = $getFileExt[1];
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
	
	function GetAuctionOwnBidderManualBidHistoryData($auctionID){
		 $bidderID = $this->session->userdata['id'];
		 $this->db->select('*');
		 $this->db->from('tbl_live_auction_bid');
		 $this->db->where('auctionID', $auctionID);
		 $this->db->where('bidderID', $bidderID);
		 //$this->db->where('bid_type','Manual');
		 $this->db->order_by('id','DESC');
		 $this->db->group_by('bid_value');
		 $query=$this->db->get();	
		//echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }else{
			$data=0;
		}
		return $data;
	}
	
	function GetAuctionOwnBidderAutoBidHistoryData($auctionID){
		 $bidderID = $this->session->userdata['id'];
		 $this->db->select('*');
		 $this->db->from('tbl_live_auction_bid');
		 $this->db->where('auctionID', $auctionID);
		 $this->db->where('bidderID', $bidderID);
		 $this->db->where('auto_bid !=','null');
		 $this->db->order_by('id','DESC');
		 $query=$this->db->get();	
		//echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }else{
			$data=0;
		}
		return $data;
	}
	
	public function GetAuctionDocuments($auctionId)
    {
		$this->db->select('*');
		$this->db->from('tbl_auction_document as ad');
		$this->db->join('tblmst_upload_document_field as ud','ud.upload_document_field_id=ad.upload_document_field_id and ud.status=1','left');
		$this->db->where('ad.auction_id',$auctionId);
		$qry = $this->db->get();
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		else
		{
			return array();
		}
	}
	
	
	public function get_tenderfee_payment($paymentId) 
    {
		$resArr = array();
		$this->db->select("p.id,p.auctionID,p.payu_amount,p.type,r.user_type,r.authorized_person,r.first_name,r.email_id,r.mobile_no");
		$this->db->where('p.id', $paymentId);
		$this->db->join('tbl_user_registration as r','r.id = p.bidderID');
		$query = $this->db->get("tbl_payment as p");
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			$res = $query->result();
			foreach($res as $row)
			{
				$resArr = $row; 
			}
		}
		return $resArr;
	}
	
	
	public function emd_participation_payment($data)
	{	
		$auctionId = $data['auction_id'];
		$this->db->where('id',$auctionId);
		$this->db->where('status',1);
		$aQry = $this->db->get('tbl_auction');
		
		if($aQry->num_rows()>0)
		{
			
			$bidderId=$this->session->userdata['id'];
			$this->db->select('usr.*,cn.country_name,st.state_name, cy.city_name');
			$this->db->from('tbl_user_registration as usr');
			$this->db->join('tbl_country as cn','cn.id=usr.country_id','left');
			$this->db->join('tbl_state as st','st.id=usr.state_id','left');
			$this->db->join('tbl_city as cy','cy.id=usr.city_id','left');
			$this->db->where('usr.id',$bidderId);
			$this->db->where('usr.status',1);
			$bQry = $this->db->get();
			if($bQry->num_rows()>0)
			{
				
				$date = date('Y-m-d');
				$bidderData = $bQry->result_array();
				if($bidderData[0]['user_type']=='builder')
				{
					$bidderName =$bidderData[0]['authorized_person'];
				}else{
					$bidderName = $bidderData[0]['first_name'].' '.$bidderData[0]['last_name'];
				}
							
				
				//Start:comment these lines when goes online
				//$emd_amt = 0.80;
				//$participation_fee = 0.20;
				
				//End:comment these lines when goes online
                                
				//Start: uncomment these lines when goes online
				$emd_amt = $this->input->post('amount');				
				//End: uncomment these lines when goes online		
						 
				$total_fee = $emd_amt;
				
				$refNo = 'Topup';
				$bidderMobile = $bidderData[0]['mobile_no'];
				$bidderEmail = $bidderData[0]['email_id'];
				$bidderAddress = $bidderData[0]['address1'];
				$bidderCountry = $bidderData[0]['country_name'];
				$bidderState = $bidderData[0]['state_name'];
				$bidderCity = $bidderData[0]['city_name'];
				$bidderZip = $bidderData[0]['zip'];
				
						
					
					
					$pData = array(
							'bidder_id'=>$bidderId,
							'auction_id'=>$auctionId,
							'control_number'=>time(),
							'payment_status'=>'pending',
							'bidder_IP'=>$_SERVER['REMOTE_ADDR'],
							'date_created'=>date('Y-m-d H:i:s')
					);
					
					$this->db->insert('tbl_jda_payment_log',$pData);
					$payment_log_id = $this->db->insert_id();
					
						
					$controlNumber = time();	  
				    $redirect_url = base_url().'owner/update_payment_response/'.$payment_log_id;	
				    $cancel_url = base_url().'owner/cancel_payment_request/'.$payment_log_id;	
				    $ccav_req_data = array(
				    'tid'=>$controlNumber,
				    'merchant_id'=>CCAV_MERCHANT_ID_AUCTION_FEE,
				    'order_id'=>$payment_log_id,
				    'amount'=>$total_fee,
				    'currency'=>'INR',
				    'redirect_url'=>$redirect_url,
				    'cancel_url'=>$cancel_url,
				    'language'=>'EN',
				    'billing_name'=>$bidderName,
				    'billing_address'=>$bidderAddress,
				    'billing_city'=>$bidderCity,
				    'billing_state'=>$bidderState,
				    'billing_zip'=>$bidderZip,
				    'billing_country'=>$bidderCountry,
				    'billing_tel'=>$bidderMobile,
				    'billing_email'=>$bidderEmail,
				    'merchant_param1'=>$controlNumber,
				    'merchant_param2'=>round($emd_amt),
				    'merchant_param3'=>round($participation_fee)
				    );
									
					//print_r($ccav_req_data);die;
					
					$updateArr = array('control_number'=>$controlNumber,'payment_request'=>json_encode($ccav_req_data),'date_modified'=>date('Y-m-d H:i:s'));
					$this->db->where('payment_log_id',$payment_log_id);
					$this->db->update('tbl_jda_payment_log',$updateArr);
					//echo $this->db->last_query();die;

	
					$merchant_data = '';
					$working_key = CCAV_WORKING_KEY_AUCTION_FEE; //Shared by CCAVENUES
					$access_code = CCAV_ACCESS_CODE_AUCTION_FEE; //Shared by CCAVENUES
					
			
					foreach ($ccav_req_data as $key => $value){
						$merchant_data.=$key.'='.$value.'&';
					}
					
					if(function_exists(encrypt))
					{
						$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
					}
					else
					{
						return $msg ='encryptFunction';
					}
					
					if(IS_PAYMENT_GATEWAY_OFF===TRUE)
					{
						$payment_response = '{"order_id":"'.$payment_log_id.'","tracking_id":"308005008436","bank_ref_no":"1555917268744","order_status":"Success","failure_message":"","payment_mode":"Net Banking","card_name":"AvenuesTest","status_code":"null","status_message":"Y","currency":"INR","amount":"2991.30","billing_name":"'.$bidderName.'","billing_address":"'.$bidderAddress.'","billing_city":"'.$bidderCity.'","billing_state":"'.$bidderState.'","billing_zip":"'.$bidderZip.'","billing_country":"India","billing_tel":"'.$bidderMobile.'","billing_email":"'.$bidderEmail.'","delivery_name":"'.$bidderName.'","delivery_address":"'.$bidderAddress.'","delivery_city":"'.$bidderCity.'","delivery_state":"'.$bidderState.'","delivery_zip":"'.$bidderZip.'","delivery_country":"India","delivery_tel":"'.$bidderMobile.'","merchant_param1":"'.$controlNumber.'","merchant_param2":"2950","merchant_param3":"0","merchant_param4":"","merchant_param5":"","vault":"N","offer_type":"null","offer_code":"null","discount_value":"0.0","mer_amount":"2950.00","eci_value":"null","retry":"N","response_code":"0","billing_notes":"","trans_date":"'.date('d').'\/'.date('m').'\/'.date('Y').' '.date('H').':'.date('i').':'.date('s').'","bin_country":"","trans_fee":"35.0","service_tax":"6.3\u0005\u0005\u0005\u0005\u0005"}';
						
						
						$rData = array(
							'payment_response'=>$payment_response,
							'payment_status'=>'success',
							'date_modified'=>date('Y-m-d H:i:s')
						);
						
						
						$this->db->where('payment_log_id',$payment_log_id);
						$this->db->where('control_number',$controlNumber);
						$this->db->update('tbl_jda_payment_log',$rData);	
						//echo $this->db->last_query();die;	
						
						
						//return $responseArr['order_status'];
						$this->session->set_flashdata('message','Bank Processing Fee Paid Successfully !<br>');	
						redirect("/owner/auction_participate/".$auctionId);
					}
					else
					{
						if($controlNumber)
						{										
							echo $form = '<form method="post" name="redirect" action="'.CCAV_PAYMENT_URL_AUCTION_FEE.'"> 										
											<input type=hidden name=encRequest value="'.$encrypted_data.'">
											<input type=hidden name=access_code value="'.$access_code.'">										
											</form>';
							echo '<script type="text/javascript">
											var form = document.forms[0];
											form.submit();
								</script>';
						}
						else{
							return $msg ='error';
						}
					}
				
			}
		}
	}
	
	public function update_payment_response($payment_log_id)
	{	
		
		$workingKey=CCAV_WORKING_KEY_AUCTION_FEE;		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);

		$data = array();
		for($i = 0; $i < $dataSize; $i++) 
		{
			$information=explode('=',$decryptValues[$i]);			
			$data[$information[0]] = $information[1];
			
		}
		
		/*
		echo "<pre>";
		print_r($data);die;
		*/
		
		$this->db->where('payment_log_id', $data['order_id']);
		$ckQry = $this->db->get('tbl_jda_payment_log');
		$ckRes = $ckQry->result_array();
		
		
		if($ckRes[0]['payment_log_id'] != $data['order_id'])
		{
			return 'Failure';
		}
		
		
		$whrArr = array(
				'payment_log_id'=>$data['order_id']				
		);
		$this->db->where($whrArr);
		$pQry = $this->db->get('tbl_jda_payment_log');
		$rows= $pQry->result_array();
		
		$responseArr = $data;
	
		
		//echo $responseArr->ChallanAmount;die;
		if($responseArr['order_status']=='Success')
		{
			$status = 'success';
			$this->session->set_flashdata('message','Bank Processing Fee Paid Successfully !<br>');	
		}
		else if($responseArr['order_status']=='Awaited')
		{
			$status = 'awaited';
			$this->session->set_flashdata('message_new','Bank Processing Fee Payment Awaited!');	
		}
		else
		{
			//$status = 'success'; //comment when goes live
			
			$status = 'failure'; //uncomment when goes live
			
			if($status == 'failure')
			{
				$this->session->set_flashdata('message_new','Bank Processing Fee Payment Failure ! Please try again<br>');	
				
				$dataAP['payment_verifier_accepted'] = NULL;
				$dataAP['payment_verifier_comment'] = NULL;
				$dataAP['payment_move_to_opener2'] = 0;
				$dataAP['payment_verifier_accepted_date'] = NULL;
				$dataAP['modify_date']= date('Y-m-d H:i:s');
				$this->db->where('bidderID',$rows[0]['bidder_id']);
				$this->db->where('auctionID',$rows[0]['auction_id']);
				$this->db->update('tbl_auction_participate',$dataAP);	
				$insertedid_id	=1;		
				
				
				$this->db->where('bidderID',$rows[0]['bidder_id']);
				$this->db->where('auctionID',$rows[0]['auction_id']);
				$pQry = $this->db->get('tbl_auction_participate');
				$rowsAP = $pQry->result_array();					
				$dataAP1 = $rowsAP[0];
				unset($dataAP1['id']);
				unset($dataAP1['pstatus']);
				unset($dataAP1['dsc_verified_status']);
				$data1['final_submit_date'] = $indate;
				$data1['auction_participate_id'] = $rowsAP[0]['id'];
				$this->db->where('bidderID',$bidderid);
				$this->db->where('auctionID',$auction_id);
				$this->db->insert('tbl_log_auction_participate',$dataAP1);	
			}
			
		}
		
		$rData = array(
			'payment_response'=>json_encode($responseArr),
			'payment_status'=>$status,
			'date_modified'=>date('Y-m-d H:i:s')
		);
		
		
		$this->db->where('payment_log_id',$data['order_id']);
		$this->db->where('control_number',$data['merchant_param1']);
		$this->db->update('tbl_jda_payment_log',$rData);	
		//echo $this->db->last_query();die;	
		
		
		//return $responseArr['order_status'];
		
		redirect("/owner/auction_participate/".$rows[0]['auction_id']);
		
	}
	
	public function cancel_payment_request($payment_log_id)
	{
		$workingKey=CCAV_WORKING_KEY_AUCTION_FEE;		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);

		$data =array();
		for($i = 0; $i < $dataSize; $i++) 
		{
			$information=explode('=',$decryptValues[$i]);			
			$data[$information[0]] = $information[1];
			
		}
		
		
		$whrArr = array(
			'payment_log_id'=>$data['order_id']			
		);
		$this->db->where($whrArr);
		$pQry = $this->db->get('tbl_jda_payment_log');
		$rows= $pQry->result_array();
		
		$controlNumber = $data['tid'];
			
		$response = $data;
				
		
		$status = 'cancel'; 
		$rData = array(
			'payment_response'=>json_encode($response),
			'payment_status'=>$status,
			'date_modified'=>date('Y-m-d H:i:s')
		);
		
		
		$this->db->where('payment_log_id',$data['order_id']);
		$this->db->where('control_number',$data['merchant_param1']);
		$this->db->update('tbl_jda_payment_log',$rData);	
		
		$this->session->set_flashdata('message_new','Bank Processing Fee Payment Failure ! Please try again<br>');	
		redirect("/owner/auction_participate/".$rows[0]['auction_id']);
		
		
	}
	
	
	
	public function emd_participation_payment_old($data)
	{
		
		$auctionId = $data['auction_id'];
		$this->db->where('id',$auctionId);
		$this->db->where('status',1);
		$aQry = $this->db->get('tbl_auction');
		
		if($aQry->num_rows()>0)
		{
			
			$bidderId=$this->session->userdata['id'];
			$this->db->where('id',$bidderId);
			$this->db->where('status',1);
			$bQry = $this->db->get('tbl_user_registration');
			if($bQry->num_rows()>0)
			{
				$date = date('Y-m-d');
				$bidderData = $bQry->result_array();
				$bidderName = $bidderData[0]['first_name'].' '.$bidderData[0]['last_name'];
				$auctionData = $aQry->result_array();
				$cValidDate = date('Y-m-d H:i:s',strtotime($auctionData[0]['bid_last_date']));
				$deptId = $auctionData[0]['department_id'];
				
				//Start:comment these lines when goes online
				/*$emd_amt = 0.80;
				$participation_fee = 0.20;
				*/
				//End:comment these lines when goes online
                                
				//Start: uncomment these lines when goes online
				$emd_amt = $auctionData[0]['emd_amt'];
				$participation_fee = $auctionData[0]['tender_fee'];
                                //End: uncomment these lines when goes online
				 
				$total_fee = $emd_amt+$participation_fee;
				$refNo = $auctionData[0]['reference_no'];
				$bidderMobile = $bidderData[0]['mobile_no'];
				$bidderEmail = $bidderData[0]['email_id'];
				$bidderAddress = $bidderData[0]['address1'];
				
				$this->db->where('bidder_id',$bidderId);
				$this->db->where('auction_id',$auctionId);
				$this->db->where('payment_status','success');
				$chkQry = $this->db->get('tbl_jda_payment_log');
				//echo $this->db->last_query();die;
				if($chkQry->num_rows()>0)
				{
					
					return $msg ='alredyPaid';
				}
				else
				{
					$pData = array(
							'bidder_id'=>$bidderId,
							'auction_id'=>$auctionId,
							'control_number'=>time(),
							'payment_status'=>'pending',
							'bidder_IP'=>$_SERVER['REMOTE_ADDR'],
							'date_created'=>date('Y-m-d H:i:s')
					);
					
					$this->db->insert('tbl_jda_payment_log',$pData);
					$payment_log_id = $this->db->insert_id();
					
					
					$indate=date('Y-m-d H:i:s');
					   
					$data = array('bidderID'=>$bidderId ,
						'tenderfeeID'=>$payment_log_id,
						'auctionID'=>$auctionId ,
						'paymentStatus'=>'pending',
						'sendTime'=>$indate ,
						'ip'=>$_SERVER['REMOTE_ADDR'] ,
						'type'=>'participate',	
						'payu_amount'=>$participation_fee,					
						'payu_email'=>$bidderEmail,
						'supply_place'=>'',
						'delivery_address'=>'',
						'gst_available'=>'',
						'gst_no'=>null
					);
												
							$this->db->insert('tbl_payment',$data); 
							//echo $this->db->last_query();die;
							$insert_id1=$this->db->insert_id();
					
					
					
					redirect('/payment2/index?txnid='.base64_encode($insert_id1));die;
					
				}
			}
		}
	}
	
	
	
	public function update_payment_response_old($payment_log_id)
	{	
		
		$whrArr = array(
				'payment_log_id'=>$payment_log_id				
		);
		$this->db->where($whrArr);
		$pQry = $this->db->get('tbl_jda_payment_log');
		$rows= $pQry->result_array();
		
		$controlNumber = $rows[0]['control_number'];
		$url = PAYMENT_GET_URL.$controlNumber;
				
		$headers = array(
			"Authorization: Basic NjM6Q2gjOVktM3I=",
		);
	
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		// Following line is compulsary to add as it is:	
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		
		$response = $data;
		
		$responseArr = json_decode($data);
		
		 
		/*
		echo "<pre>";
		$response = json_decode($data);
		print_r($response);
		echo "</pre>";die;
		*/
		
		//echo $responseArr->ChallanAmount;die;
		if($responseArr->IsFullPaymentReceived)
		{
			$status = 'success';
		}
		else
		{
			//$status = 'success'; //comment when goes live
			
			$status = 'failure'; //uncomment when goes live
			
			if($status == 'failure')
			{
				$dataAP['payment_verifier_accepted'] = NULL;
				$dataAP['payment_verifier_comment'] = NULL;
				$dataAP['payment_move_to_opener2'] = 0;
				$dataAP['payment_verifier_accepted_date'] = NULL;
				$dataAP['modify_date']= date('Y-m-d H:i:s');
				$this->db->where('bidderID',$rows[0]['bidder_id']);
				$this->db->where('auctionID',$rows[0]['auction_id']);
				$this->db->update('tbl_auction_participate',$dataAP);	
				$insertedid_id	=1;		
				
				
				$this->db->where('bidderID',$rows[0]['bidder_id']);
				$this->db->where('auctionID',$rows[0]['auction_id']);
				$pQry = $this->db->get('tbl_auction_participate');
				$rowsAP = $pQry->result_array();					
				$dataAP1 = $rowsAP[0];
				unset($dataAP1['id']);
				unset($dataAP1['pstatus']);
				unset($dataAP1['dsc_verified_status']);
				$data1['final_submit_date'] = $indate;
				$data1['auction_participate_id'] = $rowsAP[0]['id'];
				$this->db->where('bidderID',$bidderid);
				$this->db->where('auctionID',$auction_id);
				$this->db->insert('tbl_log_auction_participate',$dataAP1);	
			}
			
			
		}
		
		$rData = array(
			'payment_response'=>$response,
			'payment_status'=>$status,
			'date_modified'=>date('Y-m-d H:i:s')
		);
		
		
		$this->db->where('payment_log_id',$payment_log_id);
		$this->db->where('control_number',$controlNumber);
		$this->db->update('tbl_jda_payment_log',$rData);	
			
		
		$this->db->where('bidderID',$rows[0]['bidder_id']);
		$this->db->where('auctionID',$rows[0]['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_emd');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $rows[0]['bidder_id'],
						'auctionID' => $rows[0]['auction_id'],
						'amount' => $responseArr->ChallanAmount,
						'payment_status' => $status
						
					);
		
		if($qry->num_rows() > 0)
		{
			$record['updatedate'] = $date;
			$this->db->where('bidderID',$rows[0]['bidder_id']);
			$this->db->where('auctionID',$rows[0]['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_emd',$record);
			
		}
		else
		{
			$record['indate'] = $date;
			
			$qry = $this->db->insert('tbl_auction_participate_emd',$record);
		}
		
	}
	
	public function cancel_payment_request_old($payment_log_id)
	{
		$whrArr = array(
				'payment_log_id'=>$payment_log_id				
		);
		$this->db->where($whrArr);
		$pQry = $this->db->get('tbl_jda_payment_log');
		$rows= $pQry->result_array();
		
		$status = 'cancel'; 
		$rData = array(
			'payment_response'=>'',
			'payment_status'=>$status,
			'date_modified'=>date('Y-m-d H:i:s')
		);
		
		
		$this->db->where('payment_log_id',$payment_log_id);
		$this->db->update('tbl_jda_payment_log',$rData);	
		$this->db->last_query();
		
		/*
		$this->db->where('bidderID',$rows[0]['bidder_id']);
		$this->db->where('auctionID',$rows[0]['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_emd');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $rows[0]['bidder_id'],
						'auctionID' => $rows[0]['auction_id'],
						'amount' => $responseArr->ChallanAmount,
						'payment_status' => 'failure'
						
					);
		
		if($qry->num_rows() > 0)
		{
			$record['updatedate'] = $date;
			$this->db->where('bidderID',$rows[0]['bidder_id']);
			$this->db->where('auctionID',$rows[0]['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_emd',$record);
			
		}
		else
		{
			$record['indate'] = $date;
			
			$qry = $this->db->insert('tbl_auction_participate_emd',$record);
		}*/
	}
       /*Added By Aziz #########################*/ 
        function emdDetailPopupData($bidderID, $auctionID){
            //emd fee
            $this->db->where('auctionID', $auctionID);
            $this->db->where('bidderID', $bidderID);
            $query_emd = $this->db->get("tbl_auction_participate_emd");
            return $query_emd->result();
        }
        /*Added By Aziz #########################*/ 
	function jdaPaymentLogPopupData($bidderID,$auctionID){
           
            $this->db->where('auction_id', $auctionID);
            $this->db->where('bidder_id', $bidderID);
            $this->db->order_by('payment_log_id','DESC');
            $this->db->limit(1);
            $pQry = $this->db->get("tbl_jda_payment_log");            
            return $pQry->result();
	}
        function docDetailPopupData($bidderID,$auctionID)
	{
		//doc fee
		$data_doc=array();
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_doc = $this->db->get("tbl_auction_participate_doc");
		foreach ($query_doc->result() as $row_doc)
		{
		$data_doc[]=$row_doc;
		}
		return $data_doc;
	}
	
	function getEmdDoc($bidderID,$auctionID)
	{
		$data_doc=array();
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$this->db->where('status', 1);
		$query_doc = $this->db->get("tbl_auction_emd_doc");
		foreach ($query_doc->result() as $row_doc)
		{
		$data_doc[]=$row_doc;
		}
		return $data_doc;
	}
		
	function getUtrById($bidderID,$auctionID,$utrType)
	{
		$data_doc=array();
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$this->db->where('utr_type', $utrType);
		$this->db->where('status', 1);
		$query_doc = $this->db->get("tbl_auction_bidder_utr_no");
		foreach ($query_doc->result() as $row_doc)
		{
		$data_doc[]=$row_doc;
		}
		return $data_doc;
	}
	
	function getAllAssetsType()
    {
		$this->db->where('status',1);
		$query = $this->db->get('tbl_category');
		 
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
	}
    
    function getProperty()
    {           
		$this->db->select("a.PropertyDescription, a.id, a.reference_no");
	   
		$this->db->from('tbl_auction as a');
		$this->db->where('a.status IN(1,3,4)');				
        $this->db->where('a.auction_end_date >= NOW()');//Added by Azizur Rahman
        if(isset($_GET['search']) && $_GET['search']!='')
		{
			$pt = trim(str_replace("'","''",$_GET['search']));			
			$this->db->like('a.PropertyDescription', $pt);
		}
		if($_GET['assetsTypeId']>0)
		{
			
			$this->db->join('tbl_category as c','c.id=a.category_id','inner');
			$this->db->where('c.id',$_GET['assetsTypeId']);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
    }

	function getAuctionCityLocation()
	{
		$this->db->select("a.city,a.reference_no as location,city.city_name",false)
		->from('tbl_auction as a')	
		->join('tbl_city as city','city.id=a.city','left')
		->where('a.status IN(1)')
		->where('auction_end_date >= NOW()');

		$query = $this->db->get('');

		$data = array();
		foreach($query->result() as $row)
		{
			//echo $row->city_name;die;
			$data['city'][$row->city] = $row->city_name;
			$data['location'][$row->location] = $row->location;
		}
		return $data;
	}
	

	function getShortlistedAuctionsCount($catId=0)
	{
		$bidderId=$this->session->userdata['id'];
		$this->db->select("a.id",false)
		->from('tbl_auction as a')				
		//->join('tbl_category as c','c.id=a.subcategory_id','left')
		->join('tbl_auction_bidder_fav as f','f.auctionID=a.id','left')
		->where('f.bidderID',$bidderId);
		if($catId==1)
		{
			$this->db->where('a.category_id',1);
		}
		if($catId==2)
		{
			$this->db->where('a.category_id',2);
		}
		if($catId==3)
		{
			$this->db->where('a.category_id',3);
		}
		$this->db->where('f.is_fav', 1);
		$this->db->where('a.status IN(1)');
		$this->db->where('auction_end_date >= NOW()');

		$query = $this->db->get('');
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		else
		{
			return 0;
		}
	}


	function allShortlistedAuctionDatatable($bankIdbyshortname='')
    {           		
		
		$bidderId=$this->session->userdata['id'];

		$_POST['sColumns'] = "a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id";
		
		$this->datatables->select("a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID",false)
		->from('tbl_auction as a')				
		//->join('tbl_category as c','c.id=a.subcategory_id','left')
		->join('tbl_auction_bidder_fav as f','f.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_city as city','city.id=a.city','left')
		->where('f.bidderID',$bidderId)
		->where('f.is_fav', 1)
		->where('a.status IN(1)')
		->where('auction_end_date >= NOW()');
		$this->db->order_by('a.bid_last_date','ASC');

		return $this->datatables->generate();
		//echo $this->db->last_query();die;
    }

	function propertyShortlistedAuctionDatatable($bankIdbyshortname='')
    {           		
		
		$bidderId=$this->session->userdata['id'];

		$_POST['sColumns'] = "a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id";
		
		$this->datatables->select("a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID",false)
		->from('tbl_auction as a')				
		//->join('tbl_category as c','c.id=a.subcategory_id','left')
		->join('tbl_auction_bidder_fav as f','f.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_city as city','city.id=a.city','left')
		->where('f.bidderID',$bidderId)
		->where('f.is_fav', 1)
		->where('a.category_id',1)
		->where('a.status IN(1)')
		->where('auction_end_date >= NOW()');
		$this->db->order_by('a.bid_last_date','ASC');

		return $this->datatables->generate();
		//echo $this->db->last_query();die;
    }

	function vehicleShortlistedAuctionDatatable($bankIdbyshortname='')
    {           		
		
		$bidderId=$this->session->userdata['id'];

		$_POST['sColumns'] = "a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id";
		
		$this->datatables->select("a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID",false)
		->from('tbl_auction as a')				
		//->join('tbl_category as c','c.id=a.subcategory_id','left')
		->join('tbl_auction_bidder_fav as f','f.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_city as city','city.id=a.city','left')
		->where('f.bidderID',$bidderId)
		->where('f.is_fav', 1)
		->where('a.status IN(1)')
		->where('a.category_id',2)
		->where('auction_end_date >= NOW()');
		$this->db->order_by('a.bid_last_date','ASC');

		return $this->datatables->generate();
		//echo $this->db->last_query();die;
    }

	function otherShortlistedAuctionDatatable($bankIdbyshortname='')
    {           		
		$bidderId=$this->session->userdata['id'];

		$_POST['sColumns'] = "a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id";
		
		$this->datatables->select("a.id,b.name,a.PropertyDescription,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID",false)
		->from('tbl_auction as a')				
		//->join('tbl_category as c','c.id=a.subcategory_id','left')
		->join('tbl_auction_bidder_fav as f','f.auctionID=a.id','left')
		->join('tbl_bank as b','b.id=a.bank_id','left')
		->join('tbl_city as city','city.id=a.city','left')
		->where('f.bidderID',$bidderId)
		->where('f.is_fav', 1)
		->where('a.status IN(1)')
		->where('a.category_id',3)
		->where('auction_end_date >= NOW()');
		$this->db->order_by('a.bid_last_date','ASC');

		return $this->datatables->generate();
		//echo $this->db->last_query();die;
    }

	
}

?>
