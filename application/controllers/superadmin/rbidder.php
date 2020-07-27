<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rbidder extends MY_Controller 
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
		$data['heading']='Published Auction List'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/viewerauctionlistbidder', $data);
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

	function getAuctionList()
	{	
		echo $this->rbidder_model->getAuctionList();
	}
	
	
	public function rbidderlist($auctionId) 
	{
		$data['heading']='Bidder List'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$data['auctionId'] 	= $auctionId; 	
		$this->load->view('superadmin/rbidderlist', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	function getBidderList($auctionID)
	{	
		echo $this->rbidder_model->getBidderList($auctionID);
	}
	
	public function rbidderAuction($pId,$auctionid,$bidderID)
	{
		$this->load->library('form_validation');
		$save = $this->rbidder_model->rbidderAuctionR($pId,$auctionid,$bidderID);
		if($save)
		{
			$this->session->set_flashdata('message','Bidder removed successfully from auction');	
			redirect('superadmin/rbidder/rbidderlist/'.$auctionid);
		}else{
			
		}
	}
	
	
}?>
