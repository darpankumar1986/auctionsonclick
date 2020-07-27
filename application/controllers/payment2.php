<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment2 extends WS_Controller
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
		$this->load->model('owner_model');		
		//	$this->check_isvalidated();
	}	
		
	
	public function index()
	{
		$paymentId = $this->input->get("txnid");
		if($paymentId != '')
		{
			$payment_res = $this->owner_model->get_tenderfee_payment(base64_decode($paymentId));		
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
		$random = $this->randomString(10);
		$posted = array ('key' => PAYU_MERCHANT_KEY, 'txnid' =>$payudata->id."_".$random, 'amount' => $payudata->payu_amount,
			'firstname' => ucfirst($name), 'email' => $payudata->email_id, 'phone' => $payudata->mobile_no,
			'productinfo' => ucfirst($payudata->type), 'surl' => base_url().'payment2/payment_success/'.$payudata->auctionID, 'furl' => base_url().'payment2/payment_failure/'.$payudata->auctionID);
		
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
			//echo $hash_string;die;
			$data['hash'] = strtolower(hash('sha512', $hash_string));
			$data['action'] = $PAYU_BASE_URL . '/_payment';
		  }
		} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		}
		
		$data['posted'] = $posted;
		
		$this->load->view('payu', $data);
	}

	public function payment_success($actionID) 
	{
		/* Payment success logic goes here. */
	
		$txnidArr = explode("_",$_REQUEST['txnid']);

		$rtxnid = $txnidArr[0];
		$remail = $_REQUEST['email'];
		$ramount = (int)$_REQUEST['amount'];
		
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
		
		
		if(isset($txnidArr) && $txnidArr[0] > 0) // && $hash == $_REQUEST['hash'] 
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
					$tenderId = $row->tenderfeeID;
					$payu_amount = $row->payu_amount;
					$email_id = $row->payu_email;
				}
			}
				
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
						 
						$bidderID = $payment_res->bidderID;
						$auctionID = $payment_res->auctionID;
						$tenderfeeID = $payment_res->tenderfeeID;
						
						
						$rData = array(
							'payment_response'=>json_encode($_REQUEST),
							'payment_status'=>'success',
							'date_modified'=>date('Y-m-d H:i:s')
						);
						
						
						$this->db->where('payment_log_id',$tenderfeeID);
						$this->db->update('tbl_jda_payment_log',$rData);
						
						//data for gst_mis table
						$register_as = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'register_as');
						$city_id = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'city_id');
						$state_id = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'state_id');
						$country_id = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'country_id');		
						
						if($register_as =='builder')
						{
							$customer_name = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'organisation_name');
						}
						else
						{
							$first_name = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'first_name');
							$last_name = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'last_name');
							$customer_name = $first_name.' '.$last_name;
						}
						$address1 = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'address1');
						$address2 = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'address2');
						$cityName = GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
						$stateName = GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
						$countryName = GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');						
						$zip = GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'zip');
						
						$customer_address = $address1;
						if($address2 !='')
						{
							$customer_address .= ', '.$address2;
						}
						$customer_address .= ', '.$cityName.', '.$stateName.', '.$countryName.', '.$zip;
						
						$supplyPlaceName = GetTitleByField('tbl_payment', "id='".$txnidArr[0]."'", 'supply_place');
						$delivery_address = GetTitleByField('tbl_payment', "id='".$txnidArr[0]."'", 'delivery_address');
						$gstin = GetTitleByField('tbl_payment', "id='".$txnidArr[0]."'", 'gst_available');
						$gst_no = GetTitleByField('tbl_payment', "id='".$txnidArr[0]."'", 'gst_no');
						
						$gstMisArr = array(
								'bidder_id'=>$bidderID,
								'auction_id'=>$auctionID,
								'customer_name'=>$customer_name,
								'customer_address'=>$customer_address,
								'supply_place'=>$supplyPlaceName,
								'delivery_address'=>$delivery_address,
								'gst_available'=>$gstin,
								'gst_no'=>$gst_no,
								'service_description'=>'Processing Fee Payment',
								'base_amt'=> SUBMISSION_FEE,
								'tax_rate'=> SUBMISSION_TAX,
								'total_tax_applicable'=> SUBMISSION_TAX_AMOUNT,
								'net_amt_paid'=> SUBMISSION_AMOUNT,
								'payment_date'=>$data['returnTime'],
								'transaction_number'=>$_REQUEST['mihpayid']
						);
						//echo '<pre>';print_r($gstMisArr);die;
						//insert data into gst_mis table
						$this->db->insert('tbl_gst_mis',$gstMisArr);
				
						$this->session->set_flashdata('message','Processing Fee Paid Successfully !<br>');	
						redirect("/owner/auction_participate/".$payment_res->auctionID);
			}else{
					
					$this->db->where('id', $txnidArr[0]);
					$query  =   $this->db->get('tbl_payment');
					$res = $query->result();

					$payment_res = $res[0];

					$this->session->set_flashdata('message_new','Processing Fee Payment Failure ! Please try again<br>');	
					redirect("/owner/auction_participate/".$payment_res->auctionID);
				
			}	
		}
		else
		{
			//$this->session->set_flashdata('message_new','Tender Fee Payment Failure ! Please try again<br>');	
			//redirect("/owner/auction_participate/".$actionID);
			redirect("/registration/logout");
		}	
	}

	public function payment_failure($actionID = 0) 
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
				$query1  =   $this->db->get('tbl_payment');
				$res1 = $query1->result();
				$bidderID = $res1[0]->bidderID;
				$auctionID = $res1[0]->auctionID;
				$tenderfeeID = $res1[0]->tenderfeeID;
				
				
				$rData = array(							
							'payment_status'=>'failure',
							'date_modified'=>date('Y-m-d H:i:s')
						);
						
						
						$this->db->where('payment_log_id',$tenderfeeID);
						$this->db->update('tbl_jda_payment_log',$rData);


				$this->db->where('id', $txnidArr[0]);
				$query  =   $this->db->get('tbl_payment');
				$res = $query->result();

				$payment_res = $res[0];
				
			
				$dataAP['payment_verifier_accepted'] = NULL;
				$dataAP['payment_verifier_comment'] = NULL;
				$dataAP['payment_move_to_opener2'] = 0;
				$dataAP['payment_verifier_accepted_date'] = NULL;
				$dataAP['modify_date']= date('Y-m-d H:i:s');
				$this->db->where('bidderID',$bidderID);
				$this->db->where('auctionID',$auctionID);
				$this->db->update('tbl_auction_participate',$dataAP);	
				$insertedid_id	=1;		
				
				
				$this->db->where('bidderID',$bidderID);
				$this->db->where('auctionID',$auctionID);
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
				
				
				$rData = array(					
					'payment_status'=>'failure',
					'date_modified'=>date('Y-m-d H:i:s')
				);
				
				
				$this->db->where('payment_log_id',$payment_log_id);
				$this->db->where('control_number',$controlNumber);
				$this->db->update('tbl_jda_payment_log',$rData);	

				$this->session->set_flashdata('message_new','Processing Fee Payment Failure ! Please try again<br>');	
				redirect("/owner/auction_participate/".$payment_res->auctionID);
		}
		else
		{
			//$this->session->set_flashdata('message_new','Tender Fee Payment Failure ! Please try again<br>');	
			//redirect("/owner/auction_participate/".$actionID);
			redirect("/registration/logout");
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
