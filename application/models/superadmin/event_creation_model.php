<?php
class Event_creation_model extends CI_Model 
{
	private $path = 'public/uploads/bank/';
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function log_event_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->get('from_date')); 
                $to_date 	= trim($this->input->get('to_date')); 
                $auctionId	= trim($this->input->get('auctionId')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
				$this->db->select('au.id, au.auction_id, au.ip, au.indate, au.reference_no, au.approvalStatus, au.status, au.approverComments, tu.email_id');

				$this->db->from('tbl_log_auction AS au');  
				if($from_date != ''&& $to_date != ''){
					$this->db->where('(au.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
				}
				if($auctionId != ''){
					$this->db->where("au.auction_id",$auctionId);
				} 				           
				$this->db->join('tbl_user as tu','au.created_by=tu.id','left ');
				
				// $this->db->join('tbl_log_event_assign AS es','el.event_log_id = es.event_id','left');
				/*$this->db->join('tbl_log_auction as au','au.eventID = el.event_log_id','left');
				$this->db->join('tbl_bank as bk','el.bank_id=bk.id','left');
				$this->db->join('tbl_branch as br','au.branch_id=br.id','left');
				
				$this->db->join('tbl_user_registration as ti','au.created_by=ti.id','left ');*/
				$this->db->order_by('au.id DESC');
				$this->db->limit($limit,$start);
				$query = $this->db->get();
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
  
  
	function log_event_report_model()
	{
			$from_date 	= trim($this->input->get('from_date')); 
			$to_date 	= trim($this->input->get('to_date')); 
			$auctionId	= trim($this->input->get('auctionId')); 
			$this->db->select('au.id, au.auction_id, au.ip, au.indate, au.reference_no, au.approvalStatus, au.status, au.approverComments, tu.email_id');

			$this->db->from('tbl_log_auction AS au');  
			if($from_date != ''&& $to_date != ''){
				$this->db->where('(au.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
			}
			if($auctionId != ''){
				$this->db->where("au.auction_id",$auctionId);
			} 				           
			$this->db->join('tbl_user as tu','au.created_by=tu.id','left ');
			
			// $this->db->join('tbl_log_event_assign AS es','el.event_log_id = es.event_id','left');
			/*$this->db->join('tbl_log_auction as au','au.eventID = el.event_log_id','left');
			$this->db->join('tbl_bank as bk','el.bank_id=bk.id','left');
			$this->db->join('tbl_branch as br','au.branch_id=br.id','left');
			
			$this->db->join('tbl_user_registration as ti','au.created_by=ti.id','left ');*/
			$this->db->order_by('au.id DESC');
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
  
  
	public function log_event_count_model() {
		$from_date 	= trim($this->input->get('from_date')); 
		$to_date 	= trim($this->input->get('to_date')); 
		$auctionId	= trim($this->input->get('auctionId')); 
		$this->db->select('count(*) as total');
		$this->db->from('tbl_log_auction AS au');

		if($from_date != ''&& $to_date != ''){
			$this->db->where('(au.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
		}

		if($auctionId != ''){
			$this->db->where("au.auction_id",$auctionId);
		} 
		
		$this->db->join('tbl_user as tu','au.created_by=tu.id','left ');
		/*
		$this->db->join('tbl_log_auction as au','au.eventID = el.event_log_id','left');
		$this->db->join('tbl_bank as bk','el.bank_id=bk.id','left');
		$this->db->join('tbl_user_registration as tu','el.created_by=tu.id','left ');
		*/
		$this->db->order_by('au.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
    
    public function event_assign_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->post('from_date')); 
                $to_date 	= trim($this->input->post('to_date')); 
                $auctionId	= trim($this->input->post('auctionId')); 
                $eventId 	= trim($this->input->post('eventId')); 
                $createdby	= trim($this->input->post('createdby')); 
                $activity_done 	= trim($this->input->post('Change_status')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
	        $this->db->select('es.id,es.event_id, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.modified_date, es.ip,au.auction_id, bk.name as bname,tu.first_name as from_first_name, tu.last_name as from_last_name,re.first_name as to_first_name, re.last_name as  to_last_name');
	        
            $this->db->from('tbl_log_event_assign AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('au.auction_id',$auctionId);
                } 
              
              if($activity_done != ''){
					if($activity_done == 'assign_event')
						{
							$this->db->where('es.modified_date IS NULL');
						}
						if($activity_done == 'reassign_event')
						{
							$this->db->where('es.modified_date !=','""');
						}
				 }
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                 
               // $this->db->join('tbl_log_event_assign AS es','el.event_log_id = es.event_id','left');
                $this->db->join('tbl_log_auction as au','au.eventID = es.event_id','left');
                $this->db->join('tbl_log_event_log as el','el.event_log_id = es.event_id','left');
                $this->db->join('tbl_user_registration as tu','es.assign_from_id = tu.id','left ');
                $this->db->join('tbl_user_registration as re','es.assign_to_id = re.id','left ');
                $this->db->join('tbl_bank as bk','el.bank_id = bk.id','left');
                $this->db->order_by('es.id DESC');
                $this->db->limit($limit,$start);
                $query = $this->db->get();
                $data = array();
              if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
    
    public function event_assign_count_model() {
		$from_date 	= trim($this->input->post('from_date')); 
		$to_date 	= trim($this->input->post('to_date')); 
		$auctionId	= trim($this->input->post('auctionId')); 
		$eventId 	= trim($this->input->post('eventId')); 
		$createdby	= trim($this->input->post('createdby')); 
		$activity_done 	= trim($this->input->post('activity_done')); 
		$this->db->select('count(*) as total');
		$this->db->from('tbl_log_event_assign AS es');

		if($from_date != ''&& $to_date != ''){
			$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
        }
		if($auctionId != ''){
			$this->db->where('au.auction_id',$auctionId);
		} 
              
		if($activity_done != ''){
			if($activity_done == 'assign_event')
			{
				$this->db->where('es.modified_date IS NULL');
			}
			if($activity_done == 'reassign_event')
			{
				$this->db->where('es.modified_date !=','""');
			}
		}
		if($eventId != ''){
			$this->db->where('es.event_id',$eventId);
		}

		$this->db->join('tbl_log_auction as au','au.eventID = es.event_id','left');
		$this->db->join('tbl_log_event_log as el','el.event_log_id = es.event_id','left');
		$this->db->join('tbl_user_registration as tu','es.assign_from_id = tu.id','left ');
		$this->db->join('tbl_user_registration as re','es.assign_to_id = re.id','left ');
		$this->db->join('tbl_bank as bk','el.bank_id = bk.id','left');
		$this->db->order_by('es.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
	function event_assign_report_model()
	{
			$from_date 	= trim($this->input->post('from_date')); 
			$to_date 	= trim($this->input->post('to_date')); 
			$auctionId	= trim($this->input->post('auctionId')); 
			$eventId 	= trim($this->input->post('eventId')); 
			$createdby	= trim($this->input->post('createdby')); 
			$activity_done 	= trim($this->input->post('Change_status')); 
			
			$this->db->select('es.id,es.event_id, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.modified_date, es.ip,au.auction_id, bk.name as bname,tu.first_name as from_first_name, tu.last_name as from_last_name,re.first_name as to_first_name, re.last_name as  to_last_name');
	        
            $this->db->from('tbl_log_event_assign AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('au.auction_id',$auctionId);
                } 
              
              if($activity_done != ''){
					if($activity_done == 'assign_event')
						{
							$this->db->where('es.modified_date IS NULL');
						}
						if($activity_done == 'reassign_event')
						{
							$this->db->where('es.modified_date !=','""');
						}
				 }
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                 
               // $this->db->join('tbl_log_event_assign AS es','el.event_log_id = es.event_id','left');
                $this->db->join('tbl_log_auction as au','au.eventID = es.event_id','left');
                $this->db->join('tbl_log_event_log as el','el.event_log_id = es.event_id','left');
                $this->db->join('tbl_user_registration as tu','es.assign_from_id = tu.id','left ');
                $this->db->join('tbl_user_registration as re','es.assign_to_id = re.id','left ');
                $this->db->join('tbl_bank as bk','el.bank_id = bk.id','left');
                $this->db->order_by('es.id DESC');
                
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
    
    
    
    
    public function event_selectbankuser_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->post('from_date')); 
                $to_date 	= trim($this->input->post('to_date')); 
                $auctionId	= trim($this->input->post('auctionId')); 
                $eventId 	= trim($this->input->post('eventId')); 
                $createdby	= trim($this->input->post('createdby')); 
                $activity_done 	= trim($this->input->post('Change_status')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
	        $this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id,  es.ip, tu.email_id as email');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
           
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                 $this->db->where('es.type','bank_user');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->order_by('es.id DESC');
                $this->db->limit($limit,$start);
                $query = $this->db->get();
                $data = array();
              if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
					return $data;
				}
		return false;
	}
	
	public function event_selectbankuser_count_model() {
		$from_date 	= trim($this->input->post('from_date')); 
		$to_date 	= trim($this->input->post('to_date')); 
		$auctionId	= trim($this->input->post('auctionId')); 
		$eventId 	= trim($this->input->post('eventId')); 
		$createdby	= trim($this->input->post('createdby')); 
		$activity_done 	= trim($this->input->post('activity_done')); 
		$this->db->select('count(*) as total');
		$this->db->from('tbl_log_event_creation AS es');
		
		if($from_date != ''&& $to_date != ''){
			$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
		}
		if($auctionId != ''){
			$this->db->where('es.auction_id',$auctionId);
		} 
	  
	    if($eventId != '')
	    {
			$this->db->where('es.event_id',$eventId);
		}
		$this->db->where('es.type','bank_user');
		$this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
		$this->db->order_by('es.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
    
    function event_selectbankuser_report_model()
	{
			$from_date 	= trim($this->input->post('from_date')); 
			$to_date 	= trim($this->input->post('to_date')); 
			$auctionId	= trim($this->input->post('auctionId')); 
			$eventId 	= trim($this->input->post('eventId')); 
			$createdby	= trim($this->input->post('createdby')); 
			$activity_done 	= trim($this->input->post('Change_status')); 
			
			$this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id,  es.ip, tu.email_id as email');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
              
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                $this->db->where('es.type','bank_user');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');                
                $this->db->order_by('es.id DESC');
                
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
	
	
	
	public function event_uploaddocimg_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->post('from_date')); 
                $to_date 	= trim($this->input->post('to_date')); 
                $auctionId	= trim($this->input->post('auctionId')); 
                $eventId 	= trim($this->input->post('eventId')); 
                $createdby	= trim($this->input->post('createdby')); 
                $activity_done 	= trim($this->input->post('Change_status')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
	        $this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id,  es.ip, tu.email_id as email');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				if($activity_done != ''){
					if($activity_done == 'related')
						{
							$this->db->where('es.type','rel_doc');
						}
						if($activity_done == 'image')
						{
							$this->db->where('es.type','img');
						}
				 }
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                if($activity_done == '')
                {
                 $this->db->where('(es.type = "rel_doc" OR es.type = "img")');
                }
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->order_by('es.id DESC');
                $this->db->limit($limit,$start);
                $query = $this->db->get();
                $data = array();
              if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
					return $data;
				}
		return false;
	}
	
	
	
	public function event_uploaddocimg_count_model() {
		$from_date 	= trim($this->input->post('from_date')); 
		$to_date 	= trim($this->input->post('to_date')); 
		$auctionId	= trim($this->input->post('auctionId')); 
		$eventId 	= trim($this->input->post('eventId')); 
		$createdby	= trim($this->input->post('createdby')); 
		$activity_done 	= trim($this->input->post('activity_done')); 
		$this->db->select('count(*) as total');
		 $this->db->from('tbl_log_event_creation AS es');
		 
	   if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				if($activity_done != ''){
					if($activity_done == 'related')
						{
							$this->db->where('es.type','rel_doc');
						}
						if($activity_done == 'image')
						{
							$this->db->where('es.type','img');
						}
				 }
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                if($activity_done == '')
                {
                 $this->db->where('(es.type = "rel_doc" OR es.type = "img")');
                }
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->order_by('es.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
    
     function event_uploaddocimg_report_model()
	{
			$from_date 	= trim($this->input->post('from_date')); 
			$to_date 	= trim($this->input->post('to_date')); 
			$auctionId	= trim($this->input->post('auctionId')); 
			$eventId 	= trim($this->input->post('eventId')); 
			$createdby	= trim($this->input->post('createdby')); 
			$activity_done 	= trim($this->input->post('Change_status')); 
			
			$this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id,  es.ip, tu.email_id as email');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				if($activity_done != ''){
					if($activity_done == 'related')
						{
							$this->db->where('es.type','rel_doc');
						}
						if($activity_done == 'image')
						{
							$this->db->where('es.type','img');
						}
				 }
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
                if($activity_done == '')
                {
                 $this->db->where('(es.type = "rel_doc" OR es.type = "img")');
                }
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->order_by('es.id DESC');
                
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
    
    
    
    
    public function event_secondopener_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->post('from_date')); 
                $to_date 	= trim($this->input->post('to_date')); 
                $auctionId	= trim($this->input->post('auctionId')); 
                $eventId 	= trim($this->input->post('eventId')); 
                $createdby	= trim($this->input->post('createdby')); 
                $activity_done 	= trim($this->input->post('Change_status')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
	        $this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id, es.second_opener_id,  es.ip, tu.email_id as email, as1.email_id as semail');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','second_opener');
                
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
                $this->db->limit($limit,$start);
                $query = $this->db->get();
                $data = array();
              if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
					return $data;
				}
		return false;
	}
	
	public function event_secondopener_count_model() {
		$from_date 	= trim($this->input->post('from_date')); 
		$to_date 	= trim($this->input->post('to_date')); 
		$auctionId	= trim($this->input->post('auctionId')); 
		$eventId 	= trim($this->input->post('eventId')); 
		$createdby	= trim($this->input->post('createdby')); 
		$activity_done 	= trim($this->input->post('activity_done')); 
		$this->db->select('count(*) as total');
		 $this->db->from('tbl_log_event_creation AS es');
		 
	   if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','second_opener');
                
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
    
    function event_secondopener_report_model()
	{
			$from_date 	= trim($this->input->post('from_date')); 
			$to_date 	= trim($this->input->post('to_date')); 
			$auctionId	= trim($this->input->post('auctionId')); 
			$eventId 	= trim($this->input->post('eventId')); 
			$createdby	= trim($this->input->post('createdby')); 
			$activity_done 	= trim($this->input->post('Change_status')); 
			
			 $this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.bank_user_id, es.second_opener_id,  es.ip, tu.email_id as email, as1.email_id as semail');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','second_opener');
                
                 //$this->db->where('es.type','img');
                $this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                $this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
                
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
    
    
    public function event_dctbs_records_model($start=0, $limit=10) 
	{
                $from_date 	= trim($this->input->post('from_date')); 
                $to_date 	= trim($this->input->post('to_date')); 
                $auctionId	= trim($this->input->post('auctionId')); 
                $eventId 	= trim($this->input->post('eventId')); 
                $createdby	= trim($this->input->post('createdby')); 
                $activity_done 	= trim($this->input->post('Change_status')); 
	        //$this->db->select(' el.id,el.event_log_id, el.bank_id, el.is_assign, el.created_by, el.indate, el.ip, el.status, es.assign_from_id, es.assign_to_id, es.indate, es.status, es.ip as assign_ip,au.auction_id, bk.name as bname');
	        
	        $this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.document_to_be_submitted,  es.ip');
	        
            $this->db->from('tbl_log_event_creation AS es');
               if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','doc_sub');
                
                 //$this->db->where('es.type','img');
                //$this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                //$this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
                $this->db->limit($limit,$start);
                $query = $this->db->get();
                $data = array();
              if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
					return $data;
				}
		return false;
	}
	
	
	public function event_dctbs_count_model() {
		$from_date 	= trim($this->input->post('from_date')); 
		$to_date 	= trim($this->input->post('to_date')); 
		$auctionId	= trim($this->input->post('auctionId')); 
		$eventId 	= trim($this->input->post('eventId')); 
		$createdby	= trim($this->input->post('createdby')); 
		$activity_done 	= trim($this->input->post('activity_done')); 
		$this->db->select('count(*) as total');
		 $this->db->from('tbl_log_event_creation AS es');
		 
	   if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','doc_sub');
                
                 //$this->db->where('es.type','img');
                //$this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                //$this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			$data = $query->result();
			return $data[0]->total;
		}
		else
		{        
			return 0;
		}
    }
    
    
    function event_dctbs_report_model()
	{
			$from_date 	= trim($this->input->post('from_date')); 
			$to_date 	= trim($this->input->post('to_date')); 
			$auctionId	= trim($this->input->post('auctionId')); 
			$eventId 	= trim($this->input->post('eventId')); 
			$createdby	= trim($this->input->post('createdby')); 
			$activity_done 	= trim($this->input->post('Change_status')); 
			
			$this->db->select('es.id,es.event_id,es.auction_id, es.type, es.ip, es.indate, es.document_to_be_submitted,  es.ip');
	        
            $this->db->from('tbl_log_event_creation AS es');
              if($from_date != ''&& $to_date != ''){
					$this->db->where('(es.indate BETWEEN '."'".$from_date."'  AND '".$to_date."')");
                 }
              if($auctionId != ''){
                 $this->db->where('es.auction_id',$auctionId);
                } 
				
				
				 
               if($eventId != ''){
                 $this->db->where('es.event_id',$eventId);
                }
               
                 $this->db->where('es.type','doc_sub');
                
                 //$this->db->where('es.type','img');
                //$this->db->join('tbl_user as tu','es.bank_user_id = tu.id','left ');
                //$this->db->join('tbl_user as as1','es.second_opener_id = as1.id','left ');
                $this->db->order_by('es.id DESC');
                
			$query = $this->db->get();
			$data = array();
			if($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
              return $data;
			} 
        return false;
    }
    
    
}

?>
