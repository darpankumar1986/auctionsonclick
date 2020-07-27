<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_log extends WS_Controller{
	
	public function __Construct()
	{
		parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('event_log_model');
		$this->load->model('admin/bank_model');
		//$this->check_isvalidated();
	}	
	
	public function index($page_no)
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(!$this->session->userdata('validated')){
          redirect('admin/login');
        }
				
    }	
		
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_user');
		$data['heading']='Event Log'; 
		//$this->load->view('admin/header', $data);		
		//$this->load->view('admin/sidebar');
		
	
		$per_page=10;
		$total_record	= $this->event_log_model->GetTotalRecord();		
		$config['base_url'] = site_url().'/event_log/index';
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
		
		$array_records = $this->event_log_model->GetRecords($offset,$per_page);
		
		$data['records'] = $array_records; 
		$this->load->view('event-log', $data);
		//$this->load->view('admin/footer');
	}
	
	public function addedit($param)
	{
		if(is_numeric($param)){
			$data['heading']='Edit Event Log '; 
		}else{
			$data['heading']='Create Event Log '; 
		}
		
		if($param){
			$array_records = $this->event_log_model->GetRecordById($param);
		}else{
			$array_records=array();
		}
		
		$data['row'] = $array_records;
		
		$sales_user = $this->event_log_model->GetSalesUser();
		$data['sales_user'] = $sales_user;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$drts = $this->bank_model->GetDrtRecords();		
		$data['drts'] = $drts;
		/*$zones = $this->bank_model->GetZoneRecord();		
		$data['zones'] = $zones;
		$regions = $this->bank_model->GetRegionRecord();		
		$data['regions'] = $regions;
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$branchs = $this->bank_model->FilterBranchRecords();
		$data['branchs'] = $branchs;
		$drts = $this->bank_model->GetDrtRecords();		
		$data['drts'] = $drts;
		$c1zones = $this->bank_model->GetC1zoneRecords();		
		$data['c1zones'] = $c1zones;
		
		$roles = $this->role_model->GetRecords();
		$data['roles'] = $roles;*/
		
		//$this->load->view('admin/header', $data);		
		//$this->load->view('admin/sidebar');		
		$this->load->view('add-edit-event-log', $data);
		//$this->load->view('admin/footer');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('sales_executive_id', 'sales_executive_id', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			redirect('event_log/addedit');
		}
		else{
				$image='';$doc='';
				if($_FILES['upload_doc']['name']!= ""){
					$doc=$this->bank_model->upload1('upload_doc');
				}else{
					$doc=$this->input->post('uploaded_doc_old');
				}
				if($_FILES['upload_image']['name']!= ""){
					$image=$this->bank_model->upload1('upload_image');
				}else{
					$image=$this->input->post('upload_image_old');
				}
				$save = $this->event_log_model->save_data($image,$doc);
			
			if($save){
				redirect('event_log/index');
			}else{
				
			}
		}	
	}
	public function checkDuplicateEmail()
	{
		$email=$this->input->post('email');
		return $this->event_log_model->checkDuplicateEmail($email);
		 
	}
	public function ajax_branch($bank_id)
	{
		$array_records = $this->bank_model->FilterBranchRecords('','',$bank_id);
		echo "<option value=''>Select</option>";
		foreach($array_records as $row)
		{
		echo "<option value='$row->id'>$row->name</option>";
		}
	}
	public function ajax_branch_user($branch_id)
	{
		$array_records = $this->event_log_model->FilterBranchUserRecords($branch_id);
		echo "<option value=''>Select</option>";
		foreach($array_records as $row)
		{
		echo "<option value='$row->id'>$row->first_name".' '."$row->last_name</option>";
		}
	}
	public function ajax_drt_user($branch_id)
	{
		$array_records = $this->event_log_model->FilterDrtUserRecords($branch_id);
		echo "<option value=''>Select</option>";
		foreach($array_records as $row)
		{
		echo "<option value='$row->id'>$row->first_name".' '."$row->last_name</option>";
		}
	}
	
}
?>