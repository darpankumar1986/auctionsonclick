<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __Construct() {
        parent::__Construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('home_model');
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
	
	
  
    function faq() {
        $data['title'] = 'FAQ';
		//$staticData = $this->home_model->getStaticContents(4);
        //$data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/faq', $data);   
        $this->load->view('front_view/footer');     
    }

    function about_us() {
		$data['title'] = 'About Us';
        $staticData = $this->home_model->getStaticContents(2);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/about_us', $data);
        $this->load->view('front_view/footer');
    }

    function privacy_policy() {
		$data['title'] = 'Terms &amp; Conditions';
        $staticData = $this->home_model->getStaticContents(1);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/privecy-policy', $data);
        $this->load->view('front_view/footer');
    }

    function terms_of_use() {
		$data['title'] = 'Terms &amp; Conditions';	
        $staticData = $this->home_model->getStaticContents(5);
        $data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/terms_of_use', $data);
        $this->load->view('front_view/footer');
    }

	function sitemap() {
        $data['title'] = 'Sitemap';
		//$staticData = $this->home_model->getStaticContents(4);
        //$data['staticData'] = $staticData;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/sitemap', $data);   
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
    

	function contact_us() {
		$data['title'] = 'Contact Us';
        $getContactUsTopic = $this->home_model->getContactUsTopic();
        $data['getContactUsTopic'] = $getContactUsTopic;
        $this->load->view('front_view/header', $data);
        $this->load->view('front_view/contact_us', $data);
        $this->load->view('front_view/footer');
    }
	function contactUsSave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required','trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email ID', 'required','trim|required|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('topic_id', 'Topic', 'required','trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'message', 'required','trim|required|xss_clean');

		
		if($this->form_validation->run() == FALSE)
		{	
			$this->session->set_flashdata('message_validation', "Error: Kindly fill all fields");
			redirect('home/contactus');
			exit;
		}
		$save = $this->home_model->save_contactus();
		if ($save) {
			
			
			redirect('home/success?cs=1');
			exit;
		}
	
	}

	function auctionDetailPopup($auctionID) {
            $data['auction_data'] = $this->home_model->aucDetailPopupData($auctionID);
            $data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
            $this->load->view('front_view/auction_detail_popup', $data);
        }
	
	function auctionDetail($auctionID) {
		$data['title'] = "View Detail";
		$data['auction_data'] = $this->home_model->aucDetailPopupData($auctionID);
		$data['uploadedDocs'] = $this->home_model->GetUploadedDocsByAuctionId($auctionID);
		//print_r($data['auction_data']);
		//echo $data['auction_data'][0]->state;die;
		$salesPerson = $this->home_model->getSalesPerson($data['auction_data'][0]->state);

		$data['sales_person_detail'] = 'Mr. '.$salesPerson[0]->sales_person_name.', Mobile No. '.$salesPerson[0]->mobile_no.', <a href="mailto:'.$salesPerson[0]->email_id.'">'.$salesPerson[0]->email_id.'</a>';
		
		//$data['data'] = $this->home_model->GetAuctionDocuments($auctionID);
		$this->load->view('front_view/header', $data);	
		$this->load->view('front_view/auctionDetail', $data);
		$this->load->view('front_view/footer');
    }
        
	public function propertylisting()
	{	
		
		$data['assetsType'] = $this->home_model->getAllAssetsType();
		$this->load->view('front_view/header', $data);	
		$vdata['property'] = $this->home_model->getProperty();
		
		$vdata['data'] = $this->home_model->getAuctionCityLocation();
		$vdata['totalAuction'] = $this->home_model->getTotalAdvancedSearchAuction();
		
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

	public function liveupcomingauciton_event_add() {
       $save = $this->home_model->liveupcomingauciton_event_add_save();
        
    }

	public function premiumServices() {

		if($_GET['package_id'] > 0)
		{
			$bidderID = $this->session->userdata('id');
			$last_insert_id_payment = $this->home_model->save_payment($bidderID,$_GET['package_id']);				
			redirect('/payment2/index?txnid='.base64_encode($last_insert_id_payment));die;
		}

		
		$data['title'] = 'Premium Services';
		$data['subcription_plan'] = $this->home_model->getSubcriptionPlan(0);
        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/premiumServices', $data);
		}
        
        $this->load->view('front_view/footer');
    }

	public function success()
	{

		$data['title'] = 'Thank You!';
		$data['subcription_plan'] = $this->home_model->getSubcriptionPlan(0);
		$data['total_auction'] = $this->home_model->getTotalAuction();

        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/success', $data);
		}
        
        $this->load->view('front_view/footer');
    }

	public function getCity()
	{
		if(isset($_GET['q']) && $_GET['q']!='')
		{
			$searchtext = $_GET['q'];
			$searchtext = trim(str_replace("'","''",$searchtext));
			
			$this->db->where("city_name LIKE '".$searchtext."%'");
		}

		$this->db->where('status IN(1)');
		$this->db->limit(50);
		$this->db->order_by('city_name','ASC');
		$query = $this->db->get('tbl_city');

		$data = array();
		foreach($query->result() as $city)
		{
			array_push($data,array("id"=>$city->id,"label"=>$city->city_name));
		}
		echo json_encode($data);
	}
	
	
	public function advancedSearchDatatable() {
        echo $this->home_model->advancedSearchDatatable();
    }

	public function advanced_search()
	{
		$data['title'] = 'Advanced Search';
		$data['totalAuction'] = $this->home_model->getTotalAdvancedSearchAuction();
        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/advanced_search', $data);
		}
        
        $this->load->view('front_view/footer');
    }

	public function top_banks()
	{
		$data['title'] = 'Top Banks';
		$data['top_banks'] = $this->home_model->getAllBank();
        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/top_banks', $data);
		}
        
        $this->load->view('front_view/footer');
    }
	public function top_cities()
	{
		$data['title'] = 'Top Cities';
		$data['top_cities'] = $this->home_model->getTopCities();
        $this->load->view('front_view/header', $data);
        if(MOBILE_VIEW)
		{			
			$this->load->view('mobile/home', $data);
		}
		else
		{		
			$this->load->view('front_view/top_cities', $data);
		}
        
        $this->load->view('front_view/footer');
    }
}

?>
