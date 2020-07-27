<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/attribute_model');
		
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
		if($this->input->post('submit'))
			$this->updateStatus('tbl_attribute');
		$data['heading']='Attribute'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		
		//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['group'] 		= $this->input->post('group');
		$data['search'] = $search;
		$groups = $this->attribute_model->GetGroup();		
		$data['groups'] = $groups;
		//serach query ends//
		
		$per_page=50;
		$total_record	= $this->attribute_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/attribute/index';
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
		
		$array_records = $this->attribute_model->GetRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/attribute', $data);
		$this->load->view('superadmin/footer');
	}

	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Attribute'; 
			$attribute_id = $param;
		}else{
			$data['heading']='Add Attribute'; 
		}
		
		if($attribute_id){
			$array_records = $this->attribute_model->GetRecordById($attribute_id);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
		$groups = $this->attribute_model->GetGroup();		
		$data['groups'] = $groups;
		
				
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-attribute', $data);
		$this->load->view('superadmin/footer');
	}	
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$id = $this->input->post('id');
		if($this->form_validation->run() == FALSE){
			
			if($id)
				redirect('superadmin/attribute/addedit/'.$id);
			else
				redirect('superadmin/attribute/addedit');
		}
		else{
				
			$save = $this->attribute_model->save_data();
			if($save){
				if($id)
				{
					$this->session->set_flashdata('message','Attribute is successfully updated');
				}else{
					$this->session->set_flashdata('message','Attribute is successfully created');
				}
				redirect('superadmin/attribute');
			}else{
				
			}
		}	
	}
	
}
?>
