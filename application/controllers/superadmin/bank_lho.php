<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_lho extends MY_Controller {
	
	public function __Construct()
	{
	  parent::__Construct();
		ob_start();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library("pagination");
		$this->load->helper(array('form'));
		$this->load->model('superadmin/bank_model');
		
	  $this->check_isvalidated();
	}	
	
	public function index($page_no="")
	{
		$this->page($page_no);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated') || $this->session->userdata('arole')!='1'){
            redirect('superadmin/login');
            //redirect('registration/logout');
        }
    }	
		
	
	public function page($page_no)
	{
		if($this->input->post('submit'))
			$this->updateStatus('tbl_lho');
		$data['heading']='Bank Lho';
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		
		//search query start//
		$search['title'] 	= $this->input->get('title'); 
		//$search['status'] 		= $this->input->post('status1');
		$data['search'] = $search;
		//serach query ends//
		
		$per_page=10;
		$total_record	= $this->bank_model->GetTotalLhoRecord();		
		
		
		/*$config['base_url'] = site_url().'superadmin/bank_lho/page';
		$config['total_rows'] = $total_record;
		$config['per_page'] = $per_page;
		$config["uri_segment"] = 5;
		
		$config['cur_tag_open'] = '<li><a class="current">';
		$config['cur_tag_close'] = '</a></li>';*/
		
		$page_no = $_GET['per_page'];
		$config['base_url'] = site_url() . 'superadmin/bank_lho/page?k=2';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = 4;
        $config['cur_tag_open'] = '<li><a class="current">';
        $config['cur_tag_close'] = '</a></li>';
        $config['page_query_string'] = TRUE;
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['suffix'] = str_replace('per_page', 'k', $config['suffix']);
        $config['suffix'] = str_replace('?', '&', $config['suffix']);
		
		
		
		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();
		
		if($page_no=='')
			$limit=0;
		else
			$limit=$config["per_page"]*($page_no-1);
			
		$offset = ($limit) ? $limit : 0;
		
		$array_records = $this->bank_model->GetLhoRecords($offset,$per_page);
		$data['records'] = $array_records; 
		$this->load->view('superadmin/bank-lho', $data);
		$this->load->view('superadmin/footer');
	}
	
	function uniqueLho()
	{
		$name=$this->input->post('name');
		$bank_id=$this->input->post('bank_id');
		$id=$this->input->post('id');
		echo $this->bank_model->uniqueLho($name, $bank_id, $id);
	}
	
	public function lho_addedit($param=null)
	{
		if(is_numeric($param)){
			$data['heading']='Edit lho'; 
			$lho_id = $param;
		}else{
			$data['heading']='Add lho'; 
		}
		
		if($lho_id){
			$array_records = $this->bank_model->GetLhoRecordById($lho_id);
		}else{
			$array_records=array();
		}
		$data['row'] = $array_records; 
		$banks = $this->bank_model->GetBankRecords();		
		$data['banks'] = $banks;
		$countries = $this->bank_model->GetCountries();		
		$data['countries'] = $countries;
		$states = $this->bank_model->GetState();		
		$data['states'] = $states;
		$cities = $this->bank_model->GetCity();		
		$data['cities'] = $cities;
		
				
		$this->load->view('superadmin/header', $data);		
		//$this->load->view('superadmin/sidebar');		
		$this->load->view('superadmin/add-edit-bank-lho', $data);
		$this->load->view('superadmin/footer');
	}
	public function save_lho()
	{
		$this->load->library('form_validation');
		$bank_id = $this->input->post('bank_id');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$id = $this->input->post('id');
			if($id)
				redirect('superadmin/bank_lho/lho_addedit/'.$id);
			else
				redirect('superadmin/bank_lho/lho_addedit');
		}
		else{
			if($_FILES['image']['name']!= ""){
				$image=$this->bank_model->upload1('image');
			}else{
				$image=$this->input->post('image_old');
			}
			
			$save = $this->bank_model->save_lho_data($image);
			
			if($save){
				
				$id=$this->input->post('id');
				if($id)
				{
				$this->session->set_flashdata('message','LHO is successfully updated');	
				}else{
				$this->session->set_flashdata('message','LHO is successfully created');	
				}
				
				redirect('superadmin/bank_lho/page');
			}else{
				
			}
		}	
	}
	public function ajax_lho($bank_id)
	{
		$array_records = $this->bank_model->FilterLhoRecords($bank_id);
		echo "<option value=''>Select Lho</option>";
		foreach($array_records as $row)
		{
		echo "<option value='$row->id'>$row->name</option>";
		}
	}
}
?>
