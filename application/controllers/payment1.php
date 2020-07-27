<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(BASEPATH.'../ccvenue/new/Crypto.php');
class Payment1 extends WS_Controller
{	
	public function __Construct()
	{
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('log4php');
		log_error('my_error');
		log_info('my_info');
		log_debug('my_debug');
		error_reporting(0);
		$this->load->helper('url');
		$this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('registration_model');
		//	$this->check_isvalidated();
	}	
		
	
	public function index()
	{
		$paymentId = $this->input->get("txnid");
		if($paymentId != '')
		{
			$payment_res = $this->registration_model->get_payment(base64_decode($paymentId));
			//echo '<pre>';
			//print_r($payment_res);die;
			$this->page($payment_res);
		}
		
	}	

		
	public function page($payudata)
	{   

		if($payudata->user_type == 'builder')
		{
			$name = $payudata->authorized_person;
		}
		else
		{
			$name = $payudata->first_name;
		}
		
		$controlNumber = time();
		
		//$random = $this->randomString(10);
		$redirect_url = base_url().'payment1/payment_success';	
		$cancel_url = base_url().'payment1/payment_failure';	
		$ccav_req_data = array(
		'tid'=>$controlNumber,
		'merchant_id'=>CCAV_MERCHANT_ID,
		'order_id'=>$payudata->id,
		'amount'=>REGISTRATION_AMOUNT,
		'currency'=>'INR',
		'redirect_url'=>$redirect_url,
		'cancel_url'=>$cancel_url,
		'language'=>'EN',
		'billing_name'=>$name,
		'billing_address'=>$payudata->address1,
		'billing_city'=>$payudata->city_name,
		'billing_state'=>$payudata->state_name,
		'billing_zip'=>$payudata->zip,
		'billing_country'=>$payudata->country_name,
		'billing_tel'=>$payudata->mobile_no,
		'billing_email'=>$payudata->email_id,
		
		);
						
		//print_r($ccav_req_data);die;
		
		


		$merchant_data = '';
		$working_key = CCAV_WORKING_KEY; //Shared by CCAVENUES
		$access_code = CCAV_ACCESS_CODE; //Shared by CCAVENUES
		

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
		
		
		if($controlNumber)
		{										
			echo $form = '<form method="post" name="redirect" action="'.CCAV_PAYMENT_URL.'"> 										
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

	public function payment_success() 
	{
		/* Payment success logic goes here. */
		//echo "Registration Success";die;
		
		
		$workingKey=CCAV_WORKING_KEY;		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);

		$resData = array();
		for($i = 0; $i < $dataSize; $i++) 
		{
			$information=explode('=',$decryptValues[$i]);			
			$resData[$information[0]] = $information[1];
			
		}
		
		//echo "<pre>";print_r($resData);die;
		$this->db->where('id', $resData['order_id']);
		$ckQry = $this->db->get('tbl_payment');
		$ckRes = $ckQry->result();
		
		if($ckRes[0]->id != $resData['order_id'])
		{
			$this->session->set_flashdata('msg','Registration Failure !<br>');	
			redirect("/registration/signup");die;
		}
		
			
		$rtxnid = $resData['order_id'];
		$remail = $resData['billing_email'];
		$ramount = (int)$resData['mer_amount'];

		
		$resDataArr = array(
				'data' => json_encode($resData)
		);

		$this->db->where('id', $resData['order_id']);
		$this->db->update('tbl_payment',$resDataArr); 


			if ($ckQry->num_rows() > 0)
			{
				$txnid = $ckRes[0]->id;
				$payu_amount = $ckRes[0]->payu_amount;
				$email_id = $ckRes[0]->payu_email;
				
			}
			
			//echo $txnid .' | '. $rtxnid  .' | '. $remail  .' | '.$email_id  .' | '.$resData['order_status'];die;
			if(($txnid == $rtxnid) && ($remail == $email_id) && ($resData['order_status']=='Success'))  // Payment Success with Database Verification
			{
				$data = array(
								'payu_txnid'=>$resData['tracking_id'] ,
								'payu_mihpayid'=>$resData['bank_ref_no'] ,
								'paymentStatus'=>'success' ,
								'data' => json_encode($resData),
								'returnTime' => date("Y-m-d H:i:s")
					);

					$this->db->where('id', $resData['order_id']);
					$this->db->update('tbl_payment',$data); 

					$this->db->where('id', $resData['order_id']);
					$query  =   $this->db->get('tbl_payment');
					$res = $query->result();

					$payment_res = $res[0];
				
					 $tempId = $payment_res->bidderID;


					$this->db->where('id', $tempId);
					$query1 = $this->db->get("tbl_user_registration_temp");

					if ($query1->num_rows() > 0)
					{
						foreach ($query1->result() as $row) 
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

							$status = $row->status;
							$verify_status = $row->verify_status;
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
							$bank_id = $row->bank_id;
							$account_holder_name = $row->account_holder_name;
							$account_type = $row->account_type;
							$account_number = $row->account_number;
							$ifsc_code = $row->ifsc_code;
							
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
									'status'=>$status,
									'verify_status'=>$verify_status,
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
									'bank_id'=> $bank_id,
									'account_holder_name'=> $account_holder_name,
									'account_type'=> $account_type,
									'account_number'=> $account_number,
									'ifsc_code'=> $ifsc_code,
							);

						//echo '<pre>';
						//print_r($dataInsert);die;
						$update=$this->db->insert('tbl_user_registration',$dataInsert);
						$insert_id = $this->db->insert_id();
						
						
						$data2 = array(
								'regoriginalID'=>$insert_id ,
								'returnTime' => date("Y-m-d H:i:s")
					);

					$this->db->where('id', $resData['order_id']);
					$this->db->update('tbl_payment',$data2); 
					
					//data for gst_mis table
					if($register_as =='builder')
					{
						$customer_name = $organisation_name;
					}
					else
					{
						$customer_name = $first_name.' '.$last_name;
					}
					$cityName = GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
					$stateName = GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
					$countryName = GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');
					$supplyPlaceName = GetTitleByField('tbl_state', "id='".$supply_place."'", 'state_name');
					
					$customer_address = $address1;
					if($address2 !='')
					{
						$customer_address .= ', '.$address2;
					}
					$customer_address .= ', '.$cityName.', '.$stateName.', '.$countryName.', '.$zip;
					
					
					$gstMisArr = array(
							'bidder_id'=>$insert_id,
							'customer_name'=>$customer_name,
							'customer_address'=>$customer_address,
							'supply_place'=>$supplyPlaceName,
							'delivery_address'=>$delivery_address,
							'gst_available'=>$gstin,
							'gst_no'=>$gst_no,
							'service_description'=>'Registration Fee',
							'base_amt'=> $base_amount,
							'tax_rate'=> $tax_rate,
							'total_tax_applicable'=> $total_tax_applicable,
							'net_amt_paid'=> $net_amt_paid,
							'payment_date'=>$data2['returnTime'],
							'transaction_number'=>$_REQUEST['mihpayid']
					);
					//echo "<pre>";print_r($gstMisArr);die;
					//insert data into gst_mis table
					$this->db->insert('tbl_gst_mis',$gstMisArr);
					
					
						
						unset($dataInsert['id']);  
						$dataInsert['user_id']=$insert_id;                				
						$dataInsert['ip_address'] = $_SERVER['REMOTE_ADDR'];  
						$dataInsert['remark'] = 'Bidder Registrated Successfully';     
						$this->db->insert('tbl_log_user_registration',$dataInsert); 
						
						
						
						$this->load->library('Email_new', 'email');
						$email = new email_new();
						
						//for bidders
						$mail = $email->sendMailToNewUserVerificationLink($row->id);
					  
						/*$email = new email_new();
						$email->sendMailToUser(array($email_id),'test','Registration successfully');*/	
					
					
						//echo $this->db->last_query();die;
					}

					 $this->session->set_flashdata('msg','An Activation link has been sent to your registered email ID. Kindly click on the link to activate your account!<br>');	
					 redirect("/registration/signup");
				}else{
					
					$this->db->where('id', $resData['order_id']);
					$query  =   $this->db->get('tbl_payment');
					$res = $query->result();

					$payment_res = $res[0];
						
					$this->session->set_flashdata('error','Registration Failure !<br>');	
					redirect("/registration/signup");
					
				}
			
	}

	public function payment_failure($payment_res) 
	{
		$workingKey=CCAV_WORKING_KEY;		//Working Key should be provided here.
		$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);

		$resData =array();
		for($i = 0; $i < $dataSize; $i++) 
		{
			$information=explode('=',$decryptValues[$i]);			
			$resData[$information[0]] = $information[1];
			
		}
		
			
		//$txnidArr = explode("_",$_REQUEST['txnid']);
		if(isset($resData) && $resData['order_id'] > 0)
		{
			$data = array(
					'payu_txnid'=>$resData['tracking_id'] ,
					'payu_mihpayid'=>$resData['bank_ref_no'] ,
					'paymentStatus'=>'failure' ,
					'data' => json_encode($resData),
					'returnTime' => date("Y-m-d H:i:s")
				);

				$this->db->where('id', $resData['order_id']);
				$this->db->update('tbl_payment',$data); 

				

				$this->session->set_flashdata('error','Registration Failure !<br>');	
				redirect("/registration/signup");
		}
		else
		{
			$this->session->set_flashdata('error','Registration Failure !<br>');	
			redirect("/registration/signup");
		}
	}
	
	
	function randomString($length = 6) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
		
}
?>
