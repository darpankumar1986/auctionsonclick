<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidder extends WS_Controller
{	
	public function __Construct()
	{
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('Datatables');
        $this->load->library('table');
        $this->load->database();
		$this->load->helper(array('form'));
		$this->load->model('bidder_model');
		$this->load->model('admin/bank_model');
		$this->load->model('helpdesk_executive_model');
		$this->load->model('banker_model');
			
		/* run auction completed script */
		$this->load->model('account_model');
		$this->account_model->completedAuctionScript();
		/* end run auction completed script */	
	}	
	
	/*Check bidder is login or not*/
	private function check_isvalidated()
	{
        if(!$this->session->userdata('id') and $this->session->userdata('user_type')=='bidder')
        {
          redirect('/registration/logout');
        }
    }
	
	public function index()
	{
		$this->dashboard();
	}		
	
	public function dashboard()
	{
		$data['heading']='Dashboard';
		$data['controller']='bidder';
		$this->bidder_header();	
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$data['leftPanel']=$this->load->view('bidder_view/bidder_LeftPanel','',true);
		$this->load->view('bidder_view/bidder_dashboard', $data);
		$this->website_footer();
	       }	
	
	function datatable(){		 
	   echo $this->helpdesk_model->datatable();
	}

	public function live_auctions()
	{
		$data['heading']='Favorite Live & Upcoming Auctions';
		$data['heading1']='Live & Upcoming Auctions';
		$data['controller']='bidder';
		$this->bidder_header();	
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$data['leftPanel']=$this->load->view('bidder_view/bidder_LeftPanel','',true);
		$this->load->view('bidder_view/bidder_liveAuctionList', $data);
		$this->website_footer();
	}
	
	function favLiveUpcomingAuctionsdatatable()
	{		 
		echo $this->bidder_model->favLiveUpcomingAuctionsdatatable();
	}
	
	function liveUpcomingAuctionsdatatable()
	{		 
		echo $this->bidder_model->liveUpcomingAuctionsdatatable();
	}
	
	function concludedAuctionsdatatable()
	{		 
		echo $this->bidder_model->concludedAuctionsdatatable();
	}
	
	function actionFavAuction()
	{		 
		echo $this->bidder_model->actionFavAuction();
	}
	
	function viewAuctionDetail($auctionID)
	{
		$data['auction_data']=$this->bidder_model->viewAuctionDetailPopupData($auctionID);
		$this->load->view('banker_view/banker_myActivityAuctionDataPreviewPopup', $data);
	}
	
	public function eventTrack($auctionID=3)
	{
		$data['heading']='Bidder Event Tracker';
		$data['controller']='bidder';
		$data['user_id']=$this->session->userdata('id');
		$data['auction_data']=$this->bidder_model->eventTrackData($auctionID,$data['user_id']);
	    $this->bidder_header();	
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$data['leftPanel']=$this->load->view('bidder_view/bidder_LeftPanel','',true);
		$this->load->view('bidder_view/bidder_eventTrack', $data);
		$this->website_footer();
	}
	
	public function live_auctions_list()
	{
		$data['heading']='Add Data';
		$this->website_header();
		echo 'event_logging';
		$this->website_footer();
	}
	
	public function completed_events()
	{
		$data['heading']='Add Data';
		$this->website_header();
		echo 'event_logging';
		$this->website_footer();
	}
	
	public function listLiveAuctions()
	{
        $data['heading']='List Live Auctions';
		$data['controller']='bidder';
		$this->bidder_header();
		$auctionData=$this->bidder_model->getBiddersLiveAuctionList();
		$data['breadcrumb']=$this->load->view('common/executive_breadcrumb',$data,true);
		$data['leftPanel']=$this->load->view('bidder_view/bidder_LeftPanel','',true);
		$data['auctionData']=$auctionData;
		$this->load->view('bidder_view/bidder_myActivityListLiveAuction', $data);
		$this->website_footer();
	}
	
	function liveBiddingAuctionsdatatable(){		 
		$data['heading']='List Live Auctions';
		$data['controller']='bidder';
		$auctionData=$this->bidder_model->getBiddersLiveAuctionList();
		$data['auctionData']=$auctionData;
		echo $this->load->view('bidder_view/live_bidding_auction_list', $data,true);
	}
	

	function tcAccepted()
	{
	    echo $this->bidder_model->tcAccept();
	}

	// Save bidders live Bid Value
	function saveLiveauctionBid()
	{
		$bidValue		=	$this->input->post('bidValue');
		$auctionID		=	$this->input->post('auctionID');
		$enteredbidtype =	$this->input->post('enteredbidtype');
		$lastbidtextval =	$this->input->post('lastbidtextval');
		$bidder_bid_inc =	$this->input->post('bidder_bid_inc');
		$calVal			=	$bidValue - $lastbidtextval;	
		$mod			=	$calVal % $bidder_bid_inc;
		$max_auto_bid   =   $this->bidder_model->getMaxAutocutBidderBidValue($auctionID);	
		$adata          =   $this->bidder_model->GetauctionRecordByauctionID($auctionID);
		$lastbidArr     =   $this->banker_model->AuctionLastBidingData($auctionID);
		
		if($lastbidArr->bid_value>0)
		{
			$lastbid=$lastbidArr->bid_value;
			$bidDBval=$adata->bid_inc+$lastbid;
		}
		else
		{
			if($adata->opening_price)
			{
				$bidDBval = $adata->opening_price+$adata->bid_inc;
			}else{
				$bidDBval = $adata->reserve_price+$adata->bid_inc;
			}
		}

		if($enteredbidtype=='opening_bid')
		{
			if($adata->auction_bidding_activity_status == 1)
			{
				$error='Auction is pause.';
				$this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue=='')
			{
				 $error='Please enter a some value to submit.';
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue<=0)
			{
				 $error='You are not allowed to enter Zero or Negative values.';
				 $this->bidder_model->saveLiveauctionBidInvalid($error); 
			}
			else if($mod>0)
			{
				 $error='Please enter valid multiple of Bid Increment.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}else if($max_auto_bid==$bidValue)
			{
				 $error='Bid not Submitted. Please submit a value higher than H1 price.';
				 $this->bidder_model->saveLiveauctionBidInvalid($error); 
			}
			else if(($bidValue<(int)$lastbidtextval) || ($bidValue<$bidDBval))
			{				 
				 $error='Bid not Submitted. Please submit a value higher than H1 price.';				 
				 $this->bidder_model->saveLiveauctionBidInvalid($error); 
			}
			else
			{
				
                $insetedID=$this->bidder_model->saveLiveauctionBid();
				if($insetedID>0)
				{
					$error= "success";
                    $this->session->set_userdata('response_msg_'.$auctionID,"Bid Submitted SuccessFully");
				}
				else
				{
					$error= "Bid not saved Please contact to server administrator ";
					$this->bidder_model->saveLiveauctionBidInvalid($error);
				}
			}
		}
		else
		{
			if($adata->auction_bidding_activity_status == 1)
			{
				$error='Auction is pause.';
				$this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue=='')
			{
				$error='Please enter a some value to submit.';
				$this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue<=0)
			{
				$error='You are not allowed to enter Zero or Negative values.'; 
				$this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($mod>0)
			{ 
                $error='Please enter valid multiple of Bid Increment.'; 
                $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($max_auto_bid==$bidValue)
			{
				 $this->bidder_model->saveBidderAutoCutOffWhenBidEqual();
				 $error='Bid not Submitted. Please submit a value higher than H1 price.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if(($bidValue<=$lastbidtextval) || ($bidValue<$bidDBval))
			{
				 $error='Bid not Submitted. Please submit a value higher than H1 price.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else
			{
				
				$insetedID=$this->bidder_model->saveLiveauctionBid();
				if($insetedID>0)
				{
					$error= "success";
                    $this->session->set_userdata('response_msg_'.$auctionID,"Bid Submitted SuccessFully");
                    $this->session->set_userdata('BID_SUBMIT',"TRUE");
				}
				else
				{
					$error= "Bid not saved Please contact to server administrator ";
					$this->bidder_model->saveLiveauctionBidInvalid($error);
				}
			}
		}
		echo $error;
	}
	
	function saveLiveauctionBidInvalid()
	{		
		$error_msg = $this->input->post('error_msg');		
		$this->bidder_model->saveLiveauctionBidInvalid($error_msg);
        $this->session->set_userdata('BID_SUBMIT',"TRUE");
	}

	// Save bidders live auto Bid Value
	function saveAutoCutOffLiveauctionBid()
	{
		$bidValue		=	$this->input->post('auto_bid');
		$auctionID		=	$this->input->post('auctionID');
		$enteredbidtype	=	$this->input->post('enteredbidtype');
		$lastbidtextval	=	$this->input->post('lastbidtextval');
		$bidder_bid_inc	=	$this->input->post('bidder_bid_inc');
		$calVal			=	$bidValue - $lastbidtextval;	
		$mod			=	$calVal % $bidder_bid_inc;
		$max_auto_bid=$this->bidder_model->getMaxAutocutBidderBidValue($auctionID);	
		$adata=$this->bidder_model->GetauctionRecordByauctionID($auctionID);
		$lastbidArr=$this->banker_model->AuctionLastBidingData($auctionID);
		if($lastbidArr->bid_value>0)
		{
			$lastbid=$lastbidArr->bid_value;
			$bidDBval=$adata->bid_inc+$lastbid;
		}
		else
		{
			if($adata->opening_price)
			{
				$bidDBval = $adata->opening_price+$adata->bid_inc;
			}
			else
			{
				$bidDBval = $adata->reserve_price+$adata->bid_inc;
			}
		}
		if($enteredbidtype=='opening_bid')
		{
			if($bidValue=='')
			{
				 $error='Please enter a some value to submit.';
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue<=0)
			{
				 $error='You are not allowed to enter Zero or Negative values.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($mod>0)
			{
				 $error='Please enter valid multiple of Bid Increment.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($max_auto_bid==$bidValue)
			{
				$error='Bid not Submitted. Please submit a value higher than H1 price.'; 
				$this->bidder_model->saveLiveauctionBidInvalid($error);
				
			}
			else if(($bidValue<$lastbidtextval) || ($bidValue<$bidDBval))
			{
				 $error='Bid not Submitted. Please submit a value higher than bid start price(BSP).'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else
			{
				
				$insetedID=$this->bidder_model->saveAutoCutOffLiveauctionBid();
				if($insetedID>0)
				{
					$error= "success";
					$this->session->set_userdata('response_msg_'.$auctionID,"Bid Submitted SuccessFully");  
					$this->session->set_userdata('BID_SUBMIT',"TRUE");
				}
				else
				{
					$error= "Bid not saved Please contact to server administrator ";
					$this->bidder_model->saveLiveauctionBidInvalid($error);
				}
				
			}
		}
		else
		{
			if($bidValue=='')
			{
				 $error='Please enter a some value to submit.';
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($bidValue<=0)
			{
				 $error='You are not allowed to enter Zero or Negative values.'; 
				 $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($mod>0)
			{
				   $error='Please enter valid multiple of Bid Increment.'; 
				   $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if($max_auto_bid==$bidValue)
			{
				$error='Bid not Submitted. Please submit a value higher than H1 price.'; 
				$this->bidder_model->saveBidderAutoCutOffWhenBidEqual2();
				$this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else if(($bidValue<=$lastbidtextval) || ($bidValue<$bidDBval))
			{
				   $error='Bid not Submitted. Please submit a value higher than H1 price.'; 
				   $this->bidder_model->saveLiveauctionBidInvalid($error);
			}
			else
			{
				 
				if(($bidValue < $max_auto_bid) && ($max_auto_bid>0))
				{
					//echo 1;die;
					$insetedID=$this->bidder_model->saveAutoCutOffLiveauctionBid_BidLessThenMaxBid();
				}
				else if(($bidValue > $max_auto_bid) && ($max_auto_bid>0))
				{	
					//echo 2;die;
					$insetedID=$this->bidder_model->saveAutoCutOffLiveauctionBid_BidGreaterThenMaxBid();
				}
				else
				{
					//echo 3;die;
					
					$insetedID=$this->bidder_model->saveAutoCutOffLiveauctionBid(); 
				}
					
				if($insetedID>0)
				{
					$error="success";
                    $this->session->set_userdata('response_msg_'.$auctionID,"Bid Submitted SuccessFully");  
                    $this->session->set_userdata('BID_SUBMIT',"TRUE");
				}
				else
				{
					$error="Bid not saved Please contact to server administrator ";
					$this->bidder_model->saveLiveauctionBidInvalid($error);
				}
			}
		}
		echo $error;
	}
	
	// bidders auction Participate  
	public function auction_participate($aid)
	{  
		$bidderid = $this->session->userdata['id'];
		$data['heading']='Participate'; 
		$this->bidder_header();
		$emd_amt=GetTitleByField('tbl_auction_participate_emd', "auctionID='".$aid."' AND bidderID='".$bidderid."'", 'id');	
		$tender_amt=GetTitleByField('tbl_auction_participate_tenderfee', "auctionID='".$aid."' AND bidderID='".$bidderid."'", 'id');
		$documents_amt=GetTitleByField('tbl_auction_participate_doc', "auctionID='".$aid."' AND bidderID='".$bidderid."'", 'id');
		
		$auction_participateID=GetTitleByField('tbl_auction_participate', "auctionID='".$aid."' AND bidderID='".$bidderid."'", 'id');
		$auction_participateFRQID=GetTitleByField('tbl_auction_participate_frq', "auctionID='".$aid."' AND bidderID='".$bidderid."'", 'id');
		$frqrow=$this->helpdesk_executive_model->GetbidderLatestFRQ($aid,$bidderid);
		$data['controller']					=	'helpdesk_executive';
		$data['executive_breadcrumb']		=	$this->load->view('common/executive_breadcrumb',$data,true);
		$data['executive_leftsidebar']		=	$this->load->view('bidder_view/bidder_LeftPanel','',true);
		$data['auction_data']				=	$this->helpdesk_executive_model->GetAutionbyId($aid);
		$data['auction_id']					=	$aid;
		$data['bidderid']					=	$bidderid;
		$data['emd_paid']					=	$emd_amt;
		$data['tender_paid']				=	$tender_amt;
		$data['documents_paid']				=	$documents_amt;
		$data['latest_frq']					=	$frqrow->frq;
		$data['auction_participateID']		=	$auction_participateID;
		$data['auction_participateFRQID']	=	$auction_participateFRQID;
        $this->load->view('bidder_view/bidder_auction_participate',$data);
		$this->website_footer();
	}
	
	// save bidders  Frq Participate  
	function saveFrqParticipate()
	{
		$auction_id		=	$this->input->post('auction_id');
		$bidderid		=	 $this->session->userdata['id'];
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quote_price', 'quote_price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('documents_paid', 'documents_paid', 'trim|required|xss_clean');
		$this->form_validation->set_rules('emd_paid', 'emd_paid', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tender_paid', 'tender_paid', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{
			
			$msg="Please Enter Require fields.!";
			$this->session->set_flashdata('message', $msg);
			redirect('/bidder/auction_participate/'.$auction_id);
		}
		else
		{
			$quote_price	=	$this->input->post('quote_price');
			$reserve_price	=	$this->input->post('reserve_price');
			if($quote_price < $reserve_price)
			{
				$msg='Quote Price should not less than Reserve Price!';	
			}
			else
			{
				$returnval	=	$this->bidder_model->saveFrqParticipate();	
				$msg='FRQ Price has been saved successfully!!';	
			}
			if($returnval>0)
			{
				$msg='Record has been saved successfully.';
			}
			else
			{
				$msg='There are some problem in form.';
			}
			$this->session->set_flashdata('message', $msg);
			redirect('/bidder/auction_participate/'.$auction_id);	
		}	
	}
}
?>
