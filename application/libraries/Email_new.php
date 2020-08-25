<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
  class Email_new extends CI_Model
  {
	    
		
		//private $host = 'smtp.c1india.com';
		private $host = 'smtp.rediffmailpro.com';
		private $port = '587';
		private $smtpsecure = '';
		
		private $username = 'noreply@c1india.com';
		private $password = 'Orange@321';
        
  
  
  
public function sendMailToUser($emailArr,$sub,$message,$attachment_path = "",$cc_email = array())
{
		//print_r($message);die;
		//$email = 'dheeraj.kumar@c1india.com';
       //Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;  //3 dibugging
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = $this->host;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $this->port;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail->Username = $this->username;
		//Password to use for SMTP authentication
		$mail->Password = $this->password;

		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = $this->smtpsecure;                           
		  

		//Set who the message is to be sent from
		$mail->setFrom($this->username, 'AuctionOnClick');
		
		//Set an alternative reply-to address
		//$mail->addReplyTo($this->username, 'C1india');
		
		//$mail->AddCC('person1@domain.com', 'Person One');
		
		//Set who the message is to be sent to
		foreach($emailArr as $email)
		{
			$mail->addAddress($email);
		}
		//Set the subject line
		$mail->Subject = $sub;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail->msgHTML($message);
		//Replace the plain text body with one created manually
		//$mail->AltBody = $message;
		//Attach an image file
		if($attachment_path != '')
        {
			$mail->addAttachment($attachment_path);
		}

		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		//send the message, check for errors
		
		if (!$mail->send()) {			
			//echo "Mailer Error: " . $mail->ErrorInfo;
			$res = 0;
		} else {			
			//echo "Message sent!";
			$res = 1;
		}
		
		//$res =1;
		return $res;
}  
      
/*		
public function sendMailToUser($email,$sub,$message,$attachment_path = "",$cc_email = array())
{
        //$email = array('azizur.rahman@c1india.com');
        //$cc_email = array('neeraj.jain@c1india.com');

        //$cc_email = array('darpan.kumar@c1india.com','saurabh.paul@c1india.com');

        $transport = Swift_SmtpTransport::newInstance($this->host,$this->port,$this->smtpsecure)->setUsername($this->username)->setPassword($this->password);
		
        $mailer = Swift_Mailer::newInstance($transport);
		
        // Create a message
        $message = Swift_Message::newInstance($sub)->setFrom(array('noreply@c1india.com' => 'C1india'))
                                        ->setTo($email)
                                        ->setBody($message, "text/html");

        if(count($cc_email) > 0)
        {				
                $message->setCc($cc_email);
        }

        if($attachment_path != '')
        {				
                $message->attach(Swift_Attachment::fromPath($attachment_path));
        }

       $res = $mailer->send($message); //Uncomment for sending the mail.		
       // $res = 1;
        return $res;		
}
*/
	
	 function sendMailForTesting($auctionID)
    { 
        $subject = "Re: Testing Purpose";   
        $message    = "Dear sir, This is testing mail";
        $emailArr = array();
        $emailArr[] = 'azizurrahman181@gmail.com';
        $emailArr[] = 'dheeraj.kumar@c1india.com';

        if(is_array($emailArr) && count($emailArr)>0)
        {
            $result = $this->sendMailToUser($emailArr, $subject, $message);         
        }
         	
        return $result;		
    }
    
	
		
function sendMailToHelpdeskForOpeningStatus($auctionID)
    {

        $this->load->model('banker_model');
/*
        $subject = 'BOM Vs Mrs.Tania Raha & Shri Dipak Raha: Provide necessary training to Qualified Bidders to participate in e-Bidding Process ';
				
        $html = '';
        $html .= 'To<br/>';
        $html .= 'The Help Desk,<br/>';
		$html .= 'C1 India Pvt. Ltd.<br/><br/>';

        $html .= 'The following bidders have been qualified by bank to participate in the e-Bidding Process. Therefore, request you to do the needful to provide them necessary training on e-Auction.<br/><br/>';
				
    if($auctionID != '')
    {
        $this->db->where('auctionID =', $auctionID);
        $this->db->where('final_submit =', '1');
        $query = $this->db->get("tbl_auction_participate");
        $data = array();
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                //$row->user_id=$this->GetAssignedUser($row->id);
                $datam = $this->banker_model->getUserValue($row->bidderID);
                //print_r($datam);
                $html .= 'NAME: '.$datam[0]->first_name.' '.$datam[0]->last_name.'<br/>';
                $html .= 'MOBILE NO.: '.$datam[0]->mobile_no.'<br/>';
                
                if(isset($datam[0]->phone_no) && $datam[0]->phone_no !='')
                {
                    $html .= 'ALTERNATE NO.: '.$datam[0]->phone_no.'<br/>';
                }else{
                    $html .= 'ALTERNATE NO.: NA<br/>';
                }
                
                $html .= 'E-MAIL ID.: '.$datam[0]->email_id.'<br/>';

                if(isset($row->operner2_accepted) && $row->operner2_accepted !='')
                {
                    if($row->operner2_accepted == '1')
                    {
                        $html .= 'Qualified.: YES<br/>';
                    }else{
                        $html .= 'Qualified.: NO<br/>';
                    }	
                        $html .= 'Comment.: '.$row->operner2_comment.'<br/>';
                }else{
                    if($row->operner1_accepted == '1')
                    {
                            $html .= 'Qualified.: YES<br/>';
                    }else{
                            $html .= 'Qualified.: NO<br/>';
                    }	
                    $html .= 'Comment.: '.$row->operner1_comment.'<br/>';
                }

                $html .= '<br/>';
                $data[] = $row;
            }
                        //return $data;
        }
    }
    
    $html .= '<br/>';
    $html .= '<strong>Sd/- Authorised Officer</strong><br/>';	
    $html .= 'Branch: '.$this->banker_model->getBranchName($auctionID).'<br/>';
    $html .= 'City: '.$this->banker_model->getCityName($auctionID).'<br/><br/>';


    $html .= '<strong>This is an auto generated email; please do not reply.</strong>';					
*/
        
    
    if($auctionID != '')
    {
        $this->db->where('auctionID =', $auctionID);
        $this->db->where('final_submit =', '1');
        $query = $this->db->get('tbl_auction_participate');
        $data = array();
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                //$row->user_id=$this->GetAssignedUser($row->id);
                $datam = $this->banker_model->getUserValue($row->bidderID);
                //print_r($datam);
                $conditional_data .= 'NAME: '.$datam[0]->first_name.' '.$datam[0]->last_name.'<br/>';
                $conditional_data .= 'MOBILE NO.: '.$datam[0]->mobile_no.'<br/>';
                
                if(isset($datam[0]->phone_no) && $datam[0]->phone_no !='')
                {
                    $conditional_data .= 'ALTERNATE NO.: '.$datam[0]->phone_no.'<br/>';
                }else{
                    $conditional_data .= 'ALTERNATE NO.: NA<br/>';
                }
                
                $conditional_data .= 'E-MAIL ID.: '.$datam[0]->email_id.'<br/>';

                if(isset($row->operner2_accepted) && $row->operner2_accepted !='')
                {
                    if($row->operner2_accepted == '1')
                    {
                        $conditional_data .= 'Qualified.: YES<br/>';
                    }else{
                        $conditional_data .= 'Qualified.: NO<br/>';
                    }	
                        $conditional_data .= 'Comment.: '.$row->operner2_comment.'<br/>';
                }else{
                    if($row->operner1_accepted == '1')
                    {
                            $conditional_data .= 'Qualified.: YES<br/>';
                    }else{
                            $conditional_data .= 'Qualified.: NO<br/>';
                    }	
                    $conditional_data .= 'Comment.: '.$row->operner1_comment.'<br/>';
                }

                $conditional_data .= '<br/>';
                $data[] = $row;
            }
                        //return $data;
        }
    }
        
        
        $this->db->select('subject, msg');
        $this->db->where('email_template_id', 4);
        $this->db->where('status', 1);
        $email_query = $this->db->get('tblmst_email_template')->result();

        $subject = $email_query[0]->subject;
        $body = $email_query[0]->msg;

        $body = str_replace("%conditional_data%",$conditional_data, $body);
        $body = str_replace("%branch_name%",$this->banker_model->getBranchName($auctionID), $body);
        $body = str_replace("%city_name%",$this->banker_model->getCityName($auctionID), $body);
        //echo $body; exit;
    //$emailArr[] = 'darpan.kumar@c1india.com';
    //$emailArr[] = 'neeraj.jain@c1india.com';
    //$emailArr[] = 'saurabh.paul@c1india.com';
    //$emailArr[] = 'vijay.sharma@c1india.com';
 

    //return $this->sendMailToUser($emailArr,'BankeAuction Helpdesk',$html);
    return $this->sendMailToUser($emailArr,$subject,$body);

}
		
		function sendMailToHelpdeskForOpeningStatus1($auctionID)
		{
			

		
		}
		
function sendMailToBidderForOpeningStatus($auctionID)
{ 
	$participate_id = $this->input->post('participate_id');
	$bid_acceptance = $this->input->post('bid_acceptance');
	$txtComment = $this->input->post('txtComment');
		
	//echo "<pre>";print_r($participate_id);
	
    if($auctionID != '')
    { 
        $auctionData = "";
        $this->db->where('id =', $auctionID);
        $query = $this->db->get("tbl_auction");
        
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $auctionData = $row;
            }
        }

        $this->db->where('auctionID =', $auctionID);
        $this->db->where_in('id',$participate_id);
        //$this->db->where('final_submit =', '1');
        $query = $this->db->get("tbl_auction_participate"); 
        
        $data = array();
        if ($query->num_rows() > 0) 
            {				
                foreach ($query->result() as $row) 
                {
                    if(($auctionData->second_opener > 0 && $row->operner2_accepted == 1))
                        {
                            $auction_start_time = date("H:i:s",strtotime($auctionData->auction_start_date));
                            $auction_start_date = date("d-m-Y",strtotime($auctionData->auction_start_date));
                            $auction_end_time = date("H:i:s",strtotime($auctionData->auction_end_date));
                            $auction_end_date = date("d-m-Y",strtotime($auctionData->auction_end_date));

                            $datam = $this->banker_model->getUserValue($row->bidderID);
                            
                            
                            $user_type = GetTitleByField('tbl_user_registration', 'id="'.$row->bidderID.'"', 'user_type');              
		   
							if($user_type =='builder')
							{
								$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$row->bidderID.'"', 'authorized_person');
							}
							else
							{
								$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$row->bidderID.'"', 'first_name')." ".GetTitleByField('tbl_user_registration', 'id="'.$row->bidderID.'"', 'last_name');
							}
                            
                            
                            
                            //Email template
                            $this->db->select('subject, msg');
                            $this->db->where('email_template_id', 1);
                            $this->db->where('status', 1);
                            $email_query = $this->db->get('tblmst_email_template')->result();
                            
                            $subject = $email_query[0]->subject;
                            $body = $email_query[0]->msg;
                            
                            $body = str_replace("%first_name%",$bidder_name, $body);
                            $body = str_replace("%auction_id%",$auctionData->id, $body);
                            $body = str_replace("%auction_start_time%",$auction_start_time, $body);
                            $body = str_replace("%auction_start_date%",$auction_start_date, $body);
                            $body = str_replace("%auction_end_time%",$auction_end_time, $body);
                            $body = str_replace("%auction_end_date%",$auction_end_date, $body);
                            $body = str_replace("%branch_name%",$this->banker_model->getBranchName($auctionID), $body);
                            $body = str_replace("%city_name%",$this->banker_model->getCityName($auctionID), $body);
   
                            $emailArr = array();
                            $emailArr[] = $datam[0]->email_id; // Uncomment First


                            //$emailArr[] = 'neeraj.jain@c1india.com';
                          
                             //SMS Template
                        $this->db->select('msg');
                        $this->db->where('sms_template_id', 1);
                        $this->db->where('status', 1);
                        $sms_query = $this->db->get('tblmst_sms_template')->result();
                        
                        $message = $sms_query[0]->msg;
                        $message = str_replace("%first_name%",$bidder_name, $message);
                        $message = str_replace("%auction_ref_no%",$auctionData->reference_no, $message);
                        $mobileNo = $datam[0]->mobile_no;
                        $expDate = date('Y-m-d H:i:s');
                        $smsData = array( 
                            'mobile' => $mobileNo,
                            'SMSMessage' => $message,	
                            'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
                        );
                        
                        if($mobileNo !=''){
							$datam = $this->sendSMS($smsData); // Uncomment this to send SMS
						}  
                        if(is_array($emailArr) && count($emailArr)>0)
						{
							$this->sendMailToUser($emailArr,$subject,$body);
  					    }
                        }else{
                            //if((($auctionData->second_opener != '') && $row->operner2_accepted == 0) || ( !($auctionData->second_opener > 0) && $row->operner1_accepted == 0))

                            $auction_start_time = date("H:i:s",strtotime($auctionData->auction_start_date));
                            $auction_start_date = date("d-m-Y",strtotime($auctionData->auction_start_date));

                            $datam = $this->banker_model->getUserValue($row->bidderID);
                            
                            //Email template
                            $this->db->select('subject, msg');
                            $this->db->where('email_template_id', 2);
                            $this->db->where('status', 1);
                            $email_query = $this->db->get('tblmst_email_template')->result();
  
                            $subject = $email_query[0]->subject;
                            $body = $email_query[0]->msg;
                           
                            $body = str_replace("%auction_reject_comment%",$row->operner2_comment, $body);
                            $body = str_replace("%auction_ref_no%",$auctionData->reference_no, $body);
                           
                            $emailArr1 = array();
                            $emailArr1[] = $datam[0]->email_id; // Uncomment First
                            

                        //$emailArr1[] = 'azizur.rahman@c1india.com';
                        
                        //SMS Template
                        $this->db->select('msg');
                        $this->db->where('sms_template_id', 2);
                        $this->db->where('status', 1);
                        $sms_query = $this->db->get('tblmst_sms_template')->result();
                        
                        $message = $sms_query[0]->msg;
                        $message = str_replace("%first_name%",$datam[0]->first_name, $message);
                        $message = str_replace("%auction_ref_no%",$auctionData->reference_no, $message);
                        $mobileNo = $datam[0]->mobile_no;
                        $expDate = date('Y-m-d H:i:s');
                        $smsData = array( 
                            'mobile' => $mobileNo,
                            'SMSMessage' => $message,	
                            'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
                        );
                       
                        if($mobileNo !=''){
							$datam = $this->sendSMS($smsData); // Uncomment this to send SMS
                        }
                        
                        if(is_array($emailArr1) && count($emailArr1)>0)
						{
							$this->sendMailToUser($emailArr1,$subject,$body);         
						}
                    }


                }						
            }
    }			
    return true;		
}
		
function sendMailToUserCreatedBYAdmin($email_id, $password="root@123")
{
    $this->db->where('email_id =', $email_id);
    $query = $this->db->get("tbl_user");

    if ($query->num_rows() > 0) 
    {
        foreach ($query->result() as $row) 
        {
            $user_data = $row;
        }
    }

    $this->db->select('subject, msg');
    $this->db->where('email_template_id', 3);
    $this->db->where('status', 1);
    $email_query = $this->db->get('tblmst_email_template')->result();

    $subject = $email_query[0]->subject; 
    $body   = $email_query[0]->msg;

    $body   = str_replace("%first_name%", ucfirst($user_data->first_name), $body);    
    $body   = str_replace("%last_name%", ucfirst($user_data->last_name), $body);
    $body   = str_replace("%user_id%", $user_data->user_id, $body);
    $body   = str_replace("%email_id%", $email_id, $body);
    $body   = str_replace("%password%", $password, $body);
    
    //SMS Template
    $this->db->select('msg');
    $this->db->where('sms_template_id', 3);
    $this->db->where('status', 1);
    $sms_query = $this->db->get('tblmst_sms_template')->result();

    $message = $sms_query[0]->msg;
    $message = str_replace("%first_name%",$user_data->first_name, $message);
    $mobileNo = $user_data->mobile_no;
    $expDate = date('Y-m-d H:i:s');
    $smsData = array( 
        'mobile' => $mobileNo,
        'SMSMessage' => $message,	
        'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
    );
    
	if($mobileNo !=''){
		$datam = $this->sendSMS($smsData); // Uncomment this to send SMS
	}
    $emailArr[] = $email_id;
    
    if(is_array($emailArr) && count($emailArr)>0)
	{
		$this->sendMailToUser($emailArr,$subject,$body);         
	}	
}
		
function backendCorrigendumSendMail($auctionID,$pModified_date=null)
{
		
			$this->db->where('auctionID', $auctionID);
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get("tbl_auction_corrigendum_approval");
			if ($query->num_rows() > 0) {	
				foreach ($query->result() as $row) 
				{
					if($row->first_approver_id > 0)
					{
						 $emailArr[] = GetTitleByField('tbl_user', "id='$row->first_approver_id'", 'email_id');
					}
					
					if($row->second_approver_id > 0)
					{
						 $emailArr[] = GetTitleByField('tbl_user_registration', "id='$row->second_approver_id'", 'email_id');
					}
					
					 //$emailArr[] = "neeraj.jain@c1india.com";
					
					if(is_array($emailArr) && count($emailArr) > 0)
					{
						
						$this->db->where('id', $auctionID);
						$this->db->order_by('id', 'DESC');
						$this->db->limit(1);
						$auction_query = $this->db->get("tbl_auction");
						$auctionData = $auction_query->result();
						$modified_date = $auctionData[0]->modified_date;
						
						$data = (array)$row;
						
						$changeStr = '';
						$changeStr .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">';
						$changeStr .= "<tr><th>Fieldname</td>";
						$changeStr .= "<th>Previous(".$pModified_date.")</th>";
						$changeStr .= "<th>Current(".$auctionData[0]->modified_date.")</th></tr>";						
			
						
						if($data["event_type"] != $data["event_type_old"])
								{
									$changeStr .= '<tr><td align="left">Account</td>';
									$changeStr .= '<td align="left">'.$data["event_type_old"].'</td>';
									$changeStr .= '<td align="left">'.$data["event_type"].'</td></tr>';
								}						
								
								if($data["reference_no"] != $data["reference_no_old"])
								{
									$changeStr .= '<tr><td align="left">Reference No</td>';
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
								
								if($data["dsc_enabled"] != $data["dsc_enabled_old"])
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
						
						
						
						$changeStr .= '</table><br/><br/>';
				
						$html .= 'Dear Approver,<br/><br/>';
						
						$html .= 'In reference to EventID -'.$auctionID.', this is to inform you that  following changes are done from admin section as per requirement.<br/><br/>';
						
						$html .= $changeStr;
						
						$html .= 'Regards,<br/>';
						$html .= 'Admin<br/>';
						 
						
						$html .= '<strong>This is an auto generated email; please do not reply.</strong>';
						
						$this->sendMailToUser($emailArr,BRAND_NAME.' Helpdesk',$html);
					}
				}
			}		
		}
  
    function sendMailToBidderAfterFinalSubmission($auctionID, $bidderId)
    {
        $bidder_id = $this->session->userdata('id');
        
        if($auctionID != '' && $bidderId == $bidder_id)
        {  
            #Bidder Details
            
            $user_type = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'user_type');              
		   
			if($user_type =='builder')
			{
				$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'authorized_person');
			}
			else
			{
				$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'first_name')." ".GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'last_name');
			}
            
            $bidder_email_id    = GetTitleByField('tbl_user_registration', "id='".$bidderId."'", 'email_id');
            $bidder_mobile_no   = GetTitleByField('tbl_user_registration', "id='".$bidderId."'", 'mobile_no');
            $reference_no       = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
 
            #Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 5);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();

            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;

            $body = str_replace("%bidder_name%",$bidder_name, $body);
            $body = str_replace("%auction_ref_no%",$reference_no, $body);
            
            $emailArr = array();
            $emailArr[] = $bidder_email_id; // Uncomment First 
           
            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 5);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();

            $message = $sms_query[0]->msg;
            $message = str_replace("%bidder_name%", $bidder_name, $message);
            $message = str_replace("%auction_ref_no%", $reference_no, $message);
            $mobileNo = $bidder_mobile_no;
            $expDate = date('Y-m-d H:i:s');
            $smsData = array( 
                'mobile' => $mobileNo,
                'SMSMessage' => $message,	
                'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
            ); 

            if($mobileNo != ""){
                $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
            }

            if(is_array($emailArr) && count($emailArr)>0)
			{
				$this->sendMailToUser($emailArr,$subject,$body);         
			}         
        }	
        return true;		
    }
    
    function sendMailToApproverForApprovingAuction($auctionID)
    { 
        $creator_id = $this->session->userdata('id');
        if($auctionID != '')
        {  
            $reference_no       = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
            $creator_name       = GetTitleByField('tbl_user', "id='".$creator_id."'", 'first_name');

            #Approver Details 
            $this->db->select('user_id');
            $this->db->where('role_id', '2');
            $this->db->where('status', '1');
            $query = $this->db->get('tbl_user_department')->result();
            
            foreach($query as $key=>$value){
                
                //Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 6);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();
            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;
            
            $email_id = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'email_id');
            $mobile_no = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'mobile_no');
            $first_name = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'first_name');
            
            
            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 6);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();
            $message = $sms_query[0]->msg;
                
                $body = str_replace("%approver_name%", $first_name, $body);
                $body = str_replace("%creator_name%", $creator_name, $body);
                $body = str_replace("%auction_ref_no%", $reference_no, $body);
                $emailArr = array();                
                $emailArr[] = $email_id; // Uncomment First 
				
                $message = str_replace("%approver_name%", $first_name, $message);
                $message = str_replace("%auction_ref_no%", $reference_no, $message);
                $mobileNo = $mobile_no;
                $expDate = date('Y-m-d H:i:s');
                $smsData = array( 
                    'mobile' => $mobileNo,
                    'SMSMessage' => $message,	
                    'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
                );
                if($mobileNo !=''){					
                    $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
                }
                
                if(is_array($emailArr) && count($emailArr)>0)
                {
                       $this->sendMailToUser($emailArr,$subject,$body);         
                }
            } 
           
            
        }	
        return true;		
    }
    
    function sendMailToCreatorAfterApprovingByApprover($auctionID)
    {
        $approver_id = $this->session->userdata('id');
        if($auctionID != '')
        {  
            $creator_id             = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'created_by');
            $creator_first_name     = GetTitleByField('tbl_user', "id='".$creator_id."'", 'first_name');
            $reference_no           = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
            $approver_first_name    = GetTitleByField('tbl_user', "id='".$approver_id."'", 'first_name');
            $creator_email_id       = GetTitleByField('tbl_user', "id='".$creator_id."'", 'email_id');
            $creator_mobile_no      = GetTitleByField('tbl_user', "id='".$creator_id."'", 'mobile_no');
            $approver_first_name    = GetTitleByField('tbl_user', "id='".$approver_id."'", 'first_name');
            
            //Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 7);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();
            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;

            $body = str_replace("%creator_name%", $creator_first_name, $body);
            $body = str_replace("%approver_name%", $approver_first_name, $body);
            $body = str_replace("%auction_ref_no%", $reference_no, $body);
           
            $emailArr = array();
            $emailArr[] = $creator_email_id; // Uncomment First
            
            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 7);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();

            $message = $sms_query[0]->msg;
            $message = str_replace("%creator_name%", $creator_first_name, $message);
            $message = str_replace("%auction_ref_no%", $reference_no, $message);
            $mobileNo = $creator_mobile_no;
            $expDate = date('Y-m-d H:i:s');
            $smsData = array( 
                'mobile' => $mobileNo,
                'SMSMessage' => $message,	
                'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
            ); 
            
            if($mobileNo != ""){
                $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
            }
            if(is_array($emailArr) && count($emailArr)>0)
            {
                $send = $this->sendMailToUser($emailArr,$subject,$body);         
            }
        }	
        return true;		
    }
    
    function sendMailToCreatorAfterSendBackByApproverForReview($auctionID)
    {
        $approver_id = $this->session->userdata('id');
        
        if($auctionID != '')
        {  
            $creator_id             = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'created_by');
            $creator_first_name     = GetTitleByField('tbl_user', "id='".$creator_id."'", 'first_name');
            $reference_no           = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
            $approver_first_name    = GetTitleByField('tbl_user', "id='".$approver_id."'", 'first_name');
            $creator_email_id       = GetTitleByField('tbl_user', "id='".$creator_id."'", 'email_id');
            $creator_mobile_no      = GetTitleByField('tbl_user', "id='".$creator_id."'", 'mobile_no');
            
            #Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 8);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();

            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;

            $body = str_replace("%creator_name%", $creator_first_name, $body);
            $body = str_replace("%approver_name%", $approver_first_name, $body);
            $body = str_replace("%auction_ref_no%", $reference_no, $body);
           
            $emailArr = array();
            $emailArr[] = $creator_email_id; // Uncomment First

            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 8);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();
            $message = $sms_query[0]->msg;
            
            $message = str_replace("%creator_name%", $creator_first_name, $message);
            $message = str_replace("%auction_ref_no%", $reference_no, $message);
            $mobileNo = $creator_mobile_no;
            $expDate = date('Y-m-d H:i:s');
            $smsData = array( 
                'mobile' => $mobileNo,
                'SMSMessage' => $message,	
                'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
            );
            if($mobileNo !=""){
                $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
            }
            
            if(is_array($emailArr) && count($emailArr)>0)
            {
                $this->sendMailToUser($emailArr,$subject,$body);         
            }   
        }	
        return true;		
    }
    
    function sendMailToDocumentVarifierFinalApproverAfterPublishingAuctionByCreator($auctionID)
    {
        if($auctionID != '')
        {
            $reference_no           = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
            $regist_start_date      = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'registration_start_date')));
            $regist_end_date        = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'bid_last_date')));
            $auction_start_date     = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'auction_start_date')));
            $auction_end_date       = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'auction_end_date')));
           
        
            #Document/Approver Details 
            /*$this->db->select('first_name, email_id, mobile_no');
            $this->db->like('role_id', '2'); //final approver
            $this->db->or_like('role_id', '5'); //doc approver
            $query = $this->db->get('tbl_user')->result();
            */
            $this->db->select('user_id');
            //$this->db->like('role_id', '2'); //final approver
            $this->db->or_like('role_id', '5'); //doc approver
            $this->db->where('status', '1');
            $query = $this->db->get('tbl_user_department')->result();
            
            
            
            
            foreach($query as $key=>$value)
            { 
                #Email template
                $this->db->select('subject, msg');
                $this->db->where('email_template_id', 9);
                $this->db->where('status', 1);
                $email_query = $this->db->get('tblmst_email_template')->result();
                $subject = $email_query[0]->subject;
                $body = $email_query[0]->msg;
                
                
                $email_id = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'email_id');
				$mobile_no = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'mobile_no');
				$first_name = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'first_name');
                
                $body = str_replace("%document_approver_name%", $first_name, $body);
                $body = str_replace("%auction_ref_no%", $reference_no, $body);
                $body = str_replace("%registration_start_date%",$regist_start_date, $body);
                $body = str_replace("%registration_end_date%",$regist_end_date, $body);
                $body = str_replace("%auction_start_date%",$auction_start_date, $body);
                $body = str_replace("%auction_end_date%",$auction_end_date, $body);
                
                $emailArr = array();
                $emailArr[] = $email_id; // Uncomment First 
              
                #SMS Template
                $this->db->select('msg');
                $this->db->where('sms_template_id', 9);
                $this->db->where('status', 1);
                $sms_query = $this->db->get('tblmst_sms_template')->result();
                $message = $sms_query[0]->msg;
                
                $message = str_replace("%document_approver_name%", $first_name, $message);
                $message = str_replace("%auction_ref_no%", $reference_no, $message);
                $mobileNo = $mobile_no;
                $expDate = date('Y-m-d H:i:s');
                $smsData = array( 
                    'mobile' => $mobileNo,
                    'SMSMessage' => $message,	
                    'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
                );
                if($mobileNo !=''){
                    $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
                }

                if(is_array($emailArr) && count($emailArr)>0)
                {
                    $this->sendMailToUser($emailArr,$subject,$body);         
                }
            }
        }	
        return true;		
    }
    
    function sendMailToApproverAfterPublishingAuctionByCreator($auctionID)
    {
        $creator_id = $this->session->userdata('id');
        
        if($auctionID != '')
        {   	 #date('d-m-Y H:i:s',strtotime($regist_start_date));  	
            $approver_id            = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'second_opener');
            $approver_first_name    = GetTitleByField('tbl_user', "id='".$approver_id."'", 'first_name');
            $approver_email_id      = GetTitleByField('tbl_user', "id='".$approver_id."'", 'email_id');
            $approver_mobile_no     = GetTitleByField('tbl_user', "id='".$approver_id."'", 'mobile_no');
            $reference_no           = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
            $regist_start_date      = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'registration_start_date')));
            $regist_end_date        = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'bid_last_date')));
            $auction_start_date     = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'auction_start_date')));
            $auction_end_date       = date('d-m-Y H:i:s', strtotime(GetTitleByField('tbl_auction', "id='".$auctionID."'", 'auction_end_date')));
           
            #Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 10);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();

            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;
    
            $body = str_replace("%approver_name%", $approver_first_name, $body);
            $body = str_replace("%auction_ref_no%", $reference_no, $body);
            $body = str_replace("%registration_start_date%",$regist_start_date, $body);
            $body = str_replace("%registration_end_date%",$regist_end_date, $body);
            $body = str_replace("%auction_start_date%",$auction_start_date, $body);
            $body = str_replace("%auction_end_date%",$auction_end_date, $body);
	
            $emailArr = array();
            $emailArr[] = $approver_email_id; // Uncomment First
         
            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 10);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();
            $message = $sms_query[0]->msg;
           
            $message = str_replace("%approver_name%",$approver_first_name, $message);
            $message = str_replace("%auction_ref_no%", $reference_no, $message);
            $mobileNo = $approver_mobile_no;
            $expDate = date('Y-m-d H:i:s');
            $smsData = array( 
                'mobile' => $mobileNo,
                'SMSMessage' => $message,	
                'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
            ); 

            if($mobileNo !=''){
                $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
            }
            
            if(is_array($emailArr) && count($emailArr)>0)
			{
                            $this->sendMailToUser($emailArr,$subject,$body);         
			}        
        }	
        return true;		
    }
    
    function SendMailToApproverAfterFinalSubmission($auctionID)
    {
        if($auctionID != '')
        {
            $reference_no  = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'reference_no');
        
            #Document/Approver Details 
            
            $this->db->select('user_id');
            $this->db->like('role_id', '2'); //final approver
            $this->db->or_like('role_id', '3'); //Payment approver
            $this->db->or_like('role_id', '5'); //doc approver
            $this->db->where('status', '1');
            $query = $this->db->get('tbl_user_department')->result();
               
            
            
            foreach($query as $key=>$value)
            { 
                #Email template
                $this->db->select('subject, msg');
                $this->db->where('email_template_id', 12);
                $this->db->where('status', 1);
                $email_query = $this->db->get('tblmst_email_template')->result();
                $subject = $email_query[0]->subject;
                $body = $email_query[0]->msg;
                
                
                $email_id = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'email_id');
				$mobile_no = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'mobile_no');
				$first_name = GetTitleByField('tbl_user', "id='".$value->user_id."'", 'first_name');
                
                $body = str_replace("%auction_id%", $auctionID, $body);
                $body = str_replace("%auction_ref_no%", $reference_no, $body);
                
                $emailArr = array();
                $emailArr[] = $email_id; // Uncomment First 
              
                #SMS Template
                $this->db->select('msg');
                $this->db->where('sms_template_id', 11);
                $this->db->where('status', 1);
                $sms_query = $this->db->get('tblmst_sms_template')->result();
                $message = $sms_query[0]->msg;
                                
                $message = str_replace("%auction_id%", $auctionID, $message);
                $message = str_replace("%auction_ref_no%", $reference_no, $message);
                $mobileNo = $mobile_no;
                $expDate = date('Y-m-d H:i:s');
                $smsData = array( 
                    'mobile' => $mobileNo,
                    'SMSMessage' => $message,	
                    'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
                );
                if($mobileNo !=''){
                    $sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
                }

                if(is_array($emailArr) && count($emailArr)>0)
                {
                    $this->sendMailToUser($emailArr,$subject,$body);         
                }
            }
        }	
        return true;		
    }
    
    
     function sendAuctionAlertMailToBidders($auctionId,$email_subject,$message)
    { 
		
		$whrArr = array('ap.auctionID'=>$auctionId,'ap.final_submit'=>1);
		$this->db->select('usr.id, usr.email_id, usr.first_name');
		$this->db->from('tbl_user_registration as usr');
		$this->db->join('tbl_auction_participate as ap','ap.bidderID=usr.id','left');
		$this->db->where($whrArr);
		$uQry = $this->db->get();
		//echo $this->db->last_query();die;
		if($uQry->num_rows()>0)
		{
			
			$emailArr = array();
			foreach($uQry->result() as $row)
			{	
				$emailArr[] = $row->email_id;
			}			
			//$emailArr[] = 'dheeraj.kumar@c1india.com';
			
			
			if(is_array($emailArr) && count($emailArr)>0)
			{
				$result = $this->sendMailToUser($emailArr, $email_subject, nl2br($message));         
			}
				
			return $result;		
		}
    }
    
    function sendAcceptanceConfToBidder($mode)
    {   
		$auctionId  = $this->input->post("auction_id"); 
		$bidderId   = $this->input->post("bidder_id");
		$h1_price   = $this->input->post("h1_price");
		$area_unit  = $this->input->post("area_unit");
		$deps_within_24_hrs = moneyFormatIndia(round($this->input->post("deps_within_24_hrs")));

		$user_type = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'user_type');              
		   
		if($user_type =='builder')
		{
			$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'authorized_person');
		}
		else
		{
			$bidder_name    = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'first_name')." ".GetTitleByField('tbl_user_registration', 'id="'.$bidderID.'"', 'last_name');
		}
				       
        $bidder_email   = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'email_id');
        $bidder_mobile  = GetTitleByField('tbl_user_registration', 'id="'.$bidderId.'"', 'mobile_no');
        $prop_descp     = GetTitleByField('tbl_auction', 'id="'.$auctionId.'"', 'PropertyDescription');
        
        $prop_ser_no    = GetTitleByField('tbl_auction', 'id="'.$auctionId.'"', 'service_no');
        $prop_ser_no    = ($prop_ser_no != "")? $prop_ser_no: "N/A";
        
        $scheme_name    = GetTitleByField('tbl_auction', 'id="'.$auctionId.'"', 'scheme_name');
        $scheme_name    = ($scheme_name != "")? $scheme_name: "N/A";
        
        $reference_no    = GetTitleByField('tbl_auction', 'id="'.$auctionId.'"', 'reference_no');
		$reference_no    = ($reference_no != "")? $reference_no: "N/A";
      
        
        if($mode == "email"){
            
            #Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 13);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();

            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;
    
            $body = str_replace("%bidder_name%", $bidder_name, $body);
            $body = str_replace("%scheme_name%", $scheme_name, $body);
            $body = str_replace("%bidder_email%", $bidder_email, $body);
            $body = str_replace("%prop_descp%", $prop_descp, $body);
            $body = str_replace("%auction_id%",$auctionId, $body);
            $body = str_replace("%h1_price%",$h1_price, $body);
            $body = str_replace("%area_unit%",$area_unit, $body);
            $body = str_replace("%amt_within_24_hrs%",$deps_within_24_hrs, $body);
            $body = str_replace("%prop_ser_no%",$prop_ser_no, $body);
            $body = str_replace("%auction_ref_no%", $reference_no, $body);
            
            $emailArr = array();
            $emailArr[] = $bidder_email;
            
            if(is_array($emailArr) && count($emailArr)>0)
            {
                $result = $this->sendMailToUser($emailArr, $subject, $body);         
            }
        return $result;
        } else if($mode == "sms") {
            
            #SMS Template
            $this->db->select('msg');
            $this->db->where('sms_template_id', 12);
            $this->db->where('status', 1);
            $sms_query = $this->db->get('tblmst_sms_template')->result();
            $message = $sms_query[0]->msg;
           
            $message = str_replace("%bidder_name%", $bidder_name, $message);
            $message = str_replace("%scheme_name%",$scheme_name, $message);
            $message = str_replace("%prop_descp%", $prop_descp, $message);
            $message = str_replace("%amt_within_24_hrs%", $deps_within_24_hrs, $message);
            $message = str_replace("%seller_name%", $this->session->userdata("full_name"), $message);
            
            $mobileNo = $bidder_mobile;
            $expDate = date('Y-m-d H:i:s');
            $smsData = array( 
                'mobile' => $mobileNo,
                'SMSMessage' => $message,	
                'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
            ); 

            if($mobileNo !=''){
                $result = $this->sendSMS($smsData); // Uncomment this to send SMS
            }
          
        }
        return $result;		
    }
    
    
    
    function sendSMS($data = array())
	{
		
		
		if(is_array($data) && count($data) > 0 )
		{	
			
			if($data['mobile'] != '' && $data['SMSMessage'] != '')
			{						
				$data['code'] = 91;
				
				$url = SMSAPIURL;
				if($url !='')
				{
					$url = str_replace("%%mobile%%",$data['code'].$data['mobile'],$url);
					$url = str_replace("%%msg%%",urlencode($data['SMSMessage']),$url);
					
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$return = curl_exec($ch);
					curl_close ($ch);
					return $return;
				}
			}
		}
		
	}
    
    
    
    function sendMailToBidderResetPasswordLink($to,$randomstr,$name)
    {
        $link = base_url()."registration/resetPassword?c=".$randomstr;
		$link = " <a href='".$link."'>Click here</a>";
        
        if($to != '')
        {   
           
            #Email template
            $this->db->select('subject, msg');
            $this->db->where('email_template_id', 14);
            $this->db->where('status', 1);
            $email_query = $this->db->get('tblmst_email_template')->result();

            $subject = $email_query[0]->subject;
            $body = $email_query[0]->msg;
    
            $body = str_replace("%bidder_name%", ucwords($name), $body);
            $body = str_replace("%reset_link%", $link, $body);            
			
            $emailArr = array();
            $emailArr[] = $to; 
         
            if(is_array($emailArr) && count($emailArr)>0)
			{
				$this->sendMailToUser($emailArr,$subject,$body);         
			}        
        }	
        return true;		
    }
    
    function sendMailToNewUserVerificationLink($bidderId){
		
		
		
		$user_type = GetTitleByField('tbl_user_registration_temp', 'id="'.$bidderId.'"', 'user_type');              
		   
		if($user_type =='builder')
		{
			$bidder_name    = GetTitleByField('tbl_user_registration_temp', 'id="'.$bidderId.'"', 'authorized_person');
		}
		else
		{
			$bidder_name    = GetTitleByField('tbl_user_registration_temp', 'id="'.$bidderId.'"', 'first_name')." ".GetTitleByField('tbl_user_registration', 'id="'.$bidderID.'"', 'last_name');
		}
				       
        $bidder_email   = GetTitleByField('tbl_user_registration_temp', 'id="'.$bidderId.'"', 'email_id');
        $bidder_mobile  = GetTitleByField('tbl_user_registration_temp', 'id="'.$bidderId.'"', 'mobile_no');
		
		$verifyCode=$bidder_email.$bidderId;
		$verifyCode= md5($verifyCode);
		
		$link = base_url()."registration/verify?code=".$verifyCode;
		$link = " <a href='".$link."'>Click here</a>";
		
		#Email template
		$this->db->select('subject, msg');
		$this->db->where('email_template_id', 15);
		$this->db->where('status', 1);
		$email_query = $this->db->get('tblmst_email_template')->result();

		$subject = $email_query[0]->subject;
		$body = $email_query[0]->msg;
		$portal_name = rtrim(base_url(),'/');
		$portal_name = remove_http($portal_name);
		$body = str_replace("%full_name%", $bidder_name, $body);
		$body = str_replace("%portal_name%", $portal_name, $body);
		$body = str_replace("%verification_link%", $link, $body);
		
	   
		$emailArr = array();
		$emailArr[] = $bidder_email; // Uncomment First
		
		
		#SMS Template
		$this->db->select('msg');
		$this->db->where('sms_template_id', 13);
		$this->db->where('status', 1);
		$sms_query = $this->db->get('tblmst_sms_template')->result();
		$message = $sms_query[0]->msg;
	   
		$message = str_replace("%bidder_name%",$bidder_name, $message);
		
		$mobileNo = $bidder_mobile;
		$expDate = date('Y-m-d H:i:s');
		$smsData = array( 
			'mobile' => $mobileNo,
			'SMSMessage' => $message,	
			'exp_date' => date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'))
		); 
	
		if($mobileNo !=''){
			$sendSMS = $this->sendSMS($smsData); // Uncomment this to send SMS
		}
		
		if(is_array($emailArr) && count($emailArr)>0)
		{
			$this->sendMailToUser($emailArr,$subject,$body);         
		}  	 
		
		return true;				
	}
	
	
    
}
