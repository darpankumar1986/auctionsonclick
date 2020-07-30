<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_branch extends MY_Controller {
	
	public function __Construct() {
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/bank_model');
		$this->check_isvalidated();
		
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
	}
	
	/*execute page action to show the list of branch 
	in table format*/
	public function index($page_no="") {
		$this->page($page_no);
	}	
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated(){
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	/*find all values from tbl_branch table 
	to list number of branch*/
	public function page($page_no) {
		if($this->input->get('submit'))
			$this->updateStatus('tbl_branch');
		$data['heading']='Bank Branch';
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');	
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		//$search['bank'] 		= $this->input->post('bank');
		//$search['zone'] 		= $this->input->post('zone');
		//$search['region'] 		= $this->input->post('region');
		$data['search'] = $search;
		//serach query ends//
		$zones = $this->bank_model->GetZoneRecord();		
		$data['zones'] = $zones;
		$regions = $this->bank_model->GetRegionRecord();		
		$data['regions'] = $regions;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$drts = $this->bank_model->GetDrtRecords();		
		$data['drts'] = $drts;
		$per_page=50;
		$total_record	= $this->bank_model->GetTotalBranchRecord();
		
				
		/*$config['base_url'] = site_url().'superadmin/bank_branch/page/';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';*/
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/bank_branch?k=2';
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
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
		$offset = ($limit) ? $limit : 0;
		$array_records = $this->bank_model->GetBranchRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/bank-branch', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to Add and Edit branch form*/
	public function branch_addedit($param=null) {
		if(is_numeric($param)) {
			$data['heading']='Edit Bank Branch';
			$branch_id = $param;
		} else {
			$data['heading']='Add Bank Branch';
		}
		if($branch_id) {
			$array_records = $this->bank_model->GetBranchRecordById($branch_id);
		} else {
			$array_records=array();
		}
		$data['bank_id'] = $bank_id; 
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		$lho = $this->bank_model->GetLho($data['row']->bank_id);
		$data['lhoarr'] = $lho;
		$zones = $this->bank_model->GetZoneRecord();		
		$data['zones'] = $zones;
		$regions = $this->bank_model->GetRegionRecord();		
		$data['regions'] = $regions;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$drts = $this->bank_model->GetDrtRecords();		
		$data['drts'] = $drts;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank-branch', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update branch by this action*/
	public function save_branch($param=null) {
		$this->load->library('form_validation');
		$bank_id = $this->input->post('bank_id');
		$id = $this->input->post('id');
		$branch_id = $param;
		
		$this->form_validation->set_rules('bank', 'bank', 'trim|required|xss_clean');		
		//$this->form_validation->set_rules('zone', 'zone', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('region', 'region', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('drt', 'drt', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('address1', 'address1', 'trim|required|xss_clean');		
		//$this->form_validation->set_rules('country_id', 'country_id', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('state_id', 'state_id', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('city_id', 'city_id', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('zip', 'zip', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('agreementnodate', 'agreementnodate', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('revenueamount', 'revenueamount', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('agreementstartdate', 'agreementstartdate', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('agreementenddate', 'agreementenddate', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('unsuc_revenueamount', 'unsuc_revenueamount', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('stay_amount', 'stay_amount', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('cancel_amount', 'cancel_amount', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
				
		} else {
			$checkHTMLTagsArr['bank'] = $this->input->post('bank');
			$checkHTMLTagsArr['zone'] = $this->input->post('zone');
			$checkHTMLTagsArr['region'] = $this->input->post('region');
			$checkHTMLTagsArr['drt'] = $this->input->post('drt');
			$checkHTMLTagsArr['name'] = $this->input->post('name');
			$checkHTMLTagsArr['address1'] = $this->input->post('address1');
			$checkHTMLTagsArr['address2'] = $this->input->post('address2');
			$checkHTMLTagsArr['street'] = $this->input->post('street');
			$checkHTMLTagsArr['country_id'] = $this->input->post('country_id');
			$checkHTMLTagsArr['state_id'] = $this->input->post('state_id');
			$checkHTMLTagsArr['city_id'] = $this->input->post('city_id');
			$checkHTMLTagsArr['zip'] = $this->input->post('zip');
			$checkHTMLTagsArr['phone'] = $this->input->post('phone');
			$checkHTMLTagsArr['fax'] = $this->input->post('fax');
			$checkHTMLTagsArr['agreementnodate'] = $this->input->post('agreementnodate');
			$checkHTMLTagsArr['revenueamount'] = $this->input->post('revenueamount');
			$checkHTMLTagsArr['agreementstartdate'] = $this->input->post('agreementstartdate');
			$checkHTMLTagsArr['agreementenddate'] = $this->input->post('agreementenddate');
			$checkHTMLTagsArr['unsuc_revenueamount'] = $this->input->post('unsuc_revenueamount');
			$checkHTMLTagsArr['stay_amount'] = $this->input->post('stay_amount');
			$checkHTMLTagsArr['cancel_amount'] = $this->input->post('cancel_amount');
			
			
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
									redirect('/superadmin/bank_branch/branch_addedit/'.$id);
								}
								else
								{
									redirect('superadmin/bank_branch/branch_addedit');
								}
						  }
					}
				}
			}
			
			
			$data['name_exists'] = '';
			$input['bankid'] = $this->input->post('bank');
			$input['zone'] = $this->input->post('zone');
			$input['region'] = $this->input->post('region');
			$input['drt'] = $this->input->post('drt');
			$input['brancName'] = $this->input->post('name');
			if($param) {
				$input['id'] = $param;
			} else {
				$input['id'] = '';
			} 
			$isValid = $this->bank_model->findBankBranch($input);
			if(!$isValid) {
				if($_FILES['image']['name']!= ""){
					$image=$this->bank_model->upload1('image');
				}else{
					$image=$this->input->post('image_old');
				}
				$save = $this->bank_model->save_branch_data($image);
				if($save) {
                                    
                                if($param) {
                                        $this->session->set_flashdata('message','Branch is successfully updated');
                                } else {
                                        $this->session->set_flashdata('message','Branch is successfully created');
                                }
                                redirect('superadmin/bank_branch/page/'.$bank_id);
				}
			} else {
				$data['name_exists'] = 'Name already exist';
			}
		}
		if($branch_id) {
			$array_records = $this->bank_model->GetBranchRecordById($branch_id);
		} else {
			$array_records = array();
		}
		$data['bank_id'] = $bank_id; 
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		$lho = $this->bank_model->GetLho($_POST['bank_id']);
		$data['lhoarr'] = $lho;
		$zones = $this->bank_model->GetZoneRecord();		
		$data['zones'] = $zones;
		$regions = $this->bank_model->GetRegionRecord();		
		$data['regions'] = $regions;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$drts = $this->bank_model->GetDrtRecords();		
		$data['drts'] = $drts;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank-branch', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*show the dropdown of branch according to region id by ajax call*/
	public function ajax_branch($region_id) {
		$array_records = $this->bank_model->FilterBranchRecords($region_id);
		foreach($array_records as $row) {
			echo "<option value='$row->id'>$row->name</option>";
		}
	}
	
	/*calculate the tax according to region id*/
	public function ajax_taxcalculate() {
		$array_records = $this->bank_model->taxCalculate($region_id);
		echo json_encode($array_records);
	}
	
	/*to check the bank branch duplicate 
	during add and edit a branch*/
	public function checkBankBranch() {
		$records = $this->bank_model->findBankBranch($_POST);
		echo $records;
	}
}?>
