<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
        $this->load->model('superadmin/user_model');
        $this->load->model('superadmin/bank_model');
        $this->load->model('home_model');
        $this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
        $this->check_isvalidated();
    }

    public function index($page_no) {
        $this->page($page_no);
    }

    public function indexhelp($page_no) {
        $this->pagehelp($page_no);
    }

    private function check_isvalidated() {
        if (!$this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }

    public function page($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user_registration');
        $data['heading'] = 'C1 User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
		//$search['status'] = $this->input->post('status1');
        //$search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//

        $per_page =50;
        $total_record = $this->user_model->GetTotalRecord1();

		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/index?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecords1($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/user', $data);
        $this->load->view('superadmin/footer');
    }

    /*     * *********** Start: User Block Attempt Code ******************** */

    // blockuser

    public function userblock($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user_registration');
        $data['heading'] = 'C1 User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->post('title');
        $search['status'] = $this->input->post('status1');
        $search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecorduserblock();
        $config['base_url'] = site_url() . 'superadmin/user/userblock';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecordsuserblock($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/userblock', $data);
        $this->load->view('superadmin/footer');
    }

    // blockbank user
    public function bankuserblock($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->post('title');
        $search['status'] = $this->input->post('status1');
        $search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//

        $per_page = 10;
        $total_record = $this->user_model->GetTotalRecordbankblock();
        $config['base_url'] = site_url() . 'superadmin/user/bankuserblock';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordsbankblock($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/bank-user-block', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeraddeditblock($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Branch User';
        } else {
            $data['heading'] = 'Add Bank Branch User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        $this->load->view('superadmin/add-edit-bankuser-block', $data);
        $this->load->view('superadmin/footer');
    }

    public function saveBankuser_block() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('superadmin/user/bankeraddeditblock');
        } else {
            $save = $this->user_model->save_data_banker_block();
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'Status updated successfully');
                } else {
                    $this->session->set_flashdata('message', 'Status updated successfully');
                }
                redirect('superadmin/user/bankuserblock');
            } else {
                redirect('superadmin/user/bankeraddeditblock');
            }
        }
    }

    //**** User Block

    public function addedituserblock($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit User';
        } else {
            $data['heading'] = 'Add User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param, $type = 'user');
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-user-block', $data);
        $this->load->view('superadmin/footer');
    }

    public function save_userblock() {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('comment', 'Comment', 'trim|required|xss_clean');
        //	$this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
        //if($this->form_validation->run() == FALSE){
        //echo 'ddfd44f';die;
        //redirect('superadmin/user/addedit');
        //redirect('superadmin/user/addedituserblock');
        //}
        //else{
        $save = $this->user_model->save_data_user_block();
        if ($save) {

            $id = $this->input->post('id');
            if ($id) {
                $this->session->set_flashdata('message', 'Status updated successfully');
            } else {
                $this->session->set_flashdata('message', 'Status updated successfully');
            }
            redirect('superadmin/user/userblock');
        } else {
            redirect('superadmin/user/addedituserblock/' . $id);
        }
        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-user-block', $data);
        $this->load->view('superadmin/footer');
    }

    /*     * *********** End: User Block Attempt Code ******************** */

    public function pagehelp($page_no) 
    {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user_registration');
        $data['heading'] = 'C1 User';

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecord1help();



		 $page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/indexhelp?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecords1help($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/userhelp', $data);
        $this->load->view('superadmin/footer');
    }

    public function banker($page_no) 
    {
        $data['heading']='Branch User';
		$data['type'] = 'banker';
		$this->load->view('superadmin/header', $data);		
		 
		//search query start//
		$search['departments'] 	= $this->input->get('departments'); 

		$data['search'] = $search;
		//serach query ends//
		$per_page=100;
        $total_record = $this->user_model->GetTotalRecord();

		$config['base_url'] = site_url() . 'superadmin/user/banker?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecords($offset, $per_page);

        $data['records'] = $array_records;
		$this->load->view('superadmin/bank-user', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeradmin($page_no) 
    {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_bank_admin');
        $data['heading'] = 'Bank Admin';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
	    //$search['status'] = $this->input->post('status1');
	    //$search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//
			
        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecordadmin();
		//echo $total_record;
		
		 $page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/bankeradmin?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordsadmin($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/bank-user-admin', $data);
        $this->load->view('superadmin/footer');
    }

    public function addedit($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit User';
        } else {
            $data['heading'] = 'Add User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param);
        } else {

            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;
        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-user', $data);
        $this->load->view('superadmin/footer');
    }

    public function addedithelp($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit User';
        } else {
            $data['heading'] = 'Add User';
        }

        if ($param) {

            $array_records = $this->user_model->GetRecordByIdhelp($param);
        } else {

            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;
        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-userhelp', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeraddedit($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Branch User';
        } else {
            $data['heading'] = 'Add Bank Branch User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;
        
        $departments = $this->bank_model->GetDeptRecord();
        $data['departments'] = $departments;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankuser', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function vieweraddedit($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Viewer User';
        } else {
            $data['heading'] = 'Add Bank Viewer User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;
		
		
      
		
        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankvieweruser', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeraddeditadmin($param) {

        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Admin';
        } else {
            $data['heading'] = 'Add Bank Admin';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordByIdbankadmin($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;
        
         
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankadmin', $data);
        $this->load->view('superadmin/footer');
    }

    public function addedituser($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit User';
        } else {
            $data['heading'] = 'Add User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param, $type = 'user');
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-user', $data);
        $this->load->view('superadmin/footer');
    }

    public function addedit_b2c($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit User';
        } else {
            $data['heading'] = 'Add User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordById($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;
        $countries = $this->bank_model->GetCountries();
        $data['countries'] = $countries;
        $states = $this->bank_model->GetState();
        $data['states'] = $states;
        $cities = $this->bank_model->GetCity();
        $data['cities'] = $cities;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        $this->load->view('superadmin/sidebar');
        $this->load->view('superadmin/add-edit-user-b2c', $data);
        $this->load->view('superadmin/footer');
    }

    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile', 'trim|required|xss_clean');
		
        if ($this->form_validation->run() == FALSE) {

            //redirect('superadmin/user/addedit');
        } else {
            $data['email_exists'] = '';
            if ($this->input->post('id')) {
                $input['email'] = $this->input->post('email_id');
                $input['id'] = $this->input->post('id');
            } else {
                $input['email'] = $this->input->post('email_id');
                $input['id'] = '';
            }
            $isValid = $this->user_model->checkDuplicateEmail($input);
            if (!$isValid) {
				
				
				$checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
				$checkHTMLTagsArr['password'] = $this->input->post('password');
				$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
				$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
				$checkHTMLTagsArr['designation'] = $this->input->post('designation');
				$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
				if(is_array($checkHTMLTagsArr))
				{
					foreach($checkHTMLTagsArr as $input)
					{
						if($input != ''){
							$checkHTMLTags = checkHTMLTags($input);
							if($checkHTMLTags == "1"){
									$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									$id = $this->input->post('id');
									if($id > 0)
									{
										redirect('superadmin/user/addedit/'.$id);
									}
									else
									{
										redirect('superadmin/user/addedit');
									}
							  }
						}
					}
				}
				
				
                $save = $this->user_model->save_data();
                if ($save) {
                    $id = $this->input->post('id');
                    if ($id) {
                        $this->session->set_flashdata('message', 'User is successfully updated');
                    } else {
                        $this->session->set_flashdata('message', 'User is successfully created');
                    }
                    redirect('superadmin/user/index');
                } else {
                    redirect('superadmin/user/addedit');
                }
            } else {
                $data['email_exists'] = 'Email "' . $input['email'] . ' "already exist.';
            }
        }
        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;
        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-user', $data);
        $this->load->view('superadmin/footer');
    }

    public function savehelp() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {

            //redirect('superadmin/user/addedit');
        } else {
            $data['email_exists'] = '';
            if ($this->input->post('id')) {
                $input['email'] = $this->input->post('email_id');
                $input['id'] = $this->input->post('id');
            } else {
                $input['email'] = $this->input->post('email_id');
                $input['id'] = '';
            }
            $isValid = $this->user_model->checkDuplicateEmailhelp($input);
            if (!$isValid) {
				
				$checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
				$checkHTMLTagsArr['password'] = $this->input->post('password');
				$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
				$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
				$checkHTMLTagsArr['designation'] = $this->input->post('designation');
				$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
				if(is_array($checkHTMLTagsArr))
				{
					foreach($checkHTMLTagsArr as $input)
					{
						if($input != ''){
							$checkHTMLTags = checkHTMLTags($input);
							if($checkHTMLTags == "1"){
									$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									$id = $this->input->post('id');
									if($id > 0)
									{
										redirect('superadmin/user/addedithelp/'.$id);
									}
									else
									{
										redirect('superadmin/user/addedithelp');
									}
							  }
						}
					}
				}
				
				
                $save = $this->user_model->save_datahelp();
                if ($save) {
                    $id = $this->input->post('id');
                    if ($id) {
                        $this->session->set_flashdata('message', 'User is successfully updated');
                    } else {
                        $this->session->set_flashdata('message', 'User is successfully created');
                    }
                    redirect('superadmin/user/indexhelp');
                } else {
                    redirect('superadmin/user/addedithelp');
                }
            } else {
                $data['email_exists'] = 'Email "' . $input['email'] . ' "already exist.';
            }
        }
        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-userhelp', $data);
        $this->load->view('superadmin/footer');
    }

    public function saveBankuser() {
		$id = $this->input->post('id');
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('branch_zone', 'Zone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_id', 'User', 'trim|required|xss_clean');
		if($id){}else{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean');
		}
		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile/Phone', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
			redirect('superadmin/user/bankeraddedit');
        } else {
			
			$checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
			$checkHTMLTagsArr['user_id'] = $this->input->post('user_id');
			$checkHTMLTagsArr['password'] = $this->input->post('password');
			$checkHTMLTagsArr['cpassword'] = $this->input->post('cpassword');
			$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
			$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
			$checkHTMLTagsArr['designation'] = $this->input->post('designation');
			$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
			if(is_array($checkHTMLTagsArr))
			{
				foreach($checkHTMLTagsArr as $input)
				{
					if($input != ''){
						$checkHTMLTags = checkHTMLTags($input);
						if($checkHTMLTags == "1"){
								$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
								$id = $this->input->post('id');
								if($id > 0)
								{
									redirect('superadmin/user/bankeraddedit/'.$id);
								}
								else
								{
									redirect('superadmin/user/bankeraddedit');
								}
						  }
					}
				}
			}
			
			
            $save = $this->user_model->save_data_banker($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'User is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'User is successfully created');
                }
                redirect('superadmin/user/banker');
            } else {
                redirect('superadmin/user/bankeraddedit');
            }
        }
    }
    
    public function saveBankuserviewer() {		
        $this->load->library('form_validation');
        $this->form_validation->set_rules('branch_bank', 'Bank', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('branch_zone', 'Zone', 'trim|required|xss_clean');

		$this->form_validation->set_rules('branch_region', 'Region', 'trim|required|xss_clean');
		$this->form_validation->set_rules('branch_user_type_id', 'Branch', 'trim|required|xss_clean');
		$this->form_validation->set_rules('role', 'User Category', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_id', 'Email ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_id', 'User', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean');

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile/Phone', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {			
            redirect('superadmin/user/vieweraddedit');
        } else {			
			$checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
			$checkHTMLTagsArr['user_id'] = $this->input->post('user_id');
			$checkHTMLTagsArr['password'] = $this->input->post('password');
			$checkHTMLTagsArr['cpassword'] = $this->input->post('cpassword');
			$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
			$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
			$checkHTMLTagsArr['designation'] = $this->input->post('designation');
			$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
			if(is_array($checkHTMLTagsArr))
			{
				foreach($checkHTMLTagsArr as $input)
				{
					if($input != ''){
						$checkHTMLTags = checkHTMLTags($input);
						if($checkHTMLTags == "1"){
								$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
								$id = $this->input->post('id');
								if($id > 0)
								{
									redirect('superadmin/user/vieweraddedit/'.$id);
								}
								else
								{
									redirect('superadmin/user/vieweraddedit');
								}
						  }
					}
				}
			}
			
			
			
            $save = $this->user_model->save_data_banker_viewer($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'Bank Viewer is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'Bank Viewer is successfully created');
                }
                redirect('superadmin/user/bankerviewer');
            } else {
                redirect('superadmin/user/vieweraddedit');
            }
        }
    }


	public function bankerviewer($page_no) 
    {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Bank User Viewer';
        $this->load->view('superadmin/header', $data);
        //search query start//
        $search['title'] = $this->input->get('title');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecordViewer();

		$config['base_url'] = site_url() . 'superadmin/user/bankerviewer?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordsViewer($offset, $per_page);

        $data['records'] = $array_records;

        $this->load->view('superadmin/bank-user-viewer', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function saveBankadmin() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
		 $this->form_validation->set_rules('branch_bank', 'Bank', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean');
		
		
        if ($this->form_validation->run() == FALSE) {
            redirect('superadmin/user/bankeraddeditadmin');
        } else {
			
			 
			$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
			$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
			$checkHTMLTagsArr['designation'] = $this->input->post('designation');
			$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
			$checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
			$checkHTMLTagsArr['user_id'] = $this->input->post('user_id');
			$checkHTMLTagsArr['password'] = $this->input->post('password');
			$checkHTMLTagsArr['cpassword'] = $this->input->post('cpassword');
			
			if(is_array($checkHTMLTagsArr))
			{
				foreach($checkHTMLTagsArr as $input)
				{
					if($input != ''){
						$checkHTMLTags = checkHTMLTags($input);
						if($checkHTMLTags == "1"){
								$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
								$id = $this->input->post('id');
								if($id > 0)
								{
									redirect('superadmin/user/bankeraddeditsuperadmin/'.$id);
								}
								else
								{
									redirect('superadmin/user/bankeraddeditadmin');
								}
						  }
					}
				}
			}
			
			
			
            $save = $this->user_model->save_data_bankeradmin($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'Bank Admin is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'Bank Admin is successfully created');
                }
                redirect('superadmin/user/bankeradmin');
            } else {
                redirect('superadmin/user/bankeraddeditadmin');
            }
        }
    }

    public function saveBankuserregion() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('superadmin/user/bankeraddeditregion');
            //echo '333';
        } else {
            //echo '444';
            $save = $this->user_model->save_data_bankerregion($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'Branch User is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'Branch User is successfully created');
                }
                redirect('superadmin/user/bankerregion');
            } else {
                redirect('superadmin/user/bankeraddeditregion');
            }
        }
    }

    public function saveBankuserzone() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('superadmin/user/bankeraddeditzone');
            //echo '333';
        } else {
            //echo '444';
            $save = $this->user_model->save_data_bankerzone($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'Zone User is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'Zone User is successfully created');
                }
                redirect('superadmin/user/bankerzone');
            } else {
                redirect('superadmin/user/bankeraddeditzone');
            }
        }
    }

    public function saveBankuserdrt() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email_id', 'Email', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('drt_user_type_id', 'DRT', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('designation', 'Designation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mobile_no', 'Mobile', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('superadmin/user/bankeraddeditdrt');
            //echo '333';
        } else {
            //echo '444';
            
            $checkHTMLTagsArr['email_id'] = $this->input->post('email_id');
				$checkHTMLTagsArr['password'] = $this->input->post('password');
				$checkHTMLTagsArr['cpassword'] = $this->input->post('cpassword');
				$checkHTMLTagsArr['first_name'] = $this->input->post('first_name');
				$checkHTMLTagsArr['last_name'] = $this->input->post('last_name');
				$checkHTMLTagsArr['designation'] = $this->input->post('designation');
				$checkHTMLTagsArr['mobile_no'] = $this->input->post('mobile_no');
				if(is_array($checkHTMLTagsArr))
				{
					foreach($checkHTMLTagsArr as $input)
					{
						if($input != ''){
							$checkHTMLTags = checkHTMLTags($input);
							if($checkHTMLTags == "1"){
									$this->session->set_flashdata("msg", "Invalid HTML OR TAGS(<) CONTENT FOUND!");
									$id = $this->input->post('id');
									if($id > 0)
									{
										redirect('superadmin/user/addedit/'.$id);
									}
									else
									{
										redirect('superadmin/user/addedit');
									}
							  }
						}
					}
				}
            
            $save = $this->user_model->save_data_bankerdrt($doc);
            if ($save) {
                $id = $this->input->post('id');
                if ($id) {
                    $this->session->set_flashdata('message', 'DRT User is successfully updated');
                } else {
                    $this->session->set_flashdata('message', 'DRT User is successfully created');
                }
                redirect('superadmin/user/bankerdrt');
            } else {
                redirect('superadmin/user/bankeraddeditdrt');
            }
        }
    }

    public function bankeraddeditregion($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Region User';
        } else {
            $data['heading'] = 'Add Bank Region User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordByIdregion($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankuser-region', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeraddeditzone($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank Zone User';
        } else {
            $data['heading'] = 'Add Bank Zone User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordByIdzone($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankuser-zone', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankeraddeditdrt($param) {
        if (is_numeric($param)) {
            $data['heading'] = 'Edit Bank DRT User';
        } else {
            $data['heading'] = 'Add Bank DRT User';
        }

        if ($param) {
            $array_records = $this->user_model->GetRecordByIddrt($param);
        } else {
            $array_records = array();
        }

        $data['row'] = $array_records;

        $zones = $this->bank_model->GetZoneRecord();
        $data['zones'] = $zones;
        $lho = $this->bank_model->GetlhoRecord();
        $data['lho'] = $lho;
        $regions = $this->bank_model->GetRegionRecord();
        $data['regions'] = $regions;
        $banks = $this->bank_model->GetBankRecords();
        $data['banks'] = $banks;
        $branchs = $this->bank_model->FilterBranchRecords();
        $data['branchs'] = $branchs;
        $drts = $this->bank_model->GetDrtRecords();
        $data['drts'] = $drts;
        $c1zones = $this->bank_model->GetC1zoneRecords();
        $data['c1zones'] = $c1zones;

        $roles = $this->role_model->GetRecords();
        $data['roles'] = $roles;

        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');		
        $this->load->view('superadmin/add-edit-bankuser-drt', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankerregion($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Region User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
        //$search['status'] = $this->input->post('status1');
        //$search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecordregion();
        
       /* $config['base_url'] = site_url() . 'superadmin/user/bankerregion';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;

        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';*/
        
        $page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/bankerregion?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);
        

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordsregion($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/bank-user-region', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankerzone($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Zone User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
       // $search['status'] = $this->input->post('status1');
       // $search['type'] = $this->input->post('type');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecordzone();

		 $page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/bankerzone?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordszone($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/bank-user-zone', $data);
        $this->load->view('superadmin/footer');
    }

    public function bankerdrt($page_no) {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'DRT User';
        $this->load->view('superadmin/header', $data);
        //$this->load->view('superadmin/sidebar');
        //search query start//
        $search['title'] = $this->input->get('title');
        $data['search'] = $search;
        //end search query start//
        $per_page = 10;
        $total_record = $this->user_model->GetTotalRecorddrt();

		 $page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/user/bankerdrt?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);


        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetRecordsdrt($offset, $per_page);

        $data['records'] = $array_records;
        $this->load->view('superadmin/bank-user-drt', $data);
        $this->load->view('superadmin/footer');
    }

    public function checkDuplicateEmail() {
        echo $this->user_model->checkDuplicateEmail($_POST);
    }
    
    
    function uniquecheckDuplicateEmailDRT()
	{
		$email_id=$this->input->get('email_id');
		$id=$this->input->get('id');
		echo $this->user_model->uniquecheckDuplicateEmailDRT($email_id,$id);
	}
	
	
    public function checkDuplicateEmailDRT() {
        echo $this->user_model->checkDuplicateEmailDRT($_POST);
    }

    public function checkDuplicateEmail_bank() {
        echo $this->user_model->checkDuplicateEmail_bank($_POST);
    }

    public function checkduplicateuseridexists() {
        //echo 'dfdf';die;
        //$user_id =  $this->input->post('user_id');
        echo $this->user_model->checkduplicateuseridexist($_POST);
    }

    public function checkduplicateuseridexistsadmin() {
        //echo 'dfdf';die;
        //$user_id =  $this->input->post('user_id');
        echo $this->user_model->checkduplicateuseridexistadmin($_POST);
    }

    /*
     * //User log 
     * Author:Amit Sahu
     * */

    public function userlog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeMISLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=User_log.csv');
                        echo "Email Id,User Type,IP Address,Login Time,Logout Time" . PHP_EOL;
                        foreach ($reportData as $row) {
							$userType = ($row->user_type == 'buyer') ? 'Branch User':'Bidder';
							$logoutTime = ($row->logout_datetime !='') ? date('d-m-Y_H:i:s', strtotime($row->logout_datetime)): '';
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $row->email_id . ',' . $userType . ',' . $row->ip_address . ',' . date('d-m-Y_H:i:s', strtotime($row->login_datetime)) . ',' . $logoutTime . '' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetUserTotalogs();        
        
        $config['base_url'] = site_url() . 'superadmin/user/userlog?k=2&';                         
        
        $config['base_url'] .= http_build_query($_GET, '', "&");
			
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		$config['page_query_string'] = TRUE;
		//$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
		$config['suffix'] = str_replace('?', '&', $config['suffix']);

		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

		if ($page_no == '')
			$limit = 0;
		else
			$limit = $config["per_page"] * ($page_no - 1);

		$offset = ($limit) ? $limit : 0;
        
        $array_records = $this->user_model->GetRecordsUserlogs($offset, $per_page);
        $data['records'] = $array_records;
        
        $start= (int)$this->uri->segment(4) * $config['per_page']+1;
		$end = ($this->uri->segment(4) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(4) * $config['per_page'] + $config['per_page'];

		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";
		
		
        $this->load->view('superadmin/bank-user-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function liveauctionlog($page_no) {
		$data = array();
		$data['auction_log_arr'] = array("Pause Auction","ResumeAuction","InvalidBid Submission","NormalBid Submission");        
        if ($this->input->get('submit')) {
            $submit = $this->input->get('submit');
            $data['Change_status'] = $this->input->get('Change_status');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auctionId'] = $this->input->get('auctionId');
                $data['eventId'] = $this->input->get('eventId');
                $data['createdby'] = $this->input->get('createdby');                
                if ($submit == 'Download') {
                    $reportData = $this->user_model->completeMISCorrigondomLogData_liveauction();
                    if (!empty($reportData)) {
                        header('Content-type: text/xls');
                        header('Content-disposition: attachment;filename=misreport.xls');
                        //echo "ID,Auction_ID,Log_Date_Time,Bank_Name,EventID,User_Type,User_id,IP_Address,Activity_Name" . PHP_EOL;
                        
                        $addAuctionLog = "";
                        if(!in_array($data['Change_status'], $data['auction_log_arr'])){
							 $addAuctionLog = ",Event Log ID";
						}
                        
                       // echo "Log ID,Activity Name,Operation".$addAuctionLog.",AuctionID,ClientAddress,Date,Email ID,UserCategory,BankName" . PHP_EOL;
                        echo "Activity Name,Operation".$addAuctionLog.",AuctionID,ClientAddress,Date,Email ID,UserCategory,BankName" . PHP_EOL;
                        foreach ($reportData as $row) {
							if($row->activity_done == 'Bidder participitated agreement Successfully')
							{
								$row->bid_type = 'Submit';
							}	
							 $addAuctionLog = "";
							if(!in_array($data['Change_status'], $data['auction_log_arr'])){
								 $addAuctionLog = ',' . $row->eventID ;
							}					
										
                           // echo $row->id . ','. $row->activity_done. ',' . $row->bid_type . $addAuctionLog . ',' . $row->auctionID . ',' . $row->ip_address . ',' . $row->indate . ',' . $row->email_id . ',' . $row->usercategory. ',' .$row->bankname . PHP_EOL;
                            echo $row->activity_done. ',' . $row->bid_type . $addAuctionLog . ',' . $row->auctionID . ',' . $row->ip_address . ',' . $row->indate . ',' . $row->email_id . ',' . $row->usercategory. ',' .$row->bankname . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        

			
			$per_page = 10;
			$total_record = $this->user_model->GetUserTotalcorrigndomlogs_liveauction();
			
			/*
			$config['base_url'] = site_url() . 'superadmin/user/liveauctionlog';
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';
			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();
			if ($page_no == '')
				$limit = 0;
			else
				$limit = $config["per_page"] * ($page_no - 1);

			$offset = ($limit) ? $limit : 0;*/
			
			$config['base_url'] = site_url() . 'superadmin/user/liveauctionlog?k=2&';
			$config['base_url'] .= http_build_query($_GET, '', "&");
			
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';
			$config['page_query_string'] = TRUE;
			//$config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
			$config['suffix'] = str_replace('?', '&', $config['suffix']);

			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();

			$page_no = $_GET['per_page'];

			if ($page_no == '')
				$limit = 0;
			else
				$limit = $config["per_page"] * ($page_no - 1);

			$offset = ($limit) ? $limit : 0;

			$array_records = $this->user_model->GetRecordscorrigndomUserlogs_liveauction($offset, $per_page);
		}
		$data['heading'] = 'Live Auction Log';
		$data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 5, $data['Change_status']);
		$this->load->view('superadmin/header', $data);
        $data['records'] = $array_records;
       // echo '<pre>';
        //print_r($data['records']);
       // die;
        $this->load->view('superadmin/live-auction-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function corrigendumlog($page_no) {
        $data = array();
        // if($this->input->post('submit')){
        if ($_GET['submit']) {
            $submit = $_GET['submit'];
            if (isset($submit) and ! empty($submit)) {
				
                  $data['from_date']=trim($_GET['from_date']);
                  $data['to_date']=trim($_GET['to_date']);
                  $data['auction_id']=trim($_GET['auction_id']);
                  
                if ($submit == 'Download') {
                    $reportData = $this->user_model->completeMISCorrigondomLogData();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=corrigendum_log.csv');                        
                        echo "S.No,Auction ID,Created Date,Old Scheme/Property Address,New Scheme/Property Address,Old Press Release Date,New Press Release Date,Old Bid Increment Value,New Bid Increment Value,Old Application/EMD Start Date,New Application/EMD Start Date,Old Application/EMD End Date,New Application/EMD End Date,Old Auction Start Date,New Auction Start Date,Old Auction End Date,New Auction End Date,Remarks,Email ID,Client Address" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;                            
							
                            echo $i . ',' . $row->auctionID .','. date('d-m-Y_H:i:s',strtotime($row->indate)). ',' . str_replace(',' ,'', $row->old_product_description) . ',' . str_replace(',' ,'', $row->product_description) . ',' . date('d-m-Y_H:i:s',strtotime($row->old_NIT_date)) . ',' . date('d-m-Y_H:i:s',strtotime($row->NIT_date)) . ',' . $row->old_bid_inc . ',' . $row->bid_inc . ',' . date('d-m-Y_H:i:s',strtotime($row->old_bid_opening_date)) . ',' . date('d-m-Y_H:i:s',strtotime($row->bid_opening_date)) . ',' . date('d-m-Y_H:i:s',strtotime($row->old_bid_last_date)) . ',' . date('d-m-Y_H:i:s',strtotime($row->bid_last_date)). ',' . date('d-m-Y_H:i:s',strtotime($row->old_auction_start_date)). ',' .	date('d-m-Y H:i:s',strtotime($row->auction_start_date)). ',' . date('d-m-Y_H:i:s',strtotime($row->old_auction_end_date)) . ',' . date('d-m-Y_H:i:s',strtotime($row->auction_end_date)) . ',' . $row->remarks . ',' . $row->email_id . ',' . $row->ip_address. PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        $data['heading'] = 'Bank User';
        $data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 6, $activity_done);
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->user_model->GetUserTotalcorrigndomlogs();
        $config['base_url'] = site_url() . 'superadmin/user/corrigendumlog?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['suffix'] = str_replace('?', '&', $config['suffix']);
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        
        $page_no = $_GET['per_page'];
        if ($page_no == '') {
            $limit = 0;
        } else {
            $limit = $config["per_page"] * ($page_no - 1);
        }
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecordscorrigndomUserlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/corrigndom-user-log', $data);
        $this->load->view('superadmin/footer');
    }

	public function bidderfinalsubmissionlog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completefinalsubmissionLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=bidder_final_submission_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP,Date,Action,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$status = ($row->final_submit==1)?'Final Submitted':'Not Final Submitted';                           
                            echo $i . ',' . $row->auctionID . ',' .$bidderName . ',' . $row->final_submit_ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->final_submit_date)) . ',' . $status . ',' . $row->final_submit_message . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder Final Submission Logs';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalfinalsubmissionlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidderfinalsubmissionlog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetFinalSubmissionLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bidder_final_submission_log', $data);
        $this->load->view('superadmin/footer');
    }
    
	
	public function iagreelog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeiagreelogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=bidder_participitated_agreement_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP,Date,Action,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$status = ($row->is_accept_tc==1)?'Accepted':'Not Accepted';                           
                            echo $i . ',' . $row->auctionID . ',' .$bidderName . ',' . $row->is_accept_tc_ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->is_accept_tc_date)) . ',' . $status . ',' . $row->is_accept_tc_message . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder Final Submission Logs';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotaliagreelogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/iagreelog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetIAgreeLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/i_agree_log', $data);
        $this->load->view('superadmin/footer');
    }
	
	
	public function auctiontraininglog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeauctiontraininglogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=auction_training_acceptance_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP,Date,Action,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$status = ($row->is_accept_auct_training==1)?'Accepted':'Not Accepted';                           
                            echo $i . ',' . $row->auctionID . ',' .$bidderName . ',' . $row->is_accept_auct_training_ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->is_accept_auct_training_date)) . ',' . $status . ',' . $row->is_accept_auct_training_message . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Auction Training Acceptance Log';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalauctiontrainingloglogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/auctiontraininglog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetAuctionTrainingLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/auction_training_acceptance_log', $data);
        $this->load->view('superadmin/footer');
    }
	
    public function bidopeninglog($page_no) {
        $data = array();
        if ($this->input->get('submit')) {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auctionId'] = $this->input->get('auctionId');                
                if ($submit == 'Download') {
                    $reportData = $this->user_model->completeMISbidopeningLogData();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bid_opening_log_list.csv');
                        //echo 'id,eventID,bankname,user_type,auctionID,bidder_id,indate,status,ip_address,message' . PHP_EOL;
                        echo 'S.No.,Auction Id,Activity Name,IP Address,Date,Buyer Email ID,Bidder Email ID' . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							if($row->emailid){$remailId = $row->emailid;}else{$remailId = 'Not applicable';}                           
                            echo $i .','. $row->auctionID . ',' . str_replace(' ', '_', $row->message) . ',' . $row->ip_address. ',' . date('d-m-Y_H:i:s', strtotime($row->indate)) .',' . $row->email_id.','. $remailId . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        $data['heading'] = 'Bank User';
        $data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 4, $data['Change_status']);
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->user_model->GetUserTotalbidopeninglogs();
    	$config['base_url'] = site_url() . 'superadmin/user/bidopeninglog?k=2&';
		$config['base_url'] .= http_build_query($_GET, '', "&");        
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		$config['page_query_string'] = TRUE;        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
		$config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecordsbidopeningUserlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bid-opening-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function bidsubmissionlog($page_no) {
        $data = array();
        if ($this->input->get('submit') && $this->input->get('Change_status') != '') {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auctionId'] = $this->input->get('auctionId');
                $data['eventId'] = $this->input->get('eventId');
                $data['createdby'] = $this->input->get('createdby');
                $data['Change_status'] = $this->input->get('Change_status');
                if ($submit == 'Download') {
                    $reportData = $this->user_model->completeMISbidsubmissionLogData();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.xls');
                        //echo 'id,eventID,bankname,bank_user_id,user_type,auctionID,bidder_id,indate,status,ip_address,message' . PHP_EOL;
                        echo 'Event ID,Organization Name,User Type,Auction ID,Bidder Email ID,Indate,IP Address,Message' . PHP_EOL;
                        foreach ($reportData as $row) {
                            //echo $row->id . ',' . $row->eventID . ',' . str_replace(' ', '_', $row->bankname) . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->auctionID . ',' . $row->bidder_id . ',' . date('d-m-Y_h:i:s', strtotime($row->indate)) . ',' . $row->status . ',' . $row->ip_address . ',' . str_replace(' ', '_', $row->message) . PHP_EOL;
                            echo $row->eventID . ',' . str_replace(' ', '_', $row->bankname) . ',' . $row->user_type . ',' . $row->auctionID . ',' . $row->email_id . ',' . date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' . $row->ip_address . ',' . str_replace(' ', '_', $row->message) . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        
        
			$per_page = 10;
			$total_record = $this->user_model->GetUserTotalbidsubmissionlogs();

			/*$config['base_url'] = site_url() . 'superadmin/user/bidsubmissionlog';
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';
			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();

			if ($page_no == '')
				$limit = 0;
			else
				$limit = $config["per_page"] * ($page_no - 1);
			$offset = ($limit) ? $limit : 0;*/
			
			$config['base_url'] = site_url() . 'superadmin/user/bidsubmissionlog?k=2&';
			$config['base_url'] .= http_build_query($_GET, '', "&");        
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';
			$config['page_query_string'] = TRUE;        
			$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
			$config['suffix'] = str_replace('?', '&', $config['suffix']);
			
			
			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();

			$page_no = $_GET['per_page'];

			if ($page_no == '')
				$limit = 0;
			else
				$limit = $config["per_page"] * ($page_no - 1);

			$data['offset'] = ($limit) ? $limit : 0;  
			
			$array_records = $this->user_model->GetRecordsbidsubmissionUserlogs($data['offset'], $per_page);
        
		}
        $data['heading'] = 'Bid Submission Log List';
        $data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 3, $data['Change_status']);
        $this->load->view('superadmin/header', $data);
        
        $data['records'] = $array_records;
        $this->load->view('superadmin/bid-submission-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function masterlog($page_no) {
        $data = array();
        if ($this->input->post('submit')) {
            $submit = $this->input->post('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->post('from_date');
                $data['to_date'] = $this->input->post('to_date');
                $data['createdby'] = $this->input->post('createdby');
                $data['Change_status'] = $this->input->post('Change_status');
                if ($submit == 'Download') {
                    $reportData = $this->user_model->completeMISregistrationLogData(2);
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.csv');
                        //echo "ID,Activity_done,email_id,USER_Id,Ip_Address,User_Type,Registration_Date,status" . PHP_EOL;
                        echo "Activity_done,Operation,IP Address,User_Type,Date" . PHP_EOL;
                        foreach ($reportData as $row) {
                            //echo $row->id . ',' . str_replace(' ', '_', $row->message) . ',' . $row->email_id . ',' . $row->user_id . ',' . $row->ip_address . ',' . $row->user_type . ',' . date('d-m-Y_h:i:s', strtotime($row->indate)) . ',' . $row->status . PHP_EOL;
                           echo str_replace(' ', '_', $row->message) . ',' . 'Submit'. ',' . $row->ip_address . ',' . $row->user_type . ',' . date('d-m-Y_H:i:s', strtotime($row->indate)) . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        $data['heading'] = 'Master Logs';
        $data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 10, $data['Change_status']);
        $this->load->view('superadmin/header', $data);
        $per_page = 10;
        $total_record = $this->user_model->GetUserTotalregistrationlogs(2);
        $config['base_url'] = site_url() . 'superadmin/user/masterlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;
        $array_records = $this->user_model->GetRecordsregistrationUserlogs($offset, $per_page, 2);
    
        $data['records'] = $array_records;
        $this->load->view('superadmin/user-register-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function masterlogreports($page_no) {
        $data = array();
        if ($this->input->get('submit') and $this->input->get('Change_status') != '') {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['createdby'] = $this->input->get('createdby');
                $data['Change_status'] = $this->input->get('Change_status');
                if ($submit == 'Download') {					
                    $reportData = $this->user_model->completeMISreportsLogData();
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=misreport.xls');
                       // echo "Log ID,Activity Name,Operation,Client Address,Date,User ID,User Category,status" . PHP_EOL;
                        echo "Auction ID, Activity Name,Operation,Client Address,Date,Email ID" . PHP_EOL;
                        foreach ($reportData as $row) {
							if($row->user_type == 'owner')
							{
							  $row->user_type = 'individual';
							}
							else if($row->user_type == 'builder')
							{
								$row->user_type = 'Organization';
							}
                           // echo $row->id . ',' . str_replace(' ', '_', $row->message) . ','.$row->action_type_event.',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->indate)) . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->status . PHP_EOL;
                            echo $row->auction_id.',' .str_replace(' ', '_', $row->message) . ','.$row->action_type_event.',' . $row->ip_address . ',' . date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' . $row->email_id . PHP_EOL;
                        }
                        die;
                    }
                }
            }
       
			
			$per_page = 10;
			$total_record = $this->user_model->GetUserTotalreportslogs();
			
			$page_no = $this->input->get('per_page');
			$config['base_url'] = site_url() . 'superadmin/user/masterlogreports?k=2&';
			$config['base_url'] .= http_build_query($_GET, '', "&");        
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';
			$config['page_query_string'] = TRUE;        
			$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
			$config['suffix'] = str_replace('?', '&', $config['suffix']);
			
			
			/*$config['base_url'] = site_url() . 'superadmin/user/masterlogreports';
			$config['total_rows'] = $total_record;
			$config['per_page'] = $per_page;
			$config["uri_segment"] = 4;
			$config['cur_tag_open'] = '<li><a class="current">';
			$config['cur_tag_close'] = '</a></li>';*/
			
			
			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();

			if ($page_no == '')
				$limit = 0;
			else
				$limit = $config["per_page"] * ($page_no - 1);
			$offset = ($limit) ? $limit : 0;
			$array_records = $this->user_model->GetRecordsreportsUserlogs($offset, $per_page, 2);
			$data['records'] = $array_records;
			//$this->load->view('superadmin/bidder-register-log', $data);
		}
		$data['heading'] = 'Reports Log';
		$data['subcatdata'] = $this->user_model->fetchmodulesubcategory($id = 7, $data['Change_status']);
		$this->load->view('superadmin/header', $data);
			
        $this->load->view('superadmin/complete-report-log', $data);
        $this->load->view('superadmin/footer');
    }

    public function replaceComma($field) {
        return str_replace(',', ' ', $field);
    }

   public function bidsubmitlog($page_no) {
        if ($this->input->get('submit')) 
        { 
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
   
                if ($submit == 'Download') 
                { 
                    // if($this->input->post('from_date') && $this->input->post('to_date')){
					
                    $reportData = $this->user_model->completeBidsubmitLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bid_Submission_log.csv');
                        echo "Auction Id,Email ID,Bid Value,Indate,IP Address,in Milisecond" . PHP_EOL;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                           $dateMiliArr = explode('.',$row->modified_date);
                           $mDate = date('d-m-Y_H:i:s', strtotime($dateMiliArr[0])).'.'.$dateMiliArr[1];
                            echo $row->auctionID . ',' . $row->email_id . ',' . $row->bid_value . ',' .  date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' . $row->ip . ',' .  $mDate . '' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }
        
         

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalbidlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidsubmitlog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetBidSubmissionlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bid_submit_log', $data);
        $this->load->view('superadmin/footer');
    }
    
     public function finalapproverLog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completefinalApprovalLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Final_approverlog.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP,Date,Action,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$status = ($row->operner2_accepted==1)?'Accepted':'Rejected';
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $i . ',' . $row->auctionID . ',' .$bidderName . ',' . $row->opener2_accepted_ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->opener2_accepted_date)) . ',' . $status . ',' . $row->operner2_comment . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Final Approver Logs';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalapproverlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/finalapproverLog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetFinalApproverlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/final_approver_log', $data);
        $this->load->view('superadmin/footer');
    }

   public function invalid_bid_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeInvalidLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=InvalidBid_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,Bid Value,Indate,Message" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$i++;
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $i . ',' . $row->auctionID . ',' . $bidderName . ',' . $row->bid_value . ',' . date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' . $row->message . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalinvalidlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/invalid_bid_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->InvalidBidlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/invalid_bid_log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function document_approver_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeDocApproverLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=DocApprover_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP Address,Accepted Date,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
                            echo $i . ',' . $row->auctionID . ',' . $bidderName. ',' . $row->opener1_accepted_ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->opener1_accepted_date)) . ',' . $row->operner1_comment . ',' .  PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetdocApproverlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/document_approver_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->Doc_Approver_logs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/doc_approver_log', $data);
        $this->load->view('superadmin/footer');
    }
    
     public function payment_approver_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                
               
                
                if ($submit == 'Download') 
                {
					
					
                    // if($this->input->post('from_date') && $this->input->post('to_date')){
				
                    $reportData = $this->user_model->completePaymentApproverLogData();
                    //print_r($reportData);die;
                    /*echo '<pre>';
                    print_r($reportData);
                    echo '</pre>';die;*/
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Paymentapproval_log.csv');
                        echo "S.No.,Auction Id,Bidder Name,IP Address,Accepted Date,Action,Comments" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$action = ($row->payment_verifier_accepted == 1)?"Accepted":"Rejected";
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
                           
                            echo $i . ',' . $row->auctionID . ',' . $bidderName . ',' . $row->payment_verifier_accepted_ip . ',' . date('d-m-Y_H:i:s', strtotime($row->payment_verifier_accepted_date)) . ',' .  $action.','.$row->payment_verifier_comment . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetpaymentApproverlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/payment_approver_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->Payment_Approver_logs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/payment_approver_log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function payment_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                $data['track_id'] = $this->input->get('track_id');
                $data['ref_number'] = $this->input->get('ref_number');
                $data['email_id'] = $this->input->get('email_id');
                $data['payment_status'] = $this->input->get('payment_status');
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completePaymentLogData();
                   
                   
                    //echo '<pre>';
                   
                    
                    $pay_req = json_decode($reportData->payment_request);
					$pay_res = json_decode($reportData[1]->payment_response);
					
					
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=payment_log.csv');
                        echo "S.No.,Auction ID,Scheme Code,Scheme Name,Scheme Address,Bidder Email,Tracking ID,Payment Mode,Reference No.,Amount (Rs.),Date,IP Address,Transaction Status" . PHP_EOL;
                        $i=1;
                        foreach ($reportData as $row) {
							$scheme_code = GetTitleByField('tbl_auction',"id='".$row->auction_id."'",'reference_no');
							$scheme_name = GetTitleByField('tbl_auction',"id='".$row->auction_id."'",'scheme_name');
							$scheme_name = str_replace(',','',$scheme_name);
							$scheme_address = GetTitleByField('tbl_auction',"id='".$row->auction_id."'",'PropertyDescription');
							$scheme_address = str_replace(',','',trim($scheme_address));
							$pay_res = json_decode($row->payment_response);														
							$payment_mode = ($pay_res != '' && $pay_res->payment_mode != 'null') ? $pay_res->payment_mode :'--' ;
							$trans_date = ($pay_res != '' && $pay_res->trans_date != 'null') ? $pay_res->trans_date :'--' ;	
							$RefNo = ($pay_res != '' && $pay_res->bank_ref_no != 'null') ? $pay_res->bank_ref_no :'--' ;		
							$amount = (float)$pay_res->merchant_param2;	
							$trans_date = ($pay_res != '' && $pay_res->trans_date != 'null') ? $pay_res->trans_date :$row->date_created ;
								
                          echo $i . ',' . $row->auction_id . ',' . $scheme_code . ',' . $scheme_name . ',' . $scheme_address . ',' .$pay_res->billing_email . ',' . $pay_res->tracking_id. ',' . $payment_mode . ',' . $RefNo . ',' . $amount . ',' . $trans_date . ',' . $row->bidder_IP . ',' . $row->payment_status . ',' . PHP_EOL;
                        $i++;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalPaymentlogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/payment_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->paymentLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/payment_log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function registration_payment_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['auction_id'] = $this->input->get('auction_id');
                $data['track_id'] = $this->input->get('track_id');
                $data['ref_number'] = $this->input->get('ref_number');
                $data['email_id'] = $this->input->get('email_id');
                $data['payment_status'] = $this->input->get('payment_status');
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeRegistrationPaymentLogData();
                   
                   
                    //echo '<pre>';
                   
                    
                    $pay_req = json_decode($reportData->payment_request);
					$pay_res = json_decode($reportData[1]->payment_response);
					
					
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=payment_log.csv');
                        echo "S.No.,Bidder Email,Tracking ID,Payment Mode,Bank Reference No.,Amount (Rs.),Date,IP Address,Transaction Status" . PHP_EOL;
                        $i=1;
                        foreach ($reportData as $row) {
							$pay_res = json_decode($row->data);				
							$tracking_id = ($pay_res != '' && $pay_res != null) ? $pay_res->tracking_id :'--';
							$payment_mode = ($pay_res != '' && $pay_res != null && $pay_res->payment_mode != 'null') ? $pay_res->payment_mode :'--';
							$bank_ref_no = ($pay_res->bank_ref_no != '' && $pay_res->bank_ref_no != 'null') ? $pay_res->bank_ref_no :'--' ;
							$payu_amount = ($pay_res != '' && $pay_res != null) ? $pay_res->mer_amount :$row->payu_amount.'.00';
							$payDate = str_replace('/','-',$pay_res->trans_date);
							$trans_date = ($pay_res != '' && $pay_res != null && $payDate !='null') ? $payDate :date('d-m-Y H:i:s',strtotime($row->sendTime));
							$paymentStatus = ($pay_res->order_status !='')?ucfirst($pay_res->order_status):ucfirst($row->paymentStatus);
                          echo $i . ',' . $row->payu_email . ',' . $tracking_id . ',' . $payment_mode . ',' . $bank_ref_no . ',' .$payu_amount .  ',' . $trans_date . ',' . $row->ip . ',' . $paymentStatus . ',' . PHP_EOL;
                        $i++;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalRegistrationPaymentlogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/registration_payment_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->registrationPaymentLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/registration_payment_log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function bidderegisterlog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeBidderRegLogData();
                   
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=BidderReg_log.csv');
                        echo "S.No,Bidder Name,Email ID,User Type,Mobile No.,IP Address,Date,Address,Remarks" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;
							$userType = ($row->user_type == 'buyer') ? 'Branch User':'Bidder';
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $i . ',' . $bidderName . ',' . $row->email_id . ',' . $userType . ',' . $row->mobile_no . ',' .  $row->ip_address . ',' .  date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' .  str_replace(',',' ',$row->address1) . ',' . $row->remark . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder Registration Log';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetBidder_Reg_logs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidderegisterlog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetBidder_Reglogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bidder-register-log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function bidder_list($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
				$data['email_id'] = $this->input->get('email_id');
               
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeBidderListData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bidder_list.csv');
                        echo "S.No,First Name,Last Name,Email ID,Mobile No." . PHP_EOL;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $row->id . ',' . $row->first_name . ',' . $row->last_name 	 . ',' . $row->email_id . ',' . $row->mobile_no . ',' .    PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder List';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetBidder_list();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidder_list?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetBidder_listing($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bidder_list', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function change_status($bidderId)
    {
		$this->db->where('id',$bidderId);
		$uQry = $this->db->get('tbl_user_registration');
		if($uQry->num_rows()>0)
		{
			$rows = $uQry->result();
			
			if($rows[0]->status==1)
			{
				$status = 0;
				$verify_status = 0;
			}
			else
			{
				$status = 1;
				$verify_status = 1;
			}
			$this->db->where('id',$rows[0]->id);
			$this->db->update('tbl_user_registration',array('status'=>$status,'verify_status'=>$verify_status));
			$this->session->set_flashdata('message','Status updated successfully');	
					
		}
		redirect('superadmin/user/bidder_list');die;
		
	}
    
    public function jda_user_list($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
              
               $data['email_id'] = $this->input->get('email_id');
                
               
                
                if ($submit == 'Download') 
                {
					
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeJDAListData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=JDA_uSer_list.csv');
                        echo "S.No,First Name,Last Name,Email ID,Mobile No.,Department Id,Department Name,Roles" . PHP_EOL;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $row->id . ',' . $row->first_name . ',' . $row->last_name 	 . ',' . $row->email_id . ',' . $row->mobile_no . ',' .$row->department_id . ',' .$row->department_name . ',' .$row->name . ',' .  PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder List';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetJDA_list();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidder_list?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetJDA_listing($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/jdaUser_list', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function awardedList_log($page_no) {
     if ($this->input->get('submit')) 
        { 
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['reference_no'] = $this->input->get('reference_no');
   
                if ($submit == 'Download') 
                { 
                    // if($this->input->post('from_date') && $this->input->post('to_date')){
					
                    $reportData = $this->user_model->completeAwardedListLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Awarded_List.csv');
                        echo "S.No,Auction ID, Scheme Code,H1 Bidder,Bidder Application No.,H1 Price,Awarded By,Date,IP Address" . PHP_EOL;
                        $sn=1;
                        foreach ($reportData as $row) {
							$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->bidder_name;
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                           $dateMiliArr = explode('.',$row->modified_date);
                           $mDate = date('d-m-Y_H:i:s', strtotime($dateMiliArr[0])).'.'.$dateMiliArr[1];
                           $appNo = $row->email_id.'/'.$row->auctionID;
                             echo $sn. ',' . $row->auctionID . ',' . $row->reference_no . ',' . $bidderName . ',' . $appNo . ','. $row->h1_price . ','. $row->awarded_by_name . ',' . date('d-m-Y_H:i:s', strtotime($row->awarded_date)) . ',' . $row->awarded_ip . ',' .  PHP_EOL;
                           $sn++;  
                        }
                        die;
                    }
                }
            }
        }
        
         

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->Gettotalawardedlogs();
        
        
        
        
        
        $config['base_url'] = site_url() . 'superadmin/user/awardedList_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetAwardedListlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/awarded_list_log', $data);
        $this->load->view('superadmin/footer');
    }
    public function not_awardedList_log($page_no) {
     
     if ($this->input->get('submit')) 
        { 
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
               
                $data['reference_no'] = $this->input->get('reference_no');
   
                if ($submit == 'Download') 
                { 
                    // if($this->input->post('from_date') && $this->input->post('to_date')){
					
                    $reportData = $this->user_model->completeNotAwardedListLogData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Not_Awarded_logList.csv');
						echo "S.No,Auction ID, Scheme Code,H1 Bidder,Bidder Application No.,H1 Price,Awarded By,Date,IP Address" . PHP_EOL;
                        $sn=1;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                           $dateMiliArr = explode('.',$row->modified_date);
                           $mDate = date('d-m-Y_H:i:s', strtotime($dateMiliArr[0])).'.'.$dateMiliArr[1];                           
                           $appNo = $row->email_id.'/'.$row->auctionID;
                           $bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->bidder_name;
                             echo $sn. ',' . $row->auctionID . ',' . $row->reference_no . ',' . $bidderName . ',' . $appNo . ','. $row->h1_price . ',' . $row->awarded_by_name . ',' . date('d-m-Y_H:i:s', strtotime($row->awarded_date)) . ',' . $row->awarded_ip . ',' .  PHP_EOL;
                           $sn++;  
                        }
                        die;
                    }
                }
            }
        }
        
         

        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalNotawardedlogs();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
         
        $config['base_url'] = site_url() . 'superadmin/user/not_awardedList_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
         
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        
		
        $array_records = $this->user_model->GetNotAwardedListlogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/not_awardedList_log', $data);
        $this->load->view('superadmin/footer');
    }
    
		
     public function assigndept(){
		
	    
	   $user_id = $this->uri->segment(4);
		$data['roles'] = $this->role_model->GetRecords();
       $data['user_id'] = $user_id;
        
        $data['assigned_depts'] = $this->bank_model->GetAssigned_dept();
        //print_r($data['assigned_depts']);die;
       
        $this->load->view('superadmin/header', $data);	
        
        $data = array();
		if($this->uri->segment(4) === False){}else{
			 $user_id = $this->uri->segment(4);
			 $data['depts'] = $this->bank_model->GetDeptRecord();;
			 $data['depName'] = $this->bank_model->GetAssigned_dept($user_id);
			 //print_r($data['depName']);die;
		}  
        $this->load->view('superadmin/assign_dept', $data);
		$this->load->view('superadmin/footer');
	
	}
		
	public function assignrole(){
		
		$data['user_id'] = $this->uri->segment(4);
		$data['department_id'] = $this->uri->segment(5);
		$data['roles'] = $this->role_model->GetRecords();
        $data['depts'] = $this->bank_model->GetDeptRecord();
        $data['assigned_roles'] = $this->bank_model->GetAssigned_roles();
        //echo '<pre>';
        //print_r($data['assigned_roles']);die;
       
        $this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/assign_role', $data);
		$this->load->view('superadmin/footer');
	
		}
	public function assign_role(){
	
	    $data['user_id'] = $this->uri->segment(4);
		$data['department_id'] = $this->uri->segment(5);
		$roleArr = $this->input->post('role');
		
		if(count($roleArr) > 0){
				$this->bank_model->addUserRole($user_id,$department_id);
				redirect('superadmin/user/assignRolelist' );
		}
		else{
			redirect('superadmin/user/assignrole');
		}
			
		}
	
	public function assign_dept(){
		
		$user_id = $this->uri->segment(4);
		$data['user_id'] =$user_id;
		$departmentArr = $this->input->post('departments');
		
		if(count($departmentArr) > 0){
				$this->bank_model->addUserDept($user_id);
				redirect('superadmin/user/assignDeptlist/'.$data['user_id'] );
		}
		else{
			redirect('superadmin/user/assign_dept/'.$data['user_id'] );
		}
			
		}
			
	public function addDepCategorybyBranchId($user_id){

	$data['user_id'] = $this->uri->segment(4);
	$data['depts'] = $this->bank_model->GetDeptRecord();
	$user_id = $this->uri->segment(4);
	$this->bank_model->addDepCategorybyBranchId($user_id);
	
	}
	
	public function assignDeptlist($page_no) 
    {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        //search query start//
        $search['title'] = $this->input->get('title');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecord();

		$config['base_url'] = site_url() . 'superadmin/user/banker?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetAssignedDepts($offset, $per_page);

        $data['records'] = $array_records;	

        $this->load->view('superadmin/assigned_deptlist', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function assignRolelist($page_no) 
    {
        if ($this->input->post('submit'))
            $this->updateStatus('tbl_user');
        $data['heading'] = 'Bank User';
        $this->load->view('superadmin/header', $data);
        //search query start//
        $search['title'] = $this->input->get('title');
        $data['search'] = $search;
        //end search query start//

        $per_page = 50;
        $total_record = $this->user_model->GetTotalRecord();

		$config['base_url'] = site_url() . 'superadmin/user/banker?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;

        $array_records = $this->user_model->GetAssignedRoles($offset, $per_page);

        $data['records'] = $array_records;
        //print_r( $data['records']);die;

        $this->load->view('superadmin/assigned_rolelist', $data);
        $this->load->view('superadmin/footer');
    }
    
    
    public function bidderforgotpasslog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->bidder_forgot_pass_csv_data();
                   
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bidder_forgot_password_log.csv');
                        echo "S.No,Email ID,IP Address,Date" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							//$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;                           
                            //echo $i . ',' . $bidderName . ',' . $row->email_id . ',' . $row->mobile_no . ',' .  $row->ip_address . ',' .  date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' .  $row->address1 . ',' . PHP_EOL;
                            echo $i . ',' . $row->email_id . ',' .  $row->ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->in_date_time)) . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder Forgot Password Log';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->bidder_forgot_pass_total_data();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidderforgotpasslog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->bidder_forgot_pass_listing_data($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bidder-forgot-password-log', $data);
        $this->load->view('superadmin/footer');
    }
	
	
	public function bidderresetpasslog($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                
               
                
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->bidder_reset_pass_csv_data();
                   
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bidder_reset_password_log.csv');
                        echo "S.No,Email ID,Remkars,IP Address,Date" . PHP_EOL;
                        $i=0;
                        foreach ($reportData as $row) {
							$i++;
							//$bidderName = ($row->user_type == 'builder') ? $row->organisation_name : $row->first_name.' '.$row->last_name;                           
                            //echo $i . ',' . $bidderName . ',' . $row->email_id . ',' . $row->mobile_no . ',' .  $row->ip_address . ',' .  date('d-m-Y_H:i:s', strtotime($row->indate)) . ',' .  $row->address1 . ',' . PHP_EOL;
                            echo $i . ',' . $row->email_id . ',' .  $row->remark . ',' . $row->ip . ',' .  date('d-m-Y_H:i:s', strtotime($row->createTime)) . ',' . PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder Reset Password Log';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->bidder_reset_pass_total_data();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/bidderresetpasslog?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->bidder_reset_pass_listing_data($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/bidder-reset-password-log', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function gst_mis_report_registration_fee($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['track_id'] = $this->input->get('track_id');
                $data['email_id'] = $this->input->get('email_id');
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeGSTRegData();
                   
                   
                    //echo '<pre>';
                   
                    
                    $pay_res = json_decode($reportData[1]->data);
					
					
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('GST MIS Report Registration Fee');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
						 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Company Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Customer Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Email Address');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Contact Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Address of Customer');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Place of Supply');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Address of Delivery');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'GST Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Description Of Service');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Base Amount');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Rate of tax (%)');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Total Tax Applicable');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Net Amount Paid');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Payment Date');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Payment Mode');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Transaction Number');
						
						
						$sn=1;	
						foreach ($reportData as $row) {
							
							$i = ++$i;
							
							$organisation_name = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'organisation_name');
							$organisation_name = ($organisation_name != '')? $organisation_name:'N/A'; 
							if($organisation_name !='N/A')
							{
								$customerName = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'authorized_person');
							}
							else
							{
								$fname = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'first_name');
								$lname = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'last_name');
								$customerName = $fname.' '.$lname;
							}
							
							$mobile_no = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'mobile_no');
							$address1 = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'address1');
							$address2 = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'address2');
							$city_id = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'city_id');
							$state_id = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'state_id');
							$country_id = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'country_id');
							$zip = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'zip');
							
							$cityName = GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
							$stateName = GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
							$countryName = GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');
							
							$customer_address = $address1;
							if($address2 !='')
							{
								$customer_address .= ', '.$address2;
							}
							$customer_address .= ', '.$cityName.', '.$stateName.', '.$countryName.', '.$zip;
							
							$gst_no = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'gst_no');
							$gst_no =  ($gst_no != '')? strtoupper($gst_no):'N/A'; 
							
							$email_id = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'email_id');
							$pay_res = json_decode($row->payment_response);														
							
							
							$txn_id = ($row->payu_mihpayid != 'null') ? $row->payu_mihpayid :'--' ;
							
							$trans_date = ($row->returnTime != 'null') ? $row->returnTime :'--' ;
							
							$baseAmt= round(($row->payu_amount*100)/118,2);
							
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $organisation_name);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, ucwords(strtolower($customerName)));
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $email_id);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $mobile_no);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $customer_address);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $stateName);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $customer_address);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $gst_no);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Registration Fee');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $baseAmt);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, '18.00');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->payu_amount - $baseAmt);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->payu_amount);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $trans_date);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Online Payment');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $txn_id);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'gst_mis_report_registration_fee_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'GST MIS Report of Registration Fee';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalGSTReglogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/gst_mis_report_registration_fee?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->gstRegLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/gst_mis_report_registration_fee', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function gst_mis_report_bank_processing_fee($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['track_id'] = $this->input->get('track_id');
                $data['email_id'] = $this->input->get('email_id');
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeGSTBankData();
                   
                   
                    //echo '<pre>';
                   
                    
                    $pay_req = json_decode($reportData->payment_request);
					$pay_res = json_decode($reportData[1]->payment_response);
					
					
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('GST MIS Report Bank Process Fee');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
						 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Company Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Customer Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Email Address');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Contact Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Address of Customer');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Place of Supply');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Address of Delivery');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'GST Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Description Of Service');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Base Amount');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Rate of tax (%)');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Total Tax Applicable');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Net Amount Paid');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Payment Date');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Payment Mode');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Transaction Number');
						
						
						$sn=1;	
						foreach ($reportData as $row) {
							
							$i = ++$i;
							
							$organisation_name = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'organisation_name');
							$organisation_name = ($organisation_name != '')? $organisation_name:'N/A'; 
							if($organisation_name !='N/A')
							{
								$customerName = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'authorized_person');
							}
							else
							{
								$fname = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'first_name');
								$lname = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'last_name');
								$customerName = $fname.' '.$lname;
							}
							
							$mobile_no = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'mobile_no');
							$address1 = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'address1');
							$address2 = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'address2');
							$city_id = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'city_id');
							$state_id = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'state_id');
							$country_id = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'country_id');
							$zip = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'zip');
							
							$cityName = GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
							$stateName = GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
							$countryName = GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');
							
							$customer_address = $address1;
							if($address2 !='')
							{
								$customer_address .= ', '.$address2;
							}
							$customer_address .= ', '.$cityName.', '.$stateName.', '.$countryName.', '.$zip;
							
							$gst_no = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'gst_no');
							$gst_no =  ($gst_no != '')? strtoupper($gst_no):'N/A'; 
							
							$email_id = GetTitleByField('tbl_user_registration',"id='".$row->bidder_id."'",'email_id');
							$pay_res = json_decode($row->payment_response);														
							
							
							$txn_id = ($pay_res != '' && $pay_res->bank_ref_no != 'null') ? $pay_res->bank_ref_no :'--' ;
							
							$payDate = str_replace('/','-',$pay_res->trans_date);
							$trans_date = ($pay_res != '' && $pay_res != null) ? $payDate :$row->date_created;
							
							$baseAmt= round(($pay_res->mer_amount*100)/118,2);
							
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $organisation_name);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, ucwords(strtolower($customerName)));
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $email_id);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $mobile_no);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $customer_address);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $stateName);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $customer_address);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $gst_no);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Bank Processing Fee');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $baseAmt);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, '18.00');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $pay_res->mer_amount - $baseAmt);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $pay_res->mer_amount);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $trans_date);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Online Payment');
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $txn_id);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'gst_mis_report_bank_processing_fee_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'GST MIS Report of Bank Processing Fee';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalGSTBanklogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/gst_mis_report_bank_processing_fee?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->gstBankLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/gst_mis_report_bank_processing_fee', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function emd_deposit_report($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                $data['auction_id'] = $this->input->get('auction_id');
                $data['utr_no'] = $this->input->get('utr_no');
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeEMDDepositData();
                   
                   
                    //echo '<pre>';
                   
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('EMD Deposit Report');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Auction ID');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Email Address');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'EMD Deposit Date');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Deposit Amount');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'UTR No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Drawn on Bank');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Account Holder Bank Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Name of the Account Holder / Firm');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Account Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'IFSC Code');
						
						$sn=1;	
						foreach ($reportData as $row) {
							
							$i = ++$i;
							
							$organisation_name = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'organisation_name');
							$organisation_name = ($organisation_name != '')? $organisation_name:'N/A'; 
							if($organisation_name !='N/A')
							{
								$customerName = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'authorized_person');
							}
							else
							{
								$fname = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'first_name');
								$lname = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'last_name');
								$customerName = $fname.' '.$lname;
							}
							
							$email_id = GetTitleByField('tbl_user_registration',"id='".$row->bidderID."'",'email_id');
							$pay_res = json_decode($row->payment_response);														
							
							
							$txn_id = ($pay_res != '' && $pay_res->bank_ref_no != 'null') ? $pay_res->bank_ref_no :'--' ;
							
							$payDate = str_replace('/','-',$pay_res->trans_date);
							$emd_deposit_date = date('d M Y',strtotime($row->emd_deposit_date));
							
							
							
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->auctionID);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $email_id);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $emd_deposit_date);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->emd_amount);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->utr_no);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->drawn_bank);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->account_holder_bank_name);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->account_holder_name);
							$this->excel->getActiveSheet()->setCellValueExplicit(++$column.$i, $row->account_number, PHPExcel_Cell_DataType::TYPE_STRING);
							//$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->account_number);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->ifsc_code);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'emd_deposit_report_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'EMD Deposit Report';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalEMDDepositlogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/emd_deposit_report?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->emdDepositLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/emd_deposit_report', $data);
        $this->load->view('superadmin/footer');
    }
    
    public function emd_refund_report($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                $data['auction_id'] = $this->input->get('auction_id');
                $data['utr_no'] = $this->input->get('utr_no');
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeEMDRefundData();
                   
                   
                    //echo '<pre>';
                   
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('EMD Refund Details');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Email Address');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Account Holder Bank Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Type of Account');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Name of the Account Holder / Firm');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Account Number');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'IFSC Code');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Created Date');
						
						$sn=1;	
						foreach ($reportData as $row) {
							
							$i = ++$i;
							$indate = date('d M Y',strtotime($row->indate));
							
							
							
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->email_id);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->bank_name);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->account_type);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->account_holder_name);
							$this->excel->getActiveSheet()->setCellValueExplicit(++$column.$i, $row->account_number, PHPExcel_Cell_DataType::TYPE_STRING);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->ifsc_code);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $indate);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'emd_refund_report_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'EMD Refund Report';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalEMDRefundlogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/emd_refund_report?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->emdRefundLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/emd_refund_report', $data);
        $this->load->view('superadmin/footer');
    }

	public function contact_us_log($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['email_id'] = $this->input->get('email_id');
                $data['name'] = $this->input->get('name');
                $data['mobile'] = $this->input->get('mobile');
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeContactUsData();
                   
                   
                    //echo '<pre>';
                   
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('Contact Us Logs');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Email Address');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Mobile No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Topic');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Message');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Created Date');
						
						$sn=1;	
						foreach ($reportData as $row) {
							
							$i = ++$i;
							$indate = date('d M Y',strtotime($row->in_date_time));
							
							
							
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->name);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->email);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->mobile);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->topic_name);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->message);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $indate);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'contact_us_log_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'Contact Us Logs';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalContactUslogs();
        
        $config['base_url'] = site_url() . 'superadmin/user/contact_us_log?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->contactUsLogs($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/contact_us_log', $data);
        $this->load->view('superadmin/footer');
    }

	public function user_subscription_list($page_no) {
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
            if (isset($submit) and ! empty($submit)) {
				$data['email_id'] = $this->input->get('email_id');
               
                if ($submit == 'Download') 
                {
                    // if($this->input->post('from_date') && $this->input->post('to_date')){

                    $reportData = $this->user_model->completeBidderListData();
                    // }else{
                    //$reportData='';
                    //}
                    if (!empty($reportData)) {
                        header('Content-type: text/csv');
                        header('Content-disposition: attachment;filename=Bidder_list.csv');
                        echo "S.No,First Name,Last Name,Email ID,Mobile No." . PHP_EOL;
                        foreach ($reportData as $row) {
                           // echo $row->id . ',' . $row->user_id . ',' . $row->user_type . ',' . $row->user_type_main . ',' . $row->ip_address . ',' . date('d-m-Y_h:i:s', strtotime($row->logout_datetime)) . ',' . date('d-m-Y_h:i:s', strtotime($row->login_datetime)) . ',' . str_replace(array(' ', ';', ','), '_', $row->browser_type) . '' . PHP_EOL;
                            echo $row->id . ',' . $row->first_name . ',' . $row->last_name 	 . ',' . $row->email_id . ',' . $row->mobile_no . ',' .    PHP_EOL;
                        }
                        die;
                    }
                }
            }
        }

        $data['heading'] = 'Bidder List';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GetBidder_list();
        
        
        
       /* $config['base_url'] = site_url() . 'superadmin/user/userlog';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);
        $offset = ($limit) ? $limit : 0;*/
        
        $config['base_url'] = site_url() . 'superadmin/user/user_subscription_list?k=2&';
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        //$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->GetBidder_listing($offset, $per_page);
        $data['records'] = $array_records;
        $this->load->view('superadmin/user_subscription_list', $data);
        $this->load->view('superadmin/footer');
    }

	public function user_subscription_logs($page_no) {
		$userid = $this->uri->segment(4);
		$user_type =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "user_type");
		if($user_type == 'owner')
		{
			$full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
			$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "last_name");
		}
		else
		{
			$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "authorized_person");
		}
        if ($this->input->get('submit')) 
        {
            $submit = $this->input->get('submit');
           
            
            if (isset($submit) and ! empty($submit)) {
                $data['from_date'] = $this->input->get('from_date');
                $data['to_date'] = $this->input->get('to_date');
                $data['name'] = $this->input->get('name');
                
               
                
                if ($submit == 'Download') 
                {					 
                    $reportData = $this->user_model->completeUserSubscriptionData();
                   
                   
                    //echo '<pre>';

                   
                    if (!empty($reportData)) 
                    {
                       
                        $this->load->library('excel');
						//activate worksheet number 1
						
						$this->excel->setActiveSheetIndex(0);
						//$this->excel->getActiveSheet()->setShowGridlines(FALSE);
						//name the worksheet
						$this->excel->getActiveSheet()->setTitle('User Subscription Logs');
						
						$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
						$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
						$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(80);
						$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); 
						
						$this->excel->getActiveSheet()->getStyle("A2:Z1000")->getFont()->setSize(10);
						$i =1;
						$column = 'A';
						
						$this->excel->getActiveSheet()->setCellValue($column.$i, 'S.No.');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Package Name');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Package Description');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Amount');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Package Start Date');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Package End Date');
						$this->excel->getActiveSheet()->setCellValue(++$column.$i, 'Package Purchase Date');
						
						$sn=1;	
						foreach ($reportData as $row) {
							$package = $this->home_model->getSubcriptionPlan($row->package_id);
							$i = ++$i;
							$package_start_date = date('d M Y H:i:s',strtotime($row->package_start_date));
							$package_end_date = date('d M Y H:i:s',strtotime($row->package_end_date));
							$indate = date('d M Y H:i:s',strtotime($row->subscription_created_on));
							$state_bidder = $this->home_model->get_state_bidder($row->subscription_participate_id);
							$packageName = ($row->package_id > 3)?'State Wise (Any 2 States)':'PAN India'; 
							$packageName .= ", ".$row->sub_month." Months Plan";
						    if($row->package_id > 3)
							{ 
								
								$packageName .= ", States Chosen: ";
								$packageName .= implode(", ",$state_bidder);
							}
							
							$packageAmount = "₹".$row->package_amount.".00";
							if($row->package_id > 3 && count($state_bidder) > 2){
							  $packageAmount .= " (Subscription charges ₹";
							  $packageAmount .= $package[0]->package_amount;
							  $packageAmount .= ".00 + ";
							  $packageAmount .= (count($state_bidder)-2)." additional State charges ₹";
							  $packageAmount .= $row->package_amount - $package[0]->package_amount.".00)";
							}
							//echo $packageAmount;die;
							$column = 'A';
							$this->excel->getActiveSheet()->setCellValue($column.$i, $sn);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $packageName);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $row->package_description);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $packageAmount);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $package_start_date);							
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $package_end_date);
							$this->excel->getActiveSheet()->setCellValue(++$column.$i, $indate);
							
							
							$sn++;
                        }
                        $i = ++$i;
						//$this->excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($miestilo_SEC2);

						//$this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
						
						$filename = 'user_subscription_log_'.time().'.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
						//force user to download the Excel file without writing it to server's HD
						$objWriter->save('php://output');	
							
					}
						
                 }
            }
        }

        $data['heading'] = 'User Subscription Logs';
        $this->load->view('superadmin/header', $data);
        
        $per_page = 10;
        $total_record = $this->user_model->GettotalUserSubscriptionlogs();
        
        $config['base_url'] = site_url() . "superadmin/user/user_subscription_logs/".$userid."?k=2&";
        $config['base_url'] .= http_build_query($_GET, '', "&");
        
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);

        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();

		$page_no = $_GET['per_page'];

        if ($page_no == '')
            $limit = 0;
        else
            $limit = $config["per_page"] * ($page_no - 1);

        $offset = ($limit) ? $limit : 0;
        

        $array_records = $this->user_model->UserSubscriptionLogs($offset, $per_page,$user_id);
        $data['records'] = $array_records;
        $this->load->view('superadmin/user_subscription_logs', $data);
        $this->load->view('superadmin/footer');
    }
}



?>
