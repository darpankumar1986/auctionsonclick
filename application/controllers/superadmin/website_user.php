<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website_User extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/article_model');
		$this->load->model('superadmin/category_model');
		$this->load->model('superadmin/author_model');
		$this->load->model('superadmin/location_model');
		$this->load->model('superadmin/website_user_model');
		$this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	public function page($page_no)
	{
		$data['heading']='Website User'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');	
		
		$per_page=50;
		$total_record	= $this->website_user_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/website_user/index';
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
		
		
		$array_records = $this->website_user_model->GetRecords($offset,$per_page);	
		 
		$data['records'] = $array_records; 
		$this->load->view('superadmin/website-user', $data);
		$this->load->view('superadmin/footer');
	}

	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit website user'; 
			$user_id = $param;
		}else{
			$data['heading']='Add website user'; 
		}
		
		if($user_id){
			$array_records = $this->website_user_model->GetRecordById($user_id);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
				
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-website-user', $data);
		$this->load->view('superadmin/footer');
	}
	
	function uniqueUser()
	{
		$email_id=$this->input->post('email_id');		
		echo $this->website_user_model->uniqueUser($email_id);
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('full_name', 'full_name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/website_user/addedit');
		}
		else{
			$save = $this->website_user_model->save_user_data($image);
			
			if($save){
				redirect('superadmin/website_user');
			}else{
				
			}
		}	
	}
	
}
?>
