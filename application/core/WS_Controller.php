<?php
class WS_Controller extends CI_Controller {
  public function __construct(){
    parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('category_model');
		//$this->load->model('article_model');
		//$this->load->model('author_model');
		//$this->load->model('ads_model');
		//$this->load->model('admin/footer_magazine_model');
		//$this->load->model('admin/poll_model');		
  }
   
  
  
  function website_header($seo_data=''){
		/*$data['breaking_news'] = $this->article_model->GetHomeBreaking_news();
		$data['category'] = $this->category_model->GetRecords();
		$data['page_title'] = 'Home';
		$data['ads_top'] = 	$this->ads_model->loadAds('top');
		$data['seo_data'] = $seo_data;*/
		$data[]='';
		$this->load->view('common/header', $data);	
  }

   function popup_header($seo_data=''){
		$data[]='';
		$this->load->view('common/popupheader', $data);	
  }
  
  function website_right($additional_content = ''){
		
		/*$page_url = $this->uri->segment(1);
		
		$home_page_category=$this->category_model->GetHomeRecords();
		
		$widget ='';		
		$widget .= $additional_content;
		//ads
		$ads_right1 = $this->ads_model->loadAds('right1');
		$widget .= $this->load->view($ads_right1, '', TRUE);
		//magzine
		
			//$widget.= file_get_contents(base_url('archive/2015/1'));
			$widget.= '<div class="widget_right btmrgn" id="widget_magzine">	
			<div class="heading">मैगजीन</div>
			<div class="imgWrapper"> 
				<a href="http://www.magzter.com/IN/The_Outlook_Group/Outlook_Hindi/News//89363" target="_blank"><img src="http://cdn.magzter.com/Outlook Hindi/97/images/thumb/thumb_1.jpg" alt="" class="img-responsive lazy"></a>
							
			<div class="row">
				<a class="button" href="http://subscription.outlookindia.com" target="_blank"><img width="16" height="16" src="/images/icon_print.png">Print</a>
				<a class="button red" href="http://www.magzter.com/IN/The-Outlook-Group/Outlook-Traveller/Travel/" target="_blank"><img width="16" height="16" src="/images/icon_digital.png">Digital</a>
			</div>
			</div>
		</div>';
		
		if($home_page_category[6]->id){
		//deal-street
		$widget1['title']=$home_page_category[6]->name;
		$widget1['slug']=$home_page_category[6]->slug;
		$widget1['data'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[6]->id,4);
		$widget.= $this->load->view('right/deal-street', $widget1, TRUE);
		}
		if($home_page_category[7]->id){
		//ad-break
		$widget1['title']=$home_page_category[7]->name;
		$widget1['slug']=$home_page_category[7]->slug;
		$widget1['data'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[7]->id,1);
		$widget.= $this->load->view('right/ad-break', $widget1, TRUE);
		}
		if($home_page_category[8]->id){
		//high-five
		$widget1['title']=$home_page_category[8]->name;
		$widget1['slug']=$home_page_category[8]->slug;
		$widget1['data'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[8]->id,1);
		$widget.= $this->load->view('right/ad-break', $widget1, TRUE);
		}
		if($home_page_category[9]->id){
		//high-five
		$widget1['title']=$home_page_category[9]->name;
		$widget1['slug']=$home_page_category[9]->slug;
		$widget1['data'] = $this->article_model->GetHomePageArticle('home_page',$home_page_category[9]->id,1);
		$widget.= $this->load->view('right/ad-break', $widget1, TRUE);
		}
		//ads
		$ads_right2 = $this->ads_model->loadAds('right2');
		$widget .= $this->load->view($ads_right2, '', TRUE);
		//most-read
		//$widget1['data'] = $this->article_model->GetMostArticle(7);
		$widget1['data'] = $this->article_model->GetLatestArticle(7);
		$widget.= $this->load->view('right/most-read', $widget1, TRUE);
		//most-shared.php
		$widget1['data'] = $this->article_model->GetLatestArticle(7);
		$widget.= $this->load->view('right/most-shared', $widget1, TRUE);
		//ads
		$ads_right3 = $this->ads_model->loadAds('right3');
		$widget .= $this->load->view($ads_right3, '', TRUE);
		//insider-buyer
		$widget1['title']=$home_page_category[10]->name;
		$widget1['slug']=$home_page_category[10]->slug;
		$widget1['data'] = $this->article_model->buyer_seller('buyer',2);
		$widget.= $this->load->view('right/insider-buyer', $widget1, TRUE);
		
		//insider-seller
		$widget1['title']=$home_page_category[11]->name;
		$widget1['slug']=$home_page_category[11]->slug;
		$widget1['data'] = $this->article_model->buyer_seller('seller',2);
		$widget.= $this->load->view('right/insider-seller', $widget1, TRUE);
		
		//facebook
		$widget.= $this->load->view('right/facebook', '', TRUE);
		$data['widget']=$widget;
		$this->load->view('right/right', $data);*/
  }
  
  function website_footer(){
		
		/*$category = $this->category_model->GetRecords();
		foreach($category as $category_data){
			$footer_category[$category_data->id] = $this->category_model->GetChildRecords($category_data->id);
		}
		$data['ads_bottom'] = 	$this->ads_model->loadAds('bottom');
		$data['footer_category']=$footer_category;
		$footer_magazine = $this->footer_magazine_model->GetRecords();
		$data['footer_magazine'] = $footer_magazine;*/
		$data[]='';
		//$this->load->view('common/footer', $data);
		$this->load->view('common/footer_eauc', $data);
  }
 
  function action($act, $id, $act_val = ''){
		$module = $this->uri->segment(2);
		switch($module){
			case 'category':
			$tableName = 'tbl_category';
			break;
			case 'article':
			$tableName = 'tbl_article';
			break;
			case 'article_image':
			$tableName = 'tbl_article_images';
			break;
			case 'author':
			$tableName = 'tbl_author';
			break;
			case 'admin':
			$tableName = 'tbl_admin';
			break;
			
			default:
			$tableName = 'tbl_'.$module;
			break;
		}
		
		switch($act){
			case 'delete':
			$data = array('status'=>5);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'status':
			$data = array('status'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'menu_item':
			$data = array('menu_item'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'home_page':
			$data = array('home_page'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'show_home':
			$data = array('show_home'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'carousel':
			$data = array('carousel'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
			case 'thumbnail':
			$data = array('thumbnail'=>$act_val);
			$this->db->where('id', $id);
			$this->db->update($tableName, $data);
			break;
			
		}
	}
	
	function executive_header($seo_data='')
	{
		$data[]='';
		$this->load->view('common/executive_header_eauc', $data);	
	}
        function executive_headeradmin($seo_data='')
	{
		$data[]='';
		$this->load->view('common/executive_header_eaucadmin', $data);	
	}
         function executive_headersalesexecutive($seo_data='')
	{
		$data[]='';
		$this->load->view('common/executive_header_eaucsalesexec', $data);	
	}
	function executive_footer()
	{
			$data[]='';
			$this->load->view('common/executive_footer_eauc', $data);
	}
	function executive_breadcrumb()
	{
			$data[]='';
			$this->load->view('common/executive_breadcrumb', $data,true);
	}
	 function executive_leftsidebar()
	{
			$data[]='';
			$this->load->view('common/executive_left_sidebar', $data,true);
	}
	 function executive_leftsidebar1(){
			$data[]='';
			$this->load->view('common/executive_left_sidebar', $data,true);
	}
	function banker_header($seo_data='')
	{
		$data[]='';
		$this->load->view('common/banker_header_eauc', $data);	
	}
	function viewer_header($seo_data='')
	{
		$data[]='';
		$this->load->view('common/viewer_header_eauc', $data);	
	}
	function bidder_header($seo_data='')
	{
		$data[]='';
		$this->load->view('common/bidder_header', $data);	
	}
	
	function account_header()
	{
		$data[]='';
		$this->load->view('common/account_header_eauc', $data);	
	}
	
	function mis_header()
	{
		$data[]='';
		$this->load->view('common/mis_header_eauc', $data);	
	}
}
?>
