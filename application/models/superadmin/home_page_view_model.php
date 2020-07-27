<?php
class Home_page_view_model extends CI_Model {
    
	private $path = 'public/uploads/home_page_view/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	
	public function GetRecords() {
		$this->db->select("id, name");
		$this->db->where('status', 1);
		$this->db->where('show_home', 1);
		//$this->db->where('parent_id', 0);
		$this->db->order_by('priority ASC');		
		$query = $this->db->get("tbl_category");
		
		//echo $this->db->last_query();
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
	
	public function GetArticleById($id) {
		$today_date=date("Y-m-d");
		$this->db->select("title, id");
        $this->db->where("(category_id = $id ||  category_id IN (select id from tbl_category where parent_id = $id))");
		$this->db->where('status', 1);
		$this->db->where('home_page', 1);
		$this->db->where('date_published <=', $today_date);
		$this->db->order_by('priority ASC');
		$query = $this->db->get("tbl_article");

        if ($query->num_rows() > 0) {
			$data = array();
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	
	public function save_home_page_view_data($data) {
		
		
		foreach($data['catg_sort'] as $key=>$category){
			$priority=$key+1;
			$category_data = array('priority'=>$priority );
			if($category)			
			{
				$this->db->where('id', $category);
				$this->db->update('tbl_category', $category_data); 
			}
		}
		
		 
		foreach($data['article_sort'] as $key=>$category_article){			
			foreach($category_article as $key1=>$article){
				$priority=$key1+1;
				$article_data = array('priority'=>$priority );
				if($article)			
				{
					$this->db->where('id', $article);
					$this->db->update('tbl_article', $article_data); 
				}
			}
		}
        
		return true;
	}

	
}