<?php
class Superadmin_model extends CI_Model {
	
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
		$this->db->like('name', $title);
		//serach query ends//
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_admin");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
    }
	
	public function GetRecords($start=0, $limit=10) {
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
		$query = $this->db->get("tbl_admin");
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
				$query = $this->db->get("tbl_admin");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_admin_data($image=null) {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$indate = $this->input->post('indate');
		$status = $this->input->post('status');
		$data = array(
					'name'=>$name ,
					'email'=>$email,	
					'role'=>$role,
					'indate'=>$indate,
					'status'=>$status
					);
		if($id)			
		{
			$data['password'] = $this->input->post('password');
			$this->db->where('id', $id);
			$this->db->update('tbl_admin', $data); 
		}
		else
		{
			if($this->input->post('password') != ''){
				$data['password'] = $this->input->post('password');
			}
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_admin',$data); 
		}
		return true;
	}
	
 public function validate(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean');
	$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean|callback_check_database');
	//$this->security->xss_clean();
	$username = $this->input->post('user_email');
	$password = $this->input->post('user_pass');
	//$username=$this->db->escape($username);
	//$password=$this->db->escape($password);
	$username=$this->db->escape_str($username);
	$password=$this->db->escape_str($password);
	$username=$this->security->xss_clean($username);
	$password=$this->security->xss_clean($password);
	
	if($this->form_validation->run() == FALSE)
	{
		return false;
	}
	else
	{
			$remember_password = $this->input->post('remember_password');
			if($remember_password)
			{
			$_COOKIE['user_email']=$username;
			$_COOKIE['user_pass']=$password;
			}
			$this->db->where('email', $username);
			$this->db->where('admin_type', 1); //1-Superadmin
			//$this->db->where('password',$password);
			$this->db->where('status', 1);
			$query = $this->db->get('tbl_admin'); 
                        $row=$query->result();
			if($query->num_rows == 1)
			{
                       $generatedPass=hash("sha256", $password);   
                     if($this->is_valid_password($generatedPass, $row[0]->password)==0){
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
                      }else{
                      return false;    
                      }
                      return false;   
                     }
		   
                     
	     }
}

        public function is_valid_password($generatedPass,$Password){
                    return strcmp($generatedPass,$Password);
               }
	public function GettotalSavedAuctionRecord() {
		$this->db->select(" COUNT(id) as totalsavedrecods");
		$this->db->where('status',0);
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->totalsavedrecods;
            }
            return $data;
        }else{
			return $data=0;
		}
    }
	public function GettotalUpcomingAuctionRecord() {
		$this->db->select("COUNT(id) as totalsavedrecods");
		$this->db->where('status !=',0);
		$this->db->where('bid_last_date >= NOW()');
		$query = $this->db->get("tbl_auction");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = $row->totalsavedrecods;
            }
            return $data;
        }else{
			return $data=0;
		}
    }
    
    public function setRole()
	{
		
		$user_dept_id = $this->input->post('user_dept_id');
		$userid= $this->session->userdata('id');
		
		$this->db->select('ud.*, tu.first_name, tu.last_name,tu.email_id');
		$this->db->from('tbl_user_department as ud');
		$this->db->join('tbl_user as tu','tu.id=ud.user_id','left');
		$this->db->where('ud.user_deprt_id',$user_dept_id);
		$this->db->where('ud.user_id',$userid);
		$this->db->where('ud.status',1);
		$qry = $this->db->get();		
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
				
				$rows = $qry->result_array();
				$this->session->set_userdata('role_id',$rows[0]['role_id']);
				$this->session->set_userdata('depart_id',$rows[0]['department_id']);
				
				if ($rows[0]['role_id'] ==6) {
					
					$data = array(
                                'adminid' => $rows[0]['user_id'],
                                'id' => $rows[0]['user_id'],
                                'aname' => $rows[0]['first_name'].' '.$rows[0]['last_name'],
                                'aemail' => $row[0]['email_id'],
                                'validated' => true,
                                'arole' => 1
                                 );
                    $this->session->set_userdata($data);
                    redirect(base_url().'superadmin/home');
                }
                else{ 
					
				$this->session->unset_userdata('adminid'); 
				$this->session->unset_userdata('id'); 
				$this->session->unset_userdata('aname'); 
				$this->session->unset_userdata('aemail'); 
				$this->session->unset_userdata('validated');
				$this->session->unset_userdata('arole'); 
				
				$user_type = 'buyer';	
                $rand = rand(1000000000, 9999999999);
                $res = $this->bankuserupdate_login($rows[0]['user_id']);
                $this->session->set_userdata('id', $rows[0]['user_id']);
                $this->session->set_userdata('full_name', $rows[0]['first_name'].' '.$rows[0]['last_name']);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('bank_id', 41);
                $this->session->set_userdata('branch_id', 0);
                
                $this->session->set_userdata('session_id_user', $rand);
                $this->session->set_userdata('table_session', 'banker_tb'); 
                                
                 if($this->session->userdata('role_id')==3)
                {
					
					redirect(base_url()."buyer/emd_payment_verification");
					exit;
				}
				else
				{                
					redirect(base_url()."registration/redirectDashboard");
					exit;
				}
					 
			}
		}
		
	}
	
	public function bankuserupdate_login($id) {
        $setarray = array('user_sess_val' => $this->session->userdata('session_id_user'));
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $setarray);
        return true;
    }
    
}

?>
