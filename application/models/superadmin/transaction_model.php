<?php
class Transaction_model extends CI_Model {
    private $path = 'public/uploads/bank/';
    function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(id) as total');	
		$query = $this->db->get("tbl_transaction");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		//search query start//
		$this->db->limit($limit,$start);
		$this->db->order_by("id", "desc");
        $query = $this->db->get("tbl_transaction");	
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
	

}