<?php
class Taxmaster_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('superadmin/role_model');
	}
	
	public function GetTotalRecord() {	
		$this->db->select('count(*) as total');		
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_taxmaster");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
		$this->db->where('status !=', 5);
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_taxmaster");
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
				$query = $this->db->get("tbl_taxmaster");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetAllRecord() {
			$this->db->order_by('indate DESC');
			$query = $this->db->get("tbl_taxmaster");
			if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_taxmaster_data() {
		$id = $this->input->post('id');
		$stax = $this->input->post('stax');
		$educess = $this->input->post('educess');
		$secondaryhighertax = $this->input->post('secondaryhighertax');
        $swacchbharat_tax = $this->input->post('swacchbharat_tax');
		$krishi_kalyan = $this->input->post('krishi_kalyan');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
		$data = array(
					'stax'=>$stax ,
					'educess'=>$educess,	
					'secondaryhighertax'=>$secondaryhighertax,
                    'swacchbharat_tax'=>$swacchbharat_tax,
                    'krishi_kalyan'=>$krishi_kalyan,
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
					'status'=>1
					);
		if(isset($id) && $id>0)			
		{
			//$data['indate']=date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			$this->db->update('tbl_taxmaster', $data); 
		}
		else
		{
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_taxmaster',$data); 
		}
		return true;
	}
	
 public function validate(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean|callback_check_database');
	
	$username = $this->security->xss_clean($this->input->post('user_email'));
	$password = $this->security->xss_clean($this->input->post('user_pass'));
	
	if($this->form_validation->run() == FALSE)
	{
		return false;
	}
	else
	{		 
			$this->db->where('email', $username);
			$this->db->where('password',$password);
			$this->db->where('status', 1);
			$query = $this->db->get('tbl_taxmaster');
			if($query->num_rows == 1)
			{
					$row = $query->row();
					$data = array(
									'adminid' => $row->id,
									'aname' => $row->name,
									'aemail' => $row->email,
									'validated' => true,
									'arole' => $row->role
									);
					$this->session->set_userdata($data);
					return true;
			}
			return false;
	}
}
}

?>
