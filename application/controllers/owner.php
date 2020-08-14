<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Owner extends WS_Controller {

	public $isNewDscPlugin = true;

    public function __Construct() {
		
        parent::__Construct();
        ob_start();
        ob_clean();
        $this->load->library('session');
        $this->load->helper('log4php');
        log_error('my_error');
        log_info('my_info');
        log_debug('my_debug');
        //error_reporting(0);
        $this->load->helper('url');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
        $this->load->model('property_model');
        $this->load->helper(array('form'));
        $this->load->library("pagination");
        $this->load->model('banker_model');
        
        $this->load->model('admin/bank_model');
        $this->load->model('helpdesk_executive_model');
        $this->load->model('admin/dynamic_form_model');
        $this->load->model('owner_model');
        $this->load->model('banker_model');
        $this->load->model('bidder_model');
       // $this->load->model('admin/attribute_group_model');
        $this->load->model('product_image_model');
        $this->load->model('product_video_model');
        $this->load->helper('file');
        $this->load->model('home_model');
        $this->load->model('product_detail_model');
       
       
        
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
		
		$method = $this->router->fetch_method();
		$methodArr = array('update_payment_response','cancel_payment_request');		
		if(!in_array($method,$methodArr))
		//if($method != 'update_payment_response' || $method != 'cancel_payment_request')
		{			
			$this->check_isvalidated1();
			//$this->check_isvalidated();
			 
			// checking sso login 
			$this->banker_model->check_sso_login();
		}
    }

    public function index() {
        $this->dashboard();
    }

    private function check_isvalidated() {
        if ((!$this->session->userdata('id') && $this->session->userdata('user_type') != 'owner')) {
            redirect('/registration/logout');
        } else {
            return true;
        }
    }

    private function check_isvalidated1() {
      /*  if (!$this->session->userdata('id') || !($this->session->userdata('user_type') == 'owner' || $this->session->userdata('user_type') == 'builder' || $this->session->userdata('user_type') == 'broker')) {
            redirect('/registration/logout');
        }*/
        
        if($this->session->userdata('id') && ($this->session->userdata('user_type')=='owner' || $this->session->userdata('user_type')=='builder'))
		{
		}
		else
		{			
			redirect('/registration/logout');
		}
    }

    public function dashboard() {
		
        $data['heading'] = 'Owner Dashboard';
        $data['controller'] = 'owner';
        //$data['dashboard_statics_data'] = $this->owner_model->buyDashboardData();
        //echo '<PRE>',print_r($data['dashboard_statics_data']);echo '</PRE>';
        $this->load->view('common/owner_header_user');
        // $category=$this->owner_model->GetPopularPropertyType();
        // $data['getpopular'] = $category; 		
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        

		if(MOBILE_VIEW)
		{
			$this->load->view('mobile/mobile_dashboard', $data);
			//$this->load->view('mobile/dashboard_eauc', $data);
		}
		else
		{
			$this->load->view('owner_view/dashboard_eauc', $data);
		}
		
        $this->load->view('common/footer_eauc');
        //$this->output->set_header('Cache-control: no-store');
		//$this->output->set_header('Pragma: no-cache');
    }
    
    
    public function dashboard_list() {
		
        $data['heading'] = 'Owner Dashboard';
        $data['controller'] = 'owner';
        //$data['dashboard_statics_data'] = $this->owner_model->buyDashboardData();
        //echo '<PRE>',print_r($data['dashboard_statics_data']);echo '</PRE>';
        $this->load->view('common/owner_header_user');
        // $category=$this->owner_model->GetPopularPropertyType();
        // $data['getpopular'] = $category; 		
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        

		if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/dashboard_eauc', $data);
		}
		else
		{
			$this->load->view('owner_view/dashboard_eauc', $data);
		}
		
        $this->load->view('common/footer_eauc');
        //$this->output->set_header('Cache-control: no-store');
		//$this->output->set_header('Pragma: no-cache');
    }
    

    /*     * ********************    Start  myMessage     *********************** */

    public function myMessage() {

        if ($this->input->post('mark_as_read')) {


            if (($this->input->post('status'))) {

                $status = $this->input->post('status');

                foreach ($status as $status_id) {

                    //echo '<br />'.$status_id;
                    $data['msg_status'] = 1;
                    $this->db->where('id', $status_id);
                    $this->db->where('user_type', 'bidder');
                    $this->db->update('tbl_message', $data);
                }
            } else {

                $this->session->set_flashdata('message_validation', "Error: Kindly select any one.");
            }

            redirect('owner/myMessage');
        }

        if ($this->input->post('delete_all')) {

            //echo '<pre>', print_r($this->input->post('status')), '</pre>';

            if (($this->input->post('status'))) {

                $delete = $this->input->post('status');

                foreach ($delete as $delete_id) {

                    //echo '<br />'.$status_id;
                    $data['status'] = 5;
                    $this->db->where('id', $delete_id);
                    $this->db->update('tbl_message', $data);
                }
            } else {

                $this->session->set_flashdata('message_validation', "Error: Kindly select any one.");
            }

            redirect('owner/myMessage');
        }


        //echo "<pre>";print_r($user_record);die;
        $data['heading'] = 'My Message';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myMessageLeft', '', true);

        $userType = $this->session->userdata('user_type');
        switch ($userType) {
            case "owner":
                $total_record = $this->owner_model->GetCITotalRecord();
                break;

            default:
                $total_record = $this->owner_model->GetCIUserRecord($this->session->userdata('id'));
                break;
        }


        $data['records'] = $total_record;

        $this->load->view('owner_view/owner_myMessage', $data);
        $this->load->view('common/footer');
    }

    public function myMessage_reply_msg($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Reply Message';
            $message_id = $param;
        } else {
            $data['heading'] = 'Add Message';
        }

        if ($message_id) {
            $array_records = $this->owner_model->GetRecordById($message_id);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $data['get_user_data'] = $this->owner_model->GetUserData();
        $message = $this->owner_model->GetParentRecordsControl();
        $data['message'] = $message;

        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myMessageLeft', '', true);
        $this->load->view('owner_view/owner_myMessage_add-edit', $data);
        $this->load->view('common/footer');
    }

    public function myMessage_new($param) {

        $data['heading'] = 'New Message';
        $data['controller'] = 'owner';
        $data['row'] = $array_records;

        $message = $this->owner_model->GetParentRecordsControl();
        $data['message'] = $message;

        $data['get_user_data'] = $this->owner_model->GetUserData();

        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myMessageLeft', '', true);
        $this->load->view('owner_view/owner_myMessage_add-edit', $data);
        $this->load->view('common/footer');
    }

    public function myMessage_save() {

        $id = $this->input->post('id');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('msg_to', 'To', 'trim|required|xss_clean');
        $this->form_validation->set_rules('msg_body', 'Message', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
            //echo $this->session->flashdata('message_validation');

            if (!empty($id)) {

                redirect('owner/myMessage_reply_msg/' . $id);
            } else {

                redirect('owner/myMessage_new');
            }
        } else {

            $save = $this->owner_model->myMessage_save_message_data();

            if ($save) {
                redirect('owner/myMessage');
            }
        }
    }

    function myMessage_autocomplete() {

        $data = $this->owner_model->myMessage_get_autocomplete();
        //echo "<select>";

        if ($data) {
            foreach ($data as $row):
                //echo "<option id='$row->id' value=\"$row->id\" onclick=\"fill('$row->first_name $row->last_name ($row->email_id)')\">".$row->first_name." ".$row->last_name." (".$row->email_id.")</option>";
                echo "<li id='$row->id' value=\"$row->id\" onclick=\"fill('$row->id', '$row->first_name $row->last_name ($row->email_id)')\">" . $row->first_name . " " . $row->last_name . " (" . $row->email_id . ")</li>";
            endforeach;
        }
        //echo "</select>";
    }

    public function myMessage_delete_msg($id) {

        //echo $id;
        //$data['date_modified']=date('Y-m-d H:i:s');

        $data['status'] = 5;
        $this->db->where('id', $id);
        $this->db->update('tbl_message', $data);
        redirect('owner/myMessage');
    }

    public function myMessageUser() {

        $data['heading'] = 'My User Message';
        $message_id = $param;
        $data['row'] = $array_records;

        //$data['get_user_data'] = $this->owner_model->GetUserData();
        $message = $this->owner_model->GetUserTotalRecord();
        $data['records'] = $message;
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myMessageLeft', '', true);
        $this->load->view('owner_view/owner_myMessageUser', $data);
        //$this->load->view('owner_view/owner_myActivity', $data);
        $this->load->view('common/footer');
    }

    public function myMessageTrash() {

        $data['heading'] = 'My Trash Message';
        $message_id = $param;
        $data['row'] = $array_records;
        $message = $this->owner_model->GetTrashTotalRecord();
        $data['records'] = $message;
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myMessageLeft', '', true);
        $this->load->view('owner_view/owner_myMessageTrash', $data);
        $this->load->view('common/footer');
    }

    /*     * ********************     End myMessage     *********************** */

    /*     * ********************      myProfile     *********************** */

    public function myProfile() {

        $data['heading'] = 'My Profile';
        $data['controller'] = 'owner';
        $data['tab_type'] = 'Buy';
        $this->load->view('common/owner_header_user');
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        //$data['leftPanel'] = $this->load->view('owner_view/owner_myProfileLeft', '', true);
        $response = $this->owner_model->myProfileUserData();
        $data['row'] = $response;
        $this->load->view('owner_view/owner_myProfile', $data);
        $this->load->view('common/footer_eauc');
    }

    public function sellmyProfile() {
        $data['tab_type'] = 'Sell';
        $data['heading'] = 'My Profile';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $data['leftPanel'] = $this->load->view('owner_view/owner_myProfileLeft', '', true);
        $response = $this->owner_model->myProfileUserData();
        $data['row'] = $response;
        $this->load->view('owner_view/owner_myProfile', $data);
        $this->load->view('common/footer_eauc');
    }

    public function myProfileEdit() {

        $countries = $this->bank_model->GetCountries();
        $data['countries'] = $countries;
        $states = $this->bank_model->GetState();
        $data['states'] = $states;
        $cities = $this->bank_model->GetCity();
        $data['cities'] = $cities;

        $data['heading'] = 'Modify Profile - Subscribed User';
        $response = $this->owner_model->myProfileUserData();
        $emailAlertData = $this->owner_model->memberEmailAlertData();
		$isPremiumMember = $this->owner_model->isPremiumMember();
        //echo '<pre>';
        //print_r($emailAlertData);die;

        $data['row'] = $response;
        $data['emailAlertData'] = $emailAlertData;
        $data['isPremiumMember'] = $isPremiumMember;
        $data['controller'] = 'owner';
        $this->load->view('front_view/header');
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        
        $this->load->view('owner_view/owner_myProfileEdit', $data);
        $this->load->view('front_view/footer');
    }

    public function myProfileEditSave() {
		
        $this->load->library('form_validation');
		//echo "<pre>"; print_r($_POST);die;
        if($this->input->post('profile_type') != 'builder'){
			//echo 'O';
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		}else{
			//echo 'B';
			$this->form_validation->set_rules('organisation_name', 'Company name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('authorized_person', 'Authorized Person', 'trim|required|xss_clean');
		}
        
        //$this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|xss_clean');
        
        $this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|numeric|xss_clean');
        //$this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|xss_clean');
		//print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields");
            //echo $this->session->flashdata('message_validation');
			//echo validation_errors();die;
            redirect('owner/myProfileEdit');
        } else {
			
			if($this->input->post('first_name') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('first_name'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			if($this->input->post('last_name') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('last_name'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			
			
			if($this->input->post('mobile_no') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('mobile_no'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			if($this->input->post('address1') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('address1'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			
			if($this->input->post('zip') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('zip'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			if($this->input->post('gst_no') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('gst_no'));
				if($checkHTMLTags == "1"){
						$this->session->set_flashdata("message_validation", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
						redirect('owner/myProfileEdit');
				  }
			}
			
			if($this->input->post('pcb') == 1)
			{
				$pwd = $this->input->post('password');
				$cpwd = $this->input->post('confirm_password');
				if($pwd == '')
				{
					$this->session->set_flashdata('message_validation','Password field is required'); 
					redirect('owner/myProfileEdit');
					exit;
				}
				else if(!preg_match('/[A-Z]+/', $pwd) || !preg_match('/[a-z]+/',$pwd) || !preg_match('/[\d\W]+/',$pwd) || !preg_match('/\S{8,}/',$pwd))
				{
					
					$this->session->set_flashdata('message_validation','Password must contain 8 characters with 1 Upper, 1 Lower and 1 Number');
					redirect('owner/myProfileEdit');
					exit;
				}
				else if($pwd != $cpwd)
				{
					$this->session->set_flashdata('message_validation','Password do not match'); 
					redirect('owner/myProfileEdit');
					exit;
				}
			}	
				
            $save = $this->owner_model->myProfileEditSaveData();
            if ($save) {
				$this->session->set_flashdata("message_validation_1", 'Profile Updated Successfully!');
                //redirect('owner/myProfile');
                redirect('owner/myProfileEdit');
            }
        }
    }

    public function myProfileChangePassword() {

        $data['heading'] = 'Profile - Change Password';
		
        $response = $this->owner_model->myProfileUserData();
        //echo '<pre>';
        //print_r($response);
        $data['row'] = $response;

        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        //$data['leftPanel'] = $this->load->view('owner_view/owner_myProfileLeft', '', true);
        $this->load->view('owner_view/owner_myProfileChangePasswod', $data);
        $this->load->view('common/footer_eauc');
    }

    public function myProfileChangePasswordSave() {
		 $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('o_password', 'Old Password', 'required');
        $this->form_validation->set_rules('n_password', 'New Password', 'required');
        $this->form_validation->set_rules('c_password', 'New Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
            //echo $this->session->flashdata('message_validation');
            redirect('owner/myProfileChangePassword');
        } else {

            $o_password = $this->input->post('o_password');
            $n_password = $this->input->post('n_password');
            $c_password = $this->input->post('c_password');
			
			if ($o_password == $n_password) {				
                $this->session->set_flashdata('message_validation', "Error: Old and New Password cannot be same!");
                redirect('owner/myProfileChangePassword');
            }elseif ($n_password != $c_password) {				
                $this->session->set_flashdata('message_validation', "Error: New Password and Confirm Password should be same!");
                redirect('owner/myProfileChangePassword');
            } else {
				$r3='/[!@%^*()\-_=+{};:,.]/';
				$r4='/</';
				$r5='/>/';
				$r6='/&/';
				$r7='/#/';
				//$r8='/$/';
				
				//$n_password = "Demo@123#";
				//echo $n_password;echo "|";
				//echo preg_match($r8,$n_password);die;
				if(strlen($n_password) < 8 || !preg_match('/[A-Z]+/', $n_password) || !preg_match($r3,$n_password) || preg_match($r4,$n_password) || preg_match($r5,$n_password) || preg_match($r6,$n_password) || preg_match($r7,$n_password))
				{
					$this->session->set_flashdata('message_validation', "Error: Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#)");
					redirect('owner/myProfileChangePassword');
				}
				else
				{
					$response = $this->owner_model->myProfileUserData();
					if ($response['0']->password != hash("sha256", $o_password)) {
						$this->session->set_flashdata('message_validation', "Error: Old Password did not match!");
						redirect('owner/myProfileChangePassword');
					} else {
						$data['password'] = hash("sha256", $n_password);
						$this->db->where('id', $this->session->userdata('id'));
						$this->db->update('tbl_user_registration', $data);
						$this->session->set_flashdata("message_validation_1", 'Password Updated Successfully!');
						// redirect('owner/myProfile');
						redirect('owner/myProfileChangePassword');
					}
				}
            }
        }
    }

    /*     * ********************      myProfile     *********************** */
    /*     * ********************      postRequirement     *********************** */

    

    public function manageRequirement($action = '', $id = '') {

        if ($action && $id) {
            if ($action == 'edit') {
                redirect('/owner/postRequirement/' . $id);
            } elseif ($action == 'del') {
                $msg = "Requirement successfully submited.";
                $erows = $this->owner_model->delPostRequirement($id);
                redirect('/owner/manageRequirement');
            }
        }
        $data['heading'] = 'Manage Requirement';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabtype'] = 'MyRequirement';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);

        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $this->load->view('owner_view/MyactivityManageRequirement', $data);
    }

    public function manageRequirementDatatable() {

        echo $this->owner_model->manageRequirementDatatable();
    }

    public function matchingRequirement() {
        $data['heading'] = 'Manage Requirement';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyRequirement';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $this->load->view('owner_view/MyactivityMatchingRequirement', $data);
    }

    public function matchingRequirementDatatable() {
        echo $this->owner_model->matchingRequirementDatatable($_GET);
    }

    public function matchingRequirementPopup($requirementID) {

        $data['matching_product'] = $this->owner_model->matchingRequirementPopup($requirementID);
        $this->load->view('owner_view/banker_myActivityEventDetailPopup', $data);
    }

    /*     * ********************     End postRequirement     *********************** */
    /*     * ********************    Live Auction     *********************** */

    public function liveAuction() {

        $data['heading'] = 'Live Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        if(MOBILE_VIEW)
        {
			$this->load->view('mobile/MyactivityLiveAuction_eauc', $data);
		}
		else
		{
			$this->load->view('owner_view/MyactivityLiveAuction_eauc', $data);
		}
        $this->website_footer();
    }

    /*     * ********************     End Live Auction     *********************** */

    public function pro_detail($pid) {
        $id = $pid;
        $data['id'] = $id;
        
        //print_r($this->session->userdata);
        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('user_type');
        $data['userId'] = trim($user_id);
        $response = $this->product_detail_model->checkBankNonbank($id);
        $productRecords = $this->product_detail_model->GetRecords($id);
        $productRecords1 = $this->product_detail_model->GetRecords_auction($id);
        $data['auctionData'] = $productRecords1;
        /* Show only open event */
        if($productRecords1[0]->show_home != 1 && !$this->owner_model->checkOwnerLimitedUser($productRecords1[0]->id))        
        {
			//redirect("owner");
		}
	 
        $auctionId  =   GetTitleByField('tbl_auction', "productID='".$id."'", 'id');
	$data['uploadedDocs'] = $this->bank_model->GetUploadedDocsByAuctionId($auctionId);
        
        // get review rating id for particular product and user //
        $rating_review_id = $this->product_detail_model->GetRatingReviewId($id, $user_id);
        $data['rating_review_id'] = $rating_review_id;

        //search //
        $categoryList = $this->property_model->categoryList();
        $budgetArr = $this->property_model->getPropertyBudget();
        $data['budgetArr'] = $budgetArr;
        $data['categoryList'] = $categoryList;

        //similar properties data //
        $data['property_type'] = $this->product_detail_model->getSimilarProperties($productRecords[0]->product_type_val, $id);

        // product attribute value
        $attrib = $this->product_detail_model->getattributeValuedata($id);
        //echo "<pre>";print_r($attrib);die;
        $data['area'] = $attrib[0]->values;
        $data['room'] = $attrib[1]->values;
        $data['bathroom'] = $attrib[2]->values;
        // recent properties
        $data['recent_properties'] = $this->product_detail_model->getRecentProperties();
        // get product reviews //
        $data['reviewAll'] = $this->product_detail_model->getReviews($id, $user_id);
        $data['countUser'] = $this->property_model->totalRatedUsers($pid);
        $neighborhood = $this->property_model->getStartRatingAverage('neighborhood', $pid);
        $safety = $this->property_model->getStartRatingAverage('safety', $pid);
        $cleanliness = $this->property_model->getStartRatingAverage('cleanliness', $pid);
        $public_transport = $this->property_model->getStartRatingAverage('public_transport', $pid);
        $parking = $this->property_model->getStartRatingAverage('parking', $pid);
        $connectivity = $this->property_model->getStartRatingAverage('connectivity', $pid);
        $traffic = $this->property_model->getStartRatingAverage('traffic', $pid);
        $data['neighborhood'] = $neighborhood['totalAverage'];
        $data['safety'] = $safety['totalAverage'];
        $data['cleanliness'] = $cleanliness['totalAverage'];
        $data['public_transport'] = $public_transport['totalAverage'];
        $data['parking'] = $parking['totalAverage'];
        $data['connectivity'] = $connectivity['totalAverage'];
        $data['traffic'] = $traffic['totalAverage'];
//if (!empty($user_id)) {
        // rating review data for user//
        $rating_review = $this->product_detail_model->getRatingReviewData($user_id, $id);
        $data['total_rating'] = $rating_review[0]->total_rating;
        $data['reviews'] = $rating_review[0]->reviews;
//} 
        //heading addreess 
        $bankDetail = $this->product_detail_model->bankDetails($id);

        //echo "bankDetail--".$bankDetail[0]->auction_type;

        if ($bankDetail[0]->auction_type == '1') {
            $userData = $this->product_detail_model->getUserbyTypeDetails('tbl_user_registration', $productRecords[0]->user_id);
        } else {
            $userData = $this->product_detail_model->getUserbyTypeDetails('tbl_user', $productRecords[0]->user_id);
        }
        $data['address'] = $productRecords[0]->address1;
        $is_auction = $productRecords[0]->is_auction;
        $data['street'] = $productRecords[0]->street;
        $data['title'] = $productRecords[0]->name;
        $data['updated_date'] = $productRecords[0]->updated_date;
        $data['updated_by'] = $userData[0]->first_name;
        $data['product_description'] = $productRecords[0]->product_description;
        $cityName = $this->product_detail_model->getCity($productRecords[0]->city);
        $data['city_name'] = $cityName[0]->city_name;
        $country = GetTitleByField('tbl_country', "id='" . $userData[0]->country . "'", 'country_name');
        
        
        //$data['catename'] = $productRecords[0]->product_type_val;
        //$data['subcategory'] = $productRecords[0]->product_subtype_val;
        
         if($productRecords1[0]->category_id!=''){
	$data['catename']=  GetTitleByField('tbl_category','id='.$productRecords1[0]->category_id,'name');
        }else{
         $data['catename']='';   
        }
		  if($productRecords1[0]->area_unit_id!=''){
			$data['areaUnit']=GetTitleByField('tblmst_uom_type','uom_id='.$productRecords1[0]->area_unit_id,'uom_name');
		  }else{
			$data['areaUnit']=''; 
		  }
		  
		  if($productRecords1[0]->height_unit_id!=''){
			$data['heightUnit']=GetTitleByField('tblmst_uom_type','uom_id='.$productRecords1[0]->height_unit_id,'uom_name');
		  }else{
			$data['heightUnit']=''; 
		  }
		  
		  if($productRecords1[0]->unit_id_of_price!=''){
			$data['priceUnit']=GetTitleByField('tblmst_uom_type','uom_id='.$productRecords1[0]->unit_id_of_price,'uom_name');
		  }else{
			$data['priceUnit']=''; 
		  }
		  
        
        
        $data['supporting_doc'] = $bankDetail[0]->supporting_doc;

        $fulladdress = $productRecords[0]->address1 . ', ' . $productRecords[0]->street . ', ' . $data['city_name'] . ', ' . $country;

        $data['fulladdress'] = $fulladdress;
        //interested user //
        $interested_users = $this->product_detail_model->getInterestedUser($pid);
        $data['interested_users'] = $interested_users[0]->users;

        $blog_records = $this->product_detail_model->getBlogs();


        $product_image = $this->product_detail_model->productImage($id);
        $product_video = $this->product_detail_model->productVideo($id);
        $data['video'] = $product_video;


        $varified = $this->product_detail_model->imageVerified($id);
        $data['verified'] = trim($varified[0]->values);
        //tab photos

        $data['product_image'] = $bankDetail[0]->image;
        //Recent blogs
        $data['blogs'] = $blog_records;
        $documentRecords = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);

        $data['docList'] = $documentRecords;
        $data['eventImage'] = $documentRecords;

        $_SESSION['docName'] = $bankDetail[0]->related_doc;

        //product image
        $data['productImage'] = $product_image[0]->name;
        $data['auction_type'] = $bankDetail[0]->auction_type;

        // Basic Details
        $data['auctionID'] = $bankDetail[0]->id;
        $data['borrower_name'] = $bankDetail[0]->borrower_name;
        $bankName = $this->product_detail_model->getBankName($bankDetail[0]->bank_id);
        $bankName1 = $this->product_detail_model->getBankDetail($bankDetail[0]->bank_id);


        $branchname = GetTitleByField('tbl_branch', "id='" . $bankDetail[0]->branch_id . "'", 'name');
        
        if($bankDetail[0]->event_type == 'drt' && $bankDetail[0]->bank_branch_id > 0)
		{
			$branchname=GetTitleByField('tbl_branch',"id='".$bankDetail[0]->bank_branch_id."'",'name');
		}
		
		
        $nodelbranchname = GetTitleByField('tbl_bank', "id='" . $bankDetail[0]->nodal_bank_name . "'", 'name');
        $totalCirrigendum = $this->property_model->checkAuctionCirrigendum($bankDetail[0]->id);
        $data['totalCirrigendum'] = $totalCirrigendum;
        $data['branchname'] = $branchname;
        $data['nodelbranchname'] = $nodelbranchname;
        $data['bank_name'] = $bankName[0]->name;                
        $data['press_release_date'] = $bankDetail[0]->press_release_date;
        
        $data['NIT_date'] = $bankDetail[0]->NIT_date;
        
        $data['inspection_date_from'] = $bankDetail[0]->inspection_date_from;
        $data['inspection_date_to'] = $bankDetail[0]->inspection_date_to;
        $data['bid_last_date'] = $bankDetail[0]->bid_last_date;
        //$data['bid_last_date'] = $bankDetail[0]->tender_fee;
        $data['bid_opening_date'] = $bankDetail[0]->bid_opening_date;
        $data['created_by'] = $bankDetail[0]->created_by;
        $data['first_opener'] = $bankDetail[0]->first_opener;
        //Auction Details
        
        $data['tender_no'] = $bankDetail[0]->tender_no;
        $data['event_type'] = $bankDetail[0]->event_type;
        $data['reference_no'] = $bankDetail[0]->reference_no;
        $data['tender_fee'] = $bankDetail[0]->tender_fee;
        $data['price_bid_applicable'] = trim($bankDetail[0]->price_bid_applicable);
        $data['reserve_price'] = $bankDetail[0]->reserve_price;
        $data['emd_amt'] = $bankDetail[0]->emd_amt;
        $data['auction_start_date'] = $bankDetail[0]->auction_start_date;
        $data['auction_end_date'] = $bankDetail[0]->auction_end_date;
        $data['bid_inc'] = $bankDetail[0]->bid_inc;
        $data['auto_extension_time'] = $bankDetail[0]->auto_extension_time;
        if (!($data['auto_extension_time'] > 0)) {
            $data['auto_extension_time'] = "5";
        }
        //$data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;

     
        

        //  $data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;
        $data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;
        if (!($data['no_of_auto_extn'] > 0) || $data['no_of_auto_extn'] == 100 ) {
            $data['no_of_auto_extn'] = "Unlimited";
        }

        $data['doc_to_be_submitted'] = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);
        $data['main_data'] = $bankDetail[0];


        // user total ratings
        $userRating = $this->product_detail_model->userRating($user_id, $id);
        $rating = ($userRating[0]->neighborhood + $userRating[0]->safety + $userRating[0]->cleanliness + $userRating[0]->public_transport + $userRating[0]->parking + $userRating[0]->connectivity + $userRating[0]->traffic) / 7;
        $format_rating = number_format($rating, 2);
        $this->product_detail_model->insertUserRating($format_rating, $user_id, $id);

        // calculate total average //

        $getTotalRating = $this->product_detail_model->getTotalRating($id);
        $totalAvg = $getTotalRating[0]->totalsum / $getTotalRating[0]->totalrow;
        $data['totalAvgRating'] = number_format($totalAvg, 1);

        //user Rating Category
        $getRatingCategory = $this->product_detail_model->userRatingCategory($id);
        
        //get corrigendum 
        $data['corrigendum'] = $this->product_detail_model->getAllCorrigendumByAuctionID($bankDetail[0]->id);
        
        //echo '<pre>';
        //print_r($data['corrigendum']);

        $excellent = 0;
        $veryGood = 0;
        $good = 0;
        for ($i = 0; $i < count($getRatingCategory); $i++) {

            if (($getRatingCategory[$i]->total_rating > 4) && ($getRatingCategory[$i]->total_rating <= 5)) {
                $excellent++;
            } else if (($getRatingCategory[$i]->total_rating >= 3) && ($getRatingCategory[$i]->total_rating <= 4)) {
                $veryGood++;
            } else if (($getRatingCategory[$i]->total_rating >= 2) && ($getRatingCategory[$i]->total_rating < 3)) {
                $good++;
            }
        }
        $data['excellent'] = $excellent;
        $data['veryGood'] = $veryGood;
        $data['good'] = $good;
        //echo "ex= ".$excellent."vg= ".$veryGood."g= ".$good;die;
        // download link availability //
        $doc = $this->product_detail_model->getDoc($id);
        $data['docName'] = $doc[0]->related_doc;
        
        $CorrigendumDocImages = $this->product_detail_model->getCorrigendumDocImages($bankDetail[0]->id);
        $data['CorrigendumDocImages'] = $CorrigendumDocImages;
        
        $CorrigendumSupportingDocSpecialImages = $this->product_detail_model->getCorrigendumSupportingDocSpecialImages($bankDetail[0]->id);
        $data['CorrigendumSupportingDocSpecialImages'] = $CorrigendumSupportingDocSpecialImages;
        
        $getCorrigendumRelatedDocImages = $this->product_detail_model->getCorrigendumRelatedDocImages($bankDetail[0]->id);
        $data['getCorrigendumRelatedDocImages'] = $getCorrigendumRelatedDocImages;
        
        
        // $this->load->view('front_view/header');
        $this->load->view('common/owner_header_user', $data);
       
        $this->load->view('owner_view/productdetail_bank', $data);
        $this->website_footer();
    }

    /*     * ********************    Upcoming Auction     *********************** */

    public function upcomingAuction() {

        $data['heading'] = 'Upcoming Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $this->load->view('owner_view/MyactivityUpcomingAuction_eauc', $data);
        $this->website_footer();
    }

    public function upcomingAuctionDatatable2() {

        echo $this->owner_model->upcomingAuctionDatatable2();
    }

    public function upcomingAuctionDatatable() {

        echo $this->owner_model->upcomingAuctionDatatable1();
    }

    public function liveupcomingAuctionDatatable() {

        echo $this->owner_model->liveupcomingAuctionDatatable1();
    }
    
    public function inprogressAuctionDatatable() {

        echo $this->owner_model->inprogressAuctionDatatable();
    }

    function completedAuctionsdatatable() {
        echo $this->owner_model->concludeAuctionsdatatable_main();
    }

    public function liveAuctionDatatable() {
        echo $this->owner_model->liveAuctionDatatable();
    }

    public function liveEventDatatable1() {
        echo $this->owner_model->ownerliveEventDatatable1();
    }

    public function liveEventDatatable_main() {
        echo $this->owner_model->ownerliveEventDatatable_main();
    }

    public function liveEventDatatable_main_fav() {
        echo $this->owner_model->ownerliveEventDatatable_main_fav();
    }

    public function liveEventDatatable_main_fav_sub() {
        echo $this->owner_model->ownerliveEventDatatable_main_fav_sub();
    }

    public function liveAuctionDatatable_sub() {
        echo $this->owner_model->ownerliveEventDatatable_sub();
    }

    public function liveupcomingAuctionDatatable_fav() {

        echo $this->owner_model->liveupcomingAuctionDatatable1_fav();
    }

    public function liveupcomingauciton_fav_remove($auctionId) {

        $save = $this->owner_model->liveupcomingauciton_fav_remove_save($auctionId);
        if ($save) {

            redirect('owner/');
        }
    }

    public function liveupcomingauciton_favevent_remove($auctionId) {

        $save = $this->owner_model->liveupcomingauciton_favevent_remove_save($auctionId);
        if ($save) {

            redirect('owner/');
        }
    }

    public function liveupcomingauciton_event_add($auctionId) {

        $save = $this->owner_model->liveupcomingauciton_event_add_save($auctionId);
        //die;
        if ($save) {

            redirect('owner/');
        }
    }

    public function liveupcomingauciton_fav_add($auctionId) {

        $save = $this->owner_model->liveupcomingauciton_fav_add_save($auctionId);

        if ($save) {

            redirect('owner/');
        }
    }

    public function concludeCompletedAuctionsdatatable() {
        echo $this->owner_model->concludeCompletedAuctionsdatatable();
    }

    public function concludeCompletedAuctionsdatatable1() {
        echo $this->owner_model->concludeCompletedAuctionsdatatable1();
    }

    /*     * ********************     End Upcoming Auction     *********************** */
    /*     * ********************    Complete Auction     *********************** */

    public function completedAuction() {
        $data['heading'] = 'Completed Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $data['tabtype'] = 'MyAuction';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        if(MOBILE_VIEW)
        {
			$this->load->view('mobile/MyactivityCompletedAuction_eauc', $data);
		}
		else
		{
			$this->load->view('owner_view/MyactivityCompletedAuction_eauc', $data);
		}
        $this->website_footer();
    }

    public function completeAuctionDatatable() {

        echo $this->owner_model->completeAuctionDatatable();
    }

    public function canceleddatatable() {
        echo $this->owner_model->canceleddatatable();
    }

    /*     * ********************     End Complete Auction     *********************** */
    /*     * ********************    Cancel Auction     *********************** */

    public function cancelAuction() {

        $data['heading'] = 'Cancel Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $data['tabtype'] = 'MyAuction';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $this->load->view('owner_view/MyactivityCancelAuction', $data);
        $this->website_footer();
    }

    public function cancelAuctionDatatable() {

        echo $this->owner_model->cancelAuctionDatatable();
    }

    /*     * ********************     End Cancel Auction     *********************** */

    /*     * ********************    followBank     *********************** */

    public function followBank() {
        $user_id = $this->session->userdata('id');
        $data['heading'] = 'Follow Bank';
        $data['controller'] = 'owner';
        $data['user_id'] = $user_id;

        $data['bank_data'] = $this->owner_model->getBank();
        $data['followBank'] = $this->owner_model->getFollowBank($user_id);
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabtype'] = 'bankyoufollow';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $this->load->view('owner_view/myactivityFollowBank', $data);
        $this->website_footer();
    }

    public function followBankDatatable() {

        echo $this->owner_model->followBankDatatable();
    }

    /*     * ********************     End followBank     *********************** */
    /*     * ********************    allFavorites     *********************** */

    public function allFavorites() {

        $data['heading'] = 'All Favorites';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabtype'] = 'allFavourites';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $this->load->view('owner_view/myactivityAllFavorites', $data);
        $this->website_footer();
    }

    public function allFavoritesDatatable() {

        echo $this->owner_model->allFavoritesDatatable();
    }

    /*     * ********************     End allFavorites    *********************** */
    /*     * ********************    lastSearch     *********************** */

    public function lastSearch() {

        $data['heading'] = 'Last Search';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'ViewLastSearch';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        /* ////////////// */
        /* for new grid of last search */
        $lastSrch = $this->property_model->getLastSearchRequest();
        $_GET = unserialize($lastSrch);
        $data['menu_type'] = $_GET['propertype'];
        $user_id = $this->session->userdata('id');
        $data['userId'] = trim($user_id);
        $bankData = $this->property_model->bankList();
        $categoryList = $this->property_model->categoryList();
        $OwnerList = $this->property_model->OwnerList();
        $acttype = $_GET['act'];
        if ($acttype == 'non_auction') {
            $data['Alltotal_records'] = $this->property_model->TotalNonAuctionRecordsList();
        } else {
            $data['Alltotal_records'] = $this->property_model->TotalAuctionRecordsList();
        }
        $config = array();
        $searcharry = array();
        $searchdata = '';
        if (count($_GET) > 0) {
            $searchdata = $_GET;
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        } else {
            $searchdata = '';
            $config['suffix'] = '';
        }
        $total_records = $data['Alltotal_records'];
        $config["base_url"] = base_url() . "property/";
        $config["total_rows"] = $total_records;
        if ($_GET['limit_perpage']) {
            $config["per_page"] = $_GET['limit_perpage'];
        } else {
            $config["per_page"] = 15;
        }

        $config["uri_segment"] = 2;
        $config['use_page_numbers'] = true;
        $config['display_pages'] = true;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li ><a class="active">';
        $config['cur_tag_close'] = '</a></li>';
        //$config['num_links'] = '3';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';


        $this->pagination->initialize($config);
        $page = $page_no;
        if ($page > 0) {
            $startlimit = ($page - 1) * $config["per_page"];
        } else {
            $startlimit = $page;
        }

        if ($acttype == 'non_auction') {
            $AuctionRecordsList = $this->property_model->NonAuctionRecordsList($startlimit, $config["per_page"], $searcharry);
        } else {
            $AuctionRecordsList = $this->property_model->AuctionRecordsList($startlimit, $config["per_page"], $searcharry);
        }


        $data["pagination_links"] = $this->pagination->create_links();
        $data['AuctionRecordsList'] = $AuctionRecordsList;
        $data['bankData'] = $bankData;
        $data['categoryList'] = $categoryList;
        $data['OwnerList'] = $OwnerList;
        //$property_list_leftsidebar = $this->load->view('front_view/property_list_leftsidebar', $data, true);
        //$property_list_leftsidebar_phone = $this->load->view('front_view/property_list_leftsidebar_phone', $data, true);
        $data['property_list_leftsidebar'] = $property_list_leftsidebar;

        /* end grid code */
        $this->load->view('owner_view/myactivityLastSearch', $data);
        $this->website_footer();
    }

    public function lastSearchDatatable() {

        echo $this->owner_model->lastSearchDatatable();
    }

    /*     * ********************     End lastSearch    *********************** */

    public function eventTrack($auctionID) {
       redirect('owner/auctionParticipage/'.$auctionID);
    }

    public function auctionParticipage($auctionID) {
		
		$data['user_id'] = $this->session->userdata('id');
		/* check auction participate date and time code start */
			//$this->owner_model->checkParticipatetime($auctionID);
		/* check auction participate date and time code End */

		$cert_serial_no = GetTitleByField("tbl_auction_participate", "bidderID='".$data['user_id']."' and auctionID='".$auctionID."'", "cert_serial_no");        
		$dsc_enabled = GetTitleByField("tbl_auction", "id='".$auctionID."'", "dsc_enabled");
		if($dsc_enabled == 1)
		{
			if(!$cert_serial_no)
			{
				//redirect('/owner/dashboard');
			}
		}
		
		
        $data['heading'] = 'Owner Auction Tracker';
        $data['controller'] = 'bidder';
        $this->load->view('common/owner_header_user');
        
        $data['auction_data'] = $this->bidder_model->eventTrackData($auctionID, $data['user_id']);
        $data['uploadedDocs'] = $this->bank_model->GetUploadedDocsByAuctionId($auctionID);
        if($data['auction_data'][0]->show_home == 1 || $this->owner_model->checkOwnerLimitedUser($auctionID))
        {       
			$auction_data = $this->helpdesk_executive_model->GetAutionbyId($auctionID);
			$data['bankData'] = $this->banker_model->GetBanksData($auction_data->bank_id);
			$data['tabtype'] = 'MyAuction';
			$this->load->view('owner_view/owner_participate', $data);
			$this->website_footer();
		}
		else
		{
			redirect('owner');
			die;
		}
    }

    //Sell Section
    public function sell() {

        $data['heading'] = 'Owner Dashboard';
        $data['controller'] = 'owner';
        $data['dashboard_statics_data'] = $this->owner_model->sellDashboardData();

        $category = $this->owner_model->GetPopularPropertyType();
        $data['getpopular'] = $category;

        //echo '<PRE>',print_r($data['dashboard_statics_data']);echo '</PRE>';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $this->load->view('owner_view/sell_dashboard', $data);
        $this->load->view('common/footer');
    }

    public function sellMyActivity() {
        $this->sellBidToBeOpened();
    }

    public function sellBidToBeOpened() {
        $data['tabtype'] = 'MyAuction';
        $data['heading'] = 'My Activity';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);

        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);

        $data['tabs'] = $this->load->view('owner_view/tabs', '', true);
        $this->load->view('owner_view/sellMyactivityBidToBeOpenAuction', $data);
        $this->load->view('common/footer');
    }

    function auctionBidToBeOpenAuction() {
        echo $this->owner_model->auctionBidToBeOpenAuction();
    }

    /*     * ********************    Live Auction     *********************** */

    public function sellliveAuction() {
        $data['tabtype'] = 'MyAuction';
        $data['heading'] = 'Live Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $this->load->view('owner_view/sellMyactivityLiveAuction', $data);
        $this->website_footer();
    }

    public function sellLiveAuctionDatatable() {

        echo $this->owner_model->sellliveAuctionDatatable();
    }

    /*     * ********************     End Live Auction     *********************** */
    /*     * ********************    Upcoming Auction     *********************** */

    public function upCominAuctionDatatable() {

        echo $this->owner_model->upCominAuctionDatatable();
    }

    public function sellupcomingAuction() {
        $data['tabtype'] = 'MyAuction';
        $data['heading'] = 'Upcoming Auction';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/sellMyactivityUpcomingAuction', $data);
        $this->website_footer();
    }

    public function sellUpcomingAuctionDatatable() {

        echo $this->owner_model->sellupcomingAuctionDatatable();
    }

    /*     * ********************     End Upcoming Auction     *********************** */
    /*     * ********************    Complete Auction     *********************** */

    public function sellcompletedAuction() {
        $data['tabtype'] = 'MyAuction';
        $data['heading'] = 'Completed Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/sellMyactivityCompletedAuction_eauc', $data);
        $this->website_footer();
    }

    public function sellCompleteAuctionDatatable() {

        echo $this->owner_model->sellcompleteAuctionDatatable();
    }

    /*     * ********************     End Complete Auction     *********************** */
    /*     * ********************    Cancel Auction     *********************** */

    public function sellCancelAuction() {
        $data['tabtype'] = 'MyAuction';
        $data['heading'] = 'Cancel Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/sellMyactivityCancelAuction', $data);
        $this->website_footer();
    }

    public function sellCancelAuctionDatatable() {

        echo $this->owner_model->sellcancelAuctionDatatable();
    }

    /*public function sellerPostPropety($pid) {

        $data['tabtype'] = 'MyProperty';
        $data['heading'] = 'Seller Post Property';
        $data['controller'] = 'owner';
        $attr_records = $this->dynamic_form_model->GetAttributeValue($pid);
        $data['attr_records'] = $attr_records;
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($pid);
        $category = $this->helpdesk_executive_model->GetCategory();
        $data['category'] = $category;
        $countries = $this->bank_model->GetCountries();
        $data['countries'] = $countries;
        $states = $this->bank_model->GetState();
        $data['states'] = $states;
        $cities = $this->bank_model->GetCity();
        $data['prows'] = $prows;
        $data['cities'] = $cities;
        $data['propertyID'] = $pid;
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/owner_post_property', $data);
        $this->website_footer();
    }*/

    public function manageSellerPropety() {
        $data['tabtype'] = 'MyProperty';
        $data['heading'] = 'Manage Seller Property';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/sellMyactivityManageAuctionProperity', $data);
        $this->website_footer();
    }

    function sellerPropertyDatatable() {
        echo $this->owner_model->sellerPropertyDatatable();
    }

    public function manageSellersavedPropety() {
        $data['tabtype'] = 'MyProperty';
        $data['heading'] = 'Manage Seller saved Property';
        $data['controller'] = 'owner';
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/sellMyactivityManageSavedAuctionProperity', $data);
        $this->website_footer();
    }

    function sellersavedPropertyDatatable() {
        echo $this->owner_model->sellersavedPropertyDatatable();
    }

    public function ajaxFormData($category_id = '', $is_auction = '', $is_sell, $product_id = '') {
        $records = $this->helpdesk_executive_model->GetRecordByCategory($category_id, $is_auction, $is_bank = 'non-bank', $is_sell);
        if ($product_id) {
            $detail_records = $this->helpdesk_executive_model->GetProductDetail($product_id);
            $attr_records = $this->helpdesk_executive_model->GetAttributeValue($product_id);
        }
        $data['records'] = $records;
        $data['detail_records'] = $detail_records;
        $data['attr_records'] = $attr_records;
        $this->load->view('ajaxFormData', $data);
    }

    function sellerpostPropertydata($pid) {
        $is_auction = $this->input->post('is_auction');
        $this->load->library('form_validation');

        //die;
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'is_auction', 'trim|required|xss_clean');
        $this->form_validation->set_rules('state', 'is_auction', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'is_auction', 'trim|required|xss_clean');
        $this->form_validation->set_rules('is_auction', 'is_auction', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sele_rent', 'sele_rent', 'trim|required|xss_clean');
        $this->form_validation->set_rules('property_type', 'property_type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = "Please Enter Require fields.!";
            $this->session->set_flashdata('message', $msg);
            redirect('owner/sellerPostPropety/' . $pid);
        } else {
            $pid = $this->owner_model->savepropertyData();
            if ($is_auction == 1) {
                redirect('owner/createAuction/' . $pid);
            } else {
                $msg = "Property has been saved and sent to admin for approval.!";
                $this->session->set_flashdata('message', $msg);
                redirect('owner/sellerPostPropety/' . $pid);
            }
        }
    }

    function createAuction($pid) {
        //die;
        $data['heading'] = 'Seller Post Auction';
        $data['controller'] = 'owner';
        $biddersrow = $this->helpdesk_executive_model->getAllBiidersList();
        ;
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($pid);
        $category = $this->helpdesk_executive_model->GetCategorylist();
        $document_list = $this->helpdesk_executive_model->document_list();
        $data['auctionID'] = $prows->auctionID;
        $auctionData = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($prows->auctionID);
        $data['biddersrow'] = $biddersrow;
        $data['prows'] = $prows;
        $data['category'] = $category;
        $data['document_list'] = $document_list;
        $data['auctionData'] = $auctionData;
        $data['propertyID'] = $pid;


        $data['tabtype'] = 'MyProperty';
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/owner_post_auction', $data);
    }

    function ajaxBuyDashboardData() {

        $buyDashboardData = $this->owner_model->ajaxbuyDashboardData();
        echo json_encode($buyDashboardData);
    }

    function ajaxSellDashboardData() {

        $buyDashboardData = $this->owner_model->ajaxsellDashboardData();
        //print_r($buyDashboardData);
        echo json_encode($buyDashboardData);
    }

    function saveeventdata() {
        //echo '<pre>';print_r($_POST);die;		
        $propertyID = $this->input->post('propertyID');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('reserve_price', 'reserve_price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_title', 'event_title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category_id', 'category_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('borrower_name', 'borrower_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('press_release_date', 'press_release_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bid_opening_date', 'bid_opening_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('auction_start_date', 'auction_start_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('auction_end_date', 'auction_end_date', 'trim|required|xss_clean');
        //echo $this->form_validation->run();
        //echo '<pre>';print_r($_POST);die;

        if ($this->form_validation->run() == FALSE) {
            echo $msg = "Please Enter Require fields.!";
            $msg = "Auction has been saved successfully. Auction EventID is '" . $insetedid . "' !";
            $this->session->set_flashdata('message', $msg);
            redirect('/owner/createAuction/' . $propertyID);
        } else {
            //echo $this->form_validation->run();
            //echo '<pre>';print_r($_POST);die;
            $insetedid = $this->owner_model->saveeventdata();
            if ($insetedid) {
                //$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
                $this->session->set_flashdata('message', $msg);
                redirect('/owner/payamount/' . $propertyID);
            }
        }
    }

    function payamount($pid) {
        $data['heading'] = 'Property Payment';
        $data['controller'] = 'owner';
        $data['tabtype'] = 'MyProperty';
        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($pid);
        $user_type = $this->session->userdata('user_type');

        $property_type = $prows->sell_rent;
        $data['auctionID'] = $prows->auctionID;

        $auctionData = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($prows->auctionID);
        $bidderID = $this->session->userdata('id');
        $user_data = $this->owner_model->GetRegisterUserById($bidderID);
        //echo $user_type;
        //echo '<br/>';
        //echo $property_type;
        //echo '<br/>';
        //echo '<pre>';
        $auction_reserver_price = $auctionData->reserve_price;
        $auction_fees = $this->owner_model->GetAuctionFees($user_type, $property_type, 'auction fee', $auction_reserver_price);
        $data['user_data'] = $user_data;
        $data['prows'] = $prows;
        $data['auctionData'] = $auctionData;

        $data['propertyID'] = $pid;
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/owner_payamount', $data);
    }

    public function sellliveAuctionList($aid) {
        $data['tabtype'] = 'MyAuction';
        //print_r($this->session->userdata);
        $data['heading'] = 'Live Auction';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $auctionData = $this->owner_model->getOwnersLiveAuctionList($aid);
        //print_r($auctionData);
        $data['auctionData'] = $auctionData;
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/ownersell_myActivityListLiveAuction1', $data);
    }

    function liveBiddingAuctionsdatatable($aid) {
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'buyer';
        $auctionData = $this->owner_model->getOwnersLiveAuctionList($aid);
        $data['auctionData'] = $auctionData;
        echo $this->load->view('owner_view/live_bidding_auction_list', $data, true);
    }

    /*     * ********************     sell eventTrack     *********************** */

    public function sellEventtrack($auction_id) {
        $createdUseridsArr = $this->owner_model->getSellCreatedAuction();
        if (!in_array($auction_id, $createdUseridsArr)) {
            redirect('/owner');
        }
        $data['heading'] = 'Auction Tracker';
        $data['controller'] = 'owner';
        $data['auction_data'] = $this->owner_model->selleventTrackData($auction_id);
        //echo "<pre>";
        //print_r($data['auction_data']);
        //echo "</pre>";
        $data['tabtype'] = 'MyAuction';
        $data['user_id'] = $this->session->userdata('id');
        $this->load->view('common/owner_header_user');
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);

        $this->load->view('owner_view/owner_myActivityEventTrack', $data);
        //$this->website_footer();
    }

    function firstOpnerVerification() {
        $this->load->library('form_validation');
        $submit = $this->input->post('submit');
        $auctionID = $this->input->post('auctionID');


        if (isset($submit)) {
            $insetedid = $this->owner_model->saveFirstOpnerVerification();
            }
        redirect('owner/sellEventtrack/' . $auctionID);
    }

    function eventDetailPopup($auctionID) {
        $data['auction_detail'] = $this->banker_model->auctionDetailPopupData($auctionID);
        $this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
    }

    function emdDetailPopup($bidderID, $auctionID) {
        $data['emd'] = $this->banker_model->emdDetailPopupData($bidderID, $auctionID);
        $this->load->view('owner_view/owner_myActivityTrackEmdPopup', $data);
    }

    function bidderDetailPopup($bidderID) {
        $data['bidder_detail'] = $this->banker_model->bidderDetailPopup($bidderID);
        $this->load->view('banker_view/banker_myActivityBidderPopup', $data);
    }

    function tenderfeeDetailPopup($bidderID, $auctionID) {
        $data['tenderfee'] = $this->banker_model->tenderfeeDetailPopupData($bidderID, $auctionID);
        $this->load->view('banker_view/banker_myActivityTrackTenderfeePopup', $data);
    }

    function docDetailPopup($bidderID, $auctionID) {
        $data['doc'] = $this->banker_model->docDetailPopupData($bidderID, $auctionID);
        $this->load->view('banker_view/banker_myActivityTrackDocPopup', $data);
    }

    /*     * ********************    End  eventTrack     *********************** */

    function savefavorite() {
        $bankID = $this->input->post('bankID');
        if ($bankID) {
            $this->owner_model->savefavorite();
        }
    }

    function removefollows() {
        $bankID = $this->input->post('bankID');
        if ($bankID) {
            $this->owner_model->removefollows();
        }
    }

    function tcAccepted() {

        echo $this->owner_model->tcAccept();
    }

    function atAccepted() {

        echo $this->owner_model->atAccepted();
    }

    public function auction_participate_old($aid) { /* Create Logged Events */

        /* check auction participate date and time code start */
        $this->owner_model->checkParticipatetime($aid);
        /* check auction participate date and time code End */
        $bidderid = $this->session->userdata['id'];
        $user_type = $this->session->userdata('user_type');
        $data['heading'] = 'Participate';
        $this->load->view('common/owner_header_user');
        $emd_amt = GetTitleByField('tbl_auction_participate_emd', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $tender_amt = GetTitleByField('tbl_auction_participate_tenderfee', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $documents_amt = GetTitleByField('tbl_auction_participate_doc', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $auction_participateID = GetTitleByField('tbl_auction_participate', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $auction_participateFRQID = GetTitleByField('tbl_auction_participate_frq', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        
        $frqrow = $this->helpdesk_executive_model->GetbidderLatestFRQ($aid, $bidderid);
        $data['controller'] = 'helpdesk_executive';
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);

        $auction_data = $this->helpdesk_executive_model->GetAutionbyId($aid);
        //echo $auction_data->bank_id;
        $data['bankData'] = $this->banker_model->GetBanksData($auction_data->bank_id);
        if ($auction_data->auction_type == 1) {
            $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($auction_data->productID);
            $property_type = $prows->sell_rent;
            $participation_fee = $this->owner_model->GetAuctionFees($user_type, $property_type, 'participation fee', $auction_data->reserve_price);
            $data['participation_fee'] = $participation_fee;
        }
        //$data['executive_leftsidebar']		=	$this->load->view('bidder_view/bidder_LeftPanel','',true);
        $auction_type = $auction_data->auction_type;
        $data['auction_data'] = $auction_data;
        $data['auction_id'] = $aid;
        $data['bidderid'] = $bidderid;
        $data['emd_paid'] = $emd_amt;
        $data['tender_paid'] = $tender_amt;
        $data['documents_paid'] = $documents_amt;
        $data['latest_frq'] = $frqrow->frq;
        $data['auction_participateID'] = $auction_participateID;
        $data['auction_participateFRQID'] = $auction_participateFRQID;

        $data['tabtype'] = 'MyAuction';
        //$data['leftsidebar']=$this->load->view('owner_view/buyer_leftsidebar',$data,true);
        if ($auction_type == 1) {
            /*             * *************************Pay Auction Participate fees ************************** */
            include('Crypto.php');
            $workingKey = '6F149C1359A0FBC749A602E500C63A80';  //Working Key should be provided here.
            $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server
            $rcvdString = decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
            $order_status = "";
            $decryptValues = explode('&', $rcvdString);

            //echo "<pre>";
            //print_r($decryptValues);
            //echo "</pre>";

            $dataSize = sizeof($decryptValues);
            //echo "<center>";

            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                if ($i == 0)
                    $order_id = $information[1];
                if ($i == 1)
                    $tracking_id = $information[1];
                if ($i == 2)
                    $bank_ref_no = $information[1];
                if ($i == 5)
                    $payment_mode = $information[1];
                if ($i == 6)
                    $card_name = $information[1];
                if ($i == 3)
                    $order_status = $information[1];
                if ($i == 35)
                    $mer_amount = $information[1];
            }

            if ($order_status === "Success") {
                //echo "orderid-->".$order_id;
                $dataarr = array('status' => '1',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);

                $emddataarr = array(
                    'bidderID' => $bidderid,
                    'auctionID' => $aid,
                    'bank_name' => $card_name,
                    'amount' => $mer_amount,
                    'indate' => date("Y-m-d H:i:s"),
                    'added_type' => 'CCvenue',
                    'addby' => $bidderid
                );



                $this->owner_model->UpdateTransaction($order_id, $dataarr);
                $this->owner_model->addAuctionEmdAmout($emddataarr);


                //$title="Success";
                $msg = "<br>Thank you for Auction Payment with us. Your credit card has been charged and your transaction is successful. Your Property has been submitted Please wait for Approval.";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            } else if ($order_status === "Aborted") {
                $dataarr = array('status' => '0',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);
                $this->owner_model->UpdateTransaction($order_id, $dataarr);

                $msg = "<br> Thank you for shopping with us.Your transaction is aborted";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            } else if ($order_status === "Failure") {
                $dataarr = array('status' => '0',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);

                $this->owner_model->UpdateTransaction($order_id, $dataarr);
                $msg = "<br>Thank you for shopping with us.However,the transaction has been declined.";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            }


            //echo "fasfsadfdsa".$msg;
            /*             * ********************************************************************* */
            $data['msg'] = $msg;

            $this->load->view('/owner_view/owner_nonbank_auction_participate', $data);
        } else {
            $this->load->view('/owner_view/owner_auction_participate', $data);
        }
        $this->website_footer();
    }

    public function auction_participate($aid) { /* Create Logged Events */
			

        /* check auction participate date and time code start */
        $this->owner_model->checkParticipatetime($aid);
        /* check auction participate date and time code End */
        $bidderid = $this->session->userdata['id'];
        $user_type = $this->session->userdata('user_type');
        
        $cert_serial_no = GetTitleByField("tbl_auction_participate", "bidderID='".$bidderid."' and auctionID='".$aid."'", "cert_serial_no");        
        $dsc_enabled = GetTitleByField("tbl_auction", "id='".$aid."'", "dsc_enabled");
		
		if($dsc_enabled == 1)
		{
			if(!$cert_serial_no)
			{
				redirect('/owner/dashboard');
			}
		}
        
        $data['heading'] = 'Participate';
        $this->load->view('common/owner_header_user');
        
        $auction_data = $this->helpdesk_executive_model->GetAutionbyId($aid);
        $data['bankData'] = $this->banker_model->GetBanksData($auction_data->bank_id);
        
        $emd_amt = GetTitleByField('tbl_auction_bidder_utr_no', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'AND utr_type='2'", 'utr_id');
        $administrative_amt = GetTitleByField('tbl_auction_bidder_utr_no', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'AND utr_type='1'", 'utr_id');
        $tender_amt = GetTitleByField('tbl_auction_participate_tenderfee', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'payment_status');
        $documents_amt = GetTitleByField('tbl_auction_participate_doc', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $emd_doc = GetTitleByField('tbl_auction_emd_doc', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'emd_doc_id');
        $auction_participateID = GetTitleByField('tbl_auction_participate', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $auction_participateFRQID = GetTitleByField('tbl_auction_participate_frq', "auctionID='" . $aid . "' AND bidderID='" . $bidderid . "'", 'id');
        $frqrow = $this->helpdesk_executive_model->GetbidderLatestFRQ($aid, $bidderid);
        
        
        $data['doc_to_be_submitted'] = GetTitleByField('tbl_auction', "id=$aid", 'doc_to_be_submitted'); // Added by Azizur
        
        $data['controller'] = 'helpdesk_executive';
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);

        $auction_data = $this->helpdesk_executive_model->GetAutionbyId($aid);
        if ($auction_data->auction_type == 1) {
            $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($auction_data->productID);
            $property_type = $prows->sell_rent;
            $participation_fee = $this->owner_model->GetAuctionFees($user_type, $property_type, 'participation fee', $auction_data->reserve_price);
            $data['participation_fee'] = $participation_fee;
        }
        //$data['executive_leftsidebar']		=	$this->load->view('bidder_view/bidder_LeftPanel','',true);
        $auction_type = $auction_data->auction_type;
        $data['auction_data'] = $auction_data;
        $data['auction_id'] = $aid;
        $data['bidderid'] = $bidderid;
        $data['emd_utr_paid'] = $emd_amt;
        $data['administrative_utr_paid'] = $administrative_amt;
        $data['tender_paid'] = $tender_amt;
        $data['documents_paid'] = $documents_amt;
        $data['emd_doc_paid'] = $emd_doc;
        $data['latest_frq'] = $frqrow->frq;
        $data['auction_participateID'] = $auction_participateID;
        $data['auction_participateFRQID'] = $auction_participateFRQID;
		$data['uploadedDocs'] = $this->bank_model->GetUploadedDocsByAuctionId($aid);
		$data['jdaPayLog'] = $this->owner_model->jdaPaymentLogPopupData($bidderid, $aid);
        $data['tabtype'] = 'MyAuction';
        //$data['leftsidebar']=$this->load->view('owner_view/buyer_leftsidebar',$data,true);
        if ($auction_type == 1) {
            /*             * *************************Pay Auction Participate fees ************************** */
            include('Crypto.php');
            $workingKey = '6F149C1359A0FBC749A602E500C63A80';  //Working Key should be provided here.
            $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server
            $rcvdString = decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
            $order_status = "";
            $decryptValues = explode('&', $rcvdString);
            
            $dataSize = sizeof($decryptValues);
            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                if ($i == 0)
                    $order_id = $information[1];
                if ($i == 1)
                    $tracking_id = $information[1];
                if ($i == 2)
                    $bank_ref_no = $information[1];
                if ($i == 5)
                    $payment_mode = $information[1];
                if ($i == 6)
                    $card_name = $information[1];
                if ($i == 3)
                    $order_status = $information[1];
                if ($i == 35)
                    $mer_amount = $information[1];
            }

            if ($order_status === "Success") {
                $dataarr = array('status' => '1',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);

                $emddataarr = array(
                    'bidderID' => $bidderid,
                    'auctionID' => $aid,
                    'bank_name' => $card_name,
                    'amount' => $mer_amount,
                    'indate' => date("Y-m-d H:i:s"),
                    'added_type' => 'CCvenue',
                    'addby' => $bidderid
                );
                $this->owner_model->UpdateTransaction($order_id, $dataarr);
                $this->owner_model->addAuctionEmdAmout($emddataarr);

                //$title="Success";
                $msg = "<br>Thank you for Auction Payment with us. Your credit card has been charged and your transaction is successful. Your Property has been submitted Please wait for Approval.";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            } else if ($order_status === "Aborted") {
                $dataarr = array('status' => '0',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);
                $this->owner_model->UpdateTransaction($order_id, $dataarr);

                $msg = "<br> Thank you for shopping with us.Your transaction is aborted";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            } else if ($order_status === "Failure") {
                $dataarr = array('status' => '0',
                    'tracking_id' => $tracking_id,
                    'bank_ref_no' => $bank_ref_no,
                    'order_status' => $order_status,
                    'payment_mode' => $payment_mode,
                    'card_name' => $card_name);

                $this->owner_model->UpdateTransaction($order_id, $dataarr);
                $msg = "<br>Thank you for shopping with us.However,the transaction has been declined.";
                $this->session->set_flashdata('msg', $msg);
                redirect('owner/auction_participate/' . $aid);
            }

            //echo "fasfsadfdsa".$msg;
            /*             * ********************************************************************* */
            $data['msg'] = $msg;


            $this->load->view('/owner_view/owner_nonbank_auction_participate', $data);
        } else {

			if($this->isNewDscPlugin === true)
			{
				if(MOBILE_VIEW)
				{					
					$this->load->view('mobile/owner_auction_participitate1', $data);
				}
				else
				{
					$this->load->view('owner_view/owner_auction_participitate1', $data);
				}
			}
			else
			{
				$this->load->view('/owner_view/owner_auction_participitate1_oldDSC', $data);
			}
        }
        $this->website_footer();
    }

    public function checkdsclogin_helpdesk() {
        echo $this->owner_model->checkdsclogin_helpdesk();
    }

    public function checkdsclogin() {
        echo $this->owner_model->checkdsclogin();
    }

    public function checkvaliddsc() {
        echo $this->owner_model->checkdscloginvalid();
    }

    function checkbidderlogindSC() {
        $id = $this->session->userdata('id');
        if ($id) {
            echo 1;
        } else {
            echo 2;
        }
    }

    function auctionparticipatefees($aid) {

        $data['heading'] = 'Participate Fees';
        $this->load->view('common/owner_header_user');
        $auctionData = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($aid);
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($auctionData->productID);
        $user_type = $this->session->userdata('user_type');
        $property_type = $prows->sell_rent;
        $data['auctionID'] = $aid;
        $bidderID = $this->session->userdata('id');
        $user_data = $this->owner_model->GetRegisterUserById($bidderID);
        $participation_fee = $this->owner_model->GetAuctionFees($user_type, $property_type, 'participation fee', $auctionData->reserve_price);
        $data['participation_fee'] = $participation_fee;
        $data['user_data'] = $user_data;
        $data['prows'] = $prows;
        $data['auction_data'] = $auctionData;
        $data['propertyID'] = $auctionData->productID;
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['tabtype'] = 'MyAuction';
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
        $this->load->view('/owner_view/pay_participatefees', $data);
    }

    function saveFrqParticipate() {
        $auction_id = $this->input->post('auction_id');
        /* check auction participate date and time code start */
        $this->owner_model->checkParticipatetime($auction_id);
        /* check auction participate date and time code End */
        $bidderid = $this->session->userdata['id'];
       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('quote_price', 'quote_price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('documents_paid', 'documents_paid', 'trim|required|xss_clean');
        $this->form_validation->set_rules('emd_paid', 'emd_paid', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('tender_paid', 'tender_paid', 'trim|required|xss_clean');
        $jda_payment_status = GetTitleByField('tbl_jda_payment_log', "auction_id='" . $auction_id . "' AND bidder_id='" . $bidderid . "' order by payment_log_id DESC", 'payment_status');
        if ($this->form_validation->run() == FALSE || $jda_payment_status == 'failure') {
            $msg = "Please make payment!";
        } else {
            $quote_price = $this->input->post('quote_price');
            $reserve_price = $this->input->post('reserve_price');
            $finalsave = $this->input->post('fSave');
            $finalsave1 = $this->input->post('Save');
            if ($quote_price < $reserve_price) {
                $msg = 'Quote Price should not less than Reserve Price!';
            } else {
                $returnval = $this->owner_model->saveFrqParticipate();
                if (isset($finalsave) && $finalsave == 'Final Submit') {
                    $msg = 'Final Submit Done Successfully';
                    
                } else {
                    $msg = 'FRQ Saved Successfully';
                }
            }

            if ($returnval > 0) {
                $this->db->select('eventID,bank_id');
                $this->db->from('tbl_auction');
                $this->db->where('id', $auction_id);
                $query1 = $this->db->get();
                $row1 = $query1->result();
                $message = 'Bidder Successfully Submitted Quote Price(FRQ)';
                $data1 = array(
                    'event_id' => $row1[0]->eventID,
                    'auction_id' => $auction_id,
                    'action_type' => 'Quote_price',
                    'bank_id' => $row1[0]->bank_id,
                    'bidder_id' => $bidderid,
                    'indate' => date('Y-m-d H:i:s'),
                    'status' => '1',
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    //'message' => $message
                );
                
                //$msg='FRQ has been saved successfully.';
                //$msg='FRQ Saved Successfully';
                if (isset($finalsave) && $finalsave == 'Final Submit') 
                {
                    $msg = 'Final Submit Done Successfully';
                    $message = 'Bidder Successfully (Submitted) Quote Price(FRQ)';
                    $data1['message'] = $message;
                    #Start: Send mail to bidder and approvers after final submit by bidder 
                    $this->load->library('Email_new', 'email');
                    $email = new email_new();
                    
                    //for bidders
                    $mail = $email->sendMailToBidderAfterFinalSubmission($auction_id, $bidderid);
                    
                    //for approvers
                    $mail1 = $email->SendMailToApproverAfterFinalSubmission($auction_id);
                    
                    #End: Send mail to bidder and approvers after final submit by bidder 
                }
                else 
                {
                    $msg = 'FRQ Saved Successfully';
                    $message = 'Bidder Successfully (Saved) Quote Price(FRQ)';
                    $data1['message'] = $message;
                }
                $this->db->insert('tbl_log_bidsubmission_track', $data1);
            } else {
                $msg = 'There are some problem in form.';
            }
        }
        $this->session->set_flashdata('message', $msg);
        redirect('owner/auction_participate/' . $auction_id);
    }

    public function payEmd($bidderid, $aid, $msg = NULL) {

        /* check auction participate date and time code start */
        $this->owner_model->checkParticipatetime($aid);
        /* check auction participate date and time code End */

        $data['heading'] = 'Participate';
        $data['controller'] = 'helpdesk_executive';
        $data['bidderid'] = $bidderid;
        $data['auction_id'] = $aid;
        $data['msg'] = $msg;
        $emdrow = $this->helpdesk_executive_model->GetAutionEmgRecords($aid, $bidderid);
        $data['emdrow'] = $emdrow;
        $this->load->view('owner_view/owner_payemd', $data);
    }

    public function paytenderfee($bidderid, $aid, $msg = NULL) {
        /* check auction participate date and time code start */
        $this->owner_model->checkParticipatetime($aid);
        /* check auction participate date and time code End */
        $data['heading'] = 'Participate';
        $data['controller'] = 'helpdesk_executive';
        $data['bidderid'] = $bidderid;
        ;
        $data['auction_id'] = $aid;
        $data['msg'] = $msg;
        $tenderrow = $this->helpdesk_executive_model->GetAutionTenderRecords($aid, $bidderid);
        $data['tenderrow'] = $tenderrow;
        $this->load->view('owner_view/owner_tenderfee', $data);
    }

    public function submitDocument($bidderid, $aid, $msg = null) {
		if($bidderid == $this->session->userdata('id'))
		{
			/* check auction participate date and time code start */
			$this->owner_model->checkParticipatetime($aid);
			/* check auction participate date and time code End */
			$data['heading'] = 'Participate';
			$data['controller'] = 'helpdesk_executive';
			$doc_to_be_submitted = GetTitleByField('tbl_auction', "id=$aid", 'doc_to_be_submitted');
			//echo $aid.$this->db->last_query();

			$docArr = explode(",", $doc_to_be_submitted);
			if (count($docArr)) {
				$docnameArr = array();
				foreach ($docArr as $docID) {
					$docnameArr[$docID] = GetTitleById('tbl_doc_master', $docID);
				}
			}
			$data['auction_id'] = $aid;
			$data['bidderid'] = $bidderid;
			$data['document'] = $docnameArr;
			$data['doc_to_be_submitted'] = $doc_to_be_submitted;
			$data['msg'] = $msg;
			if(MOBILE_VIEW)
			{
				$this->load->view('mobile/owner_submit_document', $data);
			}
			else
			{
				$this->load->view('owner_view/owner_submit_document', $data);
			}
			
		}
		else
		{
			redirect('owner/');
			exit;
		}
    }


	 public function owner_submit_emd_fee($bidderid, $aid, $msg = null) {
		if($bidderid == $this->session->userdata('id'))
		{
			/* check auction participate date and time code start */
			$this->owner_model->checkParticipatetime($aid);
			/* check auction participate date and time code End */
			$data['heading'] = 'Participate';			
			$data['auction_id'] = $aid;
			$data['bidderid'] = $bidderid;
			$data['msg'] = $msg;
			
			$data['utrDetails'] = $this->owner_model->getUtrById($bidderid,$aid,2); //2-EMD Type
			if(MOBILE_VIEW)
			{
				$this->load->view('owner_view/owner_submit_emd_fee', $data);
			}
			else
			{
				$this->load->view('owner_view/owner_submit_emd_fee', $data);
			}
			
		}
		else
		{
			redirect('owner/');
			exit;
		}
    }
    
     public function owner_submit_administrative_fee($bidderid, $aid, $msg = null) {
		if($bidderid == $this->session->userdata('id'))
		{
			/* check auction participate date and time code start */
			$this->owner_model->checkParticipatetime($aid);
			/* check auction participate date and time code End */
			$data['heading'] = 'Participate';			
			$data['auction_id'] = $aid;
			$data['bidderid'] = $bidderid;
			$data['msg'] = $msg;
			
			$data['utrDetails'] = $this->owner_model->getUtrById($bidderid,$aid,1); //2-Administrative Fee Type
			if(MOBILE_VIEW)
			{
				$this->load->view('owner_view/owner_submit_administrative_fee', $data);
			}
			else
			{
				$this->load->view('owner_view/owner_submit_administrative_fee', $data);
			}
			
		}
		else
		{
			redirect('owner/');
			exit;
		}
    }
    
    public function submitEmdDocument($bidderid, $aid, $msg = null,$utrType) {
		if($bidderid == $this->session->userdata('id'))
		{
			/* check auction participate date and time code start */
			$this->owner_model->checkParticipatetime($aid);
			/* check auction participate date and time code End */
			$data['heading'] = 'Participate';			
			$data['auction_id'] = $aid;
			$data['bidderid'] = $bidderid;
			$data['msg'] = $msg;
			
			$data['utrDetails'] = $this->owner_model->getUtrById($bidderid,$aid,$utrType);
			
			if($utrType==2)
			{
				$this->load->view('owner_view/owner_submit_emd_fee', $data);
			}
			else if($utrType==1)
			{
				$this->load->view('owner_view/owner_submit_administrative_fee', $data);
			}
			
			
		}
		else
		{
			redirect('owner/');
			exit;
		}
    }
    
    

    function uploadAuctionDocument() {
        $auction_id = $this->input->post('auction_id');
        $bidderid = $this->input->post('bidderid');
        $returnval = $this->helpdesk_executive_model->UploadAuctionDocument();

        if ($returnval > 0) {
            $this->db->select('eventID,bank_id');
            $this->db->from('tbl_auction');
            $this->db->where('id', $auction_id);
            $query1 = $this->db->get();
            $row1 = $query1->result();
            $message = 'Bidder Successfully Submitted Event Fees';
            $data1 = array(
                'event_id' => $row1[0]->eventID,
                'auction_id' => $auction_id,
                'action_type' => 'EMD_Doc_upload',
                'bank_id' => $row1[0]->bank_id,
                'bidder_id' => $bidderid,
                'indate' => date('Y-m-d H:i:s'),
                'status' => '1',
                'ip' => $_SERVER['REMOTE_ADDR'],
                'message' => $message
            );
            $this->db->insert('tbl_log_bidsubmission_track', $data1);
            $msg = 'Record has been saved successfully.';
        } else {
            $msg = 'There are some problem in form.';
        }

        $this->submitDocument($bidderid, $auction_id, $msg);
    }


	function uploadAuctionEmdDocument() {
		$utr_type = $this->input->post('utr_type');
        $auction_id = $this->input->post('auction_id');
        $bidderid = $this->input->post('bidderid');
        $action_type = ($utr_type==2)? 'EMD_utr_saved':'administrative_utr_saved';
        $returnval = $this->helpdesk_executive_model->UploadAuctionEmdDocument();		
        if ($returnval > 0) {
            $this->db->select('eventID,bank_id');
            $this->db->from('tbl_auction');
            $this->db->where('id', $auction_id);
            $query1 = $this->db->get();
            $row1 = $query1->result();
            $message = 'Bidder Successfully Submitted UTR Details';
            $data1 = array(
                'event_id' => $row1[0]->eventID,
                'auction_id' => $auction_id,
                'action_type' => $action_type,
                'bank_id' => $row1[0]->bank_id,
                'bidder_id' => $bidderid,
                'indate' => date('Y-m-d H:i:s'),
                'status' => '1',
                'ip' => $_SERVER['REMOTE_ADDR'],
                'message' => $message
            );
            $this->db->insert('tbl_log_bidsubmission_track', $data1);
            $msg = 'Record has been saved successfully.';
        } else {
            $msg = 'There are some problem in form.';
        }

        $this->submitEmdDocument($bidderid, $auction_id, $msg,$utr_type);
    }
    
    
    function SaveAuctionEmd() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bank_name', 'bank_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instrument_no', 'instrument_no', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instrument_date', 'instrument_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('beneficiary', 'beneficiary', 'trim|required|xss_clean');
        $this->form_validation->set_rules('refund_bank_name', 'refund_bank_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('branch_add', 'branch_add', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'city', 'trim|required|xss_clean');
        $this->form_validation->set_rules('account_no', 'account_no', 'trim|required|xss_clean');
        $this->form_validation->set_rules('branch_ifsc_code', 'branch_ifsc_code', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = "Please Enter Require fields.!";
        } else {
            $auction_id = $this->input->post('auction_id');
            $bidderid = $this->input->post('bidderid');
            
            
            if($this->input->post('bank_name') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('bank_name'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('instrument_no') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_no'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            if($this->input->post('instrument_date') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_date'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            if($this->input->post('instrument_expiry_date') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_expiry_date'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            if($this->input->post('beneficiary') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('beneficiary'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            if($this->input->post('refund_bank_name') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('refund_bank_name'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            if($this->input->post('branch_add') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('branch_add'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('account_no') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('account_no'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('branch_ifsc_code') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('branch_ifsc_code'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->payEmd($bidderid, $auction_id, $msg);
						return false;
				  }
			}
            
            
            
            if($_FILES['supporting_doc_path']['name']!= "")
				{
					$checkMultipleExtension=$this->owner_model->checkMultipleExtension($_FILES['supporting_doc_path']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$msg = "Invalid or multiple File Extension Used while uploading a single file!";
							$this->payEmd($bidderid, $auction_id, $msg);
							return false;			
					  }		
				}
				
				
            
            $returnval = $this->helpdesk_executive_model->saveAuctionEmd();
            if ($returnval > 0) {
                $this->db->select('eventID,bank_id');
                $this->db->from('tbl_auction');
                $this->db->where('id', $auction_id);
                $query1 = $this->db->get();
                $row1 = $query1->result();
                $message = 'Bidder Successfully Submitted Event Fees';
                $data1 = array(
                    'event_id' => $row1[0]->eventID,
                    'auction_id' => $auction_id,
                    'action_type' => 'EMD_submission',
                    'bank_id' => $row1[0]->bank_id,
                    'bidder_id' => $bidderid,
                    'indate' => date('Y-m-d H:i:s'),
                    'status' => '1',
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'message' => $message
                );
                $this->db->insert('tbl_log_bidsubmission_track', $data1);
                $msg = 'Record has been saved successfully.';
            } else {
                $msg = 'There are some problem in form.';
            }
        }
        $this->payEmd($bidderid, $auction_id, $msg);
    }

    function SaveAuctionTender() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bank_name', 'bank_name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instrument_no', 'instrument_no', 'trim|required|xss_clean');
        $this->form_validation->set_rules('instrument_date', 'instrument_date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $msg = "Please Enter Require fields.!";
        } 
        else 
        {
            $auction_id = $this->input->post('auction_id');
            $bidderid = $this->input->post('bidderid');
            
            
            if($this->input->post('bank_name') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('bank_name'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->paytenderfee($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('instrument_no') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_no'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->paytenderfee($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('instrument_date') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_date'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->paytenderfee($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			if($this->input->post('instrument_expiry_date') != ''){
				$checkHTMLTags=$this->owner_model->checkHTMLTags($this->input->post('instrument_expiry_date'));
				if($checkHTMLTags == "1"){
						$msg = "Invalid HTML OR TAGS(<) CONTENT FOUND!";
						$this->paytenderfee($bidderid, $auction_id, $msg);
						return false;
				  }
			}
			
			
            if($_FILES['supporting_doc_path']['name']!= "")
				{
					$checkMultipleExtension=$this->owner_model->checkMultipleExtension($_FILES['supporting_doc_path']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$msg = "Invalid or multiple File Extension Used while uploading a single file!";
							$this->paytenderfee($bidderid, $auction_id, $msg);
							return false;			
					  }		
				}
				
            $returnval = $this->helpdesk_executive_model->saveAuctionTender();
            if ($returnval > 0) 
            {
                $msg = 'Record has been saved successfully.';
                $this->db->select('eventID,bank_id');
                $this->db->from('tbl_auction');
                $this->db->where('id', $auction_id);
                $query1 = $this->db->get();
                $row1 = $query1->result();
                $message = 'Bidder Successfully Submitted Event Fees';
                $data1 = array(
                    'event_id' => $row1[0]->eventID,
                    'auction_id' => $auction_id,
                    'action_type' => 'Event_fee_Submission',
                    'bank_id' => $row1[0]->bank_id,
                    'bidder_id' => $bidderid,
                    'indate' => date('Y-m-d H:i:s'),
                    'status' => '1',
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'message' => $message
                );
                $this->db->insert('tbl_log_bidsubmission_track', $data1);
            } else {
                $msg = 'There are some problem in form.';
            }
        }
        $this->paytenderfee($bidderid, $auction_id, $msg);
    }

    public function buylistLiveAuctions_old($getauctionID) {

        //echo 'ghfghfghfg'; die();

        $auctionData = $this->owner_model->getBiddersLiveAuctionList($getauctionID);

        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['auctionData'] = $auctionData;
        $data['getauctionID'] = $getauctionID;
        $this->load->view('owner_view/owner_myActivityListLiveAuction_auc1', $data);

        $this->website_footer();
    }

    function buyliveBiddingAuctionsdatatable($getauctionID) {
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'owner';
        $auctionData = $this->owner_model->getBiddersLiveAuctionList($getauctionID);
        //$data['auctionData']=$auctionData;
        $data['getauctionID'] = $getauctionID;
        $this->load->view('owner_view/buylive_bidding_auction_list_eauc', $data);
    }

    public function buylistLiveAuctions($getauctionID) {             ///DSC has been included
        //$auctionData = $this->owner_model->getBiddersLiveAuctionList($getauctionID);
        $auctionData = $this->owner_model->getAuctionWith10Seconds($getauctionID);
        //echo "<pre>"; print_r($auctionData); echo "</pre>";
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['auctionData'] = $auctionData;
        $data['getauctionID'] = $getauctionID;        
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
		if($this->isNewDscPlugin === true)
		{
			if(MOBILE_VIEW)
			{
				$data['buylive_bidding_auction_list_eauc_DSC'] = $this->load->view('mobile/buylive_bidding_auction_list_eauc_DSC', $data, true);
				$this->load->view('mobile/owner_myActivityListLiveAuction_auc1_DSC', $data);
				
			}
			else{
				$data['buylive_bidding_auction_list_eauc_DSC'] = $this->load->view('owner_view/buylive_bidding_auction_list_eauc_DSC', $data, true);
				$this->load->view('owner_view/owner_myActivityListLiveAuction_auc1_DSC', $data);
			}
		}
		else
		{
			$this->load->view('owner_view/owner_myActivityListLiveAuction_auc1_DSC_oldDSC', $data);
		}
        $this->website_footer();
    }
    
    
    public function buylistLiveAuctionsAutoBid($getauctionID) {             
		$auctionData = $this->owner_model->getAuctionWith10Seconds($getauctionID);
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['auctionData'] = $auctionData;
        $data['getauctionID'] = $getauctionID;        
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftsidebar'] = $this->load->view('owner_view/buyer_leftsidebar', $data, true);
		if($this->isNewDscPlugin === true)
		{
			
			if(MOBILE_VIEW)
			{
				$data['buylive_bidding_auction_list_eauc_auto_bid_DSC'] = $this->load->view('mobile/buylive_bidding_auction_list_eauc_auto_bid_DSC', $data, true);
				$this->load->view('mobile/owner_myActivityListLiveAuction_auc1_auto_bid_DSC', $data);
				
			}
			else{
				$data['buylive_bidding_auction_list_eauc_auto_bid_DSC'] = $this->load->view('owner_view/buylive_bidding_auction_list_eauc_auto_bid_DSC', $data, true);
				$this->load->view('owner_view/owner_myActivityListLiveAuction_auc1_auto_bid_DSC', $data);
			}
		}
		else
		{
			$this->load->view('owner_view/owner_myActivityListLiveAuction_auc1_DSC_oldDSC', $data);
		}
        $this->website_footer();
    }

    function buyliveBiddingAuctionsdatatableDSC($getauctionID) {
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'owner';
        //$auctionData = $this->owner_model->getBiddersLiveAuctionList($getauctionID);
        $auctionData = $this->owner_model->getAuctionWith10Seconds($getauctionID);
        $data['auctionData'] = $auctionData;
        $data['getauctionID'] = $getauctionID;

		if($this->isNewDscPlugin === true)
		{
			if(MOBILE_VIEW)
			{
				echo $this->load->view('mobile/buylive_bidding_auction_list_eauc_DSC', $data, true);
			}
			else
			{
				echo $this->load->view('owner_view/buylive_bidding_auction_list_eauc_DSC', $data, true);
			}
		}
		else
		{
	        echo $this->load->view('owner_view/buylive_bidding_auction_list_eauc_DSC_oldDSC', $data, true);
		}
    }

    public function getStateDropDown($country_id, $state_id) {
        $states = $this->bank_model->GetState($country_id);
        $str = '<option value="">Select State</option>';
        foreach ($states as $state_record) {
            $str.="<option value='$state_record->id'";
            if ($state_record->id == $state_id)
                $str.='selected';$str.=" >$state_record->state_name</option>";
        }
        echo $str;
    }

    public function getCityDropDown($state_id, $city_id) {
        $cities = $this->bank_model->GetCity($state_id);
        $str = '<option value="">Select City</option>';
        foreach ($cities as $city_record) {
            $str.="<option value='$city_record->id'";
            if ($city_record->id == $city_id)
                $str.='selected';$str.=" >$city_record->city_name</option>";
        }
        echo $str;
    }

    public function page_popup($product_id) {
        $this->load->view('admin/header-popup', $data);
        $data['heading'] = 'Product Images';
        $array_records = $this->product_image_model->GetRecordByArticleId($product_id);
        $data['product_id'] = $product_id;
        $data['records'] = $array_records;
        $this->load->view('product-image', $data);
    }

    public function getsubcategory($category) {
        $subCategory = $this->helpdesk_executive_model->GetSubCategory($category);
        $str = '<option value="">Select Subcategory</option>';
        foreach ($subCategory as $subCategory_record) {
            $str.="<option value='$subCategory_record->id'>" . $subCategory_record->name . "</option>";
        }
        echo $str;
    }

    public function invoice_mail_to_user($invoice_mail_to, $bankID) {
        $banksUsersList = $this->helpdesk_executive_model->eventBankUserList('branch', '', $bankID);
        foreach ($banksUsersList as $urow) {
            if ($urow->id == $invoice_mail_to) {
                $strc = 'disabled="disabled"';
            } else {
                $strc = '';
            }
            $str.="<option " . $strc . " value='$urow->id'>" . $urow->email_id . ",  " . $urow->user_id . ", " . ucfirst($urow->first_name) . "  " . $urow->last_name . "</option>";
        }
        echo $str;
    }

    protected function getchecksumCC($MerchantId, $Amount, $OrderId, $URL, $WorkingKey) {
        $str = "$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
        $adler = 1;
        $adler = $this->adler32($adler, $str);
        return $adler;
    }

    protected function verifychecksumCC($MerchantId, $OrderId, $Amount, $AuthDesc, $CheckSum, $WorkingKey) {
        $str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
        $adler = 1;
        $adler = $this->adler32($adler, $str);

        if ($adler == $CheckSum)
            return "true";
        else
            return "false";
    }

    private function adler32($adler, $str) {
        $BASE = 65521;

        $s1 = $adler & 0xffff;
        $s2 = ($adler >> 16) & 0xffff;
        for ($i = 0; $i < strlen($str); $i++) {
            $s1 = ($s1 + Ord($str[$i])) % $BASE;
            $s2 = ($s2 + $s1) % $BASE;
            //echo "s1 : $s1 <BR> s2 : $s2 <BR>";
        }
        return $this->leftshift($s2, 16) + $s1;
    }

    private function leftshift($str, $num) {

        $str = DecBin($str);

        for ($i = 0; $i < (64 - strlen($str)); $i++)
            $str = "0" . $str;

        for ($i = 0; $i < $num; $i++) {
            $str = $str . "0";
            $str = substr($str, 1);
            //echo "str : $str <BR>";
        }
        return $this->cdec($str);
    }

    private function cdec($num) {
        $dec = 0;
        for ($n = 0; $n < strlen($num); $n++) {
            $temp = $num[$n];
            $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
        }

        return $dec;
    }

    public function success() {
        $Merchant_Id = $_REQUEST['Merchant_Id'];
        $Order_Id = $_REQUEST['Order_Id'];
        $Amount = $_REQUEST['Amount'];
        $AuthDesc = $_REQUEST['AuthDesc'];
        $Checksum = $_REQUEST['Checksum'];
        $WorkingKey = $this->config->get('cc_Wkey');
        $arr = explode('_', $Order_Id);
        $order_id = $arr[2];
        $Checksum = $this->verifychecksumCC($Merchant_Id, $Order_Id, $Amount, $AuthDesc, $Checksum, $WorkingKey);
        $mymsg = "";
        if ($Checksum == "true" && $AuthDesc == "Y") {
            //received
            $payment_status = 'received';
            //$this->order_model->UpdateOrderPaymentStatus($order_id, $payment_status);
        } else if ($Checksum == "true" && $AuthDesc == "B") {
            //pending
            $payment_status = 'pending';
            //$this->order_model->UpdateOrderPaymentStatus($order_id, $payment_status);
        } else {
            //error
            $payment_status = 'error';
            //$this->order_model->UpdateOrderPaymentStatus($order_id, $payment_status);
        }
        $data['payment_status'] = $payment_status;
        //$this->load->view('payment-success',$data);
    }

    public function payment() {
        $str = $this->owner_model->payment();
        echo $str;
    }

    public function savePropertyAuction() {
        $str = $this->owner_model->savePropertyAuction();
        echo $str;
    }

    function paymentsuccess($pid) {
        $data['heading'] = 'Seller Post Auction';
        $data['controller'] = 'owner';
        $data['tabtype'] = 'MyProperty';
        $biddersrow = $this->helpdesk_executive_model->getAllBiidersList();
        ;
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($pid);
        $category = $this->helpdesk_executive_model->GetCategorylist();
        $document_list = $this->helpdesk_executive_model->document_list();
        $data['auctionID'] = $prows->auctionID;
        $auctionData = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($prows->auctionID);
        $data['biddersrow'] = $biddersrow;
        $data['prows'] = $prows;
        $data['category'] = $category;
        $data['document_list'] = $document_list;
        $data['auctionData'] = $auctionData;
        $data['propertyID'] = $pid;
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $this->load->view('common/owner_header_user');
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/owner_paymentsuccess', $data);
    }

    public function setopeningprice() {
        $str = $this->banker_model->setowneropeningprice();
        echo $str;
    }

    public function open_price_bid1() {
        $str = $this->banker_model->open_price_bid1();
        echo $str;
    }

    function concludeEvent($auctionID) {
        echo $this->banker_model->concludeEvent($auctionID);
    }

    function view_uploadedfile($auctionID) {
        $auctionData = $this->banker_model->GetRecordByAuctionId($auctionID);
        $data['auctionData'] = $auctionData;
        $data['bankData'] = $this->banker_model->GetBanksData($auctionData->bank_id);
		$data['uploadedDocs'] = $this->bank_model->GetUploadedDocsByAuctionId($auctionID);
        $this->load->view('banker_view/banker_uploaded_file', $data);
    }

    function eventDetailbidderHole($auctionID) {
        $auctionData = $this->banker_model->auctionDetailPopupData($auctionID);
        $data['auction_detail'] = $auctionData;
        $data['bankData'] = $this->banker_model->bankDetailPopupData($auctionData[0]->bank_id);
        $this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
    }

    function view_own_bid_history($auctionID) {

        $auctionManualBiddingData = $this->owner_model->GetAuctionOwnBidderManualBidHistoryData($auctionID);
        $auctionAutoBiddingData = $this->owner_model->GetAuctionOwnBidderAutoBidHistoryData($auctionID);
        $data['auctionManualBiddingData'] = $auctionManualBiddingData;
        $data['auctionAutoBiddingData'] = $auctionAutoBiddingData;
        if(MOBILE_VIEW)
        {
			$this->load->view('mobile/buyer_own_biddistory', $data);
		}
		else
		{
			$this->load->view('owner_view/buyer_own_biddistory', $data);
		}
    }

    public function viewReport($auctionID) {
        $data['heading'] = 'Report';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['auction_data'] = $this->owner_model->bidderviewReport($auctionID);
        $data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
        $data['auctionID'] = $auctionID;
        $data['breadcrumb'] = '';
        $data['leftsidebar'] = '';
        $this->load->view('owner_view/owner_myActivityTrackReport1', $data);
        $this->website_footer();
    }

     function is_accept_tc_update() {
        $aid = $this->input->post('aid');
        if ($aid) {
            $rt = $this->owner_model->is_accept_tc_update();
            if ($rt) {
                echo "Agreement success!";
            } else {
                echo "Agreement not success!";
            }
        } else {
            echo "Please select auction data!";
        }
    }

    function showsubcategorydata() {
        $category = $this->input->post('category');
        $subcate = $this->input->post('subcate');
        if ($category) {
            $catArr = $this->helpdesk_executive_model->GetsubCategorydata($category);
            $str = '<option value="">Select Sub Category</option>';
            if (count($catArr) > 0) {
                foreach ($catArr as $row) {
                    $selected = ($row->id == $subcate) ? 'selected' : '';
                    $str.='<option ' . $selected . ' value="' . $row->id . '">' . $row->name . '</value>';
                }
            }
            echo $str;
        }
    }

    function ccavRequestHandler() {
        include('Crypto.php');
        $working_key = '6F149C1359A0FBC749A602E500C63A80'; //Shared by CCAVENUES
        $access_code = 'AVJD06CI56BU18DJUB'; //Shared by CCAVENUES
        $merchant_id = 77323;

        if ($this->input->post('payment') == 'Pay Now') {
            $order_id = $this->owner_model->saveTransaction();
        }
        $amount = $this->input->post('amount');
        $auctionID = $this->input->post('auctionID');
        $currency = "INR";
        $payment_type = $this->input->post('payment_type');
        if ($payment_type == 'auction fee') {
            $redirect_url = base_url() . 'owner/ccavResponseHandler';
            $cancel_url = base_url() . 'owner/ccavResponseHandler';
        } else {
            $redirect_url = base_url() . 'owner/auction_participate/' . $auctionID;
            $cancel_url = base_url() . 'owner/auction_participate/' . $auctionID;
        }
        $language = 'EN';
        $billing_name = $this->input->post('billing_name');
        $billing_address = $this->input->post('billing_address');
        $billing_city = $this->input->post('billing_city');
        $billing_state = $this->input->post('billing_state');
        $billing_zip = $this->input->post('billing_zip');
        $billing_country = $this->input->post('billing_country');
        $billing_tel = $this->input->post('billing_tel');
        $billing_email = $this->input->post('billing_email');
        $merchant_data = 'merchant_id=' . $merchant_id . '&order_id=' . $order_id . '&amount=' . $amount . '&currency=' . $currency . '&redirect_url=' . $redirect_url .
                '&cancel_url=' . $cancel_url . '&language=' . $language . '&billing_name=' . $billing_name . '&billing_address=' . $billing_address .
                '&billing_city=' . $billing_city . '&billing_state=' . $billing_state . '&billing_zip=' . $billing_zip . '&billing_country=' . $billing_country .
                '&billing_tel=' . $billing_tel . '&billing_email=' . $billing_email;
        $encrypted_data = encrypt($merchant_data, $working_key);
        $data['encrypted_data'] = $encrypted_data;
        $data['access_code'] = $access_code;
        $this->load->view('owner_view/owner_ccvenue_payamountsubmit', $data);
    }

    function ccavResponseHandler() {
        include('Crypto.php');
        $workingKey = '6F149C1359A0FBC749A602E500C63A80';  //Working Key should be provided here.
        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server
        $rcvdString = decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
      for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 0)
                $order_id = $information[1];
            if ($i == 1)
                $tracking_id = $information[1];
            if ($i == 2)
                $bank_ref_no = $information[1];
            if ($i == 5)
                $payment_mode = $information[1];
            if ($i == 6)
                $card_name = $information[1];
            if ($i == 3)
                $order_status = $information[1];
        }

        if ($order_status === "Success") {
            $dataarr = array('status' => '1',
                'tracking_id' => $tracking_id,
                'bank_ref_no' => $bank_ref_no,
                'order_status' => $payment_mode,
                'payment_mode' => $payment_mode,
                'card_name' => $card_name);
            $this->owner_model->UpdateTransaction($order_id, $dataarr);
            $msg = "<br>Thank you for Auction Payment with us. Your credit card has been charged and your transaction is successful. Your Property has been submitted Please wait for Approval.";
        } else if ($order_status === "Aborted") {
            $dataarr = array('status' => '0',
                'tracking_id' => $tracking_id,
                'bank_ref_no' => $bank_ref_no,
                'order_status' => $payment_mode,
                'payment_mode' => $payment_mode,
                'card_name' => $card_name
                            );
            $this->owner_model->UpdateTransaction($order_id, $dataarr);
            $msg = "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
        } else if ($order_status === "Failure") {

            $dataarr = array('status' => '0',
                'tracking_id' => $tracking_id,
                'bank_ref_no' => $bank_ref_no,
                'order_status' => $payment_mode,
                'payment_mode' => $payment_mode,
                'card_name' => $card_name);

            $this->owner_model->UpdateTransaction($order_id, $dataarr);
            $msg = "<br>Thank you for shopping with us.However,the transaction has been declined.";
        } else {
            $msg = "<br>Security Error. Illegal access detected";
        }
        $data['heading'] = 'Property Payment ' . $order_status;
        $data['controller'] = 'owner';
        $data['tabtype'] = 'MyProperty';
        $bidderID = $this->session->userdata('id');
        $user_data = $this->owner_model->GetRegisterUserById($bidderID);
        $prows = $this->helpdesk_executive_model->GetProductDetailByProductID($pid);
        $data['auctionID'] = $prows->auctionID;
        $auctionData = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($prows->auctionID);
        $data['user_data'] = $user_data;
        $data['prows'] = $prows;
        $data['auctionData'] = $auctionData;
        $data['propertyID'] = $pid;
        $data['leftsidebar'] = $this->load->view('owner_view/seller_leftsidebar', $data, true);
        $this->load->view('common/owner_header_user');
        $data['msg'] = $msg;
        $data['dataSize'] = $dataSize;
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('owner_view/owner_payamount-success', $data);
    }

    public function video_page_popup($product_id) {
        $this->load->view('admin/header-popup', $data);
        $data['heading'] = 'Property Videos';
        $array_records = $this->product_video_model->GetRecords($product_id);
        $data['product_id'] = $product_id;
        $data['records'] = $array_records;
        $this->load->view('product-video', $data);
    }
  function owneragreementprivacypolicy() {
        $this->load->view('owner_view/agreement_and_Privacy_Policy', $data);
   }
   
   public function payAmt() 
   {	
		$bidder_id = $this->uri->segment(3);
		$auction_id = $this->uri->segment(4);
		
		$this->db->where('bidder_id',$bidder_id);
		$this->db->where('auction_id',$auction_id);
		$this->db->where('payment_status','success');
		$chkQry = $this->db->get('tbl_jda_payment_log');
		//echo $this->db->last_query();die;
		if($chkQry->num_rows()>0)
		{
			//$this->session->set_flashdata("message_new", "Payment Already received.");
			redirect('owner/auction_participate/'.$auction_id);
			exit;
		}
		
        $data['heading'] = 'Pay EMD';
        $data['controller'] = 'owner';
        $data['msg'] = $msg;
        $this->load->view('common/owner_header_user');
        $data['tabtype'] = 'MyAuction';
        $data['auctionData'] = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auction_id);
		//print_r($data['auctionData']);die;
		if(MOBILE_VIEW)
		{
			$this->load->view('mobile/owner_payamt', $data);
		}
		else
		{
			$this->load->view('owner_view/owner_payamt', $data);
		}

        $this->website_footer();
    }
    
    public function SaveAuctionAmt()
    {		
		if(isset($_POST['fee_type']) && $_POST['fee_type'] == 'emd')
		{
			if(isset($_POST['failure']))
			{
				$this->emd_paymentFail($_POST);
				$this->tender_paymentFail($_POST);
				$this->session->set_flashdata("message_new", "Payment request has been cancelled.");
				redirect('owner/auction_participate/'.$_POST['auction_id']);
			}
			else
			{
				//if(LOCAL_URL == true)
				if(false)
				{
					
					$this->emd_paymentSuccess($_POST);
					$this->tender_paymentSuccess($_POST);
					redirect('owner/auction_participate/'.$_POST['auction_id']); 
					
				}
				else
				{
					$msg = $this->owner_model->emd_participation_payment($_POST);
					if($msg =='error')
					{
						$this->session->set_flashdata("message_new", "Unable to process your request please try after some time.");
						redirect('owner/auction_participate/'.$_POST['auction_id']);
					}
					if($msg == 'alredyPaid')
					{
						$this->session->set_flashdata("message_new", "Payment Already received.");
						redirect('owner/auction_participate/'.$_POST['auction_id']);
					}
				}
				
			}
			
		}
		/*
		else
		{
			if(isset($_POST['failure']))
			{
				$this->tender_paymentFail($_POST);
			}
			else
			{
				$this->tender_paymentSuccess($_POST);
			}
		}
		*/
	}
	
	public function update_payment_response()
	{
		$payment_log_id = $this->uri->segment(3);
		$this->owner_model->update_payment_response($payment_log_id);
	}
	
	public function cancel_payment_request()
	{
		$payment_log_id = $this->uri->segment(3);
		$auction_id = $this->uri->segment(4);
		$this->owner_model->cancel_payment_request($payment_log_id);
		redirect('owner/auction_participate/'.$auction_id);
		
	}
	
	public function emd_paymentFail($data)
	{
		$this->db->where('bidderID',$data['bidder_id']);
		$this->db->where('auctionID',$data['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_emd');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $data['bidder_id'],
						'auctionID' => $data['auction_id'],
						'amount' => $data['amount'],
						'payment_status' => 'failure',
						'indate' => $date,
						'updatedate' => $date
					);
		
		if($qry->num_rows() > 0)
		{
			$this->db->where('bidderID',$data['bidder_id']);
			$this->db->where('auctionID',$data['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_emd',$record);
		}
		else
		{
			$qry = $this->db->insert('tbl_auction_participate_emd',$record);
		}
		//redirect('owner/auction_participate/'.$data['auction_id']);
	}
	
	public function emd_paymentSuccess($data)
	{
		$this->db->where('bidderID',$data['bidder_id']);
		$this->db->where('auctionID',$data['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_emd');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $data['bidder_id'],
						'auctionID' => $data['auction_id'],
						'amount' => $data['amount'],
						'payment_status' => 'success',
						'indate' => $date,
						'updatedate' => $date
					);
		
		if($qry->num_rows() > 0)
		{
			$this->db->where('bidderID',$data['bidder_id']);
			$this->db->where('auctionID',$data['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_emd',$record);
		}
		else
		{
			$qry = $this->db->insert('tbl_auction_participate_emd',$record);
		}
		//redirect('owner/auction_participate/'.$data['auction_id']);
	}

	public function tender_paymentFail($data)
	{
		$this->db->where('bidderID',$data['bidder_id']);
		$this->db->where('auctionID',$data['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_tenderfee');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $data['bidder_id'],
						'auctionID' => $data['auction_id'],
						'amount' => $data['amount'],
						'payment_status' => 'failure',
						'indate' => $date,
						'updatedate' => $date
					);
		
		if($qry->num_rows() > 0)
		{
			$this->db->where('bidderID',$data['bidder_id']);
			$this->db->where('auctionID',$data['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_tenderfee',$record);
		}
		else
		{
			$qry = $this->db->insert('tbl_auction_participate_tenderfee',$record);
		}
		//redirect('owner/auction_participate/'.$data['auction_id']);
	}
	
	public function tender_paymentSuccess($data)
	{
		$this->db->where('bidderID',$data['bidder_id']);
		$this->db->where('auctionID',$data['auction_id']);
		$qry = $this->db->get('tbl_auction_participate_tenderfee');
		$date = date("Y-m-d H:i:s");
		$record = array(
						'bidderID' => $data['bidder_id'],
						'auctionID' => $data['auction_id'],
						'amount' => $data['amount'],
						'payment_status' => 'success',
						'indate' => $date,
						'updatedate' => $date
					);
		
		if($qry->num_rows() > 0)
		{
			$this->db->where('bidderID',$data['bidder_id']);
			$this->db->where('auctionID',$data['auction_id']);
			$qry = $this->db->update('tbl_auction_participate_tenderfee',$record);
		}
		else
		{
			$qry = $this->db->insert('tbl_auction_participate_tenderfee',$record);
		}
		//redirect('owner/auction_participate/'.$data['auction_id']);
	}
	
	public function viewEventDocuments()
	{
		$data['controller'] = 'owner';        
        $this->load->view('common/owner_header_user');
		$auctionID=$this->uri->segment(3);		
		$data['data'] = $this->owner_model->GetAuctionDocuments($auctionID);
		$this->load->view('owner_view/banker_eventDocuments', $data);
		$this->website_footer();
	}
	public function quick_view()
	{
		$this->load->view('owner_view/quick_view', $data);
	}
	
	public function viewGoogleMap()
	{
		$data['heading']='Auction Event Map';
		$data['controller']='owner';
	
		$auctionID=$this->uri->segment(3);
		$this->load->view('common/owner_header_user');
		$data['data'] = $this->banker_model->GetRecordByAuctionId($auctionID);
		$this->load->view('owner_view/banker_googlemap', $data);
		$this->website_footer();
	}
        /*Start: Added by Aziz #######################*/
        function emdDetailPopupData($bidderID, $auctionID) {
            if($bidderID == $this->session->userdata('id')){
                $data['base_url'] = base_url();
               
                $data['emd'] = $this->owner_model->emdDetailPopupData($bidderID, $auctionID);
                $data['jdaPayLog'] = $this->owner_model->jdaPaymentLogPopupData($bidderID, $auctionID);
                $data['bidderID'] = $bidderID;
                $data['auctionID'] = $auctionID;
                $this->load->view('owner_view/owner_myActivityTrackEmdPopup', $data);
            } else {
                redirect('owner'); exit();
            }
        }
        /*Start: Added by Aziz #######################*/
        function docDetailPopupData($bidderID, $auctionID) {
        if($bidderID == $this->session->userdata('id')){
            $data['base_url'] = base_url();
            $data['doc'] = $this->owner_model->docDetailPopupData($bidderID, $auctionID);
            $data['auctionID'] = $auctionID;
            $data['bidderID'] = $bidderID;
            $this->load->view('owner_view/owner_myActivityTrackDocPopup', $data);
        }
    }
        
	function auctionDetail($auctionID) {
		$data['title'] = "View Detail";
		$data['auction_data'] = $this->home_model->aucDetailPopupData($auctionID);
		$data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
		//print_r($data['auction_data']);
		//echo $data['auction_data'][0]->state;die;
		$salesPerson = $this->home_model->getSalesPerson($data['auction_data'][0]->state);

		$data['sales_person_detail'] = 'Mr. '.$salesPerson[0]->sales_person_name.', Mobile No. '.$salesPerson[0]->mobile_no.', <a href="mailto:'.$salesPerson[0]->email_id.'">'.$salesPerson[0]->email_id.'</a>';
		
		//$data['data'] = $this->home_model->GetAuctionDocuments($auctionID);
		$this->load->view('front_view/header', $data);	
		$this->load->view('owner_view/auctionDetail', $data);
		$this->load->view('front_view/footer');
	}

	public function shortlistedAuction()
	{	
		$data['assetsType'] = $this->owner_model->getAllAssetsType();
		$vdata['property'] = $this->owner_model->getProperty();
		$this->load->view('front_view/header',$data);


		$vdata['data'] = $this->owner_model->getAuctionCityLocation();
		$vdata['allShortlistedAuctionsCounts'] = $this->owner_model->getShortlistedAuctionsCount(0);
		$vdata['propertyShortlistedAuctionsCounts'] = $this->owner_model->getShortlistedAuctionsCount(1);
		$vdata['vehicleShortlistedAuctionsCounts'] = $this->owner_model->getShortlistedAuctionsCount(2);
		$vdata['otherShortlistedAuctionsCounts'] = $this->owner_model->getShortlistedAuctionsCount(3);
		$vdata['otherShortlistedAuctionsCounts'] = $this->owner_model->getShortlistedAuctionsCount(3);

		if(MOBILE_VIEW)
		{				
			$this->load->view('mobile/shortlistedAuction',$vdata);
		}
		else
		{				
			$this->load->view('owner_view/shortlistedAuction',$vdata);
		}
		
		
		$this->load->view('front_view/footer');
	}
	
	 public function allShortlistedAuctionDatatable() {
        echo $this->owner_model->allShortlistedAuctionDatatable();
    }

	 public function propertyShortlistedAuctionDatatable() {
        echo $this->owner_model->propertyShortlistedAuctionDatatable();
    }

	public function vehicleShortlistedAuctionDatatable() {
        echo $this->owner_model->vehicleShortlistedAuctionDatatable();
    }

	public function otherShortlistedAuctionDatatable() {
        echo $this->owner_model->otherShortlistedAuctionDatatable();
    }

	public function manageSubscription()
	{
		if($_GET['package_id'] > 0)
		{
	
				$bidderID = $this->session->userdata('id');

				if($_GET['package_type'] == 2)
				{
					$last_insert_id_payment = $this->home_model->save_payment($bidderID,$_GET['package_id'],2); // renew 
				}
				else
				{
					$last_insert_id_payment = $this->home_model->save_payment($bidderID,$_GET['package_id'],1); // upgrade
				}
				
				redirect('/payment2/index?txnid='.base64_encode($last_insert_id_payment));die;
			
		}

		
		$data['title'] = 'Manage Subscription';
		$this->load->view('front_view/header',$data);
		if(MOBILE_VIEW)
		{				
			$this->load->view('mobile/manageSubscription',$vdata);
		}
		else
		{				
			$this->load->view('owner_view/manageSubscription',$vdata);
		}
		
		
		$this->load->view('front_view/footer');
	}

}
?>
