<?php

class Product_detail_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getCity($cityId) {
        $this->db->where('id', $cityId);
        $query = $this->db->get("tbl_city");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function GetRecords($id) {

        $this->db->where('id', $id);
        $query = $this->db->get("tbl_product");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     public function GetRecords_auction($id) {

        $this->db->where('au.productID', $id);
        $this->db->from('tbl_auction as au');
        $this->db->join('tblmst_account_type as act','act.account_id=au.account_type_id','left');        
        $query = $this->db->get();
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function getBlogs() {
        $this->db->where('category', 'blog');
        $this->db->order_by('publish_date', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get("tbl_news_blog");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function bankDetails($id) {

        $this->db->where('productID', $id);
        $query = $this->db->get("tbl_auction");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function productImage($id) {
        $this->db->select('name');
        $this->db->order_by('priority', 'ASC');
        $this->db->where('product_id', $id);
        $this->db->where('status', 1);
        $this->db->where('type', 'images');
        $query = $this->db->get("tbl_product_image_video");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     public function productVideo($id) {
       // $this->db->select('name,type');
        $this->db->order_by('priority', 'ASC');
        $this->db->where('product_id', $id);
        $this->db->where('status', 1);
        $typeArr=array('url','video');
		$this->db->where_in('type', $typeArr);
		$this->db->limit(1);
        $query = $this->db->get("tbl_product_image_video")->row_object();
        return $query ;
    }

    function getattributeValuedata($id){
        
        $this->db->select('atv.attr_name,atv.values');	
        $this->db->from("tbl_product_attribute_value as atv");
        $this->db->where('atv.product_id ', $id);
        $this->db->where('atv.status !=', 5);							 
        $this->db->where('a.is_show_on_strip', 1); 				 
        $this->db->order_by('a.priority'); 
        $this->db->limit(3); 
        $this->db->join("tbl_attribute as a","a.id=atv.attribute_id"); 								 
        $subquery = $this->db->get();	
        $data = array();
        foreach ($subquery->result() as $avrow){
               $data[] = $avrow;
        }
        return $data;
	
	}
    public function productAttribute($productId, $attributeId) {
        $this->db->select('values');
        $this->db->where('product_id', $productId);
        $this->db->where('attribute_id', $attributeId);
        $this->db->where('status !=', 5);
        $query = $this->db->get("tbl_product_attribute_value");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getDocumentList($id) {
        $this->db->select('name');
        $arr = explode(",", $id);
        $this->db->where_in('id', $arr);
        $query = $this->db->get("tbl_doc_master");

        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

   
    public function getReviews($product_id,$user_id=null,$type=null) {
        $this->db->where('product_id', $product_id);
        $this->db->order_by('created_date','DESC');
		if($type !='all')
		{
			$this->db->limit(3);
		}
		$this->db->from("tbl_rating_review");
		$query = $this->db->get(); 
		//echo $this->db->last_query();
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function GetRatingReviewId($id,$user_id){
        $this->db->select('id');
        $this->db->where('product_id', $id);
        $this->db->where('user_id', $user_id);
         $this->db->from("tbl_rating_review");
         $query = $this->db->get();
         $data = array();
          if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function addReview($data, $user_id, $id,$rating_review_id) {
	    $user_id = $this->session->userdata('id');
        $user_type = $this->session->userdata('user_type');
        if(!empty($rating_review_id)){
            $this->db->where('id', $rating_review_id);
			$date = date('Y-m-d H:i:s');
			$data['created_date']=$date;
			$data['user_type'] = $user_type;
            $this->db->update('tbl_rating_review', $data);
            redirect('property/detail/' . $id);
        }else{
             $ip_address = $_SERVER["REMOTE_ADDR"];
             $date = date('Y-m-d H:i:s');
             $ratin_review_data = array(
                "user_id" => $user_id,
                "user_type" => $user_type,
                "product_id" => $id,
                "ip_address" => $ip_address,
                 "traffic" => $data['traffic'],
                 "connectivity" => $data['connectivity'],
                 "parking" => $data['parking'],
                 "public_transport" => $data['public_transport'],
                 "cleanliness" => $data['cleanliness'],
                 "safety" => $data['safety'],
                 "neighborhood" => $data['neighborhood'],
                "reviews" => $data['reviews'],
                "review_title" => $data['review_title'],
                "created_date" => $date,
            );
            //echo "<pre>";print_r($ratin_review_data);die;
            $this->db->insert('tbl_rating_review', $ratin_review_data);
            redirect('property/detail/' . $id);
        }
    }

    public function checkBankNonbank($id) {
        $this->db->select('auctionID,sell_rent');
        $this->db->where('id', $id);
        $query = $this->db->get("tbl_product");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getRatingReviewData($user_id,$product_id) {
       // $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get("tbl_rating_review");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function getCorrigendum($id) { 
		$this->db->limit(1);
        $this->db->where('auctionID', $id);
        $this->db->order_by('indate', 'DESC');
        $query = $this->db->get("tbl_auction_corrigendum");        
        $data = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
        return $data;
    }
    
    public function getAllCorrigendumByAuctionID($id) { 		
        $this->db->where('auctionID', $id);
        $this->db->order_by('indate', 'ASC');
        $query = $this->db->get("tbl_auction_corrigendum");        
        $data = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
        return $data;
    }
    
    public function getDoc($id) {
         $this->db->select('public_notice_eng_doc');
        $this->db->where('productID', $id);
        $query = $this->db->get("tbl_auction");
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function getCorrigendumSupportingDocSpecialImages($id) {
        $this->db->select('supporting_doc,old_supporting_doc');
        $this->db->where('auctionID', $id);
        $query = $this->db->get("tbl_auction_corrigendum");

		$this->db->select('supporting_doc');
        $this->db->where('id', $id);
        $query1 = $this->db->get("tbl_auction");
        if ($query1->num_rows() > 0) {
			foreach ($query1->result() as $row1) {
				$imageLink = $row1->supporting_doc;
			}
		}
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
				//if($row->supporting_doc != 0)
				{
					if($row->old_supporting_doc != $row->supporting_doc)
					{
						$data[] = $row->old_supporting_doc;
					}	
				}
            }
            return $data;
        }
        return false;
    }
    
    public function getCorrigendumDocImages($id) {
        $this->db->select('image,old_image');
        $this->db->where('auctionID', $id);
        $query = $this->db->get("tbl_auction_corrigendum");

		$this->db->select('image');
        $this->db->where('id', $id);
        $query1 = $this->db->get("tbl_auction");
        if ($query1->num_rows() > 0) 
        {
			foreach ($query1->result() as $row1) 
			{
				$imageLink = $row1->image;
			}
		}
        
        $data = array();
		//echo $imageLink;die;
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
				if($row->old_image != $row->image && $imageLink!='')
				{
					$data[] = $row->old_image;
				}
            }
           // die;
            return $data;
        }
        return false;
    }
    
    public function getCorrigendumRelatedDocImages($id) {
        $this->db->select('related_doc,old_related_doc');
        $this->db->where('auctionID', $id);
        $query = $this->db->get("tbl_auction_corrigendum");
		
		$this->db->select('public_notice_eng_doc');
        $this->db->where('id', $id);
        $query1 = $this->db->get("tbl_auction");
        if ($query1->num_rows() > 0) {
			foreach ($query1->result() as $row1) {
				$imageLink = $row1->public_notice_eng_doc;
			}
		}
        
        $data = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				if($row->old_related_doc != $row->related_doc)
				{
					$data[] = $row->old_related_doc;
				}
            }
            return $data;
        }
        return false;
    }
    
    public function getRecentProperties(){
        //select a.city,count(a.id),c.city_name from tbl_product as a inner JOIN tbl_city as c ON c.id=a.city where 1=1 group by city
        $this->db->select('a.city, count(a.id) as count, c.city_name');
        $this->db->where('CURDATE() < p.bid_last_date');
        $this->db->from("tbl_product as a");
        $this->db->join('tbl_city as c', 'c.id=a.city','inner');
        $this->db->join('tbl_auction as p','a.id=p.productID');
        $this->db->group_by("city");
        $query = $this->db->get(); 
        //echo $this->db->last_query();
        
        $data = array();
        
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getSimilarProperties($val,$id) {
        
        $this->db->select('a.id,a.name as title,a.product_type_val,d.reserve_price,d.bid_last_date,c.city_name,p.name');
        $this->db->where('p.type', 'images');
        $this->db->where('a.id !=', $id);
        $this->db->from("tbl_product as a");
        $this->db->join('tbl_city as c', 'c.id=a.city');
        $this->db->join('tbl_product_image_video as p','a.id=p.product_id');
        $this->db->join('tbl_auction as d','a.id=d.productID');
        $this->db->like('product_type_val', $val); 
        $this->db->group_by("a.id");
        $this->db->limit(3); 
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function userRating($user_id,$product_id){
        $this->db->select('neighborhood,safety,cleanliness,public_transport,parking,connectivity,traffic');
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_rating_review'); 
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function insertUserRating($format_rating,$user_id,$product_id){
         $data = array(
                "total_rating" => $format_rating
            );
            $this->db->where('user_id', $user_id);
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_rating_review', $data);
    }
    public function getTotalRating($product_id){
        $this->db->select('count(total_rating) as totalrow, SUM(total_rating) AS totalsum');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_rating_review'); 
        // echo $this->db->last_query();die;
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function userRatingCategory($product_id){
        $this->db->select('total_rating');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_rating_review'); 
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function checkSubscribeEmail($email) {
        
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_subscribe'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            return 1;
        }else{
            $data = array(
                "email" => $email
            );
            $this->db->insert('tbl_subscribe', $data);
        }
        
        
    }
    public function getUserDetails($user_id){
        $this->db->where('id', $user_id);
        $query = $this->db->get('tbl_user'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	 public function getUserbyTypeDetails($table,$user_id){
        $this->db->where('id', $user_id);
        $query = $this->db->get($table); 
        $data = array();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
    public function avgStarRatingForAllUser($product_id){
        $this->db->select('count(*) as row,sum(neighborhood) as neighborhood,sum(safety) as safety,sum(cleanliness) as cleanliness,sum(public_transport) as public_transport,sum(parking) as parking,sum(connectivity) as connectivity,sum(traffic) as traffic');
        $this->db->where('product_id', $product_id);
         $query = $this->db->get('tbl_rating_review'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getInterestedUser($id){
        
        $this->db->select('count(bidderID) as users');
        $this->db->from("tbl_auction_participate as p");
        $this->db->join('tbl_auction a', 'a.id = p.auctionID','inner');
        $this->db->where('a.productID', $id);
        $this->db->where('p.status', 1);
        $query = $this->db->get(); 
        //echo $this->db->last_query();
        
        $data = array();
        
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function getBankName($id){
         $this->db->select('name');
         $this->db->where('id', $id);
        $query = $this->db->get('tbl_bank'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
     public function getBankDetail($id){
         $this->db->select('tender_doc,annexure2,annexure3');
         $this->db->where('id', $id);
        $query = $this->db->get('tbl_bank'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getBankNamedoc($id){
         $this->db->select('tender_doc,annexure2,annexure3');
         $this->db->where('id', $id);
        $query = $this->db->get('tbl_bank'); 
        
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function save_favourite($user_id, $productId) {
        $date = date('Y-m-d H:i:s');
        $status =1;
		$fid=GetTitleByField('tbl_user_favorites', "user_id='".$user_id."' AND product_id='".$productId."'", 'id');
		if($fid <= 0)
		{
		 $data = array(
                "user_id" => $user_id,
                "product_id" => $productId,
                "indate" => $date,
                "status" => $status,
            );
             $this->db->insert('tbl_user_favorites', $data);	
			return 1;
		}else{
			return 0;
		}
    }
    public function imageVerified($id){
        $this->db->select('values');
        $this->db->where('product_id', $id);
        $this->db->where('attribute_id', 11);
        $query = $this->db->get('tbl_product_attribute_value'); 
        //echo $this->db->last_query();
        $data = array();

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	 public function getcheckApprovedProduct($pid){
        $this->db->where('id', $pid);
        $this->db->where('status !=', 0);
        $this->db->where('status !=', 5);
        $query = $this->db->get('tbl_product'); 
        $data = array();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
			$data=$query->num_rows();
            return $data;
        }else{
			$data=0;
			
		}
    }
	
	
	
	
}

?>
