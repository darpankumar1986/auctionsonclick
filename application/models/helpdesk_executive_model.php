<?php
class Helpdesk_executive_model extends CI_Model 
{
	private $path = 'public/uploads/property_images/';
	private $videopath = 'public/uploads/videos/';
	private $event_auction = 'public/uploads/event_auction/';
	private $document_auction = 'public/uploads/document/';
	private $emd_document_auction = 'public/uploads/emd_doc/';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
        
    function userparticipated($id)
    {
        $this->db->query("SET @row = 0",false); 
        $this->datatables->select(" @row := @row + 1 as SNo,IF(tb.register_as='builder',tb.organisation_name,CONCAT(tb.first_name,' ',tb.last_name)) as username,tb.email_id,tb.mobile_no,ta.final_submit",false)
		->from('tbl_auction_participate as ta')
		->join('tbl_user_registration as tb','tb.id=ta.bidderID','left')
		->where('ta.auctionID',$id);
	    return $this->datatables->generate();
    }
	
	function liveEventsdatatable()
    {
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("ta.reference_no,UCASE(ta.event_type)  as  type,tp.product_description,ta.id,ta.auction_start_date, ta.opening_price, (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id and tbl_auction_participate.final_submit=1 and ( tbl_auction_participate.operner2_accepted = '1' OR (tbl_auction_participate.operner2_accepted IS NULL and tbl_auction_participate.operner1_accepted = '1') )) as bidders ",false)
		->unset_column("ta.id")
		->add_column('Actions',"<a class='b_action' href='liveauction/$1'>View</a>", 'ta.id')
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left')
		->join('tbl_product as tp','ta.productID=tp.id','left')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left')
		->join('tbl_auction_participate as tap','ta.id=tap.id','left')
		->where('(NOW() >= ta.bid_opening_date AND NOW()<= ta.auction_end_date AND ta.open_price_bid = 1)')
		->where('ta.status',1)
        //->where('ta.open_price_bid',1)
		->where('ta.created_by',$user_id)
		->where('ta.auction_type',0);
		
        return $this->datatables->generate();
    }
    
    function liveUpcomingAuctionsdatatable()
    {
		$user_id = $this->session->userdata['id'];
		
		$this->datatables->select("a.reference_no,UCASE(a.event_type) as type,pro.product_description,a.auction_start_date,
		a.reserve_price,a.id,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID=a.id and tbl_auction_participate.final_submit=1') as total_bidder",false)
		->unset_column("a.id")
		->add_column('Actions',"<a class='b_action' href='/helpdesk_executive/liveupcomingauction/$1'>View</a>", 'a.id')
        ->from('tbl_auction as a')
		->join('tbl_auction_participate as p','a.id=p.auctionID and tap.status=1 and tap.final_submit=1','left')
		->join('tbl_product as pro','pro.id=a.productID','left ')
		->where('(NOW()>= a.auction_start_date AND NOW()<= a.auction_end_date)')
		->where('a.auction_type',0)
		->where('a.created_by',$user_id);
		//->group_by('p.auctionID');
        return $this->datatables->generate();
    }
    
    function upcomingAuctionsdatatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("a.reference_no,UCASE(a.event_type) as type,pro.product_description,a.bid_last_date,
		a.reserve_price,a.id,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= a.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder",false)
		->unset_column("a.id")
        ->add_column('Actions',"<a class='b_action' onclick=\"return bidderHoleinfoPopup('viewBidders',$1)\" href='javascript:'>View Bidders</a>", 'a.id')        
        ->from('tbl_auction as a')
		->join('tbl_auction_participate as p','a.id=p.auctionID and p.status=1 and p.final_submit=1','left ')
		->join('tbl_product as pro','pro.id=a.productID','left ')
		->where('a.bid_last_date >= NOW()')
		->where('a.auction_type','0')
		->where('a.status ',1)
		->where('a.created_by',$user_id)
		->group_by('p.auctionID');

        return $this->datatables->generate();
    }
    
    function manageLimitedAccessEventsdatatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("a.id,a.reference_no,UCASE(a.event_type) as type,pro.product_description,a.bid_last_date,
		a.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= a.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder",false)
		//->unset_column("a.id")
        ->add_column('Actions',"<a class='b_action' href='".base_url()."helpdesk_executive/bidderlist/$1'>View/Add Bidders</a>", 'a.id')        
        ->from('tbl_auction as a')
		->join('tbl_auction_participate as p','a.id=p.auctionID and p.status=1 and p.final_submit=1','left ')
		->join('tbl_product as pro','pro.id=a.productID','left ')
		->where('a.bid_last_date >= NOW()')
		->where('a.auction_type','0')
		->where('a.status ',1)
		->where('a.show_home != 1')
		->where('a.created_by',$user_id)
		->group_by('a.id');

		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
    }
    
    function manageLimitedAccessEventsSubmissionDateExpiredatatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("a.id,a.reference_no,UCASE(a.event_type) as type,pro.product_description,a.bid_last_date,
		a.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= a.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder",false)
		->from('tbl_auction as a')
		->join('tbl_auction_participate as p','a.id=p.auctionID and p.status=1 and p.final_submit=1','left ')
		->join('tbl_product as pro','pro.id=a.productID','left ')
		->where('a.bid_last_date < NOW()')
		->where('a.auction_type','0')
		//->where('a.status ',1)
		->where('a.show_home != 1')
		->where('a.created_by',$user_id)
		->group_by('a.id');

		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
    }
    
    function bids_to_be_openeddatatable($aid)
    {	
	    $user_id = $this->session->userdata['id'];
   
	    $this->datatables->select("ta.id,ta.reference_no,UCASE(ta.event_type) as type, p.product_description,ta.bid_opening_date,ta.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ta.id and tbl_auction_participate.final_submit='1' ) as bidders",false)
	    ->unset_column("ta.id")
		->add_column('Actions',"<a class='b_action' onclick=\"return bidderHoleinfoPopup('viewBidders',$1)\" href='javascript:'>View Bidders</a>", 'ta.id')
        ->from('tbl_auction as ta')
		->join('tbl_auction_participate as tap','ta.id=tap.auctionID','left ')
		->join('tbl_product as p','ta.productID=p.id','left ')
		->where('ta.auction_start_date >= NOW()')
		->where('NOW()>= ta.bid_last_date')
		->where('ta.status',1)
		->where('ta.created_by',$user_id)
		->where('ta.auction_type','0')
        ->where('ta.open_price_bid','0')
        ->group_by('ta.id');	
        return $this->datatables->generate();
    }
	
	function event_to_be_published_datatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("els.id, IF(tu.first_name IS NULL ,'N/A',CONCAT(tu.first_name,' ',tu.last_name))  as executive_name,tb.name as bank_name, CASE  
		WHEN els.status ='1' THEN 'Assigned'
		WHEN els.status ='2' THEN 'Re-assigned'
		ELSE 'Event Logged'
		END as event_status,IF(tua.first_name IS NULL ,'N/A',CONCAT(tua.first_name ,' ',tua.last_name) ) as user_name, els.indate , IF(els.updated_date IS NULL ,'N/A',els.updated_date ) as udate",false)
        ->from('tbl_event_log_sales as els')
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id')
		->join('tbl_bank as tb','els.bank_id=tb.id')
		->join('tbl_branch as tbr','els.branch_id=tbr.id')
		->join('tbl_event_assign as tea','els.id=tea.event_id and tea.status=1')
		->join('tbl_user_registration as tua','tea.assign_to_id=tua.id')
		
		//->where('ta.created_by',$user_id)
		->where("(els.status='1' OR els.status='2')")
		->where('els.status !=',4)
		->where('els.status !=',3);
        return $this->datatables->generate();
    }
	
	function event_to_be_published_datatable_dashboard($aid)
    {  
		if($aid>0)
		{
		
			$startDate = date("Y-m-d 00:00:00");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('last sunday'));
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
			
			$sql="SELECT els.id, IF(tu.first_name IS NULL, 'N/A', CONCAT(tu.first_name, ' ', tu.last_name)) as executive_name, tb.name as bank_name, CASE WHEN els.status ='1' THEN 'Assigned' WHEN els.status ='2' THEN 'Re-assigned' ELSE 'Event Logged' END as event_status, IF(tua.first_name IS NULL, 'N/A', CONCAT(tua.first_name, ' ', tua.last_name) ) as user_name, IF(els.indate IS NULL, 'N/A',els.indate) as create_date, IF(els.updated_date IS NULL, 'N/A', els.updated_date ) as udate,IF(els.indate IS NULL, 'N/A',els.indate) as mdate FROM (`tbl_event_log_sales` as els) JOIN `tbl_user_registration` as tu ON `els`.`sales_executive_id`=`tu`.`id` JOIN `tbl_bank` as tb ON `els`.`bank_id`=`tb`.`id` JOIN `tbl_branch` as tbr ON `els`.`branch_id`=`tbr`.`id` JOIN `tbl_event_assign` as tea ON `els`.`id`=`tea`.`event_id` and tea.status=1 JOIN `tbl_user_registration` as tua ON `tea`.`assign_to_id`=`tua`.`id` WHERE (els.status='1' OR els.status='2') AND `els`.`status` != 4 AND `els`.`status` != 3   AND els.indate BETWEEN  '".$startDate."' AND '".$endDate."' order by els.id desc";
			$data=$this->db->query($sql)->result_object();
			//echo $this->db->last_query();die;
		}
		else
		{
			$sql="SELECT els.id, IF(tu.first_name IS NULL, 'N/A', CONCAT(tu.first_name, ' ', tu.last_name)) as executive_name, tb.name as bank_name, CASE WHEN els.status ='1' THEN 'Assigned' WHEN els.status ='2' THEN 'Re-assigned' ELSE 'Event Logged' END as event_status, IF(tua.first_name IS NULL, 'N/A', CONCAT(tua.first_name, ' ', tua.last_name) ) as user_name, IF(els.indate IS NULL, 'N/A',els.indate) as create_date, IF(els.updated_date IS NULL, 'N/A', els.updated_date ) as udate,IF(els.indate IS NULL, 'N/A',els.indate) as mdate FROM (`tbl_event_log_sales` as els) JOIN `tbl_user_registration` as tu ON `els`.`sales_executive_id`=`tu`.`id` JOIN `tbl_bank` as tb ON `els`.`bank_id`=`tb`.`id` JOIN `tbl_branch` as tbr ON `els`.`branch_id`=`tbr`.`id` JOIN `tbl_event_assign` as tea ON `els`.`id`=`tea`.`event_id` and tea.status=1 JOIN `tbl_user_registration` as tua ON `tea`.`assign_to_id`=`tua`.`id` WHERE (els.status='1' OR els.status='2') AND `els`.`status` != 4 AND `els`.`status` != 3 order by els.id desc";
			$data=$this->db->query($sql)->result_object(); 
		}              
		return $data;
	}
	
	function event_closing_datatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("ta.bid_last_date, ta.bid_opening_date, ta.eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name",false)
        ->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left')
		//->where('ta.created_by',$user_id)
		->where('ta.bid_last_date >= NOW()')
		->where('ta.status',1)
		->where('ta.auction_type1','0');
        return $this->datatables->generate();
    }
	
	function event_closing_datatable_dashboard($aid)
	{   
		if($aid>0)
		{
			$startDate = date("Y-m-d 00:00:00");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
			
			$sql="SELECT ta.bid_last_date as bid_last_date,ta.bid_opening_date, ta.id as eventID ,ta.id, ta.reference_no, tb.name as bank_name, ta.first_opener,ta.second_opener,tbr.name as branch_name FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE `ta`.`bid_last_date` >= NOW() AND ta.bid_last_date BETWEEN  '".$startDate."' AND '".$endDate."'  and `ta`.`status` = 1 AND `ta`.`auction_type` = '0'";
		
			$data=$this->db->query($sql)->result_object();
		}
		else
		{
            $sql="SELECT ta.bid_last_date as bid_last_date,ta.bid_opening_date, ta.id as eventID ,ta.id, ta.reference_no, tb.name as bank_name,ta.first_opener ,ta.second_opener,tbr.name as branch_name FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE `ta`.`bid_last_date` >= NOW() AND `ta`.`status` = 1 AND `ta`.`auction_type` = '0'";
			$data=$this->db->query($sql)->result_object();
		}
        return $data;       
    }
	
   function event_to_be_opened_datatable($aid)
    {	
		$user_id =	 $this->session->userdata['id'];
		if($aid>0)
		{
			$this->datatables->select("ta.bid_opening_date, ta.auction_start_date, ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name",false)
			->from('tbl_auction as ta')
			->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
			->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
			->where('ta.id',$aid)
			->where('ta.status',1)
			->where('ta.bid_opening_date >= NOW()')
			->where('ta.bid_opening_date BETWEEN  NOW() AND NOW() + INTERVAL '.$aid.' DAY ')
			->where('ta.created_by',$user_id)
			->where('ta.auction_type','0');
		}
		else
		{
			$this->datatables->select("ta.bid_opening_date, ta.auction_start_date, ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name",false)
			->from('tbl_auction as ta')
			->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
			->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
			->where('ta.bid_opening_date >= NOW()')
			//->where('ta.bid_opening_date BETWEEN  NOW() AND NOW() + INTERVAL 8 DAY ')
			//->where('ta.created_by',$user_id)
			->where('ta.auction_type','0');
		}
        return $this->datatables->generate();
    }
	
	function event_to_be_opened_datatable_dashboard($aid)
    {	
		$user_id = $this->session->userdata['id'];
		if($aid>0)
		{
			$startDate = date("Y-m-d 00:00:00");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
			$sql="SELECT ta.bid_opening_date,ta.auction_start_date,ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE  NOW() >=`ta`.`bid_last_date` and  NOW() <= ta.auction_start_date  AND `ta`.`auction_type` = '0' and ta.bid_opening_date BETWEEN  '".$startDate."' AND '".$endDate."'  and open_price_bid='0' and `ta`.`status` = 1"; 
			$data=$this->db->query($sql)->result_object();
		}
		else
		{
		    $sql="SELECT ta.bid_opening_date,ta.auction_start_date,ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE  NOW() >=`ta`.`bid_last_date` and  NOW() <= ta.auction_start_date  AND `ta`.`auction_type` = '0' and open_price_bid='0' and `ta`.`status` = 1";
            $data=$this->db->query($sql)->result_object();
		}    
        return $data;
    }
	
	
	function auction_scheduled_datatable_dashboard($aid)
	{	
		if($aid>0)
		{
	        $startDate = date("Y-m-d H:i:s");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
		
			$sql="SELECT ta.id,ta.auction_start_date, ta.auction_end_date,ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name, 'Published' FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE `ta`.`auction_type` = '0' AND NOW() >=`ta`.`bid_last_date` and  NOW() <= ta.auction_start_date  AND ta.auction_start_date BETWEEN  '".$startDate."' AND '".$endDate."'   and `ta`.`status` = 1";
		 
			$data=$this->db->query($sql)->result_object();
		}
		else
		{
	        $sql="SELECT ta.id,ta.auction_start_date, ta.auction_end_date,ta.id as eventID, ta.reference_no, tb.name as bank_name, tbr.name as branch_name, 'Published' FROM (`tbl_auction` as ta) LEFT JOIN `tbl_bank` as tb ON `ta`.`bank_id`=`tb`.`id` LEFT JOIN `tbl_branch` as tbr ON `ta`.`branch_id`=`tbr`.`id` WHERE `ta`.`auction_type` = '0' AND NOW() >=`ta`.`bid_last_date` and  NOW() <= ta.auction_start_date and `ta`.`status` = 1  AND ta.auction_start_date BETWEEN  NOW() AND NOW() + INTERVAL 7 DAY ";
            $data=$this->db->query($sql)->result_object();
		}	
        return $data;
    }
	
    function auction_scheduled_datatable()
    {	
		$user_id = $this->session->userdata['id'];
        $this->datatables->select("ta.id,ta.auction_end_date,ta.auction_start_date, ta.eventID,ta.reference_no, tb.name as bank_name,tbr.name as branch_named,'Published'",false)
		->unset_column('ta.id')
		->add_column('Actions',"<a class='b_action' href='/helpdesk_executive/addauctionbidder/$1'>Add Bidder</a>", 'ta.id')
		->from('tbl_auction as ta')
		->join('tbl_bank as tb','ta.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ta.branch_id=tbr.id','left ')
		->where('ta.auction_type','0')
		//->where('ta.created_by',$user_id)
		->where('ta.status',1)
		->where('ta.auction_start_date >= NOW()');
		//->where('ta.status = 1 or ta.status = 3 or ta.status = 4');
        return $this->datatables->generate();
    }
    
	function addEventBidderdatatable()
    {	
		$user_id =	 $this->session->userdata['id'];
		$this->db->query("SET @row = 0",false); 
        $this->datatables->select("@row := @row + 1 as SNo, a.id, a.bid_last_date, a.reference_no, a.event_title, p.product_description as 
		pdescription",false)
		//->unset_column('a.id')
		->add_column('Actions',"<a class='b_action' href='add_bidder/$1'>Add Bidder</a>", 'a.id')
        ->from('tbl_auction as a')
		->join('tbl_product as p','a.productID=p.id')
		->join('tbl_event_assign as ae','ae.event_id=a.eventID')
		->where('NOW()>=a.bid_last_date')  //bidopening date
		->where('NOW()< a.auction_start_date')
		->where('a.eventID is not null')
		->where('a.auction_type',0)
		->where('a.status',1)
        ->where('a.open_price_bid',0)
		->where('ae.status',1)
		->where('ae.assign_to_id',$user_id);
		//->group_by('ae.assign_to_id',1);
        return $this->datatables->generate();
    }
    
    function participateAuctionBidderByExecutive1()
	{               
		$returndata=array();
		$bidder_userid		=	$this->input->post('bidder_userid');
		$auction_id			=	$this->input->post('auctionID');
		$created_by			=	$this->session->userdata['id'];
                
		if(count($bidder_userid)>0)
		{	 
			$indate	= date("Y-m-d H:i:s");
			
			foreach($bidder_userid as $bidderid)
			{
				$this->db->where("bidderID",$bidderid);
				$this->db->where("auctionID",$auction_id);
				$this->db->where("final_submit","1");
				$query=$this->db->get('tbl_auction_participate');
				$rows=$query->num_rows();
                if($rows==0)
                {    
                    $alaise_name = $this->alias_name(8);	
					$data = array(                 
									'tender_fee'=>1,
									'emd'=>1,
									'frq'=>0,
									'documents'=>1,
									'final_submit'=>1,
									'auctionID'=>$auction_id,
									'alaise_name'=>$alaise_name,
									'status'=>1,
									'is_accept_auct_training'=>0, //new field added
									'operner1_accepted'=>1,
									'opener1_accepted_date'=>$indate,
									'operner2_accepted'=>1,
									'opener2_accepted_date'=>$indate,
									'bidderID'=>$bidderid,
									'added_type'=>'helpdesk_ex',
									'indate'=>$indate,
									'addby'=>$created_by,
									'pstatus'=>1
								);
					//$this->db->insert('tbl_auction_participate',$data);
					$this->db->where("bidderID",$bidderid);
					 $this->db->where("auctionID",$auction_id);
					 $query=$this->db->get('tbl_auction_participate');
					 $rows = $query->num_rows();

					if($rows == 0)
					{
					   $this->db->insert('tbl_auction_participate',$data);
					}
					else
					{
						$this->db->where("bidderID",$bidderid);
						$this->db->where("auctionID",$auction_id);
						$this->db->update('tbl_auction_participate',$data);
					}
									 
					$success .= GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').', ';
                }
                else
                {
                    $error .= GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').', ';
                }
			}
            $returndata = array('success'=>rtrim($success,','),'error'=>rtrim($error,','));        
        }
        else
        {
            $returndata='0';   
        }
		return $returndata;	
	}
	/*Case If bidders are added after bid opening date Then automatic bid opening is done 
	 */

    function participateAuctionBidderByExecutive2()
    {               
		$returndata=array();
		$bidder_userid		=	$this->input->post('bidder_userid');
		$auction_id			=	$this->input->post('auctionID');
		$created_by			=	$this->session->userdata['id'];
                
		if(count($bidder_userid)>0)
		{	 
			$indate	= date("Y-m-d H:i:s");
			
			foreach($bidder_userid as $bidderid)
			{
				$this->db->where("bidderID",$bidderid);
				$this->db->where("auctionID",$auction_id);
				$this->db->where("final_submit","1");
				$query=$this->db->get('tbl_auction_participate');
				$rows=$query->num_rows();
				if($rows==0)
				{    
					$alaise_name =	$this->alias_name(8);	
					$data 		 = 	array(                 
											'tender_fee'=>1,
											'emd'=>1,
											'frq'=>0,
											'documents'=>1,
											'final_submit'=>1,
											'auctionID'=>$auction_id,
											'alaise_name'=>$alaise_name,
											'status'=>1,
											'is_accept_auct_training'=>0, //new field added
											'operner1_accepted'=>1,
											'opener1_accepted_date'=>$indate,
											'operner2_accepted'=>1,
											'opener2_accepted_date'=>$indate,
											'bidderID'=>$bidderid,
											'added_type'=>'helpdesk_ex',
											'indate'=>$indate,
											'addby'=>$created_by,
											'pstatus'=>1
											);
					$this->db->where("bidderID",$bidderid);
					$this->db->where("auctionID",$auction_id);
					$query=$this->db->get('tbl_auction_participate');
					$rows = $query->num_rows();

					if($rows == 0)
					{
						$this->db->insert('tbl_auction_participate',$data);
					}
					else
					{
						$this->db->where("bidderID",$bidderid);
						$this->db->where("auctionID",$auction_id);
						$this->db->update('tbl_auction_participate',$data);
					}
                    $success.=GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').',';
                }
                else
                {
                    $error.=GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').',';
                }
			}
			$this->db->select('reserve_price');
			$this->db->where('id',$auction_id);
			$query_P=$this->db->get('tbl_auction');
			$opening_price=$query_P->result();
			$data_auct_update=array('open_price_bid'=>1,'opening_price'=>$opening_price[0]->reserve_price,'stageID'=>'5');
			$this->db->where('id',$auction_id);
			$this->db->update('tbl_auction',$data_auct_update);
                               
            $returndata=array('success'=>rtrim($success,','),'error'=>rtrim($error,','));        
        }
        else
        {
            $returndata='0';   
        }
		return $returndata;	
	}
	
	function createLoggedEventdatatable()
    {
		$user_id = $this->session->userdata['id'];
		$this->db->query("SET @row = 0",false); 
        $this->datatables->select("@row := @row + 1 as SNo, els.id, els.bank_id, els.branch_id,  tu.email_id, IF(td.name is null, 'N/A',td.name) as drt_name, tb.name as bank_name, tbr.name as bname, ak.account_type as type, els.uploaded_doc",false)
        //->unset_column('tbr.id')
		->unset_column('els.uploaded_doc')
		->unset_column('els.bank_id')
		->unset_column('els.branch_id')
		->add_column('Download',"<a target='_blank' href='/public/uploads/bank/$1'>$1</a>", 'els.uploaded_doc')
		//->add_column('Actions', "<a id='auction1_$3' href='javascript:void(0)' onclick='fnGetSelectAuction($1,$2,$3)'>Attach With Auction</a><span id='auction_$3'></span> | <a href='/helpdesk_executive/createEvent/$3' class='b_action'>Create Auction</a>", 'els.bank_id,els.branch_id,els.id')
		->add_column('Actions', "<a href='/helpdesk_executive/createEvent/$3' class='b_action'>Create Auction</a>", 'els.bank_id,els.branch_id,els.id')
        ->from('tbl_event_log_sales as els')
		->join('tbl_event_assign as ea','ea.event_id=els.id','left ')
		->join('tbl_user_registration as tu','els.created_by=tu.id','left ')
		->join('tbl_bank as tb','els.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left ')
		->join('tbl_drt td','els.drt_id=td.id','left ')
		->join('tbl_account_type as ak','ak.ac_id=els.event_type','left')
		->where('ea.assign_to_id',$user_id)
		->where('els.status !=',0)
		->where('els.status !=',4)
		->where('els.status !=',5)
		->where('ea.status IN(1,2)');
		$this->db->order_by("id",'DESC');
        return $this->datatables->generate();
    }
	
	function saveLoggedEventdatatable()
    {	
		$user_id = $this->session->userdata['id'];
		$this->db->query("SET @row = 0",false); 
        
		$this->datatables->select("@row := @row + 1 as SNo, els.id as eventid,els.bank_id,tu.email_id, IF(td.name is null, 'N/A',td.name) as drt_name, tb.name as bank_name, tbr.name as bname, els.event_type  as type, els.uploaded_doc",false)
                
		// ->unset_column('tbr.id')
		->unset_column('els.uploaded_doc')
		->unset_column('els.bank_id')
		->add_column('Download',"<a download href='/public/uploads/bank/$1'>$1</a>", 'els.uploaded_doc')
		->add_column('Actions',"<a href='/helpdesk_executive/createEvent/$1' class='b_action'>Publish</a>", 'eventid')
        ->from('tbl_event_log_sales as els')
		->join('tbl_event_assign as ea','ea.event_id=els.id','left ')
		->join('tbl_user_registration as tu','els.created_by=tu.id','left ')
		->join('tbl_bank as tb','els.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left ')
		->join('tbl_drt as td','els.drt_id=td.id','left ')
		->join('tbl_auction as ac','ac.eventID=els.id','left ')
		->where('ea.assign_to_id',$user_id)
		->where("(ac.status='0' OR ac.status='2')")
		->where('els.status',4)
		->where('ea.status',1);
		//$this->db->distinct('els.id');
		$this->db->group_by('els.id');
        return $this->datatables->generate();
    }
    
    function getParticipateByAuctionId($eventID)
	{        
        $this->db->where('auctionID', $eventID);
		$this->db->where('final_submit', 1);	
		$query = $this->db->get("tbl_auction_participate");
		$count = 0;		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$count++;
			}           
		}
        return $count;
	}
	
	public function GetRecordById($id) 
	{
		$this->db->where('id', $id);
		$query = $this->db->get("tbl_event_log_sales");		
        if ($query->num_rows() > 0) 
        {
			foreach ($query->result() as $row) 
			{
                $data = $row;
            }           
            return $data;
        }
        return false;
    }
	
	public function GetCountries() 
	{
		$this->db->where('status', 1);	
		$this->db->order_by("id", "desc");
		$this->db->order_by("country_name", "ASC");
        $query = $this->db->get("tbl_country");
        $data = array();
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) 
            {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetState($country_id='') 
	{
		$this->db->where('status', 1);		
		if($country_id)
		{
			$this->db->where("countryID", $country_id);	
		}
		$this->db->order_by("state_name", "ASC");
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_state");
		
        $data = array();
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) 
            {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetCity($state_id=null) 
    {
		$this->db->where('status', 1);		
		if($state_id)
		{
			$this->db->where("stateID", $state_id);		
		}
		$this->db->order_by("city_name", "ASC");
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_city");
        $data = array();
		
		if($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) 
            {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	function uploadvideo($fieldname)
	{
		$config['upload_path'] = $this->videopath;
		$config['allowed_types'] = 'flv|webm|avi|mp4|mpg|zip|xls';
		//$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	function uploadauction($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '30000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true; // Change for Filename change
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	
	function eventBankUserList($utype,$branch_id=NUll,$bankID=NULL,$eid='')
	{        
		if($branch_id)
		{
			$branch_id = $branch_id;
        }
        else
        {
			$userID		= $this->session->userdata['id'];
			$branch_id	= GetTitleByField('tbl_user', "id='".$userID."'", 'user_type_id');
		}
        $this->db->where('status !=', 5);
		$this->db->where('status', 1);
		
		if(isset($eid) && $eid != '')
		{
			$query = $this->db->query("SELECT * FROM tbl_event_log_sales Where id = '".$eid."'");			
			$res = $query->result();
			$erows = $res[0];
			$event_type = $erows->event_type;
		}
		
		if(isset($event_type) && $event_type == '0') // Check DRT USER
		{
			$branch_id = $erows->drt_id;
			$bankID = $erows->bank_id;
			$utype = 'drt';
			$this->db->where("((user_type_id = '".$branch_id."' AND user_type = '".$utype."') OR bank_id = '".$bankID."' )");
		}
		else
		{
			if($branch_id)
			{
				$this->db->where('user_type_id', $branch_id);
			}
			if($bankID){
				$this->db->where('bank_id', $bankID);
			}
			if($utype){
				$this->db->where('user_type', $utype);
			}
		}
		$this->db->order_by("email_id", "ASC");
		$query = $this->db->get("tbl_user");

		$data = array();
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$data[] = $row;
			}
            return $data;            
		}
        return false;
	}
	
	function getUserByBankId($bankID=NULL)
	{        

        $this->db->where('status !=', 5);
		$this->db->where('status', 1);	

		$this->db->where('bank_id', $bankID);
		
		$this->db->where('user_type', 'branch');
		$this->db->order_by("email_id", "ASC");
		$query = $this->db->get("tbl_user");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
            return $data;
		}
        return false;
	}
	
	function getUserByBranchId($branch_id=NULL)
	{        
        $this->db->where('status !=', 5);
		$this->db->where('status', 1);	
		{
			$this->db->where('user_type_id', $branch_id);
		}
		$this->db->where('user_type', 'branch');
		$this->db->order_by("email_id", "ASC");
		$query = $this->db->get("tbl_user");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
        return false;
	}
	
	public function assignEventLogAuction($auction_id,$event_id) 
	{
		$data['status']=4;
		$this->db->where('id', $event_id);
		$this->db->update('tbl_event_log_sales', $data);
		//echo "detail".$auction_id.'---'.$event_id;
		$data1=array('eventID'=>$event_id);
		$this->db->where('id', $auction_id);
		$this->db->update('tbl_auction', $data1); 
        return false;
    }
    
	public function GetCategory() 
	{
		$this->db->where("status", 1);
		$this->db->where("parent_id", 0);
        $query = $this->db->get("tbl_category");
        $data = array();
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetsubCategorydata($cate=null) 
	{
		$this->db->where("status", 1);
		$this->db->where("parent_id", $cate);
		$this->db->order_by("name", "ASC");
        $query = $this->db->get("tbl_category");
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetBranchdata($bankid=null) 
    {
		$this->db->where("status", '1');
		$this->db->where("bank_id", $bankid);
		$this->db->order_by("name", "ASC");
        $query = $this->db->get("tbl_branch");
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }

	public function GetCategoryRecordById($id) 
	{
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
	public function GetSubCategory($category)
	{
		$this->db->where("status", 1);
		$this->db->where("parent_id", $category);
		$this->db->order_by("name", "ASC");
        $query = $this->db->get("tbl_category");
	
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetCategorylist($category) 
	{
		$this->db->where("status", 1);
		$this->db->where("parent_id", 0);
		$this->db->order_by("id", "ASC");
        $query = $this->db->get("tbl_category");
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetRecordByCategory($category_id,$is_auction='',$is_bank='',$is_sell='') 
	{
	
		$this->db->select('a.* , ag.name as group_name, ag.id as group_id, ag.is_display');		
		$this->db->from("tbl_attribute_group as ag");
		$this->db->join('tbl_attribute as a', 'a.group_id = ag.id and a.status=1', 'left');
		$this->db->where("FIND_IN_SET('$category_id',ag.category_id) !=", 0);
		$this->db->where("ag.status",1);
		if($is_auction)
		{
			$this->db->where("(a.is_auction='$is_auction' OR a.is_auction='both')");
		}
		if($is_bank)
		{
			$this->db->where("(a.is_bank='$is_bank' OR a.is_bank='both')");
		}
		if($is_sell)
		{
			$this->db->where("(a.is_sell='$is_sell' OR a.is_sell='both')");
		}
		$this->db->order_by("a.priorty", "asc");
		$this->db->order_by("ag.priority", "asc");
		$query = $this->db->get();
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data[$row->group_id][] = $row;
            }
            return $data;
        }
        return false;
    }

	public function GetProductDetail($product_id) 
	{
		$this->db->where('id ', $product_id);		
        $query = $this->db->get("tbl_product");	
		
        $data = array();
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$data = $row;
            }
            return $data;
        }
        return false;
    }

	
	public function GetProductDetailByProductID($productID) 
	{
		$this->db->where('id ', $productID);		
        $query = $this->db->get("tbl_product");	
	
        $data = array();
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) 
            {
				$data = $row;
				if($row->id)
				{
					$this->db->where('product_id ', $row->id);	
					$this->db->where('status !=', 5);		
					$this->db->where('type', 'images');		
					$query = $this->db->get("tbl_product_image_video");	
					foreach ($query->result() as $irow){
					 $data->images[]=$irow;
					}
					
					$this->db->where('product_id ', $row->id);
					$this->db->where('status !=', 5);
					$this->db->where('type', 'file');									
					$this->db->or_where('type', 'url');									
					$query = $this->db->get("tbl_product_image_video");	
					foreach ($query->result() as $vrow){
					 $data->video[]=$vrow;
					}
					
					
					$this->db->where('product_id ', $row->id);
					$this->db->where('status !=', 5);									
					$query = $this->db->get("tbl_product_attribute_value");	
					foreach ($query->result() as $arow){
					 $data->attr_val[]=$arow;
					}
				}						
            }
            return $data;
        }
        return false;
    }

	
	public function GetAttributeValue($product_id) 
	{
		$this->db->select('attribute_id ,values');
		$this->db->where('product_id ', $product_id);
		$this->db->where('product_id !=',0);
		$this->db->where('product_id !=','undefined');
        $query = $this->db->get("tbl_product_attribute_value");	
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[$row->attribute_id] = $row;
            }
            return $data;
        }
        return false;
    }

	
	public function createEventdatastep1($eventid)
	{
		$bankuser 	= $this->input->post('bankuser');
		$eventID 	= $this->input->post('eventID');
		$auctionID 	= $this->input->post('auctionID');
		$created_by	= $this->session->userdata['id'];
		$erows		= $this->helpdesk_executive_model->GetRecordById($eventID);	
		$indate=date('Y-m-d H:i:s');
		
		$data = array(
					'first_opener'=>$bankuser,
					'status'=>2,
					'auction_type'=>0,
					'created_by'=>$created_by,
					'eventID'=>$eventID);
					
        $auctionID	= GetTitleByField('tbl_auction', "eventID='".$eventID."'", 'id');       
		
		if($auctionID>0)
		{
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',$data);	
			$this->db->where('auction_id', $auctionID);
			$this->db->update('tbl_log_auction',$data);	 //LOG
			$id = $auctionID;
		}
		else
		{
			$data['bank_id']=$erows->bank_id;
			$data['branch_id']=$erows->branch_id;
			$data['indate']=$indate;
			$data['updated_date']=$indate;      
			$this->db->insert('tbl_auction',$data);	
			$id = $this->db->insert_id();
			$data['auction_id']=$id;
			$this->db->insert('tbl_log_auction',$data);	 //LOG
		}	
		
		if($id)
		{       
            $this->db->where('id', $eventID);
			$this->db->update('tbl_event_log_sales', array('status'=>4,'updated_date'=>date('Y-m-d H:i:s'))); 	
			$this->db->where('event_log_id', $eventID);
			$this->db->update('tbl_log_event_log', array('status'=>4,'updated_date'=>date('Y-m-d H:i:s'))); 	//LOG
		}
		return $id;
	}
	
	
	
	public function document_list() 
	{
        $this->db->where("status", 1);
        $query = $this->db->get("tbl_doc_master");
        $data = array();
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	

	function saveeventdata()
	{
		//ini_set("display_errors", "1");
		//error_reporting(E_ALL);
		$created_by					=	 $this->session->userdata['id'];
		$auctionID 					=	 $this->input->post('auctionID');
		$eventID 					=	 $this->input->post('eventID');
		$account 					=	 $this->input->post('account');
		$tender_no 					= 	 $this->input->post('tender_no');
		$reference_no 				= 	 $this->input->post('reference_no');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category');
		$branch_id 					=	 $this->input->post('branch_id');
		$drt_id 					=	 $this->input->post('drt_id');
		$bank_id 					=	 $this->input->post('bank_id');
		$subcategory_id 			=	 $this->input->post('subcategory_id');
		$borrower_name 				=	 $this->input->post('borrower_name');
		$invoice_mail_to 			=	 $this->input->post('invoice_mail_to');
		$invoice_mailed 			=	 $this->input->post('invoice_mailed');
		$reserve_price 				=	 $this->input->post('reserve_price');
		$emd_amt 					=	 $this->input->post('emd_amt');
		$tender_fee 				=	 $this->input->post('tender_fee');
		$nodal_bank_name 			=	 $this->input->post('nodal_bank_name');
		$nodal_bank 				=	 $this->input->post('nodal_bank');
		$nodal_bank_account			=	 $this->input->post('nodal_bank_account');
		$branch_ifsc_code 			=	 $this->input->post('branch_ifsc_code');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$inspection_date_from 		=	 $this->input->post('inspection_date_from');
		$inspection_date_to 		=	 $this->input->post('inspection_date_to');
		$bid_last_date 				=	 $this->input->post('bid_last_date');
		$bid_opening_date 			=	 $this->input->post('bid_opening_date');
		$auction_start_date 		=	 $this->input->post('auction_start_date');
		$auction_end_date 			=	 $this->input->post('auction_end_date');
		$show_frq 					=	 $this->input->post('show_frq');
		$dsc_enabled 				=	 $this->input->post('dsc_enabled');
		$price_bid 					=	 $this->input->post('price_bid');
		$bid_inc 					=	 $this->input->post('bid_inc');
		$auto_extension_time 		=	 $this->input->post('auto_extension_time');
		$auto_extension 			=	 $this->input->post('auto_extension');
		$doc_to_be_submitted 		=	 $this->input->post('doc_to_be_submitted');
		$second_opener 				=	 $this->input->post('second_opener');
		$Publish 					=	 $this->input->post('Publish');
		$auto_bid_cut_off 			=	 $this->input->post('auto_bid_cut_off');
		$is_closed 					=	 $this->input->post('is_closed');
		$bidders_list 				=	 $this->input->post('bidders_list');
		$drtEvent 				    =	 $this->input->post('drtEvent');
		$bank_name 				    =	 $this->input->post('bank_name');
		$bank_branch_id 			=	 $this->input->post('bank_branch_name');
		$show_home 			=	 $this->input->post('show_home');
		
		if($drtEvent)
		{	
			$bank_id = $bank_name;			
		}
		
		if($bank_branch_id > 0)
		{
			$branch_id = $bank_branch_id;
		}
                
		$country_id = $this->input->post('country_id');
		$state_id   = $this->input->post('state_id');
		$city 	    = $this->input->post('city_id');
		
		if($city == '' || $city == 'others')
		{
			$other_city = $this->input->post('other_city');
		}
		else
		{
			$other_city='';     
		}
		
		if($nodal_bank=='others')
		{
			$nodal_bank_name =	$this->input->post('nodal_bank_n');
		}
		else
		{
			$nodal_bank_name = $this->input->post('nodal_bank_name');   
		}  
                
		$press_release_date			= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		
		if($inspection_date_from)
		{
			$inspection_date_from	= 	date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}
		if($inspection_date_to)
		{
			$inspection_date_to		= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));	
		}
		
		$bid_last_date				= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		$bid_opening_date			= 	date("Y-m-d H:i:s",strtotime($bid_opening_date));
		$auction_start_date			= 	date("Y-m-d H:i:s",strtotime($auction_start_date));
		$auction_end_date			= 	date("Y-m-d H:i:s",strtotime($auction_end_date));
		if($press_release_date!='' && $press_release_date == '1970-01-01 05:30:00')
		{
			$press_release_date = '';
		}
		
		if($inspection_date_from!='' && $inspection_date_from == '1970-01-01 05:30:00')
		{
			$inspection_date_from = '';
		}
		
		if($inspection_date_to!='' && $inspection_date_to == '1970-01-01 05:30:00')
		{
			$inspection_date_to = '';
		}
		
		if($bid_last_date!='' && $bid_last_date == '1970-01-01 05:30:00')
		{
				$bid_last_date = '';
		}
		
		if($bid_opening_date!='' && $bid_opening_date == '1970-01-01 05:30:00')
		{
				$bid_opening_date = '';
		}
		
		if($auction_start_date!='' && $auction_start_date == '1970-01-01 05:30:00')
		{
				$auction_start_date = '';
		}
		
		if($auction_end_date!='' && $auction_end_date == '1970-01-01 05:30:00')
		{
				$auction_end_date = '';
		}
		
		$productID	=	GetTitleByField('tbl_product', "auctionID='".$auctionID."'", 'id');
		if($Publish)
		{
			$status=1; $pstatus=1;
		}
		else
		{
			$status=0; $pstatus=4;
		}
		
		if($_FILES['image']['name'])
		{
			$image=$this->uploadauction('image');
		}
		else
		{
			$image=$this->input->post('old_image');
		} 
	
		if($_FILES['related_doc']['name'])
		{
			$related_doc=$this->uploadauction('related_doc');
		}
		else
		{
			$related_doc=$this->input->post('old_related_doc');
		}
		
        if($_FILES['supporting_doc']['name'])
		{
			$supporting_doc=$this->uploadauction('supporting_doc');
		}
		else
		{
			$supporting_doc=$this->input->post('old_supporting_doc');
		}
	
		if($doc_to_be_submitted)
		{
			$doc_to_be_submitted=implode(",",$doc_to_be_submitted);
		}
		
		if($invoice_mailed)
		{
			$invoice_mailed=implode(",",$invoice_mailed);
		}
		
		$data 	= array('productID'=>$productID,
						'eventID'=>$eventID,
						'auto_bid_cut_off'=>$auto_bid_cut_off,
						'event_type'=>$account,
						'reference_no'=>$reference_no,
						'tender_no'=>$tender_no,
						'event_title'=>$event_title,
						'category_id'=>$category_id,
						'subcategory_id'=>$subcategory_id,
						'bank_id'=>$bank_id,
						'branch_id'=>$branch_id,
						'drt_id'=>$drt_id,
						//'bank_id'=>$bank_id,
						'borrower_name'=>$borrower_name,
						'invoice_mail_to'=>$invoice_mail_to,
						'invoice_mailed'=>$invoice_mailed,
						'reserve_price'=>$reserve_price,
						'emd_amt'=>$emd_amt,
						'tender_fee'=>$tender_fee,
						'nodal_bank_name'=>$nodal_bank_name,
						'nodal_bank'=>$nodal_bank,
						'nodal_bank_account'=>$nodal_bank_account,
						'branch_ifsc_code'=>$branch_ifsc_code,
						'press_release_date'=>$press_release_date,
						'inspection_date_from'=>$inspection_date_from,
						'inspection_date_to'=>$inspection_date_to,
						'bid_last_date'=>$bid_last_date,
						'bid_opening_date'=>$bid_opening_date,
						'auction_start_date'=>$auction_start_date,
						'auction_end_date'=>$auction_end_date,
						'bank_branch_id'=>$bank_branch_id,
						'show_frq'=>$show_frq,
						'dsc_enabled'=>$dsc_enabled,
						'bid_inc'=>$bid_inc,
						'price_bid_applicable'=>$price_bid,
						'related_doc'=>$related_doc,
						'image'=>$image,
						'auto_extension_time'=>$auto_extension_time,
						'no_of_auto_extn'=>$auto_extension,
						'doc_to_be_submitted'=>$doc_to_be_submitted,
						'second_opener'=>$second_opener,
						'created_by'=>$created_by,
						'is_closed'=>$is_closed,
						'countryID'=>  $country_id,
						'state'=> $state_id,
						'city'=> $city,
						'other_city'=>$other_city,
						'supporting_doc'=>$supporting_doc,
						 //new fields
						'indate'=>date('Y-m-d H:i:s'),
						 'status'=>$status,
						 'show_home'=>$show_home
					);
					$auctionID	= GetTitleByField('tbl_auction', "eventID='".$eventID."'", 'id');
                
					if($auctionID)
					{
						$this->db->where('id', $auctionID);
						$auction=$this->db->update('tbl_auction',$data); 
						
						if($auction)
						{
							$this->db->where('id', $eventID);
							$statustype='';
							if($account=='drt'){ $statustype='0';}
							if($account=='sarfaesi'){$statustype='1';}
							if($account=='others'){$statustype='2';}
						    $data_event=array('event_type'=>$statustype);    
							$this->db->update('tbl_event_log_sales',$data_event); 
						}
						$this->db->where('auction_id', $auctionID);
						$this->db->update('tbl_log_auction',$data); 
						
						$insertedid_id 	= $auctionID;
						/*$data['auction_id'] = $insertedid_id;
						$this->db->insert('tbl_log_auction',$data);*/
					}
					else
					{
						$data['updated_date'] = date('Y-m-d H:i:s');
						$this->db->insert('tbl_auction',$data);             
						$insertedid_id = $this->db->insert_id();
						$data['auction_id'] = $insertedid_id;
						$this->db->insert('tbl_log_auction',$data);
					}
					
					$ip = $_SERVER['REMOTE_ADDR'];
					$current_date = date('Y-m-d H:i:s');
					
					if(isset($invoice_mail_to))
					{
						$data_invoice_mailed_to = array('event_id'=>$eventID,'auction_id' => $insertedid_id,'type'=>'bank_user','ip'=>$ip,'indate'=>$current_date,'bank_user_id'=>$invoice_mail_to);
						$this->db->insert('tbl_log_event_creation',$data_invoice_mailed_to);
					}
					
					if(isset($doc_to_be_submitted))
					{
						$data_doc_to_be_sub = array('event_id'=>$eventID,'auction_id' => $insertedid_id,'type'=>'doc_sub','ip'=>$ip,'indate'=>$current_date,'document_to_be_submitted'=>$doc_to_be_submitted);
						$this->db->insert('tbl_log_event_creation',$data_doc_to_be_sub);
					}
					
					if(isset($second_opener))
					{
						$data_second_opener = array('event_id'=>$eventID,'auction_id' => $insertedid_id,'type'=>'second_opener','ip'=>$ip,'indate'=>$current_date,'second_opener_id'=>$second_opener,'bank_user_id'=>$invoice_mail_to);
						$this->db->insert('tbl_log_event_creation',$data_second_opener);
					}
					
					if($_FILES['related_doc']['name'])
					{
						$data_related_doc = array('event_id'=>$eventID,'auction_id' => $insertedid_id,'type'=>'rel_doc','ip'=>$ip,'indate'=>$current_date,'bank_user_id'=>$invoice_mail_to);
						$this->db->insert('tbl_log_event_creation',$data_related_doc);
						
					}
					
					if($_FILES['image']['name'])
					{
						$data_images = array('event_id'=>$eventID,'auction_id' => $insertedid_id,'type'=>'img','ip'=>$ip,'indate'=>$current_date,'bank_user_id'=>$invoice_mail_to);
						$this->db->insert('tbl_log_event_creation',$data_images);
					}
					
				 	//******************Start Add Close Auction Bidders***************
					if($is_closed==1)
					{
						if(count($bidders_list))
						{
							$query=$this->db->query("SELECT bidderID from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
							if ($query->num_rows() > 0) 
							{
								foreach ($query->result() as $cbrow)
								{
									if(!in_array($cbrow->bidderID,$bidders_list))
									{
										$this->db->where('auctionID', $auctionID);
										$this->db->where('bidderID', $cbrow->bidderID);
										$this->db->delete('tbl_closed_auction_bidder');	
									}
								}	
							}
							
							$newbidderArr=$this->getAllCloseAuctionBidder($auctionID);
							foreach($bidders_list as $bidderID)
							{
								if(!in_array($bidderID,$newbidderArr))
								{
									$bidderdata='';
									$email_id	=	GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'email_id');
									$productUrl=$_SERVER['SERVER_NAME'].$productID;
									$bidderdata = array('bidderID'=>$bidderID,
														'auctionID'=>$auctionID,
														'email'=>$email_id,
														'product_url'=>$productUrl,
														'status'=>1,
														'indate'=>date('Y-m-d H:i:s'));
									 $this->db->insert('tbl_closed_auction_bidder',$bidderdata);
									 $this->sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID);
								}
							}
						}

					}
						
					//******************End Add Close Auction Bidders***************
					if($insertedid_id)
					{
						$this->db->where('id', $productID);
						$this->db->update('tbl_product', array('status'=>$pstatus,'updated_date'=>date('Y-m-d H:i:s')));
						$this->db->where('id', $eventID);
						$this->db->update('tbl_event_log_sales', array('status'=>4,'updated_date'=>date('Y-m-d H:i:s'))); 
						$this->db->where('event_log_id', $eventID);
						$this->db->update('tbl_log_event_log', array('status'=>4,'updated_date'=>date('Y-m-d H:i:s'))); 
					}
					return $insertedid_id;
					
	}	

	function sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID)
	{
		$username	=	GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'first_name');
		$email_msg  = "Hi ".ucfirst($username)." ,<br> You have selected for Close Auction '".$reference_no."-".$event_title."'<a href='".$productUrl."'>Property.</a>";
		$fromemail  = "info@c1indiabankeauction.com";
		$mailsubject= $reference_no." Close Auction By C1india";
        $to = $email_id;
		$headers  = "From: $fromemail\r\n";
		$headers .= "Content-type: text/html\r\n";
		
		mail($to, $mailsubject, $email_msg, $headers);
	}
		
	public function GetRecordByArticleId($product_id) 
	{
        $this->db->where('product_id', $product_id);
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_product_image_video");
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }	
	
	public function GetAutionRecordById($eid) 
	{
        $this->db->where('eventID', $eid);
		$query = $this->db->get("tbl_auction");
				
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetAutionRecordByAuctionId($eid) 
	{
        $this->db->where('id', $eid);
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetAutionRecordByProductId($pid) 
	{
		$this->db->where('productID', $pid);
		$query = $this->db->get("tbl_auction");
				
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
				$data = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function GetAutionbyId($eid) 
	{
        $this->db->where('id', $eid);     
		$query = $this->db->get("tbl_auction");
				
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetAution4ApprovalbyId($eid) 
	{
		$whrArr = array(1,2,3);
        $this->db->where('id', $eid);
        $this->db->where_in('approvalStatus',$whrArr);     
		$query = $this->db->get("tbl_auction");
				
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
	function AddBiddersUsersData($auction_id)
	{
		$this->db->query("SET @row = 0",false); 
        $this->datatables->select("@row := @row + 1 as SNo,id, email_id,IF(register_as = 'builder',organisation_name, CONCAT(first_name, ' ', last_name)) as bidder_name , mobile_no",false)
		->unset_column('id')
		->add_column('Actions',"<a href='/helpdesk_executive/auction_participate/$1/$auction_id' class='b_action'> Participate </a>", "id")
		->where("user_type IN ('broker','bidder','owner','builder')")
		->where("id NOT IN (SELECT bidderID FROM tbl_auction_participate WHERE auctionID = '".$auction_id."' and final_submit = '1')")
        ->from('tbl_user_registration');
        return $this->datatables->generate();
		
	}
        
    function AddBiddersUsersData1($auction_id)
    {
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("@row := @row + 1 as SNo,reg.id, reg.email_id,IF(reg.register_as = 'builder',reg.organisation_name, CONCAT(reg.first_name, ' ', reg.last_name)) as bidder_name , reg.mobile_no",false)
		->unset_column('reg.id')
		->add_column('Select Bidders',"<input type='checkbox' name='bidder_userid[]' class='bidder_userid[]' value='$1'>", "reg.id")
		->where("reg.user_type IN ('broker','bidder','owner','builder')")
		->where("reg.id NOT IN (SELECT bidderID FROM tbl_auction_participate WHERE auctionID = '".$auction_id."' and final_submit = '1')")               
		->from('tbl_user_registration as reg')
		->group_by("reg.id");
        return $this->datatables->generate();	
	}
	
	function limiteduserallbidderlist($auction_id)
    {
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("@row := @row + 1 as SNo,reg.id, reg.email_id,IF(reg.register_as = 'builder',reg.organisation_name, CONCAT(reg.first_name, ' ', reg.last_name)) as bidder_name , reg.mobile_no",false)
		->unset_column('reg.id')
		->add_column('Select Bidders',"<input type='checkbox' name='bidder_userid[]' class='bidder_userid[]' value='$1'>", "reg.id")
		->where("reg.user_type IN ('broker','bidder','owner','builder')")
		->where("reg.id NOT IN (SELECT bidder_id FROM tbl_auction_bidder_limited_access WHERE auction_id = '".$auction_id."' and status = '1')")               
		->from('tbl_user_registration as reg')
		->group_by("reg.id");
        return $this->datatables->generate();	
	}
	
	function limiteduserselectedbidderlist($auction_id)
    {
		$this->db->query("SET @row = 0",false); 
		$this->datatables->select("@row := @row + 1 as SNo,reg.id, reg.email_id,IF(reg.register_as = 'builder',reg.organisation_name, CONCAT(reg.first_name, ' ', reg.last_name)) as bidder_name , reg.mobile_no",false)
		->unset_column('reg.id')
		->add_column('Select Bidders',"<input type='checkbox' name='bidder_userid[]' class='bidder_userid[]' value='$1'>", "reg.id")
		->where("reg.user_type IN ('broker','bidder','owner','builder')")
		->where("reg.id IN (SELECT bidder_id FROM tbl_auction_bidder_limited_access WHERE auction_id = '".$auction_id."' and status = '1')")               
		->from('tbl_user_registration as reg')
		->group_by("reg.id");
        return $this->datatables->generate();	
	}
        
    function viewbankerUsersData($id,$sid)
    {
        $bind = array($id, $sid);
        $this->db->query("SET @row = 0",false); 
        $this->db->select("@row := @row + 1 as SNo,id, email_id,CONCAT(first_name, ' ', last_name) as bidder_name , mobile_no",false)
		->where_in('id', $bind)
        ->from('tbl_user')
        ->order_by('id','desc');  
        return $this->datatables->generate();;
    }
		
	function UploadAuctionDocument()
	{
		$documentid		=	$this->input->post('documentid');
		$auction_id		=	$this->input->post('auction_id');
		$bidderid		=	$this->input->post('bidderid');
		$submit			=	$this->input->post('submit');
		$created_by		=	$this->session->userdata['id'];
		$indate			=	date("Y-m-d H:i:s");
		$i=0;
		if($documentid)
		{
			$docArr=explode(',',$documentid);
			if(count($docArr)>0)
			{
				foreach($docArr as $docKey)
				{
					$filename = 'doc_name_'.trim($docKey);
					
					if($_FILES[$filename]['name']){
						$docfilename=$_FILES[$filename]['name'];
						$image=$this->uploadDocument($filename,$auction_id,$bidderid);
					}else if($this->input->post('old_doc_name_'.$docKey)){
						$image=$this->input->post('old_doc_name_'.$docKey);
						
					}
					if($image)
					{
						$this->db->where('auctionID',"$auction_id");	
						$this->db->where('bidderID',"$bidderid");	
						$this->db->where('documentID',"$docKey");	
						$this->db->delete('tbl_auction_participate_doc');
						$data 	= array(
									'auctionID'=>$auction_id,
									'bidderID'=>$bidderid,
									'documentID'=>$docKey,
									'document_name'=>$image,
									'addby'=>$created_by,
									'indate'=>$indate);
						
						$this->db->insert('tbl_auction_participate_doc',$data); 
						$insertedid_id = $this->db->insert_id();
						$i++;	
					}
				}
				
			}
		}
		return $i;
	}
	
	
	function UploadAuctionEmdDocument()
	{		
		$auction_id					=	$this->input->post('auction_id');
		$bidderid					=	$this->input->post('bidderid');
		$emd_deposit_date			=	$this->input->post('emd_deposit_date');
		$emd_amount					=	$this->input->post('emd_amount');
		$utr_no						=	$this->input->post('utr_no');
		$drawn_bank					=	$this->input->post('drawn_bank');
		$account_holder_bank_name	=	$this->input->post('account_holder_bank_name');
		$account_holder_name		=	$this->input->post('account_holder_name');
		$account_number				=	$this->input->post('account_number');
		$ifsc_code					=	$this->input->post('ifsc_code');
		$utr_type					=	$this->input->post('utr_type');
		$submit						=	$this->input->post('emd_doc');
		$created_by					=	$this->session->userdata['id'];
		$indate						=	date("Y-m-d H:i:s");
		$i=0;
		if($submit)
		{

				
				$this->db->where('auctionID',$auction_id);	
				$this->db->where('bidderID',$bidderid);	
				$this->db->where('utr_type',$utr_type);	
				$utrQry = $this->db->get('tbl_auction_bidder_utr_no');
				
				$data 	= array(
							'auctionID'=>$auction_id,
							'bidderID'=>$bidderid,
							'emd_deposit_date'=>date('Y-m-d H:i:s', strtotime($emd_deposit_date)),
							'emd_amount'=>$emd_amount,
							'utr_no'=>$utr_no,
							'drawn_bank'=>$drawn_bank,
							'account_holder_bank_name'=>$account_holder_bank_name,
							'account_holder_name'=>$account_holder_name,
							'account_number'=>$account_number,
							'ifsc_code'=>$ifsc_code,
							'utr_type'=>$utr_type,								
							'status'=>1,
							'indate'=>$indate
				);	
				
				if($utrQry->num_rows()>0)
				{
					$rows = $utrQry->result();
					
					$this->db->where('auctionID',$auction_id);	
					$this->db->where('bidderID',$bidderid);	
					$this->db->where('utr_type',$utr_type);						
					$this->db->update('tbl_auction_bidder_utr_no',$data); 
					$insertedid_id = $rows[0]->utr_id;
				}
				else
				{									
					$this->db->insert('tbl_auction_bidder_utr_no',$data); 
					$insertedid_id = $this->db->insert_id();					
				}
				
				if($insertedid_id)
				{
					$dataAucPart['payment_verifier_accepted'] = NULL;
					$dataAucPart['payment_verifier_comment'] = NULL;
					$dataAucPart['payment_move_to_opener2'] = 0;
					$dataAucPart['payment_verifier_accepted_date'] = NULL;
					$dataAucPart['modify_date'] = date("Y-m-d H:i:s");
					$this->db->where('bidderID',$bidderid);
					$this->db->where('auctionID',$auction_id);
					$this->db->update('tbl_auction_participate',$dataAucPart);	
				}
				
		}
		return $insertedid_id;
	}
	
	
	function uploadDocument($fieldname,$auction_id,$bidderid)
	{   		
		$auctionDir=$_SERVER['DOCUMENT_ROOT'].'/'.$this->document_auction.$auction_id;
	    $bidderidDir=$_SERVER['DOCUMENT_ROOT'].'/'.$this->document_auction.$auction_id.'/'.$bidderid.'/';
		if (!is_dir($auctionDir))
		{
			mkdir($auctionDir, 0777);
			chmod($auctionDir,0777);
		}
		if (!is_dir($bidderidDir))
		{
			mkdir($bidderidDir, 0777);
			chmod($bidderidDir,0777);
		}
		
		$config['upload_path'] = $bidderidDir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf'; //|doc|docx|zip|xls
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		if (!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
               }else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	
	function uploadEmdDocument($fieldname,$auction_id,$bidderid)
	{   		
		//echo $fieldname;die;
		$auctionDir=$_SERVER['DOCUMENT_ROOT'].'/'.$this->emd_document_auction.$auction_id;
	    $bidderidDir=$_SERVER['DOCUMENT_ROOT'].'/'.$this->emd_document_auction.$auction_id.'/'.$bidderid.'/';
	    
		if (!is_dir($auctionDir))
		{
			mkdir($auctionDir, 0777);
			chmod($auctionDir,0777);
		}
		if (!is_dir($bidderidDir))
		{
			mkdir($bidderidDir, 0777);
			chmod($bidderidDir,0777);
		}
		
		$config['upload_path'] = $bidderidDir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf'; //|doc|docx|zip|xls
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		if (!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
			echo "<pre>";print_r($error);die;
               }else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	function upload_supporting_Document($fieldname,$auction_id,$bidderid,$uploadType)
	{   
		$auctionDir					=	$_SERVER['DOCUMENT_ROOT'].'/'.$this->document_auction.$auction_id;
		$bidderidDir				=	$_SERVER['DOCUMENT_ROOT'].'/'.$this->document_auction.$auction_id.'/'.$bidderid.'/';
		$bidderidsupporting_docDir	=	$_SERVER['DOCUMENT_ROOT'].'/'.$this->document_auction.$auction_id.'/'.$bidderid.'/'.$uploadType.'/';
		if (!is_dir($auctionDir))
		{       $old = umask(0); 
                        mkdir($auctionDir, 0777);
			chmod($auctionDir,0777);
                        umask($old); 
		}
		if (!is_dir($bidderidDir))
		{       $old = umask(0);  
			mkdir($bidderidDir, 0777);
			chmod($bidderidDir,0777);
                        umask($old); 
		}
		if (!is_dir($bidderidsupporting_docDir))
		{       $old = umask(0);
			mkdir($bidderidsupporting_docDir, 0777);
			chmod($bidderidsupporting_docDir,0777);
                        umask($old);
		}
		$config['upload_path'] = $bidderidsupporting_docDir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}

	function eventTrackData($auction_id)
    {	
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();			
			$this->db->where('final_submit', 1);            
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_auction_participate");
			if($query->num_rows()>0)
			{
				$data1=array();
				foreach ($query->result() as $row1)
				{
					//emd fee
					$this->db->where('auctionID', $data[0]->id);
					$this->db->where('bidderID', $row1->bidderID);
					$query_emd = $this->db->get("tbl_auction_participate_emd");
					$emd_result=$query_emd->result();
					$row1->emd_detail=$emd_result;
					
					//frq
					$this->db->where('auctionID', $data[0]->id);
					$this->db->where('bidderID', $row1->bidderID);
					$query_frq = $this->db->get("tbl_auction_participate_frq");
					$frq_result=$query_frq->result();
					$row1->frq_detail = $frq_result;
					
					//tender fee
					$this->db->where('auctionID', $data[0]->id);
					$query_tenderfee = 
					$this->db->get("tbl_auction_participate_tenderfee");
					$tenderfee_result=$query_tenderfee->result();
					$row1->tenderfee=$tenderfee_result;
					
					//doc
					$this->db->where('auctionID', $data[0]->id);
					$query_tenderfee = 
					$this->db->get("tbl_auction_participate_tenderfee");
					$this->db->where('auctionID', $data[0]->id);
					$query_doc = $this->db->get("tbl_auction_participate_doc");
					$data_doc=array();
					foreach ($query_doc->result() as $row_doc)
					{
					$data_doc[]=$row_doc;
					}
					$row1->doc=$data_doc;
					//doc end
					$data1[]=$row1;
					$data[0]->bider_detail = $data1;
				}
			}
			/***** end bidder*****/
			
			/***** property desc*****/
			$this->db->select('product_description');
			//$this->db->where('status !=', 5);
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_product");
			$bider_total=$query->result();
			$data[0]->property_description=$bider_total[0]->product_description;
			/***** property desc*****/
			return $data;
		}
		return false;
    }
    
	public function getBidderFRQ($auctionId)
	{
		$this->db->where('aperti.auctionID', $auctionId);
		$query_frq = $this->db->get("tbl_auction_participate_frq as aperti");
		$frq_result=$query_frq->result();
		return $frq_result;
	}
	
	function saveAuctionEmd()
	{
		$emdID					=	$this->input->post('emdID');
		$bank_name				=	$this->input->post('bank_name');
		$instrument_type		=	$this->input->post('instrument_type');
		$instrument_no			=	$this->input->post('instrument_no');
		$instrument_date		=	$this->input->post('instrument_date');
		$instrument_expiry_date	=	$this->input->post('instrument_expiry_date');
		$beneficiary			=	$this->input->post('beneficiary');
		$refund_bank_name		=	$this->input->post('refund_bank_name');
		$branch_add				=	$this->input->post('branch_add');
		$city					=	$this->input->post('city');
		$account_no				=	$this->input->post('account_no');
		$branch_ifsc_code		=	$this->input->post('branch_ifsc_code');
		$auction_id				=	$this->input->post('auction_id');
		$bidderid				=	$this->input->post('bidderid');
		$created_by				=	$this->session->userdata['id'];
		$indate					=	date("Y-m-d H:i:s");
		$amount					=	GetTitleByField('tbl_auction', "id='".$auction_id."'", 'emd_amt');
		if($_FILES['supporting_doc_path']['name'])
		{
			$supportingDoc =$this->upload_supporting_Document('supporting_doc_path',$auction_id,$bidderid,'emd_supporting_doc');
			if($supportingDoc)
			{
				$msg='Record has been saved successfully.';
				$this->db->select('eventID,bank_id');  
				$this->db->from('tbl_auction');   
				$this->db->where('id', $auction_id);
				$query1=$this->db->get();
				$row1=$query1->result();
				$message='Emd Documents uploaded Successfully';
				$data12=array(  
				  'event_id'=>$row1[0]->eventID,
				  'auction_id'=>$auction_id,
				  'action_type'=>'Documents_upload_In_EMD',
				  'bank_id'=>$row1[0]->bank_id,
				  'bidder_id'=>$bidderid,
				  'indate'=>date('Y-m-d H:i:s'),
				  'status'=>'1',
				  'ip'=>$_SERVER['REMOTE_ADDR'],
				  'message'=>$message
				  );
				$this->db->insert('tbl_log_bidsubmission_track',$data12); 
            }
        }
        else
        {
		  $supportingDoc =	$this->input->post('supporting_doc_path_old');
		}
		
		$data 	= array(
						'bank_name'=>$bank_name,
						'instrument_type'=>$instrument_type,
						'instrument_no'=>$instrument_no,
						'instrument_date'=>$instrument_date,
						'instrument_expiry_date'=>$instrument_expiry_date,
						'beneficiary'=>$beneficiary,
						'refund_bank_name'=>$refund_bank_name,
						'branch_add'=>$branch_add,
						'city'=>$city,
						'account_no'=>$account_no,
						'branch_ifsc_code'=>$branch_ifsc_code,
						'auctionID'=>$auction_id,
						'bidderID'=>$bidderid,
						'amount'=>$amount,
						'addby'=>$created_by,
						'supporting_doc'=>$supportingDoc
						);
					
		if($emdID)
		{
			$data['updatedate']=$indate;
			$this->db->where('id',$emdID);
			$this->db->update('tbl_auction_participate_emd',$data); 
			$insertedid_id = 1;				
		}
		else
		{
			$data['indate']=$indate;	
			$this->db->insert('tbl_auction_participate_emd',$data);
			$insertedid_id = $this->db->insert_id();				
		}	
		return $insertedid_id;			
	}	
	
	public function GetAutionEmgRecords($eid,$bidderID) 
	{
        $this->db->where('bidderID', $bidderID);
        $this->db->where('auctionID', $eid);
		$query = $this->db->get("tbl_auction_participate_emd");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetAutionTenderRecords($eid,$bidderID) 
	{
        $this->db->where('bidderID', $bidderID);
        $this->db->where('auctionID', $eid);
		$query = $this->db->get("tbl_auction_participate_tenderfee");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	function saveAuctionTender($auctionId,$tenderIdd)
	{
		$tenderID				=	$this->input->post('tenderID');
		///$bank_name				=	$this->input->post('bank_name');
	//	$instrument_type		=	$this->input->post('instrument_type');
		//$instrument_no			=	$this->input->post('instrument_no');
		//$instrument_date		=	$this->input->post('instrument_date');
		//$instrument_expiry_date	=	$this->input->post('instrument_expiry_date');
		$auction_id				=	$this->input->post('auction_id');
		$bidderid				=	$this->session->userdata['id'];
		$created_by				=	$this->session->userdata['id'];
		$indate					=	date("Y-m-d H:i:s");
		$amount					=	SUBMISSION_AMOUNT;
		
		
		$data 	= array(						
						'auctionID'=>$auctionId,
						'bidderID'=>$bidderid,
						'amount'=>$amount,
						'addby'=>$created_by,
						'payment_status'=>'pending'
						);
			
		if($tenderIdd)
		{
			$data['updatedate']=$indate;
			$this->db->where('id',$tenderIdd);
			$this->db->update('tbl_auction_participate_tenderfee',$data); 
			$insertedid_id = $tenderIdd;				
		}
		else
		{
			$data['indate']=$indate;	
			$this->db->insert('tbl_auction_participate_tenderfee',$data);
			$insertedid_id = $this->db->insert_id();				
		}	
		return $insertedid_id;			
	}	

	function saveFrqParticipate()
	{
		$auction_participateID		=	$this->input->post('auction_participateID');
		$auction_participateFRQID	=	$this->input->post('auction_participateFRQID');
		$quote_price				=	$this->input->post('quote_price');
		$documents_paid				=	$this->input->post('documents_paid');
		$emd_paid					=	$this->input->post('emd_paid');
		$tender_paid				=	$this->input->post('tender_paid');
		$auction_id					=	$this->input->post('auction_id');
		$bidderid					=	$this->input->post('bidderid');
		$alaise_name				=	$this->input->post('alaise_name');
		$fSave						=	$this->input->post('fSave');
		$created_by					=	$this->session->userdata['id'];
		$indate						=	date("Y-m-d H:i:s");
		$Save						=	$this->input->post('Save');
		if($Save=='Submit')
		{
			$final_submit=0;
            $this->session->set_flashdata('saved','0');
		}
		else
		{
			$final_submit=1;		
		}
		
		// Insert FRQ DATA
		if($quote_price!='not_application')
		{
			$datafrq = array('auctionID'=>$auction_id,
							'bidderID'=>$bidderid,
							'frq'=>$quote_price,
							'addby'=>$created_by,
							'indate'=>$indate);
			if($auction_participateFRQID)
			{
				$this->db->where('id',$auction_participateFRQID);	
				$this->db->update('tbl_auction_participate_frq',$datafrq);
			}
			else
			{
				$this->db->insert('tbl_auction_participate_frq',$datafrq);
				$frqInsertedID = $this->db->insert_id();
			}
			$frq=1;
		}
		else
		{
			$frq=0;	
		}				
			
		if($alaise_name)
		{
			$alaise_name=$alaise_name;	
		}
		else
		{
			$alaise_name=$this->alias_name(8);	
		}
		
		$data 	= array('tender_fee'=>$tender_paid,
						'emd'=>$emd_paid,
						'frq'=>$frq,
						'documents'=>$documents_paid,
						'auctionID'=>$auction_id,
						'alaise_name'=>$alaise_name,
						'status'=>1,
						'added_type'=>'bidder',
						'auct_signature'=>'added by helpdesk',
						'bidderID'=>$bidderid,
						'addby'=>$created_by);
						
			if($Save != 'Submit')
			{
				$data['final_submit'] = 1;
			}
			$data['modify_date']=$indate;
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$this->db->update('tbl_auction_participate',$data);	
			$insertedid_id	=1;		
			$data['final_submit_date'] = $indate;
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$this->db->update('tbl_log_auction_participate',$data);	
				
		return $insertedid_id;		
	}

	public function GetbidderLatestFRQ($eid,$bidderID) 
	{
        $this->db->where('bidderID', $bidderID);
        $this->db->where('auctionID', $eid);
        $this->db->order_by('indate','asc');
		$query = $this->db->get("tbl_auction_participate_frq");
		
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
	function alias_name($chars = 8) 
	{
		$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		return strtoupper(substr(str_shuffle($letters), 0, $chars));
	}

	public function getBiidersList($auction_id) 
	{
		 $query=$this->db->query("SELECT CONCAT(b.first_name, ' ' ,b.last_name) as bidder_name, b.id, b.email_id FROM tbl_user_registration as b WHERE  b.user_type IN ('builder','owner','broker') AND b.id NOT IN (SELECT bidderID FROM tbl_auction_participate WHERE auctionID='".$auction_id."')");
		 
		if($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
        else
        {
			$data=0;
		}
        return $data;
    }


	function participateAuctionBidderByExecutive()
	{
		$bidder_userid		=	$this->input->post('bidder_userid');
		$auction_id			=	$this->input->post('auctionID');
		$created_by			=	$this->session->userdata['id'];
                
        if(count($bidder_userid)>0)
		{	 
			$indate	= date("Y-m-d H:i:s");
			
			foreach($bidder_userid as $bidderid)
			{
				$this->db->where("bidderID",$bidderid);
				$this->db->where("auctionID",$auction_id);
				$this->db->where("final_submit",'1');
				$query=$this->db->get('tbl_auction_participate');
				$rows=$query->num_rows();
				if($rows==0)
				{
                    $alaise_name	=	$this->alias_name(8);	
					$data 	= 	array(                 
									'tender_fee'=>1,
									'emd'=>1,
									'frq'=>0,
									'documents'=>1,
									'final_submit'=>1,
									'auctionID'=>$auction_id,
									'alaise_name'=>$alaise_name,
									'status'=>1,
									'is_accept_auct_training'=>0, //new field added
									'operner1_accepted'=>'1',
									'opener1_accepted_date'=>$indate,
									'operner2_accepted'=>'1',
									'opener2_accepted_date'=>$indate,
									'bidderID'=>$bidderid,
									'added_type'=>'helpdesk_ex',
									'indate'=>$indate,
									'addby'=>$created_by
									);
                                                                    
					$this->db->where("bidderID",$bidderid);
					$this->db->where("auctionID",$auction_id);
					$query=$this->db->get('tbl_auction_participate');
					$rows = $query->num_rows();

					if($rows == 0)
					{
						$this->db->insert('tbl_auction_participate',$data);
					}
					else
					{
						$this->db->where("bidderID",$bidderid);
						$this->db->where("auctionID",$auction_id);
						$this->db->update('tbl_auction_participate',$data);
					}
								 
                    $success.=GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').',';
					$returndata=1;	
                }
                else
                {
					$error.=GetTitleByField('tbl_user_registration','id='.$bidderid,'email_id').',';     
				} 
			}
            $returndata=array('success'=>$success,'error'=>$error);      
        }
        else
        {
            $returndata=0;   
        }
		return $returndata;	
	}

	public function getbankUserList($id,$sid) 
	{
		if($id!='' && $sid!='')
		{
			$query=$this->db->query("SELECT id ,email_id,CONCAT(first_name, ' ', last_name) as bidder_name , mobile_no FROM tbl_user WHERE id IN(".$id.",".$sid.") ORDER BY id=".$id." DESC");
			if ($query->num_rows() > 0) 
			{
				foreach ($query->result() as $row) 
				{
					$data[] = $row;
				}
			}
			else{$data=0;}
		}
		else
		{
			$data=0;   
		}
		return $data;
	} 
            
	function getAllCloseAuctionBidder($auctionID)
	{
		$query=$this->db->query("SELECT * from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
		if($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
                $data[] = $row->bidderID;
            }
		}
		else
		{
			$data = 0;	
		}
		return $data;
	}
	
	public function getAllBiidersList($auction_id) 
	{
		 $query=$this->db->query("SELECT CONCAT(b.first_name, ' ' ,b.last_name) as bidder_name, b.id, b.email_id FROM tbl_user_registration as b WHERE b.user_type IN ('builder','owner','broker') and b.status='1'");
		 
		if ($query->num_rows() > 0) 
		{
				foreach ($query->result() as $row) {
                $data[] = $row;
				}
        }else{
			$data=0;
		}
        return $data;
    }	
	
	
	public function GetLiveAutionbyId($eid) 
	{
        $this->db->where('id', $eid);
		$this->db->where('NOW() BETWEEN auction_start_date AND auction_end_date');
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
    }	
	
	function viewReport($auction_id)
	{
		$this->db->select("id, event_title, event_type,auction_start_date,auction_end_date, related_doc, first_opener, second_opener");
		$this->db->where('reference_no is not null');
		$this->db->where('productID !=', 0);
		$this->db->where('status !=', 5);
		//$this->db->where('status ', 1);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		
		$data = array();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();
			//Bidder Participated
				
			$this->db->where('auctionID', $data[0]->id);
			$query_bidder = $this->db->get("tbl_auction_participate");
			$data_bidder=array();
			$data_FRQbidder=array();
				
			/**  Code UNComment As Data are not Coming Properly 22-04-2016 */
			
			foreach ($query_bidder->result() as $row_bidder)
			{
				$data_bidder[]=$row_bidder;
				$this->db->where('auctionID', $data[0]->id);
				$this->db->where('bidderID', $row_bidder->bidderID);
				$query_bidder_frq = $this->db->get("tbl_auction_participate_frq");
				
				foreach ($query_bidder_frq->result() as $row_bidder_frq){
				$row_bidder->row_bidder_frq=$row_bidder_frq;
				$data_FRQbidder[]=$row_bidder;
				//End FRQ Details 
				}

			}
			$data[0]->bidder=$data_bidder;
			//FRQ Details
			$data[0]->bidderFRQ=$data_FRQbidder;
				
			/** END **/

			//Auction Last Bid Details 
			
			$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,u.user_type,u.user_type,u.company_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY b.bid_value DESC")->result_object();
			$data[0]->lastbidBidder=$lastbidBidder;
			$this->db->where('auctionID', $data[0]->id);
			$this->db->order_by('bid_value', 'DESC');							
			$query_bidder_bid = $this->db->get("tbl_live_auction_bid");
			$data_bidder_bid=array();
			foreach ($query_bidder_bid->result() as $row_bidder_bid)
			{
			$data_bidder_bid[]=$row_bidder_bid;
			}
			$data[0]->bidder_bid=$data_bidder_bid;
				
			return $data;
		
		return false;
		}
	}

	public function getAuctionParticipatedBidder($aid) 
	{
        $query=$this->db->query("SELECT p.bidderID, CONCAT(b.first_name,' ',b.last_name) as bidder_name,b.user_type,b.register_as,b.organisation_name,b.email_id, b.mobile_no, IF(p.final_submit = 1,'Yes','No') as finalsubmit FROM tbl_user_registration as b INNER JOIN tbl_auction_participate as p ON p.bidderID=b.id WHERE p.auctionID=$aid and p.final_submit = 1");
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
    }
		
	public function salesExecutiveList() 
	{
        $this->db->where('user_type', 'sales');
        $this->db->where('status', 1);
		$query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
    }
    
    public function getUserBYId($userid) 
    {
        $this->db->where('id', $userid);        
		$query = $this->db->get("tbl_user");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
    }
	
	function executiveSearchData()
	{
		$bank=$this->input->post('bank');
		$sales_executive=$this->input->post('sales_executive');
		$zone=$this->input->post('zone');
		$status=$this->input->post('status');
		$invoice_raised=$this->input->post('invoice_raised');
		$payment_received=$this->input->post('payment_received');
		$eventId=$this->input->post('eventId');
		$submit=$this->input->post('submit');	
		
		$this->db->select("ac.id as auctionID, ac.eventID, ac.status, ac.reference_no, br.name as branch_name, ac.indate, CONCAT(s.first_name,' ',s.last_name) as salseExecutive, i.invoiceNo, i.realizationAmount",false);
		$this->db->from("tbl_auction as ac");
		$this->db->join("tbl_branch as br",'br.id=ac.branch_id','left');
		$this->db->join("tbl_event_log_sales as e ",'e.id=ac.eventID','left');
		$this->db->join("tbl_user_registration as s ",'s.id=e.sales_executive_id','left');
		if($invoice_raised=='yes')
		{
			$this->db->join("tbl_event_invoice as i ",'i.auctionID=ac.id','left');
		}
		else if($invoice_raised=='no')
		{
			$this->db->join("tbl_event_invoice as i ",'i.auctionID=ac.id','left');
			$this->db->where('i.invoiceNo is null');	
		}
		else
		{
			$this->db->join("tbl_event_invoice as i ",'i.auctionID=ac.id','left');	
		}
		
		if($payment_received=='yes')
		{
			$this->db->where('i.realizationAmount > 0');
		}else if($payment_received=='no')
		{
			$this->db->where('i.realizationAmount <= 0');
		}
		if($bank!='' && $bank > 0){
			$this->db->where('ac.bank_id',$bank);	
		}
		if($eventId!='' && $eventId > 0){
			$this->db->where('ac.id',$eventId);	
		}
		if($status!='' && $status > 0){
			$this->db->where('ac.status',$status);	
		}
		if($sales_executive!='' && $sales_executive>0){
			$this->db->where('s.id',$sales_executive);	
		}
		if($zone!=''){
			$this->db->where('s.c1zone',$zone);	
		}
		$this->db->where('ac.status !=',0);	
		$this->db->where('ac.status !=',5);	
		$this->db->order_by('ac.id','DESC');	
		
		$query = $this->db->get();
		$this->db->last_query();
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }else{
			$data=0;
			return $data;
		}
	}
	
	public function addBidderLimitedAuction($auction_id = 0,$bidder_id = 0)
	{
		
		$user_id = $this->session->userdata('id');
		$data = array(
				'auction_id'=>$auction_id ,
				'bidder_id'=>$bidder_id ,
				'status'=>1 ,
				'user_id'=>$user_id 
				);
		$this->db->where('auction_id', $auction_id);
		$this->db->where('bidder_id', $bidder_id);
		$query = $this->db->get('tbl_auction_bidder_limited_access'); 
		if($query->num_rows() > 0)			
		{
			
			$this->db->where('auction_id', $auction_id);
			$this->db->where('bidder_id', $bidder_id);
			$this->db->update('tbl_auction_bidder_limited_access', $data); 
			$insertedID=$id;
		}
		else
		{
			
			$data['in_date']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_auction_bidder_limited_access',$data); 
			$insertedID=$this->db->insert_id();
		}
	}
	
	public function removeBidderLimitedAuction($auction_id = 0,$bidder_id = 0)
	{
		$user_id = $this->session->userdata('id');
		$data = array(
				'auction_id'=>$auction_id,
				'bidder_id'=>$bidder_id,
				'status'=>0,
				'user_id'=>$user_id
				);
		$this->db->where('auction_id', $auction_id);
		$this->db->where('bidder_id', $bidder_id);
		$query = $this->db->get('tbl_auction_bidder_limited_access'); 
		if($query->num_rows() > 0)			
		{
			
			$this->db->where('auction_id', $auction_id);
			$this->db->where('bidder_id', $bidder_id);
			$this->db->update('tbl_auction_bidder_limited_access', $data); 
			$insertedID=$id;
		}
		else
		{
			
			$data['in_date']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_auction_bidder_limited_access',$data); 
			$insertedID=$this->db->insert_id();
		}
	}
}

?>
