<?php
class Message_model extends CI_Model {
    
	private $path = 'public/uploads/message/';
    
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function GetSubTotalRecord() {
            
            $this->db->select('count(*) as total');		
            $query = $this->db->get("tbl_message");
            if ($query->num_rows() > 0) {
                $data = $query->result();
                return $data[0]->total;
            }
            return 0;
        }

        public function GetTotalRecord(){
            
            $this->db->select('count(*) as total');
            
            //$this->db->where('status !=', 2);
           
            $query = $this->db->get("tbl_message");

            if ($query->num_rows() > 0) {
                $data = $query->result();
                return $data[0]->total;
            }
            return 0;
        }

    public function GetRecords(){

        //$this->db->where('parent_id', 0);
        //Remove deleted message from list
        //$this->db->where('status !=', 5);
         $this->db->order_by('id','DESC');
        $query = $this->db->get("tbl_message");
		
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $row->parent_name = '';
                $data[] = $row;
                $child_array = $this->GetChildRecords($row->id);
                if (sizeof($child_array) > 0) {
                    foreach ($child_array as $child) {
                        $child->parent_name = $row->name;
                        $data[] = $child;
                    }
                }
            }
            return $data;
        }
        
        return false;
    }

    public function GetSubRecords($start=0, $limit=0) {
	
		$this->db->select('a.*');
		$this->db->from("tbl_message as a");
		//$this->db->join('tbl_message as b', 'a.parent_id = b.id', 'left');		
		//$this->db->where('a.parent_id !=', 0);		
		//$this->db->where('a.status !=', 5);
		//$this->db->order_by('parent_id');
		$this->db->order_by('id','DESC');
		$this->db->limit($limit,$start);
		//echo $this->db->last_query();
		$query = $this->db->get(); 
		//echo $this->db->last_query(); 
		
        /*$this->db->where('parent_id', 0);
				//Remove deleted message from list
				$this->db->where('status !=', 5);
				
				$query = $this->db->get("tbl_message");
				
        $data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
			    $row->parent_name = '';
				//$data[] = $row;
				$child_array = $this->GetChildRecords($row->id);
				if(sizeof($child_array) > 0){
					foreach ($child_array as $child) {
						$child->parent_name = $row->name;
						$data[] = $child;
					}	
				}
            }
            return $data;
        }
        return false; */
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }				
            return $data;
        }        
		return false;
    }
	
	public function GetParentRecords($start=0, $limit=10) {
        //$this->db->where('parent_id', 0);
		//Remove deleted message from list
		//$this->db->where('status !=', 5);
		$this->db->order_by('id','DESC');
		$this->db->limit($limit,$start);		
		$query = $this->db->get("tbl_message");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetParentRecordsControl() {
        //$this->db->where('parent_id', 0);
		$this->db->where('status', 1);
		
		$query = $this->db->get("tbl_message");
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecords($parent_id) {
		
		//$this->db->where('parent_id', $parent_id);
		$this->db->where('status !=', 5);
		$query = $this->db->get("tbl_message");
		
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){				
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function GetChildRecordsControl($parent_id) {
            //$this->db->where('parent_id', $parent_id);

                    $this->db->where('status', 1);
                    $query = $this->db->get("tbl_message");
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row){				
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
	
	
	
	public function GetRecordById($id) {
            
            $this->db->where('id', $id);
            $query = $this->db->get("tbl_message");
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data = $row;
                }
                return $data;
            }
            return false;
        }

    public function save_message_data(){
            
		$id = $this->input->post('id');
		$msg_to = $this->input->post('msg_to');
		if($msg_to)
		{
			$msgToarr=explode(',',$msg_to);
			
			print_r($msgToarr);
			
			
			
			foreach($msgToarr as $msg_to)	
			{
						if($id){
							
							$msg_role = $this->session->userdata('arole');
							$msg_from = $this->input->post('msg_to');
							//$msg_to = $this->input->post('msg_from');
							
						}else{
						
							$msg_role = $this->session->userdata('arole');
							$msg_from = $this->session->userdata('adminid');
						   // $msg_to = $this->input->post('msg_to');
						}
						
						$usertype = $this->input->post('usertype');
						$msg_body = $this->input->post('msg_body');
				
				$data = array('msg_role'=>$msg_role,
												'msg_from'=>$msg_from,
							'msg_to'=>$msg_to,
							'user_type'=>$usertype,
							'msg_body'=>$msg_body
							);
				
					
					$data['msg_created_datetime']=date('Y-m-d H:i:s');
								$data['msg_status']=2;
								$data['status']=1;
					$this->db->insert('tbl_message',$data); 
					$id = $this->db->insert_id();
					//echo $this->db->last_query();
					
					//if(empty($slug))$slug=$name;
					//$data['slug'] = url_title($slug, '-', TRUE);
					//$data['slug'] = GetSlugTitle($slug, $id);
					//$this->db->where('id', $id);
					//$this->db->update('tbl_message', $data);
					
				
			}
	}
	//die;
		return true;
	}
	
	
	public function uniqueSlug($slug, $id) {
		$this->db->where('id !=', $id);
		$this->db->where('slug', $slug);
		$query = $this->db->get("tbl_message");
		if ($query->num_rows() > 0) {
				return "false";
		}
		return "true";
	}
        
        
        public function GetUserData(){
            //$this->db->limit(10,0);
            //$this->db->order_by('id DESC');
		$query = $this->db->get("tbl_user");
                //echo $this->db->last_query();

		$data = array();
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function GetUserRecordById($id=1) {
            
            $this->db->select('a.* , b.id as b_id, b.name as b_name');		
            $this->db->from("tbl_user as a");
            $this->db->join('tbl_role as b', 'b.id = a.role');
            //$this->db->where("a.id = ", $id);
            
            //$this->db->where('id', $id);
            //$query = $this->db->get("tbl_user");
           // echo $this->db->last_query();
            
            $data = array();
            
		if ($query->num_rows() > 0){
                    
                    foreach ($query->result() as $row) {
                        $data[] = $row;
                    }
                    return $data;
		}
		return false;
        }
        
        public function get_autocomplete(){
            
            //$id = $this->input->post('search');
            
            $name = $this->input->post('name');
            $usertype = $this->input->post('usertype');
            
			if($name)
			{
				$keyArr=explode(',',$name);
				if($keyArr>0)
				{
					
					$key=end($keyArr);
				}else{
					$key=$name;
				}
				
			}
            
            $this->db->select('id, first_name, last_name, email_id');
            $this->db->where_not_in('id', $this->session->userdata('adminid'));
            //$this->db->where('first_name',1);
            $this->db->like('first_name',trim($key));
            //return $this->db->get('tbl_user', 10);
            if($usertype=='banker'){
            $query = $this->db->get("tbl_user");
			}else{
			$query = $this->db->get("tbl_user_registration");	
			}
            
            //echo $this->db->last_query().'<br />';

            $data = array();
            if ($query->num_rows() > 0){

                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;
        }
}