<?php
class C1zone_model extends CI_Model {
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetTotalRecord() 
	{	
		//$this->db->select('count(*) as total');	
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

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
	
		$this->db->where('u.status != ', 5);
		
        $query = $this->db->get("tbl_c1zone as u");	*/
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_c1zone as u WHERE 1  ";

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
		

        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetRecord($start=0, $limit=10) {
		
		//search query start//
		$title 	= trim($this->input->get('title')); 

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

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%' OR u.status like " . "'%" . $status . "%') ");
		}
	
		$this->db->where('u.status != ', 5);
		
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_c1zone as u");	*/
        
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_c1zone as u WHERE 1  ";

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
	public function GetRecords() {
		$this->db->where('status !=', 5);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$query = $this->db->get("tbl_c1zone");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$row->parent_name = '';
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
  
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_c1zone");
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
		$name = $this->input->post('name');		
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
					'status'=>$status
				);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_c1zone', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_c1zone',$data); 
		}
		return true;
	}

	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
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
}
