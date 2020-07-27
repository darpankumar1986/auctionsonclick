<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Property extends MY_Controller 
{
    public function __Construct() 
    {
        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->model('home_model');
        $this->load->model('property_model');
        $this->load->model('product_detail_model');
        $this->load->library("pagination");
        $this->load->helper(array('form'));
    }

    public function index($page_no = 0) 
    {
		$url = $_SERVER['REQUEST_URI'];
		$urlArr = explode("/",$url);
		$bankShortname = trim($urlArr['1']); 
		$notFound = false;
		 
		if(!(in_array($bankShortname,'property?')))
		{
			$notFound = true;
		}
		if($notFound)
		{
			$this->load->view('errorpage');
			die;
		}
			
		if(!empty($_GET['math_type'])) 
		{
			$mathType  = $this->property_model->matchType($_GET['math_type']);
			if($mathType['is_auction']) 
			{
				$act = 'auction';
			}
			else 
			{
				$act = 'non_auction';
			}
			if($mathType['is_buy']=='buy')
			{
				$is_buy='sell';
			}
			else
			{
				$is_buy=$mathType['is_buy'];
			}
			$match = array('propertype'=>array($is_buy), 'act'=>$act, 'budget'=>explode(",", $mathType['budget']), 'build_up_area'=>trim($mathType['built_up_area']), 'match_city'=>explode(",", $mathType['city']), 'bedrooms'=>trim($mathType['bedrooms']));
			$_GET = $match;
		}
		
		$data['menu_type'] = $_GET['propertype'];
        $user_id = $this->session->userdata('id');
        $data['userId'] = trim($user_id);
        $bankData = $this->property_model->bankList();
        $categoryList = $this->property_model->categoryList();
        $OwnerList = $this->property_model->OwnerList();
        $acttype = $_GET['act'];
        if ($acttype == 'non_auction') 
        {
          $data['Alltotal_records']  = $this->property_model->TotalNonAuctionRecordsList();
        }
        else 
        {
          $data['Alltotal_records']  = $this->property_model->TotalAuctionRecordsList();
        }
		
        $config = array();
        $searcharry = array();
        $searchdata='';
		if(count($_GET)>0)
		{
			$searchdata=$_GET;
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
		}
		else
		{
		    $searchdata='';
			$config['suffix']='';
		}
		$total_records = $data['Alltotal_records'];
		$config["base_url"] = base_url() . "property/";
		$config["total_rows"] = $total_records;
		  
		if($_GET['limit_perpage'])
		{
			$config["per_page"] =$_GET['limit_perpage'] ;  
		}
		else
		{
			$config["per_page"] = 15;   
		}
         
		$config["uri_segment"] = 2;
		$config['use_page_numbers'] = true;
		$config['display_pages'] = true;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li ><a class="active">';
		$config['cur_tag_close'] = '</a></li>';
		//$config['num_links'] = '3';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		  
		$this->pagination->initialize($config);
		$page = $page_no;
        
        if($page>0)
        {
			$startlimit=($page-1)*$config["per_page"];
        }
        else
        {
			$startlimit=$page;
        }
		  
		  if ($acttype == 'non_auction') {
            $AuctionRecordsList = $this->property_model->NonAuctionRecordsList($startlimit, $config["per_page"], $searcharry);
			
        } else {
            $AuctionRecordsList = $this->property_model->AuctionRecordsList($startlimit, $config["per_page"], $searcharry);
        }
		  

        $data["pagination_links"] = $this->pagination->create_links();
        $data['AuctionRecordsList'] = $AuctionRecordsList;
        $data['bankData'] = $bankData;
        $data['categoryList'] = $categoryList;
        $data['OwnerList'] = $OwnerList;
        $property_list_leftsidebar = $this->load->view('front_view/property_list_leftsidebar', $data, true);
        $property_list_leftsidebar_phone = $this->load->view('front_view/property_list_leftsidebar_phone', $data, true);
        $data['property_list_leftsidebar'] = $property_list_leftsidebar;
        $this->load->view('front_view/header',$data);
        $this->load->view('front_view/footer');
    }

    public function detail($pid) 
    {
        $id = $pid;
        $data['id'] = $id;
	    $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('user_type');
        $data['userId'] = trim($user_id);
        $response = $this->product_detail_model->checkBankNonbank($id);
        $productRecords = $this->product_detail_model->GetRecords($id);
        $productRecords1 = $this->product_detail_model->GetRecords_auction($id);

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
		//$data['countUser'] = count($data['reviewAll']);
        $data['countUser']  = $this->property_model->totalRatedUsers($pid);
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
		$country =	GetTitleByField('tbl_country', "id='".$userData[0]->country."'", 'country_name');
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
        $fulladdress	= 	$productRecords[0]->address1.', '.$productRecords[0]->street.', '.$data['city_name'].', '.$country;
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
		$cityNameMain =	GetTitleByField('tbl_city', "id='".$bankDetail[0]->city."'", 'city_name');
		$data['cityNameMain'] = $cityNameMain;
		$nodelbranchname=GetTitleByField('tbl_bank',"id='".$bankDetail[0]->nodal_bank_name."'",'name');
		$totalCirrigendum=$this->property_model->checkAuctionCirrigendum($bankDetail[0]->id);
		$data['totalCirrigendum'] = $totalCirrigendum;
        $data['branchname'] = $branchname;
        $data['nodelbranchname'] = $nodelbranchname;
        $data['bank_name'] = $bankName[0]->name;
		$data['nodal_bank_account'] = $bankDetail[0]->nodal_bank_account;
		
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
		if($bankDetail[0]->dsc_enabled == '1')
		{
			$dscStatus = 'Yes';
		}
		else
		{
			$dscStatus = 'No';
		}
		$data['dscStatus'] = $dscStatus;
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
        $data['corrigendum'] = $this->product_detail_model->getCorrigendum($bankDetail[0]->id);
        
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
        // download link availability //
        $doc = $this->product_detail_model->getDoc($id);
        $data['docName'] = $doc[0]->public_notice_eng_doc;
        
        $CorrigendumDocImages = $this->product_detail_model->getCorrigendumDocImages($bankDetail[0]->id);
        $data['CorrigendumDocImages'] = $CorrigendumDocImages;
        
        $CorrigendumSupportingDocSpecialImages = $this->product_detail_model->getCorrigendumSupportingDocSpecialImages($bankDetail[0]->id);
        $data['CorrigendumSupportingDocSpecialImages'] = $CorrigendumSupportingDocSpecialImages;
        
        $getCorrigendumRelatedDocImages = $this->product_detail_model->getCorrigendumRelatedDocImages($bankDetail[0]->id);
        $data['getCorrigendumRelatedDocImages'] = $getCorrigendumRelatedDocImages;
        
        $this->load->view('common/website_header_eauc', $data);	
		$this->load->view('front_view/product_detail_bank_eauc', $data);
        $this->load->view('front_view/footer_m');
    }
    
	public function admindetail($pid) 
	{
        $id = $pid;
        $data['id'] = $id;
	    $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('user_type');
        $data['userId'] = trim($user_id);
        $response = $this->product_detail_model->checkBankNonbank($id);
        $productRecords = $this->product_detail_model->GetRecords($id);

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
		$country =	GetTitleByField('tbl_country', "id='".$userData[0]->country."'", 'country_name');
		$data['catename']=$productRecords[0]->product_type_val;
		$data['subcategory']=$productRecords[0]->product_subtype_val;
		$fulladdress	= 	$productRecords[0]->address1.', '.$productRecords[0]->street.', '.$data['city_name'].', '.$country;
		$data['fulladdress']=$fulladdress;
        //interested user //
        $interested_users = $this->product_detail_model->getInterestedUser($pid);
        $data['interested_users'] = $interested_users[0]->users;

        $blog_records = $this->product_detail_model->getBlogs();
       
        $product_image = $this->product_detail_model->productImage($id);
        // product video
        $product_video = $this->product_detail_model->productVideo($id);
        $data['video'] = $product_video;
        
        $varified = $this->product_detail_model->imageVerified($id);
        $data['verified'] = trim($varified[0]->values);
        //tab photos
        $data['product_image'] = $product_image;
        //Recent blogs
        $data['blogs'] = $blog_records;
        $documentRecords = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);

        $data['docList'] = $documentRecords;
        $_SESSION['docName'] = $bankDetail[0]->related_doc;

        //product image
        $data['productImage'] = $product_image[0]->name;
        $data['auction_type'] = $bankDetail[0]->auction_type;

        // Basic Details
        $data['auctionID'] = $bankDetail[0]->id;
        $data['borrower_name'] = $bankDetail[0]->borrower_name;
        $bankName = $this->product_detail_model->getBankName($bankDetail[0]->bank_id);
        $branchname=GetTitleByField('tbl_branch',"id='".$bankDetail[0]->branch_id."'",'name');
        $nodelbranchname=GetTitleByField('tbl_branch',"id='".$bankDetail[0]->nodal_bank_name."'",'name');
        $totalCirrigendum=$this->property_model->checkAuctionCirrigendum($bankDetail[0]->id);
        $data['totalCirrigendum'] = $totalCirrigendum;
        $data['branchname'] = $branchname;
        $data['nodelbranchname'] = $nodelbranchname;
        $data['bank_name'] = $bankName[0]->name;
		$data['nodal_bank_account'] = $bankDetail[0]->nodal_bank_account;
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
        $data['event_type'] = $bankDetail[0]->event_type;
        $data['reference_no'] = $bankDetail[0]->reference_no;
        $data['tender_fee'] = $bankDetail[0]->tender_fee;
        $data['price_bid_applicable'] = trim($bankDetail[0]->price_bid_applicable);
        $data['reserve_price'] = $bankDetail[0]->reserve_price;
        $data['emd_amt'] = $bankDetail[0]->emd_amt;
        $data['auction_start_date'] = $bankDetail[0]->auction_start_date;
        $data['auction_end_date'] = $bankDetail[0]->auction_end_date;
        $data['bid_inc'] = $bankDetail[0]->bid_inc;
        $data['auto_extension_time'] = $bankDetail[0]->auto_extension_time;
        $data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;
        
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
        $data['docName'] = $doc[0]->related_doc;
        $this->load->view('front_view/header');
        if (isset($response[0]->auctionID) != "" && $is_auction==1) 
        {
            $this->load->view('front_view/product_detail_bank', $data);
        }
        else 
        {
            $this->load->view('front_view/product_detail_nonbank', $data);
        }
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
            //rating field value //
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
        if (isset($email) != "") 
        {
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
