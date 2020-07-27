<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends WS_Controller
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
		
	public function test()
	{
		$random = $this->randomString(12);
		$cid = 1102; //
		$rid = $random;
		$crn = 123456;
		$amt = 5;
		$axis_key = AXIS_KEY;
		$CKS_value = hash("sha256",  $cid. $rid. $crn.  $amt.  $axis_key);
		$string = 'CID=1102&RID='.$rid.'&CRN=123456&AMT=5&VER=1.0&TYP=TEST&CNY=I NR&RTU=http://propertyauctions.c1india.com&PPI=sam|25|10|mumbai&RE1=MN&RE2=&RE3=&RE4=&RE5=&CKS='.$CKS_value;
		
		$encrypted = $this->aes256encrypted($string,'encrypt');
			
		echo $form = '<form method="post" action ="'.AXIS_PAYMENT_URL.'">
								<input type="hidden" name="i" value="'.$encrypted.'"></form>';
						echo '<script type="text/javascript">
										var form = document.forms[0];
										form.submit();
							</script>'; die;
		
	}
	public function aes256encrypted($string, $type){
		
		$plaintext = $string;
		$password = '3sc3RLrpd17';	
		$password = AXIS_ENCRYPTION_KEY;	
		$method = 'aes-256-cbc';

		// Must be exact 32 chars (256 bit)
		//$password = substr(hash('sha256', $password, true), 0, 32);
	
	

		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		
		//$ivlen = openssl_cipher_iv_length($method);
		//$iv = openssl_random_pseudo_bytes($ivlen);
		
		$encrypted = 'lL14D4bK7oVcEKqCsaKsQDhOHUKGuyuX39r+dx6Jf3t/WUTjwLu8QYgfrvh20CVrctuqcxn5t1nQbBsq944xp1WctN0flJdtQ66a/54Jp3HVdaWoh8ZdMWUOIUcz4C2dPm4ILquwerjoLANRrhUWeuXb2A2hNoee7jbQmw444D4rrwYe+YCx0zKJIN4BuQdIVlfYmJoCTpqOIxAX8FOfuCE3pIAgwmgzCUV3BTPYpLC/ceN7tEvTpHDoUECabrMZ+kvFYUrIZ7f061dG21Tmxj1f4HTUer8km/qV67dq5+NUTCeg5nkD2s9fI/n8flce';

		if($type == 'encrypt')
		{
			$encrypted = openssl_encrypt($plaintext, $method, $password, 0, $iv);
			return $encrypted;
		}
		else if($type == 'decrypt')
		{
			$decrypted = openssl_decrypt($encrypted, $method, $password, 0, $iv);
			return $decrypted;
		}
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
		$random = $this->randomString(12);
		$cid = 1102; //
		$rid = $random;
		$crn = 123456;
		$amt = 5;
		$axis_key = AXIS_KEY;
		$CKS_value = hash("sha256",  $cid+ $rid + $crn + $amt + $axis_key);
		
		
		$plaintext = 'CID=1102&RID=12345&CRN=123456&AMT=5&VER=1.0&TYP=TEST&CNY=I NR&RTU=http://localhost/formdata/output&PPI=sam|25|10|mumbai&RE1=MN&RE2=&RE3=&RE4=&RE5=&CKS=CKS_value,'.AXIS_ENCRYPTION_KEY;
		$password = '3sc3RLrpd17';
		$method = 'aes-256-cbc';

		// Must be exact 32 chars (256 bit)
		$password = substr(hash('sha256', $password, true), 0, 32);
	

		// IV must be exact 16 chars (128 bit)
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

		// av3DYGLkwBsErphcyYp+imUW4QKs19hUnFyyYcXwURU=
		echo $encrypted = base64_encode(openssl_encrypt($plaintext, $method, $password, OPENSSL_RAW_DATA, $iv));die;

		// My secret message 1234
		$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $password, OPENSSL_RAW_DATA, $iv);
		
		
		
		
		
		
		$posted = array ('key' => PAYU_MERCHANT_KEY, 'txnid' =>$payudata->id."_".$random, 'amount' => $payudata->payu_amount,
			'firstname' => ucfirst($name), 'email' => $payudata->email_id, 'phone' => $payudata->mobile_no,
			'productinfo' => ucfirst($payudata->type), 'surl' => base_url().'payment1/payment_success', 'furl' => base_url().'payment1/payment_failure');

		/*$data = array ('key' => 'gtKFFx', 'txnid' =>'100_a', 'amount' => rand( 0, 100 ),
			'firstname' => 'Test', 'email' => 'test@payu.in', 'phone' => '98765433210',
			'productinfo' => 'Product Info', 'surl' => 'payment_success', 'furl' => 'payment_failure');*/

		//pay_page($data ,'eCwWELxi' );
		
		// Merchant key here as provided by Payu
			$data['MERCHANT_KEY'] = PAYU_MERCHANT_KEY;


			// Merchant Salt as provided by Payu
			$data['SALT'] = PAYU_SALT;

			// End point - change to https://secure.payu.in for LIVE mode
			$PAYU_BASE_URL = PAYU_BASE_URL;

			$action = '';

			$hash = '';
		// Hash Sequence
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($posted['hash']) && sizeof($posted) > 0) {
		  if(
				  empty($posted['key'])
				  || empty($posted['txnid'])
				  || empty($posted['amount'])
				  || empty($posted['firstname'])
				  || empty($posted['email'])
				  || empty($posted['phone'])
				  || empty($posted['productinfo'])
				  || empty($posted['surl'])
				  || empty($posted['furl'])
		  ) {
			$formError = 1;
		  } else {
			$hashVarsSeq = explode('|', $hashSequence);
			$hash_string = '';
			foreach($hashVarsSeq as $hash_var) {
			  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			  $hash_string .= '|';
			}
			$hash_string .= $data['SALT'];
			$data['hash'] = strtolower(hash('sha512', $hash_string));
			$data['action'] = $PAYU_BASE_URL . '/_payment.php';
		  }
		} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment.php';
		}
		
		$data['posted'] = $posted;

		$this->load->view('payu', $data);
	}

	public function payment_success() 
	{
		/* Payment success logic goes here. */
		//echo "Registration Success";die;
		
		$txnidArr = explode("_",$_REQUEST['txnid']);	
		$rtxnid = $txnidArr[0];
		$remail = $_REQUEST['email'];
		$ramount = (int)$_REQUEST['amount'];

		if(isset($txnidArr) && $txnidArr[0] > 0)
		{




		$data = array(
					'data' => json_encode($_REQUEST)
		);

		$this->db->where('id', $txnidArr[0]);
		$this->db->update('tbl_payment',$data); 

			$this->db->where('id', $txnidArr[0]);
			$query1 = $this->db->get("tbl_payment");

			if ($query1->num_rows() > 0)
			{
				foreach ($query1->result() as $row) 
				{
					$txnid = $row->id;
					$payu_amount = $row->payu_amount;
					$email_id = $row->payu_email;
				}
			}
			
			/* Create Hash Key */
				if (!empty($_REQUEST)) 
				{
					foreach ( $_REQUEST as $key => $value )
					{
						$_REQUEST[$key] = htmlentities( $value, ENT_QUOTES );
					}
				}
				
				$hashSequence = "udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
				$hashVarsSeq = explode('|', $hashSequence);
				
				$hash_string = PAYU_SALT."|".$_REQUEST['status'];
				foreach($hashVarsSeq as $hash_var) {
				  $hash_string .= '|';
				  $hash_string .= isset($_REQUEST[$hash_var]) ? $_REQUEST[$hash_var] : '';				  
				}

				$hash = strtolower(hash('sha512', $hash_string));				
			/* End Hash Key */
			
			if(($txnid == $rtxnid) && ($remail == $email_id) && ($_REQUEST['status'] == 'success'))  // Payment Success with Database Verification
			{
							$data = array(
											'payu_txnid'=>$_REQUEST['txnid'] ,
											'payu_mihpayid'=>$_REQUEST['mihpayid'] ,
											'paymentStatus'=>'success' ,
											'data' => json_encode($_REQUEST),
											'returnTime' => date("Y-m-d H:i:s")
								);

								$this->db->where('id', $txnidArr[0]);
								$this->db->update('tbl_payment',$data); 

								$this->db->where('id', $txnidArr[0]);
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
										);

									//echo '<pre>';
									//print_r($dataInsert);die;
									$update=$this->db->insert('tbl_user_registration',$dataInsert);
									$insert_id = $this->db->insert_id();
									
									
									$data2 = array(
											'regoriginalID'=>$insert_id ,
											'returnTime' => date("Y-m-d H:i:s")
								);

								$this->db->where('id', $txnidArr[0]);
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
								
								
								/*$this->load->library('Email_new','email');
									$email = new email_new();
									$email->sendMailToUser(array($email_id),'test','Registration successfully');*/	
								
								
									//echo $this->db->last_query();die;
								}

								 $this->session->set_flashdata('msg','Registration done Successfully !<br>');	
								 redirect("/registration/signup");
				}else{
					
					$this->db->where('id', $txnidArr[0]);
					$query  =   $this->db->get('tbl_payment');
					$res = $query->result();

					$payment_res = $res[0];
						
					$this->session->set_flashdata('msg','Registration Failure !<br>');	
					redirect("/registration/signup");
					
				}
		}		
	}

	public function payment_failure($payment_res) 
	{
		/* Payment failure logic goes here. */
		//echo "We are sorry. The Payment has failed";
		
		/* Create Hash Key */
			if (!empty($_REQUEST)) 
			{
				foreach ( $_REQUEST as $key => $value )
				{
					$_REQUEST[$key] = htmlentities( $value, ENT_QUOTES );
				}
			}
			
			$hashSequence = "udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
			$hashVarsSeq = explode('|', $hashSequence);
			
			$hash_string = PAYU_SALT."|".$_REQUEST['status'];
			foreach($hashVarsSeq as $hash_var) {
			  $hash_string .= '|';
			  $hash_string .= isset($_REQUEST[$hash_var]) ? $_REQUEST[$hash_var] : '';				  
			}

			$hash = strtolower(hash('sha512', $hash_string));				
		/* End Hash Key */
			
		$txnidArr = explode("_",$_REQUEST['txnid']);
		if(isset($txnidArr) && $txnidArr[0] > 0)
		{
			$data = array(
					'payu_txnid'=>$_REQUEST['txnid'] ,
					'payu_mihpayid'=>$_REQUEST['mihpayid'],
					'paymentStatus'=>'failure' ,
					'data' => json_encode($_REQUEST),
					'returnTime' => date("Y-m-d H:i:s")
				);

				$this->db->where('id', $txnidArr[0]);
				$this->db->update('tbl_payment',$data); 

				$this->db->where('id', $txnidArr[0]);
				$query  =   $this->db->get('tbl_payment');
				$res = $query->result();

				$payment_res = $res[0];

				$this->session->set_flashdata('msg','Registration Failure !<br>');	
				redirect("/registration/signup");
		}
		else
		{
			$this->session->set_flashdata('msg','Registration Failure !<br>');	
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
