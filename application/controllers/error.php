<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller
{
	
	public function __Construct()
	{        
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('log4php');
		log_error('my_error');
		log_info('my_info');
		log_debug('my_debug');
		//error_reporting(0);
		$this->load->helper('url');
		$this->load->helper('file');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model('property_model');
        $this->load->model('product_detail_model');
		$this->load->model('home_model');
		$this->load->model('admin/news_model');
		$this->load->model('property_model');               
	}
		
	function page($slug)
	{
			$staticData=$this->home_model->getStaticContentsBySlug($slug);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
			$this->load->view('front_view/about_us',$data);
			$this->load->view('front_view/footer');
	}
	    
    public function liveAuctionDatatable()
    {
       echo $this->home_model->liveAuctionDatatable();
	}
	
	public function liveAuctionDatatable1()
	{
       echo $this->home_model->liveAuctionDatatable();
	}
        
    public function checkdsclogin()
    {
		echo $this->home_model->checkdsclogin();
    }

    public function index()
    {			
		$url = $_SERVER['REQUEST_URI'];
		$urlArr = explode("/",$url);
		foreach($urlArr as $k => $v)
		{
			if($v == '')
			{
				unset($urlArr[$k]);
			}
		}
		$urlArr = array_values($urlArr);
		$productId = trim($urlArr['3']);  
		$bankShortname = trim($urlArr['0']); 
		$bankIdbyshortname = $this->home_model->getBankIdByShortname($bankShortname);
			
		$bankData=$this->home_model->bankList();
		$bData = array();
		foreach($bankData as $bank)
		{
			$bData[] = $bank->shortName;
		}
		$notFound = true;
		if(in_array($bankShortname,$bData) && count($urlArr) == 1)
		{
			$notFound = false;
		}
		else
		{
			$searchArr = $this->home_model->searchFromUrl($bankShortname);
			if(is_array($searchArr) && count($urlArr) == 1)
			{				
				$notFound = false;	
			}
		}		
			
		if(in_array("property",$urlArr))
		{
			if($productId !='')
			{
				$notFound = false;
				$this->detail($productId,$bankIdbyshortname,$bankShortname);
				die;
			}				
		}
			
		
		if($notFound == true)
		{				
			$productArr = explode("-",$bankShortname);
			$productArr = array_reverse($productArr);
			$productDetail = $this->home_model->getProductById($productArr[0]);
			if($productDetail)
			{
				$notFound = false;
				$this->detail($productArr[0],$bankIdbyshortname,$bankShortname);
				die;
			}
		}
			
		$data=array();		
		if($bankIdbyshortname > 0)
		{
			$getBankDetailsByID = $this->home_model->getBankDetailsByID($bankIdbyshortname);	
			$data['getBankDetailsByID']=$getBankDetailsByID;
			
			$data['getBankName']=$getBankDetailsByID[0]->name;
			$data['getBankShortname']=$getBankDetailsByID[0]->shortName;
		}
		
		if($notFound)
		{
			$this->load->view('errorpage');
			die;
		}
		
		
				          
		$eventData=$this->home_model->eventList();
		$data['controller']='home';
		
		$data['bankIdbyshortname']=$bankIdbyshortname;
		$data['bankShortname']=$bankShortname;
		$data['bankData'] = $bankData;
		
		$data['eventData'] = $eventData;
		$homebreakingNews=$this->home_model->getHomeBreakingNewsDetails();
		$data['homebreakingNews'] = $homebreakingNews;
		
		$headerbankId = $bankIdbyshortname;
		$homeHeaderBanner=$this->home_model->getHomeHeaderBanner($headerbankId);
		$data['homeHeaderBanner'] = $homeHeaderBanner;
		
		$sliderbankId = $bankIdbyshortname;
		$homeSliderBanner=$this->home_model->getHomeSlider($sliderbankId);
		$data['homeSliderBanner'] = $homeSliderBanner;

		$this->load->view('front_view/header',$data);
		$this->load->view('front_view/home',$data);
		$this->load->view('front_view/footer_m');
	}
                
    public function dsclogin()
    {
		$data=array();

		$bankData=$this->home_model->bankList();
		$eventData=$this->home_model->eventList();
		$data['controller']='home';
		$data['bankData'] = $bankData;

		$data['eventData'] = $eventData;
		$this->load->view('front_view/header1',$data);
		$this->load->view('front_view/home',$data);
		$this->load->view('front_view/footer');
	}
	
	public function detail($pid,$bankIdbyshortname='',$bankShortname = '') 
	{ 
		
        $id = $pid;
        $data['id'] = $id;

        $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('user_type');
        $data['userId'] = trim($user_id);
        $response = $this->product_detail_model->checkBankNonbank($id);
        $productRecords = $this->product_detail_model->GetRecords($id);
        $productRecords1 = $this->product_detail_model->GetRecords_auction($id);
        if($productRecords1[0]->show_home != 1)
        {
			$this->load->view('errorpage');
			die;
		}

        // get review rating id for particular product and user //
        $rating_review_id = $this->product_detail_model->GetRatingReviewId($id,$user_id);
        $data['rating_review_id'] = $rating_review_id;
        //search //
        $categoryList = $this->property_model->categoryList();
        $budgetArr = $this->property_model->getPropertyBudget();
        $data['budgetArr'] = $budgetArr;
        $data['categoryList'] = $categoryList;
        //similar properties data //
        $data['property_type'] = $this->product_detail_model->getSimilarProperties($productRecords[0]->product_type_val, $id);
        // product attribute value
        $attrib = $this->product_detail_model->getattributeValuedata($id);
        $data['area'] = $attrib[0]->values;
        $data['room'] = $attrib[1]->values;
        $data['bathroom'] = $attrib[2]->values;
        // recent properties
        $data['recent_properties'] = $this->product_detail_model->getRecentProperties();
        // get product reviews //
        $data['reviewAll'] = $this->product_detail_model->getReviews($id,$user_id);

        $data['countUser'] = $this->property_model->totalRatedUsers($pid);
		$neighborhood		=	$this->property_model->getStartRatingAverage('neighborhood',$pid);
		$safety				=	$this->property_model->getStartRatingAverage('safety',$pid);
		$cleanliness		=	$this->property_model->getStartRatingAverage('cleanliness',$pid);
		$public_transport	=	$this->property_model->getStartRatingAverage('public_transport',$pid);
		$parking			=	$this->property_model->getStartRatingAverage('parking',$pid);
		$connectivity		=	$this->property_model->getStartRatingAverage('connectivity',$pid);
		$traffic			=	$this->property_model->getStartRatingAverage('traffic',$pid);
	
		$data['neighborhood'] 		= $neighborhood['totalAverage'];
		$data['safety'] 			= $safety['totalAverage'];
		$data['cleanliness'] 		= $cleanliness['totalAverage'];
		$data['public_transport'] 	= $public_transport['totalAverage'];
		$data['parking'] 			= $parking['totalAverage'];
		$data['connectivity'] 		= $connectivity['totalAverage'];
		$data['traffic'] 			= $traffic['totalAverage'];

		$rating_review = $this->product_detail_model->getRatingReviewData($user_id,$id);

		$data['total_rating'] = $rating_review[0]->total_rating;
		$data['reviews'] = $rating_review[0]->reviews;
        //heading addreess 
		$bankDetail = $this->product_detail_model->bankDetails($id);

		if($bankDetail[0]->auction_type=='1')
		{
			$userData = $this->product_detail_model->getUserbyTypeDetails('tbl_user_registration',$productRecords[0]->user_id);
		}
		else
		{
			$userData = $this->product_detail_model->getUserbyTypeDetails('tbl_user',$productRecords[0]->user_id);	
		}
        $data['address'] = $productRecords[0]->address1;
        $is_auction = $productRecords[0]->is_auction;
        $data['street'] = $productRecords[0]->street;
        $data['title'] = $productRecords[0]->name;
        $data['updated_date'] = $productRecords[0]->updated_date;
        $data['updated_by'] = $userData[0]->first_name;
        $data['product_description'] = $productRecords[0]->product_description;
        $cityName = $this->product_detail_model->getCity($productRecords[0]->city);
        $data['city_name'] = $cityName[0]->city_name;
        
		$country	=	GetTitleByField('tbl_country', "id='".$userData[0]->country."'", 'country_name');
        if($productRecords1[0]->category_id!='')
        {
			$data['catename']=  GetTitleByField('tbl_category','id='.$productRecords1[0]->category_id,'name');
        }
        else
        {
			$data['catename']='';   
        }
        
        if($productRecords1[0]->category_id!='')
        {
            $data['subcategory']=GetTitleByField('tbl_category','id='.$productRecords1[0]->subcategory_id,'name');
        }
        else
        {
            $data['subcategory']=''; 
        }
        $fulladdress = 	$productRecords[0]->address1.', '.$productRecords[0]->street.', '.$data['city_name'].', '.$country;

        $data['fulladdress']=$fulladdress;
        //interested user //
        $interested_users = $this->product_detail_model->getInterestedUser($pid);
        $data['interested_users'] = $interested_users[0]->users;

        $blog_records = $this->product_detail_model->getBlogs();
        
        $product_image = $this->product_detail_model->productImage($id);
        $product_video = $this->product_detail_model->productVideo($id);
        $data['video'] = $product_video;
        
        $varified = $this->product_detail_model->imageVerified($id);
        $data['verified'] = trim($varified[0]->values);
        //tab photos
    
        $data['product_image'] = $bankDetail[0]->image;
        //Recent blogs
        $data['blogs'] = $blog_records;
        $documentRecords = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);

        $data['docList'] = $documentRecords;
        $data['eventImage'] = $documentRecords;
              
        $_SESSION['docName'] = $bankDetail[0]->related_doc;

        //product image
        $data['productImage'] = $product_image[0]->name;
        $data['auction_type'] = $bankDetail[0]->auction_type;
        $data['supporting_doc'] = $bankDetail[0]->supporting_doc;

        // Basic Details
        $data['auctionID'] = $bankDetail[0]->id;
        $data['borrower_name'] = $bankDetail[0]->borrower_name;
        $bankName = $this->product_detail_model->getBankName($bankDetail[0]->bank_id);
        $bankDoc = $this->product_detail_model->getBankNamedoc($bankDetail[0]->bank_id);
        
		$branchname=GetTitleByField('tbl_branch',"id='".$bankDetail[0]->branch_id."'",'name');
		
		if($bankDetail[0]->event_type == 'drt' && $bankDetail[0]->bank_branch_id > 0)
		{
			$branchname=GetTitleByField('tbl_branch',"id='".$bankDetail[0]->bank_branch_id."'",'name');
		}
	
		$nodelbranchname=GetTitleByField('tbl_bank',"id='".$bankDetail[0]->nodal_bank_name."'",'name');
	
		$cityNameMain		=	GetTitleByField('tbl_city', "id='".$bankDetail[0]->city."'", 'city_name');
		$data['cityNameMain'] = $cityNameMain;
		$totalCirrigendum=$this->property_model->checkAuctionCirrigendum($bankDetail[0]->id);
		$data['totalCirrigendum'] = $totalCirrigendum;
        $data['branchname'] = $branchname;
        $data['nodelbranchname'] = $nodelbranchname;
        $data['bank_name'] = $bankName[0]->name;
		$data['nodal_bank_account'] = $bankDetail[0]->nodal_bank_account;
		
		if($bankDetail[0]->dsc_enabled == 1)
		{
			$dscStatus = 'Yes';
		}
		else
		{
			$dscStatus = 'No';
		}
		$data['dscStatus'] = $dscStatus;
		
        $data['branch_ifsc_code'] = $bankDetail[0]->branch_ifsc_code;
        $data['press_release_date'] = $bankDetail[0]->press_release_date;
        $data['inspection_date_from'] = $bankDetail[0]->inspection_date_from;
        $data['inspection_date_to'] = $bankDetail[0]->inspection_date_to;
        $data['bid_last_date'] = $bankDetail[0]->bid_last_date;
        $data['bid_opening_date'] = $bankDetail[0]->bid_opening_date;
        $data['created_by'] = $bankDetail[0]->created_by;
        $data['first_opener'] = $bankDetail[0]->first_opener;
        //Auction Details
        $data['event_title'] = $bankDetail[0]->event_title;
        $data['tender_no'] = $bankDetail[0]->tender_no;
        $data['account_name'] = GetTitleByField('tblmst_account_type',"account_id='".$bankDetail[0]->account_type_id."'",'account_name');
        $data['reference_no'] = $bankDetail[0]->reference_no;
        $data['NIT_date'] = $bankDetail[0]->NIT_date;
        $data['tender_fee'] = $bankDetail[0]->tender_fee;
        $data['price_bid_applicable'] = trim($bankDetail[0]->price_bid_applicable);
        $data['reserve_price'] = $bankDetail[0]->reserve_price;
        $data['emd_amt'] = $bankDetail[0]->emd_amt;
        $data['auction_start_date'] = $bankDetail[0]->auction_start_date;
        $data['auction_end_date'] = $bankDetail[0]->auction_end_date;
        $data['bid_inc'] = $bankDetail[0]->bid_inc;
        $data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;
        if(!($data['no_of_auto_extn'] > 0) || $data['no_of_auto_extn'] == 100)
        {
				$data['no_of_auto_extn'] = "Unlimited Extension";
		}
        $data['auto_extension_time'] = $bankDetail[0]->auto_extension_time;
        if(!($data['auto_extension_time'] > 0))
        {
				$data['auto_extension_time'] = "5";
		}
       
        $data['doc_to_be_submitted'] = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);
        $data['main_data'] = $bankDetail[0];
        $data['tender_doc'] = $bankDoc[0]->tender_doc;
        $data['annexure2'] = $bankDoc[0]->annexure2;
        $data['annexure3'] = $bankDoc[0]->annexure3;
		$data['status'] = $bankDetail[0]->status;
        // user total ratings
        $userRating = $this->product_detail_model->userRating($user_id,$id);
        $rating = ($userRating[0]->neighborhood + $userRating[0]->safety + $userRating[0]->cleanliness + $userRating[0]->public_transport + $userRating[0]->parking + $userRating[0]->connectivity + $userRating[0]->traffic) / 7;
        $format_rating = number_format($rating, 2);
        $this->product_detail_model->insertUserRating($format_rating, $user_id,$id);

        // calculate total average //
        $getTotalRating = $this->product_detail_model->getTotalRating($id);
        $totalAvg = $getTotalRating[0]->totalsum / $getTotalRating[0]->totalrow;
        $data['totalAvgRating'] = number_format($totalAvg, 1);

        //user Rating Category
        $getRatingCategory = $this->product_detail_model->userRatingCategory($id);
        
        //get corrigendum 
        $data['corrigendum'] = $this->product_detail_model->getAllCorrigendumByAuctionID($bankDetail[0]->id);
        
        $excellent = 0;
        $veryGood = 0;
        $good = 0;
        for ($i = 0; $i < count($getRatingCategory); $i++) 
        {
            if (($getRatingCategory[$i]->total_rating > 4) && ($getRatingCategory[$i]->total_rating <= 5)) 
            {
                $excellent++;
            }
            else if (($getRatingCategory[$i]->total_rating >= 3) && ($getRatingCategory[$i]->total_rating <= 4)) 
            {
                $veryGood++;
            }
            else if (($getRatingCategory[$i]->total_rating >= 2) && ($getRatingCategory[$i]->total_rating < 3)) 
            {
                $good++;
            }
        }
        $data['excellent'] = $excellent;
        $data['veryGood'] = $veryGood;
        $data['good'] = $good;
        //echo "ex= ".$excellent."vg= ".$veryGood."g= ".$good;die;
        // download link availability //
        $doc = $this->product_detail_model->getDoc($id);
        $data['docName'] = $doc[0]->public_notice_eng_doc;
        
        $CorrigendumDocImages = $this->product_detail_model->getCorrigendumDocImages($bankDetail[0]->id);
        //echo '<pre>';
       // print_r($CorrigendumDocImages);
        
        $data['CorrigendumDocImages'] = $CorrigendumDocImages;
        
        $CorrigendumSupportingDocSpecialImages = $this->product_detail_model->getCorrigendumSupportingDocSpecialImages($bankDetail[0]->id);
        $data['CorrigendumSupportingDocSpecialImages'] = $CorrigendumSupportingDocSpecialImages;
        
        $getCorrigendumRelatedDocImages = $this->product_detail_model->getCorrigendumRelatedDocImages($bankDetail[0]->id);
        $data['getCorrigendumRelatedDocImages'] = $getCorrigendumRelatedDocImages;
        
        $data['bankIdbyshortname']=$bankIdbyshortname;
        $data['bankShortname']=$bankShortname;
        $getBankDetails = $this->home_model->getBankDetailsByID($bankIdbyshortname);	
        $data['getBankDetails']=$getBankDetails;
        
        
        
        $url = $_SERVER['REQUEST_URI'];
		$urlArr1 = explode("/",$url);
		$productId1 = trim($urlArr1['4']);  
		$bankShortname1 = trim($urlArr1['1']); 
		$bankIdbyshortname = $this->home_model->getBankIdByShortname($bankShortname1);
		//$headerbankId = '0';
		$homeHeaderBanner=$this->home_model->getHomeHeaderBanner($bankIdbyshortname);
		$data['homeHeaderBanner'] = $homeHeaderBanner;
		
		
         
        $this->load->view('common/website_header_eauc', $data);	
        $this->load->view('front_view/product_detail_bank_eauc', $data);
        $this->load->view('front_view/footer_m');
    }
	
	function aboutus()
	{
			$staticData=$this->home_model->getStaticContents(2);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
			$this->load->view('front_view/about_us',$data);
			$this->load->view('front_view/footer');
	}
	

	function contactus()
	{
		if($this->input->post('submit')=='Submit')
		{
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			$phone=$this->input->post('phone');
			$comment=$this->input->post('comment');
			$msg="Hi Admin,<br>A New Enquiry for you. <br><br><table>
					<tr>
						<td>Name:</td>
						<td>".$name."</td>
					</tr>
					<tr>
						<td>Email:</td>
						<td>".$email."</td>
					</tr>
					<tr>
						<td>Phone:</td>
						<td>".$phone."</td>
					</tr>
					<tr>
						<td>Content:</td>
						<td>".$comment."</td>
					</tr>
				</table>
			";
			
			
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['mailtype'] = 'html';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->from('info@bankauction.com', 'BankAuction Enquiry');
			$this->email->to('sunil.singh@afaqs.com');
			$this->email->subject('A New Enquiry for '.BRAND_NAME.' Auction'.date("D m Y :H:i:s"));
			$this->email->message($msg);
			
			if($this->email->send())
			{
				$msg="You Enquiry has been send . We will contact You very soon!";
			}else{
				$msg="You Enquiry has been send . We will contact You very soon!";
			}
			$this->session->set_flashdata('msg', $msg);
			redirect('/contact-us');
		}
		
			$staticData=$this->home_model->getStaticContents(3);
			$data['staticData']=$staticData;
			$this->load->view('front_view/header',$data);
			$this->load->view('front_view/contact_us',$data);
			$this->load->view('front_view/footer');
	}
	
	public function downloadDoc($id) 
	{
        $this->load->helper('download');
        $doc = $this->product_detail_model->getDoc($id);
        $docName = $doc[0]->related_doc;
        $name = $_SERVER["DOCUMENT_ROOT"] . "public/uploads/document/" . $docName;
        $path = file_get_contents(base_url() . "public/uploads/document/");
        force_download($docName, $path);
    }

    public function ratingReview($id) 
    {
        $user_id = $this->session->userdata('id');
		
        if ($this->input->post('submit')) 
        {
            //rating field value //
            $review['traffic'] = $this->input->post('traffic');
            $review['connectivity'] = $this->input->post('connectivity');
            $review['parking'] = $this->input->post('parking');
            $review['public_transport'] = $this->input->post('public_transport');
            $review['cleanliness'] = $this->input->post('cleanliness');
            $review['safety'] = $this->input->post('safety');
            $review['neighborhood'] = $this->input->post('neighborhood');
            $review['reviews'] = $this->input->post('review');
            $review['review_title'] = $this->input->post('review_title');
            $id = $this->input->post('id');
            $rating_review_id = $this->input->post('rating_review_id');
            $this->product_detail_model->addReview($review, $user_id, $id,$rating_review_id);
        }
        $data['id'] = $id;
        $this->load->view('front_view/rating_form', $data);
    }

    public function savefavourite() 
    {
        $user_id 	= 	$this->session->userdata('id');
        $productId	=	$this->input->post('productId');
        if (isset($user_id) != "" && isset($productId) != "") 
        {
          echo  $response = $this->product_detail_model->save_favourite($user_id, $productId);
        }
    }

    function searchcity() 
    {
        $searchtxt = $this->input->get('term');
        $data = $this->property_model->showcity($searchtxt);
        
        foreach ($data as $key => $value) 
        {
            $arr[] = array("label"=>$value,"value"=>$value);
        }
        echo json_encode($arr);
    }

    function subscribe() 
    {
        $email = $_REQUEST["email"];
        if (isset($email) != "") {
            $response = $this->product_detail_model->checkSubscribeEmail($email);
            echo $response;
        }
    }
    
	function seachcalenderData()
	{
		echo "ashdfkhfdsafsafa";
		die;
		$keyData=$this->input->post('key');
		$auctiondata=$this->property_model->showAuctionCalenderData($keyData);
		$data['auctionData']=$auctiondata;
		//echo $this->load->view('front_view/calender_seach',$data,true);
		die;
	}

	function allratingReview()
	{
		$pid=$this->input->post('pid');
		$rows=$this->product_detail_model->getReviews($pid,'','all');
		$data['reviewAll']=$rows;
		echo $this->load->view('front_view/allreview',$data,true);
	}	
		
}
?>
