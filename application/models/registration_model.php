<?php
class Registration_model extends CI_Model { 
	private $path = 'public/uploads/userdoc/';
	private $userdoc = 'public/uploads/userdoc/';
            private $rotations = 0;
    
	function __construct(){
		parent::__construct();
		$this->load->database();
       }
       public function userchecklogout(){
		   
		   $sessionValueEmpty = true;		
			$user_type = $this->session->userdata('user_type');
            $userid = $this->session->userdata('id');
            $this->db->select('user_sess_val');
            $this->db->where('id',$userid);
           if($this->session->userdata('table_session') == 'registration_tb')
            {
				$query=$this->db->get('tbl_user_registration');
			}
			else
			{
				$query=$this->db->get('tbl_user');
			}
            $row=$query->result();
            if(!empty($row)){
                   
                    $session_id = $this->session->userdata('session_id_user');
                   if($row[0]->user_sess_val !=  $session_id){
					   $sessionValueEmpty = false;
                    }
            }
            
            
             if($this->session->userdata('id'))
             {
			
				 if($this->session->userdata('table_session') == 'registration_tb' && $sessionValueEmpty)
				 {
					$this->db->where('id', $this->session->userdata('id'));
					$this->db->update('tbl_user_registration', array('user_sess_val'=>'')); 
				 }
				 if($this->session->userdata('table_session') == 'banker_tb' && $sessionValueEmpty)
				 {
					$this->db->where('id', $this->session->userdata('id'));
					$this->db->update('tbl_user', array('user_sess_val'=>'')); 
				 }
				
				$query = $this->db->query("select max(id) as id FROM tbl_user_log as foo where foo.user_id='".$this->session->userdata('id')."' ",false);
				$row=$query->result();
				if($row[0]->id)
				{
					$query = $this->db->query("UPDATE tbl_user_log SET logout_datetime= '".date('Y-m-d H:i:s',time())."' where id = '".$row[0]->id."'",false);
				}
            return $query;
             }
             return 0;
          }
	 public function userchecklogin($userID,$usertype,$bankertype,$email_id){
		 //echo $email_id;die;
             if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
                 $remote_addr = "REMOTE_ADDR_UNKNOWN";
                 }
             if( ($browser = $_SERVER['HTTP_USER_AGENT']) == '') {
                  $browser = "HTTP_USER_AGENT_UNKNOWN";
                 }       
          $data=array(
                    'user_id'=>$userID,
                    'email_id'=>$email_id,
                    'user_type'=>$usertype,
                    'user_type_main'=>$bankertype,
                    'browser_type'=>$browser,
                    'login_datetime'=>date('Y-m-d H:i:s',time()),
                    'ip_address'=>$remote_addr,
                   );  
                   //print_r($data);die;
         $this->db->insert('tbl_user_log',$data);
           return $data;
        }
	
	public function user_block_attempt() 
	{	$username=$this->input->post('user_name');
		$this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		//echo $this->db->last_query();die;		
		$row=$query->result();
                $numRow=$query->num_rows();
                if($numRow>0)
                {    
                        $userID = $row[0]->id;
                }else{
                        $userID=0;
                       }
			 
		
		if($userID > 0)
		{
			$user_id = $userID;
		}
		$data = array(
				   'userID'=>$user_id ,
				   'email_id'=>$username ,
				   'user_type'=>'bidder' ,
				   );
				   
				$data['indate']=date('Y-m-d H:i:s');
				$this->db->insert('tbl_user_block',$data);
				//echo $this->db->last_query();die;
				return $data;
    }          
    
    
    public function block_get_usertype(){
		$username=$this->input->post('user_name');
		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
                $this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
                $numRow=$query->num_rows();
                if($numRow>0)
                {    
                        $numRow = trim($row[0]->user_type);
                }else{
                        $numRow=0;
                       }
			 
		return $numRow;
	}
	
	public function block_get_user_failattempt_count()
	{
		$username=$this->input->post('user_name');
		$query = $this->db->query("select * from tbl_user_block where email_id = '".$username."' AND user_type = 'bidder' AND DATE(indate) = CURRENT_DATE",false);
		$row=$query->result();
        
        $numRow=$query->num_rows();
        if($numRow>0)
        {    
                $numRow = $numRow;
        }
        else
        {
                $numRow=0;
        }		 
		return $numRow;
	}
	
	public function user_block_id()
	{
		$username=$this->input->post('user_name');
		$currentDate = date('Y-m-d H:i:s');
		//$data=array('status'=>9);
		//$data=array('blocked_time'=>$currentDate);
		//$this->db->where('email_id',$username);
		
		//$this->db->update('tbl_user_registration',$data);
		
		$query = $this->db->query("UPDATE tbl_user_registration SET status= '9',blocked_time = '".$currentDate."' where email_id = '".$username."'",false);
		
		return true;
	}
	
	
	public function checkuserblocked(){
		$username=$this->input->post('user_name');
        $this->db->where('email_id', $username);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
			$numRow=$query->num_rows();
			if($numRow > 0)
			{    
				$status=$row[0]->status;
			}
		return $status;
	}
			/********** End: User Block Attempt ********/

	public function checkuserblocked_banker(){
		$user_id=$this->input->post('user_id');		
		$this->db->where('user_id', $user_id);
		$this->db->from('tbl_user');
		$query = $this->db->get();
		$row=$query->result();
			$numRow=$query->num_rows();
			if($numRow > 0)
			{    
				$status=$row[0]->status;
			}
		return $status;
	}
	
	
	public function block_get_usertype_banker(){
		$username=$this->input->post('user_name');
		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
		$this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->from('tbl_user');
		$query = $this->db->get();
		$row=$query->result();
				$numRow=$query->num_rows();
				if($numRow>0)
				{    
						$numRow = trim($row[0]->user_type);
				}else{
						$numRow=0;
					   }
			 
		return $numRow;
	}
	
	public function user_block_attempt_banker() 
	{	
		
		$username=$this->input->post('user_name');
		
		$this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->from('tbl_user');
		$query = $this->db->get();
		$row=$query->result();
				$numRow=$query->num_rows();
				if($numRow>0)
				{    
						$userID = $row[0]->id;
				}else{
						$userID=0;
					   }
			 
		
		if($userID > 0)
		{
			$user_id = $userID;
		}
		
		$data = array(
					'userID'=>$user_id ,
					'email_id'=>$username ,
					'user_type'=>'banker' ,
					);
						$data['indate']=date('Y-m-d H:i:s');
						$this->db->insert('tbl_user_block',$data);
						return $data;
	} 
	
	
	public function block_get_user_failattempt_count_banker()
	{
		$username=$this->input->post('user_name');
		$query = $this->db->query("select * from tbl_user_block where email_id = '".$username."' AND user_type = 'banker' AND DATE(indate) = CURRENT_DATE",false);
		$row=$query->result();
		
		$numRow=$query->num_rows();
		if($numRow>0)
		{    
				$numRow = $numRow;
		}
		else
		{
				$numRow=0;
		}		 
		return $numRow;
	}
	
	public function user_block_id_banker()
	{
		$username=$this->input->post('user_name');
		$currentDate = date('Y-m-d H:i:s');
		$query = $this->db->query("UPDATE tbl_user SET status= '9',blocked_time = '".$currentDate."' where email_id = '".$username."'",false);
		
		//$data=array('status'=>'9');
		//$data=array('blocked_time'=>$currentDate);
		//$this->db->where('email_id',$username);
		
		//$this->db->update('tbl_user',$data);
		return true;
	}
	
     /********************************** End : All User Block Attempt ***************/       
                        
        public function save_step_first() {	
			$savestatus=0;
			$insert_id=0;
			$id = $this->input->post('id');
			$register_as = $this->input->post('register_as');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$mobile_no = $this->input->post('mobile');
			$email_id = $this->input->post('email');
			$password_new = $this->input->post('password');
			$password=hash("sha256", $password_new); 
			$city = $this->input->post('city');
			$state = $this->input->post('state');
			$country = $this->input->post('country');
			$fathers_husband_name = $this->input->post('fathers_husband_name');
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$zipcode = $this->input->post('zipcode');
			$pan_form_16 = $this->input->post('pan_form-16');
			//new fields
			$organisation_name = $this->input->post('organisation_name');
			$authorised_person = $this->input->post('authorised_person');
			$designation = $this->input->post('designation');
			$phone_number = $this->input->post('phone_number');
			$fax_number = $this->input->post('fax_number');
			$gst_no = $this->input->post('gst_no');
			$bank_id = $this->input->post('bank_id');
			$account_holder_name = $this->input->post('account_holder_name');
			$account_type = $this->input->post('account_type');
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			$indate=date('Y-m-d H:i:s');
				   
		    if($pan_form_16=='form-16')
			{
				if($_FILES['form16']['name']){
					$documentName=$this->uploaduserdoc('form16');
					if($documentName['status']!='0'){
					 $documentName= $documentName['file_name'];  
					 }else{
					 $savestatus=1;
					 $this->session->set_flashdata('msg',$documentName['error']);
					 }
				}
			}else{
			$documentName = $this->input->post('pan_number');
			}
			//organisation -->2 individual 1
			$status=($register_as=='builder')?'2':'1';
					$status='0';
			$data = array(          
						'register_as'=>$register_as ,
						'user_type'=>$register_as ,
						'first_name'=>$first_name ,
						'last_name'=>$last_name ,
						'mobile_no'=>$mobile_no ,
						'user_id'=>$user_id ,
						'password'=>$password,	
						'email_id'=>$email_id,					
						'city_id'=>$city,					
						'state_id'=>$state,
						'country_id'=>$country,					
						'address2'=>$address2,					
						'address1'=>$address1,					
						'father_name'=>$fathers_husband_name,					
						'document_type'=>$pan_form_16,					
						'document_no'=>$documentName,
						//new fields
						'organisation_name'=>$organisation_name,
						'authorized_person'=>  $authorised_person,
						'designation'=> $designation,
						'phone_no'=> $phone_number,
						'zip'=> $zipcode,
						'fax'=> $fax_number,
						'indate'=>$indate,
						'gst_no'=>$gst_no,
						'bank_id'=> $bank_id,
						'account_holder_name'=> $account_holder_name,
						'account_type'=> $account_type,
						'account_number'=> $account_number,
						'ifsc_code'=> $ifsc_code,
						//'status'=>$status,
						'status'=>'1', // Remove Before Live (Set default active)
						'verify_status'=>'1'  // Remove Before Live (Set default active)
						);
					   if($savestatus==0){
							//insert data in main user registration table				
							$this->db->insert('tbl_user_registration',$data); 
							$insert_id=$this->db->insert_id();
							
							//insert data into log table
							$data['user_id']=$insert_id;                 				
							$data['ip_address'] = $_SERVER['REMOTE_ADDR'];  
							$data['remark'] = 'Bidder Registrated Successfully';     
							$this->db->insert('tbl_log_user_registration',$data); 
					 }
			  if($register_as !='broker'){ 
				$verifyCode=$email_id.$insert_id;
				$verifyCode= md5($verifyCode);
				//$udata=array('verify_code'=>$verifyCode,'verify_status'=>0);
							
				$udata=array('verify_code'=>$verifyCode,'verify_status'=>1); // Remove Before Live (Set default active)
				$this->db->where('id',$insert_id);
							
				$this->db->update('tbl_user_registration',$udata);
				//echo $this->db->last_query();
				//die;
				
				//$this->registrationVerificationMail($insert_id);
				//$this->sendSMS($insert_id);
				
				//$this->session->set_userdata('id', $insert_id);			
				//$this->session->set_userdata('full_name', $first_name.' '.$last_name);	
				//$this->session->set_userdata('user_type', $register_as);
			}
			
			return $insert_id;
	}
	
	public function save_step_first_temp() 
        {	
            $savestatus=0;
            $insert_id=0;
			$id = $this->input->post('id');
			$register_as = $this->input->post('register_as');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$mobile_no = $this->input->post('mobile');
			$email_id = $this->input->post('email');
			$password_new = $this->input->post('password');
			$password=hash("sha256", $password_new); 
			$city = $this->input->post('city');
			$state = $this->input->post('state');
			$country = $this->input->post('country');
			$fathers_husband_name = $this->input->post('fathers_husband_name');
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$zipcode = $this->input->post('zipcode');
			$pan_form_16 = $this->input->post('pan_form-16');
			//new fields
			$organisation_name = $this->input->post('organisation_name');
			$authorised_person = $this->input->post('authorised_person');
			$designation = $this->input->post('designation');
			$phone_number = $this->input->post('phone_number');
			$fax_number = $this->input->post('fax_number');
			$gst_no = $this->input->post('gst_no');
			$bank_id = $this->input->post('bank_id');
			$account_holder_name = $this->input->post('account_holder_name');
			$account_type = $this->input->post('account_type');
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			
			$indate=date('Y-m-d H:i:s');
				   
		    if($pan_form_16=='form-16')
			{
				if($_FILES['form16']['name']){
					$documentName=$this->uploaduserdoc('form16');
					if($documentName['status']!='0'){
					 $documentName= $documentName['file_name'];  
					 }else{
					 $savestatus=1;
					 $this->session->set_flashdata('msg',$documentName['error']);
					 }
				}
			}else{
			$documentName = $this->input->post('pan_number');
			}
			//organisation -->2 individual 1
			$status=($register_as=='builder')?'2':'1';
					$status='0';
			$data = array(          
						'register_as'=>$register_as ,
						'user_type'=>$register_as ,
						'first_name'=>$first_name ,
						'last_name'=>$last_name ,
						'mobile_no'=>$mobile_no ,
						'user_id'=>$user_id ,
						'password'=>$password,	
						'email_id'=>$email_id,					
						'city_id'=>$city,					
						'state_id'=>$state,
						'country_id'=>$country,					
						'address2'=>$address2,					
						'address1'=>$address1,					
						'father_name'=>$fathers_husband_name,					
						'document_type'=>$pan_form_16,					
						'document_no'=>$documentName,
						//new fields
						'organisation_name'=>$organisation_name,
						'authorized_person'=>  $authorised_person,
						'designation'=> $designation,
						'phone_no'=> $phone_number,
						'zip'=> $zipcode,
						'fax'=> $fax_number,
						'indate'=>$indate,
						'status'=>$status,						
						'verify_status'=>'0',
						'gst_no'=>$gst_no,
						'bank_id'=> $bank_id,
						'account_holder_name'=> $account_holder_name,
						'account_type'=> $account_type,
						'account_number'=> $account_number,
						'ifsc_code'=> $ifsc_code  
						);
					//echo "<pre>";
					//print_r($data);die;
                   if($savestatus==0)
                   {
                        $data['indate']=date('Y-m-d H:i:s');
                        $this->db->insert('tbl_user_registration_temp',$data); 
                        //echo $this->db->last_query();die;
						$insert_id=$this->db->insert_id();
						
						$verifyCode=$email_id.$insert_id;
						$verifyCode= md5($verifyCode);
						$udata=array('verify_code'=>$verifyCode,'verify_status'=>0);
											
						$this->db->where('id',$insert_id);									
						$this->db->update('tbl_user_registration_temp',$udata);
                   }
			
		
		return $insert_id;
	}


	public function save_payment($insert_id,$email_id) 
        {	

			$indate=date('Y-m-d H:i:s');
               
			$data = array('bidderID'=>$insert_id ,
					'auctionID'=>'' ,
					'paymentStatus'=>'pending' ,
					'sendTime'=>$indate ,
					'ip'=>$_SERVER['REMOTE_ADDR'] ,
					'type'=>'register',	
					'payu_amount'=>REGISTRATION_AMOUNT,					
					'payu_email'=>$email_id
					);

			
                    $this->db->insert('tbl_payment',$data); 
//					echo $this->db->last_query();die;
					$insert_id1=$this->db->insert_id();

		return $insert_id1;
	}

	public function get_payment($paymentId) 
    {
		$resArr = array();
		$this->db->select("p.id,p.payu_amount,p.type,r.user_type,r.authorized_person,r.first_name,r.email_id,r.mobile_no,r.address1,cn.country_name, st.state_name,cy.city_name,r.zip");
		$this->db->where('p.id', $paymentId);
		$this->db->join('tbl_user_registration_temp as r','r.id = p.bidderID');
		$this->db->join('tbl_country as cn','cn.id=r.country_id','left');
		$this->db->join('tbl_state as st','st.id=r.state_id','left');
		$this->db->join('tbl_city as cy','cy.id=r.city_id','left');
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

	public function payment_fail($id = 0) 
    {	
        // echo 'tet';die;   
		$data = array(
			'payu_txnid'=>$_REQUEST['txnid'] ,
			'payu_mihpayid'=>$_REQUEST['mihpayid'] ,
			'paymentStatus'=>'failure' ,
			//'data' => json_encode($_REQUEST),
			'returnTime' => date("Y-m-d H:i:s")
		);
					print_r($this->db);die;
		$this->db->where('id', $id);
		$this->db->update('tbl_payment',$data); 
		echo $this->db->last_query();die;
	}
	
	public function verifyuser($code){
		
		$this->db->where('verify_status', 0); 
		$this->db->where('verify_code', $code);		
		$query = $this->db->get('tbl_user_registration');
		//echo $this->db->last_query();die;
		
		if($query->num_rows()>0)
		{
			$dataInsert = $query->result_array();
			//echo "<pre>";print_r($dataInsert);die;
			
			$dataInsert['user_id']=$dataInsert[0]['id'];  
			unset($dataInsert[0]['id']);               				
			$dataInsert[0]['ip_address'] = $_SERVER['REMOTE_ADDR'];  
			$dataInsert[0]['indate'] = date('Y-m-d H:i:s');
			$dataInsert[0]['remark'] = 'Account activated';     
			$this->db->insert('tbl_log_user_registration',$dataInsert[0]);
			
			
			$data=array('status'=>1,'verify_status'=>1);
			
			$this->db->where('email_id',$dataInsert[0]['email_id']);
			$this->db->update('tbl_user_registration',$data);
			
			$this->db->where('email_id',$email_id);
			$this->db->update('tbl_user_registration_temp',$data);
			$status=1;					
			
				
		}else{
			$status=0;
		}
		return $status;
	}
	
	public function verifyuser_old($code){
		
		$this->db->where('verify_status', 0); 
		$this->db->where('verify_code', $code);		
		$query = $this->db->get('tbl_user_registration_temp');
		
		if($query->num_rows()>0)
		{
							
			foreach ($query->result() as $row) 
			{
				$first_name = $row->first_name;
				$last_name = $row->last_name;
				$email_id = $row->email_id;
				$password = $row->password;
				$designation = $row->designation;
				$mobile_no = $row->mobile_no;
				$user_id = $row->user_id;
				$role = $row->role;
				$date_modified = $row->date_modified;
				$indate = $row->indate;
				
				$verify_code = $row->verify_code;
				$c1zone_id = $row->c1zone_id;
				$c1zone = $row->c1zone;
				$user_type = $row->user_type;
				$user_type_id = $row->user_type_id;
				$register_as = $row->register_as;

				$father_name = $row->father_name;
				$address1 = $row->address1;
				$address2 = $row->address2;
				$country_id = $row->country_id;
				$state_id = $row->state_id;
				$city_id = $row->city_id;
				$zip = $row->zip;
				$document_type = $row->document_type;

				$document_no = $row->document_no;
				$organisation_name = $row->organisation_name;
				$authorized_person = $row->authorized_person;
				$phone_no = $row->phone_no;
				$fax = $row->fax;										
				$supply_place = $row->supply_place;
				$delivery_address = $row->delivery_address;
				$gstin = $row->gst_available;
				$gst_no = $row->gst_no;
				$base_amount = $row->base_amount;
				$tax_rate = $row->tax_rate;
				$total_tax_applicable = $row->total_tax_applicable;
				$net_amt_paid = $row->net_amt_paid;
				
			}

			$dataInsert = array('first_name'=>$first_name,
						'last_name'=>$last_name,
						'email_id'=>$email_id,
						'password'=>$password,
						'designation'=>$designation,
						'mobile_no'=>$mobile_no,
						'user_id'=>$user_id,
						'role'=>$role,
						'date_modified'=>$date_modified,
						'indate'=>$indate,
						'status'=>1,
						'verify_status'=>1,
						'verify_code'=>$verify_code,
						'c1zone_id'=>$c1zone_id,
						'c1zone'=>$c1zone,
						'user_type'=>$user_type,
						'user_type_id'=>$user_type_id,
						'register_as'=>$register_as,
						'father_name'=>$father_name,
						'address1'=>$address1,
						'address2'=>$address2,
						'country_id'=>$country_id,
						'state_id'=>$state_id,
						'city_id'=>$city_id,
						'zip'=>$zip,
						'document_type'=>$document_type,
						'document_no'=>$document_no,
						'organisation_name'=>$organisation_name,
						'authorized_person'=>$authorized_person,
						'phone_no'=>$phone_no,
						'fax'=>$fax,												
						'supply_place'=> $supply_place,
						'delivery_address'=> $delivery_address,
						'gst_available'=> $gstin,
						'gst_no'=> $gst_no,
						'base_amount'=> $base_amount,
						'tax_rate'=> $tax_rate,
						'total_tax_applicable'=> $total_tax_applicable,
						'net_amt_paid'=> $net_amt_paid,
				);

			//echo '<pre>';
			//print_r($dataInsert);die;
			$update=$this->db->insert('tbl_user_registration',$dataInsert);
			$insert_id = $this->db->insert_id();
					
			
			if($insert_id)
			{
				$dataInsert['user_id']=$insert_id;                 				
				$dataInsert['ip_address'] = $_SERVER['REMOTE_ADDR'];  
				$dataInsert['indate'] = date('Y-m-d H:i:s');
				$dataInsert['remark'] = 'Account activated';     
				$this->db->insert('tbl_log_user_registration',$dataInsert);
				
				//updating user id
				$dLog=array('user_id'=>$insert_id);
				$this->db->where('email_id',$email_id);
				$this->db->update('tbl_log_user_registration',$dLog);
				
				
				$data=array('verify_status'=>1);
				$this->db->where('email_id',$email_id);
				$this->db->update('tbl_user_registration_temp',$data);
				$status=1;					
			}
				
		}else{
			$status=0;
		}
		return $status;
	}
	
        public function save_step_second($broker_photo='',$company_logo=''){		
		$id = $this->input->post('id');
		$rows=$this->GetRecordById($id);
		foreach($rows as $row);
		
		$broker_name = $this->input->post('broker_name');
		$company_name = $this->input->post('company_name');
		$website_URL = $this->input->post('website_URL');
		$operating_since = $this->input->post('operating_since');
		$service_title = $this->input->post('service_title');
		$transacation_type = $this->input->post('transacation_type');
		$transacation_type=implode(',',$transacation_type);
		
		if($_FILES['broker_photo']['name']!= ""){
				$broker_photo=$this->upload1('broker_photo');
		}else{
			$broker_photo='';
		}
		if($_FILES['company_logo']['name']!= ""){
				$company_logo=$this->upload1('company_logo');
		}else{
			$company_logo='';
		}
		   $verifyCode=$row->email_id.$id;
		   $verifyCode= md5($verifyCode);
		$data = array(
					'broker_name'=>$broker_name ,
					'broker_photo'=>$broker_photo ,
					'company_name'=>$company_name ,
					'website_URL'=>$website_URL ,
					'company_logo'=>$company_logo ,
					'operating_since'=>$operating_since ,
					'service_title'=>$service_title,					
					'transacation_type'=>$transacation_type,
					'verify_status'=>0,
					'verify_code'=>$verifyCode,
					'status'=>1
					);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_user_registration', $data); 
		}
			//$this->session->set_userdata('id', $id);
			//$first_name=GetTitleById('tbl_user_registration',$id,'first_name');
			//$last_name=GetTitleById('tbl_user_registration',$id,'last_name');
			//$this->session->set_userdata('full_name', $first_name.' '.$last_name);	
			//$this->session->set_userdata('user_type', 'broker');
		
		return true;
	}
	public function UpdateUserRecord($user_id){

		$register_as = $this->input->post('register_as');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$mobile_no = $this->input->post('mobile');
		$email_id = $this->input->post('email');
		$city = $this->input->post('city');
		$company_name = $this->input->post('company_name');
		$website_URL = $this->input->post('website_URL');
		$operating_since = $this->input->post('operating_since');
		$service_title = $this->input->post('service_title');
		$transacation_type = $this->input->post('transacation_type');
		$transacation_type=implode(',',$transacation_type);
		if($_FILES['broker_photo']['name']!= ""){
				$broker_photo=$this->upload1('broker_photo');
		}else{
			$broker_photo=$this->input->post('broker_photo_old');
		}
		if($_FILES['company_logo']['name']!= ""){
				$company_logo=$this->upload1('company_logo');
		}else{
			$company_logo=$this->input->post('company_logo_old');
		}
		
		$data = array(
				'register_as'=>$register_as ,
					'first_name'=>$first_name ,
					'last_name'=>$last_name ,
					'mobile_no'=>$mobile_no ,
					'user_id'=>$user_id ,
					'email_id'=>$email_id,					
					'indate'=>$indate,
					'broker_photo'=>$broker_photo ,
					'company_name'=>$company_name ,
					'website_URL'=>$website_URL ,
					'company_logo'=>$company_logo ,
					'operating_since'=>$operating_since ,
					'service_title'=>$service_title,					
					'transacation_type'=>$transacation_type,
					'status'=>1
				);							
		if($user_id)			
		{			
			$this->db->where('id', $user_id);
			$this->db->update('tbl_user_registration', $data); 
			//echo $this->db->last_query();
			$this->session->set_userdata('full_name', $first_name.' '.$last_name);
		}									
				//$this->session->set_userdata('id', $inserted_id); 
	}
	
	
	function checkDuplicateEmail($email)
	{		
		
		$this->db->from('tbl_user_registration');
		$this->db->where('email_id', $email);
		$this->db->where('status !=', 5);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount;
		 
	}
	
	function chk_login(){
		$username=$this->input->post('user_name');
		$login_as=$this->input->post('login_as');
		$password=$this->input->post('password');
        $this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
        $numRow=$query->num_rows();
	    if($numRow>0)
	    {
			    
                //$generatedPass = hash("sha256", $password); 
                $generatedPass = $password; 
                if($this->is_valid_password($generatedPass, $row[0]->password)==0)
                {
				   
					$check_user_sess_val = $row[0]->user_sess_val;
					
					if(isset($check_user_sess_val) && $check_user_sess_val!='')
					{
						
						$numRow='session_found';
						$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
						$this->session->set_userdata('session_found_usertype', 'bidder');
						$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
					}					
                }else{
                 $numRow=0;
                }
	    }    
	    
        return $numRow;
	}
	
	
	function chk_banker_login()
	{		
		$username=$this->input->post('user_name');

		$user_id=$this->input->post('user_id');

		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
		//$this->db->where('email_id', $username);
		$this->db->where('user_id', $user_id);
		$this->db->where('status',1);
		$this->db->from('tbl_user');
		$query = $this->db->get();
		$row=$query->result();
		$numRow=$query->num_rows();
		//verify password here start

		//verify password here end

		if($numRow>0)
		{
			//$generatedPass=hash("sha256", $password);    
			$generatedPass = $password;
			if($this->is_valid_password($generatedPass, $row[0]->password)==0)
			{
				

				$check_user_sess_val = $row[0]->user_sess_val;
				
				$multiLoginEmailArr = array('gdagorakhpur@gmail.com','singhindrajeet56@gmail.com');
				
				if((isset($check_user_sess_val) && $check_user_sess_val!='') && (!in_array($row[0]->email_id,$multiLoginEmailArr)))
				{
					$numRow='session_found';
					$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
					$this->session->set_userdata('session_found_usertype', 'banker');
					$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
				}					
			}
			else
			{
				$numRow=0;  
			}
		}
		return $numRow;
	}
	
	
	
	function checkBankLogin(){
		
		$username=$this->input->post('user_name');
		
		$user_id=$this->input->post('user_id');
		
		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
		//$this->db->where('email_id', $username);
		$this->db->where('user_id', $user_id);
		$this->db->where('status',1);
		$this->db->from('tbl_user');
		$query = $this->db->get();
		$row=$query->result();
		$numRow=$query->num_rows();
		//verify password here start
		
		//verify password here end
		
			if($numRow>0)
			{
				//$generatedPass=hash("sha256", $password);    
				$generatedPass = $password;
			  if($this->is_valid_password($generatedPass, $row[0]->password)==0)
			  {
				  
						
					$check_user_sess_val = $row[0]->user_sess_val;
				  
					$multiLoginEmailArr = array('gdagorakhpur@gmail.com','singhindrajeet56@gmail.com');
				
					if((isset($check_user_sess_val) && $check_user_sess_val!='') && (!in_array($row[0]->email_id,$multiLoginEmailArr)))
					{
						$numRow='session_found';
						$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
						$this->session->set_userdata('session_found_usertype', 'banker');
						$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
					}
					else
					{
						$this->db->select('ud.user_deprt_id, ud.user_id, ud.role_id, tr.jda_role, tr.name, md.department_id, md.department_name');
						$this->db->from('tbl_user_department as ud');
						$this->db->join('tbl_role as tr','tr.role_id=ud.role_id','left');					
						$this->db->join('tblmst_department as md','md.department_id=ud.department_id','left');
						$this->db->where('ud.user_id',$row[0]->id);
						$this->db->where('ud.status', 1);
						$ssoQry = $this->db->get();
						//echo $this->db->last_query();die;
						if($ssoQry->num_rows()>0)
						{
							$ssoData  = $ssoQry->result_array();						
						}
						else
						{
							$ssoData = array();
						}
						
						
						
						//echo 'dfd';die;
						$this->userchecklogin($row[0]->id,$row[0]->user_type,'banker',$row[0]->email_id);
								
						$this->session->set_userdata('id', $row[0]->id);
						$this->session->set_userdata('full_name', $row[0]->first_name);	
						$this->session->set_userdata('user_type', trim($row[0]->user_type));
						$this->session->set_userdata('bank_id', $row[0]->bank_id); 
						$this->session->set_userdata('branch_id', $row[0]->user_type_id); 						
						//$this->session->set_userdata('role_arr', $row[0]->role_id);
						
						$this->session->set_userdata('role_id', $ssoData[0]['role_id']);
						$this->session->set_userdata('depart_id',$ssoData[0]['department_id']);
						$this->session->set_userdata('ssoData',$ssoData);
						
						$rand = rand(1000000000,9999999999);
						$this->session->set_userdata('session_id_user',$rand);				
						$this->session->set_userdata('table_session', 'banker_tb');		
						
						
						
						$res = $this->bankuserupdate_login($row[0]->id);
					}
					
				}
				else
				{
					  $numRow=0;  
			   }
			}
			
		return $numRow;
	}
	
function checkLogin(){
		$username=$this->input->post('user_name');
		$login_as=$this->input->post('login_as');
		$password=$this->input->post('password');
        $this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
        $numRow=$query->num_rows();
	    if($numRow>0 && $login_as =='owner')
	    {
			    
                //$generatedPass = hash("sha256", $password); 
                $generatedPass = $password; 
                if($this->is_valid_password($generatedPass, $row[0]->password)==0)
                {
				   
					$check_user_sess_val = $row[0]->user_sess_val;
					
					if(isset($check_user_sess_val) && $check_user_sess_val!='')
					{
						
						$numRow='session_found';
						$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
						$this->session->set_userdata('session_found_usertype', 'bidder');
						$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
					}
					else
					{
					   $this->userchecklogin($row[0]->id,$row[0]->user_type,'user',$row[0]->email_id);
					   $userset= $this->userupdate_login($row[0]->id);
					   $this->session->set_userdata('id', $row[0]->id);
					   $this->session->set_userdata('full_name', $row[0]->first_name);	
					   $this->session->set_userdata('user_type', trim($row[0]->user_type));
					   
					   $rand = rand(10000000000,99999999999);
					   $this->session->set_userdata('session_id_user',$rand);
					   
					   $this->session->set_userdata('table_session', 'registration_tb');
					   $this->userupdate_login($row[0]->id);
					}
                }else{
                 $numRow=0;
                }
	    }
	    else if($login_as =='banker')
	    {
		
				$this->db->where('email_id', $username);
				$this->db->where('status',1);
				$this->db->where('user_type','buyer');
				$this->db->from('tbl_user');
				$query1 = $this->db->get();
				//echo $this->db->last_query();die;
				$row1=$query1->result();
				$numRow=$query1->num_rows();
                //verify password here start
                
                //verify password here end
                    if($numRow>0)
                    {
						//echo $password;die;
						//$generatedPass1=hash("sha256", $password); 
						$generatedPass1=$password; 					
										
						if($this->is_valid_password($generatedPass1, $row1[0]->password)==0)
						{
							
							$check_user_sess_val = $row[0]->user_sess_val;
					
							if(isset($check_user_sess_val) && $check_user_sess_val!='')
							{
								$numRow = 'session_found';
								$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
								$this->session->set_userdata('session_found_usertype', 'banker');
								$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
							}
							else
							{
								//echo 'test';die;
								$this->userchecklogin($row1[0]->id,$row1[0]->user_type,'banker',$row1[0]->email_id);
								$this->session->set_userdata('id', $row1[0]->id);
								$this->session->set_userdata('full_name', $row1[0]->first_name);	
								$this->session->set_userdata('user_type', trim($row1[0]->user_type));
								$this->session->set_userdata('bank_id', $row1[0]->bank_id); 
								$this->session->set_userdata('branch_id', $row1[0]->user_type_id); 
								$rand = rand(10000000000,99999999999);
								$this->session->set_userdata('session_id_user',$rand);
								$this->session->set_userdata('table_session', 'banker_tb');
								$this->bankuserupdate_login($row1[0]->id);
							}
                        } 
                        else 
                        {
                                $numRow=0;  
                        }
					}
					
		}
		else
		{
			$numRow=3;
		} 
        return $numRow;
	}



	function checkLogin1(){
		$username=$this->input->post('user_name');
		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
        $this->db->where('email_id', $username);
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
        $numRow=$query->num_rows();
	    if($numRow>0)
	    {
			    
                //$generatedPass = hash("sha256", $password); 
                $generatedPass = $password; 
                if($this->is_valid_password($generatedPass, $row[0]->password)==0)
                {
				   
					$check_user_sess_val = $row[0]->user_sess_val;
					
					if(isset($check_user_sess_val) && $check_user_sess_val!='')
					{
						
						$numRow='session_found';
						$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
						$this->session->set_userdata('session_found_usertype', 'bidder');
						$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
					}
					else
					{											
					    if(!MOBILE_VIEW)
					    {														
						   $this->userchecklogin($row[0]->id,$row[0]->user_type,'user',$row[0]->email_id);
						   $userset= $this->userupdate_login($row[0]->id);
						   $this->session->set_userdata('id', $row[0]->id);
						   $this->session->set_userdata('full_name', $row[0]->first_name);	
						   $this->session->set_userdata('user_type', trim($row[0]->user_type));
						   
						   $rand = rand(10000000000,99999999999);
						   $this->session->set_userdata('session_id_user',$rand);
						   
						   $this->session->set_userdata('table_session', 'registration_tb');
						   $this->userupdate_login($row[0]->id);
					   }
					   else
					   {
						    $deviceUniqueId = DEVICE_ID;
							$encryptDeviceUniqueId = hash("sha256", $deviceUniqueId);
								
							$this->db->where('device_unique_id',$encryptDeviceUniqueId);
							$this->db->where('status', 1);
							$query = $this->db->get('tbl_user_registration');
							
							if($query->num_rows()<=0)
							{
								$data = array('device_unique_id'=>$encryptDeviceUniqueId);						
								$this->db->where('email_id',$row[0]->email_id);
								$query = $this->db->update('tbl_user_registration',$data);
							}
							
					   }
					}
                }else{
                 $numRow=0;
                }
	    }
	    else
	    {
		
				$this->db->where('email_id', $username);
				$this->db->where('status',1);
				$this->db->where('user_type','buyer');
				$this->db->from('tbl_user');
				$query1 = $this->db->get();
				//echo $this->db->last_query();die;
				$row1=$query1->result();
				$numRow=$query1->num_rows();
                //verify password here start
                
                //verify password here end
                    if($numRow>0)
                    {
						//echo $password;die;
						//$generatedPass1=hash("sha256", $password); 
						$generatedPass1=$password; 					
										
						if($this->is_valid_password($generatedPass1, $row1[0]->password)==0)
						{
							
							$check_user_sess_val = $row[0]->user_sess_val;
					
							if(isset($check_user_sess_val) && $check_user_sess_val!='')
							{
								$numRow = 'session_found';
								$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
								$this->session->set_userdata('session_found_usertype', 'banker');
								$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
							}
							else
							{
								//echo 'test';die;
								$this->userchecklogin($row1[0]->id,$row1[0]->user_type,'banker',$row1[0]->email_id);
								$this->session->set_userdata('id', $row1[0]->id);
								$this->session->set_userdata('full_name', $row1[0]->first_name);	
								$this->session->set_userdata('user_type', trim($row1[0]->user_type));
								$this->session->set_userdata('bank_id', $row1[0]->bank_id); 
								$this->session->set_userdata('branch_id', $row1[0]->user_type_id); 
								$rand = rand(10000000000,99999999999);
								$this->session->set_userdata('session_id_user',$rand);
								$this->session->set_userdata('table_session', 'banker_tb');
								$this->bankuserupdate_login($row1[0]->id);
							}
                        } 
                        else 
                        {
                                $numRow=0;  
                        }
					}
					
		} 
        return $numRow;
	}
        
        function checkbidderLoginDSC(){
                 $this->db->where('id', $id);
                 $where ='(register_as="owner" or register_as="builder")';
                $this->db->where($where);
                $this->db->where('status',1);
                $this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
               $row=$query->result();
                $numRow=$query->num_rows();
                if($numRow>0){   
                    $numRow=1;
                    }else{
                 $numRow=2;
                }
                         
		return $numRow;
	}
        
        
        function checkbidderLogin(){
		$username=$this->input->post('user_name');
		$login_type=$this->input->post('login_type');
		$password=$this->input->post('password');
		$this->db->where('email_id', $username);
		$where ='(register_as="owner" or register_as="builder")';
		$this->db->where($where);
		 //$this->db->where('register_as','owner');
		$this->db->where('status',1);
		$this->db->where('verify_status',1);
		$this->db->from('tbl_user_registration');
		$query = $this->db->get();
		$row=$query->result();
                $numRow=$query->num_rows();
                if($numRow>0){ 
					   
                //$generatedPass=hash("sha256", $password); 
                $generatedPass = $password;
                
                if($this->is_valid_password($generatedPass, $row[0]->password)==0)
                {
					$check_user_sess_val = $row[0]->user_sess_val;
					
					if(isset($check_user_sess_val) && $check_user_sess_val!='')
					{
						$numRow='session_found';
						$this->session->set_userdata('session_found_emailid', trim($row[0]->email_id));
						$this->session->set_userdata('session_found_usertype', 'bidder');
						$this->session->set_userdata('session_found_sess_val', $row[0]->user_sess_val);
					}
					else
					{
						$this->userchecklogin($row[0]->id,$row[0]->user_type,'user',$row[0]->email_id);
						$this->userupdate_login($row[0]->id);
             
						$this->session->set_userdata('id', $row[0]->id);
						$this->session->set_userdata('full_name', $row[0]->first_name);	
						$this->session->set_userdata('user_type', trim($row[0]->user_type));
						$rand = rand(10000000000,99999999999);
						$this->session->set_userdata('session_id_user',$rand);
						$this->session->set_userdata('table_session', 'registration_tb');
						$this->userupdate_login($row[0]->id);
					}
						
                }else{
                 $numRow=0;
                }
			 }
		return $numRow;
	      }
            public function userupdate_login($id){
				$setarray=array('user_sess_val'=> $this->session->userdata('session_id_user'));
                $this->db->where('id',$id);
                $this->db->update('tbl_user_registration',$setarray);
                return true;
            }
         public function bankuserupdate_login($id)
         {
			 $setarray=array('user_sess_val'=> $this->session->userdata('session_id_user'));
			 $this->db->where('id',$id);
			 $this->db->update('tbl_user',$setarray);			 
			 return true;		 
		 }
                function is_valid_password($generatedPass,$Password){
             return strcmp($generatedPass,$Password);
        }
	function check_email_availability(){
			$email_id=$this->input->post('email_id');			
			$sql= "select * from tbl_user where email_id='$email_id'";
			$res=mysql_query($sql) or die(mysql_error());
			$numRow=mysql_num_rows($res);
			return $numRow;
	}
	
	function subscribe_user(){
		$email_id=$this->input->post('email_id');		
		$sql= "select * from tbl_subscribe where email_id='$email_id'";
		$res=mysql_query($sql) or die(mysql_error());
		$numRow=mysql_num_rows($res);
		if($numRow==0){
			$data = array('email_id'=>$email_id,					
							'status'=>'1',
							'date_created'=>date('Y-m-d H:i:s'));							
			return $this->db->insert('tbl_subscribe',$data);
		}
		return false;
	}	
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
				$this->db->where('status !=', 5);
				$query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            $row=$query->result();              
            return $row;
        }
        return false;
    }
	
	public function GetRecordByEmail($email) {
        $this->db->where('email_id', $email);
				$this->db->where('status', 1);
				$query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            $row=$query->result();              
            return $row;
        }
        return false;
    }
	
	
	public function updatePassword(){

		$new_password = $this->input->post('new_password');
		$cpassword = $this->input->post('cpassword');
		$email = $this->input->post('email');
		
		$msg='';
		$insert_status=0;
		if($new_password==''){
			$insert_status=1;
			if($msg=='')
				$msg='E101';
			else
				$msg.=',E101';				
		}
		if($cpassword==''){
			$insert_status=1;
			if($msg=='')
				$msg='E102';
			else
				$msg.=',E102';
		}
		if($new_password!=$cpassword){
			$insert_status=1;
			if($msg=='')
				$msg='E103';
			else
				$msg.=',E103';
		}
	
		if($insert_status==0)
		{
			$data = array(	'password'=>hash('sha256',$new_password),
					'date_modified'=>date('Y-m-d H:i:s')
					);							
			if($email)			
			{			
				$this->db->where('email_id', $email);
                                $res=$this->db->update('tbl_user_registration', $data); 
                                $query=$this->db->get('tbl_user_registration');
                                
                                  $numRow=$query->num_rows();
                if($numRow>0)
                          
                                {
                                $row=$query->result();
                                $userlog=array(
                                'actiontype'=>'reset',
                                'email_id'=>$row[0]->email_id,
                                'user_id'=>$row[0]->id,
                                'ip_address'=>$_SERVER['REMOTE_ADDR'],
                                'user_type'=>$row[0]->user_type,
                                'indate'=>date('Y-m-d H:i:s'),
                                'status'=>'1',
                                'message'=>'User changed password successfully'
                                 );
                                $this->db->insert('tbl_log_user_registration',$userlog); 
                                }
			   }	
			return $msg='sucess-S101';
		}else{
			$msg='error-'.$msg;
			return $msg;
		}	
				
	}
	
	
	public function auth_via_google($user_profile=null){
			
			if(!isset($user_profile['id'])){
				return 'failure';
			}
			$this->db->where('email_id', $user_profile['email']);
			$this->db->where('status !=', 5);
			$query = $this->db->get('tbl_user_registration');
			if($query->num_rows == 1)
			{
				$row = $query->row();
				$data = array(
								'google_id'		=>	$user_profile['id'],
								'google_link'	=>	$user_profile['link'],
								'google_picture'=>	$user_profile['picture']
								);
				//$this->db->where('id', $row->id);
				//$this->db->update('tbl_user', $data);
				
				$data = array(
								'id' => $row->id,
								'login_via' => 'google',
								'display_name' => $user_profile['name'],
								'user_email' => $user_profile['email'],
								'user_type' => $row->user_type,
								'validated' => true,
								);
				 
				$this->session->set_userdata($data);
				return 'registered';
			}elseif($query->num_rows == 0){
				//Registration Required
					$password=get_random_password();				
					$data = array(
								'first_name'		=>	$user_profile['given_name'] ,
								'last_name'		=>	$user_profile['family_name'] ,
								//'display_name'	=>	$user_profile['name'],	
								'email_id'		=>	$user_profile['email'],
								'password'		=>	$password,
								//'gender'		=>	ucfirst($user_profile['gender']),
								//'google_id'		=>	$user_profile['id'],
								//'google_link'	=>	$user_profile['link'],
								'broker_photo'=>	$user_profile['picture'],
								'user_source'	=>	'google',
								'status'		=>		'2'
								);
					$data['indate']=date('Y-m-d H:i:s');
					$this->db->insert('tbl_user_registration',$data); 
					$id = $this->db->insert_id();
					$data = array(
								'id' => $id,
								'login_via' => 'google',
								'display_name' => $user_profile['name'],
								'user_email' => $user_profile['email'],
								'validated' => true,
								);
				$this->session->set_userdata($data);
				return $password;
			}
		
	}
	public function facebook_registration($user_profile) {		
	
		$id = $user_profile['id'];
		$email = $user_profile['email'];
		$first_name = $user_profile['first_name'];
		$gender = $user_profile['gender'];
		$last_name = $user_profile['last_name'];
		$link = $user_profile['link'];
		$locale = $user_profile['locale'];
		$name = $user_profile['name'];
		$timezone = $user_profile['timezone'];
		$updated_time = $user_profile['updated_time'];
		$verified = $user_profile['verified'];			
		
		$email_id = $email;	
		
			/*$sql= "select * from tbl_user where email_id='$email_id'";
			$res=mysql_query($sql) or die(mysql_error());
			$numRow=mysql_num_rows($res);*/
			$this->db->where('email_id', $user_profile['email']);
			$this->db->where('status !=', 5);
			$query = $this->db->get('tbl_user_registration');
			$numRow=$query->num_rows;
			
			$result=0;
			if($numRow==0 && $name!='' && $email_id!='')
			{	
				$password=get_random_password();				
				$data = array(
							'first_name'=>$name,
							'last_name'=>$name,
							'email_id'=>$email_id,
							'password'=>$password,							
							//'gender'=>$gender,
							//'dob'=>$dob,
							//'country'=>$country,
							'city'=>$city,
							'status'=>'2',
							'date_created'=>date('Y-m-d H:i:s')
						);							
					$result=$this->db->insert('tbl_user',$data); 
					//echo $this->db->last_query();
					$inserted_id=$this->db->insert_id();									
					$this->session->set_userdata('id', $inserted_id); 
					$this->session->set_userdata('full_name', $full_name);
					return $password;
			}else{
				$row=$query->result() ;	
				$this->session->set_userdata('id', $row[0]->id); 
				$this->session->set_userdata('full_name', $row[0]->first_name);
				$this->session->set_userdata('user_type', $row[0]->user_type);
				return 'registered';
			}
			
	}
	
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            

		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	function uploaduserdoc($fieldname)
	{
		$config['upload_path'] = $this->userdoc;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|doc|docx';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
                
		if (!$this->upload->do_upload($fieldname)){
                        $error = array('status'=>0,
                                       'file_name' =>'',
                                        'error' => $this->upload->display_errors()
                                       );
                        return $error;
		}else{
			$upload_data = $this->upload->data();
			//return $upload_data['file_name'];
                        $error = array('status'=>1,
                                       'file_name' => $upload_data['file_name'],
                                       'error' =>''
                                      );
                        return $error;
		}							
	}
	


function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max)];
    }
    return $token;
}
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function forgotPasswordMail($table,$userID){
		$rows=$this->GetUserBankerRecordById($table,$userID);
		foreach($rows as $row);
		$name= ucfirst($row->first_name)." ".$row->last_name;
		$mailTo=$row->email_id;
		$password=$this->getToken(10);
		$email_msg ="<p><b>Dear ".$name."</b>, <br/> <br/>
		Your Login Detail.</p><br/>
		Email : ".$mailTo."<br>
		Password : ".$password."
		<br/>
		<br/>
		<p>Regards,<br/>
                <b>".BRAND_NAME."</b><br/>
                <b>URL: 
		Plot Number 301.<br/>
		1st Floor,<br/>
		Udyog Vihar Phase – 2,<br/>
		Gurgaon-122015<br/>
		Haryana,India<br/>
                <b>Tel:</b> +91-124-4302 000<br/>
                <b>Fax:</b> +91 124 4302010<br/>
		<br/></p>";		
		//$this->load->library('email');
                $this->load->library('Email_new','email');
		/*$this->email->set_mailtype("html");
		$this->email->from('info@c1indiabankeauction.com', 'C1india');
		$this->email->to($mailTo); 
		//$this->email->to('sunil.singh@afaqs.com'); 
		$this->email->subject("E-auction Forgot password Email Alert");
		$this->email->message($email_msg);	
		//$this->email->attach($path);
		//$this->email->print_debugger();
                 * \*/
                
		$email = new email_new();
		 $res = $email->sendMailToUser(array($mailTo),'GDA: E-auction Forgot password Email Alert',$email_msg);
		 
               if($res)
		{
                $this->db->where('id',$row->id);
                $data=array('password'=>hash("sha256", $password));
                $this->db->update('tbl_user_registration',$data);      
			return 1;
		}else {
			return 0;
		}
		
}

	public function GetUserBankerRecordById($table,$id) {
		$this->db->where('id', $id);
		$this->db->where('status !=', 5);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		
        if ($query->num_rows() > 0) {
            $row=$query->result();              
            return $row;
        }
        return false;
    }

	public function GetRecordByEmailid($table,$email) {
		$this->db->where('email_id', $email);
		$this->db->where('status !=', 5);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		
        if ($query->num_rows() > 0) {
            $row=$query->result();              
            return $row;
        }else{
		 return 0;	
		}
        
    }
function forgotPassword(){
	$utype	=	$this->input->post('utype');
	$email	= 	$this->input->post('email');
	if($utype=='bidder'){
		$urow=$this->GetRecordByEmailid('tbl_user_registration',$email);
		
		if($urow!=0)
		{
			foreach($urow as $row);
			$this->forgotPasswordMail('tbl_user_registration',$row->id);
			$msg = "Password has been sent to your Emailid!";
			$data = array(
							"email_id"=>$row->email_id,
							"actiontype"=>'reset',
							"user_id"=>$row->id,
							"ip_address"=>$_SERVER['REMOTE_ADDR'],
							"user_type"=>$row->user_type,
							"date_modified"=>date("Y-m-d H:i:s"),
							"indate"=>date("Y-m-d H:i:s"),
							"status"=>1,
							"message"=>$msg
						);
			$this->db->insert("tbl_log_user_registration",$data);
			echo $msg;
		}else{
			echo "This Email ID is not registered or account is closed or Account is not active !!";
		}
		
	}else{
		
		$urow=$this->GetRecordByEmailid('tbl_user',$email);
		if($urow!=0)
		{	foreach($urow as $row);
			$this->forgotPasswordMail('tbl_user',$row->id);
			$msg = "Password has been sent to your EmailID!";
			
			$data = array(
							"email_id"=>$row->email_id,
							"actiontype"=>'reset',
							"user_id"=>$row->id,
							"ip_address"=>$_SERVER['REMOTE_ADDR'],
							"user_type"=>$row->user_type,
							"date_modified"=>date("Y-m-d H:i:s"),
							"indate"=>date("Y-m-d H:i:s"),
							"status"=>1,
							"message"=>$msg
						);
			$this->db->insert("tbl_log_user_registration",$data);
			echo $msg;			
		}else{
			echo "This Email ID is not registered or account is closed or Account is not active !!";
		}	
	}
	
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
	/*function updatePassword123()
	{
		set_time_limit(0);
		$page = 0;
		if($_GET['page'] > 0)
		{
			$page = $_GET['page'];
		}		
		$record_per_page = 500;
		$tablename = "pwd";

		$this->db->limit($record_per_page,$page*$record_per_page);
		$query = $this->db->get($tablename);		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$len = strlen($row->Pwd);
				if($len < 50)
				{
					$password = hash("sha256", $row->Pwd);
					$data['Pwd'] = $password;
					$this->db->where('UserNo', $row->UserNo);				
					$query = $this->db->update($tablename,$data);
					//echo $this->db->last_query();die;
				}
            }            
            
        }
		else
		{
			echo 'Done';die;
		}
		$page++;
		?>
			<script>
				location.href = '?page=<?php echo $page;?>';
			</script>
		<?php
       
	}	*/
	
	public function check_device_unique_id()
	{
		$deviceUniqueId = DEVICE_ID; //e3ca580cb01da6f2409f2540c2095cacd1e5888e1e4f3de9ae250cce20ebd50c
		
		$encryptDeviceUniqueId = hash("sha256", $deviceUniqueId);
		
		$this->db->where('device_unique_id',$encryptDeviceUniqueId);
		$this->db->where('status', 1);
		$query = $this->db->get('tbl_user_registration');
		if($query->num_rows()>0)
		{
			$row = $query->result_array();
			$data = $row[0];
		}
		else
		{
			$data = array();
		}		
		return $data;
		
	}
	
	public function set_mpin()
	{		
		$mPin = $this->input->post('mpin');
		$encryptMpin = hash("sha256",$mPin);
		
		$deviceUniqueId = DEVICE_ID; //e3ca580cb01da6f2409f2540c2095cacd1e5888e1e4f3de9ae250cce20ebd50c
		$encryptDeviceUniqueId = hash("sha256", $deviceUniqueId);
						
		$this->db->where('device_unique_id',$encryptDeviceUniqueId);	
		$res = $this->db->update('tbl_user_registration',array('mPin'=>$encryptMpin));
		
		return $res;		
	}
	
	public function lgn_mpin()
	{
		
		$mPin = $this->input->post('mpin');
		$encryptMpin = hash("sha256",$mPin);
		
		$deviceUniqueId = DEVICE_ID; //e3ca580cb01da6f2409f2540c2095cacd1e5888e1e4f3de9ae250cce20ebd50c
		$encryptDeviceUniqueId = hash("sha256", $deviceUniqueId);
						
		$this->db->where('device_unique_id',$encryptDeviceUniqueId);		
		$this->db->where('mpin',$encryptMpin);
		$mQry = $this->db->get('tbl_user_registration');
		$numRows = $mQry->num_rows;
		if($numRows>0)
		{
			$row = $mQry->result();					
			
		   $this->userchecklogin($row[0]->id,$row[0]->user_type,'user',$row[0]->email_id);
		   $userset= $this->userupdate_login($row[0]->id);
		   $this->session->set_userdata('id', $row[0]->id);
		   $this->session->set_userdata('full_name', $row[0]->first_name);	
		   $this->session->set_userdata('user_type', trim($row[0]->user_type));
		   
		   $rand = rand(10000000000,99999999999);
		   $this->session->set_userdata('session_id_user',$rand);
		   
		   $this->session->set_userdata('table_session', 'registration_tb');
		   $this->userupdate_login($row[0]->id);			
			
		}
		else
		{
			$numRows=0;
		}
		return $numRows;
		
	}
	
	public function forgot_login_pin()
	{
		$deviceUniqueId = DEVICE_ID; //e3ca580cb01da6f2409f2540c2095cacd1e5888e1e4f3de9ae250cce20ebd50c
		$encryptDeviceUniqueId = hash("sha256", $deviceUniqueId);
						
		$this->db->where('device_unique_id',$encryptDeviceUniqueId);		
		
		$mQry = $this->db->get('tbl_user_registration');
		
		$numRows = $mQry->num_rows;
		if($numRows>0)
		{
			$uData = array('device_unique_id'=>null,'mpin'=>null);
			$this->db->where('device_unique_id',$encryptDeviceUniqueId);		
			$res = $this->db->update('tbl_user_registration',$uData);
			if($res)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function sendForgetMail()
	{
		//print_r($_POST);die;		
		$forgotemail = $this->input->post('forgotemail');
		
		//checking email in bidder registration table
		$this->db->from('tbl_user_registration'); 
		$this->db->where('email_id', $forgotemail); 		
		$bQry=$this->db->get();		
		//echo $this->db->last_query();die;
		
		//checking email in seller registration table
		$this->db->from('tbl_user'); 
		$this->db->where('user_id', $forgotemail); 		
		$sQry=$this->db->get();
		//echo $this->db->last_query();die;
		
		if($bQry->num_rows()>0)
		{			
			$memData = $bQry->result();
			$first_name = $memData[0]->first_name;
			$last_name = $memData[0]->last_name;
			$full_name = $first_name." ".$last_name;
			$userType = 'owner';
			$random = $this->addRandomString($forgotemail,$userType);
			
			$this->load->library('Email_new');
			
			$email_new = new Email_new();
			/******************Send forgot password email to User***********************/
			$res = $email_new->sendMailToBidderResetPasswordLink($forgotemail,$random,$full_name);  // Uncomment First		
			return 1;
		}
		else if($sQry->num_rows()>0)
		{			
			$sellerData = $sQry->result();
			$first_name = $sellerData[0]->first_name;
			$last_name = $sellerData[0]->last_name;
			$full_name = $first_name." ".$last_name;
			$userType = 'buyer';			
			$random = $this->addRandomString($sellerData[0]->email_id,$userType);
			
			$this->load->library('Email_new');
			
			$email_new = new Email_new();
			/******************Send forgot password email to User***********************/
			$res = $email_new->sendMailToBidderResetPasswordLink($sellerData->email_id,$random,$full_name);  // Uncomment First		
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function addRandomString($forgotemail, $userType)
	{
		$emailId = $forgotemail;
		
		$this->db->where('email_id', $emailId); 
		$this->db->where('user_type', $userType); 
		
		$ckQry = $this->db->get('tblforget_pass');	
		if($ckQry->num_rows()>0)
		{
			$this->db->where('email_id', $emailId); 	
			$this->db->where('user_type', $userType);	
			$this->db->update('tblforget_pass',array('expiry_flag'=>1));	
		}		
		
		$random = $this->getPassword_randomString();
		$ip = $_SERVER['REMOTE_ADDR'];
		$date = date("Y-m-d H:i:s");
		$data = array(
			'email_id'=>$emailId,
			'user_type'=>$userType,
			'random_string'=>$random,
			'ip' => $ip,
			'in_date_time' => $date
		);
		
		$this->db->insert("tblforget_pass",$data);
		return $random;
	}
	public function getPassword_randomString()
    {
		$length = 20;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return strtoupper($randomString);
	}
	
	public function checkLinkValid($randomNum)
	{
		$date = date("Y-m-d H:i:s");
		$yesterday = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($date)));
		$this->db->select('email_id');
		$this->db->where('random_string', $randomNum);
		$this->db->where('in_date_time >=', $yesterday);

		$this->db->where('expiry_flag', 0);
		$query = $this->db->get('tblforget_pass');
		$res = $query->result_array();
		//echo $this->db->last_query();die;
		//echo $query->num_rows() ;die;
		if($query->num_rows() > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
		
	}
	
	public function update_password($randomNum)
	{
		
		$newPass = hash("sha256",$this->input->post('newpassword'));
		$date = date("Y-m-d H:i:s");
		$yesterday = date("Y-m-d H:i:s",strtotime('-1 day',strtotime($date)));
		$this->db->select('email_id,user_type');
		$this->db->where('random_string', $randomNum);
		$this->db->where('in_date_time >=', $yesterday);

		$this->db->where('expiry_flag', 0);
		$query = $this->db->get('tblforget_pass');
		$res = $query->result_array();
		//echo $this->db->last_query();die;
		//echo $query->num_rows() ;die;
		if($query->num_rows() > 0 && $res[0]['user_type'] =='owner')
		{			
			//check here for expired link
			$this->db->where('email_id', $res[0]['email_id']);
			$query = $this->db->update('tbl_user_registration',array('password' =>$newPass,'date_modified'=>date('Y-m-d H:i:s')));
			
			$this->db->where('email_id', $res[0]['email_id']);
			$this->db->where('user_type', 'owner');
			$query = $this->db->update('tblforget_pass',array('expiry_flag' =>1));
			
			$resetLogData = array(
				'email_id'=>$res[0]['email_id'],
				'user_type'=>'owner',
				'remark'=>'Login Password Reset Successfully',				
				'createTime'=>date('Y-m-d H:i:s'),
				'ip' => $_SERVER['REMOTE_ADDR']
			);			
			$resetQry = $this->db->insert('tbl_log_password',$resetLogData);
			
			return 1;
		}
		else if($query->num_rows() > 0 && $res[0]['user_type'] =='buyer')
		{			
			//check here for expired link
			$this->db->where('user_id', $res[0]['email_id']);
			$query = $this->db->update('tbl_user',array('password' =>$newPass,'date_modified'=>date('Y-m-d H:i:s')));
			
			$this->db->where('email_id', $res[0]['email_id']);
			$this->db->where('user_type', 'buyer');
			$query = $this->db->update('tblforget_pass',array('expiry_flag' =>1));
			
			$resetLogData = array(
				'email_id'=>$res[0]['email_id'],
				'user_type'=>'buyer',
				'remark'=>'Login Password Reset Successfully',				
				'createTime'=>date('Y-m-d H:i:s'),
				'ip' => $_SERVER['REMOTE_ADDR']
			);			
			$resetQry = $this->db->insert('tbl_log_password',$resetLogData);
			
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
}
