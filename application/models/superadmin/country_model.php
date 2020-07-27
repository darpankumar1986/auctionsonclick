<?php
class Country_model extends CI_Model {
	
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
		$this->db->like('country_name', $title);
		//serach query ends//
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_country");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	
	public function uniqueCountry($name, $id) {
			if($id > 0){
				$this->db->where('id !=', $id);
			}
			$this->db->where('country_name', $name);
			$this->db->where('status !=', 5);
			$query = $this->db->get("tbl_country");
	
			if ($query->num_rows() > 0) {
					return "false";
			}
			return "true";
  }
    
	
	
	public function GetRecords($start=0, $limit=10) {
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('country_name', $title);
		//serach query ends//
		$this->db->where('status !=', 5);
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_country");
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
				$query = $this->db->get("tbl_country");
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
		$country_name = $this->input->post('country_name');
		$status = $this->input->post('status');
		$data = array(
					'country_name'=>$country_name ,
					'status'=>$status
					);
		if($id)			
		{			
			$this->db->where('id', $id);
			$this->db->update('tbl_country', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_country',$data); 
		}
		return true;
	}
	
 
}

?>
