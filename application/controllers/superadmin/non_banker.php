<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Non_banker extends MY_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/category_model');
		$this->load->model('superadmin/non_banker_model');
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
	function productaction(){
		$this->input->post('status');
		$pid=$this->input->post('pid');
		if($pid>0){
			$returnval=$this->non_banker_model->productaction();
			echo $returnval;
		}
	}	
	public function non_bank_auction_property($page_no)
	{
		$data['heading']='Non-Bank Auction Property'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		if($this->input->post('submit')){
			
			$submitType=$this->input->post('submit');
			$statusArr=$this->input->post('status');
			if($submitType=='Active all')
			{
				$this->non_banker_model->updateStatus('1',$statusArr);
			}else{
				$this->non_banker_model->updateStatus('0',$statusArr);
			}
			
		}
			
			
		//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=10;
		$total_record	= $this->non_banker_model->GetTotalNonBankerAuctionPropertyRecord($search);		
		$config['base_url'] = site_url().'superadmin/non_banker/non_bank_auction_property/';
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
		
		$array_records = $this->non_banker_model->GetnonNonBankerAuctionProperty($offset,$per_page,$search);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/nonbank_auction_property', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function non_bank_property($page_no)
	{
		$data['heading']='Non-Bank Property';
		$data['type'] = 'main';
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		if($this->input->post('submit')){
			$this->updateStatus('tbl_product');
		}
			
			
			//search query start//
		$search['title'] 	= $this->input->post('title'); 
		$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=10;
		
		$total_record	= $this->non_banker_model->GetTotalNonAuctionPropertyRecord($search); 		
		$config['base_url'] = site_url().'superadmin/non_banker/non_bank_property/';
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
		
		$array_records = $this->non_banker_model->GetnonAuctionProperty($offset,$per_page,$search);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/nonbank_property', $data);
		$this->load->view('superadmin/footer');
	}

	
	
	
	
	
}
?>
