<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Detail extends MY_Controller {

    public function __Construct() {

        parent::__Construct();
        ob_start();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('product_detail_model');
    }

    public function index($pid) {
        $id = $pid;
        $productRecords = $this->product_detail_model->GetRecords($id);

        //heading addreess
        $data['address'] = $productRecords[0]->address1;
        $data['updated_date'] = $productRecords[0]->updated_date;
        $data['name'] = $productRecords[0]->name;
        $data['product_description'] = $productRecords[0]->product_description;

        $cityName = $this->product_detail_model->getCity($productRecords[0]->city);
        $data['city_name'] = $cityName[0]->city_name;


        $blog_records = $this->product_detail_model->getBlogs();
        $bankDetail = $this->product_detail_model->bankDetails($id);

        $product_image = $this->product_detail_model->productImage($id);

        //tab photos
        $data['product_image'] = $product_image;
        //Recent blogs
        $data['blogs'] = $blog_records;

        //product iamges attributes
        //$productId = $bankDetail[0]->productID;
        //$attributeId = 18;
        //$productAttributes = $this->product_detail_model->productAttribute($productId,$attributeId);          
        //documents
        $documentRecords = $this->product_detail_model->getDocumentList($bankDetail[0]->doc_to_be_submitted);

        $data['docList'] = $documentRecords;
        $_SESSION['docName'] = $bankDetail[0]->related_doc;

        //product image
        $data['productImage'] = $product_image[0]->name;

        // Basic Details
        $data['borrower_name'] = $bankDetail[0]->borrower_name;
        $data['nodal_bank'] = $bankDetail[0]->nodal_bank;
        $data['nodal_bank_account'] = $bankDetail[0]->nodal_bank_account;
        $data['branch_ifsc_code'] = $bankDetail[0]->branch_ifsc_code;
        $data['press_release_date'] = $bankDetail[0]->press_release_date;
        $data['inspection_date_from'] = $bankDetail[0]->inspection_date_from;
        $data['inspection_date_to'] = $bankDetail[0]->inspection_date_to;

        //Auction Details
        $data['reference_no'] = $bankDetail[0]->reference_no;
        $data['tender_fee'] = $bankDetail[0]->tender_fee;
        $data['reserve_price'] = $bankDetail[0]->reserve_price;
        $data['event_type'] = $bankDetail[0]->event_type;
        $data['auction_pause_time'] = $bankDetail[0]->auction_pause_time;
        $data['auction_resume_time'] = $bankDetail[0]->auction_resume_time;
        $data['bid_inc'] = $bankDetail[0]->bid_inc;
        $data['auto_extension_time'] = $bankDetail[0]->auto_extension_time;
        $data['no_of_auto_extn'] = $bankDetail[0]->no_of_auto_extn;

        $this->load->view('front_view/header');
        $this->load->view('front_view/product_detail', $data);
        $this->load->view('front_view/footer');
    }

    public function downloadDoc() {
        $this->load->helper('download');

        $docName = "313a1d2e9522404936e21534b672021b.jpg";
        $name = $_SERVER["DOCUMENT_ROOT"] . "public/uploads/document/" . $docName;

        $path = file_get_contents(base_url() . "public/uploads/document/");

        //force_download($name, $data);
        force_download($docName, $path);
    }

    public function ratingReview() {
        $user_id = 3;
        $rating = $_REQUEST["rating"];
        $name = $_REQUEST["name"];
        if(isset($rating))
        //$this->product_detail_model->product_detail_model($rating,$review,$user_id);
        $this->load->view('front_view/rating-form');
    }

}

?>