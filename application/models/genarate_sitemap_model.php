<?php
class Genarate_sitemap_model extends CI_Model {
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRecord() {
		$this->db->select('id , slug, date_published, category_id, title, tags');
		$this->db->where('status !=', 5);
		$this->db->where('date_published <= ', date('Y-m-d'));
		$query = $this->db->get("tbl_article");
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {         
			
			list($image,$title) = $this->getGalleryImage($row->id);
			$cat_slug = $this->getCategorySlug($row->category_id);
			$row->cat_slug= $cat_slug;
			$row->image=$image;
			$row->image_title= $title;
			$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	public function getGalleryImage($article_id)
	{
			$this->db->select('image , title');
			$this->db->where('article_id', $article_id);
			$this->db->where('status', 1);
			$this->db->limit(1);
			$query = $this->db->get("tbl_article_images");
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return array($row[0]->image,$row[0]->title);
			}        
		
		return false;
	}
	public function getCategorySlug($category_id)
	{
			$this->db->select('slug');
			$this->db->where('id', $category_id);
			$this->db->where('status', 1);
			$query = $this->db->get("tbl_category");
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return $row[0]->slug;
			}        
		
		return false;
	}
	public function GetAuthor() {
        //$this->db->where('id', $author_id);
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_author");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function getAllCategory()
	{
			$this->db->where('parent_id', 0);
			$this->db->where('status', 1);
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
	public function getAllSubCategory()
	{
			$this->db->where('parent_id !=0');
			$this->db->where('status', 1);
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
	public function GetRSSRecord($category_id='') {
		$this->db->select('id ,title,excerpt, slug,date_published,category_id');
		$this->db->where('status !=', 5);
		if($category_id!='')$this->db->where("(category_id = $category_id or category_id in (select id from tbl_category where parent_id = $category_id and status = 1))");
		$this->db->where('date_published <= ', date('Y-m-d'));
		$query = $this->db->get("tbl_article");
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {         
			
			list($image,$title) = $this->getGalleryImage($row->id);
			$cat_slug = $this->getCategorySlug($row->category_id);
			$row->cat_slug= $cat_slug;
			$row->image=$image;
			$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	

	
}