<?php
class Non_banker_model extends CI_Model {
    
	private $path = 'public/uploads/category/';
 
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	

	
	public function GetTotalNonAuctionPropertyRecord() {	
		$this->db->select('id');	
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != ''){
			$this->db->where('status', $status);	
		}else{
			$this->db->where('status !=', 5);
		}
		if($title != '')
			$this->db->like('name', "$title", 'both'); 
		//serach query ends//
		
		//$this->db->where('status', 4);
		$this->db->where('is_auction', 0);
		$query = $this->db->get("tbl_product");		
        if ($query->num_rows() > 0) {
           // $data = $query->result();
			return $query->num_rows();
        }        
		return 0;
    }
	public function GetnonAuctionProperty($start=0, $limit=10,$search) {
		
		//$this->db->where('status', 4);
		
		//print_r()
		
		if($search['title']!='')
		{
			$title=$search['title'];
			$this->db->like('name', "$title", 'both'); 
		}
		if($search['status']!='')
		{
			$this->db->where('status', $search['status']); 
		}else{
			$this->db->where('status !=', 5);
		}
		
		$this->db->where('is_auction', 0);
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);		
		$query = $this->db->get("tbl_product");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	
		public function GetTotalNonBankerAuctionPropertyRecord() {	
		$this->db->select('p.id');
		//$this->db->select('count(p.*) as total');	
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		$this->db->from('tbl_product as p');
		$this->db->join('tbl_auction as a','a.productID=p.id');
		if($status != '')
		{
			$this->db->where('a.status', $status);
		}else{
			
			$this->db->where('a.status !=', '5');
		}
		
		if($title != ''){
			$this->db->like('p.name', $title);
			//$this->db->or_like('a.reference_no', $title); 
		}
		//serach query ends//
		
		//$this->db->where('p.status', 4);
		$this->db->where('a.auction_type', '1');
		$this->db->where('p.is_auction', '1');
		
		$query = $this->db->get();	
		//echo $this->db->last_query();
		
        if ($query->num_rows() > 0) {
			return $query->num_rows();
        }        
		return 0;
    }
	public function GetnonNonBankerAuctionProperty($start=0, $limit=10) {
		$this->db->select('p.id, p.auctionID, p.name, p.status, p.indate, p.updated_date, a.reference_no');	
		//$this->db->where('status', 4);
		$this->db->from('tbl_product as p');
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		{
			$this->db->where('a.status', $status);
		}else{
			
			$this->db->where('a.status !=', '5');
		}
		
		if($title != ''){
			$this->db->like('p.name', $title);
			$this->db->or_like('a.reference_no', $title); 
		}
				
		$this->db->join('tbl_auction as a','a.productID=p.id');
		$this->db->where('p.status !=', '5');
		$this->db->where('p.is_auction', '1');
		$this->db->where('a.auction_type', '1');
		$this->db->order_by('p.id DESC');
		$this->db->limit($limit,$start);		
		$query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


	public function uniqueSlug($slug, $id) {
		$this->db->where('id !=', $id);
		$this->db->where('slug', $slug);
		$query = $this->db->get("tbl_category");
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
	
	function updateStatus($status,$idArr){
		if(count($idArr)>0)
		{
			foreach ($idArr as $id)
			{
				$auctionid=GetTitleByField('tbl_auction',"productID='".$id."'",'id');
				$this->db->where('id',$auctionid);
				$data=array('status'=>$status);
				$this->db->update('tbl_auction',$data);
				
				$this->db->where('id',$id);
				$this->db->update('tbl_product',$data);
			}
		}	
	}
	
function productaction(){
		$status=$this->input->post('status');
		$pid=$this->input->post('pid');	
		if($pid>0){
			$date=date('Y-m-d H:i:s');
			$data=array('status'=>$status,'updated_date'=>$date);
			$this->db->where('id',$pid);
			$this->db->update('tbl_product',$data);
			return true;
		}else{
			return false;
		}
}	
	
	
}
