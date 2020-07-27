<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buyer_seller extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/buyer_seller_model');
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
		$data['heading']='Buyer Seller'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		$per_page=10;
		$total_record	= $this->buyer_seller_model->GetTotalRecord();		
		$config['base_url'] = site_url().'superadmin/buyer_seller/index';
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
		
		$array_records = $this->buyer_seller_model->GetRecords($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/buyer_seller', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Buyer Seller'; 
		}else{
			$data['heading']='Add Buyer Seller'; 
		}
		
		if($param){
			$array_records = $this->buyer_seller_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
		
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-buyer_seller', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('buyer_name', 'Name', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			redirect('superadmin/buyer_seller/addedit');
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->buyer_seller_model->upload1('image');	
			}else{
				$image=$this->input->post('image_old');
			}
			
			$save = $this->buyer_seller_model->save_buyer_seller_data($image);
			
			if($save){
				redirect('superadmin/buyer_seller/index');
			}else{
				
			}
		}	
	}	
}
?>
