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

					$subject = (int)$templateAuctionCount[$row->city_id]." New Auction property in ".ucwords(strtolower($row->city_name));
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


			$subject = 'AuctionOnClick - Your subscription will expire in 3 days';
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

	public function insertBank($row)
	{
		$this->db->where('id',$row->id);
		$query = $this->db->get('tbl_bank');
		if($query->num_rows() == 0)
		{
			$data = array(
					"id"=>$row->id,
					"tender_doc"=>$row->tender_doc,
					"annexure2"=>$row->annexure2,
					"annexure3"=>$row->annexure3,
					"name"=>$row->name,
					"thumb_logopath"=>$row->thumb_logopath,
					"logopath"=>$row->logopath,
					"url"=>$row->url,
					"shortName"=>$row->shortName,
					"address1"=>$row->address1,
					"address2"=>$row->address2,
					"street"=>$row->street,
					"country"=>$row->country,
					"state"=>$row->state,
					"city"=>$row->city,
					"zip"=>$row->zip,
					"phone"=>$row->phone,
					"fax"=>$row->fax,
					"bank_header_color"=>$row->bank_header_color,
					"indate"=>$row->indate,
					"status"=>$row->status,
					"priority"=>$row->priority,
			);
			$this->db->where('id',$row->id);
			$this->db->insert('tbl_bank',$data);
		}
	}

	public function setBank()
	{
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_bank');
		$bank = $query->row();

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, API_URL.'auctionapi/getBankList/'.$bank->id);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonData = json_decode(curl_exec($curlSession));
		curl_close($curlSession);

		//echo '<pre>';
		//print_r($jsonData);

		foreach($jsonData as $row)
		{
			$this->insertBank($row);
		}

		if($_GET['cron'] == 'no')
		{
			$this->session->set_flashdata('message','Updated Successfully!');
			redirect('superadmin/bank');
		}
	}

	public function insertBranch($row)
	{
		$this->db->where('id',$row->id);
		$query = $this->db->get('tbl_branch');
		if($query->num_rows() == 0)
		{
			$data = array(
					"id"=>$row->id,
					"name"=>$row->name,
					"drt_id"=>$row->drt_id,
					"bank_id"=>$row->bank_id,
					"zone_id"=>$row->zone_id,
					"region_id"=>$row->region_id,
					"address1"=>$row->address1,
					"address2"=>$row->address2,
					"street"=>$row->street,
					"country"=>$row->country,
					"state"=>$row->state,
					"street"=>$row->street,
					"city"=>$row->city,
					"zip"=>$row->zip,
					"indate"=>$row->indate,
					"phone"=>$row->phone,
					"fax"=>$row->fax,
					"agreementnodate"=>$row->agreementnodate,
					"unsuc_revenueamount"=>$row->unsuc_revenueamount,
					"cancel_amount"=>$row->cancel_amount,
					"stay_amount"=>$row->stay_amount,
					"revenueamount"=>$row->revenueamount,
					"stax"=>$row->stax,
					"educess"=>$row->educess,
					"secondaryhighertax"=>$row->secondaryhighertax,
					"total"=>$row->total,
					"status"=>$row->status,
					"validity_from"=>$row->validity_from,
					"validity_to"=>$row->validity_to,
					"lho_id"=>$row->lho_id
			);
			$this->db->where('id',$row->id);
			$this->db->insert('tbl_branch',$data);
		}
	}

	public function setBranch()
	{
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_branch');
		$branch = $query->row();

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, API_URL.'auctionapi/getBranchList/'.$branch->id);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonData = json_decode(curl_exec($curlSession));
		curl_close($curlSession);

		//echo '<pre>';
		//print_r($jsonData);

		foreach($jsonData as $row)
		{
			$this->insertBranch($row);
		}

		if($_GET['cron'] == 'no')
		{
			$this->session->set_flashdata('message','Updated Successfully!');
			redirect('superadmin/bank_branch');
		}
	}

	public function insertCity($row)
	{
		$this->db->where('id',$row->id);
		$query = $this->db->get('tbl_city');
		if($query->num_rows() == 0)
		{
			$data = array(
					"id"=>$row->id,
					"city_name"=>$row->city_name,
					"stateID"=>$row->stateID,
					"indate"=>$row->indate,
					"status"=>$row->status,
					"CountyCode"=>$row->CountyCode
			);
			$this->db->where('id',$row->id);
			$this->db->insert('tbl_city',$data);
		}
	}

	public function setCity()
	{
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_city');
		$city = $query->row();

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, API_URL.'auctionapi/getCityList/'.$city->id);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonData = json_decode(curl_exec($curlSession));
		curl_close($curlSession);

		//echo '<pre>';
		//print_r($jsonData);

		foreach($jsonData as $row)
		{
			$this->insertCity($row);
		}

		if($_GET['cron'] == 'no')
		{
			$this->session->set_flashdata('message','Updated Successfully!');
			redirect('superadmin/city');
		}
	}

	public function insertCategory($row)
	{
		$this->db->where('id',$row->id);
		$query = $this->db->get('tbl_category');
		if($query->num_rows() == 0)
		{
			$data = array(
					"id"=>$row->id,
					"parent_id"=>$row->parent_id,
					"name"=>$row->name,
					"slug"=>$row->slug,
					"priority"=>$row->priority,
					"status"=>$row->status,
					"created_by"=>$row->created_by,
					"date_created"=>$row->date_created,					
					"date_modified"=>$row->date_modified
			);
			$this->db->where('id',$row->id);
			$this->db->insert('tbl_category',$data);
		}
	}

	public function setCategory()
	{
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_category');
		$category = $query->row();

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, API_URL.'auctionapi/getCategoryList/'.$category->id);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonData = json_decode(curl_exec($curlSession));
		curl_close($curlSession);

		//echo '<pre>';
		//print_r($jsonData);

		foreach($jsonData as $row)
		{
			$this->insertCategory($row);
		}

		if($_GET['cron'] == 'no')
		{
			$this->session->set_flashdata('message','Updated Successfully!');
			redirect('superadmin/Category');
		}
	}

	public function insertAuction($row)
	{

		$this->db->where('bankeauctionEventID',$row->id);
		$query = $this->db->get('tbl_auction');
		if($query->num_rows() == 0)
		{
			$row->event_type = str_replace('others','other',$row->event_type);
			$data = array(
					"bankeauctionEventID"=>$row->id,
					"open_price_bid"=>1,
					"reference_no"=>'',
					"event_title"=>0,
					"dispatch_date"=>date('Y-m-d H:i:s'),
					"first_opener"=>1,
					"created_by"=>1,
					"category_id"=>$row->category_id,
					"vehicle_type"=>0,
					"subcategory_id"=>$row->subcategory_id,
					"reserve_price"=>$row->reserve_price,
					"borrower_name"=>$row->borrower_name,
					"emd_amt"=>$row->emd_amt,
					"event_type"=>$row->event_type, // check
					"account_type_id"=>0,
					"bank_id"=>$row->bank_id,
					"drt_id"=>0,
					"branch_id"=>$row->branch_id,
					"countryID"=>$row->countryID,
					"state"=>$row->state,
					"city"=>$row->city,
					"is_corner_property"=>0,
					"asset_details"=>$row->product_description, // check
					"service_no"=>'Bankeauction',
					"far"=>API_URL,					
					"bid_last_date"=>$row->bid_last_date,
					"auction_start_date"=>$row->auction_start_date,
					"auction_end_date"=>$row->auction_end_date,
					"second_opener"=>1,
					"opening_price"=>$row->reserve_price,
					"status"=>0,
					"indate"=>date('Y-m-d H:i:s'),
					"updated_date"=>date('Y-m-d H:i:s'),
					"modified_date"=>date('Y-m-d H:i:s'),
					"PropertyDescription"=>$row->event_title,// ----------------
					"show_home"=>1
			);
					//echo '<pre>';
					//print_r($data);die;
			$this->db->insert('tbl_auction',$data);

			$auction_id = $this->db->insert_id();

			$datadoc = array(
					"auction_id"=>$auction_id,
					"upload_document_field_id"=>5,
					"upload_document_field_name"=>'Upload Sale Notice ',
					"file_path"=>API_URL.'public/uploads/event_auction/'.$row->related_doc,
					"date_created"=>date('Y-m-d H:i:s'),
					"date_modified"=>date('Y-m-d H:i:s'),
					"status"=>1
				);
			$this->db->insert('tbl_auction_document',$datadoc);
		}
	}

	public function setAuction()
	{
		$this->setBank();
		$this->setBranch();
		$this->setCity();
		$this->setCategory();

		//echo API_URL.'auctionapi/getAuctionList/0?date='.$_GET['date'];die;

		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, API_URL.'auctionapi/getAuctionList/'.(int)$_GET['auction_id'].'?date='.$_GET['date']);
		curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		$jsonData = json_decode(curl_exec($curlSession));
		curl_close($curlSession);

		//echo '<pre>';
		//print_r($jsonData);die;

		foreach($jsonData as $row)
		{
			$this->insertAuction($row);
		}

		echo '-------------- Done --------------';
	}
}
?>
