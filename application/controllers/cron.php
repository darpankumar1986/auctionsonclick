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
		$opt = '1';
		$template = array();
		$templateAuctionCount = array();

		if(date('w') == '0')
		{
			$opt = '1,2';
		}

		$this->db->where('a.status',1);
		$this->db->where('c.status',1);
		$this->db->where('a.alerts_type IN('.$opt.')');
		$this->db->order_by('c.city_name','ASC');
		$this->db->group_by('c.id');
		$this->db->join('tbl_city as c','c.id = a.city_id');
		$row_query = $this->db->get('tbl_member_email_alerts as a');
		//echo $this->db->last_query();die;
		foreach($row_query->result() as $row)
		{
			$this->db->select("bank.name as bank_name,a.reference_no,city.city_name,a.bid_last_date,a.reserve_price,a.id as listID,c.name as subCategory,p.name as parentCategory",false)
			->from('tbl_auction as a')				
			->join('tbl_category as c','c.id=a.category_id','left')
			->join('tbl_category as p','p.id=a.subcategory_id','left')
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
				$templateAuctionCount[$row->city_id] = $auctionList->num_rows();
			}
		}

		if(count($template) > 0)
		{
			$this->db->select("a.city_id,r.email_id,c.city_name,r.id,r.is_unsubscribe",false);
			$this->db->where('a.status',1);
			$this->db->where('c.status',1);
			$this->db->where('a.alerts_type IN('.$opt.')');
			$this->db->order_by('c.city_name','ASC');
			$this->db->join('tbl_city as c','c.id = a.city_id');
			$this->db->join('tbl_user_registration as r','r.id = a.member_id');
			$row_query = $this->db->get('tbl_member_email_alerts as a');
			foreach($row_query->result() as $row)
			{
				if($row->is_unsubscribe != 1)
				{
					$id_base64 = base64_encode($row->id);
					$email_md5 = md5($row->email_id);

					$link = base_url().'home/unsubscribe/'.$id_base64.'/'.$email_md5;
					$template_final = str_replace('%%Unsubscribe%%',$link,$template[$row->city_id]);

					$subject = (int)$templateAuctionCount[$row->city_id]." New Auction property in ".$row->city_name;
					$data = array(
									"member_id"=>$row->id,
									"email"=>$row->email_id,
									"subject"=>$subject,
									"message"=>$template_final,
									"email_type"=>1,
									"indate"=>date('Y-m-d H:i:s')
								);
					$this->db->insert('tbl_email_log',$data);
				}
			}
		}

		$this->sendMail();
	}

	public function sendReminderMail()
	{
		$before3DayDate = date('Y-m-d H:i:s',strtotime('+4 days'));
		$before2DayDate = date('Y-m-d H:i:s',strtotime('+3 days'));

		$this->db->where("p.package_end_date <= '".$before3DayDate."'");
		$this->db->where("p.package_end_date >= '".$before2DayDate."'");

		$this->db->where('p.subscription_status',1);
		$this->db->where('p.package_end_date >= now()');
		$this->db->where('p.package_start_date <= now()');
		$this->db->order_by('p.subscription_participate_id');
		$this->db->join('tbl_user_registration as r','r.id = p.member_id');
		$row_query = $this->db->get('tbl_subscription_participate as p');
		foreach($row_query->result() as $row)
		{
			$data['first_name'] = ($row->first_name != '')?$row->first_name.' '.$row->last_name:$row->authorized_person;

			$data['first_name'] = ucwords(strtolower($data['first_name']));

			

			$data['package_end_date'] = $row->package_end_date;
			$data['Logo_2'] = $this->load->view('email/Logo_2', $data, true); // render the view into HTML
			$html = $this->load->view('email/reminder', $data, true); // render the view into HTML


			$subject = 'AuctionOnClick –Your subscription will expire in 3 days';
			$data = array(
							"member_id"=>$row->id,
							"email"=>$row->email_id,
							"subject"=>$subject,
							"message"=>$html,
							"email_type"=>2,
							"indate"=>date('Y-m-d H:i:s')
						);
			$this->db->insert('tbl_email_log',$data);
		}

		$this->sendMail();
	}

	public function sendMail()
	{
		$this->db->where('status',1);
		$this->db->where('is_sent',0);
		$row_query = $this->db->get('tbl_email_log');
		foreach($row_query->result() as $row)
		{
			$this->db->where('email_id',$row->email_id);
			$this->db->where('status',1);
			$this->db->where('is_sent',0);
			$query = $this->db->get('tbl_email_log');

			if($query->num_rows() > 0)
			{
				$this->load->library('Email_new','email');
				$email_obj = new email_new();
				$ret = $email_obj->sendMailToUser(array($row->email),$row->subject,$row->message); 

				if($ret)
				{
					$this->db->where('email_id',$row->email_id);
					$this->db->update('tbl_email_log',array("is_sent"=>1));
				}
			}
		}
	}
}
?>
