<?php
class Banker_model extends CI_Model {
	
	private $apath = 'public/uploads/property_images/';
	private $event_auction = 'public/uploads/event_auction/';
	private $document_auction = 'public/uploads/document/';
	private $path = 'public/uploads/bank/';
	
        function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
                
	function saveEventsdatatable()
	{	 //get bank id of logged user
		$userid= $this->session->userdata('id');
		$depart_id = $this->session->userdata('depart_id');
		$bank_id= $this->session->userdata('bank_id');
		
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		//$approvalStatus = array(0,2,3);
		
		// $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
		$this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, cat.name, ea.reserve_price, ea.dsc_enabled, ea.approvalStatus, ea.approverComments",false)
		// ->unset_column('ea.id')		   
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_category as cat','cat.id=ea.category_id','left')
		//->where('ea.approvalStatus IN (0,2,3)')
		->where('ea.approvalStatus !=',4)
		->where('ea.department_id',$depart_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.status',0);
		
		return $this->datatables->generate();
    }
    
    function rejectedEventsdatatable()
	{	 //get bank id of logged user
		$userid= $this->session->userdata('id');
		$depart_id = $this->session->userdata('depart_id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		//$approvalStatus = array(0,2,3);
		
		// $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
		$this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, cat.name, ea.reserve_price, ea.dsc_enabled, ea.approvalStatus, ea.approverComments",false)
		// ->unset_column('ea.id')		   
		//->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->join('tbl_category as cat','cat.id=ea.category_id','left')
		->where('ea.approvalStatus',4)
		->where('ea.department_id',$depart_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.status',0);
		
		return $this->datatables->generate();
    }
    
    function approvelRejectionEventsdatatable()
	{	 //get bank id of logged user
		 $userid= $this->session->userdata('id');
		 $depart_id = $this->session->userdata('depart_id');
		 $bank_id= $this->session->userdata('bank_id');
		 $branch_id= $this->session->userdata('branch_id');
		 $user_type_ses= $this->session->userdata('user_type');

        // $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
        $this->datatables->select("ea.id,ea.reference_no,dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.auction_start_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,ea.dsc_enabled, ea.approvalStatus",false)
        // ->unset_column('ea.id')		   
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where('ea.approvalStatus IN (1,2,3)')
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		->where('ea.department_id',$depart_id)
		->where('ea.status',0);		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
    
	//liveUpcomingAuctionsdatatable
	function liveUpcomingAuctionsdatatable()
    {
		$depart_id = $this->session->userdata('depart_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
		
		//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, SUBSTRING(tp.product_description,1,100), ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id)  as total_bidder",false)
	        //$this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, SUBSTRING(tp.product_description,1,100), ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id)  as total_bidder",false)
	        $this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription,ea.registration_start_date, DATE_FORMAT(ea.auction_start_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' and ( tbl_auction_participate.operner2_accepted = '1' OR (tbl_auction_participate.operner2_accepted IS NULL and tbl_auction_participate.operner1_accepted = '1') ))   as total_bidder,ea.dsc_enabled, ea.stageID",false)

 /*$this->datatables->select(" ea.* ",false)*/
	        //->unset_column('ea.id')	   
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/buyer/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a> <a href='/buyer/auction_alert_msg/$1' class=''><img src='/bankeauc/images/alert.png' title='Add Alert' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		 ->join('tbl_user as tu','ea.created_by=tu.id','left ')
		 ->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		 ->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		 ->join('tbl_drt td','ea.drt_id=td.id','left ')
		 ->join('tbl_product tp','ea.productID=tp.id','left ')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                 ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		//->where('((NOW() >= ea.auction_start_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.auction_start_date)) OR (ea.open_price_bid = 1))')  // Changed as discussed with saurabh
		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))') MAIN

		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.opening_price IS NOT NULL AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))')	
		//->where('((NOW() >= ea.bid_opening_date AND ea.auction_end_date <=NOW()  AND ea.open_price_bid = 1) )') //before
        // neeraj ->where('((NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.open_price_bid = 1) )')   // //COMMENT WRONG QUERY
        // ->where('(NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.opening_price IS NOT NULL )')   // //CAN BE DONE
		->where('ea.status',1)
		->where('ea.department_id',$depart_id);
		if($this->session->userdata('role_id')==1)
		{
			$this->db->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		}
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
	return $this->datatables->generate();
	//echo $this->db->last_query();die;
    }
	
    function liveEventsdatatable()
    {
		$depart_id = $this->session->userdata('depart_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.bid_last_date,ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		$this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.bid_last_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder,ea.dsc_enabled, ea.stageID",false)
		
        //->unset_column('ea.id')		   
		->add_column('Action',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/buyer/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left ')
		#->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		//->where('(NOW()>= ea.auction_start_date AND NOW()<= ea.auction_end_date)')
		//->where('bid_last_date')
		->where('ea.bid_last_date >= NOW()')
		->where('ea.status',1)		
		->where('ea.department_id',$depart_id);
		if($this->session->userdata('role_id')==1)
		{
			$this->db->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		}
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		
		return $this->datatables->generate();
    }
	
    function bids_to_be_openeddatatable()
    {
			$userid= $this->session->userdata('id');
			$depart_id = $this->session->userdata('depart_id');
			$bank_id= $this->session->userdata('bank_id');
			$branch_id= $this->session->userdata('branch_id');
			
			$user_type_ses= $this->session->userdata('user_type');


			//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.bid_opening_date,ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		        $this->datatables->select("ea.id,ea.reference_no, dp.department_name as type, ea.PropertyDescription, DATE_FORMAT(ea.bid_opening_date,'%d-%m-%Y %H:%i:%s'),ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' ) as total_bidder,ea.dsc_enabled",false)
			
                     //    ->unset_column('ea.id')	   
			->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>  <a href='/buyer/createCorrigendum/$1' class=''><img src='/bankeauc/images/edit.png' title='Corrigendum' class='edit1'></a>", 'ea.id')
			->from('tbl_auction as ea')
			->join('tbl_user as tu','ea.created_by=tu.id','left ')
			->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
			->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
			->join('tbl_drt td','ea.drt_id=td.id','left ')
			->join('tbl_product tp','ea.productID=tp.id','left ')
			//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                        ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
			->where('ea.auction_start_date > NOW()')
			->where('NOW()>ea.bid_last_date')
			->where('ea.status',1)
			->where('ea.department_id',$depart_id)
			//->or_where('ea.stageID is NULL')
			//->where('ea.open_price_bid is NULL')
            ->where('ea.open_price_bid',0);                        
            //->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");                
			
			return $this->datatables->generate();
    }
	
	function completedAuctionsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
		$depart_id = $this->session->userdata('depart_id');
      //  $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	    $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	         //->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where('ea.auction_end_date < NOW()')
		->where('ea.status','6')
		->where('ea.department_id',$depart_id);
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		$this->db->group_by('ea.id');
        $this->db->order_by("ea.id","desc");
        return $this->datatables->generate();
    }
    
    function awarded_list()
    {	
        $userid= $this->session->userdata('id');
        $bank_id= $this->session->userdata('bank_id');
        $branch_id= $this->session->userdata('branch_id');
        $user_type_ses= $this->session->userdata('user_type');
        $depart_id = $this->session->userdata('depart_id');
    //  $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
        $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
         //->unset_column('ea.id')	 
        ->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
        ->join('tbl_user as tu','ea.created_by=tu.id','left')
        ->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
        ->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
        ->join('tbl_drt td','ea.drt_id=td.id','left')
        ->join('tbl_product tp','ea.productID=tp.id','left')
        ->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
        //->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
        ->join('`tbl_auction_participate as ap','ap.auctionID=ea.id','left')
        ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
        ->where('ea.auction_end_date < NOW()')
        ->where('ap.awardedStatus', 1)
        ->where('ea.status','8')
        ->where('ea.department_id',$depart_id);
        //->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");

     
        $this->db->group_by('ea.id');
        $this->db->order_by("ea.id","desc");
        return $this->datatables->generate();
    }
    
    function not_awarded_list()
    {	
        $userid= $this->session->userdata('id');
        $bank_id= $this->session->userdata('bank_id');
        $branch_id= $this->session->userdata('branch_id');
        $user_type_ses= $this->session->userdata('user_type');
        $depart_id = $this->session->userdata('depart_id');
    //  $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
        $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
         //->unset_column('ea.id')	 
        //->add_column('Actions',"<a onclick='copyAuction($1);' href='javascript:void(0);' class='cpyActn1'><img style='width:26%;' src='/images/copy.png' title='Copy Auction'></a>", 'ea.id')
        ->add_column('Actions',"<a href='/buyer/copy_auction/$1' class='' id='cpyActn'><img style='width:50%;' src='/images/copy.png' title='Copy Auction'></a>", 'ea.id')
        ->from('tbl_auction as ea')
        ->join('tbl_user as tu','ea.created_by=tu.id','left')
        ->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
        ->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
        ->join('tbl_drt td','ea.drt_id=td.id','left')
        ->join('tbl_product tp','ea.productID=tp.id','left')
        ->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
        //->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
        ->join('`tbl_auction_participate as ap','ap.auctionID=ea.id','left')
        ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
        ->where('ea.auction_end_date < NOW()')
        ->where('ap.awardedStatus', 2)
        ->where('ea.status','8')
        ->where('ea.department_id',$depart_id);
        //->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");

     
        $this->db->group_by('ea.id');
        $this->db->order_by("ea.id","desc");
        return $this->datatables->generate();
    }
		
    function concludeCompletedAuctionsdatatable()
    {	
		//get bank id of logged user
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
       // $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
	$this->datatables->select(" ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
	
                //->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/viewReport/$1' class=''>View Report</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
                ->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where('ea.status ',7)
		
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)")
		$this->db->group_by('ea.id');
        return $this->datatables->generate();
    }
	
	function bankerEventMISReport()
	{
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		//$this->datatables->select("ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, en.invoiceNo, en.amount, en.invoiceDate,  en.realizationDate, en.realizationAmount ",false)				
		$this->datatables->select("ea.id, ea.reference_no,  UCASE(ea.event_type) as type, en.invoiceNo, FORMAT((en.amount+(((en.amount * tm.stax)/100)+((en.amount * tm.educess)/100)+((en.amount * tm.secondaryhighertax)/100)+((en.amount * tm.swacchbharat_tax)/100))),2) as amount, en.invoiceDate,  en.realizationDate, en.amount_recived ",false)				
		->from('tbl_auction as ea')
		->join('tbl_event_invoice en','en.auctionID=ea.id','left')
		//->join('tbl_taxmaster as tm','tm.start_date <= ea.auction_end_date and tm.end_date >= ea.auction_end_date','left') 
		->join('tbl_taxmaster as tm','tm.start_date <= en.invoiceDate and tm.end_date >= en.invoiceDate','left')
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id)
		->where("(ea.status = '6' OR ea.status = '7' OR ea.status = '3' OR ea.status = '4')")
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		$this->db->order_by("ea.id","desc");
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();      
        

	}
	
	function bankerDrtEventMISReport(){
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		$user_type_ses= $this->session->userdata('user_type');
       // $this->datatables->select("ea.id, ea.reference_no,td.name, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, en.invoiceNo, en.amount, en.invoiceDate,  en.realizationDate, en.realizationAmount",false)				
	  $this->datatables->select("ea.id, ea.reference_no,td.name,UCASE(ea.event_type) as type, en.invoiceNo, FORMAT((en.amount+(((en.amount * tm.stax)/100)+((en.amount * tm.educess)/100)+((en.amount * tm.secondaryhighertax)/100)+((en.amount * tm.swacchbharat_tax)/100))),2) as amount, en.invoiceDate,  en.realizationDate, en.amount_recived",false)				
	
        ->from('tbl_auction as ea')
		->join('tbl_event_log_sales tels','tels.id=ea.eventID','left ')
		->join('tbl_drt td','tels.drt_id=td.id','left ')
		//->join('tbl_taxmaster as tm','tm.start_date <= ea.auction_end_date and tm.end_date >= ea.auction_end_date','left')		
		->join('tbl_event_invoice as en','en.auctionID=ea.id','left')
		->join('tbl_taxmaster as tm','tm.start_date <= en.invoiceDate and tm.end_date >= en.invoiceDate','left')
		->where('ea.event_type','drt')
		
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
	}
	
	function completedEventsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
                //  $this->datatables->select("ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.auction_start_date, ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
                $this->datatables->select("ea.reference_no,UCASE(ea.event_type) as type, ea.PropertyDescription, ea.auction_start_date, ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
     
                // ->unset_column('tbr.id')	   
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class=''><img src='/bankeauc/images/track.png' title='Track Auction' class='edit1'></a>", 'ea.eventID')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->where('ea.status',0)
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
	
	function canceleddatatable()
    {	
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
       // $this->datatables->select("ea.id,tb.name, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, ea.PropertyDescription, ea.reserve_price",false)
       $this->datatables->select("ea.id, ea.reference_no, dp.department_name as type, ea.PropertyDescription, ea.reserve_price",false)
      
                //->unset_column('ea.id')		
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/buyer/eventDetailPopup/$1' class=''><img src='/bankeauc/images/view.png' title='View' class='edit1'></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID = tp.id','left')
		//->join('tblmst_account_type as act','act.account_id=ea.account_type_id','left')
		->join('tblmst_department as dp','dp.department_id=ea.department_id','left')
		->where("ea.status",4)
		//->where("(ea.status ='3' OR ea.status ='4')")
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
		
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
    }
	
	function corrigendumdatatable()
    {	
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
		$this->db->query("SET @row = 0",false); //@row := @row + 1 as SNo,
       // $this->datatables->select("@row := @row + 1 as SNo,ta.id,ta.reference_no , tac.product_description, DATE_FORMAT(tac.bid_last_date,'%d %M %Y %H:%i:%s'),DATE_FORMAT(tac.bid_opening_date,'%d %M %Y %H:%i:%s'), DATE_FORMAT(tac.auction_start_date,'%d %M %Y %H:%i:%s'),DATE_FORMAT(tac.auction_end_date,'%d %M %Y %H:%i:%s') ,DATE_FORMAT(tac.indate,'%d %M %Y %H:%i:%s')",false)
         $this->datatables->select("tac.id as SNo,tac.id,ta.reference_no , tac.product_description, tac.bid_last_date,tac.bid_opening_date,tac.auction_start_date,tac.auction_end_date ,tac.indate",false)
      
        ->unset_column('tac.id')	   
		->add_column('Actions',"<a href='/buyer/viewCorrigendum/$1' class='corrigendum_detail_iframe'><img src='/bankeauc/images/view.png' title='View' class='edit1'></a>", 'tac.id')
        ->from('tbl_auction_corrigendum as tac')
		->join('tbl_auction as ta','tac.auctionID=ta.id','left ')
		->join('tbl_product as tp','ta.id=tp.auctionID','left ')
		
		->where("(ta.first_opener=$userid OR ta.second_opener=$userid)");
		
		
		if($user_type_ses !='drt')
		{
			//$this->db->where('ta.bank_id',$bank_id);
			//$this->db->where('ta.branch_id',$branch_id);
		}
		
		//->where('ta.bank_id',$bank_id)  // CODE COMMENT FOR DRT
		//->where('ta.branch_id',$branch_id)		 // CODE COMMENT FOR DRT
		
		//->where("(ta.first_opener=$userid OR ta.second_opener=$userid)")  // CODE COMMENT FOR DRT
		
		$this->db->group_by('tac.id'); 
		return $this->datatables->generate();
    }
	
		function eventTrackData($auction_id)
    {	
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			$data[0]->account_name = GetTitleByField('tblmst_account_type',"account_id='".$data[0]->account_type_id."'",'account_name');	
			/***** count no. of bidder*****/
			//echo "second Opener--".$data[0]->second_opener;
			$this->db->select('count(id) as bider_total');
			/*if($data[0]->second_opener>0){
				$this->db->where('operner2_accepted',1);	
			}else{
				$this->db->where('operner1_accepted',1);	
			}*/
			$this->db->where('auctionID', $data[0]->id);
                        //$this->db->where('added_type','bidder');
                        
                        $this->db->where('final_submit',1);//added by amit
			$query = $this->db->get("tbl_auction_participate");
			$bider_total=$query->result();
			$data[0]->bider_total=$bider_total[0]->bider_total;
                        ///////////////////////
                        
                        
            $this->db->select('count(id) as bider_total_new');
		    $this->db->where('auctionID', $data[0]->id);
            $this->db->where('final_submit',1);//added by amit
            $query2 = $this->db->get("tbl_auction_participate");
			$bider_total1=$query2->result();
            ///////////////////
                        
            $data[0]->bider_total_new=$bider_total1[0]->bider_total_new;
			
			
			// Auction participated Bidder
			$this->db->select('count(id) as auction_bider_total');
			if($data[0]->second_opener>0){
                             //   $this->db->where('added_type','bidder');  //added by amit
                             
				$this->db->where('operner2_accepted',1);	
			}else{  
                             //   $this->db->where('added_type','bidder');  //added by amit
				$this->db->where('operner1_accepted',1);	
			}			 			
			$this->db->where('auctionID', $data[0]->id);
			$this->db->where('final_submit',1);//added by amit
			//$this->db->or_where("(added_type = 'helpdesk_ex' AND auctionID = '".$data[0]->id."')");
			//$this->db->where('auct_signature','added by helpdesk');
			$aquery = $this->db->get("tbl_auction_participate");
			
			$auctionbider_total=$aquery->result();
			$data[0]->auction_bider_total=$auctionbider_total[0]->auction_bider_total;
			
			/***** count no. of bidder*****/
			
			/***** bidder detail*****/
			//$this->db->select('count(id) as bider_total');
			$this->db->where('final_submit', 1);
              //$this->db->where('added_type','bidder');   //added by amit
              
            $this->db->where('participate_by is not null');  // For Add Bidder by document
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_auction_participate");
               //   echo $this->db->last_query();    
				if($query->num_rows()>0)
				{
					//echo '<pre>';
					//print_r($query->result());
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
						$row1->frq_detail=$frq_result;
						
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
						$data[0]->bider_detail=$data1;
					}
				}
			//$data[0]->bider_total=$bider_total[0]->bider_total;
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
	
	function eventTrackData_old($auction_id)
    {	
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			
			/***** count no. of bidder*****/
			$this->db->select('count(id) as bider_total');
			if($data[0]->second_opener){
				$this->db->where('operner2_accepted',1);	
			}else{
				$this->db->where('operner1_accepted',1);	
			}
			$this->db->where('auctionID', $data[0]->id);
			$query = $this->db->get("tbl_auction_participate");
			$bider_total=$query->result();
			$data[0]->bider_total=$bider_total[0]->bider_total;
			/***** count no. of bidder*****/
			
			/***** bidder detail*****/
			//$this->db->select('count(id) as bider_total');
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
						$row1->frq_detail=$frq_result;
						
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
						$data[0]->bider_detail=$data1;
					}
				}
			//$data[0]->bider_total=$bider_total[0]->bider_total;
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
	
	function concludeEvent($auctionID)
	{
		if($this->input->post('auctionID')){
			$auctionID = $this->input->post('auctionID');
		}
               //conclude logic(Needs to be clear)
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('status'=>7));
		$this->db->where('auction_id', $auctionID);
		$update=$this->db->update('tbl_log_auction', array('status'=>7)); //LOG
                //ech
            if($update){
                $this->db->where('auction_id', $auctionID);
                $query=$this->db->get('tbl_log_auction');
                $data['emd']=$query->result();
               
             if(!empty($data['emd'])){
                 $type='conclude_events';
                 $message='Buyer has Concluded Event';
                 $this->trackemdDetailPopupData($data,$type,$message); 
                 }
             }	
                
                
		return true;
	}
	
	function auctionDetailPopupData($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		return $query_auction->result();
	}
	
        function bankDetailPopupData($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_bank");
		return $query_auction->result();
	}
	
	function emdDetailPopupData($bidderID, $auctionID){
               //emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_emd");
               return $query_emd->result();
	        }
	function jdaPaymentLogPopupData($bidderID,$auctionID){
               
		$this->db->where('auction_id', $auctionID);
		$this->db->where('bidder_id', $bidderID);
		$this->db->order_by('payment_log_id','DESC');
		$this->db->limit(1);
		$pQry = $this->db->get("tbl_jda_payment_log");
        return $pQry->result();
	}
	function feeDetailPopupData($bidderID,$auctionID){
               //emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_tenderfee");
               return $query_emd->result();
	        }
	function utrDetailPopupData($bidderID, $auctionID){
               //emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_utr = $this->db->get("tbl_auction_bidder_utr_no");
               return $query_utr->result();
	        }
function trackemdDetailPopupData($data,$type,$message){

     $this->db->select('eventID,bank_id');
     if($data['emd'][0]->auction_id!=null){
       $auctionid=$data['emd'][0]->auction_id;
     }else{
        $auctionid=$data['emd'][0]->auctionID;
     }
     if(!empty($data['emd'][0])){
     $this->db->where('id', $auctionid);
     $query_emd=$this->db->get('tbl_auction');
     $eventres=$query_emd->result();

     $trackdata=array(
                    'event_id'=>$eventres[0]->eventID,
                    'auction_id'=>$auctionid,
                    'action_type'=>$type,
                    'bank_id'=>$eventres[0]->bank_id,
                    'bidder_id'=>$data['emd'][0]->bidderID,
                    'bank_user_id'=>  $this->session->userdata['id'],
                    'indate'=>date('Y-m-d H:i:s'),
                    'status'=>'1',
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                    'message'=>$message
                    );
   $this->db->insert('tbl_log_bid_track',$trackdata);
     }

}
	function bidderDetailPopup($bidderID,$auctionID=null)
	{
		$data = array();
		//echo $bidderID;
		//bidder fee
		$this->db->where('id', $bidderID);
		$query_bidder = $this->db->get("tbl_user_registration");
		$bidder_result=$query_bidder->result();
           
		$row1->bidder_detail=$bidder_result;
		$data['bidder_detail'] = $bidder_result;
		
		//emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_emd");
		$emd_result=$query_emd->result();
		$row1->emd_detail=$emd_result;
		$data['emd_detail'] = $emd_result;

		//frq
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_frq = $this->db->get("tbl_auction_participate_frq");
		$frq_result=$query_frq->result();
		$row1->frq_detail=$frq_result;
		$data['frq_detail'] = $frq_result;
		
		//tender fee
		$this->db->where('auctionID', $auctionID);
		$query_tenderfee = 
		$this->db->get("tbl_auction_participate_tenderfee");
		$tenderfee_result=$query_tenderfee->result();
		$row1->fee_detail=$tenderfee_result;
		$data['fee_detail'] = $tenderfee_result;
		
		//doc
		$this->db->where('auctionID', $auctionID);
		$query_tenderfee = 
		$this->db->get("tbl_auction_participate_tenderfee");
		$this->db->where('auctionID', $auctionID);
		$query_doc = $this->db->get("tbl_auction_participate_doc");
		$data_doc=array();
		foreach ($query_doc->result() as $row_doc)
		{
			$data_doc[]=$row_doc;
		}
		$row1->doc_detail=$data_doc;
		$data[]=$row1;
		//$data['doc_detail'] = $data_doc;
		return $data;
	}
	
	function tenderfeeDetailPopupData($bidderID,$auctionID)
	{
		//tender fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_tenderfee = $this->db->get("tbl_auction_participate_tenderfee");
		return $query_tenderfee->result();
	}
		function tenderfeeDetailPopupData2($bidderID,$auctionID)
	{
		//tender fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_tenderfee = $this->db->get("tbl_auction_participate_tenderfee")->row_object();
		return $query_tenderfee;
	}
	
	function docDetailPopupData($bidderID,$auctionID)
	{
		//doc fee
		$data_doc=array();
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_doc = $this->db->get("tbl_auction_participate_doc");
		foreach ($query_doc->result() as $row_doc)
		{
		$data_doc[]=$row_doc;
		}
		return $data_doc;
	}
	
	function emdDocDetailPopupData($bidderID,$auctionID)
	{
		//doc fee
		$data_doc=array();
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$this->db->where('status', 1);
		$query_doc = $this->db->get("tbl_auction_emd_doc");
		foreach ($query_doc->result() as $row_doc)
		{
		$data_doc[]=$row_doc;
		}
		return $data_doc;
	}
	
	function viewCorrigendumPopupData($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction_corrigendum");
		return $query_auction->result();
	}
	
	function previewAuctionDetailPopupData($auctionID)
	{
		$this->db->select('ta.*,tp.product_description');
		$this->db->from("tbl_auction as ta");
		$this->db->join("tbl_product as tp",'ta.id=tp.auctionID','left ');
		
		$query_auction = $this->db->get();
		return $query_auction->result();
	}
		
	function updateStageStatus($stageID,$id)
	{
	
		$data = array(
					'stageID'=>$stageID
					);							
					
			$this->db->where('id', $id);
			$this->db->update('tbl_auction', $data); 
			
			$this->db->where('auction_id', $id);
			$this->db->update('tbl_log_auction', $data); 
	}
	
	
	function savePaymentVerification()
	{
		$auctionID = $this->input->post('auctionID');
		$bidderID = $this->input->post('bidderID');
		$participate_id = $this->input->post('participate_id');
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		
		$second_opener = $this->input->post('second_opener');
		
		if($second_opener){
			$stageID = 4;
		}else{
			$stageID = 5;
		}		
		
		$i=0;
		//echo '<pre>';print_r($_POST);die;
		foreach($participate_id as $pi)
		{	
			$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
			$data = array(
						'payment_verifier_accepted'=>$acceptance,
						'payment_verifier_comment'=>$txtComment[$i],
						'payment_verifier_accepted_date'=>date('Y-m-d H:i:s')						
						);
			$this->db->where('id', $pi);
			$bidaccepted=$this->db->update('tbl_auction_participate', $data); 
			if($bidaccepted){
			//opener1_accepted_ip
                        $data1 = array(
                            'payment_verifier_accepted'=>$acceptance,
                            'payment_verifier_comment'=>$txtComment[$i],
                            'payment_verifier_accepted_date'=>date('Y-m-d H:i:s'),
                            'payment_verifier_accepted_ip'=>$_SERVER['REMOTE_ADDR']
			     );
			$this->db->where('auction_participate_id', $pi);
			$this->db->update('tbl_log_auction_participate', $data1); 
                        }
		        if(!$second_opener){
			 $this->send_bid_acceptted_rejected_mail($bidderID[$i],$bid_acceptance[$i]);
			}
			$i++;
		}
		$this->session->set_userdata('open_popup', true);
		return true;
	}
	
	function saveFirstOpnerVerification()
	{
		$auctionID = $this->input->post('auctionID');
		$bidderID = $this->input->post('bidderID');
		$participate_id = $this->input->post('participate_id');
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		
		$payment_verifier = $this->input->post('payment_verifier');
		
		if($payment_verifier){
			$stageID = 4;
		}else{
			$stageID = 5;
		}		
		
		$i=0;
		//echo '<pre>';print_r($_POST);die;
		foreach($participate_id as $pi)
		{	
			$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
			$data = array(
						'operner1_accepted'=>$acceptance,
						'operner1_comment'=>$txtComment[$i],
						'opener1_accepted_date'=>date('Y-m-d H:i:s')						
						);
			$this->db->where('id', $pi);
			$bidaccepted=$this->db->update('tbl_auction_participate', $data); 
			if($bidaccepted){
			//opener1_accepted_ip
                        $data1 = array(
                            'operner1_accepted'=>$acceptance,
                            'operner1_comment'=>$txtComment[$i],
                            'opener1_accepted_date'=>date('Y-m-d H:i:s'),
                            'opener1_accepted_ip'=>$_SERVER['REMOTE_ADDR']
			     );
			$this->db->where('auction_participate_id', $pi);
			$this->db->update('tbl_log_auction_participate', $data1); 
            }
		      
			$i++;
		}
		$this->session->set_userdata('open_popup', true);
		return true;
	}
	
	function saveSecondOpnerVerification()
	{
		$auctionID = $this->input->post('auctionID');
		$bidderID = $this->input->post('bidderID');
		$participate_id = $this->input->post('participate_id');
		
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		
		$second_opener = $this->input->post('second_opener');
		
		if($second_opener){
			$stageID = 4;
		}else{
			$stageID = 5;
		}		
		
		$i=0;
		//echo '<pre>';print_r($_POST);die;
		foreach($participate_id as $pi)
		{	
			$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
			$data = array(
						'operner2_accepted'=>$acceptance,
						'operner2_comment'=>$txtComment[$i],			
						'opener2_accepted_date'=>date('Y-m-d H:i:s')
						);
			$this->db->where('id', $pi);
			$this->db->update('tbl_auction_participate', $data); 
			
			
			$this->db->where('auction_participate_id', $pi);
			$this->db->update('tbl_log_auction_participate', $data); 
			
			if(!$second_opener){
				$this->send_bid_acceptted_rejected_mail($bidderID[$i],$bid_acceptance[$i]);
			}
			
			//echo '<br />';
			//echo $this->db->last_query();
			$i++;
		}
		//die;
		//$this->db->where('id', $auctionID);
		//$this->db->update('tbl_auction', array('stageID'=>$stageID));
		//echo '<pre>';print_r($_POST);die;
		$this->session->set_userdata('open_popup', true);
		return true;
	}
	
	function send_bid_acceptted_rejected_mail($msg_to,$isAccepted){
		$msg_role = $this->session->userdata('role_id');
		$msg_from = $this->session->userdata('id');
		if($isAccepted){
			$msg_body = 'Your bid has been successfully accepted.';
		}else{
			$msg_body = 'Your bid has been rejected.';
		}
		$data = array('msg_role'=>$msg_role,
						'msg_from'=>$msg_from,
						'msg_to'=>$msg_to,
						'msg_body'=>$msg_body
						);
		$data['msg_created_datetime']=date('Y-m-d H:i:s');
		$data['msg_status']=2;
		$data['status']=1;
		$this->db->insert('tbl_message',$data);
		//echo $this->db->last_query();die;
	}
	
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->apath;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
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
		
	function createEventdatastep1()
	{		
		$bankuser 	= $this->input->post('bankuser');
		$auctionID 	= $this->input->post('auctionID');
		$created_by	=	 $this->session->userdata['id'];
		$indate=date('Y-m-d H:i:s');
		$data = array(
					'first_opener'=>$bankuser,
					'auction_type'=>0,
					'status'=>0,
					'created_by'=>$created_by);
		if($auctionID>0){
			$data['updated_date']=$indate;
			$data['bank_id']=$this->session->userdata('bank_id');
			$data['branch_id']=$this->session->userdata('branch_id');
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',$data);	
			$id = $auctionID;
		}else{
			$data['indate']=$indate;
			$data['bank_id']=$this->session->userdata('bank_id');
			$data['branch_id']=$this->session->userdata('branch_id');
			$this->db->insert('tbl_auction',$data);	
			$id = $this->db->insert_id();
		}	
		return $id;
		
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
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->group_id][] = $row;
            }
            return $data;
        }
        return false;
    }
    
	function createEventdatastep2()
	{	
		$productID 		=	 $this->input->post('productID');
		$auctionID 		=	 $this->input->post('auctionID');
		//$video_url 	=	 $this->input->post('video_url');
		$type 			=	 $this->input->post('type');
		$category 		= 	 $this->input->post('category');
		$product_type_val=GetTitleByField('tbl_category', "id=".$category."", 'name');
		$records		=	$this->GetRecordByCategory($type,$is_auction='auction',$is_bank='bank',$is_sell='sell');
		
		$name 			=	 $this->input->post('name');
		$description 	=	 $this->input->post('description');
		$price 			=	 $this->input->post('price');
		//$is_auction 	=	 $this->input->post('is_auction');
		$Address1 		=	 $this->input->post('address');
		$Street 		=	 $this->input->post('street');
		$Country 		=	 $this->input->post('country');
		$State 			=	 $this->input->post('state');
		$City 			=	 $this->input->post('city');
		$Zip 			=	 $this->input->post('zip');
		$phone			=	 $this->input->post('phone');
		$fax 			=	 $this->input->post('fax');
		$product_subtype_val=GetTitleByField('tbl_category', "id=".$type."", 'name');
		$data 			= array(
							'name'=>$name,
							'product_description'=>$description,
							'price'=>$price,
							'auctionID'=>$auctionID,
							'is_auction'=>1,
							'product_type'=>$category,
							'product_subtype_id'=>$type,
							'product_type_val'=>$product_type_val,
							'product_subtype_val'=>$product_subtype_val,
							'address1'=>$Address1,
							'street'=>$Street,
							'country'=>$Country,
							'state'=>$State,
							'city'=>$City,
							'zip'=>$Zip,
							'phone'=>$phone,
							'fax'=>$fax,
							'status'=>3
							);
				
				if($productID)			
				{
					$updateddate=date('Y-m-d H:i:s');
					$data['updated_date']=$updateddate;
					$this->db->where('id', $productID);
					$this->db->update('tbl_product', $data); 
					$product_id =$productID;
					
					if($product_id>0){
					$aucArr=array('updated_date'=>$updateddate);
					$this->db->where('id', $auctionID);
					$this->db->update('tbl_auction', $aucArr); 
					}
					
					
				}else{
					$data['indate']=date('Y-m-d H:i:s');
					$this->db->insert('tbl_product', $data);	
					$product_id = $this->db->insert_id();	
					if($product_id>0){
					$aucArr=array('productID'=>$product_id);
					$this->db->where('id', $auctionID);
					$this->db->update('tbl_auction', $aucArr); 
					}
					
				}
				//echo "fffff---".$product_id;
				//echo $this->db->last_query();
		// End Insert basic info
		 $files = $_FILES;
         $count = count($_FILES['image']['name']);
		if($count >0){
            for($i=0; $i<$count; $i++)
            {
				if($files['image']['name'][$i])
				{
					$_FILES['file_upload']['name']= $files['image']['name'][$i];
					$_FILES['file_upload']['type']= $files['image']['type'][$i];
					$_FILES['file_upload']['tmp_name']= $files['image']['tmp_name'][$i];
					$_FILES['file_upload']['error']= $files['image']['error'][$i];
					$_FILES['file_upload']['size']= $files['image']['size'][$i];
					$image=$this->upload1('file_upload');
			    }
				else
				{
					$file_upload = $this->input->post('image_old');
					$image=$file_upload[$i];
				}
			   if($image){
			    $priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
				$data = array(
							'product_id'=>$product_id,
							'name'=>$image,
							'type'=>'images',
							'priority'=>$priority,
							'status'=>0
						);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_image_video',$data);
				}

            }
		}
		
	
			//video 
			if($_FILES['video']['name'])
			{
				$video=$this->uploadvideo('video');
			/*	
	echo "<pre>";
	print_r($_FILES);
	echo "</pre>";
	die;
		die;*/
			}
			else{
				$video = $this->input->post('video_url');
			}
				
			if($video)
			{
				$video_type = $this->input->post('video_type');
				$priority = SetPriority('tbl_product_image_video', "and product_id = $product_id");
				$data = array(
					'product_id'=>$product_id,
					'name'=>$video,
					'type'=>$video_type,
					'priority'=>$priority,
					'status'=>0
					);
				$data['indate']=date('Y-m-d H:i:s');			
				$this->db->insert('tbl_product_image_video',$data);
			}
			
			//End video
		
		
		///Delete previous Records from tbl_product_attribute_values on edit
			if($auctionID)			
			{
				$this->db->where('product_id', $product_id);
				$this->db->update('tbl_product_attribute_value', array('status'=>5,'updated_date'=>date('Y-m-d H:i:s'))); 
			}
					
		//End Delete previous Records from tbl_product_attribute_values on edit
		foreach($records as $group_records)		
		{
			foreach($group_records as $data)		
			{
				$values = $this->input->post('form_field_'.$data->id);
				if(is_array($values))
					$values=implode(',',$values);
					$data = array(
								'attribute_id'=>$data->id,
								'group_id'=>$group_records[0]->group_id,
								'user_id'=>$user_id,
								'product_id'=>$product_id,
								'attr_name'=>$data->name,
								'values'=>$values,
								'status'=>0
								
							);
					$data['indate']=date('Y-m-d H:i:s');			
					$this->db->insert('tbl_product_attribute_value',$data); 
					//$id = $this->db->insert_id();
			}
		}
		//echo "fffff".$product_id;
		return $product_id;
		die;
	}
	
	
	
	
function saveeventdata(){ 
  
		//ini_set("display_errors", "1");
		//error_reporting(E_ALL);
		/*echo '<pre>';
        print_r($_POST);
        print_r($_FILES);die;*/
		$bank_id					= 	 $this->input->post('bank_id');
		$branch_id					= 	 $this->session->userdata('branch_id');
		$created_by					=	 $this->session->userdata['id'];
		$auctionID 					=	 $this->input->post('auctionID');
		$account 					=	 $this->input->post('account');
		$reference_no               = 	 $this->input->post('reference_no');
		$dispatch_date 				=	 $this->input->post('dispatch_date');
		//$bank_name 				=	 $this->input->post('bank_name');		
		$propertyDescription        =	 $this->input->post('description');
		$area		 	  		    =	 $this->input->post('area');
		$area_unit_id	 			=	 $this->input->post('area_unit_id');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category_id');
		$is_corner_property			=	 $this->input->post('is_corner_property');
		$remark						=	 $this->input->post('remark');
        $scheme_id                  =	 $this->input->post('scheme_id');
		$scheme_name				=	 $this->input->post('scheme_name');
		//$cprms_scheme_name		=	 $this->input->post('cprms_scheme_name');
		$service_no					=	 $this->input->post('service_no');
		$zone_id					=	 $this->input->post('zone_id');
		$far						=	 $this->input->post('far');
		$property_height			=	 $this->input->post('property_height');
		$height_unit_id				=	 $this->input->post('height_unit_id');
		$max_coverage_area			=	 $this->input->post('max_coverage_area');
		$drt_id 					=	 $this->input->post('drt_id');
		$subcategory_id 			=	 $this->input->post('subcategory_id');
		$borrower_name 				=	 $this->input->post('borrower_name');
		$invoice_mail_to 			=	 $this->input->post('invoice_mail_to');
		$invoice_mailed 			=	 $this->input->post('invoice_mailed');
		$tender_fee 				=	 $this->input->post('tender_fee');
		$reserve_price 				=	 $this->input->post('reserve_price');
		$unit_id_of_price			=	 $this->input->post('unit_id_of_price');		
		$emd_amt 					=	 $this->input->post('emd_amt');		
		$nodal_bank_name 			=	 $this->input->post('nodal_bank_name');
		$nodal_bank 				=	 $this->input->post('nodal_bank');
		$nodal_bank_account			=	 $this->input->post('nodal_bank_account');
		$branch_ifsc_code 			=	 $this->input->post('branch_ifsc_code');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$registration_start_date	=	 $this->input->post('registration_start_date');
		$registration_end_date 		=	 $this->input->post('registration_end_date');
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
                
		$open_price_bid             = 	1;
		$opening_price 				=	 $this->input->post('reserve_price');
	  
		$second_opener_status = GetTitleByField('tbl_auction', "id='" . $this->input->post('auctionID') . "'", 'second_opener');
		if($auctionID == ''){
			$second_opener 			=   0;
		}else if($this->input->post('second_opener') != '' && $auctionID != ''){
			$second_opener 			=   $this->input->post('second_opener');
		}else if($this->input->post('second_opener') == '' && $auctionID != ''){
			$second_opener 			=   $second_opener_status;
		}
                
		$publish					=	 $this->input->post('Publish');
		$auto_bid_cut_off 			=	 $this->input->post('auto_bid_cut_off');
		$is_closed 					=	 $this->input->post('is_closed');
		$bidders_list 				=	 $this->input->post('bidders_list');
		$auction_type               =    '0'; // New Added For (Banker) Type
		$first_opener 				= 	 $this->input->post('first_opener');// New Added
		$drtEvent 					=	 $this->input->post('drtEvent');		
		$bank_branch_id 			=	 $this->input->post('bank_branch_name');
		
		$latitude					=	 $this->input->post('latitude');
		$longitude					=	 $this->input->post('longitude');
		$contact_person_details_1   =	 $this->input->post('contact_person_details_1');		
		$contact_person_details_2   =	 $this->input->post('contact_person_details_2');
		$save						=	 $this->input->post('Save');
		$send4Approval				=	 $this->input->post('send4Approval');
		$approve					=	 $this->input->post('approve');
		$reject						=	 $this->input->post('reject');
		$review						=	 $this->input->post('review');
		$create_copy				=	 $this->input->post('create_copy');
		
		$mode_of_bid				=	 $this->input->post('mode_of_bid');
		
		$approverComments			=	 $this->input->post('approverComments');
		
		$upload_document_field 		= 	 $this->GetUploadDocumentFieldRecords();
		
		$depart_id 					=	 $this->session->userdata('depart_id');
		      
		/*if($auto_extension_time!='' && $auto_extension=='')
		{
			$auto_extension=100;	
		}else if($auto_extension_time>0 && $auto_extension<=0)
		{
			$auto_extension=$auto_extension;	
		}else{
			$auto_extension=$auto_extension;	
		}*/
		if($auto_extension_time =='')
		{
			$auto_extension_time = 0;
		}
		if($auto_extension == '')
		{
			$auto_extension = 0;
		}
		if($height_unit_id == '' || $height_unit_id <=0)
		{
			$height_unit_id =0;
		}
		
		$press_release_date	= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		if($inspection_date_from)
		{
			$inspection_date_from = date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}
		if($inspection_date_to)
		{
			$inspection_date_to	= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));	
		}
		$dispatch_date			=	date("Y-m-d H:i:s",strtotime($dispatch_date));
		$bid_last_date			= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		//$bid_opening_date		= 	date("Y-m-d H:i:s",strtotime($bid_opening_date)); 
		$bid_opening_date		= 	date("Y-m-d H:i:s");
		$registration_start_date	= 	date("Y-m-d H:i:s",strtotime($registration_start_date));
		//$registration_end_date		= 	date("Y-m-d H:i:s",strtotime($registration_end_date));
		
		$auction_start_date			= 	date("Y-m-d H:i:s",strtotime($auction_start_date));
		$auction_end_date			= 	date("Y-m-d H:i:s",strtotime($auction_end_date));
                
        //new fields
		$country_id =	 $this->input->post('country_id');
		$state_id 	=	 $this->input->post('state_id');
		$city 		=	 $_POST['city_id'];
                
		if($city=='' || $city == 'others')
		{
			$other_city = $this->input->post('other_city');
		}
		else
		{
			$other_city = '';     
		}
                
        if($nodal_bank=='others')
        {
            $nodal_bank_name = $this->input->post('nodal_bank_n');
        }
        else
        {
            $nodal_bank_name = $this->input->post('nodal_bank_name');   
        } 
        	
        if($auctionID >0 && $auctionID != '')
        {
			$sfa = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'approvalStatus');
		}
		
		
		if($approve || $reject || $review)
		{		
			if($approve)
			{
				$approvalStatus=2;			
			}			
			if($review)
			{
				$approvalStatus = 3;
			}
			if($reject)
			{
				$approvalStatus = 4;
			}
			
		}
		else
		{
			
			if($send4Approval)
			{
				$approvalStatus=1;			
			}
			else
			{
				$approvalStatus = $sfa;
			}
			$approverComments = GetTitleByField('tbl_auction', "id='".$auctionID."'", 'approverComments');
		}
		
		
		if($publish)
		{
			$status=1; 
			$pstatus=1;
		}
		else
		{
			$status=0; 
			$pstatus=4;
			
			
		}	
        if($save)
        {
			$approvalStatus = 0;
		}
        		
        if($doc_to_be_submitted)
        {
			$doc_to_be_submitted=implode(",",$doc_to_be_submitted);
		}
		
		if($invoice_mailed)
		{
			$invoice_mailed=implode(",",$invoice_mailed);
		}
		
		if($inspection_date_from == "" || $inspection_date_from == '0000-00-00 00:00:00' || $inspection_date_from == '1970-01-01 05:30:00')
		{
			$inspection_date_from = '0000-00-00 00:00:00';
		}
		
		if($inspection_date_to == "" || $inspection_date_to == '0000-00-00 00:00:00' || $inspection_date_to == '1970-01-01 05:30:00')
		{
			$inspection_date_to = '0000-00-00 00:00:00';
		}
		if($dispatch_date == "" || $dispatch_date == '0000-00-00 00:00:00' || $dispatch_date == '1970-01-01 05:30:00')
        {
            $dispatch_date = '0000-00-00 00:00:00';
        }
		
		$data 	= array(
			//'productID'=>$productID,
			'event_type'=>'',
			'account_type_id'=>$account,
			'auto_bid_cut_off'=>$auto_bid_cut_off,
			'reference_no'=>$reference_no,
			'event_title'=>$event_title,
			'dispatch_date'=>$dispatch_date,
			'category_id'=>$category_id,
			'subcategory_id'=>$subcategory_id,
			'area_unit_id'=>$area_unit_id,
			'is_corner_property'=>$is_corner_property,
			'remark'=>$remark,
			'scheme_id'=>$scheme_id,
			'scheme_name'=>$scheme_name,
			'open_price_bid'=>$open_price_bid,
			'opening_price'=>$opening_price,
			//'cprms_scheme_name'=>$cprms_scheme_name,
			'service_no'=>$service_no,
			'zone_id'=>$zone_id,
			'department_id'=>$depart_id,
			'far'=>$far,
			'property_height'=>$property_height,
			'height_unit_id'=>$height_unit_id,
			'max_coverage_area'=>$max_coverage_area,
			'unit_id_of_price'=>$unit_id_of_price,
			'registration_start_date'=>$registration_start_date,
			'registration_end_date'=>date('Y-m-d H:i:s'),
			'mode_of_bid'=>$mode_of_bid,
			'branch_id'=>$branch_id,
			'drt_id'=>$drt_id,
			'bank_id'=>$bank_id,
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
			'auto_extension_time'=>$auto_extension_time,
			'no_of_auto_extn'=>$auto_extension,
			'doc_to_be_submitted'=>$doc_to_be_submitted,
			'second_opener'=>$second_opener,
			'created_by'=>$created_by,
			'first_opener'=>$created_by,
			'auction_type'=>$auction_type,
			'indate'=>date('Y-m-d H:i:s'),
			'is_closed'=>$is_closed,
			'countryID'=>  $country_id,
			'state'=> $state_id,
			'city'=> $city,
			'area'=>$area,
			'latitude'=>$latitude,
			'longitude'=>$longitude,
			'other_city'=>$other_city,
			'status'=>$status,
			'contact_person_details_1'=>$contact_person_details_1,			
			'contact_person_details_2'=>$contact_person_details_2,
			'approvalStatus'=>$approvalStatus,
			'approverComments'=>$approverComments,
			'PropertyDescription'=>$propertyDescription
			
		);
		
		/*
		echo"<pre>";
		print_r($data);die;
		*/
		
		/*$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
		$this->db->last_query();
		$insertedid_id 	=$auctionID;*/
						
		if($auctionID)
		{
			$datalog = $data;
			
			if($approve || $reject || $review)
			{
				unset($data['created_by']);
				unset($data['first_opener']);
			}
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',$data); 
			
			$copy_count = $this->input->post('copy_count');
			if($copy_count > 0 && $create_copy)
			{
				$this->db->trans_begin();
				
				$this->db->where('auction_id',$auctionID);
				$this->db->where('status',1);
				$aDocQry = $this->db->get('tbl_auction_document');
				if($aDocQry->num_rows()>0)
				{
					$aDocRow = $aDocQry->result();
					
				}
				//echo "<pre>";print_r($aDocRow);die;
				
				$copyData = $data;
				$copyData['approvalStatus'] = 0;
				$copyData['approverComments'] = '';
				$isCopy=0;
				for($i=1;$i<=$copy_count;$i++)
				{
					$this->db->insert('tbl_auction',$copyData);					
					$copyInsertId = $this->db->insert_id();		
									
					$copyDataLog = $copyData;
					$copyDataLog['ip'] = $_SERVER['REMOTE_ADDR'];
					$copyDataLog['auction_id'] = $copyInsertId;
					$this->db->insert('tbl_log_auction',$copyDataLog);	
					$copyDataFile = array();
					foreach($aDocRow as $aDRow)
					{
						if($aDRow->upload_document_field_id==0) // Upload Photographs Documents
						{
							$photoCaption = $aDRow->photo_caption;
						}
						else
						{
							$photoCaption = '';
						}
						
						
						$this->db->where('auction_id',$copyInsertId);
						$this->db->where('auction_document_id',$aDRow->auction_document_id);
						$dQry = $this->db->get('tbl_auction_document');
						
						
						$copyDataFile =array(
									'auction_id'=>$copyInsertId,
									'upload_document_field_id'=>$aDRow->upload_document_field_id,
									'upload_document_field_name'=>$aDRow->upload_document_field_name,
									'file_path'=>$aDRow->file_path,
									//'photo_caption'=>$photoCaption,
									'date_created'=>date('Y-m-d H:i:s'),
									'status'=>1
							);
							
						if($dQry->num_rows()>0)
						{
							$this->db->where('auction_id',$copyInsertId);
							$this->db->where('auction_document_id',$aDRow->auction_document_id);
							$this->db->update('tbl_auction_document',$copyDataFile);
						}
						else
						{
							$this->db->insert('tbl_auction_document',$copyDataFile);
						}	
						
					}
					
					//print_r($copyDataFile);die;
					
					
				}
				
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					log_message('error', 'Unable to create copies of auctions');
				}
				else
				{
					$this->db->trans_commit();
					if($copyInsertId)
					{
						$isCopy=1;
					}
						
				}	
				//echo "<pre>";print_r($copyDataFile);die;			
				
			}
			
			$insertedid_id 	=$auctionID;
			$datalog['auction_id'] = $insertedid_id;
			$datalog['ip'] = $_SERVER['REMOTE_ADDR'];		
			$this->db->insert('tbl_log_auction',$datalog);
		}else{
			$currentdate=date('Y-m-d H:i:s');
			$data['updated_date']=$currentdate;
			$this->db->insert('tbl_auction',$data); 
			
			$insertedid_id = $this->db->insert_id();			
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['auction_id'] = $insertedid_id;
			$this->db->insert('tbl_log_auction',$data);			
			
		}			
				
		/*
		if($_FILES['image'])
		{
			$this->db->where('auction_id',$insertedid_id);
			$this->db->where('status',1);
			$this->db->update('tbl_auction_image',array('status'=>0));
			$files=$this->upload_files($_FILES['image']);
			if(count($files)>0)
			{
				$date = date('Y-m-d H:i:s');
				foreach($files as $val)
				{
					$data1 = array(
					'auction_id'=>$insertedid_id,
					'image_full_path' => $this->event_auction.$val,
					'date_created' => $date,
					'status' =>1
					);
					
					$this->db->insert('tbl_auction_image',$data1);
				}
			}
		}
		*/
		
		if(is_array($_FILES) && count($_FILES)>0)
		{
			foreach($_FILES as $key => $fls)
			{						
				foreach($upload_document_field as $udf)
				{
					$fieldName = strtolower(str_replace(' ','_',$udf->upload_document_field_name));
					if($key == $fieldName)
					{
						if($_FILES[$fieldName]['name']!='')
						{							
							if($udf->upload_document_field_type ==1)
							{
								$uploadFile = $this->uploadauction($key);
							}
							else if($udf->upload_document_field_type ==2)
							{
								$uploadFile = $this->uploadeventvideo($key);
							}
							
							$this->db->where('auction_id',$insertedid_id);
							$this->db->where('upload_document_field_id',$udf->upload_document_field_id);
							$dQry = $this->db->get('tbl_auction_document');
							
							$dataFile =array(
									'auction_id'=>$insertedid_id,
									'upload_document_field_id'=>$udf->upload_document_field_id,
									'upload_document_field_name'=>$udf->upload_document_field_name,
									'file_path'=>$uploadFile,
									'date_created'=>date('Y-m-d H:i:s'),
									'status'=>1
							);
							
							if($dQry->num_rows()>0)
							{
								$this->db->where('auction_id',$insertedid_id);
								$this->db->where('upload_document_field_id',$udf->upload_document_field_id);
								$this->db->update('tbl_auction_document',$dataFile);
							}
							else
							{
								$this->db->insert('tbl_auction_document',$dataFile);
							}
						}
					}
					
				}						
				
			}
		}
		
		
                                                
		$productID 		     =	$this->input->post('productID');	
		$type 			     =	($this->input->post('subcategory_id'))?$this->input->post('subcategory_id'):0;
		$category 		     =  ($this->input->post('category_id'))?$this->input->post('category_id'):0;
		$product_type_val    =  GetTitleByField('tbl_category', "id=".$category."", 'name');
		$records		     =	$this->GetRecordByCategory($type,$is_auction='auction',$is_bank='bank',$is_sell='sell');
		$description 	     =	$this->input->post('description');		
        $product_subtype_val =  GetTitleByField('tbl_category', "id=".$type."", 'name');
        
		$data 	= array(
			'product_description'=>$description,			
			'auctionID'=>$insertedid_id,
			'is_auction'=>1,
			'product_type'=>$category,
			'product_subtype_id'=>$type,
			'product_type_val'=>$product_type_val,
			'product_subtype_val'=>$product_subtype_val,
			'status'=>3
			);
								
			if($productID)			
			{
				$updateddate=date('Y-m-d H:i:s');
				$data['updated_date']=$updateddate;
				$this->db->where('id', $productID);
				$this->db->update('tbl_product', $data); 
				$product_id =$productID;
				
				if($product_id>0){
					//$aucArr=array('updated_date'=>$updateddate);
					//$this->db->where('id', $insertedid_id);
					//$this->db->update('tbl_auction', $aucArr); 
				}
			}
			else
			{
				$data['indate']=date('Y-m-d H:i:s');
				$this->db->insert('tbl_product', $data);	
				$product_id = $this->db->insert_id();	
				if($product_id>0)
				{
					$aucArr=array('productID'=>$product_id);
					$this->db->where('id', $insertedid_id);
					$this->db->update('tbl_auction', $aucArr); 
				}
				
			}		
			
		
				
			//******************Start Add Close Auction Bidders***************
			if($insertedid_id)
			{
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
						
						// add new bidder 
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
				$this->db->where('id', $productID);
				$this->db->update('tbl_product', array('status'=>$pstatus,'updated_date'=>date('Y-m-d H:i:s')));
			}
					
		return $insertedid_id;
	}
	
function sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID)
{
		$username	=	GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'first_name');
		$email_msg ="Hi ".ucfirst($username)." ,<br> You have selected for Close Auction '".$reference_no."-".$event_title."'<a href='".$productUrl."'>Property.</a>";
		$fromemail = "info@c1indiabankeauction.com";
		$mailsubject = $reference_no." Close Auction By C1india";
        $to = $email_id;
		$headers  = "From: $fromemail\r\n";
		$headers .= "Content-type: text/html\r\n";
		//echo $mailsubject;
		
		mail($to, $mailsubject, $email_msg, $headers);
}
	
	
	
function saveCorrigendum(){
	    $created_by					=	 $this->session->userdata['id'];
		$auctionID 					=	 $this->input->post('auctionID');
		$remarks 					=	 $this->input->post('remarks');
		$product_description 		=	 $this->input->post('product_description');
		$press_release_date 		=	 $this->input->post('press_release_date');
		$inspection_date_from 		=	 $this->input->post('inspection_date_from');
		$inspection_date_to 		=	 $this->input->post('inspection_date_to');
		$bid_last_date 				=	 $this->input->post('bid_last_date');
		$bid_opening_date 			=	 $this->input->post('bid_opening_date');
		$auction_start_date 		=	 $this->input->post('auction_start_date');
		$auction_end_date 			=	 $this->input->post('auction_end_date');
		//$second_opener 				=	 $this->input->post('second_opener');
		//$status 					=	 $this->input->post('status');
		
		if($press_release_date)
		{
			$press_release_date			= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		}else{
			$press_release_date='';
		}
		if($inspection_date_from){
			$inspection_date_from		= 	date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}else{
			$inspection_date_from='';
		}
		if($inspection_date_to){
			$inspection_date_to			= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));
		}else{
			$inspection_date_to='';
		}
		if($bid_last_date){
			$bid_last_date		= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		}else{
			$bid_last_date='';
		}
		if($bid_opening_date){
			$bid_opening_date			= 	date("Y-m-d H:i:s",strtotime($bid_opening_date));	
		}else{
			$bid_opening_date			= 	'';	
		}
		if($auction_start_date){
			$auction_start_date			= 	date("Y-m-d H:i:s",strtotime($auction_start_date));	
		}else{
			$auction_start_date='';
		}
		if($auction_end_date){
			$auction_end_date			= 	date("Y-m-d H:i:s",strtotime($auction_end_date));	
		}else{
			$auction_end_date			= 	'';	
		}
		$productID						=	GetTitleByField('tbl_product', "auctionID='".$auctionID."'", 'id');
		/*if($_FILES['image']['name']!='')
		{    
		  $image=$this->uploadauction('image');
			
		}else{
			$image=$this->input->post('old_image');
		} 
		if($_FILES['related_doc']['name']!='')
		{
			$related_doc=$this->uploadauction('related_doc');
		}else{
			$related_doc=$this->input->post('old_related_doc');
		}
		
        if($_FILES['supporting_doc1']['name']!='')
		{
			$supporting_doc=$this->uploadauction('supporting_doc1');
		}else{
			$supporting_doc=$this->input->post('old_supporting_doc');
		}*/
		$activity='';
		//get current data 
		$this->db->where('id', $auctionID);
		$query_auction = $this->db->get("tbl_auction");
		$auction_data  = $query_auction->result();
		
		/* get property description */
		$this->db->where('id', $auction_data[0]->productID);
		$query_product = $this->db->get("tbl_product");
		$product_data  = $query_product->result();
		
		if(strtotime($auction_data[0]->press_release_date) < time())
		{
			$press_release_date = $auction_data[0]->press_release_date;
		}
		
		if(strtotime($auction_data[0]->bid_last_date) < time())
		{
			$bid_last_date = $auction_data[0]->bid_last_date;
		}
		
		if(strtotime($auction_data[0]->inspection_date_from) < time())
		{
			$inspection_date_from = $auction_data[0]->inspection_date_from;
		}
		
		if(strtotime($auction_data[0]->inspection_date_to) < time())
		{
			$inspection_date_to = $auction_data[0]->inspection_date_to;
		}
		
		if(strtotime($auction_data[0]->registration_start_date) < time())
		{			
			$bid_opening_date = $auction_data[0]->registration_start_date;
		}
		
		if(strtotime($auction_data[0]->auction_start_date) < time())
		{
			$auction_start_date = $auction_data[0]->auction_start_date;
		}
		
		if(strtotime($auction_data[0]->auction_end_date) < time())
		{
			$auction_end_date = $auction_data[0]->auction_end_date;
		}
		
		if($auction_data[0]->image == "")
		{
			$old_images = 0;
		}
		else
		{
			$old_images = $auction_data[0]->image;
		}
		
		if($auction_data[0]->status == 6 || $auction_data[0]->status == 7)
		{
				redirect("/registration/banker_login");
		}
	
		$data1 	= array( 'auctionID'=>$auctionID,
				  'remarks'=>$remarks,
				  'old_NIT_date'=>$auction_data[0]->press_release_date,
				  'NIT_date'=>$press_release_date,
				  'old_bid_last_date'=>$auction_data[0]->bid_last_date,
				  'bid_last_date'=>$bid_last_date,
				  'old_inspection_date_from'=>$auction_data[0]->inspection_date_from,
				  'inspection_date_from'=>$inspection_date_from,
				  'old_inspection_date_to'=>$auction_data[0]->inspection_date_to,
				  'inspection_date_to'=>$inspection_date_to,
				  'old_bid_opening_date'=>$auction_data[0]->registration_start_date,
				  'bid_opening_date'=>$bid_opening_date,
				  'old_auction_start_date'=>$auction_data[0]->auction_start_date,
				  'auction_start_date'=>$auction_start_date,
				  'old_auction_end_date'=>$auction_data[0]->auction_end_date,
				  'auction_end_date'=>$auction_end_date,
				  //'old_related_doc'=>$auction_data[0]->related_doc,
				  //'related_doc'=>$related_doc,
                  //'old_supporting_doc'=>$auction_data[0]->supporting_doc,
				  //'supporting_doc'=>$supporting_doc,
				  //'old_image'=>$old_images,
				  //'image'=>$image,
				  //'old_second_opener'=>$auction_data[0]->second_opener,
				  //'second_opener'=>$second_opener,
				  //'old_status'=>$auction_data[0]->status,
				  //'status'=>$status,
				  'old_product_description'=>$product_data[0]->product_description,
				  'product_description'=>$product_description,
				  'created_by'=>$created_by	
				);
						
						$data1['indate']=date('Y-m-d H:i:s');
                            //  echo '<pre>';
                             // print_r($data1); die();
                               $completed=$this->db->insert('tbl_auction_corrigendum',$data1); 
                            if($completed){
                            ///trace Activity
                               /*if($data1['old_related_doc']!=$data1['related_doc']){
                                  $activity.='Documents,'; 
                               }*/
                                /*if($data1['old_image']!=$data1['image']){
                                  $activity.='Image,'; 
                               }*/
                               /*if($data1['status']=='3'){
                                  $activity.='Stay,'; 
                               }*/
                                /*if($data1['status']=='4'){
                                  $activity.='Cancel,'; 
                               }*/
                                if($data1['bid_last_date']!=''){
                                  $activity.='Bid Submission Last date,'; 
                               }
                                if($data1['registration_start_date']!=''){
                                  $activity.='Bid Opening date,'; 
                               }
                                if($data1['auction_start_date']!=''){
                                  $activity.='Auction Start date,'; 
                               }
                               if($data1['auction_end_date']!=''){
                                  $activity.='Auction End date,'; 
                               }
                               if($data1['auction_end_date']!=''){
                                  $activity.='Auction End date,'; 
                               }
                             /* 
                              * if($data1['auction_end_date']!=''){
                                  $activity.='Submit Corrigendum'; 
                               }*/
                             if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
                               $remote_addr = "REMOTE_ADDR_UNKNOWN";
                             }
                       	  $data1['ip_address']=$remote_addr;
                          $data1['activity_done']=$activity;
                          $this->db->insert('tbl_log_auction_corrigendum',$data1);
                            }
			
			$data= array();
			if($press_release_date && strtotime($auction_data[0]->press_release_date) > time())
			$data['NIT_date']=$press_release_date;
			if($inspection_date_from && strtotime($auction_data[0]->inspection_date_from) > time())
			$data['inspection_date_from']=$inspection_date_from;
			if($inspection_date_to && strtotime($auction_data[0]->inspection_date_to) > time())
			$data['inspection_date_to']=$inspection_date_to;
			if($bid_last_date && strtotime($auction_data[0]->bid_last_date) > time())
			$data['bid_last_date']=$bid_last_date;
			if($bid_opening_date && strtotime($auction_data[0]->registration_start_date) > time())
			$data['registration_start_date']=$bid_opening_date;
			if($auction_start_date && strtotime($auction_data[0]->auction_start_date) > time())
			$data['auction_start_date']=$auction_start_date;
			if($auction_end_date && strtotime($auction_data[0]->auction_end_date) > time())
			$data['auction_end_date']=$auction_end_date;
			if($related_doc)
			$data['related_doc']=$related_doc;
			if($image)
			$data['image']=$image;
			if($supporting_doc)
			$data['supporting_doc']=$supporting_doc;
			if($second_opener)
			$data['second_opener']=$second_opener;
			if($status)
			$data['status']=$status;
			if($product_description)
			$data['PropertyDescription']=$product_description;
			
			//echo "<pre>";print_r($data);die;
			//echo 'd33f12332';die;
		    if(!empty($data))
		    {					
				$data['is_corrigendum']=1;
				$this->db->where('id', $auctionID);
				$this->db->update('tbl_auction',$data);
			}
			if($product_description){
				$this->db->where('auctionID', $auctionID);
				$this->db->update('tbl_product', array('product_description'=>$product_description));
			}
			return true;	
    }	
	
	function getBankersLiveAuctionList($aid){
		$currentdate=date("Y-m-d H:i:s");
		$userid=$this->session->userdata('id');
		$bankID= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		
		$user_type_ses= $this->session->userdata('user_type');
		if($user_type_ses == 'drt')
		{
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW() AND id='$aid' AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW() AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");     
			 }           
		}
		else
		{
			//AND bank_id='$bankID' AND branch_id='$branch_id'
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW()  AND id='$aid' AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW()  AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");     
			 }  
		}
              /*  $this->db->select("ea.*",false)
	     
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		//->join('tbl_drt td','ea.drt_id=td.id','left ')
		//->join('tbl_product tp','ea.productID=tp.id','left ')
		->where('((NOW() >= ea.bid_opening_date AND ea.auction_end_date <=NOW()  AND ea.move_to_auction = 1) )')   // //after
		->where('ea.status',1)
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");  
                $query=$this->db->get();    
                 */   
                    
		//$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW() AND bank_id='$bankID' AND branch_id='$branch_id' AND status='1' AND move_to_auction ='1' AND (first_opener=$userid OR second_opener=$userid) ");
		
		//echo "queryList->".$this->db->last_query();
		if($query->num_rows()>0)
		{
			$data=array();
			foreach ($query->result() as $row)
			{
				$data[]=$row;
			}
		return $data;		
		}else{
			$data=0;
		return $data;	
		}
		//return false;			
			
	}
	
	function getBankersLiveAuction10SecondList($aid){
		$currentdate=date("Y-m-d H:i:s");
		$userid=$this->session->userdata('id');
		$bankID= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$depart_id = $this->session->userdata('depart_id');
		
		$user_type_ses= $this->session->userdata('user_type');
		if($user_type_ses == 'drt')
		{
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1 AND id='$aid' AND status IN('1','6') "); //AND (first_opener=$userid OR second_opener=$userid)
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1 AND status IN('1','6')");
				//AND (first_opener=$userid OR second_opener=$userid)
			 }           
		}
		else
		{
			//AND bank_id='$bankID' AND branch_id='$branch_id'
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1  AND id='$aid' AND status IN('1','6') AND department_id=".$depart_id); //AND (first_opener=$userid OR second_opener=$userid)
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1  AND status IN('1','6') AND department_id=".$depart_id);
				//AND (first_opener=$userid OR second_opener=$userid)
			 }  
		}
//echo 		$this->db->last_query();die;
              /*  $this->db->select("ea.*",false)
	     
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		//->join('tbl_drt td','ea.drt_id=td.id','left ')
		//->join('tbl_product tp','ea.productID=tp.id','left ')
		->where('((NOW() >= ea.bid_opening_date AND ea.auction_end_date <=NOW()  AND ea.move_to_auction = 1) )')   // //after
		->where('ea.status',1)
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");  
                $query=$this->db->get();    
                 */   
                    
		//$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW() AND bank_id='$bankID' AND branch_id='$branch_id' AND status='1' AND move_to_auction ='1' AND (first_opener=$userid OR second_opener=$userid) ");
		
		//echo "queryList->".$this->db->last_query();

		if($query->num_rows()>0)
		{
			$data=array();
			foreach ($query->result() as $row)
			{
				$data[]=$row;
			}
		return $data;		
		}else{
			$data=0;
		return $data;	
		}
		//return false;			
			
	}

	function uploadvideo($fieldname)
	{
		$config['upload_path'] = $this->apath;
		$config['allowed_types'] = 'webm|mkv|flv|avi|3gp|mp4|wmv';
		$config['max_size'] = '10485760';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
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
	
	function uploadeventvideo($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'webm|mkv|flv|avi|3gp|mp4|wmv';
		$config['max_size'] = '10485760';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
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
	
	function uploadauction($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true; // Change for Filename change
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if(!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
        }
        else
        {
			//$new_name = time().$fieldname;
			//$config['file_name'] = $new_name;

			$upload_data = $this->upload->data();
			
			return $upload_data['file_name'];		
		}							
	}
	
	public function upload_files($files)
    {
        $config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|zip|pdf|doc|docx';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $fileName = time() .'_'.$key.'_'. $image;
			

            $config['file_name'] = $fileName;
			
            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $imgData = $this->upload->data();               
                $images[] = $imgData['file_name'];
                
            } else {
				echo $this->upload->display_errors();
				
                return false;
            }
        }

        return $images;
    }
	
	function uploadauction1($fieldname)
	{
		$config['upload_path'] = $this->event_auction;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '5220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
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
	function ajaxbidActivity(){ 
                $pdata=array();
		$activity_type	=	$this->input->post('activity_type');
		$auctionID		=	$this->input->post('auctionID');
		$currentTime	=	date("Y-m-d H;i:s");
		$data=array();
		if($activity_type=='resume'){
                         $pdata['message']='Auction Resumed successfully';
                         $pdata['status']=0;
			$data 		= array('auction_resume_time'=>$currentTime,'auction_bidding_activity_status'=>0);	
		}else if($activity_type=='pause'){
                         $pdata['message']='Auction Paused successfully';
                         $pdata['status']=1;
			 $data 		= array('auction_pause_time'=>$currentTime,'auction_bidding_activity_status'=>1);		
		}
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
                //$adata=$this->GetRecordByAuctionId($auctionID);
                $adata=$this->GetRecordByAuctionId($auctionID);
                $pdata['auctionID']=$adata->id;
                $pdata['eventID']=$adata->eventID;
                $pdata['userID']=$this->session->userdata['id'];
                $pdata['bank_id']=$adata->bank_id;
                $pdata['bid_type']=($adata->auto_bid_cut_off==0)?'Manual':'AutoBid';
                $pdata['ip']=$_SERVER['REMOTE_ADDR'];
                $pdata['indate']=$currentTime;
                $this->db->insert('tbl_log_auction_pause_resume',$pdata);
               if($activity_type=='resume'){
                $this->updatePousedRemainTime($auctionID);
                }	
	       }

	function updatePousedRemainTime($auctionID){
		$adata=$this->GetRecordByAuctionId($auctionID);
		$pousetime		= 	strtotime($adata->auction_pause_time);
		$resumetime		= 	strtotime($adata->auction_resume_time);
		$totalpousetime	=	$resumetime-$pousetime;				
		$original_date 	= 	$adata->auction_pause_time;
		$time_original 	= 	strtotime($adata->auction_end_date);
		$time_add      	= 	$time_original + (1 * $totalpousetime); 
		$new_date      	= 	date("Y-m-d : H:i:s", $time_add);
		$data 		=       array('auction_end_date'=>$new_date);	
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
    }	

	public function GetRecordByAuctionId($eid){
        $this->db->where('id', $eid);
		
        
        $query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    public function GetBanksData($eid){
        $this->db->where('id', $eid);
        $query = $this->db->get("tbl_bank");
     if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }

    
	
	function GetAuctionBidderHistoryData($auctionID){
		 $this->db->where('auctionID', $auctionID);
		 $query=$this->db->query("SELECT * FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' group by bid_value ORDER BY id DESC");
		//echo $this->db->last_query();		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }else{
			$data=0;
		}
		return $data;
	}
	
		function CountAuctionBidingData($auctionID){
		 //$this->db->where('auctionID', $auctionID);
		 $query=$this->db->query("SELECT id FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' group by bid_value ORDER BY id DESC");
		 $data= $query->num_rows();
		return $data;
	}
	
	function CountAuctionFinalSubmitData($auctionID){
		 //$this->db->where('auctionID', $auctionID);
		 $query=$this->db->query("SELECT id FROM tbl_auction_participate WHERE auctionID ='$auctionID' and final_submit = '1' ORDER BY id DESC");
		 $data= $query->num_rows();
		return $data;
	}
	
		function AuctionLastBidingData($auctionID){
		 //$this->db->where('auctionID', $auctionID);
		 $query=$this->db->query("SELECT bid_value FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC limit 1");
		 if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
        }else{
			 $data = 0;
		}
		return $data;
	}
	
	function AuctionLoggedBidderData($auctionID){
		 //$this->db->where('auctionID', $auctionID);
		 $query=$this->db->query("SELECT id FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' GROUP  BY bidderID");
		 $data=$query->num_rows();
		return $data;
	}
	
	function getLoggedInBidder($auctionid)
	{
		$date = date("Y-m-d H:i:s",strtotime( '-12 seconds' )); 
		$this->db->where('auctionid', $auctionid);    
		$this->db->where('time >=',  $date);                   
        
        $this->db->group_by('userid');
        $query = $this->db->get("tbl_auction_user_live_log");  
       // echo $this->db->last_query();die;      
        $login = 0;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
			
					$login++;
				
            }            
        }
        return $login;
	}
	
	
	
	
    function getLoggedInBidderType($auctionid,$bidderId)
	{
		$this->db->where('auctionid', $auctionid); 
         $this->db->where('bidderID', $bidderId);    
		$this->db->group_by('bidderID');
         $query = $this->db->get("tbl_live_auction_bid");  
        $login = 0;
        if ($query->num_rows() > 0) {
         $login=1;            
        }
        return $login;
	}
	function calculateGainvalue($auctionID){
		$lastAuction=$this->AuctionLastBidingData($auctionID);
		$percentag='';
		if($lastAuction!=0){
			$opening_price	=	GetTitleByField('tbl_auction', "id='".$auctionID."'", 'opening_price');
			if($opening_price)
			{
				$last_bid_value=$lastAuction->bid_value;
				$grothvalue=$last_bid_value-$opening_price;
				$percentag=($grothvalue*100)/$opening_price;
				$percentag=number_format($percentag,2);
				
				
			}
			
			
			
		}else{
		$percentag=number_format(0,2);	
		}
		return $percentag;
		
	}
        
        
        /**********************    Start  myMessage     ************************/
        
        public function GetCITotalRecord(){
            $user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
            $this->db->where('msg_role =', 1);
            $this->db->where('status !=', 5);
            $this->db->where('user_type', 'banker');
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
            //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function GetUserTotalRecord(){
            $user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
            $this->db->where('msg_role =', 2);
            $this->db->where('status !=', 5);
			$this->db->where('user_type', 'banker');
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
            //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function GetTrashTotalRecord(){
            
            $this->db->where('status =', 5);
			$user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
			$this->db->where('user_type', 'banker');
            $this->db->order_by('msg_created_datetime desc');
            $query = $this->db->get("tbl_message");
                //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }

	public function GetParentRecordsControl(){
            
            $this->db->where('status', 1);
			$user_id = $this->session->userdata('id');
			$this->db->where('msg_to', $user_id);
			$this->db->where('user_type', 'banker');
            $query = $this->db->get("tbl_message");
		
            if($query->num_rows() > 0){
                
                foreach ($query->result() as $row){				
                    $data[] = $row;
                }
                return $data;
            }
            
            return false;
        }
	
	public function GetRecordById($id){
            
            $this->db->where('id', $id);
            $query = $this->db->get("tbl_message");
            if ($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data = $row;
                }
                return $data;
            }
            return false;
        }

        public function myMessage_save_message_data(){
            
            $id = $this->input->post('id');

            if($id){

                $msg_role = $this->session->userdata('role_id');
                $msg_from = $this->input->post('msg_to');
                $msg_to = $this->input->post('msg_from');

            }else{

                $msg_role = $this->session->userdata('role_id');
                $msg_from = $this->session->userdata('id');
                $msg_to = $this->input->post('msg_to');
            }

            $msg_body = $this->input->post('msg_body');

            $data = array('msg_role'=>$msg_role,
                            'msg_from'=>$msg_from,
                            'msg_to'=>$msg_to,
                            'msg_body'=>$msg_body
                            );

            //echo '<pre>', print_r($data), '</pre>';

            $data['msg_created_datetime']=date('Y-m-d H:i:s');
            $data['msg_status']=2;
            $data['status']=1;
            $this->db->insert('tbl_message',$data); 
            $id = $this->db->insert_id();

            return true;
	}
	
	public function GetUserData(){
            //$this->db->limit(10,0);
            //$this->db->order_by('id DESC');
            $query = $this->db->get("tbl_user");
            //echo $this->db->last_query();

            $data = array();
            if ($query->num_rows() > 0){

                foreach ($query->result() as $row){
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
        
        public function myMessage_get_autocomplete(){
            
            //$id = $this->input->post('search');
            
            $name = $this->input->post('name');
            
            
            $this->db->select('id, first_name, last_name, email_id');
            $this->db->where_not_in('id', $this->session->userdata('adminid'));
            $this->db->where('status',1);
            $this->db->like('first_name',$name);
            //return $this->db->get('tbl_user', 10);
            
            $query = $this->db->get("tbl_user");
            
            //echo $this->db->last_query().'<br />';

            $data = array();
            if ($query->num_rows() > 0){

                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
        /**********************  End    myMessage     ************************/ 



	
	/**********************      Report     ************************/

	function viewReport($auction_id)
	{
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();
			//Bidder Participated
				
			$this->db->where('auctionID', $data[0]->id);
			$query_bidder = $this->db->get("tbl_auction_participate");
			$data_bidder=array();
			
			$data[0]->bidder=$data_bidder;
			
			//Auction Last Bid Details 
			
			$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,u.user_type,u.user_type,u.company_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
			$data[0]->lastbidBidder=$lastbidBidder;
			$this->db->where('auctionID', $data[0]->id);
			$this->db->order_by('bid_value', 'DESC');	
			$this->db->group_by('bid_value');						
			$query_bidder_bid = $this->db->get("tbl_live_auction_bid");
			$data_bidder_bid=array();
			foreach ($query_bidder_bid->result() as $row_bidder_bid)
			{
			$data_bidder_bid[]=$row_bidder_bid;
			}
			$data[0]->bidder_bid=$data_bidder_bid;
		
			//Auction All Bid Received 
			
			return $data;
				
				
		}
		else
		{
			$data =0;
			return $data;
		}
	}


	function rejectedBidsReport($auction_id)
	{
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,u.user_type,u.user_type,u.company_name,max(b.indate) as indate from tbl_live_auction_bid_invalid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
				$data[0]->lastbidBidder=$lastbidBidder;
				$this->db->where('auctionID', $auction_id);
				$this->db->order_by('bid_value', 'DESC');							
				$query_bidder_bid = $this->db->get("tbl_live_auction_bid_invalid");
				$data_bidder_bid=array();
				foreach ($query_bidder_bid->result() as $row_bidder_bid)
				{
				$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
		
			//Auction All Bid Received 
			
			return $data;
		}else{
			$data =0;
			return $data;
		}
	}
	
	function allBidsReport($auction_id)
	{
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				/*	id,auctionID,bidderID,bid_value,total_effective_cost,message,is_valid,rank,ip,alias_name,max_bid_value,exit_bid,auto_bid,bid_type,autobid_status,indate,modified_date,bidder_type,ItemID,BidSrNo 				
				*/
				$data_bidder_bid=array();
				$query_bidder_bid = $this->db->query("SELECT * FROM (SELECT * FROM tbl_live_auction_bid
				UNION 
				SELECT *,0 as ItemID, 'Rejected' as BidSrNo	FROM tbl_live_auction_bid_invalid) 
				AS bidHistory where auctionID =".$auction_id." group by bid_value ORDER BY modified_date")->result_object(); //
				//echo $this->db->last_query();die;
							
				foreach ($query_bidder_bid as $row_bidder_bid)
				{
					$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
		
			//Auction All Bid Received 
			
			return $data;
		}else{
			$data =0;
			return $data;
		}
	}

function checkBidderIsFRQParticipate($auctionid,$bidderID){
	$result=$this->db->query("select * from tbl_auction_participate_frq where auctionID='$auctionid' AND bidderID='$bidderID'")->num_rows();
	return $result;
}
function checkBidderBidIsParticipate($auctionid,$bidderID){
	$result=$this->db->query("select * from tbl_live_auction_bid where auctionID='$auctionid' AND bidderID='$bidderID'")->num_rows();
	return $result;
}


// 28-07-2017: Added by Azizur: For calculation of Auction demand notice.(For H1 Bidder)
function demandNoticeReport($auction_id)
    {
        $this->db->select('*');
       // $this->db->select('id, reference_no,dispatch_date, first_opener, created_by, reserve_price, emd_amt, area, area_unit_id, department_id, ');
        $this->db->where('status !=', 5);
        $this->db->where('id', $auction_id);
        $query = $this->db->get("tbl_auction");
        //echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) 
        {
                $data=$query->result();
                //Bidder Participated

                $this->db->where('auctionID', $data[0]->id);
                $query_bidder = $this->db->get("tbl_auction_participate");
                $data_bidder=array();

                $data[0]->bidder=$data_bidder;

                //Auction Last Bid Details 

                $lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,u.user_type,u.user_type,u.company_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
                $data[0]->lastbidBidder=$lastbidBidder;
                $this->db->where('auctionID', $data[0]->id);
                $this->db->order_by('bid_value', 'DESC');	
                $this->db->group_by('bid_value');						
                $query_bidder_bid = $this->db->get("tbl_live_auction_bid");
                $data_bidder_bid=array();
                foreach ($query_bidder_bid->result() as $row_bidder_bid)
                {
                $data_bidder_bid[]=$row_bidder_bid;
                }
                $data[0]->bidder_bid=$data_bidder_bid;

                //Auction All Bid Received 

                return $data;


        }
        else
        {
            $data = 0;
            return $data;
        }
    }
    
    // 13-09-2017: Added by Azizur       
    function initiate_refund_scroll_report($auction_id, $dispose_order_no)
    {	
        $this->db->select('*');
        $this->db->where('auction_id', $auction_id);
        $this->db->where('dispose_order_no', $dispose_order_no);
        $rQry = $this->db->get("tbl_emd_refund");
        $data = array();
        if ($rQry->num_rows() > 0) 
        {
            $data=$rQry->result();

            $this->db->select('SUM(emd_to_be_refunded) as total_amt');
            $this->db->where('auction_id', $auction_id);
            $this->db->where('dispose_order_no', $dispose_order_no);
            $result = $this->db->get("tbl_emd_refund")->row();
           
            $data[0]->total_amt = $result->total_amt;
            //echo '<pre>'; print_r($data);die;
            return $data;
	}   
    }
    
    
    function initiate_refund_cheque_report($auction_id, $dispose_order_no)
    {	
        $this->db->select('SUM(emd_to_be_refunded) as total_amt, cheque_date');
        $this->db->where('auction_id', $auction_id);
        $this->db->where('dispose_order_no', $dispose_order_no);
        $this->db->limit(1);
        $data = $this->db->get("tbl_emd_refund")->row();
        
        if($data->total_amt != '')
        {
            return $data;
        }
        
        return FALSE; 
    }
    
        
    function initiate_transfer_scroll_report($auction_id, $dispose_order_no)
    {	
        $this->db->select('*');
        $this->db->where('auction_id', $auction_id);
        $this->db->where('dispose_order_no', $dispose_order_no);
        $rQry = $this->db->get("tbl_initiate_transfer");
        $data = array();
        if ($rQry->num_rows() > 0) 
        {
            $data=$rQry->result();

            $this->db->select('SUM(amt_to_be_transferred) as total_amt');
            $this->db->where('auction_id', $auction_id);
            $this->db->where('dispose_order_no', $dispose_order_no);
            $result = $this->db->get("tbl_initiate_transfer")->row();
           
            $data[0]->total_amt = $result->total_amt;
            //echo '<pre>'; print_r($data);die;
            return $data;
		}
    }
    
    
    function initiate_transfer_cheque_report($auction_id, $dispose_order_no)
    {	    
        $this->db->select('SUM(amt_to_be_transferred) as total_amt, cheque_date');
        $this->db->where('auction_id', $auction_id);
        $this->db->where('dispose_order_no', $dispose_order_no);
        $this->db->limit(1);
        $data = $this->db->get("tbl_initiate_transfer")->row();
        
        if($data->total_amt != '')
        {
            return $data;
        }
        
        return FALSE; 
    }



	/**********************  End Report     ************************/
/**********************      Report  PDF   ************************/

	function viewReportPDF($auction_id)
	{	
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
				$data[0]->lastbidBidder=$lastbidBidder;
				//echo '<pre>';
				//print_r($data[0]);die;
				$this->db->where('auctionID',$data[0]->id);
				$this->db->order_by('bid_value', 'DESC');	
				$this->db->group_by('bid_value');							
				$query_bidder_bid = $this->db->get("tbl_live_auction_bid");
				$data_bidder_bid=array();
				foreach ($query_bidder_bid->result() as $row_bidder_bid)
				{
				$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
			//Auction All Bid Received 
			
			return $data;
		}
	}


	function rejectedBidsReportPDF($auction_id)
	{	
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,max(b.indate) as indate from tbl_live_auction_bid_invalid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
				$data[0]->lastbidBidder=$lastbidBidder;
				//echo '<pre>';
				//print_r($data[0]);die;
				$this->db->where('auctionID', $data[0]->id);
				$this->db->order_by('bid_value', 'DESC');							
				$query_bidder_bid = $this->db->get("tbl_live_auction_bid_invalid");
				$data_bidder_bid=array();
				foreach ($query_bidder_bid->result() as $row_bidder_bid)
				{
				$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
			//Auction All Bid Received 
			
			return $data;
		}
	}
	
	
	function allBidsReportPDF($auction_id)
	{	
		$this->db->select('*');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();
			//Bidder Participated
				
				$this->db->where('auctionID', $data[0]->id);
				$query_bidder = $this->db->get("tbl_auction_participate");
				$data_bidder=array();
				
				$data[0]->bidder=$data_bidder;
				
				//Auction Last Bid Details 

				/*	id,auctionID,bidderID,bid_value,total_effective_cost,message,is_valid,rank,ip,alias_name,max_bid_value,exit_bid,auto_bid,bid_type,autobid_status,indate,modified_date,bidder_type,ItemID,BidSrNo 				
				*/
				$data_bidder_bid=array();
				$query_bidder_bid = $this->db->query("SELECT * FROM (SELECT * FROM tbl_live_auction_bid
				UNION 
				SELECT *,0 as ItemID, 'Rejected' as BidSrNo FROM tbl_live_auction_bid_invalid) 
				AS bidHistory where auctionID =".$auction_id." group by bid_value ORDER BY indate ")->result_object();
				//echo $this->db->last_query();die;
							
				foreach ($query_bidder_bid as $row_bidder_bid)
				{
				$data_bidder_bid[]=$row_bidder_bid;
				}
				$data[0]->bidder_bid=$data_bidder_bid;
			//Auction All Bid Received 
			
			return $data;
		}
	}
	
    /**********************  End Report PDF     ************************/
	/**********************  Start myProfile     ************************/

        

    public function myProfileUserData(){
            
            //$this->db->limit(10,0);
            //$this->db->order_by('id DESC');
            
                $this->db->where('id', $this->session->userdata('id'));
		$query = $this->db->get("tbl_user");
                //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
             
    }
        
    public function myProfileEditSaveData(){
    	$id = $this->session->userdata('id');

		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$designation = $this->input->post('designation');
		$mobile_no = $this->input->post('mobile_no');

		$data = array('first_name'=>$first_name,
			'last_name'=>$last_name,
			'designation'=>$designation,
			'mobile_no'=>$mobile_no
			);

		//echo '<pre>', print_r($data), '</pre>';

		$data['date_modified']=date('Y-m-d H:i:s');

		$this->db->where('id', $id);
		$this->db->update('tbl_user', $data);

		return true;
	}
        
	/**********************  End myProfile     ************************/   
	function getAllCloseAuctionBidder($auctionID){
		//echo $auctionID;die;
		$query=$this->db->query("SELECT * from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			foreach ($query->result() as $row) {
						$data[] = $row->bidderID;
					}
		}else{
			$data = 0;	
		}
		return $data;
	}
		
	function getBidderRank($auctionID){
		$query=$this->db->query("SELECT bidderID, MAX(bid_value) FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' GROUP BY bidderID  ORDER BY MAX(bid_value) DESC");
		//echo "queryList->".$this->db->last_query();
		if($query->num_rows())
		{	$rankArr=array();
			$i=1;
			foreach ($query->result() as $row)
			{
				{
					$rankArr[$i]=$row->bidderID;		
				}
			$i++;	
			}
			return $rankArr;
		}
		return false;
	}
	
	function getBidderRankByTimestamp($auctionID,$timestamp){
		$query=$this->db->query("SELECT bidderID, bid_value, indate, MAX(bid_value) as 'maxValue' FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' AND indate <='$timestamp' GROUP BY bidderID  ORDER BY MAX(bid_value) DESC");
		//echo "queryList->".$this->db->last_query();
		if($query->num_rows())
		{	$rankArr=array();
			$i=1;
			foreach ($query->result() as $row)
			{
				if($i > 1)
				{
					$rankArr[$i] = $row;
					$rankArr[$i]->rank = $i;
				}
				$i++;	
			}
			if($timestamp == '2016-04-18 10:28:00')
			{
				//echo '<pre>';
				//print_r($rankArr);die;
			}
			return $rankArr;
		}
		return false;
	}

    function ajaxDashboardData()
	{
	
		$section=$this->input->post('section');
		$key=$this->input->post('key');
		$keytype=$this->input->post('keytype');
		if($keytype=='monthly')
		{
			$condition= " AND MONTH(auction_end_date) ='$key'";	
			$pcondition= " AND MONTH(indate) ='$key'";	
			$joinpcondition= " AND MONTH(i.indate) ='$key'";	
		}
		if($keytype=='quarterly')
		{
			$keyArr=explode('-',$key);
			$range1	=	$keyArr['0'];
			$range2	=	$keyArr['1'];
			$condition= "  AND ( MONTH(auction_end_date) BETWEEN '".$range1."' AND '".$range2."')";	
			$pcondition= "  AND ( MONTH(indate) BETWEEN '".$range1."' AND '".$range2."')";	
			$joinpcondition= "  AND ( MONTH(i.indate) BETWEEN '".$range1."' AND '".$range2."')";	
		}
		if($keytype=='annually')
		{
			$condition= " AND YEAR(auction_end_date) ='$key'";		
			$pcondition= " AND YEAR(indate) ='$key'";		
			$joinpcondition= " AND YEAR(i.indate) ='$key'";		
		}
		
		$data=array();
		$userid=$this->session->userdata['id'];
		$bank_id=$this->session->userdata['bank_id'];
		$branch_id=$this->session->userdata('branch_id');
		
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id ='$bank_id' AND branch_id='$branch_id' $condition");
		$row = $query->row();
		$activeAuction=$row->total_act_action;
		//echo $this->db->last_query();
		 
		$query3=$this->db->query("SELECT count(i.id) as total, 
		sum(i.amount) as invoicedAmt,
		sum(i.realizationAmount != '0') as collected,
		sum(i.realizationAmount) as collectedAmt
		FROM tbl_auction as a INNER JOIN tbl_event_invoice as i ON a.id=i.auctionID WHERE a.bank_id='$bank_id' AND branch_id='$branch_id' $joinpcondition");
		$row3 = $query3->result();
		$total_invoice = $row3[0]->total;
		$total_invoice_amount = $row3[0]->invoicedAmt;
		$total_invoice_collected_amount = $row3[0]->collectedAmt;
		//print_r($row3);
		
		$payment_due = $total_invoice_amount-$total_invoice_collected_amount;
		
		$data['total_invoice_reaised']	=	$total_invoice;
		$data['bankactiveAuction']			=	$activeAuction;
		$data['payment_due']			=	($payment_due)?number_format($payment_due,2):'0';
		$data['outstanding_amount']		=	($total_invoice_amount)?number_format($total_invoice_amount,2):'0';
		return $data;
	}
	
    function dashboardData()
	{
		$data=array();
		$branch_id=$this->session->userdata('branch_id');
		$userid=$this->session->userdata['id'];
		$bank_id=$this->session->userdata['bank_id'];
		// Find Total Active auction 
		
		$query=$this->db->query("SELECT COUNT(id)as total_act_action FROM tbl_auction WHERE bank_id ='$bank_id' AND (first_opener=$userid OR second_opener=$userid)");
		$row = $query->row();
		$activeAuction=$row->total_act_action;
		
		$query3=$this->db->query("SELECT count(i.id) as total, 
		sum(i.amount) as invoicedAmt,
		sum(i.realizationAmount != '0') as collected,
		sum(i.realizationAmount) as collectedAmt
		FROM tbl_auction as a INNER JOIN tbl_event_invoice as i ON a.id=i.auctionID WHERE a.bank_id='$bank_id' AND branch_id='$branch_id' AND (a.first_opener=$userid OR a.second_opener=$userid)");
		$row3 = $query3->result();
		$total_invoice = $row3[0]->total;
		$total_invoice_amount = $row3[0]->invoicedAmt;
		$total_invoice_collected_amount = $row3[0]->collectedAmt;
		//print_r($row3);
		
		$payment_due = $total_invoice_amount-$total_invoice_collected_amount;
		
		$data['total_invoice_reaised']	=	$total_invoice;
		$data['activeAuction']			=	$activeAuction;
		$data['payment_due']			=	($payment_due)?number_format($payment_due,2):'0';
		$data['outstanding_amount']		=	($total_invoice_amount)?number_format($total_invoice_amount,2):'0';
		return $data;
	}
	
	
	function countPopularAuctionByRange($condition){
		$query=$this->db->query("SELECT id FROM tbl_auction WHERE $condition ");
		$totalRow=$query->num_rows();
		//echo "<br>".$this->db->last_query();
		return $totalRow;
	}
	function auctionConductedbyCategories(){
		$bank_id			= $this->session->userdata['bank_id'];
		$branch_id=$this->session->userdata('branch_id');
		$totalResidential 	= $this->countPopularAuctionByRange("bank_id=$bank_id AND
		branch_id='$branch_id' AND subcategory_id=6");
		$totalCommercial    = $this->countPopularAuctionByRange("bank_id=$bank_id AND
		branch_id='$branch_id' AND subcategory_id=7");
		$total				= $totalResidential + $totalCommercial;
		// get total percentage 
		$residentialPercentage	=	($totalResidential * 100)/$total;
		$commercialPercentage	=	($totalCommercial * 100)/$total;
		$residentialPercentage	=	number_format($residentialPercentage,2);
		$commercialPercentage	=	number_format($commercialPercentage,2);
		$dataArr= array();
		$dataArr['residentialPercentage']	= $residentialPercentage;
		$dataArr['commercialPercentage']	= $commercialPercentage;
		return $dataArr;
	}
	
	public function getUserValue($userid){
           
			$this->db->where('id', $userid);
     
            $query = $this->db->get("tbl_user_registration");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
			}
			return false;
        }
        
    public function getBranchName($auctionID){
           
           
           $this->db->where('id', $auctionID);
           $query = $this->db->get("tbl_auction");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $bankid = $row->branch_id;
                    }
			}
			
			
			$this->db->where('id', $bankid);
     
            $query1 = $this->db->get("tbl_branch");
            //echo $this->db->last_query();

			$data = array();
			if ($query1->num_rows() > 0){
                    
                    foreach ($query1->result() as $row1) {
                        $bankname = $row1->name;
                    }
                    return $bankname;
			}
			return false;
    }
    
    public function getCityName($auctionID){
           
           
           $this->db->where('id', $auctionID);
           $query = $this->db->get("tbl_auction");
            //echo $this->db->last_query();

			$data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $cityid = $row->city;
                        $otherCity = $row->other_city;
                        
                    }
			}
			
			if(isset($otherCity) && $otherCity!='')
			{
				return $otherCity;
			}
			
			$this->db->where('id', $cityid);
     
            $query1 = $this->db->get("tbl_city");
            //echo $this->db->last_query();

			$data = array();
			if ($query1->num_rows() > 0){
                    
                    foreach ($query1->result() as $row1) {
                        $city_name = $row1->city_name;
                    }
                    return $city_name;
			}
			return false;
    }
	
function setopeningprice()
{
    $this->load->library('Email_new');
    $email_new = new Email_new();
    $auctionID = $this->input->post('auctionID');

    $opening_price = $this->input->post('opening_price');
    $currentStatus = 6;
    $this->db->where('id', $auctionID);
    $this->db->update('tbl_auction', array('open_price_bid'=>1, 'status'=>1,'opening_price'=>$opening_price,'stageID'=>$currentStatus,'move_to_auction'=>1));
    $this->db->where('auction_id', $auctionID);
    $update=$this->db->update('tbl_log_auction', array('open_price_bid'=>1, 'status'=>1,'opening_price'=>$opening_price,'stageID'=>$currentStatus));
    
    if($update){              

        //$email_new->sendMailToHelpdeskForOpeningStatus($auctionID);  // Uncomment First

       //$email_new->sendMailToBidderForOpeningStatus($auctionID);

        // End:Email Code
        $this->db->where('auction_id', $auctionID);
         $query=$this->db->get('tbl_log_auction');
        $data['emd']=$query->result();
        if(!empty($data['emd'])){
            //start 
             $type='Opening_Price_selection';
             $message='Buyer submitted opening price';
             $this->trackemdDetailPopupData($data,$type,$message); 
        }
    }
		//end
		return true;
}
    
    
	public function getNITRefNo($auctionID)
	{
           $this->db->where('id', $auctionID);
           $query = $this->db->get("tbl_auction");

		   $data = array();
			if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $reference_no = $row->reference_no;
                    }
                    return $reference_no;
			}

			return false;
    }
	
    function movetoauction1(){
                ///Auction moved success fully
                   
                $type = $this->input->post('type');
                $message = $this->input->post('message');
               //
               // 
               //  
               //    $this->db->where('auction_id', $auctionID);
                
                //move_to_auction
                $query=$this->db->get('tbl_log_auction');
                $data['emd']=$query->result();
               if(!empty($data['emd'])){
                $this->trackemdDetailPopupData($data,$type,$message); 
                } 
              }
        
        function movetoauction(){
                ///Auction moved success fully
                $auctionID = $this->input->post('auctionID');
                //$this->db->where('id',$auctionID);
                //$this->db->update("tbl_auction", array('move_to_auction'=>1));
                
                $type = $this->input->post('type');
                $message = $this->input->post('message');
                $this->db->where('auction_id', $auctionID);
                
                //move_to_auction
                $query=$this->db->get('tbl_log_auction');
                $data['emd']=$query->result();
                
               if(!empty($data['emd'])){
                $this->trackemdDetailPopupData($data,$type,$message); 
                } 
              }
              
              
	
	function setowneropeningprice()
	{
		$auctionID = $this->input->post('auctionID');
		$opening_price = $this->input->post('opening_price');
		$currentStatus = 4;
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('opening_price'=>$opening_price,'stageID'=>$currentStatus));
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('opening_price'=>$opening_price,'stageID'=>$currentStatus));
		//echo $this->db->last_query();		
		return true;
	}
	
	/*
	function movetofirstopener()
	{
		$auctionID = $this->input->post('auctionID');
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('stageID'=>5));
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('stageID'=>5));
		//echo $this->db->last_query();		
		//$this->session->set_userdata('opne_popup', true);		
		return true;
	}
	
	function movetosecondopener()
	{
		$auctionID = $this->input->post('auctionID');
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('stageID'=>5));
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('stageID'=>5));
		//echo $this->db->last_query();		
		//$this->session->set_userdata('opne_popup', true);		
		return true;
	}
	*/
	
	function movetoapprover()
	{
		$auctionID = $this->input->post('auctionID');
		
		$doc_to_be_submitted=GetTitleByField("tbl_auction", "id='".$auctionID."'", "doc_to_be_submitted");
		
		if($doc_to_be_submitted == 0)
		{
			$whrArr = array('payment_verifier_accepted'=>1,'payment_verifier_comment !='=>'','auctionID'=>$auctionID); 
		}
		else
		{
			$whrArr = array('payment_verifier_accepted'=>1,'payment_verifier_comment !='=>'','operner1_accepted'=>1,'operner1_comment !='=>'','auctionID'=>$auctionID); 
		}
		$this->db->where($whrArr);
		$this->db->limit(1);		
		$ckQry = $this->db->get('tbl_auction_participate');
		//echo $this->db->last_query();die;
		
		$roleId = $this->session->userdata('role_id');
		if($roleId == 5) // document verifiyer
		{
			$this->db->where('auctionID',$auctionID);				
			$pQry = $this->db->update('tbl_auction_participate',array('opener1_move_to_opener2'=>1));
			$plQry = $this->db->update('tbl_log_auction_participate',array('opener1_move_to_opener2'=>1));
		}
		if($roleId == 3) // payment verifiyer 
		{			
			$this->db->where('auctionID',$auctionID);
			$pQry = $this->db->update('tbl_auction_participate',array('payment_move_to_opener2'=>1));
			$plQry = $this->db->update('tbl_log_auction_participate',array('payment_move_to_opener2'=>1));
		}
		
		
		if($ckQry->num_rows()>0)
		{
			
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction', array('stageID'=>5));
			
			$this->db->where('auction_id', $auctionID);
			$this->db->update('tbl_log_auction', array('stageID'=>5));
			//echo $this->db->last_query();		
			//$this->session->set_userdata('opne_popup', true);		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function open_price_bid1()
	{
		$auctionID = $this->input->post('auctionID');
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('open_price_bid'=>1, 'status'=>1));	
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('open_price_bid'=>1, 'status'=>1));	 //LOG
            if($update)
            {
                $this->db->where('auction_id', $auctionID);
                $query=$this->db->get('tbl_log_auction');
                $data['emd']=$query->result();
				if(!empty($data['emd']))
				{
                //start 
					$type='Opening_Price_selection';
					$message='Buyer submitted opening price';
					$this->trackemdDetailPopupData($data,$type,$message); 
				}
            }     
		$this->session->set_userdata('open_popup', true);
		return true;
	}

	function getBankerCreatedAuction($auction_id){
	$bankerID = $this->session->userdata('id');
	$query=$this->db->query("SELECT id from tbl_auction where  (created_by='$bankerID' OR first_opener='$bankerID' OR second_opener='$bankerID') AND auction_type='0' AND id='$auction_id'");
	
	$totalRow=$query->num_rows();
	//echo $this->db->last_query();die;
	
		if($totalRow>0){
			$dataarr=array();
			 foreach ($query->result() as $row) {
                $dataarr[] = $row->id;
            }
		}else{
		$dataarr=0;	
		}
	return $dataarr;
}


public function GetCityBank($state_id=null) {
		$this->db->where('status', 1);		

		$this->db->where("id", $state_id);		

		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_city");
        $data = array();
		//echo $this->db->last_query();
	  if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
public function GetStateBank($state_id=null) {
		$this->db->where('status', 1);		

		$this->db->where("id", $state_id);		

		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_state");
        $data = array();
		//echo $this->db->last_query();
	  if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	
	public function checkMultipleExtension($filename=null) 
	{
		$strArray = count_chars($filename,1);

		foreach ($strArray as $dotkey=>$dotCountVal)
		  {
			  if(chr($dotkey) == '.')
			  {
				$dotCountValue[] = $dotCountVal;
			  }
		  }	
		  if($dotCountValue[0] > 1)
		  {
			return 'mul';
		  }
		  else
		  {
				if($dotCountValue[0] == '1')
				  {
					  $getFileExt = explode('.',$filename);
					  $getFileExt = strtolower($getFileExt[1]);
					  $allowed =  array('gif','png' ,'jpg','jpeg','xls','doc','docx','zip','pdf');
					  if(!in_array($getFileExt,$allowed) ) 
						{
							 return 'mul';
						}
						
				  }
				 return 'sin';
		   }		
		  return 'sin';
    }
    public function checkHTMLTags($string)
    {
		if($string != strip_tags($string)) 
		{
			// contains HTML
			return '1';
		}
		else
		{
			return '0';	
		}
	}
	
	public function checkVideoMultipleExtension($filename=null) 
	{
		$strArray = count_chars($filename,1);

		foreach ($strArray as $dotkey=>$dotCountVal)
		  {
			  if(chr($dotkey) == '.')
			  {
				$dotCountValue[] = $dotCountVal;
			  }
		  }	
		  if($dotCountValue[0] > 1)
		  {
			return 'mul';
		  }
		  else
		  {
				if($dotCountValue[0] == '1')
				  {
					  $getFileExt = explode('.',$filename);
					  $getFileExt = $getFileExt[1];
					  $allowed =  array('webm','mkv','flv','avi','3gp','mp4','wmv');
					  if(!in_array($getFileExt,$allowed) ) 
						{
							 return 'mul';
						}
						
				  }
				 return 'sin';
		   }		
		  return 'sin';
    }
    
    public function GetAuctionDocuments($auctionId)
    {
		$this->db->select('*');
		$this->db->where('auction_id',$auctionId);
		$qry = $this->db->get('tbl_auction_document');
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		else
		{
			return array();
		}
	}
	public function GetUploadDocumentFieldRecords()
    {
		$this->db->where('status', 1);
		$this->db->order_by("upload_document_field_id", "ASC");
        $query = $this->db->get("tblmst_upload_document_field");	
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
	
	public function getAllPages(){
               
		//$this->db->where('auctionID', $auctionID);
		$role_id = $this->session->userdata('role_id');
		
		$this->db->select('rp.*');
		$this->db->where_in('r.role_id',$role_id);
		$this->db->where('rp.is_show_menu',1);
		$this->db->where('rp.status',1);
		$this->db->where('p.status',1);
		$this->db->join('tbl_role_page as rp','rp.role_page_id = p.role_page_id and rp.status = 1');
		$this->db->join('tbl_role as r','r.role_id = p.role_id and  r.status = 1');
		$this->db->order_by('rp.order');
		$query = $this->db->get("tbl_role_page_permission as p");
        return $query->result();
	}
	
	public function checkPageBidderPermission($method = ''){
               
		$role_id 	= $this->session->userdata('role_id');
		
		$this->db->select('rp.*');
		$this->db->where_in('r.role_id',$role_id);
		//$this->db->where('rp.is_show_menu',1);
		$this->db->where('rp.status',1);
		$this->db->where('p.status',1);
		$this->db->where('rp.link',$method);
		$this->db->join('tbl_role_page as rp','rp.role_page_id = p.role_page_id and rp.status = 1');
		$this->db->join('tbl_role as r','r.role_id = p.role_id and  r.status = 1');
		$query = $this->db->get("tbl_role_page_permission as p");
		if($query->num_rows() > 0)
		{
			return true;
		}
		
		$this->db->where('rp.link',$method);
		$this->db->where('rp.status',1);
		$query = $this->db->get("tbl_role_page as rp");
		if($query->num_rows() == 0)
		{
			return true;
		}
		
		return false;
	}
	
	//SSO Login function 
	public function check_sso_login()
	{
		
		$tokenId = $this->session->userdata('jda_token');
		if($tokenId !='')
		{
			$url = EXTERNAL_LOGIN_URL.$tokenId;
			
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$return = curl_exec($ch);
			curl_close ($ch);			
			//print_r($return);			
			$data = json_decode($return);
			
			/*
			echo "<pre>";
			print_r($data);
			echo "</pre>";die;
			*/
			
			if($data->Status !='Success')
			{
				/*$this->session->sess_destroy();
				redirect(SSO_URL.'/UserManagement/Login');
				exit;
				*/
				redirect('registration/logout');
				exit();
				
			}
		}
			
	}
	
	public function setRole()
	{
        $user_dept_id = $this->input->post('user_dept_id');
		$userid= $this->session->userdata('id');
		
		$this->db->select('ud.*, tu.first_name, tu.last_name,tu.email_id');
		$this->db->from('tbl_user_department as ud');
		$this->db->join('tbl_user as tu','tu.id=ud.user_id','left');
		$this->db->where('ud.user_deprt_id',$user_dept_id);
		$this->db->where('ud.user_id',$userid);
		$this->db->where('ud.status',1);
		$qry = $this->db->get();		
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
				
				$rows = $qry->result_array();
				$this->session->set_userdata('role_id',$rows[0]['role_id']);
				$this->session->set_userdata('depart_id',$rows[0]['department_id']);
				
				if ($rows[0]['role_id'] ==6) {
					
					$this->session->unset_userdata('full_name', $nameArr[0]);
					$this->session->unset_userdata('user_type', $user_type);
					$this->session->unset_userdata('bank_id', 41);
					$this->session->unset_userdata('branch_id', 0);
					
					$this->session->unset_userdata('session_id_user', $rand);
					$this->session->unset_userdata('table_session', 'banker_tb');     

					$data = array(
                                'adminid' => $rows[0]['user_id'],
                                'id' => $rows[0]['user_id'],
                                'aname' => $rows[0]['first_name'].' '.$rows[0]['last_name'],
                                'aemail' => $row[0]['email_id'],
                                'validated' => true,
                                'arole' => 1
                                 );
                    $this->session->set_userdata($data);
                    redirect(base_url().'admin/home');
                }
                else{ 
					
				$this->session->unset_userdata('adminid'); 
				$this->session->unset_userdata('id'); 
				$this->session->unset_userdata('aname'); 
				$this->session->unset_userdata('aemail'); 
				$this->session->unset_userdata('validated');
				$this->session->unset_userdata('arole'); 
				
				$user_type = 'buyer';	
                $rand = rand(1000000000, 9999999999);
                $res = $this->bankuserupdate_login($rows[0]['user_id']);
                $this->session->set_userdata('id', $rows[0]['user_id']);
                $this->session->set_userdata('full_name', $rows[0]['first_name'].' '.$rows[0]['last_name']);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('bank_id', 41);
                $this->session->set_userdata('branch_id', 0);
                $this->session->set_userdata('session_found_usertype', 'banker');
                $this->session->set_userdata('session_found_emailid', $rows[0]['email_id']);
                $this->session->set_userdata('session_id_user', $rand);
                $this->session->set_userdata('table_session', 'banker_tb'); 
                //echo $this->session->userdata('role_id');die;
                if($this->session->userdata('role_id')==3)
                {
					
					redirect(base_url()."buyer/emd_payment_verification");
					exit;
				}
				else
				{                
					redirect(base_url()."registration/redirectDashboard");
					exit;
				}
					 
			}
		}
	}
	
	 public function bankuserupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $setarray);
        return true;
    }
    
    function mastercontactdata()
    { 
		$auctionID = $this->uri->segment(3);
		$this->datatables->select("ap.id,ap.bidderID,ur.email_id, (CASE WHEN ap.payment_verifier_accepted = '1' THEN 'Accepted' WHEN ap.payment_verifier_accepted = '0' THEN 'Rejected' ELSE '' END), ap.payment_verifier_comment, (CASE WHEN ap.operner1_accepted = '1' THEN 'Accepted' WHEN ap.operner1_accepted = '0' THEN 'Rejected' ELSE '' END), ap.operner1_comment, (CASE WHEN ap.operner2_accepted = '1' THEN 'Accepted' WHEN ap.operner2_accepted = '0' THEN 'Rejected' ELSE '' END),ap.operner2_comment",false)		
		->add_column('Actions',"<a class='emd_detail_iframe cboxElement' href='/buyer/emdDetailPopup/$1/$auctionID'>EMD</a> | <a class='tenderfee_detail_iframe cboxElement' href='/buyer/docDetailPopup/$2/$auctionID'>Docs</a>", 'ap.bidderID,ap.bidderID')
        ->from('tbl_auction_participate as ap')		
		//->join('tbl_jda_payment_log as jp','jp.bidder_id=ap.bidderID','left')
		->join('tbl_auction_participate_doc as pd','pd.bidderID=ap.bidderID','left')
		->join('tbl_user_registration as ur','ur.id=ap.bidderID','left')
		->where(array('operner2_accepted'=>NULL))
		->where('ap.auctionID', $auctionID)		
		->where('ap.final_submit', 1)
		->group_by('ap.id');		
		return $this->datatables->generate();  
		
          
    }
    
    public function bidderListAuction($auctionID)
    {
		/***** bidder detail*****/
			//$this->db->select('count(id) as bider_total');
			$this->db->where('final_submit', 1);
              //$this->db->where('added_type','bidder');   //added by amit
              
            $this->db->where('participate_by is not null');  // For Add Bidder by document
            if($this->session->userdata('role_id')==2) 
            {
				$this->db->where(array('operner2_accepted'=>NULL));
			}
			
			if($this->session->userdata('role_id')==5)
			{
				$this->db->where(array('opener1_move_to_opener2'=>0,'operner2_accepted'=>NULL));
			}
            
			$this->db->where('auctionID', $auctionID);
			$query = $this->db->get("tbl_auction_participate");
            //echo $this->db->last_query();die;
				if($query->num_rows()>0)
				{
					//echo '<pre>';
					//print_r($query->result());
					$data1=array();
					foreach ($query->result() as $row1)
					{
						/*
						//emd fee
						$this->db->where('auctionID', $auctionID);
						$this->db->where('bidderID', $row1->bidderID);
						$query_emd = $this->db->get("tbl_auction_participate_emd");
						$emd_result=$query_emd->result();
						$row1->emd_detail=$emd_result;
						*/
						$payArr = array('pending','success');
						$this->db->where('auction_id', $row1->auctionID);
						$this->db->where('bidder_id', $row1->bidderID);
						$this->db->where_in('payment_status',$payArr);
						$query_emd = $this->db->get("tbl_jda_payment_log");
						$emd_result=$query_emd->result();
						$row1->emd_detail=$emd_result;
						
						
						//frq
						$this->db->where('auctionID', $auctionID);
						$this->db->where('bidderID', $row1->bidderID);
						$query_frq = $this->db->get("tbl_auction_participate_frq");
						$frq_result=$query_frq->result();
						$row1->frq_detail=$frq_result;
						
						//tender fee
						$this->db->where('auctionID', $auctionID);
						$this->db->where('bidderID', $row1->bidderID);
						$query_tenderfee = 
						$this->db->get("tbl_auction_participate_tenderfee");
						$tenderfee_result=$query_tenderfee->result();
						$row1->tenderfee=$tenderfee_result;
						
						//doc
						$this->db->where('auctionID', $auctionID);
						$this->db->where('bidderID', $row1->bidderID);
						$query_tenderfee = 
						$this->db->get("tbl_auction_participate_tenderfee");
						
						$this->db->where('auctionID', $auctionID);
						$this->db->where('bidderID', $row1->bidderID);
						$query_doc = $this->db->get("tbl_auction_participate_doc");
						$data_doc=array();
						foreach ($query_doc->result() as $row_doc)
						{
						$data_doc[]=$row_doc;
						}
						$row1->doc=$data_doc;
						//doc end
						$data1[]=$row1;
						$data[0]->bider_detail=$data1;
					}
				}
			//$data[0]->bider_total=$bider_total[0]->bider_total;
			/***** end bidder*****/
			return $data;
	}
	
	public function add_bidder_live_auction()
	{
		$participate_id = $this->input->post('participate_id');
		
		$bid_acceptance = $this->input->post('bid_acceptance');
		$txtComment = $this->input->post('txtComment');
		
		$txtComment = $this->input->post('txtComment');
		$txtComment = array_filter($txtComment);
		$auctionID = $this->input->post('auctionID');
		$i=0;
		foreach($participate_id as $pi)
		{	
			
			if($this->session->userdata('role_id')==3) 
			{ 
			
				$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
				$data = array(
							'payment_verifier_accepted'=>$acceptance,
							'payment_verifier_comment'=>$txtComment[$i],
							'payment_move_to_opener2'=>1,
							'payment_verifier_accepted_date'=>date('Y-m-d H:i:s')						
							
							);
				
				$this->db->where('id', $pi);
				$bidaccepted=$this->db->update('tbl_auction_participate', $data); 	
				
				if($bidaccepted){
					
					$this->db->where('id',$pi);
					$pQry = $this->db->get('tbl_auction_participate');
					$rows = $pQry->result_array();
					
					$data1 = $rows[0];
					
					unset($data1['id']);
					unset($data1['pstatus']);
					unset($data1['dsc_verified_status']);
					
					
					$data1['auction_participate_id'] = $rows[0]['id'];
					$data1['payment_verifier_accepted']= $acceptance;
					$data1['payment_verifier_comment']=$txtComment[$i];	
					$data1['payment_move_to_opener2']=1;									
					$data1['payment_verifier_accepted_date']=date('Y-m-d H:i:s');
					$data1['payment_verifier_accepted_ip']=$_SERVER['REMOTE_ADDR'];
									
					$this->db->insert('tbl_log_auction_participate', $data1); 
					
					
				}
		   }
		   if($this->session->userdata('role_id')==5) 
		   { 
				$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
				$data = array(
							'operner1_accepted'=>$acceptance,
							'operner1_comment'=>$txtComment[$i],
							'opener1_move_to_opener2'=>1,
							'opener1_accepted_date'=>date('Y-m-d H:i:s')						
							);
				
				$this->db->where('id', $pi);
				$bidaccepted=$this->db->update('tbl_auction_participate', $data); 			
				if($bidaccepted){
					
					$this->db->where('id',$pi);
					$pQry = $this->db->get('tbl_auction_participate');
					$rows = $pQry->result_array();
					
					$data1 = $rows[0];
					
					
					unset($data1['id']);
					unset($data1['pstatus']);
					unset($data1['dsc_verified_status']);
					
					$data1['auction_participate_id'] = $rows[0]['id'];
					$data1['operner1_accepted']= $acceptance;
					$data1['operner1_comment']=$txtComment[$i];	
					$data1['opener1_move_to_opener2']=1;									
					$data1['opener1_accepted_date']=date('Y-m-d H:i:s');
					$data1['opener1_accepted_ip']=$_SERVER['REMOTE_ADDR'];
									
					$this->db->insert('tbl_log_auction_participate', $data1); 
					
				}
		   }
		   if($this->session->userdata('role_id')==2) 
		   { 
				$move_to_auction = GetTitleById('tbl_auction',$auctionID,'move_to_auction');
				if($move_to_auction <=0)
				{	
					$currentStatus = 6;
					$this->db->where('id', $auctionID);
					$this->db->update('tbl_auction', array('status'=>1,'stageID'=>$currentStatus,'move_to_auction'=>1));
					$this->db->where('auction_id', $auctionID);
					$update=$this->db->update('tbl_log_auction', array( 'status'=>1,'stageID'=>$currentStatus));
				}
				
				$acceptance = ($bid_acceptance[$i]==1)?'1':'0';
				$data = array(
							'operner2_accepted'=>$acceptance,
							'operner2_comment'=>$txtComment[$i],
							'opener2_accepted_date'=>date('Y-m-d H:i:s')													
							);
				if($acceptance == 0)
				{
					$data['final_submit'] = 0;
				}
				$this->db->where('id', $pi);
				$bidaccepted=$this->db->update('tbl_auction_participate', $data); 					
				$bidderID = GetTitleByField('tbl_auction_participate', "id='".$participate_id[$i]."'", 'bidderID');		
				if($bidaccepted)
				{
					$this->db->where('id',$pi);
					$pQry = $this->db->get('tbl_auction_participate');
					$rows = $pQry->result_array();					
					$data1 = $rows[0];
					
					unset($data1['id']);
					unset($data1['pstatus']);
					unset($data1['dsc_verified_status']);
					$data1['auction_participate_id'] = $rows[0]['id'];
					$data1['operner2_accepted']= $acceptance;
					$data1['operner2_comment']=$txtComment[$i];									
					$data1['opener2_accepted_date']=date('Y-m-d H:i:s');
					$data1['opener2_accepted_ip']=$_SERVER['REMOTE_ADDR'];
					
					if($acceptance == 0)
					{
						$data1['final_submit'] = 0;
					}					
					$this->db->insert('tbl_log_auction_participate', $data1); 
				}
				
				$this->send_bid_acceptted_rejected_mail($bidderID,$bid_acceptance[$i]);
				 
		   }
			$i++;
		}
		
		$this->session->set_userdata('open_popup', true);
	}
	
	public function paymentbidderListAuction()
    {
		$depart_id = $this->session->userdata('depart_id');
		/***** bidder detail*****/
			
			$this->db->select('ap.*, a.reference_no');
			$this->db->from('tbl_auction_participate as ap');			
			//$this->db->join('tbl_jda_payment_log as pl','pl.bidder_id=ap.bidderID and pl.auction_id=ap.auctionID','left');
			$this->db->join('tbl_auction as a','a.id=ap.auctionID','left');
			$this->db->where('ap.final_submit', 1);
			//$this->db->where('a.department_id',$depart_id);
            //$this->db->where('ap.participate_by is not null');  // For Add Bidder by document
            $this->db->where(array('ap.payment_move_to_opener2'=>0,'ap.operner2_accepted'=>NULL));
            
			$this->db->group_by('ap.id','ASC');
			$query = $this->db->get();
            //echo $this->db->last_query();    die;
				if($query->num_rows()>0)
				{
					//echo '<pre>';
					//print_r($query->result());die;
					$data1=array();
					foreach ($query->result() as $row1)
					{
						//emd fee
						$payArr = array('success');
						$this->db->where('auction_id', $row1->auctionID);
						$this->db->where('bidder_id', $row1->bidderID);
						$this->db->where_in('payment_status',$payArr);
						$query_emd = $this->db->get("tbl_jda_payment_log");
						$emd_result=$query_emd->result();
						$row1->emd_detail=$emd_result;
						
						//doc end
						$data1[]=$row1;
						$data[0]->bider_detail=$data1;
					}
				}
			//$data[0]->bider_total=$bider_total[0]->bider_total;
			/***** end bidder*****/
			return $data;
	}
        
    public function sendSMS($data=array())
    {        
        /* $data['SMSMessage'] = 'Hello Azizur Rahman';
        $expDate = date('Y-m-d H:i:s');		
        $data['exp_date'] = date('Y-m-d H:i:s',strtotime($expDate . ' +1 day'));*/
		
		$jsonData = '{
                            "MobileNumber": "'.$data['mobile'].'",
                            "SMSMessage": "'.$data['SMSMessage'].'",
                            "SenderApplicationID": 3,
                            "SenderUserID": 4,
                            "SMSExpiryDateTime": "'.$data['exp_date'].'",
                            "priority": true
                          }';
		
		$headers = array(
					"Content-type: application/json",					
					//"Authorization: Basic NjM6Q2gjOVktM3I=",
				);
		
		$url = SMS_URL;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		// Following line is compulsary to add as it is:
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = curl_exec($ch);
		curl_close($ch);		
		/*
		$response = json_decode($data);
		echo "<pre>";
		print_r($response);die;
		*/ 
	}
	
	function save_awrd_status(){		
	
		$bidderId=$this->input->post('bidderId');
		$auctionId = $this->input->post('auctionId');
		if($this->input->post('awrd_reject'))
		{
			$awardedStatus = 2; //rejected
		}
		if($this->input->post('awrd_accept'))
		{
			$awardedStatus = 1; //accepted
		}
		
		$this->db->where('bidderID',$bidderId);
		$this->db->where('auctionID',$auctionId);
		$this->db->where('final_submit',1);
		$pQry = $this->db->get('tbl_auction_participate');
		//echo $this->db->last_query();die;
		
		if($pQry->num_rows()>0)
		{	
                        //Start: Auction moved from completed/conclude to archive auction list
			$aData['status'] = 8; //8 Status for Archive Auction
                        $aData['stageID'] = 8; //8 statgeID for Archive Auction
			$this->db->where('id',$auctionId);
                        $this->db->where('status >=', 6);
			$this->db->update('tbl_auction',$aData);
                        //End: Auction moved from completed/conclude to archive auction list
                        
			$data = array('awardedStatus'=>$awardedStatus);
			$this->db->where('bidderID',$bidderId);
			$this->db->where('auctionID',$auctionId);
			$this->db->where('final_submit',1);
			$this->db->update('tbl_auction_participate',$data); 
			//echo $this->db->last_query();die;
			
			$rows = $pQry->result_array();
					
			$data1 = $rows[0];
			
			unset($data1['id']);
			unset($data1['pstatus']);
			unset($data1['dsc_verified_status']);
			
			$userid= $this->session->userdata('id');
					
			$data1['auction_participate_id'] = $rows[0]['id'];
			$data1['awardedStatus']= $awardedStatus;	
			$data1['awarded_by']=$userid;
			$data1['awarded_date']=date('Y-m-d H:i:s');
			$data1['awarded_ip']=$_SERVER['REMOTE_ADDR'];
			
			$this->db->insert('tbl_log_auction_participate', $data1); 	
			
			if($this->input->post('awrd_reject'))
			{
				$msg = "H1 bid has been rejected";
				$this->session->set_flashdata('message_new', $msg);
				redirect('buyer/banker_h1Bidder/'.$auctionId);
				exit;
			}
			if($this->input->post('awrd_accept'))
			{
				$msg = "H1 bid has been successfully accepted";
				$this->session->set_flashdata('message', $msg);
				redirect('buyer/banker_h1Bidder/'.$auctionId);
				exit;
			}		
			
		}	
	}
	
	
	public function save_copy_auction($aData)
	{	
		/*
		echo "test<pre>";	
        print_r($aData);die;
        */
        
		$data 	= array(
			//'productID'=>$productID,
			'event_type'=>'',
			'account_type_id'=>$aData->account_type_id,
			'auto_bid_cut_off'=>$aData->auto_bid_cut_off,
			'reference_no'=>$aData->reference_no,
			'event_title'=>$aData->event_title,
			'dispatch_date'=>$aData->dispatch_date,
			'category_id'=>$aData->category_id,
			'subcategory_id'=>$aData->subcategory_id,
			'area_unit_id'=>$aData->area_unit_id,
			'is_corner_property'=>$aData->is_corner_property,
			'remark'=>$aData->remark,
			'scheme_id'=>$aData->scheme_id,
			'scheme_name'=>$aData->scheme_name,
			'open_price_bid'=>$aData->open_price_bid,
			'opening_price'=>$aData->opening_price,
			//'cprms_scheme_name'=>$cprms_scheme_name,
			'service_no'=>$aData->service_no,
			'zone_id'=>$aData->zone_id,
			'department_id'=>$aData->department_id,
			'far'=>$aData->far,
			'property_height'=>$aData->property_height,
			'height_unit_id'=>$aData->height_unit_id,
			'max_coverage_area'=>$aData->max_coverage_area,
			'unit_id_of_price'=>$aData->unit_id_of_price,
			'registration_start_date'=>$aData->registration_start_date,
			'registration_end_date'=>$aData->registration_end_date,
			'mode_of_bid'=>$aData->mode_of_bid,
			'branch_id'=>$aData->branch_id,
			'drt_id'=>$aData->drt_id,
			'bank_id'=>$aData->bank_id,
			'borrower_name'=>$aData->borrower_name,
			'invoice_mail_to'=>$aData->invoice_mail_to,
			'invoice_mailed'=>$aData->invoice_mailed,
			'reserve_price'=>$aData->opening_price,
			'emd_amt'=>$aData->emd_amt,
			'tender_fee'=>$aData->tender_fee,
			'nodal_bank_name'=>$aData->nodal_bank_name,
			'nodal_bank'=>$aData->nodal_bank,
			'nodal_bank_account'=>$aData->nodal_bank_account,
			'branch_ifsc_code'=>$aData->branch_ifsc_code,
			'press_release_date'=>$aData->press_release_date,
			'inspection_date_from'=>$aData->inspection_date_from,
			'inspection_date_to'=>$aData->inspection_date_to,
			'bid_last_date'=>$aData->bid_last_date,
			'bid_opening_date'=>$aData->bid_opening_date,
			'auction_start_date'=>$aData->auction_start_date,
			'auction_end_date'=>$aData->auction_end_date,
			'bank_branch_id'=>$aData->bank_branch_id,
			'show_frq'=>$aData->show_frq,
			'dsc_enabled'=>$aData->dsc_enabled,
			'bid_inc'=>$aData->bid_inc,
			'price_bid_applicable'=>$aData->price_bid_applicable,			
			'auto_extension_time'=>$aData->auto_extension_time,
			'no_of_auto_extn'=>$aData->no_of_auto_extn,
			'doc_to_be_submitted'=>null,
			'second_opener'=>null,
			'created_by'=>$aData->created_by,
			'first_opener'=>$aData->created_by,
			'auction_type'=>$aData->auction_type,
			'indate'=>date('Y-m-d H:i:s'),
			'is_closed'=>$aData->is_closed,
			'countryID'=>  $aData->country_id,
			'state'=> $aData->state_id,
			'city'=> $aData->city,
			'area'=>$aData->area,
			'latitude'=>$aData->latitude,
			'longitude'=>$aData->longitude,
			'other_city'=>$aData->other_city,
			'status'=>0,
			'contact_person_details_1'=>$aData->contact_person_details_1,			
			'contact_person_details_2'=>$aData->contact_person_details_2,
			'approvalStatus'=>0,
			'approverComments'=>null,
			'PropertyDescription'=>$aData->PropertyDescription
			
		);		
		
		//print_r($data);die;
		
		$currentdate=date('Y-m-d H:i:s');
		$data['updated_date']=$currentdate;
		$this->db->insert('tbl_auction',$data); 
		
		//start: add data into auction log table
		$insertedid_id = $this->db->insert_id();			
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['auction_id'] = $insertedid_id;
		$this->db->insert('tbl_log_auction',$data);
		//end: add data into auction log table
		
		//start: add data into docs table
		$doc_data = $this->GetUploadedDocsByAuctionId($aData->id);
		foreach($doc_data as $udf)
		{					
			$dataFile =array(
					'auction_id'=>$insertedid_id,
					'upload_document_field_id'=>$udf->upload_document_field_id,
					'upload_document_field_name'=>$udf->upload_document_field_name,
					'file_path'=>$udf->file_path,
					'date_created'=>date('Y-m-d H:i:s'),
					'status'=>1
			);
			
			$this->db->insert('tbl_auction_document',$dataFile);			
		}
		//end: add data into docs table
		
		
		//start: add data into product table
		$type 			     =	($aData->subcategory_id)?$aData->subcategory_id:0;
		$category 		     =  ($aData->category_id)?$aData->category_id:0;
		$product_type_val    =  GetTitleByField('tbl_category', "id=".$category."", 'name');		
		$description 	     =	$aData->PropertyDescription;		
        $product_subtype_val =  GetTitleByField('tbl_category', "id=".$type."", 'name');
        
		$pData 	= array(
			'product_description'=>$description,			
			'auctionID'=>$insertedid_id,
			'is_auction'=>1,
			'product_type'=>$category,
			'product_subtype_id'=>$type,
			'product_type_val'=>$product_type_val,
			'product_subtype_val'=>$product_subtype_val,
			'status'=>1,
			'indate'=>date('Y-m-d H:i:s')			
			);
			
		
		$this->db->insert('tbl_product', $pData);	
		$product_id = $this->db->insert_id();	
		//end: add data into product table
		
		//start: update product id into auction table
		if($product_id>0)
		{
			
			$aucArr=array('productID'=>$product_id);
			$this->db->where('id', $insertedid_id);
			$this->db->update('tbl_auction', $aucArr); 
		}
		
		return $insertedid_id;				
		
	}
	
	public function GetUploadedDocsByAuctionId($aId)
	{
		$this->db->where('status', 1);
		$this->db->where('auction_id',$aId);
		$this->db->order_by("upload_document_field_id", "ASC");
        $query = $this->db->get("tbl_auction_document");	
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
	
	
	public function auctionAlertsData($auctionId)
	{
		//$userid= $this->session->userdata('id');
		$_POST['sColumns'] = "@row := @row + 1 as SNo,alert.alert_id,alert.auction_id,alert.email_subject, alert.message,alert.display_page, CASE alert.alert_type WHEN 'E' THEN 'Email' WHEN 'M' THEN 'Marquee' WHEN 'P' THEN 'Panel Message' ELSE 'N/A' END, CASE alert.status WHEN '1' THEN 'Active' ELSE 'Inactive' END";
		      
		$this->db->query("SET @row = 0",false);		
		$this->datatables->select("@row := @row + 1 as SNo,alert.alert_id,alert.auction_id,alert.email_subject, alert.message,alert.display_page,CASE alert.alert_type WHEN 'E' THEN 'Email' WHEN 'M' THEN 'Marquee' WHEN 'P' THEN 'Panel Message' ELSE 'N/A' END, CASE alert.status WHEN '1' THEN 'Active' ELSE 'Inactive' END",false)
		
        ->from('tbl_auction_alert as alert')
        ->unset_column('alert.alert_id')
        ->unset_column('alert.auction_id')        
        ->add_column('Actions','<a href="'.base_url().'buyer/auction_alert_msg/$1/$2" class="tooltip" title="Edit Message"><img src="/bankeauc/images/edit.png" title="Edit Message" class="edit1"></a><img src="/bankeauc/images/delete.png" title="Delete Message" class="edit1 tooltip" onclick="alert_rmv($2)" style="cursor:pointer;">', 'alert.auction_id,alert.alert_id')		
        //<a href="'.base_url().'buyer/auction_alert_msg/$1/$2/delete">
		->where('alert.is_deleted',0)
		->where('alert.auction_id ', $auctionId);
		//$this->datatables->generate();
		//echo $this->db->last_query();die;
        return $this->datatables->generate();
	}
	public function addAuctionAlert($auctionId,$alertId = 0)
    {
		if($auctionId > 0)
		{
			$alert_type = $this->input->post("alert_type");
			$email_subject = $this->input->post("email_subject");
			$message = $this->input->post("msg_body");
			$status = $this->input->post('status');
			$created_by = $this->session->userdata('id');
			$data = array(
				 'auction_id'=>$auctionId,
				 'alert_type'=>$alert_type,
				 'email_subject'=>$email_subject,
				 'message'=>$message,				 
				 'created_by'=>$created_by,
				 'status'=>$status,
				 'date_created'=> date("Y-m-d H:i:s")
 		    );
 		    
 		    if($alert_type !='E')
 		    {
				$data['display_page'] = 'Auction Hall';
			}
 		     
			if($alertId > 0)
			{				
				$data['date_modified']= date("Y-m-d H:i:s");
				$this->db->where('auction_id',$auctionId);			
			    $this->db->where('alert_id',$alertId);
				$query = $this->db->update('tbl_auction_alert',$data);
			}
			else
			{
				if($alert_type =='E')
				{
					$this->load->library('Email_new');
					$email_new = new Email_new();
					$email_new->sendAuctionAlertMailToBidders($auctionId,$email_subject,$message); 
				}			
				$this->db->insert('tbl_auction_alert',$data); 
				$alertId = $this->db->insert_id();
			}	
			
			unset($data['date_modified']);
			$data['alert_id'] = $alertId;
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];			
			$this->db->insert('tbl_log_auction_alert',$data); 
		}		
		return true;
		
	}
	
	public function deleteAuctionAlert($auctionId,$alertId)
	{
		if($alertId > 0)
		{
			$this->db->where('auction_id',$auctionId);			
			$this->db->where('alert_id',$alertId);
			$query = $this->db->get('tbl_auction_alert');
			if($query->num_rows() > 0)
			{			
				$result = $query->result_array();
				$data = $result[0];	
				$data['is_deleted'] = 1;
				
				$this->db->where('auction_id',$auctionId);			
				$this->db->where('alert_id',$alertId);
				$query = $this->db->update('tbl_auction_alert',$data);
				
				
				unset($data['date_modified']);				
				$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$this->db->insert('tbl_log_auction_alert',$data);
				
				echo '1';
			}
			else
			{
				echo '0';
			}
			
		}
	}
	
	public function getAuctionAlertByAlertId($auctionId = 0,$alertId = 0)
    {
		if($alertId > 0)
		{			
			$this->db->where('auction_id',$auctionId);			
			$this->db->where('alert_id',$alertId);
			$this->db->where('is_deleted',0);
			$query = $this->db->get('tbl_auction_alert');
			if($query->num_rows() > 0)
			{
				$results = $query->result();
				return $results[0];
			}
			
		}		
		return array();
		
	}
	
	public function getAuctionAlertByAuctoinId($auctionId = 0)
    {
		if($auctionId > 0)
		{			
			$this->db->where('status','1');
			$this->db->where('auction_id',$auctionId);						
			$query = $this->db->get('tbl_auction_alert');
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			
		}
		return array();
		
	}
	
	function acceptanceBidderDetails($auction_id, $bidder_id)
	{
		$this->db->select('id, reference_no, reserve_price, emd_amt, area, area_unit_id, PropertyDescription');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();

			//Auction Last Bid Details 
			//$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,u.user_type,u.user_type,u.company_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY MAX(b.bid_value) DESC")->result_object();
			
			$this->db->select('MAX(bid_value) as bid_value, max(indate) as indate');
			$this->db->where('auctionID', $auction_id);
			$this->db->where('bidderID', $bidder_id);
			$lastbidBidder = $this->db->get("tbl_live_auction_bid")->result_object();
			
			$data[0]->lastbidBidder = $lastbidBidder;
			
			#SMS Template
			$this->db->select('msg');
			$this->db->where('sms_template_id', 12);
			$this->db->where('status', 1);
			$sms_query = $this->db->get('tblmst_sms_template')->result_object();
			
			$data[0]->sms_template = $sms_query;
			//echo "<pre>"; print_r($sms_query); die;
			
			#Email template
			$this->db->select('subject, msg');
			$this->db->where('email_template_id', 13);
			$this->db->where('status', 1);
			$email_query = $this->db->get('tblmst_email_template')->result_object();
			$data[0]->email_template = $email_query;
			
			return $data;


		} else{
			$data = 0;
			return $data;
		}
	}
        
	public function allCompletedAuctions()
	{
		$this->db->select("ea.id, ea.reference_no, ea.PropertyDescription, ea.auction_end_date"); 
		$this->db->from('tbl_auction as ea');
		$this->db->where('ea.auction_end_date < NOW()');
		$this->db->where('ea.status >=','6');
		$this->db->order_by('ea.id','DESC');
		$aQry = $this->db->get();
		//echo $this->db->last_query();die;
		if($aQry->num_rows()>0)
		{
			foreach ($aQry->result() as $row) 
			{		
				$data[] = $row;
			}
			//echo "<pre>";print_r($data);die;
				return $data;			
		}
		else
		{
			return array();
		}		
	}
    
	public function allparticipatedBidders($auctionId)
	{  
		$this->db->select('b.bidderID as bidder_id, MAX(b.bid_value) as bid_value, u.first_name, u.last_name,u.email_id');
		$this->db->from("tbl_live_auction_bid as b");
		$this->db->join('tbl_user_registration as u','u.id = b.bidderID', 'left');
		$this->db->where('b.auctionID', $auctionId);
		$this->db->group_by('b.bidderID');
		$this->db->order_by('MAX(b.bid_value)' ,'DESC');
		$this->db->limit(1);
		$h1_Bidder = $this->db->get()->result();
		//echo "<pre>";print_r($h1_Bidder);die;			
		$this->db->select('awardedStatus');
		$this->db->where('auctionID', $auctionId);
		$awQry = $this->db->get("tbl_auction_participate");
		foreach($awQry->result_array() as $row)
		{
		   $awardedStatus[] = $row['awardedStatus'];
		}
		
		$this->db->select('pl.*, a.reference_no, u.first_name, u.last_name,u.email_id');
		$this->db->from('tbl_auction_participate_emd as pl');
		$this->db->join('tbl_auction as a','a.id=pl.auctionID', 'left');
		$this->db->join('tbl_user_registration as u','u.id=pl.bidderID', 'left');
		$this->db->order_by('pl.id', 'DESC');
		$this->db->where('a.id', $auctionId);
		$this->db->where('a.status >=', 6);
		$this->db->where('pl.payment_status', 'success');
	   
		$bQry = $this->db->get();
		//
		//echo $this->db->last_query();die;
		if($bQry->num_rows()>0)
		{
			foreach ($bQry->result() as $row) 
			{   
				$paymentResArr = json_decode($row->payment_response);
				
				$this->db->select('MAX(amt_transferred) as amt_transferred, MIN(amt_remaining) as amt_remaining, payment_type');
				$this->db->from('tbl_initiate_transfer');
				$this->db->where('bidder_id', $row->bidderID);
				$this->db->where('auction_id', $row->auctionID);
				$this->db->where('payment_type', 1); //1-for Processing Fee
				$tRow = $this->db->get()->row();
				//echo $this->db->last_query();die;
			   //echo "<pre>";print_r($tQry->result());die;
			    $row->processing_fee =  '5000.00';
				$row->amt_transferred = (($tRow->amt_transferred == '')? '0.00': $tRow->amt_transferred);
				$row->amt_remaining = ((($tRow->amt_remaining == '' OR $tRow->amt_remaining == 0.00) && ($tRow->amt_transferred == '' OR $tRow->amt_transferred == 0.00))? '5000.00': $tRow->amt_remaining); //$paymentResArr->ChallanDetails[1]->Amount
				$row->payment_type   = 1;
				$data['processing'][] = $row;
				
				$emdFee = $row->amount;
			}
			
			 if($h1_Bidder[0]->bidder_id != '' && in_array(1,$awardedStatus))
			 { 
				 
				foreach ($h1_Bidder as $h1) 
				{   
					$this->db->select('MAX(amt_transferred) as amt_transferred, MIN(amt_remaining) as amt_remaining,payment_type');
					$this->db->from('tbl_initiate_transfer');
					$this->db->where('bidder_id', $h1->bidder_id);
					$this->db->where('auction_id', $auctionId);
					$this->db->where('payment_type', 2); //2-for EMD Fee
					$tRow = $this->db->get()->row();
					//echo "<pre>";print_r($tQry->result());die;
					$h1->emd_fee =  $emdFee;
					$h1->amt_transferred = (($tRow->amt_transferred == '')? '0.00': $tRow->amt_transferred);
					$h1->amt_remaining = ((($tRow->amt_remaining == '' OR $tRow->amt_remaining == 0.00) && ($tRow->amt_transferred == '' OR $tRow->amt_transferred == 0.00))? $emdFee: $tRow->amt_remaining);
					$h1->payment_type   = 2;
					
				   $data['emd'][] = $h1;
				   
				}
				//echo "<pre>";print_r($h1);die;
				
			 }
			
			//echo "<pre>";print_r($data);die;
			return $data;			
		}
		else
		{
			return array();
		}	
	} 
        
    public function get_all_parti_bidders_refund($auctionId)
	{  
		//Auction Last Bid Details for H1 Bidder
		$this->db->select('bidderID, MAX(bid_value) as bid_value');
		$this->db->where('auctionID', $auctionId);
		$this->db->group_by('bidderID');
		$this->db->order_by('MAX(bid_value)' ,'DESC');
		$this->db->limit(1);
		$h1_Bidder = $this->db->get("tbl_live_auction_bid")->result();
		//echo $this->db->last_query();die;
		//echo "<pre>";print_r($h1_Bidder);die;
		
		//Auction PARTICIPATE LOF DOR AWARDED STATUS
		$this->db->select('awardedStatus');
		$this->db->where('auctionID', $auctionId);
		$awQry = $this->db->get("tbl_auction_participate");
		foreach($awQry->result_array() as $row)
		{
		   $awardedStatus[] = $row['awardedStatus'];
		}
		//save_initiate_transferecho "<pre>"; print_r($awardedStatus);die;
		$this->db->select('pl.*, a.reference_no, u.first_name, u.last_name,u.email_id');
		$this->db->from('tbl_auction_participate_emd as pl');
		$this->db->join('tbl_auction as a','a.id=pl.auctionID', 'left');
		$this->db->join('tbl_user_registration as u','u.id=pl.bidderID', 'left');
		$this->db->order_by('pl.id', 'DESC');
		$this->db->where('a.id', $auctionId);
		$this->db->where('a.status >=', 6);
		$this->db->where('pl.payment_status', 'success');
		if($h1_Bidder[0]->bidderID != '' && in_array(1,$awardedStatus))
		{                
			$this->db->where('u.id !=', $h1_Bidder[0]->bidderID);
		}
		$bQry = $this->db->get();
		//echo $this->db->last_query();die;
		if($bQry->num_rows()>0)
		{
			foreach ($bQry->result() as $row) 
			{   
				
				//$paymentResArr = json_decode($row->payment_response);
				
				$this->db->select('MAX(refunded_emd) as refunded_emd, MIN(remaining_emd) as remaining_emd');
				$this->db->from('tbl_emd_refund');
				$this->db->where('bidder_id', $row->bidderID);
				$this->db->where('auction_id', $row->auctionID);
				$rRow = $this->db->get()->row();
				 //echo "<pre>";print_r($rRow);die;
			   
				$row->refunded_emd = (($rRow->refunded_emd == '')? '0.00': $rRow->refunded_emd);
				$row->remaining_emd = ((($rRow->remaining_emd == '' OR $rRow->remaining_emd == 0.00) && ($rRow->refunded_emd == '' OR $rRow->refunded_emd == 0.00))? $row->amount: $rRow->remaining_emd);
				
				//Get Bidder Account Details
				$url = BIDDER_BANK_URL.$row->bidder_id;
				//$url = "http://api.jaipurjda.org/apisso/api/UserManagement/GetRefundAccountDetails?AppId=63&UserId=26886";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$accData = curl_exec($ch);
				curl_close($ch);		

				$response = json_decode($accData);
				$acc_details = json_decode($response->Data); 
				//echo "<pre>"; print_r($acc_details); die;
				$row->AccountHolderName = ((($acc_details[0]->AccountHolderName == '') OR ($acc_details[0]->AccountHolderName == NULL))? '': $acc_details[0]->AccountHolderName);
				$row->RefundBankName    = ((($acc_details[0]->RefundBankName == '') OR ($acc_details[0]->RefundBankName == NULL))? '': $acc_details[0]->RefundBankName);
				$row->RefundAccountIFSC = ((($acc_details[0]->RefundAccountIFSC == '') OR ($acc_details[0]->RefundAccountIFSC == NULL))? '': $acc_details[0]->RefundAccountIFSC);
				$row->AccountNumber     = ((($acc_details[0]->AccountNumber == '') OR ($acc_details[0]->AccountNumber == NULL))? '': $acc_details[0]->AccountNumber);
			   
				$data[] = $row;
			}
				return $data;			
		}
		else
		{
			return array();
		}	
	} 
        
	public function get_remaining_account()
	{
		$bank_account_id    = $this->input->post("id");
		$this->db->select('*');
		$this->db->where('bank_account_id !=', $bank_account_id);
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_bank_account_details");
		//echo $this->db->last_query();die;
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	} 
	
	public function save_initiate_transfer()
	{
		//echo "<pre>";print_r($_POST);die;
		$userid= $this->session->userdata('id');
		$auction_id = $this->input->post('auction_id');
		$payment_type = $this->input->post('payment_type');
		$remitter_account = $this->input->post('remitter_account');

		$this->db->where('bank_account_id',$remitter_account);
		$this->db->where('status',1);
		$bQry = $this->db->get('tbl_bank_account_details');
		$bRow = $bQry->result();
		$account_holder_name = $bRow[0]->account_holder_name;
		$bank_name = $bRow[0]->bank_name;
		$ifsc_code = $bRow[0]->ifsc_code;
		$account_number = $bRow[0]->account_number;

		$cheque_no = $this->input->post('cheque_no');
		$cheq_date = $this->input->post('cheq_date');

		$bidder_id = $this->input->post('bidder_id');
	   // echo "<pre>"; print_r($bidder_id); die;
		$receiver_account = $this->input->post('receiver_account');
		
		$receiver_name = $this->input->post('receiver_name');
		
		
		$receiver_bank_name = $this->input->post('receiver_bank_name');
		
		
		$receiver_account_no = $this->input->post('receiver_account_no');
		
		
		$receiver_ifsc_code = $this->input->post('receiver_ifsc_code');
		
		//echo "<pre>";print_r($receiver_ifsc_code);
		$amtPaidArr = $this->input->post('amt_to_be_paid');
			
		//Get Last Payorder and dispose order number
		$this->db->select('dispose_order_no, payorder_no');
		$this->db->order_by('initiate_transfer_id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get('tbl_initiate_transfer')->row();
		$payorder_no    =   $result->payorder_no;
		$dispose_order_no    =   $result->dispose_order_no;
		
		if($payorder_no =='' || $payorder_no == NULL)
		{
			$payorder_no = 'TO'.date('y')."00001";
		}
		else
		{
			$payorder_no++;
		}
		
		if($dispose_order_no =='' || $dispose_order_no == NULL)
		{
			$dispose_order_no = 'TA'.date('y')."000001";
		}
		else
		{
			$dispose_order_no++;
		}

		$amt_transferred = 0;
		//echo "<pre>";print_r($amtPaidArr);die;
		$getAmtArr = array();
		foreach($amtPaidArr as $key => $amt)
		{	
			$rnd = $this->getRandomAlphaNum(20);
			$sequence_no = 'NT'.date('y').$rnd;
			if($amt>"0.00")
			{
				$getAmtArr = $this->getAmtTransfer($bidder_id[$key],$auction_id, $amt, $payment_type[$key]);
			 
				 
			/*  
				//Get Receiver bank account details
				$this->db->select('account_holder_name, bank_name, ifsc_code, account_number');
				$this->db->where('bank_account_id', $receiver_account[$key]);
				$this->db->where('status', 1);
				$bRow = $this->db->get('tbl_bank_account_details')->row();
				//echo "<pre>"; print_r($bQry); die;
				$receiver_name = $bRow->account_holder_name;
				$receiver_bank_name = $bRow->bank_name;
				$receiver_ifsc_code = $bRow->ifsc_code;
				$receiver_account_no = $bRow->account_number;
			*/
				$tData = array(
						'bidder_id'=>$bidder_id[$key],
						'auction_id'=>$auction_id,
						'remitter_account_id'=>(int)$remitter_account,
						'remitter_account_holder_name'=>trim($account_holder_name),
						'remitter_bank_name'=>trim($bank_name),
						'remitter_ifsc_code'=>trim($ifsc_code),
						'remitter_account_no'=>trim($account_number),
						'cheque_no'=>trim($cheque_no),
						'cheque_date'=>date("Y-m-d",strtotime($cheq_date)),
						'payment_type'=> $payment_type[$key],
						'total_amt_paid'=>$getAmtArr['processAmt'],
						'amt_transferred'=>$getAmtArr['amt_transferred'],
						'amt_remaining'=>$getAmtArr['amt_remaining'],
						'amt_to_be_transferred'=>$amt,
					
						'receiver_account_id'=>$receiver_account[$key],

						'receiver_name'=>$receiver_name[$key],
						'receiver_bank_name'=>$receiver_bank_name[$key],
						'receiver_account_no'=>$receiver_account_no[$key],
						'receiver_ifsc_code'=>$receiver_ifsc_code[$key],
					
					/*  'receiver_name'=>$receiver_name,
						'receiver_bank_name'=>$receiver_bank_name,
						'receiver_account_no'=>$receiver_account_no,
						'receiver_ifsc_code'=>$receiver_ifsc_code,
					*/
					
						'status'=>1,
						'user_id'=>$userid,
						'dispose_order_no'=>$dispose_order_no,
						'sequence_no'=>$sequence_no,
						'payorder_no'=>$payorder_no
				);
					//echo "<pre>";print_r($tData);die;
					$this->db->insert('tbl_initiate_transfer',$tData);
					$initiate_transfer_id = $this->db->insert_id();
					$tData['ip'] = $_SERVER['REMOTE_ADDR'];
					$tData['initiate_transfer_id'] = $initiate_transfer_id;
					$tData['remarks'] = 'Transfer initiated successfully.';
					$this->db->insert('tbl_log_initiate_transfer',$tData);
					
					$payorder_no++;
			}
				
		}
        /*        
		echo "<pre>";
		print_r($getAmtArr);
		print_r($tData);
		die;*/
		return $dispose_order_no;
	}
	
    
    public function save_initiate_refund()
	{
            $userid     = $this->session->userdata('id');
            $auction_id = $this->input->post('auction_id');
            $remitter_account = $this->input->post('remitter_account');
            
            //Select Remitter Bank Account Details
            $this->db->where('bank_account_id',$remitter_account);
            $this->db->where('status',1);
            $bQry = $this->db->get('tbl_bank_account_details');
            $bRow = $bQry->result();
            $account_holder_name = $bRow[0]->account_holder_name;
            $bank_name = $bRow[0]->bank_name;
            $ifsc_code = $bRow[0]->ifsc_code;
            $account_number = $bRow[0]->account_number;
		
            $cheque_no = $this->input->post('cheque_no');
            $cheq_date = $this->input->post('cheq_date');

            $bidder_id = $this->input->post('bidder_id');
            
            $receiver_name = $this->input->post('receiver_name');
            $receiver_bank_name = $this->input->post('receiver_bank_name');		
            $receiver_account_no = $this->input->post('receiver_account_no');
            $receiver_ifsc_code = $this->input->post('receiver_ifsc_code');

            $amtPaidArr = $this->input->post('amt_to_be_paid');
            
            //Get Last Payorder and dispose order number
            $this->db->select('dispose_order_no, payorder_no');
            $this->db->order_by('emd_refund_id', 'DESC');
            $this->db->limit(1);
            $result = $this->db->get('tbl_emd_refund')->row();
            $payorder_no    =   $result->payorder_no;
            $dispose_order_no    =   $result->dispose_order_no;
            
            if($payorder_no =='' || $payorder_no == NULL)
            {
                $payorder_no = 'RO'.date('y')."00001";
            }
            else
            {
                $payorder_no++;
            }
            
            if($dispose_order_no =='' || $dispose_order_no == NULL)
            {
                $dispose_order_no = 'RA'.date('y')."000001";
            }
            else
            {
                $dispose_order_no++;
            }

            $amt_transferred = 0;
            //echo "<pre>";print_r($bidder_id);die;
            foreach($amtPaidArr as $key => $amt)
            {	
                $rnd = $this->getRandomAlphaNum(20);
                $sequence_no = 'MN'.date('y').$rnd;
                if($amt>"0.00")
                {
                    $getAmtArr = $this->getAmtRefund($bidder_id[$key],$auction_id, $amt);
                /*
                    //Get Bidder Account Details
                    $url = BIDDER_BANK_URL.$bidder_id[$key];
                    //$url = "http://api.jaipurjda.org/apisso/api/UserManagement/GetRefundAccountDetails?AppId=63&UserId=26886";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $accData = curl_exec($ch);
                    curl_close($ch);		

                    $response = json_decode($accData);
                    $acc_details = json_decode($response->Data); 
                    //echo "<pre>"; print_r($acc_details); die;
                    $receiver_name = ($acc_details[0]->AccountHolderName == '' || $acc_details[0]->AccountHolderName == NULL)? '': $acc_details[0]->AccountHolderName;
                    $receiver_bank_name    = ($acc_details[0]->RefundBankName == '' || $acc_details[0]->RefundBankName == NULL)? '': $acc_details[0]->RefundBankName;
                    $receiver_account_no     = ($acc_details[0]->AccountNumber == '' || $acc_details[0]->AccountNumber == NULL)? '': $acc_details[0]->AccountNumber;
                    $receiver_ifsc_code = ($acc_details[0]->RefundAccountIFSC == '' || $acc_details[0]->RefundAccountIFSC == NULL)? '': $acc_details[0]->RefundAccountIFSC;
                */
                    
                    $rData = array(
                            'bidder_id' =>$bidder_id[$key],
                            'auction_id'=>$auction_id,
                            'remitter_account_id'=>(int)$remitter_account,
                            'remitter_account_holder_name'=>trim($account_holder_name),
                            'remitter_bank_name'=>trim($bank_name),
                            'remitter_account_no'=>trim($account_number),
                            'remitter_ifsc_code'=>trim($ifsc_code),
                            'cheque_no'=>trim($cheque_no),
                            'cheque_date'=>date("Y-m-d",strtotime($cheq_date)),
                            'total_emd'=>$getAmtArr['total_emd'],
                            'refunded_emd'=>$getAmtArr['refunded_emd'],
                            'remaining_emd'=>$getAmtArr['remaining_emd'],
                            'emd_to_be_refunded'=>$amt,
                        
                            'receiver_name'=>$receiver_name[$key],
                            'receiver_bank_name'=>$receiver_bank_name[$key],
                            'receiver_account_no'=>$receiver_account_no[$key],
                            'receiver_ifsc_code'=>$receiver_ifsc_code[$key],
                         /*   
                            'receiver_name'=>$receiver_name,
                            'receiver_bank_name'=>$receiver_bank_name,
                            'receiver_account_no'=>$receiver_account_no,
                            'receiver_ifsc_code'=>$receiver_ifsc_code,
                        */
                            'status'=>1,
                            'user_id'=>$userid,
                            'dispose_order_no'=>$dispose_order_no,
                            'sequence_no'=>$sequence_no,
                            'payorder_no'=>$payorder_no,
                        );
				
                        $this->db->insert('tbl_emd_refund',$rData);
                        $emd_refund_id  = $this->db->insert_id();
                        $rData['ip']    = $_SERVER['REMOTE_ADDR'];
                        $rData['emd_refund_id'] = $emd_refund_id;
                        $rData['remarks'] = 'Refund initiated successfully.';
                        $this->db->insert('tbl_log_emd_refund',$rData);
                        
                        $payorder_no++;
                    }
                    
            }
            return $dispose_order_no;
		//echo "<pre>";print_r($tData);die;
	}
        
	public function getAmtTransfer($bidder_id, $auction_id, $amt=0,$payment_type=1)
	{
		$logArr = array('bidderID'=>$bidder_id,'auctionID'=>$auction_id,'payment_status'=>'success');
		$this->db->where($logArr);
		$lQry = $this->db->get('tbl_auction_participate_emd');
		$lRow = $lQry->result();
		$paymentResArr = json_decode($lRow[0]->payment_response);
                if($payment_type==1)
                {
                    //$processAmt = $paymentResArr->ChallanDetails[1]->Amount; // uncomment on live                
                    $processAmt = 5000;
                }
                else
                {
                    //$processAmt = $paymentResArr->ChallanDetails[0]->Amount; // uncomment on live                
                    $processAmt = $lRow[0]->amount;
                    
                }
		//$processAmt = 5000; //comment on live for testing
		
		$itArr = array('bidder_id'=>$bidder_id,'auction_id'=>$auction_id,'status'=>1, 'payment_type'=>$payment_type);
		$this->db->where($itArr);
		$itQry = $this->db->get('tbl_initiate_transfer');
		//echo $this->db->last_query();die;
		foreach($itQry->result() as $itRow)
		{
                    $amt_transferred += $itRow->amt_to_be_transferred;
		} 
                
                $amt_transferred    = $amt_transferred + $amt;
		
		$amt_remaining = $processAmt-$amt_transferred;
		
		$data['processAmt'] = $processAmt;
		$data['amt_transferred'] = $amt_transferred;
		$data['amt_remaining'] = $amt_remaining;
		return $data;
	}
        
    public function getAmtRefund($bidder_id, $auction_id, $amt=0)
	{
		$logArr = array('bidderID'=>$bidder_id,'auctionID'=>$auction_id,'payment_status'=>'success');
		$this->db->where($logArr);
		$lQry = $this->db->get('tbl_auction_participate_emd');
		$lRow = $lQry->result();
		$paymentResArr = json_decode($lRow[0]->payment_response);	
        //$emdAmt = $paymentResArr->ChallanDetails[0]->Amount;
        $emdAmt = $lRow[0]->amount;
		
		$irArr = array('bidder_id'=>$bidder_id,'auction_id'=>$auction_id,'status'=>1);
		$this->db->where($irArr);
		$irQry = $this->db->get('tbl_emd_refund');
		//echo $this->db->last_query();die;
                
                $refunded_emd = 0.00;
		foreach($irQry->result() as $irRow)
		{
                    $refunded_emd += $irRow->emd_to_be_refunded;
		} 
                
                $refunded_emd   = $refunded_emd + $amt;
		
		$remaining_emd  = $emdAmt - $refunded_emd;
		
		$data['total_emd'] = $emdAmt;
		$data['refunded_emd'] = $refunded_emd;
		$data['remaining_emd'] = $remaining_emd;
		return $data;
	}
	
	public function getRandomAlphaNum($length)
    {		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return strtoupper($randomString);
	}
	
        
    function get_initiate_refund_data($auction_id = NULL)
    {	
        $this->db->select('DISTINCT(dispose_order_no)');
        $this->db->where('auction_id', $auction_id);
        $query = $this->db->get("tbl_emd_refund");
        $data = array();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();
            //echo '<pre>'; print_r($data);die;
            return $data;
		}
    }
   
    function get_initiate_transfer_data($auction_id = NULL)
    {	
        $this->db->select('DISTINCT(dispose_order_no)');
        $this->db->where('auction_id', $auction_id);
        $query = $this->db->get("tbl_initiate_transfer");
        $data = array();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();
            //echo '<pre>'; print_r($data);die;
            return $data;
		}
    }
    
          
    function check_remainig_refund_amt()
    {	 
        $auction_id = $this->input->post('auction_id');
        $bidderIdArr = $this->input->post('bidder_id');
        $amtPaidArr = $this->input->post('amt_to_be_paid');
       // echo "<pre>"; print_r($bidderIdArr);
        //echo "<pre>"; print_r($amtPaidArr); die;
        foreach($amtPaidArr as $key => $amount)
        {
            if($amount > 0){
                $this->db->select('MIN(remaining_emd) as remaining_emd');
                $this->db->from('tbl_emd_refund');
                $this->db->where('bidder_id', $bidderIdArr[$key]);
                $this->db->where('auction_id', $auction_id);
                $rRow = $this->db->get()->row();

                if($rRow->remaining_emd != '' OR $rRow->remaining_emd != NULL)
                {
                    if($amount > $rRow->remaining_emd) 
                    {
                        return FALSE;
                    }
                } 
                else if($rRow->remaining_emd == '' OR $rRow->remaining_emd == NULL)
                {
                    $this->db->select('amount');
                    $this->db->where('bidderID', $bidderIdArr[$key]);
                    $this->db->where('auctionID', $auction_id);
                    $this->db->where('payment_status', 'success');
                    $this->db->order_by('id', "DESC");
                    $pRow = $this->db->get('tbl_auction_participate_emd')->row();
                    //if($pRow->payment_response !='' OR $pRow->payment_response != NULL)
                    {
                        //$pResp = json_decode($pRow->payment_response);
                        if($amount > $pRow->amount)
                        {
                            return FALSE;
                        }
                    }
                }
            }
        }
        return TRUE;  
    }
    
    function check_remainig_initiate_amt($payment_type)
    {	 
        $auction_id = $this->input->post('auction_id');
        $bidderIdArr = $this->input->post('bidder_id');
        $amtPaidArr = $this->input->post('amt_to_be_paid');
       // echo "<pre>"; print_r($bidderIdArr);
        //echo "<pre>"; print_r($amtPaidArr); die;
        foreach($amtPaidArr as $key => $amount)
        {
            if($amount > 0){
                $this->db->select('MIN(amt_remaining) as amt_remaining');
                $this->db->from('tbl_initiate_transfer');
                $this->db->where('bidder_id', $bidderIdArr[$key]);
                $this->db->where('payment_type', $payment_type);
                $this->db->where('auction_id', $auction_id);
                $tRow = $this->db->get()->row();

                if($tRow->amt_remaining != '' OR $tRow->amt_remaining != NULL)
                {
                    if($amount > $tRow->amt_remaining) 
                    {
                        return FALSE;
                    }
                } 
                else if($tRow->amt_remaining == '' OR $tRow->amt_remaining == NULL)
                {
                    $this->db->select('payment_response');
                    $this->db->where('bidder_id', $bidderIdArr[$key]);
                    $this->db->where('auction_id', $auction_id);
                    $this->db->where('payment_status', 'success');
                    $this->db->order_by('payment_log_id', "DESC");
                    $pRow = $this->db->get('tbl_jda_payment_log')->row();
                    if($pRow->payment_response !='' OR $pRow->payment_response != NULL)
                    {
                        $pResp = json_decode($pRow->payment_response);
                        if($amount > $pResp->ChallanDetails[1]->Amount) 
                        {
                            return FALSE;
                        }
                    }
                }
            }
        }
        return TRUE;  
    }
    
    public function getInputCreditDataByAuctionId($auctionId)
    {
            $this->db->where('auction_id',$auctionId);
            $this->db->where('status',1);		
            $qry = $this->db->get('tbl_input_credit');
            //echo $this->db->last_query();die;
            if($qry->num_rows()>0)
            {
                    foreach($qry->result() as $row)
                    {
                            $data[] = $row;
                    }	
                    //echo "<pre>";print_r($data);die;		
            }
            else
            {
                    $data = array();
            }
            return $data;
    }
	
	
	public function add_input_credit($auctionID)
	{
		$userid= $this->session->userdata('id');		
		
		$bidder_id = $this->input->post('bidder_id');
		$instrument_no = $this->input->post('instrument_no');
		$instrument_date = date("Y-m-d",strtotime($this->input->post('instrument_date')));
		$amount_paid = $this->input->post('amount_paid');		
		$remarks = $this->input->post('remarks');		
		
		
		$iData = array(			
			'auction_id'=>$auctionID,
			'bidder_id'=>$bidder_id,
			'instrument_no'=>$instrument_no,
			'instrument_date'=>$instrument_date,
			'amount_paid'=>(float)$amount_paid,
			'remarks'=>$remarks,
			'status'=>1
		);
		
		$this->db->insert('tbl_input_credit',$iData);
		$input_credit_id = $this->db->insert_id();
		$iData['ip'] = $_SERVER['REMOTE_ADDR'];
		$iData['input_credit_id'] = $input_credit_id;
		$iData['user_id'] = $userid;
		$this->db->insert('tbl_log_input_credit',$iData);
		return $input_credit_id;
		//echo "<pre>";print_r($tData);die;
	}
	
	public function getDemandNoteDataByAuctionId($auctionId)
	{
		$this->db->where('dn.auction_id',$auctionId);
		$this->db->where('dn.status',1);
		$this->db->select('*');
		$this->db->from('tbl_demand_note as dn');
		$this->db->join('tbl_property_rate_calculation as pr','pr.auction_id=dn.auction_id','left');
		$qry = $this->db->get();
		
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
			foreach($qry->result() as $row)
			{
				$data[] = $row;
			}	
			//echo "<pre>";print_r($data);die;		
		}
		else
		{
			$data = array();
		}
		return $data;
	}
	
	public function add_demand_note($auctionID)
	{
		$userid= $this->session->userdata('id');		
		$auctionData = $this->viewReport($auctionID);
		
		$bidder_id = $this->input->post('bidder_id');
		$demand_note_no = $this->input->post('demand_note_no');
		$demand_note_date = date("Y-m-d",strtotime($this->input->post('demand_note_date')));
		
		$percentage_payment = (float)$this->input->post('percentage_payment');	
		
		$this->db->select('*');
		$this->db->where('auction_id',$auctionID);
		$prQry = $this->db->get('tbl_property_rate_calculation');
		
		if($prQry->num_rows()==0) // only first time insert data
		{
			
			$total_najarana = $auctionData[0]->area * $auctionData[0]->lastbidBidder[0]->bid_value;
			
			$lease_rate = (float)$this->input->post('lease_rate');
			$lease_rate_cal = (float)($auctionData[0]->reserve_price_zone * $lease_rate)/100;		
			$lease_amount = $auctionData[0]->area * $lease_rate_cal;
			
			$bsup_rate = (float)$this->input->post('bsup_rate');		
			$bsup_amount = $auctionData[0]->area * $bsup_rate;
			
			$site_plan_charges = (float)$this->input->post('site_plan_charges');		
			
			$total_amount_payable = $total_najarana + $lease_amount + $site_plan_charges + $bsup_amount;
			
			$net_payable_amount = (float)($total_amount_payable - $auctionData[0]->emd_amt);
					
				
			$current_payment = ($net_payable_amount * $percentage_payment)/100;		
			
			$prData = array(
				'auction_id'=>$auctionID,
				'total_najarana'=>$total_najarana,
				'lease_rate'=>$lease_rate,
				'lease_amount'=>$lease_amount,
				'site_plan_charges'=>$site_plan_charges,
				'bsup_rate'=>$bsup_rate,
				'bsup_amount'=>$bsup_amount,
				'net_payable_amount'=>$net_payable_amount,
				'status'=>1
			);
			/*
			echo "<pre>";
			print_r($prData);
			echo '<br>'.$current_payment;die;
			*/
			
			$this->db->insert('tbl_property_rate_calculation',$prData);
			$property_rate_id = $this->db->insert_id();
			$iData['ip'] = $_SERVER['REMOTE_ADDR'];
			$iData['property_rate_id'] = $property_rate_id;
			$iData['user_id'] = $userid;
			$this->db->insert('tbl_log_property_rate_calculation',$prData);
		}
		else
		{
			
			$rows = $prQry->result();
			//echo "<pre>";print_r($rows);die;
			$net_payable_amount = $rows[0]->net_payable_amount;
			$current_payment = ($net_payable_amount * $percentage_payment)/100;	
		}
		
		
		$this->db->select('*');
		$this->db->where('auction_id',$auctionID);
		$this->db->where('bidder_id',$bidder_id);
		$dnQry = $this->db->get('tbl_demand_note');
		$totalPaidPercentage = 0;
		foreach($dnQry->result() as $dnRow)
		{
			$totalPaidPercentage += $dnRow->percentage_payment;
		}
		
		$totalPercentage = (float)($totalPaidPercentage+$percentage_payment);
		
		
		if($percentage_payment <= 100 && $totalPercentage <= 100)
		{
			// insert into demand note table
			$iData = array(			
				'auction_id'=>$auctionID,
				'bidder_id'=>$bidder_id,
				'demand_note_no'=>$demand_note_no,
				'demand_note_date'=>$demand_note_date,			
				'percentage_payment'=>$percentage_payment,
				'current_payment'=>$current_payment,
				'status'=>1
			);
			
			$this->db->insert('tbl_demand_note',$iData);
			$demand_note_id = $this->db->insert_id();
			$iData['ip'] = $_SERVER['REMOTE_ADDR'];
			$iData['demand_note_id'] = $demand_note_id;
			$iData['user_id'] = $userid;
			$this->db->insert('tbl_log_demand_note',$iData);
			return $input_credit_id;
			//echo "<pre>";print_r($tData);die;
		}
		else
		{
			redirect('buyer/create_demand_note/'.$auctionID);
			exit;
		}
	}
        
    public function get_all_token()
	{
            $this->db->select('token_id, token_name');
            $this->db->where('status', 1);
            $Qry = $this->db->get("tbl_tokens");
            //echo $this->db->last_query();die;
            $data = array();
            if ($Qry->num_rows() > 0) {
                foreach ($Qry->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
	}
        
    public function save_define_demand_note()
	{
            $user_id = $this->session->userdata('id');
            $auction_id = $this->input->post('auction_id');
            $demand_note_id = $this->input->post('demand_note_id');
            $content = $this->input->post('demand_note');

            $dData = array(
                    'demand_note_id'=> $demand_note_id,
                    'auction_id'    => $auction_id,
                    'user_id'       => $user_id,
                    'content'       => $content,
                    'status'        =>  1,
                    'date_created'  => date('Y-m-d H:i:s'),
            );


            $this->db->insert('tbl_demand_note_content',$dData);
            $dnote_content_id = $this->db->insert_id();
            $dData['dnote_content_id'] = $dnote_content_id;
            $dData['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $this->db->insert('tbl_log_demand_note_content',$dData);
            
            return TRUE;    
	}
        
    public function get_defined_note_data($auction_id, $demand_note_id)
	{       
            $this->db->select('content');
            $this->db->where('demand_note_id', $demand_note_id);
            $this->db->where('auction_id', $auction_id);
            $this->db->where('status', 1);
            $Result = $this->db->get("tbl_demand_note_content")->row();

            if ($Result->content != '') {
                return $Result->content;
            }
            return false;
	}
	
	 public function get_all_remitter_account() {
        $this->db->select('bank_account_id, account_nick_name, account_holder_name, bank_name, ifsc_code, account_number');
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_bank_account_details");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function get_remitter_account_by_id() {
        $bank_account_id    = $this->input->post("id");
        $this->db->select('account_holder_name, bank_name, ifsc_code, account_number');
        $this->db->where('bank_account_id', $bank_account_id);
        $this->db->where('status', 1);
        $query = $this->db->get("tbl_bank_account_details");
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
}

?>
