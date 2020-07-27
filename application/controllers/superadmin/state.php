<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State extends MY_Controller {
	
	public function __Construct() {
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/bank_model');
		$this->load->model('superadmin/state_model');
		$this->check_isvalidated();
	}	
	
	/*execute page action to show the list of state 
	in table format*/
	public function index($page_no) {
		$this->page($page_no);
	}	
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() {
        if(!$this->session->userdata('validated')) {
			redirect('superadmin/login');
            //redirect('registration/logout');
        }		
    }	
	
	/*check for unique state duplicate state not allowed*/
	function uniqueState() {
		$name=trim($this->input->post('name'));
		$country_id=trim($this->input->post('country_id'));
		$id=$this->input->post('id');
		echo $this->state_model->uniqueState($name, $country_id, $id);
	}
		
	/*find all values from state table 
	to list number of state*/
	public function page($page_no) {
		if($this->input->post('submit')) {
			$this->updateStatus('tbl_state');
		}
		$data['heading']='State'; 
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		//search query start//
		$search['title'] = $this->input->post('title'); 
		$search['status'] = $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record = $this->state_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/state/index';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
		$offset = ($limit) ? $limit : 0;
		$array_records = $this->state_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/state', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to Add and Edit state form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading'] = 'Edit state'; 
		} else {
			$data['heading'] = 'Add state'; 
		}
		if($param) {
			$array_records = $this->state_model->GetRecordById($param);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-state', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update state by this action*/
	public function save($param) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$id=$this->input->post('id');
		if($this->form_validation->run() == FALSE){
			
		} else {
			$checkState = $this->state_model->uniqueState($this->input->post('name'), $this->input->post('country_id'), $this->input->post('id'));
			if($checkState=='true') {
				$save = $this->state_model->save_data($image);
				if($save)  {
					$id=$this->input->post('id');	
					if($id) {
						$this->session->set_flashdata('message','State is successfully updated');	
					} else {
						$this->session->set_flashdata('message','State is successfully created');	
					}
					redirect('superadmin/state/index');
				}
			} else {
				$data['state_exists'] = $this->input->post('name');
			}
		}
		if(is_numeric($param)){
			$data['heading']='Edit state'; 
		}else{
			$data['heading']='Add state'; 
		}
		if($param){
			$array_records = $this->state_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-state', $data);
		$this->load->view('superadmin/footer');
	}
}
?>
