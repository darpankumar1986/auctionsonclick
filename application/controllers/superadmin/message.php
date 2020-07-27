<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends MY_Controller {
	
	public function __Construct()
	{
	   	parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/message_model');
	   	$this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
            if(! $this->session->userdata('validated')){
               redirect('superadmin/login');
			   //redirect('registration/logout');
            }
        }
		
	public function page($page_no)
	{
		$data['heading']='Sub Message'; 
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		if($this->input->post('submit'))
			$this->updateStatus('tbl_message');
		
		$per_page=10;
		$total_record	= $this->message_model->GetSubTotalRecord();		
		$config['base_url'] = site_url().'superadmin/message/index';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		$offset = ($limit) ? $limit : 0;
		
		$array_records = $this->message_model->GetSubRecords($offset,$per_page);
		//echo "<pre>";
		//print_r($array_records);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/message', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function main($page_no)
	{
		$data['heading']='Message';
		$data['type'] = 'main';
                
                //$data['get_user_dbyid'] = $this->message_model->GetUserRecordById($id);
                
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');
		
		if($this->input->post('submit'))
			$this->updateStatus('tbl_message');
		
		$per_page=30;
		
		$total_record	= $this->message_model->GetTotalRecord(); 		
		$config['base_url'] = site_url().'superadmin/message/main/';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 4;
		
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		$offset = ($limit) ? $limit : 0;
		
		$array_records = $this->message_model->GetParentRecords($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('superadmin/message', $data);
		$this->load->view('superadmin/footer');
	}

	public function reply_msg($param)
	{
            
		if(is_numeric($param)){
			$data['heading']='Reply Message'; 
			$message_id = $param;
		}else{
			$data['heading']='Add Message'; 
		}
		
		if($message_id){
			$array_records = $this->message_model->GetRecordById($message_id);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records; 
		
                $data['get_user_data'] = $this->message_model->GetUserData();
		$message = $this->message_model->GetParentRecordsControl();
		$data['message'] = $message; 
		
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-message', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function addeditmain($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Message'; 
			$message_id = $param;
		}else{
			$data['heading']='New Message'; 
		}
		
		if($message_id){
			$array_records = $this->message_model->GetRecordById($message_id);
		}else{
			$array_records=array();
		}
		
		$data['type'] = 'main';
		$data['row'] = $array_records; 
		
		$message = $this->message_model->GetParentRecordsControl();
		$data['message'] = $message; 
                
                $data['get_user_data'] = $this->message_model->GetUserData();
		
		$this->load->view('superadmin/header', $data);		
		$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-message', $data);
		$this->load->view('superadmin/footer');
	}
	
	function subCatDropdown($parent_id,$view='',$subcat_id)
	{
		$data['view'] =$view;
		$data['subcat_id'] =$subcat_id;
		if($data['message'] = $this->message_model->GetChildRecords($parent_id))
		$this->load->view('superadmin/subCatDropdown', $data);
	}
	
	function deleteMessage($id){
		$this->message_model->deleteMessage($id);
	}
	
	
	public function save()
	{
		$this->load->library('form_validation');
        $this->form_validation->set_rules('msg_to', 'To', 'trim|required|xss_clean');    
		$this->form_validation->set_rules('msg_body', 'Message', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$msg_to=$this->input->post('msg_to');
			$msg_body=$this->input->post('msg_body');
			if($msg_to==''  && $msg_body==''){
				$msg="Please enter required fields .!";
			}else{
				$msg="Non existence of users.!";	
			}
			$this->session->set_flashdata('message',$msg);
			redirect('superadmin/message/addeditmain');
		}
		else{
			        $save = $this->message_model->save_message_data();
                    if($save){
						$msg="Message is sent successfully";
						$this->session->set_flashdata('message',$msg);
                        redirect('superadmin/message/main');
                            
                    }else{
						$msg="Message is not sent.";
						$this->session->set_flashdata('message',$msg);
						redirect('superadmin/message/addeditmain');
                    }
		}	
	}
        
        public function autosuggest_to()
	{
		$message = $this->message_model->GetAutosuggestTo();
		$this->load->view('superadmin/add-edit-message', $data);
	}
        
        function autocomplete(){
            $data = $this->message_model->get_autocomplete();
            if($data){
                foreach($data as $row):
                    echo "<li id='$row->id' value=\"$row->id\" onclick=\"fill('$row->id', '$row->first_name $row->last_name ($row->email_id)')\">".$row->first_name." ".$row->last_name." (".$row->email_id.")</li>";
                endforeach;
            }
        } 
}
?>
