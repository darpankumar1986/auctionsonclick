<?php
class Helpdesk_model extends CI_Model {
	private $path = 'public/uploads/bank/';
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}
	
	public function GetTotalRecord($is_assign=1) {	
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
		
		$this->db->where('is_assign != ', $is_assign);
		
		$query = $this->db->get("tbl_event_log_sales");
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
			return $data[0]->total;
        }        
		return 0;
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
		
		
        $this->datatables->select("els.id, CONCAT(tu.first_name,tu.last_name)  as executive_name, td.name as drt_name, tb.name as bank_name, tbr.name as bname, IF(els.event_type = 1,'DRT','SARFAESI') as type, IF(els.status = 1,'Active','Inactive') as status, els.uploaded_doc",false)
       // ->unset_column('tbr.id')
	   ->unset_column('els.uploaded_doc')
	   ->add_column('Download',"<a href='subscriber/$1'>Download</a>", 'els.uploaded_doc')
		->add_column('Actions',"<a href='subscriber/$1'>Edit</a><a href='subscriber/$1'>Delete</a>", 'tbr.id')
        ->from('tbl_event_log_sales as els')
		->join('tbl_user as tu','els.sales_executive_id=tu.id','left ')
		->join('tbl_bank as tb','els.bank_id=tb.id','left ')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left ')
		->join('tbl_drt td','els.drt_id=td.id','left ');
		
			/*"<select id='selectEmp_29' name='assign_to_$data->id'>
								<option value=' '>--Select--</option>
								";foreach($ex_user as $helpdesk){"
              <option value='$helpdesk->id'hp echo ($helpdesk->id == $role)?'selected':''>$helpdesk->first_name.' '.$helpdesk->last_name</option>
							}
								</select>
								|
								<span id='427_29' class='actions'>
								<input type='checkbox' class='status12' name='assign[]' value='$data->id'>
								</span>";*/
        return $this->datatables->generate();
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
	
	public function save_auction_data() {
		$id = $this->input->post('id');
		$account = $this->input->post('account');
		$reference_no = $this->input->post('reference_no');
		$event_title = $this->input->post('event_title');
		$bank_id = $this->input->post('bank_id');
		$category_id = $this->input->post('category_id');
		$subcategory_id = $this->input->post('subcategory_id');
		$property_desc = $this->input->post('property_desc');		
		$borrower_name = $this->input->post('borrower_name');			
		$invoice_mail_to = $this->input->post('invoice_mail_to');			
		$invoice_mailed = $this->input->post('invoice_mailed');			
		$reserve_price = $this->input->post('reserve_price');			
		$emd_amt = $this->input->post('emd_amt');			
		$tender_fee = $this->input->post('tender_fee');			
		$nodal_bank = $this->input->post('nodal_bank');			
		$nodal_bank_name = $this->input->post('nodal_bank_name');			
		$nodal_bank_account = $this->input->post('nodal_bank_account');			
		$branch_ifsc_code = $this->input->post('branch_ifsc_code');			
		$press_release_date = $this->input->post('press_release_date');			
		$inspection_date_from = $this->input->post('inspection_date_from');			
		$inspection_date_to = $this->input->post('inspection_date_to');			
		$bid_opening_date = $this->input->post('bid_opening_date');			
		$auction_start_date = $this->input->post('auction_start_date');			
		$auction_end_date = $this->input->post('auction_end_date');			
		$show_frq = $this->input->post('show_frq');			
		$dsc_enabled = $this->input->post('dsc_enabled');			
		$price_bid = $this->input->post('price_bid');			
		$bid_inc = $this->input->post('bid_inc');			
		$auto_extension = $this->input->post('auto_extension');			
		$related_doc = $this->input->post('related_doc');				
		$doc_to_be_submitted = $this->input->post('doc_to_be_submitted');			
		$second_opener = $this->input->post('second_opener');			
		$indate = $this->input->post('indate');
		$status = $this->input->post('status');	
		if($_FILES['image']['name']!= ""){
			$image=$this->upload1('image');
		}else{
			$image=$this->input->post('image_old');
		}
		$data = array(
					'account'=>$account ,
					'reference_no'=>$reference_no ,
					'event_title'=>$event_title ,
					'bank_id'=>$bank_id ,
					'category_id'=>$category_id ,
					'subcategory_id'=>$subcategory_id ,
					'property_desc'=>$property_desc ,
					'borrower_name'=>$borrower_name ,
					'invoice_mail_to'=>$invoice_mail_to,		
					'invoice_mailed'=>$invoice_mailed,	
					'reserve_price'=>$reserve_price,	
					'emd_amt'=>$emd_amt,	
					'tender_fee'=>$tender_fee,	
					'nodal_bank'=>$nodal_bank,	
					'nodal_bank_name'=>$nodal_bank_name,	
					'nodal_bank_account'=>$nodal_bank_account,	
					'branch_ifsc_code'=>$branch_ifsc_code,	
					'press_release_date'=>$press_release_date,	
					'inspection_date_from'=>$inspection_date_from,	
					'inspection_date_to'=>$inspection_date_to,	
					'bid_opening_date'=>$bid_opening_date,	
					'auction_start_date'=>$auction_start_date,	
					'auction_end_date'=>$auction_end_date,	
					'show_frq'=>$show_frq,	
					'dsc_enabled'=>$dsc_enabled,	
					'price_bid'=>$price_bid,	
					'bid_inc'=>$bid_inc,	
					'auto_extension'=>$auto_extension,	
					'related_doc'=>$related_doc,	
					'image'=>$image,	
					'doc_to_be_submitted'=>$doc_to_be_submitted,	
					'second_opener'=>$second_opener,	
					'indate'=>$indate,
					'status'=>$status
					);
		if($id)			
		{
			
			$this->db->where('id', $id);
			$this->db->update('tbl_event_auction', $data); 
		}
		else
		{
			
			$data['indate']=date('Y-m-d H:i:s');
			$this->db->insert('tbl_event_auction',$data); 
		}
		return true;
	}
	
	public function GetUser($type)
	{
		$this->db->where('status ', 1);
		$this->db->where('user_type', $type);
		$this->db->order_by('id DESC');
		if($type=='branch' or $type=='region' or $type=='lho' or $type=='bank' or $type=='zone'  )
		$query = $this->db->get("tbl_user");
		else
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
	public function assignEvent() {
		$assign=$this->input->post('assign');
		foreach($assign as $id)		
		{	
			$executive_id=$this->input->post('assign_to_'.$id);
			$data['status']=0;		
			$this->db->where('event_id', $id);
			$this->db->update('tbl_event_assign', $data);
			$data1['is_assign']=1;		
			$this->db->where('id', $id);
			$this->db->update('tbl_event_log_sales', $data1);
			$data['assign_from_id']=1;	
			$data['assign_to_id']=$executive_id;	
			$data['event_id']=$id;	
			$data['indate']=@date('Y-m-d H:i:s');	
			$data['status']=1;	
			$this->db->insert('tbl_event_assign', $data);
			
		}
		
		return true;
	}
	
	public function reAssignEvent() {
		$id=$this->input->post('event_id');
			
			$executive_id=$this->input->post('reassign_to_'.$id);
			$data['status']=0;		
			$this->db->where('event_id', $id);
			$this->db->update('tbl_event_assign', $data);
			$data['assign_from_id']=1;	
			$data['assign_to_id']=$executive_id;	
			$data['event_id']=$id;	
			$data['indate']=@date('Y-m-d H:i:s');	
			$data['status']=1;	
			$this->db->insert('tbl_event_assign', $data);
		return true;
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
