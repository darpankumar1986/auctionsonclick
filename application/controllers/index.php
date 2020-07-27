<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends WS_Controller {
	
	public function __construct()
	{   
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('category_model');
		$this->load->model('article_model');
		$this->load->model('author_model');
		$this->load->model('admin/footer_magazine_model');
		$this->load->model('admin/poll_model');
	}	
	
	public function index()
	{
		//$this->page();
            $this->load->view('index/index');
	}
	
	public function page()
	{
		/********************  Header Section  **************************/	
		$this->website_header();	
		/****************** End Header Section  *************************/
		
		/********************   Index Section     ***********************/
		//get home page category priority wise
		$home_page_category=$this->category_model->GetHomeRecords();
		$data['home_page_category']=$home_page_category;
		
		//Voice
		//$data['voice'] = $this->article_model->GetHomeVoice();
		$data['voice'] = $this->article_model->GetHomePageArticle('home_page',31,'1',0);
		//Insight
		//$data['insight'] = $this->article_model->GetHomeInsight();
		 $data['insight']=$this->article_model->GetHomePageArticle('home_page',33,'1',0);
		//Pixotry
		//$data['pixotry'] = $this->article_model->GetHomePageGallery();
		$data['pixotry'] = $this->article_model->GetHomePageArticle('home_page',10,'1',0);
		//print_r($home_page_category);
		//First section
		$data['first'] = $this->article_model->GetHomePageArticle('carousel','',5);
		//Second section
		$data['second'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[0]->id,'3',0);
		//Third section
		$data['third'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[1]->id,'1',0);
		//Fourth-Pixtory section
		//$data['fourth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[3]->id,'1',0);
		//Fifth-Voice section
		//$data['fifth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[4]->id,'1',0);
		//Sixth section
		$data['sixth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[2]->id,'4',0);
		//Seventh-Ads section
		$data['ads_top'] = 	$this->ads_model->loadAds('top');
		//$data['seventh'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[4]->id,'3',0);
		//Eighth section
		$data['eighth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[3]->id,'3',0);
		//Ninth section
		$data['ninth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[4]->id,'4',0);
		//Tenth section
		$data['tenth'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[5]->id,'3',0);
		$this->load->view('index/index', $data);
				
		/******************** Index Section  **************************/
		
		/******************** Right Section  **************************/
		$this->website_right();
		/******************* End Right Section  ************************/
		
		/********************** Footer Section  ************************/
		$this->website_footer();
		/******************* End Footer Section  ***********************/
		
	}
	public function error(){
	
		/********************  Header Section  **************************/	
		$this->website_header();	
		/****************** End Header Section  *************************/
	
		$this->load->view('index/error', '');
		
		/********************** Footer Section  ************************/
		$this->website_footer();
		/******************* End Footer Section  ***********************/
	}
	
}

