<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuyerApprover extends WS_Controller
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
		//ini_set("display_errors", "1");
		//error_reporting(E_ALL);
		//error_reporting(0);
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');		
		$this->load->library('table');
		$this->load->library('Email_new','email');
		$this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('buyer1_model');

		$this->load->model('owner_model');
		$this->load->model('product_image_model');
		$this->load->model('admin/bank_model');
		$this->load->model('admin/dynamic_form_model');
		$this->load->model('helpdesk_executive_model');	
		$this->load->model('banker_model');	
        $this->check_isvalidated();
        /* run auction completed script */
		$this->load->model('account_model');
		$this->account_model->completedAuctionScript();
		/* end run auction completed script */
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
	}	
	
	public function index()
	{   
		$userType = array("banker", "branch", "region", "zone", "bank_admin", "drt", "approver");
		//echo $this->session->userdata('user_type');die;
        if(!$this->session->userdata('id') || !in_array($this->session->userdata('user_type'), $userType))
		{ 
			redirect('/registration/logout');
		}  
        $this->myActivity();
        //$this->page($page_no);
	}	
	
	private function check_isvalidated()
	{
		checkloginUserstatus($this->session->userdata('id'),'banker');
		if($this->session->userdata('id') && $this->session->userdata('user_type')=='approver')
		{
		}
		else
		{
			redirect('/registration/logout');
		}
    }	
	
	public function dashboard()
	{
		$data['heading']='Create Auction ';
		$data['controller']='buyerApprover';
		$this->banker_header();	
		$dashboardData=$this->buyer1_model->dashboardData();
		$auctionConductedbyCategories=$this->buyer1_model->auctionConductedbyCategories();
		$category=$this->owner_model->GetPopularPropertyType();
		$data['dashboardData'] = $dashboardData; 		
		$data['auctionConductedbyCategories'] = $auctionConductedbyCategories; 		
		$data['getpopular'] = $category; 		
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$this->load->view('banker_view/banker_dashboard', $data);
		$this->website_footer();
	}
	
	function ajaxdashboard()
	{	
		$DashboardData=$this->buyer1_model->ajaxDashboardData();
		echo json_encode($DashboardData);
	}
	
	/**********************      myActivity     ************************/
	public function myActivity()
	{
		//echo "hello";die;
		$data['heading']='My Activity';
		$data['controller']='buyerApprover';
		$this->banker_header();	
		$this->load->view('approver_view/banker_myActivity', $data);
		$this->website_footer();
	}
	
	function liveEventsdatatable()
	{		 			
		echo $this->buyer1_model->liveEventsdatatable();
	}
	
	function liveUpcomingAuctionsdatatable()
	{		 
		echo $this->buyer1_model->liveUpcomingAuctionsdatatable();
	}
	
	function bids_to_be_openeddatatable()
	{		 
		echo $this->buyer1_model->bids_to_be_openeddatatable();
	}
	
	public function savedEvents()
	{
		$data['heading']='Saved Auction';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivitySavedEvents', $data);
		$this->website_footer();
	}
	
	function saveEventsdatatable()
	{		 
		echo $this->buyer1_model->saveEventsdatatable();
	}
	
	public function liveEvent()
	{
		$data['heading']='Live Auction';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityLiveEvent', $data);
		$this->website_footer();		
	}
	
	function liveEventdatatable()
	{		 
		echo $this->buyer1_model->liveEventdatatable();
	}
	
	public function liveAuctions()
	{
		$data['heading']='Live Auctions';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityLiveAuctions', $data);
		$this->website_footer();
	}
	
	function liveAuctionsdatatable()
	{		 
		echo $this->buyer1_model->liveAuctionsdatatable();
	}
        
	public function listLiveAuctions($aid)
	{
		$data['heading']='List Live Auctions';
		$data['controller']='buyerApprover';
		$this->banker_header();
		//$auctionData=$this->buyer1_model->getBankersLiveAuctionList($aid);
		$auctionData=$this->buyer1_model->getBankersLiveAuction10SecondList($aid);
		$data['auctionData']=$auctionData;
        $data['auctionId']=$aid;
		$this->load->view('banker_view/banker_myActivityListLiveAuction', $data);
		$this->website_footer();
	}
	
	public function bidsToBeOpened()
	{
		$data['heading']='Bids To Be Opened';
		$data['controller']='buyerApprover';
		$this->banker_header();		
		$this->load->view('banker_view/banker_myActivityBidsToBeOpened', $data);
		$this->website_footer();
	}
	
	function bidsToBeOpeneddatatable()
	{		 
		echo $this->buyer1_model->bidsToBeOpeneddatatable();
	}
	
	public function completedEvents()
	{
		$data['heading']='Create Auction';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityCompletedEvents', $data);
		$this->website_footer();
	}
	
	function completedAuctionsdatatable()
	{		 
		echo $this->buyer1_model->completedAuctionsdatatable();
	}
	
	function concludeCompletedAuctionsdatatable()
	{		 
		echo $this->buyer1_model->concludeCompletedAuctionsdatatable();
	}
	
	function completedEventsdatatable()
	{		 
		echo $this->buyer1_model->completedEventsdatatable();
	}
	
	function canceleddatatable()
	{		 
		echo $this->buyer1_model->canceleddatatable();
	}
    
    function movetoauction1(){
              
        echo $this->buyer1_model->movetoauction1();  
    }
    
    function movetoauction(){
        echo $this->buyer1_model->movetoauction();  
    }
    
    public function corrigendum()
	{
		$data['heading']='Corrigendum List';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityCorrigendum', $data);
		$this->website_footer();
	}
	
	function corrigendumdatatable()
	{		 
		echo $this->buyer1_model->corrigendumdatatable();
	}
	
	public function MISReport()
	{
		$data['heading']='Create Auction';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		//Track Bidder View Report start
		$trackreportdata=array(
			   'event_id'=>'',
			   'auction_id'=>'',
			   'bidder_id'=>$this->session->userdata('id'),
			   'bank_id'=>$bank_id,
			   'user_type'=>$this->session->userdata('user_type'),
			   'action_type'=>"Bank_mis_report",
			   'action_type_event'=>"view",
			   'ip'=>$_SERVER['REMOTE_ADDR'],
			   'status'=>'1',
			   'message'=>'Buyer has successfully viewed MIS Report',
			   'indate'=>date('Y-m-d H:i:s'),
				);
        $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);

		$this->load->view('banker_view/banker_myActivityMISReport', $data);
		$this->website_footer();
	}
	
	public function bankerEventMISReport()
	{
		echo $this->buyer1_model->bankerEventMISReport();
	}
	
	public function bankerDrtEventMISReport()
	{
		echo $this->buyer1_model->bankerDrtEventMISReport();
	}
	
	function createEvent($eid)
	{
		$action=$this->input->get('action');
		
		$data['heading']='Create Auction'; 
		$data['controller']='buyerApprover';
		$this->banker_header();
                
		$bankID = $this->session->userdata['bank_id'];
		$userID					=	 $this->session->userdata['id'];
		$branch_id				=	 GetTitleByField('tbl_user', "id='".$userID."'", 'user_type_id');
        $arows					=	 $this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);	
        $utype					=	 "branch";
		//$banksUsersList		=	 $this->helpdesk_executive_model->eventBankUserList($utype,$branch_id,$bankID);		
		$banksUsersList			= 	 $this->helpdesk_executive_model->getUserByBankId($bankID);		
		$document_list			=	 $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
		$auctionData			=	 $this->helpdesk_executive_model->GetAutionbyId($eid); // New Add from createEventAuction
        $banks 					= 	 $this->bank_model->GetBankRecords(); // New Add from createEventAuction
        $accountType 			= 	 $this->bank_model->GetAccountTypeRecords();
        $uomType	 			= 	 $this->bank_model->GetUOMtypeRecords();
        $category 				= 	 $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction
        
        if($eid!='')
        {
            $prows				=    $this->helpdesk_executive_model->GetProductDetailByeventID($eid); // New Add from createEventAuction
        }
		
		$data['document_list']	=	 $document_list;  // New Add  from createEventAuction
		$data['auctionData']	=	 $auctionData; // New Add  from createEventAuction
		$data['banks']			=	 $banks; // New Add  from createEventAuction
		$data['category']		=	 $category; // New Add  from createEventAuction
		$data['prows']		    =    $prows; // New Add  from createEventAuction
		$data['banksUsersList']	=	 $banksUsersList;
		$data['auctionID']		=	 $eid;
		$data['arows']			=	 $arows;
		$data['userID']			=	 $userID;
		$data['accountType']	=	 $accountType;
		$data['uomType']		=	 $uomType;
        $countries = $this->helpdesk_executive_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->helpdesk_executive_model->GetState();		
		$data['states'] = $states;
		$cities = $this->helpdesk_executive_model->GetCity();		
		$data['cities'] = $cities;
               
        $drt_user = $this->session->userdata('user_type');
		if($drt_user == 'drt')
		{	
			$bankId = $arows->bank_id;
			if(!($bankId > 0))
			{
				if(is_array($data['banks']))
				{
					$bankId = $data['banks'][0]->id;
				}
			}
			
			$data['bank_id'] = $arows->bank_id;	
			$data['banksUsersList']	=	 $this->helpdesk_executive_model->getUserByBankId($bankId);	
			$data['bankbranch']	 =	 $this->helpdesk_executive_model->GetBranchdata($bankId);		
		}
		$data['banksUsersSecondOpener']	=	 $this->helpdesk_executive_model->getUserByBranchId($branch_id);
		
		//$this->load->view('banker_view/banker_myActivityCreateEvent', $data);
		//$this->load->view('banker_view/banker_create_event_step1',$data);
		$this->load->view('banker_view/banker_create_event_step3',$data);
		$this->website_footer();
	}
	
	// Step 2 to Step 3 Click
	function createEventAuction($aid)
	{
		/*
		 $auction_list=$this->buyer1_model->getBankerCreatedAuction($aid);
			if(!in_array($aid,$auction_list))
			{
				redirect('/buyer');
			}
		*/
		$submit = $this->input->post('Save');
		if(isset($submit))
		{
			$this->load->library('form_validation');
			$productID=$this->input->post('productID');
			$auctionID=$this->input->post('auctionID');
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('type', 'type', 'trim|required|xss_clean');			
			if($this->form_validation->run() == FALSE){
				$msg="Please Enter Require fields.!";
			}else{
				$erows=$this->buyer1_model->createEventdatastep2();
				redirect('buyerApprover/createEventAuction/'.$auctionID);			
			}
		}
		
		$data['heading']='Create Event Auction'; 
		$this->banker_header();
		$data['controller']='buyerApprover';
		$banks 							= 	$this->bank_model->GetBankRecords();	
		$category 						= 	$this->helpdesk_executive_model->GetCategorylist();	
		$utype							=	 "branch";
		$userID							=	 $this->session->userdata['id'];
		$branch_id						=	 GetTitleByField('tbl_user', "id='".$userID."'", 'user_type_id');
		$bank_id						=	 GetTitleByField('tbl_user', "id='".$userID."'", 'bank_id');
		$banksUsersList					=	 $this->helpdesk_executive_model->eventBankUserList('branch',$branch_id);
		$biddersrow						=	 $this->helpdesk_executive_model->getAllBiidersList();
		$document_list					=	 $this->helpdesk_executive_model->document_list();
		$auctionData					=	 $this->helpdesk_executive_model->GetAutionbyId($aid);
		$data['bankbranch']			    =	 $this->helpdesk_executive_model->GetBranchdata($banks_id);
		$data['banksUsersList']			=	 $banksUsersList;
		$data['biddersrow']				=	 $biddersrow;
		$data['banks']					=	 $banks;
		$data['auctionID']				=	 $aid;
		$data['category']				=	 $category;
		$data['document_list']			=	 $document_list;
		$data['auctionData']			=	 $auctionData;
		$arows							=	 $this->helpdesk_executive_model->GetAutionRecordById($aid);
		$auctionID						=	 $arows->id;
		$prows							=    $this->helpdesk_executive_model->GetProductDetailByeventID($aid);
		
		if(true)
		{
			$data['drtEvent'] = true;	
		}
			
		$data['prows']=$prows;
		$this->load->view('banker_view/banker_create_event_step3',$data);
		$this->executive_footer();
	}
	
	function createEventproperty($eid)
	{
		/*
			$auction_list=$this->buyer1_model->getBankerCreatedAuction($eid);
			if(!in_array($eid,$auction_list))
			{
				redirect('/buyer');
			}
		*/	
		$submit = $this->input->post('submit');
		if(isset($submit))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('bankuser', 'bankuser', 'trim|required|xss_clean');
			if($this->form_validation->run() == FALSE){
				$msg="Please Enter Require fields.!";
			}else{
			$auctionID=$this->buyer1_model->createEventdatastep1();
			redirect('buyerApprover/createEventproperty/'.$auctionID);			
			}
		}
		$data['heading']='Create Event Property'; 
		$this->banker_header();
		$data['controller']='buyerApprover';
		//$erows=$this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);
		$category 				= 	 $this->helpdesk_executive_model->GetCategory();
		$prows					=	 $this->helpdesk_executive_model->GetProductDetailByeventID($eid);		
		$data['category'] 		= 	 $category;
		$data['auctionID']		=	 $eid;
		$countries 				= 	 $this->bank_model->GetCountries();		
		$data['countries'] 		=	 $countries;
		$states 				=	 $this->bank_model->GetState();		
		$data['states']			= 	 $states;
		$cities 				=	 $this->bank_model->GetCity();		
		$data['cities'] 		=	 $cities;
		$data['prows'] 			=	 $prows;
		$attr_records 			= 	 $this->dynamic_form_model->GetAttributeValue($prows->id);
		$data['attr_records'] 	=	 $attr_records;
		$this->load->view('banker_view/banker_create_event_step2',$data);
		$this->executive_footer();
		
	}
	
	public function getStateDropDown($country_id,$state_id)
	{
		$states = $this->bank_model->GetState($country_id);
		$str='<option value="">Select State</option>';
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
                //$str.='<option value="others">Others</option>';
		echo $str;
	}
	
	public function ajaxFormData($category_id='',$product_id='')
	{
		$records = $this->helpdesk_executive_model->GetRecordByCategory($category_id,$is_auction='auction',$is_bank='bank',$is_sell='sell');
		if($product_id)
		{
			$detail_records = $this->helpdesk_executive_model->GetProductDetail($product_id);
			$attr_records = $this->helpdesk_executive_model->GetAttributeValue($product_id);
		}
		$data['records']=$records;
		$data['detail_records']=$detail_records;
		$data['attr_records']=$attr_records;
		$this->load->view('ajaxFormData', $data);
	}
	
	public function getsubcategory($category)
	{
		$subCategory = $this->helpdesk_executive_model->GetSubCategory($category);
		$str='<option value="">Select Subcategory</option>';
		foreach($subCategory as $subCategory_record)
		{
			$str.="<option value='$subCategory_record->id'>".$subCategory_record->name."</option>";
		}
		echo $str;
	}
	
	function saveeventdata()
	{	
		//ini_set("display_errors", "1");
		//error_reporting(E_ALL);
		 $auctionID=$this->input->post('auctionID');
		$productID=$this->input->post('productID');
		$this->load->library('form_validation');
			
		$publish=$this->input->post('Publish');
		$this->form_validation->set_rules('account', 'account', 'trim|required|xss_clean');
		$this->form_validation->set_rules('reference_no', 'reference_no', 'trim|required|xss_clean');
		$this->form_validation->set_rules('event_title', 'event_title', 'trim|required|xss_clean');
		
		if($publish)
		{
			$this->form_validation->set_rules('reserve_price', 'reserve_price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('borrower_name', 'borrower_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('press_release_date', 'press_release_date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('bid_opening_date', 'bid_opening_date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('auction_start_date', 'auction_start_date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('auction_end_date', 'auction_end_date', 'trim|required|xss_clean');
		}
			
		if($this->form_validation->run() == FALSE)
		{
			$msg="Please Enter Require fields.!";
		}
		else
		{
			if($this->input->post('reference_no')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('reference_no'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('event_title')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('event_title'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('borrower_name')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('borrower_name'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('reserve_price')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('reserve_price'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('emd_amt')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('emd_amt'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('tender_fee')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('tender_fee'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('nodal_bank_account')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('nodal_bank_account'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
		if($this->input->post('branch_ifsc_code')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('branch_ifsc_code'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('press_release_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('press_release_date'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('inspection_date_from')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('inspection_date_from'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('inspection_date_to')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('inspection_date_to'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			
			
			if($this->input->post('bid_last_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('bid_last_date'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('bid_opening_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('bid_opening_date'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('auction_start_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auction_start_date'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('auction_end_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auction_end_date'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('bid_inc')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('bid_inc'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($this->input->post('auto_extension_time')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auto_extension_time'));if($checkHTMLTags == "1"){
			$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			
			
			if($this->input->post('auto_extension')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auto_extension'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createEvent');}}
			if($_FILES['related_doc']['name']!= "")
				{
					$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['related_doc']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
							redirect('buyerApprover/createEvent/');		
					  }		
				}
				
			if($_FILES['image']['name']!= "")
				{
					$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['image']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
							redirect('buyerApprover/createEvent/');		
					  }		
				}
			
			if($_FILES['supporting_doc']['name']!= "")
			{
				$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['supporting_doc']['name']);
				  if($checkMultipleExtension == 'mul')
				  {
						$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
						redirect('buyerApprover/createEvent/');		
				  }		
			}
				
			
			$insetedid=$this->buyer1_model->saveeventdata();
				
			if($insetedid)
			{
				$publish=$this->input->post('Publish');
				if($publish)
				{
					/* send Email to Helpdesk Executive */
					$arows	=	$this->helpdesk_executive_model->GetAutionRecordByAuctionId($insetedid);	
					$event_title = $arows->event_title;
					
					$first_opener = $arows->first_opener;
					$second_opener = $arows->second_opener;
						
					$arr['email'] = array();
					if($first_opener > 0)
					{
						$arr['email'][] = GetTitleById('tbl_user',$first_opener,'email_id');						
					}	
						
					if($second_opener > 0)
					{
						$arr['email'][] = GetTitleById('tbl_user',$second_opener,'email_id');
					}					
					$arr['event_title'] = $event_title;
					$this->sendMailPublish($arr);
						/* End Email to Helpdesk Executive */
						
					$msg="Event has been published successfully.!";	
					$this->session->set_flashdata('message', $msg);
					redirect('buyerApprover/createEvent/'.$auctionID);		
				}
				else
				{
					$msg="Event is saved successfully. EventID is '".$insetedid."' !";	
					$this->session->set_flashdata('message', $msg);
				        redirect('buyerApprover/savedEvents');		
				}	
			}
		}	
	}
	
	public function sendMailPublish($arr)
	{
		$html = '';
		$html .= 'Dear T M,<br/><br/>';
		$html .= 'This is to inform you that the e-Auction Event <strong>( '.$arr["event_title"].' )</strong> has been published on our Web Portal:<br/> <a href="https://www.c1india.com">https://www.c1india.com</a><br/><br/>';
		$html .= 'We would be intimating you in time-to-time as the e-Auction proceeds.<br/><br/>';
		$html .= 'You may also contact us by dialing <strong>+91-124-4302020 / 21 / 22 / 23 / 24</strong> or e-mail us to support@c1india.com for any kind of assistance/ suggestion.<br/><br/>';
		$html .= 'With regards,<br/>';
		$html .= '<span style="color: red;">e-Auction Support Team</span><br/>';
		$html .= '<a href="https://www.c1india.com">https://www.c1india.com</a><br/>';
		$html .= '0124-4302020 /2021/2022/2023/2024<br/><br/>';
		$html .= '<strong>This is an auto generated email; please do not reply.</strong>';
		
		$email = new email_new();
		//return $email->sendMailToUser($arr['email'],BRAND_NAME,$html);
		return true;
	}
	
	/**********************      eventTrack     ************************/	
	public function eventTrack($auction_id)
	{ 
		$data['heading']='Auction Tracker';
		$data['controller']='buyerApprover';
		
		$data['auction_data']=$this->buyer1_model->eventTrackData($auction_id);

		$auction_list=$this->buyer1_model->getBankerCreatedAuction($auction_id);
		if(!in_array($auction_id,$auction_list))
		{
			redirect('/buyerApprover');
		}
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityEventTrack', $data);
		$this->website_footer();
	}
	/**********************      eventTrack     ************************/
	/**********************      myActivity     ************************/

	/**********************      myProfile     ************************/
	public function myProfile()
	{
		$data['heading']='My Profile';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
        $response = $this->buyer1_model->myProfileUserData();
		$data['row'] = $response; 
		$this->load->view('banker_view/banker_myProfile', $data);
		$this->website_footer();
	}
        
    public function myProfileEdit()
    {    
        $data['heading']='Edit Profile'; 
        $response = $this->buyer1_model->myProfileUserData();
		$data['row'] = $response; 
		$data['controller']='buyerApprover';
		$this->banker_header();	
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
        $this->load->view('banker_view/banker_myProfileEdit', $data);
		$this->website_footer();
	}
        
    public function myProfileEditSave()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|xss_clean');
		
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
            redirect('buyerApprover/myProfileEdit');
        }
        else
        {
            $save = $this->buyer1_model->myProfileEditSaveData();
            if($save)
            {
                redirect('buyerApprover/myProfile');
            }
        }
    }
        
    public function myProfileChangePassword()
    {
        $data['heading']='Profile - Change Password'; 
        $response = $this->buyer1_model->myProfileUserData();
        $data['row'] = $response; 

        $data['controller']='buyerApprover';
        $this->banker_header();	
        $data['breadcrumb']='';
        $this->load->view('banker_view/banker_myProfileChangePasswod', $data);
        $this->website_footer();                
	}
        
	public function myProfileChangePasswordSave(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('o_password', 'Old Password', 'required');
		$this->form_validation->set_rules('n_password', 'New Password', 'required');
		$this->form_validation->set_rules('c_password', 'New Password', 'required');
	
		if($this->form_validation->run() == FALSE){

				$this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
				//echo $this->session->flashdata('message_validation');
				redirect('buyerApprover/myProfileChangePassword');
		}else{
			
			$o_password = $this->input->post('o_password');
			$n_password = $this->input->post('n_password');
			$c_password = $this->input->post('c_password');
			
			
			if ($o_password == $n_password) {				
                $this->session->set_flashdata('message_validation', "Error: Old and New Password cannot be same!");
                redirect('buyerApprover/myProfileChangePassword');
            }
			else if($n_password != $c_password){
				
				$this->session->set_flashdata('message_validation', "Error: New Password and Confirm Password should be same!");
				redirect('buyerApprover/myProfileChangePassword');
				
			}else{
				
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
					redirect('buyerApprover/myProfileChangePassword');
				}
				else
				{				
					$response = $this->buyer1_model->myProfileUserData();
					//echo $response['0']->password;
					
					if($response['0']->password != hash("sha256", $o_password)){
						
						$this->session->set_flashdata('message_validation', "Error: Old Password did not match!");
						redirect('buyerApprover/myProfileChangePassword');
						
					}else{
											$data['password']=hash("sha256", $n_password);
											$this->db->where('id', $this->session->userdata('id'));
											$this->db->update('tbl_user', $data);
											$this->session->set_flashdata('message_validation1', "Password Changed Successfully");
											//$data['password']=$n_password;
								   // $this->db->where('id', $this->session->userdata('id'));
						//$this->db->update('tbl_user', $data);
						 //redirect('buyer/myProfile');
											redirect('buyerApprover/myProfileChangePassword');
					}
				}
			}
			
			//redirect('buyer/myProfileChangePassword');
			
				//$save = $this->buyer1_model->myProfileEditSaveData();

				//if($save){
					//redirect('buyer/myProfile');
				//}
		}
	}
        
        
	/**********************      myProfile     ************************/
	function view_uploadedfile($auctionID){
		$auctionData			=	$this->buyer1_model->GetRecordByAuctionId($auctionID);
		$data['auctionData']	=	$auctionData;
                $data['bankData']	=	$this->buyer1_model->GetBanksData($auctionData->bank_id);
		$this->load->view('banker_view/banker_uploaded_file', $data);
		
	}
	
	function view_bid_history($auctionID){
		
		$auctionBiddingData			=	$this->buyer1_model->GetAuctionBidderHistoryData($auctionID);
		$data['auctionBiddingData']		=	$auctionBiddingData;
		$this->load->view('banker_view/banker_biddistory', $data);
	}
	
	function eventDetailbidderHole($auctionID){
		//$data['auction_detail']=$this->buyer1_model->auctionDetailPopupData($auctionID);
                $auctionData=$this->buyer1_model->auctionDetailPopupData($auctionID);
                $data['auction_detail']	=$auctionData;
                $data['bankData1']	=	$this->buyer1_model->GetBanksData($auctionData->bank_id);
		$this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
	}
	function eventDetailPopup($auctionID){
		$data['auction_detail']=$this->buyer1_model->auctionDetailPopupData($auctionID);
		$this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
	}

	function emdDetailPopup($bidderID,$auctionID){
		$data['base_url']= base_url();
		$data['emd']=$this->buyer1_model->emdDetailPopupData($bidderID,$auctionID);
                $data['bidderID']=$bidderID;
                $data['auctionID']=$auctionID;
                if(!empty($data['emd'])){
                   $type='check_emd';
                  $message='Buyer Viewed Bidder EMD Detail';
                  $this->buyer1_model->trackemdDetailPopupData($data,$type,$message);  
                }
		$this->load->view('banker_view/banker_myActivityTrackEmdPopup', $data);
	}
	
	function feedetail($bidderID,$auctionID){
		//$data['emd']=$this->buyer1_model->emdDetailPopupData($bidderID,$auctionID);
		$data['emd']=$this->buyer1_model->feeDetailPopupData($bidderID,$auctionID);
		
                $data['bidderID']=$bidderID;
                $data['auctionID']=$auctionID;
		$this->load->view('banker_view/banker_myActivityTrackFeePopup', $data);
	}	
	
	function bidderDetailPopup($bidderID,$auctionID){
		$data['array_records']=$this->buyer1_model->bidderDetailPopup($bidderID,$auctionID);
		//echo '<pre>';print_r($data['array_records']);
		$this->load->view('banker_view/banker_myActivityBidderPopup', $data);
	}
	
	function tenderfeeDetailPopup($bidderID,$auctionID){
		$data['base_url']= base_url();
		$data['tenderfee']=$this->buyer1_model->tenderfeeDetailPopupData2($bidderID,$auctionID);
              
                $data['emd'][0]=$this->buyer1_model->tenderfeeDetailPopupData2($bidderID,$auctionID);
		 if(!empty($data['emd'])){
                  $type='check_auction_fee';
                  $message='Buyer Viewed Tender Fee Detail';
                  $this->buyer1_model->trackemdDetailPopupData($data,$type,$message);  
                }
		$this->load->view('banker_view/banker_myActivityTrackTenderfeePopup', $data);
	}
	function docDetailPopup($bidderID,$auctionID){
		$data['base_url']= base_url();
		$data['doc']=$this->buyer1_model->docDetailPopupData($bidderID,$auctionID);
                $data['emd']=$this->buyer1_model->docDetailPopupData($bidderID,$auctionID);
		$data['auctionID']=$auctionID;
		$data['bidderID']=$bidderID;
                if(!empty($data['emd'])){
                  $type='check_documents';
                  $message='Buyer Viewed Bidder Document Detail';
                  $this->buyer1_model->trackemdDetailPopupData($data,$type,$message);  
                  }
		$this->load->view('banker_view/banker_myActivityTrackDocPopup', $data);
	}
	function ajaxbidActivity(){
		$activity_type=$this->input->post('activity_type');
		$auctionID=$this->input->post('auctionID');
		if($auctionID!='' &&  $activity_type!=''){
			$this->buyer1_model->ajaxbidActivity();	
		}else{
			echo "Sorry Require Fields Not Exist!";
		}
			
	}
	function createCorrigendum($auctionID){
		
			$auction_list=$this->buyer1_model->getBankerCreatedAuction($auctionID);
			if(!in_array($auctionID,$auction_list))
			{
				redirect('/buyerApprover');
			}
			
		$this->load->library('form_validation');
		$submit = $this->input->post('submit');
		if(isset($submit) && $submit=='Submit')
		{
			
			$this->form_validation->set_rules('remarks', 'remarks', 'trim|required|xss_clean');
			if($this->form_validation->run() == FALSE){
				$msg="Please Enter Require fields.!";
			}
			else
			{
				if($this->input->post('remarks')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('remarks'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				
				
				if($this->input->post('press_release_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('press_release_date'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('inspection_date_from')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('inspection_date_from'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('inspection_date_to')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('inspection_date_to'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('bid_last_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('bid_last_date'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('bid_opening_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('bid_opening_date'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('auction_start_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auction_start_date'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				if($this->input->post('auction_end_date')!= ''){$checkHTMLTags=$this->buyer1_model->checkHTMLTags($this->input->post('auction_end_date'));if($checkHTMLTags == "1"){$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");redirect('buyerApprover/createCorrigendum/'.$auctionID);}}
				
				
				if($_FILES['supporting_doc1']['name']!= "")
				{
					$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['supporting_doc1']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
							redirect('buyerApprover/createCorrigendum/'.$auctionID);			
					  }		
				}
				if($_FILES['related_doc']['name']!= "")
				{
					$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['related_doc']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
							redirect('buyerApprover/createCorrigendum/'.$auctionID);			
					  }		
				}
				if($_FILES['image']['name']!= "")
				{
					$checkMultipleExtension=$this->buyer1_model->checkMultipleExtension($_FILES['image']['name']);
					  if($checkMultipleExtension == 'mul')
					  {
							$this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
							redirect('buyerApprover/createCorrigendum/'.$auctionID);			
					  }		
				}
				
				
				$insetedid=$this->buyer1_model->saveCorrigendum();
				$msg="Event has been updated successfully.!";	
				$this->session->set_flashdata('message', $msg);
				redirect('buyerApprover/createCorrigendum/'.$auctionID);			
			}
		}
		$arows	=	 $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
		$data['corrigendumID']	=	 GetTitleByField('tbl_auction_corrigendum','auctionID='.$auctionID,'id');
		$data['heading']='Corrigendum';
		$data['controller']='buyerApprover';
		$data['auctionID']=$auctionID;
		$data['auctionData']=$arows;
		//$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		//$data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
		$this->banker_header();
		$data['doc']=$this->buyer1_model->docDetailPopupData($auctionID);
		if(strtotime($arows->auction_end_date) > time() && $arows->status != 6 && $arows->status != 7)
		{
			$this->load->view('banker_view/banker_myActivityCreateCorrigendum', $data);
		}
		else
		{
			redirect("/registration/banker_login");
			
		}
		$this->website_footer();
	}
	
	function firstOpnerVerification()
	{
		$this->load->library('form_validation');
		$submit = $this->input->post('submit');
		$auctionID = $this->input->post('auctionID');
		if(isset($submit))
		{
	
			
				$insetedid=$this->buyer1_model->saveFirstOpnerVerification();
				//$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
				//$this->session->set_flashdata('message', $msg);
						
					
			
		}
		redirect('buyerApprover/eventTrack/'.$auctionID);
	}
	function secondOpnerVerification(){
		$this->load->library('form_validation');
		$submit = $this->input->post('submit');
		$auctionID = $this->input->post('auctionID');
		if(isset($submit))
		{
	
			$insetedid=$this->buyer1_model->saveSecondOpnerVerification();
				//$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
				//$this->session->set_flashdata('message', $msg);
			
		}
		redirect('buyerApprover/eventTrack/'.$auctionID);
	}
	
	function viewCorrigendum($auctionID){
		$data['corrigendum']=$this->buyer1_model->viewCorrigendumPopupData($auctionID);
		$this->load->view('banker_view/banker_myActivityAuctionCorrigendumPreviewPopup', $data);
	}
	function previewAuctionDetail($auctionID){
		$data['auction_data']=$this->buyer1_model->previewAuctionDetailPopupData($auctionID);
		$this->load->view('banker_view/banker_myActivityAuctionDataPreviewPopup', $data);
	}
	function concludeEvent($auctionID){
		echo $this->buyer1_model->concludeEvent($auctionID);
	}
	
	function liveBiddingAuctionsdatatable($id)
	{		 
		$data['heading']='List Live Auctions';
		$data['controller']='buyerApprover';
		//$auctionData=$this->buyer1_model->getBankersLiveAuctionList($id);
		$auctionData=$this->buyer1_model->getBankersLiveAuction10SecondList($id);
		$data['auctionData']=$auctionData;
		echo $this->load->view('banker_view/live_bidding_auction_list', $data,true);
	}
        
        /**********************    Start  myMessage     ************************/
        
	public function myMessage(){
            
            if($this->input->post('mark_as_read')){
                
                //echo '<pre>', print_r($this->input->post('status')), '</pre>';
                
                if(($this->input->post('status'))){
                
                    $status = $this->input->post('status');

                    foreach($status as $status_id){

                        //echo '<br />'.$status_id;
                        $data['msg_status']=1;
                        $this->db->where('id', $status_id);
                        $this->db->update('tbl_message', $data);
                    }

                }else{
                
                    $this->session->set_flashdata('message_validation', "Error: Kindly select any one.");
                }
                
                redirect('buyerApprover/myMessage');
            }
            
            if($this->input->post('delete_all'))
            {
                if(($this->input->post('status'))){
                
                    $delete = $this->input->post('status');

                    foreach($delete as $delete_id){

                        //echo '<br />'.$status_id;
                        $data['status']=5;
                        $this->db->where('id', $delete_id);
                        $this->db->update('tbl_message', $data);
                    }
                }else{
                
                    $this->session->set_flashdata('message_validation', "Error: Kindly select any one.");
                }
                
                redirect('buyerApprover/myMessage');
            }
            
		$data['heading']='My Message';
		$data['controller']='buyerApprover';
		$this->banker_header();
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
                
                $total_record = $this->buyer1_model->GetCITotalRecord(); 
                
                //echo '<pre>', print_r($total_record), '</pre>';
                
                $data['records'] = $total_record; 
                
		$this->load->view('banker_view/banker_myMessage', $data);
                
		$this->website_footer();
	}
        
        public function myMessage_reply_msg($param){
            
            if(is_numeric($param)){
                    $data['heading']='Reply Message'; 
                    $message_id = $param;
            }else{
                    $data['heading']='Add Message'; 
            }

            if($message_id){
                    $array_records = $this->buyer1_model->GetRecordById($message_id);
            }else{
                    $array_records=array();
            }

            $data['row'] = $array_records; 

            $data['get_user_data'] = $this->buyer1_model->GetUserData();
            $message = $this->buyer1_model->GetParentRecordsControl();
            $data['message'] = $message; 

            $this->banker_header();	
            $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
            $data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
            $this->load->view('banker_view/add-edit-myMessage', $data);
            $this->website_footer();
	}
        
        public function myMessage_new($param){
            
            $data['heading']='New Message'; 
            $data['controller']='buyerApprover';
            $data['row'] = $array_records; 

            $message = $this->buyer1_model->GetParentRecordsControl();
            $data['message'] = $message; 

            $data['get_user_data'] = $this->buyer1_model->GetUserData();

            $this->banker_header();	
            $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
            $data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
            $this->load->view('banker_view/add-edit-myMessage', $data);
            $this->website_footer();
	}
        
        public function myMessage_save(){
            
            $id = $this->input->post('id');
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('msg_to', 'To', 'trim|required|xss_clean');
            $this->form_validation->set_rules('msg_body', 'Message', 'trim|required|xss_clean');

            if($this->form_validation->run() == FALSE){
                
                $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
                //echo $this->session->flashdata('message_validation');
                
                if(!empty($id)){
                    
                    redirect('buyerApprover/myMessage_reply_msg/'.$id);
                    
                }else{
                    
                    redirect('buyerApprover/myMessage_new');
                }

            }else{
                
                $save = $this->buyer1_model->myMessage_save_message_data();

                if($save){
                    redirect('buyerApprover/myMessage');
                }
            }	
	}
        
        function myMessage_autocomplete(){
            
            $data = $this->buyer1_model->myMessage_get_autocomplete();
            //echo "<select>";
            
            if($data){
                foreach($data as $row):
                    //echo "<option id='$row->id' value=\"$row->id\" onclick=\"fill('$row->first_name $row->last_name ($row->email_id)')\">".$row->first_name." ".$row->last_name." (".$row->email_id.")</option>";
                    echo "<li id='$row->id' value=\"$row->id\" onclick=\"fill('$row->id', '$row->first_name $row->last_name ($row->email_id)')\">".$row->first_name." ".$row->last_name." (".$row->email_id.")</li>";
                endforeach;
            }
            //echo "</select>";
        }
        
        
        public function myMessage_delete_msg($id){
            
            //echo $id;
            //$data['date_modified']=date('Y-m-d H:i:s');
            
            $data['status']=5;
            $this->db->where('id', $id);
            $this->db->update('tbl_message', $data);
            redirect('buyerApprover/myMessage');  
	}
        
        public function myMessageUser(){
            
            $data['heading']='My User Message'; 
            $message_id = $param;
            $data['row'] = $array_records; 

            //$data['get_user_data'] = $this->buyer1_model->GetUserData();
            $message = $this->buyer1_model->GetUserTotalRecord();
            $data['records'] = $message; 
            $this->banker_header();	
            $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
            $data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
            $this->load->view('banker_view/banker_myMessageUser', $data);
            //$this->load->view('banker_view/banker_myActivity', $data);
            $this->website_footer();
	}
        
        public function myMessageTrash(){
            
            $data['heading']='My Trash Message'; 
            $message_id = $param;
            $data['row'] = $array_records; 
            $message = $this->buyer1_model->GetTrashTotalRecord();
            $data['records'] = $message; 
            $this->banker_header();	
            $data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
            $data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
            $this->load->view('banker_view/banker_myMessageTrash', $data);
            $this->website_footer();
	}
        
	/**********************     End myMessage     ************************/
        
    function checkMail($auctionID)
    {
			
		// Start:Email Code
             
                $this->load->library('Email_new','email');

				$subject = 'BOM Vs Mrs.Tania Raha & Shri Dipak Raha: Provide necessary training to Qualified Bidders to participate in e-Bidding Process ';
				
				
				$html = '';
				$html .= 'To<br/>';
				$html .= 'The Help Desk,<br/>';
				$html .= BRAND_NAME.' Division,<br/>';
				//$html .= 'C1 India Pvt. Ltd.<br/><br/>';
				
				$html .= 'The following bidders have been qualified by bank to participate in the e-Bidding Process. Therefore, request you to do the needful to provide them necessary training on e-Auction.<br/><br/>';
				
				if($auctionID != '')
				{
					$this->db->where('auctionID =', $auctionID);
	
					$query = $this->db->get("tbl_auction_participate");
					$data = array();
					if ($query->num_rows() > 0) 
					{
						foreach ($query->result() as $row) 
						{
							//$row->user_id=$this->GetAssignedUser($row->id);
							$datam = $this->getUserValue($row->bidderID);
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
								}
								else
								{
									$html .= 'Qualified.: NO<br/>';
								}	
								$html .= 'Comment.: '.$row->operner2_comment.'<br/>';
							}else{
								if($row->operner1_accepted == '1')
								{
									$html .= 'Qualified.: YES<br/>';
								}
								else
								{
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
				$html .= 'Branch: '.$this->getBranchName($auctionID).'<br/>';
				$html .= 'City: '.$this->getCityName($auctionID).'<br/><br/>';
				
				
				$html .= '<strong>This is an auto generated email; please do not reply.</strong>';	
				
				//echo $html;die;
				$email = new email_new();
				//$email->sendMailToUser(array('darpan.kumar@c1india.com'),'BankeAuction Helpdesk',$html);
	
	}
	
	function showbranchdata(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$catArr=$this->helpdesk_executive_model->GetBranchdata($bankid);
			$str='<option value="">Select Bank Branch</option>';
			if(count($catArr)>0){
				foreach($catArr as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$str.='<option '.$selected.' value="'.$row->id.'">'.$row->name.'</value>';
		
				}
			}
		echo $str;
		}
		
	}
	
	function showBankUserListdata(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$banksUsersList	 =	 $this->helpdesk_executive_model->getUserByBankId($bankid);			
			$str='<option value="">Select</option>';
			if(count($banksUsersList)>0){
				foreach($banksUsersList as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$option = $row->email_id.", ".$row->user_id.", ".ucfirst($row->first_name)." ".$row->last_name;
					$str.='<option '.$selected.' value="'.$row->id.'">'.$option.'</value>';
		
				}
			}
			echo $str;
		}
		
	}
	
	function showBankUserListdata1(){
		$bankid=$this->input->post('bankid');		
		if($bankid)
		{
			$banksUsersList					=	 $this->helpdesk_executive_model->getUserByBankId($bankid);			
			$str='';
			if(count($banksUsersList)>0){
				foreach($banksUsersList as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$option = $row->email_id.", ".$row->user_id.", ".ucfirst($row->first_name)." ".$row->last_name;
					$str.='<option '.$selected.' value="'.$row->id.'">'.$option.'</value>';
		
				}
			}
		echo $str;
		}
		
	}
	
	public function getUserValue($userid){
           
			$this->db->where('id', $userid);
     
            $query = $this->db->get("tbl_user_registration");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
			}
			return false;
        }
        
    public function getBranchName($auctionID){
           
           
           $this->db->where('id', $auctionID);
           $query = $this->db->get("tbl_auction");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $bankid = $row->branch_id;
                    }
			}
			
			
			$this->db->where('id', $bankid);
     
            $query1 = $this->db->get("tbl_branch");
            //echo $this->db->last_query();

			$data = array();
			if ($query1->num_rows() > 0){
                    
                    foreach ($query1->result() as $row1) {
                        $bankname = $row1->name;
                    }
                    return $bankname;
			}
			return false;
    }
    
    public function getCityName($auctionID){
           
           
           $this->db->where('id', $auctionID);
           $query = $this->db->get("tbl_auction");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $cityid = $row->city;
                        $otherCity = $row->other_city;
                        
                    }
			}
			
			if(isset($otherCity) && $otherCity!='')
			{
				return $otherCity;
			}
			
			$this->db->where('id', $cityid);
     
            $query1 = $this->db->get("tbl_city");
            //echo $this->db->last_query();

			$data = array();
			if ($query1->num_rows() > 0){
                    
                    foreach ($query1->result() as $row1) {
                        $city_name = $row1->city_name;
                    }
                    return $city_name;
			}
			return false;
    }
    
	/**********************      Report     ************************/
	function viewReport($auctionID)
	{
            $data['heading']='Auction Report';
            $data['controller']='buyerApprover';
            $data['auction_data']=$this->buyer1_model->viewReport($auctionID);
            // echo '<pre>';
           // print_r($data); die();
            //Track Bidder View Report start
            $trackreportdata=array('event_id'=>$data['auction_data'][0]->eventID,
                                       'auction_id'=>$auctionID,
                                       'bidder_id'=>$this->session->userdata('id'),
                                       'bank_id'=>$data['auction_data'][0]->bank_id,
                                       'user_type'=>$this->session->userdata('user_type'),
                                       'action_type'=>"Bank_auction_report",
                                       'action_type_event'=>"view",
                                       'ip'=>$_SERVER['REMOTE_ADDR'],
                                       'status'=>'1',
                                       'message'=>'Buyer has successfully viewed Auction report',
                                       'indate'=>date('Y-m-d H:i:s'),
                                        );
            $query_log = $this->db->insert("tbl_log_all_report_track",$trackreportdata);
           //Track Bidder View Report End
            $data['BidderRankData']=$this->buyer1_model->getBidderRank($auctionID);
            $data['auctionID']=$auctionID;
            $this->banker_header();
            //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
            //$data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);

            $this->load->view('banker_view/banker_myActivityTrackReport', $data);
            $this->website_footer();
	}
	/**********************  End Report     ************************/
	
	
	public function page_popup($product_id)
	{   $this->load->view('admin/header-popup', $data);
		$data['heading']	=	'Product Images'; 
		$array_records 		= 	$this->product_image_model->GetRecordByArticleId($product_id);
		$data['product_id'] = 	$product_id;
		$data['records'] 	= 	$array_records; 
		$this->load->view('product-image', $data);
	}
	
	public function invoice_mail_to_user($bankID)
	{	
		//$banksUsersList	= $this->helpdesk_executive_model->eventBankUserList('branch','',$bankID);
		
		$banksUsersList	= $this->helpdesk_executive_model->getUserByBankId($bankID);
		foreach($banksUsersList as $urow)
		{    
			if($urow->id==$invoice_mail_to){$strc='disabled="disabled"';}else{$strc='';}
			$str.="<option ".$strc." value='$urow->id'>".$urow->email_id.",  ".$urow->user_id.", ".ucfirst($urow->first_name)."  ".$urow->last_name."</option>";
		}
		echo $str;
	}

	public function setopeningprice()
	{	
		$str = $this->buyer1_model->setopeningprice();
               echo $str;
	}
	
	public function movetosecondopener()
	{	
		$str = $this->buyer1_model->movetosecondopener();
		echo $str;
	}
	
	public function open_price_bid1()
	{	
		$str = $this->buyer1_model->open_price_bid1();
		echo $str;
	}
	function showsubcategorydata(){
		$category=$this->input->post('category');
		$subcate=$this->input->post('subcate');
		if($category)
		{
			$catArr=$this->helpdesk_executive_model->GetsubCategorydata($category);
			$str='<option value="">Select Sub Category</option>';
			if(count($catArr)>0){
				foreach($catArr as $row)
				{
					$selected=($row->id==$subcate)?'selected':'';
					$str.='<option '.$selected.' value="'.$row->id.'">'.$row->name.'</value>';
		
				}
			}
		echo $str;
		}
		
	}
}
?>
