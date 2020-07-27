<?php
class Event_log_model extends CI_Model {
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(*) as total');	
		
		//search query start//
		$title 	= $this->input->post('title'); 
		$status	= $this->input->post('status1');
		$type	= $this->input->post('type');
		if($status != '')
		$this->db->where('status ', $status);
		if($title != '')
		$this->db->like('email_id', $title);
		if($type != '')
		$this->db->like('user_type', $type);
		//serach query ends//
		
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_event_log_sales");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
	
		//search query start//
		$title 	= $this->input->post('title'); 
		$status	= $this->input->post('status1');
		$type	= $this->input->post('type');
		if($status != '')
		$this->db->where('status ', $status);
		if($title != '')
		$this->db->like('email_id', $title);
		if($type != '')
		$this->db->like('user_type', $type);
		//serach query ends//
		$this->db->where('status !=', 5);
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_event_log_sales");
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
				$query = $this->db->get("tbl_event_log_sales");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_data($upload_img=null,$uploaded_doc=null) {
		$id = $this->input->post('id');
		$sales_executive_id = $this->input->post('sales_executive_id');
		$event_type = $this->input->post('event_type');
		$drt_id = $this->input->post('drt_id');
		$drt_user_id = $this->input->post('drt_user_id');
		$bank_id = $this->input->post('bank_id');
		$branch_id = $this->input->post('branch_id');
		$branch_user_id = $this->input->post('branch_user_id');		
		$publish_date = $this->input->post('publish_date');			
		$indate = $this->input->post('indate');
		$status = $this->input->post('status');
		$data = array(
					'sales_executive_id'=>$sales_executive_id ,
					'event_type'=>$event_type ,
					'drt_id'=>$drt_id ,
					'drt_user_id'=>$drt_user_id ,
					'bank_id'=>$bank_id ,
					'branch_id'=>$branch_id ,
					'branch_user_id'=>$branch_user_id ,
					'publish_date'=>$publish_date ,
					'uploaded_doc'=>$uploaded_doc,		
					'upload_img'=>$upload_img,	
					'indate'=>$indate,
					'status'=>$status
					);
		if($id)			
		{
			
			$this->db->where('id', $id);
			$this->db->update('tbl_event_log_sales', $data); 
		}
		else
		{
			
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_event_log_sales',$data); 
		}
		return true;
	}
	public function GetSalesUser()
	{
		$this->db->where('status !=', 5);
		$this->db->where('user_type', 'sales');
		$this->db->order_by('id DESC');
		$query = $this->db->get("tbl_user");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	function checkDuplicateEmail($email)
	{		
		$this->db->from('tbl_event_log_sales');
		$this->db->where('email_id', $email);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if($rowcount)
		return true;
		else
		return false;
		 
	}
	public function FilterBranchUserRecords($branch_id) {
		if($branch_id)
		{
		$this->db->where('user_type', 'branch');
		$this->db->where('user_type_id', $branch_id);
		}
		$this->db->where('status != ', 5);
		$this->db->order_by("id", "desc");		
        $query = $this->db->get("tbl_user");	
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
	public function FilterDrtUserRecords($drt_id) {
		if($drt_id)
		{
		$this->db->where('user_type', 'drt');
		$this->db->where('user_type_id', $drt_id);
		}
		$this->db->where('status != ', 5);
		$this->db->order_by("id", "desc");		
        $query = $this->db->get("tbl_user");	
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
	function upload1($fieldname)
	{
		$config['upload_path'] = $this->path;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
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

?>
