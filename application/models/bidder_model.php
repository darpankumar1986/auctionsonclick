<?php
class Bidder_model extends CI_Model {
	
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	function liveUpcomingAuctionsdatatable()
    {
        
        $this->datatables->select("ea.id,tb.logopath,tb.name,tp.product_description, ea.auction_start_date,ea.auction_end_date,ea.status",false)
        ->unset_column('ea.id')->add_column('Actions',"<a href='/bidder/eventTrack/$1' class='b_action '>Track</a> <a href='/bidder/viewAuctionDetail/$1' class='auction_detail_iframe b_action '>View </a> <a href='javascript:void(0)' class='b_action' onClick='return actionFavAuction($1,\"add\")'><img src='/images/favAdd.png' /></a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_auction_bidder_fav as tabf',' ea.id=tabf.auctionID AND tabf.bidderID =2 AND tabf.is_fav !=1','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_product tp','ea.id=tp.auctionID','left')
		->where('ea.status',1);
        return $this->datatables->generate();
    }
	function favLiveUpcomingAuctionsdatatable(){
        
        $this->datatables->select("ea.id,tb.logopath,tb.name,tp.product_description, ea.auction_start_date,ea.auction_end_date,  ea.status",false)
        ->unset_column('ea.id')		   
		->add_column('Actions',"<a href='/bidder/eventTrack/$1' class='b_action'>Track</a> <a href='/bidder/viewAuctionDetail/$1' class='auction_detail_iframe1 b_action' >View </a>  <a href='javascript:void(0)' class='b_action' onClick='return actionFavAuction($1,\"remove\")'><img src='/images/favRemove.png' /></a>", 'ea.id')
		->from('tbl_auction_bidder_fav tabf')
                ->join('tbl_auction as ea','ea.id=tabf.auctionID','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_product tp','ea.id=tp.auctionID','left ')
		->where('ea.status',1)
		->where('tabf.is_fav',1);
        return $this->datatables->generate();
    }
	function concludedAuctionsdatatable(){
          $this->datatables->select("ea.id,tb.logopath,tb.name,tp.product_description, ea.auction_start_date,ea.auction_end_date,  ea.status",false)
               ->unset_column('ea.id')		   
               ->add_column('Actions',"<a href='/bidder/eventTrack/$1' class='b_action'>Track</a>", 'ea.id')
               ->from('tbl_auction as ea')
               ->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
               ->join('tbl_product tp','ea.id=tp.auctionID','left ')
               ->where('ea.status',7);
        return $this->datatables->generate();
    }
	function actionFavAuction(){
        
                $action 		=	 $this->input->post('action');
		$auctionID 		=	 $this->input->post('auctionID');
		$bidderID		=        $this->session->userdata('id');
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$this->db->where('is_fav', 1);
		$query = $this->db->get("tbl_auction_bidder_fav");
	    if($query->num_rows() == 0){
                if($action =='add'){
                $data = array(  'auctionID'=>$auctionID,
                                'bidderID'=>$bidderID,
                                'is_fav'=>1,
                                'indate'=>date('Y-m-d H:i:s'));
                $this->db->insert('tbl_auction_bidder_fav',$data);	
                 }
		}
	   if($action =='remove'){
                $this->db->where('auctionID', $auctionID);
                $this->db->where('bidderID', $bidderID);
                $this->db->where('is_fav', 1);
                $this->db->update('tbl_auction_bidder_fav', array('is_fav'=>0)); 
            }
		return true;
    }
    
    function auction_user_live_log_insert($auctionID,$bidderID='')
    {
		
		$data = array('auctionid'=>$auctionID,
                                'userid'=>$bidderID,
                                'ip'=>$_SERVER['REMOTE_ADDR'],
                                'time'=>date('Y-m-d H:i:s'));
           $success =  $this->db->insert('tbl_auction_user_live_log',$data);	
           if($success){
				return true;
			}else{
					return false;
			}
                 
            
                 
	}
	
	function eventTrackData($auctionID,$bidderID='')
    {	
		//	$this->db->where('stageID =', 5);
		$this->db->where('status !=', 5);
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");
		$data  = array();
		if ($query->num_rows() > 0) {
			$data=$query->result();			
			/***** count no. of bidder*****/
			//$this->db->select('count(id) as bider_total');
			$this->db->where('auctionID ', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$query = $this->db->get("tbl_auction_participate");
			$bidder_participation_detail=$query->result();
			$data[0]->bidder_participation_detail=$bidder_participation_detail;
			/***** count no. of bidder*****/
			return $data;
		}
		return false;
    }
    function eventTrackCurrentStage($status,$bid_last_date,$auction_start_date,$auction_end_date,$second_opener,$bidder_id,$bidder_status,$bidder_operner1_accepted,$bidder_operner2_accepted)
    {
		$date=@date('Y-m-d h:m:i');
		if(!$bidder_id)
		{
			return 'tc';
		}
		elseif($bidder_status==2)
		{
			return 'participate';
		}
		elseif( $date<=$bid_last_date)
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'accepted';
			 else
				return 'openning';
			}else{
			 if($bidder_operner1_accepted)
				return 'accepted';
			 else
				return 'openning';
			}
		}
		
		elseif( $auction_start_date<=$date and $auction_end_date>=$date )
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'liveauction';
			 else
				return 'auction';
			}
			else
			{
			 if($bidder_operner1_accepted)
				return 'liveauction';
			 else
				return 'auction';
			}
		 }
		elseif( $auction_end_date<$date )
		{
			if($second_opener)
			{
			 if($bidder_operner2_accepted)
				return 'viewreport';
			 else
				return 'report';
			}
			else
			{
			 if($bidder_operner1_accepted)
				return 'viewreport';
			 else
				return 'report';
			}
		}
		return 'tc';
	}
	function tcAccept()
	{
		$auctionID 	= $this->input->post('auctionID');
		$bidderID	= $this->session->userdata('id');
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query = $this->db->get("tbl_auction_participate");
		if($query->num_rows() == 0)
		{
				$data = array(
						'auctionID'=>$auctionID,
						'bidderID'=>$bidderID,
						'is_accept_tc'=>1,
						'participate_by'=>'bidder',
						'status'=>2,
						'indate'=>date('Y-m-d H:i:s'));
				$this->db->insert('tbl_auction_participate',$data);	
			
		}
		else
		{
			$this->db->where('auctionID', $auctionID);
			$this->db->where('bidderID', $bidderID);
			$this->db->update('tbl_auction_participate', array('is_accept_tc'=>1)); 
		}
		return true;
	}
	function viewAuctionDetailPopupData($auctionID)
	{       $this->db->select('ta.*,tp.product_description');
		$this->db->from("tbl_auction as ta");
		$this->db->join("tbl_product as tp",'ta.id=tp.auctionID','left ');
		$query_auction = $this->db->get();
	return $query_auction->result();
	}
	

function getBidderAuctionRank($auctionID){
		$bidderID		=	 $this->session->userdata['id'];
		$query=$this->db->query("SELECT id,bidderID, max(bid_value) FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."'  GROUP BY bidderID ORDER BY MAX(bid_value) DESC");
		//$this->db->last_query();
		$data=$query->num_rows();
		if($data>0){
			$dataarr=array();
			$i=1;
			 foreach ($query->result() as $row) {
                          $dataarr[$i] = $row;
                                   $i++;
                            }
			//print_r($dataarr);
			 //$key = array_search($bidderID, array_column($dataarr, 'bidderID'));
			 if(count($dataarr)>0){
				 foreach($dataarr as $key=>$val){
					 if($val->bidderID==$bidderID){
						 $rank=$key;
					 } 
				 }
			 }
			return  $rank;
		}
		return false;
	
}	

function saveLiveauctionBid(){
   // print_r($_POST);
	$bidValue 		=	 $this->input->post('bidValue');
	$auctionID 		=	 $this->input->post('auctionID');
	$bidderID		=	 $this->session->userdata['id'];
	$current_date	=	 date('Y-m-d H:i:s');
	$arow	= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
	$auto_extension_time	=	$arow->auto_extension_time;
	$no_of_auto_extn		=	$arow->no_of_auto_extn;
	$auction_end_date		=	$arow->auction_end_date;
	$added_autoextension_time		=	$arow->added_autoextension_time;
	$remaintime=findRemainTime($auction_end_date,$current_date);
	$rday		=	$remaintime['days'];
	$rhours		=	$remaintime['hours'];
	$rminute	=	$remaintime['minute'];
	
	
	if(strtotime($auction_end_date) >= time())
	{
			
		/*AutoExtend Time increment start*/
		//if($no_of_auto_extn > 0  && $auto_extension_time > 0)
		if(!($auto_extension_time > 0) && false)
		{
			$auto_extension_time = 5;
			$time_add = AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END;
		}
		else
		{
			$time_add = $auto_extension_time;
		}
                
                
		if($auto_extension_time > 0)
		{		
                    
                    if($rday==0 && $rhours ==0 && $rminute < $time_add && ($added_autoextension_time < $no_of_auto_extn || !($no_of_auto_extn > 0)))
                    {
                        
                        $time_original 		= 	strtotime($auction_end_date);
                        //$extendedtime_add   	= 	$time_original + ($auto_extension_time*60);
                        
                        //Start:Extend time exact till 5 minuts 
                        //$extendedtime_add   	= 	$time_original + (strtotime($current_date)+5*60)- $time_original;
                        //$extendedtime_add   	= 	strtotime($current_date) + 5*60;
                        //End:Extend time exact till 5 minuts
                        
                        $extendedtime_add   	= 	strtotime($current_date) + $auto_extension_time*60;
                        
                        
                        
                        $new_date      		= 	date("Y-m-d : H:i:s", $extendedtime_add);
                        $added_autoextension_time	=	$added_autoextension_time+1;
                        $data = array('auction_end_date'=>$new_date, 'added_autoextension_time'=>$added_autoextension_time);	
                        $this->db->where('id', $auctionID);
                        $this->db->update('tbl_auction',$data); 
                        //echo $this->db->last_query();
                    }
		}	
		
		/*AutoExtend Time increment start*/
		$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
		$msg			=	'bid has been successfully submitted';
		$bid_type		=	'Manual';
		$ip				=	$_SERVER["REMOTE_ADDR"];
		$date=date('Y-m-d H:i:s');	
		$microtime = microtime(true);
		$microSeconds = sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
		$data=array(
					'auctionID'=>$auctionID,
					'bidderID'=>$bidderID,
					'bid_value'=>$bidValue,
					'bid_type'=>$bid_type,
					'alias_name'=>$alaise_name,
					'message'=>$msg,
					'ip'=>$ip,
					'indate'=>$date,
					'modified_date'=>$date.".".$microSeconds
					);
		$this->db->insert('tbl_live_auction_bid',$data); 
		//echo $this->db->last_query();
		$id = $this->db->insert_id();
		if($id>0){
			$this->autoBidIncrementAuctionBid($auctionID);
			return $id;
		}
	}
			
}
	
	function saveLiveauctionBidInvalid($msg = ""){
   
			$bidValue 		=	 $this->input->post('bidValue');
			$auctionID 		=	 $this->input->post('auctionID');
			$bidderID		=	 $this->session->userdata['id'];
			$current_date	=	 date('Y-m-d H:i:s');
			$arow	= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);			
			$auction_end_date		=	$arow->auction_end_date;
			
			
			
			if(strtotime($arow->auction_end_date) >= time())
			{
				$this->session->set_userdata('response_msg_'.$auctionID,$msg);
				
				$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
				//$msg			=	'bid has been successfully submitted';
				$bid_type		=	'Manual';
				$ip				=	$_SERVER["REMOTE_ADDR"];
				$date=date('Y-m-d H:i:s');	
				$microtime = microtime(true);
				$microSeconds = sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
				$data=array(
							'auctionID'=>$auctionID,
							'bidderID'=>$bidderID,
							'bid_value'=>$bidValue,
							'bid_type'=>$bid_type,
							'alias_name'=>$alaise_name,
							'message'=>$msg,
							'ip'=>$ip,
							'indate'=>$date,
							'modified_date'=>$date.".".$microSeconds
							);
				$this->db->insert('tbl_live_auction_bid_invalid',$data); 
				//echo $this->db->last_query();
				$id = $this->db->insert_id();	
			}
			
	}
	
	function saveBidderAutoCutOffWhenBidEqual()
	{
		$bidValue 		=	 $this->input->post('bidValue');
		$auctionID 		=	 $this->input->post('auctionID');
		$autobidderValue=	$this->getAutocutBidderdata($auctionID);
		$bidderID		=	$autobidderValue->bidderID;
		$current_date	=	 date('Y-m-d H:i:s');
		$arow			= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
		$auto_extension_time	=	$arow->auto_extension_time;
		$no_of_auto_extn		=	$arow->no_of_auto_extn;
		$auction_end_date		=	$arow->auction_end_date;
		$added_autoextension_time		=	$arow->added_autoextension_time;
		$remaintime=findRemainTime($auction_end_date,$current_date);
		$rday		=	$remaintime['days'];
		$rhours		=	$remaintime['hours'];
		$rminute	=	$remaintime['minute'];
		$time_add	=	AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END;		
		/*AutoExtend Time increment start*/
		if($no_of_auto_extn > 0  && $auto_extension_time > 0)
		{			
			if($rday==0 && $rhours ==0 && $rminute < $time_add && $added_autoextension_time	< $no_of_auto_extn)
					{
						$time_original 				= 	strtotime($auction_end_date);
						$extendedtime_add   		= 	$time_original + ($auto_extension_time*60); 
						$new_date      				= 	date("Y-m-d : H:i:s", $extendedtime_add);
						$added_autoextension_time	=	$added_autoextension_time+1;
						$data = array('auction_end_date'=>$new_date, 'added_autoextension_time'=>$added_autoextension_time);	
						$this->db->where('id', $auctionID);
						$this->db->update('tbl_auction',$data); 
						
					}
		}	
				
				$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
				$msg			=	'bid has been successfully submitted';
				$bid_type		=	'Auto';
				$ip				=	$_SERVER["REMOTE_ADDR"];
				$date=date('Y-m-d H:i:s');	
				$microtime = microtime(true);
				$microSeconds = sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
				$data=array(
							'auctionID'=>$auctionID,
							'bidderID'=>$bidderID,
							'bid_value'=>$bidValue,
							'bid_type'=>$bid_type,
							'alias_name'=>$alaise_name,
							'message'=>$msg,
							'ip'=>$ip,
							'indate'=>$date,
							'modified_date'=>$date.".".$microSeconds
							);
				$this->db->insert('tbl_live_auction_bid',$data);
				//disable bidder Auto bid
				$id = $this->db->insert_id();
				if($id){
					$updata=array('autobid_status'=>0);
					$this->db->where('auctionID',$auctionID);
					$this->db->where('autobid_status','1');
					$this->db->where('bidderID',$bidderID);
					$this->db->update('tbl_live_auction_bid',$updata); 
					return $id;
				}
				
		return true;	
	}
	
	function saveBidderAutoCutOffWhenBidEqual2()
	{
		$bidValue 		=	 $this->input->post('auto_bid');
		$auctionID 		=	 $this->input->post('auctionID');
		$autobidderValue        =	$this->getAutocutBidderdata($auctionID);
		$bidderID		=	$autobidderValue->bidderID;
		/*AutoExtend Time increment start*/
                $alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
                $msg			=	'bid has been successfully submitted';
                $bid_type		=	'Auto';
                $ip			=$_SERVER["REMOTE_ADDR"];
                $date=date('Y-m-d H:i:s');	
                $microtime = microtime(true);
				$microSeconds = sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
                $data=array(
                        'auctionID'=>$auctionID,
                        'bidderID'=>$bidderID,
                        'bid_value'=>$bidValue,
                        'bid_type'=>$bid_type,
                        'alias_name'=>$alaise_name,
                        'message'=>$msg,
                        'ip'=>$ip,
                        'indate'=>$date,
                        'modified_date'=>$date.".".$microSeconds
                         );
                $this->db->insert('tbl_live_auction_bid',$data);
                $id = $this->db->insert_id();
                if($id){
                $updata=array('autobid_status'=>0);
                $this->db->where('auctionID',$auctionID);
                $this->db->where('autobid_status','1');
                $this->db->where('bidderID',$bidderID);
                $this->db->update('tbl_live_auction_bid',$updata); 
                return $id;
				}
				
		return true;	
	}
	
	function saveAutoCutOffLiveauctionBid_BidLessThenMaxBid(){
		//echo "Value is less then";
		$auto_bid 		=	 $this->input->post('auto_bid');
		$auctionID 		=	 $this->input->post('auctionID');
		$bidderID		=	 $this->session->userdata['id'];		
			
		$current_date	=	 date('Y-m-d H:i:s');
		$arow	= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
		$auto_extension_time	=	$arow->auto_extension_time;
		$no_of_auto_extn		=	$arow->no_of_auto_extn;
		$auction_end_date		=	$arow->auction_end_date;
		$added_autoextension_time		=	$arow->added_autoextension_time;
		$remaintime=findRemainTime($auction_end_date,$current_date);
		$rday		=	$remaintime['days'];
		$rhours		=	$remaintime['hours'];
		$rminute	=	$remaintime['minute'];
		$time_add	=	AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END;
		
		if(strtotime($auction_end_date) >= time())
		{
				
			/*AutoExtend Time increment start*/
			//if($no_of_auto_extn > 0  && $auto_extension_time > 0)
			if(!($auto_extension_time > 0))
			{
				$auto_extension_time = 5;
			}
			if($auto_extension_time > 0)
			{			
						if($rday==0 && $rhours ==0 && $rminute < $time_add && ($added_autoextension_time < $no_of_auto_extn || !($no_of_auto_extn > 0)))
						{
							$time_original 		= 	strtotime($auction_end_date);
							//$extendedtime_add   	= 	$time_original + ($auto_extension_time*60);
							//Extend time exact till 5 minuts 
							//$extendedtime_add   	= 	$time_original + (strtotime($current_date)+5*60)- $time_original;
							$extendedtime_add   	= 	strtotime($current_date) + 5*60;
							$new_date      		= 	date("Y-m-d : H:i:s", $extendedtime_add);
							$added_autoextension_time	=	$added_autoextension_time+1;
							$data = array('auction_end_date'=>$new_date, 'added_autoextension_time'=>$added_autoextension_time);	
							$this->db->where('id', $auctionID);
							$this->db->update('tbl_auction',$data); 
							//echo $this->db->last_query();
						}
			}	
			
			/*AutoExtend Time increment start*/
			$msg			=	'bid has been successfully submitted';
			$manualValue	=	$auto_bid;

			$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
			$ip				=	 $_SERVER["REMOTE_ADDR"];
			$bid_type		=	'Manual';
			$date			=	date('Y-m-d H:i:s');	
			$microtime 		= 	microtime(true);
			$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
			$data			=	array(
							'auctionID'=>$auctionID,
							'bidderID'=>$bidderID,
							'auto_bid'=>$auto_bid,
							'bid_type'=>$bid_type,
							'bid_value'=>$manualValue,
							'alias_name'=>$alaise_name,
							'message'=>$msg,
							'autobid_status'=>1,
							'ip'=>$ip,
							'indate'=>$date,
							'modified_date'=>$date.".".$microSeconds
							);
			$this->db->insert('tbl_live_auction_bid',$data); 
			$id = $this->db->insert_id();
			if($id>0){
							$this->autoBidIncrementAuctionBidforAutoBid($auctionID,$bidderID);
							//$this->autoBidIncrementAuctionBid($auctionID);
							$updata=array('autobid_status'=>0);
							$this->db->where('auctionID',$auctionID);
							$this->db->where('autobid_status','1');
							$this->db->where('bidderID',$bidderID);
							$this->db->update('tbl_live_auction_bid',$updata);
			   return $id; 
			}
		}
							
	}
	function saveAutoCutOffLiveauctionBid_BidGreaterThenMaxBid(){
		
		$auto_bid 		=	 $this->input->post('auto_bid');
		$auctionID 		=	 $this->input->post('auctionID');
		$bidderID		=	 $this->session->userdata['id'];
		
		$current_date	=	 date('Y-m-d H:i:s');
		$arow	= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
		$auto_extension_time	=	$arow->auto_extension_time;
		$no_of_auto_extn		=	$arow->no_of_auto_extn;
		$auction_end_date		=	$arow->auction_end_date;
		$added_autoextension_time		=	$arow->added_autoextension_time;
		$remaintime=findRemainTime($auction_end_date,$current_date);
		$rday		=	$remaintime['days'];
		$rhours		=	$remaintime['hours'];
		$rminute	=	$remaintime['minute'];
		$time_add	=	AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END;
		
		if(strtotime($auction_end_date) >= time())
		{
			if(!($auto_extension_time > 0))
			{
				$auto_extension_time = 5;
			}
			if($auto_extension_time > 0)
			{			
				if($rday==0 && $rhours ==0 && $rminute < $time_add && ($added_autoextension_time < $no_of_auto_extn || !($no_of_auto_extn > 0)))
				{
					$time_original 		= 	strtotime($auction_end_date);
					//$extendedtime_add   	= 	$time_original + ($auto_extension_time*60);
					//Extend time exact till 5 minuts 
					//$extendedtime_add   	= 	$time_original + (strtotime($current_date)+5*60)- $time_original;
					$extendedtime_add   	= 	strtotime($current_date) + 5*60;
					$new_date      		= 	date("Y-m-d : H:i:s", $extendedtime_add);
					$added_autoextension_time	=	$added_autoextension_time+1;
					$data = array('auction_end_date'=>$new_date, 'added_autoextension_time'=>$added_autoextension_time);	
					$this->db->where('id', $auctionID);
					$this->db->update('tbl_auction',$data); 
					//echo $this->db->last_query();
				}
			}	
				
								
			$query=$this->db->query("SELECT bidderID, MAX(auto_bid)as auto_cutoff_bid  FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND  autobid_status='1' AND bidderID!='$bidderID'  GROUP BY bidderID ORDER BY id ASC");
			//echo $this->db->last_query();
					
			if($query->num_rows()>0)
			{
					foreach ($query->result() as $row) {
						
						$bidValue = $row->auto_cutoff_bid;
						//echo "<br>";
						$bidderID 	=	$row->bidderID;	
						$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
						$autobidCutOffVal 	=	$row->auto_cutoff_bid;
					
						$msg			=	'bid has been successfully submitted';
						$bid_type		=	'Auto';
						$ip				=	 $_SERVER["REMOTE_ADDR"];
						$date			=	 date('Y-m-d H:i:s');	
						$microtime 		= 	microtime(true);
						$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
							$data=array(
								'auctionID'=>$auctionID,
								'bidderID'=>$bidderID,
								'bid_value'=>$bidValue,
								'bid_type'=>$bid_type,
								'alias_name'=>$alaise_name,
								'message'=>$msg,
								'ip'=>$ip,
								'indate'=>$date,
								'modified_date'=>$date.".".$microSeconds
								);
						$this->db->insert('tbl_live_auction_bid',$data); 					
						
					
						$data=array('autobid_status'=>0);
						$this->db->where('auctionID',$auctionID);
						$this->db->where('autobid_status','1');
						$this->db->where('bidderID',$bidderID);
						$this->db->update('tbl_live_auction_bid',$data);
						
					}
			}
			
			
			$bidderID		=	 $this->session->userdata['id'];			
			$msg			=	'bid has been successfully submitted';
			$manualValue=$max_auto_bid=$this->getMaxAutocutBidderBidValue($auctionID);
			$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
			$ip				=	 $_SERVER["REMOTE_ADDR"];
			$bid_type		=	'Manual';
		    $date			=	 date('Y-m-d H:i:s');
		    $bid_inc	=	GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'bid_inc');	
		    $h1price	=	$this->getH1price($auctionID);
			$manualValue   =   ($h1price+$bid_inc);
			$microtime 		= 	microtime(true);
			$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
			
			$data			=	array(
								'auctionID'=>$auctionID,
								'bidderID'=>$bidderID,
								'auto_bid'=>$auto_bid,
								'bid_type'=>$bid_type,
								'bid_value'=>$manualValue,
								'alias_name'=>$alaise_name,
								'message'=>$msg,
								'autobid_status'=>1,
								'ip'=>$ip,
								'indate'=>$date,
								'modified_date'=>$date.".".$microSeconds
								);
			//echo "<pre>";
			//print_r($data);die;
			$this->db->insert('tbl_live_auction_bid',$data); 
			$id = $this->db->insert_id();
		if($id>0){
			
			if($manualValue >= $auto_bid)
			{
				$updata=array('autobid_status'=>0);
				$this->db->where('auctionID',$auctionID);
				$this->db->where('autobid_status','1');
				$this->db->where('bidderID',$bidderID);
				$this->db->update('tbl_live_auction_bid',$updata); 				
			}			
		 }
		 return $id;
		}
		
	}
	
	function saveAutoCutOffLiveauctionBid(){
			
		$auto_bid 		=	 $this->input->post('auto_bid');
		$manualValue 	=	 $this->input->post('manualValue');
		$auctionID 		=	 $this->input->post('auctionID');
		$bidderID		=	 $this->session->userdata['id'];
		
		$current_date	=	 date('Y-m-d H:i:s');
		$arow	= $this->helpdesk_executive_model->GetAutionRecordByAuctionId($auctionID);
		$auto_extension_time	=	$arow->auto_extension_time;
		$no_of_auto_extn		=	$arow->no_of_auto_extn;
		$auction_end_date		=	$arow->auction_end_date;
		$added_autoextension_time		=	$arow->added_autoextension_time;
		$remaintime=findRemainTime($auction_end_date,$current_date);
		$rday		=	$remaintime['days'];
		$rhours		=	$remaintime['hours'];
		$rminute	=	$remaintime['minute'];
		$time_add	=	AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END;
		
		if(strtotime($auction_end_date) >= time())
		{
			
			if(!($auto_extension_time > 0))
			{
				$auto_extension_time = 5;
			}
			if($auto_extension_time > 0)
			{	
				if($rday==0 && $rhours ==0 && $rminute < $time_add && ($added_autoextension_time < $no_of_auto_extn || !($no_of_auto_extn > 0)))
				{
					
					$time_original 		= 	strtotime($auction_end_date);
					//$extendedtime_add   	= 	$time_original + ($auto_extension_time*60);
					//Extend time exact till 5 minuts 
					//$extendedtime_add   	= 	$time_original + (strtotime($current_date)+5*60)- $time_original;
					$extendedtime_add   	= 	strtotime($current_date) + 5*60;
					$new_date      		= 	date("Y-m-d : H:i:s", $extendedtime_add);
					$added_autoextension_time	=	$added_autoextension_time+1;
					$data = array('auction_end_date'=>$new_date, 'added_autoextension_time'=>$added_autoextension_time);	
					$this->db->where('id', $auctionID);
					$this->db->update('tbl_auction',$data); 
					//echo $this->db->last_query();
				}
			}	
			
				
			$msg			=	'bid has been successfully submitted';
			$max_auto_bid   =    $this->getMaxAutocutBidderBidValue($auctionID);
			$alaise_name    =    GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
			$ip			=	 $_SERVER["REMOTE_ADDR"];
			$bid_type		=	'Manual';
		    $date			=	 date('Y-m-d H:i:s');
		    
		    $bid_inc	=	GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'bid_inc');	
		    $h1price	=	$this->getH1price($auctionID);
				
		    
		    $adata=$this->bidder_model->GetauctionRecordByauctionID($auctionID);
			
			if($h1price > 0)
			{
				$bid_value   =   ($h1price+$bid_inc);
			}
			else
			{
				
				if($adata->opening_price)
				{					
					$bid_value = $adata->opening_price+$bid_inc;
					
				}
				else
				{		
					$bid_value = $adata->reserve_price+$bid_inc;
				}
			}
		    
		    $microtime 		= 	microtime(true);
			$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
			
			$lastBidderBidValue = $this->LastBidderBidValue($auctionID);
			
			if($h1price > 0 && $lastBidderBidValue == $h1price)
			{
				$bid_value = $lastBidderBidValue;
			}
			
			
			$data			=	array(
								'auctionID'=>$auctionID,
								'bidderID'=>$bidderID,
								'auto_bid'=>$auto_bid,
								'bid_type'=>$bid_type,
								'bid_value'=>$bid_value,
								'alias_name'=>$alaise_name,
								'message'=>$msg,
								'autobid_status'=>1,
								'ip'=>$ip,
								'indate'=>$date,
								'modified_date'=>$date.".".$microSeconds
								);
		
			$this->db->insert('tbl_live_auction_bid',$data); 
			$id = $this->db->insert_id();
			
			if($id>0){
				
				if($manualValue >= $auto_bid)
				{
					$updata=array('autobid_status'=>0);
					$this->db->where('auctionID',$auctionID);
					$this->db->where('autobid_status','1');
					$this->db->where('bidderID',$bidderID);
					$this->db->update('tbl_live_auction_bid',$updata); 				
				}			
			 }
			 
			return $id;
		}
			
	}
	
	function checkAutocutBidderBidValue($auctionID){
		$bidderID		=$this->session->userdata['id'];
		$query                  =$this->db->query("SELECT id FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND bidderID='".$bidderID."' AND autobid_status='1'");
		//$this->db->last_query();
		$data=$query->num_rows();
		return $data;
	
}


	function LastBidderBidValue($auctionID){
		$bidderID		=	 $this->session->userdata['id'];
		$query=$this->db->query("SELECT MAX(bid_value) as lasthighestBid FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND bidderID='".$bidderID."'");
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {}
                $lasthighestBid = $row->lasthighestBid;
           
		}
		return $lasthighestBid;
}
	function getAutocutBidderBidValue($auctionID){
		
		$bidderID = $this->session->userdata['id'];
		$query=$this->db->query("SELECT auto_bid FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND bidderID='".$bidderID."' AND autobid_status='1' order by id DESC limit 1");
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
                $data = $row;	
            }
		}
		return $data;
}

	function getMaxAutocutBidderBidValue($auctionID){
		$query=$this->db->query("SELECT MAX(auto_bid)as max_auto_bid FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND autobid_status='1'")->row_object();
		return $query->max_auto_bid;
}

	function getAutocutMax2BidderBidValue($auctionID){
		 $query=$this->db->query("SELECT auto_bid FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."'  AND autobid_status='1' ORDER BY auto_bid DESC limit 2");
		if($query->num_rows()>0){
			$data=array();
			foreach ($query->result() as $row) {
                         $data[] = $row;
                         }  
		         }else{
			 $data=0;
		        }
		return $data;
}

        function getAutocutBidderdata($auctionID){
                 $query=$this->db->query("SELECT auto_bid, bidderID FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."'  AND autobid_status='1' ORDER BY auto_bid DESC limit 1")->row_object();
                 return $query;
        }

        function getH1price($auctionID){
	 $MaxAutoBid=$this->getAutocutMax2BidderBidValue($auctionID);
	  if(count($MaxAutoBid)>1){
		//$MaxAutoBid[0]->auto_bid;
		$nextH1=$MaxAutoBid[1]->auto_bid;
		$h1price=$nextH1;
	    }else{
		$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
		$lastbid=$lastbidArr->bid_value;
	    if($lastbid>0){
		$h1price=$lastbid;	
	    }else{
                $opening_price	=GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'opening_price');
                $h1price=$adata->opening_price;		
	    }
	}
	return $h1price;	
        }


function getAutoBidH1price($auctionID){
	$MaxAutoBid=$this->getAutocutMax2BidderBidValue($auctionID);
	if(count($MaxAutoBid)>1){
		//$MaxAutoBid[0]->auto_bid;
		$nextH1=$MaxAutoBid[1]->auto_bid;
		$h1price=$nextH1;
	}else{
		$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
		$lastbid=$lastbidArr->bid_value;
		if($lastbid>0){
			$h1price=$lastbid;	
		}else{
			$opening_price	=GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'opening_price');
			$h1price=$adata->opening_price;		
		}
	}
	return $h1price;	
      }

function autoBidIncrementAuctionBid($auctionID){

	$query=$this->db->query("SELECT bidderID, MAX(auto_bid)as auto_cutoff_bid  FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND  autobid_status='1' GROUP BY bidderID ORDER BY id ASC");
	//echo $this->db->last_query();
	if($query->num_rows()>0)
	{
			$bid_inc	=	GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'bid_inc');
			foreach ($query->result() as $row) {
				$h1price	=	$this->getH1price($auctionID);
			    $bidValue=($h1price+$bid_inc);
				$bidderID 	=	$row->bidderID;	
				$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
				$autobidCutOffVal 	=	$row->auto_cutoff_bid;
				
				$msg			=	'bid has been successfully submitted';
				$bid_type		=	'Auto';
				$ip				=	 $_SERVER["REMOTE_ADDR"];
				$date			=	 date('Y-m-d H:i:s');	
				$microtime 		= 	microtime(true);
				$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
				$data=array(
					'auctionID'=>$auctionID,
					'bidderID'=>$bidderID,
					'bid_value'=>$bidValue,
					'bid_type'=>$bid_type,
					'alias_name'=>$alaise_name,
					'message'=>$msg,
					'ip'=>$ip,
					'indate'=>$date,
					'modified_date'=>$date.".".$microSeconds
					);
				if($bidValue<=$autobidCutOffVal)
				{
					$this->db->insert('tbl_live_auction_bid',$data); 
				}
				else{
					//$data['bid_value'] = $autobidCutOffVal;
					//$this->db->insert('tbl_live_auction_bid',$data); 
					
				}
				if($bidValue>=$autobidCutOffVal)
				{
					$updata=array('autobid_status'=>0);
					$this->db->where('auctionID',$auctionID);
					$this->db->where('autobid_status','1');
					$this->db->where('bidderID',$bidderID);
					$this->db->update('tbl_live_auction_bid',$updata); 
			    }
                
				
            }
	}
}
function autoBidIncrementAuctionBidforAutoBid($auctionID,$bidderID){

	$query=$this->db->query("SELECT bidderID, MAX(auto_bid)as auto_cutoff_bid  FROM tbl_live_auction_bid WHERE auctionID ='".$auctionID."' AND  autobid_status='1' AND bidderID!='$bidderID'  GROUP BY bidderID ORDER BY id ASC");
	//echo $this->db->last_query();
	if($query->num_rows()>0)
	{
			$bid_inc	=	GetTitleByField('tbl_auction', "id='".$auctionID."'" , 'bid_inc');
			foreach ($query->result() as $row) {
				//getH1 price
				$h1price	=	$this->getH1price($auctionID);
			    $bidValue=($h1price+$bid_inc);
				//echo "<br>";
				$bidderID 	=	$row->bidderID;	
				$alaise_name	=	GetTitleByField('tbl_auction_participate', "auctionID='".$auctionID."' AND bidderID='".$bidderID."'", 'alaise_name');
				$autobidCutOffVal 	=	$row->auto_cutoff_bid;
				if($bidValue <= $autobidCutOffVal)
				{
					$msg			=	'bid has been successfully submitted';
					$bid_type		=	'Auto';
					$ip				=	 $_SERVER["REMOTE_ADDR"];
					$date			=	 date('Y-m-d H:i:s');	
					$microtime 		= 	microtime(true);
					$microSeconds 	= 	sprintf("%06d", ($microtime - floor($microtime)) * 1000000);
						$data=array(
							'auctionID'=>$auctionID,
							'bidderID'=>$bidderID,
							'bid_value'=>$bidValue,
							'bid_type'=>$bid_type,
							'alias_name'=>$alaise_name,
							'message'=>$msg,
							'ip'=>$ip,
							'indate'=>$date,
							'modified_date'=>$date.".".$microSeconds
							);
					$this->db->insert('tbl_live_auction_bid',$data); 					
					
				}
				
				if($bidValue >= $autobidCutOffVal)
				{
					$data=array('autobid_status'=>0);
					$this->db->where('auctionID',$auctionID);
					$this->db->where('autobid_status','1');
					$this->db->where('bidderID',$bidderID);
					$this->db->update('tbl_live_auction_bid',$data);
				}
            }
	}
}
function getBiddersLiveAuctionList(){
		$currentdate=date("Y-m-d:h:i:s");
		$bidderID		=	 $this->session->userdata['id'];
		$query=$this->db->query("SELECT a.*, p.bidderID,p.auctionID FROM tbl_auction as a INNER JOIN tbl_auction_participate as p ON a.id=p.auctionID WHERE a.auction_start_date <='$currentdate' AND a.auction_end_date >= '$currentdate' AND p.bidderID='".$bidderID."'");
		$this->db->last_query();
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
	
function saveFrqParticipate(){
	
	
		$bidderid					=	 $this->session->userdata['id'];
		$auction_participateID		=	$this->input->post('auction_participateID');
		$auction_participateFRQID	=	$this->input->post('auction_participateFRQID');
		$quote_price				=	$this->input->post('quote_price');
		$documents_paid				=	$this->input->post('documents_paid');
		$emd_paid					=	$this->input->post('emd_paid');
		$tender_paid				=	$this->input->post('tender_paid');
		$auction_id					=	$this->input->post('auction_id');
		$alaise_name				=	$this->input->post('alaise_name');
		$bidderid					=	$bidderid;
		$fSave						=	$this->input->post('fSave');
		$created_by					=	$this->session->userdata['id'];
		$indate						=	date("Y-m-d H:i:s");
		$Save						=	$this->input->post('Save');
		if($Save=='Submit'){
			$final_submit=0;
		}else{
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
				if($auction_participateFRQID){
					$this->db->where('id',$auction_participateFRQID);	
					$this->db->update('tbl_auction_participate_frq',$datafrq);
				}else{
					$this->db->insert('tbl_auction_participate_frq',$datafrq);
					$frqInsertedID = $this->db->insert_id();
				}
				//echo $this->db->last_query();
				//die;
			$frq=1;
		}else{
			$frq=0;	
		}				
			
		// Insert Final submit  FRQ DATA
		
		if($alaise_name)
		{
		$alaise_name=$alaise_name;	
		}else{
		$alaise_name=$this->alias_name(8);	
		}
		$data 	= array('tender_fee'=>$tender_paid,
						'emd'=>$emd_paid,
						'frq'=>$frq,
						'documents'=>$documents_paid,
						'final_submit'=>$final_submit,
						'auctionID'=>$auction_id,
						'alaise_name'=>$alaise_name,
						'status'=>1,
						'bidderID'=>$bidderid,
						'added_type'=>'bidder',
						'addby'=>$created_by);
						
	//	if($auction_participateID)
	//	{
		
			$data['modify_date']=$indate;
			$this->db->where('bidderID',$bidderid);
			$this->db->where('auctionID',$auction_id);
			$this->db->update('tbl_auction_participate',$data);	
			$insertedid_id	=1;		
		/*
		}else{
			$data['indate']=$indate;
			$this->db->insert('tbl_auction_participate',$data);				
			$insertedid_id = $this->db->insert_id();			
		}*/				
return $insertedid_id;		
}

function alias_name($chars = 8) {
   $letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    return strtoupper(substr(str_shuffle($letters), 0, $chars));
}

public function GetauctionRecordByauctionID($aid){           
            $this->db->where('id', $aid);
            $query = $this->db->get("tbl_auction")->row_object();
            return $query;
        }

	
}

?>
