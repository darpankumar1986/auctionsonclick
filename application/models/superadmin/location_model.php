<?php
class Location_model extends CI_Model {
	
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
		$columns = array("u.location_id", "u.location_name", "city.city_name", "state.state_name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_location as u LEFT JOIN tbl_city as city ON city.id = u.cityID LEFT JOIN tbl_state as state ON state.id = u.stateID WHERE 1  ";

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
		$query .= "ORDER BY u.location_id DESC ";
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
		
        $query = $this->db->get("tbl_location as u");	*/
        
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.location_id", "u.location_name", "city.city_name", "state.state_name");
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_location as u LEFT JOIN tbl_city as city ON city.id = u.cityID LEFT JOIN tbl_state as state ON state.id = u.stateID WHERE 1  ";

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
		$query .= "ORDER BY u.location_id DESC ";
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
        $this->db->where('location_id', $id);
				$query = $this->db->get("tbl_location");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
  
    
	public function save_data($image=null) {
		$id = $this->input->post('id');
		$location_name = $this->input->post('location_name');
		$city_id = $this->input->post('city_id');
		$state_id = $this->input->post('state_id');
		$status = $this->input->post('status');
		$country_id = $this->input->post('country_id');
		$data = array(
					'CountyCode'=>$country_id ,
					'location_name'=>$location_name,
					'cityID'=>$city_id ,
					'stateID'=>$state_id ,
					'status'=>$status
					);
		if($id)			
		{			
			$this->db->where('location_id', $id);
			$this->db->update('tbl_location', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_location',$data); 
		}
		return true;
	}
	
 	public function uniqueLocation($name,$city_id,$state_id, $id) {
			$this->db->where('location_id !=', $id);
			$this->db->where('location_name', $name);
			$this->db->where('cityID', $city_id);
			$this->db->where('stateID', $state_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_location");
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
}

?>
