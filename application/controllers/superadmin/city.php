<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City extends MY_Controller {
	
	public function __Construct() {
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/bank_model');
		$this->load->model('superadmin/city_model');
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
		$this->check_isvalidated();
	}	
	
	/*execute page action to show the list of city 
	in table format*/
	public function index($page_no) {
		$this->page($page_no);
	}	
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() {
        if(!$this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
			redirect('superadmin/login');
            //redirect('registration/logout');
        }		
    }

	/*check for unique city duplicate city not allowed*/
	function uniqueCity() {
		$name = trim($this->input->post('name'));
		$state_id = $this->input->post('state_id');
		$id = $this->input->post('id');
		echo $this->city_model->uniqueCity($name, $state_id, $id);
	}
	
	/*find all values from city table 
	to list number of city*/
	public function page($page_no) {
		if($this->input->post('submit'))
		$this->updateStatus('tbl_city');
		$data['heading']='City'; 
		$this->load->view('superadmin/header', $data);		

		//search query start//
		$search['title'] 	= trim($this->input->get('title')); 

		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->city_model->GetTotalRecord();	
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/city/index?k=2';
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
		$array_records = $this->city_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/city', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to Add and Edit city form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit City'; 
		} else {
			$data['heading']='Add City'; 
		}
		if($param) {
			$array_records = $this->city_model->GetRecordById($param);
		} else {
			$array_records = array();
		}
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-city', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update city by this action*/
	public function save($param) {
		$id=$this->input->post('id');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) {

		} else {
			$isValid = $this->city_model->uniqueCity($this->input->post('name'), $this->input->post('state_id'), $this->input->post('id'));
			if($isValid=='true') {
				
				$checkHTMLTagsArr['name'] = $this->input->post('name');
			
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
									redirect('superadmin/city/addedit/'.$id);
								}
								else
								{
									redirect('superadmin/city/addedit');
								}
						  }
					}
				}
			}
				
				
				
				$save = $this->city_model->save_data($image);
				if($save) {
					if($id) {
						$this->session->set_flashdata('message','City is successfully updated');	
					} else {
						$this->session->set_flashdata('message','City is successfully created');
					}
					redirect('superadmin/city/index');
				}
			} else {
				$data['city_exists'] = $this->input->post('name');
			}
		}
		if(is_numeric($param)) {
			$data['heading']='Edit City'; 
		} else {
			$data['heading']='Add City'; 
		}
		
		if($param) {
			$array_records = $this->city_model->GetRecordById($param);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-city', $data);
		$this->load->view('superadmin/footer');
	}
}?>
