<?php
class Auction_fees_model extends CI_Model {
    
	private $path = 'public/uploads/bank/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(*) as total');	

		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$this->db->where('status != ', '5');
		$query = $this->db->get("tbl_auction_fee");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		
		$this->db->where('status !=', '5');		
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_auction_fee");	
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
	
	public function GetRecordByid($id) {
	
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_auction_fee");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_data() {
		$id = $this->input->post('id');
		$property_type = $this->input->post('property_type');
		$fee_type = $this->input->post('fee_type');
		$user_type = $this->input->post('user_type');
		$range_from = $this->input->post('range_from');
		$range_to = $this->input->post('range_to');
		$fees = $this->input->post('fees');
		$data = array(
					'property_type'=>strtolower($property_type),
					'fee_type'=>strtolower($fee_type),
					'user_type'=>strtolower($user_type),
					'range_from'=>$range_from,
					'range_to'=>$range_to,
					'fees'=>$fees
				);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_auction_fee', $data); 
		}
		else
		{
			
			$data['indate']=date('Y-m-d H:i:s');			
			$data['status']=0;			
			$this->db->insert('tbl_auction_fee',$data); 
			$id = $this->db->insert_id();

		}
		return true;
	}
	

    public function checkUniqueAuctionFees() {
			$property_type=$this->input->post('property_type');
			$fee_type=$this->input->post('fee_type');
			$user_type=$this->input->post('user_type');
			$range_from=$this->input->post('range_from');
			$range_to=$this->input->post('range_to');
			$fees=$this->input->post('fees');
			$id=$this->input->post('id');
			if($id > 0){$this->db->where('id !=', $id);}
			if($property_type!=''){ $this->db->where('property_type', $property_type);}
			if($fee_type!=''){ $this->db->where('fee_type', $fee_type);}
			if($user_type!=''){	$this->db->where('user_type', $user_type);}
			if($range_from!=''){ $this->db->where('range_from', $range_from);}
			if($range_to!=''){	$this->db->where('range_to', $range_to);}
			if($fees!=''){	$this->db->where('fees', $fees);}
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_auction_fee");
			if ($query->num_rows() > 0) {
					return  'true';
			}else{
				return 'false';;	
			}
			
  }
}