<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caste_category extends MY_Controller {
	
	public function __Construct() {
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/caste_category_model');
		$this->output->set_header("no-cache, private, no-store,must-revalidate, max-stale=0, post-check=0, pre-check=0");
		$this->output->set_header('Pragma: no-cache');
	   	$this->check_isvalidated();
	}
	
	/*execute page action to show the list of category 
	in table format*/
	public function index($page_no) {
		$this->page($page_no);
	}
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() {
        if(! $this->session->userdata('validated')|| $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
	
	/*find all values from category table 
	to list number of category*/
	public function page($page_no) {
		$data['heading']='Caste Category'; 
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		if($this->input->post('submit'))
		$this->updateStatus('tbl_caste_category');
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		
		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->caste_category_model->GetSubTotalRecord();	
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/category/index?k=2';
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
		$array_records = $this->caste_category_model->GetSubRecords($offset,$per_page);
		//echo "<pre>";
		//print_r($array_records);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/category', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*show the parent category list*/
	public function main($page_no) {
		$data['heading']='Category';
		$data['type'] = 'main';
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		if($this->input->post('submit'))
			$this->updateStatus('tbl_caste_category');
		//search query start//
		$search['title'] 	= $this->input->get('title'); 

		$data['search'] = $search;
		//serach query ends//
		$per_page=100;
		$total_record	= $this->caste_category_model->GetTotalRecord(); 		


		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/caste_category/main?k=2';
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
		$array_records = $this->caste_category_model->GetParentRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/caste_category', $data);
		$this->load->view('superadmin/footer');
	}

	/*Redirect to Add and Edit subcategory form*/
	public function addedit($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Caste Category'; 
			$category_id = $param;
		} else {
			$data['heading']='Add Caste Category'; 
		}
		if($category_id) {
			$array_records = $this->caste_category_model->GetRecordById($category_id);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;
		$category = $this->caste_category_model->GetParentRecordsControl();
		$data['category'] = $category;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-caste-category', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to add edit parent category form*/
	public function addeditmain($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Caste Category'; 
			$category_id = $param;
		} else {
			$data['heading']='Add Caste Category'; 
		}
		if($category_id) {
			$array_records = $this->caste_category_model->GetRecordById($category_id);
		} else {
			$array_records = array();
		}
		$data['type'] = 'main';
		$data['row'] = $array_records;
		$category = $this->caste_category_model->GetParentRecordsControl();
		$data['category'] = $category;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-caste-category', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*check for unique category duplicate category not allowed*/
	function uniqueCategory() {
		$name=$this->input->post('caste_category_name');		
		$id=$this->input->post('caste_category_id');
		echo $this->caste_category_model->uniqueCategory($name,$id);
	       }
	
	/*Get subcategory according to parent category 
	to show drop down*/
	function subCatDropdown($parent_id, $view='', $subcat_id) {
		$data['view'] =$view;
		$data['subcat_id'] =$subcat_id;
		if($data['category'] = $this->caste_category_model->GetChildRecords($parent_id))
		$this->load->view('superadmin/subCatDropdown', $data);
	}
	
	/*delete category by id*/
	function deleteCategory($id) {
		$this->caste_category_model->deleteCategory($id);
	}
	
	/*save and update category and subcategory*/
	public function save($param) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('caste_category_name', 'Name', 'trim|required|xss_clean');		
		$id = $this->input->post('caste_category_id');
		if($this->form_validation->run() == FALSE){
			
		} else {
			$isValid = $this->caste_category_model->uniqueCategory($this->input->post('caste_category_name'), $id);
			if($isValid=='true') {
				
				$save = $this->caste_category_model->save_category_data();
				if($save) {
					
					if($id) {
						$this->session->set_flashdata('message','Caste Category is successfully updated');
						redirect('superadmin/caste_category/main');
					} else {
						$this->session->set_flashdata('message','Caste Category is successfully created');
						redirect('superadmin/caste_category/main');	
					}
					
				}
			} else {
				$data['category_exist']= $this->input->post('caste_category_name');
			}
		}
		if(is_numeric($param)) {
			$data['heading'] = 'Edit Caste Category'; 
			$category_id = $param;
		} else {
			$data['heading']='Add Caste Category'; 
		}
		if($category_id) {
			$array_records = $this->caste_category_model->GetRecordById($category_id);
		} else {
			$array_records=array();
		}
		if($this->input->post('parent_id')==0) {
			$data['type'] = 'main';	
		}
		if($this->input->post('parent_id')!=0 and  is_numeric($param)) {
			$data['heading'] = 'Edit Sub Category'; 
		} else if($this->input->post('parent_id')!=0 and empty($param)) {
			$data['heading'] = 'Add Sub Category';
		}
		$data['row'] = $array_records;
		$data['category']= $this->caste_category_model->GetParentRecordsControl();
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		$this->load->view('superadmin/add-edit-caste-category', $data);
		$this->load->view('superadmin/footer');		
	}
}?>
