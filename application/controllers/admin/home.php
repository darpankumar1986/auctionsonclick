
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
		$this->load->library('table');
		$this->load->model('admin/admin_model');
		$this->load->model('admin/bank_model');
		$this->load->model('helpdesk_executive_model');
	   	$this->check_isvalidated();
	}	
	public function index()
	{
		//$this->viewForm();
		$this->dashboard();
	}	
	
	function check_isvalidated()
	{
        if(! $this->session->userdata('validated')){
		     redirect('admin/login');
		     //redirect('registration/logout');
        }
    }
	
    function viewForm()
    {   
        $upcomingtotalRecords=$this->admin_model->GettotalUpcomingAuctionRecord();
        $totalRecords=$this->admin_model->GettotalSavedAuctionRecord();
        $data['totalRecords']=$totalRecords;
        $data['upcomingtotalRecords']=$upcomingtotalRecords;
        $this->load->view('admin/header');		
        //$this->load->view('admin/sidebar');					
        $this->load->view('admin/home',$data);
        $this->load->view('admin/footer');

    }
    public function sendRole() {						
        $data = $this->admin_model->setRole();       
    }
    
    
    public function dashboard() {
        $data['heading'] = 'My Activity';
        $data['controller'] = 'admin/home';
        $this->load->view('admin/header');		
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }
    
     function liveEventsdatatable() {
        echo $this->admin_model->liveEventsdatatable();
    }

    function liveUpcomingAuctionsdatatable() {
        echo $this->admin_model->liveUpcomingAuctionsdatatable();
    }

    function bids_to_be_openeddatatable() {
        echo $this->admin_model->bids_to_be_openeddatatable();
    }

    public function savedEvents() {
        $data['heading'] = 'Saved Auction';
        $data['controller'] = 'admin/home';
        $this->load->view('admin/header');
        $this->load->view('admin/saved_events', $data);
        $this->load->view('admin/footer');
    }

    function saveEventsdatatable() {
        echo $this->admin_model->saveEventsdatatable();
    }
    
    public function completedEvents() {
        $data['heading'] = 'Completed Auction';
        $data['controller'] = 'admin/home';
        $this->load->view('admin/header');
        $this->load->view('admin/completedEvents', $data);
        $this->load->view('admin/footer');
    }

    function completedAuctionsdatatable() {
        echo $this->admin_model->completedAuctionsdatatable();
    }
    
    
/*
    function completedEventsdatatable() {
        echo $this->banker_model->completedEventsdatatable();
    }
*/
	function concludeCompletedAuctionsdatatable() {
        echo $this->admin_model->concludeCompletedAuctionsdatatable();
    }
    
    function canceleddatatable() {
        echo $this->admin_model->canceleddatatable();
    }

    function rejectedEventsdatatable() {
        echo $this->admin_model->rejectedEventsdatatable();
    }

    function approvelRejectionEventsdatatable() {
        echo $this->admin_model->approvelRejectionEventsdatatable();
    }


	public function liveAuctions() {
        $data['heading'] = 'Live Auctions';
        $data['controller'] = 'admin/home';
        $this->load->view('admin/header');
        $this->load->view('admin/liveAuctions', $data);
        $this->load->view('admin/footer');
        
    }
	

	public function viewGoogleMap() {
        $data['heading'] = 'Auction Event Map';
        $data['controller'] = 'admin/home';
        

        $auctionID = $this->uri->segment(4);
        $this->load->view('admin/header');
        $data['data'] = $this->admin_model->GetRecordByAuctionId($auctionID);
        $this->load->view('admin/googlemap', $data);
        $this->load->view('admin/footer');
    }
    
    
    function eventDetailPopup($auctionID) {
		$document_list = $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
        $data['document_list'] = $document_list;
		$uploadedDocs = $this->bank_model->GetUploadedDocsByAuctionId($auctionID);
        $data['uploadedDocs'] = $uploadedDocs;
        $data['auction_detail'] = $this->admin_model->auctionDetailPopupData($auctionID);
        $this->load->view('admin/eventDetailPopup', $data);
    }
    
    function createEvent($eid) { 
       

        $action = $this->input->get('action');

        $data['heading'] = 'Create Auction';
        $data['controller'] = 'admin/home';
        $data['utype'] = "creator";

        $this->load->view('admin/header');

        $bankID = $this->session->userdata['bank_id'];
        $userID = $this->session->userdata['id'];
        $branch_id = GetTitleByField('tbl_user', "id='" . $userID . "'", 'user_type_id');
        $arows = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);

        //$banksUsersList		=	 $this->helpdesk_executive_model->eventBankUserList($utype,$branch_id,$bankID);		
        $banksUsersList = $this->helpdesk_executive_model->getUserByBankId($bankID);
        $document_list = $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
        $auctionData = $this->helpdesk_executive_model->GetAutionbyId($eid); // New Add from createEventAuction
        $banks = $this->bank_model->GetBankRecords(); // New Add from createEventAuction

        $accountType = $this->bank_model->GetAccountTypeRecords();
        $uomType = $this->bank_model->GetUOMtypeRecords();
        $heightUomType = $this->bank_model->GetHeightUOMtypeRecords();

        $upload_document_field = $this->bank_model->GetUploadDocumentFieldRecords();
        

        $uploadedDocs = $this->bank_model->GetUploadedDocsByAuctionId($eid);
        $zoneArr = $this->bank_model->GetZoneData();
        $approverArr = $this->bank_model->getApproverData();
        if ($eid != '') {
            $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($eid); // New Add from createEventAuction
        }

		
        $countries = $this->bank_model->GetCountries();
        $data['countries'] = $countries;
        $states = $this->bank_model->GetState();
        $data['states'] = $states;
        $cities = $this->bank_model->GetCity();
        $data['cities'] = $cities;
        
        $data['document_list'] = $document_list;  // New Add  from createEventAuction
        $data['auctionData'] = $auctionData; // New Add  from createEventAuction
        $data['banks'] = $banks; // New Add  from createEventAuction
        $data['bankbranch'] = $this->helpdesk_executive_model->GetBranchdata($auctionData->bank_id);
        
        $data['prows'] = $prows; // New Add  from createEventAuction
        $data['banksUsersList'] = $banksUsersList;
        $data['auctionID'] = $eid;
        $data['arows'] = $arows;
        $data['userID'] = $userID;
        $data['accountType'] = $accountType;
        $data['uomType'] = $uomType;
        $data['heightUomType'] = $heightUomType;
        $data['upload_document_field'] = $upload_document_field;
        $data['uploadedDocs'] = $uploadedDocs;
        $data['zoneArr'] = $zoneArr;
        $data['approverArr'] = $approverArr;
		$data['category'] = $this->helpdesk_executive_model->GetCategorylist();
		$data['sub_category'] = $this->helpdesk_executive_model->GetSubCategory($auctionData->category_id);

        $data['banksUsersSecondOpener'] = $this->helpdesk_executive_model->getUserByBranchId($branch_id);
		$salesPerson = $this->admin_model->getSalesPerson($auctionData->state);

		$data['sales_person_detail'] = $salesPerson[0]->sales_person_name.', '.$salesPerson[0]->mobile_no;

        $this->load->view('admin/banker_create_event_step3', $data);
        $this->load->view('admin/footer');
    }
    
    
    function saveeventdata() {
        //ini_set("display_errors", "1");
        //error_reporting(E_ALL);
        $auctionID = $this->input->post('auctionID');
        $productID = $this->input->post('productID');
        $this->load->library('form_validation');
        $upload_document_field = $this->bank_model->GetUploadDocumentFieldRecords();
        /*
          echo "<pre>";
          print_r($_FILES);
         */

        //$this->form_validation->set_rules('account', 'Institution', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_id', 'Bank Name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('reference_no', 'Auction Reference No', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area', 'Property Area', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area_unit_id', 'Area Unit', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category_id', 'Category/ Property Type', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('contact_person_details_1', '1st Contact Person Details', 'trim|required|xss_clean');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required|xss_clean');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required|xss_clean');



        if (is_array($upload_document_field) && count($upload_document_field) > 0) {
            foreach ($upload_document_field as $udf) {
                $fieldName = strtolower(str_replace(' ', '_', $udf->upload_document_field_name));
                if ($udf->isMandatory == 1) {
                    if ('old_' . $fieldName == '') {
                        if ($_FILES[$fieldName]['name'] == '') {
                            $this->form_validation->set_rules($fieldName, $udf->upload_document_field_name, 'trim|required|xss_clean');
                        }
                    }
                }
            }
        }

        $send4Approval = $this->input->post('send4Approval');
        $createCopy = $this->input->post('create_copy');
		$copyCount = $this->input->post('copy_count');
		if($createCopy){									
			$errflg = 0;
			if(!is_numeric($copyCount))
			{
				$errflg = 1;
				$this->session->set_flashdata("crcp", "Please Enter Valid Number of Copies.");              
			}
			if($errflg==1)
			{
				redirect('admin/home/createEvent/'.(int)$auctionID);
			}
		}          
        else if ($send4Approval) {
            //$this->form_validation->set_rules('zone_id', 'Concerned Zone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reserve_price', 'Bid Start Price (BSP)', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('unit_id_of_price', 'BSP Unit of Price', 'trim|required|xss_clean');
            $this->form_validation->set_rules('emd_amt', 'EMD Amount', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('tender_fee', 'Participation Fee', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('press_release_date', 'press_release_date', 'trim|required|xss_clean');
           // $this->form_validation->set_rules('inspection_date_from', 'Site Visit Start Date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('inspection_date_to', 'Site Visit End Date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('registration_start_date', 'Apply And EMD Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bid_last_date', 'EMD Submission Last Date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('bid_opening_date', 'Shortlisting Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('auction_start_date', 'auction_start_date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('auction_end_date', 'auction_end_date', 'trim|required|xss_clean');
            
            $crrDte = strtotime(date('Y-m-d H:i:s'));
			$press_release_date = strtotime($this->input->post('press_release_date'));
			$inspection_date_from = $this->input->post('inspection_date_from');
			if($inspection_date_from !='' && $inspection_date_from != '0000-00-00 00:00:00'){
                           $inspection_date_from = strtotime($this->input->post('inspection_date_from')); 
                        }
                        $inspection_date_to = $this->input->post('inspection_date_to');
			if($inspection_date_to !='' && $inspection_date_to != '0000-00-00 00:00:00'){
                           $inspection_date_to = strtotime($this->input->post('inspection_date_to')); 
                        }
                        
			
			$registration_start_date = strtotime($this->input->post('registration_start_date'));
			$bid_last_date = strtotime($this->input->post('bid_last_date'));
			$auction_start_date = strtotime($this->input->post('auction_start_date'));
			$auction_end_date = strtotime($this->input->post('auction_end_date'));
			$errflg = 0;
			
			if(!is_numeric($this->input->post('emd_amt')))
			{
				$errflg = 1;
				$this->session->set_flashdata("emda", "Please Enter Valid EMD Amount!");
              
			}
			/*if(!is_numeric($this->input->post('tender_fee')))
			{
				$errflg = 1;
				$this->session->set_flashdata("parf", "Please Enter Valid Participation Fee!");
              
			}*/
			if(!is_numeric($this->input->post('reserve_price')))
			{
				$errflg = 1;
				$this->session->set_flashdata("bsp", "Please Enter Valid Bid Start Price (BSP)!");
              
			}
            /*                               
			if(!is_numeric($this->input->post('area')))
			{
				$errflg = 1;
				$this->session->set_flashdata("prarea", "Please Enter Valid Carpet Area!");
              
			}
            */
             /*          
			 if(!is_numeric($this->input->post('bid_inc')))
			{
				$errflg = 1;
				$this->session->set_flashdata("bicv", "Please Enter Valid Bid Increment value!");
              
			}
                       
			if($press_release_date>=$crrDte)
			{
				$errflg = 1;
				$this->session->set_flashdata("prd", "Press Release Date & time should be less than current date & time!");
              
			}
			if($inspection_date_from !='' && $press_release_date>=$inspection_date_from)
			{
				$errflg = 1;
				$this->session->set_flashdata("svsd", "Site Visit Start Date & time should be greater than Press release date & time!");
               
			}
			if($inspection_date_from !='' && $inspection_date_to !='' && $inspection_date_from>=$inspection_date_to)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be greater than Site Visit Start Date time!");
                
			}
			*/
			/*
			if($inspection_date_to>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be less than Auction Start date or time!");
            }*/
            /*
			if($inspection_date_to !='' && $inspection_date_to>=$auction_end_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be less than Auction End date time!");
			}
			if($press_release_date>=$registration_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("aesd", "Apply And EMD Start Date time should be greater than Press Release Date time!");
                
			}
			if($registration_start_date>=$bid_last_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("aeed", "EMD Submission Last Date time should be greater than Apply And EMD Start Date time!");
                
			}
			if($registration_start_date>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("asdt", "Auction Start Date time should be greater than Apply And EMD Start Date time!");
                
			}			
			if($bid_last_date>=$auction_end_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("aedt", "Auction End Date time should be greater than EMD Submission Last Date time!");
               
			}
			*/
			/*
			if(($this->input->post('auto_extension')>0 && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')) || ($this->input->post('auto_extension') =='' && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')))
			{
				$errflg = 1;
				$this->session->set_flashdata("aetm", "Please Enter Valid Auto Extension Time!");
               
			}
			*/
			
			if($errflg==1)
			{
				 redirect('admin/home/createEvent');
			}
        }

        if ($this->form_validation->run() == FALSE) {
            //echo validation_errors();die;
            $msg = "Please Enter Require fields.!";
            $this->session->set_flashdata("message", "Please Enter Require fields.!");
            redirect('admin/home/createEvent/');
        } else {
			
			
            if ($this->input->post('reference_no') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('reference_no'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('event_title') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('event_title'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('borrower_name') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('borrower_name'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('reserve_price') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('reserve_price'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('emd_amt') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('emd_amt'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('tender_fee') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('tender_fee'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('nodal_bank_account') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('nodal_bank_account'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('branch_ifsc_code') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('branch_ifsc_code'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('press_release_date') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('press_release_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('inspection_date_from') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('inspection_date_from'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('inspection_date_to') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('inspection_date_to'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }


            if ($this->input->post('bid_last_date') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('bid_last_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('bid_opening_date') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('bid_opening_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('auction_start_date') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('auction_start_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('auction_end_date') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('auction_end_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('bid_inc') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('bid_inc'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }
            if ($this->input->post('auto_extension_time') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('auto_extension_time'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }


            if ($this->input->post('auto_extension') != '') {
                $checkHTMLTags = $this->admin_model->checkHTMLTags($this->input->post('auto_extension'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('admin/home/createEvent');
                }
            }


            if (is_array($upload_document_field) && count($upload_document_field) > 0) {
                foreach ($upload_document_field as $udf) {
                    $fieldName = strtolower(str_replace(' ', '_', $udf->upload_document_field_name));

                    if ($udf->upload_document_field_type == 2) { // 2 video validation
                        $checkMultipleExtension = $this->admin_model->checkVideoMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('admin/home/createEvent/');
                        }
                    } else {
                        $checkMultipleExtension = $this->admin_model->checkMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('admin/home/createEvent/');
                        }
                    }
                }
            }

            $insetedid = $this->admin_model->saveeventdata();

            if ($insetedid) {
                $publish = $this->input->post('Publish');
                
                $saveasdraft = $this->input->post('Save');
                

                if ($publish) {
					
					
					
					$this->db->where('id', $insetedid);
					$aQry = $this->db->get('tbl_auction');	
					if($aQry->num_rows()>0)
					{
						$row = $aQry->result_array();
						$datalog = $row[0];
						unset($datalog['id']);
						unset($datalog['move_to_auction']);
						unset($datalog['UserNo']);
						unset($datalog['EventBankID']);
						unset($datalog['IsPaused']);
						unset($datalog['IsComplete']);
						unset($datalog['IsDeleted']);
						unset($datalog['indate']);
						unset($datalog['approverComments']);
						$datalog['tender_no'] = 0;
						$datalog['auction_id'] = $insetedid;
						$datalog['ip'] = $_SERVER['REMOTE_ADDR'];		
						$datalog['indate'] = date('Y-m-d H:i:s');;		
						$this->db->insert('tbl_log_auction',$datalog);
					}
					// Add/Update data in elastic search engine
					$this->load->model('elastic_model');		
					$res = $this->elastic_model->property($insertedid_id);
					
					$msg = "Auction has been published successfully.";
					$this->session->set_flashdata('message', $msg);
					redirect('admin/home/liveAuctions');
					
                } else if($saveasdraft){
                    $msg = "Auction is saved successfully. EventID is '" . $insetedid . "' !";
                    $this->session->set_flashdata('message', $msg);
                    //redirect('admin/home/createEvent/' . $auctionID);
                    redirect('admin/home/createEvent/'.$insetedid);// Added by Aziz

                } else if($createCopy){
					$msg = $copyCount." Number of copies has been created.";
                    $this->session->set_flashdata('message', $msg);
					redirect('admin/home/createEvent/'.(int)$auctionID);
				}
                
            }
        }
    }
    
    function removePorpertyPhotoData() {
        $auction_document_id = $this->input->post('auction_document_id');        
        if ($auction_document_id != '') {
            $this->admin_model->removePorpertyPhotoData();
        } else {
            echo "Property Photo not deleted";
        }
    }
    
    public function getStateDropDown($country_id, $state_id) {
        $states = $this->bank_model->GetState($country_id);
        $str = '<option value="">Select State</option>';
        foreach ($states as $state_record) {
            $str .= "<option value='$state_record->id'";
            if ($state_record->id == $state_id)
                $str .= 'selected';$str .= " >$state_record->state_name</option>";
        }
        echo $str;
    }

    public function getCityDropDown($state_id, $city_id) {
        $cities = $this->bank_model->GetCity($state_id);
        $str = '<option value="">Select City</option>';
        foreach ($cities as $city_record) {
            $str .= "<option value='$city_record->id'";
            if ($city_record->id == $city_id)
                $str .= 'selected';$str .= " >$city_record->city_name</option>";
        }
        //$str.='<option value="others">Others</option>';
        echo $str;
    }
    
    public function getSalesPerson($state_id) {
        $salesPerson = $this->admin_model->getSalesPerson($state_id);
		echo $salesPerson[0]->sales_person_name.', '.$salesPerson[0]->mobile_no;
    }

    function showbranchdata($bank_id) {
        
        if ($bank_id) {
            $catArr = $this->helpdesk_executive_model->GetBranchdata($bank_id);
            $str = '<option value="">Select Branch</option>';
            if (count($catArr) > 0) {
                foreach ($catArr as $row) {
                    $selected = ($row->id == $subcate) ? 'selected' : '';
                    $str .= '<option ' . $selected . ' value="' . $row->id . '">' . $row->name . '</value>';
                }
            }
            echo $str;
        }
    }
    
	
    public function showsubcatdata($catId) {
        $subCategories = $this->helpdesk_executive_model->GetSubCategory($catId);
        $str = '<option value="">Select Sub Type</option>';
        foreach ($subCategories as $sub_cat) {
            $str .= "<option value='$sub_cat->id'";
			$str .= " >$sub_cat->name</option>";
        }
        echo $str;
    }

	
    
}
