<?php
class City_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('superadmin/role_model');
	}
	
	public function GetTotalRecord() {	
			//search query start//
		$title 	= trim($this->input->get('title')); 
		        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.city_name", "state.state_name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_city as u LEFT JOIN tbl_state as state ON state.id = u.stateID WHERE 1  ";

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
		$title 	= trim($this->input->get('title')); 
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

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.city_name like " . "'%" . $title . "%' OR state.state_name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
		
		$this->db->where('u.status != ', 5);
		$this->db->join('tbl_state as state','state.id = u.stateID','left');
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_city as u");	*/
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.city_name", "state.state_name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_city as u LEFT JOIN tbl_state as state ON state.id = u.stateID WHERE 1  ";

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
  
  public function GetRecordById($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_city");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
  
    
    
    
    public function GetTotalRecord_enquiry() {	
		$this->db->select('count(*) as total');	
			//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != ''){
		$this->db->where('status', $status);
                }
		$query = $this->db->get("tbl_enquiry_details");
		
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords_enquiry($start=0, $limit=10) {
		$this->db->where('status !=', 5);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		//$this->db->like('city_name', $title);
		//serach query ends//
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get(" tbl_enquiry_details");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
  
  public function GetRecordById_enquiry($id) {
        $this->db->where('id', $id);
	$query = $this->db->get("tbl_enquiry_details");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
  function checkcityAttributeExist($cityID)
  {
	  
	$row=$this->db->query("SELECT count(a.id) as total from tbl_auction as a INNER JOIN tbl_bank as b ON a.bank_id=b.id AND b.city= '$cityID'")->row();  
	return $row->total;   
	  
  }
  
  
  
	
	
	
	public function save_data($image=null) {
		$id = $this->input->post('id');
		$city_name = $this->input->post('name');
		$state_id = $this->input->post('state_id');
		$status = $this->input->post('status');
		$country_id = $this->input->post('country_id');
		$data = array(
					'CountyCode'=>$country_id ,
					'city_name'=>$city_name ,
					'stateID'=>$state_id ,
					'status'=>$status
					);
		if($id)			
		{			
			$this->db->where('id', $id);
			$this->db->update('tbl_city', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_city',$data); 
		}
		return true;
	}
	
 	public function uniqueCity($name,$state_id, $id) {
			$this->db->where('id !=', $id);
			$this->db->where('city_name', $name);
			$this->db->where('stateID', $state_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_city");
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
}

?>
