<?php
class Helpdesk_admin_model extends CI_Model {
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
   function non_assign_datatable($aid)
    {	
		
		$startDate = date("Y-m-d H:i:s");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
			
		$ex_user = $this->helpdesk_model->GetUser('helpdesk_ex');
        $this->datatables->select("els.id, CONCAT(tu.first_name ,' ',tu.last_name)  as executive_name, td.name as drt_name, tb.name as bank_name, tbr.name as bname,ak.account_type as type, 'Not Assign' as status, els.uploaded_doc",false)
       // ->unset_column('tbr.id')
	   ->unset_column('els.uploaded_doc')
	    ->add_column('Download',"<a download href='/public/uploads/bank/$1'>$1</a>", 'els.uploaded_doc')
		->add_column('Actions',$this->addNonAssignedAction('$1',$ex_user ), 'els.id')
                ->from('tbl_event_log_sales as els')
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id','left ')
		->join('tbl_bank as tb','els.bank_id=tb.id','left ')
                 ->join('tbl_account_type as ak','ak.ac_id=els.event_type','left ')
		->join('tbl_branch as tbr','els.branch_id=tbr.id','left ')
		->join('tbl_drt td','els.drt_id=td.id','left ')
                ->where('els.is_assign',0)
		->where('els.status',0)
		->where('els.status !=',5);
		if($aid>0)
		{
			$this->db->where('els.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'" ');
		}
		if($this->session->userdata('event_id')){
			$this->db->where('els.id',$this->session->userdata('event_id'));
		}
	 return $this->datatables->generate();
         
      //   return $this->db->last_query();
    }
	function assigned_datatable($aid)
    {	
		
			$startDate = date("Y-m-d H:i:s");
			$endDate = date("Y-m-d 23:59:59");
			if($aid == 2)
			{
				$startDate = date('Y-m-d 00:00:00', strtotime('+1 day'));
				$endDate = date('Y-m-d 23:59:59', strtotime('+1 day'));
			}
			if($aid == 7)
			{
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59', strtotime('next saturday'));
			}
			
			
		$ex_user = $this->helpdesk_model->GetUser('helpdesk_ex');
        $this->datatables->select("els.id,CONCAT(tu.first_name ,' ',tu.last_name)  as executive_name,CONCAT(tua.first_name ,' ',tua.last_name)  as user_name, tua.id as user_id, td.name as drt_name, tb.name as bank_name, tbr.name as bname, ak.account_type,tea.indate, if(els.status = 1,'Assigned','Reassigned') as status, els.uploaded_doc",false)
       // ->unset_column('els.id')
                ->unset_column('els.uploaded_doc')
                ->unset_column('user_name')
                ->unset_column('user_id')
	        ->add_column('Download',"<a download href='/public/uploads/bank/$1'>$1</a>", 'els.uploaded_doc')
		->add_column('Actions',$this->addAssignedAction('$1','$2','$3',$ex_user ), 'els.id,user_name,user_id')
        ->from('tbl_event_log_sales as els')
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id')		
		->join('tbl_bank as tb','els.bank_id=tb.id')
		->join('tbl_branch as tbr','els.branch_id=tbr.id')
		->join('tbl_drt td','els.drt_id=td.id','left')
		->join('tbl_event_assign tea','els.id=tea.event_id')
		->join('tbl_user_registration as tua','tea.assign_to_id=tua.id')
        ->join('tbl_account_type as ak','ak.ac_id=els.event_type','left')
		//->join('tbl_auction as auc','auc.eventID=els.id','left')
		->where('tea.status',1)
        ->where('els.is_assign !=',0)
        ->where('els.status !=',4)
        ->where('els.status !=',5);
        //->where("els.id NOT IN(select eventID from tbl_auction where status >= 0)");
		//->where('auc.status !=',7)
		//->where('auc.status !=',4)
		//->where('auc.status !=',6);
		//$this->db->order_by('id','DESC
		
		if($aid>0)
		{
			$this->db->where('tea.indate BETWEEN  "'.$startDate.'" AND "'.$endDate.'" ');
		}
		if($this->session->userdata('event_id')){
			$this->db->where('els.id',$this->session->userdata('event_id'));
		}
		
        return $this->datatables->generate();
    }
	function addAssignedAction($id,$username,$user_id,$ex_user)
	{
		$html='';
		$html.="<span class='node'><span id='reassign_form_$id' style='display:none'>
		<form method='post' onsubmit='return show_assigned_user($id)'>
		<select id='user_$id' name='reassign_to_$id' class='reassign_select'>
				<option value=' '>--Select--</option>";
				$selected="";
				foreach($ex_user as $helpdesk){
					$html.="<option value='$helpdesk->id'";
					$html.=">".$helpdesk->email_id."</option>";
				}
				$html.="</select>
				<input type='hidden' id='event_id_$id' value='$id'>
				<input type='hidden' id='user_id_$id' value='$user_id'>
				<input type='submit' value='ReAssign' class='button_grey' name='submit'>
				</form>
				</span>
				<span id='assign_info_$id'>";
		$html.='<span id="username_'.$id.'">'.$username.'</span>';
		$html.="| <a href='javascript:void(0)' class='button_gray' onclick='return select_assigned_user(this,$id);'>ReAssign</a></td>
		</span></span>";
		return $html;
								
	}
	function addNonAssignedAction($id,$ex_user )
	{
	
		$html="<span id='427_29' class='actions'><select id='selectEmp_29' name='assign_to_$id'>
								<option value=' '>--Select--</option>";
                foreach($ex_user as $helpdesk){
                  $html.="<option value='$helpdesk->id' >".$helpdesk->email_id."</option>";
                    }
                            $html.="</select>
                    <span class='help_desk_admin_sepereator'>|</span>
                    <input type='checkbox' class='status12' name='assign[]' value='$id'>
                            </span>";
                            return $html;
								
	}
	public function assignEvent() {
		$assign=$this->input->post('assign');
                $i=0;
                $ids=array();
		foreach($assign as $id)		
		{	 
			$executive_id=$this->input->post('assign_to_'.$id);
			$data['status']=0;		
			$ip	= $_SERVER["REMOTE_ADDR"];
			
			$this->db->where('event_id', $id);
			$update=$this->db->update('tbl_event_assign', $data);
			if($update){
                            $data_eventaalog=array(
                                      'ip'=>$ip,
                                      'status'=>'0',
                                     );
			$this->db->where('event_id', $id); // log
			$assign=$this->db->update('tbl_log_event_assign', $data_eventaalog); // log
                      
                        }
                        array_push( $ids,$id);
			
			$data1['is_assign']=1;		
			$data1['status']=1;		
			$data1['updated_date']=@date('Y-m-d H:i:s');	

			$this->db->where('id', $id);
			$this->db->update('tbl_event_log_sales', $data1);
			
			$data1['is_assign']=1;		
			$data1['status']=1;		
			$data1['updated_date']=@date('Y-m-d H:i:s');		
			//$data1['ip']=$ip;
			$this->db->where('event_log_id', $id);
			$this->db->update('tbl_log_event_log', $data1); // log
			
			$data2['assign_from_id']=$this->session->userdata('id');	
			$data2['assign_to_id']=$executive_id;	
			$data2['event_id']=$id;	
			$data2['indate']=@date('Y-m-d H:i:s');	
			$data2['status']=1;
                       $loginsert=$this->db->insert('tbl_event_assign', $data2);
		     if($loginsert){
                         $_SESSION['event_id'][$i] = $id;
                         
			$data5['assign_from_id']=$this->session->userdata('id');	
			$data5['assign_to_id']=$executive_id;	
			$data5['event_id']=$id;	
			$data5['indate']=@date('Y-m-d H:i:s');	
			$data5['status']=1;	
			$data5['ip']=$ip;
			$this->db->insert('tbl_log_event_assign', $data5); // log
                        }
			 $i++;
			
		}
                
                     if(count($ids)>0){
                          $id=implode(',',$ids);
                           $this->session->set_userdata('succ_message',"Logged event ID ".$id." assigned successfully");  
                       }
		
		return true;
	}
	
	public function reAssignEvent() {
		$assign_to_id=$this->input->post('assign_to_id');
		$event_id=$this->input->post('event_id');
		
		$data1 = array('status'=>'0');		
		$this->db->where('event_id', $event_id);
		$this->db->update('tbl_event_assign', $data1);
		
		
		$ip	= $_SERVER["REMOTE_ADDR"];
		
		$data1 = array('status'=>'0','ip'=>$ip);	
		$this->db->where('event_id', $event_id);
		$this->db->update('tbl_log_event_assign', $data1);
		//echo $this->db->last_query();
		
		$data2 = array(
			'assign_from_id'=>$this->session->userdata('id'),
			'assign_to_id'=>$assign_to_id,
			'event_id'=>$event_id,
			'indate'=>@date('Y-m-d H:i:s'),
			'modified_date'=>@date('Y-m-d H:i:s'),
			'status' =>'1'
			);	
		$this->db->insert('tbl_event_assign', $data2); // log
		
		
		$data2 = array(
			'assign_from_id'=>$this->session->userdata('id'),
			'assign_to_id'=>$assign_to_id,
			'event_id'=>$event_id,
			'indate'=>@date('Y-m-d H:i:s'),
			'modified_date'=>@date('Y-m-d H:i:s'),
			'status' =>'1',
			'ip'=>$ip
			);	
		$this->db->insert('tbl_log_event_assign', $data2); // log
		//echo $this->db->last_query();
		
		
		$data3 = array(
			'is_assign'=>'2',
			'updated_date'=>@date('Y-m-d H:i:s'),
			'status' =>'2'
			);
		$this->db->where('id', $this->input->post('event_id'));
		$this->db->update('tbl_event_log_sales', $data3);
		
		
		$data3 = array(
			'is_assign'=>'2',
			'updated_date'=>@date('Y-m-d H:i:s'),
			'status' =>'2'
			);
		$this->db->where('event_log_id', $this->input->post('event_id'));
		$this->db->update('tbl_log_event_log', $data3);
		//echo $this->db->last_query();
		
		return true;
	}
	function search_datatable($event_id)
    {	
		$ex_user = $this->helpdesk_model->GetUser('helpdesk_ex');
       /* $this->datatables->select("tua.id,tu.user_id,tu.first_name,tu.last_name,els.indate",false)
		//->unset_column('els.id')
        ->from('tbl_auction as tua')
        ->join('tbl_event_log_sales as els','els.id=tua.eventID','left')		
		->join('tbl_user_registration as tu','els.sales_executive_id=tu.id','left')		
		->join('tbl_event_assign tea','els.id=tea.event_id and tea.status=1','left')
		->where('tua.id',$event_id);*/
		
		$this->datatables->select("tua.id,tu.email_id,tu.first_name,tu.last_name,tua.updated_date",false) 
        //->unset_column('els.id') 
        ->from('tbl_event_log_sales as els') 
        ->join('tbl_auction as tua','els.id=tua.eventID','left')    
        ->join('tbl_user_registration as tu','els.sales_executive_id=tu.id','left')         
        ->join('tbl_event_assign tea','els.id=tea.event_id and tea.status=1','left') 
        ->where('tua.id',$event_id); 
		
        return $this->datatables->generate();
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
