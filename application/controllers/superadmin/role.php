<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/role_model');
	  $this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(!$this->session->userdata('validated')){
          redirect('superadmin/login');
		//redirect('registration/logout');
        }
				
    }	
		
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_role');
		$data['heading']='Role'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=10;
		$total_record	= $this->role_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/role/index';
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
		
		$array_records = $this->role_model->GetRecord($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/role', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Role'; 
		}else{
			$data['heading']='Add Role'; 
		}
		
		if($param){
			$array_records = $this->role_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records;
		
		$roles = $this->role_model->GetRecords();
		$data['roles'] = $roles;
		
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-role', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/role/addedit');
		}
		else{
			
			$save = $this->role_model->save_data($image);
			if($save){
				redirect('superadmin/role/index');
			}else{
				
			}
		}	
	}	
}
?>
