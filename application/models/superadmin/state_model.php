<?php
class State_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('superadmin/role_model');
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(*) as total');
		
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('state_name', $title);
		//serach query ends//
		
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_state");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function uniqueState($name, $country_id, $id) {
			$this->db->where('id !=', $id);
			$this->db->where('state_name', $name);
			$this->db->where('countryID', $country_id);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_state");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
	
	
	public function GetRecords($start=0, $limit=10) {
		$this->db->where('status !=', 5);
		
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('state_name', $title);
		//serach query ends//
		
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_state");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
	
	public function GetRecordById($id) {
        $this->db->where('id', $id);
		
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('state_name', $title);
		//serach query ends//
		
		$query = $this->db->get("tbl_state");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_data($image=null) {
		$id = $this->input->post('id');
		$state_name = $this->input->post('name');
		$countryID = $this->input->post('country_id');
		$status = $this->input->post('status');
		$data = array(
					'state_name'=>$state_name ,
					'countryID'=>$countryID ,
					'status'=>$status
					);
		if($id)			
		{			
			$this->db->where('id', $id);
			$this->db->update('tbl_state', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_state',$data); 
		}
		return true;
	}
 
}

?>
