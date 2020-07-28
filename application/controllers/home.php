<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __Construct() {
        header_remove("X-Powered-By");

        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('log4php');
        log_error('my_error');
        log_info('my_info');
        log_debug('my_debug');
        //error_reporting(0);
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('home_model');
        $this->load->model('admin/news_model');
        $this->load->model('property_model');
		
		/* run auction completed script */
        $this->load->model('account_model');
        $this->account_model->completedAuctionScript();
        /* end run auction completed script */
		
        if ($this->session->userdata('user_type') == 'owner' || $this->session->userdata('user_type') == 'builder' || $this->session->userdata('user_type') == 'broker') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'helpdesk_ex') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'sales_cordinator') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'banker') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'account') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'helpdesk_admin') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'sales') {
            redirect('/registration/logout');
        }
        if ($this->session->userdata('user_type') == 'mis') {
            redirect('/registration/logout');
        }

        if (preg_match("/index.php/", $_SERVER['REQUEST_URI'])) {
            redirect('/', 'location', 301);
        }
    }

    function page($slug) {
        $staticData = $this->home_model->getStaticContentsBySlug($slug);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/about_us', $data);
        $this->load->view('front_view/footer');
    }



    public function archiveAuctionDatatable() {
        echo $this->home_model->archiveAuctionDatatable();
    }

    public function liveAuctionDatatableHome() {
        echo $this->home_model->liveAuctionDatatableHome();
    }

    public function checkdsclogin() {
        echo $this->home_model->checkdsclogin();
    }

    public function index() {
		/*
		$this->load->model('elastic_model');		
		$res = $this->elastic_model->property();
		*/
        $data = array();
        $bankData = $this->home_model->bankList();
        $eventData = $this->home_model->eventList();
        $homebreakingNews = $this->home_model->getHomeBreakingNewsDetails();
        $data['homebreakingNews'] = $homebreakingNews;
	
        $headerbankId = '0';
        $homeHeaderBanner = $this->home_model->getHomeHeaderBanner($headerbankId);
        $data['homeHeaderBanner'] = $homeHeaderBanner;

        $sliderbankId = '0';
        $homeSliderBanner = $this->home_model->getHomeSlider($sliderbankId);
        $data['homeSliderBanner'] = $homeSliderBanner;


        $data['controller'] = 'home';
        $data['bankData'] = $bankData;

        $data['eventData'] = $eventData;
		
		$data['aData'] = $this->home_model->liveAuctionDatatable();
		$data['assetsType'] = $this->home_model->getAllAssetsType();

        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/home', $data);
		}
        
        $this->load->view('front_view/footer');
    }
	
	
  
    function faqs() {
        //$staticData = $this->home_model->getStaticContents(4);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/faq', $data);   
        $this->load->view('front_view/footer');     
    }

    function aboutus() {
        $staticData = $this->home_model->getStaticContents(2);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/about_us', $data);
        $this->load->view('front_view/footer');
    }

    function contactus() {
        $staticData = $this->home_model->getStaticContents(3);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/contact_us', $data);
        $this->load->view('front_view/footer');
    }

    function privacy_policy() {
        $staticData = $this->home_model->getStaticContents(1);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/privecy-policy', $data);
        $this->load->view('front_view/footer');
    }

    function terms_of_use() {
        $staticData = $this->home_model->getStaticContents(5);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/terms_of_use', $data);
        $this->load->view('front_view/footer');
    }

    

    public function bankuserupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $setarray);
        return true;
    }

    public function userupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user_registration', $setarray);
        return true;
    }   
    
	
	function auctionDetailPopup($auctionID) {
            $data['auction_data'] = $this->home_model->aucDetailPopupData($auctionID);
            $data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
            $this->load->view('front_view/auction_detail_popup', $data);
        }
        
	public function propertylisting()
	{	
		/*		
		$vdata['subCategory'] = $this->search_model->getSubCategories();
		
		
		$sub_cat_name = $vdata['subCategory'][0]['sub_categories'][0]['name'];
		if($sub_cat_name)
		{
			$subcatname = $sub_cat_name.', '.$sub_cat_name;
		}
		else
		{
			$subcatname = '';
		}
		//$data['title'] = $subcatname.' manufacturers, '.$sub_cat_name.' suppliers, '.$sub_cat_name.'  exporters | '.$this->siteurl;
		$data['title'] = 'Assets List';
		
		$this->load->view('front_view/header', $data);
		$vdata['topProducts'] = $this->search_model->getTopProducts();
		
		$vdata['products'] = $this->search_model->getProducts();
		
		//echo '<pre>';
	   // print_r($vdata['products']);die
		$vdata['total'] = $this->search_model->count_products();
		$vdata['country'] = $this->search_model->getSupplierLocation();
		//echo'<pre>'; print_r($vdata['country']);die;
		$this->load->view('productlist',$vdata);
		$this->load->view('front_view/footer');
		*/
		$data['assetsType'] = $this->home_model->getAllAssetsType();
		$this->load->view('front_view/header', $data);	
		$vdata['property'] = $this->home_model->getProperty();	
		
		 if(MOBILE_VIEW)
		{				
			$this->load->view('mobile/property_listing',$vdata);
		}
		else
		{				
			$this->load->view('front_view/property_listing',$vdata);
		}
		
		
		$this->load->view('front_view/footer');
	}
	
	public function search_product()
	{
		/*
		$this->load->model('elastic_model');		
		$res = $this->elastic_model->property();
		*/
		if(ELASTICSEARCH_STATUS != 'ON')
		{
			$this->home_model->query_search();
		}
		else
		{
			$q = strtolower(urldecode($_GET['q']));
			$assetsTypeId = $_GET['assetsTypeId'];
			$this->load->library('Elasticsearch');		
			$elasticSearch = new Elasticsearch();
			$elasticSearch->index = 'c1prop';
			/*$elasticsearch->type = 'details';
			$elasticsearch->create();
			$data = '{"author" : "jhon", "datetime" : "2001-09-09 00:02:04"}';
			$elasticsearch->add(1, $data);

			$elasticsearch->index = '';*/
			
			//$res = $elasticSearch->delete('');
			
			if($q != "")	
			{
				$search_data_1 = '{
							"query": {
								"bool": {								
									"should": [
											{"wildcard":{"search":"'.$q.'*"}}										
										]
								}
								
								
							}
						}';
			}
			else
			{
					$search_data_1 = null;
			}
				
			if($q != "")	
			{
				$search_data = '{
							  "query": {								  
								"query_string": {
								  "query": "'.$q.'~",
								  "boost" :         1.0,
									"fuzziness" :     2
								  
								}								
								
							  }
							}';
			}
			else
			{
					$search_data = null;
			}
								
				
			
			$res_1 = $elasticSearch->search_product('propertydata/_search?size=100',$search_data_1);
			//echo "<pre>";print_r($res_1);die;
			$data = array();		
			
			if(is_array($res_1->hits->hits))
			{
							
				foreach($res_1->hits->hits as $product)
				{
					//echo "<pre>";print_r($product);
					if(count($data) < 10)
					{
						//$data[] = $product->_source->search."(name,".$product->_source->category_id.")";	
						//echo $assetsTypeId .' '. $product->_source->category_id;die;
						if($assetsTypeId>0)
						{
							if($assetsTypeId == $product->_source->category_id)
							{
								$data[] = ucwords($product->_source->search);	
							}
						}
						else
						{
							$data[] = ucwords($product->_source->search);	
						}
						
						$data = array_unique($data);
					}					
				}
				
			}
			
			if(count($res_1->hits->hits) < 11)
			{
				$res = $elasticSearch->search_product('propertydata/_search?size=100',$search_data);
				if(is_array($res->hits->hits))
				{			
					foreach($res->hits->hits as $product)
					{
						if($product->_score > 2)
						{
							if(count($data) < 10)
							{
								//$data[] = $product->_source->search."(name,".$product->_source->product_id.")";						
								if($assetsTypeId>0)
								{
									if($assetsTypeId == $product->_source->category_id)
									{
										$data[] = ucwords($product->_source->search);	
									}
									
								}
								else
								{
									$data[] = ucwords($product->_source->search);	
								}
								$data = array_unique($data);					
							}
						}
					}
				}
			}
			
			echo json_encode($data);die;
		}
	}

	public function login() {
		
        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/login', $data);
		}
        
        $this->load->view('front_view/footer');
    }
}

?>
