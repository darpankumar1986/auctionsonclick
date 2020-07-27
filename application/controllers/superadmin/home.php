
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('superadmin/superadmin_model');
	   	$this->check_isvalidated();
	}	
	public function index()
	{
		$this->viewForm();
	}	
	
	function check_isvalidated()
	{
        if(! $this->session->userdata('validated')){
		     redirect('superadmin/login');
		     ////redirect('registration/logout');
        }
    }
	
    function viewForm()
    {   
        $upcomingtotalRecords=$this->superadmin_model->GettotalUpcomingAuctionRecord();
        $totalRecords=$this->superadmin_model->GettotalSavedAuctionRecord();
        $data['totalRecords']=$totalRecords;
        $data['upcomingtotalRecords']=$upcomingtotalRecords;
        $this->load->view('superadmin/header');		
        //$this->load->view('superadmin/sidebar');					
        $this->load->view('superadmin/home',$data);
        $this->load->view('superadmin/footer');

    }
    public function sendRole() {						
        $data = $this->superadmin_model->setRole();       
    }
    
    
}
