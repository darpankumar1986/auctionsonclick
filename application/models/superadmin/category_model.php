<?php
class Category_model extends CI_Model {
    
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
		$columns = array("u.id", "u.name","b.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_category as u LEFT JOIN tbl_category as b ON u.parent_id = b.id WHERE 1  ";

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
		
		$query .= " AND u.status != 5 AND u.parent_id != 0 ";
		$query .= " ORDER BY u.id DESC ";
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
		$columns = array("u.id", "u.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT count(*) as total FROM tbl_category as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5 AND u.parent_id = 0 ";
		$query .= " ORDER BY u.id DESC ";
		$query = $this->db->query($query);
		
        $query = $this->db->get("tbl_category as u");		
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords() {
        $this->db->where('parent_id', 0);
				//Remove deleted category from list
				//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->where('id', $title);
		//serach query ends//
				$this->db->where('status !=', 5);
				$query = $this->db->get("tbl_category");
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
		$this->db->join('tbl_category as b','u.parent_id = b.id','left');
		$this->db->order_by("u.parent_id", "desc");
		$this->db->order_by("u.id", "desc");
		$this->db->limit($limit,$start);
		
        $query = $this->db->get("tbl_category as u");	*/


		 $searchq = $title;
		$words = explode(" ", $searchq);
		$wordCount = count($words);

		// declare which columns should be searched
		$columns = array("u.id", "u.name","b.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.*, b.name as parent_name FROM tbl_category as u LEFT JOIN tbl_category as b ON u.parent_id = b.id WHERE 1  ";

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
		
		$query .= " AND u.status != 5 AND u.parent_id != 0 ";
		$query .= " ORDER BY u.id DESC ";
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
		$columns = array("u.id", "u.name" );
		$columnCount = count($columns);

		// start from a basic query, which we will expand later
		$query = "SELECT u.* FROM tbl_category as u WHERE 1  ";

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
		
		$query .= " AND u.status != 5 AND u.parent_id = 0 ";
		$query .= " ORDER BY u.id ASC ";
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
        $this->db->where('parent_id', 0);
		$this->db->where('status', 1);
		$this->db->order_by("id", "asc");
		$query = $this->db->get("tbl_category");
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecords($parent_id) {
		
		$this->db->where('parent_id', $parent_id);
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_category");
		
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
		$query = $this->db->get("tbl_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function uniqueCategory($name, $parent_id, $id) {
			$this->db->where('id !=', $id);
			$this->db->where('name', $name);
			$this->db->where('parent_id', $parent_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_category");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_category_data($image=null) {
		$id = $this->input->post('id');
		$parent_id = $this->input->post('parent_id');
		$name = $this->input->post('name');
		$slug = $this->input->post('slug');
		$priority = $this->input->post('priority');
		$show_home = $this->input->post('show_home');
		$menu_item = $this->input->post('menu_item');	
		$status = $this->input->post('status');				
		$meta_title = $this->input->post('meta_title');
		$meta_description = $this->input->post('meta_description');		
		$meta_keywords = $this->input->post('meta_keywords');		
		$created_by = $this->session->userdata('adminid');
		
		if(!$priority){
			$priority = SetPriority('tbl_category', "and parent_id = $parent_id");
		}
		
		$data = array('parent_id'=>$parent_id ,
					'name'=>$name ,
					'image'=>$image,	
					'slug'=>$slug,	
					'priority'=>$priority,
					'show_home'=>$show_home,
					'menu_item'=>$menu_item,
					'status'=>$status,
					'meta_title'=>$meta_title,
					'meta_description'=>$meta_description,
					'meta_keywords'=>$meta_keywords,
					'created_by'=>$created_by
					);
		if($id)			
		{
			if(empty($slug))$slug=$name;
			$data['slug'] = url_title($slug, '-', TRUE);
			//$data['slug'] = GetSlugTitle($slug, $id);
			
			$data['date_modified']=date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			$this->db->update('tbl_category', $data); 
		}
		else
		{
			$data['slug'] = '';
			$data['date_created']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_category',$data); 
			$id = $this->db->insert_id();
			if(empty($slug))$slug=$name;
			$data['slug'] = url_title($slug, '-', TRUE);
			//$data['slug'] = GetSlugTitle($slug, $id);
			$this->db->where('id', $id);
			$this->db->update('tbl_category', $data);
			
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
        $query = $this->db->get('tbl_category');
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
		$query = $this->db->get("tbl_category");
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
}
