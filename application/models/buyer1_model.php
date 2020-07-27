<?php
class Buyer1_model extends CI_Model {
	
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
		 $bank_id= $this->session->userdata('bank_id');
		 $branch_id= $this->session->userdata('branch_id');
		 $user_type_ses= $this->session->userdata('user_type');

               // $this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.auction_start_date,ea.reserve_price,  '%complete'",false)
                $this->datatables->select("ea.id,ea.reference_no,UCASE(ea.event_type) as type, tp.product_description, ea.auction_start_date,ea.reserve_price,ea.dsc_enabled",false)
               // ->unset_column('ea.id')		   
		->add_column('Actions',"<a href='/buyerApprover/eventTrack/$1' class='b_action'>Track</a>", 'ea.id')
                ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->where('ea.approvalStatus',1)
		->where('ea.status',0);
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			/*$this->db->where('ea.bank_id',$bank_id);
			$this->db->where('ea.branch_id',$branch_id);*/
		}
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
	//liveUpcomingAuctionsdatatable
	function liveUpcomingAuctionsdatatable()
    {
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
		
		//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, SUBSTRING(tp.product_description,1,100), ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id)  as total_bidder",false)
	        //$this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, SUBSTRING(tp.product_description,1,100), ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id)  as total_bidder",false)
	        $this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' and ( tbl_auction_participate.operner2_accepted = '1' OR (tbl_auction_participate.operner2_accepted IS NULL and tbl_auction_participate.operner1_accepted = '1') ))   as total_bidder,ea.dsc_enabled",false)
	        //->unset_column('ea.id')	   
		//->add_column('Actions',"<a href='/buyer1/eventTrack/$1' class='b_action'>Approve</a>  <a href='/buyer1/createCorrigendum/$1' class='b_action'>Corrigendum</a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left ')
		//->where('((NOW() >= ea.auction_start_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.auction_start_date)) OR (ea.open_price_bid = 1))')  // Changed as discussed with saurabh
		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.open_price_bid = 1 AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))') MAIN

		//->where('((NOW() >= ea.bid_opening_date AND NOW()<= ea.auction_end_date) OR  (ea.opening_price IS NOT NULL AND (NOW() >= ea.bid_opening_date)) OR (ea.open_price_bid = 1))')	
		//->where('((NOW() >= ea.bid_opening_date AND ea.auction_end_date <=NOW()  AND ea.open_price_bid = 1) )') //before
        ->where('((NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.open_price_bid = 1) )')   // //COMMENT WRONG QUERY
        // ->where('(NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.opening_price IS NOT NULL )')   // //CAN BE DONE
		
		->where('ea.status',1);
		
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		if($user_type_ses !='drt')
		{
			//$this->db->where('ea.bank_id',$bank_id);
			//$this->db->where('ea.branch_id',$branch_id);
		}
	  return $this->datatables->generate();
    }
	
    function liveEventsdatatable()
    {
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.bid_last_date,ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		$this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.bid_last_date,ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id  and tbl_auction_participate.final_submit='1'  ) as total_bidder,ea.dsc_enabled",false)
		
        //->unset_column('ea.id')		   
		//->add_column('Action',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>  <a href='/buyer/createCorrigendum/$1' class='b_action'>Corrigendum</a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left ')
		//->where('(NOW()>= ea.auction_start_date AND NOW()<= ea.auction_end_date)')
		//->where('bid_last_date')
		->where('ea.bid_last_date >= NOW()')
		->where('ea.status',1);
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
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
			$bank_id= $this->session->userdata('bank_id');
			$branch_id= $this->session->userdata('branch_id');
			
			$user_type_ses= $this->session->userdata('user_type');


			//$this->datatables->select("ea.id,ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.bid_opening_date,ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		        $this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.bid_opening_date,ea.reserve_price,  (select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' ) as total_bidder,ea.dsc_enabled",false)
			
                     //    ->unset_column('ea.id')	   
			->add_column('Actions',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>  <a href='/buyer/createCorrigendum/$1' class='b_action'>Corrigendum</a>", 'ea.id')
			->from('tbl_auction as ea')
			->join('tbl_user as tu','ea.created_by=tu.id','left ')
			->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
			->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
			->join('tbl_drt td','ea.drt_id=td.id','left ')
			->join('tbl_product tp','ea.productID=tp.id','left ')
			->where('ea.auction_start_date > NOW()')
			->where('NOW()>ea.bid_last_date')
			->where('ea.status',1)
			//->or_where('ea.stageID is NULL')
			//->where('ea.open_price_bid is NULL')
                        ->where('ea.open_price_bid',0);
                        
            //->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");                
			if($user_type_ses !='drt')
			{
				//$this->db->where('ea.bank_id',$bank_id);
				//$this->db->where('ea.branch_id',$branch_id);
			}
			//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
			return $this->datatables->generate();
    }
	
	function completedAuctionsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');
      //  $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	    $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
	         //->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
		->where('ea.auction_end_date < NOW()')
		->where('ea.status','6');
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
		
	function concludeCompletedAuctionsdatatable()
    {	
		//get bank id of logged user
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
       // $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
	$this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no,UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
	
                //->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/viewReport/$1' class='b_action'>View Report</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
		->where('ea.status ',7);
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
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
		->where("(ea.status = '6' OR ea.status = '7' OR ea.status = '3' OR ea.status = '4')");
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
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
		->where('ea.event_type','drt');
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
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
                //  $this->datatables->select("ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.auction_start_date, ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
                $this->datatables->select("ea.reference_no,UCASE(ea.event_type) as type, tp.product_description, ea.auction_start_date, ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
     
                // ->unset_column('tbr.id')	   
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>", 'ea.eventID')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->where('ea.status',0)
		->where('ea.bank_id',$bank_id)
		->where('ea.branch_id',$branch_id);
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
        return $this->datatables->generate();
    }
	
	function canceleddatatable()
    {	
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		
		$user_type_ses= $this->session->userdata('user_type');
		
       // $this->datatables->select("ea.id,tb.name, ea.reference_no, IF(ea.event_type = 'sarfaesi','SARFAESI','DRT') as type, tp.product_description, ea.reserve_price",false)
       $this->datatables->select("ea.id,tb.name, ea.reference_no,  UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price",false)
      
                //->unset_column('ea.id')		
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/buyer/eventDetailPopup/$1' class='b_action'>View</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID = tp.id','left')
		->where("(ea.status ='3' OR ea.status ='4')");
		
		//->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
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
		->add_column('Actions',"<a href='/buyer/viewCorrigendum/$1' class='corrigendum_detail_iframe'>View</a>", 'tac.id')
        ->from('tbl_auction_corrigendum as tac')
		->join('tbl_auction as ta','tac.auctionID=ta.id','left ')
		->join('tbl_product as tp','ta.id=tp.auctionID','left ');
		
		//->where("(ta.first_opener=$userid OR ta.second_opener=$userid)");
		
		
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
	
	function emdDetailPopupData($bidderID,$auctionID){
               //emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_emd");
               return $query_emd->result();
	        }
	function feeDetailPopupData($bidderID,$auctionID){
               //emd fee
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_tenderfee");
               return $query_emd->result();
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
	
	function saveFirstOpnerVerification()
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
		        if(!$second_opener){
			 $this->send_bid_acceptted_rejected_mail($bidderID[$i],$bid_acceptance[$i]);
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
		//echo '<pre>';
        //print_r($_POST);die;
		$bank_id					= 	$this->session->userdata('bank_id');
		$branch_id					= 	$this->session->userdata('branch_id');
		$created_by					=	 $this->session->userdata['id'];
		$auctionID 					=	 $this->input->post('auctionID');
		$account 					=	 $this->input->post('account');
		$reference_no 				= 	 $this->input->post('reference_no');
		$event_title 				=	 $this->input->post('event_title');
		$category_id 				=	 $this->input->post('category_id');
		$drt_id 					=	 $this->input->post('drt_id');
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
		$auction_type               =    '0'; // New Added For (Banker) Type
		$first_opener 				= $this->input->post('first_opener');// New Added
		$drtEvent 					=	 $this->input->post('drtEvent');
		$bank_name 					=	 $this->input->post('bank_name');
		$bank_branch_id 				=	 $this->input->post('bank_branch_name');
		
		$drt_user = $this->session->userdata('user_type');
		if($drt_user == 'drt')
		{	
			$bank_id = $bank_name;			
		}
		
		if($drt_user == 'drt')
		{	
			$branch_id = $bank_branch_id;			
		}
              
		/*if($auto_extension_time!='' && $auto_extension=='')
		{
			$auto_extension=100;	
		}else if($auto_extension_time>0 && $auto_extension<=0)
		{
			$auto_extension=$auto_extension;	
		}else{
			$auto_extension=$auto_extension;	
		}*/

		$press_release_date	= 	date("Y-m-d H:i:s",strtotime($press_release_date));
		if($inspection_date_from)
		{
			$inspection_date_from = date("Y-m-d H:i:s",strtotime($inspection_date_from));
		}
		if($inspection_date_to)
		{
			$inspection_date_to	= 	date("Y-m-d H:i:s",strtotime($inspection_date_to));	
		}
		$bid_last_date			= 	date("Y-m-d H:i:s",strtotime($bid_last_date));
		$bid_opening_date		= 	date("Y-m-d H:i:s",strtotime($bid_opening_date));
		$auction_start_date		= 	date("Y-m-d H:i:s",strtotime($auction_start_date));
		$auction_end_date		= 	date("Y-m-d H:i:s",strtotime($auction_end_date));
                
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
        	
		//$productID					=	GetTitleByField('tbl_product', "auctionID='".$auctionID."'", 'id');
		
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
		
		if($inspection_date_from == "" || $inspection_date_from == '0000-00-00 00:00:00' || $inspection_date_from == '1970-01-01 05:30:00')
		{
			$inspection_date_from = '0000-00-00 00:00:00';
		}
		
		if($inspection_date_to == "" || $inspection_date_to == '0000-00-00 00:00:00' || $inspection_date_to == '1970-01-01 05:30:00')
		{
			$inspection_date_to = '0000-00-00 00:00:00';
		}
		
		$data 	= array(
			//'productID'=>$productID,
			'event_type'=>$account,
			'auto_bid_cut_off'=>$auto_bid_cut_off,
			'reference_no'=>$reference_no,
			'event_title'=>$event_title,
			'category_id'=>$category_id,
			'subcategory_id'=>$subcategory_id,
			'bank_id'=>$bank_id,
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
			'related_doc'=>$related_doc,
			'image'=>$image,
			'supporting_doc'=>$supporting_doc, 
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
			'other_city'=>$other_city,
			'status'=>$status
		);
		/*$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
		$this->db->last_query();
		$insertedid_id 	=$auctionID;*/
						
		if($auctionID)
		{
			$this->db->where('id', $auctionID);
			$this->db->update('tbl_auction',$data); 
			
			$insertedid_id 	=$auctionID;
			$data['auction_id'] = $insertedid_id;
			$this->db->insert('tbl_log_auction',$data);
		}else{
			$currentdate=date('Y-m-d H:i:s');
			$data['updated_date']=$currentdate;
			$this->db->insert('tbl_auction',$data); 
			$insertedid_id = $this->db->insert_id();
			$data['auction_id'] = $insertedid_id;
			$this->db->insert('tbl_log_auction',$data);
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
		$second_opener 				=	 $this->input->post('second_opener');
		$status 					=	 $this->input->post('status');
		
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
		if($_FILES['image']['name']!='')
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
		}
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
		
		if(strtotime($auction_data[0]->bid_opening_date) < time())
		{
			$bid_opening_date = $auction_data[0]->bid_opening_date;
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
				  'old_bid_opening_date'=>$auction_data[0]->bid_opening_date,
				  'bid_opening_date'=>$bid_opening_date,
				  'old_auction_start_date'=>$auction_data[0]->auction_start_date,
				  'auction_start_date'=>$auction_start_date,
				  'old_auction_end_date'=>$auction_data[0]->auction_end_date,
				  'auction_end_date'=>$auction_end_date,
				  'old_related_doc'=>$auction_data[0]->related_doc,
				  'related_doc'=>$related_doc,
                                  'old_supporting_doc'=>$auction_data[0]->supporting_doc,
				  'supporting_doc'=>$supporting_doc,
				  'old_image'=>$old_images,
				  'image'=>$image,
				  'old_second_opener'=>$auction_data[0]->second_opener,
				  'second_opener'=>$second_opener,
				  'old_status'=>$auction_data[0]->status,
				  'status'=>$status,
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
                               if($data1['old_related_doc']!=$data1['related_doc']){
                                  $activity.='Documents,'; 
                               }
                                if($data1['old_image']!=$data1['image']){
                                  $activity.='Image,'; 
                               }
                               if($data1['status']=='3'){
                                  $activity.='Stay,'; 
                               }
                                if($data1['status']=='4'){
                                  $activity.='Cancel,'; 
                               }
                                if($data1['bid_last_date']!=''){
                                  $activity.='Bid Submission Last date,'; 
                               }
                                if($data1['bid_opening_date']!=''){
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
			if($bid_opening_date && strtotime($auction_data[0]->bid_opening_date) > time())
			$data['bid_opening_date']=$bid_opening_date;
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
		
		$user_type_ses= $this->session->userdata('user_type');
		if($user_type_ses == 'drt')
		{
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1 AND id='$aid' AND status IN('1','6')  AND (first_opener=$userid OR second_opener=$userid)");
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1 AND status IN('1','6')  AND (first_opener=$userid OR second_opener=$userid)");     
			 }           
		}
		else
		{
			//AND bank_id='$bankID' AND branch_id='$branch_id'
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1  AND id='$aid' AND status IN('1','6')  AND (first_opener=$userid OR second_opener=$userid)");
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND open_price_bid = 1  AND status IN('1','6')  AND (first_opener=$userid OR second_opener=$userid)");     
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
		$config['allowed_types'] = 'webm|flv|avi|mp4|mpg|zip|xls';
		$config['max_size'] = '100000';
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
		 $query=$this->db->query("SELECT * FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC");
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
		 $query=$this->db->query("SELECT id FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC");
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
		$this->db->select('id, event_title, event_type,eventID,bank_id,auction_start_date, auction_end_date, related_doc, first_opener, second_opener');
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
				$data_FRQbidder=array();
				
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


	/**********************  End Report     ************************/
/**********************      Report  PDF   ************************/

function viewReportPDF($auction_id)
	{
		
		
		$this->db->select('id, productID, eventID, event_title,reference_no,bank_id , event_type, press_release_date, inspection_date_from, inspection_date_to, bid_opening_date, bid_last_date, auction_start_date, auction_end_date, related_doc, first_opener, second_opener,status');
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
				$data_FRQbidder=array();
				
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
				//Auction Last Bid Details 

				$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY b.bid_value,b.indate DESC")->result_object();
				$data[0]->lastbidBidder=$lastbidBidder;
				//echo '<pre>';
				//print_r($data[0]);die;
				$this->db->where('auctionID', $data[0]->id);
				$this->db->order_by('bid_value', 'DESC');							
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
                $currentStatus = 5;
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('opening_price'=>$opening_price,'stageID'=>$currentStatus,'move_to_auction'=>1));
		$this->db->where('auction_id', $auctionID);
		$update=$this->db->update('tbl_log_auction', array('opening_price'=>$opening_price,'stageID'=>$currentStatus));
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
	
	function movetosecondopener()
	{
		$auctionID = $this->input->post('auctionID');
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('stageID'=>4));
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('stageID'=>4));
		//echo $this->db->last_query();		
		//$this->session->set_userdata('opne_popup', true);		
		return true;
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
	$query=$this->db->query("SELECT id from tbl_auction where 1 or (created_by='$bankerID' OR first_opener='$bankerID' OR second_opener='$bankerID') AND auction_type='0' AND id='$auction_id'");
	
	$totalRow=$query->num_rows();
	//echo $this->db->last_query();
	
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
					  $getFileExt = $getFileExt[1];
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
}
?>