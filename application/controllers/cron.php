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
		$template = array();

		$this->db->where('a.status',1);
		$this->db->where('c.status',1);
		$this->db->where('a.alerts_type IN(1,2)');
		$this->db->order_by('c.city_name','ASC');
		$this->db->group_by('c.id');
		$this->db->join('tbl_city as c','c.id = a.city_id');
		$row_query = $this->db->get('tbl_member_email_alerts as a');
		foreach($row_query->result() as $row)
		{
			$this->db->select("bank.name as bank_name,a.reference_no,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID",false)
			->from('tbl_auction as a')				
			->join('tbl_category as c','c.id=a.subcategory_id','left')
			->join('tbl_city as city','city.id=a.city','left')
			->join('tbl_bank as bank','bank.id=a.bank_id','left')
			->where('a.city',$row->city_id)
			->where('a.status IN(1)')
			->where('bid_last_date >= NOW()');
			$auctionList = $this->db->get('');
			$data['auctionList'] = $auctionList->result();

			if($auctionList->num_rows() > 0)
			{
				$data['city_name'] = $row->city_name;

				$data['Logo'] = $this->load->view('email/Logo', $data, true); // render the view into HTML
				$data['Logo_2'] = $this->load->view('email/Logo_2', $data, true); // render the view into HTML
				$data['view_button'] = $this->load->view('email/view_button', $data, true); // render the view into HTML
				$html = $this->load->view('email/emailer', $data, true); // render the view into HTML

				$template[$row->city_id] = $html;
			}
		}

		if(count($template) > 0)
		{
			$this->db->select("a.city_id,r.email_id",false);
			$this->db->where('a.status',1);
			$this->db->where('c.status',1);
			$this->db->where('a.alerts_type IN(1,2)');
			$this->db->order_by('c.city_name','ASC');
			$this->db->group_by('c.id');
			$this->db->join('tbl_city as c','c.id = a.city_id');
			$this->db->join('tbl_user_registration as r','r.id = a.member_id');
			$row_query = $this->db->get('tbl_member_email_alerts as a');
			foreach($row_query->result() as $row)
			{
				$data = array(
								"email"=>$row->email_id,
								"subject"=>'Emailer',
								"message"=>$template[$row->city_id],
								//"attachment"=>'',
								//"cc_email"=>'',
								"indate"=>date('Y-m-d H:i:s')
							);
				$this->db->insert('tbl_email_log',$data);

				//$this->load->library('Email_new','email');
				//$email_obj = new email_new();
				//$email_obj->sendMailToUser(array('neeraj.jain@c1india.com'),'Emailer',$template[$row->city_id]); 
			}
		}
	}
}
?>
