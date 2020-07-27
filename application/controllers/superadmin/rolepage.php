<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolepage extends MY_Controller {
	
	public function __Construct() {
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/rolepage_model');
		$this->load->model('superadmin/category_model');
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
		$data['heading']='Sub Category'; 
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');
		if($this->input->post('submit'))
		$this->updateStatus('tbl_category');
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		
		$data['search'] = $search;
		//serach query ends//
		$per_page=50;
		$total_record	= $this->category_model->GetSubTotalRecord();	
		
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
		$array_records = $this->category_model->GetSubRecords($offset,$per_page);
		//echo "<pre>";
		//print_r($array_records);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/category', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*show the parent category list*/
	public function main() {
		$data['heading']='Role';
		$data['type'] = 'main';
		$this->load->view('superadmin/header', $data);		

		$array_records = $this->rolepage_model->GetAllRoles();
		$data['records'] = $array_records; 
		$this->load->view('superadmin/roles', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to add edit parent category form*/
	public function addeditrole($param) {
		
		if(is_numeric($param)) {
			$data['heading']='Edit Role'; 
			$role_id = $param;
		} else {
			$data['heading']='Add Role'; 
		}
		if($role_id) {
			//echo "ehleop";die;
			$array_records = $this->rolepage_model->GetRoleById($role_id);
		} else {
			$array_records = array();
		}
		$data['role'] = $array_records;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-roles', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update category and subcategory*/
	public function save($param) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		
		$role_id1 = $this->input->post('role_id');
		if($this->form_validation->run() == FALSE)
		{		
			redirect('superadmin/rolepage/addeditrole');
		}
		else
		{	
			
			$role_id = $this->rolepage_model->managerole($role_id1);
			if($role_id1>0)					
			{
				$this->session->set_flashdata('successMsg','Role Updated Successfully'); 
			}
			else
			{
				$this->session->set_flashdata('successMsg','Role Added Successfully'); 
			}
			redirect('superadmin/rolepage/main', 'refresh');
		}		
	}
	
	
	/*show the parent category list*/
	public function mainpage() {
		$data['heading']='Page';
		$data['type'] = 'main';
		$this->load->view('superadmin/header', $data);		

		$array_records = $this->rolepage_model->GetAllPages();
		$data['records'] = $array_records; 
		$this->load->view('superadmin/pages', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to add edit parent category form*/
	public function addeditpage($param) {
		
		if(is_numeric($param)) {
			$data['heading']='Edit Page'; 
			$page_id = $param;
		} else {
			$data['heading']='Add Page'; 
		}
		if($page_id) {
			$array_records = $this->rolepage_model->GetPageById($page_id);
		} else {
			$array_records = array();
		}
		
		$data['page'] = $array_records;
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-pages', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update category and subcategory*/
	public function savepage($param) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		
		$page_id1 = $this->input->post('page_id');
		if($this->form_validation->run() == FALSE)
		{		
			redirect('superadmin/rolepage/addeditpage');
		}
		else
		{	
			
			$page_id = $this->rolepage_model->managepage($page_id1);
			if($page_id1>0)					
			{
				$this->session->set_flashdata('successMsg','Page Updated Successfully'); 
			}
			else
			{
				$this->session->set_flashdata('successMsg','Page Added Successfully'); 
			}
			redirect('superadmin/rolepage/mainpage', 'refresh');
		}		
	}
	
	/*show the parent category list*/
	public function assignrole() {
		$data['heading']='Role-Page';
		$data['type'] = 'main';
		$this->load->view('superadmin/header', $data);		

		$array_records = $this->rolepage_model->GetAllPages();
		$data['records'] = $array_records;
		$role_id = $this->uri->segment(4);
		$data['pages'] = $this->rolepage_model->GetRolePages($role_id);
		
		$this->load->view('superadmin/rolepages', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*Redirect to add edit parent category form*/
	public function addeditrolepage($param) {
		
		if(is_numeric($param)) {
			$data['heading']='Edit Role-Page'; 
			$rolepage_id = $param;
		} else {
			$data['heading']='Add Role-Page'; 
		}
		if($rolepage_id) {
			$array_records = $this->rolepage_model->GetRolePageById($rolepage_id);
		} else {
			$array_records = array();
		}
		
		$data['rolepage'] = $array_records;
		$data['pages'] = $this->rolepage_model->GetAllPages();
		$data['roles'] = $this->rolepage_model->GetAllRoles();
		
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-rolepage', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*save and update category and subcategory*/
	public function saverolepage($param) {
		
		$role_id1 = $this->input->post('role_id');
		$role_name = $this->input->post('role_name');
		
		$role_id = $this->rolepage_model->managerolepage($role_id1);
		if($role_id1>0)					
		{
			$this->session->set_flashdata('successMsg','Role-Page Updated Successfully'); 
		}
		else
		{
			$this->session->set_flashdata('successMsg','Role-Page Added Successfully'); 
		}
		
		redirect('superadmin/rolepage/assignrole/'.$role_id1."/".$role_name, 'refresh');
				
	}
	
	
	
}?>
