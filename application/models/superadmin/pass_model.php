<?php
class Pass_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function getBidderPasswordList() 
	{
		     $this->datatables->select(" ta.id, ta.first_name,ta.organisation_name,ta.email_id, ta.user_id,
				DATE_FORMAT(ta.indate,'%d/%b/%Y %h:%i %p'),  CASE ta.status
				WHEN 1 THEN 'Active'
				WHEN 0 THEN 'Inactive'
				WHEN 9 THEN 'Blocked'
				ELSE 'Blank'
				END AS status,ta.register_as",false)
				->add_column('Actions', "<a href='/superadmin/pass/editBidderPass/$1'>Edit</a>", 'ta.id')
				->from('tbl_user_registration as ta');
				//$this->datatables->generate();
				//echo $this->db->last_query();die;
				return $this->datatables->generate();
    }
    
    function getBankerPasswordList() 
	{
		     $this->datatables->select(" ta.id, ta.first_name,ta.email_id, ta.user_id,
				DATE_FORMAT(ta.indate,'%d/%b/%Y %h:%i %p'),  CASE ta.status
				WHEN 1 THEN 'Active'
				WHEN 0 THEN 'Inactive'
				WHEN 9 THEN 'Blocked'
				ELSE 'Blank'
				END AS status,ta.user_type",false)
				->add_column('Actions', "<a href='/superadmin/pass/editBankerPass/$1'>Edit</a>", 'ta.id')
				->from('tbl_user as ta')
				->where("ta.id !=","36");
				//$this->datatables->generate();
				//echo $this->db->last_query();die;
				return $this->datatables->generate();
    }
    
    function getPasswordLogList() 
	{
		     $this->datatables->select(" ta.id, ta.email_id,ta.user_id,ta.createTime, ta.ip,
				ta.type,CASE ta.table
				WHEN 'tbl_user' THEN 'tu'
				ELSE 'tur'
				END AS table1,ta.candid_id",false)
				//->add_column('Actions', "<a href='/superadmin/pass/editBidderPass/$1'>Edit</a>", 'ta.id')
				->from('tbl_log_password as ta');
				return $this->datatables->generate();
    }
    
	public function GetBidderRecordById($id) 
	{
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_user_registration");
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function GetBankerRecordById($id) 
	{
        $this->db->where('id', $id);
		$query = $this->db->get("tbl_user");
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function save_bidder_data($id1) 
	{
		
		$id = $this->input->post('id');
		if($id1 == $id)
		{
				$email = $this->input->post('email');
				$type = $this->input->post('type');
				$old_password = $this->getBidderPassword($id,$email);
				$set_new_pass = hash("sha256", $this->input->post('password'));
				$new_password = $set_new_pass;
				$createTime = date('Y-m-d H:i:s');
				$userid = $this->input->post('userid');	
				$status = $this->input->post('status');
				$ip = $_SERVER["REMOTE_ADDR"];				
				$table = 'tbl_user_registration';
				$candid_id = $id;		
				
				$data = array('email_id'=>$email ,
							'user_id'=>$userid,
							'old_password'=>$old_password,	
							'new_password'=>$new_password,	
							'createTime'=>$createTime,
							'ip'=>$ip,
							'type'=>$type,
							'table'=>$table,
							'candid_id'=>$candid_id,
							);

				if($id)			
				{
					$this->db->insert('tbl_log_password',$data); 
					
					$data1['date_modified']=date('Y-m-d H:i:s');
					$data1['password']=$new_password;
					$data1['status']=$status;
					$this->db->where('id', $id);
					$this->db->where('email_id', $email);
					$this->db->where('register_as', $type);
					$this->db->update('tbl_user_registration', $data1); 
					return true;
				}
				return false;
				
		}else{
				return false;
		}
	}
	
	public function save_banker_data($id1) 
	{
		$id = $this->input->post('id');
		if($id1 == $id)
		{
				$email = $this->input->post('email');
				$type = $this->input->post('type');
				$old_password = $this->getBankerPassword($id,$email);
				$set_new_pass = hash("sha256", $this->input->post('password'));
				$new_password = $set_new_pass;
				$createTime = date('Y-m-d H:i:s');
				$userid = $this->input->post('userid');	
				$status = $this->input->post('status');
				$ip = $_SERVER["REMOTE_ADDR"];				
				$table = 'tbl_user';
				$candid_id = $id;		
				
				$data = array('email_id'=>$email ,
							'user_id'=>$userid,
							'old_password'=>$old_password,	
							'new_password'=>$new_password,	
							'createTime'=>$createTime,
							'ip'=>$ip,
							'type'=>$type,
							'table'=>$table,
							'candid_id'=>$candid_id,
							);

				if($id)			
				{
					$this->db->insert('tbl_log_password',$data); 
					
					$data1['date_modified']=date('Y-m-d H:i:s');
					$data1['password']=$new_password;
					$data1['status']=$status;
					$this->db->where('id', $id);
					$this->db->where('email_id', $email);
					$this->db->where('user_type', $type);
					$this->db->update('tbl_user', $data1); 
					return true;
				}
				return false;
				
		}else{
				return false;
		}
	}
	
	public function getBankerPassword($id,$email) 
	{
		$this->db->where('id', $id);
		$this->db->where('email_id', $email);
		$query = $this->db->get("tbl_user");
		if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) 
				{
					$data = $row->password;
				}
				return $data;
		}
		return false;
	}
	
	public function getBidderPassword($id,$email) 
	{
		$this->db->where('id', $id);
		$this->db->where('email_id', $email);
		$query = $this->db->get("tbl_user_registration");
		if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) 
				{
					$data = $row->password;
				}
				return $data;
		}
		return false;
	}
}
