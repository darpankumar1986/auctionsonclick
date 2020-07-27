<?php
class Property_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}	
	function bankList()
    {
		$this->db->select('id,shortName');
		$this->db->where('status', 1);
		//$this->db->limit(21);
                $this->db->from("tbl_bank");
                $query = $this->db->get();
	     if($query->num_rows() > 0){
	        $data=array();
                foreach ($query->result() as $row){
                            $data[]=$row;
                }
                return $data;
               }else{
              $data=0;
              return $data;	
             }
    }
	function categoryList(){
		$this->db->select('id,name');
		$this->db->where('status', 1);
		$this->db->where('parent_id', 0);
		//$this->db->limit(21);
        $this->db->from("tbl_category");
        $query = $this->db->get();
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}else{
			$data=0;
			return $data;	
		}
    }
		function SubcategoryList($cate)
    {
		$this->db->select('id,name');
		$this->db->where('status', 1);
		$this->db->where('parent_id', $cate);
		//$this->db->limit(21);
        $this->db->from("tbl_category");
        $query = $this->db->get();
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}else{
			$data=0;
			return $data;	
		}
    }
	
	function OwnerList()
    {
		$this->db->select('id, first_name, last_name,email_id');
		$this->db->where('status', 1);
		$this->db->where('user_type', 'owner');
        $this->db->from("tbl_user_registration");
        $query = $this->db->get();
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}else{
			$data=0;
			return $data;	
		}
    }
	function getPostedProductId($postedby){
             $this->db->select('id');
             $this->db->where_in('user_type', $postedby);
             $query = $this->db->get("tbl_user_registration");
             $this->db->last_query();
             $data = array();
                        if ($query->num_rows() > 0) {
                            foreach ($query->result() as $row) {
                            $data[] = $row;
                        }
                        return $data;
                        
                    }
        }
    /*for new grid view of last search*/
	function getLastSearchRequest() {
		$this->db->order_by("id", 'desc');
		$this->db->limit(1);
		$data = $this->db->get("tbl_user_search_detail")->row_array();
		if(!empty($data['search_content'])) {
			return $data['search_content'];
		}
	}
	
	
	function NonAuctionRecordsList($startlimit, $per_page,$searcharry){
		
		$limit_perpage=$_GET['limit_perpage'];
		$sort_by=$_GET['sort_by'];
		$location=$_GET['location'];
		$category=$_GET['category'];
		$subcategory=$_GET['subcategory'];
		$bankname=$_GET['bankname'];
		$start_date=$_GET['start_date'];
		$end_date=$_GET['end_date'];
		$budgetArr=$_GET['budget'];
		$action=$_GET['action'];
		$owner=$_GET['owner'];
		$propertype=$_GET['propertype'];
                $postedby = $_GET['postedby'];
		if(count($budgetArr)>0)
		{
			$budgetRange=array();
			foreach($budgetArr as $b_range)
			{
				$budgetr=explode('-',$b_range);
			
				$budgetRange[]=$budgetr[0];
				$budgetRange[]=$budgetr[1];
			}
		$minBudget=min($budgetRange);	
		$maxBudget=max($budgetRange);		
		}
           $this->db->select('p.*');
	   $this->db->from("tbl_product as p");
	   $this->db->join("tbl_user_registration as u",'u.id=p.user_id','left');
       if(count($postedby)>0){
	   $this->db->where_in("u.user_type", $postedby);
	  }
       if($location) {
			$cityid=GetTitleByField('tbl_city', "city_name='$location'", 'id');
			$this->db->where("p.city",$cityid);	
		}
		if(isset($_GET['match_city'])) {
			$cities = explode(',', $_GET['match_city']);
			foreach($cities as $city) {
				$cityid[] = GetTitleByField('tbl_city', "city_name='$city'", 'id');
			}
			$this->db->where_in("p.city", $cityid);
		}
		
		
		if(count($category)>0){
		$category=$this->findStringFromArray($category);
		if(count($subcategory)>0){
			$subcategory=$this->findStringFromArray($subcategory);
			$this->db->where("(p.product_type_val IN($category) AND p.product_subtype_val IN($subcategory))");	
		}else{
			$this->db->where("(p.product_type_val IN($category))");		
		}			
		}
        
		//if($budgetArr!=0){
			if(count($budgetArr)>0){
				if($minBudget>0 && $maxBudget>0){
				$this->db->where("p.price BETWEEN '$minBudget' AND '$maxBudget'");
				}
			}
		//}
		
		if(($sort_by!='')){
			$this->db->order_by($sort_by);
		}
		
		if(count($propertype)>0){
			 $this->db->where_in("p.sell_rent", $propertype);
		}
		
		$this->db->where('p.status', 1);
		$this->db->where('p.is_auction', 0);
		if($limit_perpage){
			$this->db->limit($limit_perpage,$startlimit);	
		}else{
			$this->db->limit($per_page,$startlimit);
			
		}
        $query = $this->db->get();
		//echo $this->db->last_query();
		//die;
		$total_records=$query->num_rows();
		if($query->num_rows() > 0){
            foreach ($query->result() as $row){	
				if($row->id){
					$this->db->where('product_id ', $row->id);	
					$this->db->where('status != ',5);		
					$this->db->where('type ','images');
					$this->db->order_by('priority','ASC');
					$this->db->limit(1);
					$subquery = $this->db->get("tbl_product_image_video");	
					foreach ($subquery->result() as $irow){
					$row->image[]=$irow;
					}
					 $this->db->select('a.icon,atv.attribute_id,atv.attr_name,atv.values');	
					 $this->db->from("tbl_product_attribute_value as atv");
					 $this->db->where('atv.product_id ', $row->id);
					 $this->db->where('atv.status !=', 5);							 
					 $this->db->where('a.is_show_on_strip', 1); 				 
					 $this->db->order_by('a.priority'); 
					 $this->db->join("tbl_attribute as a","a.id=atv.attribute_id"); 
					 $this->db->limit(3); 								 
					 $subquery = $this->db->get();	
					 foreach ($subquery->result() as $avrow){
						$row->attribute[]=$avrow;
					 }
						 
				}
				$row->total_records = $total_records;	
								
                $data[] = $row;
				
            }
            return $data;
			}
            $data=0; 
            return $data;
		
	}
	
	function TotalNonAuctionRecordsList($startlimit, $per_page,$searcharry){
		//$limit_perpage=$_GET['limit_perpage'];
		$sort_by=$_GET['sort_by'];
		$location=$_GET['location'];
		$category=$_GET['category'];
		$subcategory=$_GET['subcategory'];
		$bankname=$_GET['bankname'];
		$start_date=$_GET['start_date'];
		$end_date=$_GET['end_date'];
		$budgetArr=$_GET['budget'];
		$action=$_GET['action'];
		$owner=$_GET['owner'];
		$propertype=$_GET['propertype'];
        $postedby = $_GET['postedby'];
		if(count($budgetArr)>0)
		{
			$budgetRange=array();
			foreach($budgetArr as $b_range)
			{
				$budgetr=explode('-',$b_range);
			
				$budgetRange[]=$budgetr[0];
				$budgetRange[]=$budgetr[1];
			}
				
		$minBudget=min($budgetRange);	
		$maxBudget=max($budgetRange);		
		}
		//print_r($budgetArr);
                 // posted by start//
                
       $this->db->select('p.*');
	   $this->db->from("tbl_product as p");
	   $this->db->join("tbl_user_registration as u",'u.id=p.user_id','left');
       if(count($postedby)>0){
			   $this->db->where_in("u.user_type", $postedby);
			}
 
		if($location){
			$cityid=GetTitleByField('tbl_city', "city_name='$location'", 'id');
			$this->db->where("p.city",$cityid);	
		}
		if(isset($_GET['match_city'])) {
			$cities = explode(',', $_GET['match_city']);
			foreach($cities as $city) {
				$cityid[] = GetTitleByField('tbl_city', "city_name='$city'", 'id');
			}
			$this->db->where_in("p.city", $cityid);
		}
		if(count($category)>0){
		$category=$this->findStringFromArray($category);
		if(count($subcategory)>0){
			$subcategory=$this->findStringFromArray($subcategory);
			$this->db->where("(p.product_type_val IN($category) AND p.product_subtype_val IN($subcategory))");		
		}else{
			$this->db->where("(p.product_type_val IN($category))");		
		}			
		}
        
		if(count($budgetArr)>0){
			if($minBudget>0 && $maxBudget>0){
			$this->db->where("p.price BETWEEN '$minBudget' AND '$maxBudget'");
			}
		}
		if(($sort_by!='')){
			$this->db->order_by($sort_by);
		}
		
		if(count($propertype)>0){
			 $this->db->where_in("p.sell_rent", $propertype);
		}
		
		$this->db->where('p.status', 1);
		$this->db->where('p.is_auction', 0);
		if($limit_perpage){
			//$this->db->limit($limit_perpage,$startlimit);	
		}else{
			//$this->db->limit($per_page,$startlimit);
			
		}
        $query = $this->db->get();
		//echo $this->db->last_query();
		//die;
		$total_records=$query->num_rows();
		return $total_records;
		
	}
	function AuctionRecordsList($startlimit, $per_page,$searcharry)
    {
			
		$limit_perpage=$_GET['limit_perpage'];
		$sort_by=$_GET['sort_by'];
		$location=$_GET['location'];
		$category=$_GET['category'];
		$subcategory=$_GET['subcategory'];
		$bank_name=$_GET['bank_name'];
		$bankname=$_GET['bankname'];
		$start_date=$_GET['start_date'];
		$end_date=$_GET['end_date'];
		$postedby = $_GET['postedby'];
		$propertype = $_GET['propertype'];
		$categorySearch = $_GET['categorySearch'];
		$key = $_GET['key'];
		$actiontype=$_GET['actiontype'];
		$action=$_GET['action'];
		//print_r($propertype);
		
		if(empty($budget_Arr)){
			$budgetArr=$_GET['budget'];
		}else{
			$budgetArr = $_GET['budget'];
		}
		
		//print_r($budgetArr);
		
		$owner=$_GET['owner'];
	    if(count($budgetArr)>0)
		{
			$budgetRange=array();
			foreach($budgetArr as $b_range)
			{
				$budgetr=explode('-',$b_range);
			
				$budgetRange[]=$budgetr[0];
				$budgetRange[]=$budgetr[1];
			}
		$minBudget=min($budgetRange);	
		$maxBudget=max($budgetRange);		
		}
		
                // posted by end//
	$this->db->select('a.id,a.productID,a.reserve_price,a.bid_last_date,a.bid_opening_date,a.bank_id');
	if($actiontype=='pastauction')
	{
		$this->db->where('a.status !=',5);	
	}else{
		$this->db->where('a.status', 1);
	}
	
	$this->db->where('p.status', 1);
	
	if(count($categorySearch)>0){
		$this->db->where("(p.product_type_val IN('$categorySearch') OR p.product_subtype_val IN('$categorySearch'))");			
	}
	if(count($category)>0){
		$category=$this->findStringFromArray($category);
		if(count($subcategory)>0){
			$subcategory=$this->findStringFromArray($subcategory);
			$this->db->where("(p.product_type_val IN($category) AND p.product_subtype_val IN($subcategory))");		
		}else{
			$this->db->where("(p.product_type_val IN($category))");		
		}			
	}
		      
		if($bank_name!=''){
		$this->db->where('a.bank_id', $bank_name);	
		}
		if(count($bankname)>0){
			$this->db->where_in('a.bank_id', $bankname);
		}
		if(count($budgetArr)>0){
			if($minBudget>0 && $maxBudget>0){
			$this->db->where("a.reserve_price BETWEEN '$minBudget' AND '$maxBudget'");
			}
		}
		
		
		
		if(($start_date!='') && ($end_date!='')){
			$start_date	=	date('Y-m-d',strtotime($start_date));
		    $end_date	=	date('Y-m-d',strtotime($end_date));
			$this->db->where("(DATE (a.auction_end_date) BETWEEN '$start_date' AND '$end_date')");	
			}
		
		$this->db->where('a.is_closed', 0);
		$this->db->where('a.productID != 0');
		$this->db->where('a.productID is not null');
		
		if($action=='past' || $actiontype=='pastauction'){
			$this->db->where('NOW() > a.auction_end_date');
		}else{
			$this->db->where('NOW() <= a.auction_end_date');	
		}
		
		if(($sort_by!='Sort') || ($sort_by!=''))
		{
			if($sort_by=='name')
			{
				$this->db->order_by('event_title');	
			}else if($sort_by=='price'){
				$this->db->order_by('reserve_price');
			}else{
				$this->db->order_by('a.id','DESC');	
			}
		}else{
			$this->db->order_by('a.id','DESC');	
		}
		
		if($limit_perpage){
			$this->db->limit($limit_perpage,$startlimit);	
		}else{
			$this->db->limit($per_page,$startlimit);
			
		}
		
		if($location){
		$cityid=GetTitleByField('tbl_city', "city_name='$location'", 'id');
		$this->db->where("p.city",$cityid);	
		}
		if(isset($_GET['match_city'])) {
			$cities = explode(',', $_GET['match_city']);
			foreach($cities as $city) {
				$cityid[] = GetTitleByField('tbl_city', "city_name='$city'", 'id');
			}
			$this->db->where_in("p.city", $cityid);
		}
        
        $this->db->from("tbl_auction as a");
        $this->db->where_in('p.user_id', $response_data);
		$this->db->join('tbl_product as p','p.id=a.productID');
		if(count($postedby)>0){
		$this->db->join("tbl_user_registration as u",'u.id=p.user_id');	
		$this->db->where_in("u.user_type", $postedby);
		}
		if($propertype!='sell'){
			if($propertype[0]!='sell'){
				if(count($propertype) > 0){
					 $this->db->where_in("p.sell_rent",$propertype);
					 
				}
			}
			
		}
		if($key!=''){
			$this->db->join('tbl_city as c','c.id=p.city');
			$this->db->join('tbl_state as s','s.id=p.state');
			$this->db->join('tbl_product_attribute_value as at','at.product_id=p.id');
			$this->db->join('tbl_bank as b','b.id=a.bank_id');
			$this->db->join('tbl_branch as br','br.id=a.branch_id');
			$this->db->where("(a.reference_no='$key' OR a.tender_no='$key' 
									 OR a.event_type ='$key'
									 OR a.event_title LIKE '%$key%' 
									 OR p.name LIKE '%$key%'
									 OR p.product_description LIKE '%$key%'
									 OR p.product_type_val = '$key'
									 OR p.product_subtype_val = '$key'
									 OR c.city_name = '$key'
									 OR s.state_name = '$key'
									 OR b.name  LIKE '%$key%'
									 OR b.shortName = '$key'
									 OR at.attr_name LIKE '%$key%'
									 OR at.values LIKE '%$key%'
								)");
		$this->db->group_by('at.product_id');						
		}
		
        $query = $this->db->get();
		$total_records=$query->num_rows();
		if($total_records > 0){
            foreach ($query->result() as $row){	
				if($row->id){
								$this->db->where('product_id ', $row->productID);	
								$this->db->where('status != ',5);		
								$this->db->where('type ','images');
								$this->db->order_by('priority','ASC');
								$this->db->limit(1);
								$subquery = $this->db->get("tbl_product_image_video");	
								foreach ($subquery->result() as $irow){
								 $row->image[]=$irow;
								}
								$this->db->where('id ', $row->productID);
								$this->db->where('status !=', 5);									
								$subquery = $this->db->get("tbl_product");	
								foreach ($subquery->result() as $prow){}
								 $row->product_detail=$prow;
								 $this->db->select('a.icon,atv.attribute_id,atv.attr_name,atv.values');	
								 $this->db->from("tbl_product_attribute_value as atv");
								 
								 $this->db->where('atv.product_id ', $row->productID);
								 $this->db->where('atv.status !=', 5);							 
								 $this->db->where('a.is_show_on_strip', 1); 				 
								 $this->db->order_by('a.priority'); 
								 $this->db->limit(3); 
								 $this->db->join("tbl_attribute as a","a.id=atv.attribute_id"); 								 
								 $subquery = $this->db->get();	
                                                                 //echo $this->db->last_query();die;
								 foreach ($subquery->result() as $avrow){
									$row->attribute[]=$avrow;
								 }
                                                                 
								 
								 
							}
				$row->total_records = $total_records;							
                $data[] = $row;
                
            }
            return $data;
        }
            $data=0; 
            return $data;
    }

	function TotalAuctionRecordsList()
    {
		
		$limit_perpage=$_GET['limit_perpage'];
		$sort_by=$_GET['sort_by'];
		$location=$_GET['location'];
		$category=$_GET['category'];
		$subcategory=$_GET['subcategory'];
		$bank_name=$_GET['bank_name'];
		$bankname=$_GET['bankname'];
		$start_date=$_GET['start_date'];
		$end_date=$_GET['end_date'];
		$postedby = $_GET['postedby'];
		$propertype = $_GET['propertype'];
		$categorySearch = $_GET['categorySearch'];
		$key = $_GET['key'];
		$action=$_GET['action'];
		$actiontype=$_GET['actiontype'];
		//print_r($propertype);
		
                if(empty($budget_Arr)){
                    $budgetArr=$_GET['budget'];
                }else{
                    $budgetArr = $math_type_budget_Arr;
                }
		$owner=$_GET['owner'];
	    if(count($budgetArr)>0)
		{
			$budgetRange=array();
			foreach($budgetArr as $b_range)
			{
				$budgetr=explode('-',$b_range);
			
				$budgetRange[]=$budgetr[0];
				$budgetRange[]=$budgetr[1];
			}
		$minBudget=min($budgetRange);	
		$maxBudget=max($budgetRange);		
		}
		
                // posted by end//
	$this->db->select('a.id,a.productID,a.reserve_price,a.bid_last_date,a.bid_opening_date,a.bank_id');
	
	if($actiontype=='pastauction')
	{
		$this->db->where('a.status !=',5);	
	}else{
		$this->db->where('a.status', 1);
	}
	
	$this->db->where('p.status', 1);
	
	if(count($categorySearch)>0){
		$this->db->where("(p.product_type_val IN('$categorySearch') OR p.product_subtype_val IN('$categorySearch'))");			
	}
	if(count($category)>0){
		$category=$this->findStringFromArray($category);
		if(count($subcategory)>0){
			$subcategory=$this->findStringFromArray($subcategory);
			$this->db->where("(p.product_type_val IN($category) AND p.product_subtype_val IN($subcategory))");		
		}else{
			$this->db->where("(p.product_type_val IN($category))");		
		}			
	}
		      
		if($bank_name!=''){
		$this->db->where('a.bank_id', $bank_name);	
		}
		if(count($bankname)>0){
			$this->db->where_in('a.bank_id', $bankname);
		}
		if(count($budgetArr)>0){
			if($minBudget>0 && $maxBudget>0){
			$this->db->where("a.reserve_price BETWEEN '$minBudget' AND '$maxBudget'");
			}
		}
		/*
		if(($start_date!='') && ($end_date!='')){
			$start_date	=date('Y-m-d',strtotime($start_date));
			$end_date	=date('Y-m-d',strtotime($end_date));
			$this->db->where("(DATE (a.auction_end_date) BETWEEN '$start_date' AND '$end_date')");	
		}*/
		//$currentData=date("")
		
		if(($start_date!='') && ($end_date!='')){
			$start_date	=	date('Y-m-d',strtotime($start_date));
			$end_date	=	date('Y-m-d',strtotime($end_date));
			$this->db->where("(DATE (a.auction_end_date) BETWEEN '$start_date' AND '$end_date')");	
			}
		
		$this->db->where('a.is_closed', 0);
		$this->db->where('a.productID != 0');
		$this->db->where('a.productID is not null');
		
		if($action=='past' || $actiontype=='pastauction'){
			$this->db->where('NOW() > a.auction_end_date');
		}else{
			$this->db->where('NOW() <= a.auction_end_date');	
		}
		
		if(($sort_by!='Sort') || ($sort_by!=''))
		{
			if($sort_by=='name')
			{
				$this->db->order_by('event_title');	
			}else if($sort_by=='price'){
				$this->db->order_by('reserve_price');
			}else{
				$this->db->order_by('a.id','DESC');	
			}
		}else{
			$this->db->order_by('a.id','DESC');	
		}
		
		if($limit_perpage){
			//$this->db->limit($limit_perpage,$startlimit);	
		}else{
			//$this->db->limit($per_page,$startlimit);
			
		}
		if($location) {
			$cityid=GetTitleByField('tbl_city', "city_name='$location'", 'id');
			$this->db->where("p.city", $cityid);	
		}
		if(isset($_GET['match_city'])) {
			$cities = explode(',', $_GET['match_city']);
			foreach($cities as $city) {
				$cityid[] = GetTitleByField('tbl_city', "city_name='$city'", 'id');
			}
			$this->db->where_in("p.city", $cityid);
		}
         
        $this->db->from("tbl_auction as a");
        $this->db->where_in('p.user_id', $response_data);
		$this->db->join('tbl_product as p','p.id=a.productID');
		if(count($postedby)>0){
		$this->db->join("tbl_user_registration as u",'u.id=p.user_id');	
		$this->db->where_in("u.user_type", $postedby);
		}
		if($propertype!='sell'){
			if($propertype[0]!='sell'){
				if(count($propertype) > 0){
					 $this->db->where_in("p.sell_rent",$propertype);
				}
			}
			
		}
		if($key!=''){
			$this->db->join('tbl_city as c','c.id=p.city');
			$this->db->join('tbl_state as s','s.id=p.state');
			$this->db->join('tbl_product_attribute_value as at','at.product_id=p.id');
			$this->db->join('tbl_bank as b','b.id=a.bank_id');
			$this->db->join('tbl_branch as br','br.id=a.branch_id');
			$this->db->where("(a.reference_no='$key' OR a.tender_no='$key' 
									 OR a.event_type ='$key'
									 OR a.event_title LIKE '%$key%' 
									 OR p.name LIKE '%$key%'
									 OR p.product_description LIKE '%$key%'
									 OR p.product_type_val = '$key'
									 OR p.product_subtype_val = '$key'
									 OR c.city_name = '$key'
									 OR s.state_name = '$key'
									 OR b.name  LIKE '%$key%'
									 OR b.shortName = '$key'
									 OR at.attr_name LIKE '%$key%'
									 OR at.values LIKE '%$key%'
								)");
		$this->db->group_by('at.product_id');						
		}
		
        $query = $this->db->get();
		//echo $this->db->last_query();
		//die;
		$total_records=$query->num_rows();
		return $total_records;
    }
	
	
	
	
	
	
function getTotalAuctionRecordsOfList(){
	
	$query=$this->db->query("SELECT `a`.`id`, `a`.`productID` FROM (`tbl_auction` as a) JOIN `tbl_product` as p ON `p`.`id`=`a`.`productID` WHERE `a`.`status` = 1 AND `p`.`status` = 1 AND `a`.`is_closed` = 0 AND `a`.`productID` != 0 AND `a`.`productID` is not null ORDER BY `a`.`id` DESC ");
	$totalRow=$query->num_rows();
	return $totalRow;
}	
function getTotalNonAuctionRecordsOfList(){
	
	$query=$this->db->query("SELECT `p`.* FROM (`tbl_product` as p) JOIN `tbl_user_registration` as u ON `u`.`id`=`p`.`user_id` WHERE `p`.`status` = 1 AND `p`.`is_auction` = 0");
	$totalRow=$query->num_rows();
	return $totalRow;
}	
	
function getattributeValuedata($condition){
	$query=$this->db->query("SELECT a.values as retunrdata FROM tbl_product_attribute_value as a WHERE $condition");
	$totalRow=$query->num_rows();
	if($totalRow>0){
		 foreach ($query->result() as $row){
			  $rowValue=$row->retunrdata;
			}
	}
	  return $rowValue;
	}
	

function getPropertyBudget(){
	$data=array();
	$data['less then 5']='0-500000';
	$data['5-10']='500000-1000000';
	$data['10-20']='1000000-2000000';
	$data['20-30']='2000000-3000000';
	$data['30-40']='3000000-4000000';
	$data['40-50']='4000000-5000000';
	$data['more then 50']='500000-10000000000';
	return $data;
	
}
function showcity($key){
	$query=$this->db->query("SELECT city_name  FROM tbl_city WHERE city_name like '$key%' limit 10");
	$totalRow=$query->num_rows();
	if($totalRow>0){
		$data=array();
		 foreach ($query->result() as $row){
			  $city_name=$row->city_name;
			  //$data.='<a class="link" onclick="fillme(\''.$city_name.'\');"><div id="fbresult"><span class="name">'.$city_name.'</span></div></a>';
                          $data[] = $city_name;
			}
	}
	  return $data;
	}
	
function showAuctionCalenderData($keyData=null){
	$start_date=$_GET['start_date'];
	$end_date=$_GET['end_date'];
	$this->db->select('a.id, a.productID,a.reference_no, a.event_title, a.reserve_price,emd_amt, a.bid_last_date, a.bid_opening_date, a.auction_end_date, a.auction_start_date,b.name as bank_name,b.thumb_logopath,c.city_name,p.product_description,p.product_type_val');
	if(($start_date!='') && ($end_date!='')){
			$start_date	=date('Y-m-d',strtotime($start_date));
			$end_date	=date('Y-m-d',strtotime($end_date));
			$this->db->where("(DATE (a.auction_end_date) BETWEEN '$start_date' AND '$end_date')");	
		}
	if($keyData!='')
	{
		$this->db->where("(c.city_name LIKE '%$keyData%'  
							OR b.name LIKE '%$keyData%' 
							OR a.id LIKE '%$keyData%' 
							OR a.reserve_price LIKE '%$keyData%' 
							OR p.product_type_val LIKE '%$keyData%' 
							) ");
								
	}		
	$this->db->where('a.status', 1);	
	$this->db->where('NOW() <= a.auction_end_date');;
	$this->db->from("tbl_auction as a");
	$this->db->join("tbl_bank as b",'b.id=a.bank_id','left');
	$this->db->join("tbl_product as p",'p.id=a.productID');
	$this->db->join("tbl_city as c",'c.id=p.city');
	$query = $this->db->get();
	//echo $this->db->last_query();
	//die;
		if($query->num_rows() > 0){
			
            foreach ($query->result() as $row){	
			$rowValue[]=$row;
			}
		}else{
			$rowValue=0;
		}	
	return $rowValue;
}

    function matchType($math_type_id) {
		$this->db->where_in('id', $math_type_id);
		$this->db->where_in('status', 1);
		$query = $this->db->get("tbl_post_requirement")->row_array();
		return $query;
    }
	
	
	function saveserchData($pageurl, $search_content) {
		if($pageurl)
		{
			$user_id=$this->session->userdata('id');
			$date=date('Y-m-d H:i:s');
			$serach_url=$pageurl;
			$data=array(
			'user_id'=>$user_id,
			'serach_url'=>$serach_url,
			'search_content'=>$search_content,
			'indate'=>$date
			);
			
			$this->db->insert('tbl_user_search_detail',$data);
			
		}
	}

	
	function totalRatedUsers($pid){
		 $query=$this->db->query("SELECT COUNT('user_id') as total_user FROM tbl_rating_review where product_id='$pid' group by product_id");
		  //$this->db->last_query();
		   if ($query->num_rows() > 0) {
			    $row = $query->row(); 
			    $total=$row->total_user;
				return $total;
		   }else{
			   $total=0;
			   return $total;
		   } 
	}
	
	
	function getStartRatingAverage($field,$pid){
		$query=$this->db->query("SELECT SUM($field) as total_sum, count(id) as total_entry , AVG($field) as totalAverage FROM tbl_rating_review where product_id='$pid' group by product_id");
		//echo $this->db->last_query();
		  if ($query->num_rows() > 0) {
			    $row = $query->row(); 
			    $total_sum=$row->total_sum;
			    $total_entry=$row->total_entry;
			    $totalAverage=$row->totalAverage;
				$data['total_sum']=$total_sum;
				$data['total_entry']=$total_entry;
				$data['totalAverage']=$totalAverage;
				
		   }else{
			    $data['total_sum']=0;
				$data['total_entry']=0;
				$data['totalAverage']=0;
			   
		   }
		return $data;
	}
	
function findStringFromArray($array){
	if(count($array)>0){
				$cateString='';
					foreach ($array as $cname)
					{
						$cateString.="'$cname'".',';
					}
					$string=substr($cateString, 0, -1);
			return $string;
	}	
}

function checkAuctionCirrigendum($aid){
		 $query=$this->db->query("SELECT COUNT('id') as total_user FROM tbl_auction_corrigendum where auctionID='$aid' group by auctionID");
		// echo $this->db->last_query();
		   if ($query->num_rows() > 0) {
			    $row = $query->row(); 
			    $total=$row->total_user;
				return $total;
		   }else{
			   $total=0;
			   return $total;
		   } 
	}
	
function socialmediaIcon($pid){
		$user_id=$this->session->userdata('id');
		$data='';
		if($user_id>0){
			$cls=checkfavoriteAuctionExist($user_id,$pid);
			 $data.='<a class=" fevoriteLogo_'.$pid.' '.$cls.'" href="javascript:" onclick="favFunction('.$pid.');"><img src="/images/icon-like.png"></a>'; 
		}else{
			$data.='<a href="/registration/login?fav=1">
			<img src="/images/icon-like.png"></a>'; 	
		}
		$socialIcon=showsocialSharingIcon($pid);
		$data.='<div class="a2a_kit">'.$socialIcon.'</div>';
		return $data;
	}
}
?>
