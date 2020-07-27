<?php
class Role_model extends CI_Model {
    
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
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_role");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	public function GetRecord($start=0, $limit=10) {
		$this->db->where('status !=', 5);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_role");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
	public function GetRecords() {
		$this->db->where('status !=', 5);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$query = $this->db->get("tbl_role");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$row->parent_name = '';
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
  
		public function GetallRollsRecords() {
		$this->db->where('status',1);
		//search query start//
		$title 	= trim($this->input->post('title')); 
		$status	= trim($this->input->post('status1'));
		if($status != '')
		$this->db->where('status', $status);
		if($title != '')
		$this->db->like('name', $title);
		//serach query ends//
		$query = $this->db->get("tbl_role");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$row->parent_name = '';
				$data[] = $row;
			}
			return $data;
		}
		return false;
  }
	public function GetRecordById($id) {
        $this->db->where('id', $id);
				$query = $this->db->get("tbl_role");
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
		$name = $this->input->post('name');
		$section = $this->input->post('section');
		$section_value = $this->input->post('section_value');
		$status = $this->input->post('status');	
		
		$data = array(
					'name'=>$name ,
					'section'=>$section ,
					'section_value'=>$section_value ,
					'status'=>$status
					);
		if($id)			
		{
			$this->db->where('id', $id);
			$this->db->update('tbl_role', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_role',$data); 
		}
		return true;
	}

	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		if (!is_dir($this->path))
		{
			mkdir($this->path, 0777);
		}
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = '2000';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);            
		
		if (!$this->upload->do_upload($fieldname)){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];		
		}							
	}
	
	
}
