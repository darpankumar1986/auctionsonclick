<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends MY_Controller {
	
	public function __Construct() {
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/country_model');
		$this->check_isvalidated();
	}
	
	/*execute page action to show the list of country 
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
	
	/*find all values from country table 
	to list number of country*/
	public function page($page_no) {
	    if($this->input->post('submit'))
		$this->updateStatus('tbl_country');
		$data['heading']='Country'; 
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->country_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/country/index';
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
		$array_records = $this->country_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/country', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*check for unique country duplicate country not allowed*/
	function uniqueCountry() {
		$name=trim($this->input->post('country_name'));
		$id=$this->input->post('id');
		echo $this->country_model->uniqueCountry($name, $id);
	}
	
	/*Redirect to Add and Edit country form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Country'; 
		} else {
			$data['heading']='Add Country'; 
		}
		if($param) {
			$array_records = $this->country_model->GetRecordById($param);
		} else {
			$array_records = array();
		}
		$data['row'] = $array_records;
		$roles = $this->role_model->GetRecords();
		$data['roles'] = $roles;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-country', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update country by this action*/
	public function save($param) {
		if(!empty($param) and is_numeric($param)) {
			$data['heading']='Edit Country'; 
		} else {
			$data['heading']='Add Country'; 
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('country_name', 'country name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE) {
		
		} else {
			$checkCountry = $this->country_model->uniqueCountry($this->input->post('country_name'), $this->input->post('id'));
			if($checkCountry=='true') {
				$save = $this->country_model->save_data($image);
				if($save) {
					$id=$this->input->post('id');	
					if($id) {
						$this->session->set_flashdata('message','Country is successfully updated');	
					} else {
						$this->session->set_flashdata('message','Country is successfully created');	
					}
					redirect('superadmin/country');
				}
			} else {
				$data['country_exists'] = $this->input->post('country_name');
			}
		}
		if($param) {
			$array_records = $this->country_model->GetRecordById($param);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-country', $data);
		$this->load->view('superadmin/footer');
	}
}?>
