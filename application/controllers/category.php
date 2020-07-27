<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends WS_Controller {
	
	public function __construct()
	{       parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->model('category_model');	
		$this->load->model('article_model');
		$this->load->model('author_model');	
		$this->load->model('admin/footer_magazine_model');
	}		
	public function index($catg_slug, $sub_catg_slug, $page_no)
	{		
		$this->page($catg_slug, $sub_catg_slug, $page_no);
	}
	
	public function page($catg_slug, $sub_catg_slug, $page_no)
	{
	$category_record = $this->category_model->GetRecordBySlug($catg_slug, $sub_catg_slug);
	//start 404 redirect	
	if(!$category_record){redirect404();}
		//end 404 redirect
		$category_id	=	$category_record->id;
		$seo_data['page_seo_desc']=$category_record->meta_description;
		$seo_data['page_seo_keywords']=$category_record->meta_keywords;
		$seo_data['page_title'] = ($category_record->meta_title != '')?$category_record->meta_title:$category_record->name;
		
		$this->website_header($seo_data);
		$sub_cats = $this->category_model->GetRecords($category_record->id);
		if($category_record->parent_id == 0 && $sub_cats) {
		
			$data['parent_name'] = $category_record->name;
			$i = 0;
			$data['first_article']=$this->article_model->GetHomePageArticle('home_page',$category_id, 1);
			foreach($sub_cats as $sub_cat){
				$articles = $this->article_model->GetRecordByCategoryId($sub_cat->id, 4);
				$data['category_data'][$i] = $sub_cat;
				if($articles){					
					$data['category_data'][$i]->article = $articles;
					$i++;	
				}
			}
			switch($category_id){
				case '1':
				$this->load->view('category/bigstory',$data);
				break;
				case '2':
				$this->load->view('category/pixtory',$data);
				break;
				case '3':
				$this->load->view('category/enterprise',$data);
				break;
				
				case '4':
				$this->load->view('category/strategy',$data);
				break;
				
				case '5':
				$this->load->view('category/market',$data);
				break;
				
				case '6':
				$this->load->view('category/cest-lavie',$data);
				break;
				
				default:
				$this->load->view('category/pixtory',$data);
				break;
			      }
			//$this->load->view('category',$data);
		}
		else{
			
			$data['category_data'] = $category_record;
			$parent_record=$this->category_model->GetRecordById($category_record->parent_id);
			$data['parent_record'] =$parent_record;
			$total_record	= $this->article_model->GetTotalCategoryRecord($category_record->id);		
			$config['base_url'] = site_url($catg_slug.'/'. $sub_catg_slug);
			$config['total_rows'] = $total_record;
			$config['per_page'] = 30;
			$config["uri_segment"] = 3;
			
			$this->pagination->initialize($config);
			$data['pagination_links'] = $this->pagination->create_links();
			
			if($page_no=='')
				$limit=0;
			else
				$limit=$config["per_page"]*($page_no-1);
				
			$offset = ($limit) ? $limit : 0;
			
			$articles = $this->article_model->GetRecordByCategoryId($category_record->id, $config['per_page'], $offset);
			if($articles->excerpt == 'default') $articles->excerpt='';
			
			if($articles){
				$data['category_data']->article = $articles;
			}
			$this->load->view('sub-category',$data);
		}
		
		/******************** Right Section  **************************/
		$this->website_right();
		/******************* End Right Section  ************************/
		
		/********************** Footer Section  ************************/
		$this->website_footer();
		/******************* End Footer Section  ***********************/
	}
}

