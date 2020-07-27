<?php
class Product_listing_model extends CI_Model{

    function __construct(){
            parent::__construct();
            $this->load->database();
    }
    function listingRecords()
    {
		$this->db->where('status ', 1);									
		$query = $this->db->get("tbl_product");	
		
		if($query->num_rows() > 0){
            foreach ($query->result() as $row){	
          if($row->is_auction){
            $this->db->select('id ');
            $this->db->where('status !=', 5);									
            $subquery = $this->db->get("tbl_auction");	
            foreach ($query->result() as $arow){}
            $row->product_detail=$row;								
            }
            $data[] = $row;
            }
            return $data;
        }
            
            return false;
    }
  
  public function GetProductDetailByProductID($productID=16){
      
    $this->db->select('a.* , b.id as a_id, b.id as b_id, b.event_title as b_event_title, DATE(b.bid_last_date) as b_bid_last_date, b.reserve_price as b_reserve_price');		
    $this->db->from("tbl_product as a");
    $this->db->join('tbl_auction as b', 'b.productID = a.id');
    //$this->db->where("FIND_IN_SET('$category_id',ag.product_id) !=", 0);
    $this->db->where("a.status != ", 5);
    $this->db->order_by("a.id", "desc");
    $this->db->limit(10,0);
    
    $query = $this->db->get();
    //echo $this->db->last_query();
      
    /*//$this->db->where('id ', $productID);
    $this->db->limit(10,0);
    $this->db->order_by('id DESC');
    $query = $this->db->get("tbl_product");
    //echo $this->db->last_query();*/
    
    
    
    $data = array();
    if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
            
            if ($row->id){
                
                $this->db->where('product_id ', $row->id);
                $this->db->where('status !=', 5);
                $query = $this->db->get("tbl_product_image_video");
                
                foreach ($query->result() as $irow) {
                    $row->images[] = $irow;
                }

                $this->db->where('product_id ', $row->id);
                $this->db->where('status !=', 5);
                $query = $this->db->get("tbl_product_attribute_value");
                foreach ($query->result() as $arow) {
                   $row->attr_val[] = $arow;
                }
                
                //Get City Data
                    if($row->city > 0){
                        
                        $this->db->where('id', $row->city);
                        $query = $this->db->get("tbl_city");
                        //echo $this->db->last_query();
                        foreach ($query->result() as $cityrow) {
                           $row->city_name = $cityrow->city_name;
                            
                            //echo '<br />'.$cityrow->city_name;
                            //echo $row = $cityrow->city_name;
                            
                            //echo '<pre>', print_r($cityrow), '</pre>';
                        }
                    }
                    
                //Get Attribute
                    $this->db->select('attribute_id ,values');
                    $this->db->where('product_id ', $row->id);
                    $query = $this->db->get("tbl_product_attribute_value");	
                    //echo $this->db->last_query();

                    $data = array();

                    if ($query->num_rows() > 0){

                        foreach ($query->result() as $row){
                            $data[$row->attribute_id] = $row;
                        }
                    }
                    
            }
            
            $data[] = $row;
        }
        return $data;
    }
    return false;
    }

}
   ?>