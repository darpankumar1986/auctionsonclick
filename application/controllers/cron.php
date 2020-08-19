<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends WS_Controller
{	
	public function __Construct()
	{   
		 parent::__Construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('home_model');
	}

	public function sendAuctionMail()
	{
		$this->db->where('subscription_status',1);
		$this->db->where('package_end_date >= now()');
		$this->db->where('package_start_date <= now()');
		$this->db->order_by('subscription_participate_id');
		$row_query = $this->db->get('tbl_subscription_participate');
	}
}
?>
