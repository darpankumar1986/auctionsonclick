<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment2 extends WS_Controller
{	
	public function __Construct()
	{
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		//error_reporting(0);
		$this->load->helper('url');
		$this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('home_model');		
		//	$this->check_isvalidated();
	}	
		
	
	public function index()
	{
		$paymentId = $this->input->get("txnid");
		if($paymentId != '')
		{
			$payment_res = $this->home_model->get_subcription_payment(base64_decode($paymentId));		
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
						$package_id = $payment_res->auctionID;
						$state_str = $payment_res->state;
						$package_type = $payment_res->package_type;
						$paid_amount = $payment_res->payu_amount;
						$email_id = $payment_res->payu_email;

						$stateArr = array();
						if($state_str != '')
						{
							$stateArr = explode(',',$state_str);
						}

					
						$this->db->where('package_id', $package_id);
						$query = $this->db->get("tbl_subscription_package");
						$package = $query->row();

						if($package_type == 1) // Previous Subscrition Expired
						{
							$row = $this->home_model->getCurrentPackage($bidderID);
							
							$this->db->where('subscription_participate_id', $row->subscription_participate_id);
							$this->db->update("tbl_subscription_participate",array('package_end_date'=>date('Y-m-d H:i:00')));

							$this->db->where('subscription_participate_id', $row->subscription_participate_id);
							$this->db->update("tbl_subscription_participate_city",array('sub_end_date'=>date('Y-m-d H:i:00')));

							if($package_id > 3 && count($stateArr) > 2)
							{
								$package->package_amount += (count($stateArr) - 2) * $package->city_per_cost;
							}

							/* credit amount */
							$log_data = array(
								'subscription_participate_id'=>$row->subscription_participate_id,
								'member_id'=>$bidderID,
								'payment_id'=>0,
								'amount'=>$package->package_amount-$paid_amount,
								'remarks' =>'Upgrade - Add Credit',
								'status' => 1,
								'indate' => date("Y-m-d H:i:s")
							);
							$this->db->insert('tbl_subscription_log',$log_data);

							
							
						}

						if($package_type == 3) // add more state
						{
							$row = $this->home_model->getCurrentPackage($bidderID);
							$startDate = $row->package_start_date;
							$endDate = $row->package_end_date;

							$this->db->where('subscription_participate_id', $row->subscription_participate_id);
							$this->db->update("tbl_subscription_participate",array('package_amount'=>$row->package_amount+$paid_amount));					

							$subscription_participate_id = $row->subscription_participate_id;
							$remarks = "State - Add State";
						}
						else if($package_type == 2 && strtotime($row->package_end_date) < time()) // renew
						{
							$row = $this->home_model->getCurrentPackage($bidderID);
							$startDate = date('Y-m-d 00:00:00',strtotime($row->package_end_date) + 10);


							$endDate = date('Y-m-d 23:59:59',strtotime("+".$package->sub_month." months",strtotime($startDate)-86400));
							//$endDate = date('Y-m-d 23:59:59',strtotime("+3 days",strtotime($startDate)));							
							$remarks = "Renew - Add Package";
							$package->package_amount = $paid_amount;
						}
						else
						{
							$startDate = date('Y-m-d 00:00:00');
							$endDate = date('Y-m-d 23:59:59',strtotime("+".$package->sub_month." months")-86400);
							//$endDate = date('Y-m-d 23:59:59',strtotime("+3 days"));

							
							$remarks = "New - Add Package";
						
							if($package_type == 2 && strtotime($row->package_end_date) > time())
							{
								$remarks = "Renew after expired - Add Package";
								$package->package_amount = $paid_amount;
							}
							else if($package_type == 1)
							{
								$remarks = "Upgrade - Add Package";
							}
							else
							{
								$package->package_amount = $paid_amount;
							}

						}

						if($package_type != 3)
						{
							$participated_data = array(
							'member_id'=>$bidderID,
							'package_id'=>$package_id,
							'package_amount'=>$package->package_amount,
							'package_start_date' => $startDate,
							'package_end_date' => $endDate,
							'subscription_status' => 1,
							'subscription_created_on' => date("Y-m-d H:i:s")
							);

							$this->db->insert('tbl_subscription_participate',$participated_data);
							$subscription_participate_id = $this->db->insert_id();
						}

						$stateLogArr = array();
						$this->db->where('status', 1);
						$query = $this->db->get("tbl_state");
						foreach($query->result() as $state)
						{
							if(($package->package_city == "0" && $package_id < 4) || in_array($state->id,$stateArr))
							{
								$stateLogArr[] = $state->id;
								$participated_city_data = array(
									'subscription_participate_id'=>$subscription_participate_id,
									'member_id'=>$bidderID,
									'sub_state_id'=>$state->id,
									'package_id'=>$package_id,
									'sub_start_date' => $startDate,
									'sub_end_date' => $endDate,
									'sub_status' => 1,
									'sub_type' => 'package',
									'sub_created_on' => date("Y-m-d H:i:s")
								);

								$this->db->insert('tbl_subscription_participate_city',$participated_city_data);
							}
						}

						
						if($package_type == 3) // State - Add state
						{
							$package->package_amount = $paid_amount;
						}
						

						/* debit amount */
						$log_data = array(
							'subscription_participate_id'=>$subscription_participate_id,
							'member_id'=>$bidderID,
							'payment_id'=>0,
							'amount'=>-1*$package->package_amount,
							'remarks' => $remarks,
							'status' => 1,
							'indate' => date("Y-m-d H:i:s")
						);
						$this->db->insert('tbl_subscription_log',$log_data);

						/* credit amount */
						$log_data = array(
							'subscription_participate_id'=>$subscription_participate_id,
							'member_id'=>$bidderID,
							'payment_id'=>$txnidArr[0],
							'amount'=>$paid_amount,
							'remarks' =>'Payment - Paid Successfully',
							'status' => 1,
							'indate' => date("Y-m-d H:i:s")
						);
						$this->db->insert('tbl_subscription_log',$log_data);
						$subscription_log_id = $this->db->insert_id();



						/* add state log */
						if(is_array($stateLogArr))
						{
							foreach($stateLogArr as $state_id)
							{
								$log_data = array(
									'subscription_log_id'=>$subscription_log_id,
									'member_id'=>$bidderID,
									'payment_id'=>$txnidArr[0],
									'subscription_participate_id'=>$subscription_participate_id,
									'sub_state_id'=>$state_id
								);
								$this->db->insert('tbl_subscription_state_log',$log_data);
							}
						}


						$emailData['userid'] = $bidderID;
						$emailData['paid_amount'] = $paid_amount;
						$emailData['order_date'] = date("Y-m-d H:i:s");
						$emailData['ip'] = $payment_res->ip;
						$emailData['order'] = $txnidArr[0];
						$emailData['response'] = json_decode($payment_res->data);						
						/* Email */

						$subject = 'Your order#'.$emailData['order'].' on www.AuctionOnClick.com is successful.';
						$emailData['Logo'] = $this->load->view('email/Logo', $emailData, true); // render the view into HTML
						$body = $this->load->view('email/subscription', $emailData, true); // render the view into HTML

						$data = array(
								"member_id"=>$bidderID,
								"email"=>$email_id,
								"subject"=>$subject,
								"message"=>$body,
								"email_type"=>5,
								"indate"=>date('Y-m-d H:i:s')
							);
						$this->db->insert('tbl_email_log',$data);
						$email_log_id = $this->db->insert_id();

						$this->load->library('Email_new','email');
						$email_obj = new email_new();
						$ret = $email_obj->sendMailToUser(array($email_id),$subject,$body); 

						if($ret)
						{
							$this->db->where('email_id',$email_log_id);
							$this->db->update('tbl_email_log',array("is_sent"=>1));
						}
                        

						
						
						/* Email */



						$this->session->set_flashdata('message','Subscription Payment Paid Successfully !<br>');	

						/* login after payment */
						$this->db->where('id', $bidderID);
						$row_query = $this->db->get('tbl_user_registration');
						$row = $row_query->result();

						$this->session->set_userdata('id', $row[0]->id);
						$this->session->set_userdata('full_name', $row[0]->first_name);	
						$this->session->set_userdata('user_type', trim($row[0]->user_type));
						$rand = rand(10000000000,99999999999);
						$this->session->set_userdata('session_id_user',$rand);
						$this->session->set_userdata('table_session', 'registration_tb');

						$setarray=array('user_sess_val'=> $rand);
				        $this->db->where('id',$row[0]->id);
		                $this->db->update('tbl_user_registration',$setarray);
						/* end login after payment */

						redirect("home/success");
			}else{
					
					$this->session->set_flashdata('message_new','Subscription Payment Failure ! Please try again<br>');	
					redirect("home/premiumServices");
				
			}	
		}
		else
		{
			//redirect("/registration/logout");
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
				
				
				

				$this->db->where('id', $txnidArr[0]);
				$query  =   $this->db->get('tbl_payment');
				$res = $query->result();

				$payment_res = $res[0];
				
			
				/* login after payment */
					$this->db->where('id', $bidderID);
					$row_query = $this->db->get('tbl_user_registration');
					$row = $row_query->result();

					$this->session->set_userdata('id', $row[0]->id);
					$this->session->set_userdata('full_name', $row[0]->first_name);	
					$this->session->set_userdata('user_type', trim($row[0]->user_type));
					$rand = rand(10000000000,99999999999);
					$this->session->set_userdata('session_id_user',$rand);
					$this->session->set_userdata('table_session', 'registration_tb');

					$setarray=array('user_sess_val'=> $rand);
					$this->db->where('id',$row[0]->id);
					$this->db->update('tbl_user_registration',$setarray);
				/* end login after payment */
			
					
			
		
				if($res1[0]->package_type > 0)
				{
					$this->session->set_flashdata('message_new','Subcription Payment Failure ! Please try again<br>');	
					redirect("/owner/manageSubscription");
				}
				else
				{
					$this->session->set_flashdata('message_new','Subcription Payment Failure ! Please try again<br>');	
					redirect("/home/premiumServices/");
				}
		}
		else
		{
			//$this->session->set_flashdata('message_new','Tender Fee Payment Failure ! Please try again<br>');	
			//redirect("/owner/auction_participate/".$actionID);
			//redirect("/registration/logout");
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
