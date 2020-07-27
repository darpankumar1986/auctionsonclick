<?php
class Viewer_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function getAuctionList() 
	{
		     $this->datatables->select("a.id,b.name,a.auction_start_date,a.auction_end_date, CASE  
                                            WHEN a.status ='2' THEN 'Initialize'
                                            WHEN a.status ='1' THEN 'Published'
                                             WHEN a.status ='3' THEN 'Stay'
                                            WHEN a.status ='0' THEN 'Saved'
                                            END as status1",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/viewer/addviewer/$1'>Add Viewer</a>", 'a.id')
			->from('tbl_auction as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			//->where('(a.status="3" OR a.status = "1")');
			->where('(a.status = "1")');

			return $this->datatables->generate();
    }
    
    function getAuctionListAssigned() 
	{
		     $this->datatables->select("a.id,a.auctionID,us.email_id,b.name,au.auction_start_date,au.auction_end_date",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/viewer/removeviewer1/$1'>Remove Viewer</a>", 'a.id')
			->from('tbl_assign_viewer_account as a')
			->join('tbl_bank as b','b.id=a.bankid','left')
			->join('tbl_user as us','us.id=a.userId','left')
			->join('tbl_auction as au','au.id=a.auctionID','left')
			//->where('(a.status="3" OR a.status = "1")');
			->where('(a.status = "1")');

			return $this->datatables->generate();
    }


	function addviewerlist($auction_id)
    {
		//$this->db->query("SET @row = 0",false); 
		$this->datatables->select("asva.id as assid,reg.id, reg.email_id,reg.user_id,b.name as bname,br.name as brname",false)
		->unset_column('reg.id')
		->add_column('Select Bidders',"<input type='checkbox' name='bidder_userid[]' class='bidder_userid[]' value='$1'>", "reg.id")
		
		->join('tbl_bank as b','b.id=reg.bank_id','left')
		->join('tbl_branch as br','br.id=reg.user_type_id','left')
		->join('tbl_auction as auc','auc.bank_id=reg.bank_id','left')
		->join('tbl_assign_viewer_account as asva','asva.auctionID=auc.id','left')
		->join('tbl_assign_viewer_account as asvu','asvu.userId=reg.id','left')
		->from('tbl_user as reg')
		->where("reg.user_type IN ('viewer')")
		->where('reg.status','1')
		->where('auc.id',$auction_id);
        return $this->datatables->generate();	
	}
	
    public function GetRecords($start=0, $limit=10,$auction_id='') {
		//search query start//
		//search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        $status = $this->input->get('status1');
        $type = $this->input->get('type');
		
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("reg.email_id", "reg.first_name", "reg.id" ,  "reg.user_id", "b.name", "br.name","reg.user_type");
		$columnCount = count($columns);

		$query = "SELECT reg.* FROM tbl_user as reg LEFT JOIN tbl_bank as b ON b.id=reg.bank_id LEFT JOIN tbl_branch as br ON br.id=reg.user_type_id LEFT JOIN tbl_auction as auc ON auc.bank_id=reg.bank_id  WHERE 1  ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " reg.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " reg.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND reg.status = 1 AND reg.user_type = 'viewer' AND auc.id = ".$auction_id." ";
		$query .= "ORDER BY reg.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
		
        $data = array();
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->bank_name = $this->getbankName($row->bank_id);
                $row->branch_name = $this->getbranchName($row->user_type_id);
                $data[] = $row;
            }
            return $data;
        }
		
        return false;
    }
    
    
     public function GetTotalRecord($auction_id) {
        //$this->db->select('count(*) as total');

        //search query start//
        $title 	= str_replace("'","",trim($this->input->get('title')));
        $status = $this->input->get('status1');
        $type = $this->input->get('type');

        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("reg.email_id", "reg.first_name", "reg.id" ,  "reg.user_id", "b.name", "br.name","reg.user_type");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_user as reg LEFT JOIN tbl_bank as b ON b.id=reg.bank_id LEFT JOIN tbl_branch as br ON br.id=reg.user_type_id LEFT JOIN tbl_auction as auc ON auc.bank_id=reg.bank_id  WHERE 1 ";

		// all words should be used
		// that's why we are adding them with the 'AND' operator.
		if ($title != '')
		{
			$query .= " AND ";
				for($i=0;$i<$wordCount;$i++)
				{
				  $word = mysql_escape_string($words[$i]);
				   
				  if ($i > 0) $query .= " AND ";

				  // build the condition
				  $condition = " (";
				  for($j=0;$j<$columnCount;$j++)
				  {
					// but each word can match any column, doesn't matter which one.
					// that's why we are using the 'OR' operator here. 
					if ($j > 0) $condition .= " OR ";
					$column = $columns[$j];
					
					if(strtolower($word) == 'active')
					{
						$status = 1;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) == 'inactive')
					{
						$status = 0;
						$condition .= " u.status like '%{$status}%' ";
					}
					if(strtolower($word) != 'active' && strtolower($word) != 'inactive')
					{
						$condition .= " {$column} like '%{$word}%' ";
					}
				  }
				  $condition .= ") ";
				  $query .= $condition;
				}
		}
		
		$query .= " AND reg.status = 1 AND reg.user_type = 'viewer' AND auc.id = ".$auction_id." ";
		$query .= "ORDER BY reg.id DESC ";
		$query = $this->db->query($query);
		
		
        $data = array();
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                //$row->bank_name = $this->getbankName($row->bank_id);
                //$row->branch_name = $this->getbranchName($row->user_type_id);
                $data[] = $row;
            }
            return $data;
        }
        return 0;
    }
    
	public function saveviewer($auctionid,$userid) 
	{
		
		$this->db->where('auctionID', $auctionid);
		$this->db->where('userId', $userid);
		$query = $this->db->get("tbl_assign_viewer_account");
		if ($query->num_rows() > 0) 
		{
				foreach ($query->result() as $row) 
				{
					$id = $row->id;
				}
					$data1['status']='1';
					$this->db->where('auctionID', $auctionid);
					$this->db->where('userId', $userid);
					$save = $this->db->update('tbl_assign_viewer_account', $data1); 
					if($save){
						return true;
					}else{
						return false;
					}
				
		}
		else
		{
				$bankid = $this->getbankId($userid);
				$branchid = $this->getbranchId($userid);
				
				$data = array('auctionID'=>$auctionid ,
							'userId'=>$userid,
							'bankid'=>$bankid,	
							'branchid'=>$branchid,	
							'status'=>'1',
							'indate'=>date('Y-m-d H:i:s'),
							);
				$save = $this->db->insert('tbl_assign_viewer_account',$data); 
				if($save){
					return true;
				}else{
					return false;
				}
				
				
		}
	}
	
	
	public function removeviewer($auctionid,$userid) 
	{
		$this->db->where('auctionID', $auctionid);
		$this->db->where('userId', $userid);
		$query = $this->db->get("tbl_assign_viewer_account");
		if ($query->num_rows() > 0) 
		{
				foreach ($query->result() as $row) 
				{
					$id = $row->id;
				}
					$data1['status']='0';
					$this->db->where('auctionID', $auctionid);
					$this->db->where('userId', $userid);
					$save = $this->db->update('tbl_assign_viewer_account', $data1); 
					if($save){
						return true;
					}else{
						return false;
					}		
		}
		return false;
	}
	
	public function removeviewer1($id) 
	{
		$this->db->where('id', $id);
		$query = $this->db->get("tbl_assign_viewer_account");
		if ($query->num_rows() > 0) 
		{
					$data1['status']='0';
					$this->db->where('id', $id);
					$save = $this->db->update('tbl_assign_viewer_account', $data1); 
					if($save){
						return true;
					}else{
						return false;
					}		
		}
		return false;
	}
	
	
	public function checkUserExists($auctionid,$userid)
	{
		$this->db->where('auctionID', $auctionid);
		$this->db->where('userId', $userid);
		$query = $this->db->get("tbl_assign_viewer_account");
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) 
			{
				$id = $row->status;
			}
			return $id;
		}
		else
		{
			return 'na';
		}
	}
	
	public function getAuctionDetails($id) {

        //search query start//
        $this->db->select('*');
        $this->db->from('tbl_auction');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        $array = array();
        if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }
    
    
    public function getBankDetails($id) {

        //search query start//
        $this->db->select('*');
        $this->db->from('tbl_bank');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        $array = array();
        if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }
    
    public function getViewerDetails($viewerid,$bankid) 
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('id', $viewerid);  // Also mention table name here
        $query = $this->db->get();
        $array = array();
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
    
	public function getbankName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_bank');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }
    
    public function getbranchName($id) {

        //search query start//
        $this->db->select('name');
        $this->db->from('tbl_branch');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           $rows = $query->result();
            return $rows[0]->name;
        }

        return false;
    }
    
    public function getbankId($id) {

        //search query start//
        $this->db->select('bank_id');
        $this->db->from('tbl_user');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$rows = $query->result();
            return $rows[0]->bank_id;
        }

        return false;
    }
    
    public function getbranchId($id) {

        //search query start//
        $this->db->select('user_type_id');
        $this->db->from('tbl_user');
        $this->db->where('id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$rows = $query->result();
            return $rows[0]->user_type_id;
        }

        return false;
    }
    
    
    
    
    function getBankList() 
	{
		     $this->datatables->select("a.id,a.name,a.indate",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/viewer/bankviewerList/$1'>Viewer List</a>", 'a.id')
			->from('tbl_bank as a')
			//->join('tbl_bank as b','b.id=a.bank_id','left')
			//->where('(a.status="3" OR a.status = "1")');
			->where('(a.status = "1")');

			return $this->datatables->generate();
    }
    
    function bankviewerListData($bankid) 
	{
		     $this->datatables->select("a.id,b.id as bid,a.email_id,a.first_name,a.user_id,b.name,a.user_type,a.indate",false)
			->add_column('Actions',"<a class='b_action' href='/superadmin/viewer/assignViewerAuction/$1,$2'>Assign Auction</a>", 'a.id,b.id')
			->from('tbl_user as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			//->where('(a.status="3" OR a.status = "1")');
			->where('(a.status = "1")');
			$this->db->where('a.user_type', 'viewer');
			$this->db->where('a.bank_id', $bankid);

			return $this->datatables->generate();
    }
    
    function assignViewerAuctionData($viewerId,$bankid) 
	{
		     $this->datatables->select("a.id,a.id as aidd,b.id as bid,a.auction_start_date,a.auction_end_date,b.name",false)
		     ->add_column('Actions',"<a class='b_action' href='/superadmin/viewer/assignViewerAuction/$1'>Assign Auction</a>", 'a.id')
			->from('tbl_auction as a')
			->join('tbl_bank as b','b.id=a.bank_id','left')
			//->join('tbl_assign_viewer_account as asgn','asgn.auctionID=a.id','left')
			
			//->where('(a.status="3" OR a.status = "1")');
			->where('(a.status = "1")')
			//->where('(asgn.userId = '.$viewerId.' or asgn.id is null)')
			//->where('(asgn.status = "0" or asgn.id is null)');
			
			->where('a.id NOT IN(SELECT auctionID FROM tbl_assign_viewer_account WHERE userId = '.$viewerId.' and status = 1)');
			
			$this->db->where('a.bank_id', $bankid);
			//$this->db->where('asgn.userId', $viewerId);
			//$this->db->where('asgn.status', '0');

			return $this->datatables->generate();
			//echo $this->db->last_query();die;
    }
    
    function saveViewerAuction()
    {
		$userid = $this->input->post('viewerID');
		$bankID = $this->input->post('bankID');
		$auction_id = $this->input->post('auction_id');
		
		if(isset($auction_id))
		{
			//echo '<pre>';
			//print_r($auction_id);
			//die;
			foreach($auction_id as $auctionid)
			{
					$this->db->where('auctionID', $auctionid);
					$this->db->where('userId', $userid);
					$query = $this->db->get("tbl_assign_viewer_account");
					if ($query->num_rows() > 0) 
					{
							foreach ($query->result() as $row) 
							{
								$id = $row->id;
							}
								$data1['status']='1';
								$this->db->where('auctionID', $auctionid);
								$this->db->where('userId', $userid);
								$save = $this->db->update('tbl_assign_viewer_account', $data1); 
					}
					else
					{
							$bankid = $this->getbankId($userid);
							$branchid = $this->getbranchId($userid);
							
							$data = array('auctionID'=>$auctionid ,
										'userId'=>$userid,
										'bankid'=>$bankid,	
										'branchid'=>$branchid,	
										'status'=>'1',
										'indate'=>date('Y-m-d H:i:s'),
										);
							$save = $this->db->insert('tbl_assign_viewer_account',$data); 
					}
		
			}
			if($save)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}
    
}

