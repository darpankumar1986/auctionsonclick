<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends WS_Controller {
	
	public function __construct()
	{   
	
		parent::__Construct();
		ob_start();		 	
		
		//error_reporting(0);
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('captcha');		
		$this->load->helper(array('form'));		
		$this->load->model('registration_model');
		$this->load->model('home_model');
                $this->load->model('admin/user_model');
		$this->load->model('admin/bank_model');
		$this->load->model('admin/news_model');
		$this->load->library('facebook/fb','fb');
		
		/*$this->load->library('Email_new','email');
		$email = new email_new();
		$email->sendMailToUser(array('neeraj.jain@c1india.com'),'test','hi');*/		
		
	}
	
	public function index($param=null)
	{	
		if($param==''){
			redirect('/signup/');
		}
	}
       
        
    public function bidderlogin()
    {
        $track=$this->input->get('track');
		$auctionID=$this->input->get('auctionID');
          
        if($this->input->post('submit1')=='LOGIN')
        {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				if($this->form_validation->run() == FALSE){
					$data['error_msg']="Enter Required Fields!";
					redirect("registration/bidderlogin?track=bidder&auctionID=".$auctionID);
				}
				else
				{
                    $redirect 	= $this->input->post('redirect_link');
				    $res=$this->registration_model->checkbidderLogin(); 
				
				
				if($res == 'session_found')
				{
					$data['session_id_found']="found";
					
					$this->session->set_flashdata('session_id_found', $data['session_id_found']);	
					redirect("registration/bidderlogin?track=bidder&auctionID=".$auctionID);
				}
				else if($res>0)
				{	
					$auctionID = $this->input->get('auctionID');
					$track 	= $this->input->get('track');
					if($track=='bidder' && $auctionID>0)
					{
						redirect("/owner/auctionParticipage/".$auctionID);	
					}
					else
					{
						if(!empty($redirect)){
							$arr = explode("/", $redirect);
							$str = "/".$arr['3']."/".$arr['4']."/".$arr['5'];
							redirect("$str");
						}
						else
						{
							redirect("registration/redirectDashboard");
						}
					}
				}
				else if($res==0)
				{  			
					$this->registration_model->checkuserblocked(); 
					if($this->registration_model->checkuserblocked() == '9')
					{
							$data['error_msg']="Your account is blocked!<br> Please contact administrator to unblock it.";
					} else{
                        $data['error_msg']="Invalid username or password..!";
					}
		 // Start : Block Code
                 //$block_get_usertype = $this->registration_model->block_get_usertype(); 
                // Block Code 
                /*if($block_get_usertype == 'owner' || $block_get_usertype == 'builder' || $block_get_usertype == 'broker' )
                {
                       $this->registration_model->user_block_attempt();  // Block Code
                       $failattempt_count = $this->registration_model->block_get_user_failattempt_count(); // Block Code 
                   if($failattempt_count > 0 && $failattempt_count < 5){
                       $data['error_msg'].="<br>Failed attempt ".$failattempt_count." for today!.<br> Account will be blocked after 5 failed attempt!";
                        }
                        if($failattempt_count == 5)
                        {
                                $this->registration_model->user_block_id();  // Block Code
                                $data['error_msg'].="<br>Your account has been blocked!<br> Please contact administrator to unblock it.";
                        }

                }*/
                //End : Block Code
					$data['auctionID'] = $this->input->get('auctionID');
					$data['track']	= $this->input->get('track');
                }
            }
         }
        $this->load->view('bidderlogin', $data);    
        }
        
	
	public function signup($encoded_str=null) 
	{
		//$this->registration_model->sendSMS(12);
		$word=random_string('numeric',6);
		$data['captcha']=$this->captcha_image($word);
		$this->session->set_userdata('captchaWord', $data['captcha']['word']);
		$bankID=$this->input->get('bi');
		
		if(isset($bankID) && $bankID!='')
		{
			$getBankDetailsByID = $this->home_model->getBankDetailsByID($bankID);	
			$data['getBankDetailsByID']=$getBankDetailsByID;
			$data['bankIdbyshortname']=$bankID;
		}
		
		if($this->session->userdata('id'))
		{
			redirect("registration/redirectDashboard");
		}
		
		$countries 				= 	 $this->bank_model->GetCountries();		
		$data['countries'] 		=	 $countries;
		$states 				=	 $this->bank_model->GetState();		
		$data['states']			= 	 $states;
		$cities 				=	 $this->bank_model->GetCity();		
		$data['cities'] 		=	 $cities;
		$data['bank']			=	 $this->bank_model->GetMstBank();	
		
		$staticData=$this->home_model->getStaticContents(2);
		$data['staticData']=$staticData;
		$id=base64_decode(urldecode($encoded_str));
		$data['id']=$id;
		$this->load->view('front_view/header',$data);
		if(MOBILE_VIEW)
		{
            $this->load->view('mobile/registration-step-first', $data);
		}
		else
		{
			$this->load->view('front_view/signup', $data);
		}
		 $this->load->view('front_view/footer');
		
	}	
	
	
	
    public function checklogintype()
    {
		$this->login(); 		
       
    }
    
    
     public function m_checklogintype()
    {
		if($_POST['login_as']=='owner' && MOBILE_VIEW)
		{
			$this->m_login();
		}
	}
	
    public function forgetpassword()
    {    
		$word=random_string('numeric',6);
		$data['fp_captcha']=$this->captcha_image($word);
		$this->session->set_userdata('fp_captcha', $data['fp_captcha']['word']);

		$this->load->view('front_view/header',$data);
		if(MOBILE_VIEW)
		{         
            $this->load->view('mobile/forgetPassword');     
		}
		else
		{			
			$this->load->view('front_view/forgetPassword');     
		}
		
		$this->load->view('front_view/footer');     
         
    }
    
    public function checkforgetCaptchaCode($captcha)
	{
		$captchaWord = $this->session->userdata('fp_captcha');		
		if($captcha == $captchaWord)
		{
			echo 'success';die;
		}
		else
		{
			$word = random_string('numeric',6);
			$data['fp_captcha'] = $this->captcha_image($word);
			$this->session->set_userdata('fp_captcha', $data['fp_captcha']['word']);
			echo $data['fp_captcha']['image'];die;
		}
	}
    public function sendrandomlink()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','trim|required|xss_clean');
		
		
		$captchaWord = $this->session->userdata('fp_captcha');
		$captcha =  $this->input->post('fp_captcha');
		
		if($captcha == $captchaWord)
		{
			if($this->form_validation->run() == true)
			{
		
				$res = $this->registration_model->sendForgetMail();
				if($res)
				{			
					$this->session->set_flashdata('msg','A password reset link has been sent to your email address');
				}
				else
				{			
					$this->session->set_flashdata('error','Sorry this email address is not registered with us');
				}
				redirect('registration/forgetpassword');
			}
		}
		else
		{
			
			$this->session->set_flashdata('error','Please enter valid captcha code! <br>');
			
			redirect('registration/forgetpassword');
		}
	}
	
	
	public function resetPassword()
	{
		$randomNum = $this->input->get('c');
		
		$res = $this->registration_model->checkLinkValid($randomNum);
		if($res)
		{
			$data['title'] = 'Reset Password';		
			$this->load->view('front_view/header',$data);
			if(MOBILE_VIEW)
			{         
				$this->load->view('mobile/updateMember_pass');     
			}
			else
			{			
				$this->load->view('front_view/updateMember_pass');     
			}
			
			$this->load->view('front_view/footer');
		}
		else
		{
			
			$this->session->set_flashdata('error','Sorry Link expired');
			
			redirect('registration/forgetpassword');
		}
	}
	
	public function updateMemberPassword()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('newpassword', 'New Password', 'required');
		$this->form_validation->set_rules('re_password', 'Confirm New Password', 'required');			
		$randomNum = $this->input->post('randomNum');
		
		if($this->form_validation->run() == FALSE)
		{	
			redirect('registration/resetPassword?c='.$randomNum);
		}
		else
		{				
			$updt = $this->registration_model->update_password($randomNum);			
			if($updt == 0)
			{
				$this->session->set_flashdata('error','Link expired');
				redirect('registration/forgetpassword');
			}
			else
			{
				$this->session->set_flashdata('msg','Password updated successfully');
				redirect('registration/reset_password_success');
			}
			
		}
	}
      
    public function reset_password_success()
	{		
		$data['title'] = 'Password Reset Success';		
		$this->load->view('front_view/header',$data);
		if(MOBILE_VIEW)
		{         
			$this->load->view('mobile/reset_password_success');     
		}
		else
		{	
			$this->load->view('front_view/reset_password_success');
		}
		
		$this->load->view('front_view/footer');
		if($this->session->flashdata('msg')=='')
		{
			redirect('home/');
		}
	}  
     
    public function chk_login()
    {		
		$res=$this->registration_model->chk_login();	
		//echo $res;	die;
		if($res == 'session_found' && $res!='0')
		{
			echo '1';die;
		}
		else if($res==0)
		{			
			
			$this->registration_model->checkuserblocked();
			if($this->registration_model->checkuserblocked() == '9')
			{
				echo '2';die;
				//$data['error_msg']="Your account is blocked!<br> Please contact administrator to unblock it.";
				//$this->session->set_flashdata('error_msg', $data['error_msg']);
			}	
			else
			{
				echo '3';die;
				//$data['error_msg']="Invalid username or password..!";
				//$this->session->set_flashdata('error_msg', $data['error_msg']);
			}
			
				// Start : Block Code
				$block_get_usertype = $this->registration_model->block_get_usertype();  // Block Code
				if($block_get_usertype == 'owner' || $block_get_usertype == 'builder' || $block_get_usertype == 'broker' )
				{
					//$data['error_msg'] = "";
					$this->registration_model->user_block_attempt();  // Block Code
					
					$failattempt_count = $this->registration_model->block_get_user_failattempt_count(); // Block Code 
					if($failattempt_count > 0 && $failattempt_count < 5)
					{
							//$data['error_msg'] = "Failed attempt ".$failattempt_count." for today!.<br> Account will be blocked after 5 failed attempt!";
							echo '4';die;
							//$data['error_msg'] .= "<br/>Account will be blocked after 5 failed attempt!";
							//$this->session->set_flashdata('error_msg', $data['error_msg']);
					}
					if($failattempt_count == 5)
					{
						echo '5';die;
						$this->registration_model->user_block_id();  // Block Code
						//$data['error_msg'] = "Your account has been blocked!<br> Please contact administrator to unblock it.";
						//$this->session->set_flashdata('error_msg', $data['error_msg']);
					}
					
				}
	
		}
		else if($res>0)
		{
			echo 'success';die;
		}
		
	} 
        
    public function chk_banker_login()
    {
		$res=$this->registration_model->chk_banker_login(); 
		//echo $res;die;
		
		if($res == 'session_found' && $res!='0')
		{										
			echo '1';die;
		}
		else if($res==0)
		{			
			if($this->registration_model->checkuserblocked_banker() == '9')
			{
				echo '2';die;
			}	
			else
			{
				echo '3';die;
			}
		}
		else if($res>0)
		{
			echo '0';die;
		}
	}    
        
    public function m_login()
	{
				
			$track=$this->input->post('track');
			$auctionID=$this->input->post('auctionID');
			
			if($this->session->userdata('id')&& $this->session->userdata('user_type'))
			{
				
				redirect("registration/redirectDashboard");
			}
				$data['redirectData'] = $_GET['review'];
			if(!empty($_GET['review']))
			{
				$data['redirectData'] = $_GET['review'];
			}
			elseif(!empty($_GET['fav']))
			{
				$data['redirectData'] = $_GET['fav'];
			}       
            
            
            if($this->input->post('m_submit')=='LOGIN')
            {		
							
				$this->load->library('form_validation');
				$this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				if($this->form_validation->run() == FALSE)
				{					
                    $data['error_msg']="Enter Required Fields!";
                    $this->session->set_flashdata('error_msg', $data['error_msg']);	
                    redirect("registration/login");
                }
                else
                {
					
					
                    $redirect = $this->input->post('redirect_link');
					$res=$this->registration_model->checkLogin();
					//echo $res;die;
					
					/*
					if($res == 'session_found' && $res!='0')
					{
						$data['session_id_found']="found";
						
						$this->session->set_flashdata('session_id_found', $data['session_id_found']);	
						redirect("registration/login");
					}
					*/
					if($res>0)
					{
						
						$rand_ = rand(10000000,9999999);
						$cookie_value = sha1($rand_);
						$date_of_expiry = time() + 60 ;
						setcookie( "csrf_cookie_name", $cookie_value , $date_of_expiry, "/" ) ;
						
						
						$auctionID = $this->input->post('auctionID');
                        $track 	= $this->input->post('track');
						if($track=='bidder' && $auctionID>0)
						{
							redirect("/owner/auctionParticipage/".$auctionID);	
						}
						else
						{
							if(!empty($redirect))
							{
								$arr = explode("/", $redirect);
								$str = "/".$arr['3']."/".$arr['4']."/".$arr['5'];
                                redirect("$str");
							}
							else
							{ 
								redirect("registration/redirectDashboard");
							}
						}
					}
					/*
					else if($res==0)
					{			
						$this->registration_model->checkuserblocked();
						if($this->registration_model->checkuserblocked() == '9')
						{
							$data['error_msg']="Your account is blocked!<br> Please contact administrator to unblock it.";
							$this->session->set_flashdata('error_msg', $data['error_msg']);
						}	
						else
						{
							$data['error_msg']="Invalid username or password..!";
							$this->session->set_flashdata('error_msg', $data['error_msg']);
						}
						
							// Start : Block Code
							$block_get_usertype = $this->registration_model->block_get_usertype();  // Block Code
							if($block_get_usertype == 'owner' || $block_get_usertype == 'builder' || $block_get_usertype == 'broker' )
							{
								//$data['error_msg'] = "";
								$this->registration_model->user_block_attempt();  // Block Code
								
								$failattempt_count = $this->registration_model->block_get_user_failattempt_count(); // Block Code 
								if($failattempt_count > 0 && $failattempt_count < 5)
								{
										//$data['error_msg'] = "Failed attempt ".$failattempt_count." for today!.<br> Account will be blocked after 5 failed attempt!";
										$data['error_msg'] .= "<br/>Account will be blocked after 5 failed attempt!";
										$this->session->set_flashdata('error_msg', $data['error_msg']);
								}
								if($failattempt_count == 5)
								{
									$this->registration_model->user_block_id();  // Block Code
									$data['error_msg'] = "Your account has been blocked!<br> Please contact administrator to unblock it.";
									$this->session->set_flashdata('error_msg', $data['error_msg']);
								}
								
							}
							//End : Block Code
				
						$this->session->set_flashdata('error_msg', $data['error_msg']);
						$auctionID = $this->input->post('auctionID');
                        $track 	= $this->input->post('track');
						if($track=='bidder' && $auctionID>0)
						{
							redirect("/registration/login?track=bidder&status=1&auctionID=".$auctionID);	
						}
						else
						{
							redirect("registration/login");	
						}
				
					}
					*/
					
				}
            }
			$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
		
				//****************** facebook*****************************
				$data['user_profile'] = array();
				$data['login_url'] = $this->fb->createLoginLink();
				$data['track']=$track;
				$data['auctionID']=$auctionID;
				$user_profile = $this->fb->initialize();		
					
				$res=$this->registration_model->facebook_registration($user_profile);
				if($res!='registered')
						{
							$data['password']=$ress;
							$this->load->view('mail_template',$data);
						}
				if($user_profile){
					//$this->userprofile();
					$this->load->helper('url');
					redirect("registration/userprofile");
				}
				//******************** End *************************************
	
		$this->load->view('front_view/home', $data);	
				
		/********************** Footer Section  ************************/
		$this->load->view('front_view/footer',$data);
		/******************* End Footer Section  ***********************/
	} 
	    
    public function m_login1()
	{
				
			$track=$this->input->post('track');
			$auctionID=$this->input->post('auctionID');
			
			if($this->session->userdata('id')&& $this->session->userdata('user_type'))
			{
				
				redirect("registration/redirectDashboard");
			}
				$data['redirectData'] = $_GET['review'];
			if(!empty($_GET['review']))
			{
				$data['redirectData'] = $_GET['review'];
			}
			elseif(!empty($_GET['fav']))
			{
				$data['redirectData'] = $_GET['fav'];
			}       
            
            
            if($this->input->post('m_submit')=='LOGIN')
            {		
							
				$this->load->library('form_validation');
				$this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				if($this->form_validation->run() == FALSE)
				{					
                    $data['error_msg']="Enter Required Fields!";
                    $this->session->set_flashdata('error_msg', $data['error_msg']);	
                    redirect("registration/login");
                }
                else
                {
					
					
                    $redirect = $this->input->post('redirect_link');
					$res=$this->registration_model->checkLogin();
					//echo $res;die;
					
					
					if($res>0)
					{
						
						$rand_ = rand(10000000,9999999);
						$cookie_value = sha1($rand_);
						$date_of_expiry = time() + 60 ;
						setcookie( "csrf_cookie_name", $cookie_value , $date_of_expiry, "/" ) ;
						
						
						$auctionID = $this->input->post('auctionID');
                        $track 	= $this->input->post('track');
						if($track=='bidder' && $auctionID>0)
						{
							redirect("/owner/auctionParticipage/".$auctionID);	
						}
						else
						{
							if(!empty($redirect))
							{
								$arr = explode("/", $redirect);
								$str = "/".$arr['3']."/".$arr['4']."/".$arr['5'];
                                redirect("$str");
							}
							else
							{ 
								//redirect("registration/redirectDashboard");
								redirect("registration/mobile_set_mpin");
								
							}
						}
					}
					
					
				}
            }
			$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
		
				//****************** facebook*****************************
				$data['user_profile'] = array();
				$data['login_url'] = $this->fb->createLoginLink();
				$data['track']=$track;
				$data['auctionID']=$auctionID;
				$user_profile = $this->fb->initialize();		
					
				$res=$this->registration_model->facebook_registration($user_profile);
				if($res!='registered')
						{
							$data['password']=$ress;
							$this->load->view('mail_template',$data);
						}
				if($user_profile){
					//$this->userprofile();
					$this->load->helper('url');
					redirect("registration/userprofile");
				}
				//******************** End *************************************
	
		$this->load->view('front_view/home', $data);	
				
		/********************** Footer Section  ************************/
		$this->load->view('front_view/footer',$data);
		/******************* End Footer Section  ***********************/
	}    
        
        
        
	public function login()
	{
		
			$track=$this->input->post('track');
			$auctionID=$this->input->post('auctionID');
			
			if($this->session->userdata('id')&& $this->session->userdata('user_type'))
			{
				redirect("registration/redirectDashboard");
			}
				$data['redirectData'] = $_GET['review'];
			if(!empty($_GET['review']))
			{
				$data['redirectData'] = $_GET['review'];
			}
			elseif(!empty($_GET['fav']))
			{
				$data['redirectData'] = $_GET['fav'];
			}       
            if($this->input->post('user_name')!='')
            {	
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				if($this->form_validation->run() == FALSE)
				{					
                   // $data['error_msg']="Enter Required Fields!";
                   // $this->session->set_flashdata('error_msg', $data['error_msg']);	
                   // redirect("home/login");
                }
                else
                {		
					
                    $redirect = $this->input->post('redirect_link');
					$res=$this->registration_model->checkLogin();
					//echo $res;die;
					
					/*
					if($res == 'session_found' && $res!='0')
					{
						$data['session_id_found']="found";
						
						$this->session->set_flashdata('session_id_found', $data['session_id_found']);	
						redirect("registration/login");
					}
					*/
					if($res>0)
					{						
						$rand_ = rand(10000000,9999999);
						$cookie_value = sha1($rand_);
						$date_of_expiry = time() + 60 ;
						setcookie( "csrf_cookie_name", $cookie_value , $date_of_expiry, "/" ) ;
						
						
						$auctionID = $this->input->post('auctionID');
                        $track 	= $this->input->post('track');
						if($track=='bidder' && $auctionID>0)
						{
							redirect("/owner/auctionParticipage/".$auctionID);	
						}
						else
						{
							
							if(!empty($redirect))
							{
								$arr = explode("/", $redirect);
								$str = "/".$arr['3']."/".$arr['4']."/".$arr['5'];
                                redirect("$str");
							}
							else
							{ 								
								redirect("registration/redirectDashboard");
							}
						}
					}
								
				}
            }

			 $data['error_msg']="Invalid username and password";
             $this->session->set_flashdata('error_msg', $data['error_msg']);	

			$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
		
				
	
		$this->load->view('front_view/login', $data);	
				
		/********************** Footer Section  ************************/
		$this->load->view('front_view/footer',$data);
		/******************* End Footer Section  ***********************/
	}
	
	function verify()
	{
		
		$code=$this->input->get('code');
		if($code)
		{
			 $returnvalue=$this->registration_model->verifyuser($code);
		}
		$data['msg']=$returnvalue;
		$this->load->view('front_view/header',$data);
		$this->load->view('verification', $data);	
		$this->load->view('front_view/footer');	
	}
	
    public function checkDuplicateEmail()
	{
		$email=$_POST['email'];
		echo  $this->user_model->checkDuplicateEmail($email);
		 
	}	
	
	function checkbankerlogin()
	{
		//echo "hello max";die;
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			$data['error_msg']="Enter Required Fields!";
			$this->session->set_flashdata('error_msg', $data['error_msg']);	
			redirect("registration/banker_login");
		}else{		
			
				$res=$this->registration_model->checkBankLogin(); 
				//echo $res;die;
				
				if($res == 'session_found' && $res!='0')
				{
					$data['session_id_found']="found";
					
					$this->session->set_flashdata('session_id_found', $data['session_id_found']);	
					redirect("registration/login");
				}
				
				else if($res>0)
				{
					//echo "you";die;
					$rand_ = rand(10000000,9999999);
					$cookie_value = sha1($rand_);
					$date_of_expiry = time() + 60 ;
					setcookie( "csrf_cookie_name", $cookie_value , $date_of_expiry, "/" ) ;
						
					redirect("registration/redirectDashboard");
				}
				
				else
				{			
					if($this->registration_model->checkuserblocked_banker() == '9')
					{
						$data['error_msg']="Your account is blocked!<br> Please contact administrator to unblock it.";
					}	
					else
					{
						$data['error_msg']="Invalid username or password..!";
					}
					
					
					// Start : Block Code
					/*$block_get_usertype = $this->registration_model->block_get_usertype_banker();  // Block Code
					
						$this->registration_model->user_block_attempt_banker();  // Block Code
						
						$failattempt_count = $this->registration_model->block_get_user_failattempt_count_banker(); // Block Code 
						if($failattempt_count > 0 && $failattempt_count < 5)
						{
								$data['error_msg'].="<br>Failed attempt ".$failattempt_count." for today!.<br> Account will be blocked after 5 failed attempt!";
						}
						if($failattempt_count == 5)
						{
							$this->registration_model->user_block_id_banker();  // Block Code
							$data['error_msg'].="<br>Your account has been blocked!<br> Please contact administrator to unblock it.";
						}
					*/
					//End : Block Code
					
					$this->session->set_flashdata('error_msg', $data['error_msg']);
					redirect("registration/banker_login");
				}
					
		}

		
	}
	
	public function banker_login(){
		
		if($this->session->userdata('id')){
			redirect("registration/redirectDashboard");
		}
			$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
			$this->load->view('banker_login', $data);	
			$this->load->view('front_view/footer');
	}
	
	public function forgot_password(){
		$staticData=$this->home_model->getStaticContents(2);
		$data['staticData']=$staticData;
		$this->load->view('front_view/header',$data);
		
		$this->load->view('forgot_password');	
		
		/********************** Footer Section  ************************/
		$this->load->view('front_view/footer');
		/******************* End Footer Section  ***********************/
	}		
	public function redirectDashboard(){
		
		
			$user_type=$this->session->userdata('user_type');
			//echo $user_type;die;    
			
			if($user_type=='owner' || $user_type =='builder')
			{
				redirect('/owner');
			}			
			else if($user_type == 'buyer')
			{
				$role_id = $this->session->userdata('role_id');
				if($role_id == 3)
				{
					redirect('/buyer/emd_payment_verification');
				}
				else
				{
					redirect('/buyer/myActivity');
				}
			}
			else 
			{
				redirect('/');
			}
		
	}
	
	
	
	public function logout()
	{	
			$sessionValueEmpty = true;		
			$user_type = $this->session->userdata('user_type');
            $userid = $this->session->userdata('id');
            $this->db->select('user_sess_val');
            $this->db->where('id',$userid);
            if($this->session->userdata('session_found_usertype') == 'bidder')
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
            
            
            
            
		
		if($this->session->userdata('session_found_emailid'))
		{
			if($this->session->userdata('session_found_usertype') == 'bidder' && $sessionValueEmpty)
			{
				$this->db->where('email_id', $this->session->userdata('session_found_emailid'));
				$this->db->where('user_sess_val', $this->session->userdata('session_found_sess_val'));
				$this->db->update('tbl_user_registration', array('user_sess_val'=>'')); 
			}
			if($this->session->userdata('session_found_usertype') == 'banker')//&& $sessionValueEmpty
			{
				
				$this->db->where('email_id', $this->session->userdata('session_found_emailid'));
				//$this->db->where('user_sess_val', $this->session->userdata('session_found_sess_val'));
				$this->db->update('tbl_user', array('user_sess_val'=>'')); 
			}
			$this->session->userdata('session_found_emailid');
			$query = $this->db->query("select max(id) as id FROM tbl_user_log as foo where foo.email_id='".$this->session->userdata('session_found_emailid')."' ",false);
				$row=$query->result();
				
				if($row[0]->id)
				{
					$query = $this->db->query("UPDATE tbl_user_log SET logout_datetime= '".date('y-m-d H:i:s',time())."' where id = '".$row[0]->id."'",false);
				}
				
		}
				
        $this->registration_model->userchecklogout();
		$usertype=$this->session->userdata('user_type');
		$this->session->sess_destroy();
		$this->session->unset_userdata('id'); 
		$this->session->unset_userdata('first_name');
		$this->session->unset_userdata('last_name');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('bank_id');
		$this->session->unset_userdata('branch_id');		
		$this->fb->facebookLogout();
		
		$date_of_expiry = time() + 60 ;
		setcookie( "csrf_cookie_name", "", $date_of_expiry, "/" ) ;
		
		unset($_SESSION['token']);	
		
		if(LOCAL_URL == true)
		{
			if($usertype=='branch'){
				redirect('registration/banker_login');	
			}else{
				redirect('registration/login');		
			}
		}
		else
		{
			/*
			redirect(SSO_URL);
			exit;*/	
			redirect('registration/login');	
			exit;
		}
		
	}
	public function validate_captcha(){
		if($this->input->post('captcha') != $this->session->userdata['captcha'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, hmm are you the Terminator?');
			return false;
		}else{
			return true;
		}
	}
    
	public  function rpHash($value) {
		$hash = 5381;
		$value = strtoupper($value);
		for($i = 0; $i < strlen($value); $i++) {
			$hash = (($hash << 5) + $hash) + ord(substr($value, $i));
		}
		return $hash;
	}
	
	public function checkCaptchaCode($captcha)
	{
		$captchaWord = $this->session->userdata('captchaWord');
		//$captcha =  $this->input->post('captcha');		
		//echo $captcha;echo '<br/>';
		//echo $captchaWord;die;
		if($captcha == $captchaWord)
		{
			echo 'success';die;
		}
		else
		{
			$word = random_string('numeric',6);
			$data['captcha'] = $this->captcha_image($word);
			$this->session->set_userdata('captchaWord', $data['captcha']['word']);
			echo $data['captcha']['image'];die;
		}
	}
	
	public function save()
	{
		//$this->website_header();	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','email','mobile','password','cpassword','trim|required|xss_clean');
		//$this->form_validation->set_rules('captcha', "Captcha", 'required');
              // echo '<pre>';
                //print_r($_POST); die();
		//$userCaptcha = $this->input->post('captcha');
		$captchaWord = $this->session->userdata('captchaWord');
		$captcha =  $this->input->post('captcha');
		
		if($captcha == $captchaWord)
		{
			if($this->form_validation->run() == true)
			{               
				$isValid = $this->user_model->checkDuplicateEmail(array("email"=>$this->input->post('email')));
				if(!$isValid) 
				{
					
					if($_FILES['form16']['name']!= "")
					{
						$str1 = $_FILES['form16']['name'];
						$strArray = count_chars($str1,1);

						foreach ($strArray as $dotkey=>$dotCountVal)
						  {
							  if(chr($dotkey) == '.')
							  {
								$dotCountValue[] = $dotCountVal;
							  }
						  }	
						  if($dotCountValue[0] > 1)
						  {
							  if(isset($bankID) && $bankID!='')
								{
									$this->session->set_flashdata("error", "Invalid or multiple File Extension Used!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid or multiple File Extension Used!");
									redirect('/registration/signup');
								}
						  }	
						  if($dotCountValue[0] == '1')
						  {
							  $getFileExt = explode('.',$_FILES['form16']['name']);
							  $getFileExt = $getFileExt[1];
							  $allowed =  array('gif','png' ,'jpg','jpeg','xls','doc','docx','zip','pdf');
							  if(!in_array($getFileExt,$allowed) ) {
									 if(isset($bankID) && $bankID!='')
										{
											$this->session->set_flashdata("error", "Invalid Extension Used!");
											redirect('/registration/signup?bi='.$bankID.'');
										}else{
											$this->session->set_flashdata("error", "Invalid Extension Used!");
											redirect('/registration/signup');
										}
								}
								
						  }	
					}
					
					if($this->input->post('email')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('email'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('confirmemail')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('confirmemail'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('first_name')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('first_name'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('last_name')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('last_name'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('fathers_husband_name')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('fathers_husband_name'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('address1')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('address1'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('address2')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('address2'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('zipcode')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('zipcode'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('pan_number')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('pan_number'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('gst_no')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('gst_no'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('phone_number')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('phone_number'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('mobile')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('mobile'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('fax_number')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('fax_number'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('organisation_name')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('organisation_name'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('authorised_person')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('authorised_person'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					if($this->input->post('designation')!= ''){
						$checkHTMLTags=$this->registration_model->checkHTMLTags($this->input->post('designation'));
						if($checkHTMLTags == "1"){
							if(isset($bankID) && $bankID!=''){
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup?bi='.$bankID.'');
								}else{
									$this->session->set_flashdata("error", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									redirect('/registration/signup');
								}
						}
					}
					
							
							//$res = $this->registration_model->save_step_first_temp();
							
							
							
							if(IS_PAYMENT_GATEWAY_OFF===TRUE)
							{
								$res = $this->registration_model->save_step_first();
								$this->session->set_flashdata('msg','Registration done Successfully !<br>');	
								redirect("/registration/signup");
							}
							else
							{
								$res = $this->registration_model->save_step_first_temp();
								
								$last_insert_id_payment = $this->registration_model->save_payment($res,$this->input->post('email'));
								
								redirect('/payment1/index?txnid='.base64_encode($last_insert_id_payment));die;
							}
											
							//$this->session->set_flashdata('msg','Registration Successful !<br>');
							$this->session->set_flashdata('msg','An Activation link has been sent to your registered email ID. Kindly click on the link to activate your account.'); //You will not be able to login in until your email address has been verified.!
							if(isset($bankID) && $bankID!='')
							{
								
								redirect('/registration/signup?bi='.$bankID.'');
							}else{

								redirect('/registration/signup');
							}
										   
							/*if($res)
							{
								$register_as = $this->input->post('register_as');
								if($register_as=='broker')
								{
									$str=base64_encode($res);
									$url_to_be_send=urlencode($str);
									redirect('/registration/signup/'.$url_to_be_send);
								}
								else
								{
									$this->session->set_flashdata('msg','Registration Successful !<br> A conformation email has been sent to your registered email ID.You will not be able to login in until your email address has been verified.!');
									redirect('/registration/signup');
								}
											
										   
							} */
				} else {
					$this->session->set_flashdata("msg1", "Email already exist");
					if(isset($bankID) && $bankID!='')
					{
						
						redirect('/registration/signup?bi='.$bankID.'');
					}else{

						redirect('/registration/signup');
					}
				}
			} else {
				redirect('/registration/');
			}
		}
		else
		{
			
			$this->session->set_flashdata('error','Please enter valid captcha code! <br>');
			
			if(isset($bankID) && $bankID!='')
			{
				
				redirect('/registration/signup?bi='.$bankID.'');
			}else{

				redirect('/registration/signup');
			}
		}
	}
	
	public function save_next()
	{
		$staticData=$this->home_model->getStaticContents(2);
		$data['staticData']=$staticData;
		$this->load->view('front_view/header',$data);
		
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('broker_name','company_name','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){				
			$this->load->view('registration-step-second', $data);
		}
		else
		{
			//print_r($_POST);
			$res = $this->registration_model->save_step_second();
			
			if($res)
			{
				$this->session->set_flashdata('msg','Successfully Register. You have sent a verification mail to you email id.!');
				redirect('/registration/save_next');
			}
		}	
		$this->load->view('front_view/footer');
		
	}
	
	public function userprofile(){
		if(!$this->session->userdata('id'))redirect("registration/login");
		
		$user_id = $this->session->userdata('id');
		$data['user_data']=$this->registration_model->GetRecordById($user_id);
		if($data['user_data'][0]->status!=5)
			redirect('/registration/redirectDashboard');
		
		$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);

		
		
		//print_r($data['user_data']);
		//$this->load->view('userprofile', $data);
		
		/******************** Right Section  **************************/
		$this->website_right();
		/******************* End Right Section  ************************/
		
		/********************** Footer Section  ************************/
		$this->load->view('front_view/footer');
		/******************* End Footer Section  ***********************/
	}
	

	
	
	public function login_via_google(){
		//Login For GooglePlus
		$google_client_id 		= '238313751600-a024t9m5t0fus6amhg32sthou3uuhcgf.apps.googleusercontent.com';
		$google_client_secret 	= '4gdI1_jR8pfV03guwuc86iww';
		$google_redirect_url 	= 'http://bankauction.afaqsdelhi.com/registration/login_via_google'; 
		$google_developer_key 	= 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		
		include_once APPPATH . "libraries/google/src/Google_Client.php";
		include_once APPPATH . "libraries/google/src/contrib/Google_Oauth2Service.php";
		
		$gClient = new Google_Client();
		$gClient->setApplicationName('bankeauction');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);

		$google_oauthV2 = new Google_Oauth2Service($gClient);
		//If user wish to log out, we just unset Session variable
		if (isset($_REQUEST['reset']))
		{
		  unset($_SESSION['token']);
		  $gClient->revokeToken();
		  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
		}

		if (isset($_GET['code'])){ 
			$gClient->authenticate($_GET['code']);
			$_SESSION['token'] = $gClient->getAccessToken();
			header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
			return;
		}

		if (isset($_SESSION['token'])){ 
			$gClient->setAccessToken($_SESSION['token']);
		}
		
		if ($gClient->getAccessToken()){
			//For logged in user, get details from google using access token
			$user = $google_oauthV2->userinfo->get();
			//print_r($user);die;
			if(isset($user['id'])){
				$user['login_via']='google';			
				//$this->process($user);
				$result=$this->registration_model->auth_via_google($user);
				if($result!='registered')
				{
					$data['password']=$result;
					$this->load->view('mail_template',$data);
				}
				redirect('registration/login');
			}
			
		}else{//For Guest user, get google login url
			$authUrl = $gClient->createAuthUrl();
			header('Location:'.$authUrl.'');
		}//Login For GooglePlus End Here
		
	}
	public function yahoologin() {
    set_include_path(APPPATH . "libraries/yahoo/Yahoo");
    require_once APPPATH . "libraries/yahoo/OAuth/OAuth.php";
    require_once APPPATH . "libraries/yahoo/Yahoo/YahooOAuthApplication.class.php";
    $CONSUMER_KEY      = 'dj0yJmk9ZDhEZWZVaURQejIyJmQ9WVdrOWFHUlBSR0V5Tm5FbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD00Mg--';
    $CONSUMER_SECRET   = 'dcee77130e9eae4304520e33db26f8d1c30bf669';
    $APPLICATION_ID    = 'hdODa26q';
    $CALLBACK_URL      = base_url("registration/yahoologin");
    $oauthapp      = new YahooOAuthApplication($CONSUMER_KEY, $CONSUMER_SECRET, $APPLICATION_ID, $CALLBACK_URL);

    # Fetch request token
    $request_token = json_decode($this->session->userdata('request_token'));
    # Exchange request token for authorized access token
    $access_token = $oauthapp->getAccessToken($request_token, $_REQUEST['oauth_verifier']);

    # update access token
    $oauthapp->token = $access_token;

    # fetch user profile
    $profile = $oauthapp->getProfile();

    var_dump($profile);
	}
	function yahoo($url) {
    if($url == 'login') {
        $url = base_url('registration/yahoologin');
    } else {
        $url = base_url('registration/yahooregister');
    }
	set_include_path(APPPATH . "libraries/yahoo/Yahoo");
   require_once APPPATH . "libraries/yahoo/OAuth/OAuth.php";
    require_once APPPATH . "libraries/yahoo/Yahoo/YahooOAuthApplication.class.php";
    $CONSUMER_KEY      = 'dj0yJmk9ZDhEZWZVaURQejIyJmQ9WVdrOWFHUlBSR0V5Tm5FbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD00Mg--';
    $CONSUMER_SECRET   = 'dcee77130e9eae4304520e33db26f8d1c30bf669';
    $APPLICATION_ID    = 'hdODa26q';
    $CALLBACK_URL      = $url;
    $oauthapp      = new YahooOAuthApplication($CONSUMER_KEY, $CONSUMER_SECRET, $APPLICATION_ID, $CALLBACK_URL);

    # Fetch request token
    $request_token = $oauthapp->getRequestToken($CALLBACK_URL);
    $this->session->set_userdata('request_token',json_encode($request_token));

    # Redirect user to authorization url
    $redirect_url  = $oauthapp->getAuthorizationUrl($request_token);
    redirect($redirect_url);
}
	public function refresh_captcha()
	{
		$word=random_string('numeric',6);
		$captcha=$this->captcha_image($word);
		$this->session->set_userdata('captchaWord', $captcha['word']);
		echo  $captcha['image'];
	}
	public function captcha_image($word='')
	{
		$vals = array(
			'img_path'  => './public/uploads/images/',
			'img_url'  => base_url().'public/uploads/images/',
			'word' => $word,
			'img_width' => 120,
			'img_height' => '55',
			'expiration' => 7200
			);
		$cap = create_captcha($vals);
		return $cap;
	}

	public function getStateDropDown($country_id,$state_id)
	{
		$states = $this->bank_model->GetState($country_id);
		$str='<option value=""></option>';
		foreach($states as $state_record)
		{
		$str.="<option value='$state_record->id'"; if($state_record->id==$state_id)$str.='selected';$str.=" >$state_record->state_name</option>";
		}
		echo $str;
	}	
	
	public function getCityDropDown($state_id,$city_id)
	{
		$cities = $this->bank_model->GetCity($state_id);
		$str='<option value="">Select City</option>';
		foreach($cities as $city_record)
		{
		$str.="<option value='$city_record->id'"; if($city_record->id==$city_id)$str.='selected';$str.=" >$city_record->city_name</option>";
		}
		echo $str;
	}

	
		
	function oldforgotPassword(){
		$utype	=	$this->input->post('utype');
		$email	= 	$this->input->post('email');
			if($email)
			{
				$this->registration_model->forgotPassword();
			}	
	}
	
	function updatePassword123(){
				$this->registration_model->updatePassword123();		
	}
	
	public function mobile_lgn()
	{
		$data = '';
		$this->load->view('front_view/header',$data);
		$this->load->view('mobile/mobile_login', $data);
		$this->load->view('front_view/footer');		
	}
	
	public function mobile_lgn1()
	{		 
		$userRegData = $this->registration_model->check_device_unique_id();
		//echo "<pre>";
		//print_r($userRegData);die;			
		$data = '';
		$this->load->view('front_view/header',$data);
		
		if(count($userRegData)>0 && ($userRegData['mPin'] ==null || $userRegData['mPin'] == ''))
		{			
			//$this->load->view('mobile/mobile_set_mpin', $data);			
			redirect('registration/mobile_set_mpin');
		}
		else if(count($userRegData)>0 && $userRegData['mPin'] !='')
		{			
			redirect('registration/mobile_login_mpin');
			//$this->load->view('mobile/mobile_login_mpin', $data);
		}
		else
		{
			$this->load->view('mobile/mobile_login', $data);			
		}
		
		$this->load->view('front_view/footer');	
		
	}
	
	public function mobile_set_mpin()
	{		
		$data = '';
		$this->load->view('front_view/header',$data);
		$this->load->view('mobile/mobile_set_mpin', $data);					
		$this->load->view('front_view/footer');	
		
	}
	
	public function set_mpin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mpin', 'mPin', 'trim|required|min_length[4]|xss_clean');		
		$this->form_validation->set_rules('conf_mpin', 'Confirm mPin', 'trim|required|min_length[4]|xss_clean');
		
		if($this->form_validation->run() == FALSE){			
			$data['error_msg']="Enter Required Fields!";
			$this->session->set_flashdata('error_msg', $data['error_msg']);	
			redirect("registration/mobile_lgn");
		}else{
			
			$res = $this->registration_model->set_mpin();
			
			if($res)
			{
				redirect('registration/mobile_login_mpin');
			}
			else
			{
				redirect('registration/mobile_set_mpin');
			}
		}	
		
	}
	
	public function mobile_login_mpin()
	{		
		$data = '';
		$this->load->view('front_view/header',$data);
		$this->load->view('mobile/mobile_login_mpin', $data);					
		$this->load->view('front_view/footer');	
		
	}
	
	public function lgn_mpin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mpin', 'mPin', 'trim|required|min_length[4]|xss_clean');	
		if($this->form_validation->run() == FALSE){			
			$data['error_msg']="Enter Required Fields!";
			$this->session->set_flashdata('error_msg', $data['error_msg']);	
			redirect("registration/mobile_lgn");
		}else{
			
			$res = $this->registration_model->lgn_mpin();
			
			if($res>0)
			{
				redirect('registration/redirectDashboard');
			}
			else
			{
				redirect('registration/mobile_login_mpin');
			}
		}	
		
	}
	
	public function forgot_login_pin()
	{
		$res = $this->registration_model->forgot_login_pin();
		redirect('registration/mobile_lgn');
		die;		
	}

	public function sendMobileCode()
	{
		$mobileNo = $this->input->post('mobile');		
		$randNumber=rand(100000,999999);
		$randNumber = 111111;
		$this->session->set_userdata('mobileVerificationCode', $randNumber);
		$this->session->set_userdata('mobileNo', $mobileNo);

		$smsData = array( 
                            'mobile' => $mobileNo,
                            'SMSMessage' => "Verification code is ".$randNumber
                        );
                        
                        if($mobileNo !=''){
							$this->load->library('Email_new','email');
							$email = new email_new();
							$datam = $email->sendSMS($smsData);
							echo $datam;die('--Done--');
						}
						echo 'tet';die;
	}

	public function verMobileCode()
	{
		$mobileNo = $this->input->post('mobile');
		$mobile_verification_code = $this->input->post('mobile_verification_code');

		$mobile_verification_code_session = $this->session->userdata('mobileVerificationCode');
		$mobileNo_session = $this->session->userdata('mobileNo');

		if($mobile_verification_code_session == $mobile_verification_code  && $mobileNo_session == $mobileNo)
		{
			echo 'success';die;
		}
		echo 'fail';die;
	}

	public function sendEmailCode()
	{
		$email = $this->input->post('email');		
		$randNumber=rand(100000,999999);
		//$randNumber = 111111;
		$this->session->set_userdata('emailVerificationCode', $randNumber);
		$this->session->set_userdata('email', $email);
		$body = "Code: ".$randNumber;
		$subject = "Verification Code!";
                        
                        if($email !=''){
							$this->load->library('Email_new','email');
							$email_obj = new email_new();
							echo $email_obj->sendMailToUser(array($email),$subject,$body);  
							die('--Done--');
						}
						echo 'tet';die;
	}

	public function verEmailCode()
	{
		$email = $this->input->post('email');
		$email_verification_code = $this->input->post('email_verification_code');

		$email_verification_code_session = $this->session->userdata('emailVerificationCode');
		$email_session = $this->session->userdata('email');

		if($email_verification_code_session == $email_verification_code  && $email_session == $email)
		{
			echo 'success';die;
		}
		echo 'fail';die;
	}

	
	
}

?>
