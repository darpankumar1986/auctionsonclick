<?php
class Article_model extends CI_Model {
    
	private $path = 'public/uploads/category/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetRelatedRecord($category_id, $article_id=null) {        
		$this->db->select('a.author_id,a.id, a.title, a.description, a.image, a.other, a.slug, a.excerpt, a.date_published , c.parent_id, c.slug as category_slug');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		
		$this->db->where("(a.category_id = '$category_id' or a.category_id in (select id from tbl_category where parent_id = '$category_id' and status = 1))");
		$this->db->where('a.id != ', $article_id);
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->where('a.status', 1);
		$this->db->order_by("a.date_published", "desc");
		$this->db->limit(6);
		$query = $this->db->get();
		//echo $this->db->last_query();       
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ",$data_author);
				//End get multiple author
				if($row->parent_id != 0){
					$parent_catg = $this->category_model->GetRecordById($row->parent_id);
					$row->category_parent_slug = $parent_catg->slug;
				}
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
			return $data;
		}
		return false;
    }
	
	public function GetRecordByCategoryId($category_id, $limit=5, $start=0) {        
		$this->db->select('a.author_id,a.id, a.title, a.description, a.image, a.other, a.slug, a.excerpt, a.date_published , c.parent_id, c.slug as category_slug');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.id', 'left');
		
		$this->db->where('a.category_id', $category_id);
		$this->db->where('a.status', 1);
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->order_by("a.date_published", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo "<pre>";
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->parent_id != 0){
					$parent_catg = $this->category_model->GetRecordById($row->parent_id);
					$row->category_parent_slug = $parent_catg->slug;
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ", $data_author);
				//End get multiple author
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	public function GetTotalCategoryRecord($category_id) {	
		$this->db->select('count(*) as total');
		$this->db->where('category_id', $category_id);
		$this->db->where('date_published <= ', date('Y-m-d'));
		$this->db->where('status', 1);
		$query = $this->db->get("tbl_article");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetRecordByAuthorId($author_id, $limit=5, $start=0) {        
		$this->db->select('a.author_id,a.id, a.title, a.description, a.image, a.other, a.slug, a.excerpt, a.date_published,a.category_id, c.parent_id, c.slug as category_slug');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		
		$this->db->where('a.author_id', $author_id);
		$this->db->where('a.status', 1);
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->order_by("a.date_published", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo "<pre>";
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ", $data_author);
				//End get multiple author
				
				list($image, $photo_credit, $photo_credit_url) = $this->getGalleryImage($row->id);
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				if($row->parent_id != 0){
					$parent_catg = $this->category_model->GetRecordById($row->parent_id);
					$row->category_parent_slug = $parent_catg->slug;
				}
				
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	
	public function GetRecordBySlug($slug) {
        $this->db->where('slug', urldecode($slug));
		$this->db->where('status !=', 5);
		$this->db->where('date_published <= ', date('Y-m-d'));
		$query = $this->db->get("tbl_article");
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
			
			list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$data->imageMedium='gallery/'. $imageMedium;
				$data->imageThumb='gallery/'. $imageThumb;
				$data->image='gallery/'. $image;
				$data->photo_credit= $photo_credit;
				$data->photo_credit_url= $photo_credit_url;
				
            return $data;
        }
        return false;
    }
	public function GetHomePageGallery($category_id=''){
		$articles = $this->GetHomePageArticle('home_page', $category_id, '5', 0);
		
		foreach ($articles as $article) {
			$this->db->select('title, image, photo_credit');
			$this->db->where('article_id', $article->id);
			$this->db->where('status', 1);
			$this->db->where('type', 'home');
			$this->db->order_by("home_page desc, priority asc");
			//$this->db->order_by("id desc");
			$this->db->limit(1);
			$query = $this->db->get("tbl_article_images");
			
			$this->db->select('count(*) as cnt');
			$this->db->where('article_id', $article->id);
			$this->db->where('status', 1);
			$query_cnt = $this->db->get("tbl_article_images");
			$row_cnt = $query_cnt->row();
			
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$row->cnt = $row_cnt->cnt;
					$row->slug = $article->slug;
					$row->category_slug = $article->category_slug;
					$row->category_parent_slug = $article->category_parent_slug;
					$data[] = $row;
				}
			}        
		}
		return $data;
	}
	
	public function GetHomePageArticle($type = 'home_page', $category_id = '', $limit=3, $start=0) {        
		$this->db->select('a.id, a.author_id, a.title, a.image, a.other, a.slug, a.excerpt, a.date_published, a.category_id,d.slug as category_parent_slug, c.slug as category_slug, c.name as category_name, pu.name as publication_name');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		$this->db->join('tbl_category as d', 'd.id = c.parent_id', 'left');
		$this->db->join('tbl_publication as pu', 'pu.id = a.publication_id', 'left');
		if($category_id != ''){
			$this->db->where("(a.category_id = '$category_id' or a.category_id in (select id from tbl_category where parent_id = '$category_id' and status = 1))");
		}
		
		$this->db->where('a.status', 1);
		if($type == 'carousel'){
			$this->db->where('carousel', 1);
		}
		else
		{
			//$this->db->where('home_page', 1);
		}

		$this->db->where('a.date_published <= ', date('Y-m-d'));
		//$this->db->order_by("a.priority", "asc");
		
		$this->db->order_by("a.home_page desc, a.date_published desc, a.id desc");
		$this->db->limit($limit, $start);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
        
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ",$data_author);
				//End get multiple author
				
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	public function GetLatestArticle($limit=3, $start=0 ) {        
		$this->db->select('a.title, a.slug, a.date_published,d.slug as category_parent_slug ,  c.slug as category_slug ');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		$this->db->join('tbl_category as d', 'd.id = c.parent_id', 'left');
		$this->db->where('a.status', 1);		
		$this->db->order_by("a.id", "desc");
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->limit($limit, $start);		
		$query = $this->db->get();
		//echo $this->db->last_query();
        
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	public function GetMostArticle($limit=3, $start=0 ) {        
		$this->db->select('a.title, a.slug, a.date_published,  d.slug as category_slug,  c.slug as category_parent_slug ');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		$this->db->join('tbl_category as d', 'd.id = c.parent_id', 'left');
		$this->db->join('tbl_most_view as mv', 'mv.articleSlug = a.slug', 'left');
		
		$this->db->where('a.status', 1);
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->where('mv.type', 7);
		$this->db->order_by("mv.views", "desc");
		
		$this->db->limit($limit, $start);		
		$query = $this->db->get();
		//echo $this->db->last_query();
        
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	public function GetBoltiTasvir( $category_id = '31', $limit=1, $start=0) {        
		$this->db->select('a.id, a.author_id, a.title, a.image, a.other, a.slug, a.excerpt, a.date_published, a.category_id, c.slug as category_slug, c.name as category_name, pu.name as publication_name');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		$this->db->join('tbl_publication as pu', 'pu.id = a.publication_id', 'left');
		if($category_id != ''){
			$this->db->where("(a.category_id = '$category_id' or a.category_id in (select id from tbl_category where parent_id = '$category_id' and status = 1))");
		}
		
		$this->db->where('a.status', 1);
		if($type == 'carousel'){
			$this->db->where('carousel', 1);
		}
		else
		{
			//$this->db->where('home_page', 1);
		}

		$this->db->where('a.date_published <= ', date('Y-m-d'));
		//$this->db->order_by("a.priority", "asc");
		$this->db->order_by("a.id desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
        
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ",$data_author);
				//End get multiple author
				
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	
public function getGalleryImage($article_id,$type='home')
	{
			$this->db->select('image , photo_credit, photo_credit_url');
			$this->db->where('article_id', $article_id);
			$this->db->where('status', 1);
			$this->db->where('type', $type);
			$this->db->limit(1);
			$this->db->order_by('priority asc, home_page DESC');
			$query = $this->db->get("tbl_article_images");
			
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return array($row[0]->image,$row[0]->photo_credit,$row[0]->photo_credit_url);
			}        
		
		return false;
	}
	
	public function GetTotalSearchRecord($search) {	
		
		$this->db->select('count(*) as total');
		$this->db->from("tbl_article as a");
		$this->db->where('MATCH(a.title, a.description, a.excerpt, a.tags) AGAINST("'.urldecode ($search ).'" IN BOOLEAN MODE)');
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->where('a.status', 1);
		$query = $this->db->get();
		
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }	
	
	public function GetRecordBySeachKeyword($search, $limit, $start) {

		$this->db->select('MATCH(a.title) AGAINST("'.urldecode ($search).'") as Relevance, a.author_id, a.title,a.id, a.description, a.image, a.other, a.slug, a.excerpt, a.date_published, c.parent_id, c.slug as category_slug, pu.name as publication_name');
		$this->db->from("tbl_article as a");
		$this->db->join('tbl_category as c', 'c.id = a.category_id', 'left');
		$this->db->join('tbl_publication as pu', 'pu.id = a.publication_id', 'left');
		$this->db->where('MATCH(a.title, a.description, a.excerpt, a.tags) AGAINST("'.urldecode ($search).'" IN BOOLEAN MODE)');
		$this->db->where('a.status', 1);
		$this->db->where('a.date_published <= ', date('Y-m-d'));
		$this->db->order_by('Relevance, a.date_published DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ",$data_author);
				//End get multiple author
				
				if($row->parent_id != 0){
					$parent_catg = $this->category_model->GetRecordById($row->parent_id);
					$row->category_parent_slug = $parent_catg->slug;
				}
				
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }        
		return false;
    }
	
	public function GetArticleGalleryImage($article_id) {
        $this->db->where('article_id', $article_id);
		$this->db->where('status', 1);
		$this->db->where('type', 'home');
		$this->db->order_by("priority asc");
		$query = $this->db->get("tbl_article_images");
		
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }        
		return false;
    }
	public function GetBoltiImage() {
		$this->db->where("category_id = 31 and status = 1");
		$this->db->where('date_published <= ', date('Y-m-d'));
		$this->db->where('type', 'home');
		$this->db->order_by("id desc");
		$query = $this->db->get("tbl_article");
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row1){    
			   $this->db->where('article_id', $row1->id);
			   $this->db->where('status', 1);
			   $query1 = $this->db->get("tbl_article_images");
			   //echo $this->db->last_query();
				if ($query1->num_rows() > 0) {
					foreach ($query1->result() as $row) {
						$data[] = $row;
					}
				}
			}
			return $data;
		}
		return false;
    }
	
	public function GetTotalMyBoltiImage() {
		$this->db->select('count(*) as total');
		$this->db->from('tbl_article_images');
		$this->db->join('tbl_article', 'tbl_article.id = tbl_article_images.article_id', 'inner');
		$this->db->where('tbl_article.category_id', 31);
		//$this->db->where('tbl_article_images.status', 1);
		$this->db->where('tbl_article.status', 1);
		$this->db->where('tbl_article_images.type', 'home');
		$this->db->order_by('tbl_article_images.id', 'desc');
		$query = $this->db->get();		
		
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data[0]->total;
		}else{
			return false;
		}
	}
	
	public function GetMyBoltiImage($total_records, $start=0, $limit=4){
		$this->db->select('tbl_article_images.id, tbl_article_images.title, tbl_article_images.description, tbl_article_images.image, tbl_article_images.photo_credit, tbl_article_images.photo_credit_url, tbl_article.title as article');
		$this->db->from('tbl_article_images');
		$this->db->join('tbl_article', 'tbl_article.id = tbl_article_images.article_id', 'inner');
		$this->db->where('tbl_article.category_id', 31);
		//$this->db->where('tbl_article_images.status', 1);
		$this->db->where('tbl_article.status', 1);
		$this->db->where('tbl_article_images.type', 'home');
		$this->db->order_by('tbl_article_images.id', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();	
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			if($query->num_rows() < $limit){
				$new_limit = $limit - $query->num_rows();
				$new_data = $this->GetMyBoltiImage($total_records, $start=0, $new_limit);
				$data = array_merge($data, $new_data);
			}
			return $data;
		}else{		
			return false;
		}
	}		
	
	public function GetArticleRecordByCategoryId($category_id, $limit=5, $start=0) {        
		$this->db->select('*');
		$this->db->from("tbl_article");
		
		$this->db->where('category_id', $category_id);
		$this->db->where('status', 1);
		$this->db->where('date_published <= ', date('Y-m-d'));
		$this->db->order_by("priority", "ASC");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				//Start Get multiple author
				$author_name = '';
				$data_author = array();
				if($row->author_id != 0){
					
					$this->db->select("id, slug, name");
					$this->db->where("id IN ($row->author_id)");
					$query_author = $this->db->get("tbl_author");
					if ($query_author->num_rows() > 0) {
						foreach ($query_author->result() as $row_author) {
							$data_author[] = "<a href='/author/".$row_author->slug."'>".$row_author->name."</a>";
						}
						
					}
					
				}
				if($row->other != ''){ $data_author[] = $row->other;}
				$author_name = @implode(", ",$data_author);
				//End get multiple author
				
				list($image,$photo_credit,$photo_credit_url) = $this->getGalleryImage($row->id);
				list($imageMedium) = $this->getGalleryImage($row->id,'medium');
				list($imageThumb) = $this->getGalleryImage($row->id,'thumbnail');
				$row->imageMedium='gallery/'. $imageMedium;
				$row->imageThumb='gallery/'. $imageThumb;
				$row->image='gallery/'. $image;
				$row->photo_credit= $photo_credit;
				$row->photo_credit_url= $photo_credit_url;
				
				$row->author_name = $author_name;
				$data[] = $row;
			}
            return $data;
        }
        return false;
    }
	
	public function GetQuoteRecord($article_id) {       
		$this->db->where('status', 1);
		$this->db->where('article_id', $article_id);
		$this->db->order_by('priority ASC');
		$query = $this->db->get("tbl_article_quote");
		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function GetHomeBreaking_news($limit=1)
	{
		$this->db->select('title , url');
			$this->db->where('status', 1);
			$this->db->limit($limit);
			$this->db->order_by('newsID desc');
			$query = $this->db->get("tbl_breaking_news");
			
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return $row;
			}        
		
		return false;
	}
	public function GetHomeVoice($limit=1)
	{
		//$this->db->select('title , url');
			$this->db->where('status', 1);
			$this->db->limit($limit);
			$this->db->order_by('voiceID desc');
			$query = $this->db->get("tbl_voice");
			
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return $row;
			}        
		
		return false;
	}
	public function GetHomeInsight($limit=1)
	{
		//$this->db->select('title , url');
			$this->db->where('status', 1);
			$this->db->limit($limit);
			$this->db->order_by('insightID desc');
			$query = $this->db->get("tbl_insight");
			
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$row=$query->result();
				//echo $row[0]->image;
				return $row;
			}        
		
		return false;
	}
	public function buyer_seller($action,$limit=1)
	{
		//$this->db->select('title , url');
			$this->db->where('status', 1);
			if($action=='buyer')
			$this->db->where('action', 1);
			else
			$this->db->where('action', 0);
			$this->db->limit($limit);
			$this->db->order_by('id desc');
			$query = $this->db->get("tbl_buyer_seller");
			$data=array();
			//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
                $data[] = $row;
				}
				return $data;
			}        
		
		return false;
	}
	
}