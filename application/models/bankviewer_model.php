<?php
class Bankviewer_model extends CI_Model 
{
	
	private $apath = 'public/uploads/property_images/';
	private $event_auction = 'public/uploads/event_auction/';
	private $document_auction = 'public/uploads/document/';
	private $path = 'public/uploads/bank/';
	
    function __construct()
    {
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	
	//liveUpcomingAuctionsdatatable
	function liveUpcomingAuctionsdatatable()
    {
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$userid= $this->session->userdata('id');
		$user_type_ses= $this->session->userdata('user_type');
		
	    $this->datatables->select("ea.id,ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.auction_start_date,ea.opening_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id and tbl_auction_participate.final_submit='1' and ( tbl_auction_participate.operner2_accepted = '1' OR (tbl_auction_participate.operner2_accepted IS NULL and tbl_auction_participate.operner1_accepted = '1') ))   as total_bidder,ea.dsc_enabled",false)
	    ->unset_column('ea.id')	   
		->add_column('Actions',"<a href='/bankviewer/eventTrack/$1' class='b_action'>Track</a>", 'ea.id')
		->from('tbl_auction as ea')
		->join('tbl_assign_viewer_account as v','v.auctionID=ea.id')
		->join('tbl_user as tu','ea.created_by=tu.id','left ')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left ')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID=tp.id','left ')
        ->where('((NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.open_price_bid = 1) )')   // //COMMENT WRONG QUERY
        // ->where('(NOW() >= ea.bid_opening_date AND NOW()<=ea.auction_end_date AND ea.opening_price IS NOT NULL )')   // //CAN BE DONE
		->where('ea.status',1)		
		//->where('ea.bank_id',$bank_id)
		//->where('ea.branch_id',$branch_id)
		->where('v.status',1)
		->where("(v.userId=$userid)");
	
		return $this->datatables->generate();
    }
	
	function completedAuctionsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
		$user_type_ses= $this->session->userdata('user_type');

	    $this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no, UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price, ea.opening_price, MAX(b.bid_value) as  last_bid_value ",false)	 
        ->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_live_auction_bid as b','b.auctionID=ea.id','left')
		->where('ea.auction_end_date < NOW()')
		->where('ea.status','6')
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
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
		
		$this->datatables->select("tb.name as bank_name, ea.id, ea.reference_no,UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price,  MAX(b.frq) as  larget_frq",false)				
        ->unset_column('ea.id')	 
		->add_column('Actions',"<a href='/buyer/viewReport/$1' class='b_action'>View Report</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left')
		->join('tbl_product tp','ea.productID=tp.id','left')
		->join('tbl_auction_participate_frq as b','b.auctionID=ea.id','left')
		->where('ea.status ',7)
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		$this->db->group_by('ea.id');
        return $this->datatables->generate();
    }
	
	function completedEventsdatatable()
    {	
		$userid= $this->session->userdata('id');
		$bank_id= $this->session->userdata('bank_id');
		$branch_id= $this->session->userdata('branch_id');
                
        $this->datatables->select("ea.reference_no,UCASE(ea.event_type) as type, tp.product_description, ea.auction_start_date, ea.reserve_price,(select count(id) from tbl_auction_participate where tbl_auction_participate.auctionID= ea.id ) as total_bidder",false)
		->add_column('Actions',"<a href='/buyer/eventTrack/$1' class='b_action'>Track</a>", 'ea.eventID')
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
		
        $this->datatables->select("ea.id,tb.name, ea.reference_no,  UCASE(ea.event_type) as type, tp.product_description, ea.reserve_price",false)
		->unset_column('ea.id')		
		->add_column('Actions',"<a class='auctiondetail_iframe' href='/buyer/eventDetailPopup/$1' class='b_action'>View</a>", 'ea.id')
        ->from('tbl_auction as ea')
		->join('tbl_user as tu','ea.created_by=tu.id','left')
		->join('tbl_bank as tb','ea.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','ea.branch_id=tbr.id','left')
		->join('tbl_drt td','ea.drt_id=td.id','left ')
		->join('tbl_product tp','ea.productID = tp.id','left')
		->where("(ea.status ='3' OR ea.status ='4')")
		->where("(ea.first_opener=$userid OR ea.second_opener=$userid)");
		
        return $this->datatables->generate();
    }
	
	function getBankerCreatedAuction($auction_id)
	{
		$bankerID = $this->session->userdata('id');
		$query=$this->db->query("SELECT auctionID from  tbl_assign_viewer_account where  userId='$bankerID' AND auctionID='$auction_id' and status=1");
		$totalRow=$query->num_rows();
		if($totalRow>0)
		{
			$dataarr=array();
			 foreach ($query->result() as $row) {
                $dataarr[] = $row->auctionID;
            }
		}
		else
		{
			$dataarr=0;	
		}
		return $dataarr;
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

			/***** count no. of bidder*****/
			$this->db->select('count(id) as bider_total');
			$this->db->where('auctionID', $data[0]->id);
            $this->db->where('final_submit',1);//added by amit
			$query = $this->db->get("tbl_auction_participate");
			$bider_total=$query->result();
			$data[0]->bider_total=$bider_total[0]->bider_total;

            $this->db->select('count(id) as bider_total_new');
		    $this->db->where('auctionID', $data[0]->id);
            $this->db->where('final_submit',1);//added by amit
            $query2 = $this->db->get("tbl_auction_participate");
			$bider_total1=$query2->result();

            $data[0]->bider_total_new=$bider_total1[0]->bider_total_new;
			
			// Auction participated Bidder
			$this->db->select('count(id) as auction_bider_total');
			if($data[0]->second_opener>0)
			{
                //   $this->db->where('added_type','bidder');  //added by amit
				$this->db->where('operner2_accepted',1);	
			}
			else
			{  
                //   $this->db->where('added_type','bidder');  //added by amit
				$this->db->where('operner1_accepted',1);	
			}			 			
			$this->db->where('auctionID', $data[0]->id);
			$this->db->where('final_submit',1);//added by amit
			$aquery = $this->db->get("tbl_auction_participate");
			
			$auctionbider_total=$aquery->result();
			$data[0]->auction_bider_total=$auctionbider_total[0]->auction_bider_total;
			
			/***** count no. of bidder*****/
			
			/***** bidder detail*****/
			//$this->db->select('count(id) as bider_total');
			$this->db->where('final_submit', 1);
            //$this->db->where('added_type','bidder');   //added by amit
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
			/***** end bidder*****/
			
			/***** property desc*****/
			$this->db->select('product_description');
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
		if($this->input->post('auctionID'))
		{
			$auctionID = $this->input->post('auctionID');
		}
        //conclude logic(Needs to be clear)
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('status'=>7));
		$this->db->where('auction_id', $auctionID);
		$update=$this->db->update('tbl_log_auction', array('status'=>7)); //LOG
		if($update)
		{
			$this->db->where('auction_id', $auctionID);
			$query=$this->db->get('tbl_log_auction');
			$data['emd']=$query->result();
		   
			if(!empty($data['emd']))
			{
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
	
	function emdDetailPopupData($bidderID,$auctionID)
	{
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_emd");
        return $query_emd->result();
	}
	
	function feeDetailPopupData($bidderID,$auctionID)
	{
		$this->db->where('auctionID', $auctionID);
		$this->db->where('bidderID', $bidderID);
		$query_emd = $this->db->get("tbl_auction_participate_tenderfee");
        return $query_emd->result();
	}
	
    function trackemdDetailPopupData($data,$type,$message)
    {
		$this->db->select('eventID,bank_id');
		if($data['emd'][0]->auction_id!=null)
		{
			$auctionid=$data['emd'][0]->auction_id;
		}
		else
		{
			$auctionid=$data['emd'][0]->auctionID;
		}
		if(!empty($data['emd'][0]))
		{
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
	
	function send_bid_acceptted_rejected_mail($msg_to,$isAccepted)
	{
		$msg_role = $this->session->userdata('role_id');
		$msg_from = $this->session->userdata('id');
		if($isAccepted)
		{
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
		
		if (!$this->upload->do_upload($fieldname))
		{
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
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
    
	function sendAuctionAssingMail($reference_no,$event_title,$email_id,$productUrl,$auctionID,$bidderID)
	{
		$username	=	GetTitleByField('tbl_user_registration', "id='".$bidderID."'", 'first_name');
		$email_msg ="Hi ".ucfirst($username)." ,<br> You have selected for Close Auction '".$reference_no."-".$event_title."'<a href='".$productUrl."'>Property.</a>";
		$fromemail = "info@c1indiabankeauction.com";
		$mailsubject = $reference_no." Close Auction By C1india";
        $to = $email_id;
		$headers  = "From: $fromemail\r\n";
		$headers .= "Content-type: text/html\r\n";	
		
		mail($to, $mailsubject, $email_msg, $headers);
	}	
	
	function getBankersLiveAuctionList($aid)
	{
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
			if($aid)
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW()  AND id='$aid' AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");
			}
			else
			{
				$query=$this->db->query("SELECT * FROM tbl_auction WHERE NOW() >= bid_opening_date AND auction_start_date <= NOW() AND auction_end_date >= NOW()  AND status='1'  AND (first_opener=$userid OR second_opener=$userid)");     
			 }  
		}
		
		if($query->num_rows()>0)
		{
			$data=array();
			foreach ($query->result() as $row)
			{
				$data[]=$row;
			}
			return $data;		
		}
		else
		{
			$data=0;
			return $data;	
		}
			
	}
	
	function getBankersLiveAuction10SecondList($aid)
	{
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
			if($aid)
			{
				$query=$this->db->query("SELECT auc.* FROM tbl_auction as auc LEFT JOIN tbl_assign_viewer_account as vw ON auc.id = vw.auctionID WHERE NOW() >= auc.bid_opening_date AND auc.auction_start_date <= NOW() AND auc.auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND auc.open_price_bid = 1  AND auc.id='$aid' AND auc.status IN('1','6')  AND vw.userId=$userid AND vw.auctionID=$aid AND vw.status=1");
			}
			else
			{
				$query=$this->db->query("SELECT auc.* FROM tbl_auction as auc LEFT JOIN tbl_assign_viewer_account as vw ON auc.id = vw.auctionID WHERE NOW() >= auc.bid_opening_date AND auc.auction_start_date <= NOW() AND auc.auction_end_date >= (now() - INTERVAL ".BIDDER_AUCTION_END_MESSAGE_TIME." second ) AND auc.open_price_bid = 1  AND auc.status IN('1','6')  AND vw.userId=$userid AND vw.status=1");     
			 }  
		}
		
		if($query->num_rows()>0)
		{
			$data=array();
			foreach ($query->result() as $row)
			{
				$data[]=$row;
			}
			return $data;		
		}
		else
		{
			$data=0;
			return $data;	
		}			
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
	
	function ajaxbidActivity()
	{ 
        $pdata=array();
		$activity_type	=	$this->input->post('activity_type');
		$auctionID		=	$this->input->post('auctionID');
		$currentTime	=	date("Y-m-d H;i:s");
		$data=array();
		if($activity_type=='resume')
		{
			$pdata['message'] = 'Auction Resumed successfully';
			$pdata['status'] = 0;
			$data = array('auction_resume_time'=>$currentTime,'auction_bidding_activity_status'=>0);	
		}
		else if($activity_type=='pause')
		{
			$pdata['message']='Auction Paused successfully';
			$pdata['status']=1;
			$data = array('auction_pause_time'=>$currentTime,'auction_bidding_activity_status'=>1);		
		}
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction',$data); 
                
		$adata=$this->GetRecordByAuctionId($auctionID);
		$pdata['auctionID']=$adata->id;
		$pdata['eventID']=$adata->eventID;
		$pdata['userID']=$this->session->userdata['id'];
		$pdata['bank_id']=$adata->bank_id;
		$pdata['bid_type']=($adata->auto_bid_cut_off==0)?'Manual':'AutoBid';
		$pdata['ip']=$_SERVER['REMOTE_ADDR'];
		$pdata['indate']=$currentTime;
		$this->db->insert('tbl_log_auction_pause_resume',$pdata);
		if($activity_type=='resume')
		{
			$this->updatePousedRemainTime($auctionID);
		}	
	}

	function updatePousedRemainTime($auctionID)
	{
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

	public function GetRecordByAuctionId($eid)
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
    
    public function GetBanksData($eid)
    {
        $this->db->where('id', $eid);
        $query = $this->db->get("tbl_bank");
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

	function GetAuctionBidderHistoryData($auctionID)
	{
		$this->db->where('auctionID', $auctionID);
		$query=$this->db->query("SELECT * FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC");
		
        if ($query->num_rows() > 0) 
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
	
	function CountAuctionBidingData($auctionID)
	{
		$query=$this->db->query("SELECT id FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC");
		$data= $query->num_rows();
		return $data;
	}
	
	function CountAuctionFinalSubmitData($auctionID)
	{
		$query=$this->db->query("SELECT id FROM tbl_auction_participate WHERE auctionID ='$auctionID' and final_submit = '1' ORDER BY id DESC");
	    $data= $query->num_rows();
		return $data;
	}
	
	function AuctionLastBidingData($auctionID)
	{
		$query=$this->db->query("SELECT bid_value FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' ORDER BY id DESC limit 1");
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data = $row;
			}
		}
		else
		{
			$data = 0;
		}	
		return $data;
	}
	
	function AuctionLoggedBidderData($auctionID)
	{
	
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
        $login = 0;
        if ($query->num_rows() > 0) 
        {
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
	
	function calculateGainvalue($auctionID)
	{
		$lastAuction=$this->AuctionLastBidingData($auctionID);
		$percentag='';
		if($lastAuction!=0)
		{
			$opening_price	=	GetTitleByField('tbl_auction', "id='".$auctionID."'", 'opening_price');
			if($opening_price)
			{
				$last_bid_value=$lastAuction->bid_value;
				$grothvalue=$last_bid_value-$opening_price;
				$percentag=($grothvalue*100)/$opening_price;
				$percentag=number_format($percentag,2);
			}
		}
		else
		{
			$percentag=number_format(0,2);	
		}
		return $percentag;
	}
        
        
    /**********************    Start  myMessage     ************************/
    public function GetCITotalRecord()
    {
		$user_id = $this->session->userdata('id');
		$this->db->where('msg_to', $user_id);
		$this->db->where('msg_role =', 1);
		$this->db->where('status !=', 5);
		$this->db->where('user_type', 'banker');
		$this->db->order_by('msg_created_datetime desc');
		$query = $this->db->get("tbl_message");

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
        
    public function GetUserTotalRecord()
    {
		$user_id = $this->session->userdata('id');
		$this->db->where('msg_to', $user_id);
		$this->db->where('msg_role =', 2);
		$this->db->where('status !=', 5);
		$this->db->where('user_type', 'banker');
		$this->db->order_by('msg_created_datetime desc');
		$query = $this->db->get("tbl_message");

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
        
    public function GetTrashTotalRecord()
    {
		$this->db->where('status =', 5);
		$user_id = $this->session->userdata('id');
		$this->db->where('msg_to', $user_id);
		$this->db->where('user_type', 'banker');
		$this->db->order_by('msg_created_datetime desc');
		$query = $this->db->get("tbl_message");

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

	public function GetParentRecordsControl()
	{
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
	
	public function GetRecordById($id)
	{
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

    public function myMessage_save_message_data()
    {
		$id = $this->input->post('id');
		if($id)
		{
			$msg_role = $this->session->userdata('role_id');
			$msg_from = $this->input->post('msg_to');
			$msg_to = $this->input->post('msg_from');

		}
		else
		{
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

		$data['msg_created_datetime']=date('Y-m-d H:i:s');
		$data['msg_status']=2;
		$data['status']=1;
		$this->db->insert('tbl_message',$data); 
		$id = $this->db->insert_id();

		return true;
	}
	
	public function GetUserData()
	{
        $query = $this->db->get("tbl_user");

		$data = array();
		if ($query->num_rows() > 0){

			foreach ($query->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
    }
        
    public function myMessage_get_autocomplete()
    {
		$name = $this->input->post('name');
		$this->db->select('id, first_name, last_name, email_id');
		$this->db->where_not_in('id', $this->session->userdata('adminid'));
		$this->db->where('status',1);
		$this->db->like('first_name',$name);
		
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
    /**********************  End    myMessage     ************************/ 
    
	/**********************      Report     ************************/

	function viewReport($auction_id)
	{
		$this->db->select('id, event_title, event_type,eventID,bank_id,auction_start_date, auction_end_date, related_doc, first_opener, second_opener');
		$this->db->where('status !=', 5);
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
			return $data;
		}
		else
		{
			$data =0;
			return $data;
		}
	}

	function checkBidderIsFRQParticipate($auctionid,$bidderID)
	{
		$result=$this->db->query("select * from tbl_auction_participate_frq where auctionID='$auctionid' AND bidderID='$bidderID'")->num_rows();
		return $result;
	}
	
	function checkBidderBidIsParticipate($auctionid,$bidderID)
	{
		$result=$this->db->query("select * from tbl_live_auction_bid where auctionID='$auctionid' AND bidderID='$bidderID'")->num_rows();
		return $result;
	}
	/**********************  End Report     ************************/
	/**********************      Report  PDF   ************************/

	function viewReportPDF($auction_id)
	{	
		$this->db->select('id, productID, eventID, event_title,reference_no,bank_id , event_type, press_release_date, inspection_date_from, inspection_date_to, bid_opening_date, bid_last_date, auction_start_date, auction_end_date, related_doc, first_opener, second_opener');
		$this->db->where('status !=', 5);
		$this->db->where('id', $auction_id);
		$query = $this->db->get("tbl_auction");
		$data = array();
	
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();
			
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
				
				foreach ($query_bidder_frq->result() as $row_bidder_frq)
				{
					$row_bidder->row_bidder_frq=$row_bidder_frq;
					$data_FRQbidder[]=$row_bidder;
				}
			}
			$data[0]->bidder=$data_bidder;
			//FRQ Details
			$data[0]->bidderFRQ=$data_FRQbidder;
			//Auction Last Bid Details 

			$lastbidBidder=$this->db->query("select b.auctionID,b.bidderID,MAX(b.bid_value) as bid_value ,u.first_name,max(b.indate) as indate from tbl_live_auction_bid as b,tbl_user_registration as u where auctionID='".$data[0]->id."' AND b.bidderID=u.id GROUP BY b.bidderID ORDER BY b.bid_value,b.indate DESC")->result_object();
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
		}
	}

    /**********************  End Report PDF     ************************/
	/**********************  Start myProfile     ************************/
    public function myProfileUserData()
    {
        $this->db->where('id', $this->session->userdata('id'));
		$query = $this->db->get("tbl_user");

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
        
    public function myProfileEditSaveData()
    {
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

		$data['date_modified']=date('Y-m-d H:i:s');
		$this->db->where('id', $id);
		$this->db->update('tbl_user', $data);
		return true;
	}
	/**********************  End myProfile     ************************/  
	 
	function getAllCloseAuctionBidder($auctionID)
	{
		$query=$this->db->query("SELECT * from tbl_closed_auction_bidder where auctionID='".$auctionID."'");
		if ($query->num_rows() > 0) 
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
		
	function getBidderRank($auctionID)
	{
		$query=$this->db->query("SELECT bidderID, MAX(bid_value) FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' GROUP BY bidderID  ORDER BY MAX(bid_value) DESC");
	
		if($query->num_rows())
		{	
			$rankArr=array();
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
	
	function getBidderRankByTimestamp($auctionID,$timestamp)
	{
		$query=$this->db->query("SELECT bidderID, bid_value, indate, MAX(bid_value) as 'maxValue' FROM tbl_live_auction_bid WHERE auctionID ='$auctionID' AND indate <='$timestamp' GROUP BY bidderID  ORDER BY MAX(bid_value) DESC");
	
		if($query->num_rows())
		{	
			$rankArr=array();
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
		 
		$query3=$this->db->query("SELECT count(i.id) as total, 
		sum(i.amount) as invoicedAmt,
		sum(i.realizationAmount != '0') as collected,
		sum(i.realizationAmount) as collectedAmt
		FROM tbl_auction as a INNER JOIN tbl_event_invoice as i ON a.id=i.auctionID WHERE a.bank_id='$bank_id' AND branch_id='$branch_id' $joinpcondition");
		$row3 = $query3->result();
		$total_invoice = $row3[0]->total;
		$total_invoice_amount = $row3[0]->invoicedAmt;
		$total_invoice_collected_amount = $row3[0]->collectedAmt;
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
		$payment_due = $total_invoice_amount-$total_invoice_collected_amount;
		
		$data['total_invoice_reaised']	=	$total_invoice;
		$data['activeAuction']			=	$activeAuction;
		$data['payment_due']			=	($payment_due)?number_format($payment_due,2):'0';
		$data['outstanding_amount']		=	($total_invoice_amount)?number_format($total_invoice_amount,2):'0';
		return $data;
	}
	
	
	function countPopularAuctionByRange($condition)
	{
		$query=$this->db->query("SELECT id FROM tbl_auction WHERE $condition ");
		$totalRow=$query->num_rows();
		return $totalRow;
	}
	
	function auctionConductedbyCategories()
	{
		$bank_id = $this->session->userdata['bank_id'];
		$branch_id=$this->session->userdata('branch_id');
		$totalResidential = $this->countPopularAuctionByRange("bank_id=$bank_id AND
		branch_id='$branch_id' AND subcategory_id=6");
		$totalCommercial = $this->countPopularAuctionByRange("bank_id=$bank_id AND
		branch_id='$branch_id' AND subcategory_id=7");
		$total	= $totalResidential + $totalCommercial;
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
	
	public function getUserValue($userid)
	{
		$this->db->where('id', $userid);
		$query = $this->db->get("tbl_user_registration");

		$data = array();
		if ($query->num_rows() > 0){
				
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
				return $data;
		}
		return false;
    }
        
    public function getBranchName($auctionID)
    {
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");

		$data = array();
		if ($query->num_rows() > 0)
		{
				foreach ($query->result() as $row) {
					$bankid = $row->branch_id;
				}
		}

		$this->db->where('id', $bankid);
		$query1 = $this->db->get("tbl_branch");

		$data = array();
		if ($query1->num_rows() > 0)
		{		
			foreach ($query1->result() as $row1) {
				$bankname = $row1->name;
			}
			return $bankname;
		}
		return false;
    }
    
    public function getCityName($auctionID)
    {
                
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");

		$data = array();
		if ($query->num_rows() > 0)
		{		
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

		$data = array();
		if ($query1->num_rows() > 0)
		{
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
		
        if($update)
        {
           // $email_new->sendMailToHelpdeskForOpeningStatus($auctionID);  // Uncomment First
            //$email_new->sendMailToBidderForOpeningStatus($auctionID);
			// End:Email Code
			
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
		//end
		return true;
	}
    
	public function getNITRefNo($auctionID)
	{
		$this->db->where('id', $auctionID);
		$query = $this->db->get("tbl_auction");

		$data = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$reference_no = $row->reference_no;
			}
			return $reference_no;
		}
		return false;
    }
	
    function movetoauction1()
    {
		$type = $this->input->post('type');
		$message = $this->input->post('message');
		
		$query=$this->db->get('tbl_log_auction');
		$data['emd']=$query->result();
		if(!empty($data['emd']))
		{
			$this->trackemdDetailPopupData($data,$type,$message); 
		} 
    }
        
	function movetoauction()
	{
		///Auction moved success fully
		$auctionID = $this->input->post('auctionID');
		$type = $this->input->post('type');
		$message = $this->input->post('message');
		$this->db->where('auction_id', $auctionID);

		//move_to_auction
		$query=$this->db->get('tbl_log_auction');
		$data['emd']=$query->result();
		if(!empty($data['emd']))
		{
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

		return true;
	}
	
	function movetosecondopener()
	{
		$auctionID = $this->input->post('auctionID');
		$this->db->where('id', $auctionID);
		$this->db->update('tbl_auction', array('stageID'=>4));
		
		$this->db->where('auction_id', $auctionID);
		$this->db->update('tbl_log_auction', array('stageID'=>4));
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


	public function GetCityBank($state_id=null) 
	{
		$this->db->where('status', 1);		
		$this->db->where("id", $state_id);		
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_city");
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
    
	public function GetStateBank($state_id=null) 
	{
		$this->db->where('status', 1);		
		$this->db->where("id", $state_id);		
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_state");
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
			return '1';
		}
		else
		{
			return '0';	
		}
	}
}
?>
