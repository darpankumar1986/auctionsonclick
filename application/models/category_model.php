<?php
class Category_model extends CI_Model {
    
	private $path = 'public/uploads/category/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRecords($parent_id = 0) {
        $this->db->where('parent_id', $parent_id);
		$this->db->where('status', 1);
		if($parent_id == 0)
		$this->db->where('menu_item', 1);
		$this->db->order_by("priority", "asc");
		$query = $this->db->get("tbl_category");
		//echo $this->db->last_query();
        $data = array();
		if ($query->num_rows() > 0) {
			$i = 0;
            foreach ($query->result() as $row) {
			    $data[$i] = $row;
				
				$child_array = $this->GetRecords($row->id);
				if(sizeof($child_array) > 0){
				if($row->parent_id != 0){
					$parent_catg = $this->category_model->GetRecordById($row->parent_id);
					$data[$i]->parent_slug = $parent_catg->slug;
				}
					$data[$i]->child = 	$child_array;
				}
				$i++;
            }
            return $data;
        }
        return false;
    }
	
	public function GetSubRecords() {
		echo "Test";
        $this->db->where('parent_id', 0);
				//Remove deleted category from list
				$this->db->where('status !=', 5);				
				$query = $this->db->get("tbl_category");
				//echo $this->db->last_query(); 
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
			    $row->parent_name = '';
				//$data[] = $row;
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
	
	public function GetHomeRecords() {
        $this->db->where('status', 1);
		$this->db->where('show_home', 1);
		$this->db->order_by("priority", "asc");
		$query = $this->db->get("tbl_category");
				
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetParentRecords() {
        $this->db->where('parent_id', 0);
				//Remove deleted category from list
				$this->db->where('status !=', 5);
				
		$query = $this->db->get("tbl_category");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecordsFooter($parent_id) {
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
	
	public function uniqueCategory($name, $parent_id, $id) {
			$this->db->where('id !=', $id);
			$this->db->where('name', $name);
			$this->db->where('parent_id', $parent_id);
			//$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_category");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
	}
	
	
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_category");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }		
	
	public function GetRecordBySlug($slug, $sub_catg_slug = '0') 
	{
		if($sub_catg_slug == '0'){
			$this->db->from('tbl_category');
			$this->db->where('slug', urldecode($slug));
			$this->db->where('status', 1);
			$this->db->where('parent_id', 0);
			$this->db->order_by('id',"ASC");
		}
		else{
	    $this->db->select('c.*');
            $this->db->from('tbl_category as p');
            $this->db->join('tbl_category as c', 'p.id = c.parent_id','left');
            $this->db->where('p.slug',  urldecode($slug));
            $this->db->where('c.slug',  urldecode($sub_catg_slug));
            $this->db->where('c.status', 1);
            $this->db->order_by('c.id',"ASC");
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
        
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function findObjectById($id,$array)
	{
		foreach($array as $element)
		{
			if ( $id == $element->slug )
			{
				return $element;
			}
		}
	return false;
	}	
	
}