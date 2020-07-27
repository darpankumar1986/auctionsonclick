<?php
class Bank_model extends CI_Model {
    
	private $path = 'public/uploads/bank/';
    
	function __construct(){
		parent::__construct();
	
		$this->load->database();
	}
	
	public function GetTotalRecord() 
	{	
		//$this->db->select('count(*) as total');	

		//search query start//
		$title = str_replace("'","",trim($this->input->get('title')));
		
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR u.url like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
        $query = $this->db->get("tbl_bank as u");*/
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name", "u.url" , "u.shortName");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_bank as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);

		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		//search query start//
		$title = str_replace("'","",trim($this->input->get('title')));
		
		
		
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR u.url like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
     
		$this->db->limit($limit,$start);
		$this->db->order_by("u.id", "desc");
        $query = $this->db->get("tbl_bank as u");	*/



		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name", "u.url", "u.shortName" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_bank as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
		
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
	public function GetBankRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("name", "ASC");
        $query = $this->db->get("tbl_bank");	
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
	public function GetZoneRecord() {
		
		$this->db->where('status', 1);
		$this->db->order_by("zone_name", "asc");
        $query = $this->db->get("tbl_zone");	
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
	public function GetRegionRecord() {
		
		$this->db->where('status ', 1);
		$this->db->order_by("name", "asc");
        $query = $this->db->get("tbl_region");	
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
	public function GetDrtRecords($orderbyname = "") {
		
		$this->db->where('status', 1);
		if($orderbyname == "")
		{
			//$this->db->order_by("id", "desc");
		}
		else
		{
			//$this->db->order_by($orderbyname, "ASC");
		}
		$this->db->order_by("name", "asc");
        $query = $this->db->get("tbl_drt");	
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
	public function GetCountries() {
				
		$this->db->where('status', 1);	
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_country");
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetState($country_id='') {
		$this->db->where('status', 1);		
		if($country_id){
			$this->db->where("countryID", $country_id);	
		}
		
		$this->db->order_by("state_name", "asc");
        $query = $this->db->get("tbl_state");
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
    
    public function GetLho($bank_id='')
    {
	
	$data = array();
	if($bank_id){
	$this->db->where('status', 1);		
	
	$this->db->where("bank_id", $bank_id);
	$this->db->order_by("name", "asc");
        $query = $this->db->get("tbl_lho");
	//echo $this->db->last_query();
	//echo $query->num_rows();
	
       
	if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
            }
            return $data;
        }
	}
        return false;
    }
    
    
	public function GetCity($state_id=null) {
		$this->db->where('status', 1);		
		if($state_id){
		$this->db->where("stateID", $state_id);		
		}
		$this->db->order_by("city_name", "asc");
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
	public function GetRecordByid($id) {
	
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_bank");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_data($image=null,$thumb_logopath=null) {
			/*if($_FILES['thumb_logopath']['name']!= ""){
				$thumb_logopath=$this->upload1('thumb_logopath');
			}else{
				$thumb_logopath=$this->input->post('thumb_logopath_old');
			}*/
                if($_FILES['tender_doc']['name']!= ""){
				$tender_doc=$this->upload2('tender_doc');
			}else{
				$tender_doc=$this->input->post('tender_doc_old');
			}
                if($_FILES['annexure2']['name']!= ""){
				$annexure2=$this->upload2('annexure2');
			}else{
				$annexure2=$this->input->post('annexure2_old');
			}
                if($_FILES['annexure3']['name']!= ""){
				$annexure3=$this->upload2('annexure3');
			}else{
				$annexure3=$this->input->post('annexure3_old');
			}        
		//$thumb_logopath=$this->upload1('thumb_logopath');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$url = $this->input->post('url');
		$shortname = trim($this->input->post('shortname'));
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$country = $this->input->post('country_id');
		$state = $this->input->post('state_id');		
		$city = $this->input->post('city_id');
		$street = $this->input->post('street');		
		$zip = $this->input->post('zip');		
		$phone = $this->input->post('phone');		
		$fax = $this->input->post('fax');		
		$bank_header_color= $this->input->post('bank_header_color');
		$status = $this->input->post('status');	
		$priority = $this->input->post('priority');	
		
		$data = array(
					'name'=>$name,
					'url'=>$url,
					'shortName'=>strtolower($shortname),
					'address1'=>$address1,
					'logopath'=>$image,
					'thumb_logopath'=>$thumb_logopath,
					'address2'=>$address2,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city,
					'street'=>$street,
					'zip'=>$zip,
					'phone'=>$phone,
					'fax'=>$fax,
					'tender_doc'=>$tender_doc,
					'annexure2'=>$annexure2,
					'annexure3'=>$annexure3,
					'bank_header_color'=>$bank_header_color,
					'status' =>$status,
					'priority' =>$priority
				);
        if($id)			
		{
			/*if(!preg_match("/^[_a-z0-9-]+-[0-9]+$/", $data['slug'])) {
			  $data['slug'] = GetSlug($title, $id);
			}*/
			
			$this->db->where('id', $id);
			$this->db->update('tbl_bank', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_bank',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	
	public function FilterBranchRecords($region_id='',$zone_id='',$bank_id='') {
		if($bank_id)
		$this->db->where('bank_id', $bank_id);
		if($zone_id)
		$this->db->where('zone_id', $zone_id);
		if($region_id)
		$this->db->where('region_id', $region_id);
		$this->db->where('status', 1);
		$this->db->order_by("name", "ASC");
		$this->db->order_by("address1", "ASC");	
        $query = $this->db->get("tbl_branch");	
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
	public function FilterRegionRecords($zone_id='',$bank_id='') {
		if($bank_id)
		$this->db->where('bank_id', $bank_id);
		if($zone_id)
		$this->db->where('zone_id', $zone_id);
		$this->db->where('status', 1);
		$this->db->order_by("name", "asc");		
        $query = $this->db->get("tbl_region");	
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
	public function FilterZoneRecords($bank_id) {
		if($bank_id)
		$this->db->where('bank_id', $bank_id);
		$this->db->where('status', 1);
		$this->db->order_by("name", "asc");		
        $query = $this->db->get("tbl_zone");	
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
	public function GetTotalBranchRecord() {	
		//$this->db->select('count(*) as total');	

		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title')));

		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%' OR region.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->join('tbl_region as region','region.id = u.region_id','left');
        $query = $this->db->get("tbl_branch as u");	*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name", "tb.name" , "zone.name", "region.name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_branch as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_zone as zone ON zone.zone_id = u.zone_id LEFT JOIN tbl_region as region ON region.id = u.region_id WHERE 1  ";

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
		
		$query .= " AND u.status != 5 ";
		$query .= "ORDER BY u.zone_id";
		
		$query = $this->db->query($query);
        
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
           
			return $data[0]->total;
        }        
		return 0;
    }
    
    function get_bank_branch_list(){	
       
		$this->datatables->select("a.id,a.name as brname,bk.name as bkname,zo.name as zoname,re.name as rename1, CASE  a.status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' END as status1,a.indate",false)
		->add_column('Actions',"<a class='b_action' href='/sales_coordinator/createBranch/$1'>Edit</a>", 'a.id')
        ->from('tbl_branch as a')
		->join('tbl_bank as bk','bk.id=a.bank_id','left')
		->join('tbl_zone as zo','zo.id=a.zone_id','left') // Favourite LIST ADDED
		->join('tbl_region as re','re.id=a.region_id','left')
		//->where('ap.final_submit','1')
		//->where('fav.is_fav', 1)  // Favourite LIST ADDED
		->where('(a.status="1")');
		// $this->db->order_by('a.id','DESC');
		 $this->db->order_by('a.name','ASC');
		//->order_by('a.id','DESC');
		
        return $this->datatables->generate();
        
    }
    
	public function GetBranchRecords($start=0, $limit=10) 
	{
		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title')));

		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name", "tb.name" , "zone.name", "region.name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_branch as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_zone as zone ON zone.zone_id = u.zone_id LEFT JOIN tbl_region as region ON region.id = u.region_id WHERE 1  ";

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
		
		$query .= " AND u.status != 5 ";
		$query .= "ORDER BY u.id";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		//echo $query->num_rows();
	
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%' OR region.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->join('tbl_region as region','region.id = u.region_id','left');
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_branch as u");	
		//echo $this->db->last_query();*/
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
	public function GetBranchRecordByid($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_branch");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    
    public function uniqueBank($name, $id) {
			if($id > 0){
			$this->db->where('id !=', $id);
			}
			$this->db->where('name', $name);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_bank");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
    }
    
    public function uniquePriority($priority, $id) {
			if($id > 0){
			$this->db->where('id !=', $id);
			}
			$this->db->where('priority', $priority);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_bank");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
  
  public function uniqueshortname($name, $id) {
			if($id > 0){
			$this->db->where('id !=', $id);
			}
			$this->db->where('shortName', $name);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_bank");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
  
  
    
    public function uniqueLho($name, $bank_id, $id) {
			if($id > 0)
			{$this->db->where('id !=', $id);}
			$this->db->where('name', $name);
			$this->db->where('bank_id', $bank_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_lho");
	//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
    
	public function save_branch_data($image=null) {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$zone = $this->input->post('zone');
		$drt = $this->input->post('drt');
		$region = $this->input->post('region');
		$bank_id = $this->input->post('bank');
		$lho_id = $this->input->post('lho_id');

		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$country = $this->input->post('country_id');
		$state = $this->input->post('state_id');		
		$city = $this->input->post('city_id');
		$street = $this->input->post('street');		
		$zip = $this->input->post('zip');		
		$phone = $this->input->post('phone');		
		$fax = $this->input->post('fax');		
		$agreementnodate = $this->input->post('agreementnodate');		
		$unsuc_revenueamount = $this->input->post('unsuc_revenueamount');		
		$revenueamount = $this->input->post('revenueamount');		
		$stax = $this->input->post('stax');		
		$secondaryhighertax = $this->input->post('secondaryhighertax');		
		$educess = $this->input->post('educess');		
		$total = $this->input->post('total');
		$status = $this->input->post('status');
                $cancel_amount=$this->input->post('cancel_amount');
                $stay_amount=$this->input->post('stay_amount');
                $auctionstartdate =  date('Y-m-d H:i:s',  strtotime($this->input->post('agreementstartdate')));	
	        $agreementenddate = date('Y-m-d H:i:s',strtotime($this->input->post('agreementenddate')));
              
		// die()
		$data = array(
					'name'=>$name,
					'drt_id'=>$drt,
					'bank_id'=>$bank_id,
					'lho_id'=>$lho_id,
					'zone_id'=>$zone,
					'region_id'=>$region,
					'status'=>1,
					'address1'=>$address1,
					'address2'=>$address2,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city,
					'street'=>$street,
					'zip'=>$zip,
					'phone'=>$phone,
					'fax'=>$fax,
					'agreementnodate'=>$agreementnodate,
					'revenueamount'=>$revenueamount,
					'unsuc_revenueamount'=>$unsuc_revenueamount,
					'stax'=>$stax,
					'secondaryhighertax'=>$secondaryhighertax,
					'educess'=>$educess,
					'total'=>$total,
                                        'validity_from'=>$auctionstartdate,
                                        'validity_to'=>$agreementenddate,
                                        'stay_amount'=>$stay_amount,
                                        'cancel_amount'=>$cancel_amount,
                                      );
                    if($id!=0){
			$this->db->where('id', $id);
			$this->db->update('tbl_branch', $data); 
		}else{
                        $data['indate']=date('Y-m-d H:i:s');
                        $this->db->insert('tbl_branch',$data);
                               $insert_id=mysql_insert_id();
                               $userlog=array(
                                    'actiontype'=>'create_branch',
                                    //'email_id'=>$email_id,
                                    'user_id'=>$insert_id,
                                    'ip_address'=>$_SERVER['REMOTE_ADDR'],
                                    'user_type'=>'branch',
                                    'indate'=>date('Y-m-d H:i:s'),
                                    'status'=>'1',
                                    'message'=>'Branch Registered Successfully'
                                        ); 
 $this->db->insert('tbl_log_user_registration',$userlog);  
		     }
		return true;
	}
	public function GetTotalZoneRecord() {	
		//$this->db->select('count(*) as total');
		
		//search query start//
		$title = str_replace("'","",trim($this->input->get('title')));
		
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.name like ' . "'%" . $title . "%'   OR u.id like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');

        $query = $this->db->get("tbl_zone as u");*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.zone_id", "u.zone_name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_zone as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5 ";
		$query .= "ORDER BY u.zone_id DESC ";
		$query = $this->db->query($query);
		
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetZoneRecordByid($id) {
        $this->db->where('zone_id', $id);
				$query = $this->db->get("tbl_zone");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetZoneRecordByBank() {
		$this->db->where('status != ', 5);
				$query = $this->db->get("tbl_zone");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetZoneRecords($start=0, $limit=10) {		
		//search query start//
		$title = str_replace("'","",trim($this->input->get('title')));
	
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.name like ' . "'%" . $title . "%'   OR u.id like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
            
		//serach query ends//
        $this->db->where('u.status !=', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->order_by('u.id DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get("tbl_zone as u");*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.zone_name", "u.zone_id");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_zone as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5 ";
		$query .= "ORDER BY u.zone_id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
    
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
	public function save_zone_data($image=null) {
		$zone_id = $this->input->post('zone_id');
		$zone_name = $this->input->post('zone_name');		
		$status = $this->input->post('status');
		
		$data = array(
					'zone_name'=>$zone_name,					
					'status' =>$status
				);
		if($zone_id)			
		{
			$data['date_modified']=date('Y-m-d H:i:s');		
			$this->db->where('zone_id', $zone_id);
			$this->db->update('tbl_zone', $data); 
		}
		else
		{			
			$data['date_created']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_zone',$data); 
			//$id = $this->db->insert_id();

		}
		return true;
	}
	public function GetLhoRecord() {
		
		$this->db->where('status', 1);
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_lho");	
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
	public function FilterLhoRecords($bank_id='') {
		if($bank_id)
		$this->db->where('bank_id', $bank_id);
		$this->db->where('status', 1);
		$this->db->order_by("id", "desc");		
        $query = $this->db->get("tbl_lho");	
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
	public function GetTotalLhoRecord() {	
		$this->db->select('count(*) as total');	
		
		$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		
        $query = $this->db->get("tbl_lho as u");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetLhoRecordByid($id) {
        $this->db->where('id', $id);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
				$query = $this->db->get("tbl_lho");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetLhoRecordByBank() {
		$this->db->where('status != ', 5);
				$query = $this->db->get("tbl_lho");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetLhoRecords($start=0, $limit=10) {		
		
		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title')));
		
		$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR tb.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_lho as u");
        
       
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
	public function save_lho_data($image=null) {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$bank_id = $this->input->post('bank');		
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$country = $this->input->post('country_id');
		$state = $this->input->post('state_id');		
		$city = $this->input->post('city_id');
		$street = $this->input->post('street');		
		$zip = $this->input->post('zip');		
		$phone = $this->input->post('phone');		
		$fax = $this->input->post('fax');		
		//$status = $this->input->post('status');
		
		$data = array(
					'name'=>$name,
					'bank_id'=>$bank_id,
					'status'=>1,
					'address1'=>$address1,
					'address2'=>$address2,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city,
					'street'=>$street,
					'zip'=>$zip,
					'phone'=>$phone,
					'fax'=>$fax,
					'status' =>1
				);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_lho', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_lho',$data); 
			//$id = $this->db->insert_id();

		}
		return true;
	}
	public function GetTotalRegionRecord($bank_id='') {	
		//$this->db->select('count(*) as total');	
			//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title'))); 
		$status	= trim($this->input->get('status1'));
		//if($status != '')
		//$this->db->where('status', $status);
		//if($title != '')
		//$this->db->like('name', $title);
		//serach query ends//
		
		
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.name like ' . "'%" . $title . "%'   OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		
		
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_region as u");	*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.name", "tb.name", "zone.name" , "u.id");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_region as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_zone as zone ON zone.zone_id = u.zone_id WHERE 1  ";

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
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		$query = $this->db->query($query);
        
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetRegionRecordByid($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_region");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetRegionRecordByBank($bank_id) {
        $this->db->where('BankId', $bank_id);
		$this->db->where('status != ', 5);
				$query = $this->db->get("tbl_region");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetRegionRecords($start=0, $limit=10) {;		
		
		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title'))); 
		$status	= trim($this->input->get('status1'));
	
	
			
		/*$this->db->select("u.*");
		if ($title != '')
		{
			$status = $title;
			if(strtolower($title) == 'active')
			{
				$status = 1;
			}
			else if(strtolower($title) == 'inactive')
			{
				$status = 0;
			}

			$this->db->where('(u.name like ' . "'%" . $title . "%'   OR tb.name like " . "'%" . $title . "%' OR zone.name like " . "'%" . $title . "%' OR u.id like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_bank as tb','tb.id = u.bank_id','left');
		$this->db->join('tbl_zone as zone','zone.id = u.zone_id','left');
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
        $query = $this->db->get("tbl_region as u");	*/
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.name", "tb.name", "zone.name" , "u.id");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_region as u LEFT JOIN tbl_bank as tb ON tb.id = u.bank_id LEFT JOIN tbl_zone as zone ON zone.zone_id = u.zone_id WHERE 1  ";

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
		
		$query .= " AND u.status != 5  ";
		$query .= "ORDER BY u.id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
        
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
    
	public function save_region_data($image=null) {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$bank_id = $this->input->post('bank');
		$lho_id = $this->input->post('lho_id');

		$zone_id = $this->input->post('zone');	
		$address1 = $this->input->post('address1');
		$address2 = $this->input->post('address2');
		$country = $this->input->post('country_id');
		$state = $this->input->post('state_id');		
		$city = $this->input->post('city_id');
		$street = $this->input->post('street');		
		$zip = $this->input->post('zip');		
		$phone = $this->input->post('phone');		
		$fax = $this->input->post('fax');		
		$status = $this->input->post('status');
		
		$data = array(
					'name'=>$name,
					'bank_id'=>$bank_id,
					'lho_id'=>$lho_id,
					'zone_id'=>$zone_id,
					'status'=>$status,
					'address1'=>$address1,
					'address2'=>$address2,
					'country'=>$country,
					'state'=>$state,
					'city'=>$city,
					'street'=>$street,
					'zip'=>$zip,
					'phone'=>$phone,
					'fax'=>$fax,
					'status' =>$status
				);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_region', $data); 
		}
		else
		{			
			$data['indate']=date('Y-m-d H:i:s');			
			$this->db->insert('tbl_region',$data); 
			//$id = $this->db->insert_id();

		}
		return true;
	}
	public function GetC1zoneRecords() {		
		$this->db->where('status', 1);
		$this->db->order_by("id", "desc");
		
        $query = $this->db->get("tbl_c1zone");	
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
	public function taxCalculate() {		
		$this->db->where('status', 1);
		$this->db->where("id", 1);
        $query = $this->db->get("tbl_taxmaster");
		$result=$query->result();
		//echo $this->db->last_query();
		$amount = $this->input->post('amount');
		$stax=($amount*$result[0]->stax)/100;
		$educess=($amount*$result[0]->educess)/100;
		$secondaryhighertax=($amount*$result[0]->secondaryhighertax)/100;
		$total=$amount+$stax+$educess+$secondaryhighertax;
		$data['stax']=$stax;
		$data['educess']=$educess;
		$data['secondaryhighertax']=$secondaryhighertax;
		$data['total']=$total;
		return $data;
    }
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		//$config['max_width']  = '105';
		//$config['max_height']  = '100';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
			echo '<script>alert("'.$this->upload->display_errors().'")</script>';
		}else{
			$upload_data = $this->upload->data();
			if($upload_data['file_name'])
			return '/'.$this->path.$upload_data['file_name'];
			
			return false;
		}							
	}
        function upload2($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|zip';
		$config['max_size'] = '5120';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		//$config['max_width']  = '105';
		//$config['max_height']  = '100';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
			echo '<script>alert("'.$this->upload->display_errors().'")</script>';
		}else{
			$upload_data = $this->upload->data();
			if($upload_data['file_name'])
			return '/'.$this->path.$upload_data['file_name'];
			
			return false;
		}							
	}
    function findBankBranch($data) {
        $this->db->where('bank_id', $data['bankid']);
		$this->db->where('zone_id', $data['zone']);
		$this->db->where('region_id', $data['region']);
		$this->db->where('drt_id', $data['drt']);
        $this->db->where("name", $data['brancName']);
		if(!empty($data['id'])) {
			$this->db->where("id !=", $data['id']);
		}
        $total = $this->db->get("tbl_branch")->num_rows();
		if($total>0) {
			return 1;
		} else {
			return 0;
		}
    }
    
    public function GetAccountTypeRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("account_name", "ASC");
        $query = $this->db->get("tblmst_account_type");	
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
    
    public function GetUOMtypeRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("uom_name", "ASC");
        $query = $this->db->get("tblmst_uom_type");	
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
    
    public function GetHeightUOMtypeRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("height_uom_name", "ASC");
        $query = $this->db->get("tblmst_height_uom_type");	
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
	
	public function GetZoneData() {
		
		$this->db->where('status', 1);
		$this->db->order_by("zone_id", "ASC");
        $query = $this->db->get("tbl_zone");	
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
    
    public function uniquezone($name,$id) {
		$this->db->where('zone_id !=', $id);
		$this->db->where('zone_name', $name);
		$query = $this->db->get("tbl_zone");
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
	
	public function getApproverData() {
		
		$this->db->where('status', 1);
		$this->db->where('role_id',2);
		$this->db->order_by("zone_id", "ASC");
        $query = $this->db->get("tbl_user");	
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
    
    public function GetDeptRecord() {
		
		$this->db->where('status', 1);
		$this->db->order_by("department_name", "asc");
        $query = $this->db->get("tblmst_department");	
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
    
     public function GetAssigned_dept($user_id) {
		 
		$user_id = $this->uri->segment(4);
		$this->db->select('department_id');
		$this->db->where('user_id', $user_id);
		$this->db->where('status',1);
		$this->db->from("tbl_user_assign_department");
		
        $query = $this->db->get();	
			//echo $this->db->last_query();die;
		
       if($query->num_rows()>0)
        {
			$arrData =array();
			foreach($query->result_array() as $arr)
			{
				$arrData[] = $arr['department_id'];
				//print_r($arr['department_id']);             
			}
			return $arrData;
		}
		
		return false;
	}
    
    public function GetAssigned_roles() {
		 
		 $user_id = $this->uri->segment(4);
		 $department_id = $this->uri->segment(5);
		 
		 $this->db->select('role_id');
		 $this->db->where('user_id', $user_id);
		 $this->db->where('department_id',$department_id);
		 $this->db->where('status',1);
		 $this->db->from("tbl_user_department");
		 $this->db->order_by("user_id", "asc");
		
        $query = $this->db->get();
			//echo $this->db->last_query();die;
		
        if($query->num_rows()>0)
        {
			$arrData =array();
			foreach($query->result_array() as $arr)
			{
				$arrData[] = $arr['role_id'];
				//print_r($arr['role_id']);die;       
			}
			return $arrData;
			
		}
		
		return false;
		}
    
    
    public function addDepCategorybyBranchId($user_id) 
	 {
		$id = $this->input->post('id');
		$user_id = $this->uri->segment(4);
		$user_deptArr = $this->input->post('departments');
		$user_dept = implode(',',$user_deptArr);
		$roleArr = $this->input->post('role');
		$role = implode(',',$roleArr);
		$date = date('Y-m-d H:i:s');
		
		$data = array(
                'department_id' => $user_dept,
                'date_modified' => date('Y-m-d H:i:s'),
                 'role_id' => $role
            );
		
		 if ($id) {
            $this->db->where('user_deprt_id', $id);
            $this->db->update('tbl_user_department', $data);
        } else {
            $data['date_created'] = date('Y-m-d H:i:s');
            $data = array(
               'user_id' => $user_id,
               'status' => 1
            );
            $this->db->insert('tbl_user_department', $data);
            
        }
        return true;	
					
    }
    
    public function addUserDept($user_id){
		
		$user_id = $this->uri->segment(4);
		$user_deptArr = $this->input->post('departments');
		
		$this->db->where(array('user_id'=>$user_id));
		$this->db->update('tbl_user_assign_department',array('status'=>0));	
		
		
		$this->db->where(array('user_id'=>$user_id));	
		$this->db->update('tbl_user_department',array('status'=>0));		
		
		foreach($user_deptArr as $user_dept) {
			
			$data = array(
				'user_id' => $user_id,
				'department_id' => $user_dept,
				'status' => 1,
				'date_created'=>date('Y-m-d H:i:s')				
			);			
			$this->db->insert('tbl_user_assign_department', $data);
			
			
			$uDeptArr = array(					
					'status' => 0,
			);
			$this->db->where(array('user_id'=>$user_id,'department_id' => $user_dept));	
			$this->db->update('tbl_user_department', $uDeptArr);
			
		}  
			return true;			
		}
		
	 public function addUserRole($user_id,$department_id){
		$id = $this->input->post('id');
		$user_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);
		$user_roleArr = $this->input->post('role');	
		
		$this->db->where(array('user_id'=>$user_id,'department_id'=>$department_id));
		$this->db->update('tbl_user_department',array('status'=>0));
		
		foreach($user_roleArr as $user_role) 
		{
			
			$data = array(
			'user_id' => $user_id,
			'department_id' => $department_id,
			'role_id' => $user_role,
			'status' => 1,
			'date_created'=>date('Y-m-d H:i:s')				
			);
			$this->db->insert('tbl_user_department', $data);
		}  
		return true;			
	}
		
	  
    public function GetMstBank($bank_id=null) {
		$this->db->where('status', 1);		
		if($state_id){
		$this->db->where("bank_id", $bank_id);		
		}
		$this->db->order_by("bank_name", "asc");
        $query = $this->db->get("tblmst_bank");
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
    
    public function GetCasteCategoryRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("caste_category_name", "ASC");
        $query = $this->db->get("tbl_caste_category");	
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
    
    public function GetLocationRecords() {
		
		$this->db->where('status', 1);
		$this->db->order_by("location_name", "ASC");
        $query = $this->db->get("tbl_location");	
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

}
