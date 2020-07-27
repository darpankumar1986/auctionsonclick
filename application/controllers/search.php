<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends WS_Controller {
	
	public function __construct()
	{   
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->model('category_model');	
		$this->load->model('article_model');
		$this->load->model('author_model');	
		$this->load->model('admin/footer_magazine_model');
		//$this->load->model('google_model');
		
	}	
	
	public function index($param, $page_no=null)
	{
		$this->page($param, $page_no);
	}
	
	public function page($param, $page_no)
	{
		
		$this->website_header();
		
		if($page_no){
			$page_no = $page_no;
		}else{
			$page_no = 1;
		}
		
		//echo urldecode($param);
		$search_key = ($param)?str_replace('~', ' ', urldecode($param)):'';
		$data['search_key'] = $search_key;
		//$search_key=Translate($search_key,'en_to_hi');
		
		
		//echo  $search_key=Translate($search_key,'en_to_hi');
		
		//echo $search_key; die;
		$total_record	= $this->article_model->GetTotalSearchRecord($search_key);
		$config['base_url'] = site_url().'/search/'.$param;
		$config['total_rows'] = $total_record;
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		
			
		$offset = ($limit) ? $limit : 0;	
		
		$article_record	= $this->article_model->GetRecordBySeachKeyword($search_key, $config['per_page'], $offset);	
		
		$data['article_record'] = $article_record;		
		$data['page_title'] = 'Search';
		
		$this->load->view('search',$data);
			
		
		/******************** Right Section  **************************/
		$this->website_right();
		/******************* End Right Section  ************************/
		
		/********************** Footer Section  ************************/
		$this->website_footer();
		/******************* End Footer Section  ***********************/
	}		
}