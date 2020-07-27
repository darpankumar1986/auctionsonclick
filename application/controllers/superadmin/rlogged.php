<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rlogged extends MY_Controller 
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
		$this->load->model('superadmin/rbidder_model');
	   	$this->check_isvalidated();
	}
	
	public function index() 
	{
		$data['heading']='Remove Logged ID'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/viewerloggedlist', $data);
		$this->load->view('superadmin/footer');
	}
	
	/*check session if not loged in then redirect 
	to login page*/
	private function check_isvalidated() 
	{
		
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='1')
        {
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	

	function getLoggedList()
	{	
		echo $this->rbidder_model->getLoggedList();
	}
	
	public function rloggedid($loggedId)
	{
		$this->load->library('form_validation');
		$save = $this->rbidder_model->rloggedid($loggedId);
		if($save)
		{
			$this->session->set_flashdata('message','Logged ID Removed Successfully');	
			redirect('superadmin/rlogged/');
		}else{
			
		}
	}
	
	
	
	
	public function rlist($auctionId) 
	{
		$data['heading']='Removed Logged List'; 
		$this->load->view('superadmin/header_pass', $data);		
		$this->load->view('superadmin/rviewerloggedlist', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	function rgetLoggedList()
	{	
		echo $this->rbidder_model->rgetLoggedList();
	}
	
	
	
	
}?>
