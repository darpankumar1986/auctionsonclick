<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pass extends MY_Controller 
{
	public function __Construct() 
	{
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
		$this->load->library('table');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/pass_model');
	   	$this->check_isvalidated();
	}
	
	public function index() 
	{
		$data['heading']='Change Bidder Pass'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/bidPass', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function cBank() 
	{
		$data['heading']='Change Buyer Pass'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/bankPass', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function clog() 
	{
		$data['heading']='Change Buyer Pass'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/clog', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() 
	{
		
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='10')
        {
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	

	function getBidderPasswordList()
	{	
		echo $this->pass_model->getBidderPasswordList();
	}
	function getBankerPasswordList()
	{	
		echo $this->pass_model->getBankerPasswordList();
	}
	function getPasswordLogList()
	{	
		echo $this->pass_model->getPasswordLogList();
	}


	/*Redirect to Add and Edit subcategory form*/
	public function editBidderPass($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Password'; 
			$category_id = $param;
		} 
		if($category_id) {
			$array_records = $this->pass_model->GetBidderRecordById($category_id);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header_pass', $data);		
		$this->load->view('superadmin/editBidderPass', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	/*Redirect to Add and Edit subcategory form*/
	public function editBankerPass($param) {
		if(is_numeric($param)) {
			$data['heading']='Edit Buyer Password'; 
			$category_id = $param;
		} 
		if($category_id) {
			$array_records = $this->pass_model->GetBankerRecordById($category_id);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header_pass', $data);		
		$this->load->view('superadmin/editBankerPass', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	public function saveBidder($param) 
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$id = $this->input->post('id');
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata("error", "Please enter Password");
			redirect('/superadmin/pass/editBidderPass/'.$param.'');
		}
		else 
		{
				$save = $this->pass_model->save_bidder_data($id);
				if($save) {
						if($id) {
							$this->session->set_flashdata('message','Password is successfully updated');
							redirect('superadmin/pass/');
						} else {
							$this->session->set_flashdata('message','Password is successfully created');
							redirect('superadmin/pass/');	
						}
				}
	
		}
		if($id) {
			$array_records = $this->pass_model->GetBidderRecordById($id);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header_pass', $data);		
		$this->load->view('superadmin/editBidderPass', $data);
		$this->load->view('superadmin/footer');		
	}
	
	
	public function saveBanker($param) 
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$id = $this->input->post('id');
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata("error", "Please enter Password");
			redirect('/superadmin/pass/editBankerPass/'.$param.'');
		}
		else 
		{
				$save = $this->pass_model->save_banker_data($id);
				if($save) {
						if($id) {
							$this->session->set_flashdata('message','Password is successfully updated');
							redirect('superadmin/pass/cBank');
						} else {
							$this->session->set_flashdata('message','Password is successfully created');
							redirect('superadmin/pass/cBank');	
						}
				}
	
		}
		if($id) {
			$array_records = $this->pass_model->GetBankerRecordById($id);
		} else {
			$array_records=array();
		}
		$data['row'] = $array_records;		
		$this->load->view('superadmin/header_pass', $data);		
		$this->load->view('superadmin/editBankerPass', $data);
		$this->load->view('superadmin/footer');		
	}
}?>
