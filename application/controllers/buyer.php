<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Buyer extends WS_Controller {

    public function __Construct() {
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
        $this->load->library('Email_new', 'email');
        $this->load->database();
        $this->load->helper(array('form'));
        $this->load->model('banker_model');

        $this->load->model('owner_model');
        $this->load->model('product_image_model');
        $this->load->model('admin/bank_model');
        $this->load->model('admin/dynamic_form_model');
        $this->load->model('helpdesk_executive_model');
        $this->check_isvalidated();
        /* run auction completed script */
        $this->load->model('account_model');
        $this->account_model->completedAuctionScript();
        /* end run auction completed script */
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
        $this->output->set_header('Pragma: no-cache');

        // checking sso login 
        $this->banker_model->check_sso_login();
    }

    public function index() {
        $userType = array("buyer");
        //echo $this->session->userdata('user_type');die;
        if (!$this->session->userdata('id') || !in_array($this->session->userdata('user_type'), $userType)) {
            redirect('/registration/logout');
        }
        $this->myActivity();
        //$this->page($page_no);
    }

    private function check_isvalidated() {

        $method = $this->router->fetch_method();

        $res = $this->banker_model->checkPageBidderPermission($method);

        if (!$res && $method != 'myActivity') {
            redirect('/buyer/myActivity');
        }

        if ($this->session->userdata('id') && ($this->session->userdata('user_type') == 'buyer')) {
            
        } else {
            redirect('/registration/logout');
        }
    }

    public function dashboard() {
        $data['heading'] = 'Create Auction ';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $dashboardData = $this->banker_model->dashboardData();
        $auctionConductedbyCategories = $this->banker_model->auctionConductedbyCategories();
        $category = $this->owner_model->GetPopularPropertyType();
        $data['dashboardData'] = $dashboardData;
        $data['auctionConductedbyCategories'] = $auctionConductedbyCategories;
        $data['getpopular'] = $category;
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $this->load->view('banker_view/banker_dashboard', $data);
        $this->website_footer();
    }

    function ajaxdashboard() {
        $DashboardData = $this->banker_model->ajaxDashboardData();
        echo json_encode($DashboardData);
    }

    /*     * ********************      myActivity     *********************** */

    public function myActivity() {
        $data['heading'] = 'My Activity';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivity', $data);
        $this->website_footer();
    }

    function liveEventsdatatable() {
        echo $this->banker_model->liveEventsdatatable();
    }

    function liveUpcomingAuctionsdatatable() {
        echo $this->banker_model->liveUpcomingAuctionsdatatable();
    }

    function bids_to_be_openeddatatable() {
        echo $this->banker_model->bids_to_be_openeddatatable();
    }

    public function savedEvents() {
        $data['heading'] = 'Saved Auction';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivitySavedEvents', $data);
        $this->website_footer();
    }

    function saveEventsdatatable() {
        echo $this->banker_model->saveEventsdatatable();
    }

    function rejectedEventsdatatable() {
        echo $this->banker_model->rejectedEventsdatatable();
    }

    function approvelRejectionEventsdatatable() {
        echo $this->banker_model->approvelRejectionEventsdatatable();
    }

    public function liveEvent() {
        $data['heading'] = 'Live Auction';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityLiveEvent', $data);
        $this->website_footer();
    }

    function liveEventdatatable() {
        echo $this->banker_model->liveEventdatatable();
    }

    public function liveAuctions() {
        $data['heading'] = 'Live Auctions';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityLiveAuctions', $data);
        $this->website_footer();
    }

    function liveAuctionsdatatable() {
        echo $this->banker_model->liveAuctionsdatatable();
    }

    public function listLiveAuctions($aid) {
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'buyer';
        $this->banker_header();
        //$auctionData=$this->banker_model->getBankersLiveAuctionList($aid);
        $auctionData = $this->banker_model->getBankersLiveAuction10SecondList($aid);
        $data['auctionData'] = $auctionData;
        $data['auctionId'] = $aid;
        $this->load->view('banker_view/banker_myActivityListLiveAuction', $data);
        $this->website_footer();
    }

    public function bidsToBeOpened() {
        $data['heading'] = 'Shortlisting For Bidding Room';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityBidsToBeOpened', $data);
        $this->website_footer();
    }

    function bidsToBeOpeneddatatable() {
        echo $this->banker_model->bidsToBeOpeneddatatable();
    }

    public function completedEvents() {
        $data['heading'] = 'Create Auction';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityCompletedEvents', $data);
        $this->website_footer();
    }

    function completedAuctionsdatatable() {
        echo $this->banker_model->completedAuctionsdatatable();
    }
    
    public function archive_auctions() {
        $data['heading'] = 'Archive Auction';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/archive_auctions', $data);
        $this->website_footer();
    }

    function awarded_list() {
        echo $this->banker_model->awarded_list();
    }
    
    function not_awarded_list() {
        echo $this->banker_model->not_awarded_list();
    }

    function concludeCompletedAuctionsdatatable() {
        echo $this->banker_model->concludeCompletedAuctionsdatatable();
    }

    function completedEventsdatatable() {
        echo $this->banker_model->completedEventsdatatable();
    }

    function canceleddatatable() {
        echo $this->banker_model->canceleddatatable();
    }

    function movetoauction1() {

        echo $this->banker_model->movetoauction1();
    }

    function movetoauction() {
        echo $this->banker_model->movetoauction();
    }

    public function corrigendum() {
        $data['heading'] = 'Corrigendum List';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityCorrigendum', $data);
        $this->website_footer();
    }

    function corrigendumdatatable() {
        echo $this->banker_model->corrigendumdatatable();
    }

    public function MISReport() {
        $data['heading'] = 'Create Auction';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $bank_id = $this->session->userdata('bank_id');
        $branch_id = $this->session->userdata('branch_id');
        $userid = $this->session->userdata('id');
        //Track Bidder View Report start
        $trackreportdata = array(
            'event_id' => '',
            'auction_id' => '',
            'bidder_id' => $this->session->userdata('id'),
            'bank_id' => $bank_id,
            'user_type' => $this->session->userdata('user_type'),
            'action_type' => "Bank_mis_report",
            'action_type_event' => "view",
            'ip' => $_SERVER['REMOTE_ADDR'],
            'status' => '1',
            'message' => 'Buyer has successfully viewed MIS Report',
            'indate' => date('Y-m-d H:i:s'),
        );
        $query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);

        $this->load->view('banker_view/banker_myActivityMISReport', $data);
        $this->website_footer();
    }

    public function bankerEventMISReport() {
        echo $this->banker_model->bankerEventMISReport();
    }

    public function bankerDrtEventMISReport() {
        echo $this->banker_model->bankerDrtEventMISReport();
    }

    ##### Added by Azizur rahman ###########################################

    function viewEvent($eid) {
        $action = $this->input->get('action');

        $data['heading'] = 'Create Auction';
        $data['controller'] = 'buyer';
        $data['utype'] = "creator";

        $this->banker_header();

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
        $category = $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction

        $uploadedDocs = $this->bank_model->GetUploadedDocsByAuctionId($eid);
        $zoneArr = $this->bank_model->GetZoneData();
        $approverArr = $this->bank_model->getApproverData();
        if ($eid != '') {
            $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($eid); // New Add from createEventAuction
        }
        $data['document_list'] = $document_list;  // New Add  from createEventAuction
        $data['auctionData'] = $auctionData; // New Add  from createEventAuction
        $data['banks'] = $banks; // New Add  from createEventAuction
        $data['category'] = $category; // New Add  from createEventAuction
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


        $data['banksUsersSecondOpener'] = $this->helpdesk_executive_model->getUserByBranchId($branch_id);

        //$this->load->view('banker_view/banker_myActivityCreateEvent', $data);
        //$this->load->view('banker_view/banker_create_event_step1',$data);
        $this->load->view('banker_view/banker_view_event_step3', $data);
        $this->website_footer();
    }

    function createEvent($eid) { 
       

        $action = $this->input->get('action');

        $data['heading'] = 'Create Auction';
        $data['controller'] = 'buyer';
        $data['utype'] = "creator";

        $this->banker_header();

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
        $category = $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction

        $uploadedDocs = $this->bank_model->GetUploadedDocsByAuctionId($eid);
        $zoneArr = $this->bank_model->GetZoneData();
        $approverArr = $this->bank_model->getApproverData();
        if ($eid != '') {
            $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($eid); // New Add from createEventAuction
        }
        $data['document_list'] = $document_list;  // New Add  from createEventAuction
        $data['auctionData'] = $auctionData; // New Add  from createEventAuction
        $data['banks'] = $banks; // New Add  from createEventAuction
        $data['category'] = $category; // New Add  from createEventAuction
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


        $data['banksUsersSecondOpener'] = $this->helpdesk_executive_model->getUserByBranchId($branch_id);

        //$this->load->view('banker_view/banker_myActivityCreateEvent', $data);
        //$this->load->view('banker_view/banker_create_event_step1',$data);
        $this->load->view('banker_view/banker_create_event_step3', $data);
        $this->website_footer();
    }

    function approveRejectEvent($eid) {
        $action = $this->input->get('action');

        $data['heading'] = 'Approve/Reject Auction';
        $data['controller'] = 'buyer';
        $data['utype'] = "approver";

        $this->banker_header();

        $bankID = $this->session->userdata['bank_id'];
        $userID = $this->session->userdata['id'];
        $branch_id = GetTitleByField('tbl_user', "id='" . $userID . "'", 'user_type_id');
        $arows = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);

        //$banksUsersList		=	 $this->helpdesk_executive_model->eventBankUserList($utype,$branch_id,$bankID);		
        $banksUsersList = $this->helpdesk_executive_model->getUserByBankId($bankID);
        $document_list = $this->helpdesk_executive_model->document_list(); // New Add from createEventAuction
        $auctionData = $this->helpdesk_executive_model->GetAution4ApprovalbyId($eid); // New Add from createEventAuction
        $banks = $this->bank_model->GetBankRecords(); // New Add from createEventAuction

        $accountType = $this->bank_model->GetAccountTypeRecords();
        $uomType = $this->bank_model->GetUOMtypeRecords();
        $heightUomType = $this->bank_model->GetHeightUOMtypeRecords();
        $upload_document_field = $this->bank_model->GetUploadDocumentFieldRecords();
        $category = $this->helpdesk_executive_model->GetCategorylist(); // New Add from createEventAuction

        $uploadedDocs = $this->bank_model->GetUploadedDocsByAuctionId($eid);
        $zoneArr = $this->bank_model->GetZoneData();
        $approverArr = $this->bank_model->getApproverData();
        if ($eid != '') {
            $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($eid); // New Add from createEventAuction
        }

        $data['document_list'] = $document_list;  // New Add  from createEventAuction
        $data['auctionData'] = $auctionData; // New Add  from createEventAuction
        $data['banks'] = $banks; // New Add  from createEventAuction
        $data['category'] = $category; // New Add  from createEventAuction
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



        $data['banksUsersSecondOpener'] = $this->helpdesk_executive_model->getUserByBranchId($branch_id);

        //$this->load->view('banker_view/banker_myActivityCreateEvent', $data);
        //$this->load->view('banker_view/banker_create_event_step1',$data);
        $this->load->view('banker_view/banker_create_event_step3', $data);
        $this->website_footer();
    }

    // Step 2 to Step 3 Click
    function createEventAuction($aid) {
        /*
          $auction_list=$this->banker_model->getBankerCreatedAuction($aid);
          if(!in_array($aid,$auction_list))
          {
          redirect('/buyer');
          }
         */
        $submit = $this->input->post('Save');
        if (isset($submit)) {
            $this->load->library('form_validation');
            $productID = $this->input->post('productID');
            $auctionID = $this->input->post('auctionID');
            $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address', 'address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('type', 'type', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $msg = "Please Enter Require fields.!";
            } else {
                $erows = $this->banker_model->createEventdatastep2();
                redirect('buyer/createEventAuction/' . $auctionID);
            }
        }

        $data['heading'] = 'Create Event Auction';
        $this->banker_header();
        $data['controller'] = 'buyer';
        $banks = $this->bank_model->GetBankRecords();
        $category = $this->helpdesk_executive_model->GetCategorylist();
        $utype = "branch";
        $userID = $this->session->userdata['id'];
        $branch_id = GetTitleByField('tbl_user', "id='" . $userID . "'", 'user_type_id');
        $bank_id = GetTitleByField('tbl_user', "id='" . $userID . "'", 'bank_id');
        $banksUsersList = $this->helpdesk_executive_model->eventBankUserList('branch', $branch_id);
        $biddersrow = $this->helpdesk_executive_model->getAllBiidersList();
        $document_list = $this->helpdesk_executive_model->document_list();
        $auctionData = $this->helpdesk_executive_model->GetAutionbyId($aid);
        $data['bankbranch'] = $this->helpdesk_executive_model->GetBranchdata($banks_id);
        $data['banksUsersList'] = $banksUsersList;
        $data['biddersrow'] = $biddersrow;
        $data['banks'] = $banks;
        $data['auctionID'] = $aid;
        $data['category'] = $category;
        $data['document_list'] = $document_list;
        $data['auctionData'] = $auctionData;
        $arows = $this->helpdesk_executive_model->GetAutionRecordById($aid);
        $auctionID = $arows->id;
        $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($aid);

        if (true) {
            $data['drtEvent'] = true;
        }

        $data['prows'] = $prows;
        $this->load->view('banker_view/banker_create_event_step3', $data);
        $this->executive_footer();
    }

    function createEventproperty($eid) {
        /*
          $auction_list=$this->banker_model->getBankerCreatedAuction($eid);
          if(!in_array($eid,$auction_list))
          {
          redirect('/buyer');
          }
         */
        $submit = $this->input->post('submit');
        if (isset($submit)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('bankuser', 'bankuser', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $msg = "Please Enter Require fields.!";
            } else {
                $auctionID = $this->banker_model->createEventdatastep1();
                redirect('buyer/createEventproperty/' . $auctionID);
            }
        }
        $data['heading'] = 'Create Event Property';
        $this->banker_header();
        $data['controller'] = 'buyer';
        //$erows=$this->helpdesk_executive_model->GetAutionRecordByAuctionId($eid);
        $category = $this->helpdesk_executive_model->GetCategory();
        $prows = $this->helpdesk_executive_model->GetProductDetailByeventID($eid);
        $data['category'] = $category;
        $data['auctionID'] = $eid;
        $countries = $this->bank_model->GetCountries();
        $data['countries'] = $countries;
        $states = $this->bank_model->GetState();
        $data['states'] = $states;
        $cities = $this->bank_model->GetCity();
        $data['cities'] = $cities;
        $data['prows'] = $prows;
        $attr_records = $this->dynamic_form_model->GetAttributeValue($prows->id);
        $data['attr_records'] = $attr_records;
        $this->load->view('banker_view/banker_create_event_step2', $data);
        $this->executive_footer();
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

    public function ajaxFormData($category_id = '', $product_id = '') {
        $records = $this->helpdesk_executive_model->GetRecordByCategory($category_id, $is_auction = 'auction', $is_bank = 'bank', $is_sell = 'sell');
        if ($product_id) {
            $detail_records = $this->helpdesk_executive_model->GetProductDetail($product_id);
            $attr_records = $this->helpdesk_executive_model->GetAttributeValue($product_id);
        }
        $data['records'] = $records;
        $data['detail_records'] = $detail_records;
        $data['attr_records'] = $attr_records;
        $this->load->view('ajaxFormData', $data);
    }

    public function getsubcategory($category) {
        $subCategory = $this->helpdesk_executive_model->GetSubCategory($category);
        $str = '<option value="">Select Subcategory</option>';
        foreach ($subCategory as $subCategory_record) {
            $str .= "<option value='$subCategory_record->id'>" . $subCategory_record->name . "</option>";
        }
        echo $str;
    }

    function publishApprovedData($param1 = NULL) {

        $auctionID = $param1;
        $publish = $this->input->post('Publish');
        $status = 1;

        $this->db->where('id', $auctionID);
        $update = $this->db->update('tbl_auction', array('status' => $status));
        
        $this->db->where('id', $auctionID);
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
			$datalog['auction_id'] = $auctionID;
			$datalog['ip'] = $_SERVER['REMOTE_ADDR'];		
			$datalog['indate'] = date('Y-m-d H:i:s');;		
			$this->db->insert('tbl_log_auction',$datalog);
		}
			
		#Start: Send mail to creator after publishing auction ##Added by aziz
		
		$this->load->library('Email_new', 'email');
		$email = new email_new();
		
		//send mail to approver
		$mail = $email->sendMailToApproverAfterPublishingAuctionByCreator($auctionID);
		
		//send mail to document approver
	    $mail1= $email->sendMailToDocumentVarifierFinalApproverAfterPublishingAuctionByCreator($auctionID);
        
        if ($update) {
			
			// Add/Update data in elastic search engine
			$this->load->model('elastic_model');		
			$res = $this->elastic_model->property($insertedid_id);
			
            $msg = "Auction has been published successfully.";
            $this->session->set_flashdata('message', $msg);
            redirect('buyer/liveEvent', 'refresh');
        }
		
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

        $this->form_validation->set_rules('account', 'Institution', 'trim|required|xss_clean');
        $this->form_validation->set_rules('reference_no', 'Auction Reference No', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area', 'Property Area', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area_unit_id', 'Area Unit', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category_id', 'Category/ Property Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contact_person_details_1', '1st Contact Person Details', 'trim|required|xss_clean');
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
				redirect('buyer/createEvent/'.(int)$auctionID);
			}
		}          
        else if ($send4Approval) {
            $this->form_validation->set_rules('zone_id', 'Concerned Zone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reserve_price', 'Bid Start Price (BSP)', 'trim|required|xss_clean');
            $this->form_validation->set_rules('unit_id_of_price', 'BSP Unit of Price', 'trim|required|xss_clean');
            $this->form_validation->set_rules('emd_amt', 'EMD Amount', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tender_fee', 'Participation Fee', 'trim|required|xss_clean');
            $this->form_validation->set_rules('press_release_date', 'press_release_date', 'trim|required|xss_clean');
           // $this->form_validation->set_rules('inspection_date_from', 'Site Visit Start Date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('inspection_date_to', 'Site Visit End Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('registration_start_date', 'Apply And EMD Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bid_last_date', 'Apply And EMD End Date', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('bid_opening_date', 'Shortlisting Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('auction_start_date', 'auction_start_date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('auction_end_date', 'auction_end_date', 'trim|required|xss_clean');
            
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
			if(!is_numeric($this->input->post('tender_fee')))
			{
				$errflg = 1;
				$this->session->set_flashdata("parf", "Please Enter Valid Participation Fee!");
              
			}
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
			/*
			if($inspection_date_to>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be less than Auction Start date or time!");
            }*/
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
				$this->session->set_flashdata("aeed", "Apply And EMD End Date time should be greater than Apply And EMD Start Date time!");
                
			}
			if($registration_start_date>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("asdt", "Auction Start Date time should be greater than Apply And EMD Start Date time!");
                
			}			
			if($bid_last_date>=$auction_end_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("aedt", "Auction End Date time should be greater than Apply And EMD End Date time!");
               
			}
			
			if(($this->input->post('auto_extension')>0 && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')) || ($this->input->post('auto_extension') =='' && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')))
			{
				$errflg = 1;
				$this->session->set_flashdata("aetm", "Please Enter Valid Auto Extension Time!");
               
			}
			
			if($errflg==1)
			{
				 redirect('buyer/createEvent');
			}
        }

        if ($this->form_validation->run() == FALSE) {
            //echo validation_errors();die;
            $msg = "Please Enter Require fields.!";
            $this->session->set_flashdata("message", "Please Enter Require fields.!");
            redirect('buyer/createEvent/');
        } else {
			
			
            if ($this->input->post('reference_no') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('reference_no'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('event_title') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('event_title'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('borrower_name') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('borrower_name'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('reserve_price') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('reserve_price'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('emd_amt') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('emd_amt'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('tender_fee') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('tender_fee'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('nodal_bank_account') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('nodal_bank_account'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('branch_ifsc_code') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('branch_ifsc_code'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('press_release_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('press_release_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('inspection_date_from') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_from'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('inspection_date_to') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_to'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }


            if ($this->input->post('bid_last_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_last_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('bid_opening_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_opening_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('auction_start_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_start_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('auction_end_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_end_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('bid_inc') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_inc'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }
            if ($this->input->post('auto_extension_time') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auto_extension_time'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }


            if ($this->input->post('auto_extension') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auto_extension'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }


            if (is_array($upload_document_field) && count($upload_document_field) > 0) {
                foreach ($upload_document_field as $udf) {
                    $fieldName = strtolower(str_replace(' ', '_', $udf->upload_document_field_name));

                    if ($udf->upload_document_field_type == 2) { // 2 video validation
                        $checkMultipleExtension = $this->banker_model->checkVideoMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('buyer/createEvent/');
                        }
                    } else {
                        $checkMultipleExtension = $this->banker_model->checkMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('buyer/createEvent/');
                        }
                    }
                }
            }

            $insetedid = $this->banker_model->saveeventdata();

            if ($insetedid) {
                $publish = $this->input->post('Publish');
                $send4Approval = $this->input->post('send4Approval');
                $saveasdraft = $this->input->post('Save');
                $approver_id            = GetTitleByField('tbl_auction', "id='".$insetedid."'", 'second_opener');
				$approver_email_id       = GetTitleByField('tbl_user', "id='".$approver_id."'", 'email_id');

                if ($send4Approval) {
                    $msg = "Auction has been sent for approval.";
                    $this->session->set_flashdata('message', $msg);
                    #Start: Send mail to approver for approving auction ##Added by aziz
                    $creatorId = $this->session->userdata['id'];
                    $this->load->library('Email_new', 'email');
                    $email = new email_new();
                    
                    
                    //if($approver_email_id  !='')
                    //{
						$mail = $email->sendMailToApproverForApprovingAuction($insetedid);
					//}
                    #End: Send mail to approver for approving auction 
                    redirect('buyer/savedEvents');
                } else if($saveasdraft){
                    $msg = "Auction is saved successfully. EventID is '" . $insetedid . "' !";
                    $this->session->set_flashdata('message', $msg);
                    //redirect('buyer/createEvent/' . $auctionID);
                    redirect('buyer/createEvent/'.$insetedid);// Added by Aziz

                } else if($createCopy){
					$msg = $copyCount." Number of copies has been created.";
                    $this->session->set_flashdata('message', $msg);
					redirect('buyer/createEvent/'.(int)$auctionID);
				}
                
            }
        }
    }

    function saveapproverejecteventdata() {
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

        $this->form_validation->set_rules('account', 'Institution', 'trim|required|xss_clean');
        $this->form_validation->set_rules('reference_no', 'reference_no', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('area_unit_id', 'Area Unit', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contact_person_details_1', '1st Contact Person Details', 'trim|required|xss_clean');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required|xss_clean');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required|xss_clean');

        $this->form_validation->set_rules('reserve_price', 'reserve_price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('press_release_date', 'press_release_date', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('bid_opening_date', 'bid_opening_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('auction_start_date', 'auction_start_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('auction_end_date', 'auction_end_date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('approverComments', 'Auction Approve/ Reject Comments ', 'trim|required|xss_clean');

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
			
			/*
			if(!is_numeric($this->input->post('area')))
			{
				$errflg = 1;
				$this->session->set_flashdata("prarea", "Please Enter Valid Carpet Area!");
              
			}
            */            
			if(!is_numeric($this->input->post('bid_inc')))
			{
				$errflg = 1;
				$this->session->set_flashdata("bicv", "Please Enter Valid Bid Increment value!");
              
			}
                        
			if($press_release_date>=$crrDte)
			{
				$errflg = 1;
				$this->session->set_flashdata("prd", "Press Release Date or time should be less than current date & time!");
              
			}
                       
                       
			if($inspection_date_from != '' && $press_release_date>=$inspection_date_from)
			{
				$errflg = 1;
				$this->session->set_flashdata("svsd", "Site Visit Start Date time should be greater than Press release date!");
               
			}
			if($inspection_date_from != '' && $inspection_date_to !='' && $inspection_date_from>=$inspection_date_to)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be greater than  Site Visit Start Date time!");
                
			}
			/*
			if($inspection_date_to>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("sved", "Site Visit End Date time should be less than Auction Start date or time!");
            }*/
			if( $inspection_date_to !='' && $inspection_date_to>=$auction_end_date)
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
				$this->session->set_flashdata("aeed", "Apply And EMD End Date time should be greater than Apply And EMD Start Date time!");
                
			}
			if($registration_start_date>=$auction_start_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("asdt", "Auction Start Date time should be greater than Apply And EMD Start Date time!");
                
			}			
			if($bid_last_date>=$auction_end_date)
			{
				$errflg = 1;
				$this->session->set_flashdata("aedt", "Auction End Date time should be greater than Apply And EMD End Date time!");
               
			}
			if(($this->input->post('auto_extension')> 0 && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')) || ($this->input->post('auto_extension') =='' && ($this->input->post('auto_extension_time') <=0 || $this->input->post('auto_extension_time')=='')))
			{
				$errflg = 1;
				$this->session->set_flashdata("aetm", "Please Enter Valid Auto Extension Time!");
               
			}
			if($errflg==1)
			{
				 redirect('buyer/approveRejectEvent/' . $auctionID);
			}


        if ($this->form_validation->run() == FALSE) {
            //echo validation_errors();die;
            $msg = "Please Enter Require fields.!";
            $this->session->set_flashdata("message", "Please Enter Require fields.!");
            redirect('buyer/createEvent/' . $auctionID);
        } else {
			
			
			
            if ($this->input->post('reference_no') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('reference_no'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('event_title') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('event_title'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('borrower_name') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('borrower_name'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('reserve_price') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('reserve_price'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('emd_amt') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('emd_amt'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('tender_fee') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('tender_fee'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('nodal_bank_account') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('nodal_bank_account'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('branch_ifsc_code') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('branch_ifsc_code'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('press_release_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('press_release_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('inspection_date_from') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_from'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('inspection_date_to') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_to'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }


            if ($this->input->post('bid_last_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_last_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('bid_opening_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_opening_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('auction_start_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_start_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('auction_end_date') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_end_date'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('bid_inc') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_inc'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }
            if ($this->input->post('auto_extension_time') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auto_extension_time'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent');
                }
            }


            if ($this->input->post('auto_extension') != '') {
                $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auto_extension'));
                if ($checkHTMLTags == "1") {
                    $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                    redirect('buyer/createEvent/' . $auctionID);
                }
            }


            if (is_array($upload_document_field) && count($upload_document_field) > 0) {
                foreach ($upload_document_field as $udf) {
                    $fieldName = strtolower(str_replace(' ', '_', $udf->upload_document_field_name));

                    if ($udf->upload_document_field_type == 2) { // 2 video validation
                        $checkMultipleExtension = $this->banker_model->checkVideoMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('buyer/createEvent/' . $auctionID);
                        }
                    } else {
                        $checkMultipleExtension = $this->banker_model->checkMultipleExtension($_FILES[$fieldName]['name']);
                        if ($checkMultipleExtension == 'mul') {
                            $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                            redirect('buyer/createEvent/' . $auctionID);
                        }
                    }
                }
            }

            $insetedid = $this->banker_model->saveeventdata();

            if ($insetedid) {
                $review = $this->input->post('review');
                $approve = $this->input->post('approve');
                $reject = $this->input->post('reject');
                $creator_id             = GetTitleByField('tbl_auction', "id='".$insetedid."'", 'created_by');
				$creator_email_id       = GetTitleByField('tbl_user', "id='".$creator_id."'", 'email_id');

                if ($approve) {
					
					
            
                    $msg = "Auction has been approved successfully.!";
                    $this->session->set_flashdata('message', $msg);
                    #Start: Send mail to Creator after approved by Approver.
                    $this->load->library('Email_new', 'email');
                    $email = new email_new();
                    if($creator_email_id !='')
                    {
						$mail = $email->sendMailToCreatorAfterApprovingByApprover($insetedid);
					}
                    #End: Send mail to Creator after approved by Approver.
                    redirect('buyer/savedEvents');
                } else if ($review) {
                    $msg = "Auction has been sent for reviewed";
                    $this->session->set_flashdata('message', $msg);
                    #Start: Send mail to Creator after approved by Approver.
                    $this->load->library('Email_new', 'email');
                    $email = new email_new();
                    if($creator_email_id !='')
                    {
						$mail = $email->sendMailToCreatorAfterSendBackByApproverForReview($insetedid);
                    }
                    #End: Send mail to Creator after approved by Approver.
                    redirect('buyer/savedEvents');
                } else if ($reject) {
                    $msg = "Auction has been rejected successfully";
                    $this->session->set_flashdata('message', $msg);
                    redirect('buyer/savedEvents');
                }
            }
        }
    }

    public function sendMailPublish($arr) {
        $html = '';
        $html .= 'Dear T M,<br/><br/>';
        $html .= 'This is to inform you that the e-Auction Event <strong>( ' . $arr["event_title"] . ' )</strong> has been published on our Web Portal:<br/> <br/><br/>';
        $html .= 'We would be intimating you in time-to-time as the e-Auction proceeds.<br/><br/>';
        $html .= 'You may also contact us by dialing <strong>+91-124-4302020 / 21 / 22 / 23 / 24</strong> or e-mail us to for any kind of assistance/ suggestion.<br/><br/>';
        $html .= 'With regards,<br/>';
        $html .= '<span style="color: red;">Bank e-Auction Support Team</span><br/>';
        $html .= ' <br/>';
        $html .= '0124-4302020 /2021/2022/2023/2024<br/><br/>';
        $html .= '<strong>This is an auto generated email; please do not reply.</strong>';

        $email = new email_new();
        //return $email->sendMailToUser($arr['email'],BRAND_NAME, $html);
        return true;
    }

    /*     * ********************      eventTrack     *********************** */

    public function eventTrack($auction_id) {
        $data['heading'] = 'Auction Tracker';
        $data['controller'] = 'buyer';

        $data['auction_data'] = $this->banker_model->eventTrackData($auction_id);
        $data['document_list'] = $this->helpdesk_executive_model->document_list();
//die;
        $auction_list = $this->banker_model->getBankerCreatedAuction($auction_id);
        //print_r($auction_id);die;
        if (!in_array($auction_id, $auction_list)) {
            //redirect('/buyer');
        }
        $this->banker_header();
        $this->load->view('banker_view/banker_myActivityEventTrack', $data);
        $this->website_footer();
    }

    /*     * ********************      eventTrack     *********************** */
    /*     * ********************      myActivity     *********************** */

    /*     * ********************      myProfile     *********************** */

    public function myProfile() {
        $data['heading'] = 'My Profile';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $response = $this->banker_model->myProfileUserData();
        $data['row'] = $response;
        $this->load->view('banker_view/banker_myProfile', $data);
        $this->website_footer();
    }

    public function myProfileEdit() {
        $data['heading'] = 'Edit Profile';
        $response = $this->banker_model->myProfileUserData();
        $data['row'] = $response;
        $data['controller'] = 'buyer';
        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftPanel'] = $this->load->view('banker_view/banker_myActivityLeftPanel', '', true);
        $this->load->view('banker_view/banker_myProfileEdit', $data);
        $this->website_footer();
    }

    public function myProfileEditSave() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|numeric|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
            redirect('buyer/myProfileEdit');
        } else {
            $save = $this->banker_model->myProfileEditSaveData();
            if ($save) {
                redirect('buyer/myProfile');
            }
        }
    }

    public function myProfileChangePassword() {
        $data['heading'] = 'Profile - Change Password';
        $response = $this->banker_model->myProfileUserData();
        $data['row'] = $response;

        $data['controller'] = 'buyer';
        $this->banker_header();
        $data['breadcrumb'] = '';
        $this->load->view('banker_view/banker_myProfileChangePasswod', $data);
        $this->website_footer();
    }

    public function myProfileChangePasswordSave() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('o_password', 'Old Password', 'required');
        $this->form_validation->set_rules('n_password', 'New Password', 'required');
        $this->form_validation->set_rules('c_password', 'New Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('message_validation', "Error: Kindly fill all fields those mark with *");
            //echo $this->session->flashdata('message_validation');
            redirect('buyer/myProfileChangePassword');
        } else {

            $o_password = $this->input->post('o_password');
            $n_password = $this->input->post('n_password');
            $c_password = $this->input->post('c_password');


            if ($o_password == $n_password) {
                $this->session->set_flashdata('message_validation', "Error: Old and New Password cannot be same!");
                redirect('buyer/myProfileChangePassword');
            } else if ($n_password != $c_password) {

                $this->session->set_flashdata('message_validation', "Error: New Password and Confirm Password should be same!");
                redirect('buyer/myProfileChangePassword');
            } else {

                $r3 = '/[!@%^*()\-_=+{};:,.]/';
                $r4 = '/</';
                $r5 = '/>/';
                $r6 = '/&/';
                $r7 = '/#/';
                //$r8='/$/';
                //$n_password = "Demo@123#";
                //echo $n_password;echo "|";
                //echo preg_match($r8,$n_password);die;
                if (strlen($n_password) < 8 || !preg_match('/[A-Z]+/', $n_password) || !preg_match($r3, $n_password) || preg_match($r4, $n_password) || preg_match($r5, $n_password) || preg_match($r6, $n_password) || preg_match($r7, $n_password)) {
                    $this->session->set_flashdata('message_validation', "Error: Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#)");
                    redirect('buyer/myProfileChangePassword');
                } else {
                    $response = $this->banker_model->myProfileUserData();
                    //echo $response['0']->password;

                    if ($response['0']->password != hash("sha256", $o_password)) {

                        $this->session->set_flashdata('message_validation', "Error: Old Password did not match!");
                        redirect('buyer/myProfileChangePassword');
                    } else {
                        $data['password'] = hash("sha256", $n_password);
                        $this->db->where('id', $this->session->userdata('id'));
                        $this->db->update('tbl_user', $data);
                        $this->session->set_flashdata('message_validation1', "Password Changed Successfully");
                        //$data['password']=$n_password;
                        // $this->db->where('id', $this->session->userdata('id'));
                        //$this->db->update('tbl_user', $data);
                        //redirect('buyer/myProfile');
                        redirect('buyer/myProfileChangePassword');
                    }
                }
            }

            //redirect('buyer/myProfileChangePassword');
            //$save = $this->banker_model->myProfileEditSaveData();
            //if($save){
            //redirect('buyer/myProfile');
            //}
        }
    }

    /*     * ********************      myProfile     *********************** */

    function view_uploadedfile($auctionID) {
        $auctionData = $this->banker_model->GetRecordByAuctionId($auctionID);
        $data['auctionData'] = $auctionData;
        $data['bankData'] = $this->banker_model->GetBanksData($auctionData->bank_id);
        $data['uploadedDocs'] = $this->bank_model->GetUploadedDocsByAuctionId($auctionID);
        $this->load->view('banker_view/banker_uploaded_file', $data);
    }

    function view_bid_history($auctionID) {

        $auctionBiddingData = $this->banker_model->GetAuctionBidderHistoryData($auctionID);
        $data['auctionBiddingData'] = $auctionBiddingData;
        $this->load->view('banker_view/banker_biddistory', $data);
    }

    function eventDetailbidderHole($auctionID) {
        //$data['auction_detail']=$this->banker_model->auctionDetailPopupData($auctionID);
        $auctionData = $this->banker_model->auctionDetailPopupData($auctionID);
        $data['auction_detail'] = $auctionData;
        $data['bankData1'] = $this->banker_model->GetBanksData($auctionData->bank_id);
        $this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
    }

    function eventDetailPopup($auctionID) {
        $data['auction_detail'] = $this->banker_model->auctionDetailPopupData($auctionID);
        $this->load->view('banker_view/banker_myActivityEventDetailPopup', $data);
    }

    function emdDetailPopup($bidderID, $auctionID) {
        $data['base_url'] = base_url();
        $data['utrDetails'] = $this->banker_model->utrDetailPopupData($bidderID, $auctionID);
        $data['jdaPayLog'] = $this->banker_model->jdaPaymentLogPopupData($bidderID, $auctionID);
        $data['bidderID'] = $bidderID;
        $data['auctionID'] = $auctionID;
        if (!empty($data['emd'])) {
            $type = 'check_emd';
            $message = 'Buyer Viewed Bidder EMD Detail';
            $this->banker_model->trackemdDetailPopupData($data, $type, $message);
        }
        $this->load->view('banker_view/banker_myActivityTrackEmdPopup', $data);
    }

    function feedetail($bidderID, $auctionID) {
        //$data['emd']=$this->banker_model->emdDetailPopupData($bidderID,$auctionID);
        $data['emd'] = $this->banker_model->feeDetailPopupData($bidderID, $auctionID);

        $data['bidderID'] = $bidderID;
        $data['auctionID'] = $auctionID;
        $this->load->view('banker_view/banker_myActivityTrackFeePopup', $data);
    }

    function bidderDetailPopup($bidderID, $auctionID) {
        $data['array_records'] = $this->banker_model->bidderDetailPopup($bidderID, $auctionID);
        //echo '<pre>';print_r($data['array_records']);
        $this->load->view('banker_view/banker_myActivityBidderPopup', $data);
    }

    function tenderfeeDetailPopup($bidderID, $auctionID) {
        $data['base_url'] = base_url();
        $data['tenderfee'] = $this->banker_model->tenderfeeDetailPopupData2($bidderID, $auctionID);

        $data['emd'][0] = $this->banker_model->tenderfeeDetailPopupData2($bidderID, $auctionID);
        if (!empty($data['emd'])) {
            $type = 'check_auction_fee';
            $message = 'Buyer Viewed Tender Fee Detail';
            $this->banker_model->trackemdDetailPopupData($data, $type, $message);
        }
        $this->load->view('banker_view/banker_myActivityTrackTenderfeePopup', $data);
    }

    function docDetailPopup($bidderID, $auctionID) {
        $data['base_url'] = base_url();
        $data['doc'] = $this->banker_model->docDetailPopupData($bidderID, $auctionID);
        $data['emd'] = $this->banker_model->docDetailPopupData($bidderID, $auctionID);
        $data['auctionID'] = $auctionID;
        $data['bidderID'] = $bidderID;
        if (!empty($data['emd'])) {
            $type = 'check_documents';
            $message = 'Buyer Viewed Bidder Document Detail';
            $this->banker_model->trackemdDetailPopupData($data, $type, $message);
        }
        $this->load->view('banker_view/banker_myActivityTrackDocPopup', $data);
    }
    
    function emdDocDetailPopup($bidderID, $auctionID) {
        $data['base_url'] = base_url();
        $data['doc'] = $this->banker_model->emdDocDetailPopupData($bidderID, $auctionID);
        $data['emd'] = $this->banker_model->emdDocDetailPopupData($bidderID, $auctionID);
        $data['auctionID'] = $auctionID;
        $data['bidderID'] = $bidderID;
        if (!empty($data['emd'])) {
            $type = 'check_documents';
            $message = 'Buyer Viewed Bidder EMD Document Detail';
            $this->banker_model->trackemdDetailPopupData($data, $type, $message);
        }
        $this->load->view('banker_view/banker_myActivityTrackEmdDocPopup', $data);
    }

    function ajaxbidActivity() {
        $activity_type = $this->input->post('activity_type');
        $auctionID = $this->input->post('auctionID');
        if ($auctionID != '' && $activity_type != '') {
            $this->banker_model->ajaxbidActivity();
        } else {
            echo "Sorry Require Fields Not Exist!";
        }
    }

    function createCorrigendum($auctionID) {
		/*
        $auction_list = $this->banker_model->getBankerCreatedAuction($auctionID);
        if (!in_array($auctionID, $auction_list)) {
            redirect('/buyer');
        }
		*/
        $this->load->library('form_validation');
        $submit = $this->input->post('submit');
        if (isset($submit) && $submit == 'Submit') {

            $this->form_validation->set_rules('remarks', 'remarks', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $msg = "Please Enter Require fields.!";
            } else {
                if ($this->input->post('remarks') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('remarks'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }


                if ($this->input->post('press_release_date') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('press_release_date'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('inspection_date_from') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_from'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('inspection_date_to') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('inspection_date_to'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('bid_last_date') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_last_date'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('bid_opening_date') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bid_opening_date'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('auction_start_date') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_start_date'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($this->input->post('auction_end_date') != '') {
                    $checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('auction_end_date'));
                    if ($checkHTMLTags == "1") {
                        $this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }


                /*if ($_FILES['supporting_doc1']['name'] != "") {
                    $checkMultipleExtension = $this->banker_model->checkMultipleExtension($_FILES['supporting_doc1']['name']);
                    if ($checkMultipleExtension == 'mul') {
                        $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($_FILES['related_doc']['name'] != "") {
                    $checkMultipleExtension = $this->banker_model->checkMultipleExtension($_FILES['related_doc']['name']);
                    if ($checkMultipleExtension == 'mul') {
                        $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }
                if ($_FILES['image']['name'] != "") {
                    $checkMultipleExtension = $this->banker_model->checkMultipleExtension($_FILES['image']['name']);
                    if ($checkMultipleExtension == 'mul') {
                        $this->session->set_flashdata("message", "Invalid or multiple File Extension Used while uploading a single file!");
                        redirect('buyer/createCorrigendum/' . $auctionID);
                    }
                }*/


                $insetedid = $this->banker_model->saveCorrigendum();
                $msg = "Event has been updated successfully.!";
                $this->session->set_flashdata('message', $msg);
                redirect('buyer/createCorrigendum/' . $auctionID);
            }
        }
        $arows = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
        $data['corrigendumID'] = GetTitleByField('tbl_auction_corrigendum', 'auctionID=' . $auctionID, 'id');
        $data['corrigendumRemarks'] = GetTitleByField('tbl_auction_corrigendum', 'auctionID=' . $auctionID, 'remarks');
         
        $data['heading'] = 'Corrigendum';
        $data['controller'] = 'buyer';
        $data['auctionID'] = $auctionID;
        $data['auctionData'] = $arows;
        //$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
        //$data['leftPanel']=$this->load->view('banker_view/banker_myActivityLeftPanel','',true);
        $this->banker_header();
        $data['doc'] = $this->banker_model->docDetailPopupData($auctionID);
        //echo strtotime($arows->auction_end_date).'|'. time() .'|'. $arows->status.'|'. 6 .'|'.$arows->status.'|'. 7;die;
        if (strtotime($arows->auction_end_date) > time() && $arows->status != 6 && $arows->status != 7) {
            $this->load->view('banker_view/banker_myActivityCreateCorrigendum', $data);
        } else {
            redirect('/buyer');exit;
        }
        $this->website_footer();
    }

    function firstOpnerVerification() {
        $this->load->library('form_validation');
        $submit = $this->input->post('submit');
        $auctionID = $this->input->post('auctionID');
        if (isset($submit)) {


            $insetedid = $this->banker_model->saveFirstOpnerVerification();
            //$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
            //$this->session->set_flashdata('message', $msg);
        }
        redirect('buyer/eventTrack/' . $auctionID);
    }

    function secondOpnerVerification() {
        $this->load->library('form_validation');
        $submit = $this->input->post('submit');
        $auctionID = $this->input->post('auctionID');
        if (isset($submit)) {

            $insetedid = $this->banker_model->saveSecondOpnerVerification();
            //$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
            //$this->session->set_flashdata('message', $msg);
        }
        redirect('buyer/eventTrack/' . $auctionID);
    }

    function paymentVerification() {
        $this->load->library('form_validation');
        $submit = $this->input->post('submit');
        $auctionID = $this->input->post('auctionID');
        if (isset($submit)) {

            $insetedid = $this->banker_model->savePaymentVerification();
            //$msg="Auction has been saved successfully. Auction EventID is '".$insetedid."' !";	
            //$this->session->set_flashdata('message', $msg);
        }
        redirect('buyer/eventTrack/' . $auctionID);
    }

    function viewCorrigendum($auctionID) {
        $data['corrigendum'] = $this->banker_model->viewCorrigendumPopupData($auctionID);
        $this->load->view('banker_view/banker_myActivityAuctionCorrigendumPreviewPopup', $data);
    }

    function previewAuctionDetail($auctionID) {
        $data['auction_data'] = $this->banker_model->previewAuctionDetailPopupData($auctionID);
        $this->load->view('banker_view/banker_myActivityAuctionDataPreviewPopup', $data);
    }

    function concludeEvent($auctionID) {
        echo $this->banker_model->concludeEvent($auctionID);
    }

    function liveBiddingAuctionsdatatable($id) {
        $data['heading'] = 'List Live Auctions';
        $data['controller'] = 'buyer';
        //$auctionData=$this->banker_model->getBankersLiveAuctionList($id);
        $auctionData = $this->banker_model->getBankersLiveAuction10SecondList($id);
        $data['auctionData'] = $auctionData;
        echo $this->load->view('banker_view/live_bidding_auction_list', $data, true);
    }

    /*     * ********************    Start  myMessage     *********************** */

    public function myMessage() {

        if ($this->input->post('mark_as_read')) {

            //echo '<pre>', print_r($this->input->post('status')), '</pre>';

            if (($this->input->post('status'))) {

                $status = $this->input->post('status');

                foreach ($status as $status_id) {

                    //echo '<br />'.$status_id;
                    $data['msg_status'] = 1;
                    $this->db->where('id', $status_id);
                    $this->db->update('tbl_message', $data);
                }
            } else {

                $this->session->set_flashdata('message_validation', "Error: Kindly select any one.");
            }

            redirect('buyer/myMessage');
        }

        if ($this->input->post('delete_all')) {
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

            redirect('buyer/myMessage');
        }

        $data['heading'] = 'My Message';
        $data['controller'] = 'buyer';
        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);

        $total_record = $this->banker_model->GetCITotalRecord();

        //echo '<pre>', print_r($total_record), '</pre>';

        $data['records'] = $total_record;

        $this->load->view('banker_view/banker_myMessage', $data);

        $this->website_footer();
    }

    public function myMessage_reply_msg($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Reply Message';
            $message_id = $param;
        } else {
            $data['heading'] = 'Add Message';
        }

        if ($message_id) {
            $array_records = $this->banker_model->GetRecordById($message_id);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $data['get_user_data'] = $this->banker_model->GetUserData();
        $message = $this->banker_model->GetParentRecordsControl();
        $data['message'] = $message;

        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftPanel'] = $this->load->view('banker_view/banker_myActivityLeftPanel', '', true);
        $this->load->view('banker_view/add-edit-myMessage', $data);
        $this->website_footer();
    }

    public function myMessage_new($param) {

        $data['heading'] = 'New Message';
        $data['controller'] = 'buyer';
        $data['row'] = $array_records;

        $message = $this->banker_model->GetParentRecordsControl();
        $data['message'] = $message;

        $data['get_user_data'] = $this->banker_model->GetUserData();

        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftPanel'] = $this->load->view('banker_view/banker_myActivityLeftPanel', '', true);
        $this->load->view('banker_view/add-edit-myMessage', $data);
        $this->website_footer();
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

                redirect('buyer/myMessage_reply_msg/' . $id);
            } else {

                redirect('buyer/myMessage_new');
            }
        } else {

            $save = $this->banker_model->myMessage_save_message_data();

            if ($save) {
                redirect('buyer/myMessage');
            }
        }
    }

    function myMessage_autocomplete() {

        $data = $this->banker_model->myMessage_get_autocomplete();
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
        redirect('buyer/myMessage');
    }

    public function myMessageUser() {

        $data['heading'] = 'My User Message';
        $message_id = $param;
        $data['row'] = $array_records;

        //$data['get_user_data'] = $this->banker_model->GetUserData();
        $message = $this->banker_model->GetUserTotalRecord();
        $data['records'] = $message;
        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftPanel'] = $this->load->view('banker_view/banker_myActivityLeftPanel', '', true);
        $this->load->view('banker_view/banker_myMessageUser', $data);
        //$this->load->view('banker_view/banker_myActivity', $data);
        $this->website_footer();
    }

    public function myMessageTrash() {

        $data['heading'] = 'My Trash Message';
        $message_id = $param;
        $data['row'] = $array_records;
        $message = $this->banker_model->GetTrashTotalRecord();
        $data['records'] = $message;
        $this->banker_header();
        $data['breadcrumb'] = $this->load->view('common/executive_breadcrumb', $data, true);
        $data['leftPanel'] = $this->load->view('banker_view/banker_myActivityLeftPanel', '', true);
        $this->load->view('banker_view/banker_myMessageTrash', $data);
        $this->website_footer();
    }

    /*     * ********************     End myMessage     *********************** */

    function checkMail($auctionID) {

        // Start:Email Code

        $this->load->library('Email_new', 'email');

        $subject = 'BOM Vs Mrs.Tania Raha & Shri Dipak Raha: Provide necessary training to Qualified Bidders to participate in e-Bidding Process ';


        $html = '';
        $html .= 'To<br/>';
        $html .= 'The Help Desk,<br/>';
        $html .=  BRAND_NAME.' Division,<br/>';
        $html .= 'C1 India Pvt. Ltd.<br/><br/>';

        $html .= 'The following bidders have been qualified by bank to participate in the e-Bidding Process. Therefore, request you to do the needful to provide them necessary training on e-Auction.<br/><br/>';

        if ($auctionID != '') {
            $this->db->where('auctionID =', $auctionID);

            $query = $this->db->get("tbl_auction_participate");
            $data = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    //$row->user_id=$this->GetAssignedUser($row->id);
                    $datam = $this->getUserValue($row->bidderID);
                    //print_r($datam);
                    $html .= 'NAME: ' . $datam[0]->first_name . ' ' . $datam[0]->last_name . '<br/>';
                    $html .= 'MOBILE NO.: ' . $datam[0]->mobile_no . '<br/>';
                    if (isset($datam[0]->phone_no) && $datam[0]->phone_no != '') {
                        $html .= 'ALTERNATE NO.: ' . $datam[0]->phone_no . '<br/>';
                    } else {
                        $html .= 'ALTERNATE NO.: NA<br/>';
                    }
                    $html .= 'E-MAIL ID.: ' . $datam[0]->email_id . '<br/>';

                    if (isset($row->operner2_accepted) && $row->operner2_accepted != '') {
                        if ($row->operner2_accepted == '1') {
                            $html .= 'Qualified.: YES<br/>';
                        } else {
                            $html .= 'Qualified.: NO<br/>';
                        }
                        $html .= 'Comment.: ' . $row->operner2_comment . '<br/>';
                    } else {
                        if ($row->operner1_accepted == '1') {
                            $html .= 'Qualified.: YES<br/>';
                        } else {
                            $html .= 'Qualified.: NO<br/>';
                        }
                        $html .= 'Comment.: ' . $row->operner1_comment . '<br/>';
                    }

                    $html .= '<br/>';
                    $data[] = $row;
                }
                //return $data;
            }
        }
        $html .= '<br/>';
        $html .= '<strong>Sd/- Authorised Officer</strong><br/>';
        $html .= 'Branch: ' . $this->getBranchName($auctionID) . '<br/>';
        $html .= 'City: ' . $this->getCityName($auctionID) . '<br/><br/>';


        $html .= '<strong>This is an auto generated email; please do not reply.</strong>';

        //echo $html;die;
        $email = new email_new();
        //$email->sendMailToUser(array('darpan.kumar@c1india.com'), 'BankeAuction Helpdesk', $html);
    }

    function showbranchdata() {
        $bankid = $this->input->post('bankid');
        if ($bankid) {
            $catArr = $this->helpdesk_executive_model->GetBranchdata($bankid);
            $str = '<option value="">Select Bank Branch</option>';
            if (count($catArr) > 0) {
                foreach ($catArr as $row) {
                    $selected = ($row->id == $subcate) ? 'selected' : '';
                    $str .= '<option ' . $selected . ' value="' . $row->id . '">' . $row->name . '</value>';
                }
            }
            echo $str;
        }
    }

    function showBankUserListdata() {
        $bankid = $this->input->post('bankid');
        if ($bankid) {
            $banksUsersList = $this->helpdesk_executive_model->getUserByBankId($bankid);
            $str = '<option value="">Select</option>';
            if (count($banksUsersList) > 0) {
                foreach ($banksUsersList as $row) {
                    $selected = ($row->id == $subcate) ? 'selected' : '';
                    $option = $row->email_id . ", " . $row->user_id . ", " . ucfirst($row->first_name) . " " . $row->last_name;
                    $str .= '<option ' . $selected . ' value="' . $row->id . '">' . $option . '</value>';
                }
            }
            echo $str;
        }
    }

    function showBankUserListdata1() {
        $bankid = $this->input->post('bankid');
        if ($bankid) {
            $banksUsersList = $this->helpdesk_executive_model->getUserByBankId($bankid);
            $str = '';
            if (count($banksUsersList) > 0) {
                foreach ($banksUsersList as $row) {
                    $selected = ($row->id == $subcate) ? 'selected' : '';
                    $option = $row->email_id . ", " . $row->user_id . ", " . ucfirst($row->first_name) . " " . $row->last_name;
                    $str .= '<option ' . $selected . ' value="' . $row->id . '">' . $option . '</value>';
                }
            }
            echo $str;
        }
    }

    public function getUserValue($userid) {

        $this->db->where('id', $userid);

        $query = $this->db->get("tbl_user_registration");
        //echo $this->db->last_query();

        $data = array();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getBranchName($auctionID) {


        $this->db->where('id', $auctionID);
        $query = $this->db->get("tbl_auction");
        //echo $this->db->last_query();

        $data = array();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $bankid = $row->branch_id;
            }
        }


        $this->db->where('id', $bankid);

        $query1 = $this->db->get("tbl_branch");
        //echo $this->db->last_query();

        $data = array();
        if ($query1->num_rows() > 0) {

            foreach ($query1->result() as $row1) {
                $bankname = $row1->name;
            }
            return $bankname;
        }
        return false;
    }

    public function getCityName($auctionID) {


        $this->db->where('id', $auctionID);
        $query = $this->db->get("tbl_auction");
        //echo $this->db->last_query();

        $data = array();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $cityid = $row->city;
                $otherCity = $row->other_city;
            }
        }

        if (isset($otherCity) && $otherCity != '') {
            return $otherCity;
        }

        $this->db->where('id', $cityid);

        $query1 = $this->db->get("tbl_city");
        //echo $this->db->last_query();

        $data = array();
        if ($query1->num_rows() > 0) {

            foreach ($query1->result() as $row1) {
                $city_name = $row1->city_name;
            }
            return $city_name;
        }
        return false;
    }

    /*     * ********************      Report     *********************** */

	function allReport($auctionID)
	{
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Auction Report';
			$data['controller'] = 'buyer';
			$data['auctionId'] = $auctionID;
			$this->banker_header();
			$this->load->view('banker_view/banker_myActivityAllReport', $data);
			$this->website_footer();
        }
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}

    function viewReport($auctionID) {
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Highest Bid Report';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);
			// echo '<pre>';
			// print_r($data); die();
			//Track Bidder View Report start
			$trackreportdata = array('event_id' => $data['auction_data'][0]->eventID,
				'auction_id' => $auctionID,
				'bidder_id' => $this->session->userdata('id'),
				'bank_id' => 1,
				'user_type' => $this->session->userdata('user_type'),
				'action_type' => "mcg_auction_report",
				'action_type_event' => "view",
				'ip' => $_SERVER['REMOTE_ADDR'],
				'status' => '1',
				'message' => 'Buyer has successfully viewed Auction report',
				'indate' => date('Y-m-d H:i:s'),
			);
			$query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();

			$this->load->view('banker_view/banker_myActivityTrackReport', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
    }
	
	function acceptedBidsReport($auctionID)
	{
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Accepted Bid Report';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);
			// echo '<pre>';
			// print_r($data); die();
			//Track Bidder View Report start
			$trackreportdata = array('event_id' => $data['auction_data'][0]->eventID,
				'auction_id' => $auctionID,
				'bidder_id' => $this->session->userdata('id'),
				'bank_id' => 1,
				'user_type' => $this->session->userdata('user_type'),
				'action_type' => "mcg_auction_report",
				'action_type_event' => "view",
				'ip' => $_SERVER['REMOTE_ADDR'],
				'status' => '1',
				'message' => 'Buyer has successfully viewed Auction report',
				'indate' => date('Y-m-d H:i:s'),
			);
			$query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();

			$this->load->view('banker_view/banker_myActivityAcceptedBidReport', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}
	
	function rejectedBidsReport($auctionID)
	{
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Rejected Bid Report';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->rejectedBidsReport($auctionID);
			// echo '<pre>';
			// print_r($data); die();
			//Track Bidder View Report start
			$trackreportdata = array('event_id' => $data['auction_data'][0]->eventID,
				'auction_id' => $auctionID,
				'bidder_id' => $this->session->userdata('id'),
				'bank_id' => 1,
				'user_type' => $this->session->userdata('user_type'),
				'action_type' => "mcg_auction_report",
				'action_type_event' => "view",
				'ip' => $_SERVER['REMOTE_ADDR'],
				'status' => '1',
				'message' => 'Buyer has successfully viewed Auction report',
				'indate' => date('Y-m-d H:i:s'),
			);
			$query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();

			$this->load->view('banker_view/banker_myActivityRejectedBidReport', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
		
	}
	
	function allBidsReport($auctionID) 
	{
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Bid History Report';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->allBidsReport($auctionID);
			// echo '<pre>';
			// print_r($data); die();
			//Track Bidder View Report start
			$trackreportdata = array('event_id' => $data['auction_data'][0]->eventID,
				'auction_id' => $auctionID,
				'bidder_id' => $this->session->userdata('id'),
				'bank_id' => 1,
				'user_type' => $this->session->userdata('user_type'),
				'action_type' => "mcg_auction_report",
				'action_type_event' => "view",
				'ip' => $_SERVER['REMOTE_ADDR'],
				'status' => '1',
				'message' => 'Buyer has successfully viewed Auction report',
				'indate' => date('Y-m-d H:i:s'),
			);
			$query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();

			$this->load->view('banker_view/banker_myActivityAllBidReport', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
        
    }
	
	function breakupBidsReport($auctionID)
	{
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'Bid History Report';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);
			// echo '<pre>';
			// print_r($data); die();
			//Track Bidder View Report start
			$trackreportdata = array('event_id' => $data['auction_data'][0]->eventID,
				'auction_id' => $auctionID,
				'bidder_id' => $this->session->userdata('id'),
				'bank_id' => 1,
				'user_type' => $this->session->userdata('user_type'),
				'action_type' => "mcg_auction_report",
				'action_type_event' => "view",
				'ip' => $_SERVER['REMOTE_ADDR'],
				'status' => '1',
				'message' => 'Buyer has successfully viewed Auction report',
				'indate' => date('Y-m-d H:i:s'),
			);
			$query_log = $this->db->insert("tbl_log_all_report_track", $trackreportdata);
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();

			$this->load->view('banker_view/banker_myActivityBreakOfBid', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
		
	}
	
    /*     * ********************  End Report     *********************** */

    public function page_popup($product_id) {
        $this->load->view('admin/header-popup', $data);
        $data['heading'] = 'Product Images';
        $array_records = $this->product_image_model->GetRecordByArticleId($product_id);
        $data['product_id'] = $product_id;
        $data['records'] = $array_records;
        $this->load->view('product-image', $data);
    }

    public function invoice_mail_to_user($bankID) {
        //$banksUsersList	= $this->helpdesk_executive_model->eventBankUserList('branch','',$bankID);

        $banksUsersList = $this->helpdesk_executive_model->getUserByBankId($bankID);
        foreach ($banksUsersList as $urow) {
            if ($urow->id == $invoice_mail_to) {
                $strc = 'disabled="disabled"';
            } else {
                $strc = '';
            }
            $str .= "<option " . $strc . " value='$urow->id'>" . $urow->email_id . ",  " . $urow->user_id . ", " . ucfirst($urow->first_name) . "  " . $urow->last_name . "</option>";
        }
        echo $str;
    }

    public function setopeningprice() {
        $str = $this->banker_model->setopeningprice();
        echo $str;
    }

    /*
      public function movetofirstopener()
      {
      $str = $this->banker_model->movetofirstopener();
      echo $str;
      }

      public function movetosecondopener()
      {
      $str = $this->banker_model->movetosecondopener();
      echo $str;
      }
     */

    public function movetoapprover() {
        $str = $this->banker_model->movetoapprover();
        echo $str;
    }

    public function open_price_bid1() {
        $str = $this->banker_model->open_price_bid1();
        echo $str;
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
                    $str .= '<option ' . $selected . ' value="' . $row->id . '">' . $row->name . '</value>';
                }
            }
            echo $str;
        }
    }

    

    public function get_part_emd_val() {
        $fee = array();
        $areaVal = $this->input->post('areaVal');
        $bspVal = $this->input->post('bspVal');
        if ($areaVal != "" && $bspVal != '') {
            $propertyEstimateVal = $areaVal * $bspVal;

            $this->db->where('min_range <', $propertyEstimateVal);
            $this->db->where('status', 1);
            $this->db->order_by('min_range', 'desc');
            $this->db->limit(1);
            $peQry = $this->db->get('tblmst_participationfee_emdfee');
            //echo $this->db->last_query();die;
            //echo $peQry->num_rows();
            if ($peQry->num_rows() > 0) {
                $row = $peQry->result_array();
                //$fee['pFee'] = $row[0]['participation_fee'];
                $fee['pFee'] = BANK_PROCESSING_FEE;
                $fee['emdFee'] = $row[0]['emd_fee'];

                $this->db->where('participation_emd_id', $row[0]['participation_emd_id']);
                $this->db->where('status', 1);
                $ehQry = $this->db->get('tblmst_participationfee_emdfee_extra_header');
                //echo $this->db->last_query();die;

                /* if($ehQry->num_rows()>0)
                  {
                  foreach($ehQry->result_array() as $eh)
                  {

                  if($eh['type'] == 'participate')
                  {
                  if($eh['amount_type'] =='amount')
                  {
                  $fee['pFee'] += $eh['amount'];
                  }
                  else if($eh['amount_type'] == 'percentage')
                  {
                  $fee['pFee'] += ($row[0]['participation_fee']*$eh['amount'])/100;
                  }
                  }
                  if($eh['type'] == 'emd')
                  {
                  if($eh['amount_type'] =='amount')
                  {
                  $fee['emdFee'] += $eh['amount'];
                  }
                  else if($eh['amount_type'] == 'percentage')
                  {
                  $fee['emdFee'] += ($row[0]['emd_fee']*$eh['amount'])/100;
                  }
                  }
                  }
                  } */
            } else {
                $fee['pFee'] = 0;
                $fee['emdFee'] = 0;
            }
        }
        echo json_encode($fee);
    }

    public function viewGoogleMap() {
        $data['heading'] = 'Auction Event Map';
        $data['controller'] = 'buyer';

        $auctionID = $this->uri->segment(3);
        $this->banker_header();
        $data['data'] = $this->banker_model->GetRecordByAuctionId($auctionID);
        $this->load->view('banker_view/banker_googlemap', $data);
        $this->website_footer();
    }

    public function viewEventDocuments() {
        $data['heading'] = 'Auction Documents';
        $data['controller'] = 'buyer';

        $auctionID = $this->uri->segment(3);
        $this->banker_header();
        $data['data'] = $this->banker_model->GetAuctionDocuments($auctionID);
        $this->load->view('banker_view/banker_eventDocuments', $data);
        $this->website_footer();
    }

    public function quick_view() {
        $this->load->view('banker_view/quick_view', $data);
    }

    public function sendRole() {
        $data = $this->banker_model->setRole();      
    }
    
    
    //SMS api send sms to bidder
    public function sms_send($data=array())
    {	
		$jsonData = '{
                            "MobileNumber": "'.$data['mobile'].'",
                            "SMSMessage": "'.$data['SMSMessage'].'",
                            "SenderApplicationID": 3,
                            "SenderUserID": 4,
                            "SMSExpiryDateTime": "'.$data['exp_date'].'",
                            "priority": true
                          }';
		
		$headers = array(
					"Content-type: application/json",					
					//"Authorization: Basic NjM6Q2gjOVktM3I=",
				);
		
		$url = SMS_URL;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		// Following line is compulsary to add as it is:
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = curl_exec($ch);
		curl_close($ch);		
		/*
		$response = json_decode($data);
		echo "<pre>";
		print_r($response);die;
		*/ 
	}
	
	function add_bidder_live_auction()
	{
		$data['heading'] = 'Add Bidder in Live Auction';
        $data['controller'] = 'buyer';

        $auctionID = $this->uri->segment(3);
        $data['bidders'] = $this->banker_model->bidderListAuction($auctionID);
        $this->banker_header();        
        $this->load->view('banker_view/banker_bidder_for_auction', $data);
        $this->website_footer();
	}
	
	public function mastercontactdata()
	{
		echo $this->banker_model->mastercontactdata();
	}
	
	
	function add_bidder_auction()
	{
		$auctionID = $this->input->post('auctionID');
		$participateArr = $this->input->post('participate_id');		
		$txtCommentArr = $this->input->post('txtComment');
		$txtCommentArr = array_filter($txtCommentArr);
		
		if(is_array($participateArr) && count($participateArr)>0)
		{	
			
			if(is_array($txtCommentArr) && count($txtCommentArr)>0)
			{
				$this->banker_model->add_bidder_live_auction();	
				
				if($this->session->userdata('role_id')==3) 
				{
					$msg = "Bidders Moved To Final Approver Successfully.";
					$this->session->set_flashdata('message', $msg);
					redirect('buyer/emd_payment_verification');
					exit;
 				}
 				if($this->session->userdata('role_id')==5) 
				{
					$msg = "Bidders Moved To Final Approver Successfully.";
					$this->session->set_flashdata('message', $msg);
					redirect('buyer/add_bidder_live_auction/'.$auctionID);
					exit;
 				}
 				else
 				{
					$this->load->library('Email_new', 'email');
					$email = new email_new();
					
					//send mail to bidders
					$mail = $email->sendMailToBidderForOpeningStatus($auctionID);
					
					$msg = "Accepted bidders moved to auction. Rejected bidders shall be able to re-apply after making necessary changes.";
					$this->session->set_flashdata('message', $msg);
					redirect('buyer/add_bidder_live_auction/'.$auctionID);
					exit;
				}
		
			}
			else
			{			
				$msg = "Please enter your comments for selected bidder";
				$this->session->set_flashdata('message_new', $msg);
				if($this->session->userdata('role_id')==3) 
				{
					redirect('buyer/emd_payment_verification');
					exit;
 				}
 				else
 				{
					redirect('buyer/add_bidder_live_auction/'.$auctionID);
					exit;
				}
			}
		}
		else
		{		
			$msg = "Please select atleast one bidder";
			$this->session->set_flashdata('message_new', $msg);
			if($this->session->userdata('role_id')==3) 
			{
				redirect('buyer/emd_payment_verification');
				exit;
			}
			else
			{
				redirect('buyer/add_bidder_live_auction/'.$auctionID);
				exit;
			}
		}
	}
	
	function emd_payment_verification()
	{
		$data['heading'] = 'EMD Payment Verification';
        $data['controller'] = 'buyer';

        //$auctionID = $this->uri->segment(3);
        $data['bidders'] = $this->banker_model->paymentbidderListAuction();
        $this->banker_header();        
        $this->load->view('banker_view/emd_payment_verification', $data);
        $this->website_footer();
	}
        
    ##### Added By Aziz ##################################
	public function auctionsForApproval() {
		$data['heading'] = 'Auctions For Approval/Rejection';
		$data['controller'] = 'buyer';
		$this->banker_header();
		$this->load->view('banker_view/banker_myActivityAuctionForApproval', $data);
		$this->website_footer();
	}
	
	//For testing purpose
	public function azizTest() {
		$data['heading'] = 'Auctions For Approval/Rejection';
		$data['controller'] = 'buyer';
	  
		$this->load->view('banker_view/aziz_test', $data);
	   
	}
	
	public function banker_h1Bidder($auctionID)
	{
            
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
		if($aStatus>=6)
		{
			$data['heading'] = 'H1 Bidder';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);			
			
			//Track Bidder View Report End
			$data['BidderRankData'] = $this->banker_model->getBidderRank($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();
			$this->load->view('banker_view/banker_h1Bidder', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}
	
	public function acceptanceBidderDetails($auctionID, $bidderID)
	{
          
            $aStatus = GetTitleById('tbl_auction',$auctionID,'status');

            if($aStatus >= 6)
            {
               $data['heading']        = 'H1 Bidder';
               $data['controller']     = 'buyer';
               $data['auctionID']      = $auctionID;
               $data['bidder_id']      = $bidderID;
               $data['prop_desc']      = GetTitleById('tbl_auction',$auctionID,'PropertyDescription');
               $data['bidder_name']    = GetTitleByField('tbl_user_registration', 'id="'.$bidderID.'"', 'first_name')." ".GetTitleByField('tbl_user_registration', 'id="'.$bidderID.'"', 'last_name');
               $data['bidder_email']   = GetTitleByField('tbl_user_registration', 'id="'.$bidderID.'"', 'email_id');
               $data['auction_data']   = $this->banker_model->acceptanceBidderDetails($auctionID, $bidderID);

               //echo "<pre>"; print_r($data['auction_data']); die;

               $this->banker_header();
               $this->load->view('banker_view/banker_acceptanceBidderDetails', $data);
               $this->website_footer();
            } else {
               redirect('buyer/myActivity');
               exit;
            }
	}
	
	public function acceptanceBidderSmsAndEmail()
	{   
            $auctionID  = $this->input->post("auction_id"); 
            $bidderID   = $this->input->post("bidder_id");

            $aStatus    = GetTitleById('tbl_auction',$auctionID,'status');
             
            if($aStatus >= 6)
            { 
                if($this->input->post("send_sms") == "Send SMS"){
                    $email = new email_new();
                    $mail = $email->sendAcceptanceConfToBidder("sms");
                    $msg = "Message has been send successfully.";
                    $this->session->set_flashdata('message', $msg);
                         
                }else if($this->input->post("send_email") == "Send Email"){
                    $email = new email_new();
                    $mail = $email->sendAcceptanceConfToBidder("email");
                    if($mail){
                        $msg = "Mail has been send successfully.";
                        $this->session->set_flashdata('message', $msg);
                    }else{
                        $msg = "Sorry, Something went wrong!";
                        $this->session->set_flashdata('message', $msg);
                    }  
                }
      
                redirect('buyer/acceptanceBidderDetails/'.$auctionID.'/'.$bidderID);
            } else {
                redirect('buyer/myActivity');
                exit;
            }
	}
	
	public function save_awrd()
	{
            $bidderId = $this->input->post('bidderId');
            $auctionId = $this->input->post('auctionId');
            if ($bidderId && $auctionId) {			
                $this->banker_model->save_awrd_status();            
            }
            else
            {
                redirect('buyer/myActivity');
		exit;
            }
	}
	
	public function copy_auction($auctionId)
	{
        $arows = $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionId);
        $insertId = $this->banker_model->save_copy_auction($arows);
        
        if($insertId){			
			$msg = "Auction has been copied successfully. Auction ID is '" . $insertId . "' !";
			$this->session->set_flashdata('message', $msg);                    
			//echo $insertId;
			redirect('buyer/createEvent/'.$insertId);
			exit;
		}
	}
	
	public function auction_alert_msg($auctionId = 0,$alertId = 0)
	{
		$data['auctionId'] = $auctionId;
		
		if($alertId > 0)
		{
			$data['alert'] = $this->banker_model->getAuctionAlertByAlertId($auctionId,$alertId);
		}
		
		$data['heading'] = 'Live Auction Alert Message';
		$data['controller'] = 'buyer';
		$this->banker_header();
		$this->load->view('banker_view/auction_alert_msg', $data);
		$this->website_footer();
		
	}
	
	public function deleteAuctionAlert($auctionId=0,$alertId=0,$action='')
	{
		if($alertId>0 && $action == 'delete')
		{			
			$res = $this->banker_model->deleteAuctionAlert($auctionId,$alertId);
			$this->session->set_flashdata('success_msg', '<p class="alert alert-success"> Alert deleted successfully!</p>');
			echo $res;						
			//redirect("/buyer/auction_alert_msg/".$auctionId);
		}
		else
		{
			echo 0;
		}
	}
	
	
	public function auctionAlertsData($auctionId)
    {
		echo $this->banker_model->auctionAlertsData($auctionId);
	}
	
	public function save_alert_msg($auctionId = 0,$alertId = 0)
	{
		$this->load->library('form_validation');
		$save = $this->input->post("save");
		if(isset($save) && $save != "")
		{
			$alert_type = $this->input->post("alert_type");
			
			$this->form_validation->set_rules('alert_type', 'Alert Type', 'trim|required|xss_clean');
			
			if($alert_type == 'E')
			{
				$this->form_validation->set_rules('email_subject', 'Email Subject', 'trim|required|xss_clean');
			}
			$this->form_validation->set_rules('msg_body', 'Message', 'trim|required|xss_clean');
	
			
			if ($this->form_validation->run() == FALSE) {
				
				//echo validation_errors();die;				
				$this->session->set_flashdata("err_msg", "Please Enter Require fields.!");
				redirect('/buyer/auction_alert_msg/'.$auctionId);
			} 
			else 
			{	
				
				$this->banker_model->addAuctionAlert($auctionId,$alertId);	
				$alertName = "";
				if($alert_type == 'E')
				{
					$alertName = "E-Mail";
				}
				if($alert_type == 'M')
				{
					$alertName = "Marquee";
				}
				if($alert_type == 'P')
				{
					$alertName = "Panel Message";
				}
				
				if($alertId > 0)
				{
					$this->session->set_flashdata('success_msg', '<p class="alert alert-success">'.$alertName.' Alert updated successfully!</p>');			
				}
				else
				{
					$this->session->set_flashdata('success_msg', '<p class="alert alert-success">'.$alertName.' Alert added successfully!</p>');			
				}
				redirect("/buyer/auction_alert_msg/".$auctionId);				
			}
		}
		
	}
	
	public function refund_transfer_dashboard()
	{
            $data['heading'] = 'Refund/Transfer Dashboard';
            $data['controller'] = 'buyer';

            //$auctionID = $this->uri->segment(3);
            $data['auctionData'] = $this->banker_model->allCompletedAuctions();         
            $this->banker_header();        
            $this->load->view('banker_view/refund_transfer_dashboard', $data);
            $this->website_footer();
	}
	
    public function initiate_refund()
	{
            $auction_id         = $this->uri->segment(3);
            $data['heading']    = 'Initiate Refund';
            $data['controller'] = 'buyer';
            $data['auction_id'] = $auction_id;
            
            $data['accountData']    = $this->banker_model->get_all_remitter_account();
            $data['bidderData']     = $this->banker_model->get_all_parti_bidders_refund($auction_id);
            //echo "<pre>"; print_r($data['auction_details']); die;
            $this->banker_header();        
            $this->load->view('banker_view/initiate_refund', $data);
            $this->website_footer();
	}
        
	public function get_remitter_account_by_id(){
		$array_records = $this->banker_model->get_remitter_account_by_id();
		echo json_encode($array_records);
	}
	
    public function initiate_transfer()
	{    
            $auctionId          = $this->uri->segment(3);
            $data['heading']    = 'Initiate Refund';
            $data['controller'] = 'buyer';

            $data['accountData']    = $this->banker_model->get_all_remitter_account();
            $data['bidderData']     = $this->banker_model->allparticipatedBidders($auctionId);
            //echo "<pre>"; print_r($data['bidderData']); die;
            $this->banker_header();        
            $this->load->view('banker_view/initiate_transfer', $data);
            $this->website_footer();
	}
	
    public function save_initiate_transfer()
	{
            $submit = $this->input->post('gen_scrl_chq');
            if (isset($submit)) {			
                $payment_type = $this->input->post('payment_type');
                //echo "<pre>";print_r($payment_type);die;
                $this->load->library('form_validation');			
                $auction_id = $this->input->post('auction_id');
                $this->form_validation->set_rules('remitter_account', 'Remitter Account Id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('cheque_no', 'Cheque No.', 'trim|required|xss_clean');
                $this->form_validation->set_rules('cheq_date', 'Cheque Date', 'trim|required|xss_clean');
                
                //Check amount to be paid is not be empty
                $amtPaidArr = $this->input->post('amt_to_be_paid');
                $chkAmtArr   = 0.00;
                for($i = 0; $i<count($amtPaidArr); $i++)
                {
                    $chkAmtArr += $amtPaidArr[$i];
                }
                if($chkAmtArr <= 0)
                {
                    $this->form_validation->set_rules('amt_to_be_paid', 'Amount to be Paid', 'trim|required|xss_clean');
                }
                
                //Check amount to be paid is not be greater than the remaining amount.
                
                
                for($i = 0;$i<count($amtPaidArr);$i++){
                    $chkRemAmt  = $this->banker_model->check_remainig_initiate_amt($payment_type[$i]);
                }
                if( ! $chkRemAmt)
                {
                    $this->form_validation->set_rules('amt_to_be_paid', 'Amount to be Paid', 'trim|required|alpha|min_length[50]|xss_clean');
                }
                
                if ($this->form_validation->run() == FALSE) 
                {
                   if( ! $chkRemAmt)
                    {
                        $msg = "Amount To Be Transfered Can Not Be Greater Than Remaining Amount.!";
                    }
                    else
                    {
                        $msg = "Please Enter Require fields.!";
                    }
                    
                    $this->session->set_flashdata('error_msg', $msg);
                    redirect('buyer/initiate_transfer/'.$auction_id);
                    exit;
                }
                
                else
                {
                    $dOrder = $this->banker_model->save_initiate_transfer();				
                    redirect('buyer/initiate_transfer_dashboard/'.$auction_id);
                    exit;
                }

            }
	}
        
    public function save_initiate_refund()
	{
		$submit = $this->input->post('gen_scrl_chq');
		if (isset($submit)) 
		{			
			$this->load->library('form_validation');			
			$auction_id = $this->input->post('auction_id');
			$this->form_validation->set_rules('remitter_account', 'Remitter Account Id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cheque_no', 'Cheque No.', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cheq_date', 'Cheque Date', 'trim|required|xss_clean');
			
			//Check amount to be paid is not be empty
			$amtPaidArr = $this->input->post('amt_to_be_paid');
			$chkAmtArr   = 0.00;
			for($i = 0; $i<count($amtPaidArr); $i++)
			{
				$chkAmtArr += $amtPaidArr[$i];
			}
			if($chkAmtArr <= 0)
			{
				$this->form_validation->set_rules('amt_to_be_paid', 'Amount to be Paid', 'trim|required|xss_clean');
			}
			
			//Check amount to be paid is not be greater than the remaining amount.
			$chkRemAmt  = $this->banker_model->check_remainig_refund_amt();
			if( ! $chkRemAmt)
			{
				$this->form_validation->set_rules('amt_to_be_paid', 'Amount to be Paid', 'trim|required|alpha|min_length[50]|xss_clean');
			}
			
		   //Checking Receiver Account Details can not be blank.
			$aPaidArr   = $this->input->post('amt_to_be_paid');
			$rName      = $this->input->post('receiver_name');
			$rBName     = $this->input->post('receiver_bank_name');
			$rIFSCCode  = $this->input->post('receiver_ifsc_code');
			$rAcNo      = $this->input->post('receiver_account_no');
			$rStatus  = 0;
			for($i = 0; $i<count($aPaidArr); $i++)
			{
				if (($amtPaidArr[$i] > 0) && (($rName[$i] == '') || ($rBName[$i] == '') || ($rIFSCCode[$i] == '') || ($rAcNo[$i] == '')))
				{
				   $rStatus = 1; 
				}
			}
			if($rStatus > 0)
			{
				$this->form_validation->set_rules('amt_to_be_paid', 'Amount to be Paid', 'trim|required|alpha|min_length[50]|xss_clean');
			}
			
		   
			
			if ($this->form_validation->run() == FALSE) 
			{   
				if( ! $chkRemAmt)
				{
					$msg = "Amount To Be Transfered Can Not Be Greater Than Remaining Amount.!";
				}
			   elseif($rStatus > 0)
				{
					$msg = "Receiver Account Details is insufficient.!";
				}
				else
				{
					$msg = "Please Enter Require fields.!";
				}
				
				$this->session->set_flashdata('error_msg', $msg);
				redirect('buyer/initiate_refund/'.$auction_id);
				exit;

			} 
			else
			{
				$dOrder = $this->banker_model->save_initiate_refund();				
				redirect('buyer/initiate_refund_dashboard/'.$auction_id);
				exit;
			}
		}
	}
	
    public function initiate_refund_dashboard($auction_id = NULL) 
    {
		$data['heading'] = 'Initiate Refund Dashboard';
		$data['controller'] = 'buyer';
		$data['auction_id'] = $auction_id;
		//$auctionID = $this->uri->segment(3);
		$data['refundData'] = $this->banker_model->get_initiate_refund_data($auction_id);         
		$this->banker_header();        
		$this->load->view('banker_view/initiate_refund_dashboard', $data);
		$this->website_footer();
	   
	}
        
	public function initiate_transfer_dashboard($auction_id = NULL) 
	{
		$data['heading'] = 'Initiate Transfer Dashboard';
		$data['controller'] = 'buyer';
		$data['auction_id'] = $auction_id;
		$data['transferData'] = $this->banker_model->get_initiate_transfer_data($auction_id);         
		$this->banker_header();        
		$this->load->view('banker_view/initiate_transfer_dashboard', $data);
		$this->website_footer();
	   
	}
     
        
	public function get_remaining_account()
	{
		$array_records = $this->banker_model->get_remaining_account();
		echo json_encode($array_records);
	}
	
	public function input_credit_details($auctionID)
	{
            
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');
             
		if($aStatus >= 6)
		{
			$data['heading'] = 'H1 Bidder';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);			
			$data['inputCreditData'] = $this->banker_model->getInputCreditDataByAuctionId($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();
			$this->load->view('banker_view/input_credit_details', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}
	
	public function add_input_credit($auctionID)
	{
		
		$this->load->library('form_validation');			
		$auction_id = $this->input->post('auction_id');
		$this->form_validation->set_rules('instrument_no', 'Instrument No.', 'trim|required|xss_clean');
		$this->form_validation->set_rules('instrument_date', 'Instrument Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) 
		{
			$msg = "Please Enter Require fields.!";
			$this->session->set_flashdata('error_msg', $msg);
			redirect('buyer/input_credit_details/'.$auctionID);
			exit;
			
		} 
		else
		{
			if ($this->input->post('instrument_no') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('instrument_no'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/input_credit_details/'.$auctionID);
					exit;
				}
			}
			if ($this->input->post('instrument_date') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('instrument_date'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/input_credit_details/'.$auctionID);
					exit;
				}
			}
			if ($this->input->post('amount_paid') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('amount_paid'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/input_credit_details/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('remarks') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('remarks'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/input_credit_details/'.$auctionID);
					exit;
				}
			}
			
			$erows = $this->banker_model->add_input_credit($auctionID);				
			$msg = "Input Credit details save successfully.";
			$this->session->set_flashdata('message', $msg);    
			redirect('buyer/input_credit_details/'.$auctionID);
			exit;
		}			
			
			
	}
	
	public function create_demand_note($auctionID)
	{
            
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');

		if($aStatus >= 6)
		{
			$data['heading'] = 'H1 Bidder';
			$data['controller'] = 'buyer';
			$data['auction_data'] = $this->banker_model->viewReport($auctionID);			
			$data['demandNoteData'] = $this->banker_model->getDemandNoteDataByAuctionId($auctionID);
			$data['auctionID'] = $auctionID;
			$this->banker_header();
			$this->load->view('banker_view/create_demand_note', $data);
			$this->website_footer();
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}
	
	public function add_demand_note($auctionID)
	{
		
		$this->load->library('form_validation');			
		$auction_id = $this->input->post('auction_id');
		$this->form_validation->set_rules('demand_note_no', 'demand Note No.', 'trim|required|xss_clean');
		$this->form_validation->set_rules('demand_note_date', 'demand Note Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('percentage_payment', 'Payment Percentage', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) 
		{
			$msg = "Please Enter Require fields.!";
			$this->session->set_flashdata('error_msg', $msg);
			redirect('buyer/create_demand_note/'.$auctionID);
			exit;
			
		} 
		else
		{
			if ($this->input->post('demand_note_no') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('demand_note_no'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			if ($this->input->post('demand_note_date') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('demand_note_date'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			if ($this->input->post('lease_rate') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('lease_rate'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('site_plan_charges') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('site_plan_charges'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('bsup_rate') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('bsup_rate'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('total_amount_paid') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('total_amount_paid'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('percentage_payment') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('percentage_payment'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			
			if ($this->input->post('current_payment') != '') {
				$checkHTMLTags = $this->banker_model->checkHTMLTags($this->input->post('current_payment'));
				if ($checkHTMLTags == "1") {
					$this->session->set_flashdata("message", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
					redirect('buyer/create_demand_note/'.$auctionID);
					exit;
				}
			}
			$erows = $this->banker_model->add_demand_note($auctionID);				
			$msg = "Demand Note save successfully.";
			$this->session->set_flashdata('message', $msg);    
			redirect('buyer/create_demand_note/'.$auctionID);
			exit;
		}			
			
			
	}
        
        
    public function define_demand_note($auctionID)
	{
            
		$aStatus = GetTitleById('tbl_auction',$auctionID,'status');

		if($aStatus >= 6)
		{
			$data['controller'] = 'buyer';
			$data['auction_id'] = $auctionID;
			$data['tokens']     = $this->banker_model->get_all_token();
			//echo "<pre>"; print_r($data['tokens']); die;
			$data['demandNoteData'] = $this->banker_model->getDemandNoteDataByAuctionId($auctionID);
		   
			$this->load->view('banker_view/define_demand_note_popup', $data);
		}
		else
		{
			redirect('buyer/myActivity');
			exit;
		}
	}
    

}

?>
