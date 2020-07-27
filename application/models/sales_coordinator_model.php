<?php
class Sales_coordinator_model extends CI_Model {
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	public function GetRecords($start=0, $limit=10,$is_assign=1) {
	
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
		$this->db->where('is_assign != ', $is_assign);
		$this->db->order_by('id DESC');
		$this->db->limit($limit,$start);
		$query = $this->db->get("tbl_event_log_sales");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if(!$is_assign)
				$row->user_id=$this->GetAssignedUser($row->id);
				$data[] = $row;
			}
			return $data;
		}
		return false;
    }
   
    function datatable()
	{
		$id=$this->session->userdata('id');
                $this->datatables->select("els.id, CONCAT(tu.first_name,' ', tu.last_name)  as executive_name,td.name as drt_name, tb.name as bank_name, tbr.name as bname,  els.event_type AS type,els.status AS status , els.uploaded_doc",false)

	
            //    $this->datatables->select("els.id, CONCAT(tu.first_name,' ', tu.last_name)  as executive_name,td.name as drt_name, tb.name as bank_name, tbr.name as bname,  els.event_type AS type,els.status AS status , els.uploaded_doc,els.id",false) //CODE FOR LOG WORK BAKCEND
		/*$this->datatables->select("els.id, CONCAT(tu.first_name,' ', tu.last_name)  as executive_name,td.name as drt_name, tb.name as bank_name, tbr.name as bname, CASE  els.event_type
                                            WHEN 0 THEN 'DRT'
                                            WHEN 1 THEN 'SARFAESI'
                                            ELSE 'OTHERS' END AS type, CASE els.status
                                            WHEN 0 THEN 'Event Logged'
                                            WHEN 1 THEN 'Assign'
                                            WHEN 3 THEN 'Reassign'
                                            WHEN 4 THEN 'Created'
                                            ELSE 'Event Logged'$
                                            END AS status , els.uploaded_doc",false)
                        */
               /* $this->datatables->select("els.id, CONCAT(tu.first_name,' ', tu.last_name)  as executive_name, td.name as drt_name, tb.name as bank_name, tbr.name as bname,
                                           CASE els.event_type WHEN 0 THEN 'DRT'
                                            CASE WHEN 1 THEN 'SARFAESI'
                                            CASE WHEN 2 THEN 'OTHERS' END as type, 
                                            CASE els.status
                                            WHEN 0 THEN 'Event Logged'
                                            WHEN 1 THEN 'Assign'
                                            WHEN 3 THEN 'Reassign'
                                            WHEN 4 THEN 'Created'
                                            ELSE 'Event Logged'
                                              END AS status , els.uploaded_doc",false)*/
                
                
		->unset_column('els.uploaded_doc')
		->add_column('Download',$this->addDownload('$1'), 'els.uploaded_doc')
		->add_column('Action',"<a class='b_action' href='/sales_coordinator/event_logging/$1'>Edit</a>", 'els.id') //CODE FOR LOG WORK BAKCEND
		->from('tbl_event_log_sales as els')
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id','left ')
		->join('tbl_bank as tb','els.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left ')
		->join('tbl_drt td','els.drt_id=td.id','left ')
		->where('els.status !=','5')
		->where('els.is_assign','0');
		return $this->datatables->generate();
    }
   
	function addDownload($file)
	{
		if($file){
			//$html = '<a target="_blank" href="/public/uploads/bank/'.$file.'" download>'.$file.'</a>';
		$html = '<a target="_blank" href="/public/uploads/bank/'.$file.'" download>'.$file.'</a>';
		
                    
                }else{
			$html = '';
		}
		return $html;						
	}
	
	function addAction($id,$ex_user )
	{	
		$html="<span id='427_29' class='actions'><select id='selectEmp_29' name='assign_to_$id'>
								<option value=' '>--Select--</option>";
								 foreach($ex_user as $helpdesk){
              $html.="<option value='$helpdesk->id' >$helpdesk->first_name $helpdesk->last_name</option>";
							}
								$html.="</select>
								|
								
								<input type='checkbox' class='status12' name='assign[]' value='$id'>
								</span>";
								return $html;
								
	}
	public function GetAssignedUser($event_id)
	{
		$this->db->where('status ', 1);
		$this->db->where('event_id', $event_id);
		$query = $this->db->get("tbl_event_assign");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data = $row->assign_to_id;
			}
			return $data;
		}
		return false;
	}
	
	
	public function save_data() {
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
		$bank_tender_no = $this->input->post('bank_tender_no');
		$user_id=$this->session->userdata('id');
		$number_of_auction_to_published = $this->input->post('number_of_auction_to_published');	
		$ip	= $_SERVER["REMOTE_ADDR"];
		
		if($_FILES['upload_doc']['name']!= ""){
			$uploaded_doc=$this->sales_coordinator_model->upload_file('upload_doc');
								
		}else{
			$uploaded_doc=$this->input->post('uploaded_doc_old1');
		}
		if($_FILES['upload_image']['name']!= "")
		{
			$upload_img=$this->sales_coordinator_model->upload1('upload_image');                    
		}else{
			$upload_img=$this->input->post('upload_image_old');
		}
				
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
					'bank_tender_no'=>$bank_tender_no,	
					'created_by'=>$user_id,
					'number_of_auction_to_published'=>$number_of_auction_to_published,
					//'indate'=>$indate,
					'status'=>$status
					);
		if($id)			
		{
			
			$this->db->where('id', $id);
			$this->db->update('tbl_event_log_sales', $data); 
			$data['ip'] = $ip;
			$this->db->where('event_log_id', $id);
			$this->db->insert('tbl_log_event_log',$data); 
		}else{  $data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_event_log_sales',$data); 
			
			
			$last_insert_id = $this->db->insert_id();
			$data['event_log_id'] = $last_insert_id;
			$data['ip'] = $ip;
			$this->db->insert('tbl_log_event_log',$data); 
		}
		return true;
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
	public function GetSalesUser()
	{
		$this->db->where('status !=', 5);
		$this->db->where('user_type', 'sales');
		$this->db->order_by('id DESC');
		$query = $this->db->get("tbl_user_registration");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
		public function GetAllSalesUser()
	{
		$this->db->where('status', 1);
		$this->db->where('user_type', 'sales');
		$this->db->order_by('first_name');
		$query = $this->db->get("tbl_user_registration");
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	public function FilterBranchUserRecords($branch_id) {
	
		if($branch_id)
		{
		//$this->db->where('user_type', 'branch');
		$this->db->where('user_type_id',$branch_id);
		}
		$this->db->where('status', 1);
		$this->db->order_by("first_name", "");		
        $query = $this->db->get("tbl_user");	
		//return $this->db->last_query();
		
        $data = array();
				if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
							$data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function FilterDrtUserRecords($drt_id,$orderby = "") {
		if($drt_id)
		{
			$this->db->where('user_type', 'drt');
			$this->db->where('user_type_id', $drt_id);
		}
		$this->db->where('status', 1);
		if($orderby == "")
		{
			$this->db->order_by("id", "desc");		
		}
		else
		{
			$this->db->order_by($orderby, "ASC");
		}
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
		$config['max_size'] = '30220';
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
	
	function upload_file($fieldname)
	{	
		$config['upload_path'] = $this->path;
		$config['allowed_types'] = 'jpg|png|jpeg|gif|doc|docx|pdf|zip|xls';
		$config['max_size'] = '30220';
		$config['remove_spaces'] = true;
		$config['overwrite'] = false;
		$config['encrypt_name'] = false;
		$config['max_width']  = '';
		$config['max_height']  = '';
		$config['file_name']  = time().'_'.$_FILES['upload_doc']['name'];
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
