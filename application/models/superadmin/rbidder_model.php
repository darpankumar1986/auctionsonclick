<?php
class Rbidder_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function getAuctionList() 
	{
		     $this->datatables->select("a.id,b.name,a.eventID,a.auction_start_date,a.auction_end_date, CASE  
                                            WHEN a.status ='2' THEN 'Initialize'
                                            WHEN a.status ='1' THEN 'Published'
                                             WHEN a.status ='3' THEN 'Stay'
                                            WHEN a.status ='0' THEN 'Saved'
                                            END as status1",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/rbidder/rbidderlist/$1'>Participated Bidder List</a>", 'a.id')
			->from('tbl_auction as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			->where('(a.status = "1")');

			return $this->datatables->generate();
    }
    
    function getBidderList($auctionId) 
	{
		     $this->datatables->select("a.id,b.email_id,a.auctionID,a.bidderID,a.added_type, CASE  
                                            WHEN a.final_submit ='0' THEN 'Partial'
                                            WHEN a.final_submit ='1' THEN 'Full Partipated'
                                            END as final_submit",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/rbidder/rbidderAuction/$1'>Remove from auction</a>", 'a.id')
			->from('tbl_auction_participate as a')
			->join('tbl_user_registration as b','b.id=a.bidderID','left')
			->where('a.auctionID',$auctionId)
			->where('(a.final_submit = "1")');

			return $this->datatables->generate();
    }
	
	public function rbidderAuctionR($pId,$auctionid,$bidderID) 
	{
		$data1['final_submit']='0';
		$data1['operner1_accepted']='0';
		$data1['operner1_comment']='';
		$data1['operner2_accepted']='0';
		$data1['operner2_comment']='';
		$this->db->where('bidderID', $bidderID);
		$this->db->where('auctionID', $auctionid);
		$this->db->where('id', $pId);
		$save = $this->db->update('tbl_auction_participate', $data1); 
		if($save)
		{
			
			$data = array('auction_participate_id'=>$pId ,
							'bidderID'=>$bidderID,
							'auctionID'=>$auctionid,	
							'final_submit'=>0,	
							'final_submit_date'=>date('Y-m-d H:i:s'),
							'added_type'=>'admin',
							'indate'=>date('Y-m-d H:i:s'),
							'operner1_accepted'=>0,	
							'operner2_accepted'=>0,	
							'modify_date'=>date('Y-m-d H:i:s'),
							'modify_ip'=>$_SERVER['REMOTE_ADDR'],	
							);
					$save = $this->db->insert('tbl_log_auction_participate',$data); 
				
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	
	function getLoggedList() 
	{
		     $this->datatables->select("a.id,b.name,bh.name as name1,rg.email_id,a.indate",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/rlogged/rloggedid/$1'>Remove Logged ID</a>", 'a.id')
			->from('tbl_event_log_sales as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			->join('tbl_branch as bh','bh.id=a.branch_id','left')
			->join('tbl_user_registration as rg','rg.id=a.created_by','left')
			->where('(a.status != "5" AND a.id >34000)');

			return $this->datatables->generate();
    }
    
    public function rloggedid($loggedId) 
	{
	
		$data1['status']='5';
		$this->db->where('id', $loggedId);
		$save = $this->db->update('tbl_event_log_sales', $data1); 
		if($save)
		{	
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function rgetLoggedList() 
	{
		     $this->datatables->select("a.id,b.name,bh.name as name1,rg.email_id,a.indate",false)
			//->add_column('Actions',"<a class='b_action' href='/superadmin/rlogged/rloggedid/$1'>Remove Logged ID</a>", 'a.id')
			->from('tbl_event_log_sales as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			->join('tbl_branch as bh','bh.id=a.branch_id','left')
			->join('tbl_user_registration as rg','rg.id=a.created_by','left')
			->where('(a.status = "5")');

			return $this->datatables->generate();
    }
	
	
}
