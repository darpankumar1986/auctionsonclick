<?php
class Home_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}	
	
	function bankList()
    {
		$this->db->select('id,logopath,thumb_logopath,shortName,url');
		$this->db->where('status', 1);
		$this->db->order_by('priority','asc');
		$this->db->limit(70);
		$this->db->from("tbl_bank");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}
		return false;
	
    }
    
    
    function eventList()
    {
		$this->db->select('id,category,title');
		$this->db->where('status', 1);
		$this->db->where('category', 'event');
		$this->db->order_by('priority','asc');
		$this->db->limit(29);
		$this->db->from("tbl_news_blog");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
			return $data;
		}
		return false;
	
    }
    
    function getProductById($id='')
    {
		$this->db->where('id',$id);
		$this->db->limit(1);
		$this->db->from("tbl_product");
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {
				return $row;
			}				
		}
		return false;
	}
    
    function searchFromUrl($bankIdbyshortname)
    {
			if($bankIdbyshortname != '')
			{
				$this->db->where('shortName',$bankIdbyshortname);
				$this->db->limit(1);
				$this->db->from("tbl_bank");
				$query = $this->db->get();
				//echo $this->db->last_query();die;
				if ($query->num_rows() > 0) {				
					foreach ($query->result() as $row) {
						$searchArr['bank_id'] = $row->id;
					}				
				}
				
				$this->db->where('city_name',$bankIdbyshortname);
				$this->db->limit(1);
				$this->db->from("tbl_city");
				$query = $this->db->get();
				if ($query->num_rows() > 0) {				
					foreach ($query->result() as $row) {	
						$searchArr['city'] = $row->id;
					}				
				}
				
				$this->db->where('state_name',$bankIdbyshortname);
				$this->db->limit(1);
				$this->db->from("tbl_state");
				$query = $this->db->get();
				if ($query->num_rows() > 0) {				
					foreach ($query->result() as $row) {	
						$searchArr['state'] = $row->id;				
					}				
				}
				
				$this->db->where('name',$bankIdbyshortname);
				$this->db->where('parent_id','0');
				$this->db->limit(1);
				$this->db->from("tbl_category");
				$query = $this->db->get();
				if ($query->num_rows() > 0) {				
					foreach ($query->result() as $row) {	
						$searchArr['category_id'] = $row->id;				
					}				
				}
				
				$this->db->where('name',$bankIdbyshortname);
				$this->db->where('parent_id !=','0');
				$this->db->limit(1);
				$this->db->from("tbl_category");
				$query = $this->db->get();
				if ($query->num_rows() > 0) {				
					foreach ($query->result() as $row) {	
						$searchArr['subcategory_id'] = $row->id;				
					}				
				}
				
			}			
			return $searchArr;
	}
    
    function liveAuctionDatatable()
    {           
		$this->db->select("a.PropertyDescription, a.id, a.reference_no, z.zone_name, a.area, a.tender_fee, a.emd_amt, a.opening_price, ut.uom_name, a.registration_start_date, a.bid_last_date, a.auction_start_date, a.auction_end_date");
	   
		$this->db->from('tbl_auction as a');
		$this->db->join('tbl_zone as z','z.zone_id=a.zone_id','left');
		//$this->db->join('tbl_product as pro','pro.id=a.productID','left');
		$this->db->join('tblmst_uom_type as ut','ut.uom_id=a.area_unit_id','left');
		$this->db->where('a.status IN(1,3,4)');
		$this->db->where('a.show_home = 1');
		//$this->db->where('a.bid_last_date >= NOW()');//commented by Azizur Rahman
        $this->db->where('a.auction_end_date >= NOW()');//Added by Azizur Rahman
		$query = $this->db->get();
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
    }
    
    function liveAuctionDatatableHome($bankIdbyshortname='')
    {           //$this->datatables->select("b.logopath,a.id,b.name, a.event_title,cit.city_name,DATE_FORMAT(a.bid_last_date,'%m %b %Y'), a.reserve_price,a.emd_amt,a.productID",false)
		//$this->datatables->select("b.logopath,a.id,b.name, a.event_title,IFNULL( cit.city_name, a.other_city) AS city_name,a.bid_last_date, a.reserve_price,a.emd_amt,a.productID,a.dsc_enabled",false)
		
		/*$monthArr = array("january"=>"01","febuary"=>"02","march"=>"03","april"=>"04","may"=>"05","june"=>"06","january"=>"01","january"=>"01","january"=>"01","january"=>"01","january"=>"01","january"=>"01");
		$dateArr = explode(" ",$_POST['sSearch']);*/
		
		
				$searchArr = $this->searchFromUrl($bankIdbyshortname);
				
               $this->datatables->select("a.reference_no, a.PropertyDescription,a.emd_amt, a.registration_start_date, a.bid_last_date, a.auction_start_date, a.auction_end_date,a.id",false)
                ->from('tbl_auction as a')				
				->join('tblmst_uom_type as ut','ut.uom_id=a.area_unit_id','left')
                ->where('a.status IN(1)')
                ->where('auction_end_date >= NOW()');
                  $this->db->order_by('a.bid_last_date','ASC');
                  
                  /*if($bankIdbyshortname > 0)
                  {
					 $this->db->where('a.bank_id',$bankIdbyshortname);
				  }*/
				  
				  if(is_array($searchArr))
				  {
					  foreach($searchArr as $key => $v)
					  {
						  $this->db->where('a.'.$key,$v);
					  }
				  }
                  
      			//$result = $this->datatables->generate();				
      			
				//echo '<pre>';
				//print_r($result);die;

                 return $this->datatables->generate();
    }
    
    function getAllAssetsType()
    {
		$this->db->where('status',1);
		$query = $this->db->get('tbl_category');
		 
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
	}
    
    function getProperty()
    {           
		$this->db->select("a.PropertyDescription, a.id, a.reference_no");
	   
		$this->db->from('tbl_auction as a');
		$this->db->where('a.status IN(1,3,4)');				
        $this->db->where('a.auction_end_date >= NOW()');//Added by Azizur Rahman
        if(isset($_GET['search']) && $_GET['search']!='')
		{
			$pt = trim(str_replace("'","''",$_GET['search']));			
			$this->db->like('a.PropertyDescription', $pt);
		}
		if($_GET['assetsTypeId']>0)
		{
			
			$this->db->join('tbl_category as c','c.id=a.category_id','inner');
			$this->db->where('c.id',$_GET['assetsTypeId']);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
    }
    
    
    function aucDetailPopupData($auctionID)
    {           
		$this->db->select("a.*");               
		$this->db->from('tbl_auction as a');
		$this->db->join('tbl_zone as z','z.zone_id=a.zone_id','left');
		$this->db->join('tbl_product as pro','pro.id=a.productID','left');
		$this->db->join('tblmst_uom_type as ut','ut.uom_id=a.area_unit_id','left');
		$this->db->where('a.status IN(1,3,4)');
		$this->db->where('a.show_home = 1');
                $this->db->where('a.id = "'.$auctionID.'"');
		//$this->db->where('a.bid_last_date >= NOW()');//commented by Azizur Rahman
                $this->db->where('a.auction_end_date >= NOW()');//Added by Azizur Rahman
		$query = $this->db->get();
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
    }
    
    function archiveAuctionDatatable($bankIdbyshortname='')
    {           
		$this->datatables->select("a.reference_no, a.id, pro.product_description, z.zone_name, concat(a.area,' ',ut.uom_name) as area,concat(reg.first_name,' ',reg.last_name) as uName, ut.uom_name, tap.awardedStatus,(select MAX(b.bid_value) from tbl_live_auction_bid as b where b.auctionID=a.id) as bid_value",false)
		//->add_column('view',"<a href='".base_url()."home/viewEventDocuments/$1' target='_blank' class=''>View</a> ", 'a.id')
                ->add_column('view',"<a href='".base_url()."home/archiveAuctionDetailPopup/$1' target='_blank' class='view-details-btn grn-txt float-right b_showevent inline_auctiondetail auction_detail_iframe'>View</a>", 'a.id')
		->add_column('reach_sch',"<a href='".base_url()."home/viewGoogleMap/$1' target='_blank' class=''>On Google Map</a> ", 'a.id')
		->from('tbl_auction as a')
		->join('tbl_zone as z','z.zone_id=a.zone_id','left')
		->join('tbl_product as pro','pro.id=a.productID','left')
		->join('tblmst_uom_type as ut','ut.uom_id=a.area_unit_id','left')
                ->join('tbl_auction_participate as tap','tap.auctionID=a.id and tap.final_submit=1','left')
                ->join('tbl_user_registration as reg','reg.id=tap.bidderID','left')
		->where('a.status >= ',6)                
                ->group_by('a.id')
		->where('a.show_home = 1');
		//->where('a.bid_last_date >= NOW()');
		  
		//$result = $this->datatables->generate();				
		
		//echo '<pre>';
		//print_r($result);die;

		return $this->datatables->generate();
                //$this->db->last_query();
    }
    
    //Added by Azizur For Archive Auction Details.
    function archiveAuctionDetailPopupData($auctionID)
    {           
		$this->db->select("a.*");               
		$this->db->from('tbl_auction as a');
		$this->db->join('tbl_zone as z','z.zone_id=a.zone_id','left');
		$this->db->join('tbl_product as pro','pro.id=a.productID','left');
		$this->db->join('tblmst_uom_type as ut','ut.uom_id=a.area_unit_id','left');
		$this->db->where('a.status >=', 6);
		$this->db->where('a.show_home = 1');
                $this->db->where('a.id = "'.$auctionID.'"');
		//$this->db->where('a.bid_last_date >= NOW()');//commented by Azizur Rahman
                //$this->db->where('a.auction_end_date >= NOW()');//Added by Azizur Rahman
		$query = $this->db->get();
		if ($query->num_rows() > 0) {				
			foreach ($query->result() as $row) {	
				$aData[] = $row;				
			}				
		}
		return $aData;
    }
    
    function checkdsclogin(){
       
        $this->session->userdata['id'];
        $auctionId='5';
        $bidderId='41';
         $cert_serial_no 			        =	 $this->input->post('cert_serial_no');
         $thum_print 					=	 $this->input->post('thum_print');
         $cert_file 					=	 $this->input->post('cert_file');
         $falid_from 					=	 $this->input->post('falid_from');
         $valid_to 					=	 $this->input->post('valid_to');
         $signature 					=	 $this->input->post('signature');
     
         $data=array(
             'cert_serial_no'=>$cert_serial_no,
             'thum_print'=>$thum_print,
             'cert_file'=>$cert_file,
             'falid_from'=>  date('Y-m-d H:i:s',strtotime($falid_from)),
             'valid_to'=> date('Y-m-d H:i:s',strtotime($valid_to)),
             'signature'=>$signature,
         );
        $this->db->where('bidderID', $bidderId);
        $this->db->where('auctionID', $auctionId);
        $update=$this->db->update('tbl_auction_participate',$data);
       // print_r($this->db->last_query()); 
       return $update;
     }
    
    function homeAuctionRecords($type='upcoming')
    {
		$this->db->select('id, productID, reserve_price, auction_start_date, auction_end_date, bid_last_date, bank_id');
		
		$this->db->where('productID != 0');
		if($type=='upcoming'){
		$this->db->where('auction_end_date >= NOW()');
		$this->db->where('status', 1);
		}
		if($type=='past'){
			$this->db->where('(status=6 or status=7)');
			$this->db->where('auction_end_date < NOW()');	
		}
		$this->db->limit(5);
		$this->db->order_by('id','DESC');		
		$this->db->from("tbl_auction");
                $query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
            foreach ($query->result() as $row){	
	     if($row->id){
            $this->db->where('product_id', $row->productID);	
            $this->db->where('type','images');
            $this->db->where('status','1');
            $this->db->order_by('priority','ASC');
            $this->db->limit(1);
            $subquery = $this->db->get("tbl_product_image_video");	
            //echo $this->db->last_query();
            foreach ($subquery->result() as $irow){
                    $row->image=$irow;
            }
            $this->db->where('id ', $row->productID);
            $this->db->where('status', 1);									
            $subquery = $this->db->get("tbl_product");	
            foreach ($subquery->result() as $prow){}
             $row->product_detail=$prow;
		}
                $data[] = $row;
            }
            return $data;
        }
            
            return false;
    }
    
    
    
    
    function frontBanner() {
        $this->db->where('status !=', 0);
        
        $this->db->order_by('priority', 'DESC');
        $this->db->limit(4);
        $this->db->from("tbl_home_page_slider");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = array();
            foreach ($query->result() as $row) {
               
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function blogNewsRecords($type='news')
    {
		//$this->db->select('id,author,thumb_image,publish_date,short_desc');
		//$this->db->where('status', 1);
		
		//if($type=='news')
			//$this->db->where('category','news');
		//if($type=='blog')
			//$this->db->where('category','blog');
			
		//$this->db->order_by('priority','ASC');
		//$this->db->limit(4);
        //$this->db->from("tbl_news_blog");
		/*
		$query = $this->db->get('tbl_news_blog');
		if($query->num_rows() > 0){
			$data=array();
            foreach ($query->result() as $row){
			$data[]=$row;
			}
		}
		*/
		$this->db->where('status', 1);
		if($type=='news')
			$this->db->where('category','news');
		if($type=='blog')
			$this->db->where('category','blog');
		$this->db->order_by('publish_date', 'DESC');
		$this->db->limit(4);
        $query = $this->db->get("tbl_news_blog");
        $data = array();
		if ($query->num_rows() > 0){

            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	
    }

	function getStaticContents($id) {
		$this->db->where('webpage_id',$id);
        $this->db->from("tbl_webpage");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
               
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	function getStaticContentsBySlug($slug) {
		$this->db->where('slug',$slug);
        $this->db->from("tbl_webpage");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    function getBankIdByShortname($slug) {
		$this->db->where('shortName',$slug);
        $this->db->from("tbl_bank");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data = $row->id;
            }
            return $data;
        }
        return false;
    }
    
    function getCityIdByCityName($slug) {
		$this->db->where('city_name',$slug);
		$this->db->limit(1);
        $this->db->from("tbl_city");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data = $row->id;
            }
            return $data;
        }
        return false;
    }
    
    function getBankDetailsByID($id) {
		$this->db->where('id',$id);
        $this->db->from("tbl_bank");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function getHomeBreakingNewsDetails() {
		$this->db->where('category','home');
		$this->db->where('status','1');
		$this->db->where('bank_id','0');
        $this->db->from("tbl_news_blog");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data = $row->title;
            }
            return $data;
        }
        return false;
    }
    
    function getHomeHeaderBanner($bankId = '') {
		
		if($bankId > '0')
		{
			$category = 'bank_header';
		}else{
			$category = 'home_header';
		}
		
		
		$this->db->where('category',$category);
		$this->db->where('status','1');
		$this->db->where('bank_id',$bankId);
        $this->db->from("tbl_news_blog");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    function getHomeSlider($bankId = '') {
		
		if($bankId > '0')
		{
			$category = 'bank_slider';
		}else{
			$category = 'home_slider';
		}
		
		
		$this->db->where('category',$category);
		$this->db->where('status','1');
		$this->db->where('bank_id',$bankId);
		$this->db->order_by('priority','asc');
        $this->db->from("tbl_news_blog");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //$data = array();
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetUploadedDocsByAuctionId($aId)
	{
		$this->db->where('status', 1);
		$this->db->where('auction_id',$aId);
		$this->db->order_by("upload_document_field_id", "ASC");
        $query = $this->db->get("tbl_auction_document");	
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
    
    public function GetAuctionDocuments($auctionId)
    {
		$this->db->select('*');
		$this->db->from('tbl_auction_document as ad');
		$this->db->join('tblmst_upload_document_field as ud','ud.upload_document_field_id=ad.upload_document_field_id and ud.status=1','left');
		$this->db->where('ad.auction_id',$auctionId);
		$qry = $this->db->get();
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		else
		{
			return array();
		}
	}
	
	public function GetRecordByAuctionId($eid){
        $this->db->where('id', $eid);		      
        $query = $this->db->get("tbl_auction");
		//echo $this->db->last_query();		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function query_search()
	{
		$q = strtolower(urldecode($_GET['q']));
		$assetsTypeId = $_GET['assetsTypeId'];
		$parr = array();
		
		//$productNames = GetAllData('a.PropertyDescription', 'tbl_auction a', 'a.status = 1 limit 10');
		$this->db->select('a.PropertyDescription');
		$this->db->from('tbl_auction a');		
		$this->db->like('a.PropertyDescription',$q);
		if($assetsTypeId>0)
		{
			$this->db->join('tbl_category as c','c.id=a.category_id','inner');
			$this->db->where('c.id',$assetsTypeId);
		}
		$this->db->where('a.status',1);
		$this->db->where('a.auction_end_date >= NOW()');
		$sQry = $this->db->get();
		if($sQry->num_rows()>0)
		{
			$productNames = $sQry->result_array();
			foreach($productNames as $productName)
			{
				array_push($parr,$productName['PropertyDescription']);
			}
			$productsArr = json_encode($parr);	
			echo $productsArr;die;
		}
		else
		{
			echo null;die;
		}
	}
}

?>
