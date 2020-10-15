<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

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
		
		$path = dirname(__FILE__);
		include_once($path.'/../libraries/icici/config.php');
		include_once($path.'/../libraries/icici/razorpay-php/Razorpay.php');

		session_start();

		// Create the Razorpay Order		

		$api = new Api($keyId, $keySecret);

		//
		// We create an razorpay order using orders api
		// Docs: https://docs.razorpay.com/docs/orders
		//
		$orderData = array(
			'receipt'         => $payudata->id,
			'amount'          => $payudata->payu_amount * 100, // 2000 rupees in paise
			'currency'        => 'INR',
			'payment_capture' => 1 // auto capture
		);

		$razorpayOrder = $api->order->create($orderData);

		$razorpayOrderId = $razorpayOrder['id'];

		$_SESSION['razorpay_order_id'] = $razorpayOrderId;

		$displayAmount = $amount = $orderData['amount'];

		if ($displayCurrency !== 'INR')
		{
			$url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
			$exchange = json_decode(file_get_contents($url), true);

			$displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
		}

		$checkout = 'orders';

		if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
		{
			$checkout = $_GET['checkout'];
		}

		$random = $this->randomString(10);
		
		$data = [
			"key"               => $keyId,
			"amount"            => $amount,
			"name"              => ucfirst($name),
			"description"       => "AuctionOnClick - Subscription Plan",
			"image"             => "https://auctiononclick.com/assets/auctiononclick/images/Logo.png",
			"prefill"           => [
			"name"              => ucfirst($name),
			"email"             => $payudata->email_id,
			"contact"           => $payudata->mobile_no,
			],
			"notes"             => [
			"address"           => $payudata->address1.' '.$payudata->city_id.' - '.$payudata->zip.' India',
			"merchant_order_id" => $payudata->id."_".$random,
			],
			"theme"             => [
			"color"             => "#005ca8"
			],
			"order_id"          => $razorpayOrderId,
		];

		if ($displayCurrency !== 'INR')
		{
			$data['display_currency']  = $displayCurrency;
			$data['display_amount']    = $displayAmount;
		}

		$data1['json'] = json_encode($data);
		
		$this->db->where('id',$payudata->id);
		$this->db->update('tbl_payment',array("payu_mihpayid"=>$razorpayOrderId));

	
		$this->load->view('icici', $data1);

		
	}


	public function payment_success($actionID) 
	{
		$path = dirname(__FILE__);
		include_once($path.'/../libraries/icici/config.php');
		include_once($path.'/../libraries/icici/razorpay-php/Razorpay.php');
		
		$success = true;

		$error = "Payment Failed";
		
	
		if (empty($_POST['razorpay_payment_id']) === false)
		{
			@session_start();
			$api = new Api($keyId, $keySecret);

			try
			{
				// Please note that the razorpay order ID must
				// come from a trusted source (session here, but
				// could be database or something else)
				$attributes = array(
					'razorpay_order_id' => $_SESSION['razorpay_order_id'],
					'razorpay_payment_id' => $_POST['razorpay_payment_id'],
					'razorpay_signature' => $_POST['razorpay_signature']
				);

				$api->utility->verifyPaymentSignature($attributes);

				$payment = $api->payment->fetch($_POST['razorpay_payment_id']);

 				$paymentdata['id'] = $payment->id;
				$paymentdata['entity'] = $payment->entity;
				$paymentdata['amount'] = $payment->amount;
				$paymentdata['currency'] = $payment->currency;
				$paymentdata['status'] = $payment->status;
				$paymentdata['order_id'] = $payment->order_id;
				$paymentdata['invoice_id'] = $payment->invoice_id;
				$paymentdata['international'] = $payment->international;
				$paymentdata['method'] = $payment->method;
				$paymentdata['refund_status'] = $payment->refund_status;
				$paymentdata['captured'] = $payment->captured;
				$paymentdata['description'] = $payment->description;
				$paymentdata['card_id'] = $payment->card_id;
				$paymentdata['bank'] = $payment->bank;
				$paymentdata['wallet'] = $payment->wallet;
				$paymentdata['vpa'] = $payment->vpa;
				$paymentdata['email'] = $payment->email;
				$paymentdata['contact'] = $payment->contact;

				$paymentdata['address'] = $payment->notes->address;
				$paymentdata['merchant_order_id'] = $payment->notes->merchant_order_id;

				$paymentdata['fee'] = $payment->fee;
				$paymentdata['tax'] = $payment->tax;
				$paymentdata['error_code'] = $payment->error_code;
				$paymentdata['error_description'] = $payment->error_description;
				$paymentdata['error_source'] = $payment->error_source;
				$paymentdata['error_step'] = $payment->error_step;
				$paymentdata['auth_code'] = $payment->acquirer_data->auth_code;
				$paymentdata['created_at'] = $payment->created_at;

				$paymentdata = (object)$paymentdata;



				$data = array(
								'data' => json_encode($paymentdata)
								);

				$this->db->where('payu_mihpayid',$paymentdata->order_id);
				$this->db->update('tbl_payment',$data);
			}
			catch(SignatureVerificationError $e)
			{
				$success = false;
				$error = 'Razorpay Error : ' . $e->getMessage();
			}
		}

		if ($success === true)
		{
			$this->db->where('payu_mihpayid',$paymentdata->order_id);
			$q = $this->db->get('tbl_payment');
			$row = $q->row();
		
			//echo  $_SESSION['razorpay_order_id'];die;
			//$html = "<p>Your payment was successful</p>
			//		 <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
		

	
		
				$txnidArr[0] = $row->id;

				$rtxnid = $txnidArr[0];
				$remail = $row->payu_email;
				$ramount = (int)$row->payu_amount;
				
					
				if(isset($txnidArr) && $rtxnid > 0) // && $hash == $_REQUEST['hash'] 
				{
					
					
				
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
						
					if(($txnid == $rtxnid) && ($remail == $email_id))  // Payment Success with Database Verification
					{
						
						
							$data = array(
								'payu_txnid'=>$_POST['razorpay_payment_id'],
								'paymentStatus'=>'success' ,
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
								$emailData['bank_ref_num'] = $_POST['razorpay_payment_id'];
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
		else
		{
			$this->db->where('payu_mihpayid',$_SESSION['razorpay_order_id']);
			$q = $this->db->get('tbl_payment');
			$row = $q->row();
		

			$txnidArr[0] = $row->id;

			if(isset($txnidArr) && $txnidArr[0] > 0)
			{
				$data = array(
						'payu_txnid'=>$_POST['razorpay_payment_id'],						
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
				
				
			//$html = "<p>Your payment failed</p>
				//	 <p>{$error}</p>";
		}
	}

	public function payment_failure($order_id = 0) 
	{
	
		
		/* Payment failure logic goes here. */
		//echo "We are sorry. The Payment has failed";
		
		
		
		$this->db->where('payu_mihpayid',$order_id);
		$q = $this->db->get('tbl_payment');
		$row = $q->row();
		
		$txnidArr[0] = $row->id;
		
		if(isset($txnidArr) && $txnidArr[0] > 0)
		{
			$data = array(
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
