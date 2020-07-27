<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewer extends MY_Controller 
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
		$this->load->model('superadmin/viewer_model');
	   	$this->check_isvalidated();
	}
	
	public function index() 
	{
		$data['heading']='Published Auction List'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/viewerauctionlist', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	public function assignedList() 
	{
		$data['heading']='Assigned Auction Viewer List'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/assignedList', $data);
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
		echo $this->viewer_model->getAuctionList();
	}
	
	function getAuctionListAssigned()
	{	
		echo $this->viewer_model->getAuctionListAssigned();
	}
	
	function addviewer($auction_id)
    {
		//new code
		$data['heading']='Add Auction Viewer'; 
		$this->load->view('superadmin/header_pass', $data);
		$data['controller']='viewer';
		$data['auction_id']=$auction_id;
		$data['auctionDetails']=$this->viewer_model->getAuctionDetails($auction_id);
				
		
		$per_page=100;
		//$total_record	= $this->viewer_model->GetTotalRecord($auction_id);
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/viewer/addviewer/'.$auction_id.'?k=2';
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
		
		$array_records = $this->viewer_model->GetRecords($offset,$per_page,$auction_id);
		//echo '<pre>';
		//print_r($array_records);
		$data['records'] = $array_records; 
		
		
		$this->load->view('superadmin/addviewer',$data);
		$this->load->view('superadmin/footer');
	}
	
	function addviewerlist($auction_id)
	{		
		echo $this->viewer_model->addviewerlist($auction_id);
	}

	public function saveviewer($auctionid,$userid)
	{
		$this->load->library('form_validation');
		$save = $this->viewer_model->saveviewer($auctionid,$userid);
		if($save)
		{
			$this->session->set_flashdata('message','Viewer added successfully');	
			redirect('superadmin/viewer/addviewer/'.$auctionid);
		}else{
			
		}
	}
	public function removeviewer($auctionid,$userid)
	{
		$this->load->library('form_validation');
		$save = $this->viewer_model->removeviewer($auctionid,$userid);
		if($save)
		{
			$this->session->set_flashdata('message','Viewer removed successfully');	
			redirect('superadmin/viewer/addviewer/'.$auctionid);
		}else{
			
		}
	}
	
	public function removeviewer1($id)
	{
		$this->load->library('form_validation');
		$save = $this->viewer_model->removeviewer1($id);
		if($save)
		{
			$this->session->set_flashdata('message','Viewer removed successfully');	
			redirect('superadmin/viewer/assignedList/');
		}else{
			
		}
	}
	
	
	
	
	public function bankList($id)
	{
		$data['heading']='Bank List'; 
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/bankList', $data);
		$this->load->view('superadmin/footer');
	}
	
	function getBankList()
	{	
		echo $this->viewer_model->getBankList();
	}
	
	public function bankviewerlist($bankid)
	{
		$data['heading']='Bank Viewer List'; 
		$data['bankid'] = $bankid;
		$data['bankDetails']=$this->viewer_model->getBankDetails($bankid);
		
		
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/bankviewerlist', $data);
		$this->load->view('superadmin/footer');
	}
	
	function bankviewerListData($bankId)
	{	
		echo $this->viewer_model->bankviewerListData($bankId);
	}
	
	public function assignViewerAuction($viewerId,$bankid)
	{
		$data['heading']=BRAND_NAME.'Auction List'; 
		$data['bankid'] = $bankid;
		$data['viewerId'] = $viewerId;
		$data['getViewerDetails']=$this->viewer_model->getViewerDetails($viewerId,$bankid);
		$data['getbankName']=$this->viewer_model->getbankName($bankid);
		$this->load->view('superadmin/header_pass', $data);	
		$data['pass'] 	= 'pass'; 	
		$this->load->view('superadmin/assignViewerAuction', $data);
		$this->load->view('superadmin/footer');
	}
	
	function assignViewerAuctionData($viewerId,$bankId)
	{	
		echo $this->viewer_model->assignViewerAuctionData($viewerId,$bankId);
	}
	
	function addViewerAuction()
	{
		$viewerID = $this->input->post('viewerID');
		$bankID = $this->input->post('bankID');

			$saveID = $this->viewer_model->saveViewerAuction();
			
			if($saveID > 0)
			{
				$this->session->set_flashdata('message','Auction Assigned Successfully!!'); 
			}
			else
			{
				$this->session->set_flashdata('message','Auction Not Assigned!!'); 
			}
			redirect('superadmin/viewer/assignViewerAuction/'.$viewerID.'/'.$bankID);
		
	}
	
	
}


?>
