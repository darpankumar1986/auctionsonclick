<?php
class Caste_category_model extends CI_Model {
    
	private $path = 'public/uploads/category/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetSubTotalRecord() {	
		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title')));
     
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.caste_category_id", "u.caste_category_name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_caste_category as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5";
		$query .= " ORDER BY u.caste_category_id DESC ";
		$query = $this->db->query($query);
		
			
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetTotalRecord() {	
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

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%'  OR u.status like " . "'%" . $status . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('u.parent_id = ', 0);*/
		
		
		$searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.caste_category_id", "u.caste_category_name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_caste_category as u WHERE 1  ";

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
		$query .= " ORDER BY u.caste_category_id DESC ";
		$query = $this->db->query($query);
		
        $query = $this->db->get("tbl_caste_category as u");		
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords() {        
		
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->where('id', $title);
		//serach query ends//
				$this->db->where('status !=', 5);
				$query = $this->db->get("tbl_caste_category");
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
			    $row->parent_name = '';
				$data[] = $row;
				$child_array = $this->GetChildRecords($row->id);
				if(sizeof($child_array) > 0){
					foreach ($child_array as $child) {
						$child->parent_name = $row->name;
						$data[] = $child;
					}	
				}
            }
            return $data;
        }
        return false;
    }
	
	public function GetSubRecords($start=0, $limit=0) 
	{

		$title 	= str_replace("'","",trim($this->input->get('title')));

		/*$this->db->select("u.*, b.name as parent_name");
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

			$this->db->where('(u.id like ' . "'%" . $title . "%'   OR u.name like " . "'%" . $title . "%'  OR u.status like " . "'%" . $status . "%'  OR b.name like " . "'%" . $title . "%') ");
		}

		$this->db->where('u.status != ', 5);
		$this->db->where('u.parent_id !=', 0);	
		$this->db->join('tbl_caste_category as b','u.parent_id = b.id','left');
		$this->db->order_by("u.parent_id", "desc");
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_caste_category as u");	*/


		 $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.caste_category_id", "u.caste_category_name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_caste_category as u WHERE 1  ";

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
		$query .= " ORDER BY u.caste_category_id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		
		

		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }				
            return $data;
        }        
		return false;
    }
	
	public function GetParentRecords($start=0, $limit=10) {

		//search query start//
		$title 	= str_replace("'","",trim($this->input->get('title')));
		
        
        $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.caste_category_id", "u.caste_category_name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_caste_category as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5";
		$query .= " ORDER BY u.caste_category_id DESC ";
		 $query .= " LIMIT ".$start.", ".$limit."";
		$query = $this->db->query($query);
		


		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetParentRecordsControl() {        
		$this->db->where('status', 1);
		$this->db->order_by("caste_category_name", "asc");
		$query = $this->db->get("tbl_caste_category");
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecords($parent_id) {
		
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_caste_category");
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecordsControl($parent_id) {
        $this->db->where('parent_id', $parent_id);
		
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_caste_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function uniqueCategory($name,$id) {
			$this->db->where('caste_category_id !=', $id);
			$this->db->where('caste_category_name', $name);						
			$query = $this->db->get("tbl_caste_category");	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
	
	public function GetRecordById($id) {
        $this->db->where('caste_category_id', $id);
				$query = $this->db->get("tbl_caste_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_category_data() {
		$caste_category_id = $this->input->post('caste_category_id');		
		$caste_category_name = $this->input->post('caste_category_name');
		$status = $this->input->post('status');								
		$data = array(
				'caste_category_name'=>$caste_category_name ,					
				'status'=>$status,
				);
		if($caste_category_id)			
		{						
			$data['modified_date']=date('Y-m-d H:i:s');
			$this->db->where('caste_category_id', $caste_category_id);
			$this->db->update('tbl_caste_category', $data); 
		}
		else
		{
			$data['inDate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_caste_category',$data); 
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
		
	function create_nested_category($parent_id = 0) {
        $items = array();
        $this->db->where('parent_id', $parent_id);
        $query = $this->db->get('tbl_caste_category');
        $results = $query->result();
    	foreach($results as $result) {
			$child_array = $this->create_nested_category($result->id);
			if(sizeof($child_array) == 0){
                array_push($items, $result);
            }else{
                array_push($items, array($result, $child_array));
            }
        }        
        return $items;
    }

	public function uniqueSlug($slug, $id) {
		$this->db->where('id !=', $id);
		$this->db->where('slug', $slug);
		$query = $this->db->get("tbl_caste_category");
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
}
